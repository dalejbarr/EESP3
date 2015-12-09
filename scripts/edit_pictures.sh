#!/bin/bash
scripts/move_images.sh
R --vanilla < scripts/squareoff.R
scripts/resize.sh
scripts/to_jpg.sh
php scripts/stimset_review.php
