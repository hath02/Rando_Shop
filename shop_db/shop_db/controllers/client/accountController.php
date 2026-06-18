<?php
require_once "models/accountModel.php";
require_once "models/categoryModel.php";

class AccountController {

    private $accountModel;
    private $categoryModel;

    public function __construct($db) {
        $this->accountModel = new Account($db);
        $this->categoryModel = new Category($db);
    }

    // show account details
    public function index() {

        if (!isset($_SESSION['account_id'])) {
            die("Please login first");
        }

        $account_id = $_SESSION['account_id'];
        $account = $this->accountModel->getById($account_id);

        // get categories for header
        $categories = $this->categoryModel->getAll();

        require __DIR__ . "/../../views/client/account/index.php";
    }

    public function update() {

        if (!isset($_SESSION['account_id'])) {
            die("Please login first");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $account_id = $_SESSION['account_id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $address = $_POST['address'] ?? '';

            // hash password
            if (empty($password)) {
                $password = null;
            }

            $this->accountModel->update($account_id, $username, $email, $hashed_password, $address);
        }

        header("Location: /shop_db/index.php?action=my_account");
        exit;
    }

}