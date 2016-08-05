<?php

namespace App\Http\Controllers;

use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Announcement\Controllers\AnnouncementController;
use App\Modules\Appointment\Controllers\AppointmentController;
use App\Modules\Files\Controllers\FilesController;
use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Login\Controllers\LoginController;
use App\Modules\Parent\Controllers\ParentController;
use App\Modules\Quickblox\Controllers\QuickbloxController;
use App\Modules\Registration\Models\Pass_table;
use App\Modules\Registration\Models\Users;
use App\Modules\SchoolAdmin\Controllers\DashboardController;
use App\Modules\School\Controllers\SchoolController;
use App\Modules\Subject\Controllers\SubjectController;
use App\Modules\SuperAdmin\Controllers\SuperAdminController;
use App\Modules\Teacher\Controllers\TeacherController;
use App\Modules\Universal\Controllers\UniversalController;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $Frontend;
    private $login;
    private $qb;
    private $teacher;
    private $parent;
    private $subject;
    private $global;
    private $file;
    private $appointment;
    private $admin;
    private $suAdmin;
    private $schoolAdmin;
    private $school;
    private $announcement;
    //

    public function __construct()
    {
        $this->Frontend = new FrontendController();
        $this->login = new LoginController();
        $this->qb = new QuickbloxController();
        $this->teacher = new TeacherController();
        $this->parent = new ParentController();
        $this->subject = new SubjectController();
        $this->global = new UniversalController();
        $this->file = new FilesController();
        $this->appointment = new AppointmentController();
        $this->admin = new AdminController();
        $this->suAdmin = new SuperAdminController();
        $this->school = new SchoolController();
        $this->announcement = new AnnouncementController();
        $this->schoolAdmin = new DashboardController();
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            return redirect('/Dashboard');
        } else {
            return view('Frontend::index');
        }
    }

    public function viewLogin()
    {
        return $this->Frontend->viewLogin();
    }

    public function processLogin(Request $req)
    {
        $this->middleware('auth');

        if (strlen($req->password) < 8) {
            return json_encode(array('message' => 'Password should be minimum of 8 character', 'code' => '0'));
            // break;
        } else {
            //$active = Users::where(['email'=>$req->email,'school_id'=>$req->school_id])->get(); #---old login
            $active = Users::where(['email' => $req->email])->get();
            if ($active->isEmpty()) {
                return json_encode(array('message' => 'Email or password is incorrect.', 'code' => '0'));
                // break;
            } else {
                $active = $active->toArray();
                //dd($active);
                if ($active[0]['status'] == 1) {
                    return json_encode(array('message' => 'Please confirm your email to continue', 'code' => '0'));
                    //   break;
                } else {
                    //$user_data = array('user'=>array('email'=>$req->email,'password'=>$req->password));//qb login
                    //$qb_result = $this->qb->qbLogin($user_data);
                    //if(isset($qb_result['success'])){
                    //dd(Hash::make($req->password));
                    if ($active[0]['approved'] == 0) {
                        return json_encode(array('message' => 'Your account is not approved by school admin yet.', 'code' => '0'));
                    }

                    if ($active[0]['approved'] == 2) {
                        return json_encode(array('message' => 'Your account has been denied by school admin.', 'code' => '0'));
                    }

                    if ($active[0]['suspend'] != 0 || $active[0]['suspend'] == '') {
                        return json_encode(array('message' => 'Your account has been suspended. Please contact the admin.', 'code' => '0'));
                    }
                    $remember = ($req->has('remember')) ? true : false;
                    if (Auth::attempt(['email' => $req->email, 'password' => $req->password], $remember)) {
                        $user = Users::where(['email' => $req->email])->get();
                        Users::where(['email' => $req->email])->update(['active' => '1']); //======status changer
                        Auth::loginUsingId($active[0]['id']);
                        return json_encode(array('message' => 'Login successful.', 'code' => '1'));
                    } else {
                        return json_encode(array('message' => 'Email or password is incorrect. Please try again.', 'code' => '0'));
                    }

                }
            }
        }
    }

    public function UserChangeStatus($id, $status)
    {
        Users::where('id', $id)->update(['active' => $status]);
        return json_encode(array('id' => $id, 'active' => $status));
    }

    public function getUsersStatus()
    {
        $res = Users::where('school_id', Auth::user()->school_id)->get()->toArray();
        return json_encode($res);
    }

    public function qbLogin()
    {
        $email = Auth::user()->email;
        $password = Crypt::decrypt(Pass_table::where('id', Auth::user()->id)->value('password'));
        $qbLogin = array('email' => $email, 'password' => $password);
        return $this->data['qbLogin'] = $qbLogin;
    }

    public function Dashboard()
    {

        if (Auth::check() != null) {
            if (Auth::user()->role_id === 2) {
                return $this->teacher->index();
            } else if (Auth::user()->role_id === 3) {
                return $this->parent->index();
            } else if (Auth::user()->role_id === 1) {
                return $this->admin->index();
            } else if (Auth::user()->role_id === 5) {
                return redirect('school-admin/dashboard'); //$this->schoolAdmin->index();
            } else {
                return $this->suAdmin->index();
            }
        } else {
            return redirect('/');
        }
    }

    public function logout()
    {
        Users::where('id', Auth::user()->id)->update(['active' => '0']);
        Auth::logout();
        return redirect('/');
    }

    public function myAccount()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 2) {
                return $this->teacher->myAccount();
            } else {
                return $this->parent->myAccount();
            }

        } else {
            return redirect('/');
        }
    }

    public function Grades()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->Grades();
        }
    }

    public function Students()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->myStudent();
        } else {
            return $this->parent->myChild();
        }
    }

    public function Messages()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->Messages();
        } else {
            return $this->parent->Messages();
        }
    }

    public function Appointments()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->Appointments();
        } else {
            return $this->parent->Appointments();
        }
    }

    public function History()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->History();
        } else {
            return $this->parent->History();
        }
    }

    public function Settings()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->settings();
        } else {
            return $this->parent->settings();
        }
    }

    public function add_Appointment()
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->add_Appointment();
        } else {
            //--perform error catch here
            dd('your not a teacher');
        }
    }

    public function edit_Appointment($id)
    {
        if (Auth::user()->role_id == 2) {
            return $this->teacher->edit_Appointment($id);
        } else {
            //--perform error catch here
            dd('your not a teacher');
        }
    }

    public function add_Child()
    {
        if (Auth::user()->role_id == 3) {
            return $this->parent->add_Child();
        } else {
            //--perform error catch here
            dd('your not a parent');
        }
    }

    public function edit_Child($id)
    {
        if (Auth::user()->role_id == 3) {
            return $this->parent->edit_Child($id);
        } else {
            //--perform error catch here
            dd('your not a parent');
        }
    }

    public function teachers()
    {
        if (Auth::user()->role_id == 3) {
            return $this->parent->teachers();
        } else {
            dd('opps youre not a parent');
        }
    }

    public function updateAdvisory(Request $req)
    {
        //dd($req->all());
        return $this->teacher->updateAdvisory($req->all());
    }

    public function addSubject(Request $req)
    {
        //dd($this->subject->addSubject($req));
        return $this->subject->addSubject($req);
    }

    public function deleteSubject($id)
    {
        return $this->subject->deleteSubject($id);
    }

    public function startVideoChat($type, $id, $duration, $session)
    {
        return $this->qb->startVideoChat($type, $id, $duration, $session);
    }

    public function accountVerifier($email, $code)
    {
        return $this->login->accountVerifier($email, $code);
    }

    public function parentMyaccount(Request $req)
    {
        return $this->parent->parentMyaccount($req);
    }

    public function AddChild(Request $req)
    {
        return $this->parent->AddChild($req);
    }

    public function UpdateChild(Request $req)
    {
        return $this->parent->UpdateChild($req);
    }

    public function deleteChild(Request $req)
    {
        return $this->parent->deleteChild($req);
    }

    public function getSubjectOfSelectedTeacher($id)
    {
        return $this->subject->getSubjectOfTeacher($id);
    }

    public function addNewStudent(Request $req)
    {
        return $this->parent->addNewStudent($req);
    }

    public function RemoveChildFrmStudent(Request $req)
    {
        return $this->parent->RemoveChildFrmStudent($req);
    }

    public function changePassword(Request $req)
    {
        return $this->global->UpdatePassword($req);
    }

    public function uploadProfileImage(Request $req)
    {
        //dd($req->all());
        return $this->global->uploadProfileImage($req);
    }

    public function getAllFileByStudentID($student_id)
    {
        return $this->file->getAllFileByStudentID($student_id);
    }

    public function uploadFile(Request $req)
    {
        return $this->file->file_upload($req);
    }

    public function deleteFileById($id)
    {
        return $this->file->deleteFileById($id);
    }

    public function create_appointment(Request $req)
    {
        return $this->appointment->create_Appointment($req);
    }

    public function getAllAppointmentByUser()
    {
        return $this->appointment->getAllAppointmentByUser();
    }

    public function getAppointmentBySelectedDate($date)
    {
        return $this->appointment->getAppointmentBySelectedDate($date);
    }

    public function downloadFileById($id)
    {
        return $this->file->file_download($id);
    }

    public function updateAppointmentById(Request $req)
    {
        return $this->appointment->updateAppointmentById($req);
    }

    public function viewAppointmentDetailsById($id)
    {
        return $this->appointment->getAppointmentById_allDetails($id);
    }

    public function deleteAppointmentById($id)
    {
        return $this->appointment->deleteAppointmentById($id);
    }

    public function parentResponseOnApoointment(Request $req)
    {
        // dd($req->all());
        return $this->appointment->parentResponseOnApoointment($req);
    }

    public function updateSettings_tab(Request $req)
    {
        return $this->teacher->updateSettings_tab($req);
    }

    public function createHistory(Request $req)
    {
        $this->global->createHistory($req);
    }

    public function getAllNewAppointment()
    {
        return $this->appointment->getAllNewAppointment(Auth::user()->id);
    }

    public function setAppointmentToSeen()
    {
        $this->appointment->setAppointmentToSeen(Auth::user()->id);
    }

    public function activatedPage()
    {
        return view('Frontend::activated');
    }

    public function viewAttachment($id)
    {
        return $this->parent->viewAttachment($id);
    }

    #---super admin functions
    public function SU_index()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->index();
        } else {
            return redirect('/Dashboard');
        }

    }

    public function SU_settings()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->settings();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function SU_principal()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->principal();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function SU_addPrincipal()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->addPrincipal();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function SU_editPrincipal($id)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->editPrincipal($id);
        } else {
            return redirect('/Dashboard');
        }
    }

    public function SU_schools()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->ViewSchool();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function SU_addSchool()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->AddSchool();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function SU_newSchool(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->school->created_newSchool($req);
        }
    }

    public function SU_addNewPrincipal(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->add_newPrincipal($req);
        }
    }

    public function SU_updatePrincipal(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            //dd($req->all());
            return $this->suAdmin->SU_updatePrincipal($req);
        }
    }

    public function SU_ChangeUploadState(Request $req)
    {

        if (Auth::user()->role_id === 4) {
            return $this->school->updateUploadState($req);
        }
    }

    public function SU_deletePrincipal($id)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->deletePrincipal($id);
        }
    }

    public function SU_updateSchool(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->school->updateSchool($req);
        }
    }

    public function SU_SchoolDelete(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            //dd($req->all());
            return $this->school->deleteSchoolById($req->id);
        }
    }

    public function SU_editSchool($id)
    {
        return $this->suAdmin->editSchool($id);
    }

    public function SU_viewTeachers()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->SU_viewTeachers();
        }
    }

    public function SU_viewUsers()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->SU_viewUsers();
        }
    }

    public function SU_suspendUser(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->SU_suspendUser($req);
        }
    }

    public function SU_location()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->su_viewLocation();
        }
    }

    public function addNewState(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            //dd($req->all());
            return $this->school->createNewState($req);
        }
    }

    public function SU_addTeacher()
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->viewAddteacher();
        }
    }

    public function SU_deleteTeacher(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->deleteTeacher($req);
        }
    }

    public function SU_editTeacher($id)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->editTeacher($id);
        }
    }

    public function SU_teacher_Update(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->SU_updateTeacher($req);
        }
    }

    public function SU_activateUser(Request $req)
    {
        if (Auth::user()->role_id === 4) {
            return $this->suAdmin->SU_statusUser($req);
        }
    }

    public function SU_editUser($id)
    {
        return $this->suAdmin->SU_editUser($id);
    }

    public function SU_updateState(Request $req)
    {

        return $this->school->updateState($req);
    }

    #--end of super admin

    #-- admin / principal
    public function admin_DashBoard()
    {
        if (Auth::user()->role_id === 1) {
            return $this->admin->index();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function admin_settings()
    {
        if (Auth::user()->role_id === 1) {
            return $this->admin->settings();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function admin_announcement()
    {
        if (Auth::user()->role_id === 1) {
            return $this->admin->announcement();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function admin_addAnnouncement()
    {
        if (Auth::user()->role_id === 1) {
            return $this->admin->addAnnouncement();
        } else {
            return redirect('/Dashboard');
        }
    }

    public function admin_editAnnouncement($id)
    {
        //dd($id);
        if (Auth::user()->role_id === 1) {
            return $this->admin->editAnnouncement($id);
        } else {
            return redirect('/Dashboard');
        }
    }

    public function addNewAnnouncement(Request $req)
    {
        if (Auth::user()->role_id === 1) {
            return $this->announcement->create($req);
        } else {
            return redirect('/Dashboard');
        }
    }

    public function updateAnnouncement(Request $req)
    {
        if (Auth::user()->role_id === 1) {
            return $this->announcement->update($req);
        } else {
            return redirect('/Dashboard');
        }
    }

    public function deleteAnnouncement($id)
    {
        if (Auth::user()->role_id === 1) {
            return $this->announcement->destroy($id);
        } else {
            return redirect('/Dashboard');
        }
    }

    public function viewAnnouncement($id)
    {
        return json_encode($this->announcement->show(null, $id));
    }
    #-- end admin / principal

    public function addSchoolEmail(Request $req)
    {
        $data = $req->all();
        //dd($data);
        Mail::send('school_request', ['data' => $data], function ($message) use ($data) {
            $message->to('info@teachat.co', 'name')->subject('Request School Teachat.co');
        });
        return json_encode(array('message' => 'Your request has been sent. Give us 48 hours to respond to your query.', 'code' => '1'));
    }
}
