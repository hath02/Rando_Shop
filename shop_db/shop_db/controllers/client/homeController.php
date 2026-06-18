<?php
    require_once "models/cartModel.php";
    require_once "models/productModel.php";
    require_once "models/categoryModel.php";

class HomeController {

    private $conn;
    private $cart;
    private $product;
    private $category;

    public function __construct($conn){
        
        $this->cart = new Cart($conn);
        $this->product = new Product($conn);
        $this->category = new Category($conn);
    }

    public function index(){
        $products = $this->product->getAll();
        $categories = $this->category->getAll();

        include __DIR__ . "/../../views/client/home/index.php";
    }
}