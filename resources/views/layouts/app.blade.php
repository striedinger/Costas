<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            {{ config('app.name', 'Laravel') }} - @yield('title')
        @else
            {{ config('app.name', 'Laravel') }}
        @endif
    </title>

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css" />

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{{ URL::asset('js/controllers.js') }}"></script>
    <script src="{{ URL::asset('js/services.js') }}"></script>



    <script src="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js"></script>
   
    <script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>


 
  <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.3/dist/leaflet.css" />
  <script src="https://npmcdn.com/leaflet@1.0.0-rc.3/dist/leaflet.js"></script>
  <!--script src="../node_modules/leaflet/dist/leaflet-src.js"></script-->
  <script src="https://npmcdn.com/leaflet.path.drag/src/Path.Drag.js"></script>
  <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
 




    

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

    <script src="js/leaflet/src/Leaflet.draw.js"></script>
    <link rel="stylesheet" href="js/leaflet/dist/leaflet.draw.css" />
         <script src="js/leaflet_libs/L.Path.Transform.js"></script>
    <script src="{{ URL::asset('js/leaflet-providers.js') }}"></script>

    <script src="js/leaflet_libs/Leaflet.Editable.js"></script>



    @yield('scripts')
</body>
</html>
