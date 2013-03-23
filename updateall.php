<?php

$array = array(
    "css",
    "html",
    "jquery",
    "js",
    "nodejs",
    "php",
    "python",
    "ror",
    "haskell",
    "erlang"
);
foreach ($array as $val) {
    require_once('update.'.$val.'.php');
}
