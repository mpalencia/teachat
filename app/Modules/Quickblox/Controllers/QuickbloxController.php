<?php namespace App\Modules\Quickblox\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use App\Modules\Registration\Models\Users;
use App\Modules\Teacher\Controllers\TeacherController;
use App\Modules\Student\Controllers\StudentController;
use App\Modules\Parent\Controllers\ParentController;
use App\Modules\School\Controllers\SchoolController;
use App\Modules\Registration\Models\Pass_table;
use App\Modules\Parent\Models\Children;
use App\Modules\Files\Models\Files;
use DB;

class QuickbloxController extends Controller {

		private $teacher;
		private $parent;
		private $student;
		private $school;

		public function __construct(){
			$this->middleware('auth');
			$this->teacher = new TeacherController();
			$this->parent = new ParentController();
			$this->student = new StudentController();
			$this->school = new SchoolController();
			//$this->profile = $this->global->profile_image(Auth::user()->id);
		}


		public function qbRegister($userData=array()){
		
				 /*$userData = array(
					'user'=>array(
						'login'=>'criss',
						'password'=>'password',
						'email' => 'cris02ph@gmail.com'
					)
				);*/
				
				$output = array();
				if(!isset($userData['user']['email']) && empty($userData['user']['email'])){
					$output = array(
							'msg'=>'Email address is required.',
							'msgCode'=>0
					);
				}else if(empty($userData['user']['password'])){
					$output = array(
							'msg' => 'Username is required.',
							'msgCode'=>0
					);
				}else{
					
					$userData = json_encode($userData);
					$headers = array(
							"Content-Type: application/json",
							"QuickBlox-REST-API-Version: ".QB_API_VER,
							"QB-Token: ".$this->qbCreateSession(),
							"Accept: application/json"
					);
					
					$res = $this->submitCurl($userData, $headers, QB_ENDPOINT_URL.'/users.json');
					
					$output = json_decode($res, true);

				}
		
			return $output;
		}

		public function qbLogin($userData=array()){

			$data = array('email'=>$userData['user']['email'], 'password'=>$userData['user']['password']);
			//dd($data);
			$userToken = $this->qbCreateSession();
			$headers = array(
					//"Content-Type: application/json",
					"QuickBlox-REST-API-Version: ".QB_API_VER,
					"QB-Token: ".$userToken,
					"Accept: application/json"
			);
			
			$res = $this->submitCurl($data, $headers, QB_ENDPOINT_URL.'/login.json');
		
			$r = json_decode($res, true);
			$output = $r;
			if(isset($r['user'])){
				//success
				$output =array('success' => array(
					'qbUserId'=>$r['user']['id'],
					'qbEmailAdd'=> $r['user']['email'],
					'qbUserToken' => $userToken
					
				));
			}
			
			return $output;
			
		}

		public function qbCreateSession($userData=null){
		
				$nonce = rand();
				
				if(isset($userData)){
					$login = $userData['email'];
					$password = $userData['password'];
					
					$signature_string = "application_id=".QB_APPLICATION_ID."&auth_key=".QB_AUTH_KEY."&nonce=".$nonce."&timestamp=".TIMESTAMP."&user[email]=".$login. "&user[password]=".$password;
					
					$signature = hash_hmac( 'sha1', $signature_string , QB_AUTH_SECRET);
					$data = array(
							'application_id' => QB_APPLICATION_ID,
							'auth_key'=> QB_AUTH_KEY,
							'timestamp'=>TIMESTAMP,
							'nonce'=>$nonce,
							'signature'=>$signature,
							'user[email]' => $login,
							'user[password]' => $password
					);
					
				}else{
					
					$signature_string = "application_id=".QB_APPLICATION_ID."&auth_key=".QB_AUTH_KEY."&nonce=".$nonce."&timestamp=".TIMESTAMP;
					$signature = hash_hmac( 'sha1', $signature_string , QB_AUTH_SECRET);
					$data = array(
							'application_id' => QB_APPLICATION_ID,
							'auth_key'=> QB_AUTH_KEY,
							'timestamp'=>TIMESTAMP,
							'nonce'=>$nonce,
							'signature'=>$signature
					);
				}
				
				$headers = array(
						"QuickBlox-REST-API-Version: ".QB_API_VER,
						"Accept: application/json"
				);
				
				$res = $this->submitCurl($data, $headers, QB_ENDPOINT_URL.'/session.json');
				
				$r = json_decode($res, true);
				$output = 0;
				if(isset($r['session'])){
					//success
					$output = $r['session']['token'];
				}
				
				return $output;
		}

		public function submitCurl($data=null,$headers=array(), $url=null, $method='POST'){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		
			
			$result = curl_exec($ch);
			//dd($result);
			curl_close($ch);
			
			return $result;
			
		}

		//--------------none qb functions

		public function startVideoChat($type,$id,$duration,$session){
			$opponent = Users::where('id',$id)->get()->toArray();
			$currentUser = Users::where('id',Auth::user()->id)->get()->toArray();
			//dd($opponent);
			$this->data['opponent'] = $opponent;
			$this->data['currentUser'] = $currentUser;
			//$this->getqbLogin();
			$this->data['type'] = $type;
			$this->data['files'] = $this->getAllFilesOfStudentOFVideoChat($opponent[0]['id']);
			$this->data['upload'] = $this->school->getUpdateState(Auth::user()->school_id);
			$this->data['duration'] = $duration;
			$this->data['session'] = $session;
			//dd(floatval($duration));
			return view('Quickblox::videochat',$this->data);
		}

		public function getqbLogin(){
			$email= Auth::user()->email;
        	$password = Crypt::decrypt(Pass_table::where('id',Auth::user()->id)->value('password'));
        	$qbLogin = array('email'=>$email,'password'=>$password);
        	return $this->data['qbLogin'] = $qbLogin;
		}

		public function getAllFilesOfStudentOFVideoChat($opponent_id){
				$type = Users::where('id',Auth::user()->id)->value('role_id');
				if($type == 3){
					$students = collect($this->student->getStudentByParent(Auth::user()->id))->unique('child_id');
					$students = $students->where('teacher_id',$opponent_id);

					$res = [];
					$label = [];
					foreach ($students as $key => $student) {
						$label['children'] = Children::where('id',$student['child_id'])->get()->toArray();
						$label['files'] = Files::where(['teacher_id'=>$opponent_id,'student_id'=>$student['child_id']])->get()->toArray();
						array_push($res,$label);
					}
				}else{
					$students = collect($this->student->getStudentByParent($opponent_id))->unique('child_id');
					$students = $students->where('teacher_id',Auth::user()->id);

					$res = [];
					$label = [];
					foreach ($students as $key => $student) {
						$label['children'] = Children::where('id',$student['child_id'])->get()->toArray();
						$label['files'] = Files::where(['teacher_id'=>Auth::user()->id,'student_id'=>$student['child_id']])->get()->toArray();
						array_push($res,$label);
					}
				}
			return $res;
		}

}
