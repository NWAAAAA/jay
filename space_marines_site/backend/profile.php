<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
$conn = new mysqli("localhost", "root", "", "space_marines_db");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT m.name, m.email, c.name AS chapter FROM marines m JOIN chapters c ON m.chapter_id = c.id WHERE m.email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}
$stmt->close();
$conn->close();
?>