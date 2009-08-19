<?
if(!isset($_GET['short']) || $_GET['short'] == "")
	die("<div style=\"color:#444;width:300px;margin:20% auto 0;text-align:center;font:20pt Myriad Pro,Lucida Grande,Lucida Sans Unicde,sans-serif\">You clearly don't belong.<br/>So why are you still here?<br/><br/><a href=\"http://adityamukherjee.com\" style=\"font-size:12pt;color:#888;text-decoration:none;border-bottom:1px solid #DDD\">You should be here.</a></div>");

$u = "DB_USERNAME";
$p = "DB_PASSWORD";
mysql_connect('localhost', $u, $p);
mysql_select_db('DB_NAME');

	$row = "SELECT `long` FROM `mapping` WHERE `short`='". $_GET['short'] ."'";
	$row = mysql_query($row);
	$url = urldecode(mysql_result($row, 0, "long"));

header("Location:$url");
?>