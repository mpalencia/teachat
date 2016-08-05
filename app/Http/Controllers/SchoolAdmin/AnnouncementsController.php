<?php

namespace Teachat\Http\Controllers\SchoolAdmin;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\AnnouncementsRequest;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\UserInterface;

class AnnouncementsController extends Controller
{
    /**
     * @var AnnouncementsInterface
     */
    private $announcements;

    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(AnnouncementsInterface $announcements, UserInterface $user)
    {
        $this->announcements = $announcements;
        $this->user = $user;
    }

    /**
     * Get all annnoucements.
     *
     * @return array
     */
    public function getAll()
    {
        $announcements = $this->announcements->getAllByAttributesWithRelations(['user_id' => Auth::user()->id], ['user', 'school'], 'created_at', 'DESC');

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
            $created_at = date_format(date_create($structure['created_at']), "M d, Y");
            $publish_on = date_format(date_create($structure['publish_on']), "M d, Y");
            $expiration_date = date_format(date_create($structure['expiration_date']), "M d, Y");
            $epublish_on = date_format(date_create($structure['publish_on']), "d F, Y");
            $eexpiration_date = date_format(date_create($structure['expiration_date']), "d F, Y");

            $action = '<button id="btn-view-announcements" type="button" class="btn btn-primary blue btn-circle btn-flat btn-view-announcements white-text" title="View" data-toggle="modal" data-target="#view-announcements"
                        onclick="viewAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="' . $announce_to . '"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '"
                        data-created-at="' . $created_at . '"
                        data-school="' . $structure['school']['school_name'] . '"
                        data-publish="' . $publish_on . '"
                        data-exp="' . $expiration_date . '"
                        data-from="' . $structure['user']['first_name'] . ' ' . $structure['user']['last_name'] . '" >
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

            $action .= ' <button id="btn-edit-announcements" type="button" class="btn waves-effect white-text" title="Edit" data-toggle="modal" data-target="#edit-announcements"
                        onclick="editAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="' . $structure['announce_to'] . '"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '"
                        data-publish="' . $epublish_on . '"
                        data-exp="' . $eexpiration_date . '"
                        data-created-at="' . $created_at . '">
                        <i class="material-icons">edit</i>
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
     * Get an announcement by id
     *
     * @return Response
     */
    public function get($id)
    {
        if ($announcement = $this->announcements->getByIdWithRelations($id, ['user'])) {
            return response()->json(['result' => true, 'message' => $announcement]);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
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
        $publish_on = date_format(date_create($request->publish_on), 'Y-m-d');
        $exp_date = date_format(date_create($request->expiration_date), 'Y-m-d');

        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id, 'publish_on' => $publish_on, 'expiration_date' => $exp_date));

        if ($this->announcements->create($request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully added.']);
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
        $publish_on = date_format(date_create($request->publish_on), 'Y-m-d');
        $exp_date = date_format(date_create($request->expiration_date), 'Y-m-d');

        $request->merge(array('publish_on' => $publish_on, 'expiration_date' => $exp_date));

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
