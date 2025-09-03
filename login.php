<?php
session_start();
$db = new SQLite3('eshop.db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['login-username'];
    $pass = $_POST['login-password'];

    $stmt = $db->prepare('SELECT password FROM users WHERE username = :username');
    $stmt->bindValue(':username', $user, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user;
            header("Location: index.php");
            exit();
        } else {
            header("Location: index.html?login_error=Invalid password.");
        }
    } else {
        header("Location: index.html?login_error=No user found.");
    }
    exit();
}

$db->close();
?>