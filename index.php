<?php
global $_POST, $DATA;
require('supabase.php');
include('incl/functions.php');
include('incl/supabaseFunctions.php');
$DATA = array_merge($_GET, $_POST);
if (isset($DATA['group'])) {
	$getGroup = $DATA['group'];
} else
	$getGroup = 'blog';
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
</head>

<body>
	<div class="container">
		<header><img src="img/ck-feed-reader-logo.png" alt="CK Feed Reader" height="24" width="157" /></header>
		<article id="nieuwsartikel"><?php echo getArticle($getNewsUrl); ?></article>
		<main>

			<?php require('./components/CrudFeeds.php'); ?>
			<?php
			echo getFilters();
			echo getFeeds($getGroup);
			?>
		</main>
		<footer id="page-footer">
			<div class="container">© Cors, Frontend Developer 2023</div>
		</footer>
	</div>
</body>

</html>