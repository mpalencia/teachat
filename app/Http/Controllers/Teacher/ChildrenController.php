<?php

namespace Teachat\Http\Controllers\Teacher;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\GradesInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\StudentsInterface;

class ChildrenController extends Controller
{
    /**
     * @var GradesInterface
     */
    private $grades;

    /**
     * @var StateUsInterface
     */
    private $stateUs;

    /**
     * @var ChildrenInterface
     */
    private $children;

    /**
     * @var StudentsInterface
     */
    private $students;

    /**
     * Dashboard controller instance.
     *
     * @param GradesInterface $grades
     * @param StateUsInterface $stateUs
     * @param ChildrenInterface $children
     * @param StudentsInterface $students
     * @return void
     */
    public function __construct(GradesInterface $grades, StateUsInterface $stateUs, ChildrenInterface $children, StudentsInterface $students)
    {
        $this->grades = $grades;
        $this->stateUs = $stateUs;
        $this->children = $children;
        $this->students = $students;
    }

    /**
     * Get all students.
     *
     * @return array
     */
    public function getAllStudents($subject_id, $grade_id)
    {
        $children = $this->children->getAllByAttributesWithRelations(['school_id' => Auth::user()->school_id, 'grade_id' => $grade_id, 'approved' => 1], ['grade'], 'last_name');

        $sc = array_map(function ($structure) use ($children, $subject_id) {

            if (!$this->students->getByAttributesFirst(['curriculum_id' => $subject_id, 'teacher_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id, 'child_id' => $structure['id']])) {
                $action = '<button id="" type="button" class="btn-floating btn-flat blue" title="Delete"
                            onclick="addStudentToSubject(this)"
                            data-students-id="' . $structure['id'] . '"
                            data-curriculum-id="' . $subject_id . '">
                            <i class="material-icons">person_add</i>
                        </button>';

                return [
                    'action' => $action,
                    'name' => ucwords($structure['first_name']) . ' ' . ucwords($structure['middle_name'][0]) . ' ' . ucwords($structure['last_name']),

                ];
            }
        }, $children);

        return ['data' => array_slice(array_filter($sc), 0)];
    }
}
