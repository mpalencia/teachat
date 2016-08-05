<?php

namespace Teachat\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\RegisterRequest;
use Teachat\Repositories\Interfaces\CountryInterface;
use Teachat\Repositories\Interfaces\SchoolInterface;
use Teachat\Repositories\Interfaces\StateUsInterface;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\Curl;
use Teachat\Services\MailSender;

class ParentController extends Controller
{
    /**
     * @var SchoolInterface
     */
    private $school;

    /**
     * @var StateUsInterface
     */
    private $stateUs;

    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * @var UserInterface
     */
    private $parent;

    /**
     * @param UserInterface $user
     */
    public function __construct(SchoolInterface $school, StateUsInterface $stateUs, CountryInterface $country, UserInterface $parent)
    {
        $this->school = $school;
        $this->stateUs = $stateUs;
        $this->country = $country;
        $this->parent = $parent;
    }

    /**
     * Display parent page
     *
     * @return view
     */
    public function index()
    {
        $data['parents'] = $this->parent->getAllByAttributesWithRelations(['country', 'state'], ['role_id' => 3], 'first_name');

        return view('admin.parent.index', $data);
    }

    /**
     * Display create parent page
     *
     * @return view
     */
    public function create()
    {
        $data['school'] = $this->school->getAll();
        $data['state_us'] = $this->stateUs->getAll();
        $data['country'] = $this->country->getAll();
        $data['parents'] = $this->parent->getAllByAttributesWithRelations(['country', 'state'], ['role_id' => 3], 'first_name');

        return view('admin.parent.create', $data);
    }

    /**
     * Get all parents waiting for approval.
     *
     * @return array
     */
    public function get($id)
    {
        if ($parent = $this->parent->getByIdWithRelations($id, ['state'])) {
            return response()->json(['result' => true, 'data' => $parent], 200);
        }

        return response()->json(['result' => false, 'message' => 'Teacher not found'], 200);

    }

    /**
     * Store a new school principal.
     *
     * @return view
     */
    public function store(RegisterRequest $request)
    {

        $temp_password = $this->_generate_verification_code();
        $code = md5($this->_generate_verification_code());
        $request->merge(['role_id' => 3]);

        $request->merge(['password' => bcrypt($temp_password), 'approved' => 1, 'active' => 1, 'suspend' => 0, 'status' => 0]);

        $parent = $this->parent->create($request->all());

        $fields = array(
            'user_id' => $parent->id,
            'additional_data' => ['first_name' => $parent->first_name, 'last_name' => $parent->last_name],
        );

        $fields = json_encode($fields);

        $curl = new Curl();
        $curl->call($fields);

        $mailSender = new MailSender;

        $request->merge(['temp_password' => $temp_password]);
        $mailSender->send('email.principal_email_confirmation', 'Email Confirmation', $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Created.', 'url' => '/admin/parents/']);
    }

    /**
     * Display edit parent page
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        $data['school'] = $this->school->getAll();
        $data['states'] = $this->stateUs->getAll();
        $data['country'] = $this->country->getAll();
        $data['parent'] = $this->parent->getByIdWithRelationsAndAttributes($id, ['country', 'state'], ['role_id' => 3]);

        return view('admin.parent.edit', $data);
    }

    /**
     * Update a certain school principal.
     *
     * @param $id
     * @param RegisterRequest $request
     * @return view
     */
    public function update($id, RegisterRequest $request)
    {
        $request->merge(['role_id' => 3]);

        $this->parent->update($id, $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Updated.', 'url' => '/admin/parents/']);
    }

    /**
     * Update a certain school principal.
     *
     * @param $id
     * @param RegisterRequest $request
     * @return view
     */
    public function updateAField($id, Request $request)
    {
        $this->parent->update($id, $request->all());

        return response()->json(['success' => true, 'message' => 'Successfully Updated.', 'url' => '/admin/parents/']);
    }

    public function destroy($id)
    {
        if ($this->parent->delete($id)) {
            return response()->json(['result' => true, 'message' => 'Successfully Deleted.']);
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
