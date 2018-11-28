--TEST--
Test ImagickDraw, getTextDirection
--SKIPIF--
<?php
require_once(dirname(__FILE__) . '/skipif.inc');
require_once(dirname(__FILE__) . '/functions.inc');

if (isVersionGreaterEqual('6.9.8-6', '7.0.5-7') !== true) {
    die("either version '6.9.8-6', '7.0.5-7' is minimum reliable setTextInterlineSpacing.");
}

?>
--FILE--
<?php

require_once(dirname(__FILE__) . '/functions.inc');

$backgroundColor = 'rgb(225, 225, 225)';
$strokeColor = 'rgb(0, 0, 0)';
$fillColor = 'DodgerBlue2';


if (isVersionGreaterEqual('6.9.8-6', '7.0.5-7') !== true) {
    die("either version '6.9.8-6', '7.0.5-7' is minimum reliable setTextInterlineSpacing.");
}
else {
    echo "Tests think version is okay.\n";
}

$interlineSpacings = [0, 16, 24, 36];

$imageHeights = [];

foreach ($interlineSpacings as $interlineSpacing) {

    $draw = new \ImagickDraw();

    $draw->setStrokeColor($strokeColor);
    $draw->setFillColor($fillColor);

    $draw->setStrokeWidth(2);
    $draw->setFontSize(56);

    $draw->setFontSize(16);
    $draw->setStrokeAntialias(true);
    $draw->setTextAntialias(true);
    $draw->setFillColor('#ff0000');
    $draw->setTextInterlineSpacing($interlineSpacing);

    $imagick = new \Imagick();
    $imagick->newImage(600, 600, "rgb(230, 230, 230)");
    $imagick->setImageFormat('png');
    $imagick->annotateImage($draw, 30, 40, 0, "Line 1\nLine 2\nLine 3");
    $imagick->trimImage(0);
    $imagick->setImagePage($imagick->getimageWidth(), $imagick->getimageheight(), 0, 0);

    $bytes = $imagick->getImageBlob();
    if (strlen($bytes) <= 0) {
        die("Failed to generate image.");
    }

    $imageHeights[$interlineSpacing] = $imagick->getImageHeight();

    $imagick->writeImage(__DIR__ . "/interline_spacing_test_$interlineSpacing.png");
}


$previousHeight = null;

foreach ($imageHeights as $interlineSpacing => $imageHeight) {
    if ($previousHeight !== null) {
        $differenceFromPrevious = $imageHeight - $previousHeight;
        if ($differenceFromPrevious < 15) {
            echo "textInterlineSpacing of $interlineSpacing only resulted in extra height of $differenceFromPrevious\n";
        }
    }

    $previousHeight = $imageHeight;
}

echo "Ok";
?>
--EXPECTF--
Ok