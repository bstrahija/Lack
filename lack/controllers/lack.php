<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Lack Controller
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Lack extends CI_Controller {
	
	protected $data = array();
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Run some setup actions
		$this->_setup();
		
	} // __contruct()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function index()
	{
		if ( ! $this->uri->segment(1)) $content_file = './data/index.md';
		else                           $content_file = './data/'.$this->uri->segment(1).'.md';
		
		if (file_exists($content_file))
		{
			// Get content
			$this->data['content'] = markdown(read_file($content_file));
			
			// And load view
			$this->load->view('layout', $this->data);
		}
		else
		{
			$this->error_404();
		}
		
	} // index()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	private function _setup()
	{
		// Load resources
		$this->load->helper(array('file', 'directory', 'date', 'form', 'html', 'array', 'url', 'string', 'text', 'typography'));
		
	} // _setup()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function error_404()
	{
		show_404();
		
	} // error_404()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} // Lack


// Get the markdown parser
include(APPPATH.'/third_party/markdown.php');


/* End of file lack.php */