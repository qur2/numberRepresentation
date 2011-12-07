<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Klingon number machine</title>
	<link rel="stylesheet" href="<?php echo $basePath;?>/www/css/reset.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $basePath;?>/www/css/styles.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $basePath;?>/www/css/buttons.css" type="text/css" />
	<!--[if lt IE 9]>
	<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src='<?php echo $basePath;?>/vendor/jquery/jquery.js' type='text/javascript' charset='utf-8'></script>
	<script src='<?php echo $basePath;?>/www/js/ui.js' type='text/javascript' charset='utf-8'></script>
</head>
<body>
	<div class="wrapper">
		<form action="<?php echo $basePath;?>" id="controls">
		<div class="controls-wrapper">
			<select name="responseType">
				<option value="plain" selected="selected">Good ol' plain text</option>
				<option value="json">JSON</option>
				<option value="xml">XML</option>
			</select>
			
			<select name="language">
				<option value="klingon" selected="selected">Klingon</option>
			<select>
			
			<select name="inputType">
				<option value="number" selected="selected">Number</option>
				<option value="pronoun">Pronoun</option>
			</select>
			
			<input type="text" name="inputValue" />
			
			<button type="submit" class="button grey">Submit</button>
		</div>
		
		<div class="clear"></div>

		<div class="response-wrapper">
			<textarea id="response"></textarea>
		</div>
		</form>
<body>
</body>
</html>