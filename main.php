
<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0" />
<meta property="fb:app_id" content=113773748780990 />
<meta property="og:url" content="http://routebook.pe.kr/main.php/" />
<link href="./css/jquery-ui-1.9.0.custom.min.css" rel="stylesheet" type="text/css"/> 
<link href="./css/base.css" rel="stylesheet" type="text/css"/> 
<link href="./css/main.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./css/global.css">

<script type="text/javascript" src="./js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.9.0.custom.min.js"></script>
<script type="text/javascript" src="./js/ui.geo_autocomplete.js"></script>

<script type="text/javascript"
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD5QgHb5w3nCzBMSlb21iQt8c6XtuKwHUw&sensor=false">	
</script>

<script type="text/javascript" src="./js/googleMap.js"></script>
</head>
<?

	$con = mysql_connect("localhost", "routebook", "routebook2013");
	
	if(!$con)
	{
		die('Could not connect: '. mysql_error());
	}
	
	mysql_select_db("routebook");
	
	
	$uId = $_GET["uId"];
	
	//$mId = $_POST["mId"];
	
	if($uId == NULL){
		//echo "<script>location.href = 'index.php'</script>";
	}
?>
<script type="text/javascript">
$(document).ready(function() {
	
	$.ajax({
		type: "POST",
		url: "get_mInfo.php",
		cache: false,
		data: "uId=<? echo $uId ?>",
		success: function (data, status){
			
			
			//var compareTmp = 'WELCOME';
			//console.log(compareTmp);
			var tt = "welcome";
				tt +="";
			
			if($.trim(data)=='welcome'){
				console.log("datas1");
			}else{
				console.log("datas2");
				var mDatas = $.parseJSON(data);
				loadDB(mDatas);
			}
			
			load();
			addMapListener();
			search();
		},
		error: onError
	});		

	
	$("#edit").bind('click', function(){
		edit(map.getCenter(), map.getZoom());
		addMapListener();
	});
	
	$("#resister").bind('click',function(){
		
		//removeListener();
		getMapOption();
		
		console.log("initCenter:" + initCenter);
		//console.log(markerArray[0].position);
		
		var markerSepArray= [];
		var uIdForGetIndex = {}
		uIdForGetIndex.uId = <? echo $uId ?>;
		uIdForGetIndex.mCenter = initCenter;
		uIdForGetIndex.mZoom = initZoom;
		
		markerSepArray.push(uIdForGetIndex);
		for( var i = 0; i<markerArray.length; i++){
			//eval("markerPosEle.n"+i+" = [markerArray["+i+"].position.Xa, markerArray["+i+"].position.Ya];");
			//eval("markerTitleEle.n"+i+" = markerArray["+i+"].title;");
			//eval("markerContentEle.n"+i+" = infowindowArray["+i+"].content;");
			var markerLatLng = {};
			markerLatLng.Ya = "" + markerArray[i].position.Ya;
			markerLatLng.Za = "" + markerArray[i].position.Za;
			
			var markerSeperate = {};
			markerSeperate.position  = markerLatLng;
			markerSeperate.title = markerArray[i].title;
			markerSeperate.content = infowindowArray[i].content;
			
			var marker
			markerSepArray.push(markerSeperate);
		}
		
		//console.log(markerSepArray);
		//console.log(JSON.stringify(markerSepArray));
		
				
		$.ajax({
			type: "POST",
			url: "insert_mInfo.php",
			cache: false,
			dataType: "JSON",
			data: { makers: JSON.stringify(markerSepArray) },
			success: function (data, status){
				console.log("mkInfo: " + data);
			},
			error: onError
		});
	})	
	
	
})
</script>
<title>Routebook</title>


