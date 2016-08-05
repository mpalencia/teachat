<?php

namespace App\Modules\SchoolAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolAdmin\Models\Curriculum;
use App\Modules\SchoolAdmin\Models\Grades;
use App\Modules\SchoolAdmin\Models\SubjectCategory;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class CurriculumController extends Controller
{
    /**
     * @var Curriculum
     */
    private $curriculum;

    /**
     * @var SubjectCategory
     */
    private $subjectCategory;

    /**
     * @var Grades
     */
    private $grades;

    public function __construct(Curriculum $curriculum, SubjectCategory $subjectCategory, Grades $grades)
    {
        $this->curriculum = $curriculum;
        $this->subjectCategory = $subjectCategory;
        $this->grades = $grades;
    }

    /**
     * Display curriculum page.
     *
     * @return View
     */
    public function index()
    {
        $data['grades'] = $this->grades->where('user_id', Auth::user()->id)->get();
        $data['subjectCategory'] = $this->subjectCategory->where('user_id', Auth::user()->id)->get();
        return view('SchoolAdmin::curriculum', $data);
    }

    /**
     * Get all curriculum.
     *
     * @return array
     */
    public function getAll()
    {
        $curriculum = $this->curriculum->with('grades')->with('subjectCategory')->where('user_id', Auth::user()->id)->get()->toArray();

        $c = array_map(function ($structure) use ($curriculum) {

            $action = '<button id="btn-edit-curriculum" type="button" class="btn btn-primary btn-circle btn-edit-curriculum" title="Edit" data-toggle="modal" data-target="#edit-curriculum"
                        onclick="editCurriculum(this)"
                        data-curriculum-id="' . $structure['id'] . '"
                        data-grade-id="' . $structure['grade_id'] . '"
                        data-subject-category-id="' . $structure['subject_category_id'] . '"
                        data-subject="' . $structure['subject'] . '">
                        <i class="material-icons">edit</i>
                    </button> ';
            $action .= '<button id="btn-delete-curriculum" type="button" class="btn btn-danger btn-circle red btn-delete-curriculum" title="Delete" data-toggle="modal" data-target="#delete-curriculum"
                        onclick="deleteCurriculum(this)"
                        data-curriculum-id="' . $structure['id'] . '"
                        data-grade-id="' . $structure['grade_id'] . '"
                        data-subject-category-id="' . $structure['subject_category_id'] . '">
                        <i class="material-icons">delete</i>
                    </button>';

            return [
                'grades' => $structure['grades']['description'],
                'subject_category' => $structure['subject_category']['description'],
                'subject' => $structure['subject'],
                'action' => $action,
            ];
        }, $curriculum);

        return ['data' => $c];
    }

    /**
     * Store a new curriculum.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->merge(array('user_id' => Auth::user()->id));
        $request->merge(array('school_id' => Auth::user()->school_id));

        $rules = [
            'grade_id' => 'required',
            'subject_category_id' => 'required',
            'subject' => 'required|max:50',
        ];

        $error_messages = [
            'grade_id.required' => 'The grade field is required.',
            'subject_category_id.required' => 'The subject category field is required.',
        ];

        $validator = Validator::make([
            'grade_id' => $request->grade_id,
            'subject_category_id' => $request->subject_category_id,
            'subject' => $request->subject,
        ], $rules, $error_messages);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->curriculum->create($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully added.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.'], 200);
    }

    /**
     * Edit a new curriculum.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $rules = [
            'grade_id' => 'required',
            'subject_category_id' => 'required',
            'subject' => 'required|max:50',
        ];

        $error_messages = [
            'grade_id.required' => 'The grade field is required.',
            'subject_category_id.required' => 'The subject category field is required.',
        ];

        $validator = Validator::make([
            'grade_id' => $request->grade_id,
            'subject_category_id' => $request->subject_category_id,
            'subject' => $request->subject,
        ], $rules, $error_messages);

        if ($validator->fails()) {
            return Response::json(['result' => false, 'message' => $validator->errors()->first(), 200]);
        }

        if ($this->curriculum->find($id)->update($request->all())) {
            return Response::json(['result' => true, 'message' => 'Successfully updated.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.'], 200);
    }

    /**
     * Delete a new curriculum.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->curriculum->find($id)->delete()) {
            return Response::json(['result' => true, 'message' => 'Successfully Deleted.'], 200);
        }

        return Response::json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.'], 200);
    }
}
