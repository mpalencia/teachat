<?php

namespace App\Modules\SchoolAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolAdmin\Models\Announcements;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class AnnouncementsController extends Controller
{
    /**
     * @var Grades
     */
    private $Announcements;

    public function __construct(Announcements $announcements)
    {
        $this->announcements = $announcements;
    }

    /**
     * Get all annnoucements.
     *
     * @return array
     */
    public function getAll()
    {
        $announcements = $this->announcements->where('user_id', Auth::user()->id)->get()->toArray();

        $c = array_map(function ($structure) use ($announcements) {

            switch ($structure['announce_to']) {
                case '1':
                    $announce_to = 'All';
                    break;
                case '2':
                    $announce_to = 'Teachers';
                    break;
                default:
                    $announce_to = 'Parents';
                    break;
            }
            $created_at = date_format(date_create($structure['created_at']), "M d, Y h:i A");

            $action = '<button id="btn-view-announcements" type="button" class="btn btn-primary blue btn-circle btn-view-announcements" title="View" data-toggle="modal" data-target="#view-announcements"
                        onclick="viewAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="' . $announce_to . '"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '"
                        data-created-at="' . $created_at . '">
                        <i class="material-icons">search</i>
                    </button> ';

            $action .= '<button id="btn-edit-announcements" type="button" class="btn btn-primary green btn-circle btn-edit-announcements" title="Edit" data-toggle="modal" data-target="#edit-announcements"
                        onclick="editAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="' . $structure['announce_to'] . '"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';

            $action .= '<button id="btn-delete-announcements" type="button" class="btn btn-danger red btn-circle red btn-delete-announcements" title="Delete" data-toggle="modal" data-target="#delete-announcements"
                        onclick="deleteAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'title' => $structure['title'],
                'announce_to' => $announce_to,
                'created_at' => $created_at,
                'action' => $action,
            ];
        }, $announcements);

        return ['data' => $c];
    }

    /**
     * Display annoucements page.
     *
     * @return View
     */
    public function index()
    {
        return view('SchoolAdmin::announcements');
    }

    /**
     * Store a new announcements.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->merge(array('user_id' => Auth::user()->id));
        $request->merge(array('school_id' => Auth::user()->school_id));

        $rules = [
            'title' => 'required|max:50',
            'announcement' => 'required',
            'announce_to' => 'required',
        ];

        $validator = Validator::make([
            'title' => $request->title,
            'announcement' => $request->announcement,
            'announce_to' => $request->announce_to,
        ], $rules);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->announcements->create($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully added.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.'], 200);
    }

    /**
     * Edit a new announcements.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $rules = [
            'title' => 'required|max:50',
            'announcement' => 'required',
            'announce_to' => 'required',
        ];

        $validator = Validator::make([
            'title' => $request->title,
            'announcement' => $request->announcement,
            'announce_to' => $request->announce_to,
        ], $rules);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->announcements->find($id)->update($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully updated.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }

    /**
     * Delete a new announcements.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->announcements->find($id)->delete()) {
            return Response::json(['result' => true, 'message' => 'Successfully Deleted.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.'], 200);
    }
}
