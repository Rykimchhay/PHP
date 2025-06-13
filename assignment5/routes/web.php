<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;

Route::get('/', function () {
    return view('welcome');
});

// GET all students
Route::get('/students', function () {
    return response()->json(Student::all());
});

// GET single student by ID
Route::get('/students/{id}', function ($id) {
    $student = Student::find($id);
    if ($student) {
        return response()->json($student);
    }
    return response()->json(['message' => 'Student not found'], 404);
});

// POST new student
Route::post('/students', function (Request $request) {
    $student = $request->all();
    $created = Student::create($student);
    if ($created) {
        return response()->json(['message' => 'Student created successfully']);
    } else {
        return response()->json(['message' => 'Duplicate ID found'], 400);
    }
});

// DELETE student by ID
Route::delete('/students/{id}', function ($id) {
    $deleted = Student::delete($id);
    if ($deleted) {
        return response()->json(['message' => 'Student deleted successfully']);
    } else {
        return response()->json(['message' => 'Student not found'], 404);
    }
});

// PATCH update student by ID
Route::patch('/students/{id}', function (Request $request, $id) {
    $updated = Student::update($id, $request->all());
    if ($updated) {
        return response()->json(['message' => 'Student updated successfully']);
    } else {
        return response()->json(['message' => 'Student not found'], 404);
    }
});




use App\Models\Teacher;

// GET all teachers
Route::get('/teachers', function () {
    return response()->json(Teacher::all());
});

// GET single teacher by ID
Route::get('/teachers/{id}', function ($id) {
    $teacher = Teacher::find($id);
    return $teacher
        ? response()->json($teacher)
        : response()->json(['message' => 'Teacher not found'], 404);
});

// POST new teacher
Route::post('/teachers', function (Request $request) {
    $created = Teacher::create($request->all());
    return $created
        ? response()->json(['message' => 'Teacher created successfully'])
        : response()->json(['message' => 'Duplicate ID found'], 400);
});

// DELETE teacher by ID
Route::delete('/teachers/{id}', function ($id) {
    $deleted = Teacher::delete($id);
    return $deleted
        ? response()->json(['message' => 'Teacher deleted successfully'])
        : response()->json(['message' => 'Teacher not found'], 404);
});

// PATCH update teacher by ID
Route::patch('/teachers/{id}', function (Request $request, $id) {
    $updated = Teacher::update($id, $request->all());
    return $updated
        ? response()->json(['message' => 'Teacher updated successfully'])
        : response()->json(['message' => 'Teacher not found'], 404);
});
