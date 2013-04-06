<?php

include("updater.php");


$array = array();

$ignore = array(
    "AutoSuggestParser.php"
);

foreach (scandir("parsers/autosuggest/classes") as $item) {
    if ($item == '.' || $item == '..') continue;
    if (in_array($item, $ignore)) continue;
    $array[] = $item;
}

define("PARSER_URL", "parsers/autosuggest/");

require_once(PARSER_URL."classes/AutoSuggestParser.php");



foreach ($array as $val) {
    $parser = ucFirst($val)."Parser";

    require_once(PARSER_URL."classes/".$val."/".$parser.".php");
    $parser = new $parser;
    $parser->check_update();
}
