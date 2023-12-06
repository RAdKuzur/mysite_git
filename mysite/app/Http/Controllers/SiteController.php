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
    public function welcome() {
        return view('welcome');
    }
    public function login() {
    }

    public function register() {
        return view('register');
    }
    function loginPost(Request $request){
    }  




    function registerPost(Request $request){
    



    }

}


