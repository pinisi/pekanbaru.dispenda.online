<?php
class Merchant{
 
    // database connection and table name
    private $conn;
    private $table_name = "merchant";
 
    // object properties
    public $id;
    public $merchantname;
    public $npwp;
    public $address;
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
                    merchantname = ?, npwp = ?, address = ?, creationtime = ?, updatedtime = ?";
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(1, $this->merchantname);
        $stmt->bindParam(2, $this->npwp);
        $stmt->bindParam(3, $this->address);
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

    function readAll($page='', $from_record_num='', $records_per_page=''){

        if ( $from_record_num == '' && $records_per_page == '') {
            $LIMIT = '';
        } else {
            $LIMIT = " LIMIT {$from_record_num}, {$records_per_page}";            
        }
 
        $query = "SELECT
                    id, merchantname
                FROM
                    " . $this->table_name . "
                ORDER BY
                    merchantname ASC" . $LIMIT;                

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
                    merchantname = :merchantname,
                    npwp = :npwp,
                    address = :address,
                    updatedtime = :updatedtime
                WHERE
                    id = :id";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(':merchantname', $this->merchantname);
        $stmt->bindParam(':npwp', $this->npwp);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':updatedtime', $this->timestamp);
        $stmt->bindParam(':id', $this->id);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // delete the product
    function delete(){
     
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
         
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
     
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function checkExists($name_to_check) {
        $query = "SELECT
                    id
                FROM
                    " . $this->table_name . "
                WHERE
                    merchantname = ?";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $name_to_check);

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

    function checkExistsDiffId($name_to_check, $id) {
        $query = "SELECT
                    id
                FROM
                    " . $this->table_name . "
                WHERE
                    merchantname = ? and id <> ? ";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $name_to_check);
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

    function checkDeviceExists($id) {
         $query = "SELECT
                    id
                FROM
                    device
                WHERE
                    merchantid = ?";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $id);
        
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
     

    }

}
?>