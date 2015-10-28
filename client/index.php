<?php

/*

color-rest-app
Main index page

*/

require_once 'colorrequest.php';

if(isset($_GET) && isset($_GET['id']) && isset($_GET['color'])) {

	$id = $_GET['id'];
	$color = $_GET['color'];

	$colorRequest = new ColorRequest('PUT', '/colors/' . $id . '/' . $color);
	$response = $colorRequest->request();

	if (!isset($response->error)) {

		header('Refresh: 0; url=index.php');

	} else {
		
		exit($reponse->error);

	}
}

$colorOptions = ['red', 'green', 'blue'];

$colorRequest = new ColorRequest('GET', '/colors/');
$colors = $colorRequest->request();

if(!isset($colors->error)) {
	
	foreach($colors as $color) {

		$colorGroups[$color->color][] = $color;
	}
}
else {

	exit( $colors->error );

} ?>

<html>

<head>
<title> Color REST app </title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" >

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>	

<style>

	body {
		margin: 0 auto;
		max-width: 1400px;
		text-align: center;
	}
	div {
		border-radius: 5px;
		margin: 5px auto;
	}

	div.section {
		background-color: #EEE;
	}

	div.color {
		padding: 10px;
		border: 1px solid black;
		cursor: pointer;
	}

	div.color p{
		margin: 0;
		color: white;
	}

	a.color {
		padding: 10px 20px;
		color: white;
		text-decoration: none;
		border: 1px solid black;
		border-radius: 5px;
	}

</style>
</head>

<body>

	<?php

	if(!isset($colors->error)) {
		
		foreach(array_keys($colorGroups) as $option) { ?>

			<div class="section col-sm-offset-3 col-sm-6 col-xs-12">
				
				<h3> <?php echo $option ?> </h3>

			 	<?php
			 	
			 	foreach($colorGroups[$option] as $color) {

					displayModal($color, $colorOptions); ?>

					<div style="background-color:<?php echo $color->color; ?>" 
							class="color col-xs-2" data-toggle="modal" 
							data-target="#myModal<?php echo $color->id; ?>">

						<p> <?php echo $color->id; ?> </p>

					</div>

				<?php
				} ?>

			</div>

		<?php
		}
	} ?>

</body>
</html>

<?php
function displayModal($color, $groups) { ?>

	<div class="modal fade" id="myModal<?php echo $color->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
				 
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				    <h2 class="modal-title" id="myModalLabel"> Change color? </h2>

				</div>

				<div class="modal-body row">
					
					<?php
					
					foreach($groups as $option) { 

						$href = 'index.php?id='.$color->id.'&color='.$option; ?>

						<a style="background-color:<?php echo $option; ?>" 
							class="color col-sm-offset-5 col-sm-2 col-xs-offset-2 col-xs-8"
							href="<?php echo $href; ?>"> <?php echo $color->id; ?> </a>
					
					<?php 
					} ?>

				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>

			</div>
		</div>
	</div>

<?php
} ?>