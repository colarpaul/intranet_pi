////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ------------------------------------------------- Google Maps ------------------------------------------------ //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Setup Google Maps to have unique stylings
 *
 * @return void
 */

 if ($(document).find('#lage-map')[0])
 {
    // Basic options for a simple Google Map
    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom : 18,

        // What happens when the user uses the scrollwheel when the cursor is over the map
        scrollwheel : true,
        disableDoubleClickZoom : false,
        mapTypeControl : true,
        mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite']
       },
       mapTypeId : 'roadmap',

        // The latitude and longitude to center the map (always required)
        center : new google.maps.LatLng(latitude, longitude),

        // Map styles
        styles : [
        {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [
            {
                "color": "#444444"
            }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [
            {
                "color": "#f2f2f2"
            }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [
            {
                "visibility": "off"
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "all",
            "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [
            {
                "visibility": "simplified"
            }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [
            {
                "visibility": "off"
            }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [
            {
                "visibility": "off"
            }
            ]
        },
        {
            "featureType": "water",
            "elementType": "all",
            "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "visibility": "on"
            }
            ]
        }
        ]
    };


    // Get the HTML DOM element
    var mapElement = document.getElementById('lage-map');

    // Create the Google Map using the element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    // Create a new info-box
    var infowindow = new google.maps.InfoWindow
    ({
        content : pinAddress
    });

    // Create a marker with a unique icon
    // 
    // 
    var marker = new google.maps.Marker
    ({
        position : new google.maps.LatLng(latitude, longitude),
        map      : map,
        icon     : '/images/googleMaps-icon.png'
    });

    // Listen for click events on the marker, to display an info-box with the address
    marker.addListener('click', function()
    {
        infowindow.open(map, marker);
    });
}

