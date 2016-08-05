<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Teachat\Services\Curl;
use Teachat\Services\MailSender;

use Illuminate\Http\Request;
use Teachat\Http\Requests\RegisterRequest;

use Teachat\Models\User;

use Teachat\Http\Requests;
use Teachat\Http\Controllers\Controller;

use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Carbon\Carbon;

class ManageParentsController extends Controller
{
    /**
     * @var UserInterface
     */
    private $parents;

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

    public function __construct(UserInterface $parents, ChildrenInterface $children, SchoolInterface $school, StateUsInterface $stateUs, CountryInterface $country)
    {
        $this->parents = $parents;
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
        $data['parents'] = User::select('users.*', 'children.parent_id')->join('children', 'users.id', '=', 'children.parent_id')->where('children.school_id', Auth::user()->school_id)->groupBy('children.parent_id')->get();
        return view('school_admin.manage-parents', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'state_us' => $this->stateUs->getAll(),
            'country' => $this->country->getAll(),
        ];
        return view('school_admin.add-parent', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $temp_password = $this->_generate_verification_code();
        $code = md5($this->_generate_verification_code());
        $birthdate = date_format(date_create($request->birthdate), 'Y-m-d');

        $request->merge(['birthdate' => $birthdate, 'password' => bcrypt($temp_password), 'role_id' => 3, 'approved' => 1, 'active' => 1, 'suspend' => 0, 'status' => 0]);

        $user = $this->parents->create($request->all());

        $fields = array(
            'user_id' => $user->id,
            'additional_data' => ['first_name' => $user->first_name, 'last_name' => $user->last_name],
        );

        $fields = json_encode($fields);

        $curl = new Curl();
        $curl->call($fields);

        $mailSender = new MailSender;

        $request->merge(['temp_password' => $temp_password, 'temp_name' => $request->email]);
        $mailSender->send('email.parent_email_confirmation', 'Email Confirmation', $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Created.', 'url' => '/school-admin/manage-parents/']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country_id = User::where('id', $id)->value('country_id');

        $data = [
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name'),
            'country' => $this->country->getAll(),
        ];

        $data['parent'] = User::where('id', $id)->first();

        return view('school_admin.edit-parent', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, RegisterRequest $request)
    {
        $query = User::where('id', '=', $id)->first();
        $old_email = $query->email;

        $birthdate = date_format(date_create($request->birthdate), 'Y-m-d');
        $request->merge(['birthdate' => $birthdate, 'role_id' => 3]);

        if($old_email != $request->email){
            $password = $this->_generate_verification_code();
            $request->merge(['password' => bcrypt($password)]);

            $request->merge(['temp_password' => $password]);

            $mailSender = new MailSender;

            $mailSender->send('email.parent_email_confirmation', 'Email Confirmation', $request->all());
        }

        if ($this->parents->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully Updated!', 'url' => '/school-admin/manage-parents/']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->parents->delete($id)) {
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
     * Display a certeain parent page.
     *
     * @return View
     */
    public function show($id)
    {
        $data['children'] = $this->children->getAllByAttributes(['parent_id' => $id], 'last_name');
        $data['parent_id'] = $id;

        return view('school_admin.manage-parent-child', $data);
    }

     /**
     * Get all children waiting for approval.
     *
     * @return array
     */
    public function getAllChildren($parent_id)
    {
        $children = $this->children->getAllByAttributes(['parent_id' => $parent_id], 'last_name');

        $s = array_map(function ($structure) use ($children) {

            $student_name = '<span> ' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . ' </span>';

            $action = '<button id="btn-delete-students" type="button" class="btn waves-effect white-text" data-toggle="modal" data-target="#view-students"
                        onclick="viewChild('.$structure['id'].')"
                        data-students-id="' . $structure['id'] . '"
                        data-students-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">search</i>Vew Information
                    </button>';

            return [
                'students' => $student_name,
                'action' => $action,
            ];
        }, $children);

        return ['data' => $s];
    }

    /**
     * Get all children waiting for approval.
     *
     * @return array
     */
    public function getChildById($child_id)
    {
        $children = $this->children->getAllByAttributesWithRelations(['id' => $child_id], ['grade', 'school'], 'last_name');

        $s = array_map(function ($structure) use ($children) {
            $name = '' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '';
            $gender = $structure['gender'];
            $bday = $structure['birthdate'] ? with(new Carbon($structure['birthdate']))->format('F d, Y') : '';;
            $grade = $structure['grade']['description'];
            $section = $structure['section'];
            $school = $structure['school']['school_name'];
            return [
                $name,
                $gender,
                $bday ,
                $grade,
                $school,
                $section
            ];
        }, $children);


        return ['data' => $s];
    }

    /**
     * Suspension update of parents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateField($id, Request $request)
    {
        if ($this->parents->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully Updated!']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

}
