<?php



$parser = ucFirst($type)."Parser";

define("PARSER_URL", "parsers/autosuggest/");

require_once(PARSER_URL."classes/AutoSuggestParser.php");

require_once(PARSER_URL."classes/".$type."/".$parser.".php");

require_once('workflows.php');

$parser = new $parser;

$icon = PARSER_URL."classes/".$type."/".$parser->icon;


$data = file_get_contents(PARSER_URL."data/".$parser->data_filename);


$wf = new Workflows();


$data = json_decode($data);

if (!isset($icon)) {
    $icon = "icon.png";
}

$query = strtolower($query);

$arr = get_defined_functions();

$extras = array();

$extras2 = array();

$found = array();



foreach ($data as $key => $result){




    $value = strtolower(trim($result->title));
    $description = utf8_decode(strip_tags($result->description));

    $new_key = $type.$result->title;

    //if ($value === "wbr") echo 23;

    if (strpos($value, $query) === 0) {
        if (!isset($found[$value])) {
            $found[$value] = true;
            $wf->result( $type.$result->title, $result->url, $result->title, $result->description,$icon  );
        }
    }
    else if (strpos($value, $query) > 0) {
        if (!isset($found[$value])) {
            $found[$value] = true;
            $extras[$key] = $result;
        }
    }

    else if (strpos($description, $query) !== false) {
        if (!isset($found[$value])) {
            $found[$value] = true;
            $extras2[$key] = $result;
        }
    }
}

foreach ($extras as $key => $result) {
        $wf->result( $type.$result->title, $result->url, $result->title, $result->description, $icon  );

}

foreach ($extras2 as $key => $result) {
        $wf->result( $type.$result->title, $result->url, $result->title, $result->description, $icon  );

}

echo $wf->toxml();



