<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];
    if (!in_array($product_name, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_name;
    }
}

// Handle remove from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product'])) {
    $product_name = $_POST['remove_product'];
    $key = array_search($product_name, $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Emporium</title>
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

        /* Colored emoji */
        .color-emoji {
            display: inline-block;
            margin-right: 0.5rem;
            font-size: 1.5rem;
            vertical-align: middle;
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

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80vh;
            background: url('https://images.unsplash.com/photo-1600185366721-0f33bb8e55b6?auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            color: white;
            text-align: center;
        }
        .hero h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        .hero p {
            font-size: 1.2rem;
            text-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        /* Product List */
        .products {
            padding: 5% 5%;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .product-card {
            text-align: center;
        }

        .product-img {
            width: 600px;
            height: 600px;
            object-fit: cover;
            border-radius: 600px;
        }
        .product-card {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .product-card .info {
            padding: 1.5rem;
            text-align: left;
            width: 50%;
        }
        .product-card .info h3 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        .product-card .info p {
            color: #777;
            margin-bottom: 1rem;
        }
        .product-card .info span {
            font-weight: 700;
            font-size: 1.2rem;
        }
        .product-card .info button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: #bfa06b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .product-card .info button:hover {
            background: #a7894f;
        }

        /* Footer */
        footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 5%;
            border-top: 1px solid #eee;
            color: white;
            font-size: 0.9rem;
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

        /* Cart Styles */
        .cart-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-info {
            flex-grow: 1;
        }

        .cart-item-price {
            font-weight: bold;
            color: #bfa06b;
        }

        .remove-btn {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .remove-btn:hover {
            background: #cc0000;
        }

        .total-price {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #eee;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: right;
        }

        .checkout-btn {
            margin-top: 2rem;
            padding: 1rem 2rem;
            background: #bfa06b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.3s;
            display: block;
            margin-left: auto;
        }

        .checkout-btn:hover {
            background: #a7894f;
        }
        
        /* Add to cart form */
        .add-to-cart {
            display: inline-block;
        }
        
        /* Contact Page Styles */
        .contact-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .contact-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #bfa06b;
        }
        
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .contact-item {
            flex: 1 1 200px;
            text-align: center;
        }
        
        .contact-item i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #bfa06b;
        }
        
        .map-container {
            height: 300px;
            margin: 2rem 0;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
<video class="video-bg" autoplay muted loop>
    <source src="img/fa.mp4" type="video/mp4">
</video>
<header>
    <h1 class="gold-text">Luxury Emporium</h1>
    <nav>
        <a href="#">Home</a>
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<section class="hero">
    <div>
        <h2 class="gold-text">World's Rarest Colors</h2>
        <p>Discover the top most exquisite colors money can buy.</p>
    </div>
</section>

<section class="products">
    <?php
    $products = [
        ["name" => "Lapis Lazuli (Ultramarine)", "price" => 20000, "description" => "Historically the most expensive pigment, made from the semi-precious stone lapis lazuli.", "image" => "/img/u.png", "emoji" => "🟦"],
        ["name" => "Tyrian Purple", "price" => 10000, "description" => "Ancient purple obtained from sea snails.", "image" => "/img/t.png", "emoji" => "🟪"],
        ["name" => "Vantablack", "price" => 400, "description" => "The blackest color in the world.", "image" => "/img/v.png", "emoji" => "⚫"],
        ["name" => "Phthalo Blue", "price" => 1000, "description" => "Intense blue used in the 20th century.", "image" => "/img/p.png", "emoji" => "🔵"],
        ["name" => "Cadmium Red", "price" => 200, "description" => "Bright, toxic pigments.", "image" => "/img/c.jpg", "emoji" => "🟥"],
        ["name" => "Cochineal Red", "price" => 800, "description" => "Obtained from cochineal insects.", "image" => "/img/co.png", "emoji" => "🟥"],
        ["name" => "Indian Yellow", "price" => 300, "description" => "Obtained from dried cow urine.", "image" => "/img/i.png", "emoji" => "🟨"],
        ["name" => "Cobalt Blue", "price" => 400, "description" => "Intense blue pigment.", "image" => "/img/b.jpg", "emoji" => "🔵"],
        ["name" => "Emerald Green", "price" => 150, "description" => "Contains arsenic, extremely toxic.", "image" => "/img/z.jpg", "emoji" => "🟩"]
    ];

    foreach ($products as $product): 
        $in_cart = in_array($product['name'], $_SESSION['cart']);
    ?>
        <div class="product-card">
            <img class="product-img" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <div class="info">
                <h3>
                    <span class="color-emoji"><?php echo $product['emoji']; ?></span>
                    <span class="gold-text"><?php echo $product['name']; ?></span>
                </h3>
                <p><?php echo $product['description']; ?></p>
                <span class="gold-text">$<?php echo number_format($product['price']); ?></span>
                <form action="" method="post" class="add-to-cart">
                    <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                    <?php if ($in_cart): ?>
                        <button type="submit" name="remove_product" value="<?php echo $product['name']; ?>" style="background:#ff4d4d;">Remove from Cart</button>
                    <?php else: ?>
                        <button type="submit">Add to Cart</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<footer>
    &copy; 2025 Luxury Emporium. All rights reserved.
</footer>

</body>
</html>

<?php
// Display cart contents
if (isset($_GET['view_cart'])) {
    echo '<div class="cart-container">';
    echo '<h2>Your Shopping Cart</h2>';
    
    if (empty($_SESSION['cart'])) {
        echo '<p>Your cart is empty.</p>';
    } else {
        $total_price = 0;
        foreach ($_SESSION['cart'] as $item) {
            // Find product details
            $product_details = null;
            foreach ($products as $product) {
                if ($product['name'] == $item) {
                    $product_details = $product;
                    break;
                }
            }
            
            if ($product_details) {
                $total_price += $product_details['price'];
                echo '<div class="cart-item">';
                echo '<div class="cart-item-info">';
                echo '<span class="color-emoji">' . $product_details['emoji'] . '</span>';
                echo '<span>' . $product_details['name'] . '</span>';
                echo '</div>';
                echo '<div class="cart-item-price">' . number_format($product_details['price']) . '</div>';
                echo '<form method="post" style="display:inline;">';
                echo '<input type="hidden" name="remove_product" value="' . $item . '">';
                echo '<button type="submit" class="remove-btn">Remove</button>';
                echo '</form>';
                echo '</div>';
            }
        }
        
        echo '<div class="total-price">Total: $' . number_format($total_price) . '</div>';
        echo '<form action="checkout.php" method="post">';
        echo '<button type="submit" class="checkout-btn">Continue to Checkout</button>';
        echo '</form>';
    }
    
    echo '</div>';
}
?>

<?php
// Contact page content
if (basename($_SERVER['PHP_SELF']) == 'contact.php') {
    echo '
    <div class="contact-container">
        <h2>Contact Us</h2>
        <div class="contact-info">
            <div class="contact-item">
                <i>📧</i>
                <h3>Email</h3>
                <p>contact@luxuryemporium.com</p>
            </div>
            <div class="contact-item">
                <i>📞</i>
                <h3>Phone</h3>
                <p>+971 50 123 4567</p>
            </div>
            <div class="contact-item">
                <i>📍</i>
                <h3>Address</h3>
                <p>Palm Jebel Ali, Dubai, United Arab Emirates</p>
            </div>
        </div>
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3609.279086488482!2d54.86514431501064!3d24.98484998389614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f5c4d0f4d0f0b%3A0x4b0f4b0f4b0f4b0f!2sPalm%20Jebel%20Ali!5e0!3m2!1sen!2sae!4v1633072800000!5m2!1sen!2sae" allowfullscreen="" loading="lazy"></iframe>
        </div>
        
        <p style="text-align:center; margin-top:2rem;">
            We are located at Palm Jebel Ali, Dubai, United Arab Emirates. 
            Our luxury emporium offers the rarest and most exquisite colors in the world.
        </p>
    </div>';
}
?>
