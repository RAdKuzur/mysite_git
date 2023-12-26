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
        return json_encode(['data' => $data]);
    }

    public function schools_get(Request $request){
        $url = $request->query('url');
        $data = DB::table('schools')->get();
        if(DB::table('teachers')->where('url', '=', $url)->where('flag', '=', 1)->count() == 0){
            return json_encode(['data' => $data, 'abort' => 0]);
        }
        else {
            return json_encode(['data' => $data, 'abort' => 1]);
        }
    }

    public function register_teacher($name, Request $request){
        $data = DB::table('schools')->where('name', '=', $name)->get(); 
        $tname = $request->query('name');
        $tsurname = $request->query('surname');
        $id_school = $data[0]->id;
        $server = $request->query('record');
        $url_parent = $server["HTTP_REFERER"];
        $data = DB::table('users')->where('id_teacher', '=', $id_school)->get(); 
        if (DB::table('teachers')->where('name', '=' , "{$tname}")
                                 ->where('surname', '=', "{$tsurname}")
                                 ->where('flag', '=', 0)->where('school', '=', "{$id_school}")
                                 ->where("url", '=', "{$url_parent}")->count() == 0)
        {
            $record = DB::table('teachers')->insert(['name' => "{$tname}", 'surname' => "{$tsurname}", 'flag' => 0, 'school' => "{$id_school}", "url" => "{$url_parent}"]);
        }
        $record = DB::table('teachers')->where('name', '=' , "{$tname}")->where('surname', '=', "{$tsurname}")
        ->where('flag', '=', 0)->where('school', '=', "{$id_school}")->where("url", '=', "{$url_parent}")->get();
        $id = $record[0]->id;
        
        
        return json_encode(['data' => $data, 'teacher_id' => $id]);
    }

    public function show_students($id){
        $data = DB::table('users')->where('id_teacher', '=', $id)->get();
        $countries = DB::table('countries')->get();
        return json_encode(['data' => $data, 'countries' => $countries]);
    }

    public function register_students(Request $request){
        $flag = $request->query('flag');
        $user_id = $request->query('id');
        $ovz = $request->query('ovz');
        $country = $request->query('country');
        $record = DB::table('countries')->where('name', '=', $country)->get();
        $id_country = $record[0]->id; 
        $teacher_id = $request->query('teacher_id');
        $data = DB::table('users')->where('user_id', '=', $user_id)->update(['flag' => $flag , 'disability' => $ovz, 'citizen' => $id_country]);
        DB::table('teachers')->where('id', '=', $teacher_id)->update(['flag' => 1]);
        return json_encode(['data' => $user_id]);
    }
    public function students($id, Request $request){
        $id_school = $id;
        $students = array();
        $record = DB::table('users')->where('id_teacher', '=', $id_school)->get();
        foreach ($record as $element){
            $user_id = $element->user_id;
            array_push($students, $user_id);
        }
        return json_encode(['data' => $students, 'num' => $record->count()]);
    }
}
