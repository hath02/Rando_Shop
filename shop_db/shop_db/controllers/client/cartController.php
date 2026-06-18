<?php
require_once __DIR__ . "/../../models/cartModel.php";

class CartController {
    private $cartModel;
    private $productModel;

    public function __construct($db) {
        $this->cartModel = new Cart($db);
        $this->productModel = new Product($db);
    }

    // show cart items
    public function index() {

        if (!isset($_SESSION['account_id'])) {
            die("Please login first");
        }

        $account_id = $_SESSION['account_id'];

        $cartItems = $this->cartModel->getByAccount($account_id);
        $categories = $this->productModel->getCategories(); // for navbar

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // load view
        require __DIR__ . "/../../views/client/cart/index.php";
    }

    // add product to cart
    public function add() {

        if (!isset($_SESSION['account_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }

        $account_id = (int)($_SESSION['account_id']);
        $product_id = (int)($_POST['product_id'] ?? $_POST['id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($product_id > 0) {
            $this->cartModel->addToCart($account_id, $product_id, $quantity);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    // get cart data for checkout page
    public function getCartData() {

        if (!isset($_SESSION['account_id'])) {
            return [
                'items' => [],
                'total' => 0
            ];
        }

        $account_id = $_SESSION['account_id'];

        $cartItems = $this->cartModel->getByAccount($account_id);

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return [
            'items' => $cartItems,
            'total' => $total
        ];
    }

    // update quantity in cart
    public function update() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];

            $this->cartModel->updateQuantity($id, $quantity);
        }

        header("Location: /shop_db/index.php?action=cart");
        exit;
    }

    // delete item from cart
    public function delete() {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $this->cartModel->removeFromCart($id);
        }

        header("Location: /shop_db/index.php?action=cart");
        exit;
    }

    // clear cart
    public function clear() {

        if (!isset($_SESSION['account_id'])) {
            die("Please login first");
        }

        $account_id = $_SESSION['account_id'];

        $this->cartModel->clearCart($account_id);

        header("Location: /shop_db/index.php?action=cart");
        exit;
    }
}