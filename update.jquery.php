<?php


$data = file_get_contents("http://dochub.io/data/jquery.json");

$output = "data.jquery.json";

$data = json_decode($data);

$results = array();


function addResultjQuery($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsjQuery($arr) {
    foreach ($arr as $key => $val) {
        $title = $val->title;
        $url = $val->url;
        $description = strip_tags(implode($val->sectionHTMLs, ""));
        //$description = "";
        addResultjQuery($url, $title, $description);
        /*
        foreach ($val->searchableItems as $res) {
          addResult($url."#".$res->domId, $res->name, "");
        }
        */

    }
}


addResultsjQuery($data);

file_put_contents($output, json_encode($results));
echo "Updated jquery\n";