<?php

namespace Teachat\Http\Controllers\Teacher;

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
        $new_carbon = date("Y-m-d");
        $announcements =  $this->announcements
                            ->gets()
                            ->select('announcement.*', 'users.first_name', 'users.last_name', 'school.school_name')
                            ->join('users', 'announcement.user_id', '=', 'users.id')
                            ->join('school', 'announcement.school_id', '=', 'school.id')
                            ->where('announcement.publish_on', '<=', $new_carbon)
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->toArray();

        $sc = array_map(function ($structure) use ($announcements) {

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
            $publish_on = date_format(date_create($structure['publish_on']), "M d, Y");
            $expiration_date = date_format(date_create($structure['expiration_date']), "M d, Y");

            $action = '<button id="btn-view-announcements" type="button" class="btn btn-primary blue btn-circle btn-flat btn-view-announcements" title="View" data-toggle="modal" data-target="#view-announcements"
                        onclick="viewAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="' . $announce_to . '"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '"
                        data-from="' . $structure['first_name'] . ' ' . $structure['last_name'] . '"
                        data-school="' . $structure['school_name'] . '"
                        data-publish="' . $publish_on . '"
                        data-exp="' . $expiration_date . '"
                        data-created-at="' . $created_at . '">
                        <i class="material-icons">search</i>
                    </button> ';

            $action .= '';

            return [
                'title' => $structure['title'],
                'created_at' => $created_at,
                'action' => $action,
            ];
        }, $announcements);

        return ['data' => $sc];
    }

    /**
     * Get an announcement by id
     *
     * @return Response
     */
    public function get($id)
    {
        if ($announcement = $this->announcements->getByIdWithRelations($id, ['user'])) {
            $this->announcements->update($id, ['seen' => 1]);
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
        return view('teacher.announcements');
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

        $request->merge(array('user_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id, 'announce_to' => 3, 'publish_on' => $publish_on, 'expiration_date' => $exp_date));

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
