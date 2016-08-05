<?php

namespace Teachat\Http\Controllers\Teacher;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\SubjectRequest;
use Teachat\Models\TeacherSubjects;
use Teachat\Repositories\Interfaces\CurriculumInterface;
use Teachat\Repositories\Interfaces\GradesInterface;
use Teachat\Repositories\Interfaces\SubjectCategoryInterface;
use Teachat\Repositories\Interfaces\TeacherSubjectsInterface;

class SubjectsController extends Controller
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
     * @var GradesInterface
     */
    private $grades;

    private $subjectCategory;

    /**
     * Curriculum controller instance.
     *
     * @param CurriculumInterface $subject
     * @param TeacherSubjectsInterface $teacherSubjects
     * @return void
     */
    public function __construct(CurriculumInterface $subject, TeacherSubjectsInterface $teacherSubjects, GradesInterface $grades, SubjectCategoryInterface $subjectCategory)
    {
        $this->subject = $subject;
        $this->subjectCategory = $subjectCategory;
        $this->teacherSubjects = $teacherSubjects;
        $this->grades = $grades;
    }

    /**
     * Display subject page.
     *
     * @return View
     */
    public function index()
    {
        $selected_subjects = TeacherSubjects::where(['user_id' => Auth::user()->id], ['school_id' => Auth::user()->school_id])
            ->select('subject_id')
            ->get()
            ->toArray();

        $sc = array_map(function ($structure) use ($selected_subjects) {
            return $structure['subject_id'];

        }, $selected_subjects);

        $data['subjects'] = $this->subject->getAllByAttributesWithRelationsCustom(['school_id' => Auth::user()->school_id], ['grades', 'subjectCategory'], 'subject')->whereNotIn('id', $sc)->get()->toArray();

        return view('teacher.subject', $data);
    }

    /**
     * Get all subject.
     *
     * @return array
     */
    public function getAll()
    {
        //$subjects = $this->teacherSubjects->getAllByAttributesWithRelations(['user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id], ['subject'], 'subject_id');
        $subjects = TeacherSubjects::where(['user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id])
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

        $sc = array_map(function ($structure) use ($subjects) {

            $action = '<a href="/teacher/subjects/add-students/' . $structure['subject_id'] . '">
                    <button type="button" class="btn btn-primary btn-flat blue btn-circle" title="Add Students">
                        <i class="material-icons" style="color:#fff">person_add</i>
                    </button></a> ';

            $action .= '<button id="btn-delete-subjects" type="button" class="btn btn-primary red btn-circle btn-flat btn-delete-subjects" title="Delete"
                        onclick="deleteSubject(this)"
                        data-subjects-id="' . $structure['id'] . '"
                        data-subject-id="' . $structure['subject_id'] . '">
                        <i class="material-icons" style="color:#fff">delete</i>
                    </button>';

            return [
                'grade' => $structure['subject']['grades']['description'],
                'subject_category' => $structure['subject']['subject_category']['description'],
                'subject' => $structure['subject']['subject'],
                'action' => $action,
            ];
        }, $subjects);

        return ['data' => $sc];
    }

    /**
     * Store a new subject.
     *
     * @return Response
     */
    public function store(SubjectRequest $request)
    {
        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if ($this->teacherSubjects->create($request->all())) {

            return response()->json(['success' => true, 'message' => 'Successfully added.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Edit a subject.
     *
     * @param integer $id
     * @param GradesRequest $request
     * @return Response
     */
    public function update($id, GradesRequest $request)
    {
        if ($this->teacherSubjects->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Display adding students to a subject page.
     *
     * @param integer $id
     * @return Response
     */
    public function addStudents($id)
    {
        $curriculum = $this->subject->getByIdAndAttributes(['subject_category_id' => $id, 'school_id' => Auth::user()->school_id]);
        $grade = $this->grades->getByIdAndAttributes(['id' => $curriculum->grade_id]);

        $data = array(
            'curriculum' => $curriculum,
            'grade' => $grade,
        );

        return view('teacher.add-students', $data);
    }

    /**
     * Delete a subject.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->teacherSubjects->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }
}
