<?php
global $DATA;
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

		<?php
		echo getFilters();
		echo getFeeds($getGroup, $getTimeframe);
		?>
	</main>
</body>

</html>