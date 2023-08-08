<div class="crud-feeds">
	<div class="create">
		<?php
		if (isset($_POST['addfeed'])) echo addFeed();
		?>
		<h2>Create:</h2>
		<form method="post">
			<input type="text" name="addfeed-name" placeholder="Name" size="15">
			<input type="text" name="addfeed-url" placeholder="URL" size="25">
			<input type="text" name="addfeed-rss-suffix" placeholder="RSS Suffix" size="8">
			<input type="number" name="addfeed-interval" placeholder="In seconds" style="width:85px;" value="86400">
			nw: <input type="checkbox" name="addfeed-new-window" value="true" />
			<input type="hidden" name="addfeed" value="true" />
			<input type="submit" />
		</form>
	</div>
	<div class="read">
		<h2>Read/List:</h2>
		<?php
		$listFeeds = ListFeeds();
		foreach ($listFeeds as $feed) {
			if ($feed->hidden === true) continue;
			echo '<li>'
				. $feed->id . ' - '
				. $feed->name . ': '
				. $feed->url
				. $feed->rss_suffix . ' _blank: '
				. $feed->interval . ' '
				. $feed->new_window
				. $feed->hidden
				. '</li>';
		}
		?>
	</div>
	<div class="update">
		<?php

		?>
		<h2>Update & Delete:</h2>
		<?php if (!isset($listFeeds)) $listFeeds = ListFeeds(); ?>

		<form method="post">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Url</th>
						<th>Suffix</th>
						<th>Intv</th>
						<th>nw</th>
						<th>rm</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($listFeeds as $feed) {
						if ($feed->url == '') continue;
						if ($feed->hidden === true) continue; ?>
						<tr>
							<td><input type="text" name="updatefield[<?= $feed->id ?>][]name" value="<?= $feed->name ?>" size="15" /></td>
							<td><input type="text" name="updatefield[<?= $feed->id ?>][]url" value="<?= $feed->url ?>" size="25" /></td>
							<td><input type="text" name="updatefield[<?= $feed->id ?>][]suffix" value="<?= $feed->rss_suffix ?>" size="8" /></td>
							<td><input type="number" name="updatefield[<?= $feed->id ?>][]interval" value="<?= $feed->interval ?>" style="width:85px;" /></td>
							<td><input type="checkbox" name="updatefield[<?= $feed->id ?>][]new_window" <?= ($feed->new_window ? ' checked' : '') ?> /></td>
							<td><input type="checkbox" name="updatefield[<?= $feed->id ?>][]hidden" <?= ($feed->hidden ? ' checked' : '') ?> /></td>
						</tr>
					<?php
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">
							<input type="hidden" name="updatefeeds" value="true" />
							<input type="submit" />
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>