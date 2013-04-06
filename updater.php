<?php


$repo_name = "alfred-dev-doctor";
$repo_user = "sydlawrence";

$ignore_files = array(
  "updater.php",
  ".",
  ".."
);

$zip_url = "https://github.com/".$repo_user."/".$repo_name."/archive/master.zip";


$destination = "./";
$end_zip_url = "tmpfile.zip";


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
  //do your work here
}






// clear up files
deleteDirectory($folder);
unlink($end_zip_url);
