<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Carbon\Carbon;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\ChildrenRequest;
use Teachat\Repositories\Interfaces\ChildrenInterface;
use Teachat\Repositories\Interfaces\GradesInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;

class ChildrenController extends Controller
{
    /**
     * @var GradesInterface
     */
    private $grades;

    /**
     * @var StateUsInterface
     */
    private $stateUs;

    /**
     * @var ChildrenInterface
     */
    private $children;

    /**
     * Dashboard controller instance.
     *
     * @param GradesInterface $grades
     * @param StateUsInterface $grades
     * @param ChildrenInterface $grades
     * @return void
     */
    public function __construct(GradesInterface $grades, StateUsInterface $stateUs, ChildrenInterface $children)
    {
        $this->grades = $grades;
        $this->stateUs = $stateUs;
        $this->children = $children;
    }

    /**
     * Display list page.
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'grades' => $this->grades->getAllByAttributes(['school_id' => Auth::user()->school_id], 'description'),
            'children' => $this->children->getAllByAttributes(['parent_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id], 'last_name'),
        ];

        return view('parent.index_child', $data);
    }

    /**
     * Display create page.
     *
     * @return view
     */
    public function create()
    {
        $data = [
            'grades' => $this->grades->getAllByAttributes(['school_id' => Auth::user()->school_id], 'description'),
            'children' => $this->children->getAllByAttributes(['parent_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id], 'last_name'),
            'state_us' => $this->stateUs->getAll(),
        ];

        return view('parent.create_child', $data);
    }

    /**
     * Display edit page.
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $data = [
            'grades' => $this->grades->getAllByAttributes(['school_id' => Auth::user()->school_id], 'description'),
            'children' => $this->children->getAllByAttributes(['parent_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id], 'last_name'),
            'state_us' => $this->stateUs->getAll(),
            'child' => $this->children->getByIdWithRelationsAndAttributes($id, ['parent', 'state', 'grade'], ['parent_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id]),
        ];
        return view('parent.edit_child', $data);
    }

    /**
     * Store a new child.
     *
     * @return Response
     */
    public function store(ChildrenRequest $request)
    {
        $request->merge(array('parent_id' => Auth::user()->id, 'school_id' => Auth::user()->school_id));

        if (intval(explode("-", $request->birthdate)[0]) > intval(date('Y'))) {
            return response()->json(['result' => false, 'message' => 'Invalid Birthdate.']);
        }

        $age = $this->_child_age($request->birthdate);

        if ($age < 5) {
            return response()->json(['result' => false, 'message' => 'Please check the birthdate. Too young.']);
        }

        if ($this->children->create($request->all())) {

            return response()->json(['success' => true, 'message' => 'Successfully added.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    private function _child_age($date)
    {
        $dt = Carbon::parse($date);
        $age = Carbon::createFromDate($dt->year, $dt->month, $dt->day)->age;
        return $age;
    }
}
