<!DOCTYPE html>
<html>
<head>
	<title>Leaflet.draw vector editing handlers</title>

	<script src="js/leaflet_libs/leaflet-src.js"></script>
	<link rel="stylesheet" href="js/leaflet_libs/leaflet.css" />

	<script src="js/leaflet/src/Leaflet.draw.js"></script>
	<link rel="stylesheet" href="js/leaflet/dist/leaflet.draw.css" />

	<script src="js/leaflet/src/Toolbar.js"></script>
	<script src="js/leaflet/src/Tooltip.js"></script>

	<script src="js/leaflet/src/ext/GeometryUtil.js"></script>
	<script src="js/leaflet/src/ext/LatLngUtil.js"></script>
	<script src="js/leaflet/src/ext/LineUtil.Intersect.js"></script>
	<script src="js/leaflet/src/ext/Polygon.Intersect.js"></script>
	<script src="js/leaflet/src/ext/Polyline.Intersect.js"></script>
	<script src="js/leaflet/src/ext/TouchEvents.js"></script>

	<script src="js/leaflet/src/draw/DrawToolbar.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.Feature.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.SimpleShape.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.Polyline.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.Circle.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.Marker.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.Polygon.js"></script>
	<script src="js/leaflet/src/draw/handler/Draw.Rectangle.js"></script>


	<script src="js/leaflet/src/edit/EditToolbar.js"></script>
	<script src="js/leaflet/src/edit/handler/EditToolbar.Edit.js"></script>
	<script src="js/leaflet/src/edit/handler/EditToolbar.Delete.js"></script>

	<script src="js/leaflet/src/Control.Draw.js"></script>

	<script src="js/leaflet/src/edit/handler/Edit.Poly.js"></script>
	<script src="js/leaflet/src/edit/handler/Edit.SimpleShape.js"></script>
	<script src="js/leaflet/src/edit/handler/Edit.Circle.js"></script>
	<script src="js/leaflet/src/edit/handler/Edit.Rectangle.js"></script>
	<script src="js/leaflet/src/edit/handler/Edit.Marker.js"></script>
</head>
<body>
	<div id="map" style="height: 1000px; border: 1px solid #ccc"></div>

	<script>
		var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
			map = new L.Map('map', {center: new L.LatLng(14.997828918781796, -74.81552682962854), zoom: 6}),
			drawnItems = L.featureGroup().addTo(map);
		L.control.layers({
		 'osm':osm.addTo(map),
		 "google": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
                attribution: 'google'
            })
		}, {'drawlayer':drawnItems}, { position: 'topleft', collapsed: false }).addTo(map);
		map.addControl(new L.Control.Draw({
			edit: {
				featureGroup: drawnItems,
				poly : {
					allowIntersection : false
				}
			},
			draw: {
				polygon : {
					allowIntersection: false,
					showArea:true
				}
			}
		}));

		map.on('draw:created', function(event) {
			var layer = event.layer;

			drawnItems.addLayer(layer);
		});

	</script>
</body>
</html>
