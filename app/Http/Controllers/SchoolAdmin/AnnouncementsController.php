<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\AnnouncementsRequest;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;

class AnnouncementsController extends Controller
{
    /**
     * @var AnnouncementsInterface
     */
    private $announcements;

    public function __construct(AnnouncementsInterface $announcements)
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
        $announcements = $this->announcements->getAllByAttributes(['user_id' => Auth::user()->id], 'created_at', 'DESC');

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
            $created_at = date_format(date_create($structure['created_at']), "M d, Y h:i");

            $action = '<button id="btn-view-announcements" type="button" class="btn btn-primary blue btn-circle btn-view-announcements" title="View" data-toggle="modal" data-target="#view-announcements"
                        onclick="viewAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="' . $announce_to . '"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '"
                        data-created-at="' . $created_at . '">
                        <i class="material-icons">search</i>
                    </button> ';

            /*$action .= '<button id="btn-edit-announcements" type="button" class="btn btn-primary green btn-circle btn-edit-announcements" title="Edit" data-toggle="modal" data-target="#edit-announcements"
            onclick="editAnnouncements(this)"
            data-announcements-id="' . $structure['id'] . '"
            data-announce-to="' . $structure['announce_to'] . '"
            data-title="' . $structure['title'] . '"
            data-announcement="' . $structure['announcement'] . '">
            <i class="material-icons">edit</i>
            </button> ';*/

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
        return view('school_admin.announcements');
    }

    /**
     * Store an announcements.
     *
     * @return Response
     */
    public function store(AnnouncementsRequest $request)
    {
        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if ($this->announcements->create($request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Edit an announcements.
     *
     * @return Response
     */
    public function update($id, AnnouncementsRequest $request)
    {
        if ($this->announcements->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Delete an announcements.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->announcements->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }
}
