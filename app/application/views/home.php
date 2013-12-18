<!DOCTYPE html>

<html>

<head>
	<title>Search for Harvard's Online Resources</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div id = container>
    	<div class="header">
        	<img src = "<?php echo asset_url() . 'img/my_harvard_pic.png';?>" alt="" />
        </div>

	    <div class="main">
	    	<div id = search_tools>
	        	<div id = text_search>
		        	<p> <?php echo $test; ?> </p>
	            </div>
	
	            <div id = checkboxes>
		        	<p> Checkboxes here </p>
	            </div>
	        </div>
	        <div id = results>
				<p>Results here </p>
			</div>
	
	    </div>
    </div>
</body>

</html>
