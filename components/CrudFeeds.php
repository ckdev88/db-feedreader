<div class="crud-feeds">
	<div class="create">
		<?php
		if (isset($_POST['addfeed'])) echo addFeed();
		?>
		<h2>Create:</h2>
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
				<dt><input type="checkbox" name="addfeed-new-window" value="true" /></dt>
			</label>
			<input type="hidden" name="addfeed" value="true" />
			<input type="submit" />
		</form>
	</div>
	<div class="read">
		<h2>Read/List:</h2>
		<?php
		$listFeeds = ListFeeds();
		foreach ($listFeeds as $feed) {
			echo '<li>'
				. $feed->id . ' - '
				. $feed->name . ': '
				. $feed->url
				. $feed->rss_suffix . ' _blank: '
				. $feed->new_window
				. '</li>';
		}
		?>
	</div>
	<div class="update">
		<?php
		if (isset($_POST['updatefeeds'])) echo listFeedsUpdate();
		// include('incl/ListFeedsUpdate.php');
		?>
		<h2>Update:</h2>
		<?php if (!isset($listFeeds)) $listFeeds = ListFeeds(); ?>

		<form method="post">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Url</th>
						<th>Suffix</th>
						<th>nw</th>
						<!-- <th>rm</th> // not yet -->
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($listFeeds as $feed) {
						if ($feed->url == '') continue;	?>
						<tr>
							<td><input type="text" name="updatefield[<?= $feed->id ?>][]name" value="<?= $feed->name ?>" size="15" /></td>
							<td><input type="text" name="updatefield[<?= $feed->id ?>][]url" value="<?= $feed->url ?>" size="25" /></td>
							<td><input type="text" name="updatefield[<?= $feed->id ?>][]suffix" value="<?= $feed->rss_suffix ?>" size="8" /></td>
							<td><input type="checkbox" name="updatefield[<?= $feed->id ?>][]-new_window" <?= ($feed->new_window ? ' checked' : '') ?> /></td>
							<!-- <td><input type="checkbox"  name="updatefield-<?= $feed->id ?>-remove" /></td>'; // not yet -->
						</tr>
					<?php
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<input type="hidden" name="updatefeeds" value="true" />
							<input type="submit" />
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
	<div class="delete">
		<h2>Delete:</h2>
		<form></form>
	</div>
</div>
<?php
