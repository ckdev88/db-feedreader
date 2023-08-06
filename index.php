<?php
$DATA = array_merge($_GET, $_POST);
if (isset($DATA['group'])) {
	$getGroup = $DATA['group'];
} else
	$getGroup = 'blog';
if (isset($DATA['timeframe'])) {
	$getTimeframe = $DATA['timeframe'];
} else
	$getTimeframe = 36000;
if (isset($DATA['newsurl'])) {
	$getNewsUrl = urldecode($DATA['newsurl']);
} else {
	$getNewsUrl = false;
}
?>
<html>

<head>
	<title>RSS Feeds</title>
	<link rel="stylesheet" type="text/css" href="./styles.css" />
	<script src="./script.js"></script>
	<?php if (isset($DATA['refresh'])) { ?>
		<meta http-equiv="refresh" content="<?= $DATA['refresh'] ?>"><?php } ?>
</head>

<body>
	<?php include('incl/functions.php'); ?>
	<main>
		<article id="nieuwsartikel"><?php echo getArticle($getNewsUrl); ?></article>
		<nav>
			<?php
			echo "Sorteer:
\t\t\t\t\t<select name=\"group\">
\t\t\t\t\t\t<option value=\"blog\"" . (($getGroup == 'blog') ? ' selected' : '') . "\">Blog</option>
\t\t\t\t\t\t<option value=\"datum\"" . (($getGroup == 'datum') ? ' selected' : '') . ">Datum</option>
\t\t\t\t\t</select>";
			echo "Tijd:
\t\t\t\t\t<select name=\"timeframe\" id=\"selectTimeFrame\" onChange=\"javascript:changeVal()\">
\t\t\t\t\t\t<option value=\"300\"" . (($getTimeframe == 300) ? ' selected' : '') . ">5 minuten</option>
\t\t\t\t\t\t<option value=\"600\"" . (($getTimeframe == 600) ? ' selected' : '') . ">10 minuten</option>
\t\t\t\t\t\t<option value=\"900\"" . (($getTimeframe == 900) ? ' selected' : '') . ">15 minuten</option>
\t\t\t\t\t\t<option value=\"1800\"" . (($getTimeframe == 1800) ? ' selected' : '') . ">30 minuten</option>
\t\t\t\t\t\t<option value=\"3600\"" . (($getTimeframe == 3600) ? ' selected' : '') . ">1 uur</option>-
\t\t\t\t\t\t<option value=\"7200\"" . (($getTimeframe == 7200) ? ' selected' : '') . ">2 uur</option>
\t\t\t\t\t\t<option value=\"36000\"" . (($getTimeframe == 36000 || '') ? ' selected' : '') . ">10 uur</option>
\t\t\t\t\t\t<option value=\"86400\"" . (($getTimeframe == 86400) ? ' selected' : '') . ">1 dag</option>
\t\t\t\t\t\t<option value=\"432000\"" . (($getTimeframe == 432000) ? ' selected' : '') . ">5 dagen</option>
\t\t\t\t\t</select>";
			echo 'Ververs: <input type="checkbox" name="refresh" id="refreshTimeFrame" value="' . $getTimeframe . '" ' . ((isset($DATA['refresh']) > 0) ? ' checked' : '') . '/>';
			echo '<input type="submit" value="Filter"></input>';
			?>
			</form>
			<?php
			echo getFeeds($getGroup, $getTimeframe);
			?>
		</nav>
	</main>
</body>

</html>