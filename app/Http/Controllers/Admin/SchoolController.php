<?php

namespace Teachat\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\SchoolRequest;
use Teachat\Models\School;
use Teachat\Models\StateUs;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\ImageUploader;

class SchoolController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var School
     */
    private $school;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var State
     */
    private $state;

    /**
     * @param User $user
     * @param User $school
     */
    public function __construct(UserInterface $user, SchoolInterface $school, CountryInterface $country, StateUsInterface $state)
    {
        $this->user = $user;
        $this->school = $school;
        $this->country = $country;
        $this->state = $state;
    }

    /**
     * Display school page
     *
     * @return view
     */
    public function index()
    {
        $data['users'] = $this->user->getByAttributesWithRelations(['role_id' => 5], ['school'], 'last_name');
        $data['schools'] = $this->school->getAllSchool();
        $data['country'] = $this->country->getAll();
        $data['states'] = $this->state->getAll();

        return view('admin.school.index', $data);
    }

    /**
     * Display create school page
     *
     * @return view
     */
    public function create()
    {
        return view('admin.school.create');
    }

    /**
     * Display create school page
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $data['school'] = $this->school->getById($id);
        $data['states'] = $this->state->getAllByAttributes(['country_id' => $data['school']['country_id']]);
        $data['country'] = $this->country->getAll();

        return view('admin.school.edit', $data);
    }

    /**
     * Store a new school.
     *
     * @return Response
     */
    public function store(SchoolRequest $request)
    {
        $file = $request->file('school_logo');

        $this->_validate_image_format($file->getClientOriginalExtension());

        $school = $this->school->create(['state_id' => $request->state_id, 'country_id' => $request->country_id, 'school_name' => $request->school_name]);

        $this->school->update($school->id, ['school_logo' => $school->id . '.' . $file->getClientOriginalExtension()]);

        $imageUploader = new ImageUploader;

        $imageUploader->upload($file, $school->id);

        // return redirect('admin/schools/create')->with('message', 'Successfully Created');
        return json_encode(array('result' => 'success', 'message' => 'Successfully Created'));
    }

    /**
     * Store a new school.
     *
     * @param integer $id
     * @param SchoolRequest $request
     * @return Response
     */
    public function update($id, SchoolRequest $request)
    {

        if ($request->hasFile('school_logo_temp')) {
            $file = $request->file('school_logo_temp');

            $this->_validate_image_format($file->getClientOriginalExtension());

            $imageUploader = new ImageUploader;

            $imageUploader->upload($file, $id);

            $request->merge(['school_logo' => $id . '.' . $file->getClientOriginalExtension()]);

        }

        $this->school->update($id, $request->except('_method'));

        // return redirect('admin/schools/' . $id . '/edit')->with('message', 'Successfully Updated');
        return json_encode(array('result' => 'success', 'message' => 'Successfully Updated'));
    }

    /**
     * Get States by attributes
     *
     * @param integer $country_id
     * @return Response
     */
    public function getStates($country_id)
    {
        $states = StateUs::where('country_id', $country_id)->get()->toArray();

        return ['states' => $states];
    }

    /**
     * Get Schools by attributes
     *
     * @param integer $state_id
     * @return Response
     */
    public function getSchools($state_id)
    {
        return ['schools' => $this->school->getAllByAttributes(['state_id' => $state_id])];
    }

    /**
     * Get Schools by attributes
     *
     * @param integer $state_id
     * @return Response
     */
    public function getByStatus($status)
    {
        $schools = $this->school->getAllByAttributes(['status' => $status]);

        return ['data' => $schools];
    }

    /**
     * Generate new verification code.
     *
     * @return string
     */
    private function _validate_image_format($file_extension)
    {
        if (!in_array($file_extension, array('gif', 'png', 'jpg', 'jpeg', 'PNG', 'JPG'))) {
            return redirect()->back()->with('error', 'Image invalid format.')->withInput();
        }
    }

    /**
     * Generate new verification code.
     *
     * @return string
     */
    private function _generate_verification_code()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';

        $pin = mt_rand(10, 99) . mt_rand(10, 99) . $characters[rand(0, strlen($characters) - 1)];

        return str_shuffle($pin);
    }

    /**
     * Update upload status.
     *
     * @param integer $id
     * @return string
     */
    public function updateUpload($id, Request $request)
    {
        if ($this->school->update($id, ['upload' => $request->upload])) {
            return response()->json(['result' => true, 'message' => 'Updated Successfully.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while updating. Please try again later.']);
    }

    /**
     * Delete a certaing school.
     *
     * @param integer $id
     * @return string
     */
    public function destroy($id)
    {
        if ($this->school->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Deleted Successfully.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }
}
