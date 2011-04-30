<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Site Controller
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Site extends Lack {
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function index()
	{
		// Run it!
		Lack::run();
		
		// Enable profiler
		$this->output->enable_profiler(true);
		
	} // index()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} // Site


/* End of file site.php */