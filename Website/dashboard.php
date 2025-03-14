<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $password_hash);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $password_hash)) {
        $_SESSION["user"] = $username;
        echo "Welcome, " . $_SESSION["user"] . "! <a href='logout.php'>Logout</a>";
    } else {
        echo "Invalid credentials. <a href='login.html'>Try again</a>";
    }
}
?>
