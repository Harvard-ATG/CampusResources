<?php

// Connection
$con=mysqli_connect("localhost","username","password","database");

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Get all links
$result = mysqli_query($con,"SELECT * FROM links");

$numRows = mysqli_num_rows($result);
    
while($row = mysqli_fetch_array($result))
{
    print("Checking id:" . $row['id'] . "<br>\n");


	$text = file_get_contents($row['url']);
	$dom = new DOMDocument;
	
	libxml_use_internal_errors(true);
	$dom->loadHTML($text);
	$ps = $dom->getElementsByTagName('p');
	
	$bodyText = "";
	
	foreach ($ps as $paragraph) {
		$bodyText.=$paragraph->nodeValue;
	}
	
	$bodyText = substr(strip_tags($bodyText),0,8192);
	$bodyText = str_replace("'", "", $bodyText);
	$bodyText = str_replace("\"", "", $bodyText);
	$bodyText = str_replace(",", "", $bodyText);
	$bodyText = str_replace("\n", "", $bodyText);
	
	
	$sql = "update links set `text`='{$bodyText}' where `id`='{$row['id']}'";
   
    $textUpdateResult = mysqli_query($con,$sql);

	
    set_time_limit(0);


}


mysqli_close($con);
?>
