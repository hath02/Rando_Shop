<?php
require_once "models/orderModel.php";

class AdminOrderController {

    private $order;

    public function __construct(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        global $conn;
        $this->order = new Order($conn);

        $this->requireAdmin();
    }

    // helper: check if user is admin
    private function requireAdmin(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['account_id']) || $_SESSION['role'] !== 'admin'){
            header("Location: index.php?action=login");
            exit();
        }
    }

    // list orders
    public function index(){
        $orders = $this->order->getAll();
        include __DIR__ . "/../../views/admin/order/index.php";
    }

    //get by id
    public function detail(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            echo "Invalid order ID";
            exit();
        }

        $order = $this->order->getById($id);

        if (!$order) {
            $orderItems = [];
        } else {
            $orderItems = $this->order->getItems($id);
        }

        include __DIR__ . "/../../views/admin/order/details.php";
    }

    //search orders
    public function search(){
        $keyword = $_GET['keyword'] ?? '';
        $orders = $this->order->search($keyword);

        include __DIR__ . "/../../views/admin/order/search.php";
    }

    //update order status
    public function update(){
        if($_SERVER['REQUEST_METHOD'] !== "POST"){
            echo "Invalid request method.";
            exit();
        }

        $id = (int)($_GET['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
            
        if($id <= 0 || !in_array($status, $allowed)){
            die ("Invalid order ID or status");
        }

        $result = $this->order->update($id, $_POST['status']);

        if (!$result) {
            die("Failed to update order status");
        }

        header("Location: index.php?action=admin_orders");
        exit();
    }

    public function delete(){
        if($_SERVER['REQUEST_METHOD'] !== "POST"){
            echo "Invalid request method.";
            exit();
        }
        
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            die("Invalid order ID");
        }

        $result = $this->order->delete($id);

        if (!$result) {
            echo "Failed to delete order";
            exit();
        }

        header("Location: index.php?action=admin_orders");
        exit();
    }
}