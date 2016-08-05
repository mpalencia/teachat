<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\GradesRequest;
use Teachat\Repositories\Interfaces\GradesInterface;

class GradesController extends Controller
{
    /**
     * @var GradesInterface
     */
    private $grades;

    /**
     * Grades controller instance.
     *
     * @param GradesInterface $grades
     * @return void
     */
    public function __construct(GradesInterface $grades)
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
        return view('school_admin.grades');
    }

    /**
     * Get all grades.
     *
     * @return array
     */
    public function getAll()
    {
        $grades = $this->grades->getAll();

        $g = array_map(function ($structure) use ($grades) {

            $action = '<button id="btn-edit-grades" type="button" class="btn btn-primary btn-circle btn-flat btn-edit-grades" title="Edit" data-toggle="modal" data-target="#edit-grades"
                        onclick="editGrades(this)"
                        data-grades-id="' . $structure['id'] . '"
                        data-description="' . $structure['description'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';
            $action .= ' <button id="btn-delete-grades" type="button" class="btn btn-primary red btn-circle btn-flat btn-delete-grades" title="Delete" data-toggle="modal" data-target="#delete-grades"
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
    public function store(GradesRequest $request)
    {
        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if ($this->grades->create($request->all())) {

            return response()->json(['success' => true, 'message' => 'Successfully added.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Edit a grades.
     *
     * @return Response
     */
    public function edit($id, GradesRequest $request)
    {
        if ($this->grades->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Delete a grades.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->grades->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }
}
