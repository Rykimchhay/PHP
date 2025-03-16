<?php
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data["action"] === "add") {
        $id = count($_SESSION['students']) + 1;
        $_SESSION['students'][] = ["id" => $id, "name" => $data["name"], "age" => $data["age"], "email" => $data["email"]];
    } elseif ($data["action"] === "edit") {
        foreach ($_SESSION['students'] as &$student) {
            if ($student["id"] == $data["id"]) {
                $student["name"] = $data["name"];
                $student["age"] = $data["age"];
                $student["email"] = $data["email"];
                break;
            }
        }
    } elseif ($data["action"] === "delete") {
        $_SESSION['students'] = array_values(array_filter($_SESSION['students'], fn($student) => $student["id"] != $data["id"]));
    }

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode($_SESSION['students']);
}
?>