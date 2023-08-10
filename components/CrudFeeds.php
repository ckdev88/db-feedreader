<?php
if (isset($_POST['addfeed'])) echo addFeed();
?>
<div class="cud" id="cud">
	<form method="post">
		<table cellpadding=0 cellspacing=0>
			<thead>
				<tr>
					<th>Name</th>
					<th>Url</th>
					<th>Suffix</th>
					<th>Intv d</th>
					<th>nw</th>
					<th>rm</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label for="addfeed-name" class="sr-only">Name</label><input type="text" id="addfeed-name" name="addfeed-name" placeholder="Name..." size="12"></td>
					<td>
						<label for="addfeed-url" class="sr-only">URL</label>
						<input type="text" name="addfeed-url" id="addfeed-url" placeholder="URL..." size="25">
					</td>
					<td><label for="addfeed-rss-suffix" class="sr-only">Suffix</label>
						<input type="text" name="addfeed-rss-suffix" id="addfeed-rss-suffix" placeholder="RSS Suffix..." size="8">
					</td>
					<td>
						<label for="addfeed-interval" class="sr-only">Interval</label>
						<select name="addfeed-interval" id="addfeed-interval" style="width:70px">
							<option value="86400">1</option>
							<option value="259200">3</option>
							<option value="432000">5</option>
							<option value="864000">10</option>
							<option value="1728000">20</option>
							<option value="3456000">40</option>
						</select>
					</td>
					<td><label for="chk-new-window" class="sr-only">Open in new window</label><input id="chk-new-window" type="checkbox" name="addfeed-new-window" value="true" /></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5" class="pt-1">
						<input type="hidden" name="addfeed" value="true" />
						<input type="submit" value="Add feed" />
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
	<?php if (!isset($listFeeds)) $listFeeds = ListFeeds(); ?>
	<form method="post"><br />
		<table cellpadding="0" cellspacing="0">
			<tbody>
				<?php
				foreach ($listFeeds as $feed) {
					if ($feed->url == '') continue;
					if ($feed->hidden === true) continue; ?>
					<tr>
						<td><label for="updatefield-<?= $feed->id ?>-name" class="sr-only"></label><input type="text" id="updatefield-<?= $feed->id ?>-name" name="updatefield[<?= $feed->id ?>][]name" value="<?= $feed->name ?>" size="12" /></td>
						<td><label for="updatefield-<?= $feed->id ?>-url" class="sr-only"></label><input type="text" id="updatefield-<?= $feed->id ?>-url" name="updatefield[<?= $feed->id ?>][]url" value="<?= $feed->url ?>" size="25" /></td>
						<td><label for="updatefield-<?= $feed->id ?>-suffix" class="sr-only"></label><input type="text" id="updatefield-<?= $feed->id ?>-suffix" name="updatefield[<?= $feed->id ?>][]suffix" value="<?= $feed->rss_suffix ?>" size="8" /></td>
						<td><label for="updatefield-<?= $feed->id ?>-interval" class="sr-only"></label>
							<select id="updatefield-<?= $feed->id ?>-interval" name="updatefield[<?= $feed->id ?>][]interval" style="width:70px;">
								<option value="86400" <?= ($feed->interval === 86400 || '') ? 'selected' : ''; ?>>1</option>
								<option value="259200" <?= ($feed->interval === 259200 || '') ? 'selected' : ''; ?>>3</option>
								<option value="432000" <?= ($feed->interval == 432000) ? 'selected' : ''; ?>>5</option>
								<option value="864000" <?= ($feed->interval == 864000) ? 'selected' : ''; ?>>10</option>
								<option value="1728000" <?= ($feed->interval == 1728000) ? 'selected' : ''; ?>>20</option>
								<option value="3456000" <?= ($feed->interval == 3456000) ? 'selected' : ''; ?>>40</option>
							</select>
						</td>
						<td><label for="chk-<?= $feed->id ?>-new-window" class="sr-only">Open in new window</label><input id="chk-<?= $feed->id ?>-new-window" type="checkbox" name="updatefield[<?= $feed->id ?>][]new_window" <?= ($feed->new_window ? ' checked' : '') ?> /></td>
						<td><label for="chk-<?= $feed->id ?>-remove" class="sr-only">Remove this feed</label><input id="chk-<?= $feed->id ?>-remove" type="checkbox" name="updatefield[<?= $feed->id ?>][]hidden" <?= ($feed->hidden ? ' checked' : '') ?> /></td>
					</tr>
				<?php
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" class="pt-1">
						<input type="hidden" name="updatefeeds" value="true" />
						<input type="submit" value="Update feeds" />
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>