<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
      $ID = $_POST['ID'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $balance = $_POST['balance'];
        
        $sql = "INSERT INTO system (ID,name, lastname, age, address, phone, balance) 
                VALUES (  '$ID' ,'$name', '$lastname', '$age', '$address', '$phone', '$balance')";
                
        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    if (isset($_POST['search'])) {
        $account = $_POST['account'];
        $sql = "SELECT * FROM system WHERE id = '$account'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "User Found: " . $row['name'] . " " . $row['lastname'] . " Age: " . $row['age'] . 
                     " Address: " . $row['address'] . " Phone: " . $row['phone'] . 
                     " Balance: " . $row['balance'];
            }
        } else {
            echo "No user found with that account number.";
        }
    }
    if (isset($_POST['delete'])) {
        $account = $_POST['account'];
        $sql = "DELETE FROM system WHERE id = '$account'";
        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Banking System</title>

    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;   
        margin: 0;
      }

      header {
        background-color: #007bff;
        color: white;
        padding: 20px;
        text-align: center;
        display: flex;
        align-items: center;
        width: 100%;
      }
      header img {
        height: 100px;
        width: 200px;
        margin-right: 10px;
      }

      .admin-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        width: 400px;
        margin-top: 60px;
      }

      h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      .form-container {
        margin-bottom: 20px;
        display: none;
      }

      .form-container h3 {
        font-size: 16px;
        margin-bottom: 10px;
      }

      .form-container input {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        margin-bottom: 10px;
      }

      .form-container button {
        padding: 12px;
        font-size: 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
      }

      .form-container button:hover {
        background-color: #348f74;
      }
      #submit{
        padding: 15px 30px;
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        border: none;
        border-radius: 25px;
        margin: 10px;
        font-size: 18px;
        cursor: pointer;


      }

      .error-message {
        color: red;
        font-size: 14px;
        text-align: center;
        margin-top: 10px;
      }

      footer p {
        font-size: 14px;
        text-align: center;
      }

      footer {
        background-color: #007bff;
        color: white;
        padding: 0px 0;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
      }

      #button-container button {
        padding: 15px 30px;
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        border: none;
        border-radius: 25px;
        margin: 10px;
        font-size: 18px;
        cursor: pointer;
      }

      #button-container button:hover {
        background: linear-gradient(45deg, #0056b3, #003366);
        transform: translateY(-4px);
      }
    </style>
  </head>
  <body>
    <header>
      <img src="images/CBE logo.jfif" />
      <h1>Welcome to Commercial Bank of Ethiopia</h1>
    </header>

    <div id="button-container" style="margin-top: 20px; text-align: center">
      <h2 style="color: blueviolet">The bank that always relies on!</h2>
      <button onclick="showForm('register-form')">Register User</button>
      <button onclick="showForm('search-form')">Search User</button>
      <button onclick="showForm('delete-form')">Delete User</button>
    </div>

    <div class="admin-container">
      <form id="register-form" class="form-container" method="POST" action="">
        <h3>Register New User</h3>
        <input type="number" name="ID" id="reg-name" placeholder="enter the ID" required />
        <input type="text" name="name" id="reg-name" placeholder="First Name" required />
        <input type="text" name="lastname" id="reg-lastname" placeholder="Last Name" required />
        <input type="number" name="age" id="reg-age" placeholder="Age" required />
        <input type="text" name="address" id="reg-address" placeholder="Address" required />
        <input type="text" name="phone" id="reg-phone" placeholder="Phone Number" required />
        <input type="number" name="balance" id="reg-balance" placeholder="Initial Balance" required />
        <input type="submit" class="submit" name="register" value="Register User" />
        <button type="button" onclick="backToMenu()">Back</button>
      </form>

      <form id="search-form" class="form-container" method="POST" action="">
        <h3>Search User by Account</h3>
        <input type="text" name="account" id="search-account" placeholder="Enter Account Number" required />
        <input type="submit" class="submit" name="search" value="Search User" />
        <button type="button" onclick="backToMenu()">Back</button>
        <p id="search-result"></p>
      </form>

      <form id="delete-form" class="form-container" method="POST" action="">
        <h3>Delete User by Account</h3>
        <input type="text" name="account" id="delete-account" placeholder="Enter Account Number" required />
        <input type="submit" class="submit" name="delete" value="Delete User" />
        <button type="button" onclick="backToMenu()">Back</button>
        <p id="delete-result"></p>
      </form>

      <p id="error-message" class="error-message"></p>
    </div>
    <footer>
      <p>&copy; 2025 Commercial Bank of Ethiopia. All rights reserved.</p>
    </footer>

    <script>
      let users = [
        { account: "001", name: "John", lastname: "Doe", age: 30, address: "123 Main St", phone: "123-456-7890", balance: 1000 },
      ];

      function showForm(formId) {
        document.getElementById("button-container").style.display = "none";
        document.querySelectorAll(".form-container").forEach((form) => form.style.display = "none");
        document.getElementById(formId).style.display = "block";
      }

      function backToMenu() {
        document.getElementById("button-container").style.display = "block";
        document.querySelectorAll(".form-container").forEach((form) => form.style.display = "none");
      }

      function registerUser() {
        const name = document.getElementById("reg-name").value.trim();
        const lastname = document.getElementById("reg-lastname").value.trim();
        const age = document.getElementById("reg-age").value.trim();
        const address = document.getElementById("reg-address").value.trim();
        const phone = document.getElementById("reg-phone").value.trim();
        const balance = document.getElementById("reg-balance").value.trim();

        if (!name || !lastname || !age || !address || !phone || !balance) {
          alert("Please fill out all fields!");
          return;
        }

        const account = "00" + (users.length + 1).toString().padStart(3, "0");
        users.push({ account, name, lastname, age, address, phone, balance: parseFloat(balance) });

        alert(`User registered with account number: ${account}`);
        backToMenu();
      }

      function searchUser() {
        const account = document.getElementById("search-account").value.trim();
        const resultText = document.getElementById("search-result");

        if (!account) {
          resultText.textContent = "Please enter an account number!";
          return;
        }

        const user = users.find((user) => user.account === account);

        if (user) {
          resultText.textContent = `Found User: ${user.name} ${user.lastname}, Age: ${user.age}, Address: ${user.address}, Phone: ${user.phone}, Balance: $${user.balance}`;
        } else {
          resultText.textContent = "No user found with that account number.";
        }
      }

      function deleteUser() {
        const account = document.getElementById("delete-account").value.trim();
        const resultText = document.getElementById("delete-result");

        if (!account) {
          resultText.textContent = "Please enter an account number!";
          return;
        }

        const index = users.findIndex((user) => user.account === account);

        if (index !== -1) {
          users.splice(index, 1);
          resultText.textContent = `User with account number ${account} has been deleted.`;
        } else {
          resultText.textContent = "No user found with that account number.";
        }
        document.getElementById("delete-account").value = "";
      }
    </script>
  </body>
</html>
