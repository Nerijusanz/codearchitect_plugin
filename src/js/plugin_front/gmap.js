class Gmap {

    constructor(){

        this.init();
    }

    init(){

        //console.log(ca_localize.gmap.map_zoom);

        var options = {
            zoom: Number(ca_localize.gmap.map_zoom),
            center:{ lat: Number(ca_localize.gmap.map_center.lat), lng: Number(ca_localize.gmap.map_center.long)},
            locations: ca_localize.gmap.locations
        };



        /*var locations = [
            {title:'vilnius',coords:{lat: 54.68916, lng: 25.2798}},
            {title:'kaunas',coords:{lat: 54.898521, lng: 23.903597}},
            {title:'klaipeda',coords:{lat: 55.71722, lng: 21.1175}},
            {title:'plunge',coords:{lat: 55.91139, lng: 21.84417}}
        ];*/


        function initMap() {

            var map = document.getElementById('map');
            
            if(map == null || map == undefined )
                return;

            var mapobj = new google.maps.Map (map, {
                zoom: options.zoom,
                center: options.center
            });


            for(var i=0;i<options.locations.length;i++){

                addMarker(options.locations[i]);

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



