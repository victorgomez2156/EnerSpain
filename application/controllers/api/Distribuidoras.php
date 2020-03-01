<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Distribuidoras extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Distribuidoras_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    public function list_distribuidoras_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
        $data = $this->Distribuidoras_model->get_list_distribuidoras();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','GET',0,$this->input->ip_address(),'Cargando Lista de Distribuidoras');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function comprobar_cif_distribuidora_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$resultado = $this->Distribuidoras_model->comprobar_cif_distribuidora($objSalida);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','GET',0,$this->input->ip_address(),'COMPROBANDO DISPONIBILIDAD DEL CIF DE LA DISTRIBUIDORA.');	
		$this->db->trans_complete();
		$this->response($resultado);
    }
     public function crear_distribuidora_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodDist))
		{		
			$this->Distribuidoras_model->actualizar($objSalida->CodDist,$objSalida->EmaDis,$objSalida->NomComDis,$objSalida->NumCifDis,$objSalida->ObsDis,$objSalida->PagWebDis,$objSalida->PerConDis,$objSalida->RazSocDis,$objSalida->TelFijDis,$objSalida->TipSerDis);		
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','UPDATE',$objSalida->CodDist,$this->input->ip_address(),'Actualizando Datos De la Distribuidoras');
		}
		else
		{
			$id = $this->Distribuidoras_model->agregar($objSalida->EmaDis,$objSalida->NomComDis,$objSalida->NumCifDis,$objSalida->ObsDis,$objSalida->PagWebDis,$objSalida->PerConDis,$objSalida->RazSocDis,$objSalida->TelFijDis,$objSalida->TipSerDis);
			$objSalida->CodDist=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','INSERT',$objSalida->CodDist,$this->input->ip_address(),'Creando Registro De la Distribuidoras');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }  
    public function buscar_xID_Distribuidora_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodDist=$this->get('CodDist');		
        $data = $this->Distribuidoras_model->get_distribuidora_data($CodDist);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','GET',$CodDist,$this->input->ip_address(),'Consultando datos de la Distribuidora');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}
		$this->response($data);		
    } 
     public function borrar_row_distribuidora_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodDist=$this->get('CodDist');
        $data = $this->Distribuidoras_model->borrar_distribuidora_data($CodDist);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','DELETE',$CodDist,$this->input->ip_address(),'Borrando Distribuidora.');		
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
		$this->Distribuidoras_model->update_status_distribuidora($objSalida->opcion,$objSalida->CodDist);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','UPDATE',$objSalida->opcion,$this->input->ip_address(),'Actualizando Estatus de La Distribuidora');
		
		
		if($objSalida->opcion==2)
		{
			$CodBloq=$this->Distribuidoras_model->agregar_motivo_bloqueo($objSalida->CodDist,$objSalida->FechBlo,$objSalida->MotBloq,$objSalida->ObsBloDis);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoDistribuidora','INSERT',$CodBloq,$this->input->ip_address(),'Agregando Motivo Bloqueo de Distribuidora');
		}		
		$this->db->trans_complete();
		$this->response(true);
    }
	
}
?>