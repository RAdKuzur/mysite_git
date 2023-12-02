<?php

namespace App\Http\Controllers;
use App\Models\User;
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
            abort(403, "Время сеанса истекло" );
        }
        $record = DB::table('teacher')
        ->where('id', '=', $id)
        ->get();  
        if($record[0]->flag != 0) {
            abort(403, "Вы уже приняли участие в олимпиаде");
        }
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
                ->where('id', '=' , $id)
                ->update(['url' => $request->url()]);
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
}
