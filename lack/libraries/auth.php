<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Authentication Library
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Auth {
	
	protected static $ci;
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		self::$ci = get_instance();
		
		// Load resources
		self::$ci->load->helper(array('security'));
		self::$ci->load->library(array('session'));
		
		// Load system settings
		self::$ci->config->load('lack');
		
	} //end __contruct()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function login($password = null)
	{
		$hashed_password = hash('sha256', xss_clean($password));
		
		if(config_item('lack_password') == $hashed_password)
		{
			$user_data = array(
				'userloggedin' => true,
				'userkey'      => $hashed_password,
			);
			self::$ci->session->set_userdata($user_data);
			
			return true;
		}
		
		return false;
		
	} //end login()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function logout()
	{
		self::$ci->session->sess_destroy();
		
	} // end logout()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function logged_in()
	{
		$logged_in = self::$ci->session->userdata('userloggedin');
		$user_key  = self::$ci->session->userdata('userkey');
		
		if ((bool) $logged_in and xss_clean($user_key) == config_item('lack_password'))
		{
			return true;
		}
		
		return false;
		
	} // end logged_in()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function restrict()
	{
		if ( ! self::logged_in())
		{
			redirect('backend/authentication/login');
		}
		
	} // end restrict()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} //end Auth


/* End of file auth.php */