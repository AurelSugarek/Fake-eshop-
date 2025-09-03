<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$product_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Product Details</h1>
        <a href="logout.php">Logout</a>
    </header>
    <div class="container">
        <h2>Paint <?php echo $product_id; ?></h2>
        <p>Description of Paint <?php echo $product_id; ?>. This is one of the most exclusive paints available.</p>
        <p>Price: $<?php echo $product_id * 1000; ?></p>
        <form action="cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</body>
</html>