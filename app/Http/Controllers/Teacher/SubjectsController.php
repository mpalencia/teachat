<?php

namespace Teachat\Http\Controllers\Teacher;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\SubjectRequest;
use Teachat\Models\TeacherSubjects;
use Teachat\Repositories\Interfaces\CurriculumInterface;
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
     * Curriculum controller instance.
     *
     * @param CurriculumInterface $subject
     * @param TeacherSubjectsInterface $teacherSubjects
     * @return void
     */
    public function __construct(CurriculumInterface $subject, TeacherSubjectsInterface $teacherSubjects)
    {
        $this->subject = $subject;
        $this->teacherSubjects = $teacherSubjects;
    }

    /**
     * Display subject page.
     *
     * @return View
     */
    public function index()
    {
        $data['subjects'] = $this->subject->getAllByAttributesWithRelations(['school_id' => Auth::user()->school_id], ['grades', 'subjectCategory'], 'subject');

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
            $action = '<button id="btn-delete-subjects" type="button" class="btn btn-primary red btn-circle btn-delete-subjects" title="Delete"
                        onclick="deleteSubject(this)"
                        data-subjects-id="' . $structure['id'] . '"
                        data-subject-id="' . $structure['subject_id'] . '">
                        <i class="material-icons">delete</i>
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
