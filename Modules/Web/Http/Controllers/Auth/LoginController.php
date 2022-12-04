<?php

namespace Modules\Web\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Web\Http\Controllers\Controller;
use Auth;
use App\Entities\User;

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
    }

    public function showLoginForm(Request $request)
    {
        return view('web::auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['userCode'=>$request->userCode, 'password'=> $request->password])) {
            $user = \DB::table('users')->where('userCode', $request->input('userCode'))->first();
            if ($user->session_id !== '')
            {
                \Session::getHandler()->destroy($user->session_id);
            }

            \DB::table('users')->where('id', $user->id)->update(['session_id' => \Session::getId()]);
            if(Auth::user()->getRoleNames()[0]===USER_ROLE_ADMIN) {
                return redirect('/play_file');
            }
            else if (Auth::user()->getRoleNames()[0]===USER_ROLE_PE) {
                return redirect('/sync_file');
            }
            else if (Auth::user()->getRoleNames()[0]===USER_ROLE_MANAGE_LINE) {
                return redirect('/play_file');
            }
            else {
                return redirect('/hello');
            }
        }
        else {
            return back()->withInput()->with('error', __('auth.failed'));
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
