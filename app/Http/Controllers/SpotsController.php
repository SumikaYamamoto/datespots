<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Spot;

  class SpotsController extends Controller
  {

    public function create()
    {
        $keyword = request()->keyword;
        $spots = [];
        
        if ($keyword) {
            	$api_key = 'AIzaSyBoip3JCxXBNUO_yPVHZcAJcRmYEJGcmUk';
            	$keyword = urlencode($keyword);
            	$url = "https://maps.googleapis.com/maps/api/place/textsearch/json?key={$api_key}&query={$keyword}";
            	$json = file_get_contents($url);
            	$data = json_decode($json, true);

            
            // Creating "Spot" instance to make it easy to handle.（not saving）
            foreach ($data['results'] as $google_spot) {
                $spot = new Spot();
                $spot->code = $google_spot['id'];
                $spot->name = $google_spot['name'];
                $spot->reference = $google_spot['reference'];
                $spot->icon = $google_spot['icon'];
                $spots[] = $spot;
            }
        }

        return view('spots.create', [
            'keyword' => $keyword,
            'spots' => $spots,
        ]);
    }
  }