<?php
// app/Controllers/CatalogController.php

require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Models/CartModel.php';

class CatalogController
{
    private ProductModel $productModel;
    private CartModel $cartModel;

    public function __construct(PDO $pdo)
    {
        $this->productModel = new ProductModel($pdo);
        $this->cartModel = new CartModel($pdo);
    }

    public function index(): array
    {
        return $this->productModel->getAllProducts();
    }

    public function addToCart(int $productId): void
    {
        $this->cartModel->addToCart($productId, 1);
    }
}