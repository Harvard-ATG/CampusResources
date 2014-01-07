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

	function returnAllLinksAsCSV()
	{
		$links = $this->returnAllLinks();
		
		$output = "";
		
		$rows_total = count($links);
		$columns_total = count((array)$links[0]);

		// Get Records from the table
		foreach ($links as &$link) {
			$linkArray = array_values((array)$link);
			for ($i = 0; $i<$columns_total; $i++)
			{
				if ($i != $columns_total - 1) {
					$output.= "\"" . $linkArray[$i]. "\"";
					$output.=",";
				}
				else {
					$output.="\"\"";
				}
			}
			$output.="\n";
		}
		
		return $output;
	}
	
	function updateLinks($filename)
	{
		$field_map = array(
			'id' => 0, 
			'title' => 1, 
            'description' => 2,
			'url' => 3, 
			'category1' => 4, 
			'subCategory1' => 5, 
			'category2' => 6, 
			'subCategory2' => 7,
            'text' => 8
		);

		// try to update
		try
		{
			ini_set('auto_detect_line_endings',TRUE);
			$filepath = "upload/" . $filename;
			$handle = fopen($filepath, 'r');
			if($handle === FALSE) {
				throw new Exception("Error opening csv file {$filename} to update links");
			}

			$this->db->trans_begin();
			$this->db->truncate("links");

			while(($data = fgetcsv($handle, 4096, ',')) !== FALSE) {
				if(isset($data) && implode("", $data) !== '') { 
					$link = array();
					foreach($field_map as $field_name => $field_index) {
						$link[$field_name] = (isset($data[$field_index]) ? $data[$field_index] : '');
					}
					if(!$link['id']) {
						unset($link['id']); // let the DB autoincrement the ID
					}
					$this->db->insert('links', $link);
				}
			}

			$this->db->trans_commit();
			fclose($handle);
			return 0;
		}
		catch (Exception $e)
		{
			log_message('error', "Error updating link model: ".$e->getMessage());
			$this->db->trans_rollback();
			fclose($handle);
			return 1;
		}
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
