<?php


$data = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22http%3A%2F%2Fwww.acm.uiuc.edu%2Fwebmonkeys%2Fbook%2Fc_guide%2F%22%20and%0A%20%20%20%20%20%20xpath%3D'%2F%2Fa'&format=json");






$data = json_decode($data);

$results = array();


function addResultHaskell($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsHaskell($arr) {
    foreach ($arr as $key => $val) {
        $title = $val->content;
        $url = "http://www.acm.uiuc.edu/webmonkeys/book/c_guide/".$val->href;
        //$description = strip_tags($val->html);
        $description = "";
        addResultHaskell($url, $title, $description);


    }
}


addResultsHaskell($data->query->results->a);

file_put_contents("data.c.json", json_encode($results));
echo "Updated c\n";