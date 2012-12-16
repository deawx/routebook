
var initCenter, initZoom, markerArray, infowindowArray; 
	
var map;
var mapListener;

var markerArray = [];
var infowindowArray = [];

var greenIcon = new google.maps.MarkerImage(
		   "http://labs.google.com/ridefinder/images/mm_20_green.png",
		   new google.maps.Size(12, 20),
		   new google.maps.Point(0, 0),
		   new google.maps.Point(6, 20)
		);

var dialog;

function loadDB(jsonData) {
	initCenter = new google.maps.LatLng(jsonData.mCenter.Ya, jsonData.mCenter.Za);
	initZoom = jsonData.mZoom;
	for(var i in jsonData.mkArray){
		var jsonMarker = jsonData.mkArray[i];
		var marker = new google.maps.Marker({
			icon : greenIcon,
			position : new google.maps.LatLng(jsonMarker.position.Ya, jsonMarker.position.Za),
			title : jsonMarker.title,
			map : map
		}); 
		
		var infowindow = new google.maps.InfoWindow({
			content : jsonMarker.content,
			position : new google.maps.LatLng(jsonMarker.position.Ya, jsonMarker.position.Za),
			disableAutoPan : true
		});
			
		google.maps.event.addListener(marker, 'mouseover', function(event) {	
			
			showInfoWindow(marker);
		
			google.maps.event.addListener(marker, 'mouseout', function(event) {	
				
				hideInfoWindow(marker);
				
			});  		
			
		});
		
		marker.leftClickListener = google.maps.event.addListener(marker, 'click', function(event) {
			 editDialog(event.latLng, marker); 
			 google.maps.event.removeListener(mapListener);
			// $("#exposeMask").css("z-index","990");
		});
		
		marker.doubleLeftClickListener = google.maps.event.addListener(marker, 'doubleclick', function(event) {
			 google.maps.event.removeListener(marker.doubleLeftClickListener);
			// $("#exposeMask").css("z-index","990");
		});
		
		marker.rightClickListener = google.maps.event.addListener(marker, 'rightclick', function(event) {
				deleteSpot(marker);
		});
		
		markerArray.push(marker);
		infowindowArray.push(infowindow);
	}
}

function load(){	//the world map always loaded first
	
	var center, zoom;
	
	dialog = $( "#dialog" ).dialog({ autoOpen: false, 
		closeOnEscape : false ,
		show : { effect: 'drop', direction: "up"}
		});
	
	if(initCenter, initZoom){	//when get data from php
		center = initCenter; 			//new google.maps.LatLng(num, num);
		zoom = initZoom;
		initCenter = intiZoom = null;
	}
	else {
		center = new google.maps.LatLng(20, 10);
		zoom = 2;
	}
	
	var markerLoadedArray = markerArray;
		markerArray = [];
		
	var infowindowLoadedArray = infowindowArray;
		infowindowArray = [];		
		
	map = null;
	
	var mapOptions = {
		center : center,
		zoom : zoom,
		minZoom : 2,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

	for(var i in markerLoadedArray) {
		loadInfo();
	}
	
	function loadInfo(){
		var marker = new google.maps.Marker({
			icon : greenIcon,
			position : markerLoadedArray[i].getPosition(),
			title : markerLoadedArray[i].getTitle(),
			map : map
		}); 
		
		var infowindow = new google.maps.InfoWindow({
			content : infowindowLoadedArray[i].getContent(),
			position : markerLoadedArray[i].getPosition(),
			disableAutoPan : true
		});
			
		google.maps.event.addListener(marker, 'mouseover', function(event) {	
			
			showInfoWindow(marker);
		
			google.maps.event.addListener(marker, 'mouseout', function(event) {	
				
				hideInfoWindow(marker);
				
			});  		
			
		});
		
		marker.leftClickListener = google.maps.event.addListener(marker, 'click', function(event) {
			 editDialog(event.latLng, marker); 
			 google.maps.event.removeListener(mapListener);
			// $("#exposeMask").css("z-index","990");
		});
		
		marker.doubleLeftClickListener = google.maps.event.addListener(marker, 'doubleclick', function(event) {
			 google.maps.event.removeListener(marker.doubleLeftClickListener);
			// $("#exposeMask").css("z-index","990");
		});
		
		marker.rightClickListener = google.maps.event.addListener(marker, 'rightclick', function(event) {
				deleteSpot(marker);
		});
		
		markerArray.push(marker);
		infowindowArray.push(infowindow);
	}
	
}

function edit(getCenter, getZoom){	//the world map always loaded first
	
	var center, zoom;
	
	initCenter = getCenter;
	initZoom = getZoom;
	dialog = $( "#dialog" ).dialog({ autoOpen: false, 
		closeOnEscape : false ,
		show : { effect: 'drop', direction: "up"}
		});
	
	if(initCenter, initZoom){	//when get data from php
		center = initCenter; 			//new google.maps.LatLng(num, num);
		zoom = initZoom;
		initCenter = intiZoom = null;
	}
	else {
		center = new google.maps.LatLng(20, 10);
		zoom = 2;
	}
	
	var markerLoadedArray = markerArray;
		markerArray = [];
		
	var infowindowLoadedArray = infowindowArray;
		infowindowArray = [];		
		
	map = null;
	
	var mapOptions = {
		center : center,
		zoom : zoom,
		minZoom : 2,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

	for(var i in markerLoadedArray) {
		loadInfo();
	}
	
	function loadInfo(){
		var marker = new google.maps.Marker({
			icon : greenIcon,
			position : markerLoadedArray[i].getPosition(),
			title : markerLoadedArray[i].getTitle(),
			map : map
		}); 
		
		var infowindow = new google.maps.InfoWindow({
			content : infowindowLoadedArray[i].getContent(),
			position : markerLoadedArray[i].getPosition(),
			disableAutoPan : true
		});
			
		google.maps.event.addListener(marker, 'mouseover', function(event) {	
			
			showInfoWindow(marker);
		
			google.maps.event.addListener(marker, 'mouseout', function(event) {	
				
				hideInfoWindow(marker);
				
			});  		
			
		});
		
		marker.leftClickListener = google.maps.event.addListener(marker, 'click', function(event) {
			 editDialog(event.latLng, marker); 
			 google.maps.event.removeListener(mapListener);
			// $("#exposeMask").css("z-index","990");
		});
		
		marker.doubleLeftClickListener = google.maps.event.addListener(marker, 'doubleclick', function(event) {
			 google.maps.event.removeListener(marker.doubleLeftClickListener);
			// $("#exposeMask").css("z-index","990");
		});
		
		marker.rightClickListener = google.maps.event.addListener(marker, 'rightclick', function(event) {
				deleteSpot(marker);
		});
		
		markerArray.push(marker);
		infowindowArray.push(infowindow);
	}
	
}
/* create */
function create() {	//create new map
	
	dialog = $( "#dialog" ).dialog({ autoOpen: false, 
									closeOnEscape : false ,
									show : { effect: 'drop', direction: "up" }
									}); 
	
	map = null;
		
	var mapOptions = {
			center : new google.maps.LatLng(20, 10),
			zoom : 2,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		};

	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
		mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
			placeMaker(event.latLng);
			google.maps.event.removeListener(mapListener);
		});
}

