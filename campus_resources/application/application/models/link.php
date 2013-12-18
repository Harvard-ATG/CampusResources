<?php
Class Link extends CI_Model
{

	/*
	"Array
(
    [0] => stdClass Object
        (
            [Health and Safety] => Array
                (
                    [0] => Immediate Crisis
                )

        )

    [1] => stdClass Object
        (
            [Residential Life] => Array
                (
                )

        )

)
1"
*/

    function returnAllLinks()
	{

		$sql = "SELECT * FROM links";			
		$query = $this->db->query($sql);

		return $query->result();
	}

	function getLinksWithCategories($categories)
	{
		$categories = json_decode($categories);
		
		
		$queryString = '';
		$queryString2 = '';
		
		
	    if (is_array($categories))
	    {
		    foreach($categories as $cat1)
		    {
		    	$cat1Array = (array) $cat1;
		    	reset($cat1Array);
		    	$cat1Name = key($cat1Array);
		    	
			    if ($queryString == '')
			    {
				    $queryString = "(category1 LIKE '%$cat1Name%'";
			    }
			    else
			    {
			        $queryString = $queryString . " OR (category1 LIKE '%$cat1Name%'";
			    }
			    
			    if ($queryString2 == '')
			    {
				    $queryString2 = "(category2 LIKE '%$cat1Name%'";
			    }
			    else
			    {
			        $queryString2 = $queryString2 . " OR (category2 LIKE '%$cat1Name%'";
			    }
			    
			    if (count($cat1Array[$cat1Name]) > 0)
			    {
			    	for ($i = 0; $i < count($cat1Array[$cat1Name]); $i++)
			    	{
			    		$cat2 = $cat1Array[$cat1Name][$i];
			    		if ($i == 0)
			    		{
				    		$queryString = $queryString . " AND (subCategory1 LIKE '%$cat2%'";
				    		$queryString2 = $queryString2 . " AND (subCategory2 LIKE '%$cat2%'";
			    		}
			    		else
			    		{
				    		$queryString = $queryString . " OR subCategory1 LIKE '%$cat2%'";
				    		$queryString2 = $queryString2 . " OR subCategory2 LIKE '%$cat2%'";
			    		}
			    	}
			    	$queryString = $queryString . ")";
			    	$queryString2 = $queryString2 . ")";
			    }
			    
			    $queryString = $queryString . ")";
			    $queryString2 = $queryString2 . ")";
		    }
	    }
		
				
		$sql = "SELECT * FROM links WHERE (" . $queryString . " OR " . $queryString2 . ")";			
		$query = $this->db->query($sql);
		
		#return $sql;
		return $query->result();
	}
}
?>