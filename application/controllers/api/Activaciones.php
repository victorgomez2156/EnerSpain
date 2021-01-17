<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Activaciones extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Activaciones_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }    
    
    public function getCUPsActivaciones_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CUPs=$this->get('CUPsName');		
        $data = $this->Activaciones_model->GetDatosCUPsForActivaciones($CUPs);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'V_CupsGrib','GET',null,$this->input->ip_address(),'Buscando CUPs Para Agregar Activación');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
	
}
?>