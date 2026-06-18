<?php

require_once "config/database.php";
require_once "models/accountModel.php";

class AuthController {

    private $account;

    public function __construct(){

        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        global $conn;
        $this->account = new Account($conn);
    }

    //login page
    public function login(){
        include "views/auth/login.php";
    }

    //login handle
    public function loginPost(){

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if(empty($email) || empty($password)){
            echo "Email and password required";
            return;
        }

        // get user (already array)
        $user = $this->account->getByEmail($email);

        if($user && password_verify($password, $user['password'])){

            $_SESSION['account_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // redirect
            if($user['role'] == "admin"){
                header("Location: /shop_db/index.php?action=admin");
            }else{
                header("Location: /shop_db/index.php");
            }
            exit();

        }else{
            echo "Invalid email or password";
        }
    }

    //register page
    public function register(){
        include "views/auth/register.php";
    }

    //register handle
    public function registerPost(){

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $address = $_POST['address'] ?? '';

        if(empty($username) || empty($email) || empty($password)){
            echo "Username, email and password required";
            return;
        }
        
        // check email exists
        $user = $this->account->getByEmail($email);

        if($user){
            echo "Email already exists";
            return;
        }

        // create user
        $this->account->create($username, $email, $password, $address, "client");

        header("Location: index.php?action=login");
        exit();
    }

    //logout
    public function logout(){

        session_unset();
        session_destroy();

        header("Location: index.php?action=login");
        exit();
    }

}