<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\studentsResource;
use App\Http\Requests\studentRequest;
use App\Models\students;
use App\Models\teacher;
use App\Models\school;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(studentRequest $request)
    {  
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {  
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(studentRequest $request, students $student)
    {   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(studentRequest $request, students $student)
    {
    }
    public function getData(Request $request)
    {
    }

    public function postData(Request $request, $id ,$token)
    {
        if(DB::table('students')->where('token', '=' ,$token)->where('id', '=', $id)->count() == 0){
            abort(401);
        };
        
        $data = DB::table('students')->where('token', '=', $token)->where('id', '=', $id)->get();
        return response()->json(['data' => $data, 'token'=>$token]);
    }
}
