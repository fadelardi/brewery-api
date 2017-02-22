<?php
include 'bootstrap.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Beer App</title>
</head>
<body>
<h3>Distilled SCH Beer App</h3>

<div>
	<div>
		<span><?=$randomBeer['data']['name']?></span>
		<div><img src="<?=$randomBeer['data']['labels']['icon']?>" /></div>
	</div>
	<div><?=$randomBeer['data']['description']?></div>
	<div>
		<form method="get" action="">
			<input type="submit" name="action" value="Another Beer" />
			<input type="submit" name="action" value="More from this Brewery" />
			<input type="hidden" name="bid" value="<?=$bid?>" />
		</form>
	</div>
</div>

<h3>Search</h3>
<form method="get" action="">
<div>
	<div><input type="text" name="query" placeholder="Search" required /></div>
	<div><input type="radio" name="type" value="beer" checked="checked" /> Beer <input type="radio" name="type" value="brewery" /> Brewery</div>
	<div><input type="submit" name="action" value="Search" /></div>
</div>
</form>

<?php
if ($results) { 
	?>
	<h3>Search Results</h3>
	<div>
		<?php
		if ($results['status'] == 'failure' || !count($results['data'])) {
			?>
			<div>No results were found.</div>
			<?php
		} else {
			foreach($results['data'] as $res) {
				?>
				<div>
					<div><?=isset($res['labels']['icon']) ? $res['labels']['icon'] : 'No image available'?></div>
					<div><?=$res['name']?></div>
					<div><?=isset($res['description']) ? $res['description'] : 'No description available'?></div>
				</div>
				<?php			
			}
		}
		?>
	</div>
	<?php
}
?>
</body>
</html>
