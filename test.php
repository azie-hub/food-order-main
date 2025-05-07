<?php
// insert.php

// 1. Connect to database
$host = "localhost";
$dbname = "log";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

// 2. Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Get data from form
$name     = $_POST['name'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$age      = $_POST['age'] ?? '';
$address  = $_POST['address'] ?? '';
$phone    = $_POST['phone'] ?? '';
$balance  = $_POST['balance'] ?? 0;

// 4. Generate account number
$account = "00" . str_pad(rand(1, 999), 3, "0", STR_PAD_LEFT);

// 5. Insert data into table
$stmt = $conn->prepare("INSERT INTO users (account, name, lastname, age, address, phone, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssd", $account, $name, $lastname, $age, $address, $phone, $balance);

if ($stmt->execute()) {
    echo "✅ User registered successfully. Account No: " . $account;
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
