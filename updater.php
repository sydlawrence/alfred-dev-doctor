<?php

$under_development = false;

$repo_name = "alfred-dev-doctor";
$repo_user = "sydlawrence";

$package = "it.wemakeawesomesh.alfred-dev-doctor";

$ignore_files = array(
  "updater.php",
  ".",
  ".."
);

$to_do = true;

if ($under_development) {
  $to_do = false;
}

$repo_url = "https://github.com/".$repo_user."/".$repo_name;

$zip_url = $repo_url."/archive/master.zip";


$destination = "./";
$end_zip_url = "tmpfile.zip";

$cache_url = $_SERVER['HOME'] . '/Library/Caches/'.$package;

$commit_id_file = $cache_url . '/latest_commit';
$current_commit_id = "";

if (file_exists($commit_id_file)) {
  // update max once an hour
  if ( filemtime($commit_id_file) <= time()-60*60 ) {
    $to_do = false;
  }

  $current_commit_id =file_get_contents($commit_id_file);
} else {
  mkdir($cache_url);
}

function get_latest_commit_id() {
  global $repo_url;
  $xml_source = file_get_contents($repo_url."/commits/master.atom");
  $x = simplexml_load_string($xml_source);
  $attributes = array();
  foreach($x->entry[0]->link->attributes() as $a => $b) {
    $attributes[$a] = $b;
  }
  $href = (string)$attributes['href'];
  $id = str_replace($repo_url."/commit/","", $href);
  return $id;

}

function is_update_available() {
  global $current_commit_id;
  global $commit_id_file;
  $latest = get_latest_commit_id();
  if ($current_commit_id !== $latest) {
    // set the id
    file_put_contents($commit_id_file, $latest);
    return true;
  }
  return false;
}



if ($to_do && !is_update_available()) {
  $to_do = false;
}


function deleteDirectory($dir) {
  if (!file_exists($dir)) return true;
  if (!is_dir($dir) || is_link($dir)) return unlink($dir);
  foreach (scandir($dir) as $item) {
    if ($item == '.' || $item == '..') continue;
    if (!deleteDirectory($dir . "/" . $item)) {
      chmod($dir . "/" . $item, 0777);
      if (!deleteDirectory($dir . "/" . $item)) return false;
    };
  }
  return rmdir($dir);
}

if ($to_do) {

  $folder = "temp";

  mkdir($folder);

  $temp_dir = $folder."/".$repo_name."-master/";

  // download the zip
  file_put_contents($end_zip_url, fopen($zip_url, 'r'));

  // unzip it
  $zip = new ZipArchive;
  $zip->open($end_zip_url);
  $zip->extractTo('./'.$folder);
  $zip->close();

  function is_to_update($file) {
    global $ignore_files;
    if (!in_array($file, $ignore_files)) return true;
    return false;
  }

  // loop through each file / folder
  $files = scandir($temp_dir);
  foreach($files as $file) {
    if (is_to_update($file)) {
      if (is_dir($temp_dir.$file)) {
        deleteDirectory($destination.$file);
      }
      rename($temp_dir.$file, $destination.$file);
    }
  }

  // clear up files
  deleteDirectory($folder);
  unlink($end_zip_url);
}
