<?php


$data = file_get_contents("http://dochub.io/data/css-mdn.json");

$output = "data.css.json";

$data = json_decode($data);

$results = array();


function addResultCSS($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsCSS($arr) {
    foreach ($arr as $key => $val) {
        $title = $val->title;
        $url = $val->url;
        $description = strip_tags(implode($val->sectionHTMLs, ""));
        //$description = "";
        addResultCSS($url, $title, $description);
        /*
        foreach ($val->searchableItems as $res) {
          addResult($url."#".$res->domId, $res->name, "");
        }
        */

    }
}


addResultsCSS($data);

file_put_contents($output, json_encode($results));
echo "Updated css\n";