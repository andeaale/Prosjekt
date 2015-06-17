<?php
$con = mysql_connect("localhost","user","prosjekt");

if (!$con) {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("Test", $con);

$sth = mysql_query("SELECT humidity FROM dht22");
$rows = array();
$rows['name'] = 'Humidity';
while($r = mysql_fetch_array($sth)) {
    $rows['data'][] = $r['humidity'];
}

$sth = mysql_query("SELECT temperature FROM dht22");
$rows1 = array();
$rows1['name'] = 'Temperature';
while($rr = mysql_fetch_assoc($sth)) {
    $rows1['data'][] = $rr['temperature'];
}

$result = array();
array_push($result,$rows);
array_push($result,$rows1);


print json_encode($result, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
