<?php

require_once "models/accountModel.php";
require_once "config/database.php";

class AdminAccountController {

    private $account;

    public function __construct() {

        //check admin login
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /shop_db/index.php?action=login");
            exit();
        }

        global $conn;
        $this->account = new Account($conn);
    }

    //list accounts
    public function index(){

        $keyword = $_GET['keyword'] ?? '';

        $accounts = $keyword ? $this->account->search($keyword) : $this->account->getAll();

        include __DIR__ . "/../../views/admin/account/index.php";
    }

    //create account
    public function create(){
        include __DIR__ . "/../../views/admin/account/create.php";
    }

    //store account
    public function store(){

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? "client";

            // check email exist
            $check = $this->account->getByEmail($email);

                if($check){
                    header("Location: /shop_db/index.php?action=admin_create_account&error=email_exists");
                    exit();
                }

            $this->account->create($username,$email,$password,$address,$role);

            header("Location: /shop_db/index.php?action=admin_accounts");
            exit();
        }
    }

    //search accounts
    public function search(){

        $keyword = $_GET['keyword'] ?? '';

        $accounts = $this->account->search($keyword);

        include __DIR__ . "/../../views/admin/account/search.php";
    }

    //edit account
    public function edit(){

        $id = $_GET['id'] ?? 0;

        $account = $this->account->getById($id);

        include __DIR__ . "/../../views/admin/account/edit.php";
    }

    //update account
    public function update(){

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'];

            // if password is not empty, hash it. Otherwise, keep the old password
            if(empty($password)){ //model handle null password by keeping old password
                $password = null;
            }

            $this->account->update($id,$username,$email,$password,$address,$role);

            header("Location: /shop_db/index.php?action=admin_accounts");
            exit();
        }
    }

    //delete account
    public function delete(){

        $id = $_POST['id'];

        // prevent deleting yourself
        if($_SESSION['account_id'] == $id){
            echo "Cannot delete your own account";
            return;
        }

        $this->account->delete($id);

        header("Location: /shop_db/index.php?action=admin_accounts");
        exit();
    }
}