function placeMaker(location) {
	var marker = new google.maps.Marker({
		icon : greenIcon,
		position : location,
		map : map
	});
	console.log(location);
	formDialog(location, marker);
	
	google.maps.event.addListener(marker, 'mouseover', function(event) {	//on the marker
		showInfoWindow(marker);
		
		google.maps.event.addListener(marker, 'mouseout', function(event) {	//on the marker
			hideInfoWindow(marker);
		}); 
	}); 
	
	marker.leftClickListener = google.maps.event.addListener(marker, 'click', function(event) {	//on the kk
		 editDialog(event.latLng, marker); 
		 google.maps.event.removeListener(mapListener);
		// $("#exposeMask").css("z-index","990");
	});
	
	marker.doubleLeftClickListener = google.maps.event.addListener(marker, 'doubleclick', function(event) {
		 google.maps.event.removeListener(marker.doubleLeftClickListener);
		// $("#exposeMask").css("z-index","990");
	});
	
	marker.rightClickListener = google.maps.event.addListener(marker, 'rightclick', function(event) {	//on the marker
			deleteSpot(marker);
	});
	
	markerArray.push(marker);
};
/*  */
function formDialog(location, marker) {
	var html = "<form id='contentForm'>";
	/*  html += "	<input type='hidden' name='id' value="+facebookId+">"; */
	 	html += "	 <p>save the happy time...^^<p>";
	 	html += "	 <input type='text' name='title' id='title' style='width:260px'>";
 	 	html += "	 <textarea name='content' id='content' style='width:260px'></textarea>";
	  	html += "	<input type='button' value='save' id='save'>";
	 	html += "	<input type='button' value='cancle' id='cancle'>";
	 	html += "</form>";
		 	  
	document.getElementById('formHolder').innerHTML = html;	
	
	 $( "#dialog" ).dialog( "open" );
	/*  $("#dialog").dialog( "option", "show", { effect: 'drop', direction: "up" } ); */
	 
	 $("#save").bind("click", function(){
		 saveSpot(location, marker);
			mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
				placeMaker(event.latLng);	
				google.maps.event.removeListener(mapListener);
			});
		});
	 
		$("#cancle").bind("click", function(){
			cancleSpot();
			mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
				placeMaker(event.latLng);	
				google.maps.event.removeListener(mapListener);
			});
		});		 
}

