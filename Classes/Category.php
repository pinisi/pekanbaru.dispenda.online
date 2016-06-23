<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "kategori";
 
    // object properties
    public $id;
    public $kategori_name;
    public $nilai_pajak;
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
                    kategori_name = ?, nilai_pajak = ?, creationtime = ?";
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(1, $this->kategori_name);
        $stmt->bindParam(2, $this->nilai_pajak);
        $stmt->bindParam(3, $this->timestamp);
 
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
                    id, kategori_name, nilai_pajak
                FROM
                    " . $this->table_name . "
                ORDER BY
                    kategori_name ASC" . $LIMIT;                

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
                    kategori_name = :kategori_name,
                    nilai_pajak = :nilai_pajak
                WHERE
                    id = :id";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(':kategori_name', $this->kategori_name);
        $stmt->bindParam(':nilai_pajak', $this->nilai_pajak);
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
                    kategori_name = ?";
     
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
                    kategori_name = ? and id <> ? ";
     
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