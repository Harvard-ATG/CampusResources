<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('link','',TRUE);
	}

	function search()
	{
		$callback = $this->input->get('callback');

		# Get Links
		$categoriesPOST = $this->input->post('categories');

		if ($categoriesPOST == '[]')
		{
			echo "";
			return;
		}
		
		$linksArray = $this->link->getLinksWithCategories($categoriesPOST);
		
		# Score Links
		$categories = json_decode($categoriesPOST);
		
		if (is_array($categories))
	    {
		    foreach($linksArray as $link)
		    {   
		    	$link->score = 0;
		        foreach($categories as $cat1)
		        {
			        $cat1Array = (array) $cat1;
			    	reset($cat1Array);
			    	$cat1Name = key($cat1Array);
			    	
				    if (strpos($link->category1,$cat1Name)!==false)
					{
						$link->score = $link->score + 1;
					}

				    
				    if (count($cat1Array[$cat1Name]) > 0)
				    {
				    	for ($i = 0; $i < count($cat1Array[$cat1Name]); $i++)
				    	{
				    		$cat2 = $cat1Array[$cat1Name][$i];
				    		if (strpos($link->category2,$cat2)!==false)
				    		{
					    		$link->score = $link->score + 1;
					    	}
				    	}
				    }
				    

		        }
		        
		    }
	    }

		# Sort Links
		$score = array();
		foreach ($linksArray as $link)
		{
			$score[$link->id] = $link->score;
		}
		array_multisort($score, SORT_DESC, $linksArray);
		
		# Return Links encoded as JSON
		$jsondata = json_encode($linksArray);
		if($callback) {
			$result = $callback."($jsondata)";
		} else {
			$result = $jsondata;
		}

		echo $result;
	}	

	function index()
	{
		$data['test'] = "test";
		$this->load->view('home_view', $data);
	}
}
?>
