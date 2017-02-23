<?php
include 'bootstrap.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Beer App</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="static/style.css">
</head>
<body>

<div class="container">
<h3>Distilled SCH Beer App</h3>
	<?php
	if (!isset($randomBeer['status']) || $randomBeer['status'] == 'failure') {
		?>
		<div class="col-md-10">
			<b class="bg-primary">The random beer of the day could not be loaded. The script gave up trying to find an image that met the criteria, or the API is taking no more requests for the day.</b>
		</div>
		<?php
	} else {
		?>
		<div class="col-md-12"><b><?=$randomBeer['data']['name']?></b></div>
		<div class="col-md-2">
			<div><img src="<?=$randomBeer['data']['labels']['icon']?>" class="img-thumbnail" /></div>
		</div>
		<div class="col-md-8"><?=$randomBeer['data']['description']?></div>
		<?php 
	}
	?>
	<div class="col-md-2">
		<form method="get" action="">
			<input type="submit" name="action" value="Another Beer" class="btn btn-primary btn-block" />
			<input type="submit" name="action" value="More from Brewery" class="btn btn-primary btn-block" />
			<input type="hidden" name="bid" value="<?=$bid?>" />
		</form>
	</div>

</div>

<form method="get" action="">
<div class="container">
	<h3>Search</h3>
	<div class="col-md-6"><input type="text" name="query" placeholder="Search" class="form-control" value="<?=$_GET['query']?>" required /></div>
	<div class="col-md-4">
		<div>
		<label class="radio-inline">
			<input type="radio" name="type" value="beer" <?=!isset($_GET['type']) || $_GET['type'] == 'beer' ? 'checked' : ''?>> Beer 
		</label>
		<label class="radio-inline">
			<input type="radio" name="type" value="brewery" <?=isset($_GET['type']) && $_GET['type'] == 'brewery' ? 'checked' : ''?>> Brewery
		</label>
		</div>
	</div>
	<div class="col-md-2"><input type="submit" name="action" value="Search" class="btn btn-primary" /></div>
</div>
</form>

<?php
if ($results) { 
	?>
	<div class="container">
		<h3>Search Results</h3>
		<?php
		if ($results['status'] == 'failure' || !count($results['data'])) {
			?>
			<div class="col-md-12">No results were found.</div>
			<?php
		} else {
			foreach($results['data'] as $res) {
				?>
				<div class="col-md-12 result-box">
					<div class="col-md-2">
						<?=isset($res['labels']['icon']) ? '<img src="' . $res['labels']['icon'] .'" class="img-thumbnail" />' : '<div class="img-thumbnail fake-thumbnail"></div>'?>	
					</div>
					<div class="col-md-10">
						<div><?=$res['name']?></div>
						<div><?=isset($res['description']) ? $res['description'] : 'No description available'?></div>
					</div>
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
