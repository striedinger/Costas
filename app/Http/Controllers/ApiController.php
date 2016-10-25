<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Batimetria;

class ApiController extends Controller
{
    public function batimetria(Request $request){
    	if(isset($request->json)){
    		$success = true;
    		$message = null;
    		$json = json_decode($request->json, true);
    		$json = $json["features"];
    		$json = $json[0]["geometry"];
    		$json = $json["coordinates"];
    		$json = $json[0];
    		$coordinates = array();
    		foreach($json as $array){
    			$set = array();
    			foreach($array as $number){
    				array_push($set, (double) $number);
    			}
    			array_push($coordinates, $set);
    		}
    		$results = \App\Batimetria::whereRaw([
				'geometry' => [
					'$geoWithin' => [
						'$geometry' => [
							'type' => "Polygon",
							'coordinates' => array($coordinates)
						]
					]
				]
			])->get();
    	}else{
    		$success = false;
    		$message = "Faltan parametros";
    		$results = null;
    	}
		return response()->json(["success" => $success, "message" => $message, "results" => $results]);
    }
}
