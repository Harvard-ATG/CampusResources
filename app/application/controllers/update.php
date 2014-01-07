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
		$upload_path = dirname(dirname(dirname(realpath(__FILE__)))).'/upload';

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = '*';
		$config['max_size']	= '1024';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);


		if (!$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('update_form', $error);
		}
		else
		{
			/* Upload successful! Now try updating database */
			$data = array('upload_data' => $this->upload->data());
			
			// First back up data in the case that the user submits a bad file.
			$backup_filename = "$upload_path/backupCSV.csv";
			file_put_contents($backup_filename, $this->link->returnAllLinksAsCSV());
			
			$uploaded_data = $this->upload->data();
			$upload_filename = $upload_path.'/'.$uploaded_data['file_name'];

			if ($this->link->updateLinks($upload_filename) == 0)
			{
				$data['upload_data'] = "SUCCESS";
			}
			else {
				$data['upload_data'] = "FAILURE: no changes made";
				$this->link->updateLinks($backup_filename);
				unlink($backup_filename);
			}
			
			$this->load->view('update_success', $data);
		}
    }
}
?>
