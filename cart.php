<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// Handle remove from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product'])) {
    $remove_product = $_POST['remove_product'];
    if (($key = array_search($remove_product, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

// Calculate total price
$total_price = 0;
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

foreach ($_SESSION['cart'] as $product_name) {
    $total_price += $products[$product_name];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="img/FAV.jpg" href="img/l.jpg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        /* Cart Section */
        .container {
            padding: 5% 5%;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .cart-item h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
        }
        .cart-item button {
            padding: 0.5rem 1rem;
            background: #bfa06b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .cart-item button:hover {
            background: #a7894f;
        }
        .total-price {
            text-align: right;
            font-size: 1.5rem;
            margin-top: 2rem;
        }
        .checkout-button {
            display: block;
            margin: 2rem auto;
            padding: 0.5rem 2rem;
            background: #bfa06b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .checkout-button:hover {
            background: #a7894f;
        }

        /* Empty Cart Message */
        .empty-cart-message {
            color: white;
            text-align: center;
            margin-top: 2rem;
            font-size: 1.2rem;
        }

        /* Footer */
        footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 5%;
            border-top: 1px solid #eee;
            font-size: 0.9rem;
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
        .cart-item h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: white; /* pridaj toto */
}

.total-price {
    text-align: right;
    font-size: 1.5rem;
    margin-top: 2rem;
    color: white; /* pridaj toto */
}

.empty-cart-message {
    color: white; /* už tam je */
}

    </style>
</head>
<body>
<header>
    <h1 class="gold-text">Your Cart</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<video class="video-bg" autoplay muted loop>
        <source src="img/fa.mp4" type="video/mp4">
    </video>
<div class="container">
    <?php if (!empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <div class="cart-item">
                <h3><?php echo $item; ?></h3>
                <form action="" method="post" class="remove-from-cart" style="display:inline;">
                    <input type="hidden" name="remove_product" value="<?php echo $item; ?>">
                    <button type="submit">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>
        <div class="total-price">
            <strong>Total Price: $<?php echo number_format($total_price); ?></strong>
        </div>
        <form action="checkout.php" method="post">
            <button type="submit" class="checkout-button">Continue to Checkout</button>
        </form>
    <?php else: ?>
        <p class="empty-cart-message">Your cart is empty.</p>
    <?php endif; ?>
</div>
<footer>
    &copy; 2025 Luxury Emporium. All rights reserved.
</footer>
<script>
$(document).ready(function() {
    // Handle Add to Cart
    $('form.add-to-cart').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Update the cart UI or show a success message
                alert('Product added to cart!');
            }
        });
    });

    // Handle Remove from Cart
    $('form.remove-from-cart').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Update the cart UI or show a success message
                form.closest('.cart-item').remove();
                alert('Product removed from cart!');
            }
        });
    });
});
</script>
</body>
</html>
