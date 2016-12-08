<?php
ini_set("display_errors", "on");
error_reporting(E_ALL);

$now     = strtotime('now');
$startWeek = strtotime('this Tuesday -6 day + 9 hour', $now);
$endWeek   = strtotime('this Tuesday +32 hour +59 minute +59 second', $now);
if(!($now >= $startWeek && $now <= $endWeek)) {
  $startWeek = strtotime('this Tuesday +1 week -6 day + 9 hour', $now);
  $endWeek   = strtotime('this Tuesday +1 week +32 hour +59 minute +59 second', $now);
  if(!($now >= $startWeek && $now <= $endWeek)) {
    $startWeek = strtotime('this Tuesday -1 week -6 day + 9 hour', $now);
    $endWeek   = strtotime('this Tuesday -1 week +32 hour +59 minute +59 second', $now);
  } 
}

const EU_DELAY = 1;
const NA_DELAY = -1;

$brutAffixes = array('bolstering', 'fortified', 'necrotic', 'overflowing', 'raging', 'sanguine', 'skittish', 'teeming', 'tyrannical', 'volcanic');

$affixes = array(
    array(array(6, 'Raging'),     array(4, 'Necrotic'),    array(10, 'Fortified')),
    array(array(7, 'Bolstering'), array(1, 'Overflowing'), array(9, 'Tyrannical')),
    array(array(8, 'Sanguine'),   array(3, 'Volcanic'),    array(10, 'Fortified')),
    array(array(5, 'Teeming'),    array(4, 'Necrotic'),    array(9, 'Tyrannical')),
    array(array(6, 'Raging'),     array(3, 'Volcanic'),    array(9, 'Tyrannical')),
    array(array(7, 'Bolstering'), array(2, 'Skittish'),    array(10, 'Fortified')),
    array(array(8, 'Sanguine'),   array(1, 'Overflowing'), array(9, 'Tyrannical')),
    array(array(5, 'Teeming'),    array(2, 'Skittish'),    array(10, 'Fortified')),
);

$weekNumber = date('W', $startWeek);
if(date('Y', $startWeek) != 2016) {
    $weekNumber += 53;
}

$numberAffix = ($weekNumber + NA_DELAY) % 8;

// echo date('d/m/Y', $startWeek) . ' <br />';
// echo 'This week : <br />';
// echo $affixes[$numberAffix][0]. ' ' . $affixes[$numberAffix][1] . ' ' . $affixes[$numberAffix][2] . ' <br /><br />';

// $numberAffix += 1;
// $numberAffix %= 8;
// echo date('d/m/Y', $endWeek) . ' <br />';
// echo 'Next week : <br />';
// echo $affixes[$numberAffix][0]. ' ' . $affixes[$numberAffix][1] . ' ' . $affixes[$numberAffix][2] . ' <br />'; 
?>
<!DOCTYPE html>
<html>
<head>
<title>WoW's affixes</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="shortcut icon" type="image/jpeg" href="/images/<?= $brutAffixes[array_rand($brutAffixes)]; ?>.jpg"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="">WoW Affixes (On EU)</h1>
    <div class="col-md-6">
        <h2>This Week</h2>
        <h4>(<?= date('d/m/Y', $startWeek); ?>)</h4>
        <a href="http://www.wowhead.com/affix=<?= $affixes[$numberAffix][0][0]; ?>/" class="affix affix-<?= $affixes[$numberAffix][0][0]; ?>"><?= $affixes[$numberAffix][0][1]; ?></a><br />
        <a href="http://www.wowhead.com/affix=<?= $affixes[$numberAffix][1][0]; ?>/" class="affix affix-<?= $affixes[$numberAffix][1][0]; ?>"><?= $affixes[$numberAffix][1][1]; ?></a><br />
        <a href="http://www.wowhead.com/affix=<?= $affixes[$numberAffix][2][0]; ?>/" class="affix affix-<?= $affixes[$numberAffix][2][0]; ?>"><?= $affixes[$numberAffix][2][1]; ?></a><br />
    </div>
    <?php $numberAffix += 1; $numberAffix %= 8; ?>
    <div class="col-md-6">
        <h2>Next Week</h2>
        <h4>(<?= date('d/m/Y', $endWeek); ?>)</h4>
        <a href="http://www.wowhead.com/affix=<?= $affixes[$numberAffix][0][0]; ?>/" class="affix affix-<?= $affixes[$numberAffix][0][0]; ?>"><?= $affixes[$numberAffix][0][1]; ?></a><br />
        <a href="http://www.wowhead.com/affix=<?= $affixes[$numberAffix][1][0]; ?>/" class="affix affix-<?= $affixes[$numberAffix][1][0]; ?>"><?= $affixes[$numberAffix][1][1]; ?></a><br />
        <a href="http://www.wowhead.com/affix=<?= $affixes[$numberAffix][2][0]; ?>/" class="affix affix-<?= $affixes[$numberAffix][2][0]; ?>"><?= $affixes[$numberAffix][2][1]; ?></a><br />
    </div>
</div>
<script type="text/javascript" src="//wow.zamimg.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }</script>
</body>
</html>