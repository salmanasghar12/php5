<?php
session_start();

// generate random number and store in session
$randomnr = '';  
for ($i = 0; $i < 5; $i++) {  
    // this numbers refer to numbers of the ascii table (lower case)  
    $randomnr .= chr(rand(97, 122));  
}
$_SESSION['randomnr2'] = $randomnr;

//generate image
$im = imagecreatetruecolor(120, 55);

//colors:
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);

$bluee = imagecolorallocate($im, 215, 225, 235);
$blue2 = imagecolorallocate($im, 113, 148, 196);

imagefilledrectangle($im, 1, 1, 118, 53, $bluee);
imagefilledrectangle($im, 1, 10, 118, 45, $blue2);

//path to font: Please upload a font file and specify path here
$font = 'fonts/arial.ttf';

/* draw text */
// Shadow text, If you need then place otherwise comment.
imagettftext($im, 20, 18, 20, 40, $grey, $font, $randomnr);
// VALIDATION CAPTCHA CODE TEXT
imagettftext($im, 20, 15, 20, 40, $black, $font, $randomnr);

// prevent client side  caching
header("Expires: Wed, 1 Jan 2010 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, false");
header("Pragma: no-cache");

//send image to browser
header ("Content-type: image/gif");
imagegif($im);
imagedestroy($im);
?>