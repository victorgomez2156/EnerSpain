<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Configuraciones_Generales extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default'); 
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Configuraciones_generales_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    ////PARA LAS PROVINCIAS START///////
    public function list_provincias_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_provincias();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',0,$this->input->ip_address(),'Cargando Lista de Provincias');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_provincias_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodPro))
		{		
			$this->Configuraciones_generales_model->actualizar($objSalida->CodPro,$objSalida->DesPro);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','UPDATE',$objSalida->CodPro,$this->input->ip_address(),'Actualizando La Provincia');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar($objSalida->DesPro);		
			$objSalida->CodPro=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','INSERT',$objSalida->CodPro,$this->input->ip_address(),'Creando Provincias');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodPro=$this->get('CodPro');		
        $data = $this->Configuraciones_generales_model->get_provincia_data($CodPro);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',$CodPro,$this->input->ip_address(),'Consultando datos de la Provincia');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function borrar_row_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodPro=$this->get('CodPro');
        $data = $this->Configuraciones_generales_model->borrar_provincia_data($CodPro);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','DELETE',$hcliente,$this->input->ip_address(),'Borrando Cliente.');		
    }

     ////PARA LAS PROVINCIAS END///////

    ////PARA LAS LOCALIDADES START///////
    public function buscar_xID_Localidad_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodLoc=$this->get('CodLoc');		
        $data = $this->Configuraciones_generales_model->get_localidad_data($CodLoc);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','GET',$CodLoc,$this->input->ip_address(),'Consultando datos de la Localidad');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
     public function list_localidad_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_localidad();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','GET',0,$this->input->ip_address(),'Cargando Lista de Localidades');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_providencias_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_providencias();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',0,$this->input->ip_address(),'Cargando Lista de Providencias');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function get_localidades_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_localidades();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','GET',0,$this->input->ip_address(),'Cargando Lista de Localidades');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_localidad_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodLoc))
		{		
			$this->Configuraciones_generales_model->actualizar_localidad($objSalida->CodLoc,$objSalida->CodPro,$objSalida->DesLoc,$objSalida->CPLoc);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','UPDATE',$objSalida->CodLoc,$this->input->ip_address(),'Actualizando La Localidad');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_localidad($objSalida->CodPro,$objSalida->DesLoc,$objSalida->CPLoc);		
			$objSalida->CodLoc=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','INSERT',$objSalida->CodLoc,$this->input->ip_address(),'Creando Localidad');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function borrar_row_localidad_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodLoc=$this->get('CodLoc');
        $data = $this->Configuraciones_generales_model->borrar_localidad_data($CodLoc);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','DELETE',$CodLoc,$this->input->ip_address(),'Borrando Localidad.');		
    }
     public function importar_excel_localidades_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$data = array();

		$directorio="../Imports/";
		$tipo_archivo="xls";
		$fecha= date('Y-m-d_H:i:s');
		$nombre_archivo= $fecha.'.importe.'.$tipo_archivo;
		$subir_archivo=$directorio.$nombre_archivo;
		if(move_uploaded_file($_FILES['file']['tmp_name'][0],$subir_archivo))
		{
			$file='si';
		}
		else
		{
			$file='no';
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','INSERT',0,$this->input->ip_address(),'Importando Archivo Excel');	
		$this->db->trans_complete();
		$this->response($file);
		
    }
    ////PARA LAS LOCALIDADES END///////


    /// PARA EL COMERCIAL START/////
    public function list_comercial_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_comerciales();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',0,$this->input->ip_address(),'Cargando Lista Comercial');
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
        $data = $this->Configuraciones_generales_model->get_comercial_data($CodCom);
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
		if (isset($objSalida->CodCom))
		{		
			$this->Configuraciones_generales_model->actualizar_comercial($objSalida->CodCom,$objSalida->NomCom,$objSalida->NIFCom,$objSalida->TelCelCom,$objSalida->TelFijCom,$objSalida->EmaCom,$objSalida->CarCom,$objSalida->PorComCom,$objSalida->ObsCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','UPDATE',$objSalida->CodCom,$this->input->ip_address(),'Actualizando La Comercial');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_comercial($objSalida->NomCom,$objSalida->NIFCom,$objSalida->TelCelCom,$objSalida->TelFijCom,$objSalida->EmaCom,$objSalida->CarCom,$objSalida->PorComCom,$objSalida->ObsCom);		
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
        $data = $this->Configuraciones_generales_model->borrar_comercial_data($CodCom);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','DELETE',$CodCom,$this->input->ip_address(),'Borrando Comercial.');		
    }

    /// PARA EL COMERCIAL END//////

    /// PARA TIPO DE CLIENTES START/////
     public function list_tipo_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_tipo_clientes();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',0,$this->input->ip_address(),'Cargando Lista Tipo Clientes');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function buscar_xID_Tipo_Cliente_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipCli=$this->get('CodTipCli');		
        $data = $this->Configuraciones_generales_model->get_tipo_cliente_data($CodTipCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',$CodTipCli,$this->input->ip_address(),'Consultando datos Tipo Clientes');
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
			$this->Configuraciones_generales_model->actualizar_tipo_cliente($objSalida->CodTipCli,$objSalida->DesTipCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','UPDATE',$objSalida->CodTipCli,$this->input->ip_address(),'Actualizando Tipo Cliente');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_tipo_cliente($objSalida->DesTipCli);		
			$objSalida->CodTipCli=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','INSERT',$objSalida->CodTipCli,$this->input->ip_address(),'Creando Tipo Cliente');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function borrar_row_tipo_cliente_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipCli=$this->get('CodTipCli');
        $data = $this->Configuraciones_generales_model->borrar_tipo_cliente_data($CodTipCli);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','DELETE',$CodTipCli,$this->input->ip_address(),'Borrando Tipo Cliente.');		
    }


    ///PARA TIPO DE CLIENTES END////////


    ///PARA CONFIGURACIONES SISTEMAS START///

    public function cargar_configuraciones_sistemas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
        $data = $this->Configuraciones_generales_model->get_configuracion_sistema();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ConfiguracionesSistema','GET',0,$this->input->ip_address(),'Cargando Configuraciones del Sistema');
		if (empty($data)){
			$this->response(false);
			return false;
		}
		//$contrasena_smtp=md5($data->smtp_pass);
		//$data->smtp_pass=$contrasena_smtp;
		$this->response($data);		
    }
    public function guardar_configuraciones_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$this->Configuraciones_generales_model->actualizar_configuracion_sistema($objSalida->id,$objSalida->nombre_sistema,$objSalida->logo,$objSalida->telefono,$objSalida->direccion,$objSalida->version_sistema,$objSalida->correo_principal,$objSalida->correo_cc,$objSalida->url,$objSalida->protocol,$objSalida->smtp_host,$objSalida->smtp_user,$objSalida->smtp_pass,$objSalida->smtp_port);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ConfiguracionesSistema','UPDATE',$objSalida->id,$this->input->ip_address(),'Actualizando Configuración del Sistema');			
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    /// PARA CONFIGURACIONES SITEMAS END///


    /// PARA LOS BANCOS START //////
     public function list_bancos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_bancos();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','GET',0,$this->input->ip_address(),'Cargando Lista Bancos');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function borrar_row_bancos_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodBan=$this->get('CodBan');
        $data = $this->Configuraciones_generales_model->borrar_bancos($CodBan);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','DELETE',$CodBan,$this->input->ip_address(),'Borrando Bancos.');		
    }
    public function buscar_xID_Bancos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodBan=$this->get('CodBan');		
        $data = $this->Configuraciones_generales_model->get_banco_data($CodBan);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','GET',$CodBan,$this->input->ip_address(),'Consultando datos del banco');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function crear_banco_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodBan))
		{		
			$this->Configuraciones_generales_model->actualizar_banco($objSalida->CodBan,$objSalida->CodEur,$objSalida->DesBan);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','UPDATE',$objSalida->CodBan,$this->input->ip_address(),'Actualizando Banco');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_banco($objSalida->CodEur,$objSalida->DesTipCli);		
			$objSalida->CodBan=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','INSERT',$objSalida->CodBan,$this->input->ip_address(),'Creando Banco');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    /// PARA LOS BANCOS END/////

     /// PARA LOS TIPOS DE VIAS START //////
     public function list_tipos_vias_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_tipos_vias();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoVia','GET',0,$this->input->ip_address(),'Cargando Lista de Tipos de Vias');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function borrar_row_tipos_vias_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$hvia=$this->get('hvia');
        $data = $this->Configuraciones_generales_model->borrar_tipos_vias($hvia);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoVia','DELETE',$hvia,$this->input->ip_address(),'Borrando Tipo de Vias.');		
    }
      public function buscar_xID_tipo_via_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipVia=$this->get('CodTipVia');		
        $data = $this->Configuraciones_generales_model->get_tipo_via_data($CodTipVia);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoVia','GET',$CodTipVia,$this->input->ip_address(),'Consultando Datos Del Tipo De Via');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function crear_tipos_vias_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipVia))
		{		
			$this->Configuraciones_generales_model->actualizar_tipo_vias($objSalida->CodTipVia,$objSalida->DesTipVia,$objSalida->IniTipVia);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','UPDATE',$objSalida->CodTipVia,$this->input->ip_address(),'Actualizando Tipos de Vias');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_tipo_vias($objSalida->DesTipVia,$objSalida->IniTipVia);		
			$objSalida->CodTipVia=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','INSERT',$objSalida->CodTipVia,$this->input->ip_address(),'Creando Tipos de Vias');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
   	/// PARA LOS TIPOS DE VIAS END //////

    ////PARA LAS TARIFAS ELECTRICAS START///////
    public function get_list_tarifa_electricas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->list_tarifa_electricas();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','GET',0,$this->input->ip_address(),'Cargando Lista de Tarifas Electricas');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function borrar_tarifa_electrica_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTarEle=$this->get('CodTarEle');
        $data = $this->Configuraciones_generales_model->borrar_tarifa_electrica($CodTarEle);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','DELETE',$CodTarEle,$this->input->ip_address(),'Borrando Tarifa Electrica.');		
    }
    public function crear_tarifa_electrica_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTarEle))
		{		
			$this->Configuraciones_generales_model->actualizar_tarifa_electrica($objSalida->CodTarEle,$objSalida->TipTen,$objSalida->NomTarEle,$objSalida->CanPerTar,$objSalida->MinPotCon,$objSalida->MaxPotCon);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','UPDATE',$objSalida->CodTarEle,$this->input->ip_address(),'Actualizando Tarifa Electrica');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_tarifa_electrica($objSalida->TipTen,$objSalida->NomTarEle,$objSalida->CanPerTar,$objSalida->MinPotCon,$objSalida->MaxPotCon);		
			$objSalida->CodTarEle=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','INSERT',$objSalida->CodTarEle,$this->input->ip_address(),'Creando Tarifa Electrica');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function buscar_XID_TarEle_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTarEle=$this->get('CodTarEle');		
        $data = $this->Configuraciones_generales_model->get_tarifa_electrica($CodTarEle);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','GET',$CodTarEle,$this->input->ip_address(),'Consultando datos de la Tarifa Electrica');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }

     ////PARA LAS TARIFAS ELECTRICAS END///////
     ////PARA LAS TARIFAS GAS START///////
    public function get_list_tarifa_Gas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_tarifa_Gas();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',0,$this->input->ip_address(),'Cargando Lista de Tarifas Gas');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
   	public function borrar_tarifa_gas_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTarGas=$this->get('CodTarGas');
        $data = $this->Configuraciones_generales_model->borrar_tarifa_gas($CodTarGas);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','DELETE',$CodTarGas,$this->input->ip_address(),'Borrando Tarifa Gas.');		
    }
     public function buscar_XID_TarGas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTarGas=$this->get('CodTarGas');		
        $data = $this->Configuraciones_generales_model->get_tarifa_gas($CodTarGas);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',$CodTarGas,$this->input->ip_address(),'Consultando datos de la Tarifa Gas');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
   public function crear_tarifa_GAS_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTarGas))
		{		
			$this->Configuraciones_generales_model->actualizar_tarifa_gas($objSalida->CodTarGas,$objSalida->NomTarGas,$objSalida->MinConAnu,$objSalida->MaxConAnu);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','UPDATE',$objSalida->CodTarGas,$this->input->ip_address(),'Actualizando Tarifa Gas');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_tarifa_gas($objSalida->NomTarGas,$objSalida->MinConAnu,$objSalida->MaxConAnu);		
			$objSalida->CodTarGas=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','INSERT',$objSalida->CodTarGas,$this->input->ip_address(),'Creando Tarifa Gas');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }  

     ////PARA LAS TARIFAS GAS END///////


   ////PARA LOS TIPO DE COMISIONES START///////
    public function get_list_Tipo_Comision_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_Tipo_Comision();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoComision','GET',0,$this->input->ip_address(),'Cargando Lista de Tipos de Comisiones');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function buscar_XID_TipoComision_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipCom=$this->get('CodTipCom');		
        $data = $this->Configuraciones_generales_model->get_tipo_comision($CodTipCom);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoComision','GET',$CodTipCom,$this->input->ip_address(),'Consultando datos del tipo de comision');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
   public function borrar_tipo_comision_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipCom=$this->get('CodTipCom');
        $data = $this->Configuraciones_generales_model->borrar_tipo_comision($CodTipCom);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoComision','DELETE',$CodTipCom,$this->input->ip_address(),'Borrando Tipo de Comision.');		
    }	
     
   public function crear_Tipo_Comision_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipCom))
		{		
			$this->Configuraciones_generales_model->actualizar_tipo_comision($objSalida->CodTipCom,$objSalida->DesTipCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoComision','UPDATE',$objSalida->CodTipCom,$this->input->ip_address(),'Actualizando Tipo de Comisión');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_tipo_comision($objSalida->DesTipCom);		
			$objSalida->CodTipCom=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoComision','INSERT',$objSalida->CodTipCom,$this->input->ip_address(),'Creando Tipo de Comisión');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     ////PARA LOS TIPO DE COMISIONES END///////

   	/// PARA LOS MOTIVOS DE BLOQUEOS START //////
   	  public function list_tMotivos_Bloqueos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_Motivos_Bloqueos();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de Bloqueos');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function borrar_row_tMotivos_Bloqueos_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodMotBloCli=$this->get('CodMotBloCli');
        $data = $this->Configuraciones_generales_model->borrar_tMotivos_Bloqueos($CodMotBloCli);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','DELETE',$CodMotBloCli,$this->input->ip_address(),'Borrando Motivo de Bloqueo.');		
    }
     public function buscar_xID_tMotivo_Bloqueo_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodMotBloCli=$this->get('CodMotBloCli');		
        $data = $this->Configuraciones_generales_model->get_tipo_tMotivo_Bloqueo($CodMotBloCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',$CodMotBloCli,$this->input->ip_address(),'Consultando Datos Del Motivo de Bloqueo');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
      public function crear_tMotivos_Bloqueos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodMotBloCli))
		{		
			$this->Configuraciones_generales_model->actualizar_motivo_bloqueo($objSalida->CodMotBloCli,$objSalida->DesMotBloCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','UPDATE',$objSalida->CodMotBloCli,$this->input->ip_address(),'Actualizando Motivo de Bloqueo');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_motivo_bloqueo($objSalida->DesMotBloCli);		
			$objSalida->CodMotBloCli=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','INSERT',$objSalida->CodMotBloCli,$this->input->ip_address(),'Creando Motivo de Bloqueo');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
   	/// PARA LOS MOTIVOS DE BLOQUEOS END //////
   	 ////PARA LOS MOTIVOS DE BLOQUEO DE LAS ACTIVIDADES START///////
    public function list_tMotivos_Bloqueos_Actividades_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->list_tMotivos_Bloqueos_Actividades();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de Bloqueado de Actividades');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function crear_tMotivos_Bloqueos_Actividades_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodMotBloAct))
		{		
			$this->Configuraciones_generales_model->actualizar_motivo_bloqueo_actividades($objSalida->CodMotBloAct,$objSalida->DesMotBloAct);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','UPDATE',$objSalida->CodMotBloAct,$this->input->ip_address(),'Actualizando Motivo de Bloqueo');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_motivo_bloqueo_actividades($objSalida->DesMotBloAct);		
			$objSalida->CodMotBloAct=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','INSERT',$objSalida->CodMotBloAct,$this->input->ip_address(),'Creando Motivo de Bloqueo');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_tMotivo_Bloqueo_Actividades_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodMotBloAct=$this->get('CodMotBloAct');		
        $data = $this->Configuraciones_generales_model->get_tipo_tMotivo_Bloqueo_Actividades($CodMotBloAct);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',$CodMotBloAct,$this->input->ip_address(),'Consultando Datos Del Motivo de Bloqueo de Actividades');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function borrar_row_tMotivos_Bloqueos_Actividades_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodMotBloAct=$this->get('CodMotBloAct');
        $data = $this->Configuraciones_generales_model->borrar_tMotivos_Bloqueos_Actividades($CodMotBloAct);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','DELETE',$CodMotBloAct,$this->input->ip_address(),'Borrando Motivo de Bloqueo Actividades.');		
    }

     ////PARA LOS MOTIVOS DE BLOQUEO DE LAS ACTIVIDADES END///////

     ////PARA LAS COLABORADORES START///////
    public function list_colaboradores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_colaboradores();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'Cargando Lista de Colaboradores');
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
        $data = $this->Configuraciones_generales_model->borrar_colaborador_data($CodCol);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','DELETE',$CodCol,$this->input->ip_address(),'Borrando Colaborador.');		
    }
    public function get_colaborador_data_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCol=$this->get('CodCol');		
        $data = $this->Configuraciones_generales_model->get_colaborador_data($CodCol);
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
			$this->Configuraciones_generales_model->actualizar_colaborador($objSalida->CodCol,$objSalida->BloDir,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->EmaCol,$objSalida->EscDir,$objSalida->EstCol,$objSalida->NomCol,$objSalida->NomViaDir,$objSalida->NumIdeFis,$objSalida->NumViaDir,$objSalida->ObsCol,$objSalida->PlaDir,$objSalida->PorCol,$objSalida->PueDir,$objSalida->TelCelCol,$objSalida->TelFijCol,$objSalida->TipCol);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','UPDATE',$objSalida->CodCol,$this->input->ip_address(),'Actualizando Colaborador');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_colaborador($objSalida->BloDir,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->EmaCol,$objSalida->EscDir,$objSalida->EstCol,$objSalida->NomCol,$objSalida->NomViaDir,$objSalida->NumIdeFis,$objSalida->NumViaDir,$objSalida->ObsCol,$objSalida->PlaDir,$objSalida->PorCol,$objSalida->PueDir,$objSalida->TelCelCol,$objSalida->TelFijCol,$objSalida->TipCol);		
			$objSalida->CodCol=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','INSERT',$objSalida->CodCol,$this->input->ip_address(),'Creando Colaborador');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     
   

     ////PARA LAS COLABORADORES END///////

     ////PARA LAS SECTORES START///////
    public function list_sectores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_sectores();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',0,$this->input->ip_address(),'Cargando Lista de Sectores');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function borrar_row_sectores_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodSecCli=$this->get('CodSecCli');
        $data = $this->Configuraciones_generales_model->borrar_sector_data($CodSecCli);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','DELETE',$CodSecCli,$this->input->ip_address(),'Borrando Sector.');		
    }
    public function buscar_xID_sectores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodSecCli=$this->get('CodSecCli');		
        $data = $this->Configuraciones_generales_model->get_sector_data($CodSecCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',$CodSecCli,$this->input->ip_address(),'Consultando datos del Sector');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
   public function crear_sectores_post()
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
			$this->Configuraciones_generales_model->actualizar_sector($objSalida->CodSecCli,$objSalida->DesSecCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','UPDATE',$objSalida->CodSecCli,$this->input->ip_address(),'Actualizando Sector');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_sector($objSalida->DesSecCli);		
			$objSalida->CodSecCli=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','INSERT',$objSalida->CodSecCli,$this->input->ip_address(),'Creando Sector');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     ////PARA LAS SECTORES END///////

     ////PARA LAS TIPOS DE INMUEBLES START///////
    public function list_inmuebles_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_inmuebles();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','GET',0,$this->input->ip_address(),'Cargando Lista de Inmuebles');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
   public function crear_tipo_inmueble_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipInm))
		{		
			$this->Configuraciones_generales_model->actualizar_inmueble($objSalida->CodTipInm,$objSalida->DesTipInm);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','UPDATE',$objSalida->CodTipInm,$this->input->ip_address(),'Actualizando Inmueble');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_inmueble($objSalida->DesTipInm);		
			$objSalida->CodTipInm=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','INSERT',$objSalida->CodTipInm,$this->input->ip_address(),'Creando Inmueble');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
      public function buscar_xID_inmuebles_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipInm=$this->get('CodTipInm');		
        $data = $this->Configuraciones_generales_model->get_inmueble_data($CodTipInm);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','GET',$CodTipInm,$this->input->ip_address(),'Consultando datos del Inmueble');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function borrar_row_inmueble_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTipInm=$this->get('CodTipInm');
        $data = $this->Configuraciones_generales_model->borrar_inmueble_data($CodTipInm);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','DELETE',$CodTipInm,$this->input->ip_address(),'Borrando Tipo Inmueble.');		
    }

     ////PARA LAS TIPOS DE INMUEBLES END///////

     
     ////PARA LAS COMERCIALIZADORAS START////
     public function comprobar_cif_comercializadora_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$result = $this->Configuraciones_generales_model->consultar_cif_comercializadora($objSalida->NumCifCom);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'Comprobando CIF Comercializadora');	
		$this->db->trans_complete();
		$this->response($result);
    }
     public function get_list_comercializadora_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}			
        $data = $this->Configuraciones_generales_model->get_list_comercializadora();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'Cargando Listado de Comercializadoras');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function get_tipos_vias_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_tipos_vias();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoVias','GET',0,$this->input->ip_address(),'Cargando Lista de Tipos Vias');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function registrar_comercializadora_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodCom))
		{		
			$this->Configuraciones_generales_model->actualizar_comercializadora($objSalida->CodCom,$objSalida->BloDirCom,$objSalida->CarConCom,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->DurConCom,$objSalida->EmaCom,$objSalida->EscDirCom,$objSalida->FecConCom,$objSalida->FecVenConCom,$objSalida->NomComCom,$objSalida->NomConCom,$objSalida->NomViaDirCom,$objSalida->NumCifCom,$objSalida->NumViaDirCom,$objSalida->ObsCom,$objSalida->PagWebCom,$objSalida->PlaDirCom,$objSalida->PueDirCom,$objSalida->RazSocCom,$objSalida->RenAutConCom,$objSalida->SerEle,$objSalida->SerEsp,$objSalida->SerGas,$objSalida->TelFijCom,$objSalida->DocConCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','UPDATE',$objSalida->CodCom,$this->input->ip_address(),'Actualizando Comercializadora');
		}
		else
		{
			$id = $this->Configuraciones_generales_model->agregar_comercializadora($objSalida->BloDirCom,$objSalida->CarConCom,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->DurConCom,$objSalida->EmaCom,$objSalida->EscDirCom,$objSalida->FecConCom,$objSalida->FecVenConCom,$objSalida->NomComCom,$objSalida->NomConCom,$objSalida->NomViaDirCom,$objSalida->NumCifCom,$objSalida->NumViaDirCom,$objSalida->ObsCom,$objSalida->PagWebCom,$objSalida->PlaDirCom,$objSalida->PueDirCom,$objSalida->RazSocCom,$objSalida->RenAutConCom,$objSalida->SerEle,$objSalida->SerEsp,$objSalida->SerGas,$objSalida->TelFijCom,date('Y-m-d'),$objSalida->DocConCom);		
			$objSalida->CodCom=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','INSERT',$objSalida->CodCom,$this->input->ip_address(),'Creando Comercializadora');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function Buscar_xID_Comercializadora_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $CodCom=$this->get('CodCom');
        $data = $this->Configuraciones_generales_model->get_CodCom($CodCom);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'Consultando Datos de la Comercializadora');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function cambiar_estatus_comercializadora_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$resultado = $this->Configuraciones_generales_model->update_status_comercializadora($objSalida->CodCom,$objSalida->EstCom);
		


		if($objSalida->EstCom==2)
		{
			$CodBloCom=$this->Configuraciones_generales_model->agregar_bloqueo_Com($objSalida->CodCom,date('Y-m-d'),$objSalida->MotBloq,$objSalida->ObsBloCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoComercializadora','INSERT',$CodBloCom,$this->input->ip_address(),'Bloqueo de Comercializadora.');
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','UPDATE',$objSalida->CodCom,$this->input->ip_address(),'Actualizando Estatus de la Comercializadora');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function borrar_comercializadora_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodCom=$this->get('CodCom');
        $data = $this->Configuraciones_generales_model->delete_comercializadora($CodCom);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','DELETE',$CodCom,$this->input->ip_address(),'Borrando Comercializadora.');		
    }
    public function list_MotBloCom_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Configuraciones_generales_model->get_list_MotBloCom();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de Bloqueos Comercializadora');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }

     public function get_list_Actividades_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
        $ComAct = $this->Configuraciones_generales_model->get_list_ComAct();
       	$ProAct = $this->Configuraciones_generales_model->get_list_ProAct();
       	$TioCom = $this->Configuraciones_generales_model->get_list_TipCom();
       	$Tarifa_Gas= $this->Configuraciones_generales_model->get_list_tarifa_Gas();
       	$Tarifa_Ele= $this->Configuraciones_generales_model->list_tarifa_electricas();


       	$data=array('TProComercializadoras' =>$ComAct,'TProductosActivos' =>$ProAct,'Tipos_Comision' =>$TioCom,'Tarifa_Gas' =>$Tarifa_Gas,'Tarifa_Ele' =>$Tarifa_Ele );
       	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'Cargando Lista de Activades Para Usar');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }



    

    /////PARA LAS COMERCIALIZADORAS END////








	/////PARA LOS BLOQUEOS DEL PUNTO DE SUMINISTRO  START////

     public function list_motPumSum_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
        $data = $this->Configuraciones_generales_model->get_list_MotPumSum();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de Puntos de Suministros');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function crear_motivo_PumSum_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	

		if(isset($objSalida->CodMotBloPun))
		{
			$this->Configuraciones_generales_model->actualizar_MotBloPunSum($objSalida->CodMotBloPun,$objSalida->DesMotBloPun);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','UPDATE',$objSalida->CodMotBloPun,$this->input->ip_address(),'Actualizando Motivo de Bloqueo Punto de Suministros');	
		}
		else
		{			
			$id = $this->Configuraciones_generales_model->agregar_MotBloPunSum($objSalida->DesMotBloPun);		
			$objSalida->CodMotBloPun=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','INSERT',$objSalida->CodMotBloPu,$this->input->ip_address(),'Agregando Motivo de Bloqueo Punto de Suministros');
		}			
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_xID_MotPumSum_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $CodMotBloPun=$this->get('CodMotBloPun');
        $data = $this->Configuraciones_generales_model->get_MotBloPunSum($CodMotBloPun);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',$CodMotBloPun,$this->input->ip_address(),'Buscando Motivo de Bloqueo Por CodMotBloPun');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function borrar_row_MotPumSum_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodMotBloPun=$this->get('CodMotBloPun');
        $data = $this->Configuraciones_generales_model->borrar_MotBloPumSum($CodMotBloPun);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','DELETE',$CodMotBloPun,$this->input->ip_address(),'Borrando Motivo Bloqueo Punto Sumninistro.');		
    }
    /////PARA LOS BLOQUEOS DEL PUNTO DE SUMINISTRO  END////


    /////PARA LOS BLOQUEOS DE LAS COMERCIALIZADORAS START////
     public function list_motivos_Comercializadora_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
        $data = $this->Configuraciones_generales_model->get_motivos_Comercializadora();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos Bloqueos Comercializadora');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_motivo_BloCom_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	

		if(isset($objSalida->CodMotBloCom))
		{
			$this->Configuraciones_generales_model->actualizar_MotBloCom($objSalida->CodMotBloCom,$objSalida->DesMotBloCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','UPDATE',$objSalida->CodMotBloCom,$this->input->ip_address(),'Actualizando Motivo de Bloqueo Comercializadora');	
		}
		else
		{			
			$id = $this->Configuraciones_generales_model->agregar_MotBloCom($objSalida->DesMotBloCom);		
			$objSalida->CodMotBloCom=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','INSERT',$objSalida->CodMotBloCom,$this->input->ip_address(),'Agregando Motivo de Bloqueo Comercializadora');
		}			
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function buscar_xID_MotBloCom_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $CodMotBloCom=$this->get('CodMotBloCom');
        $data = $this->Configuraciones_generales_model->get_MotBloCom($CodMotBloCom);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',$CodMotBloCom,$this->input->ip_address(),'Buscando Motivo de Bloqueo Por CodMotBloCom');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function borrar_row_MotBloCom_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodMotBloCom=$this->get('CodMotBloCom');
        $data = $this->Configuraciones_generales_model->borrar_MotBloCom($CodMotBloCom);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','DELETE',$CodMotBloCom,$this->input->ip_address(),'Borrando Motivo Bloqueo Comercializadora.');		
    }
   
    /////PARA LOS BLOQUEOS DE LAS COMERCIALIZADORAS END////


