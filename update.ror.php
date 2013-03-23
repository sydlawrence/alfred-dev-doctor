<?php


$data = file_get_contents("http://api.rubyonrails.org/panel/tree.js");
$data = str_replace("var tree =", "", $data);
$data = json_decode($data);

$results = array();

$done = array();

function addResultROR($url, $title, $description) {
    global $results;
    global $done;
    if (!isset($done[$title])) {
        $done[$title] = true;
        $results[] = array(
            "url" => "http://api.rubyonrails.org/".$url ,
            "title" => $title,
            "description" =>$description
        );
    }

}

function addResultsROR($arr, $string = "") {
    foreach ($arr as $key => $val) {
        $title = $string.$val[0];
        $url = $val[1];
        //$description = strip_tags($val->html);
        $description = "";
        if (strlen($title) > 0) {
            addResultROR($url, $title, $description);
            addResultsROR($val[3], $title."::");
        } else {
            addResultsROR($val[3]);
        }

    }
}


addResultsROR($data);

file_put_contents("data.ror.json", json_encode($results));
echo "Updated ror\n";