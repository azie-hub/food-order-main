<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$account = $data['account'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $account);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "User deleted."]);
} else {
    echo json_encode(["status" => "error", "message" => "User not found."]);
}
?>
