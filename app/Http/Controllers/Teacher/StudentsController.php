<?php

namespace Teachat\Http\Controllers\Teacher;

use Auth;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\CurriculumInterface;
use Teachat\Repositories\Interfaces\StudentsInterface;
use Teachat\Repositories\Interfaces\TeacherSubjectsInterface;

class StudentsController extends Controller
{
    /**
     * @var CurriculumInterface
     */
    private $subject;

    /**
     * @var TeacherSubjectsInterface
     */
    private $teacherSubjects;

    /**
     * @var StudentsInterface
     */
    private $students;

    /**
     * @var ChildrenInterface
     */
    private $children;

    /**
     * Curriculum controller instance.
     *
     * @param CurriculumInterface $subject
     * @param TeacherSubjectsInterface $teacherSubjects
     * @param StudentsInterface $students
     * @param ChildrenInterface $children
     * @return void
     */
    public function __construct(CurriculumInterface $subject, TeacherSubjectsInterface $teacherSubjects, StudentsInterface $students, ChildrenInterface $children)
    {
        $this->subject = $subject;
        $this->teacherSubjects = $teacherSubjects;
        $this->students = $students;
        $this->children = $children;
    }

    /**
     * Display Students page.
     *
     * @return view
     */
    public function index()
    {
        return view('teacher.students');
    }

    /**
     * Get all subject.
     *
     * @return array
     */
    public function getAll($subject_id)
    {
        $students = $this->teacherSubjects->getAllByAttributesWithRelations(['user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id], ['subject'], 'subject_id')
            ->with(['subject' => function ($query) {
                $query->with(['grades' => function ($query) {
                    $query->select('id', 'description');
                }]);
                $query->with(['subjectCategory' => function ($query) {
                    $query->select('id', 'description');
                }]);
            }])
            ->get()
            ->toArray();

        $sc = array_map(function ($structure) use ($students) {
            $action = '<button id="btn-delete-students" type="button" class="btn btn-primary red btn-circle btn-delete-students" title="Delete"
                        onclick="deleteSubject(this)"
                        data-students-id="' . $structure['id'] . '"
                        data-subject-id="' . $structure['subject_id'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            $action .= '<a href="/teachers/students/add-students/' . $structure['id'] . '">
                    <button type="button" class="btn btn-primary blue btn-circle" title="Add Students">
                        <i class="material-icons">person_add</i>
                    </button></a>';

            return [
                'grade' => $structure['subject']['grades']['description'],
                'subject_category' => $structure['subject']['subject_category']['description'],
                'subject' => $structure['subject']['subject'],
                'action' => $action,
            ];
        }, $students);

        return ['data' => $sc];
    }

    /**
     * Get all students.
     *
     * @return array
     */
    public function get()
    {
        $students = $this->students
            ->get()
        /*->with(['child' => function ($query) {
        $query->with('grade');

        }])*/
            ->select('students.*', 'curriculum.subject', 'children.*', 'state_us.*', 'grades.id', 'grades.description', 'users.id AS ui', 'users.first_name AS ifn', 'users.middle_name AS mfn', 'users.last_name AS lfn')
            ->leftJoin('curriculum', 'students.curriculum_id', '=', 'curriculum.id')
            ->leftJoin('children', 'students.child_id', '=', 'children.id')
            ->leftJoin('grades', 'children.grade_id', '=', 'grades.id')
            ->leftJoin('users', 'children.parent_id', '=', 'users.id')
            ->leftJoin('state_us', 'children.state_id', '=', 'state_us.id')
            ->where(['children.approved' => 1, 'students.teacher_id' => Auth::user()->id, 'students.school_id' => Auth::user()->school_id])
            ->groupBy('students.child_id')
            ->get()
            ->toArray();

        $s = array_map(function ($structure) use ($students) {
            $action = '<a href="appointments/create/' . $structure['parent_id'] . '"><button id="btn-set-appointment" type="button" class="btn btn-primary btn-circle blue btn-flat btn-set-appointment" title="Set an Appointment"
                        data-parent-id="' . $structure['parent_id'] . '">
                        <i class="material-icons" style="color:#fff">perm_contact_calendar</i>
                    </button></a> ';
            $action .= '<button onclick="(viewStudent(this))" id="btn-view-student" type="button" class="btn btn-info btn-circle btn-flat teal btn-view-student" title="View Details"
                        data-child-id="' . $structure['child_id'] . '"
                        data-child-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '"
                        data-parent-name="' . $structure['ifn'] . ' ' . $structure['mfn'] . ' ' . $structure['lfn'] . '"
                        data-grade="' . $structure['description'] . '"
                        data-gender="' . $structure['gender'] . '"
                        data-state="' . $structure['state_name'] . '">
                        <i class="material-icons" style="color:#fff">visibility</i>
                    </button>';
            return [
                'name' => ucfirst($structure['first_name']) . ' ' . ucfirst($structure['middle_name']) . ' ' . ucfirst($structure['last_name']),
                'grade' => $structure['description'],
                'subject' => $structure['subject'],
                'action' => $action,
            ];
        }, $students);

        return ['data' => $s];
    }

    /**
     * Store a student.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->merge(array('teacher_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if ($this->students->create($request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Store a student.
     *
     * @return Response
     */
    public function storeAll($grade_id, $subject_id, Request $request)
    {
        $children = $this->children->getAllByAttributesWithRelations(['school_id' => Auth::user()->school_id, 'grade_id' => $grade_id, 'approved' => 1], ['grade'], 'last_name');

        $sc = array_map(function ($structure) use ($children, $subject_id) {

            if (!$this->students->getByAttributesFirst(['curriculum_id' => $subject_id, 'teacher_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id, 'child_id' => $structure['id']])) {

                $data = array('child_id' => $structure['id'], 'curriculum_id' => $subject_id, 'teacher_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id);

                $this->students->create($data);
            }

        }, $children);

        return response()->json(['success' => true, 'message' => 'Successfully created.']);
    }
}
