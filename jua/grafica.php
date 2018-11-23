<?php
function graph($fun, $path, $max = 10, $min = 10, $width = 640, $height = 640){
  $xmax = $max;
  $xmin = -$min;
  $ymax = $max;
  $ymin = -$min;
  $rangeX = $xmax - $xmin;
  $rangeY = $ymax - $ymin;
  $unitX = $width/$rangeX;
  $unitY = $height/$rangeY;
  $centerX = round(abs($ymin/$rangeY)*$height);
  $centerY = round(abs($xmin/$rangeX)*$width);
  $iterations = ($xmax-$xmin)/1000;
  $scaleX = $width/$rangeX;
  $scaleY = $height/$rangeY;
  $canvas = imagecreatetruecolor($width, $height);
  imagesetthickness($canvas, 3);
  $red = imagecolorallocate($canvas, 255, 0, 0);
  $reda = imagecolorallocatealpha($canvas, 255, 0, 0, 50);
  $black = imagecolorallocate($canvas, 0, 0, 0);
  $white = imagecolorallocate($canvas, 255, 255, 255);
  $blue = imagecolorallocate($canvas, 0, 0, 255);
  $gray = imagecolorallocatealpha($canvas, 150, 150, 150, 50);
  imagefill($canvas, 0, 0, $white);
  //dibujar eje de coordenadas
  imageline($canvas, $centerX, 0, $centerX, $height, $gray);
  imageline($canvas, 0, $centerY, $width, $centerY, $gray);
  //$point = [];
  $point[] = 0;
  $point[] = $height;
  for($x = -($width/2); $x <= $width; $x+= $iterations) {
    $point[] = round(($x*$scaleX) + $centerX);
    $point[] = round((f($fun,$x)*(-$scaleY)) + $centerY);
  }
  $point[] = $width;
  $point[] = $height;
  $n = round(count($point)/2);
  imagepolygon($canvas, $point, $n, $red);
  imagepng($canvas, $path);
  imagedestroy($canvas);
}
graph('x',3);

?>
