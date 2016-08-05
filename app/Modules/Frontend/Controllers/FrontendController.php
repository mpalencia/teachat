<?php namespace App\Modules\Frontend\Controllers;

use App\Http\Requests;
use Auth;
use Hash;
use App\Http\Controllers\Controller;
use App\Modules\School\Models\School;

use Illuminate\Http\Request;

class FrontendController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct(){
		//$this->middleware('guest');
	}

	public function index()
	{
		return view("Frontend::index");
	}

	public function viewLogin(){
		//$school_name = str_replace("-", " ", $school_name);
		//$school = School::where('school_name',$school_name)->get();
		return $this->Login();
	}

	public function Login(){
		//$this->data['school'] = $data->toArray();
		return view('Frontend::loginv2');
	}

}
