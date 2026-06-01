/*
 * Obsluga elementow do map po stronie Admina - ikonek
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

   document.getElementById('CmsMapElements_icoCenter_width').value = a; //lat
   document.getElementById('CmsMapElements_icoCenter_long').value = b;  //lng

}


function deleteOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;

    document.getElementById('CmsMapElements_icoCenter_long').value = "";
    document.getElementById('CmsMapElements_icoCenter_width').value = "";
  }
}