<?php
// app/Controllers/CartController.php

require_once __DIR__ . '/../Models/CartModel.php';

class CartController
{
    private CartModel $cartModel;

    public function __construct(PDO $pdo)
    {
        $this->cartModel = new CartModel($pdo);
    }

    public function index(): array
    {
        return $this->cartModel->getCartItems();
    }

    public function updateQuantity(int $productId, int $qty): void
    {
        $this->cartModel->updateQuantity($productId, $qty);
    }

    public function remove(int $productId): void
    {
        $this->cartModel->removeFromCart($productId);
    }

    public function clear(): void
    {
        $this->cartModel->clearCart();
    }

    public function totals(): array
    {
        return $this->cartModel->getTotals();
    }
}