
<?
	 
	$con = mysql_connect("localhost", "routebook", "routebook2013");
	
	if(!$con)
	{
		die('Could not connect: '. mysql_error());
	}
	
	mysql_select_db("routebook");
	
	$uId = $_POST['uId'];
	
	/*$mkSepData = $mkDatas[1];
	$mkTitle = "\"".$mkSepData['title']."\"";
	$mkContent = "\"".$mkSepData["content"]."\"";*/
	
	//mId 만들기
	$sql = "SELECT idx FROM user_Info WHERE uId = $uId";
	$result = mysql_query($sql, $con);
	$result_array = mysql_fetch_array($result);
	$idx = $result_array[0];
	$mId = 0;
	
	//db로부터 mCenter 불러오기
	$sql = "SELECT mCenter FROM map_Info WHERE idx=$idx and mId = $mId";
	$result = mysql_query($sql, $con);
	$result_array = mysql_fetch_array($result);
	$mCenter = $result_array[0];
	
	$sql = "SELECT mZoom FROM map_Info WHERE idx=$idx and mId = $mId";
	$result = mysql_query($sql, $con);
	$result_array = mysql_fetch_array($result);
	$mZoom = $result_array[0];

	
	
	
	//db로부터 맵정보 불러오기
	$sql = "SELECT * FROM marker_Info WHERE idx = $idx AND mId = $mId";
	$result = mysql_query($sql, $con);
	
	$mapNum = mysql_num_rows($result);
	if($mapNum > 0 ){
		$halfData = "{\"mCenter\":".$mCenter.", \"mZoom\":".$mZoom.", \"mkArray\":[";
		
		
		//db로부터 마커정보 불러오기
		while($row = mysql_fetch_array($result)){
	
			$halfData .="{\"position\":".$row['mkLatLng'].", \"title\":\"".$row['mkTitle']."\", \"content\":\"".$row['mkContent']."\"},";
			//{'position':{'lat':'68.39235897587034','lng':'-116.2109375'},'title':'3','content':'3'}
			
		}
		//
		$sql = "SELECT * FROM marker_Info WHERE idx = $idx AND mId = $mId";
		
		$result = mysql_query($sql, $con);
		$numrows = mysql_num_rows($result);
		if($numrows>0){
			$fullData = substr($halfData, 0, -1);
		}else{
			$fullData = $halfData;
		}
		
		$fullData .= "]}";
	}else{
		$fullData = "welcome";
	}
	
	//$test = "[{\"uId\":100002093563916,'mCenter':{'Xa':20,'Ya':10},'mZoom':2}, {'position':{'lat':'68.39235897587034','lng':'-116.2109375'},'title':'3','content':'3'}]";

	//echo $mZoom;
	echo $fullData;
	
?>