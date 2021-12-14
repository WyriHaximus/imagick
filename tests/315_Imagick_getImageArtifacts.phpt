--TEST--
Test Imagick, getImageArtifacts
--SKIPIF--
<?php
require_once(dirname(__FILE__) . '/skipif.inc');
checkClassMethods('Imagick', array('getImageArtifacts'));
?>
--FILE--
<?php

function getImageArtifacts() {
    $imagick = new \Imagick(__DIR__ . '/Biter_500.jpg');
    $artifacts = $imagick->getImageArtifacts();

    $expectedEntries = [
        "exif:ApertureValue" => false,
        "exif:BodySerialNumber" => false,
        "exif:ColorSpace" => false,
        "exif:CustomRendered" => false,
        "exif:DateTime" => false,
        "exif:DateTimeDigitized" => false,
        "exif:DateTimeOriginal" => false,
        "exif:ExifOffset" => false,
        "exif:ExifVersion" => false,
    ];


    foreach ($artifacts as $key => $value) {
       if (array_key_exists($key, $expectedEntries) === true) {
            $expectedEntries[$key] = true;
        }
    }

    foreach ($expectedEntries as $key => $value) {
        if ($value !== true) {
            echo "Expected entry $key was not set\n";
        }
    }

    $imagick->getImageBlob();
}

getImageArtifacts();
echo "Ok";
?>
--EXPECTF--
Ok