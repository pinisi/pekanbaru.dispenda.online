<?php
include("init_dbconnection.php");

$sql = "SELECT distinct id,wpname FROM device ORDER BY wpName";
$result = mysql_query($sql);

echo "<select name='merchantid' id='merchantid'>";
echo "<option value='none' selected>[Pilih Salah Satu]</option>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . $row['wpname'] . "</option>";
}
echo "</select>";
?>
