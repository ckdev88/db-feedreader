<?php
if (isset($_POST['addfeed'])) echo addFeed();
?>
<form method="post" class="cud">
	<div class="cud-name">Name</div>
	<div class="cud-url">Url</div>
	<div class="cud-intv">Intv</div>
	<div class="cud-rm">rm</div>

	<div class="cud-name"><label for="addfeed-name" class="sr-only">Name</label><input type="text" id="addfeed-name"
			name="addfeed-name" placeholder="Name..."></div>
	<div class="cud-url">
		<label for="addfeed-url" class="sr-only">URL</label>
		<input type="text" name="addfeed-url" id="addfeed-url" placeholder="URL...">
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
			<option value="6912000">80</option>
			<option value="13824000">160</option>
			<option value="27648000">320</option>
		</select>
	</div>
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
	<div class="cud-name"><label for="updatefield-<?= $feed->id ?>-name" class="sr-only"></label><input type="text"
			id="updatefield-<?= $feed->id ?>-name" name="updatefield[<?= $feed->id ?>][]name"
			value="<?= $feed->name ?>" /></div>
	<div class="cud-url"><label for="updatefield-<?= $feed->id ?>-url" class="sr-only"></label><input type="text"
			id="updatefield-<?= $feed->id ?>-url" name="updatefield[<?= $feed->id ?>][]url" value="<?= $feed->url ?>" />
	</div>
	<div class="cud-interval"><label for="updatefield-<?= $feed->id ?>-interval" class="sr-only"></label>
		<select id="updatefield-<?= $feed->id ?>-interval" name="updatefield[<?= $feed->id ?>][]interval">
			<option value="86400" <?=($feed->interval === 86400 || '') ? 'selected' : ''; ?>>1</option>
			<option value="259200" <?=($feed->interval === 259200 || '') ? 'selected' : ''; ?>>3</option>
			<option value="432000" <?=($feed->interval == 432000) ? 'selected' : ''; ?>>5</option>
			<option value="864000" <?=($feed->interval == 864000) ? 'selected' : ''; ?>>10</option>
			<option value="1728000" <?=($feed->interval == 1728000) ? 'selected' : ''; ?>>20</option>
			<option value="3456000" <?=($feed->interval == 3456000) ? 'selected' : ''; ?>>40</option>
			<option value="6912000" <?=($feed->interval == 6912000) ? 'selected' : ''; ?>>80</option>
			<option value="13824000" <?=($feed->interval == 13824000) ? 'selected' : ''; ?>>160</option>
			<option value="27648000" <?=($feed->interval == 27648000) ? 'selected' : ''; ?>>320</option>
		</select>
	</div>
	<div class="cud-rm"><label for="chk-<?= $feed->id ?>-remove" class="sr-only">Remove this feed</label><input
			id="chk-<?= $feed->id ?>-remove" type="checkbox" name="updatefield[<?= $feed->id ?>][]hidden"
			<?=($feed->hidden ? ' checked' : '') ?> /></div>
	<?php
	}
	?>
	<div class="cud-submit">
		<input type="hidden" name="updatefeeds" value="true" />
		<input type="submit" value="Update feeds" />
	</div>
</form>
