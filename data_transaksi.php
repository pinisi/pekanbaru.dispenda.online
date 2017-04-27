<?php
include("init_dbconnection.php");
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;
//$merchantid = $_GET['merchant'];
 
//array to translate the search type
$ops = array(
    'eq'=>'=', //equal
    'ne'=>'<>',//not equal
    'lt'=>'<', //less than
    'le'=>'<=',//less than or equal
    'gt'=>'>', //greater than
    'ge'=>'>=',//greater than or equal
    'bw'=>'LIKE', //begins with
    'bn'=>'NOT LIKE', //doesn't begin with
    'in'=>'LIKE', //is in
    'ni'=>'NOT LIKE', //is not in
    'ew'=>'LIKE', //ends with
    'en'=>'NOT LIKE', //doesn't end with
    'cn'=>'LIKE', // contains
    'nc'=>'NOT LIKE'  //doesn't contain
);
function getWhereClause($col, $oper, $val){
    global $ops;
    if($oper == 'bw' || $oper == 'bn') $val .= '%';
    if($oper == 'ew' || $oper == 'en' ) $val = '%'.$val;
    if($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni') $val = '%'.$val.'%';
    return " AND $col {$ops[$oper]} '$val' ";
}
$where = ""; //if there is no search request sent by jqgrid, $where should be empty
$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
if ($_GET['_search'] == 'true') {
    $where = getWhereClause($searchField,$searchOper,$searchString);
}

if (isset($_GET['merchant'])) {
   if ($_GET['merchant'] == 'all') {
      $where = "";
   } else {
      $where .= " AND (device.merchantid in ( " . $_GET['merchant']. " ))";
   }
}

if (isset($_GET["start"]) && isset($_GET["end"])) {
   $where .= " AND (tgltransaksi between concat(str_to_date('" . $_GET["start"] ."','%d/%m/%Y'),' 00:00:00')"
   . " AND concat(str_to_date('" . $_GET['end'] . "','%d/%m/%Y'),' 23:59:59'))";
}

//$result = mysql_query("SELECT COUNT(*) AS count FROM struk");
$sql= "SELECT count(*)  as count FROM struk,device"
. " WHERE struk.deviceid = device.deviceid"
. $where;

$result = mysql_query($sql);
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
    $total_pages = ceil($count/$limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)

//$limit = 30;
//$SQL = "select deviceid,nostruk,msisdn,kategori,tgltransaksi,jumlah from v_strukmerchant"
$SQL = "SELECT struk.id as id,struk.deviceid as deviceid, struk.nostruk as nostruk,merchant.merchantname"
. ", (select kategori_name from kategori where device.kategoriid = id) as kategori_name"
. ",struk.tgltransaksi as tgltransaksi,struk.jumlah as jumlah"
. ", round( (select nilai_pajak from kategori where device.kategoriid = id) * struk.jumlah, 2) as pajak"
. " FROM struk,device,merchant WHERE struk.deviceid = device.deviceid AND device.merchantid = merchant.id"
.$where." ORDER BY $sidx $sord LIMIT $start , $limit";

//mysql_query("INSERT into logs(messages) value('". $_GET['_search']) . "')");
//echo $SQL;
$result = mysql_query( $SQL ) or die("Couldn?t execute query.".mysql_error());

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}
$et = ">";
 
echo "<?xml version='1.0' encoding='utf-8'?$et\n";
echo "<rows>";
echo "<page>".$page."</page>";
echo "<total>".$total_pages."</total>";
echo "<records>".$count."</records>";
// be sure to put text data in CDATA

while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    echo "<row id='". $row['id']."'>";
//    echo "<cell>". $row['deviceid']."</cell>";
    //echo "<cell>". $row['nostruk']."</cell>";    
    echo "<cell>". $row['nostruk'] ."</cell>";
    echo "<cell>". $row['merchantname']."</cell>";    
    echo "<cell>". $row['kategori_name']."</cell>";
    //echo "<cell>0000</cell>";
    echo "<cell>". $row['tgltransaksi']."</cell>";
//     echo "<cell></cell>";
    echo "<cell>". $row['jumlah']."</cell>";
    echo "<cell>". $row['pajak']."</cell>";
    echo "</row>";
}
echo "</rows>";

?>