<body>
    <div id="fb-root"></div>
    

	<script>
    window.fbAsyncInit = function() {
        
        //초기화
        FB.init({
            appId      : '113773748780990', // App ID
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true,  // parse XFBML
			redirect :false
        });
    
        //페이지 로드 했을시 호출 
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
				asLogin();
				
				//로그인한 유저 정보 뿌리기
				spread_logined_userInfo();
				
                FB.api('/me', function(user) {
                    if (user) {
						//유저정보 저장하기
						var uDataJson = {};
						uDataJson.uId = user.id;
						uDataJson.uName = user.name;
						console.log(JSON.stringify(uDataJson));
						
						$.ajax({
							type: "POST",
							url: "insert_uInfo.php",
							cache: false,
							dataType: "json",
							data: "uId=" + user.id +"&uName=" + user.name,
							data: {
								uData : JSON.stringify(uDataJson)
							},							
							//data: JSON.stringify(uDataJson),
							success: function (data, status){
								var my_uId=data;
								console.log(data);
							},
							error: onError
						});
						
						document.getElementById('goMyPage').href = "main.php?uId=" + user.id;
						
                    }
                });	
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app
				asLogout();
            } else {
                // the user isn't logged in to Facebook.
				asLogout();
            }
			
			
			var image = document.getElementById('ur_image');
			image.src = 'http://graph.facebook.com/' + <? echo $uId ?>+ '/picture';
			var id = document.getElementById('ur_id');

        });
        
        //로그인 되는 순간 호출
        FB.Event.subscribe('auth.login', function(response) {
			location.href = "main.php?uId=<? echo $uId ?>";
			asLogin();
        });
        //로그아웃 되는 순간 호출
        FB.Event.subscribe('auth.logout', function(response) {
			location.href = "main.php?uId=<? echo $uId ?>";
			asLogout();
        });
    };
     
    // Load the SDK Asynchronously
    (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/ko_KR/all.js";
        ref.parentNode.insertBefore(js, ref);
     }(document));
     //end Load the SDK Asynchronously
	 
	
	function onError(data, status){
		console.log("ajaxError");
	}
	
	function spread_logined_userInfo(){
		FB.api('/me', function(user) {
			if (user) {
				var image = document.getElementById('my_image');
				image.src = 'http://graph.facebook.com/' + user.id + '/picture';
				var name = document.getElementById('my_name');
				name.innerHTML = user.name
				var id = document.getElementById('my_id');
				//id.innerHTML = user.id
			}
        });	
	}
	
	function asLogin(){
		var div_login = document.getElementById('div_login');
		var logout = " <a href='' onclick='FB.logout();'>[로그아웃]</a><br>";
		div_login.innerHTML =  logout;
		
		var div_myInfo = document.getElementById('div_myInfo');
		var str_myInfo = "<img id='my_image' style='height:30px; width:30px;'/>";
			str_myInfo +="<span id='my_name' style='color: #D5D5D5'></span>";
		div_login.innerHTML +=  str_myInfo;
		
		spread_logined_userInfo();
	}
	
	function asLogout(){
		var div_login = document.getElementById('div_login');
		var login = " <a href='#' onclick='FB.login();'>[로그인]</a>";
		div_login.innerHTML =  login;
		
		var div_myInfo = document.getElementById('div_myInfo');
		var str_myInfo = "<p></p>";
		div_login.innerHTML +=  str_myInfo;

	}

    </script>
    
<!-- -->
<div id="wrapper">
	<div id="home_header">
		<img src="./image/header.png" class="header">
		<div class="logo">
			<a href="./home.php"><img src="./image/logo.png"></a>
		</div>
		<div class="navi">
			<div class="myPage">
				<a id="goMyPage">
					<img src="image/btn1.png" class="myPage_btn">
				</a>
			</div>
			<div class="newMap">
				<a href="#">
					<img src="image/btn2.png" class="newMap_btn">
				</a>
			</div>
			<div class="myMap">
				<a href="#" class="myMap_show">
					<img src="image/btn3.png" class="myMap_btn">
				</a>
			</div>
		</div>	
		<div class="user">
		    <div id="div_login" style="position: relative; float: left; z-index: 101; top: -10px;"></div>
		    <div id="div_myInfo"></div>
		</div>
	</div>
	
	<div class="welcome">
		<img src="./image/welcome_bar.png" class="img">
		<a href="#" id="hide"><img src="./image/welcome_bar_close.png" class="hide"></a>
	</div>
	<div class="welcome_bt">
	</div>
		
	<script>
		$('#hide').bind("click", function(){
			$('.welcome').slideToggle();
		});
	</script>
	
	<div class="map_slide"></div>
	
	<div id="home_contents" style="background-color: #ffffff;">	
<!--		<div id="mapp">
			
    <div id="div_login"></div>
    <div id="div_myInfo"></div> -->

		    <div id="map_make" style="position: relative; z-index: 102; padding: 20px; margin: 20px; top:-80px;">
				<div id="map_menu" width: 200px;  style="position: relative; float: left; margin-left: 20px; margin-bottom: 15px; left: 200px;">
				    <!--<input type = "button" id = "create" value = "create"/>-->
				    <a href="#" id="resister"><img src="./image/save.png" style="cursor: hand;"></a>
				    <!-- <input type = "button" id = "resister" value = "resister"/> -->
					<a href="#" id="edit"><img src="./image/edit.PNG" style="cursor:hand;"></a>
					<!-- <input type = "button" id = "edit" value = "edit" /> -->
					<input type = "button" id = "checkArray" value = "현재 배열 체크" />
				<img src="./image/bar.png"> <img src="./image/search.png"> <input type="text" id="searchAddress" value="검색하려는 여행지를 입력 후 엔터를 쳐보세요!" size="50" style="z-index:50" onClick="this.value=''" onblur="if(this.value == '') this.value='';"></p>
			</div>
			</div>	
							
				<div id="dialog" title="Resister spot">
					<div id ="formHolder"></div>
				</div>
				
				<div id="map_canvas" style="background-color: #c0c0c0;"></div>
			
		  	<div id="comment" style="margin-top: 20px; margin-bottom:20px; margin-left:40px;">
			<fb:comments href="http://www.routebook.pe.kr/main.php" num_posts="4" width="900"></fb:comments><br>
			</div>
		</div>
	</div>
</div>
</body>
</html>


