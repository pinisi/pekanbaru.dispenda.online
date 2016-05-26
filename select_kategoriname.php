<?php
include("init_dbconnection.php");

$sql = "SELECT * FROM kategori ORDER BY kategori_name";
$result = mysql_query($sql);

echo "<select name='kategori_name' id='kategori_name'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['kategori_name'] . "'>" . $row['kategori_name'] . "</option>";
}
echo "</select>";
?>
