<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$cart = $_SESSION['cart'] ?? [];

$products = [
    "Lapis Lazuli (Ultramarine)" => 20000,
    "Tyrian Purple" => 10000,
    "Vantablack" => 400,
    "Phthalo Blue" => 1000,
    "Cadmium Red" => 200,
    "Cochineal Red" => 800,
    "Indian Yellow" => 300,
    "Cobalt Blue" => 400,
    "Emerald Green" => 150
];

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="img/FAV.jpg" href="img/l.jpg">
    <style>
        /* Reset & base */
        * {margin:0; padding:0; box-sizing:border-box;}
        body {
            font-family: 'Montserrat', sans-serif;
            color: #111;
            background-color: #fffaf5;
        }
        a {text-decoration: none; color: inherit;}

        /* Gradient gold text */
        .gold-text {
            background: linear-gradient(to right, #f7e9a0, #bfa06b, #a7894f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Header */
        header {
            color: #fff;
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

        /* Container */
        .container {
            padding: 5% 5%;
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            color: white;
        }

        /* Video Background */
        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Button */
        .button {
            padding: 0.5rem 1rem;
            background: #bfa06b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .button:hover {
            background: #a7894f;
        }

        /* Footer */
        footer {
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 5%;
            border-top: 1px solid #eee;
            font-size: 0.9rem;
        }

        /* List */
        ul { list-style: none; margin-top: 1rem; }
        li { padding: 0.5rem 0; font-size: 1.1rem; }

        /* Total price */
        .total-price { 
            text-align: right; 
            font-size: 1.3rem; 
            font-weight: bold; 
            margin-top: 1rem;
        }

        /* Form labels & inputs */
        label { display: block; margin: 0.5rem 0 0.2rem; }
        input, select { width: 100%; padding: 0.5rem; margin-bottom: 1rem; border-radius: 6px; border: 1px solid #ccc; }

    </style>
</head>
<body>
<video class="video-bg" autoplay muted loop>
    <source src="img/fa.mp4" type="video/mp4">
</video>
<header>
    <h1 class="gold-text">Checkout</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<div class="container">
    <h2 class="gold-text">Your Cart</h2>
    <ul>
        <?php foreach ($cart as $item): 
            $price = $products[$item] ?? 0;
            $total_price += $price;
        ?>
            <li>Paint <?php echo $item; ?> - $<?php echo number_format($price); ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="total-price">Total: $<?php echo number_format($total_price); ?></div>

    <h2 class="gold-text">Delivery Information</h2>
    <form action="payment.php" method="post">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
        </select>

        <button type="submit" class="button">Pay Now</button>
    </form>
</div>
<footer>
    &copy; 2025 Luxury Emporium. All rights reserved.
</footer>
</body>
</html>
