<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/eshop.db'); // cesta k databáze
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
