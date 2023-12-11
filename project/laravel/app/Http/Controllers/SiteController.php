<?php

namespace App\Http\Controllers;
use App\Models\User;
use Redirect;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
class SiteController extends Controller
{
    //get формы подтверждения
    public function table_process(Request $request, $id){
        if(!$request->hasValidSignature()){
            abort(403, "Время сеанса истекло");
        }
        $data = Http::get("http://127.0.0.1:8001/api/show_students/{$id}");
        $number = count($data['data']);
        //dd($data->json());
        return view('welcome')->with('record', $data)->with('number', $number)->with('id_t', '=', $id);
    }

    public function registerPost(Request $request, $id){
        $number = 1;
        $data = Http::get("http://127.0.0.1:8001/api/register_students/{$id}");
        for($i = 0; $i < $num; $i++) {
            $id_student = $element->id;
            if ($request->input("checkbox{$number}") == "on"){
               
            }
            else {
                
            }
            $number = $number + 1;
        }

    }
    public function main(){   
        return view('main');
    }


    //POST формы регистрации учителя
    public function giveurl(Request $request){
        $data = Http::get("http://127.0.0.1:8001/api/register/{$request->name}");
        $data  = $data->json();
        $id = $data['data'][0]['id_teacher'];
        $url = URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => $id]);
        return Redirect::to($url); 
    }



    //  GET формы регистрации учителя
    public function giveurl_get(Request $request){  
        if(!$request->hasValidSignature()){
            abort(403, "Время сеанса истекло");
        }
        $data = Http::get("http://127.0.0.1:8001/api/schools");
        $num = count($data['data']);
        return view('giveurl')->with('record', $data)->with('num2', $num);
    }
}
