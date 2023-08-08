<?php
require('supabase.php');
if (isset($_POST['updatefeeds'])) listFeedsUpdate();

function addFeed()
{
	if (isset($_POST['addfeed'])) {
		global $service;
		if (boolval($_POST['addfeed']) === true) {
			$db = $service->initializeDatabase('feeds', 'id');

			if (
				$_POST['addfeed-name'] != ''
				&& $_POST['addfeed-url'] != ''
				&& isset($_POST['addfeed-rss-suffix'])
			) {
				$newFeed = [
					'name' => $_POST['addfeed-name'],
					'url'       => $_POST['addfeed-url'],
					'rss_suffix'  => $_POST['addfeed-rss-suffix'],
					'interval'  => (int)$_POST['addfeed-interval'],
					'new_window'  => (isset($_POST['addfeed-new-window']) ? true : false),
					'hidden'  => (isset($_POST['hidden']) ? true : false),
				];

				try {
					$data = $db->insert($newFeed);
					print_r($data);
					//returns an array with the new register data
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}
		}
	}
}
function ListFeeds()
{
	global $service;
	$db = $service->initializeDatabase('feeds', 'id');

	try {
		$listFeeds = $db->fetchAll()->getResult(); // fetch all feeds
		return $listFeeds;
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function ListFeedsUpdate()
{
	if (isset($_POST['updatefeeds'])) {
		global $service;
		$db = $service->initializeDatabase('feeds', 'id');

		$updatedata = $_POST['updatefield'];
		if (is_array($updatedata)) {
			try {
				foreach ($updatedata as $key => $feed) {
					$updateFeed = [
						'name' => $feed[0],
						'url' => $feed[1],
						'rss_suffix' => $feed[2],
						'interval' => (int)$feed[3],
						'new_window' => (!isset($feed[4]) ? false : true),
						'hidden' => (!isset($feed[5]) ? false : true)
					];
					$data = $db->update((string)$key, $updateFeed);
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
}
