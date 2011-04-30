<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Lack
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Lack extends MY_Controller {

	public static    $data = array();
	protected        $cfg  = array();
	protected static $entry_files;
	protected static $entries;
	protected static $entry_dir;
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Run setup
		$this->_setup();
		
	} //end __contruct()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function run()
	{
		$this->benchmark->mark('Lack_start');
		
		// Determine data file
		if ( ! $this->uri->segment(1)) $template = 'index';
		else                           $template = $this->uri->segment(1);
		
		// Load content if file exists
		if (file_exists('./data/'.$template.'.'.$this->cfg['data_extension']))
		{
			$this->benchmark->mark('Lack_Parse_Markdown_start');

			// Get content
			self::$data['content'] = markdown($this->parser->parse($this->cfg['data_path'].'/'.$template.'.'.$this->cfg['data_extension'], self::$data, true));
			
			$this->benchmark->mark('Lack_Parse_Markdown_end');


			$this->benchmark->mark('Lack_Parse_start');

			// And load view
			$this->load->view($this->cfg['template_path'].'/layout', self::$data);

			$this->benchmark->mark('Lack_Parse_end');

		}
		
		// List of entries
		elseif (is_dir('./data/'.$template))
		{
			// Set the directory name
			self::$entry_dir = $template;
			
			// Or is it a single entry
			if ($this->uri->segment(2) and file_exists('./data/'.self::$entry_dir.'/'.$this->uri->segment(2).'.'.$this->cfg['data_extension']))
			{
				// Get content
				$entry = self::parse_entry($this->uri->segment(2).'.'.$this->cfg['data_extension']);
				self::$data['content'] = $entry['content'];
				
				//markdown($this->parser->parse($this->cfg['data_path'].'/'.self::$entry_dir.'/'.$this->uri->segment(2).'.'.$this->cfg['data_extension'], self::$data, true));
				
				// And load view
				$this->load->view($this->cfg['template_path'].'/layout', self::$data);
			}
			else
			{
				// Get all the files in the folder
				self::$entry_files = directory_map('./data/'.$template, 1);
				
				// Sort it
				rsort(self::$entry_files);
				
				// And load view
				$this->load->view($this->cfg['template_path'].'/layout_list', self::$data);
			}
		}
		
		// Show 404 error
		else
		{
			show_404();
		}
		
		$this->benchmark->mark('Lack_end');
		
	} // end run()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	protected function _setup()
	{
		$this->benchmark->mark('Lack_setup_start');
		
		// Load resources
		$this->load->library('parser');
		$this->load->helper(array('file', 'directory', 'date', 'form', 'html', 'array', 'url', 'string', 'text', 'typography'));
		
		// Load configuration
		$this->config->load('lack');
		$this->cfg = $this->config->item('lack');
		
		$this->benchmark->mark('Lack_setup_end');
		
	} // _setup()
	
	
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
	public function entry_list($return = false)
	{
		$this->benchmark->mark('Entry_list_start');
		
		if (self::$entry_files)
		{
			$html = '<ul class="entries">';
			
			foreach (self::$entry_files as $e)
			{
				if (is_file($this->config->item('data', 'lack').'/'.self::$entry_dir.'/'.$e))
				{
					$entry = self::parse_entry($e);
					
					// Add entry to array
					self::$entries[] = (object) $entry;
					
					// Prepare HTML
					$html .= '<li><h2><a href="'.$entry['permalink'].'">'.$entry['title'].'</a></h2>';
					$html .= '<p>'.$entry['summary'].'</p>';
					$html .= '</li>';
				}
			}
			
			// Add to data list
			self::$data['entries'] = self::$entries;
			
			$html .= '</ul>';
			
			if ($return) return $html;
			else         echo   $html;
		}
		
		$this->benchmark->mark('Entry_list_end');
		
		return null;
		
	} // entry_list()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function parse_entry($filename = null)
	{
		$this->benchmark->mark('Lack_Parse_Entry_start');
		
		// Basename
		$basename = basename($filename, '.'.$this->config->item('data_extension', 'lack'));
		
		$entry = array(
			'filename'    => $filename,
			'raw_content' => $this->parser->parse($this->config->item('data_path', 'lack').'/'.self::$entry_dir.'/'.$filename, self::$data, true),
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
		
		// Format content
		if ($entry['meta']) $entry['content'] = markdown(trim(substr_replace($entry['raw_content'], '', strpos($entry['raw_content'], "{"), strpos($entry['raw_content'], "}") + 1)));
		else                $entry['content'] = markdown(trim($entry['raw_content']));
		
		// Prepare content summary
		$entry['summary'] = strip_tags(character_limiter($entry['content'], 200), '<strong><b><em><i><a>');

		$this->benchmark->mark('Lack_Parse_Entry_end');
		
		return $entry;
		
	} // end parse_entry()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function partial($view = null, $data = null)
	{
		$this->benchmark->mark('Lack_Partial_'.$view.'_start');
		
		if ( ! $data) $data = self::$data;
		
		// In 'core' subfolder
		if (file_exists($this->config->item('templates', 'lack').'/core/'.$view.'.php'))
		{
			$this->load->view($this->config->item('template_path', 'lack').'/core/'.$view, $data);
		}
		
		// In 'partial' subfolder
		elseif (file_exists($this->config->item('templates', 'lack').'/partials/'.$view.'.php'))
		{
			$this->load->view($this->config->item('template_path', 'lack').'/partials/'.$view, $data);
		}
		
		// In root of templates
		elseif (file_exists($this->config->item('templates', 'lack').'/'.$view.'.php'))
		{
			$this->load->view($this->config->item('template_path', 'lack').'/'.$view, $data);
		}
		
		$this->benchmark->mark('Lack_Partial_'.$view.'_end');
		
	} // partial()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} //end Lack


// Get the markdown parser
include(APPPATH.'/third_party/markdown.php');



/* End of file lack.php */