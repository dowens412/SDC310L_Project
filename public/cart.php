<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/header.php";

// =========================
// HANDLE CREATE (Add to Cart)
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {

    $product_id = (int) $_POST['product_id'];
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];

    if ($quantity > 0) {
        $stmt = db()->prepare("
            INSERT INTO cart_items (product_id, quantity, price)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$product_id, $quantity, $price]);
    }
}

// =========================
// HANDLE UPDATE (Change Quantity)
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {

    $update_id = (int) $_POST['update_id'];
    $new_quantity = (int) $_POST['new_quantity'];

    if ($new_quantity > 0) {
        $stmt = db()->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->execute([$new_quantity, $update_id]);
    }
}

// =========================
// HANDLE DELETE (Remove Item)
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {

    $remove_id = (int) $_POST['remove_id'];

    $stmt = db()->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->execute([$remove_id]);
}

// =========================
// FETCH CART ITEMS (READ)
// =========================
$stmt = db()->query("
    SELECT c.id, c.product_id, c.quantity, c.price,
           (c.quantity * c.price) AS line_total,
           p.name
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    ORDER BY c.added_at DESC
");

$cartItems = $stmt->fetchAll();

// =========================
// CALCULATE TOTALS
// =========================
$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['line_total'];
}

$tax = $subtotal * 0.07;
$shipping = $subtotal > 0 ? 5.99 : 0;
$total = $subtotal + $tax + $shipping;
?>

<h2>Shopping Cart</h2>

<?php if (count($cartItems) === 0): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Line Total</th>
            <th>Update</th>
            <th>Remove</th>
        </tr>

        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id']) ?></td>
                <td><?= htmlspecialchars($item['name']) ?></td>

                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="update_id" value="<?= $item['id'] ?>">
                        <input type="number" name="new_quantity" value="<?= $item['quantity'] ?>" min="1" style="width:60px;">
                        <button type="submit">Update</button>
                    </form>
                </td>

                <td>$<?= htmlspecialchars($item['price']) ?></td>
                <td>$<?= number_format($item['line_total'], 2) ?></td>

                <td>
                    <!-- Empty cell for spacing alignment -->
                </td>

                <td>
                    <form method="POST">
                        <input type="hidden" name="remove_id" value="<?= $item['id'] ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Totals</h3>
    <p>Subtotal: $<?= number_format($subtotal, 2) ?></p>
    <p>Tax (7%): $<?= number_format($tax, 2) ?></p>
    <p>Shipping: $<?= number_format($shipping, 2) ?></p>
    <p><strong>Order Total: $<?= number_format($total, 2) ?></strong></p>
<?php endif; ?>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
