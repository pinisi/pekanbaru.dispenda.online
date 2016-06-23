<?php
class Database{
 
    // specify your own database credentials
    private $host     = DATABASE_HOST;
    private $db_name  = DATABASE_NAME;
    private $username = DATABASE_USER;
    private $password = DATABASE_PASS;
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>