<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<html>
<meta property="og:url" content="http://routebook.pe.kr/" />
<head>
  <meta charset="UTF-8">
  <title>Routebook Login Page</title>
</head>
<body>
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
    
        //페이지 로드 했을시 호출 
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
				FB.api('/me', function(user) {
                    if (user) {
						location.href = "main.php?uId=" + user.id;
                    }
                });	

				
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app
				location.href = "home.php";
            } else {
                // the user isn't logged in to Facebook.
				location.href = "home.php";
            }
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
    
</body>
</html>
