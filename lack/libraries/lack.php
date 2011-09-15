<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Lack
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Lack {
	
	protected static $ci;
	public static    $data = array();
	protected static $entry_files;
	protected static $entries;
	protected static $entry_dir;
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		self::$ci = get_instance();
		
		// Run setup
		self::_setup();
		
	} //end __contruct()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function run()
	{
		// Determine data file
		if ( ! self::$ci->uri->segment(1)) $template = 'index';
		else                               $template = self::$ci->uri->segment(1);
		
		// Load core partials
		self::_load_core_partials();
		
		// Load content if file exists
		if (file_exists('./data/'.$template.'.'.config_item('data_extension')))
		{
			// Get content
			self::$data['content'] = markdown(self::$ci->parser->parse(config_item('data_path').'/'.$template.'.'.config_item('data_extension'), self::$data, true));

			// And load view
			self::$ci->parser->parse(config_item('template_path').'/layout', self::$data);
		}
		
		// List of entries
		elseif (is_dir('./data/'.$template))
		{
			// Set the directory name
			self::$entry_dir = $template;
			
			// Or is it a single entry
			if (self::$ci->uri->segment(2) and file_exists('./data/'.self::$entry_dir.'/'.self::$ci->uri->segment(2).'.'.config_item('data_extension')))
			{
				// Get content
				$entry = self::parse_entry(self::$ci->uri->segment(2).'.'.config_item('data_extension'));
				self::$data['content'] = $entry['content'];
				
				// And load view
				if (file_exists(config_item('templates').'/layout_'.$template.'.php'))
				{
					self::$ci->parser->parse(config_item('template_path').'/layout_'.$template, self::$data);
				}
				else
				{
					self::$ci->parser->parse(config_item('template_path').'/layout', self::$data);
				}
			}
			else
			{
				// Get all the files in the folder
				self::$entry_files = directory_map('./data/'.$template, 1);
				
				// Sort it
				rsort(self::$entry_files);
				self::entry_list('array');
				
				// And load view
				if (file_exists(config_item('templates').'/layout_'.$template.'_list.php'))
				{
					self::$ci->parser->parse(config_item('template_path').'/layout_'.$template.'_list', self::$data);
				}
				else
				{
					self::$ci->parser->parse(config_item('template_path').'/layout_list', self::$data);
				}
			}
		}
		
		// Show 404 error
		else
		{
			show_404();
		}
		
	} // end run()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function content($return = false)
	{
		if (isset(self::$data['content'])) {
			if ($return) return self::$data['content'];
			else         echo   self::$data['content'];
		}
		
		return null;
		
	} // end content()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function entry_list($format = 'html', $return = false)
	{
		if (self::$entry_files)
		{
			$html = '<ul class="entries">';
			
			foreach (self::$entry_files as $e)
			{
				if (is_file(config_item('data').'/'.self::$entry_dir.'/'.$e))
				{
					$entry = self::parse_entry($e);
					
					// Add entry to array
					self::$entries[] = $entry;
					
					// Prepare HTML
					$html .= '<li><h2><a href="'.$entry['permalink'].'">'.$entry['title'].'</a></h2>';
					$html .= '<h3>'.$entry['when'].'</h3>';
					$html .= '<p>'.$entry['summary'].'</p>';
					$html .= '</li>';
				}
			}
			
			// Add to data list
			self::$data['entries'] = self::$entries;
			
			$html .= '</ul>';
			
			if ($format == 'html')
			{
				if ($return) return $html;
				else         echo   $html;
			}
			else
			{
				return self::$entries;
			}
		}
		
		return null;
		
	} // entry_list()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function parse_entry($filename = null)
	{
		// Basename
		$basename = basename($filename, '.'.config_item('data_extension'));
		
		$entry = array(
			'filename'    => $filename,
			'raw_content' => self::$ci->parser->parse(config_item('data_path').'/'.self::$entry_dir.'/'.$filename, self::$data, true),
			'permalink'   => site_url(self::$entry_dir.'/'.$basename)
		);
		
		// Meta
		$entry['meta'] = trim(substr($entry['raw_content'], strpos($entry['raw_content'], "{"), strpos($entry['raw_content'], "}") + 1));
		$entry['meta'] = json_decode($entry['meta']);
		
		// Prepare meta
		if ($entry['meta'])
		{
			foreach ($entry['meta'] as $key=>$meta)
			{
				$entry[$key] = $meta;
			}
		}
		
		// Check for title
		if ( ! isset($entry['title'])) $entry['title'] = $basename;
		
		// Time
		$entry['time'] = filemtime(config_item('data').'/'.self::$entry_dir.'/'.$filename);
		$entry['when'] = date('Y/m/d H:i', $entry['time']);
		
		// Add time to meta
		if ( ! isset($entry['meta']->time)) $entry['meta']->time = $entry['time'];
		if ( ! isset($entry['meta']->when)) $entry['meta']->when = $entry['when'];
		
		// Format content
		if ($entry['meta'])
		{
			$entry['content'] = markdown(trim(substr_replace($entry['raw_content'], '', strpos($entry['raw_content'], "{"), strpos($entry['raw_content'], "}") + 1)));
			$entry['content'] = self::$ci->parser->parse_string($entry['content'], $entry['meta'], true);
		}
		else
		{
			$entry['content'] = markdown(trim($entry['raw_content']));
		}
		
		// Prepare content summary
		$entry['summary'] = strip_tags(character_limiter($entry['content'], 200), '<strong><b><em><i><a>');
		
		// And remove meta array
		unset($entry['meta']);

		return $entry;
		
	} // end parse_entry()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function partial($view = null, $data = null, $return = false)
	{
		if ( ! $data) $data = self::$data;
		$html = '';
		
		// In 'core' subfolder
		if (file_exists(config_item('templates').'/core/'.$view.'.php'))
		{
			$html = self::$ci->parser->parse(config_item('template_path').'/core/'.$view, $data, true);
		}
		
		// In 'partial' subfolder
		elseif (file_exists(config_item('templates').'/partials/'.$view.'.php'))
		{
			$html = self::$ci->parser->parse(config_item('template_path').'/partials/'.$view, $data, true);
		}
		
		// In root of templates
		elseif (file_exists(config_item('templates').'/'.$view.'.php'))
		{
			$html = self::$ci->parser->parse(config_item('template_path').'/'.$view, $data, true);
		}
		
		if ($return) return $html;
		else         echo   $html;
		
	} // partial()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	private static function _load_core_partials()
	{
		self::$data['navigation'] = self::partial('navigation', null, TRUE);
		self::$data['aside']      = self::partial('aside',      null, true);
		self::$data['header']     = self::partial('header',     null, true);
		self::$data['footer']     = self::partial('footer',     null, true);
		
	} // _load_core_partials()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	protected static function _setup()
	{
		// Load resources
		self::$ci->load->library('parser');
		self::$ci->load->helper(array('file', 'directory', 'date', 'form', 'html', 'array', 'url', 'string', 'text', 'typography'));
		include(APPPATH.'/third_party/markdown.php');
		
		// Load configuration
		self::$ci->config->load('lack');
		
		// Prepare some variables for the parser
		self::$data['site_url'] = trim_slashes(site_url());
		
	} // _setup()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} //end Lack


/* End of file lack.php */