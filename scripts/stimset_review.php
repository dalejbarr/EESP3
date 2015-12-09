<?php
chdir(__DIR__);  
$dir = "sqlite:../EESP3.db";
$dbh = new PDO($dir) or die("couldn't open");

function load_stimset($iid, $dbh, $phase) {
  $qry = "select StimulusSets.*, Pos from StimulusSets JOIN MainDisplays USING (ItemID, Role) WHERE Display = '".$phase."' AND ItemID=".$iid;
  // $qry = "SELECT * FROM StimulusSets WHERE ItemID=".$iid;
  $res = $dbh->query($qry);
  $res->setFetchMode(PDO::FETCH_ASSOC); 
  $i = 0;
  while ($row = $res->fetch()) {
    $itm[$row['Role']] = array($row['Image'], $row['Pos']);
  }
  $res = $dbh->query("SELECT Pos FROM MainDisplays WHERE Role='Crit' AND Display='".$phase."' AND ItemID=".$iid);
  $res->setFetchMode(PDO::FETCH_ASSOC);
  $row = $res->fetch();
  $p = $row['Pos'];
  $res = $dbh->query("SELECT * FROM StimulusSets WHERE (Role = 'Competitor' OR Role = 'Foil') AND ItemID=".$iid);
  $res->setFetchMode(PDO::FETCH_ASSOC);
  while ($row = $res->fetch()) {
    $itm[$row['Role']] = array($row['Image'], $p);
  }
  return($itm);
}

function place_image($fname, $sqr, $im, $bord = 2) {
  $size = 180;
  if ($bord == 0) {
    $size = 184;
  } else {}
  $img = imagecreatefromjpeg("../imgjpg/".$fname.".jpg");
  $row = floor(($sqr - 1) / 5);
  $col = ($sqr - 1) % 5;
  imagecopy($im, $img, $bord + $col * 182, $bord + $row * 182,
            0, 0, $size, $size);
  imagedestroy($img);
}

function make_stimset_review_display($itm, $iid) {
  $im = imagecreatefromjpeg("../resource/grid.jpg");
  place_image($itm['Target'][0], 1, $im);
  place_image($itm['Competitor'][0], 3, $im);
  place_image($itm['Foil'][0], 5, $im);
  $sqr = 11;  
  foreach ($itm as $k => $v) {
    if (($k != "Target") && ($k != "Competitor") && ($k != "Foil")) {
      place_image($v[0], $sqr++, $im);
    } else {}
  }
  imagejpeg($im, "../stimset_review/".str_pad($iid, 2, "0", STR_PAD_LEFT).".jpg");
  imagedestroy($im);
}

function make_stimset_display($itm, $cond, $iid, $dir) {
  $crit = $itm['Foil'];
  if ($cond == "comp") {
    $crit = $itm['Competitor'];
  } else {}
  $im = imagecreatefromjpeg("../resource/grid.jpg");
  place_image("../resource/highlight", $itm['Target'][1], $im, 0);
  place_image($itm['Target'][0], $itm['Target'][1], $im);
  place_image($crit[0], $crit[1], $im);
  // place_image($itm['Foil'][0], 5, $im);
  foreach ($itm as $k => $v) {
    if (($k != "Target") && ($k != "Competitor") && ($k != "Foil")) {
      place_image($v[0], $v[1], $im);
    } else {}
  }
  imagejpeg($im, "../".$dir."/".str_pad($iid, 2, "0", STR_PAD_LEFT).".jpg");
  imagedestroy($im);
}

for ($i = 1; $i <= 48; $i++) {
  $itm = load_stimset($i, $dbh);
  make_stimset_review_display($itm, $i);
}
?>
