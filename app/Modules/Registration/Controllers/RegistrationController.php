<?php namespace App\Modules\Registration\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Quickblox\Controllers\QuickbloxController;
use App\Modules\Registration\Models\Advisory;
use App\Modules\Registration\Models\Parent_profile;
use App\Modules\Registration\Models\Pass_table;
use App\Modules\Registration\Models\Teacher_profile;
use App\Modules\Registration\Models\Users;
use App\Modules\School\Controllers\SchoolController;
use App\Modules\StatesUS\Models\StatesUS;
use Crypt;
use Illuminate\Http\Request;
use Mail;
use Validator;

class RegistrationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $school;
    //private $qb;
    private $role;

    public function __construct()
    {

        $this->school = new SchoolController();
        //$this->qb = new QuickbloxController();
        $this->role = array('admin' => 1, 'teacher' => 2, 'parent' => 3);
    }

    public function index()
    {
        $state_us = StatesUS::get()->toArray();
        $schools = $this->school->getSchool();

        return view("Registration::index", ['state_us' => $state_us, 'schools' => $schools]);
    }

    public function registration(Request $request)
    {

        //dd($request->all());
        if (isset($request->agree)) {
            return json_encode(array('message' => 'Please agree to the Terms and Condition in order to continue', 'code' => '0'));
        } else if (strlen($request->password) < 8) {
            return json_encode(array('message' => 'Password is weak *Minimum 8 character password.', 'code' => '0'));
        } else if ($request->password !== $request->password_confirm) {
            return json_encode(array('message' => 'Password not match. Please try again', 'code' => '0'));
        } else {

            $code = $this->verification_code();
            $qbPass = $this->Encrypt($request->password);
            //$userPass = Hash::make($request->password);
            $userPass = bcrypt($request->password);
            $users = array('password' => $userPass, 'email' => $request->user_email, 'first_name' => $request->first_name, 'profile_img' => 'dp.png', 'gender' => $request->gender, 'middle_name' => $request->middle_name, 'last_name' => $request->last_name, 'state_id' => $request->state_id, 'active' => 0, 'school_id' => $request->school_id, 'role_id' => $this->role[$request->type], 'verification_code' => $code, 'status' => 1, 'contact_cell' => $request->contact_mobile, 'contact_home' => $request->contact_home, 'contact_work' => $request->contact_work, 'city' => $request->city, 'zip_code' => $request->zip_code, 'address_one' => $request->address_one, 'address_two' => $request->address_two);

            $rules = [
                'school_id' => 'required',
                'role_id' => 'required',
                'email' => 'email|required|unique:users',
                'password' => 'required|min:8',
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'state_id' => 'required',
                'contact_cell' => 'required|max:30',
                'address_one' => 'required',
            ];

            $validator = Validator::make($users, $rules);

            if ($validator->fails()) {
                return json_encode(array('message' => $validator->errors()->first(), 'code' => '0'));
            }

            $create_user = Users::create($users);
            if ($create_user) {
                $floox = $this->registerFloox($create_user);
                $this->createPassEncrypt(array('id' => $create_user->id, 'password' => $qbPass));
                //create profile for teacher or parent here------------
                if ($this->role[$request->type] == 2) {
                    $this->createTeacher($create_user->id, $create_user->school_id);
                    //$this->createAdvisory($create_user->id);
                } else {
                    //-- admin account should be here
                    //dd('admin account in registration goes herer');
                }

                $this->mailer_deamon($request->user_email, $code);
                return json_encode(array('message' => 'Registration Successful. Please check your email inbox to verify your account. Also please check your SPAM folder if you don\'t see it in  your inbox.', 'code' => '1'));
            }

        }
    }
    public function registerFloox($user)
    {
        $additional_data = array(
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        );

        $url = "http://10.10.0.195:1337/applicationusers?user_id=" . $user->id . "&additional_data=" . json_encode($additional_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'app_id: 5742b703c60856fc3c688ec3', 'access_token:Kg9m7QUHVblyaeYAFbXtUVIe'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    public function Encrypt($text)
    {
        $result = Crypt::encrypt($text);
        return $result;
    }

    public function Decrypt($text)
    {

    }

    public function createPassEncrypt($data = array())
    {
        $result = Pass_table::create($data);
        return $result;
    }

    public function createAdvisory($user_id)
    {
        return Advisory::create(array('teacher_id' => $user_id));
    }

    public function createParent($user_id)
    {
        $result = Parent_profile::create(array('user_id' => $user_id));
        return $result;
    }

    public function createTeacher($user_id, $school_id)
    {
        $result = Teacher_profile::create(array('user_id' => $user_id, 'school_id' => $school_id));
        return $result;
    }

    public function verification_code()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(10, 99)
        . mt_rand(10, 99)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        //dd($string);
        return $string;
    }

    public function mailer_deamon($email, $code)
    {
        $url_emailed = 'dev2.teachat.co/verify/v2/' . $email . '/' . $code;
        $data = array('link' => $url_emailed, 'email' => $email);
        //dd($data);
        Mail::send('confirm_email', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'], 'name')->subject('Account verification from Teachat.co');
        });
    }

    public function mailer_deamon_teachat(Request $req)
    {
        $data = $req->all();
        //dd($data);
        Mail::send('teachatco_mailer', ['data' => $data], function ($message) use ($data) {
            $message->to('info@teachat.co', 'name')->subject('Subscription Teachat.co');
        });

        return json_encode(array('message' => 'Thank you for subscribing to teachat', 'code' => '1'));
    }

    public function contact_us(Request $req)
    {
        $data = $req->all();
        //dd($data);
        unset($data['g-recaptcha-response']);
        Mail::send('teachatco_mailer_contact_us', ['data' => $data], function ($message) use ($data) {
            $message->to('info@teachat.co', 'name')->subject('Contact Us from Teachat.co');
        });

        return json_encode(array('message' => 'Thank you for subscribing to teachat', 'code' => '1'));
    }

    public function appointmentSetupTeacher_email($data)
    {
        $data = $req->all();
        //dd($data);
        Mail::send('teachatco_mailer', ['data' => $data], function ($message) use ($data) {
            $message->to('info@teachat.co', 'name')->subject('Subscription Teachat.co');
        });

        return json_encode(array('message' => 'Thank you for subscribing to teachat', 'code' => '1'));
    }

}
