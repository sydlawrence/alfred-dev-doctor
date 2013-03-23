<?php


$data = file_get_contents("http://dochub.io/data/html-mdn.json");

$output = "data.html.json";

$data = json_decode($data);

$results = array();


function addResultHTML($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsHTML($arr) {
    foreach ($arr as $key => $val) {
        $title = $val->title;
        $url = $val->url;
        $description = strip_tags(implode($val->sectionHTMLs, ""));
        //$description = "";
        addResultHTML($url, $title, $description);
        /*
        foreach ($val->searchableItems as $res) {
          addResult($url."#".$res->domId, $res->name, "");
        }
        */

    }
}


addResultsHTML($data);

file_put_contents($output, json_encode($results));
echo "Updated html\n";