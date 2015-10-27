<?php

/*

color-rest-app
Main index page

*/

?>

<html>
<head>
<title> Color REST app </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" >

<style>
	body {
		margin: 0 auto;
		max-width: 1400px;
		text-align: center;
	}
	div {
		border-radius: 5px;
		margin: 5px auto;
		background-color: #EEE;
	}

	div.color {
		padding: 10px;
		border: 1px solid black;
	}
</style>

</head>

<body>

	<div class="col-sm-offset-2 col-sm-2 col-xs-12">

		<h3> RED </h3>

		<div style="background-color:red" class="color col-xs-4"></div>
		<div style="background-color:red" class="color col-xs-4"></div>
		<div style="background-color:red" class="color col-xs-4"></div>

	</div>
	
	<div class="col-sm-offset-1 col-sm-2 col-xs-12">

		<h3> GREEN </h3>

		<div style="background-color:green" class="color col-xs-4"></div>
		<div style="background-color:green" class="color col-xs-4"></div>
		<div style="background-color:green" class="color col-xs-4"></div>

	</div>

	<div class="col-sm-offset-1 col-sm-2 col-xs-12">

		<h3> BLUE </h3>

		<div style="background-color:blue" class="color col-xs-4"></div>
		<div style="background-color:blue" class="color col-xs-4"></div>
		<div style="background-color:blue" class="color col-xs-4"></div>

	</div>

</body>
</html>