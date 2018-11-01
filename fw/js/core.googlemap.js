function booklovers_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof BOOKLOVERS_STORAGE['googlemap_init_obj'] == 'undefined') booklovers_googlemap_init_styles();
	BOOKLOVERS_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		BOOKLOVERS_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: BOOKLOVERS_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		booklovers_googlemap_create(id);

	} catch (e) {
		
		dcl(BOOKLOVERS_STORAGE['strings']['googlemap_not_avail']);

	};
}

function booklovers_googlemap_create(id) {
	"use strict";

	// Create map
	BOOKLOVERS_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(BOOKLOVERS_STORAGE['googlemap_init_obj'][id].dom, BOOKLOVERS_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers)
		BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	booklovers_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].map)
			BOOKLOVERS_STORAGE['googlemap_init_obj'][id].map.setCenter(BOOKLOVERS_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function booklovers_googlemap_add_markers(id) {
	"use strict";
	for (var i in BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (BOOKLOVERS_STORAGE['googlemap_init_obj'].geocoder == '') BOOKLOVERS_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			BOOKLOVERS_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			BOOKLOVERS_STORAGE['googlemap_init_obj'].geocoder.geocode({address: BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = BOOKLOVERS_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					BOOKLOVERS_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						booklovers_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(BOOKLOVERS_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: BOOKLOVERS_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].title;
			BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				BOOKLOVERS_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				BOOKLOVERS_STORAGE['googlemap_init_obj'][id].map.setCenter(BOOKLOVERS_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								BOOKLOVERS_STORAGE['googlemap_init_obj'][id].map,
								BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			BOOKLOVERS_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function booklovers_googlemap_refresh() {
	"use strict";
	for (id in BOOKLOVERS_STORAGE['googlemap_init_obj']) {
		booklovers_googlemap_create(id);
	}
}

function booklovers_googlemap_init_styles() {
	// Init Google map
	BOOKLOVERS_STORAGE['googlemap_init_obj'] = {};
	BOOKLOVERS_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.booklovers_theme_googlemap_styles!==undefined)
		BOOKLOVERS_STORAGE['googlemap_styles'] = booklovers_theme_googlemap_styles(BOOKLOVERS_STORAGE['googlemap_styles']);
}