<?php


$data = file_get_contents("http://dochub.io/data/js-mdn.json");

$output = "data.js.json";

$data = json_decode($data);

$results = array();


function addResultJS($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsJS($arr) {
    foreach ($arr as $key => $val) {
        $title = $val->title;
        $url = $val->url;
        $description = strip_tags(implode($val->sectionHTMLs, ""));
        //$description = "";
        addResultJS($url, $title, $description);
        /*
        foreach ($val->searchableItems as $res) {
          addResult($url."#".$res->domId, $res->name, "");
        }
        */

    }
}


addResultsJS($data);

file_put_contents($output, json_encode($results));
echo "Updated js\n";