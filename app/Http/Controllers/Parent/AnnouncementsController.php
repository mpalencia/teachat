<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\AnnouncementsInterface;
use Teachat\Repositories\Interfaces\ChildrenInterface;

class AnnouncementsController extends Controller
{
    /**
     * @var AnnouncementsInterface
     */
    private $announcements;

    /**
     * @var ChildrenInterface
     */
    private $children;

    public function __construct(AnnouncementsInterface $announcements, ChildrenInterface $children)
    {
        $this->announcements = $announcements;
        $this->children = $children;
    }

    /**
     * Get all annnoucements.
     *
     * @return array
     */
    public function getAll()
    {   
        $new_carbon = date("Y-m-d");
        //$announcements = $this->announcements->getAllByAttributes(['school_id' => Auth::user()->school_id, 'announce_to' => 1, 'announce_to' => 3], 'created_at', 'DESC');
        $children = $this->children->getAllByAttributes(['parent_id' => Auth::user()->id], 'first_name');
        $school_ids = array();

        if ($children) {
            foreach ($children as $key => $value) {
                $school_ids[] = $value['school_id'];
            }
        }

        // $announcements = $this->announcements->getByAttributesWithCondition()->select('users.*')->whereIn('school_id', $school_ids)->where('announce_to', 1)->orWhere('announce_to', 3)->get()->toArray();
        $announcements = $this->announcements
            ->gets()
            ->select('announcement.*', 'users.first_name', 'users.last_name', 'school.school_name')
            ->join('users', 'announcement.user_id', '=', 'users.id')
            ->join('school', 'announcement.school_id', '=', 'school.id')
            ->where(['announcement.school_id' => $school_ids])
            ->where('announcement.publish_on', '<=', $new_carbon)
            ->whereIn('announcement.announce_to', [1, 3])
            // ->orWhere('announcement.announce_to', '=', 3)
            ->orderBy('announcement.created_at', 'DESC')
            ->get()->toArray();

        $c = array_map(function ($structure) use ($announcements) {

            $created_at = date_format(date_create($structure['created_at']), "M d, Y h:i");
            $publish_on = date_format(date_create($structure['publish_on']), "M d, Y");
            $expiration_date = date_format(date_create($structure['expiration_date']), "M d, Y");

            $action = '<button id="btn-view-announcements" type="button" class="btn btn-primary blue btn-circle btn-flat btn-view-announcements" title="View" data-toggle="modal" data-target="#view-announcements"
                        onclick="viewAnnouncements(this)"
                        data-announcements-id="' . $structure['id'] . '"
                        data-announce-to="Parents"
                        data-title="' . $structure['title'] . '"
                        data-announcement="' . $structure['announcement'] . '"
                        data-from="' . $structure['first_name'] . ' ' . $structure['last_name'] . '"
                        data-school="' . $structure['school_name'] . '"
                        data-publish="' . $publish_on . '"
                        data-exp="' . $expiration_date . '"
                        data-created-at="' . $created_at . '">
                        <i class="material-icons">search</i>
                    </button> ';

            return [
                'title' => $structure['title'],
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
        if ($announcement = $this->announcements->getByIdWithRelations($id, ['user', 'school'])) {
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
        return view('parent.announcements');
    }
}
