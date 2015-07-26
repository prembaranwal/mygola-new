/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

function initialize() {

  var markers = [];
  var map = new google.maps.Map(document.getElementById('map-canvas'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(-33.8902, 151.1759),
      new google.maps.LatLng(-33.8474, 151.2631));
  map.fitBounds(defaultBounds);

  // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
  
  $('#add').on('click',function(){
        if(markers[0] == undefined){
            alert('Please enter the restaurant location');
            return;
        } else {
            $('#latitude').val(markers[0]['internalPosition']['A']);
            $('#longitude').val(markers[0]['internalPosition']['F']);

            $("#addForm").validate({
                rules: {
                    hotel_name: "required",
                    password: {
                      required: true
                    },
                    password2: {
                        required: true,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                            hotel_name: {
                                required: "Please enter restaurant name"
                            },
                            password: {
                                required: "Please provide your password"
                            },
                            password2: {
                                required: "Please provide a password",
                                equalTo: "Please enter the same password as above"
                            },
                            email: "Please enter a valid email address",
                    }
                });

                if($("#addForm").valid()){
                    $.ajax({
                        url: 'add_action.php',
                        type: 'POST',
                        data: {
                            'hotel_name' : $('#hotel_name').val(),
                            'password' : $('#password').val(),
                            'email' : $('#email').val(),
                            'latitude' : $('#latitude').val(),
                            'status' : $('#status').val(),
                            'longitude' : $('#longitude').val(),
                            'isEdit' : $('#isEdit').val(),
                            'id':$('#id').val()
                        },
                        success: function(data) {
                                if(data == 'success'){
                                    alert('Merchant added successfully!')
                                    window.location = "dashboard.php";
                                } else {
                                    alert('Something is wrong, please try again!');
                                    window.location = "dashboard.php";
                                }
                        },
                        error: function(e) {
                                console.log(e.message);
                        }
                    });

                }
      }
});
}

google.maps.event.addDomListener(window, 'load', initialize);

