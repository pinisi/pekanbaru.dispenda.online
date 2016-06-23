<?php


//if ( $_POST ) {

  include_once('config.php');
  include_once 'Classes/Database.php';
  include_once 'Classes/Merchant.php';
  include_once 'Classes/Device.php';
  include_once 'Classes/Struk.php';
  include_once 'Classes/RandomColor.php';

  use \Colors\RandomColor;

  //$C = RandomColor::one(array('luminosity' => 'light','format' => 'rgb'));
  //print_r($C);

  //echo $C['r'];

  // Returns a hex code for an attractive color
  //echo RandomColor::one(array('luminosity' => 'bright','format' => 'rgbCss'));
if ($_POST['oper']=="r-group-datemerchant") {

    $DBPDO = new Database();
    $db = $DBPDO->getConnection($DBPDO);

    $struk = new Struk($db);

    $start = $_POST['start'];
    $end = $_POST['end'];
    $merchantid = $_POST['merchant'];

    $stmt = $struk->getStrukTransactionByDateMerchant($start,$end, $merchantid);
    //$stmt = $struk->getStrukTransactionByDateMerchant('01/06/2016','13/06/2016',"all");
    //echo $stmt;
    //echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    //echo "<br><br>";
    $plot_data = array();
    $labels = array();
    $label = array();
    $datasets = array();
    $labelidx = 0;

/*    var lineData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "Example dataset",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "Example dataset",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.7)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [28, 48, 40, 19, 86, 27, 90]
            }
        ]
    };*/


// GROUP plot Data by Merchant
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC) )  {
        
        if (! in_array($row['merchantname'], $labels)) {
            array_push($labels,$row['merchantname']); 
            $labels_idx = count($labels) - 1;
        } else {
            $labels_idx = array_search($row['merchantname'],$labels);
        }

        if (! in_array($row['tgltransaksi'], $label)) {
            array_push($label,$row['tgltransaksi']);            
            $plot_data['datasets'][count($label)-1]['label'] = $row['tgltransaksi'];

            if ( $labels_idx > 0 && isset($plot_data['datasets'][count($label)-1]) ) {
               $plot_data['datasets'][count($label)-1]['data'] = array_fill(0,$labels_idx, 0);
            } 

            $plot_data['datasets'][count($label)-1]['data'][$labels_idx] = $row['pajak'];
            $plot_data['datasets'][count($label)-1]['pointStrokeColor'] = "#fff";
            $plot_data['datasets'][count($label)-1]['pointHighlightFill'] = "#fff";
            $plot_data['datasets'][count($label)-1]['fillColor'] = RandomColor::one(array('format'=>'rgbCss'));;

        } else {
            $label_idx = array_search($row['tgltransaksi'],$label);
            $plot_data['datasets'][$label_idx]['data'][$labels_idx] = $row['pajak'];
        }



    }

    $plot_data['labels'] = $labels;
    echo json_encode($plot_data);

} else if ( $_POST['oper']=="r-group-monthmerchant" ) {

    $DBPDO = new Database();
    $db = $DBPDO->getConnection($DBPDO);

    $struk = new Struk($db);

    $start = $_POST['start'];
    $end = $_POST['end'];
    $merchantid = $_POST['merchant'];

    $stmt = $struk->getStrukTransactionByMonthMerchant($start,$end, $merchantid);
    //$stmt = $struk->getStrukTransactionByDateMerchant('01/06/2016','13/06/2016',"all");
    //echo $stmt;
    //echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    //echo "<br><br>";
    $plot_data = array();
    $labels = array();
    $label = array();
    $datasets = array();
    $labelidx = 0;

   /* while ($row = $stmt->fetch(PDO::FETCH_ASSOC) )  {
        
        if (! in_array($row['merchantname'], $labels)) {
            array_push($labels,$row['merchantname']); 
            $labels_idx = count($labels) - 1;
        } else {
            $labels_idx = array_search($row['merchantname'],$labels);
        }

        if (! in_array($row['tgltransaksi'], $label)) {
            array_push($label,$row['tgltransaksi']);            
            $plot_data['datasets'][count($label)-1]['label'] = $row['tgltransaksi'];

            if ( $labels_idx > 0 && isset($plot_data['datasets'][count($label)-1]) ) {
               $plot_data['datasets'][count($label)-1]['data'] = array_fill(0,$labels_idx, 0);
            } 

            $plot_data['datasets'][count($label)-1]['data'][$labels_idx] = $row['pajak'];
            $plot_data['datasets'][count($label)-1]['pointStrokeColor'] = "#fff";
            $plot_data['datasets'][count($label)-1]['pointHighlightFill'] = "#fff";
            $plot_data['datasets'][count($label)-1]['fillColor'] = RandomColor::one(array('format'=>'rgbCss'));;

        } else {
            $label_idx = array_search($row['tgltransaksi'],$label);
            $plot_data['datasets'][$label_idx]['data'][$labels_idx] = $row['pajak'];
        }
    }

    $plot_data['labels'] = $labels;
    echo json_encode($plot_data);*/

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC) )  {
        
        if (! in_array($row['tgltransaksi'], $labels)) {
            array_push($labels,$row['tgltransaksi']); 
            $labels_idx = count($labels) - 1;
        } else {
            $labels_idx = array_search($row['tgltransaksi'],$labels);
        }

        if (! in_array($row['merchantname'], $label)) {
            array_push($label,$row['merchantname']);            
            $plot_data['datasets'][count($label)-1]['label'] = $row['merchantname'];

            if ( $labels_idx > 0 && isset($plot_data['datasets'][count($label)-1]) ) {
               $plot_data['datasets'][count($label)-1]['data'] = array_fill(0,$labels_idx, 0);
            } 

            $plot_data['datasets'][count($label)-1]['data'][$labels_idx] = $row['pajak'];
            $plot_data['datasets'][count($label)-1]['pointStrokeColor'] = "#fff";
            $plot_data['datasets'][count($label)-1]['pointHighlightFill'] = "#fff";            
            $plot_data['datasets'][count($label)-1]['fillColor'] = RandomColor::one(array('format'=>'rgbCss'));;

        } else {
            $label_idx = array_search($row['merchantname'],$label);
            $plot_data['datasets'][$label_idx]['data'][$labels_idx] = $row['pajak'];
        }
    }

    $plot_data['labels'] = $labels;
    echo json_encode($plot_data);    

}
/*

// GROUP plot Data by Date
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC) )  {
        
        if (! in_array($row['tgltransaksi'], $labels)) {
            array_push($labels,$row['tgltransaksi']); 
            $labels_idx = count($labels) - 1;
        } else {
            $labels_idx = array_search($row['tgltransaksi'],$labels);
        }

        if (! in_array($row['merchantname'], $label)) {
            array_push($label,$row['merchantname']);            
            $plot_data['datasets'][count($label)-1]['label'] = $row['merchantname'];

            if ( $labels_idx > 0 && isset($plot_data['datasets'][count($label)-1]) ) {
               $plot_data['datasets'][count($label)-1]['data'] = array_fill(0,$labels_idx, 0);
            } 

            $plot_data['datasets'][count($label)-1]['data'][$labels_idx] = $row['pajak'];
            $plot_data['datasets'][count($label)-1]['pointStrokeColor'] = "#fff";
            $plot_data['datasets'][count($label)-1]['pointHighlightFill'] = "#fff";            
            $plot_data['datasets'][count($label)-1]['fillColor'] = RandomColor::one(array('format'=>'rgbCss'));;

        } else {
            $label_idx = array_search($row['merchantname'],$label);
            $plot_data['datasets'][$label_idx]['data'][$labels_idx] = $row['pajak'];
        }



    }

    $plot_data['labels'] = $labels;    
    echo json_encode($plot_data);

*/
    /*switch ($_POST['oper']) {
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
    }*/
//}
//}
?>  
