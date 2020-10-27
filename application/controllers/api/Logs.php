<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Logs extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Logs_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }    
    public function list_logs_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        if($this->session->userdata('nivel')==1 || $this->session->userdata('nivel')==2)
        {
        	$data = $this->Logs_model->get_list_Logs(1,$this->session->userdata('id'));
        }
        else
        {
        	$data = $this->Logs_model->get_list_Logs(2,$this->session->userdata('id'));
        }

        
        



        $this->Auditoria_model->agregar($this->session->userdata('id'),'tblauditorias','GET',null,$this->input->ip_address(),'Cargando Listado de Logs');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
   
	
}
?>