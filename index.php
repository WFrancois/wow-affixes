<?php
session_start();
ini_set("display_errors", "on");
error_reporting(E_ALL);

if(!empty($_POST['language'])) {
    setcookie('language', $_POST['language'], time()+60*60*24*30);
    header('location:/');
    die();
} 

if(!empty($_COOKIE['language'])) {
    setcookie('language', $_COOKIE['language'], time()+60*60*24*30);
}

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

$numberAffix = ($weekNumber + EU_DELAY) % 8;


// Language
$languageUsing = 'en';

$acceptLanguage = array('en');
if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $acceptLanguage = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
}

if(!empty($_COOKIE['language'])) {
    array_unshift($acceptLanguage, $_COOKIE['language']);
}

$languageIso = array('fr' => 'Français', 'en' => 'English', 'de' => 'Deutsch', 'es' => 'Español', 'it' => 'Italiano', 'pt' => 'Português Brasileiro', 'ru' => 'Русский', 'ko' => '한국어', 'cn' => '简体中文');
$languageAllowedWowhead = array('en' => 'www', 'de' => 'de', 'es' => 'es', 'fr' => 'fr', 'it' => 'it', 'pt' => 'pt', 'ru' => 'ru', 'ko' => 'ko', 'cn' => 'cn');
$languageAllowedOther = array('fr' => 'fr', 'en' => 'en');

foreach ($acceptLanguage as $key => $value) {
    $language = substr($value, 0, 2);
    if(!empty($languageAllowedWowhead[$language])) {
        $languageUsing = $language;
        break;
    }
}
if(!empty($languageAllowedOther[$languageUsing])) {
    $languageDisplayOther = $languageUsing;
} else {
    $languageDisplayOther = 'en';
}

$title = array(
    'fr' => 'Affix Mythic (Europe)',
    'en' => 'WoW Affixes (On EU)',
);
$thisWeek = array(
    'fr' => 'Cette semaine',
    'en' => 'This Week',
);
$nextWeek = array(
    'fr' => 'La semaine prochaine',
    'en' => 'Next Week',
);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>WoW's affixes</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="shortcut icon" type="image/jpeg" href="/images/<?= $brutAffixes[array_rand($brutAffixes)]; ?>.jpg"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
            crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="choseLanguage">
            <form method="post">
                <select name="language" onchange="this.form.submit()" class="form-control">
                    <?php foreach($languageIso as $iso => $name) { ?>
                        <option value="<?= $iso; ?>" 
                            <?php if($languageUsing == $iso) { echo 'selected'; } ?>>
                                <?= $name; ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
        </div>
        <div class="container">
            <h1 class="col-md-offset-2"><?= $title[$languageDisplayOther]; ?></h1>
            <div class="col-md-6">
                <h2><?= $thisWeek[$languageDisplayOther]; ?></h2>
                <h4>(<?= date('d/m/Y', $startWeek); ?>)</h4>
                <a href="http://<?= $languageAllowedWowhead[$languageUsing]; ?>.wowhead.com/affix=<?= $affixes[$numberAffix][0][0]; ?>/" class="affixes affixes-<?= $affixes[$numberAffix][0][0]; ?>"><?= $affixes[$numberAffix][0][1]; ?></a><br />
                <a href="http://<?= $languageAllowedWowhead[$languageUsing]; ?>.wowhead.com/affix=<?= $affixes[$numberAffix][1][0]; ?>/" class="affixes affixes-<?= $affixes[$numberAffix][1][0]; ?>"><?= $affixes[$numberAffix][1][1]; ?></a><br />
                <a href="http://<?= $languageAllowedWowhead[$languageUsing]; ?>.wowhead.com/affix=<?= $affixes[$numberAffix][2][0]; ?>/" class="affixes affixes-<?= $affixes[$numberAffix][2][0]; ?>"><?= $affixes[$numberAffix][2][1]; ?></a><br />
            </div>
            <?php $numberAffix += 1; $numberAffix %= 8; ?>
            <div class="col-md-6">
                <h2><?= $nextWeek[$languageDisplayOther]; ?></h2>
                <h4>(<?= date('d/m/Y', $endWeek); ?>)</h4>
                <a href="http://<?= $languageAllowedWowhead[$languageUsing]; ?>.wowhead.com/affix=<?= $affixes[$numberAffix][0][0]; ?>/" class="affixes affixes-<?= $affixes[$numberAffix][0][0]; ?>"><?= $affixes[$numberAffix][0][1]; ?></a><br />
                <a href="http://<?= $languageAllowedWowhead[$languageUsing]; ?>.wowhead.com/affix=<?= $affixes[$numberAffix][1][0]; ?>/" class="affixes affixes-<?= $affixes[$numberAffix][1][0]; ?>"><?= $affixes[$numberAffix][1][1]; ?></a><br />
                <a href="http://<?= $languageAllowedWowhead[$languageUsing]; ?>.wowhead.com/affix=<?= $affixes[$numberAffix][2][0]; ?>/" class="affixes affixes-<?= $affixes[$numberAffix][2][0]; ?>"><?= $affixes[$numberAffix][2][1]; ?></a><br />
            </div>
        </div>
        <footer class="footer">
            <i class="fa fa-lg fa-github"></i> <a href="https://github.com/WFrancois/wow-affixes">GitHub</a><br />
            Created By Wisak
        </footer>
        <script type="text/javascript" src="//wow.zamimg.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }</script>
    </body>
</html>