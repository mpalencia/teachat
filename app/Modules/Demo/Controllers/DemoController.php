<?php namespace App\Modules\Demo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Registration\Models\Users;
use Auth;

class DemoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 3) {
            return $this->parentView();
        } else {
            return $this->teacherView();
        }

    }

    public function parentView()
    {
        $id = Auth::user()->id;
        $user = Users::find($id);

        $this->data['user'] = $user;

        return view('Demo::parent', $this->data);
    }

    public function teacherView()
    {
        $id = Auth::user()->id;
        $user = Users::find($id);

        $this->data['user'] = $user;
        return view('Demo::teacher', $this->data);
    }

    public function videoView($call, $id)
    {
        $this->data['type'] = $call;
        if ($id == 'paolo') {
            $id = 'richie';
            $opp = 'paolo';
        } else {
            $id = 'paolo';
            $opp = 'richie';
        }

        $this->data['user'] = $id;
        $this->data['opp'] = $opp;

        return view('Demo::video', $this->data);
    }
}
