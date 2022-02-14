<?php


include '../phpqrcode/qrlib.php';

header("Content-type: image/png");
$string = "text";
$im     = imagecreatefrompng(QRcode::png('PHP QR Code :)'));
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
imagestring($im, 3, $px, 9, $string, $orange);
imagepng($im);
imagedestroy($im);



//QRcode::png('PHP QR Code :)');
