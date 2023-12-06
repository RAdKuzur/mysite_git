<?php


namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class apicontroller extends Controller
{
    public function getData(Request $request,$token)
    {
      // $response = Http::get("http://127.0.0.1:8000/api/data", [
       // 'name' => '1',
       // 'page' => 1,
   // ]);
       $response = Http::get("http://127.0.0.1:8000/api/data", ['token' => $token]);
       $api_token = $response->json('token');
       if($api_token != $token){
            //dd($api_token , $token);
            return $response->json();
            abort(403, "Неверный токен");
       }
       else {
            dd($api_token , $token);
            return $response->json();
       }
       return $response->json();
    }
    public function postData(Request $request, $token){

        dd($request);
    }
}
