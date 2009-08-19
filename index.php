<?
if(!isset($_GET['short']) || $_GET['short'] == "")
	die();

$u = "DB_USERNAME";
$p = "DB_PASSWORD";
mysql_connect('localhost', $u, $p);
mysql_select_db('DB_NAME');

	$row = "SELECT `long` FROM `mapping` WHERE `short`='". $_GET['short'] ."'";
	$row = mysql_query($row);
	$url = urldecode(mysql_result($row, 0, "long"));

header("Location:$url");
?>