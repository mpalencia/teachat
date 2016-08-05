<?php namespace App\Modules\Files\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Files\Models\Files;
use App\Modules\Registration\Models\Users;
use Auth;
use DB;

class FilesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Files::index");
    }

    public function getAllFileByStudentID($student_id)
    {
        $role_id = Auth::user()->role_id;
        if ($role_id == 3) {
            $files = Files::where('student_id', $student_id)->simplePaginate(5)->toArray();
            /*$files = DB::table('files')->select('files.*','users.*')
        ->join('users','files.teacher_id','=','users.id')
        ->where('files.student_id','=',$student_id)
        ->get();*/
        } else {
            $files = Files::where(['student_id' => $student_id, 'teacher_id' => Auth::user()->id])->simplePaginate(5)->toArray();
        }
        //$files['Uploaded'] = DB::table('users')->where('id','=',$files['data'][0]['teacher_id'])->get();
        //dd($files);
        if ($files['data'] !== []) {
            $files['code'] = '1';
            $files['message'] = 'Fetch successful';

            $count = 0;
            foreach ($files['data'] as $key => $data) {
                $files['data'][$count]['uploaded'] = Users::where('id', $data['teacher_id'])->get()->toArray();
                $count = $count + 1;
                //array_push($files['data']['uploaded'], $files['data']['uploaded'] );
            }

        } else {
            $files['code'] = '0';
        }
        //dd($files);
        return json_encode($files);
    }

    public function file_download($id)
    {
        $data = Files::where('id', $id)->firstOrFail();
        //dd($data);
        $file = \Storage::disk('s3')->get('attach/' . $data->file_name);
        //return response()->download(\Storage::disk('local')->get($data->file_name));
        return $this->responseDownloader($file, $data->orig_file . '.' . $data->ext, $data->mimetype); //\Response::download(storage_path());
    }

    public function responseDownloader($fileContent, $fileName, $mime)
    {
        $response = response($fileContent, 200, [
            'Content-Type' => $mime,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Content-Transfer-Encoding' => 'binary',
        ]);

        ob_end_clean(); // <- this is important, i have forgotten why.

        return $response;
    }

    public function file_upload($req)
    {
        $file = $req->file;
        $student_id = $req->student_id;
        $orig_file = $file->getClientOriginalName();
        $file_desc = $req->file_desc;

        $teacher_id = Auth::user()->id;

        $extension = $file->getClientOriginalExtension();
        $file_name = $file->getFilename() . '.' . $extension;
        if (\Storage::disk('s3')->put('attach/' . $file->getFilename() . '.' . $extension, \File::get($file), 'public')) {
            $file_name = $file->getFilename() . '.' . $extension;
            $mime = $file->getClientMimeType();
            $file_id = Files::create(array('file_desc' => $file_desc, 'mimetype' => $mime, 'orig_file' => $orig_file, 'teacher_id' => $teacher_id, 'student_id' => $student_id, 'file_name' => $file_name, 'ext' => $extension));

            return json_encode(array('message' => '<i class="material-icons">check</i> Upload Successfully.', 'code' => '1', 'file_id' => $file_id->id, 'file_name' => $file_id->orig_file, 'file_desc' => $file_desc));
        }
    }

    public function deleteFileById($id)
    {
        $data = Files::where('id', $id)->firstOrFail();
        $file = \Storage::disk('s3')->delete('attach/' . $data->file_name);
        if ($file) {
            Files::destroy($id);
            $res = json_encode(array('message' => '<i class="material-icons">check</i> File deleted successfully.', 'code' => '1', 'id' => $id));
        } else {
            $res = json_encode(array('message' => '<i class="material-icons">error</i> Deleting error. please try again.', 'code' => '0'));
        }
        return $res;
    }

    public function getFileById($id)
    {
        $res = Files::where('id', $id)->get()->toArray();
        return $res;
    }

    public function getAllNewAttachment($id)
    {
        $res = DB::table('children')
            ->join('files', 'children.id', '=', 'files.student_id')
            ->where('children.parent_id', '=', $id)
            ->where('files.status', '=', '0')
            ->count();
        if (count($res) < 2) {
            $res = '0' . $res;
        }
        return $res;
    }

    public function updateAllNewAttachment($id)
    {
        $res = DB::table('children')
            ->join('files', 'children.id', '=', 'files.student_id')
            ->where('children.parent_id', '=', $id)
            ->update(['files.status' => '1']);
        if (count($res) < 2) {
            $res = '0' . $res;
        }
        return $res;
    }

}
