<?php

namespace Teachat\Http\Controllers\Admin;

use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\SchoolInterface;

class DashboardController extends Controller
{
    /**
     * @var School
     */
    private $school;

    /**
     * @param User $user
     * @param User $school
     */
    public function __construct(SchoolInterface $school)
    {
        $this->school = $school;
    }

    /**
     * Display school page
     *
     * @return view
     */
    public function index()
    {
        $data['schools'] = $this->school->getAllWithLimit();
        $data['schools_count'] = $this->school->getAll();

        return view('admin.dashboard.index', $data);
    }
}
