<?php
require_once "models/orderModel.php";
require_once "models/cartModel.php";

class CheckoutController {

    private $order;
    private $cart;  
    private $db;

    public function __construct($db){

        $this->db = $db;
        $this->order = new Order($db);
        $this->cart = new Cart($db);

        //safe check session
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }   
    }

    // checkout page
    public function index(){

        if(!isset($_SESSION['account_id'])){
            header("Location: index.php?action=login");
            exit();
        }

        $accountId = $_SESSION['account_id'];

        // get cart items for this account
        $result = $this->cart->getByAccount($accountId);

        $cartItems = [];
        while($row = mysqli_fetch_assoc($result)){
            $cartItems[] = $row;
        }

        // calculate total amount
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        require_once "models/productModel.php";
        $productModel = new Product($this->db);
        $categories = $productModel->getCategories(); // for navbar

        include __DIR__ . "/../../views/client/checkout/index.php";
    }

    // place order
    public function placeOrder(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Invalid request method.";
            exit();
        }

        // check login
        if(!isset($_SESSION['account_id'])){
            header("Location: index.php?action=login");
            exit();
        }

        $accountId = $_SESSION['account_id'];

        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        // get cart from DB (SAFE)
        $res = $this->cart->getByAccount($accountId);

        $cartItems = [];
        while($row = mysqli_fetch_assoc($res)){
            $cartItems[] = $row;
        }

        if (empty($cartItems)) {
            echo "Cart is empty.";
            exit();
        }

        // calculate total (SERVER SIDE)
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }

        $orderId = $this->order->create(
            $accountId, 
            $name, $phone, 
            $address, 
            $totalAmount);

        if (!$orderId) {
            echo "Failed to create order.";
            exit();
        }

        // save order items
        foreach ($cartItems as $item) {
            $this->order->addItem(
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            );
        }

        // clear cart
        $this->cart->clearCart($accountId);

        // redirect
        header("Location: index.php?action=order_success");
        exit();
    }

    public function success(){

        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['account_id'])){
            header("Location: index.php?action=login");
            exit();
        }

        require_once "models/productModel.php";
        $productModel = new Product($this->db);
        $categories = $productModel->getCategories();

        include __DIR__ . "/../../views/client/checkout/success.php";
    }

    public function history(){

        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['account_id'])){
            header("Location: index.php?action=login");
            exit();
        }

        $accountId = $_SESSION['account_id'];

        $orders = $this->order->getByAccount($accountId);

        require_once "models/productModel.php";
        $productModel = new Product($this->db);
        $categories = $productModel->getCategories();

        include __DIR__ . "/../../views/client/checkout/history.php";
    }

    public function details($orderId){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['account_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $accountId = $_SESSION['account_id'];

        // load order (must verify ownership!)
        $order = $this->order->getById($orderId, $accountId);

        if (!$order) {
            $order = null;
            $orderItems = [];
        } else {
            $orderItems = $this->order->getItems($orderId);
        }

        require_once "models/productModel.php";
        $productModel = new Product($this->db);
        $categories = $productModel->getCategories();

        include __DIR__ . "/../../views/client/checkout/details.php";
    }
}