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
        $this->Auditoria_model->agregar($this->session->userdata('id'),'V_CupsGrib','GET',null,$this->input->ip_address(),'Buscando CUPs Para Activación');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}
		if($data-> TipServ=='E' || $data-> TipServ=='Eléctrico')
		{
			$dataCUPS=$this->Activaciones_model->GetInformacionCUPsElectrico($data-> CodCupGas);
			if (empty($dataCUPS))
			{
				$this->response(array('status'=>400,'menssage'=>'No se encontraron contratos asignados a este CUPs.','statusText'=>'CUPs Sin Contrato'));
				return false;
			}
			$arrayName = array('status'=>200,'menssage'=>'Se encontraron contratos registrados.','statusText'=>'Contratos','ListContratos'=>$dataCUPS);
		}
		elseif ($data-> TipServ=='G' || $data-> TipServ=='Gas') 
		{
			
			$dataCUPS=$this->Activaciones_model->GetInformacionCUPsGas($data-> CodCupGas);
			if (empty($dataCUPS))
			{
				$this->response(array('status'=>400,'menssage'=>'No se encontraron contratos asignados a este CUPs.','statusText'=>'CUPs Sin Contrato'));
				return false;
			}
			$arrayName = array('status'=>200,'menssage'=>'Se encontraron contratos registrados.','statusText'=>'Contratos','ListContratos'=>$dataCUPS);
		}	
		else
		{
			$arrayName = array('status'=>305,'menssage'=>'Error en Tipo de Servicio del CUPs.','statusText'=>'CUPs');
		}	
		$this->response($arrayName);		
    }
     public function UpdateInformationContratos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$respose=$this->Activaciones_model->UpdateInformationContratos($objSalida->CodConCom,$objSalida->CodCups,$objSalida->CodProCom,$objSalida->CodProComCli,$objSalida->CodProComCup,$objSalida->ConCup,$objSalida->FecActCUPs,$objSalida->FecVenCUPs,$objSalida->TipCups);
		if($respose==false)
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$objSalida->CodProComCup,$this->input->ip_address(),'Error Actualizando Desde Activiciones');
			$this->response(false);
			return false;
		}		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$objSalida->CodProComCup,$this->input->ip_address(),'Actualizando Propuesta Comercial FecActCUPs,FecVenCUPs,ConCup Desde Activiciones');	
		$this->db->trans_complete();
		$this->response($respose);
    }
	
}
?>