<?php

namespace Teachat\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Models\StateUs;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;

class LocationController extends Controller
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
     * Display the Location Page
     *
     * @return view
     */
    public function index()
    {
        $data['country'] = $this->country->getAll();
        $data['states'] = $this->state->getAllWithRelations(['country'], 'state_name');

        return view('admin.location.index', $data);
    }

    /**
     * Display all the locations in a datatable 
     *
     * @return view
     */

    public function getAll()
    {
        $states = $this->state->getAllWithRelations(['state', 'country'], 'state_name');

        $sc = array_map(function ($structure) use ($states) {

            $action = '<a href="#!" id="edit_loc" class="btn waves-effect white-text" data-id="' . $structure['state']['id'] . '" data-cid="' . $structure['state']['country_id'] . '" data-state="' . $structure['state']['state_name'] . '" onclick="showEditLocation(' . $structure['state']['id'] . ');"><i class="material-icons" style="color:#fff">edit</i></a> ';

            // $action .= '<a id="del-table" href="#delete_location_modal" class="btn red white-text" data-id="' . $structure['state']['id'] . '" data-cid="' . $structure['state']['country_id'] . '" data-state="' . $structure['state']['state_name'] . '" onclick="deleteLocation(this)" ><i class="material-icons" style="color:#fff">delete</i></a>';

            return [
                'country' => $structure['country']['name'],
                'state_name' => $structure['state']['state_name'],
                'state_code' => $structure['state']['state_code'],
                'action' => $action,
            ];
        }, $states);

        return ['data' => $sc];
    }

    /**
     * Store a new location.
     *
     * @return view
     */
    public function store(Request $request)
    {   
        if($request->country_id == 2){
            $request->merge(['state_code' => '']);
        }

        $this->state->create($request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Created.']);
    }

    /**
     * Display edit location
     *
     * @return view
     */
    public function edit($id)
    {
        $states = StateUs::where('id', '=', $id)->first();

        return ['data' => $states];
    }

    /**
     * Update a certain location.
     *
     * @return view
     */
    public function update($id, Request $request)
    {
        if($request->country_id == 2){
            $request->merge(['state_code' => '']);
        }
        
        if ($this->state->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully Updated.']);
        }

        return response()->json(['result' => false, 'message' => 'Error']);

    }

    /**
     * Delete a location.
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->state->delete($id)) {
            return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while deleting. Please try again later.']);
    }

    /**
     * Generate new verification code.
     *
     * @return string
     */
    private function _generate_verification_code()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';

        $pin = mt_rand(10, 9999) . mt_rand(10, 9999) . $characters[rand(0, strlen($characters) - 1)];

        return str_shuffle($pin);
    }
}
