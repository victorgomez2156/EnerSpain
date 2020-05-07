<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Tipos extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Tipos_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301); 
		}
    }
    /////////////// PARA TIPO CLIENTE START/////
    public function list_tipo_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Tipos_model->get_list_tipo_clientes();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',0,$this->input->ip_address(),'Cargando Lista Tipo Clientes');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_tipo_cliente_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipCli))
		{		
			$this->Tipos_model->actualizar_tipo_cliente($objSalida->CodTipCli,$objSalida->DesTipCli,$objSalida->ObsTipCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','UPDATE',$objSalida->CodTipCli,$this->input->ip_address(),'Actualizando Tipo Cliente');
		}
		else
		{
			$id = $this->Tipos_model->agregar_tipo_cliente($objSalida->DesTipCli,$objSalida->ObsTipCli);		
			$objSalida->CodTipCli=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','INSERT',$objSalida->CodTipCli,$this->input->ip_address(),'Creando Tipo Cliente');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_Tipo_Cliente_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipCli=$this->get('CodTipCli');		
        $data = $this->Tipos_model->get_tipo_cliente_data($CodTipCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',$CodTipCli,$this->input->ip_address(),'Consultando datos Tipo Clientes');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function borrar_row_tipo_cliente_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipCli=$this->get('CodTipCli');
        $data = $this->Tipos_model->borrar_tipo_cliente_data($CodTipCli);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','DELETE',$CodTipCli,$this->input->ip_address(),'Borrando Tipo Cliente Fallido.');
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','DELETE',$CodTipCli,$this->input->ip_address(),'Borrando Tipo Cliente.');		
		$this->response($data);
				
    }  
    ///////////////////////////////////////////////////// PARA TIPO CLIENTE END///////////////////////////////////////////////



    //////////////////////////////////////////////////// PARA TIPO SECTOR START///////////////////////////////////////////////
  	public function list_tipo_sector_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Tipos_model->get_list_tipo_sector();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',0,$this->input->ip_address(),'Cargando Lista Tipo Sector');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_tipo_sector_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodSecCli))
		{		
			$this->Tipos_model->actualizar_tipo_sector($objSalida->CodSecCli,$objSalida->DesSecCli,$objSalida->ObsSecCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','UPDATE',$objSalida->CodSecCli,$this->input->ip_address(),'Actualizando Tipo de Sector');
		}
		else
		{
			$id = $this->Tipos_model->agregar_tipo_sector($objSalida->DesSecCli,$objSalida->ObsSecCli);		
			$objSalida->CodSecCli=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','INSERT',$objSalida->CodSecCli,$this->input->ip_address(),'Creando Tipo de Sector');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_Tipo_Sector_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodSecCli=$this->get('CodSecCli');		
        $data = $this->Tipos_model->get_tipo_sector_data($CodSecCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',$CodSecCli,$this->input->ip_address(),'Consultando datos Tipo Sector');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function borrar_row_tipo_sector_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodSecCli=$this->get('CodSecCli');
        $data = $this->Tipos_model->borrar_tipo_sector_data($CodSecCli);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','DELETE',$CodSecCli,$this->input->ip_address(),'Borrando Tipo Sector Fallido.');
			$this->response(false);
			return false;
		}	
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','DELETE',$CodSecCli,$this->input->ip_address(),'Borrando Tipo Sector.');		
		$this->response($data);
			
    }
    /// PARA TIPO SECTOR END//////


    /// PARA TIPO CONTACTO START/////
    public function list_tipo_contacto_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Tipos_model->get_list_tipo_contacto();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','GET',0,$this->input->ip_address(),'Cargando Lista Tipo Contacto');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
   public function crear_tipo_contacto_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipCon))
		{		
			$this->Tipos_model->actualizar_tipo_contacto($objSalida->CodTipCon,$objSalida->DesTipCon,$objSalida->ObsTipCon);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','UPDATE',$objSalida->CodTipCon,$this->input->ip_address(),'Actualizando Tipo de Contacto');
		}
		else
		{
			$id = $this->Tipos_model->agregar_tipo_contacto($objSalida->DesTipCon,$objSalida->ObsTipCon);		
			$objSalida->CodTipCon=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','INSERT',$objSalida->CodTipCon,$this->input->ip_address(),'Creando Tipo de Contacto');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_Tipo_Contacto_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipCon=$this->get('CodTipCon');		
        $data = $this->Tipos_model->get_tipo_contacto_data($CodTipCon);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','GET',$CodTipCon,$this->input->ip_address(),'Consultando datos Tipo Contacto');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function borrar_row_tipo_contacto_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipCon=$this->get('CodTipCon');
        $data = $this->Tipos_model->borrar_tipo_contacto_data($CodTipCon);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','DELETE',$CodTipCon,$this->input->ip_address(),'Borrando Tipo Contacto Fallido.');
			$this->response(false);
			return false;
		}	
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','DELETE',$CodTipCon,$this->input->ip_address(),'Borrando Tipo Contacto.');
		$this->response($data);			
    }  
    //////////////////////////////////////////////////////////////// PARA TIPO CONTACTO END/////////////////////////////////////////////////////




   
   	//////////////////////////////////////////////////////////////////// PARA TIPO DOCUMENTO START/////////////////////////////////////////////
   	 public function list_tipo_documentos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Tipos_model->get_list_tipo_documentos();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','GET',0,$this->input->ip_address(),'Cargando Lista Tipo Documentos');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_tipo_documento_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipDoc))
		{		
			$this->Tipos_model->actualizar_tipo_documentos($objSalida->CodTipDoc,$objSalida->DesTipDoc,$objSalida->ObsTipDoc,$objSalida->EstReq);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','UPDATE',$objSalida->CodTipDoc,$this->input->ip_address(),'Actualizando Tipo de Documento.');
		}
		else
		{
			$id = $this->Tipos_model->agregar_tipo_documentos($objSalida->DesTipDoc,$objSalida->ObsTipDoc,$objSalida->EstReq);		
			$objSalida->CodTipDoc=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','INSERT',$objSalida->CodTipDoc,$this->input->ip_address(),'Creando Tipo de Documento.');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_Tipo_Documento_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipDoc=$this->get('CodTipDoc');		
        $data = $this->Tipos_model->get_tipo_documentos_data($CodTipDoc);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','GET',$CodTipDoc,$this->input->ip_address(),'Consultando datos Tipo Documento.');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function borrar_row_tipo_documento_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipDoc=$this->get('CodTipDoc');
        $data = $this->Tipos_model->borrar_tipo_documento_data($CodTipDoc);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','DELETE',$CodTipDoc,$this->input->ip_address(),'Borrando Tipo Documento Fallido.');
			$this->response(false);
			return false;
		}	
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','DELETE',$CodTipDoc,$this->input->ip_address(),'Borrando Tipo Documento.');
		$this->response($data);			
    }

  
    //////////////////////// PARA TIPO DOCUMENTO END/////////////////////////////////////////////////////////////
  


  /////////////// PARA TIPO GESTIONES START////////////////////////
    public function list_tipo_gestiones_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Tipos_model->get_list_tipo_gestiones();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoGestion','GET',NULL,$this->input->ip_address(),'Cargando Lista Tipo de Gestiones');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_tipo_gestion_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipGes))
		{		
			$this->Tipos_model->actualizar_tipo_gestion($objSalida->CodTipGes,$objSalida->DesTipGes,$objSalida->ActTipGes);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoGestion','UPDATE',$objSalida->CodTipGes,$this->input->ip_address(),'Actualizando Tipo de Gestión');
		}
		else
		{
			$id = $this->Tipos_model->agregar_tipo_gestion($objSalida->DesTipGes,$objSalida->ActTipGes);		
			$objSalida->CodTipGes=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoGestion','INSERT',$objSalida->CodTipGes,$this->input->ip_address(),'Creando Tipo de Getión');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_Tipo_Gestion_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipGes=$this->get('CodTipGes');		
        $data = $this->Tipos_model->get_tipo_gestion_data($CodTipGes);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoGestion','GET',$CodTipGes,$this->input->ip_address(),'Consultando datos Tipo de Gestión');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function borrar_row_tipo_gestion_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipGes=$this->get('CodTipGes');
        $data = $this->Tipos_model->borrar_tipo_gestion_data($CodTipGes);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoGestion','DELETE',$CodTipGes,$this->input->ip_address(),'Borrando Tipo Gestión Fallido.');
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoGestion','DELETE',$CodTipGes,$this->input->ip_address(),'Borrando Tipo Gestión.');		
		$this->response($data);
				
    }
    ///////////////////////////////////////////////////// PARA TIPO GESTIONES END///////////////////////////////////////////////
   
	
}
?>