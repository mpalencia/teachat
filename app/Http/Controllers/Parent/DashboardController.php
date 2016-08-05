<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\AppointmentsInterface;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\MailSender;

class DashboardController extends Controller
{
    /**
     * @var AppointmentsInterface
     */
    private $appointments;

    /**
     * @var SchoolInterface
     */
    private $school;

    /**
     * @var AnnouncementsInterface
     */
    private $announcements;

    /**
     * @var ChildrenInterface
     */
    private $children;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * Dashboard controller instance.
     *
     * @param TeacherInterface $appointments
     * @return void
     */
    public function __construct(AppointmentsInterface $appointments, SchoolInterface $school, AnnouncementsInterface $announcements, ChildrenInterface $children, UserInterface $user)
    {
        $this->appointments = $appointments;
        $this->school = $school;
        $this->announcements = $announcements;
        $this->children = $children;
        $this->user = $user;
    }

    /**
     * Display Dashboard page.
     *
     * @return view
     */
    public function index()
    {
        $children = $this->children->getAllByAttributes(['parent_id' => Auth::user()->id], 'first_name');
        $children_parent_ids = array();

        if ($children) {
            foreach ($children as $key => $value) {
                $children_parent_ids[] = $value['school_id'];
            }
        }
        else{
            $children_parent_ids[] = 0;
        }
        $data = array(
            'appointment_count' => $this->appointments->getCount(Auth::user()->id),
            //'school' => $this->school->getById(Auth::user()->school_id),
            'appointments_today' => $this->appointments->getAllByAttributesWithRelations(['parent_id' => Auth::user()->id, 'appt_date' => Carbon::now()->toDateString()], ['teacher'], 'appt_date', 'ASC', '', false),
            'announcements' => $this->announcements->getDashboardAnnoucements(Auth::user()->role_id, $children_parent_ids),
            'appt' => $this->appointments->getAllByAttributesWithRelations(['parent_id' => Auth::user()->id, 'status' => 0], ['teacher'], 'created_at', 'DESC', 'not_null', false),

        );

        return view('parent.dashboard', $data);
    }

    /**
     * Show video page.
     *
     * @param int $user_type
     * @param int $user_id
     * @param string $session_id
     * @return \Illuminate\Http\Response
     */
    public function videocall($user_type, $user_id, $session_id)
    {
        $data = array(
            'user_id' => $user_id,
            'session_id' => $session_id,
            'user_type' => $user_type,
            'duration' => 900,
            'opponent_id' => 2,
        );

        return view('calls/video_chat', $data);
    }

    public function messages()
    {
        $data['teachers'] = $this->user->getTeachersByChild(Auth::user()->id);

        return view('parent.messages', $data);
    }

    public function history()
    {
        $data['appointments'] = $this->appointments->getActivityLogs(['parent_id' => Auth::user()->id], ['teacher'], 'created_at', 'DESC');
        return view('parent.history', $data);
    }

    /**
     * Upload Parent's Profile in S3
     *
     * @return view
     */

    public function uploadImage(Request $request)
    {
        if (($request->file('profile_img')) != '') {

            $file = $request->file('profile_img');

            $file_name = $file->getClientOriginalName();

            if (\Storage::disk('s3')->put('images/' . $file_name, \File::get($file), 'public') && $this->user->update(Auth::user()->id, ['profile_img' => $file_name])) {
                return json_encode(array('result' => 'success', 'message' => 'Profile Picture successfully uploaded.'));
            }

            return json_encode(array('result' => 'error', 'message' => 'There is an error encountered while uploading. Please try again later.'));

        }

        return json_encode(array('result' => 'error', 'message' => 'There is an error occurred while uploading. Please try again later.'));

    }

    /**
     * Upload Teacher's Attachment in S3
     *
     * @param
     * @return view
     */
    public function uploadAttachment(Request $request)
    {
        $id = Auth::user()->id;

        if (($request->file('file_chat')) != '') {

            $file = $request->file('file_chat');
            $extension = $file->getClientOriginalExtension();
            $file_name = $file->getClientOriginalName();

            if (\Storage::disk('s3')->put('attach/' . $file_name, \File::get($file), 'public')) {
                return json_encode(array('result' => 'success', 'message' => 'https://s3-ap-southeast-1.amazonaws.com/teachatco/attach/' . $file_name));
            } else {
                return json_encode(array('result' => 'error', 'message' => 'There is an error encountered while uploading. Please try again later.'));
            }
        } else {
            return json_encode(array('result' => 'error', 'message' => 'There is an error occurred while uploading. Please try again later.'));
        }
    }

    /**
     * Upload Parent's Profile in local
     *
     * @return view
     */

    public function uploadProfileImage_local(Request $request)
    {
        $id = Auth::user()->id;

        if (($request->file('profile_img')) != '') {

            $file = $request->file('profile_img');

            $file_name = $file->getClientOriginalName();

            $destination = public_path('/assets/images/profiles/');

            if ($request->file('profile_img')->move($destination, $file_name) && $this->user->update($id, ['profile_img' => $file_name])) {
                return json_encode(array('result' => 'success', 'message' => 'Profile Picture successfully uploaded.'));
            }

            return json_encode(array('result' => 'error', 'message' => 'There is an error encountered while uploading. Please try again later.'));

        }
        return json_encode(array('result' => 'error', 'message' => 'There is an error occurred while uploading. Please try again later.'));

    }

    /**
     * Get all parents for messaging
     *
     * @return view
     */
    public function getTeachersByStudent()
    {
        echo "<pre>";
        print_r($this->user->getTeachersByChild(Auth::user()->id));die;
    }

    /**
     * Send Email from messages if user is offline
     *
     * @return view
     */
    public function sendEmailIfOffline(Request $req)
    {
        if(Auth::user()->email_notification == 1){
            $user = $this->user->getById($req->opp_id);

            $data = ['email'=>$user['email'], 'first_name'=>$user['first_name'], 'last_name'=>$user['last_name'], 'message'=>$req->message];

            $mailer = new MailSender();

            $mailer->send('email.message_notification', 'Someone message you to Teachat', $data);
        }

        return json_encode(array('result' => 'success', 'message' => 'Email successfully sent.'));
    }
}
