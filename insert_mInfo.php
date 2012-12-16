
<?
	 
	$con = mysql_connect("localhost", "routebook", "routebook2013");
	
	if(!$con)
	{
		die('Could not connect: '. mysql_error());
	}
	
	mysql_select_db("routebook");
	
	$mkDatas = json_decode(stripslashes($_POST['makers']), true);
	
	$uId = $mkDatas[0]['uId'];
	$mCenter = $mkDatas[0]['mCenter'];
	$mCenterStr = "{\"Ya\":".$mCenter['Ya'].", \"Za\":".$mCenter['Za']."}";
	//$mCenterStr = "{\"Xa\":20,"." \"Ya\":".$mCenter['Ya']."}";
	$mZoom = $mkDatas[0]['mZoom'];
	
	/*$mkSepData = $mkDatas[1];
	$mkTitle = "\"".$mkSepData['title']."\"";
	$mkContent = "\"".$mkSepData["content"]."\"";*/
	
	//mId 만들기
	$sql = "SELECT idx FROM user_Info WHERE uId = '$uId'";
	$result = mysql_query($sql, $con);
	$result_array = mysql_fetch_array($result);
	$idx = $result_array[0];
	$mId = 0;
	
	//mId가 없는 경우 생성, 있으면 UPDATE 지도정보
	/*
	$sql = "SELECT COUNT(*) FROM map_Info WHERE idx = $idx AND mId = $mId";
	$result = mysql_query($sql, $con);
	$result_num = mysql_fetch_array($result);
	*/
	$sql = "SELECT * FROM map_Info WHERE idx = $idx AND mId = $mId";
	
	$result = mysql_query($sql, $con);
	$result_num = mysql_num_rows($result);
	
	
	if ($result_num == 0){
		$sql = "INSERT INTO map_Info (mId, idx, mZoom, mCenter) VALUES ($mId, $idx, $mZoom, '$mCenterStr')";
	}else{
		$sql = "UPDATE map_Info SET mId='$mId',idx=$idx, mZoom=$mZoom, mCenter='$mCenterStr' WHERE idx = $idx AND  mId = $mId";
	}
	
	mysql_query($sql, $con);
	
	
	//마커정보 저장
	for($i = 0 ; $i<count($mkDatas); $i++){
		if($i != 0){
			$mkId = $i - 1;
			$mkData = $mkDatas[$i];
			$mkTitle = $mkData['title'];
			$mkContent = $mkData['content'];
			$mkLatLng = $mkData['position'];
			$mkLatLngStr = "{\"Ya\":".$mkLatLng['Ya'].", \"Za\":".$mkLatLng['Za']."}";

			
			$sql = "SELECT COUNT(*) FROM marker_Info WHERE idx = $idx AND mkId = $mkId";
			$result = mysql_query($sql, $con);
			$result_num = mysql_fetch_array($result);
			
			if ($result_num[0] == "0"){
				$sql = "INSERT INTO marker_Info (idx, mId, mkId, mkTitle, mkContent, mkLatLng) 
						VALUES ($idx, $mId, $mkId, '$mkTitle', '$mkContent', '$mkLatLngStr')";
			}else{
				$sql = "UPDATE marker_Info SET idx=$idx, mId=$mId, mkId=$mkId, mkTitle='$mkTitle', mkContent='$mkContent', mkLatLng='$mkLatLngStr' 
						WHERE idx = $idx AND mkId = $mkId";
			}
			
			mysql_query($sql, $con);
		}
		
	}
	
	$Del_mkId = count($mkDatas) - 1;
	
	$sql = "DELETE FROM marker_Info WHERE idx = $idx AND mkId >= $Del_mkId";
	mysql_query($sql, $con);
	
	
	
	//db로부터 mCenter 불러오기
	$sql = "SELECT mCenter FROM map_Info idx = $idx AND WHERE mId = $mId";
	$result = mysql_query($sql, $con);
	$result_array = mysql_fetch_array($result);
	$mCenter = $result_array[0];
	
	//db로부터 mkLatLng 불러오기
	$sql = "SELECT mkLatLng FROM marker_Info WHERE idx = $idx AND mId = $mId";
	$result = mysql_query($sql, $con);
	$result_array = mysql_fetch_array($result);
	$mkLatLng = $result_array[0];
	
	//echo count($mkDatas);
	//echo json_encode($mCenter);
	echo json_encode($mkLatLng);
	//echo "\"".$mId."\"";
	//echo json_encode($mkDatas);
?>