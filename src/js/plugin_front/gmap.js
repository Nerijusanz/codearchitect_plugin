class Gmap {

    constructor(){

        this.init();
    }

    init(){

        //console.log(ca_localize.gmap.map_zoom);

        var options = {
            zoom: Number(ca_localize.gmap.map_zoom),
            center:{ lat: Number(ca_localize.gmap.map_center_lat), lng: Number(ca_localize.gmap.map_center_long)},
            locations: ca_localize.gmap.locations
        };

        function initMap() {

            var map = document.getElementById('map');
            
            if(map == null || map == undefined )
                return;

            var mapobj = new google.maps.Map (map, {
                zoom: options.zoom,
                center: options.center
            });



            if(options.locations.length > 0) {
                for (var i = 0; i < options.locations.length; i++) {

                    addMarker(options.locations[i]);

                }
            }

            function addMarker(location){

                var marker = new google.maps.Marker({
                    position: {lat:Number( location.lat ),lng:Number( location.long )}, //location.coords,
                    map: mapobj,
                    title: location.title
                });

            }

        }

        initMap();

    }




}

export default Gmap;



