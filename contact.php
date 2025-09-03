<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="img/FAV.jpg" href="img/l.jpg">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            color: #111;
            background-color: #fffaf5;
        }
        .gold-text {
            background: linear-gradient(to right, #f7e9a0, #bfa06b, #a7894f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 5%;
            border-bottom: 1px solid #eee;
        }
        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
        }
        nav a {
            margin-left: 2rem;
            font-weight: 600;
            transition: color 0.3s;
            background: linear-gradient(to right, #f7e9a0, #bfa06b, #a7894f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        nav a:hover {color: #bfa06b;}
        .container {
            padding: 5% 5%;
            text-align: center;
        }
        .contact-info {
            font-size: 1.2rem;
            margin-top: 2rem;
        }
        footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 5%;
            border-top: 1px solid #eee;
            font-size: 0.9rem;
            color: white;
        }
        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        iframe {
            width: 100%;
            height: 400px;
            border: 0;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
<video class="video-bg" autoplay muted loop>
    <source src="img/fa.mp4" type="video/mp4">
</video>
<header>
    <h1 class="gold-text">Contact Us</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<div class="container">
    <div class="contact-info gold-text">
        <p>Phone: +971 4 123 4567</p>
        <p>Email: contact@luxuryemporium.com</p>
    </div>
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3609.279086488482!2d55.27078231501064!3d25.20484998389614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f434d0f4d0f0b%3A0x4b0f4b0f4b0f4b0f!2sDubai%20Mall!5e0!3m2!1sen!2sae!4v1633072800000!5m2!1sen!2sae"
        allowfullscreen=""
        loading="lazy">
    </iframe>
</div>
<footer>
    &copy; 2025 Luxury Emporium. All rights reserved.
</footer>
</body>
</html>