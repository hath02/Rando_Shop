<?php

class Category {
    private $conn;
    private $table = "category";

    public function __construct($db) {
        $this->conn = $db;
    }

    //get all categories
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        return mysqli_query($this->conn, $sql);
    }

    //get category by id
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table .  " WHERE id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    //create category
    public function create($name,$description) {
        if(empty($name) || empty($description)){
            return false;
        }
        
        $sql = "INSERT INTO " . $this->table . " (name, description) 
                VALUES ('$name', '$description')";
        return mysqli_query($this->conn, $sql);
    }

    //update category
    public function update($id, $name, $description) {
        $sql = "UPDATE " . $this->table . " SET name = '$name', description = '$description' WHERE id = $id";
        return mysqli_query($this->conn, $sql);
    }

    //search categories
    public function search($keyword){

        $sql = "SELECT * FROM category 
                WHERE id LIKE '%$keyword%' 
                OR name LIKE '%$keyword%' 
                OR description LIKE '%$keyword%'";

        return mysqli_query($this->conn, $sql);
    }

    //delete category
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = $id";
        return mysqli_query($this->conn, $sql);
    }
}