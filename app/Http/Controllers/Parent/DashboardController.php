<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Carbon\Carbon;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\AppointmentsInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;

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
     * Dashboard controller instance.
     *
     * @param TeacherInterface $appointments
     * @return void
     */
    public function __construct(AppointmentsInterface $appointments, SchoolInterface $school, AnnouncementsInterface $announcements)
    {
        $this->appointments = $appointments;
        $this->school = $school;
        $this->announcements = $announcements;
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
            'appointments_today' => $this->appointments->getAllByAttributesWithRelations(['parent_id' => Auth::user()->id, 'appt_date' => Carbon::now()->toDateString()], ['teacher'], 'appt_date'),
            'announcements' => $this->announcements->getDashboardAnnoucements(Auth::user()->role_id, Auth::user()->school_id),
            'appt' => $this->appointments->getAllByAttributesWithRelations(['parent_id' => Auth::user()->id, 'status' => 0], ['user'], 'created_at', 'DESC', 'not_null'),
        );

        return view('parent.dashboard', $data);
    }
}
