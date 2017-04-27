<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( $_POST ) {
  include_once('config.php');
  include_once 'Classes/Database.php';
  include_once 'Classes/Category.php';


  if ($_POST['oper']) {

    $DBPDO = new Database();
    $db = $DBPDO->getConnection($DBPDO);

    $category = new Category($db);

      
    switch ($_POST['oper']) {
       case "c":  //create    
            if (  !$category->checkExists($_POST['kategoriname']) ) {
              $category->kategori_name = $_POST['kategoriname'];
              $category->nilai_pajak = $_POST['nilaipajak'];
              $res = $category->create();
              echo $res;
            } else {
              echo "already-exists";
            }       
            break;
        case "select-option": //select merchant option
            $stmt =  $category->readAll();
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
            if (  !$category->checkExistsDiffId($_POST['kategoriname'],$_POST['id']) ) {
                $category->kategori_name = $_POST['kategoriname'];
                $category->nilai_pajak  = $_POST['nilaipajak'];                             
                $category->id     = $_POST['id'];
                echo $res = $category->update();
            } else {
                echo "already-exists";
            }           

            break;
       case "d": //delete
            $category->id = $_POST['id'];
            $res = $category->delete();
            echo $res;
            break;
    }
  }
}
?>  
