<?php namespace App\Modules\Parent\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Announcement\Controllers\AnnouncementController;
use App\Modules\Appointment\Controllers\AppointmentController;
use App\Modules\Files\Controllers\FilesController;
use App\Modules\Parent\Models\Children;
use App\Modules\Registration\Models\Parent_profile;
use App\Modules\Registration\Models\Pass_table;
use App\Modules\Registration\Models\Users;
use App\Modules\School\Controllers\SchoolController;
use App\Modules\Student\Controllers\StudentController;
use App\Modules\Subject\Controllers\SubjectController;
use App\Modules\Universal\Controllers\UniversalController;
use Auth;
use Carbon\Carbon;
use Crypt;

class ParentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $global;
    private $profile;
    private $subject;
    private $student;
    private $school;
    private $appointment;
    private $files;
    private $announcement;

    public function __construct()
    {
        $this->middleware('auth');
        $this->global = new UniversalController();
        $this->subject = new SubjectController();
        $this->student = new StudentController();
        $this->school = new SchoolController();
        $this->appointment = new AppointmentController();
        $this->files = new FilesController();
        $this->announcement = new AnnouncementController();
        //$this->profile = $this->global->profile_image(Auth::user()->id);
    }

    public function index()
    {
        return $this->dashboard();
    }

    public function qbLogin()
    {
        $email = Auth::user()->email;
        $password = Crypt::decrypt(Pass_table::where('id', Auth::user()->id)->value('password'));
        $qbLogin = array('email' => $email, 'password' => $password);
        $this->data['notif'] = $this->appointment->getCountNewAppointment(Auth::user()->id);
        $this->data['upload'] = $this->school->getUpdateState(Auth::user()->school_id);
        $this->data['qbLogin'] = $qbLogin;
        return $this->data;
    }

    public function dashboard()
    {
        //$this->qbLogin();
        $this->data['todays_appt'] = json_decode($this->appointment->getAppointmentBySelectedDate(Carbon::now()->toDateString()));
        $this->data['badge'] = $this->school->getSchoolById(Auth::user()->school_id);
        $this->data['profile'] = $this->profile(Auth::user()->id);
        $this->data['file'] = $this->files->getAllNewAttachment(Auth::user()->id);
        $this->data['announcement'] = $this->announcement->show(null, null, Auth::user()->school_id);
        //dd($this->data);
        return view("Parent::dashboard", $this->data);
    }

    public function myAccount()
    {
        $id = Auth::user()->id;
        //$this->qbLogin();
        $this->data['profile'] = $this->profile($id);
        $this->data['details'] = $this->myProfile($id);
        //return $this->data['details'];
        //dd($this->data);
        return view("Parent::myaccount", $this->data);
    }

    public function myChild()
    {
        $id = Auth::user()->id;
        // $this->qbLogin();
        $this->data['profile'] = $this->profile($id);
        $this->data['child'] = $this->getChild($id);
        $this->files->updateAllNewAttachment($id);
        //dd($this->data);
        return view("Parent::child", $this->data);
    }

    public function Messages()
    {
        //$this->qbLogin();
        $this->data['messageOpponent'] = $this->global->getMessagesOpponent(Auth::user());
        $this->data['profile'] = $this->profile(Auth::user()->id);
        $this->data['todays_appt'] = json_decode($this->appointment->getAppointmentBySelectedDate(Carbon::now()->toDateString()));
        $aprentAndAppointment = [];
        foreach ($this->data['messageOpponent'] as $key => $parent) {
            $parent = $parent;
            foreach ($this->data['todays_appt'] as $key => $appt) {
                if ($parent['id'] == $appt->teacher_id) {
                    $parent['appointment'] = $appt;
                }
            }
            array_push($aprentAndAppointment, $parent);
        }
        $this->data['upload'] = $this->school->getUpdateState(Auth::user()->school_id);
        $this->data['messageOpponent'] = $aprentAndAppointment;
        return view("Parent::messages", $this->data);
    }

    public function Appointments()
    {
        //$this->qbLogin();
        $this->data['profile'] = $this->profile(Auth::user()->id);
        $appCollection = Collect(json_decode($this->appointment->getAllAppointmentByUser()));
        $this->data['appts'] = $appCollection;
        $appt = [];
        foreach ($this->data['appts'] as $key => $appt) {
            $appt->parent_id = json_decode($this->appointment->getAppointmentById_allDetails($appt->id));
        }
        $collectDate = $appCollection;
        $this->data['dates'] = $collectDate->unique('appt_date');

        return view("Parent::appointments", $this->data);
    }

    public function History()
    {
        //$this->qbLogin();
        $this->data['profile'] = $this->profile(Auth::user()->id);
        $this->data['History'] = $this->global->getHistory();
        return view("Parent::history", $this->data);
    }

    public function settings()
    {
        //$this->qbLogin();
        $this->data['profile'] = $this->profile(Auth::user()->id);
        return view("Parent::settings", $this->data);
    }

    public function add_Child()
    {
        //$this->qbLogin();
        $this->data['profile'] = $this->profile(Auth::user()->id);
        return view("Parent::add-child", $this->data);
    }

    public function edit_Child($child_id)
    {
        $id = Auth::user()->id;
        //$this->qbLogin();
        $this->data['profile'] = $this->profile($id);
        $this->data['child'] = $this->getChild($id, $child_id);
        //dd($this->data);
        if (empty($this->data['child'])) {
            dd('empty');
        }
        return view("Parent::edit-child", $this->data);
    }

    public function profile($id)
    {
        return $this->global->profile_image($id);
    }

    public function teachers()
    {
        $id = Auth::user()->id;
        //$this->qbLogin();
        $this->data['profile'] = $this->profile($id);
        $this->data['child'] = $this->getChild($id, null);
        $this->data['teacher'] = $this->global->getMessagesOpponent(Auth::user());
        //$this->data['mychild'] = collect($this->data['child']);
        //--join child count and details
        $child_all_details = [];
        $label = [];
        foreach ($this->data['child'] as $key => $child) {
            $label = $child;
            $details = $this->student->getMyChildsTeacher($child['id']);
            foreach ($details as $key => $detail) {
                if ($label['id'] == $detail->child_id) {
                    $label['detail'] = $details;
                }
            }
            array_push($child_all_details, $label);
        }
        //--end of join
        $this->data['mychild'] = collect($child_all_details);
        //dd($this->data);
        return view("Parent::teachers-list", $this->data);
    }

    public function myProfile($id)
    {
        $details = Users::where('id', $id)->get()->toArray();
        return $details;
    }

    public function parentMyaccount($req)
    {
        $id = Auth::user()->id;
        $resUser = Users::where('id', $id)->update(['name_prefix' => $req->name_prefix, 'first_name' => $req->first_name, 'last_name' => $req->last_name]);
        $resParent = Parent_profile::where('user_id', $id)->update(['address' => $req->address, 'contact_home' => $req->contact_home, 'contact_mobile' => $req->contact_mobile, 'contact_no' => $req->contact_work]);
        if ($resParent && $resUser) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Profile updated successfully.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Error encountered. Please try again.', 'code' => '0'));
        }
    }

    public function AddChild($req)
    {
        $age = $this->child_age($req->child_date_of_birth);
        if ($age < 5) {
            return json_encode(array('message' => '<i class="material-icons">warning</i> Please check the birthdate. Too young.', 'code' => '0'));
        } else {
            $req['child_age'] = $age;
            $req['parent_id'] = Auth::user()->id;
            $child_data = $req->all();
            $result = Children::create($child_data);
            if ($result) {
                return json_encode(array('message' => '<i class="material-icons">check</i> Your child credential created successfully.', 'code' => '1'));
            } else {
                return json_encode(array('message' => '<i class="material-icons">warning</i> Please check the fields.', 'code' => '0'));
            }
        }
    }

    public function child_age($date)
    {
        $dt = \Carbon\Carbon::parse($date);
        $age = \Carbon\Carbon::createFromDate($dt->year, $dt->month, $dt->day)->age;
        return $age;
    }

    public function getChild($parent_id, $id = null)
    {
        //dd($parent_id);
        if (isset($id)) {
            $child = Children::where(['id' => $id, 'parent_id' => $parent_id])->get()->toArray();
            return $child;
        } else {
            $res = Children::where('parent_id', $parent_id)->get()->toArray();
            return $res;
        }

    }

    public function UpdateChild($req)
    {
        $age = $this->child_age($req->child_date_of_birth);
        if ($age < 5) {
            return json_encode(array('message' => 'Please check the birthdate. Too young.', 'code' => '0'));
        } else {
            $result = Children::where('id', $req->id)->update($req->all());
            if ($result) {
                return json_encode(array('message' => '<i class="material-icons">check</i> Your child credential updated successfully.', 'code' => '1'));
            } else {
                return json_encode(array('message' => '<i class="material-icons">warning</i> Please check the fields.', 'code' => '0'));
            }
        }
    }

    public function deleteChild($req)
    {
        $result = Children::where(['id' => $req->id, 'parent_id' => Auth::user()->id])->delete();
        if ($result) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Child details successfully removed.', 'code' => '1'));
        } else {
            return json_encode(array('message' => 'Error. Please check the fields.', 'code' => '0'));
        }
    }

    public function addNewStudent($req)
    {
        $id = Auth::user()->id;
        $child_detail = $this->getChild($id, $req->child_id);
        $teacher_details = $this->global->getUser($req->teacher_id);
        $subject_details = $this->subject->getSubjectOfTeacher($req->teacher_id, $req->subject_id);
        $data = $req->all();
        $data['parent_id'] = $id;
        $data['child_grade'] = $child_detail[0]['child_grade'];
        $data['child_section'] = $child_detail[0]['child_section'];
        $result = json_decode($this->student->addNewStudent($data));
        if ($result->code === "1") {
            $teacher_fullName = $teacher_details[0]['name_prefix'] . '' . $teacher_details[0]['first_name'] . ' ' . $teacher_details[0]['last_name'];
            if (isset($subject_details[0]['subject_name'])) {
                $subject = $subject_details[0]['subject_name'];
            } else {
                $subject = '';
            }

            return json_encode(array('message' => '<i class="material-icons">check</i> Your child is successfully added!' /*, subject <strong>'.$subject.'</strong><br/> under <strong>'.$teacher_fullName.'</strong>'*/, 'code' => '1'));
        } else {
            return json_encode(array('message' => $result->message, 'code' => '0'));
        }
    }

    public function RemoveChildFrmStudent($req)
    {
        return $this->student->removeChildFrmStudents($req->id);
    }

    public function viewAttachment($apptid)
    {
        $id = Auth::user()->id;
        $this->qbLogin();
        $this->data['profile'] = $this->profile($id);
        $this->data['appointment'] = json_decode($this->appointment->getAppointmentById_allDetails($apptid));
        //dd($this->data);
        return view('Parent::appointments_attachment', $this->data);
    }
}
