<?php
// Database connection
$host = "localhost";
$dbname = "log";
$username = "root";  // Change this if you have a different MySQL username
$password = "";      // Change this if you have a MySQL password

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['role']) && $_POST['role'] === 'user') {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user'] = $user;
            header("Location: user.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
        $stmt->close();
    } elseif (isset($_POST['role']) && $_POST['role'] === 'admin') {
        $account = $_POST['account'];
        $pass = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $account, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $account;
            header("Location: javascript/admin.php");
            exit();
        } else {
            $error = "Incorrect account ID or password.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        button, .login-button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        button:hover, .login-button:hover {
            background-color: #0056b3;
        }
        .login-container {
            display: none;
        }
        .login-container.active {
            display: block;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Banking System</h1>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <div id="role-selection">
            <button type="button" onclick="showLoginForm('user')">User Login</button>
            <button type="button" onclick="showLoginForm('admin')">Admin Login</button>
        </div>
        
        <div id="user-login" class="login-container">
            <h2>User Login</h2>
            <form method="POST">
                <input type="hidden" name="role" value="user">
                <div class="input-group">
                    <label for="user-username">Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label for="user-password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
        
        <div id="admin-login" class="login-container">
            <h2>Admin Login</h2>
            <form method="POST">
                <input type="hidden" name="role" value="admin">
                <div class="input-group">
                    <label for="admin-account">Account ID:</label>
                    <input type="text" name="account" required>
                </div>
                <div class="input-group">
                    <label for="admin-password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>
    
    <script>
        const users = {
       username: "azanaw",
       password: "password123",
      };

      const admins = [
        { account: "admin1", password: "password1" },
      ];

        function showLoginForm(role) {
            document.getElementById("role-selection").style.display = "none";
            document.getElementById("user-login").classList.remove("active");
            document.getElementById("admin-login").classList.remove("active");

            if (role === "user") {
                document.getElementById("user-login").classList.add("active");
            } else if (role === "admin") {
                document.getElementById("admin-login").classList.add("active");
            }
        }
        function loginAdmin(event) {
        event.preventDefault();
        const account = document.getElementById("admin-account").value;
        const password = document.getElementById("admin-password").value;
        const errorMessage = document.getElementById("admin-error-message");
        errorMessage.textContent = "";

        const admin = admins.find(
          (admin) => admin.account === account && admin.password === password
        );

        if (admin) {
          alert(`Welcome, ${account}! You are now logged in.`);
          window.location.href = "admin.php"; // Redirect to admin page
        } else {
          errorMessage.textContent = "Incorrect account ID or password.";
        }
      }
    </script>
</body>
</html>
