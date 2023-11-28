<?php

namespace App\Http\Controllers;
use App\Models\User;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SiteController extends Controller
{
    public function welcome($id) {
        
        

        $record = DB::table('users')
                    ->where('id', '=', $id)
                    ->get();    
        #$record = DB::select('select * from users where id = :id', ['id' => $id]);
        return view('welcome')->with('record',$record);
    }
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
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $cr = $request->only('email', 'password');
        if(Auth::attempt($cr)) {
            Session::flush();
            Auth::logout();
            $record = DB::select('select * from users where email = :email', ['email' => $request->email]);
            $id = $record[0]->id;
            return redirect(route('welcome', $id))->with("success", "Yes");
            /* Вариант 3 session() -> put('record', $record->where('email', '=', $request->email)->get())*/;
            # Вариант 2: return view('welcome')->with('record', $record);
            # return redirect(route('welcome', ['record' => $record]-))
        }
        else {
            return redirect(route('login'))-> with("Error", "No");;
        }
    }  




    function registerPost(Request $request){
        $request->validate([
          'name' => 'required',
          'nickname' => 'required',
          'email' => 'required',
          'password' => 'required',
        ]);
        $data['name'] = $request->name;
        $data['nickname'] = $request->nickname;
        $data['email'] = $request->email;
        #$data['password'] = Hash::make($request->password);
        $data['password'] = $request->password;
        $user = User::create($data);
       
    
        if(!$user) {
            return redirect(route('register')) -> with("error", "No");
        }
        #$record = DB::select('select * from users where email = :email', ['email' => $request->email]);
        $record = DB::table('users')
                        ->where('email', '=', $request->email)
                        ->get();    

        $id = $record[0]->id;
        $record = DB::table('users')
                        ->where('id', '=', $id)
                        ->get();    
        
        # $record = session() -> put('record', $record->where('email', '=', $request->email)->get());
        return redirect(route('welcome',$id))->with("success", "Yes");



    }

}


