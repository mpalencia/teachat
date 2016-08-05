<?php namespace App\Modules\Announcement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Announcement\Models\Announcement;
use Auth;
use DB;

class AnnouncementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->announce_to = array('All' => 0, 'Teachers' => 2, 'Parents' => 3);
    }

    public function index()
    {
        return view("Announcement::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($req)
    {
        $data = $req->all();
        $data['school_id'] = Auth::user()->school_id;
        $data['user_id'] = Auth::user()->id;
        $data['announce_to'] = $this->announce_to[$req->announce_to];
        //dd($data);
        $res = Announcement::create($data);
        if ($res) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Announcement successfully posted.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Something went wrong please try again', 'code' => '0'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id = null, $announce_id = null, $school_id = null)
    {

        if (isset($announce_id)) {
            //dd('asdasd');
            //return Announcement::where(['id'=>$announce_id])->get()->all();
            return DB::table('announcement')->select('announcement.*', 'users.*')
                ->join('users', 'announcement.user_id', '=', 'users.id')
                ->where('announcement.id', '=', $announce_id)
                ->get();
        }
        if (isset($id)) {

            return Announcement::where('school_id', $id)->orderBy('created_at', 'desc')->get();
        }
        if (isset($school_id)) {
            //dd($school_id);
            return Announcement::where('school_id', $school_id)
            //->where(DB::raw('Date(created_at)'), '>=', Carbon::now()->toDateString())
                ->whereIn('announce_to', [0, Auth::user()->role_id])
                ->orderBy('created_at', 'desc')
            //->where(DB::raw('announce_to'),'=',Auth::user()->role_id)
            //->orWhere(DB::raw('announce_to'),'=',0)
                ->get();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($req)
    {
        $res = Announcement::where('id', $req->id)->update($req->all());
        if ($res) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Announcement successfully posted.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Something went wrong please try again', 'code' => '0'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $res = Announcement::destroy($id);
        if ($res) {
            return json_encode(array('message' => '<i class="material-icons">check</i> Deleted successfully.', 'code' => '1'));
        } else {
            return json_encode(array('message' => '<i class="material-icons">error</i> Something went wrong please try again', 'code' => '0'));
        }
    }

}
