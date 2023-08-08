<?php
require('supabase.php');

function addFeed()
{
	global $service;
	if (isset($_POST['addfeed'])) {
		pp($_POST, 'red2');
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
					'new_window'  => (isset($_POST['addfeed-new-window']) ? true : false),
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
