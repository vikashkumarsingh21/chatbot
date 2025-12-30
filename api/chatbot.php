<?php
include "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$sql = "INSERT INTO parent_chat
(first_name, middle_name, last_name, email, phone,
 child_name, child_age, child_gender, parent_query)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssssiss",
    $data['first_name'],
    $data['middle_name'],
    $data['last_name'],
    $data['email'],
    $data['phone'],
    $data['child_name'],
    $data['child_age'],
    $data['child_gender'],
    $data['parent_query']
);

if (!$stmt->execute()) {
    if ($conn->errno == 1062) {
        echo json_encode([
            "status" => "error",
            "message" => "This child is already registered."
        ]);
        exit;
    }
}

echo json_encode(["status" => "success"]);
