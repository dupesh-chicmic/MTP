/*
 * Obsluga map po stronie Admina
 */

var map;
var markersArray = [];

function initialize() {
  var haightAshbury = new google.maps.LatLng(50.05925439136519, 19.93904151318358);
  var mapOptions = {
    zoom: 12,
    center: haightAshbury,

    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    navigationControl: true,
    navigationControlOptions: {
      style: google.maps.NavigationControlStyle.SMALL
    },

    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  google.maps.event.addListener(map, 'click', function(event) {
    deleteOverlays();
    addMarker(event.latLng);
  });
}

function addMarker(location) {
  marker = new google.maps.Marker({
    position: location,
    map: map
  });
  markersArray.push(marker);
   var a = location.lat().toFixed(6);
   var b = location.lng().toFixed(6);

   document.getElementById('CmsMap_mapCenter_wide').value = a;    //lat
   document.getElementById('CmsMap_mapCenter_long').value = b; //lng
   var c = map.getZoom();
     document.getElementById('CmsMap_zoom').value = c;

}


function deleteOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;

    document.getElementById('CmsMap_mapCenter_long').value = "";
    document.getElementById('CmsMap_mapCenter_wide').value = "";
  }
}