<?php
// app/Models/CartModel.php

class CartModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCartItems(): array
    {
        $sql = "
            SELECT c.id,
                   c.product_id,
                   c.quantity,
                   c.price,
                   (c.quantity * c.price) AS line_total,
                   p.name
            FROM cart_items c
            JOIN products p ON c.product_id = p.id
            ORDER BY c.id DESC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function addToCart(int $productId, int $qty = 1): void
    {
        if ($qty <= 0) return;

        // Get product price from products table
        $stmt = $this->pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if (!$product) return;

        $price = $product['price'];

        $insert = $this->pdo->prepare("
            INSERT INTO cart_items (product_id, quantity, price)
            VALUES (?, ?, ?)
        ");

        $insert->execute([$productId, $qty, $price]);
    }

    public function updateQuantity(int $id, int $qty): void
    {
        if ($qty <= 0) return;

        $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->execute([$qty, $id]);
    }

    public function removeFromCart(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function clearCart(): void
    {
        $this->pdo->exec("DELETE FROM cart_items");
    }

    public function getTotals(): array
    {
        $items = $this->getCartItems();

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['line_total'];
        }

        $tax = $subtotal * 0.07;
        $shipping = $subtotal > 0 ? 5.99 : 0;
        $total = $subtotal + $tax + $shipping;

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total
        ];
    }
}