function saveSpot(location, marker) {
	
	var title= $("#title").val();
	marker.setTitle(title);
	
   	var content= $("#content").val();	//紐?湲?옄 ?댁긽 ?낅젰?댁＜?몄슂 ++option
   	
   	infowindow(location, content);
	    	
   	document.getElementById('contentForm').reset();
   	$( "#dialog" ).dialog( "close" );
 }

function cancleSpot() {
	document.getElementById('contentForm').reset();
	$( "#dialog" ).dialog( "close" );
	
	markerArray[markerArray.length-1].setMap(null); 
	markerArray.pop();	//delete the last index in the markerArray
}

function infowindow(location, content) {
	var infowindow = new google.maps.InfoWindow({
		content : content,
		position : location,
		disableAutoPan : true
	});
	
	infowindowArray.push(infowindow);
};
/*  */
function editDialog(location, marker) {
	var infowindow = [];
	for(var i in markerArray) {
        if(marker==markerArray[i]) {
        	infowindow = infowindowArray[i];
        } 
    }
		
	var html = "<form id='contentForm'>";
	html += "	<p>modifying...^^<p>";
	html += "	 <input type='text' name='title' id='title' style='width:260px' value="+marker.getTitle()+">";
 	html += "	<textarea name='content' id='content' style='width:260px'>"+infowindow.getContent()+"</textarea>";
  	html += "	<input type='button' value='modify' id='modify'>";
  	html += "	<input type='button' value='cancle' id='modifyCancle'>";
 	html += "	<input type='button' value='delete' id='delete'>";
 	html += "</form>";
		 	  
	document.getElementById('formHolder').innerHTML = html;	
	
	$( "#dialog" ).dialog( "open" );
	
	$("#modify").bind("click", function(){
		modifySpot(location, marker, infowindow);
		mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
			placeMaker(event.latLng);	
			google.maps.event.removeListener(mapListener);
		});
	});
	
	$("#modifyCancle").bind("click", function(){
		document.getElementById('contentForm').reset();
    	$( "#dialog" ).dialog( "close" );
		mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
			placeMaker(event.latLng);	
			google.maps.event.removeListener(mapListener);
		});
	});
	 
	$("#delete").bind("click", function(){
		deleteSpot(marker);
		mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
			placeMaker(event.latLng);	
			google.maps.event.removeListener(mapListener);
		});
	});		 
}

function modifySpot(location, marker, infowindow) {
	
	var title= $("#title").val();
	marker.setTitle(title);
	
   	var content= $("#content").val();
	infowindow.setContent(content);
	    	
	document.getElementById('contentForm').reset();
	$( "#dialog" ).dialog( "close" );
	
 }
 
function deleteSpot(marker) {
	
	document.getElementById('contentForm').reset();
	
	$( "#dialog" ).dialog( "close" );
	
	for(var i in markerArray) {
		if(marker==markerArray[i]) {
			markerArray[i].setMap(null); 
			markerArray.splice(i, 1);
			infowindowArray[i].setMap(null);
			infowindowArray.splice(i, 1);
		} 
    }
 }

function showInfoWindow(marker) {	
    for(var i in markerArray) {
        if(marker==markerArray[i]) {
        	infowindowArray[i].setMap(map);
        } 
    }
}

function hideInfoWindow(marker) {
    for(var i in markerArray) {
        if(marker==markerArray[i]) {
        	infowindowArray[i].setMap(null);
        } 
    }
}

function deleteSpot(marker) {
	
	document.getElementById('contentForm').reset();
	
	$( "#dialog" ).dialog( "close" );
	
	for(var i in markerArray) {
		if(marker==markerArray[i]) {
			markerArray[i].setMap(null); 
			markerArray.splice(i, 1);
			infowindowArray[i].setMap(null);
			infowindowArray.splice(i, 1);
		} 
    }
 }
function removeListener(){
	
	google.maps.event.removeListener(mapListener);
	
	for(var i in markerArray) {
		 google.maps.event.removeListener(markerArray[i].leftClickListener);
	}

	for(var i in markerArray) {
		 google.maps.event.removeListener(markerArray[i].rightClickListener);
	}
}

function addMapListener() {
	mapListener = google.maps.event.addListener(map, 'click', function(event) {		 	//on the map
		placeMaker(event.latLng);
		google.maps.event.removeListener(mapListener);
	});
}

/* search  */
function search() {
	$('#searchAddress').geo_autocomplete({
		select: function(_event, _ui) {
			if (_ui.item.viewport) map.fitBounds(_ui.item.viewport);
		}
	});
}

function getMapOption() {	//center, zoom
	initCenter = map.getCenter();
	initZoom = map.getZoom();
	console.log(initCenter);
	console.log(initZoom);
}
