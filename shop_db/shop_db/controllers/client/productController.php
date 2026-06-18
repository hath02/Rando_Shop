<?php

require_once "config/database.php";
require_once "models/productModel.php";

class ClientProductController {

    private $product;

    public function __construct(){
        global $conn;
        $this->product = new Product($conn);
    }

    //search products
    public function search(){
        $keyword = $_GET['keyword'] ?? '';
        $products = $this->product->search($keyword);
        include __DIR__ . "/../../views/client/product/search.php";
    }

    // show all products (shop page)
    public function shop(){
        $products = $this->product->getAll();
        $categories = $this->product->getCategories();
        include __DIR__ . "/../../views/client/product/index.php";
    }

    //show products on sale
    public function sales(){
        $products = $this->product->getSaleProducts();
        $categories = $this->product->getCategories();
        include __DIR__ . "/../../views/client/product/sales.php";
    }

    //show products by category
    public function category(){
        $categoryId = $_GET['id'] ?? 0;

        $products = $this->product->getByCategory($categoryId);
        $categories = $this->product->getCategories();

        include __DIR__ . "/../../views/client/product/category.php";
    }

    // product detail
    public function detail(){

        $id = $_GET['id'] ?? 0;
        $product = $this->product->getById($id);
        $categories = $this->product->getCategories();

        if (!$product) {
            echo "Product not found";
            exit();
        }

        include __DIR__ . "/../../views/client/product/details.php";
    }

}