<?php require('supabase.php');

function UpdateFeeds()
{
	global $service;
	$db = $service->initializeDatabase('feeds', 'id');
	try {
		$listFeeds = $db->fetchAll()->getResult(); //fetch all feeds
		foreach ($listFeeds as $feed) {
			echo '<li>'
				. $feed->id . ' - '
				. $feed->name . ': '
				. $feed->url
				. $feed->rss_suffix . ' _blank: '
				. $feed->new_window
				. '</li>';
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}
