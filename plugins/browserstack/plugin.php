<?php
require_once('options.php');


function build_url($options) {
    global $resolution;
    global $query;

    if (!isset($browser['browser'])) {
        $browser['browser'] = "title";
    }

    $url = "http://www.browserstack.com/start#".
        "os=".$browser['os'].
        "&browser=".$browser['browser'].
        "&resolution=".$resolution.
        "&zoom_to_fit=true&full_screen=true&url=".$query."&speed=1&start=true";

    return $url;
}

foreach ($options as $browser) {
    $wf->result( "browserstack".$browser['title'], build_url($browser), $browser['title'], "Test your site in ".$browser['title'],$icon);
}

