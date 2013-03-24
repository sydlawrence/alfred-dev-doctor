<?php
require_once('workflows.php');

$wf = new Workflows();


$data = json_decode($data);

if (!isset($icon)) {
    $icon = "icon.png";
}

$query = strtolower($query);

$arr = get_defined_functions();

$extras = array();

$extras2 = array();

foreach ($data as $key => $result){

    $value = $result->title;
    $description = utf8_decode(strip_tags($result->description));

    if (strpos(strtolower($value), $query) === 0) {
        $wf->result( $key.$result->title, $result->url, $type.": ".$result->title, 'Search docs for '.$result->title,$icon  );
    }
    else if (strpos(strtolower($value), $query) > 0) {
        $extras[$key] = $result;
    }

    else if (strpos($description, $query) !== false) {
        $extras2[$key] = $result;
    }
}

foreach ($extras as $key => $value) {
        $wf->result( $key.$result->title, $result->url, $type.": ".$result->title, 'Search docs for '.$result->title, $icon  );

}

foreach ($extras2 as $key => $value) {
        $wf->result( $key.$result->title, $result->url, $type.": ".$result->title, 'Search docs for '.$result->title, $icon  );

}

echo $wf->toxml();

