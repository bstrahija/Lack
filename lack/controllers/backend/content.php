<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Content Controller
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Content extends CI_Controller {
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load resources
		$this->load->library(array('auth', 'lack'));
		$this->load->helper(array('directory', 'file'));
		
		// Restrict access
		Auth::restrict();
		
	} // __contruct()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function index()
	{
		$this->browse();
		
	} // index()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	function browse($path = null)
	{
		$data['path'] = $path;
		$path         = config_item('data').'/'.$path;
		
		// Get all files and folders in data directory
		$data['directories'] = $this->_filter_dir_data(directory_map($path));
		$data['entries']     = $this->_filter_entry_data(directory_map($path));
		
		// Load login form
		$data['yield'] = $this->load->view('backend/content/index', $data, true);
		
		// Load layout
		$this->load->view('backend/layout', $data);
		
	} // browse()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function add()
	{
		$data = array();
		
		// Load add form
		$data['yield'] = $this->load->view('backend/content/add', $data, true);
		
		// Try to save content
		if ($this->input->post('content') and $this->input->post('filename'))
		{
			$filename = $this->input->post('filename').'.'.config_item('data_extension');
			$file     = config_item('data').'/'.$filename;
			
			// Write the data
			write_file($file, $this->input->post('content', true));
			
			// Redirect to edit form
			redirect('backend/content/edit/'.$filename.'?notice=Content saved.');
		}
		
		// Load layout
		$this->load->view('backend/layout', $data);
		
	} // add()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function edit($file = null, $file_in_dir = null)
	{
		if ($this->uri->segment(5)) $file = config_item('data').'/'.$file.'/'.$this->uri->segment(5);
		else                        $file = config_item('data').'/'.$file;
		
		// Try to save content
		if ($this->input->post('content'))
		{
			write_file($file, $this->input->post('content', true));
			$data['notice'] = 'Content saved.';
		}
		
		
		// Load the content
		if ($this->uri->segment(5))
		{
			$data['content'] = read_file($file);
		}
		else
		{
			$data['content'] = read_file($file);
		}
		
		// Load edit form
		$data['file']  = $file;
		$data['yield'] = $this->load->view('backend/content/edit', $data, true);
		
		// Load layout
		$this->load->view('backend/layout', $data);
		
	} // edit()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function preview()
	{
		$data['content'] = markdown($this->input->post('data'));
		
		// Load layout
		$this->load->view('backend/content/preview', $data);
		
	} // end preview()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 * Returns only data file and folders
	 *
	 */
	private function _filter_entry_data($map = null)
	{
		unset($map['assets']);
		unset($map['system_assets']);
		
		$entries = array();
		foreach ($map as $key=>$m)
		{
			if ( ! is_array($m)) $entries[] = $m;
		}
		
		return $entries;
		
	} // _filter_entry_data()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	private function _filter_dir_data($map = null)
	{
		unset($map['assets']);
		unset($map['system_assets']);
		
		$dirs = array();
		foreach ($map as $key=>$m)
		{
			if (is_array($m)) $dirs[] = $key;
		}
		
		return $dirs;
		
	} // _filter_dir_data()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} //end Content


/* End of file content.php */