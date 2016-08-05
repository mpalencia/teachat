<?php

namespace Teachat\Http\Controllers\HomePage;

use Teachat\Events\UserWasCreated;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\RegisterRequest;
use Teachat\Http\Requests\New_RegisterRequest;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\Curl;
use Teachat\Services\MailSender;

class RegistrationController extends Controller
{
    /**
     * @var SchoolInterface
     */
    private $school;

    /**
     * @var StateUsInterface
     */
    private $stateUs;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * Registration controller instance.
     *
     * @param SchoolInterface $school
     * @param StateUsInterface $stateUs
     * @return void
     */
    public function __construct(SchoolInterface $school, StateUsInterface $stateUs, UserInterface $user, CountryInterface $country)
    {
        $this->school = $school;
        $this->stateUs = $stateUs;
        $this->user = $user;
        $this->country = $country;
    }

    /**
     * Display Registration page
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'schools' => $this->school->getAll(),
            'state_us' => $this->stateUs->getAll(),
            'country' => $this->country->getAll(),
        ];

        return view('homepage.registration', $data);
    }

    public function getStateSchoolByCountryId($country_id)
    {
        $stateUs = $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name');
        $school = $this->school->getAllByAttributes(['country_id' => $country_id], 'school_name');

        if (!empty($stateUs)) {
            return ['result' => true, 'message' => $stateUs, 'messages' => $school];
        }

        return ['result' => false, 'message' => 'No State/Province Available.', 'messages' => 'No School Available.'];

    }

    /**
     * Create a new user.
     *
     * @param RegisterRequest $request
     * @return view
     */
    public function store(New_RegisterRequest $request, MailSender $mailSender)
    {

        $verification_code = $this->_generate_verification_code();

        if ($request->role_id == 3) {
            $request->merge(['school_id' => 1]);
        }

        $request->merge(['password' => bcrypt($request->password), 'verification_code' => $verification_code]);

        $user = $this->user->create($request->all());

        if (!$user) {
            return json_encode(array('result' => 'error', 'message' => 'Error in creating account. Pleast try again.'));
        }

        if ($user->role_id == 2) {

            $request->merge(['user_id' => $user->id]);

            \Event::fire(new UserWasCreated($request));
        }

        $fields = array(
            'user_id' => $user->id,
            'additional_data' => ['first_name' => $user->first_name, 'last_name' => $user->last_name],
        );

        $fields = json_encode($fields);

        $curl = new Curl();
        $curl->call($fields);

        $request->merge(['link' => env('APP_URL') . '/registration/activate/' . $verification_code]);

        $mailSender->send('email.email_confirmation', 'Email Confirmation', $request->all());

        return json_encode(array('result' => 'success', 'message' => 'Registration Successful. Please check your email inbox to verify your account. <br> Also please check your SPAM folder if you don\'t see it in your inbox.'));

    }

    /**
     * Activate user account.
     *
     * @param string $verification_code
     * @return view
     */
    public function activate($verification_code)
    {
        if ($user = $this->user->updateByAttributes(['verification_code' => $verification_code, 'status' => 0], ['status' => 1, 'active' => 1])) {

            return redirect('login')->with('account_activated', 'Your account is now activated.');
        }

        return redirect('login')->with('account_activated_already', 'Your account is already activated.');
    }

    /**
     * Generate new verification code.
     *
     * @return string
     */
    private function _generate_verification_code()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';

        $pin = mt_rand(10, 99) . mt_rand(10, 99) . $characters[rand(0, strlen($characters) - 1)];

        return str_shuffle($pin);
    }
}
