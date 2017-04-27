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

//   $awal = substr($_GET['tanggal1'],3);
  // $akhir = substr($_GET['tanggal2'],3);

   $awal = $_GET['start'];
   $akhir = $_GET['end'];

//   $where .= " AND (tgltransaksi between concat(str_to_date(concat('01/','" . $awal . "'), '%d/%m/%Y'),' 00:00:00')"
  // . " AND concat(last_day(str_to_date(concat('01/','" . $akhir . "'),'%d/%m/%Y')),' 23:59:59'))";

   $where .= " AND (tgltransaksi between concat(str_to_date(concat('01/','" . $awal . "'), '%d/%m/%Y'),' 00:00:00')"
   . " AND concat(last_day(str_to_date(concat('01/','" . $akhir . "'),'%d/%m/%Y')),' 23:59:59'))";

}

$sql= "SELECT count(*) as count FROM struk,device, merchant"
. " WHERE struk.deviceid = device.deviceid AND device.merchantid = merchant.id"
. $where . " group by DATE_FORMAT(tgltransaksi,'%M/%Y'), merchantname, struk.deviceid";

//echo $sql;
//mysql_query("INSERT into log (logtext) values (\"" . $sql . "\")");

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

$SQL = "SELECT merchantname, ucase(device.wpname) as deviceid, DATE_FORMAT(tgltransaksi,'%M-%Y') as 'bulan', sum(round( (select nilai_pajak from kategori where device.kategoriid = id) * struk.jumlah, 0)) as pajak,merchant.address, (select kategori_name from kategori where id = device.kategoriid) as kategori "
. " FROM struk,device,merchant"
. " WHERE struk.deviceid = device.deviceid AND device.merchantid=merchant.id"
. $where . " group by DATE_FORMAT(tgltransaksi,'%M/%Y'), merchantname, struk.deviceid"
. " ORDER BY $sidx $sord LIMIT $start , $limit";

//echo $SQL;
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
$grandtotal = 0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    echo "<row>";
    echo "<cell>". $row['merchantname'] ."</cell>";
    echo "<cell>". $row['deviceid'] ."</cell>";
    echo "<cell>". $row['bulan']."</cell>";    
    echo "<cell>". $row['pajak']."</cell>";
    echo "<cell>". $row['deviceid']."|".$row['bulan']."|" . $row['pajak'] . "|" . $row['merchantname']. "|" . $row['address'] . "|" . $row['kategori'] . "</cell>";
    echo "</row>";
    $grandtotal += $row['pajak'];
}
echo "<userdata name='wpname'>Total:</userdata>";
echo "<userdata name='pajak'>". $grandtotal . "</userdata>";
echo "</rows>";

?>
