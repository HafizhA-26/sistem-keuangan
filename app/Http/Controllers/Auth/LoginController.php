<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;
use DB;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index()
    {
        $title = "Sistem Informasi Keuangan";
        return view('auth.login', ['title' => $title]);
    }
    
    function checklogin(Request $request){
        $this->validate($request,[
            'nip'   => 'required',
            'password'  => 'required'
        ]);
        $akun_data = array(
            'nip' =>  $request->get('nip'),
            'password'  =>  $request->get('password')
        );
        if(Auth::attempt($akun_data)){
            return redirect('login/successlogin');
        }else{
            return back()->with('pesan','NIP atau Password salah');
        }
    }
    function successlogin(){
        $nip = '1';
        $user_data = DB::table('accounts')
                ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                ->select('accounts.*','detail_accounts.*')
                ->where('accounts.nip','=',$nip)
                ->get();
        dd(Auth::user());
        if(Auth::check()){
            dd($user_data);
        }
    }
    function logout(){
        Auth::logout();
        return redirect('login');
    }
}
