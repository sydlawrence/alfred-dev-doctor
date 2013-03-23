<?php


$data = file_get_contents("http://nodejs.org/api/all.json");

$data = json_decode($data);

$results = array();


function seoUrlNode($string) {
    //lower case everything
    $string = strtolower($string);
    //make alphaunermic
    $string = preg_replace("/[^a-z0-9_\s-]/", " ", $string);
    //Clean multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = trim($string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "_", $string);

    $new_string = str_replace("__", "_", $string);
    while($new_string !== $string) {
        $s = $new_string;
        $new_string = str_replace("__", "_", $string);
        $string = $s;
    }

    return $new_string;
}

function addResultNode($data) {


    global $results;
  if (isset($data->name)) {
      $results[] = array(
        "url" => "http://nodejs.org/api/all.html#all_".seoUrlNode($data->textRaw) ,
        "title" => $data->textRaw,
        "description" => $data->desc
      );
    }
  if (isset($data->globals)) {
    addResultsNode($data->globals);
  }

  if (isset($data->methods)) {
    addResultsNode($data->methods);
  }

  if (isset($data->miscs)) {
    addResultsNode($data->miscs);
  }

  if (isset($data->vars)) {
    addResultsNode($data->vars);
  }

  if (isset($data->modules)) {
    addResultsNode($data->modules);
  }
}

function addResultsNode($arr) {
    foreach ($arr as $key => $val) {
        addResultNode($val);
    }
}


addResultNode($data);

file_put_contents("data.nodejs.json", json_encode($results));
echo "Updated nodejs\n";