<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    public function index(){

        $students = Student::all();

        if ($students->count()>0){
            return response()->json([
                'status'=> 200,
                'students'=>$students
            ], 200);
        }
        else {
            return response()->json([
                'status'=> 404,
                'students'=>'No records found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:190',
            'course'=>'required|string|max:190',
            'email'=>'required|email|max:190',
            'phone'=>'required|digits:13'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'errors'=>$validator->messages()
            ],422);
        }else {
            $student=Student::create([
                'name'=>$request->name,
                'course'=>$request->course,
                'email'=>$request->email,
                'phone'=>$request->phone
            ]);
        }

        if ($student) {
            return response()->json([
                'status'=>200,
                'message'=>"Student created successfully"
            ],200);
        }else {
            return response()->json([
                'status'=>500,
                'message'=>"Student not created"
            ],500);
        }
    }

    public function show($id){
        $student = Student::find($id);
        if ($student) {
            # code...
            return response()->json([
                'status'=>200,
                'student'=>$student,
                'message'=>"Student found"
            ],200);
        } else {
            
            return response()->json([
                'status'=>404,
                'message'=>"No student with that id found"
            ],404);
        }
        
    }

    public function edit($id){
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status'=>200,
                'student'=>$student,
                'message'=>"Student found"
            ],200);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>"No student found"
            ],404);
        }
        
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:190',
            'course'=>'required|string|max:190',
            'email'=>'required|email|max:190',
            'phone'=>'required|digits:13'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'errors'=>$validator->messages()
            ],422);
        }else {
            $student=Student::find($id);
        

            if ($student) {

                $student->update([
                    'name'=>$request->name,
                    'course'=>$request->course,
                    'email'=>$request->email,
                    'phone'=>$request->phone
                ]);

                return response()->json([
                    'status'=>200,
                    'message'=>"Student updated successfully"
                ],200);
            }else {
                return response()->json([
                    'status'=>404,
                    'message'=>"no such student found"
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $student=Student::find($id);

        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'Message'=>"Student of id $id has beeen deleted succesfully"
            ],200);
        }else {
            return response()->json([
                'status'=>404,
                'message'=>"No such Student found!!"
            ],404);
        }
    }
}
