<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\RegisterRequest;
use Teachat\Models\User;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\Curl;
use Teachat\Services\MailSender;

class ManageTeachersController extends Controller
{
    /**
     * @var UserInterface
     */
    private $teacher;

    /**
     * @var ChildrenInterface
     */
    private $children;

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

    public function __construct(UserInterface $teacher, ChildrenInterface $children, SchoolInterface $school, StateUsInterface $stateUs, CountryInterface $country)
    {
        $this->teacher = $teacher;
        $this->children = $children;
        $this->school = $school;
        $this->stateUs = $stateUs;
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'teacher' => $this->teacher->getAllByAttributes(['school_id' => Auth::user()->school_id, 'role_id' => 2], 'last_name'),
        ];

        return view('school_admin.manage-teachers', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country_id = Auth::user()->country_id;
        $data = [
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name'),
            'country' => $this->country->getAllByAttributes(['id' => $country_id], 'id'),
            'school' => $this->school->getAllByAttributes(['id' => Auth::user()->school_id], 'school_name'),
        ];
        return view('school_admin.add-teacher', $data);
    }

    /**
     * Store a newly created teacher.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request, MailSender $mailSender)
    {

        $verification_code = $this->_generate_verification_code();
        $password = $this->_generate_temporary_password();
        $birthdate = date_format(date_create($request->birthdate), 'Y-m-d');

        $request->merge(['birthdate' => $birthdate]);
        $request->merge(['role_id' => 2]);
        $request->merge(['school_id' => Auth::user()->school_id]);
        $request->merge(['country_id' => Auth::user()->country_id]);
        $request->merge(['active' => 1]);
        $request->merge(['approve' => 1]);
        $request->merge(['password_reset' => 1]);

        $request->merge(['password' => bcrypt($password), 'verification_code' => $verification_code]);

        $user = $this->teacher->create($request->all());

        if (!$user) {
            return response()->json(['result' => false, 'message' => 'Error in adding teacher. Pleast try again.']);
        }

        $fields = array(
            'user_id' => $user->id,
            'additional_data' => ['first_name' => $user->first_name, 'last_name' => $user->last_name],
        );

        $fields = json_encode($fields);

        $curl = new Curl();
        $curl->call($fields);

        $request->merge(['temp_email' => $request->email, 'temp_password' => $password, 'link' => env('APP_URL') . '/login']);

        $mailSender->send('email.teacher_email_password', 'Email Confirmation', $request->all());

        return response()->json(['success' => true, 'message' => 'Teacher successfully added!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing teacher.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country_id = Auth::user()->country_id;
        $data = [
            'teacher' => $this->teacher->getById($id),
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name'),
            'country' => $this->country->getAllByAttributes(['id' => $country_id], 'id'),
            'school' => $this->school->getAllByAttributes(['id' => Auth::user()->school_id], 'school_name'),
        ];

        return view('school_admin.edit-teacher', $data);
    }

    /**
     * Update the specific teacher.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterRequest $request, MailSender $mailSender, $teacher_id)
    {
        $query = User::where('id', '=', $teacher_id)->first();
        $oldemail = $query->email;

        $birthdate = date_format(date_create($request->birthdate), 'Y-m-d');

        $request->merge(['birthdate' => $birthdate]);
        $request->merge(['role_id' => 2]);
        $request->merge(['school_id' => Auth::user()->school_id]);
        $request->merge(['country_id' => Auth::user()->country_id]);
        $request->merge(['active' => 1]);
        $request->merge(['approve' => 1]);
        $request->merge(['password_reset' => 1]);

        if ($oldemail != $request->email) {
            $password = $this->_generate_temporary_password();
            $request->merge(['password' => bcrypt($password)]);

            $request->merge(['temp_password' => $password, 'link' => env('APP_URL') . '/login']);

            $mailSender->send('email.teacher_email_password', 'Email Confirmation', $request->all());
        }

        if ($this->teacher->update($teacher_id, $request->all())) {

            return json_encode(array('success' => 'success', 'message' => 'Successfully Updated!'));
        }

        return json_encode(array('result' => 'error', 'message' => 'There is an error occured while saving. Please try again later.'));
    }

    /**
     * Update the status of specific teacher.
     *
     * @param integer $id
     * @return Response
     */
    public function updateStatus($id, Request $request)
    {
        if ($this->teacher->update($id, $request->all())) {

            return json_encode(array('success' => 'success', 'message' => 'Successfully Updated!'));
        }

        return json_encode(array('result' => 'error', 'message' => 'There is an error occured while saving. Please try again later.'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->teacher->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
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
     * Generate new verification code.
     *
     * @return string
     */
    private function _generate_verification_code()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';

        $pin = mt_rand(1000, 9999) . mt_rand(1000, 9999) . $characters[rand(0, strlen($characters) - 1)];

        return str_shuffle($pin);
    }

    /**
     * Generate temporary password.
     *
     * @return string
     */

    private function _generate_temporary_password()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(100, 9999) . mt_rand(100, 9999) . $characters[rand(0, strlen($characters) - 1)];
        // shuffle the result
        return str_shuffle($pin);
    }
}
