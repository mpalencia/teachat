<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\UserInterface;

class DashboardController extends Controller
{
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
     * Dashboard controller instance.
     *
     * @param SchoolInterface $school
     * @param AnnouncementsInterface $announcements
     * @param UserInterface $user
     * @return void
     */
    public function __construct(SchoolInterface $school, AnnouncementsInterface $announcements, UserInterface $user)
    {
        $this->school = $school;
        $this->announcements = $announcements;
        $this->user = $user;
    }

    /**
     * Display Dashboard page.
     *
     * @return view
     */
    public function index()
    {
        $data = array(
            'school' => $this->school->getById(Auth::user()->school_id),
            'announcements' => $this->announcements->getDashboardAnnoucements(Auth::user()->role_id, Auth::user()->school_id),
        );

        return view('school_admin.dashboard', $data);
    }
}
