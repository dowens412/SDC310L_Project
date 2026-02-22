<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/header.php";
?>

<p>
Welcome to the Supplement Store project. Week 4 focuses on applying the
Model-View-Controller (MVC) framework to improve the structure and
maintainability of the application.
</p>

<p>This application now includes:</p>

<ul>
    <li>Separation of concerns using the MVC architectural pattern</li>
    <li>Model classes handling all database interactions</li>
    <li>Controller classes managing user requests and application logic</li>
    <li>View files responsible only for presentation</li>
    <li>Dynamic product catalog pulled from the database</li>
    <li>Add to Cart functionality (CREATE)</li>
    <li>View cart contents (READ)</li>
    <li>Update cart item quantities (UPDATE)</li>
    <li>Remove items from the cart (DELETE)</li>
    <li>Automatic subtotal, tax, shipping, and order total calculations</li>
</ul>

<p>
The application has been refactored to remove direct SQL queries from
public-facing files, resulting in a cleaner and more scalable design.
</p>

<p>
Use the navigation links above to browse products and manage your shopping cart.
</p>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>