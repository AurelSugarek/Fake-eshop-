<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$db = new SQLite3('eshop.db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkStmt = $db->prepare('SELECT username FROM users WHERE username = :username');
    $checkStmt->bindValue(':username', $user, SQLITE3_TEXT);
    $checkResult = $checkStmt->execute();

    if ($checkResult->fetchArray(SQLITE3_ASSOC)) {
        // Username already exists
        header("Location: index.html?register_error=Username already exists. Please log in.");
        exit();
    }

    // Insert new user
    $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stmt->bindValue(':username', $user, SQLITE3_TEXT);
    $stmt->bindValue(':password', $pass, SQLITE3_TEXT);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: index.html?register_error=User registration failed.");
        exit();
    }
}

$db->close();
?>