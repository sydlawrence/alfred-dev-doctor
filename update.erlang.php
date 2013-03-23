<?php




$data = file_get_contents("http://erldocs.com/R15B/erldocs_index.js");
$data = str_replace("var index =", "", $data);


$data = str_replace(";","", $data);

$data = str_replace("\"","", $data);
$data = str_replace("\t","", $data);

$data = str_replace("   ","", $data);

$data = utf8_decode($data);

$data = str_replace("'","\"", $data);






//file_put_contents("data.erlang.json",$data);

//exit;
$data = json_decode($data);



$results = array();


function addResultErlang($url, $title, $description) {


    global $results;
      $results[] = array(
        "url" => $url ,
        "title" => $title,
        "description" =>$description
      );

}

function addResultsErlang($arr) {
    foreach ($arr as $key => $val) {
        $title = $val[2];

        $strs = explode(":", $val[2]);
        $str = $strs[0].".html";
        if (count($strs) > 1) {
            $str .= "#".$strs[1];
        }

        $url = "http://erldocs.com/R15B/".$val[1]."/".$str;
        //$description = strip_tags($val->html);
        $description = implode(" ", array($val[3]));
        addResultErlang($url, $title, $description);


    }
}

addResultsErlang($data);

file_put_contents("data.erlang.json", json_encode($results));
echo "Updated erlang\n";