<div class="crud-feeds">
	<div>
		<?php
		include('incl/AddFeed.php');
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
			<input type="submit" value="post" />
		</form>
	</div>
	<div>
		<h2>Update:</h2>
		<form>



		</form>
	</div>
	<div>
		<h2>Delete:</h2>
		<form></form>
	</div>
</div>
<?php
