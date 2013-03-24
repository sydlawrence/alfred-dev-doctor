<?php

$canIUseFeed = json_decode(file_get_contents("https://raw.github.com/Fyrd/caniuse/master/data.json"));

$canIUseFeatureURL = "http://caniuse.com/#feat=";

$output = "data.caniuse.json";

$results = array();


function addResultCanIuse($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsCanIuse($features) {
    global $canIUseFeatureURL;
    foreach ($features as $featureName => $featureObject) {
        $title = $featureObject->title;
        $url = $canIUseFeatureURL . $featureName;
        $description = $featureObject->description;
        addResultCanIuse($url, $title, $description);
    }
}


addResultsCanIuse($canIUseFeed->data);

file_put_contents($output, json_encode($results));
echo "Updated CanIuse\n";