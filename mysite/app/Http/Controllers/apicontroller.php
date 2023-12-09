<?php


namespace App\Http\Controllers;



use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class apicontroller extends Controller
{
    public function getData(Request $request, $token)
    {
       $response = Http::post("http://127.0.0.1:8000/api/data/{$token}");
       if($response->json() == null){
        abort(401);
    }
       return $response->json();
    }
    public function postData(Request $request, $token){
        dd($request->all());
    }
}
