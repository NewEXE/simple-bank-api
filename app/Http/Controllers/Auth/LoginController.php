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

    protected $wantsJson = false;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->wantsJson()) $this->wantsJson = true;

        $this->middleware('guest')->except('logout');
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        if ($this->wantsJson) {

            $name = $request->input($this->username());
            $cnp = $request->input('cnp');

            if ($user = $this->checkApiCredentials($name, $cnp)) {

                $this->guard()->login($user, false);

                $user->generateToken();

                return response()->json([
                    'api_token' => $user->api_token,
                ]);
            }

            return $this->sendFailedLoginResponse($request);
        }

        return $this->traitLogin($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        if ($this->wantsJson) {
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

    /**
     * @param $name
     * @param $cnp
     * @return User|null
     */
    protected function checkApiCredentials($name, $cnp)
    {
        return User::where('name', $name)->where('cnp', $cnp)->first();
    }
}
