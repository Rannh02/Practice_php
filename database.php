<?php
class Database {
    private $host = "localhost";
    private $db_name = "School";
    private $username = "root"; // or your MySQL user
    private $password = "";     // put your password if any
    private $pdo;

    public function connect() {
        if ($this->pdo == null) {
            try {
                $this->pdo = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                    $this->username,
                    $this->password
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
