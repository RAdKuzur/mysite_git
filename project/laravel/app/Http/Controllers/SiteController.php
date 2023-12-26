<?php

namespace App\Http\Controllers;
use App\Models\User;
use Redirect;
use GuzzleHttp\Client;
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
    public function table_process(Request $request, $id, $teacher_id){
        if(!$request->hasValidSignature()){
            abort(403, "Время сеанса истекло");
        }
        $data = Http::get("http://127.0.0.1:8001/api/show_students/{$id}");
        $data = json_decode($data, true);
        $number = count($data['data']);
        $countries = $data['countries'];
        return view('welcome')->with('record', $data)->with('number', $number)->with('id_t', $id)->with('teacher_id',$teacher_id)
                              ->with('countries',$countries)->with('num_count',count($countries));
    }
    //Post формы подтверждения
    public function registerPost(Request $request, $id, $teacher_id){
        $number = 3;
        $data = Http::get("http://127.0.0.1:8001/api/students/{$id}");
        $data = json_decode($data, true);
        $data_id = $data["data"];
        $num = $data["num"];
        for($i = 0; $i < $num; $i++) {
            $num2 = $number - 1;
            $num3 = $number - 2;
            $checkbox_ovz = $request->input("checkbox{$num2}");
            if($checkbox_ovz == "on"){
                $ovz = 1;
            }
            else {
                $ovz = 0;
            }
            $country = $request->input("checkbox{$num3}");
            if ($request->input("checkbox{$number}") == "on"){       
                $data = Http::get("http://127.0.0.1:8001/api/register_students",
                [   
                    'ovz' => $ovz,
                    'country' => $country,
                    'id' => $data_id[$i],
                    'flag' => 1, 
                    'teacher_id' => $teacher_id
                ]);
            }
            else {       
                $data =  Http::get("http://127.0.0.1:8001/api/register_students",
                [
                    'ovz' => $ovz,
                    'country' => $country,
                    'id' => $data_id[$i],
                    'flag' => 0,  
                    'teacher_id' => $teacher_id
                ]);               
            }
            $number = $number + 3;
        }
        return redirect(route('main'));
    }
    public function main(){   
        return view('main');
    }
    //POST формы регистрации учителя
    public function giveurl(Request $request){
        $data = Http::get("http://127.0.0.1:8001/api/register/{$request->name}",
        [
            'name' => $request -> name_teacher,
            'surname' => $request -> surname_teacher,
            'record' => $request->server(),
        ]);
        //$data  = $data->json();
        $data = json_decode($data, true);
        $id_school = $data['data'][0]['id_teacher'];
        $teacher_id = $data['teacher_id'];
        $url = URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => $id_school, 'teacher_id' => $teacher_id]);
        return Redirect::to($url); 
    }
    //  GET формы регистрации учителя
    public function giveurl_get(Request $request){  
        if(!$request->hasValidSignature()){
            abort(403, "Время сеанса истекло");
        }
        $data = Http::get("http://127.0.0.1:8001/api/schools",
        [
            'url' => url()->full(),
        ]);
        $data = json_decode($data, true);
        $num = count($data['data']);
        if($data['abort'] == 1)
        {
            abort(403, "Ссылка недействительна");
        }
        return view('giveurl')->with('record', $data)->with('num2', $num);
    }
}
