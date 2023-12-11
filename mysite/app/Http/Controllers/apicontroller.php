<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class apicontroller extends Controller
{
    public function getData(Request $request, $token)
    {  
       $id = 2;
       $response = Http::post("http://127.0.0.1:8000/api/data/{$id}/{$token}");
       if($response->json() == null){
        abort(401);
    }
       return $response->json();
    }
    public function postData(Request $request, $id_users){
        $data = DB::table('users')->where('id_teacher', '=', $id_users)->get();
        return response()->json(['data' => $data]);
    }
    public function schools_get(){
        $data = DB::table('schools')->get();
        return response()->json(['data' => $data]);

    }
    public function register_teacher($name){
        $data = DB::table('schools')->where('name', '=', $name)->get();
        $id_school = $data[0]->id;
        $data = DB::table('users')->where('id_teacher', '=', $id_school)->get();       
        return response()->json(['data' => $data]);
    }
    public function show_students($id){
        $data = DB::table('users')->where('id_teacher', '=', $id)->get();
        return  response()->json(['data' => $data]);
    }
    public function register_students($id_user){
        $data = DB::table('users')->where('id_teacher', '=', $id_user)->get();
        return  response()->json(['data' => $data]);
    }
}