///////////////////////////////////////////PARA LOS PRODUCTOS START////////////////////////////////////////////////////////////////////////////////////

public function get_list_productos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	//$CodCom=$this->get('CodCom');
    $data = $this->Configuraciones_generales_model->get_list_productos();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','GET',0,$this->input->ip_address(),'Cargando Lista de Productos Por Comercializadora.');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}		
	$this->response($data);		
}
public function registrar_productos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	

		if(isset($objSalida->CodTPro))
		{
			$this->Configuraciones_generales_model->actualizar_productos($objSalida->CodTPro,$objSalida->CodTProCom,$objSalida->DesPro,$objSalida->CodTProCom,$objSalida->SerGas,$objSalida->SerEle,$objSalida->ObsPro);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','UPDATE',$objSalida->CodTPro,$this->input->ip_address(),'Actualizando Productos.');	
		}
		else
		{			
			$id = $this->Configuraciones_generales_model->agregar_productos($objSalida->CodTProCom,$objSalida->DesPro,$objSalida->CodTProCom,$objSalida->SerGas,$objSalida->SerEle,$objSalida->ObsPro,date('Y-m-d'));		
			$objSalida->CodTPro=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','INSERT',$objSalida->CodTPro,$this->input->ip_address(),'Agregando Productos.');
		}			
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function cambiar_estatus_productos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$resultado = $this->Configuraciones_generales_model->update_status_productos($objSalida->CodPro,$objSalida->EstPro);
		


		if($objSalida->EstPro==2)
		{
			$CodMotBloPro=$this->Configuraciones_generales_model->agregar_bloqueo_productos($objSalida->CodPro,date('Y-m-d'),$objSalida->MotBloqPro,$objSalida->ObsBloPro);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoProducto','INSERT',$CodMotBloPro,$this->input->ip_address(),'Bloqueo de Producto.');
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','UPDATE',$objSalida->CodPro,$this->input->ip_address(),'Actualizando Estatus de la Comercializadora');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
///////////////////////////////////////////PARA LOS PRODUCTOS END////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////PARA LOS ANEXOS START////////////////////////////////////////////////////////////////////////////////////
public function get_list_anexos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	//$CodCom=$this->get('CodCom');
    $data = $this->Configuraciones_generales_model->get_list_anexos();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','GET',0,$this->input->ip_address(),'Cargando Lista de Anexos.');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}		
	$this->response($data);		
}
public function registrar_anexos_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$T_DetalleAnexoTarifaElecAlt=$objSalida->T_DetalleAnexoTarifaElecAlt;
	$T_DetalleAnexoTarifaElecBaj=$objSalida->T_DetalleAnexoTarifaElecBaj;
	$T_DetalleAnexoTarifaGas=$objSalida->T_DetalleAnexoTarifaGas;
	$this->db->trans_start();	
	if($objSalida->Fijo==true&&$objSalida->Indexado==false)
	{
		$TipPre=0;
	}
	elseif ($objSalida->Indexado==true&&$objSalida->Fijo==false) 
	{
		$TipPre=1;
	}
	else
	{
		$TipPre=2;
	}
	if(isset($objSalida->CodAnePro))
	{
		$this->Configuraciones_generales_model->eliminar_detalles_anexos($objSalida->CodAnePro);
		$this->Configuraciones_generales_model->actualizar_anexos($objSalida->CodAnePro,$objSalida->CodPro,$objSalida->DesAnePro,$objSalida->SerGas,$objSalida->SerEle,$objSalida->DocAnePro,$objSalida->ObsAnePro,$objSalida->CodTipCom,0,$TipPre);
		if($T_DetalleAnexoTarifaGas!=false)
		{
			foreach ($T_DetalleAnexoTarifaGas as $T_DetalleAnexoTarifaGas => $record_Tarifa_Gas):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_gas($objSalida->CodAnePro,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecBaj!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecBaj as $T_DetalleAnexoTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Baja($objSalida->CodAnePro,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecAlt!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecAlt as $T_DetalleAnexoTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Alta($objSalida->CodAnePro,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','UPDATE',$objSalida->CodAnePro,$this->input->ip_address(),'Actualizando Productos.');	
	}
	else
	{			
		$id = $this->Configuraciones_generales_model->agregar_anexos($objSalida->CodPro,$objSalida->DesAnePro,$objSalida->SerGas,$objSalida->SerEle,$objSalida->DocAnePro,$objSalida->ObsAnePro,date('Y-m-d'),$objSalida->CodTipCom,0,1,$TipPre);		
			$objSalida->CodAnePro=$id;
		if($T_DetalleAnexoTarifaGas!=false)
		{
			foreach ($T_DetalleAnexoTarifaGas as $T_DetalleAnexoTarifaGas => $record_Tarifa_Gas):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_gas($objSalida->CodAnePro,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecBaj!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecBaj as $T_DetalleAnexoTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Baja($objSalida->CodAnePro,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecAlt!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecAlt as $T_DetalleAnexoTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Alta($objSalida->CodAnePro,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','INSERT',$objSalida->CodAnePro,$this->input->ip_address(),'Agregando Anexos.');
	}			
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function Buscar_xID_Anexos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
    $CodAnePro=$this->get('CodAnePro');
    $data_anexos = $this->Configuraciones_generales_model->get_anexos_data($CodAnePro);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','GET',$CodAnePro,$this->input->ip_address(),'Buscando Anexos Por CodAnePro');
	if (empty($data_anexos))
	{
		$this->response(false);
		return false;
	}	

	if($data_anexos->SerGas==1)
	{
		$data_detalle_tarifa_gas = $this->Configuraciones_generales_model->get_detalle_tarifa_gas($CodAnePro);
		$data_anexos->T_DetalleAnexoTarifaGas=$data_detalle_tarifa_gas;
	}
	else
	{
		$data_anexos->T_DetalleAnexoTarifaGas=false;
	}
	if($data_anexos->SerEle==1)
	{		
		$data_anexos->T_DetalleAnexoTarifaElec = $this->obtener_detalle_tarifa_electrica($CodAnePro);		
	}
	else
	{
		$data_anexos->T_DetalleAnexoTarifaElec=false;
		//$data_anexos->T_DetalleAnexoTarifaElecAlt=false;
		//$data_anexos->T_DetalleAnexoTarifaElecBaj=false;
	}
	$this->response($data_anexos);		
}
	public function obtener_detalle_tarifa_electrica($CodAnePro)
    {
    	$detalleG = $this->Configuraciones_generales_model->obtener_detalle_tarifa_electrica($CodAnePro);
		$detalleFinal = Array();
		if (empty($detalleG))
		{
			return false;
		}
		return $detalleG;
	}
	public function cambiar_estatus_anexos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$resultado = $this->Configuraciones_generales_model->update_status_anexos($objSalida->CodAnePro,$objSalida->EstAne);
		


		if($objSalida->EstAne==2)
		{
			$CodMotBloPro=$this->Configuraciones_generales_model->agregar_bloqueo_anexos($objSalida->CodAnePro,date('Y-m-d'),$objSalida->MotBloAne,$objSalida->ObsMotBloAne);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoAnexo','INSERT',$CodMotBloPro,$this->input->ip_address(),'Bloqueo de Anexo.');
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','UPDATE',$objSalida->CodAnePro,$this->input->ip_address(),'Actualizando Estatus del Anexo');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }

///////////////////////////////////////////PARA LOS ANEXOS END////////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////PARA LOS SERVICIOS ESPECIALES START////////////////////////////////////////////////////////////////////////////////////

public function get_list_servicos_especiales_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	//$CodCom=$this->get('CodCom');
    $data = $this->Configuraciones_generales_model->get_list_servicos_especiales();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','GET',0,$this->input->ip_address(),'Cargando Lista de Servicios Especiales.');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}		
	$this->response($data);		
}
public function registrar_servicios_especiales_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$T_DetalleServicioEspecialTarifaElecBaj=$objSalida->T_DetalleServicioEspecialTarifaElecBaj;
	$T_DetalleServicioEspecialTarifaElecAlt=$objSalida->T_DetalleServicioEspecialTarifaElecAlt;
	$T_DetalleServicioEspecialTarifaGas=$objSalida->T_DetalleServicioEspecialTarifaGas;
	$this->db->trans_start();	
	

	if($objSalida->SerEle==true&&$objSalida->SerGas==false)
	{
		$TipSumSerEsp=0;
	}
	elseif ($objSalida->SerEle==false&&$objSalida->SerGas==true)
	{
		$TipSumSerEsp=1;
	}
	else
	{
		$TipSumSerEsp=2;
	}
	if(isset($objSalida->CodSerEsp))
	{
		$this->Configuraciones_generales_model->eliminar_detalles_servicios_especiales($objSalida->CodSerEsp);
		$this->Configuraciones_generales_model->actualizar_servicio_especial($objSalida->CodSerEsp,$objSalida->CodCom,$objSalida->DesSerEsp,$TipSumSerEsp,$objSalida->TipCli,$objSalida->CarSerEsp,$objSalida->CodTipCom,$objSalida->OsbSerEsp);		
		if($T_DetalleServicioEspecialTarifaElecBaj!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecBaj as $T_DetalleServicioEspecialTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Baja_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleServicioEspecialTarifaElecAlt!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecAlt as $T_DetalleServicioEspecialTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Alta_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleServicioEspecialTarifaGas!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaGas as $T_DetalleServicioEspecialTarifaGas => $record_Tarifa_Gas):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_gas_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','UPDATE',$objSalida->CodSerEsp,$this->input->ip_address(),'Actualizando Servicio Especial.');	
	}
	else
	{
		$id = $this->Configuraciones_generales_model->agregar_servicio_especial($objSalida->CodCom,$objSalida->DesSerEsp,date('Y-m-d'),$TipSumSerEsp,$objSalida->TipCli,$objSalida->CarSerEsp,$objSalida->CodTipCom,$objSalida->OsbSerEsp);		
			$objSalida->CodSerEsp=$id;
	
		if($T_DetalleServicioEspecialTarifaElecBaj!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecBaj as $T_DetalleServicioEspecialTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Baja_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleServicioEspecialTarifaElecAlt!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecAlt as $T_DetalleServicioEspecialTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_Elec_Alta_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
			if($T_DetalleServicioEspecialTarifaGas!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaGas as $T_DetalleServicioEspecialTarifaGas => $record_Tarifa_Gas):
			{
				$this->Configuraciones_generales_model->agregar_detalle_tarifa_gas_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','INSERT',$objSalida->CodSerEsp,$this->input->ip_address(),'Agregando Servicio Especial.');
	}			
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function Buscar_xID_ServicioEspecial_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
    $CodSerEsp=$this->get('CodSerEsp');
    $data_servicio_especial = $this->Configuraciones_generales_model->get_servicio_especial_data($CodSerEsp);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','GET',$CodSerEsp,$this->input->ip_address(),'Buscando Servicio Especial Por CodSerEsp');
	if (empty($data_servicio_especial))
	{
		$this->response(false);
		return false;
	}	

	if($data_servicio_especial->SerGas=="SI")
	{
		$data_detalle_tarifa_gas = $this->Configuraciones_generales_model->get_detalle_tarifa_gas_SerEsp($CodSerEsp);
		$data_servicio_especial->T_DetalleServicioEspecialTarifaGas=$data_detalle_tarifa_gas;
	}
	else
	{
		$data_servicio_especial->T_DetalleServicioEspecialTarifaGas=false;
	}
	if($data_servicio_especial->SerEle=="SI")
	{		
		$data_servicio_especial->T_DetalleServicioEspecialTarifaEle = $this->obtener_detalle_tarifa_electrica_SerEsp($CodSerEsp);		
	}
	else
	{
		$data_servicio_especial->T_DetalleServicioEspecialTarifaEle=false;
	}
	$this->response($data_servicio_especial);		
}
public function obtener_detalle_tarifa_electrica_SerEsp($CodSerEsp)
    {
    	$detalleG = $this->Configuraciones_generales_model->obtener_detalle_tarifa_electrica_SerEsp($CodSerEsp);
		$detalleFinal = Array();
		if (empty($detalleG))
		{
			return false;
		}
		return $detalleG;
	}
	public function cambiar_estatus_servicio_especial_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$resultado = $this->Configuraciones_generales_model->update_status_servicio_especial($objSalida->CodSerEsp,$objSalida->EstSerEsp);
		


		if($objSalida->EstSerEsp==2)
		{
			$CodMotBloPro=$this->Configuraciones_generales_model->agregar_bloqueo_servicio_especial($objSalida->CodSerEsp,date('Y-m-d'),$objSalida->MotBloSerEsp,$objSalida->ObsMotBloSerEsp);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoServicioEspecial','INSERT',$CodMotBloPro,$this->input->ip_address(),'Bloqueo de Servicio Especial.');
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','UPDATE',$objSalida->CodSerEsp,$this->input->ip_address(),'Actualizando Estatus del Servicio Especial');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }


///////////////////////////////////////////PARA LOS SERVICIOS ESPECIALES END////////////////////////////////////////////////////////////////////////////////////

}
?>