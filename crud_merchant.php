<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( $_POST ) {
  include_once('config.php');
  include_once 'Classes/Database.php';
  include_once 'Classes/Merchant.php';


  if ($_POST['oper']) {

    $DBPDO = new Database();
    $db = $DBPDO->getConnection($DBPDO);

    $merchant = new Merchant($db);

      
    switch ($_POST['oper']) {
       case "c":  //create    
            if (  !$merchant->checkExists($_POST['merchantname']) ) {
              $merchant->merchantname = $_POST['merchantname'];
              $merchant->npwp = $_POST['npwp'];
              $merchant->address = $_POST['address'];
              $res = $merchant->create();
              echo $res;
            } else {
              echo "already-exists";
            } 
            break;
        case "select-option": //select merchant option
            $stmt =  $merchant->readAll();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            /*$html = '';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $html .= '<option value="'.$row['id'].'">'.$row['merchantname'].'</option>';
            } 

            echo $html;*/

            break;            
       case "r": //read         
            /*$user->id = $_POST['id'];
            $res =  $user->readById();
            echo json_encode($res);*/
            break;
       case "u": //update
            if (  !$merchant->checkExistsDiffId($_POST['merchantname'],$_POST['id']) ) {
                $merchant->merchantname = $_POST['merchantname'];
                $merchant->npwp  = $_POST['npwp'];                             
                $merchant->address  = $_POST['address'];                
                $merchant->id     = $_POST['id'];
                echo $res = $merchant->update();
            } else {
                echo "user-already-exists";
            }           

            break;
       case "d": //delete
            $merchant->id = $_POST['id'];
            if (  !$merchant->checkDeviceExists($_POST['id']) ) {
                $res = $merchant->delete();
                echo $res;
            } else {
                echo "device-still-exists";
            }
            break;
    }
  }
}
?>  

