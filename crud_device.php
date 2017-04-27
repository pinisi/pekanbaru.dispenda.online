<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( $_POST ) {
  include_once('config.php');
  include_once 'Classes/Database.php';
  include_once 'Classes/Merchant.php';
  include_once 'Classes/Device.php';


  if ($_POST['oper']) {

    $DBPDO = new Database();
    $db = $DBPDO->getConnection($DBPDO);

    $device   = new Device($db);
    $merchant = new Merchant($db);
     
    switch ($_POST['oper']) {
       case "c":  //create    
            if (  !$device->checkExists($_POST['deviceid'], $_POST['wpname']) ) {
              $device->deviceID = $_POST['deviceid'];
              $device->msisdn = $_POST['msisdn'];
              $device->merchantid = $_POST['wpname'];
              $device->kategoriid = $_POST['kategori'];
              $device->address = $_POST['address'];                           
              $res = $device->create();
              echo $res;
            } else {
              echo "already-exists";
            }           
            break;
       case "r": //read         
            $device->id = $_POST['id'];
            $device =  $device->readById();
            echo json_encode($res);
            break;
       case "u": //update
            if (  !$device->checkExistsDiffId($_POST['deviceid'],$_POST['id']) ) {
                $device->deviceID = $_POST['deviceid'];
                $device->msisdn = $_POST['msisdn'];
                $device->merchantid = $_POST['wpname'];
                $device->kategoriid = $_POST['kategori'];
                $device->address = $_POST['address'];                           
                $device->id     = $_POST['id'];
                echo $res = $device->update();
            } else {
                echo "already-exists";
            }           

            break;           
       case "d": //delete
            $device->id = $_POST['id'];
            $res = $device->delete();
            echo $res;
            break;      
    }
  }
}
?>  
