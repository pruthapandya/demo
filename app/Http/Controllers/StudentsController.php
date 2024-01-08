<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentsController extends Controller
{
   // List all students
   public function index()
   {
        try{
            $students = Student::paginate(10);
            return response()->json(['students' => $students], 200);
        }catch(Exception $e){
            Log::info($e);
            return $e;
        }
   }

   // Create a new student
   public function createStudent(Request $request)
   {
        try{
       $data = $request->validate([
           'name' => 'required|string|max:255',
           'age' => 'required|numeric',
           'grade' => 'required',
       ]);

       $student = Student::create($data);
       return response()->json(['student' => $student], 201);
    }catch(Exception $e){
        Log::info($e);
        dd($e);
    }
   }

   // Show a specific student
   public function show($id)
   {
       $student = Student::find($id);

       if (!$student) {
           return response()->json(['message' => 'Student not found'], 404);
       }

       return response()->json(['student' => $student], 200);
   }

   // Update a specific student
   public function update(Request $request, $id)
   {
       $data = $request->all();
       $student = Student::find($id);

       if (!$student) {
           return response()->json(['message' => 'Student not found'], 404);
       }

       $student->update($data);

       return response()->json(['student' => $student], 200);
   }

   // Delete a specific student
   public function destroy($id)
   {
       $student = Student::find($id);

       if (!$student) {
           return response()->json(['message' => 'Student not found'], 404);
       }

       $student->delete();

       return response()->json(['message' => 'Student deleted successfully'], 200);
   }
}
