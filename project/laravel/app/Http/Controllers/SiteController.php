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
    public function table_process($id){
        $record = DB::table('students')
                    ->where('id_teacher', '=', $id)
                    ->get();    
        return view('welcome')->with('record', $record)->with('id_teacher', $id);
    }
    public function registerPost(Request $request, $id){
        $number = 1; 
        $record = DB::table('students')
                    ->where('id_teacher', '=', $id)
                    ->get();
        //dd($request);
        $var = new User;
        foreach ($record as $element) {
            $id_student = $element->id;
            if ($request->input("checkbox{$number}") == "on"){
                $var = DB::table('students')->where('id','=', $element->id)->update(['flag' => 1]);
              /*  echo("@");
                echo($number);
                echo("    ");
                echo($element->id);
                
                echo("on");*/
            }
            else {
                $var = DB::table('students')->where('id','=', $element->id)->update(['flag' => 0]);
               /*echo("@");
                echo($number);
                echo("off");
                echo("    ");
                echo($element->id);*/
                
            }
            $number = $number + 1;
        }
    }
}
