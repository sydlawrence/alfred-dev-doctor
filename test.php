<?php

$str = " (PHP 5 &gt;= 5.1.0)strptime &mdash; fewf ";
$str = html_entity_decode($str);
echo $str;

//exit;
//$type = "html";
$type = "underscore";
//$query = "wbr";
$query = "some";

require_once('search.php');





$parser->update();