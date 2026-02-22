<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../app/Controllers/CartController.php";

$pdo = db();
$controller = new CartController($pdo);

// =========================
// HANDLE UPDATE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $update_id = (int) $_POST['update_id'];
    $new_quantity = (int) $_POST['new_quantity'];

    $controller->updateQuantity($update_id, $new_quantity);
    header("Location: cart.php");
    exit;
}

// =========================
// HANDLE REMOVE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $remove_id = (int) $_POST['remove_id'];

    $controller->remove($remove_id);
    header("Location: cart.php");
    exit;
}

// =========================
// FETCH DATA FROM CONTROLLER
// =========================
$cartItems = $controller->index();
$totals = $controller->totals();

require_once __DIR__ . "/../includes/header.php";
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

                <td></td>

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
    <p>Subtotal: $<?= number_format($totals['subtotal'], 2) ?></p>
    <p>Tax (7%): $<?= number_format($totals['tax'], 2) ?></p>
    <p>Shipping: $<?= number_format($totals['shipping'], 2) ?></p>
    <p><strong>Order Total: $<?= number_format($totals['total'], 2) ?></strong></p>
<?php endif; ?>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>