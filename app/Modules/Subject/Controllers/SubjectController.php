<?php namespace App\Modules\Subject\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Subject\Models\Subject;
use Auth;
use Illuminate\Http\Request;
use App\Modules\Student\Controllers\StudentController;

class SubjectController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $student;

	public function __construct(){
		$this->middleware('auth');
		$this->student = new StudentController();
	}

	public function index()
	{
		return view("Subject::index");
	}

	public function getTeacherSubjects($id){
		$subjects = Subject::where('user_id',$id)->get()->all();
		return $subjects;
	}

	public function addSubject($req){
		$checkDuplicate = Subject::where(['user_id'=>Auth::user()->id,'subject_name'=>$req->subject])->get();
		if($checkDuplicate->isEmpty()){
			$res = Subject::create(['user_id'=>Auth::user()->id,'subject_name'=>$req->subject]);
				if($res){
					return json_encode(array('message'=>'<i class="material-icons">check</i> Subject added successful.','code'=>'1','data'=>array('data_name'=>$res->subject_name,'id'=>$res->id)));
				}else{
					return json_encode(array('message'=>'<i class="material-icons">error</i> Error encountered. Please try again.','code'=>'0'));
				}
		}else{
			return json_encode(array('message'=>'Subject already exist','code'=>'0'));
		}
	}

	public function deleteSubject($id){
		$res = Subject::destroy($id);
		if($res){
			$student = $this->student->deleteStudent($id);
				if($student == 1){
					return json_encode(array('message'=>'<i class="material-icons">check</i> Subject and student remove.','code'=>'1','data'=>array('id'=>$id)));
				}
			return json_encode(array('message'=>'<i class="material-icons">check</i> Subject deleted successful.','code'=>'1','data'=>array('id'=>$id)));
		}else{
			return json_encode(array('message'=>'<i class="material-icons">error</i> Error encountered. Please try again.','code'=>'0'));
		}
	}

	public function getSubjectOfTeacher($id,$subject_id = null){
		if(isset($subject_id)){
			$subjects = Subject::where(['user_id'=>$id,'id'=>$subject_id])->get()->toArray();
			return $subjects;
		}

		$subjects = Subject::where('user_id',$id)->get()->toArray();
		return $subjects;
	}

	public function getSubjectById($id){
		$subject = Subject::where('id',$id)->get();
		return $subject;
	}

}
