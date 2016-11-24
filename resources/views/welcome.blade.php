@extends('layouts.app')

@section('title')
	Inicio
@endsection

@section('content')
<div id="map">
	
</div>

<div id="controls" class="fa fa-minus">
  <a class="minimizar" id="ocultar_controls" href="#"> ocultar</a>
  <div class="wrapper">
    <form class="form-horizontal">
      <fieldset>
   <!-- <h2 class="text-center">Herramienta Selección de región</h2>-->
        <!-- Form Name -->
        <legend>Seleccionar Región</legend>
        <!-- Latitud-->
        <div class="row">
          <h4 class="col-md-offset-1 col-md-3"><p class="fa fa-long-arrow-right"> </p> Latitud</h4>
          <!-- Text input-->
          <div class="form-group col-md-4">
            <label class="col-md-2 control-label" for="Xi">Xi</label>
            <div class="col-md-10">
              <input id="Xi" name="Xi" type="text" placeholder="X inicial" class="form-control input-md">
              
            </div>
          </div>
          
          <!-- Text input-->
          <div class="form-group col-md-4">
            <label class="col-md-2 control-label" for="Xf">Xf</label>
            <div class="col-md-10">
              <input id="Xf" name="Xf" type="text" placeholder="X final" class="form-control input-md">
              
            </div>
          </div>
        </div>
        <!-- Longitud-->
        <div class="row">
          <h4 class="col-md-offset-1 col-md-3">  <p class="fa fa-long-arrow-up"></p> Longitud</h4>
          <!-- Text input-->
          <div class="form-group col-md-4">
            <label class="col-md-2 control-label" for="Yi">Yi</label>
            <div class="col-md-10">
              <input id="Yi" name="Yi" type="text" placeholder="Y inicial" class="form-control input-md">
              
            </div>
          </div>
          <!-- Text input-->
          
          <div class="form-group col-md-4">
            <label class="col-md-2 control-label" for="Xf">Yf</label>
            <div class="col-md-10">
              <input id="Yf" name="Xf" type="text" placeholder="Y final" class="form-control input-md">
              
            </div>
          </div>
        </div>
        <div class=" row">
          <div class="form-group col-md-12">
              <label class="col-md-2 control-label" for="angulo">angulo</label>
              <div class="col-md-10">
                <input id="angulo" name="angulo" type="text" placeholder="angulo" class="form-control input-md">
                
              </div>
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
       // var map = L.map('map').setView([20.19, 46.60], 3)
       //INICIALIZAR MAPA
  	    var map = L.map('map', {
                                editable: true,
                                //transform: true,
                                minZoom:6,
                                maxZoom:10,
                                maxBounds:[[29.305561325527698, -98.87695312500001],[2.4601811810210052, -46.58203125000001]]
                              })
                  .setView([14, -70],6);
        
        // AÑADIR CAPAS
        var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        var osmUrl_grid = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors';
        osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
        osm_grid = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
        drawnItems = L.featureGroup().addTo(map);
        L.control.layers(
        {

         'osm':osm.addTo(map),
         'osm grid':osm.addTo(map),
         "google": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
                    attribution: 'google'
                })
        }, 
        {'drawlayer':drawnItems}, 
        { position: 'topleft', collapsed: false}
        ).addTo(map);
 



     
//CONTROSL

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
            callback: newRectange,
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
              showArea:true, 

            }
          }
        }
    ));


//Events
 map.on('editable:drawing:start', function(e) {
      drawnItems.clearLayers();
 });
 map.on('editable:drawing:move', function(e) {  
      //var coordinates = e.layer.getLatLngs()[0];
     // console.log(coordinates);
      rotate_call(e);
 });

var global_polygon;
  //callback editcontrol
