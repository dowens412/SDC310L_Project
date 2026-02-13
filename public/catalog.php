<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/header.php";

// Fetch all products from database
$stmt = db()->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<h2>Catalog</h2>

<?php if (count($products) === 0): ?>
    <p>No products found in database.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Add</th>
    </tr>

    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['description']) ?></td>
            <td>$<?= htmlspecialchars($product['price']) ?></td>
            <td><?= htmlspecialchars($product['stock']) ?></td>
            <td>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="price" value="<?= $product['price'] ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
