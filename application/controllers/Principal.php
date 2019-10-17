<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();      
        $this->load->helper('url'); 	
		$this->load->database('default');
        $this->load->library('form_validation'); 
        $this->load->library('user_agent');
		$this->load->helper('cookie');
		$this->load->model('Usuarios_model');
	}
	public function index() 
	{ 
		if ($this->agent->is_browser())
		{
	        $agent = $this->agent->browser(); 
	        $version= $this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
			$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
	        $agent = $this->agent->mobile();
		}
		else
		{
	        $agent = 'Unidentified User Agent';
		}
		$ip=$this->input->ip_address();
		$os=$this->agent->platform();
		$this->render();
	}
	
}
?>