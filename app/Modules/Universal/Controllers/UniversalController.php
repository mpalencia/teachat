<?php namespace App\Modules\Universal\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Registration\Models\Users;
use App\Modules\Universal\Models\History;
use Hash;
use DB;

class UniversalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	/*public function __function(){
		$this->middleware('auth');
	}*/
	

	public function index()
	{
		return view("Universal::index");
	}

	public function profile_image($id){
		$profile = Users::where('id',$id)->get()->toArray();
		return $profile;
	}

	public function getMessagesOpponent($user){
		if($user->role_id == 2){
			$list = Users::where(['role_id'=>3,'school_id'=>$user->school_id])->orderBy('last_name','active')->get()->toArray();
		}else{
			$list = Users::where(['role_id'=>2,'school_id'=>$user->school_id])->orderBy('last_name','active')->get()->toArray();
		}
		//dd($list);
		return $list;
	}

	public function getUser($id){
		$res = Users::where('id',$id)->get()->toArray();
		return $res;
	}

	public function UpdatePassword($req){
		$id = Auth::user()->id;
		$currentPassword = Users::where('id',$id)->value('password');
		if (Hash::check($req->current_pass, $currentPassword)) {
		    if($req->new_pass !== $req->confirm_pass){
				return json_encode(array('message'=>'<i class="material-icons">warning</i> Password not match. Min 8 character','code'=>'0'));
			}else if(strlen($req->new_pass) < 8 || strlen($req->confirm_pass) < 8){
				return json_encode(array('message'=>'<i class="material-icons">warning</i> Password is less than 8 characters','code'=>'0'));
			}else{
				$newPassword = Hash::make($req->new_pass);
				$res = Users::where('id',$id)->update(['password'=>$newPassword]);
					if($res){
						return json_encode(array('message'=>'<i class="material-icons">check</i> Password changed successfully','code'=>'1'));
					}else{
						return json_encode(array('message'=>'<i class="material-icons">error</i> Error encountered. Please try again.','code'=>'0'));
					}
			}
		}else{
			return json_encode(array('message'=>'<i class="material-icons">warning</i> Current password not match','code'=>'0'));
		}
		
	}

	public function uploadProfileImage_old($req){
		if($req->hasFile('profile_')){
				$extension = $req->file('profile_')->getClientOriginalExtension(); // getting image extension
      			$fileName = Auth::user()->first_name.'-'.rand(11111,99999).'.'.$extension;
      			$destination = public_path('/assets/images/profiles/');
      			$oldProfile_image = Users::where('id',Auth::user()->id)->value('profile_img');
      			if($req->file('profile_')->move($destination,$fileName) && Users::where('id',Auth::user()->id)->update(['profile_img'=>$fileName])){
					return json_encode(array('message'=>'Profile changed.','code'=>'1','data'=>asset('/assets/images/profiles/').'/'.$fileName));
				}else{
					return json_encode(array('message'=>'Error encountered while uploading... Please try again.','code'=>'0'));
				}
		}else{
			return json_encode(array('message'=>'Error encountered. Please try again.','code'=>'0'));
		}
	}

	public function uploadProfileImage($req){
		if($req->hasFile('profile_')){
			$file = $req->profile_;
			$extension = $file->getClientOriginalExtension();
			$file_name = $file->getFilename().'.'.$extension;
			if(\Storage::disk('s3')->put('images/'.$file->getFilename().'.'.$extension,  \File::get($file), 'public') && Users::where('id',Auth::user()->id)->update(['profile_img'=>$file_name])){
				return json_encode(array('message'=>'Profile changed.','code'=>'1','data'=>'https://s3-ap-southeast-1.amazonaws.com/teachatco/images/'.$file_name));
			}else{
				return json_encode(array('message'=>'Error encountered while uploading... Please try again.','code'=>'0'));
			}
		}else{
			return json_encode(array('message'=>'Error encountered. Please try again.','code'=>'0'));
		}
	}

	public function removeOldProfile($oldProfile_image){
		\Storage::disk('s3')->delete('images/'.$oldProfile_image);
		//\File::delete(public_path('/assets/images/profiles/'.$oldProfile_image));
	}

	public function createHistory($req){
		$user_id = Auth::user()->id;
		if (strpos($req->duration, ':') !== false) {
		    $timer = explode(':', $req->duration);
			$hr = $timer[0];
			$min = 15 - $timer[1];
				if(strlen($min) < 2){
					$min = '0'.$min;
				}
				$sec = 60 - $timer[2];
				if(strlen($sec) < 2){
					$sec = '0'.$sec;
				}
			$duration = $hr.':'.$min.':'.$sec;
		}else{
			$duration = $req->duration;
		}
		
		$opponent_id = Users::where('id',$req->oppenent)->value('id');
		History::create(['user_id'=>$user_id,'opponent_id'=>$opponent_id,'duration'=>$duration,'date'=>$req->date,'time'=>$req->time]);
	}

	public function getHistory(){
		$res = DB::table('history')->select('users.*','history.*')
				->join('users','history.opponent_id','=','users.id')
				->where('history.user_id','=',Auth::user()->id)
				->groupBy('history.created_at')
				->orderBy('history.id', 'desc')
				->get();
		//dd($res);
		return  $res;

	}
	
	

}
