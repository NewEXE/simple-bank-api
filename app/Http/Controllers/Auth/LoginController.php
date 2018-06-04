<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as traitLogin;
        logout as traitLogout;
        validateLogin as traitValidateLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    public function login(Request $request)
    {
        if ($request->wantsJson()) {
            $this->validateLogin($request);

            if ($this->attemptLogin($request)) {

                /** @var User $user */
                $user = $this->guard()->user();

                $user->generateToken();

                return response()->json([
                    'data' => $user->toArray(),
                ]);
            }

            return $this->sendFailedLoginResponse($request);
        }

        return $this->traitLogin($request);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        if ($request->wantsJson()) {
            /** @var User|null $user */
            $user = Auth::guard('api')->user();

            if ($user) {
                $user->api_token = null;
                $user->save();

                return response()->json(['data' => 'User logged out.'], 200);
            } else {
                return response()->json(['data' => 'User already logged out or api_token not provided.'], 400);
            }
        }

        return $this->traitLogout($request);
    }
}
