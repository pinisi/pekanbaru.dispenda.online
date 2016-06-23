<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "login";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $level;
    public $create_user_id;
    public $update_user_id;
    public $timestamp;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // create product
    function create(){
 
        // to get time-stamp for 'created' field
        $this->getTimestamp();
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username = ?, password = ?, level = ?, creationtime = ?, updatedtime = ?";
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(1, $this->username);
        $stmt->bindParam(2, $this->password);
        $stmt->bindParam(3, $this->level);
        $stmt->bindParam(4, $this->timestamp);
        $stmt->bindParam(5, $this->timestamp);
 
        if($stmt->execute()){
            return true;
        }else{
            return $this->conn->errorInfo();
        }
 
    }

    // used for the 'created' field when creating a product
    function getTimestamp(){
        date_default_timezone_set('Asia/Jakarta');
        $this->timestamp = date('Y-m-d H:i:s');
    }

    function readAll($page, $from_record_num, $records_per_page){
 
        $query = "SELECT
                    id, username, level
                FROM
                    " . $this->table_name . "
                ORDER BY
                    username ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }

    // used for paging products
    public function countAll(){
     
        $query = "SELECT id FROM " . $this->table_name . "";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        $num = $stmt->rowCount();
     
        return $num;
    }

    function readOne(){
 
        $query = "SELECT
                    username, password, level
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->level    = $row['level'];  


    }

    function update(){
 
        $this->getTimestamp();

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    username = :username,
                    level = :level,
                    updatedtime = :updatedtime
                WHERE
                    id_login = :id";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':updatedtime', $this->timestamp);
        $stmt->bindParam(':id', $this->id);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function updatePassword(){
 
        $this->getTimestamp();

        echo $this->password . "-" . $this->id . "==";

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password = :password,
                    updatedtime = :updatedtime
                WHERE
                    id_login = :id";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':updatedtime', $this->timestamp);
        $stmt->bindParam(':id', $this->id);

        $stmt->debugDumpParams();
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }    

    // delete the product
    function delete(){
     
        $query = "DELETE FROM " . $this->table_name . " WHERE id_login = ?";
         
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
     
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function checkUserExists($user_to_check) {
        $query = "SELECT
                    id_login
                FROM
                    " . $this->table_name . "
                WHERE
                    username = ?";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $user_to_check);

        // execute the query
        if($stmt->execute()){
            $this->count = $stmt->rowCount();
            if ($this->count > 0) {
                return true;     
            } else {
                return false;
            }             
        }else{
            return false;
        }        
    }

    function checkUserExistsDiffId($user_to_check, $id) {
        $query = "SELECT
                    id_login
                FROM
                    " . $this->table_name . "
                WHERE
                    username = ? and id_login <> ? ";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $user_to_check);
        $stmt->bindParam(2, $id);

        // execute the query
        if($stmt->execute()){
            $this->count = $stmt->rowCount();
            if ($this->count > 0) {
                return true;     
            } else {
                return false;
            }             
        }else{
            return false;
        }        
    }

    function readExists($user_to_check, $password_to_check) {
        $query = "SELECT
                    id, username, password, level
                FROM
                    " . $this->table_name . "
                WHERE
                    username = ? and
                    password = ?";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $user_to_check);
        $stmt->bindParam(2, md5($password_to_check));
        //$stmt->execute();   

        // execute the query
        if($stmt->execute()){
            $this->count = $stmt->rowCount();
            if ($this->count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->level = $row['level']; 
                $this->id = $row['id']; 
            return $this;          
            } else {
                return false;
            }             
        }else{
            return false;
        }
     
        /*if ($stmt->rowCount() > 0)
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->name = $row['username'];
            $this->price = $row['password'];
            $this->level = $row['level'];            
        } else {

        }*/
    }

}
?>