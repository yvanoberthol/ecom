<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use App\Mail\SecondEmailVerifyMailManager;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     * @throws Exception
     */
    public function sendResetLinkEmail(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
            if ($user !== null) {
                $user->verification_code = random_int(100000,999999);
                $user->save();

                $array['view'] = 'emails.verification';
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['subject'] = translate('Password Reset');
                $array['content'] = translate('Verification Code is ').$user->verification_code;

                Mail::to($user->email)->queue(new SecondEmailVerifyMailManager($array));

                return view('auth.passwords.reset');
            }

            flash(translate('No account exists with this email'))->error();
            return back();
        }

        $user = User::where('phone', $request->email)->first();
        if ($user !==null) {
            $user->verification_code = random_int(100000,999999);
            $user->save();
            SmsUtility::password_reset($user);
            return view('otp_systems.frontend.auth.passwords.reset_with_phone');
        }

        flash(translate('No account exists with this phone number'))->error();
        return back();
    }
}
