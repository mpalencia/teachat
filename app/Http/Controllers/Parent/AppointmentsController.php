<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\AppointmentsRequest;
use Teachat\Repositories\Interfaces\AppointmentsInterface;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\StudentsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\MailSender;

class AppointmentsController extends Controller
{
    /**
     * @var AppointmentsInterface
     */
    private $appointments;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var ChildrenInterface
     */
    private $children;

    /**
     * @var StudentsInterface
     */
    private $students;

    /**
     * Appointments controller instance.
     *
     * @param AppointmentsInterface $appointments
     * @param UserInterface $user
     * @return void
     */
    public function __construct(AppointmentsInterface $appointments, UserInterface $user, ChildrenInterface $children, StudentsInterface $students)
    {
        $this->appointments = $appointments;
        $this->user = $user;
        $this->children = $children;
        $this->students = $students;
    }

    /**
     * Display Appointments page.
     *
     * @return view
     */
    public function index()
    {
        $appointments = $this->appointments->getByAttributesByGroup(['parent_id' => Auth::user()->id], 'teacher');

        $appointment_collection = Collect($appointments);

        $data = array(
            'profile' => $this->user->getById(Auth::user()->id),
            'appointments' => $appointment_collection,
        );

        return view('parent.appointments', $data);
    }

    /**
     * Get Appointments details.
     *
     * @param integer $id
     * @return view
     */
    public function show($id)
    {
        if (Auth::user()->role_id == 2) {
            return \DB::table('appointment')
                ->select('appointment.*', 'users.id as uid', 'users.first_name', 'users.last_name')
                ->join('users', 'appointment.parent_id', '=', 'users.id')
                ->where('appointment.id', $id)
                ->get();
        }
        return \DB::table('appointment')
            ->select('appointment.*', 'users.id as uid', 'users.first_name', 'users.last_name')
            ->join('users', 'appointment.teacher_id', '=', 'users.id')
            ->where('appointment.id', $id)
            ->get();

    }

    /**
     * Get all apoointments by parent.
     *
     * @return view
     */
    public function getAllByParent()
    {
        $appointments = $this->appointments->getAllByAttributesWithConditions(['parent_id' => Auth::user()->id]);

        $i = 0;
        $date = array();

        foreach ($appointments as $key => $apt) {
            $appointments[$i]->appt_date = $apt->appt_date;
            $appointments[$i]->date = $apt->appt_date;
            $i = $i + 1;
        }

        return json_encode($appointments);
    }

    /**
     * Get all apoointments by teacher.
     *
     * @return view
     */
    public function getAllByTeacher($teacher_id)
    {
        $appointments = $this->appointments->getAllByAttributesWithConditions(['teacher_id' => $teacher_id]);

        $i = 0;
        $date = array();
        $chain = array();
        foreach ($appointments as $key => $apt) {
            $appointments[$i]->appt_date = $apt->appt_date;
            $appointments[$i]->date = $apt->appt_date;
            $i = $i + 1;
            $chain[]['date'] = $apt->appt_date;
        }

        return json_encode($chain);
    }

    /**
     * Get all apoointments by selected date.
     *
     * @return view
     */
    public function getAllBySelectedDate($date)
    {
        $selected_date = $this->appointments->getAppointmentsToday(Auth::user()->id, $date, 'parent');

        return json_encode($selected_date);
    }

    /**
     * Get all time schedule of user.
     *
     * @return view
     */
    public function getTimeSchedule($date, $user_id)
    {
        $times = $this->appointments->getTimeSchedule($date, $user_id, 'parent');

        /*$t = array_map(function ($structure) {
        $time['start'] = [$structure['appt_stime'], $structure['appt_etime']];
        $time['end'] = [$structure['appt_etime'], $structure['appt_stime']];
        return $time;
        }, $time);*/

        $disabled_dates = array();

        foreach ($times as $key => $value) {

            $disabled_dates['start'][] = [$value['appt_stime'], $value['appt_etime']];
            $date = new \DateTime($value['appt_etime']);

            $disabled_dates['end'][] = [$value['appt_etime'], $date->modify("+1 minutes")->format('H:i A')];
        }

        return json_encode($times);
    }

