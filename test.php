<?php

$type = "python";
$query = "trans";

require_once('search.php');




$url = "http://docs.python.org/library/struct.html#struct_struct.pack";

echo $url;

echo $parser->filter_url($url);



exit;




$parser->update();