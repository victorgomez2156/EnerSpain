<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Menu extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Menu_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    public function usuariomenu_get() 
    {
		$usuario = $this->session->userdata('id');
        $data = $this->Menu_model->get_Menu($usuario);
		if (!empty($data)){
			return $this->response($data);
			return true;
		}
		$this->response(false);
    }

   
	
}
?>