    /**
     * Display create page.
     *
     * @return view
     */
    public function createWithParent($parent_id)
    {
        $parent = $this->user->getByAttributesFirst(['id' => $parent_id, 'role_id' => 3/*, 'school_id' => Auth::user()->school_id*/]);

        if (is_null($parent)) {
            abort(401);
        }

        $data = [
            'children' => $this->children->getAllByAttributes(['parent_id' => $parent_id/*, 'school_id' => Auth::user()->school_id*/], 'last_name'),
            'parent' => $parent,
        ];

        return view('parent.create-appointments-with-parent', $data);
    }

    /**
     * Display create page.
     *
     * @return view
     */
    public function create()
    {
        $teachers = $this->students->getAllByAttributesWithRelations(['parent_id' => Auth::user()->id], ['teacher'], 'id');

        // $children = $this->children->getAllByAttributes(['parent_id' => Auth::user()->id], 'first_name');
        // $school_ids = array();

        // if ($children) {
        //     foreach ($children as $key => $value) {
        //         $school_ids[] = $value['school_id'];
        //     }
        // }

        // $teachers = $this->user->getAllByAttributes(['role_id' => 2, 'school_id' => Auth::user()->school_id], 'last_name');

        if (is_null($teachers)) {
            abort(401);
        }

        $data = [

            'teachers' => $teachers,
        ];

        return view('parent.create_appointment', $data);
    }

    /**
     * Display create page.
     *
     * @return view
     */
    public function edit($id)
    {
        $appointment = $this->appointments->edit(['id' => $id, 'parent_id' => Auth::user()->id]);

        if (is_null($appointment)) {
            abort(401);
        }

        $data = [
            'appointment' => $appointment,
        ];

        return view('parent.edit-appointments', $data);
    }

    /**
     * Store an appointment.
     *
     * @return Response
     */
    public function store(AppointmentsRequest $request)
    {
        $duplicate = $this->appointments->getCountByAttributes(['teacher_id' => $request->teacher_id, 'appt_date' => $request->appt_date], $request->appt_stime, $request->appt_etime);

        if ($duplicate > 0) {
            return response()->json(['result' => false, 'message' => 'Date and time is already taken. Please choose another slot.']);
        }

        $request->merge(array('parent_id' => Auth::user()->id));

        if ($appointment = $this->appointments->create($request->all())) {

            $data = $this->appointments->getByIdWithRelations($appointment->id, 'parent');
            $user = $this->user->getById($appointment->teacher_id);
            $data[0]['user_image'] = $user['profile_img'];
            $data[0]['email'] = $user['email'];

            $mailer = new MailSender();
            $mailer->send('email.appointment_notification', 'Appointment', $data[0]);

            return response()->json(['success' => true, 'message' => 'Successfully created.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Edit an announcement.
     *
     * @param integer $id
     * @param AppointmentsRequest $request
     * @return Response
     */
    public function update($id, AppointmentsRequest $request)
    {
        if ($this->appointments->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Edit an announcement by attributes.
     *
     * @param Request $request
     * @return Response
     */
    public function updateByAttributes(Request $request)
    {
        if ($this->appointments->updateByAttributes(['parent_id' => Auth::user()->id], $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Delete a subject.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->appointments->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }

    /**
     * Save parent's response to teacher's appointment.
     *
     * @param Request $request
     * @return Response
     */
    public function parentResponse($id, Request $request)
    {
        if ($this->appointments->update($id, $request->all())) {
            $data = $this->appointments->getByIdWithRelations($id, 'parent');
            $user = $this->user->getById($data[0]['teacher_id']);

            $data[0]['user_image'] = $user['profile_img'];
            $data[0]['email'] = $user['email'];

            $mailer = new MailSender();
            $mailer->send('email.appointment_response', 'Appointment', $data[0]);

            return response()->json(['result' => true, 'message' => 'Your response has sucessfully submitted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while sending your response. Please try again later.']);
    }
}
