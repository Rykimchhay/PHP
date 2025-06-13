<?php 


namespace App\Models;

use Illuminate\Support\Facades\DB;

class Student
{
    public static function allStudents() {
        return DB::select("SELECT * FROM students");
    }

    public static function findStudent($id) {
        $result = DB::select("SELECT * FROM students WHERE id = ?", [$id]);
        return $result ? $result[0] : null;
    }

    public static function addStudent($data) {
        return DB::insert(
            "INSERT INTO students (name, age,  grade) VALUES (?, ?, ?)",
            [$data['name'], $data['age'],  $data['grade']]
        );
    }

    public static function updateStudent($id, $data) {
        return DB::update(
            "UPDATE students SET name = ?, age = ?,  grade = ? WHERE id = ?",
            [$data['name'], $data['age'], $data['grade'], $id]
        );
    }

    public static function deleteStudent($id) {
        return DB::delete("DELETE FROM students WHERE id = ?", [$id]);
    }
}