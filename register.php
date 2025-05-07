<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$lastname = $data['lastname'];
$age = $data['age'];
$address = $data['address'];
$phone = $data['phone'];
$balance = $data['balance'];

$stmt = $conn->prepare("INSERT INTO users (name, lastname, age, address, phone, balance) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissi", $name, $lastname, $age, $address, $phone, $balance);

if ($stmt->execute()) {
    $accountId = $conn->insert_id;
    echo json_encode(["status" => "success", "account" => str_pad($accountId, 3, "0", STR_PAD_LEFT)]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed."]);
}
?>
