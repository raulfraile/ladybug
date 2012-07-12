#!/usr/bin/env php
<?php

set_time_limit(0);

// create temporary folder with files and components
$temp = '/tmp/Ladybug';

if (is_dir($temp)) rrmdir($temp);
rmkdir($temp);

$files = array(
    'LICENSE',
    'README.md',
    'examples/',
    'tests/',
    'lib/Ladybug/'
);

$components = array(
    'Serializer' => array(
        'git' => 'http://github.com/symfony/Serializer.git',
        'target' => 'lib/Symfony/Component/Serializer'
    ),
    'Yaml' => array(
        'git' => 'http://github.com/symfony/Yaml.git',
        'target' => 'lib/Symfony/Component/Yaml'
    )
);

// add files
foreach ($files as $item) {
    if (is_dir(__DIR__ . '/../' . $item)) rmkdir($temp . '/' . $item);
    rcopy(__DIR__ . '/../' . $item, $temp . '/' . $item);
}

// add git components
foreach ($components as $key => $item) {
    if (!is_dir($temp . '/' . $item['target'])) rmkdir($item['target']);

    $command = 'git clone '.$item['git'].' '.$temp.'/'.$item['target'];
    echo "$command\n";

    shell_exec($command);
}

// create the zip file
$zip = new ZipArchive();
$filename = __DIR__ . '/../Ladybug.zip';

if (is_file($filename)) unlink($filename);

if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

raddzip($temp, $zip);

$zip->close();

// functions from https://github.com/asiermarques/Leophard/blob/master/leophard_install.php
function rrmdir($dir)
{
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object);
         else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
}

function rcopy($src, $dst)
{
  //if (file_exists($dst)) rrmdir($dst);
  if (is_dir($src)) {
    @mkdir($dst);
    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
  } elseif (file_exists($src)) copy($src, $dst);
}

function rmkdir($dir)
{
    @mkdir($dir, 0777, true);
}

function raddzip($src, & $zip)
{
  if (is_dir($src)) {
    $zip->addEmptyDir($src);

    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") raddzip("$src/$file", $zip);
  } elseif (file_exists($src)) {
      $zip->addFile("$src", preg_replace('/^\/tmp\/Ladybug/', '', $src));
  }
}
