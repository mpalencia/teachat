<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Carbon\Carbon;
use DB;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\ChildrenRequest;
use Teachat\Http\Requests\SubjectRequest;
use Teachat\Models\Children;
use Teachat\Models\TeacherSubjects;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\GradesInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\StudentsInterface;
use Teachat\Repositories\Interfaces\TeacherSubjectsInterface;

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
     * @var TeacherSubjectsInterface
     */
    private $teacherSubjects;

    /**
     * @var SchoolInterface
     */
    private $school;

    /**
     * Dashboard controller instance.
     *
     * @param GradesInterface $grades
     * @param StateUsInterface $stateUs
     * @param ChildrenInterface $children
     * @param TeacherSubjectsInterface $teacherSubjects
     * @param SchoolInterface $school
     * @return void
     */
    public function __construct(GradesInterface $grades, StateUsInterface $stateUs, ChildrenInterface $children, TeacherSubjectsInterface $teacherSubjects, StudentsInterface $students, SchoolInterface $school)
    {
        $this->grades = $grades;
        $this->stateUs = $stateUs;
        $this->children = $children;
        $this->teacherSubjects = $teacherSubjects;
        $this->students = $students;
        $this->school = $school;
    }

    /**
     * Display list page.
     *
     * @return view
     */
    public function index()
    {
        $grades = $this->children->getByAttributes(['parent_id' => Auth::user()->id]);
        $data = [
            'children' => $this->children->getAllByAttributesWithRelations(['parent_id' => Auth::user()->id], ['grade', 'school'], 'last_name'),
        ];

        return view('parent.index_child', $data);
    }

    /**
     * Get all grades by school id.
     *
     * @param $school_id
     * @return view
     */
    public function getGradesBySchoolId($school_id)
    {
        $grades = $this->grades->getAllByAttributes(['school_id' => $school_id], 'description');

        if (!empty($grades)) {
            return ['result' => true, 'message' => $grades];
        }

        return ['result' => false, 'message' => 'No Grades Available.'];

    }

    /**
     * Display create page.
     *
     * @return view
     */
    public function create()
    {
        $data = [
            'grades' => $this->grades->getAll(),
            'children' => $this->children->getAllByAttributes(['parent_id' => Auth::user()->id], 'last_name'),
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => Auth::user()->country_id], 'state_name'),
            'schools' => $this->school->getAllByAttributes(['country_id' => Auth::user()->country_id], 'school_name'),
        ];

        return view('parent.create_child', $data);
    }

    /**
     * Display edit page.
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $child = DB::table('children')->where('id', '=', $id)->first();
        $data = [
            'grades' => $this->grades->getAll(),
            'children' => $this->children->getAllByAttributes(['parent_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id], 'last_name'),
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => Auth::user()->country_id], 'state_name'),
            'child' => $this->children->getByIdWithRelationsAndAttributes($id, ['parent', 'state', 'grade'], ['parent_id' => Auth::user()->id, 'school_id' => $child->school_id]),
            'schools' => $this->school->getAllByAttributes(['country_id' => Auth::user()->country_id], 'school_name'),
        ];
        return view('parent.edit_child', $data);
    }

    /**
     * Store a new child.
     *
     * @return Response
     */
    public function store(ChildrenRequest $request)
    {
        $request->merge(array('parent_id' => Auth::user()->id));
        $request->merge(array('state_id' => Auth::user()->state_id));

        if (intval(explode("-", $request->birthdate)[0]) > intval(date('Y'))) {
            return json_encode(array('result' => 'error', 'message' => 'Invalid Birthdate.'));
        }

        $age = $this->_child_age($request->birthdate);

        if ($age < 5) {
            return json_encode(array('result' => 'error', 'message' => 'Please check the birthdate. Too young.'));
        }

        if ($this->children->create($request->all())) {
            return json_encode(array('result' => 'success', 'message' => 'Successfully Added!'));
        }

        return json_encode(array('result' => 'error', 'message' => 'There is an error occured while saving. Please try again later.'));
    }

    /**
     * Edit a child.
     *
     * @return Response
     */
    public function update($id, ChildrenRequest $request)
    {
        if (intval(explode("-", $request->birthdate)[0]) > intval(date('Y'))) {
            return json_encode(array('result' => 'error', 'message' => 'Invalid Birthdate.'));
        }

        $age = $this->_child_age($request->birthdate);

        if ($age < 5) {
            return json_encode(array('result' => 'error', 'message' => 'Please check the birthdate. Too young.'));
        }

        if ($this->children->update($id, $request->all())) {
            return json_encode(array('result' => 'success', 'message' => 'Successfully Updated!'));
        }

        return json_encode(array('result' => 'error', 'message' => 'There is an error occured while updating. Please try again later.'));

    }

    /**
     * Delete a child.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->children->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }

    /**
     * Add teacher to parent's child.
     *
     * @return Response
     */
    public function addTeachers($child_id)
    {
        $child = $this->children->getById($child_id);
        $data['child'] = $child;

        $data['subjects'] = \DB::table('teacher_subjects')
            ->where(['teacher_subjects.school_id' => $child->school_id, 'curriculum.grade_id' => $child->grade_id])
            ->select('teacher_subjects.*', 'curriculum.*', 'subject_category.id as sc_id', 'subject_category.description as subject_desc', 'users.id', 'users.first_name', 'users.last_name')
            ->leftJoin('users', 'teacher_subjects.user_id', '=', 'users.id')
            ->leftJoin('curriculum', 'teacher_subjects.subject_id', '=', 'curriculum.id')
            ->leftJoin('subject_category', 'curriculum.subject_category_id', '=', 'subject_category.id')
            ->groupBy('subject_id')
            ->get();

        return view('parent.add_teacher', $data);
    }

    private function _child_age($date)
    {
        $dt = Carbon::parse($date);
        $age = Carbon::createFromDate($dt->year, $dt->month, $dt->day)->age;
        return $age;
    }

    /**
     * Get teachers by subject id
     *
     * @param integer $subject_id
     * @return view
     */
    public function getTeachersBySubjectId($subject_id)
    {
        $teachers = TeacherSubjects::where(['subject_id' => $subject_id])
            ->with(['teacher' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'profile_img');
            }])
            ->get()
            ->toArray();

        if (empty($teachers)) {
            return ['result' => false, 'message' => 'No teachers available.'];
        }

        return ['result' => true, 'message' => $teachers];
    }

    /**
     * Store a new subject.
     *
     * @return Response
     */
    public function addTeacherToChild(SubjectRequest $request)
    {
        if ($request->teacher_id == '') {
            return response()->json(['result' => false, 'message' => 'Please select a Teacher']);
        }

        $checkIfExist = $this->students->getAllByAttributes(array('child_id' => $request->child_id, 'teacher_id' => $request->teacher_id, 'curriculum_id' => $request->subject_id, 'school_id' => Auth::user()->school_id), 'child_id');

        if (!empty($checkIfExist)) {
            return response()->json(['result' => false, 'message' => 'Your child is already in this subject.']);
        }

        $request->merge(array('parent_id' => Auth::user()->id, 'teacher_id' => $request->teacher_id, 'curriculum_id' => $request->subject_id, 'school_id' => $request->school_id));

        if ($this->students->create($request->all())) {

            return response()->json(['success' => true, 'message' => 'Successfully added.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Get teachers by subject id
     *
     * @param integer $subject_id
     * @return view
     */
    public function getTeachersByChildId($child_id)
    {
        $teachers = $this->students->getAllByAttributesWithRelations(array('child_id' => $child_id, 'school_id' => Auth::user()->school_id), ['teacher'], 'child_id');

        if (empty($teachers)) {
            return ['result' => false, 'message' => 'No teachers available.'];
        }

        $teacher = array_map(function ($structure) use ($teachers) {
            $action = '<button id="btn-delete-teachers" type="button" class="btn btn-primary red btn-circle btn-delete-teachers" title="Delete"
                        onclick="deleteSubject(this)"
                        data-teachers-id="' . $structure['id'] . '"
                        data-subject-id="' . $structure['teacher']['first_name'] . '">
                        <i class="material-icons">delete</i>
                        </button>';

            $action .= '<a href="/teachers/teachers/add-teachers/' . $structure['id'] . '">
                        <button type="button" class="btn btn-primary blue btn-circle" title="Add Students">
                        <i class="material-icons">person_add</i>
                        </button></a>';

            $image = ($structure['teacher']['profile_img'] == 'dp.png') ? '<img src="' . asset("/images/dp.png") . '>' : '<img src=https://s3-ap-southeast-1.amazonaws.com/teachatco/images/"' . $structure['teacher']['profile_img'] . '" alt="" class="circle">';
            return [
                'teacher' => $structure['teacher']['first_name'] . ' ' . $structure['teacher']['last_name'],
                'image' => $image,
                'action' => $action,
            ];
        }, $teachers);

        return ['data' => $teacher];
    }

    /**
     * Get all teachers by child id
     *
     * @param integer $subject_id
     * @return view
     */
    public function getTeachers($child_id)
    {

        $data = [
            'child' => $this->children->getByIdWithRelations($child_id, ['parent']),
            'teachers' => $this->students->getCustom(array('child_id' => $child_id)),
        ];

        return view('parent.index_teachers', $data);
    }
}
