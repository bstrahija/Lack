<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Site Controller
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Site extends CI_Controller {
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function index()
	{
		// Load Lack
		$this->load->library('lack');
		
		// Run it!
		Lack::run();
		
		// Enable profiler
		$this->output->enable_profiler(true);
		
	} // index()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} // Site


/* End of file site.php */