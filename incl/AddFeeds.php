<?php
require('supabase.php');

function addFeeds()
{
	global $service;
	$db = $service->initializeDatabase('feeds', 'id');

	if (isset($_POST['addfeed-name']) && isset($_POST['addfeed-url']) && isset($_POST['addfeed-rss-suffix']) && isset($_POST['addfeed-new-window'])) {
		$newFeed = [
			'name' => $_POST['addfeed-name'],
			'url'       => $_POST['addfeed-url'],
			'rss_suffix'  => $_POST['addfeed-rss-suffix'],
			'new_window'  => ($_POST['addfeed-new-window'] == 'on' ? true : false),
		];


		try {
			$data = $db->insert($newFeed);
			// print_r($data); //returns an array with the new register data
			/*
        Array
        (
            [0] => stdClass Object
                (
                    [id] => 1
                    [productname] => XBOX Series S
                    [price] => 299.99
                    [categoryid] => 1
                )
        )
    */
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
?>

	<form method="post">
		<label>
			<dd>Name</dd>
			<dt><input type="text" name="addfeed-name"></dt>
		</label><br />
		<label>
			<dd>URL</dd>
			<dt><input type="text" name="addfeed-url"></dt>
		</label><br />
		<label>
			<dd>RSS Suffix</dd>
			<dt><input type="text" name="addfeed-rss-suffix"></dt>
		</label><br />
		<label>
			<dd>New window</dd>
			<dt><input type="checkbox" name="addfeed-new-window" /></dt>
		</label>
		<input type="submit" value="post" />
	</form>

<?php
}
