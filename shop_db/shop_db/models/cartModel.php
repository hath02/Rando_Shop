<?php

class Cart{
    private $conn;
    private $table = "cart";

    public function __construct($db) {
        $this->conn = $db;
    }
    //get all carts
    public function getByAccount($account_id){
        $sql = "SELECT cart.*, product.name, product.price, product.image
        FROM " . $this->table . " 
        JOIN product ON cart.product_id = product.id
        WHERE cart.account_id = $account_id";

        return mysqli_query($this->conn, $sql);

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        return $data;
    }

    //add product to cart
    public function addToCart($account_id, $product_id, $quantity) {
        // check if product already exists
        $checkSql = "SELECT * FROM " . $this->table . " 
                    WHERE account_id = $account_id AND product_id = $product_id";
        $result = mysqli_query($this->conn, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            // update quantity
            $sql = "UPDATE " . $this->table . " 
                    SET quantity = quantity + $quantity
                    WHERE account_id = $account_id AND product_id = $product_id";
        } else {
            // insert new
            $sql = "INSERT INTO " . $this->table . " (account_id, product_id, quantity) 
                    VALUES ($account_id, $product_id, $quantity)";
        }

        return mysqli_query($this->conn, $sql);
    }

    //update quantity in cart
    public function updateQuantity($id, $quantity) {
        $sql = "UPDATE " . $this->table . " SET quantity = $quantity WHERE id = $id";
        return mysqli_query($this->conn, $sql);
    }

    //remove product from cart
    public function removeFromCart($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = $id";
        return mysqli_query($this->conn, $sql);
    }

    //clear cart
    public function clearCart($account_id) {
        $sql = "DELETE FROM " . $this->table . " WHERE account_id = $account_id";
        return mysqli_query($this->conn, $sql); 
    }
}