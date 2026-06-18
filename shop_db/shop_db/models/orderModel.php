<?php

class Order {
    private $conn;
    private $table = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    //helper: prepare statement
    private function prepare($sql) {
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . mysqli_error($this->conn));
        }
        return $stmt;
    }

    // get orders by account id
    public function getByAccount($account_id){
        $sql = "SELECT * FROM " . $this->table . "
                WHERE account_id = ? 
                ORDER BY created_at DESC";

        $stmt = $this->prepare($sql);

        mysqli_stmt_bind_param($stmt, "i", $account_id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    // get order by id
    public function getById($id, $account_id = null) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";

        if ($account_id !== null) {
            $sql .= " AND account_id = ?";
        }

        $stmt = $this->prepare($sql);

        if ($account_id !== null) {
            mysqli_stmt_bind_param($stmt, "ii", $id, $account_id);
        } else {
            mysqli_stmt_bind_param($stmt, "i", $id);
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result) ?: null;
    }

    // create order
    public function create($account_id, $name, $phone, $address, $total) {
        $sql = "INSERT INTO orders (account_id, name, phone, address, total_price, status) 
                VALUES (?, ?, ?, ?, ?, 'pending')";

        $stmt = $this->prepare($sql);

        $total = (float)$total; // ensure total is float for binding
        mysqli_stmt_bind_param(
            $stmt, 
            "isssd", 
            $account_id, 
            $name, 
            $phone, 
            $address, 
            $total);

        if(mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }
        return false;
    }

    // add order item
    public function addItem($order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->prepare($sql);

        mysqli_stmt_bind_param($stmt, "iiid", $order_id, $product_id, $quantity, $price);

        return mysqli_stmt_execute($stmt);
    }

    //create full order (WITH TRANSACTION)
    public function createFullOrder($account_id, $name, $phone, $address, $total, $items) {
        mysqli_begin_transaction($this->conn);

        try {
            //validate input
            if (empty($items)) {
                throw new Exception("Cart is empty");
            }

            // create order
            $order_id = $this->create($account_id, $name, $phone, $address, $total);

            if (!$order_id) {
                throw new Exception("Failed to create order");
            }

            // add items
            foreach ($items as $item) {
                if (!isset($item['product_id'], $item['quantity'], $item['price'])) {
                    throw new Exception("Invalid order item data");
                }
                
                $ok = $this->addItem(
                    $order_id, 
                    $item['product_id'], 
                    $item['quantity'], 
                    $item['price']
                );

                if (!$ok) {
                    throw new Exception("Failed to add order item");
                }
            }

            // commit transaction
            mysqli_commit($this->conn);
            return $order_id;

        } catch (Exception $e) {
            mysqli_rollback($this->conn);
            error_log("Error creating order: " . $e->getMessage());
            return false;
        }
    }

    // update order status
    public function update($id, $status){
        $sql = "UPDATE " . $this->table . " SET status = ? WHERE id = ?";
        $stmt = $this->prepare($sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        return mysqli_stmt_execute($stmt);
    }

    //get all orders
    public function getAll(){
        $sql = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->prepare($sql);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    //get order items 
    public function getItems($order_id){
        $sql = "SELECT 
                    order_items.*,
                    product.name AS product_name,
                    product.image AS product_image,
                    (order_items.quantity * order_items.price) AS subtotal
                FROM order_items
                JOIN product ON order_items.product_id = product.id
                WHERE order_items.order_id = ?";

        $stmt = $this->prepare($sql);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    //search orders (admin)
    public function search($keyword){

        if (is_numeric($keyword)) {
            $sql = "SELECT * FROM " . $this->table . " 
                    WHERE id = ? OR account_id = ? 
                    ORDER BY created_at DESC";

            $stmt = $this->prepare($sql);
            $id = (int)$keyword;
            mysqli_stmt_bind_param($stmt, "ii", $id, $id);

        } else {
            $keyword = "%$keyword%";
            $sql = "SELECT * FROM " . $this->table . " 
                    WHERE name LIKE ? OR phone LIKE ? OR status LIKE ?
                    ORDER BY created_at DESC";

            $stmt = $this->prepare($sql);
            mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $keyword);
        }

        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    //delete order (admin)
    public function delete($id){
        mysqli_begin_transaction($this->conn);

        try {
            // delete order items first
            $sqlItems = "DELETE FROM order_items WHERE order_id = ?";
            $stmtItems = $this->prepare($sqlItems);
            mysqli_stmt_bind_param($stmtItems, "i", $id);
            mysqli_stmt_execute($stmtItems);

            // delete order
            $sqlOrder = "DELETE FROM " . $this->table . " WHERE id = ?";
            $stmtOrder = $this->prepare($sqlOrder);
            mysqli_stmt_bind_param($stmtOrder, "i", $id);
            mysqli_stmt_execute($stmtOrder);

            mysqli_commit($this->conn);
            return true;

        } catch (Exception $e) {
            mysqli_rollback($this->conn);
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }
}