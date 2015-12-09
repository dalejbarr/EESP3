<?php
$celldim = 180;
$bord = 2;

$width = $celldim * 5 + $bord * 6;
$height = $celldim * 4 + $bord * 5;

$im = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($im, 128, 128, 128);
$fg = imagecolorallocate($im, 64, 64, 64);

imagefill($im, 0, 0, $bg);

for ($i = 0; $i < 6; $i++) {
  // vertical
  imagefilledrectangle($im, $i * ($celldim + $bord), 0,
                       $i * ($celldim + $bord) + 1, $height, $fg);
  if ($i < 5) {
    // horizontal
    imagefilledrectangle($im, 0, $i * ($celldim + $bord),
                         $width, $i * ($celldim + $bord) + 1, $fg);
  } else {}
}

imagejpeg($im, "resource/grid.jpg");

imagecolordeallocate($im, $bg);
imagecolordeallocate($im, $fg);

imagedestroy($im);
?>
