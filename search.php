<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$account = $data['account'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $account);
$stmt->execute();

$result = $stmt->get_result();
if ($user = $result->fetch_assoc()) {
    echo json_encode(["status" => "success", "user" => $user]);
} else {
    echo json_encode(["status" => "error", "message" => "User not found."]);
}
?>
