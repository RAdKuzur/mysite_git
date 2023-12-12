<?php


namespace App\Http\Controllers;
use GuzzleHttp\Client;
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
    public function register_teacher($name, Request $request){
        $data = DB::table('schools')->where('name', '=', $name)->get(); 
        $tname = $request->query('name');
        $tsurname = $request->query('surname');
        $id_school = $data[0]->id;
        $server = $request->query('record');
        $url_parent = $server["HTTP_REFERER"];
        $data = DB::table('users')->where('id_teacher', '=', $id_school)->get();    
        $record = DB::table('teachers')->insert(['name' => "{$tname}", 'surname' => "{$tsurname}", 'flag' => 0, 'school' => "{$id_school}", "url" => "{$url_parent}"]);
        return response()->json(['data' => $data]);
    }
    public function show_students($id){
        $data = DB::table('users')->where('id_teacher', '=', $id)->get();
        return  response()->json(['data' => $data]);
    }
    public function register_students(Request $request){
        $flag = $request->query('flag');
        $user_id = $request->query('id');
        $data = DB::table('users')->where('user_id', '=', $user_id)->update(['flag' => $flag]);
        return  response()->json(['data' => $user_id]);
    }
    public function students($id, Request $request){
        $id_school = $id;
        $students = array();
        $record = DB::table('users')->where('id_teacher', '=', $id_school)->get();
        foreach ($record as $element){
            $user_id = $element->user_id;
            array_push($students, $user_id);
        }
        return response()->json(['data' => $students, 'num' => $record->count()]);
    }
}
