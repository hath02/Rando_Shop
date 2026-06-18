<?php

class Product {
    private $conn;
    private $table = "product";

    public function __construct($db) {
        $this->conn = $db;
    }

    //get all products
    public function getAll() {
        $sql = "SELECT product.*, category.name as category_name FROM " . $this->table . " 
        LEFT JOIN category ON product.category_id = category.id";
        return mysqli_query($this->conn, $sql);
    }

    //get product by id
    public function getById($id) {
        $id = (int)$id; // ensure it's an integer to prevent SQL injection

        $sql = "SELECT product.*, category.name as category_name FROM " . $this->table .  " 
        LEFT JOIN category ON product.category_id = category.id 
        WHERE product.id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    //get products on sale
    public function getSaleProducts() { 
        $sql = "SELECT product.*, category.name as category_name FROM " . $this->table . " 
        LEFT JOIN category ON product.category_id = category.id 
        WHERE product.on_sale = 1";
        return mysqli_query($this->conn, $sql);
    }

    //get products by category
    public function getByCategory($category_id) {
        $category_id = (int)$category_id; // ensure it's an integer to prevent SQL injection

        $sql = "SELECT product.*, category.name as category_name FROM " . $this->table . " 
        LEFT JOIN category ON product.category_id = category.id 
        WHERE category.id = $category_id";
        return mysqli_query($this->conn, $sql);
    }

    //get all categories
    public function getCategories() {
        $sql = "SELECT * FROM category ORDER BY name ASC";
        return mysqli_query($this->conn, $sql);
    }

    //search products
    public function search($keyword){
        $keyword = mysqli_real_escape_string($this->conn, $keyword);
        
        $sql = "SELECT product.*, category.name as category_name FROM product
                LEFT JOIN category ON product.category_id = category.id
                WHERE product.name LIKE '%$keyword%' 
                OR product.description LIKE '%$keyword%'";

        return mysqli_query($this->conn, $sql);
    }

    //create product
    public function create($name, $description, $price, $stock, $category_id, $image, $on_sale = 0, $sale_price = null) {

        $sale_price_sql = ($sale_price !== null && $sale_price > 0) ? $sale_price : "NULL";

        $sql = "INSERT INTO " . $this->table . " 
        (name, description, price, stock, category_id, image, on_sale, sale_price)
                VALUES (
                '$name', 
                '$description', 
                $price, 
                $stock, 
                $category_id, 
                '$image', 
                $on_sale, 
                $sale_price_sql)";
        return mysqli_query($this->conn, $sql);
    }

    //update product
    public function update($id, $name, $description, $price, $stock, $category_id, $image = null, $on_sale = 0, $sale_price = null) {

        $sale_price_sql = ($sale_price !== null && $sale_price > 0) ? $sale_price : "NULL";

        $sql = "UPDATE " . $this->table . " 
            SET 
                name = '$name',
                image = '$image',
                description = '$description',
                price = $price,
                stock = $stock,
                category_id = $category_id,
                on_sale = $on_sale,
                sale_price = $sale_price_sql 
                WHERE id = $id";
                
        return mysqli_query($this->conn, $sql);
    }

    //delete product
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = $id";
        return mysqli_query($this->conn, $sql);
    }
}