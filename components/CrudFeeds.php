<?php
if (isset($_POST['addfeed'])) echo addFeed();
?>
<?= expandButton('cud'); ?>
<div class="cud" id="cud">
	<h2>CUD</h2>
	<form method="post">
		<table cellpadding=0 cellspacing=0>
			<tr>
				<td><input type="text" name="addfeed-name" placeholder="Name" size="15"></td>
				<td>
					<input type="text" name="addfeed-url" placeholder="URL" size="25">
				</td>
				<td>
					<input type="text" name="addfeed-rss-suffix" placeholder="RSS Suffix" size="8">
				</td>
				<td>
					<select name="addfeed-interval" style="width:85px;">
						<option value="86400">1 dag</option>
						<option value="259200">3 dagen</option>
						<option value="432000">5 dagen</option>
						<option value="864000">10 dagen</option>
						<option value="1728000">20 dagen</option>
						<option value="3456000">40 dagen</option>
					</select>
				</td>
				<td>nw:<input type="checkbox" name="addfeed-new-window" value="true" /></td>
			</tr>
			<tr>
				<td colspan="5">
					<input type="hidden" name="addfeed" value="true" />
					<input type="submit" value="Add feed" />
				</td>
			</tr>
		</table>
	</form>
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
						<td>
							<select name="updatefield[<?= $feed->id ?>][]interval" style="width:85px;">
								<option value="86400" <?= ($feed->interval === 86400 || '') ? ' selected' : ''; ?>>1 dag</option>
								<option value="259200" <?= ($feed->interval === 259200 || '') ? ' selected' : ''; ?>>3 dagen</option>
								<option value="432000" <?= ($feed->interval == 432000) ? ' selected' : ''; ?>>5 dagen</option>
								<option value="864000" <?= ($feed->interval == 864000) ? ' selected' : ''; ?>>10 dagen</option>
								<option value="1728000" <?= ($feed->interval == 1728000) ? ' selected' : ''; ?>>20 dagen</option>
								<option value="3456000" <?= ($feed->interval == 3456000) ? ' selected' : ''; ?>>40 dagen</option>
							</select>
						</td>
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
						<input type="submit" value="Update feeds" />
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>