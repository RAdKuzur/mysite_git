<?php

namespace App\Http\Controllers;
use App\Models\User;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class SiteController extends Controller
{

    public function login() {
        if (Auth::check()) {
            Session::flush();
            Auth::logout();
            return redirect(route('welcome'));
        }
        return view('login');
    }

    public function register() {
        return view('register');
    }
    function loginPost(Request $request){
        //return dd($request);
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $cr = $request->only('email', 'password');
        
        if(Auth::attempt($cr)) {
            Session::flush();
            Auth::logout();
            return redirect(route('welcome')) -> with("success", "Yes");;
          //  return redirect()->intended(route('welcome'));  
        }
        return redirect(route('login'))-> with("Error", "No");;
    }  




    function registerPost(Request $request){
        $request->validate([
          'name' => 'required',
          'nickname' => 'required',
          'email' => 'required',
          'password' => 'required',
       ]);
        $data['name'] = $request->name;
       // $data['nickname'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
      
        if(!$user) {
            return redirect(route('register')) -> with("error", "No");
        }
        return redirect(route('welcome')) -> with("success", "Yes");
    }
}