function newRectange(){
   for (var k in drawnItems._layers){
        drawnItems._layers[k].transform.disable();
        drawnItems._layers[k].dragging.disable();
          
      }

  drawnItems.clearLayers();
  if(typeof global_polygon != "undefined"){
    global_polygon.transform.disable();
  }
  global_polygon = map.editTools.startRectangle(null,{
     // interactive: true, 
      draggable: true, 
      transform: true, 
      color: "red", 
      weight: 1 
  });
}
function rotate_call(e){  
      var coordinates = e.layer.getLatLngs()[0];
      console.log(coordinates);

      $("#angulo").val(e.rotation);
      $("#Xi").val(coordinates[0].lat);
      $("#Yi").val(coordinates[1].lng);
      $("#Xf").val(coordinates[2].lat);
      $("#Yf").val(coordinates[3].lng);
}
 
   

 //GRID
  L.latlngGraticule({
        showLabel: true,
        weight:1,
        opacity: 2,
        color:"#999",
        fontColor: "#000",
        zoomInterval: [
            {start: 2, end: 3, interval: 30},
            {start: 4, end: 4, interval: 10},
            {start: 5, end: 7, interval: 5},
            {start: 8, end: 10, interval: 1}
        ]
    }).addTo(map);

     


//coordinates
    L.control.coordinates({
      position:"bottomleft", //optional default "bootomright"
      decimals:2, //optional default 4
      decimalSeperator:".", //optional default "."
      labelTemplateLat:"Latitud: {y}", //optional default "Lat: {y}"
      labelTemplateLng:"Longitud: {x}", //optional default "Lng: {x}"
      enableUserInput:false, //optional default true
      useDMS:false, //optional default false
      useLatLngOrder: true, //ordering of labels, default false-> lng-lat
      markerType: L.marker, //optional default L.marker
      markerProps: {}, //optional default {},
      labelFormatterLng : function(lng){return lng+" lng"}, //optional default none,
      labelFormatterLat : function(lat){return lat+" lat"}, //optional default none
      //customLabelFcn: function(latLonObj, opts) { "Geohash: " + encodeGeoHash(latLonObj.lat, latLonObj.lng)} //optional default none
    }).addTo(map);

 map.on('editable:drawing:end', function(e) {      
     // var coordinates = e.layer.getLatLngs()[0];
     // console.log(coordinates);
      rotate_call(e);
      var layer = e.layer;
      drawnItems.addLayer(layer);
      console.log(global_polygon);
      //global_polygon.disableEdit();
      global_polygon.transform.enable();
      global_polygon.dragging.enable();
      //global_polygon.on("rotateend", rotate_call);
      global_polygon.on("transformed", rotate_call);
     
  });
  
   $("#query").click(function(e) {
     e.preventDefault();

        $.ajax({
          type: "GET",
          url: "api/batimetria",
          // The key needs to match your method's input parameter (case-sensitive).
          data: {json:JSON.stringify(drawnItems.toGeoJSON())},
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          success: function(data){
            console.log(data);
            alert(JSON.stringify(data));
          },
          failure: function(errMsg) {
              alert(errMsg);
          }
      });

     //alert("realizando el query" + JSON.stringify(drawnItems.toGeoJSON()));

     console.log(drawnItems.toGeoJSON());

   });

   $("#clear").click(function(e) {
     e.preventDefault();
      $("#angulo").val("");
      $("#Xi").val("");
      $("#Xf").val("");
      $("#Yi").val("");
      $("#Yf").val("");
     
    for (var k in drawnItems._layers){
        drawnItems._layers[k].transform.disable();
        drawnItems._layers[k].dragging.disable();
          
      }
      drawnItems.clearLayers();
      //global_polygon.transform.disable();
   });

   $("#Xi, #Xf, #Yi, #Yf").click(function(e) {
     e.preventDefault();

     if($("#Xi").val()!="" && $("#Xf").val()!="" && $("#Yi").val()!="" && $("#Yf").val()!="" ){
      for (var k in drawnItems._layers){
        drawnItems._layers[k].transform.disable();
        drawnItems._layers[k].dragging.disable();
      }
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
        
       polygon.on("transformstart",function(e){
        rotate_call(e);
       });
       polygon.on("transformed",function(e){
        rotate_call(e);
       })
       //console.log(polygon);
       

     }

   });
   $("#ocultar_controls").click(function(e) {
     e.preventDefault();
    if($('#controls').hasClass('minimizar')) {
       $('#controls').removeClass('minimizar fa-square-o');
       $('#controls').addClass('fa fa-minus');
       
       $('#controls fieldset').show('fast');
        
    } else {
        $('#controls').removeClass('fa-minus');
        $('#controls').addClass('minimizar fa fa-square-o');
        $('#controls fieldset').hide('fast');
        $("#ocultar_controls").text(' Seleccionar Región');
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
/*var polygon = new L.Polygon(
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
polygon.transform.enable();*/


    });

  </script>
@endsection