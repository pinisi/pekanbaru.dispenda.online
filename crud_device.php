<?php
require_once "secure.php";
include("init_dbconnection.php");

$merchantid="0";
$crudTableName = "device";

$crudColumns =  array(
	'deviceid'=>'deviceid'
	,'wpname'=>'wpname'
	,'merchantid'=>'merchantid'
        ,'kategoriid'=>'kategoriid'
        ,'status'=>'status' 
);

if (isset($_REQUEST['merchantname'])) {
   $sql = "SELECT id FROM merchant WHERE merchantname = '" . $_REQUEST['merchantname'] . "'";
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result,MYSQL_ASSOC);
   $merchantid = $row['id'];
}

if (isset($_REQUEST['kategori_name'])) {
   $sql = "SELECT id FROM kategori WHERE kategori_name = '" . $_REQUEST['kategori_name'] .  "'";
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result,MYSQL_ASSOC);
   $kategoriid = $row['id'];
}


function fnCleanInputVar($string){
	//$string = mysql_real_escape_string($string);
	return $string;
}

foreach ($crudColumns as $key => $value){ 
        if ($key=='merchantid') {
           $crudColumnValues[$key] = $merchantid; 
        }elseif( $key=='kategoriid' ) {
           $crudColumnValues[$key] = $kategoriid;
	}elseif(isset($_REQUEST[$key])){
	   $crudColumnValues[$key] = '"'.fnCleanInputVar($_REQUEST[$key]).'"';
	}
}


if ($_REQUEST['oper'] == "edit") {
   if (isset($_REQUEST['id'])) {
      $crudColumnValues['id'] = '"'.fnCleanInputVar($_REQUEST['id']).'"';
   }
  
   $sql = 'UPDATE '.$crudTableName.' SET ';
   foreach($crudColumns as $key => $value){ 
         $updateArray[$key] = $value.'='.$crudColumnValues[$key]; 
   };
   $sql .= implode(',',$updateArray);
   $sql .= ' WHERE id = '.$crudColumnValues['id'];

   mysql_query( $sql ) 
   or die();

}
elseif ($_REQUEST['oper'] == "add") {
   $sql = 'INSERT INTO '.$crudTableName.'(';
		
   $sql .= implode(',',$crudColumns);
   $sql .= ')VALUES(';
		
   $sql .= implode(',',$crudColumnValues);
		
   $sql .= ')';
   
   $result = mysql_query( $sql );
}
elseif ($_REQUEST['oper'] == "del") {
   if (isset($_REQUEST['id'])) {
      $crudColumnValues['id'] = '"'.fnCleanInputVar($_REQUEST['id']).'"';
   }

   $sql = 'DELETE FROM '.$crudTableName.' WHERE id = '.$crudColumnValues['id'];
    
   $result = mysql_query( $sql );

}

?>
