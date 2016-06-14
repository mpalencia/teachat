<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\SubjectCategoryRequest;
use Teachat\Repositories\Interfaces\SubjectCategoryInterface;

class SubjectCategoryController extends Controller
{
    /**
     * @var SubjectCategoryInterface
     */
    private $subjectCategory;

    /**
     * Subject Category controller instance.
     *
     * @param SubjectCategoryInterface $subjectCategory
     * @return void
     */
    public function __construct(SubjectCategoryInterface $subjectCategory)
    {
        $this->subjectCategory = $subjectCategory;
    }

    /**
     * Display subject category page.
     *
     * @return View
     */
    public function index()
    {
        return view('school_admin.subject-category');
    }

    /**
     * Get all subject category.
     *
     * @return array
     */
    public function getAll()
    {
        $subject_category = $this->subjectCategory->getAllByAttributes(['user_id' => Auth::user()->id], 'description');

        $sc = array_map(function ($structure) use ($subject_category) {

            $action = '<button id="btn-edit-subject-category" type="button" class="btn btn-primary btn-circle btn-edit-subject-category" title="Edit"
                        onclick="editSubjectCategory(this)"
                        data-subject-category-id="' . $structure['id'] . '"
                        data-description="' . $structure['description'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';
            $action .= '<button id="btn-delete-subject-category" type="button" class="btn btn-primary red btn-circle btn-delete-subject-category" title="Delete"
                        onclick="deleteSubjectCategory(this)"
                        data-subject-category-id="' . $structure['id'] . '"
                        data-description="' . $structure['description'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'subject_category' => $structure['description'],
                'action' => $action,
            ];
        }, $subject_category);

        return ['data' => $sc];
    }

    /**
     * Store a new subject category.
     *
     * @return Response
     */
    public function store(SubjectCategoryRequest $request)
    {
        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if ($this->subjectCategory->create($request->all())) {

            return response()->json(['success' => true, 'message' => 'Successfully added.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Edit a subject category.
     *
     * @return Response
     */
    public function edit($id, SubjectCategoryRequest $request)
    {
        if ($this->subjectCategory->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Delete a subject category.
     *
     * @return Response
     */
    public function delete($id)
    {
        if ($this->subjectCategory->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }
}
