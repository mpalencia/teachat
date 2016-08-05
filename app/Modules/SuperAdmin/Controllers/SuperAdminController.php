<?php namespace App\Modules\SuperAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Registration\Controllers\RegistrationController;
use App\Modules\Registration\Models\Users;
use App\Modules\School\Controllers\SchoolController;
use Auth;
use DB;

class SuperAdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $school;
    private $registration;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->school = new SchoolController();
        $this->registration = new RegistrationController();
        //$this->index();
    }

    public function index()
    {

        if (Auth::user()->role_id === 4) {
            $school = collect($this->school->getSchool());
            $this->data['school_latest'] = $school->sortByDesc('id')->take(4);
            $school_list = [];
            foreach ($this->data['school_latest'] as $item) {
                $item['state'] = $this->school->getState(null, $item->state_id)->toArray();
                array_push($school_list, $item);
            }
            $this->data['school_latest'] = $school_list;
            return view('SuperAdmin::index', $this->data);
        } else {

            return redirect('/');
        }

    }

    public function settings()
    {
        if (Auth::check() === true) {
            return view('SuperAdmin::settings');
        } else {
            return redirect('/');
        }

    }

    public function principal()
    {

        if (Auth::check() === true) {
            $this->data['principals'] = $this->getAllPrincipal();
            foreach ($this->data['principals'] as $key => $prin) {
                $prin['school'] = $this->school->getSchoolById($prin->school_id);
            }
            //dd($this->data);
            return view('SuperAdmin::principal', $this->data);
        } else {
            return redirect('/');
        }

    }

    public function addPrincipal()
    {

        if (Auth::check() === true) {
            $this->data['country'] = Collect($this->school->getCountry())->unique('country');
            $this->data['region'] = Collect($this->school->getCountry());
            $this->data['school'] = $this->school->getSchool();
            //dd($this->data['school']->toArray());
            return view('SuperAdmin::principal-add', $this->data);
        } else {
            return redirect('/');
        }
    }

    public function editPrincipal($id)
    {

        if (Auth::check() === true) {
            $this->data['principal'] = $this->getAllPrincipal($id);
            $this->data['school'] = $this->school->getSchool();
            //dd($this->data);
            return view('SuperAdmin::principal-edit', $this->data);
        } else {
            return redirect('/');
        }
    }

    public function ViewSchool()
    {
        if (Auth::check() === true) {
            $this->data['school'] = $this->school->getSchool();
            foreach ($this->data['school'] as $school) {
                $school->state_id = $this->school->getState(null, $school->state_id);
            }
            //dd($this->data);
            return view('SuperAdmin::school', $this->data);
        } else {
            return redirect('/');
        }

    }

    public function AddSchool()
    {
        if (Auth::check() === true) {
            $this->data['state'] = $this->school->getState();
            //dd($this->data);
            return view('SuperAdmin::school-add', $this->data);
        } else {
            return redirect('/');
        }

    }

    public function SU_editUser($id)
    {
        $this->data['user'] = $this->getAllPrincipal($id);
        $this->data['school'] = $this->school->getSchool();
        //dd($this->data);
        return view('SuperAdmin::users-edit', $this->data);
    }

    public function viewAddteacher()
    {
        $this->data['school'] = $this->school->getSchool();
        return view('SuperAdmin::teachers-add', $this->data);
    }

    public function su_viewLocation()
    {
        $this->data['country'] = Collect($this->school->getCountry())->unique('country');
        $this->data['list'] = $this->school->getCountry();
        //dd($this->data);
        return view('SuperAdmin::location', $this->data);
    }

    public function SU_viewTeachers()
    {
        $this->data['users'] = $this->getAllUsersByType(2);
        return view('SuperAdmin::teachers', $this->data);
    }

    public function SU_viewUsers()
    {
        $this->data['users'] = $this->getAllUsersByType(3);
        $this->data['totalUser'] = count($this->data['users']);
        //dd($this->data);
        return view('SuperAdmin::users', $this->data);
    }

    public function editSchool($id)
    {
        $this->data['state'] = $this->school->getState();
        $this->data['school'] = $this->school->getSchoolById($id);
        //$this->data['country'] = Collect($this->school->getCountry())->unique('country');
        $this->data['schoollist'] = $this->school->getSchool();
        //dd($this->data);
        return view('SuperAdmin::school-edit', $this->data);
    }

    public function deleteTeacher($req)
    {
        $this->deletePrincipal($req->id);
        return json_encode(array('message' => 'Teacher updated successfully', 'code' => '1'));
    }

    public function editTeacher($id)
    {
        $this->data['user'] = $this->getAllPrincipal($id);
        return view('SuperAdmin::teachers-edit', $this->data);
    }

    public function SU_updateTeacher($req)
    {
        $res = Users::where('id', $req->id)->update($req->all());
        if ($req) {
            return json_encode(array('message' => 'Updated successfully', 'code' => '1'));
        } else {
            return json_encode(array('message' => $reg->message, 'code' => '0'));
        }
    }

    public function add_newPrincipal($req)
    {
        $req['type'] = 'admin';
        $req['name_prefix'] = ' ';
        $req['last_name'] = ' ';
        $reg = json_decode($this->registration->registration($req));
        //dd($reg);
        if ($reg->code == 1) {
            return json_encode(array('message' => 'new Principal added successfully', 'code' => '1'));
        } else {
            return json_encode(array('message' => $reg->message, 'code' => '0'));
        }
    }

    public function deletePrincipal($id)
    {
        //dd($id);
        $res = Users::destroy($id);
        if ($res) {
            return $this->principal();
        }
    }

    public function getAllPrincipal($id = null)
    {
        if (isset($id)) {
            return Users::where(['id' => $id])->get()->toArray();
        } else {
            return Users::where('role_id', 1)->get()->all();
        }

    }

    public function SU_updatePrincipal($req)
    {
        $res = Users::where('id', $req->id)->update($req->all());
        if ($res) {
            return json_encode(array('message' => 'Principal updated successfully', 'code' => '1'));
        } else {
            return json_encode(array('message' => 'Error encounter please try again.', 'code' => '0'));
        }
    }

    public function SU_suspendUser($req)
    {
        $data = array('true' => 1, 'false' => 0);
        //dd($req->all());
        $res = Users::where('id', $req->id)->update(['suspend' => $data[$req->suspend]]);
        if ($res) {
            return json_encode(array('message' => 'User is suspended.', 'code' => '1'));
        } else {
            return json_encode(array('message' => 'Error encounter please try again.', 'code' => '0'));
        }
    }

    public function SU_statusUser($req)
    {
        $data = array('true' => 0, 'false' => 1);
        //dd($req->all());
        $res = Users::where('id', $req->id)->update(['status' => $data[$req->status]]);
        if ($res) {
            return json_encode(array('message' => 'User is suspended.', 'code' => '1'));
        } else {
            return json_encode(array('message' => 'Error encounter please try again.', 'code' => '0'));
        }
    }

    public function getAllUsersByType($role_id)
    {
        $res = DB::table('users')->select('users.id as UserId', 'school.*', 'users.*')
            ->join('school', 'users.school_id', '=', 'school.id')
            ->where('users.role_id', $role_id)
            ->get();
        //dd($res);
        return $res;
    }

}
