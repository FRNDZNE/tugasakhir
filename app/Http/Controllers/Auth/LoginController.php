<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
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

    use AuthenticatesUsers;

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
        $this->middleware('auth')->only('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('login','password');
        $user = User::where('email', $credentials['login'])
            ->orWhere('name', $credentials['login'])
            ->orWhereHas('admin', function ($query) use ($credentials) {
                $query->where('uuid', $credentials['login']);
            })
            ->orWhereHas('staff', function ($query) use ($credentials) {
                $query->where('uuid', $credentials['login']);
            })
            ->orWhereHas('agency', function ($query) use ($credentials) {
                $query->where('uuid', $credentials['login']);
            })
            ->orWhereHas('mentor', function ($query) use ($credentials) {
                $query->where('uuid', $credentials['login']);
            })
            ->orWhereHas('dosen', function ($query) use ($credentials) {
                $query->where('uuid', $credentials['login']);
            })
            ->orWhereHas('mahasiswa', function ($query) use ($credentials) {
                $query->where('uuid', $credentials['login']);
            })
            ->first();

        if ($user) {
            return Auth::attempt(['email' => $user->email, 'password' => $credentials['password']]);
        }

        return false;
    }
    public function username()
    {
        return 'login';
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
