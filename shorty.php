<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css" media="screen">
		body {
			font:10pt Myriad Pro, sans-serif;
			line-height: 1.7em;
		}
		
		a {
			color: #333;
			text-decoration: none;
		}
		
		input[type=text] {
			border: 1px solid #DDD;
			padding: 4px 8px;
			font-size: 12pt;
		}
	</style>
<?
	if(!isset($_GET['url']) || trim($_GET['url']) == "")
		die('Nothing to shorten.');
	
	$host = parse_url($_GET['url']);
	if(in_array($host['host'], array("tr.im", "bit.ly", "tinyurl", "u.nu", "is.gd")))
		die('Nothing to shorten.');
		
	echo "<!--";
	print_r($_GET);
	echo "-->";
	
	$u = "DB_USERNAME";
	$p = "DB_PASSWORD";
	
	mysql_connect('localhost', $u, $p);
	mysql_select_db('DB_NAME');
	
	# check if URL already exists
	$url_exists = mysql_query("SELECT `short` FROM `mapping` WHERE `long` = '". strip_tags(urlencode($_GET['url'])) ."'");
	if(mysql_num_rows($url_exists) > 0){
		$n_row = mysql_result($url_exists, 0, 'short');
	} else {
		if($_GET['vanity'] == "{3}"):
			$row = "SELECT count(short) FROM `mapping` WHERE `vanity` != \"1\"";
			$row = mysql_query($row);
			$rows = mysql_result($row, 0, "count(short)");
			$n_row = base_convert($rows+1, 10, 36);
			$vanity = 0;
		else:
			$n_row = $_GET['vanity'];
			$vanity = 1;
		endif;
		$ins = "INSERT INTO `mapping` (`short`, `long`, `vanity`) VALUES ('$n_row', '". urlencode(preg_replace("/\/{2,}$/", "/", strip_tags($_GET['url'])))."', '$vanity');";
		mysql_query($ins);
	}
	
	$url = "http://⌘am.ws/$n_row";
?>
<title><?=$url?> — Short URL</title>
</head>
<body>
<a href="javascript:history.back()" accesskey='1'>&laquo; Go back</a> &nbsp; | &nbsp; <input type='text' value='<?=$url?>' id='short_url'/> &mdash; <?=$_GET['url']?>
<script type="text/javascript" charset="utf-8">
	document.getElementById('short_url').select()
</script>
</body>
</html>