#!/bin/bash
mkdir -p imgjpg
for f in resource/*.bmp
do 
    b=`basename $f .bmp`
    convert $f imgjpg/$b.jpg
done
