<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Teachat\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * @var TeachersInterface
     */
    private $teacher;

    /**
     * Dashboard controller instance.
     *
     * @param TeacherInterface $teacher
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display Dashboard page.
     *
     * @return view
     */
    public function index()
    {
        return view('school_admin.dashboard');
    }
}
