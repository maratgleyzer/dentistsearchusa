var globalMyLatlng = null;
var map = null;
var routerBoxer = null;
var directionService = null;
var directionsRenderer = null;
var l_address = $('#popup_directions_address').val();
var l_city = $('#popup_directions_city').val();
var l_zip = $('#popup_directions_zip').val();
var direction_routed = false;

function update_location(){
	l_address = $('#popup_directions_address').val();
	l_city = $('#popup_directions_city').val();
	l_zip = $('#popup_directions_zip').val();
}			
function addDirections(){
	routeBoxer = new RouteBoxer();
	directionService = new google.maps.DirectionsService();
	directionsRenderer = new google.maps.DirectionsRenderer({ 
		map: map
	});  
	directionsRenderer.setPanel(document.getElementById("panel_holder"));
}
function route(location){
	if(!location){
		var direction_val = $('#directions_input').val();
	}else{
		var direction_val = location;
	}
	if(direction_val != 'Enter your location here'){
		// Clear any previous route boxes from the map
		$('#get_direction_text').css('background','url("'+base_url+'/assets/images/ajax-loader-min.gif") no-repeat scroll 0 3px transparent');
		$('#get_direction_text').text('routing path...');
	//	$('#get_direction_text').text('please wait...');
		clearBoxes();
		var request = {
			origin: direction_val,
			destination: globalMyLatlng,
			travelMode: google.maps.DirectionsTravelMode.DRIVING,
			region: 'US'
		}
		// Make the directions request
		directionService.route(request, function(result, status){
			if (status == google.maps.DirectionsStatus.OK){
				directionsRenderer.setDirections(result);
				$('#toggle_direction').css('display','block');
				direction_routed = true;				
			}else{
				Sexy.error("<h1>Directions Failed</h1><p>"+status+"</p>");
			}
			$('#get_direction_text').css('background','url("'+base_url+'/assets/themes/default/images/ico-arrows.gif") no-repeat scroll 0 0 transparent');
			$('#get_direction_text').text('get directions');
		});
	}else{
		Sexy.alert('<h1>Location is Required</h1><p>Please enter your location to get a proper direction to reach this dentist.</p>'
				+'<div id="directions_form">' 
					+'<label>Adddress</label> <br/><input onchange="update_location()" id="popup_directions_address" class="d_field" type="text"/><br/>' 
					+'<label>City</label><br/> <input onchange="update_location()" id="popup_directions_city" class="d_field city_zip_autocomplete {autoc_width:338,autoc_type:\'city\'}" type="text"/><br/> '
					+'<label>Zip Code</label><br/> <input onchange="update_location()" id="popup_directions_zip" class="d_field city_zip_autocomplete {autoc_width:338,autoc_type:\'zip\'}" type="text"/>'
				+'</div>',{
					onComplete: 
					function(returnvalue){
						if(returnvalue){
							route(l_address+' '+l_city+' '+l_zip);
						}
					}
				}
		);
		init_autocomplete();
	}
}
// Clear boxes currently on the map
function clearBoxes() {
	for (var i = 0; i < markers.length; i++) {
	  markers[i].setMap(null);
	}
}
function center_location(address) {
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({ 'address': address}, function(results, status){
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
		}else {
			Sexy.error("<h1>Geocode Error</h1><p>Geocode was not successful for the following reason: "+status+"</p>");
		}
    });
}
function create_static_map(){
	if(direction_routed){
		var points = directionsRenderer.getDirections().routes[0].overview_path;
		static_map_path = '';
		skip = points.length/50;
		var order = '';
		for(i in points){
			if(skip > 1){
				if(i % parseInt(skip)){
					continue;
				}else{
					order += i+' - ';
					var rnd_lat = Math.round(points[i].lat()*10000)/10000; //round to 4 decimal numbers
					var rnd_lng = Math.round(points[i].lng()*10000)/10000;
				}
			}else{
				order += i+' - ';
				var rnd_lat = Math.round(points[i].lat()*10000)/10000; //round to 4 decimal numbers
				var rnd_lng = Math.round(points[i].lng()*10000)/10000;
			}
			static_map_path += '|'+rnd_lat+','+rnd_lng;
		}
	//	alert(order);
		static_map_zoom = map.getZoom() + 1;
		static_map_center = map.getCenter().lat()+','+map.getCenter().lng();
		static_map_origin_marker = 'color:green|label:A|'+directionsRenderer.getDirections().routes[0].overview_path[0].lat()+','+directionsRenderer.getDirections().routes[0].overview_path[0].lng();
		static_map_destination_marker = 'color:green|label:B|'+globalMyLatlng.lat()+','+globalMyLatlng.lng();
		static_map_url = 'http://maps.google.com/maps/api/staticmap?center='+static_map_center+'&size=640x640&zoom='+static_map_zoom+'&markers='+static_map_origin_marker+'&markers='+static_map_destination_marker+'&path=color:0x0000ff|weight:5'+static_map_path+'&sensor=false';
		$('#print_map_holder_img').attr('src',static_map_url);
	}else{
		static_map_destination_marker = 'color:red|label:X|'+globalMyLatlng.lat()+','+globalMyLatlng.lng();
		static_map_zoom = map.getZoom() + 1;
		static_map_center = map.getCenter().lat()+','+map.getCenter().lng();
		static_map_url = 'http://maps.google.com/maps/api/staticmap?center='+static_map_center+'&size=640x640&zoom='+static_map_zoom+'&markers='+static_map_destination_marker+'&sensor=false';
		$('#print_map_holder_img').attr('src',static_map_url);
	}
}

	
