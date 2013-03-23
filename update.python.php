<?php


$data = file_get_contents("http://dochub.io/data/python.json");

$data = json_decode($data);

$results = array();


function addResultPython($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsPython($arr) {
    foreach ($arr as $key => $val) {
        $title = $val->title;
        $url = $val->url;
        //$description = strip_tags($val->html);
        $description = "";
        addResultPython($url, $title, $description);

        foreach ($val->searchableItems as $res) {
          addResultPython($url."#".$res->domId, $res->name, "");
        }

    }
}


addResultsPython($data);

file_put_contents("data.python.json", json_encode($results));
echo "Updated python\n";