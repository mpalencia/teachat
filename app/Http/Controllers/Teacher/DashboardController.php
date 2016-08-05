<?php

namespace Teachat\Http\Controllers\Teacher;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\AccountRequest;
use Teachat\Http\Requests\ChangePasswordRequest;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\AppointmentsInterface;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
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
     * @var UserInterface
     */
    private $user;

    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * @var SateUsInterface
     */
    private $stateUs;

    /**
     * Dashboard controller instance.
     *
     * @param TeacherInterface $appointments
     * @return void
     */
    public function __construct(AppointmentsInterface $appointments, SchoolInterface $school, AnnouncementsInterface $announcements, UserInterface $user, CountryInterface $country, StateUsInterface $stateUs)
    {
        $this->appointments = $appointments;
        $this->school = $school;
        $this->announcements = $announcements;
        $this->user = $user;
        $this->country = $country;
        $this->stateUs = $stateUs;
    }

    /**
     * Display Dashboard page.
     *
     * @return view
     */
    public function index()
    {
        $data = array(
            'appointment_count' => $this->appointments->getCount(Auth::user()->id),
            'school' => $this->school->getById(Auth::user()->school_id),
            'appointments_today' => $this->appointments->getAllByAttributesWithRelations(['teacher_id' => Auth::user()->id, 'appt_date' => Carbon::now()->toDateString()], ['parent'], 'appt_date', 'ASC', '', false),
            'announcements' => $this->announcements->getDashboardAnnoucements(Auth::user()->role_id, Auth::user()->school_id),
            'appt' => $this->appointments->getAllByAttributesWithRelations(['teacher_id' => Auth::user()->id, 'status' => 0], ['parent'], 'created_at', 'DESC', 'not_null', false),
        );

        return view('teacher.dashboard', $data);
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
            'opponent_id' => 3,
        );
        return view('calls/video_chat', $data);
    }

    public function messages()
    {
        $data['parents'] = $this->user->getParentsByStudent(Auth::user()->id);

        return view('teacher.messages', $data);
    }

    public function history()
    {
        $data['appointments'] = $this->appointments->getActivityLogs(['teacher_id' => Auth::user()->id], ['parent'], 'created_at', 'DESC');
        return view('teacher.history', $data);
    }

    /**
     * Display the settings page.
     *
     * @param
     * @return view
     */

    public function settings()
    {
        $country_id = Auth::user()->country_id;
        $user_id = Auth::user()->id;

        $data = [
            'schools' => $this->school->getAllByAttributes(['id' => Auth::user()->school_id], 'school_name'),
            'country' => $this->country->getAll(),
            'user' => $this->user->getByIdWithRelationsAndAttributes($user_id, ['country', 'state'], ['country_id' => Auth::user()->country_id, 'state_id' => Auth::user()->state_id]),
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name'),
        ];

        return view('teacher.settings', $data);
    }

    /**
     * Get all state by country id.
     *
     * @param $country_id
     * @return view
     */
    public function getStateByCountryId($country_id)
    {
        $state = $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name');

        if (!empty($state)) {
            return ['result' => true, 'message' => $state];
        }

        return ['result' => false, 'message' => 'No State Available.'];

    }

    /**
     * Update the Teacher's Account.
     *
     * @param
     * @return view
     */

    public function settings_update(AccountRequest $request)
    {
        $id = Auth::user()->id;

        if ($this->user->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully Updated!']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Change Password
     *
     * @param
     * @return view
     */
    public function changePasswords(ChangePasswordRequest $request)
    {
        $id = Auth::user()->id;
        if (Auth::validate(['id' => $id, 'password' => $request->current_pass])) {
            $newPassword = bcrypt($request->password);
            if ($this->user->update($id, ['password' => $newPassword, 'password_reset' => 0])) {
                return response()->json(['success' => true, 'message' => 'Password changed successfully.']);
            }
        } else {
            return response()->json(['result' => false, 'message' => 'Current password did not match.']);
        }

    }

    /**
     * Upload Teacher's Profile in S3
     *
     * @param
     * @return view
     */
    public function uploadImage(Request $request)
    {
        $id = Auth::user()->id;

        if (($request->file('profile_img')) != '') {

            $file = $request->file('profile_img');
            $extension = $file->getClientOriginalExtension();
            $file_name = $file->getClientOriginalName();

            if (\Storage::disk('s3')->put('images/' . $file_name, \File::get($file), 'public') && $this->user->update($id, ['profile_img' => $file_name])) {
                return json_encode(array('result' => 'success', 'message' => 'Profile Picture successfully uploaded.'));
            } else {
                return json_encode(array('result' => 'error', 'message' => 'There is an error encountered while uploading. Please try again later.'));
            }
        } else {
            return json_encode(array('result' => 'error', 'message' => 'There is an error occurred while uploading. Please try again later.'));
        }
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
     * Upload Teacher's Profile in Local
     *
     * @param
     * @return view
     */

    public function uploadProfileImage_local(Request $request)
    {
        $id = Auth::user()->id;

        if (($request->file('profile_img')) != '') {

            $file = $request->file('profile_img');
            $extension = $file->getClientOriginalExtension();
            $file_name = $file->getClientOriginalName();
            $destination = public_path('/assets/images/profiles/');

            if ($request->file('profile_img')->move($destination, $file_name) && $this->user->update($id, ['profile_img' => $file_name])) {
                return json_encode(array('result' => 'success', 'message' => 'Profile Picture successfully uploaded.'));
            } else {
                return json_encode(array('result' => 'error', 'message' => 'There is an error encountered while uploading. Please try again later.'));

            }

        } else {
            return json_encode(array('result' => 'error', 'message' => 'There is an error occurred while uploading. Please try again later.'));
        }
    }

    /**
     * Get all parents for messaging
     *
     * @return view
     */
    public function getParentsByStudent()
    {
        echo "<pre>";
        print_r($this->user->getParentsByStudent(Auth::user()->id));die;
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
