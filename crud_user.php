<?php
if ( $_POST ) {
  include_once('config.php');
  include_once 'Classes/Database.php';
  include_once 'Classes/User.php';


  if ($_POST['oper']) {

    $DBPDO = new Database();
    $db = $DBPDO->getConnection($DBPDO);

    $user = new User($db);

      
    switch ($_POST['oper']) {
       case "c":  //create    
            if (  !$user->checkUserExists($_POST['username']) ) {
              $user->username = $_POST['username'];
              $user->password = md5($_POST['password']);
              $user->level = $_POST['level'];                             
              $res = $user->create();
              echo $res;
            } else {
              echo "user-already-exists";
            }           
            break;
       case "r": //read         
            $user->id = $_POST['id'];
            $res =  $user->readById();
            echo json_encode($res);
            break;
       case "u": //update
            if (  !$user->checkUserExistsDiffId($_POST['username'],$_POST['id']) ) {
                $user->username = $_POST['username'];
                $user->level  = $_POST['level'];                             
                $user->id     = $_POST['id'];
                echo $res = $user->update();
            } else {
                echo "user-already-exists";
            }           

            break;
       case "upassword": //update
                $user->password = md5($_POST['password']);
                $user->id     = $_POST['id'];
                echo $res = $user->updatePassword();
                echo "here";
            break;            
       case "d": //delete
            $user->id = $_POST['id'];
            $res = $user->delete();
            echo $res;
            break;
    }
  }
}
?>  
