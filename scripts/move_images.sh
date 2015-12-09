#!/bin/bash
mkdir -p tmpstim
for f in experiment_stimuli/Filler_items/*.jpg experiment_stimuli/Filler_items/*.png experiment_stimuli/Stimuli_EESP3/*.png experiment_stimuli/Stimuli_EESP3/*.jpg
do
    b=`basename $f .png`
    convert $f tmpstim/$b.png
done
