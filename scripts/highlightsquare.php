<?php
$celldim = 180;
$bord = 2;

$im = imagecreatetruecolor($celldim + 2 * $bord,
                           $celldim + 2 * $bord);
$bg = imagecolorallocate($im, 128, 128, 128);
$fg = imagecolorallocate($im, 0, 255, 0);

imagefill($im, 0, 0, $fg);
imagefilledrectangle($im, 2, 2, 180, 180, $bg);

chdir(__DIR__);
imagejpeg($im, "../resource/highlight.jpg");

imagecolordeallocate($im, $bg);
imagecolordeallocate($im, $fg);

imagedestroy($im);
?>
