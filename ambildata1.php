<?php
include "init_dbconnection.php";
$akhir = $_GET['akhir'];
if($akhir==1){
    $query = "SELECT * FROM data_gis";

	if(isset($_GET['status']))
		$query .=" WHERE STATUS='".$_GET['status']."'";

	$query .=" ORDER BY MSISDN DESC LIMIT 1";
	
}else{
    $query = "SELECT * FROM data_gis";
	if($_GET['status'] !="")
	    $query = "SELECT * FROM data_gis where status='".$_GET['status']."'";
}

	
	
	
//echo $query;
$data = mysql_query($query);

$json = '{"wilayah": {';
$json .= '"petak":[ ';
while($x = mysql_fetch_array($data)){
    $json .= '{';
    $json .= '"id":"'.$x['MSISDN'].'",
		"judul":"'.htmlspecialchars($x['judul']).'",
		"deskripsi":"'.htmlspecialchars($x['deskripsi']).'",
		"x":"'.$x['LATTITUDE'].'",
        "y":"'.$x['LONGITUDE'].'",
        "status":"'.$x['STATUS'].'"
    },';
}
 //       "judul":"'.htmlspecialchars($x['judul']).'",
//        "deskripsi":"'.htmlspecialchars($x['deskripsi']).'",

$json = substr($json,0,strlen($json)-1);
$json .= ']';

$json .= '}}';
echo $json;

?>
