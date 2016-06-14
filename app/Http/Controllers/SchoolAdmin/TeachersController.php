<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\UserInterface;

class TeachersController extends Controller
{
    private $teachers;

    public function __construct(UserInterface $teachers)
    {
        $this->teachers = $teachers;
    }

    /**
     * Display parents page.
     *
     * @return View
     */
    public function index()
    {
        return view('school_admin.teachers');
    }

    /**
     * Get all teachers waiting for approval.
     *
     * @return array
     */
    public function getAll()
    {
        $teachers = $this->teachers->getAllByAttributes(['role_id' => 2, 'school_id' => Auth::user()->school_id, 'approved' => 0], 'last_name');

        $t = array_map(function ($structure) use ($teachers) {

            $teacher_name = '<a href="#" style="color:#3174c7" onclick="viewTeacher(' . $structure['id'] . ')">' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '</a>';

            $action = '<button id="btn-edit-teachers" type="button" class="btn btn-primary btn-circle btn-edit-teachers" title="Approve" data-toggle="modal" data-target="#edit-teachers"
                        onclick="approveTeacher(this)"
                        data-teachers-id="' . $structure['id'] . '"
                        data-teachers-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">check</i>
                    </button> ';
            $action .= '<button id="btn-delete-teachers" type="button" class="btn btn-primary red btn-circle btn-delete-teachers" title="Denied" data-toggle="modal" data-target="#delete-teachers"
                        onclick="denyTeacher(this)"
                        data-teachers-id="' . $structure['id'] . '"
                        data-teachers-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'teachers' => $teacher_name,
                'action' => $action,
            ];
        }, $teachers);

        return ['data' => $t];
    }

    /**
     * Get all parents waiting for approval.
     *
     * @return array
     */
    public function get($id)
    {
        if ($teacher = $this->teachers->getByIdWithRelations($id, ['state'])) {
            return response()->json(['result' => true, 'data' => $teacher], 200);
        }

        return response()->json(['result' => false, 'message' => 'Teacher not found'], 200);

    }

    /**
     * Edit a teachers.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $decision = 'approved.';

        if ($request->approved == 2) {
            $decision = 'denied.';
        }

        if ($this->teachers->update($id, ['approved' => $request->approved])) {
            return response()->json(['result' => true, 'message' => 'Teacher has been ' . $decision], 200);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }
}
