<?php namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Files\Controllers\FilesController;
use App\Modules\Registration\Models\Users;
use Auth;
use Carbon\Carbon;
use DB;
use Mail;

class AppointmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $file;

    public function __construct()
    {
        $this->file = new FilesController();
    }

    public function create_Appointment($req)
    {
        $teacher_id = Auth::user()->id;
        if ($req->parent_id === '0') {
            return json_encode(array('message' => 'Please select parent', 'code' => '0'));
        } else if ($req->appt_date === '') {
            return json_encode(array('message' => 'Please select date', 'code' => '0'));
        } else {
            $apptData = $req->all();

            if (isset($req->file)) {
                //upload file here
                $res = json_decode($this->file->file_upload($req));
                unset($apptData['file']);
                $apptData['file_id'] = $res->file_id;

            }

            $apptData['teacher_id'] = $teacher_id;
            //dd($apptData);
            $check_duplicate = Appointment::where(['teacher_id' => $apptData['teacher_id'], 'appt_date' => $apptData['appt_date'], 'appt_stime' => $apptData['appt_stime']])->count();

            if ($check_duplicate === 0) {
                $res = Appointment::create($apptData);
                if ($res) {
                    $this->EmailParentForNewAppointment($res->id);
                    return json_encode(array('message' => '<i class="material-icons">check</i> Appointment is set successful.', 'code' => '1'));
                } else {
                    return json_encode(array('message' => '<i class="material-icons">error</i> Something went wrong please try again', 'code' => '0'));
                }
            } else {
                return json_encode(array('message' => '<i class="material-icons">warning</i> Date and time is already taken. Please choose another slot', 'code' => '0'));
            }

        }
    }

    public function getAllAppointmentByUser()
    {
        $id = Auth::user()->id;
        $role_id = Auth::user()->role_id;
        if ($role_id == 2) {
            //---teacher
            //$res = Appointment::where('teacher_id',$id)->get();
            $res = DB::table('appointment')
                ->where('teacher_id', '=', $id)
                ->where('appt_date', '>=', Carbon::now()->toDateString())->get();
            //dd($res);
        } else {
            //--parent
            $res = DB::table('appointment')
                ->where('parent_id', '=', $id)
                ->where('appt_date', '>=', Carbon::now()->toDateString())
                ->whereIn('action', ['Accept', 'Inperson', null, ''])
                ->get();
        }

        $i = 0;
        foreach ($res as $key => $apt) {
            $res[$i]->appt_date = $apt->appt_date;
            $i = $i + 1;
        }
        //dd($res);
        return json_encode($res);
    }

    public function getAppointmentBySelectedDate($date)
    {
        $id = Auth::user()->id;
        if (Auth::user()->role_id == 2) {
            $res = DB::table('appointment')->select('appointment.id as Appt_id', 'appointment.*', 'users.*')
                ->join('users', 'appointment.parent_id', '=', 'users.id')
                ->where('appointment.teacher_id', '=', $id)
                ->where('appointment.appt_date', '=', $date)
                ->get();
            //Appointment::where(['teacher_id'=>$id,'date'=>$date])->get()->all();
        } else {
            //--parent
            $res = $res = DB::table('appointment')->select('appointment.id as Appt_id', 'appointment.*', 'users.*')
                ->join('users', 'appointment.teacher_id', '=', 'users.id')
                ->where('appointment.parent_id', '=', $id)
                ->where('appointment.appt_date', '=', $date)
                ->get();

        }
        //dd($res);
        return json_encode($res);
    }

    public function getAppointmentById($id)
    {
        $res = Appointment::where('id', $id)->get()->toArray();
        if ($res[0]['file_id'] !== null) {
            $file = $this->file->getFileById($res[0]['file_id']);
            $res[0]['file_data'] = $file;
        }
        return $res;
    }

    public function updateAppointmentById($req)
    {
        $reqData = $req->all();
        $dataCheck = array('date' => $reqData['date'], 'appt_stime' => $reqData['appt_stime'], 'appt_etime' => $reqData['appt_etime']);
        $check_duplicate = Appointment::where($dataCheck)->count();
        if ($check_duplicate === 0) {
            Appointment::where('id', $reqData['id'])->update($reqData);
            return json_encode(array('message' => '<i class="material-icons">check</i> Updated successfully.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">warning</i> Time or date is already taken.', 'code' => '0'));
        }
    }

    public function getAppointmentById_allDetails($id)
    {
        $res = Appointment::where('id', $id)->get()->toArray();
        if ($res[0]['file_id'] !== null) {
            $file = $this->file->getFileById($res[0]['file_id']);
            $res[0]['file_data'] = $file;
        }

        if (Auth::user()->role_id === 2) {
            $user = Users::where('id', $res[0]['parent_id'])->get()->toArray();
            $res[0]['user'] = $user;
        } else {
            $user = Users::where('id', $res[0]['teacher_id'])->get()->toArray();
            $res[0]['user'] = $user;
        }

        return json_encode($res);
    }

    public function deleteAppointmentById($id)
    {
        $user_id = Auth::user()->id;
        $res = Appointment::where(['id' => $id, 'teacher_id' => $user_id])->delete();
        if ($res) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Appointment is deleted successful.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Something went wrong please try again', 'code' => '0'));
        }

    }

    public function parentResponseOnApoointment($req)
    {
        //dd($req->all());
        $res = Appointment::where('id', $req->id)->update(['action' => $req->res]);
        if ($res) {
            $this->EmailTeacherForParentResponse($req->id);
            return json_encode(array('message' => '<i class="material-icons">check</i> Your response has sucessfully submitted.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">warning</i> Something went wrong please try again', 'code' => '0'));
        }
    }

    public function getAllNewAppointment($id)
    {
        $res = DB::table('appointment')->select('appointment.*', 'appointment.id as Appt_id', 'users.*')
            ->join('users', 'appointment.teacher_id', '=', 'users.id')
            ->where('appointment.parent_id', '=', $id)
            ->where('appt_date', '>=', Carbon::now()->toDateString())
            ->whereNULL('appointment.action')
            ->get();

        return json_encode($res);
    }

    public function getCountNewAppointment($id)
    {
        $res = DB::table('appointment')->where('parent_id', '=', $id)
            ->where('appt_date', '>=', Carbon::now()->toDateString())
            ->whereNULL('action')->count(); //Appointment::where(['parent_id'=>$id,'status'=>'0'])->count();
        if (count($res) < 2) {
            $res = $res;
        }
        //dd($res);
        return $res;
    }

    public function setAppointmentToSeen($id)
    {
        Appointment::where('teacher_id', $id)->update(['status' => '1']);
    }

    public function getAllParentReply($id)
    {
        $res = DB::table('appointment')->select('appointment.*', 'appointment.id as Appt_id', 'users.*')
            ->join('users', 'appointment.parent_id', '=', 'users.id')
            ->where('appointment.teacher_id', '=', $id)
            ->where('appointment.status', '=', '0')
            ->whereNotNull('appointment.action')
            ->get();
        return $res;
    }

    public function getAllParentReplyCount($id)
    {
        $res = count($this->getAllParentReply($id));
        if (count($res) < 2) {
            $res = $res;
        }
        return $res;

    }

    public function EmailParentForNewAppointment($id)
    {
        $data = json_decode($this->getAppointmentById_allDetails($id));
        $data['teacher'] = Users::where('id', $data[0]->teacher_id)->get();
        //dd($data);
        Mail::send('appointment_notif', ['data' => $data], function ($message) use ($data) {
            $message->to($data[0]->user[0]->email, 'name')->subject('New appointment - Teachat.co');
        });
    }

    public function EmailTeacherForParentResponse($id)
    {
        $data = json_decode($this->getAppointmentById_allDetails($id));
        $data['parent'] = Users::where('id', $data[0]->parent_id)->get();
        //dd($data);
        Mail::send('appointment_response', ['data' => $data], function ($message) use ($data) {
            $message->to($data[0]->user[0]->email, 'name')->subject('New appointment - Teachat.co');
        });
    }

}
