<?php
if (isset($_POST['addfeed'])) echo addFeed();
?>
<form method="post" class="cud">
	<div class="cud-name">Name</div>
	<div class="cud-url">Url</div>
	<div class="cud-suffix">Suffix</div>
	<div class="cud-intv">Intv</div>
	<div class="cud-nw">nw</div>
	<div class="cud-rm">rm</div>

	<div class="cud-name"><label for="addfeed-name" class="sr-only">Name</label><input type="text" id="addfeed-name" name="addfeed-name" placeholder="Name..."></div>
	<div class="cud-url">
		<label for="addfeed-url" class="sr-only">URL</label>
		<input type="text" name="addfeed-url" id="addfeed-url" placeholder="URL...">
	</div>
	<div class="cud-suffix"><label for="addfeed-rss-suffix" class="sr-only">Suffix</label>
		<input type="text" name="addfeed-rss-suffix" id="addfeed-rss-suffix" placeholder="RSS Suffix...">
	</div>
	<div class="cud-interval">
		<label for="addfeed-interval" class="sr-only">Interval</label>
		<select name="addfeed-interval" id="addfeed-interval">
			<option value="86400">1</option>
			<option value="259200">3</option>
			<option value="432000">5</option>
			<option value="864000">10</option>
			<option value="1728000">20</option>
			<option value="3456000">40</option>
		</select>
	</div>
	<div class="cud-nw"><label for="chk-new-window" class="sr-only">Open in new window</label><input id="chk-new-window" type="checkbox" name="addfeed-new-window" value="true" /></div>
	<div class="cud-rm">&nbsp;-</div>
	<div class="cud-submit"><input type="hidden" name="addfeed" value="true" />
		<input type="submit" value="Add feed" />
	</div>
</form>
<?php if (!isset($listFeeds)) $listFeeds = ListFeeds(); ?>
<form method="post" class="cud">
	<?php
	foreach ($listFeeds as $feed) {
		if ($feed->url == '') continue;
		if ($feed->hidden === true) continue; ?>
		<div><label for="updatefield-<?= $feed->id ?>-name" class="sr-only"></label><input type="text" id="updatefield-<?= $feed->id ?>-name" name="updatefield[<?= $feed->id ?>][]name" value="<?= $feed->name ?>" /></div>
		<div><label for="updatefield-<?= $feed->id ?>-url" class="sr-only"></label><input type="text" id="updatefield-<?= $feed->id ?>-url" name="updatefield[<?= $feed->id ?>][]url" value="<?= $feed->url ?>" /></div>
		<div><label for="updatefield-<?= $feed->id ?>-suffix" class="sr-only"></label><input type="text" id="updatefield-<?= $feed->id ?>-suffix" name="updatefield[<?= $feed->id ?>][]suffix" value="<?= $feed->rss_suffix ?>" /></div>
		<div><label for="updatefield-<?= $feed->id ?>-interval" class="sr-only"></label>
			<select id="updatefield-<?= $feed->id ?>-interval" name="updatefield[<?= $feed->id ?>][]interval">
				<option value="86400" <?= ($feed->interval === 86400 || '') ? 'selected' : ''; ?>>1</option>
				<option value="259200" <?= ($feed->interval === 259200 || '') ? 'selected' : ''; ?>>3</option>
				<option value="432000" <?= ($feed->interval == 432000) ? 'selected' : ''; ?>>5</option>
				<option value="864000" <?= ($feed->interval == 864000) ? 'selected' : ''; ?>>10</option>
				<option value="1728000" <?= ($feed->interval == 1728000) ? 'selected' : ''; ?>>20</option>
				<option value="3456000" <?= ($feed->interval == 3456000) ? 'selected' : ''; ?>>40</option>
			</select>
		</div>
		<div><label for="chk-<?= $feed->id ?>-new-window" class="sr-only">Open in new window</label><input id="chk-<?= $feed->id ?>-new-window" type="checkbox" name="updatefield[<?= $feed->id ?>][]new_window" <?= ($feed->new_window ? ' checked' : '') ?> /></div>
		<div><label for="chk-<?= $feed->id ?>-remove" class="sr-only">Remove this feed</label><input id="chk-<?= $feed->id ?>-remove" type="checkbox" name="updatefield[<?= $feed->id ?>][]hidden" <?= ($feed->hidden ? ' checked' : '') ?> /></div>
	<?php
	}
	?>
	<div class="cud-submit">
		<input type="hidden" name="updatefeeds" value="true" />
		<input type="submit" value="Update feeds" />
	</div>
</form>