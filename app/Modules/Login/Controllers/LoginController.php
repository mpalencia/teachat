<?php namespace App\Modules\Login\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Quickblox\Controllers\QuickbloxController;
use App\Modules\Registration\Models\Users;
use App\Modules\School\Models\School;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    //private $qb;

    /*public function __construct()
    {
        $this->qb = new QuickbloxController();
    }*/

    public function index()
    {
        return view("Login::index");
    }

    public function accountVerifier($email, $code)
    {
        $action = Users::where(['email' => $email, 'verification_code' => $code, 'status' => 1])->get();
        if (!$action->isEmpty()) {
            $data = array('id' => $action[0]->id, 'status' => 0);
            $this->updateUsers($data);
            return view('Frontend::activated');
            //return $this->idToSchoolName($action[0]->school_id);
        } else {
            return redirect('notFound');
        }
    }

    public function displayError()
    {
        return view('errors.503');
    }

    public function idToSchoolName($id)
    {
        $school_name = School::where('id', $id)->get();
        $new_url = str_replace(" ", "-", $school_name[0]->school_name);
        $route = 'login/' . $new_url;
        return redirect($route)->with('school_id', $id);
        //dd($school_name[0]->school_name);
    }

    public function updateUsers($data = array())
    {
        Users::where('id', $data['id'])->update($data);
    }

    public function processLogin(Request $req)
    {
        //dd($req->all());
        if (strlen($req->password) < 8) {
            return json_encode(array('message' => 'Password should be minimum of 8 character', 'code' => '0'));
            //break;
        } else {
            $active = Users::where(['email' => $req->email, 'school_id' => $req->school_id])->get();
            if ($active->isEmpty()) {
                return json_encode(array('message' => 'Email or password is incorrect', 'code' => '0'));
                //break;
            } else {
                $active = $active->toArray();
                //dd($active);
                if ($active[0]['status'] == 1) {
                    return json_encode(array('message' => 'Please confirm your email to continue', 'code' => '0'));
                    //break;
                } else {
                    /*$user_data = array('user' => array('email' => $req->email, 'password' => $req->password)); //qb login
                    $qb_result = $this->qb->qbLogin($user_data);*/
                    if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
                        //dd(Auth::check());
                        return json_encode(array('message' => 'Login successful.', 'code' => '1'));
                    } else {
                        return json_encode(array('message' => 'Email or password is incorrent. Please try again.', 'code' => '0'));
                    }
                }
            }
        }
    }

    public function logout()
    {
        if (Auth::logout()) {
            return redirect('/');
        }
    }

}
