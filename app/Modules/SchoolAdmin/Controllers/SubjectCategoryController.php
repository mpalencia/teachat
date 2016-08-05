<?php

namespace App\Modules\SchoolAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolAdmin\Models\SubjectCategory;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class SubjectCategoryController extends Controller
{
    private $subjectCategory;

    public function __construct(SubjectCategory $subjectCategory)
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
        return view('SchoolAdmin::subject-category');
    }

    /**
     * Get all subject category.
     *
     * @return array
     */
    public function getAll()
    {
        $subject_category = $this->subjectCategory->where('user_id', Auth::user()->id)->get()->toArray();

        $sc = array_map(function ($structure) use ($subject_category) {

            $action = '<button id="btn-edit-subject-category" type="button" class="btn btn-primary btn-circle btn-edit-subject-category" title="Edit" data-toggle="modal" data-target="#edit-subject-category"
                        onclick="editSubjectCategory(this)"
                        data-subject-category-id="' . $structure['id'] . '"
                        data-description="' . $structure['description'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';
            $action .= '<button id="btn-delete-subject-category" type="button" class="btn btn-primary red btn-circle btn-delete-subject-category" title="Delete" data-toggle="modal" data-target="#delete-subject-category"
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
    public function store(Request $request)
    {
        $request->merge(array('user_id' => Auth::user()->id));

        $validator = Validator::make(['description' => $request->description], ['description' => 'required|max:50|unique:subject_category']);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->subjectCategory->create($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully added.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.'], 200);
    }

    /**
     * Edit a new subject category.
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $validator = Validator::make(['description' => $request->description], ['description' => 'required|max:50|unique:subject_category,description,' . $id]);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->subjectCategory->find($id)->update($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully updated.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }

    /**
     * Delete a new subject category.
     *
     * @return Response
     */
    public function delete($id)
    {
        if ($this->subjectCategory->find($id)->delete()) {
            return Response::json(['result' => true, 'message' => 'Successfully Deleted.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.'], 200);
    }
}
