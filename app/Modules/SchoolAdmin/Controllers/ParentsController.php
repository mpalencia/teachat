<?php

namespace App\Modules\SchoolAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parent\Models\Children;
use App\Modules\Registration\Models\Users;
use Auth;
use Illuminate\Http\Request;
use Response;

class ParentsController extends Controller
{
    /**
     * @var User
     */
    private $parents;

    /**
     * @var Children
     */
    private $children;

    public function __construct(Users $parents, Children $children)
    {
        $this->parents = $parents;
        $this->children = $children;
    }

    /**
     * Display parents page.
     *
     * @return View
     */
    public function index()
    {
        //$data['parents'] = $this->parents->where(['role_id' => 3, 'school_id' => Auth::user()->school_id])->orderBy('first_name')->get();
        $data['parents'] = $this->parents->select('users.*', 'children.parent_id')->join('children', 'users.id', '=', 'children.parent_id')->where('children.approved', 0)->groupBy('children.parent_id')->get();

        return view('SchoolAdmin::parents', $data);
    }

    /**
     * Display a certeain parent page.
     *
     * @return View
     */
    public function show($id)
    {
        $data['children'] = $this->children->where(['parent_id' => $id, 'approved' => 0])->orderBy('first_name')->get();
        $data['parent_id'] = $id;

        return view('SchoolAdmin::students', $data);
    }

    /**
     * Get all parents waiting for approval.
     *
     * @return array
     */
    public function getAll()
    {
        $parents = $this->parents->where(['role_id' => 3, 'school_id' => Auth::user()->school_id])->get()->toArray();

        $t = array_map(function ($structure) use ($parents) {

            $parent_name = '<a href="#" style="color:#3174c7" onclick="viewParent(' . $structure['id'] . ')">' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '</a>';

            $action = '<button id="btn-edit-parents" type="button" class="btn btn-primary btn-circle btn-edit-parents" title="Approve" data-toggle="modal" data-target="#edit-parents"
                        onclick="approveParent(this)"
                        data-parents-id="' . $structure['id'] . '"
                        data-parents-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">check</i>
                    </button> ';
            $action .= '<button id="btn-delete-parents" type="button" class="btn btn-primary red btn-circle btn-delete-parents" title="Deny" data-toggle="modal" data-target="#delete-parents"
                        onclick="denyParent(this)"
                        data-parents-id="' . $structure['id'] . '"
                        data-parents-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'parents' => $parent_name,
                'action' => $action,
            ];
        }, $parents);

        return ['data' => $t];
    }

    /**
     * Get all children waiting for approval.
     *
     * @return array
     */
    public function getAllChildren($parent_id)
    {
        $children = $this->children->where(['parent_id' => $parent_id, 'approved' => 0])->orderBy('first_name')->get()->toArray();

        $s = array_map(function ($structure) use ($children) {

            $student_name = '<a href="#" style="color:#3174c7" onclick="viewStudent(' . $structure['id'] . ')">' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '</a>';

            $action = '<button id="btn-edit-students" type="button" class="btn btn-primary btn-circle btn-edit-students" title="Approve" data-toggle="modal" data-target="#edit-students"
                        onclick="approveStudent(this)"
                        data-students-id="' . $structure['id'] . '"
                        data-students-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">check</i>
                    </button> ';
            $action .= '<button id="btn-delete-students" type="button" class="btn btn-primary red btn-circle btn-delete-students" title="Deny" data-toggle="modal" data-target="#delete-students"
                        onclick="denyStudent(this)"
                        data-students-id="' . $structure['id'] . '"
                        data-students-name="' . $structure['first_name'] . ' ' . $structure['middle_name'] . ' ' . $structure['last_name'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'students' => $student_name,
                'action' => $action,
            ];
        }, $children);

        return ['data' => $s];
    }

    /**
     * Get all parents waiting for approval.
     *
     * @return array
     */
    public function get($id)
    {
        if ($parent = $this->parents->with('state')->find($id)) {
            return Response::json(['result' => true, 'data' => $parent], 200);
        }

        return Response::json(['result' => false, 'message' => 'Parent not found'], 200);

    }

    /**
     * Get all parent's children waiting for approval.
     *
     * @return array
     */
    public function getChild($id)
    {
        if ($children = $this->children->with('grade')->with('state')->where(['approved' => 0])->find($id)) {
            return Response::json(['result' => true, 'data' => $children], 200);
        }

        return Response::json(['result' => false, 'message' => 'Children not found'], 200);

    }

    /**
     * Edit a parent.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $decision = 'approved.';

        if ($request->approved == 2) {
            $decision = 'denied.';
        }

        if ($this->parents->find($id)->update(['approved' => $request->approved])) {
            return Response::json(['result' => true, 'message' => 'Parent has been ' . $decision], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }

    /**
     * Edit a children.
     *
     * @return Response
     */
    public function updateChild($id, Request $request)
    {
        $decision = 'approved.';

        if ($request->approved == 2) {
            $decision = 'denied.';
        }

        if ($this->children->find($id)->update(['approved' => $request->approved])) {
            $child = $this->children->find($id);
            return Response::json(['result' => true, 'message' => $child->first_name . ' ' . $child->middle_name . ' ' . $child->last_name . ' has been ' . $decision], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }
}
