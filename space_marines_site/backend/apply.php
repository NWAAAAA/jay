<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$conn = new mysqli("localhost", "root", "", "space_marines_db");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}
$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$chapter = $data['chapter'];

$stmt = $conn->prepare("SELECT id FROM chapters WHERE name = ?");
$stmt->bind_param("s", $chapter);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO chapters (name) VALUES (?)");
    $stmt->bind_param("s", $chapter);
    $stmt->execute();
    $chapter_id = $stmt->insert_id;
} else {
    $chapter_id = $result->fetch_assoc()['id'];
}

$stmt = $conn->prepare("INSERT INTO marines (name, email, password, chapter_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $email, $password, $chapter_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Application successful."]);
} else {
    echo json_encode(["success" => false, "message" => "Error: Email may already be used."]);
}
$conn->close();
?>