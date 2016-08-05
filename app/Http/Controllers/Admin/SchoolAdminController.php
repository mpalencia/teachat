<?php

namespace Teachat\Http\Controllers\Admin;

use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\RegisterRequest;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\MailSender;

class SchoolAdminController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var School
     */
    private $school;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var State
     */
    private $state;

    /**
     * @param User $user
     * @param User $school
     */
    public function __construct(UserInterface $user, SchoolInterface $school, CountryInterface $country, StateUsInterface $state)
    {
        $this->user = $user;
        $this->school = $school;
        $this->country = $country;
        $this->state = $state;
    }

    /**
     * Display school page
     *
     * @return view
     */
    public function index()
    {
        $data['users'] = $this->user->getByAttributesWithRelations(['role_id' => 4], ['school', 'country'], 'last_name');
        $data['schools'] = $this->school->getAll();
        $data['country'] = $this->country->getAll();
        $data['states'] = $this->state->getAll();

        return view('admin.school_admin.index', $data);
    }

    /**
     * Display create school admin page
     *
     * @return view
     */
    public function create()
    {
        $data['schools'] = $this->school->getAll();
        $data['country'] = $this->country->getAll();
        $data['states'] = $this->state->getAll();

        return view('admin.school_admin.create', $data);
    }

    /**
     * Store a new school principal.
     *
     * @return view
     */
    public function store(RegisterRequest $request)
    {
        $temp_password = $this->_generate_verification_code();
        $code = md5($this->_generate_verification_code());

        $request->merge(['password' => bcrypt($temp_password), 'approved' => 1, 'active' => 1, 'suspend' => 0, 'status' => 0]);

        $this->user->create($request->all());

        $mailSender = new MailSender;

//      $request->merge(['link' => 'dev3.teachat.co/verify/' . $code]);
        $request->merge(['temp_password' => $temp_password]);
        $mailSender->send('email.principal_email_confirmation', 'Email Confirmation', $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Created.']);
    }

    /**
     * Display edit school admin page
     *
     * @return view
     */
    public function edit($id)
    {
        $data['schools'] = $this->school->getAll();
        $data['country'] = $this->country->getAll();
        $data['principal'] = $this->user->getById($id);
        $data['states'] = $this->state->getAllByAttributes(['country_id' => $data['principal']['country_id']]);

        return view('admin.school_admin.edit', $data);
    }

    /**
     * Update a certain school admin.
     *
     * @return view
     */
    public function update($id, RegisterRequest $request)
    {
        $this->user->update($id, $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Updated.']);
    }

    /**
     * Generate new verification code.
     *
     * @return string
     */
    private function _generate_verification_code()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';

        $pin = mt_rand(10, 9999) . mt_rand(10, 9999) . $characters[rand(0, strlen($characters) - 1)];

        return str_shuffle($pin);
    }
}
