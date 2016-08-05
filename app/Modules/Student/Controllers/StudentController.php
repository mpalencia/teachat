<?php namespace App\Modules\Student\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Student\Models\Student;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Modules\Subject\Controllers\SubjectController;
use App\Modules\Subject\Models\Subject;

class StudentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $subject;

	public function __construct(){
		//$this->subject = new SubjectController();
	}

	public function index()
	{
		return view("Student::index");
	}

	public function getMyChildsTeacher($id){
		$students = DB::table('students')->select('users.*','students.id as STUDENT_ID','students.*')
					->join('users','students.teacher_id','=','users.id')
					->where('students.child_id','=',$id)
					->get();
				
				//dd($students);
		return $students;
	}

	public function getTeacherStudents($id){
		$students = DB::table('students')->select('users.*','students.id as STUDENT_ID','students.*','children.*')//'subjects.*',
					->join('users','students.parent_id','=','users.id')
					->join('children','students.child_id','=','children.id')
					//->join('subjects','students.subject_id','=','subjects.id')
					->where('students.teacher_id','=',$id)
					->get();
					//dd($students);
		return $students;
	}

	public function deleteStudent($id){
		$student = Student::where('subject_id',$id)->delete();
		return $student;
	}

	//---remove child from students
	public function removeChildFrmStudents($id){
		$res = Student::where('id',$id)->delete();
		if($res){
				return json_encode(array('message'=>'<i class="material-icons">check</i> Your child is now removed under the selected teacher.','code'=>'1'));
			}else{
				return json_encode(array('message'=>'Error encountered. Please refresh or hit F5 and try again.','code'=>'0'));
			}
	}

	public function AddnewStudent($data){
		try
		{
			//dd($data);
			$checK_duplicate = Student::where($data)->firstOrFail();
			if($checK_duplicate){
				return json_encode(array('message'=>'<i class="material-icons">error_outline</i> Error! Duplicate entry found!','code'=>'0'));
			}

		}catch(ModelNotFoundException $e){

			$res = Student::create($data);
			if($res){
				return json_encode(array('message'=>'<i class="material-icons">check</i> Your child is now belong to a '.$data['child_section'].' ','code'=>'1'));
			}else{
				return json_encode(array('message'=>'Error encountered. Please refresh or hit F5 and try again.','code'=>'0'));
			}
		}		
	}

	public function getStudentByParent($parent_id){
		$student = Student::where('parent_id',$parent_id)->get()->toArray();
		return $student;
	}

	public function getSubjectById($id){
		$subject = Subject::where('id',$id)->get();
		return $subject;
	}


}
