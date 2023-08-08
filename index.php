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
	<main>
		<article id="nieuwsartikel"><?php echo getArticle($getNewsUrl); ?></article>
		<?php require('./components/CrudFeeds.php'); ?>
		<?php
		echo getFilters();
		echo getFeeds($getGroup);
		?>
	</main>
</body>

</html>