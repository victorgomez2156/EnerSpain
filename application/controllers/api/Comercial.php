<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Comercial extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Comercial_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
     /// PARA EL COMERCIAL START/////
    public function list_comercial_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Comercial_model->get_list_comerciales();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',0,$this->input->ip_address(),'Cargando Lista Comercial');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function comprobar_dni_nie_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$NumDNI_NIECli=$this->get('NIFComCon');	
        $data = $this->Comercial_model->get_numero_dni_nie($NumDNI_NIECli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',0,$this->input->ip_address(),'Comprobando Número de DNI/NIE');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function buscar_xID_Comercial_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCom=$this->get('CodCom');		
        $data = $this->Comercial_model->get_comercial_data($CodCom);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',$CodCom,$this->input->ip_address(),'Consultando datos Comercial');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function crear_comercial_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$convertir_fec_ini=explode("/", $objSalida->FecIniCom);
		$new_fec_ini=$convertir_fec_ini[2]."-".$convertir_fec_ini[1]."-".$convertir_fec_ini[0];		
		if (isset($objSalida->CodCom))
		{		
			$this->Comercial_model->actualizar_comercial($objSalida->CodCom,$objSalida->NomCom,$objSalida->NIFCom,$objSalida->TelCelCom,$objSalida->TelFijCom,$objSalida->EmaCom,$objSalida->CarCom,$objSalida->PorComCom,$objSalida->ObsCom,$new_fec_ini);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','UPDATE',$objSalida->CodCom,$this->input->ip_address(),'Actualizando La Comercial');
		}
		else
		{
			$id = $this->Comercial_model->agregar_comercial($objSalida->NomCom,$objSalida->NIFCom,$objSalida->TelCelCom,$objSalida->TelFijCom,$objSalida->EmaCom,$objSalida->CarCom,$objSalida->PorComCom,$objSalida->ObsCom,$new_fec_ini);		
			$objSalida->CodCom=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','INSERT',$objSalida->CodCom,$this->input->ip_address(),'Creando Comercial');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function borrar_row_comercial_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodCom=$this->get('CodCom');
        $data = $this->Comercial_model->borrar_comercial_data($CodCom);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','DELETE',$CodCom,$this->input->ip_address(),'Borrando Comercial Fallido.');
			$this->response(false);
			return false;
		}		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','DELETE',$CodCom,$this->input->ip_address(),'Borrando Comercial.');
		$this->response($data);
				
    }
    public function update_status_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$resultado = $this->Comercial_model->update_status_comercial($objSalida->CodCom,$objSalida->EstCom);
		if($objSalida->EstCom==2)
		{
			$CodBloCom=$this->Comercial_model->agregar_bloqueo_Comercial($objSalida->CodCom,$objSalida->FechBloCom,$objSalida->MotBloqCom,$objSalida->ObsBloCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoComercial','INSERT',$CodBloCom,$this->input->ip_address(),'Bloqueando Comercial');
			$objSalida->CodBloCom=$CodBloCom;
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','UPDATE',$objSalida->CodCom,$this->input->ip_address(),'Actualizando Estatus del Comercial');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function geTComercialFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Comercial_model->geTComercialFilter($objSalida->filtrar_search);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Comerciales Filtrados');
		$this->db->trans_complete();
		$this->response($consulta);
	}

    /// PARA EL COMERCIAL END//////
   
    
	
}
?>