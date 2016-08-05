<?php

namespace Teachat\Http\Controllers\Parent;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Teachat\Http\Requests\ChangePasswordRequest;
use Teachat\Http\Requests\AccountRequest;
use Teachat\Http\Controllers\Controller;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;

class MyAccountController extends Controller
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * @var SateUsInterface
     */
    private $stateUs;

    /**
     * MyAccount controller instance.
     *
     * @param TeacherInterface $appointments
     * @return void
     */
    public function __construct(UserInterface $user, CountryInterface $country, StateUsInterface $stateUs)
    {
        $this->user = $user;
        $this->country = $country;
        $this->stateUs = $stateUs;
    }

    /**
     * Display My Account page.
     *
     * @return view
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $country_id = Auth::user()->country_id;

        $data = [
            'country' => $this->country->getAll(),
            'user' => $this->user->getByIdWithRelationsAndAttributes($user_id, ['country', 'state'], ['country_id' => Auth::user()->country_id, 'state_id' => Auth::user()->state_id]),
            'state_us' => $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name'),

        ];

        return view('parent.myaccount', $data);
    }

    /**
     * Get all states by country id.
     *
     * @param $school_id
     * @return view
     */
    public function getStateByCountryId($country_id)
    {
        $state = $this->stateUs->getAllByAttributes(['country_id' => $country_id], 'state_name');

        if (!empty($state)) {
            return ['result' => true, 'message' => $state];
        }

        return ['result' => false, 'message' => 'No State Available.'];

    }

    /**
     * Update Parent's Account
     *
     * @return view
     */
    public function account_update(AccountRequest $request)
    {
        $id = Auth::user()->id;

        if ($this->user->update($id, $request->all())) {
            return response()->json(['success' => true, 'message' => 'Successfully Updated!']);
        }

        return response()->json(['result' => false, 'message' => 'There is an error occured while saving. Please try again later.']);
    }

    /**
     * Change Password
     *
     * @return view
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $id = Auth::user()->id;
        if(Auth::validate(['id' => $id, 'password' => $request->current_pass])){
            $newPassword = bcrypt($request->password);
            if ($this->user->update($id, ['password' => $newPassword, 'password_reset' => 0])) {
                return response()->json(['success' => true, 'message' => 'Password changed successfully.']);
            }
        }

        else{
            return response()->json(['result' => false, 'message' => 'Current password does not match.']);
        }

    }
}
