@extends('layouts.app')

@section('title')
	Inicio
@endsection

@section('content')
<div id="map">
	
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	 
</script>
<script>
    d3.json('https://gist.githubusercontent.com/cyrilcherian/92b8f73dcbbb08fd42b4/raw/087202976663f9f3192bec8f0143cf3bc131c794/cities.json', function(error, incidents) {


      var geoData = incidents;
      var cscale = d3.scale.linear().domain([1, 3]).range(["#ff0000", "#ff6a00", "#ffd800", "#b6ff00", "#00ffff", "#0094ff"]); //"#00FF00","#FFA500"
     // var leafletMap = L.map('map').setView([20.19, 46.60], 3);

	var leafletMap = L.map('map').setView([10.997828918781796, -74.81552682962854], 13);
	var OpenStreetMap_Mapnik = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(leafletMap);


      //L.tileLayer("http://{s}.sm.mapstack.stamen.com/(toner-lite,$fff[difference],$fff[@23],$fff[hsl-saturation@20])/{z}/{x}/{y}.png").addTo(leafletMap);


      var svg = d3.select(leafletMap.getPanes().overlayPane).append("svg");
      var g = svg.append("g").attr("class", "leaflet-zoom-hide");

      // Use Leaflet to implement a D3 geometric transformation.
      function projectPoint(x, y) {
        var point = leafletMap.latLngToLayerPoint(new L.LatLng(y, x));
        this.stream.point(point.x, point.y);
      }

      var transform = d3.geo.transform({
        point: projectPoint
      });
      var path = d3.geo.path().projection(transform);
      leafletMap.on('moveend', mapmove);


      redrawSubset(geoData.features)

      function redrawSubset(subset) {
        path.pointRadius(3); // * scale);

        var bounds = path.bounds({
          type: "FeatureCollection",
          features: subset
        });
        var topLeft = bounds[0];
        var bottomRight = bounds[1];


        svg.attr("width", bottomRight[0] - topLeft[0])
          .attr("height", bottomRight[1] - topLeft[1])
          .style("left", topLeft[0] + "px")
          .style("top", topLeft[1] + "px");


        g.attr("transform", "translate(" + -topLeft[0] + "," + -topLeft[1] + ")");

        var start = new Date();


        var points = g.selectAll("path")
          .data(subset, function(d) {
            return d.geometry.coordinates;
          });
        points.enter().append("path");

        points.attr("d", path).attr("class", "points");

        points.style("fill-opacity", function(d) {
          if (d.group) {
            return (d.group * 0.1) + 0.2;
          }
        });

      }

      function mapmove(e) {
        //remove all points
        d3.selectAll(".points").remove();
        redrawSubset(geoData.features);
      }


    });
  </script>
@endsection