<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<html>
<head>
  <meta charset="UTF-8">
  <meta content="user-scalable=yes, initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, width=device-width,target-densitydpi=medium-dpi" name="viewport">
  <title>Routebook</title>
</head>

<script src="./js/jquery-1.8.2.min.js"></script>
<script src="./js/slides.min.jquery.js"></script>

<link rel="stylesheet" href="./css/home.css">
<link rel="stylesheet" href="./css/global.css">
	
<script type="text/javascript">

	function sendInfo(uId){
		var str = "<form name='loginForm'>";
			str += "	<input type='hidden' name='uId' value=" + uId + ">";
			str += "</form>";
		
		document.body.innerHTML += str;
		
		document.loginForm.method = "POST";
		document.loginForm.action = "main.php";
		document.loginForm.submit();
		
	}

// mainSlider
	$(function(){
		$('#slides').slides({
			container: 'slides_container',
			preload: true,
			preloadImage: 'image/loading.gif',
			play: 5000,
			pause: 1500,
			hoverPause: true,
			slideSpeed: 200
		});
	});
</script>
</script>
<body>

<body>
<div id="wrapper">
	<div id="home_header">
		<img src="./image/header.png" class="header">
		<div class="logo">
			<a href="./home.php"><img src="./image/logo.png"></a>
		</div>
		<div class="navi">
			<div class="myPage">
				<a  id = "goMyPage">
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
		    <a href="#" onclick="FB.login();"><p class="text">[login]</p></a>
		</div>
	</div>

	
	<div class="welcome">
		<img src="./image/welcome_bar.png" class="img">
		<a href="#" id="hide"><img src="./image/welcome_bar_close.png" class="hide"></a>
	</div>
		
	<script>
		$('#hide').bind("click", function(){
			$('.welcome').slideToggle();
		});
	</script>
	
	<div class="map_slide"></div> 
	
	<div id="home_contents">

		<div class="update_slide">
			<img src="./image/slide_box.png" width="830px" height="340px" class="img">
			<div id="container">
			<!--<img src="img/frame.png" width="739" height="341" alt="Example Frame" id="frame">-->
				<div id="example">
					<div id="slides">
						<div class="slides_container">
							<div class="slide">
								<div class="item">
									<img src="image/slide-1.png" alt="Slide 1">
								</div>
								<div class="item">
									<img src="image/slide-2.jpg" alt="Slide 2">
								</div>
							</div>
							<div class="slide">
								<div class="item">
									<img src="image/slide-3.jpg" alt="Slide 3">
								</div>
								<div class="item">
									<img src="image/slide-4.jpg" alt="Slide 4">
								</div>
							</div>								
						</div>
						<a href="#" class="prev"><img src="image/left.png" width="30" height="49" alt="Arrow Prev"></a>
						<a href="#" class="next"><img src="image/right.png" width="30" height="49" alt="Arrow Prev"></a>					
					</div>			
				</div>
			</div>
		</div>
	

    <div id="fb-root"></div>
    
	<script>

    window.fbAsyncInit = function() {
        
        //초기화
        FB.init({
            appId      : '113773748780990', // App ID
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });
    
		var uId;
		
        //페이지 로드 했을시 호출 
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
				FB.api('/me', function(user) {
                    if (user) {
						uId = user.id;
						//location.href = "main.php?uId=" + user.id 	
						document.getElementById('goMyPage').href = "main.php?uId=" + uId;		
                    }
                });	

				;
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app
            } else {
                // the user isn't logged in to Facebook.
            }
        });
        
        //로그인 되는 순간 호출
        FB.Event.subscribe('auth.login', function(response) {
		 	FB.api('/me', function(user) {
				if (user) {
					location.href = "main.php?uId=" + user.id 			
				}
            });	
        });
		
        //로그아웃 되는 순간 호출
        FB.Event.subscribe('auth.logout', function(response) {    
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
    </script>
    
<!--    <h1>처음 로그인화면</h1>
    <hr><hr>
    
    <p>login 버튼</p>
    <a href="#" onclick="FB.login();">[login]</a><br>
    <hr>
    
    <p>like 버튼</p>
    <fb:like send="false" width="450" show_faces="true" font="verdana"></fb:like><br>
    <hr>-->
    
</body>
</html>
