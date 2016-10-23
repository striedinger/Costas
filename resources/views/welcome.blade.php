@extends('layouts.app')

@section('title')
	Inicio
@endsection

@section('content')
<div id="map">
	
</div>

<div id="controls">
          <div class="wrapper">
            <h2>Herramientas</h2>


            <form class="form-horizontal">
<fieldset>

      <!-- Form Name -->
      <legend>Seleccionar Región</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="Xi">Xi</label>  
        <div class="col-md-7">
        <input id="Xi" name="Xi" type="text" placeholder="X inicial" class="form-control input-md">
          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="Xf">Xf</label>  
        <div class="col-md-7">
        <input id="Xf" name="Xf" type="text" placeholder="X final" class="form-control input-md">
          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="Yf">Yf</label>  
        <div class="col-md-7">
        <input id="Yf" name="Yf" type="text" placeholder="Y final" class="form-control input-md">
          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="Yi">Yi</label>  
        <div class="col-md-7">
        <input id="Yi" name="Yi" type="text" placeholder="Y inicial" class="form-control input-md">
          
        </div>
      </div>

      <!-- Button -->
      <div class="form-group row">
        
        <div class="col-md-7">
          <button id="query" name="query" class="btn btn-primary">Ejecutar consulta</button>
        </div>
         
        <div class="col-md-4">
          <button id="clear" name="clear" class="btn ">Limpiar</button>
        </div>
      </div>

      </fieldset>
      </form>

          </div>
        <div>
@endsection

@section('scripts')
<script type="text/javascript">
	 
</script>
<script>


      d3.json('https://gist.githubusercontent.com/cyrilcherian/92b8f73dcbbb08fd42b4/raw/087202976663f9f3192bec8f0143cf3bc131c794/cities.json', function(error, incidents) 
      {


        var geoData = incidents;
        var cscale = d3.scale.linear().domain([1, 3]).range(["#ff0000", "#ff6a00", "#ffd800", "#b6ff00", "#00ffff", "#0094ff"]); //"#00FF00","#FFA500"
       // var map = L.map('map').setView([20.19, 46.60], 3);

  	    var map = L.map('map', {editable: true}).setView([14.997828918781796, -74.81552682962854],6);
        var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
        drawnItems = L.featureGroup().addTo(map);
        L.control.layers(
        {

         'osm':osm.addTo(map),
         "google": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
                    attribution: 'google'
                })
        }, 
        {'drawlayer':drawnItems}, 
        { position: 'topleft', collapsed: false}
        ).addTo(map);


    L.EditControl = L.Control.extend({

        options: {
            position: 'topleft',
            callback: null,
            kind: '',
            html: ''
        },

        onAdd: function (map) {
            var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar'),
                link = L.DomUtil.create('a', '', container);

            link.href = '#';
            link.title = 'Crear un nuevo ' + this.options.kind;
            link.innerHTML = this.options.html;
            L.DomEvent.on(link, 'click', L.DomEvent.stop)
                      .on(link, 'click', function () {
                        window.LAYER = this.options.callback.call(map.editTools);
                      }, this);

            return container;
        }

    });




    L.NewRectangleControl = L.EditControl.extend({

        options: {
            position: 'topleft',
            callback: map.editTools.startRectangle,
            kind: 'rectangle',
            html: '⬛'
        }

    });

 
 
 
    map.addControl(new L.NewRectangleControl({

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
        }
    ));

 map.on('editable:drawing:start', function(e) {  
      drawnItems.clearLayers();
 });
   map.on('editable:drawing:end', function(e) {  
      console.log(e);
      
      var coordinates = e.layer.getLatLngs()[0];
      console.log(coordinates);
      $("#Xi").val(coordinates[0].lat);
      $("#Xf").val(coordinates[2].lat);
      $("#Yi").val(coordinates[1].lng);
      $("#Yf").val(coordinates[3].lng);


      var layer = e.layer;
      drawnItems.addLayer(layer);

  

  });

   $("#query").click(function(e) {
     e.preventDefault();

     alert("realizando el query" + JSON.stringify(drawnItems.toGeoJSON()));
     console.log(drawnItems.toGeoJSON());

   });

   $("#clear").click(function(e) {
     e.preventDefault();

      $("#Xi").val("");
      $("#Xf").val("");
      $("#Yi").val("");
      $("#Yf").val("");
      drawnItems.clearLayers();

   });

   $("#Xi, #Xf, #Yi, #Yf").click(function(e) {
     e.preventDefault();

     if($("#Xi").val()!="" && $("#Xf").val()!="" && $("#Yi").val()!="" && $("#Yf").val()!="" ){
       drawnItems.clearLayers();
       // define rectangle geographical bounds
       var bounds = [[$("#Xi").val(), $("#Yi").val()], [$("#Xf").val(), $("#Yf").val()]];
        // add rectangle passing bounds and some basic styles
       var polygon = L.rectangle(bounds,  
        { interactive: true, 
          draggable: true, 
          transform: true, 
          color: "red", 
          weight: 1}
        ).addTo(drawnItems);
       
       polygon.transform.enable();
       polygon.dragging.enable();
       

     }

   });
  








    
 



        //L.tileLayer("http://{s}.sm.mapstack.stamen.com/(toner-lite,$fff[difference],$fff[@23],$fff[hsl-saturation@20])/{z}/{x}/{y}.png").addTo(map);


        var svg = d3.select(map.getPanes().overlayPane).append("svg");
        var g = svg.append("g").attr("class", "leaflet-zoom-hide");

        // Use Leaflet to implement a D3 geometric transformation.
        function projectPoint(x, y) {
          var point = map.latLngToLayerPoint(new L.LatLng(y, x));
          this.stream.point(point.x, point.y);
        }

        var transform = d3.geo.transform({
          point: projectPoint
        });
        var path = d3.geo.path().projection(transform);
        map.on('moveend', mapmove);


        redrawSubset(geoData.features)

        function redrawSubset(subset) {
          path.pointRadius(2); // * scale);

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

//******************
////////////////////////////////////////////////////////////////////////////////
function interpolateArr(array, insert) {
  var res = [];
  array.forEach(function(p, i, arr) {
    res.push(p.concat());

    if (i < arr.length - 1) {
      var diff = [arr[i + 1][0] - p[0], arr[i + 1][1] - p[1]];
      for (var i = 1; i < insert; i++) {
        res.push([p[0] + (diff[0] * i) / insert, p[1] + (diff[1] * i) / insert]);
      }
    }
  });

  return res;
}

////////////////////////////////////////////////////////////////////////////////
var polygon = new L.Polygon(
  L.GeoJSON.coordsToLatLngs(

    // ~ 13 000 points
    interpolateArr([
      [113.97697448730469, 22.403410892712124],
      [113.98658752441405, 22.38373008592495],
      [114.01268005371094, 22.369126397545887],
      [114.02778625488281, 22.38563480185718],
      [114.04701232910156, 22.395157990290755],
      [114.06005859375,    22.413567638369805],
      [114.06280517578125, 22.432609534876796],
      [114.04838562011717, 22.444668051657157],
      [114.04289245605469, 22.44847578656544],
      [114.03259277343749, 22.444668051657157],
      [114.01954650878906, 22.447206553211814],
      [113.99620056152344, 22.436417600763114],
      [113.98178100585938, 22.420549970290875],
      [113.97697448730469, 22.403410892712124]
    ], 1000)
  ), {
    color: '#f00',
    interactive: true,
    draggable: true,
    transform: true
  }).addTo(map);
polygon.transform.enable();


    });

  </script>
@endsection