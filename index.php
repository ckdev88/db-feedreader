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
<!DOCTYPE html>
<html lang="en">

<head>
	<title>CK Feed Reader</title>
	<style type="text/css">
		<?php include('./styles.css'); ?>
	</style>
	<!-- <link rel="stylesheet" href="./styles.css" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Feed reader, input the feed and get links to the articles posted there, filtered by date per feed." />
	<meta name="author" content="CK Dev." />
	<link rel="manifest" href="/manifest.json" />
	<meta name="theme-color" content="#3367D6">
</head>

<body>
	<div class="container">
		<header><img src="img/ck-feed-reader-logo.png" alt="CK Feed Reader" height="24" width="157" /></header>
		<?php echo getArticle($getNewsUrl); ?>
		<main>
			<?php
			echo getFilters();
			echo getFeeds($getGroup);
			?>
		</main>
		<aside><?php require('./components/CrudFeeds.php'); ?></aside>
		<footer id="page-footer">
			<div class="container">© Cors, Frontend Developer 2023</div>
		</footer>
	</div>
</body>

</html>