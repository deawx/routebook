<?
	$con = mysql_connect("localhost", "routebook", "routebook2013");
	
	if(!$con)
	{
		die('Could not connect: '. mysql_error());
	}
	
	mysql_select_db("routebook");

	$uData = json_decode(stripslashes($_POST["uData"]), true);
	
	$uId = "\"".$uData['uId']."\"";
	$uId = $uData['uId'];
	$uName = "\"".$uData["uName"]."\"";
	//$uName = preg_replace("/\s+/","",$uData['uName']);
	
	
	$sql = "SELECT COUNT(*) FROM user_Info WHERE uId='$uId'";
	
	$result = mysql_query($sql, $con);
	$row = mysql_fetch_array($result);
	$numrows = mysql_num_rows($result);
	
	if ($row[0] == "0"){
		$sql = "INSERT INTO user_Info (uId, uName) VALUES ($uId, $uName)";
		mysql_query($sql, $con);
	}else{
		
	}
	
	//echo json_encode($uData);
	//echo $row[0];
?>