<?php namespace App\Modules\School\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\School\Models\School;
use App\Modules\School\Models\State;
use App\Modules\Registration\Models\Users;
use Illuminate\Http\Request;
use DB;

class SchoolController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	public function getSchool($id = null){
			if($id !== null){
				$school = School::where('state_id',$id)->get()->toArray();
			}else{
				$school = School::get()->all();
			}

		return $school;
	}

	public function getState($id = null,$state_id = null){
			if(isset($state_id)){
				return State::where('id',$state_id)->get();
			}
			if($id !== null){
				$state = State::where('country',$id)->get();
			}else{
				$state = State::get()->toArray();
			}
			
		return $state;
	}

	public function getSchoolById($id){
		$school = School::where('id',$id)->get()->toArray();
		return $school;
	}

	public function created_newSchool($req){
		//dd($req->all());
		$file = $req->school_logo;
		$orig_file = $file->getClientOriginalName();
		$res = $this->badgeUploaded($file);

			if($res == 1){
				$state_id = School::create(['school_name'=>$req->school_name,'school_logo'=>$orig_file,'state_id'=>$req->state_id]);
				$res = json_encode(array('message'=>'New school added','code'=>'1'));
			}else{
				$res = json_encode(array('message'=>'Error please try again later.','code'=>'0'));
			}
		return $res;
	}

	public function badgeUploaded($file){
		$orig_file = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();
		//dd($orig_file);
		if(\Storage::disk('uploads')->put('images/school_badges/'.$orig_file,  \File::get($file))){
			$res = 1;
		}else{
			$res = 0;
		}

		return $res;
	}

	public function getCountry(){
		$res = State::all();
		return $res;
	}

	public function updateUploadState($req){
		$data = array('true'=>1,'false'=>0);
		//dd($data[$req->upload]);
		School::where('id',$req->id)->update(['upload'=>$data[$req->upload]]);
	}

	public function getUpdateState($id){
		return School::where('id',$id)->value('upload');
	}

	public function deleteSchoolById($id){
		$schoolUsers = Users::where('school_id',$id)->count();
		//dd($schoolUsers);
		if($schoolUsers == 0){
			$res = School::destroy($id);
			if($res){
				$res = json_encode(array('message'=>'School deleted.','code'=>'1'));
			}
		}else{
			$res = json_encode(array('message'=>'School cant be delete.','code'=>'0'));
		}

		return $res;
	}

	public function updateSchool($req){
		$data = $req->all();
		if(isset($req->school_logo)){
			$res = $this->badgeUploaded($req->school_logo);
			if($res == 1){
				$data['school_logo'] = $orig_file = $req->school_logo->getClientOriginalName();
			}
		}
		//dd($data);
		$res = School::where('id',$req->id)->update($data);
		if($res){
			$res = json_encode(array('message'=>'School updated.','code'=>'1'));
		}else{
			$res = json_encode(array('message'=>'Error please try again later.','code'=>'0'));
		}	
		return $res;
	}
	
	public function createNewState($req){
		//dd($req->all());
		$res = DB::table('state_us')->insert(
				    ['state_name' => $req->state_name, 'country' => $req->country]
				);//School::create($req->all());
		if($res){
			$res = json_encode(array('message'=>'New state created.','code'=>'1'));
		}else{
			$res = json_encode(array('message'=>'Error please try again later.','code'=>'0'));
		}	
		return $res;
	}

	public function updateState($req)
	{
		$res = json_encode(array('message'=>'Error please try again later.','code'=>'0'));

		if(State::where('id',$req->id)->update($req->all()))
		{
			$res = json_encode(array('message'=>'State Updated','code'=>'1'));
		}

		return $res;

	}
}
