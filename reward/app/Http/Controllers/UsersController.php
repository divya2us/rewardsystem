<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;

class UsersController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function signup()
    {
        return view('registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('You have Successfully loggedin');
        }
        return redirect("login")->withErrors('Oppes! You have entered invalid credentials');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'referer_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirmpassword' => 'required|min:6',
        ]);
        $data = $request->all();
        $checkReferer = User::findByReferer($data);
        if($checkReferer == null){
            return redirect("signup")->withErrors('Oppes! You have entered wrong referral');
        }else{
            User::createUser($data);
            return redirect("login")->withSuccess('Great! You have Successfully registered');
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {
            $refDetails = User::getUsersById(Auth::id());
            if($refDetails != null){
                for($i=0; $i < count($refDetails);$i++) {
                    $refDetails[$i]['credit_points'] = Reward::getCreditpoints($refDetails[$i]['id']);
                    $refDetails[$i]['referral_email'] = Auth::user()->email;
                }
            }
            return view('dashboard')->with('refDetails',$refDetails);
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

}
