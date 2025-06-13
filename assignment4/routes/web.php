<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

$students = [];
$teachers = [];


Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', function () use (&$students) {
    return response()->json($students);
});

Route::post('/students', function (Request $request) use (&$students) {
    foreach ($students as $student) {
        if ($student['id'] === $request->id) {
            return response()->json(['message' => 'Student ID already exists'], 400);
        }
    }
    $students[] = $request->all();
    return response()->json(end($students), 201);
});

Route::delete('/students/{id}', function ($id) use (&$students) {
    $students = array_filter($students, fn($s) => $s['id'] !== $id);
    return response()->json(['message' => "Student $id deleted"]);
});

Route::patch('/students/{id}', function (Request $request, $id) use (&$students) {
    foreach ($students as &$student) {
        if ($student['id'] === $id) {
            $student = array_merge($student, $request->all());
            return response()->json($student);
        }
    }
    return response()->json(['message' => 'Student not found'], 404);
});

Route::get('/teachers', function () use (&$teachers) {
    return response()->json($teachers);
});

Route::post('/teachers', function (Request $request) use (&$teachers) {
    foreach ($teachers as $teacher) {
        if ($teacher['id'] === $request->id) {
            return response()->json(['message' => 'Teacher ID already exists'], 400);
        }
    }
    $teachers[] = $request->all();
    return response()->json(end($teachers), 201);
});

Route::delete('/teachers/{id}', function ($id) use (&$teachers) {
    $teachers = array_filter($teachers, fn($t) => $t['id'] !== $id);
    return response()->json(['message' => "Teacher $id deleted"]);
});

Route::patch('/teachers/{id}', function (Request $request, $id) use (&$teachers) {
    foreach ($teachers as &$teacher) {
        if ($teacher['id'] === $id) {
            $teacher = array_merge($teacher, $request->all());
            return response()->json($teacher);
        }
    }
    return response()->json(['message' => 'Teacher not found'], 404);
});

