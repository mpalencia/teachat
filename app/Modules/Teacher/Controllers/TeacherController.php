<?php namespace App\Modules\Teacher\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Announcement\Controllers\AnnouncementController;
use App\Modules\Appointment\Controllers\AppointmentController;
use App\Modules\Files\Models\Files;
use App\Modules\Registration\Models\Pass_table;
use App\Modules\Registration\Models\Teacher_profile;
use App\Modules\Registration\Models\Users;
use App\Modules\SchoolAdmin\Models\Curriculum;
use App\Modules\School\Controllers\SchoolController;
use App\Modules\Student\Controllers\StudentController;
use App\Modules\Subject\Controllers\SubjectController;
use App\Modules\Teacher\Models\Advisory;
use App\Modules\Universal\Controllers\UniversalController;
use App\Modules\Universal\Models\History;
use Auth;
use Carbon\Carbon;
use Crypt;

class TeacherController extends Controller
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
    private $announcement;

    public function __construct()
    {
        $this->middleware('auth');
        $this->global = new UniversalController();
        $this->subject = new SubjectController();
        $this->student = new StudentController();
        $this->school = new SchoolController();
        $this->appointment = new AppointmentController();
        $this->announcement = new AnnouncementController();

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
        $this->data['notif'] = $this->appointment->getAllParentReplyCount(Auth::user()->id);
        $this->data['appt'] = $this->appointment->getAllParentReply(Auth::user()->id);
        $this->data['announcement'] = $this->announcement->show(null, null, Auth::user()->school_id);
        //dd($this->data);
        return view("Teacher::dashboard", $this->data);
    }

    public function myAccount()
    {
        $id = Auth::user()->id;
        //$this->qbLogin();
        $this->data['subject'] = $this->subject->getTeacherSubjects($id);
        $this->data['profile'] = $this->profile($id);
        $this->data['advisory'] = $this->getAdvisory($id);
        return view("Teacher::myaccount", $this->data);
    }

    public function Grades()
    {
        $id = Auth::user()->id;
        $this->data['profile'] = $this->profile($id);

        $this->data['curriculum'] = Curriculum::with(['grades', 'subjectCategory'])->where('school_id', Auth::user()->school_id)->get();

        return view("Teacher::grades", $this->data);
    }

    public function myStudent()
    {
        $id = Auth::user()->id;
        //$this->qbLogin();
        $this->data['students'] = $this->student->getTeacherStudents($id);
        $this->data['profile'] = $this->profile($id);

        //dd($this->data);
        return view("Teacher::students", $this->data);
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
                if ($parent['id'] == $appt->parent_id) {
                    $parent['appointment'] = $appt;
                }
            }
            array_push($aprentAndAppointment, $parent);
        }
        $this->data['messageOpponent'] = $aprentAndAppointment;
        $this->data['upload'] = $this->school->getUpdateState(Auth::user()->school_id);
        //dd($aprentAndAppointment);
        return view("Teacher::messages", $this->data);
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

        // = $appt;
        //dd($this->data);
        return view("Teacher::appointments", $this->data);
    }

    public function History()
    {
        //$this->qbLogin();
        $this->data['profile'] = $this->profile(Auth::user()->id);
        $this->data['History'] = $this->global->getHistory();
        //dd($this->data);
        return view("Teacher::history", $this->data);
    }

    public function settings()
    {
        //$this->qbLogin();
        $this->data['profile'] = $this->profile(Auth::user()->id);
        $this->data['settings'] = $this->profileSettings(Auth::user()->id);
        return view("Teacher::settings", $this->data);
    }

    public function add_Appointment()
    {
        $id = Auth::user()->id;
        //$this->qbLogin();
        $this->data['parents'] = $this->global->getMessagesOpponent(Auth::user());
        $this->data['profile'] = $this->profile($id);
        $this->data['upload'] = 0;
        $files = Files::where('teacher_id', $id)->get()->toArray();

        if (!empty($files)) {

            $this->data['upload'] = 1;
        }

        //dd($this->data);
        return view("Teacher::add-appointments", $this->data);
    }

    public function edit_Appointment($appt_id)
    {
        //$this->qbLogin();
        $id = Auth::user()->id;
        $this->data['profile'] = $this->profile($id);
        $this->data['parents'] = $this->global->getMessagesOpponent(Auth::user());
        $this->data['appt'] = $this->appointment->getAppointmentById($appt_id);
        //dd($this->data);
        return view("Teacher::edit-appointments", $this->data);
    }

    public function profile($id)
    {
        return $this->global->profile_image($id);
    }

    public function profileSettings($id)
    {
        $this->data['school'] = $this->school->getSchoolById(Auth::user()->school_id);
        $this->data['details'] = Teacher_profile::where('user_id', Auth::user()->id)->get()->toArray();
        return $this->data;
    }

    public function updateAdvisory($req)
    {
        $res = Advisory::where('teacher_id', Auth::user()->id)->update(['subject_id' => $req['grade']]);
        if ($res) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Advisory updated.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Error encountered. Please try again.', 'code' => '0'));
        }
    }

    public function getAdvisory($id)
    {
        $advisory = Advisory::where('teacher_id', $id)->get()->toArray();
        return $advisory;
    }

    public function updateSettings_tab($req)
    {
        $userData = $req->all();
        unset($userData['contact_no']);
        $tres = Teacher_profile::where('user_id', Auth::user()->id)->update(['contact_no' => $req->contact_no]);
        $ures = Users::where('id', Auth::user()->id)->update($userData);
        if ($tres && $ures) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Profile updated successfull.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Error encountered. Please try again.', 'code' => '0'));
        }

    }

}
