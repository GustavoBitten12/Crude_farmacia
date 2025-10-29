<?php
class DatabaseMySQLi {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "farmacia_vila_boa";
    public $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->conn->connect_error) {
            die("Erro de conexão: " . $this->conn->connect_error);
        }
        
        return $this->conn;
    }
}
?>