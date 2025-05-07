<?php$servername = "localhost";$username = "username";$password = "password";
try { 
     $dbc = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
     echo "Connected successfully";}catch(PDOException $e)
     {
        echo $e->getMessage(); }?> 
