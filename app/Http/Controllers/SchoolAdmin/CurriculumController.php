<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Response;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\CurriculumRequest;
use Teachat\Repositories\Interfaces\CurriculumInterface;
use Teachat\Repositories\Interfaces\GradesInterface;
use Teachat\Repositories\Interfaces\SubjectCategoryInterface;

class CurriculumController extends Controller
{
    /**
     * @var CurriculumInterface
     */
    private $curriculum;

    /**
     * @var SubjectCategoryInterface
     */
    private $subjectCategory;

    /**
     * @var GradesInterface
     */
    private $grades;

    public function __construct(CurriculumInterface $curriculum, SubjectCategoryInterface $subjectCategory, GradesInterface $grades)
    {
        $this->curriculum = $curriculum;
        $this->subjectCategory = $subjectCategory;
        $this->grades = $grades;
    }

    /**
     * Display curriculum page.
     *
     * @return View
     */
    public function index()
    {
        $data['grades'] = $this->grades->getAll();
        $data['subjectCategory'] = $this->subjectCategory->getAllByAttributes(['user_id' => Auth::user()->id], 'description');

        return view('school_admin.curriculum', $data);
    }

    /**
     * Get all curriculum.
     *
     * @return array
     */
    public function getAll()
    {
        $curriculum = $this->curriculum->getAllByAttributesWithRelations(['user_id' => Auth::user()->id], ['grades', 'subjectCategory'], 'subject');

        $c = array_map(function ($structure) use ($curriculum) {

            $action = '<button id="btn-edit-curriculum" type="button" class="btn btn-primary teal btn-circle btn-flat btn-edit-curriculum" title="Edit" data-toggle="modal" data-target="#edit-curriculum"
                        onclick="editCurriculum(this)"
                        data-curriculum-id="' . $structure['id'] . '"
                        data-grade-id="' . $structure['grade_id'] . '"
                        data-subject-category-id="' . $structure['subject_category_id'] . '"
                        data-subject="' . $structure['subject'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';
            $action .= '<button id="btn-delete-curriculum" type="button" class="btn btn-danger btn-circle btn-flat red btn-delete-curriculum" title="Delete" data-toggle="modal" data-target="#delete-curriculum"
                        onclick="deleteCurriculum(this)"
                        data-curriculum-id="' . $structure['id'] . '"
                        data-grade-id="' . $structure['grade_id'] . '"
                        data-subject-category-id="' . $structure['subject_category_id'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'grades' => $structure['grades']['description'],
                'subject_category' => $structure['subject_category']['description'],
                'subject' => $structure['subject'],
                'action' => $action,
            ];
        }, $curriculum);

        return ['data' => $c];
    }

    /**
     * Store a new curriculum.
     *
     * @return Response
     */
    public function store(CurriculumRequest $request)
    {
        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if ($this->curriculum->create($request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully added.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Edit a curriculum.
     *
     * @return Response
     */
    public function update($id, CurriculumRequest $request)
    {
        if ($this->curriculum->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Delete a curriculum.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->curriculum->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }
}
