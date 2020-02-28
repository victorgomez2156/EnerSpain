<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Colaboradores extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Colaboradores_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
	////PARA LAS COLABORADORES START///////
	public function get_only_colaboradores_get(){
		$data = $this->Colaboradores_model->get_list_colaboradores();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'Obteniendo Lista de Solo Colaboradores');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
    public function get_all_functions_colaboradores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$Provincias = $this->Colaboradores_model->get_list_provincias();
        $Tipo_Vias = $this->Colaboradores_model->get_list_tipos_vias();
        $Localidades = $this->Colaboradores_model->get_list_localidad();        
        $data=array('Provincias' =>$Provincias ,'Tipo_Vias' =>$Tipo_Vias ,'Localidades' =>$Localidades  );
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'Cargando Lista Peticiones');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function list_colaboradores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Colaboradores_model->get_list_colaboradores();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'Cargando Lista de Colaboradores');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function comprobar_cif_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$NumIdeFis=$this->get('NumIdeFis');		
        $data = $this->Colaboradores_model->comprobar_dni_nie($NumIdeFis);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'Comprobando DNI/NIE.');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function borrar_row_colaboradores_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodCol=$this->get('CodCol');
        $data = $this->Colaboradores_model->borrar_colaborador_data($CodCol);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','DELETE',$CodCol,$this->input->ip_address(),'Borrando Colaborador Fallido.');
			$this->response(false);
			return false;
		}		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','DELETE',$CodCol,$this->input->ip_address(),'Borrando Colaborador.');
		$this->response($data);
				
    }
    public function get_colaborador_data_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCol=$this->get('CodCol');		
        $data = $this->Colaboradores_model->get_colaborador_data($CodCol);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',$CodCol,$this->input->ip_address(),'Consultando datos del Colaborador');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
   public function crear_colaborador_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodCol))
		{		
			$this->Colaboradores_model->actualizar_colaborador($objSalida->CodCol,$objSalida->BloDir,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->EmaCol,$objSalida->EscDir,$objSalida->NomCol,$objSalida->NomViaDir,$objSalida->NumIdeFis,$objSalida->NumViaDir,$objSalida->ObsCol,$objSalida->PlaDir,$objSalida->PorCol,$objSalida->PueDir,$objSalida->TelCelCol,$objSalida->TelFijCol,$objSalida->TipCol);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','UPDATE',$objSalida->CodCol,$this->input->ip_address(),'Actualizando Colaborador');
		}
		else
		{
			$id = $this->Colaboradores_model->agregar_colaborador($objSalida->BloDir,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->EmaCol,$objSalida->EscDir,$objSalida->NomCol,$objSalida->NomViaDir,$objSalida->NumIdeFis,$objSalida->NumViaDir,$objSalida->ObsCol,$objSalida->PlaDir,$objSalida->PorCol,$objSalida->PueDir,$objSalida->TelCelCol,$objSalida->TelFijCol,$objSalida->TipCol);		
			$objSalida->CodCol=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','INSERT',$objSalida->CodCol,$this->input->ip_address(),'Creando Colaborador');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
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
		$resultado = $this->Colaboradores_model->update_status_Colaborador($objSalida->CodCol,$objSalida->opcion);
		


		if($objSalida->opcion==2)
		{
			$CodBloCol=$this->Colaboradores_model->agregar_bloqueo_Colaborador($objSalida->CodCol,date('Y-m-d'),$objSalida->MotBloqColBlo,$objSalida->ObsBloColBlo);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoColaborador','INSERT',$CodBloCol,$this->input->ip_address(),'Bloqueo de Colaborador.');
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','UPDATE',$objSalida->CodCol,$this->input->ip_address(),'Actualizando Estatus del Colaborador');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     
   
	public function clientes_colaboradores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCol=$this->get('CodCol');		
        $data = $this->Colaboradores_model->get_clientes_x_colaborador($CodCol);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',$CodCol,$this->input->ip_address(),'Consultando datos de Clientes por Colaborador');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     ////PARA LAS COLABORADORES END///////
   
	
}
?>