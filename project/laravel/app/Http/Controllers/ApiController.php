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
        return studentsResource::collection(students::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(studentRequest $request)
    {
        $create = students::create($request->validated());
        return new studentsResource($create);    
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return new studentsResource(students::findOrFail($id));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(studentRequest $request, students $student)
    {
        $student->where('id', '=', $request->id)->update($request->validated());
        
        return new studentsResource($student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(studentRequest $request, students $student)
    {
        $student->where('id', '=', $request->id)->delete();
        return new studentsResource($student);
    }
    public function getData(Request $request)
    {
        $token = "";
        if ($request->token != null){
            $token = Str::random(80);
            echo($token);
        }
        $data = students::all();
        return response()->json(['data' => $data, 'token'=>$token]);
    }
    public function postData()
    {

    }
}
