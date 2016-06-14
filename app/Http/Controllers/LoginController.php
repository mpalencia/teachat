<?php

namespace Teachat\Http\Controllers;

use Auth;
use Teachat\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * Login controller instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Display Login page.
     *
     * @return view
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * Authenticate user credentials.
     *
     * @param LoginRequest $login_request
     * @return view
     */
    public function authenticate(LoginRequest $login_request)
    {
        if (!Auth::attempt(['email' => $login_request->email, 'password' => $login_request->password, 'active' => 1, 'suspend' => 0])) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password.']);
        }

        return response()->json(['success' => true, 'message' => $this->getUserRole(Auth::user()->role_id) . '/dashboard']);
    }

    /**
     * Logout user.
     * @return Redirect
     */
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
