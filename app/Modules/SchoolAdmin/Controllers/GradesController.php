<?php

namespace App\Modules\SchoolAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolAdmin\Models\Grades;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class GradesController extends Controller
{
    private $grades;

    public function __construct(Grades $grades)
    {
        $this->grades = $grades;
    }

    /**
     * Display grades page.
     *
     * @return View
     */
    public function index()
    {
        return view('SchoolAdmin::grades');
    }

    /**
     * Get all grades.
     *
     * @return array
     */
    public function getAll()
    {
        $grades = $this->grades->where('user_id', Auth::user()->id)->get()->toArray();

        $g = array_map(function ($structure) use ($grades) {

            $action = '<button id="btn-edit-grades" type="button" class="btn btn-primary btn-circle btn-edit-grades" title="Edit" data-toggle="modal" data-target="#edit-grades"
                        onclick="editGrades(this)"
                        data-grades-id="' . $structure['id'] . '"
                        data-description="' . $structure['description'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';
            $action .= ' <button id="btn-delete-grades" type="button" class="btn btn-primary red btn-circle btn-delete-grades" title="Delete" data-toggle="modal" data-target="#delete-grades"
                        onclick="deleteGrades(this)"
                        data-grades-id="' . $structure['id'] . '"
                        data-description="' . $structure['description'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'grades' => $structure['description'],
                'action' => $action,
            ];
        }, $grades);

        return ['data' => $g];
    }

    /**
     * Store a new grade.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->merge(array('user_id' => Auth::user()->id));

        $validator = Validator::make(['description' => $request->description], ['description' => 'required|max:50|unique:grades']);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->grades->create($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully added.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.'], 200);
    }

    /**
     * Edit a new grade.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make(['description' => $request->description], ['description' => 'required|max:50|unique:grades,description,' . $id]);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->grades->find($id)->update($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully updated.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }

    /**
     * Delete a new grade.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->grades->find($id)->delete()) {
            return Response::json(['result' => true, 'message' => 'Successfully Deleted.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.'], 200);
    }
}
