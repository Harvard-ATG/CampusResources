<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Update extends CI_Controller {
      
    function __construct()
    {
        parent::__construct();
		$this->load->helper(array('form', 'url', 'download'));
		$this->load->model('link', '', TRUE);
    }

    public function index()
    {
		$this->load->view('update_form', array('error' => ' ' ));
    }

	function downloadLinks()
	{
		$output = $this->link->returnAllLinksAsCSV();
		$name = 'links.csv';
		force_download($name, $output);
	}

    function do_upload()
    {

        $config['upload_path'] = dirname(dirname(dirname(realpath(__FILE__)))).DIRECTORY_SEPARATOR.'upload';
        $config['allowed_types'] = '*';
       	$config['max_size']	= '1024';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);


        if ( ! $this->upload->do_upload())
		{
	  		$error = array('error' => $this->upload->display_errors());
 	  		$this->load->view('update_form', $error);
        }
		else
		{
			/* Upload successful! Now try updating database */
	    	$data = array('upload_data' => $this->upload->data());
	    	
	    	// First back up data in the case that the user submits a bad file.
			$output = $this->link->returnAllLinksAsCSV();
			file_put_contents("upload/backupCSV.csv", $output);
			
			$uploadedData = $this->upload->data();
			//$uploadedData['file_name']
			if ($this->link->updateLinks($uploadedData['file_name']) == 0)
			{
				$data['upload_data'] = "SUCCESS";
			}
			else {
				$data['upload_data'] = "FAILURE: no changes made";
				$this->link->updateLinks("backupCSV.csv");
				unlink("upload/backupCSV.csv");
			}
				
	    	
            $this->load->view('update_success', $data);
		}
    }
}
?>
