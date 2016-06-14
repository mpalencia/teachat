<?php

namespace Teachat\Http\Controllers\Teacher;

use Auth;
use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\AppointmentsRequest;
use Teachat\Repositories\Interfaces\AppointmentsInterface;

class AppointmentsController extends Controller
{
    /**
     * @var AppointmentsInterface
     */
    private $appointments;

    public function __construct(AppointmentsInterface $appointments)
    {
        $this->appointments = $appointments;
    }
    /**
     * Edit an announcement.
     *
     * @param integer $id
     * @param AppointmentsRequest $request
     * @return Response
     */
    public function update($id, AppointmentsRequest $request)
    {
        if ($this->appointments->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Edit an announcement by attributes.
     *
     * @param Request $request
     * @return Response
     */
    public function updateByAttributes(Request $request)
    {
        if ($this->appointments->updateByAttributes(['teacher_id' => Auth::user()->id], $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully updated.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }
}
