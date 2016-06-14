<?php

namespace Teachat\Http\Controllers\HomePage;

use Teachat\Events\UserWasCreated;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\RegisterRequest;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
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
    public function __construct(SchoolInterface $school, StateUsInterface $stateUs, UserInterface $user)
    {
        $this->school = $school;
        $this->stateUs = $stateUs;
        $this->user = $user;
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
        ];

        return view('homepage.registration', $data);
    }

    /**
     * Create a new user.
     *
     * @param RegisterRequest $request
     * @return view
     */
    public function store(RegisterRequest $request, MailSender $mailSender)
    {
        $verification_code = $this->_generate_verification_code();

        $request->merge(['password' => bcrypt($request->password), 'verification_code' => $verification_code]);

        $user = $this->user->create($request->all());

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Error in creating account. Pleast try again.']);
        }

        if ($user->role_id == 2) {

            $request->merge(['user_id' => $user->id]);

            \Event::fire(new UserWasCreated($request));
        }

        $request->merge(['link' => env('APP_URL') . '/registration/activate/' . $verification_code]);

        $mailSender->send('email.email_confirmation', 'Email Confirmation', $request->all());

        return response()->json(['success' => true, 'message' => "Congratulatons! You've successfully created your account.<br> Please confirm your account in your email."]);
    }

    /**
     * Activate user account.
     *
     * @param string $verification_code
     * @return view
     */
    public function activate($verification_code)
    {
        if ($user = $this->user->updateByAttributes(['verification_code' => $verification_code, 'status' => 0], ['status' => 1])) {

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
