<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Dashboard extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Clientes_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    public function getclientes_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getclientessearch($objSalida->searchText);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function get_all_list_customers_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
	    $data = $this->Clientes_model->get_list_clientes();
	    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',null,$this->input->ip_address(),'Cargando Lista de Clientes');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function view_information_customers_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');		
	    $customer = $this->Clientes_model->get_data_cliente($CodCli);	    
	    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$CodCli,$this->input->ip_address(),'Buscando Cliente');
		if (empty($customer))
		{
			$this->response(false);
			return false;
		}
		$Electricos=$this->Clientes_model->get_CUPs_Electricos_Dashboard($CodCli);
		$Gas=$this->Clientes_model->get_CUPs_Gas_Dashboard($CodCli);
		$Contactos=$this->Clientes_model->get_data_cliente_contactos($CodCli);
		$Cuenta_Bancarias=$this->Clientes_model->get_data_cliente_cuentas($CodCli);
		$Documentos=$this->Clientes_model->get_data_cliente_documentos($CodCli);
		$Puntos_Suministros=false;
		$response = array('customer' => $customer,'Puntos_Suministros'=>$Puntos_Suministros,'Contactos'=>$Contactos,'Cuenta_Bancarias' => $Cuenta_Bancarias,'Documentos' => $Documentos,'CUPs_Electricos'=>$Electricos,'CUPs_Gas'=>$Gas);

		$this->response($response);		
	}
	public function GetContratosElectricosGas_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCups=$this->get('CodCups');	
		$CodCli=$this->get('CodCli');
		$TipCups=$this->get('TipCups');	
	   	$ResponseContratos = $this->Clientes_model->GetCUPsContratosElectricosGas($CodCups,$CodCli,$TipCups);
	   	if(empty($ResponseContratos))
	   	{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','GET',$CodCups,$this->input->ip_address(),'Buscando Contratos Cups');
	   		$this->response(false);
			return false;
	   	}
	   	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','GET',$CodCups,$this->input->ip_address(),'Mostrando Contratos del CUPs');
	   	$this->response($ResponseContratos);	  	
	}
	public function Search_CUPs_Customer_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodPumSum=$this->get('CodPumSum');		
	    $CUPs_Gas=$this->Clientes_model->get_CUPs_Gas($CodPumSum);
	    $CUPs_Electricos=$this->Clientes_model->get_CUPs_Electricos($CodPumSum);
		$response = array('CUPs_Gas' => $CUPs_Gas,'CUPs_Electricos'=>$CUPs_Electricos);		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$CodPumSum,$this->input->ip_address(),'Buscando CUPs Puntos Suministros');
		$this->response($response);		
	}

    

}
?>