<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Authentication Controller
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Authentication extends CI_Controller {
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load resources
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'auth'));
		
	} //end __contruct()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function index()
	{
		$this->login();
		
	} //end index()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function login()
	{
		$data = array();
		
		// Try to login
		if ($this->input->post())
		{
			if (Auth::login($this->input->post('password', true)))
			{
				redirect('backend/content');
			}
			else
			{
				$data['error'] = 'Wrong password.';
			}
		}
		
		// Load login form
		$data['yield'] = $this->load->view('backend/authentication/login', $data, true);
		
		// Load layout
		$this->load->view('backend/authentication/layout', $data);
		
	} // end login()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function logout()
	{
		Auth::logout();
		redirect('backend/authentication/login');
		
	} // end logout()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} //end Authentication


/* End of file authentication.php */