<?php

namespace Teachat\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Teachat\Http\Controllers\Controller;
use Teachat\Http\Requests\ForgotPasswordRequest;
use Teachat\Http\Requests\ChangePasswordRequest;
use Teachat\Repositories\Interfaces\UserInterface;
use Teachat\Services\MailSender;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    /**
     * Password reset
     *
     * @param FogatPasswordRequerst $request
     * @param MailSender $mailSender
     * @return Response
     */
    public function reset(ForgotPasswordRequest $request, MailSender $mailSender)
    {
        $user_data = $this->user->getByAttributes(['email' => $request->email]);

        if (!$user_data) {
            return response()->json(['success' => false, 'message' => 'Failed! User does not exist.']);
        }

        $user_data['temp_password'] = $this->_generate_temporary_password();

        $this->user->update($user_data['id'], ['password' => bcrypt($user_data['temp_password']), 'password_reset' => 1]);

        if ($mailSender->send('email.reset_password', 'Reset Password Request', $user_data)) {
            return response()->json(['success' => true, 'message' => 'Success! New password has been sent to your email.']);
        }

        return response()->json(['success' => false, 'message' => 'Failed! There is an error occured while sending. Please try again.']);
    }

    /**
     * Generate temporary password.
     *
     * @return string
     */
    private function _generate_temporary_password()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZzxcvbnmasdfghjklqwertyuiop';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(100, 9999) . mt_rand(100, 9999) . $characters[rand(0, strlen($characters) - 1)];
        // shuffle the result
        return str_shuffle($pin);
    }

    /**
     * Change Password
     *
     * @return view
     */
    public function changePassword(ChangePasswordRequest $request)
    {   
        dd(Auth::user()->id);
        $id = Auth::user()->id;
        if(Auth::validate(['password' => $request->current_pass])){
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
