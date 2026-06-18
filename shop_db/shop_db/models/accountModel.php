<?php

class Account {
    private $conn;
    private $table = "accounts";

    public function __construct($db) {
        $this->conn = $db;
    }

    //get all accounts
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        return mysqli_query($this->conn, $sql);
    }

    //get account by id
    public function getById($id) {
        $sql = "SELECT id, username, email, password, address, role
                FROM " . $this->table .  " WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $id, $username, $email, $password, $address, $role);
        if (mysqli_stmt_fetch($stmt)) {
            return ['id' => $id, 'username' => $username, 'email' => $email, 'password' => $password, 'address' => $address, 'role' => $role];
        }
        return null;
    }

    //get account by email
    public function getByEmail($emailInput) {
        $sql = "SELECT id, username, email, password, address, role
                FROM " . $this->table .  " WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $emailInput);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $id, $username, $email, $password, $address, $role);
        if (mysqli_stmt_fetch($stmt)) {
            return ['id' => $id, 'username' => $username, 'email' => $email, 'password' => $password, 'address' => $address, 'role' => $role];
        }
        return null;
    }


    //search accounts
    public function search($keyword){
        $keyword = "%$keyword%"; // add wildcards for LIKE query

        $sql = "SELECT * FROM accounts 
                WHERE id LIKE ?
                OR username LIKE ?
                OR email LIKE ?
                OR address LIKE ?
                OR role LIKE ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $keyword, $keyword, $keyword, $keyword, $keyword);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    //create account
    public function create($username,$email, $password, $address, $role) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO " . $this->table . " (username, email, password, address, role) 
                VALUES (?, ?, ?, ?, ?)";
                
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashed_password, $address, $role);
        return mysqli_stmt_execute($stmt);
    }

    //update account
    public function update($id, $username, $email, $password = null, $address = null, $role = null) {
        $params = [];
        $fields = [];
        $types = "";

        if ($username !== null) {
            $fields[] = "username = ?";
            $params[] = $username;
            $types .= "s";
        }

        if ($email !== null) {
            $fields[] = "email = ?";
            $params[] = $email;
            $types .= "s";
        }

        if ($password !== null) {
            $fields[] = "password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
            $types .= "s";
        }

        if ($address !== null) {
            $fields[] = "address = ?";
            $params[] = $address;
            $types .= "s";
        }

        if ($role !== null) {
            $fields[] = "role = ?";
            $params[] = $role;
            $types .= "s";
        }

        if (empty($fields)) {
             // No fields to update
             return false;
         }

        $types .= "i"; // for id
        $params[] = $id;

        $sql = "UPDATE " . $this->table . " SET " . implode(", ", $fields) . " WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        return mysqli_stmt_execute($stmt);
    }

    //delete account
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}