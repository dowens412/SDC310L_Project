<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/header.php";
?>

<p>Welcome to the Supplement Store project. Week 3 focuses on adding full database support using PHP and MySQL.</p>

<p>This application now includes:</p>

<ul>
    <li>Database connection using PDO</li>
    <li>Dynamic product catalog pulled from the database</li>
    <li>Add to Cart functionality (CREATE)</li>
    <li>View cart contents (READ)</li>
    <li>Update cart item quantities (UPDATE)</li>
    <li>Remove items from the cart (DELETE)</li>
    <li>Automatic subtotal, tax, shipping, and total calculations</li>
</ul>

<p>Use the navigation links above to browse products and manage your shopping cart.</p>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
