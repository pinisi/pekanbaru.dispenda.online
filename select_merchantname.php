<?php
include("init_dbconnection.php");

$sql = "SELECT * FROM merchant ORDER BY merchantname";
$result = mysql_query($sql);

echo "<select name='merchantname' id='merchantname'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['merchantname'] . "'>" . $row['merchantname'] . "</option>";
}
echo "</select>";
?>
