#!/bin/bash
mkdir -p resource
for f in tmpstim/*.png
do
    b=`basename $f .png`
    convert $f -resize 180x180 resource/$b.bmp
done
