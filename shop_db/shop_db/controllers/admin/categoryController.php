<?php

require_once "models/categoryModel.php";

class AdminCategoryController {

    private $category;

    public function __construct(){

        if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
            header("Location: /shop_db/index.php?action=login");
            exit();
        }

        global $conn;
        $this->category = new Category($conn);
    }

    // list
    public function index(){
        $categories = $this->category->getAll();
        include __DIR__ . "/../../views/admin/category/index.php";
    }

    // create form
    public function create(){
        include __DIR__ . "/../../views/admin/category/create.php";
    }

    // store
    public function store(){

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $name = $_POST['name'] ?? "";
            $description = $_POST['description'] ?? "";
    
            if(!$name){
                echo "Category name required";
                return;
            }
            if(!$description){
                echo "Category description required";
                return;
            }

            $this->category->create($name, $description);

            header("Location: /shop_db/index.php?action=admin_categories");
            exit();
        }
    }

    //search categories
    public function search(){

        $keyword = $_GET['keyword'] ?? '';

        $categories = $this->category->search($keyword);

        include __DIR__ . "/../../views/admin/category/search.php";
    }


    //edit form
    public function edit(){

        $id = $_GET['id'] ?? 0;

        $category = $this->category->getById($id);

        if(!$category){
            echo "Category not found";
            return;
        }

        include __DIR__ . "/../../views/admin/category/edit.php";
    }

    //update
    public function update(){

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? "";
            $description = $_POST['description'] ?? "";
    
            if(!$name){
                echo "Category name required";
                return;
            }
            if(!$description){
                echo "Category description required";
                return;
            }

            $this->category->update($id, $name, $description);

            header("Location: /shop_db/index.php?action=admin_categories");
            exit();
        }
    }

    // delete
    public function delete(){

        $id = $_GET['id'] ?? 0;

        $this->category->delete($id);

        header("Location: /shop_db/index.php?action=admin_categories");
        exit();
    }
}