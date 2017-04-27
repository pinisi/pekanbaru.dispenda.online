<?php
$YEAR_LEAP = 3;

$curr_year = date("Y");
$before = $curr_year - $YEAR_LEAP;

echo "<select name='tahun' id='tahun'>";

for ($i = $before; $i <= $curr_year; $i++) {
  if ($i == $curr_year) {$selected="selected";};
  echo "<option value='$i' $selected>$i</option>";
}
echo "</select>";
?>
