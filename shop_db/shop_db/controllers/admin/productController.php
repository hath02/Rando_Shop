<?php

require_once "models/productModel.php";
require_once "models/categoryModel.php";

class AdminProductController {

    private $product;
    private $category;

    public function __construct(){

        // check admin
        if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
            header("Location: /shop_db/index.php?action=login");
            exit();
        }

        global $conn;
        $this->product = new Product($conn);
        $this->category = new Category($conn);
    }

    // list products
    public function index(){
        $products = $this->product->getAll();
        include "views/admin/product/index.php";
    }

    //search product
    public function search(){
        $keyword = $_GET['keyword'] ?? '';
        $products = $this->product->search($keyword);

        include __DIR__ . "/../../views/admin/product/search.php";
    }

    //view product
    public function view() {
         $id = $_GET['id'] ?? 0;
        $product = $this->product->getById($id);

        if (!$product) {
            echo "Product not found";
            exit();
        }

        include __DIR__ . "/../../views/admin/product/details.php";
    }

    // create form
    public function create(){
        $categories = $this->category->getAll();
        include "views/admin/product/create.php";
    }
    
    // create new product
    public function store(){

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $name = $_POST['name'] ?? "";
            $description = $_POST['description'] ?? "";
            $price = (int)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $category_id = (int)($_POST['category_id'] ?? 0);

            // handle image upload
            $imageName = "";
            if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){

                $imageName = time() . "_" . basename($_FILES['image']['name']);
                $targetDir = __DIR__ . "/../../public/uploads/";

                if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName)){
                    echo "Failed to upload image!";
                    exit();
                }
            }

            $on_sale = isset($_POST['on_sale']) ? (int)$_POST['on_sale'] : 0;
            $sale_price = isset($_POST['sale_price']) ? (float)$_POST['sale_price'] : 0;
            
            $this->product->create(
                $name, 
                $description, 
                $price, 
                $stock, 
                $category_id, 
                $imageName,
                $on_sale,
                $sale_price);

            header("Location: /shop_db/index.php?action=admin_products");
            exit();
        }
    }

    // edit form
    public function edit(){
        $id = $_GET['id'] ?? null;
        if(!$id){
            header("Location: /shop_db/index.php?action=admin_products");
            exit();
        }

        $product = $this->product->getById($id);
        if(!$product){
            header("Location: /shop_db/index.php?action=admin_products");
            exit();
        }

        $categories = $this->category->getAll();
        include "views/admin/product/edit.php";
    }

    // update product
    public function update(){

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $id = $_POST['id'] ?? null;
            if(!$id){
                header("Location: /shop_db/index.php?action=admin_products");
                exit();
            }

            $product = $this->product->getById($id);
            if(!$product){
                header("Location: /shop_db/index.php?action=admin_products");
                exit();
            }

            $name = $_POST['name'] ?? "";
            $description = $_POST['description'] ?? "";
            $price = (int)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $category_id = (int)($_POST['category_id'] ?? 0);

            // keep current image unless a new file is uploaded
            $imageName = $product['image'] ?? "";

            if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
                $imageName = time() . "_" . basename($_FILES['image']['name']);
                $targetDir = __DIR__ . "/../../public/uploads/";

                if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName)){
                    echo "Failed to upload image!";
                    exit();
                }
            }

            $on_sale = isset($_POST['on_sale']) ? (int)$_POST['on_sale'] : 0;
            $sale_price = isset($_POST['sale_price']) ? (float)$_POST['sale_price'] : 0;

            $this->product->update(
                $id, 
                $name, 
                $description, 
                $price, 
                $stock, 
                $category_id,     
                $imageName,
                $on_sale,
                $sale_price);

            header("Location: /shop_db/index.php?action=admin_products");
            exit();
        }
    }

    // delete product
    public function delete(){

        $id = $_GET['id'] ?? null;
        if(!$id){
            header("Location: /shop_db/index.php?action=admin_products");
            exit();
        }

        $this->product->delete((int)$id);

        header("Location: /shop_db/index.php?action=admin_products");
        exit();
    }
}