<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../app/Controllers/CatalogController.php";


$pdo = db();

$controller = new CatalogController($pdo);

// Handle Add to Cart
if (isset($_GET['add'])) {
    $productId = (int)$_GET['add'];
    $controller->addToCart($productId);
    header("Location: catalog.php");
    exit;
}

$products = $controller->index();

require_once __DIR__ . "/../includes/header.php";
?>

<h2>Product Catalog</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Add</th>
    </tr>

    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['description']) ?></td>
            <td>$<?= number_format($product['price'], 2) ?></td>
            <td>
                <a href="catalog.php?add=<?= $product['id'] ?>">
                    Add to Cart
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="cart.php">Go to Cart</a>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>