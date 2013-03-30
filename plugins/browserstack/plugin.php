<?php
require_once('workflows.php');
require_once('options.php');



define("PLUGIN_URL", "plugins/".$plugin."/");



$wf = new Workflows();

$icon = PLUGIN_URL."icon.png";


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

echo $wf->toxml();
