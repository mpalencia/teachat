<?php

namespace Teachat\Http\Controllers\Admin;

use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\RegisterRequest;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\Curl;
use Teachat\Services\MailSender;

class TeacherController extends Controller
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
     * @var CountryInterface
     */
    private $country;

    /**
     * @var UserInterface
     */
    private $teacher;

    /**
     * @param UserInterface $user
     */
    public function __construct(SchoolInterface $school, StateUsInterface $stateUs, CountryInterface $country, UserInterface $teacher)
    {
        $this->school = $school;
        $this->stateUs = $stateUs;
        $this->country = $country;
        $this->teacher = $teacher;
    }

    /**
     * Display teacher page
     *
     * @return view
     */
    public function index()
    {
        $data['teachers'] = $this->teacher->getAllByAttributesWithRelations(['country', 'state', 'school'], ['role_id' => 2], 'first_name');

        return view('admin.teacher.index', $data);
    }

    /**
     * Display create teacher page
     *
     * @return view
     */
    public function create()
    {
        $data['school'] = $this->school->getAll();
        $data['state_us'] = $this->stateUs->getAll();
        $data['country'] = $this->country->getAll();
        $data['teachers'] = $this->teacher->getAllByAttributesWithRelations(['country', 'state'], ['role_id' => 2], 'first_name');

        return view('admin.teacher.create', $data);
    }

    /**
     * Get all parents waiting for approval.
     *
     * @return array
     */
    public function get($id)
    {
        if ($teacher = $this->teacher->getByIdWithRelations($id, ['state'])) {
            return response()->json(['result' => true, 'data' => $teacher], 200);
        }

        return response()->json(['result' => false, 'message' => 'Teacher not found'], 200);

    }

    /**
     * Store a new teacher.
     *
     * @return view
     */
    public function store(RegisterRequest $request)
    {

        $temp_password = $this->_generate_verification_code();

        $request->merge(['role_id' => 2, 'password' => bcrypt($temp_password), 'approved' => 1, 'active' => 1, 'suspend' => 0, 'status' => 0]);

        $teacher = $this->teacher->create($request->all());

        $fields = array(
            'user_id' => $teacher->id,
            'additional_data' => ['first_name' => $teacher->first_name, 'last_name' => $teacher->last_name],
        );

        $curl = new Curl();
        $curl->call(json_encode($fields));

        $mailSender = new MailSender;

        $request->merge(['temp_password' => $temp_password]);
        $mailSender->send('email.principal_email_confirmation', 'Email Confirmation', $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Created.', 'url' => '/admin/teachers/']);
    }

    /**
     * Display edit teacher page
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $data['school'] = $this->school->getAll();
        $data['states'] = $this->stateUs->getAll();
        $data['country'] = $this->country->getAll();
        $data['teacher'] = $this->teacher->getByIdWithRelationsAndAttributes($id, ['country', 'state'], ['role_id' => 2]);

        return view('admin.teacher.edit', $data);
    }

    /**
     * Update a certain teacherl.
     *
     * @param $id
     * @param RegisterRequest $request
     * @return view
     */
    public function update($id, RegisterRequest $request)
    {
        $request->merge(['role_id' => 2]);

        $this->teacher->update($id, $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Updated.', 'url' => '/admin/teachers/']);
    }

    /**
     * Delete a teacher.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->teacher->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
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
