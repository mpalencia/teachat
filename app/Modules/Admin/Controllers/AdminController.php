<?php namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Modules\Announcement\Controllers\AnnouncementController;
use Illuminate\Http\Request;
use App\Modules\School\Controllers\SchoolController;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $announcement;
	private $school;

	public function __construct(){
		//$this->Check();
		$this->middleware('auth');

		$this->announcement = new AnnouncementController();
		$this->school = new SchoolController();
		$this->data['admin'] = Auth::user();
	}

	public function index()
	{
		$this->data['school'] = $this->school->getSchoolById(Auth::user()->school_id);
		$this->data['announcement'] = $this->announcement->show(Auth::user()->school_id,null,null);
		//dd($this->data);
		return view("Admin::dashboard",$this->data);
	}

	public function settings(){
		return view('Admin::settings');
	}

	public function announcement(){
		$this->data['announce'] = $this->announcement->show(Auth::user()->school_id,null,null);
		//dd($this->data);
		return view('Admin::announcements',$this->data);
	}

	public function addAnnouncement(){
		return view('Admin::add-announcements');
	}

	public function editAnnouncement($id){
		$this->data['announce'] = $this->announcement->show(Auth::user()->id,$id);
		//dd($this->data);
		return view('Admin::edit-announcements',$this->data);
	}

	

	

}
