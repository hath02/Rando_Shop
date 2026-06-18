<?php
require_once "models/accountModel.php";
require_once "models/productModel.php";
require_once "models/categoryModel.php";

class AdminDashboardController {

    public function __construct(){
        //safe check session
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // check admin
        if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
            header("Location: index.php?action=login");
            exit();
        }
    }

    public function index(){
        global $conn;

        $accountModel = new Account($conn);
        $productModel = new Product($conn);
        $categoryModel = new Category($conn);

        $totalAccounts = mysqli_num_rows($accountModel->getAll());
        $totalProducts = mysqli_num_rows($productModel->getAll());
        $totalCategories = mysqli_num_rows($categoryModel->getAll());

        include "views/admin/dashboard/index.php";
    }

}