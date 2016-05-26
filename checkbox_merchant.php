<?php
include("init_dbconnection.php");

$sql = "SELECT id, wpName FROM device ORDER BY wpName";
$result = mysql_query($sql);

echo '<div id="ScrollCB" name="ScrollCB" style="height:150px;width:200px;overflow:auto;display:none;font-size: 11px;border: 1px solid  #AAAAAA">';
while ($row = mysql_fetch_array($result)) {
    echo "<input type='checkbox' id='merchantid' name='merchantid' value='" . $row['id'] . "' style='font-size: 8px;'><span style='font-size: 10px;'>" . $row['wpName'] . "</span><br>";
}
echo "</div>";

?>
