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
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Feeds</title>
	<style type="text/css">
		<?php include('./styles.css');
		?>
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description"
		content="Feed reader, input the feed and get links to the articles posted there, filtered by date per feed." />
	<meta name="author" content="Cors" />
	<link rel="manifest" href="/manifest.json" />
	<meta name="theme-color" content="#3367D6">
</head>

<body>
	<div class="container">
		<!-- <header><img src="img/ck-feed-reader-logo.png" alt="CK Feed Reader" height="24" /></header> -->
		<main>
			<?php
			echo getFilters();
			echo getFeeds($getGroup);
			?>
		</main>
		<aside>
			<?php require('./components/CrudFeeds.php'); ?>
		</aside>
		<footer id="page-footer">
			© Cors - 2023
		</footer>
	</div>
	<script src="incl/script.js"></script>
</body>

</html>
