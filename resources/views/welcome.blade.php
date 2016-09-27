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
	var mymap = L.map('map').setView([10.997828918781796, -74.81552682962854], 13);
	var OpenStreetMap_Mapnik = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(mymap);
</script>
@endsection