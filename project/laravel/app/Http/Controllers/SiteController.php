<?php

namespace App\Http\Controllers;
use App\Models\User;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
class SiteController extends Controller
{
    //
       // Implement your logic here to handle actions when the link is accessed.
       // This may include updating records, confirming email addresses, resetting passwords, and more.
    public function table_process(Request $request, $id){
        if(!$request->hasValidSignature()){
            abort(403, "Время сеанса истекло");
        }
        $record = DB::table('teacher')
        ->where('id', '=', $id)
        ->get();  
        if($record[0]->flag != 0) {
            abort(403, "Вы уже приняли участие в олимпиаде");
        } 
        DB::table('teacher')
            ->where('id', '=' , $id)
            ->update(['flag' => 1]);
        $id2 =  DB::table('teacher')
        ->where('id', '=', $id)
        ->get();    
        $id = $id2[0]->school;
        $record = DB::table('students')
                    ->where('id_teacher', '=', $id)
                    ->get();    
        return view('welcome')->with('record', $record)->with('id_teacher', $id);
    }
    public function registerPost(Request $request, $id){
        DB::table('teacher')
                ->where('id', '=' , $id)
                ->update(['flag' => 1]);
        DB::table('teacher')
                ->where('id', '=' , $id);

        $number = 1; 
        $record = DB::table('students')
                    ->where('id_teacher', '=', $id)
                    ->get();
        $var = new User;
        foreach ($record as $element) {
            $id_student = $element->id;
            if ($request->input("checkbox{$number}") == "on"){
                $var = DB::table('students')->where('id','=', $element->id)->update(['flag' => 1]);
            }
            else {
                $var = DB::table('students')->where('id','=', $element->id)->update(['flag' => 0]);
            }
            $number = $number + 1;
        }
        sleep(1);
        return redirect(route('main'));
    }
    public function main(){   
        return view('main');
    }


    //POST METHOD
    public function giveurl(Request $request){
        
        if($request->name == ""){
            //указание об ошибке
            return redirect(route('giveurl'));
        }
        else {
            $id_schools = DB::table('school')->where('id', '=', $request->name)->get();
            $id_school = $id_schools[0]->id;
            $teachers = DB::table('teacher')->where('school', '=', $id_school)->get();
            $num2 = $teachers->count();

            //добавить проверку по url
            $urlfull = ($request->server())["HTTP_REFERER"];
            if(DB::table('teacher')->where('url', '=' ,$urlfull)->get()->count() != 0){
                abort(403, "Время сеанса истекло");
            }
            $record = DB::table('teacher')
                ->where('school', '=', $id_school)
                ->where( 'name', '=' ,"{$request->name_teacher}")
                ->where('surname', '=' ,"{$request->surname_teacher}")
                
                ->get();
           
            if($record->count() == 0){        
                DB::table('teacher')->insert([
                    'name' => "{$request->name_teacher}", 
                    'surname' => "{$request->surname_teacher}",
                    'flag' => 0,
                    'school' =>  $id_school,
                    'url' => ""

                ]);  
                $record = DB::table('teacher')
                        ->where('school', '=', $id_school)
                        ->where( 'name', '=' ,"{$request->name_teacher}")
                        ->where('surname', '=' ,"{$request->surname_teacher}")->get();  
                $i = $record[0]->id;
                $url = URL::temporarySignedRoute('table.process', now()->addSeconds(1000), ['id' => $i]);
                DB::table('teacher')
                        ->where('school', '=', $id_school)
                        ->where( 'name', '=' ,"{$request->name_teacher}")
                        ->where('surname', '=' ,"{$request->surname_teacher}")
                        ->update(['url' => $urlfull]);
                return Redirect::to($url);
            }
            else {      
                DB::table('teacher')
                        ->where('school', '=', $id_school)
                        ->where( 'name', '=' ,"{$request->name_teacher}")
                        ->where('surname', '=' ,"{$request->surname_teacher}")
                        ->where('url', '=' ,$urlfull)
                        ->update(['flag' => 1]);
                abort(403, "Вы уже приняли участие в олимпиаде");
            }
            //return view('teacher')->with('record',$teachers)->with('num2',$num2);
        }
       /* if($request->name == ""){
            //указание об ошибке
            return redirect(route('giveurl'));
        }
        else {

            
            return view('teacher')->with('record',$teachers)->with('num2',$num2);
        }
        */
    }
    public function giveurl_get(Request $request){  
        if(!$request->hasValidSignature()){
            abort(403, "Время сеанса истекло");
        }
        $record = DB::table('school')->get();
        $num2 = DB::table('school')->count();
        return view('giveurl')->with('record', $record)->with('num2',$num2);
    }
}
