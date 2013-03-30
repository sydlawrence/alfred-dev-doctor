<?php

require_once('workflows.php');

define("PLUGIN_URL", "plugins/".$plugin."/");

$wf = new Workflows();

$icon = PLUGIN_URL."icon.png";

require_once(PLUGIN_URL."plugin.php");

echo $wf->toxml();
