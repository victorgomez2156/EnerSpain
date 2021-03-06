<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Clientes extends REST_Controller
{
	function __construct()
	{
		parent::__construct(); 
		$this->load->database('default');
		$this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Clientes_model');
		$this->load->model('Propuesta_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
	}
	public function get_all_functions_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
		$Provincias = $this->Clientes_model->get_list_providencias();
		$Localidades = $this->Clientes_model->get_list_localidades();       
		$Tipo_Cliente = $this->Clientes_model->get_list_tipo_Cliente();
		$Comerciales = $this->Clientes_model->get_list_comerciales();
		$Sector_Cliente = $this->Clientes_model->get_list_sector_cliente();
		$Colaborador = $this->Clientes_model->get_list_colaboradores();
		$Tipo_Vias = $this->Clientes_model->get_list_tipos_vias();
		$Tipo_Inmuebles = $this->Clientes_model->get_list_tipo_inmuebles();
		$Bancos = $this->Clientes_model->get_list_bancos();
		$Tipo_Contacto = $this->Clientes_model->get_list_tipo_contacto();        
		$Tipos_Documentos=$this->Clientes_model->get_list_tipos_documentos();
		$Clientes=$this->Clientes_model->get_list_clientes();
		$Actividades_Clientes=$this->Clientes_model->get_activity_clientes();
		$Puntos_Suministros_Clientes=$this->Clientes_model->get_puntos_suministros_clientes();
		$Contactos=$this->Clientes_model->get_lista_contactos();
		$Cuentas_Bancarias = $this->Clientes_model->get_all_Cuentas_Bancarias_clientes();
		$Documentos = $this->Clientes_model->get_all_documentos();
		$Fecha=date('d/m/Y');
		$data= array('Provincias' =>$Provincias , 'Localidades' =>$Localidades  , 'Tipo_Cliente' =>$Tipo_Cliente , 'Comerciales' =>$Comerciales ,'Sector_Cliente' =>$Sector_Cliente,'Colaborador' =>$Colaborador,'Tipo_Vias' =>$Tipo_Vias,'Tipo_Inmuebles' =>$Tipo_Inmuebles,'Bancos' =>$Bancos,'Tipo_Contacto' =>$Tipo_Contacto,'Tipos_Documentos' =>$Tipos_Documentos,'Fecha_Server'=>$Fecha
			,
			'Clientes'=>$Clientes,'Actividades_Clientes'=>$Actividades_Clientes,'Puntos_Suministros_Clientes'=>$Puntos_Suministros_Clientes,'Contactos'=>$Contactos,'Cuentas_Bancarias'=>$Cuentas_Bancarias,'Documentos'=>$Documentos );
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_V_T','GET',null,$this->input->ip_address(),'Cargando Varias Consultas');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
////////////////////////////////////////////////////////////// PARA CLIENTES START ////////////////////////////////////////////////
	public function get_service_clientes_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}  
		$Clientes=$this->Clientes_model->get_list_clientes();
		$Fecha=date('d/m/Y');

		$data= array('Fecha_Server'=>$Fecha,'Clientes'=>$Clientes);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_V_T','GET',null,$this->input->ip_address(),'Cargando Varias Consultas');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function get_service_AddClientes_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$Tipo_Cliente = $this->Clientes_model->get_list_tipo_Cliente();
		$Sector_Cliente = $this->Clientes_model->get_list_sector_cliente();		
		$Tipo_Vias = $this->Clientes_model->get_list_tipos_vias();
		$Provincias = $this->Clientes_model->get_list_providencias();		
		$TipoContactos=$this->Clientes_model->get_list_tipo_contacto();
		//$Comerciales = $this->Clientes_model->get_list_comerciales();
		//$Colaborador = $this->Clientes_model->get_list_colaboradores();
		$arrayName = array('Fecha_Server' =>date('d/m/Y'),'Tipo_Cliente'=>$Tipo_Cliente,'Sector_Cliente'=>$Sector_Cliente,'Tipo_Vias'=>$Tipo_Vias,'Provincias'=>$Provincias,'TipoContactos'=>$TipoContactos/*,'Comerciales'=>$Comerciales,'Colaborador'=>$Colaborador*/ );
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_VariasConsultas','GET',null,$this->input->ip_address(),'Generando ServiceAddClientes');
		$this->response($arrayName);		
	}

	public function RealizarConsultaFiltros_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}  
		$metodo=$this->get('metodo');        
		if($metodo==1)
		{
			$Response = $this->Clientes_model->get_list_tipo_Cliente();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',null,$this->input->ip_address(),'Cargando Tipo de Clientes');
			//$Response->metodo=$metodo;
		}
		elseif ($metodo==2) {
			$Response = $this->Clientes_model->get_list_sector_cliente();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Sector','GET',null,$this->input->ip_address(),'Cargando Tipo de Sector');
		}
		elseif ($metodo==3) {
			$Response = $this->Clientes_model->get_list_providencias();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',null,$this->input->ip_address(),'Cargando Provincias');
		}
		elseif ($metodo==4) {
			$Response = $this->Clientes_model->get_list_providencias();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',null,$this->input->ip_address(),'Cargando Provincias');
		}
		elseif ($metodo==5) {
			$Response = $this->Clientes_model->get_list_comerciales();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',null,$this->input->ip_address(),'Cargando Comerciales');
		}
		elseif ($metodo==6) {
			$Response =$this->Clientes_model->get_list_colaboradores();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaboradores','GET',null,$this->input->ip_address(),'Cargando Colaboradores');
		}
		elseif ($metodo==7) {
			$Response =false;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'Estatus','GET',null,$this->input->ip_address(),'Estatus');
		}
		elseif ($metodo==8) {
			$Response=$this->Clientes_model->get_list_tipo_inmuebles();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','GET',null,$this->input->ip_address(),'Cargando Listado de Tipos de Inmuebles');
		}
		elseif ($metodo==9) {
			$Response= $this->Clientes_model->get_list_tipo_contacto();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','GET',null,$this->input->ip_address(),'Cargando Listado de Contactos');
		}
		elseif ($metodo==10) {
			$Response= $this->Clientes_model->get_list_bancos();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','GET',null,$this->input->ip_address(),'Cargando Listado de Bancos');
		}
		elseif ($metodo==11) {
			$Response=$this->Clientes_model->get_list_tipos_documentos();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','GET',null,$this->input->ip_address(),'Cargando Listado de Tipos de Documentos');
			# code...
		}
		elseif ($metodo==12) {
			$Response= $this->Clientes_model->get_list_tipos_vias();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoVia','GET',null,$this->input->ip_address(),'Cargando listado de tipos via');
			# code...
		}
		else
		{
			$Response =array('status' =>201 ,'statusText'=>'Error','menssage'=>'Estatus del Clientes');
			$this->Auditoria_model->agregar($this->session->userdata('id'),'Estatus','GET',null,$this->input->ip_address(),'Estatus');
		}		
		$this->response($Response);		
	}
	public function BuscarLocalidadesFil_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$CodPro=$this->get('CodPro');
		$data = $this->Clientes_model->get_localidadesProvincia($CodPro);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',NULL,$this->input->ip_address(),'Cargando Lista de Localidades');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function BuscarLocalidadAddClientes_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$CodPro=$this->get('CodPro');
    	//$Metodo=$this->get('Metodo');
		$data = $this->Clientes_model->get_localidadesProvincia($CodPro);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',$CodPro,$this->input->ip_address(),'Cargando Lista de Localidades');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function list_clientes_get()
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
	public function comprobar_cif_existente_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->comprobar_cif_existencia($objSalida->Clientes_CIF);							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($consulta);
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
		$this->Clientes_model->update_status_cliente($objSalida->opcion,$objSalida->hcliente);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','UPDATE',$objSalida->opcion,$this->input->ip_address(),'Actualizando Estatus del Cliente a Activo');

		if($objSalida->opcion==2)
		{
			$Fecha_Bloqueo=explode("/", $objSalida->FechBlo);
			$Fecha_Bloqueo_Final=$Fecha_Bloqueo[2]."-".$Fecha_Bloqueo[1]."-".$Fecha_Bloqueo[0];
			$CodBloq=$this->Clientes_model->agregar_motivo_bloqueo($objSalida->hcliente,$Fecha_Bloqueo_Final,$objSalida->CodMotBloCli,$objSalida->ObsBloCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoCliente','INSERT',$CodBloq,$this->input->ip_address(),'Actualizando Estatus del Cliente a Activo');
		}		
		$this->db->trans_complete();
		$this->response(true);
	}
	public function Motivos_Bloqueos_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Clientes_model->get_list_motivos_bloqueos();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',null,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	protected function buscar_xID_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$huser=$this->get('huser');		
		$data = $this->Clientes_model->get_clientes_data($huser);		
		$ContactoPrincipal=$this->Clientes_model->GetContactoPrincipal($huser);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$huser,$this->input->ip_address(),'Consultando datos del Cliente');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}	
		$data->tContacto_data_modal=$ContactoPrincipal;
		$this->response($data);		
	} 
	public function crear_clientes_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodCli))
		{		
			
			$this->Clientes_model->actualizar($objSalida->CodCli,$objSalida->BloDomFis,$objSalida->BloDomSoc,$objSalida->CodCol,$objSalida->CodCom,$objSalida->CodLocFis,$objSalida->CodLocSoc,$objSalida->CodProFis,$objSalida->CodProSoc,$objSalida->CodSecCli,$objSalida->CodTipCli,$objSalida->CodTipViaFis,$objSalida->CodTipViaSoc,$objSalida->EmaCli,$objSalida->EscDomFis,$objSalida->EscDomSoc,$objSalida->NomComCli,$objSalida->NomViaDomFis,$objSalida->NomViaDomSoc,$objSalida->NumViaDomFis,$objSalida->NumViaDomSoc,$objSalida->ObsCli,$objSalida->PlaDomFis,$objSalida->PlaDomSoc,$objSalida->PueDomFis,$objSalida->PueDomSoc,$objSalida->RazSocCli,$objSalida->TelFijCli,$objSalida->WebCli,$objSalida->FecIniCli,$objSalida->CPLocSoc,$objSalida->CPLocFis,$objSalida->TelMovCli,$objSalida->EmaCliOpc);

			if($objSalida->tContacto_data_modal!=false)
			{
				if(isset($objSalida->tContacto_data_modal->CodConCli))
				{
					$validar_contacto=$this->Clientes_model->validar_CIF_NIF_Existente_UPDATE($objSalida->tContacto_data_modal->CodConCli);
					if($objSalida->CodCli!=$validar_contacto->CodCli && $objSalida->tContacto_data_modal->NIFConCli==$validar_contacto->NIFConCli)
					{
						$validar_contacto1=$this->Clientes_model->validar_CIF_NIF_Existente($objSalida->tContacto_data_modal->NIFConCli,$objSalida->CodCli);
						if (!empty($validar_contacto1))
						{
							$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',null,$this->input->ip_address(),'El Contacto ya se encuentra asignado');
							$arrayName = array('status' =>400 ,'menssage'=>'El n??mero de documento ya se encuentra asignado a este Cliente','statusText'=>'Error');
							$this->db->trans_complete();
							$this->response($arrayName);
						}
						else
						{
							$this->Clientes_model->actualizar_contacto($objSalida->tContacto_data_modal->CodConCli,$objSalida->tContacto_data_modal->NIFConCli,$objSalida->tContacto_data_modal->EsRepLeg,$objSalida->tContacto_data_modal->TieFacEsc,$objSalida->tContacto_data_modal->CanMinRep,$objSalida->tContacto_data_modal->CodCli,$objSalida->tContacto_data_modal->CodTipCon,$objSalida->tContacto_data_modal->CarConCli,$objSalida->tContacto_data_modal->NomConCli,$objSalida->tContacto_data_modal->TelFijConCli,$objSalida->tContacto_data_modal->TelCelConCli,$objSalida->tContacto_data_modal->EmaConCli,$objSalida->tContacto_data_modal->TipRepr,$objSalida->tContacto_data_modal->DocNIF,$objSalida->tContacto_data_modal->ObsConC,$objSalida->tContacto_data_modal->DocPod,$objSalida->tContacto_data_modal->NumColeCon,$objSalida->tContacto_data_modal->ConPrin);
							$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->tContacto_data_modal->CodConCli,$this->input->ip_address(),'Actualizando registro del Contacto desde Clientes');
						}
					}
					else
					{
						$this->Clientes_model->actualizar_contacto($objSalida->tContacto_data_modal->CodConCli,$objSalida->tContacto_data_modal->NIFConCli,$objSalida->tContacto_data_modal->EsRepLeg,$objSalida->tContacto_data_modal->TieFacEsc,$objSalida->tContacto_data_modal->CanMinRep,$objSalida->tContacto_data_modal->CodCli,$objSalida->tContacto_data_modal->CodTipCon,$objSalida->tContacto_data_modal->CarConCli,$objSalida->tContacto_data_modal->NomConCli,$objSalida->tContacto_data_modal->TelFijConCli,$objSalida->tContacto_data_modal->TelCelConCli,$objSalida->tContacto_data_modal->EmaConCli,$objSalida->tContacto_data_modal->TipRepr,$objSalida->tContacto_data_modal->DocNIF,$objSalida->tContacto_data_modal->ObsConC,$objSalida->tContacto_data_modal->DocPod,$objSalida->tContacto_data_modal->NumColeCon,$objSalida->tContacto_data_modal->ConPrin);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->tContacto_data_modal->CodConCli,$this->input->ip_address(),'Actualizando registro del Contacto desde Clientes');
					}										
				}
				else
				{
					$validar_contacto=$this->Clientes_model->validar_CIF_NIF_Existente($objSalida->tContacto_data_modal->NIFConCli,$objSalida->CodCli);
					if (!empty($validar_contacto))
					{
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',null,$this->input->ip_address(),'El Contacto ya se encuentra asignado');
						$arrayName = array('status' =>false ,'menssage'=>'El N??mero de Documento Ya Se Encuentra Registrado y Asignado ha Este Cliente.','objSalida'=>$objSalida,'response'=>false);
						$this->db->trans_complete();
						$this->response($arrayName);
					}
					else
					{
						$id = $this->Clientes_model->agregar_contacto($objSalida->tContacto_data_modal->NIFConCli,$objSalida->tContacto_data_modal->EsRepLeg,$objSalida->tContacto_data_modal->TieFacEsc,$objSalida->tContacto_data_modal->CanMinRep,$objSalida->tContacto_data_modal->CodCli,$objSalida->tContacto_data_modal->CodTipCon,$objSalida->tContacto_data_modal->CarConCli,$objSalida->tContacto_data_modal->NomConCli,$objSalida->tContacto_data_modal->TelFijConCli,$objSalida->tContacto_data_modal->TelCelConCli,$objSalida->tContacto_data_modal->EmaConCli,$objSalida->tContacto_data_modal->TipRepr,$objSalida->tContacto_data_modal->DocNIF,$objSalida->tContacto_data_modal->ObsConC,$objSalida->tContacto_data_modal->DocPod,$objSalida->tContacto_data_modal->NumColeCon,$objSalida->tContacto_data_modal->ConPrin);
						$objSalida->CodConCli=$id;	
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',$objSalida->CodConCli,$this->input->ip_address(),'Creando Contacto desde Clientes.');
					}
				}
			}
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','UPDATE',$objSalida->CodCli,$this->input->ip_address(),'Actualizando Datos Del Clientes');
		}
		else
		{
			$id = $this->Clientes_model->agregar($objSalida->BloDomFis,$objSalida->BloDomSoc,$objSalida->CodCol,$objSalida->CodCom,$objSalida->CodLocFis,$objSalida->CodLocSoc,$objSalida->CodProFis,$objSalida->CodProSoc,$objSalida->CodSecCli,$objSalida->CodTipCli,$objSalida->CodTipViaFis,$objSalida->CodTipViaSoc,$objSalida->EmaCli,$objSalida->EscDomFis,$objSalida->EscDomSoc,$objSalida->FecIniCli,$objSalida->NomComCli,$objSalida->NomViaDomFis,$objSalida->NomViaDomSoc,$objSalida->NumCifCli,$objSalida->NumViaDomFis,$objSalida->NumViaDomSoc,$objSalida->ObsCli,$objSalida->PlaDomFis,$objSalida->PlaDomSoc,$objSalida->PueDomFis,$objSalida->PueDomSoc,$objSalida->RazSocCli,$objSalida->TelFijCli,$objSalida->WebCli,$objSalida->CPLocSoc,$objSalida->CPLocFis,$objSalida->TelMovCli,$objSalida->EmaCliOpc);
			if($id==false)
			{
				$arrayName = array('status' =>false ,'response'=> $id, 'message'=>'El N??mero de CIF ya se encuentra registrado, Por Favor intente con otro.');
				$this->response($arrayName);
				return false;
			}	
			$objSalida->CodCli=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','INSERT',$objSalida->CodCli,$this->input->ip_address(),'Creando Registro de Clientes');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
	} 
	public function getClientesFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getClientessearchFilter($objSalida->filtrar_clientes);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Clientes Filtradas');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function LocalidadCodigoPostal_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CPLoc=$this->get('CPLoc');			
		$data = $this->Clientes_model->get_LocalidadByCPLoc($CPLoc);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','GET',null,$this->input->ip_address(),'Cargando Listado de Localidades Por C??digo Postal');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
	}
/////////////////////////////////////////////////////////////////////////// PARA CLIENTES END //////////////////////////////////////

    ////////////////////////////////////// PARA LAS ACTIVIDADES CLIENTES START /////////////////////////////////////////////////
	public function all_actividades_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');		
		$data = $this->Clientes_model->get_activity_clientes();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','GET',null,$this->input->ip_address(),'Cargando Lista de Actividades');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function Buscar_CNAE_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodActCNAE=$this->get('CodActCNAE');				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->Buscar_CNAECod($CodActCNAE);
		if($consulta==false)
		{
			$this->response(false);
			return false;
		}

		$consulta->FechaServer=date('d/m/Y');							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CNAE','SEARCH',null,$this->input->ip_address(),'Buscando C??digo CNAE');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function Asignar_Actividad_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTActCli))
		{		
			$this->Clientes_model->actualizar_actividad($objSalida->id,$objSalida->CodCli,$objSalida->FecIniAct,$objSalida->CodTActCli);		
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CNAE','UPDATE',$objSalida->CodTActCli,$this->input->ip_address(),'Actualizando Actividad del Cliente');
		}
		else
		{			
			$comprobar_actividad=$this->Clientes_model->verificar_actividad($objSalida->id,$objSalida->CodCli);
			if($comprobar_actividad==true)
			{
				$this->response(false);	
				return false;
			}
			$id = $this->Clientes_model->agregar_actividad($objSalida->id,$objSalida->CodCli,$objSalida->FecIniAct);
			$objSalida->CodTActCli=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CNAE','INSERT',$objSalida->CodTActCli,$this->input->ip_address(),'Creando Actividad del Cliente');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function update_status_activity_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->update_actividad_cliente($objSalida->opcion,$objSalida->CodTActCli,$objSalida->CodCli);							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','UPDATE',$objSalida->CodCli,$this->input->ip_address(),'Cambiando Estatus de Actividad.');

		if($objSalida->opcion==2)
		{
			$CodBloAct=$this->Clientes_model->agregar_motivo_bloqueo_actividad($objSalida->CodCli,$objSalida->CodTActCli,$objSalida->FecBloAct,$objSalida->MotBloq,$objSalida->ObsBloAct);
			$objSalida->CodBloAct=$CodBloAct;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','INSERT',$CodBloAct,$this->input->ip_address(),'Agregando Motivo de Bloqueo de Actividad');
		}
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function Motivos_Bloqueos_Actividades_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Clientes_model->get_list_motivos_bloqueos_actividades();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',null,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos Actividades');
		if (empty($data)){
			$this->response(false);
			return false;
		}
		$arrayName = array('FechaServer' =>date('d/m/Y'), 'data'=>$data);		
		$this->response($arrayName);		
	}
	public function getActividadesFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getActividadesFilter($objSalida->filtrar_search);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Actividades Filtradas');
		$this->db->trans_complete();
		$this->response($consulta);
	}
    //////////////////////////////////////PARA LAS ACTIVIDADES CLIENTES END ///////////////////////////////////////////////////////


    //////////////////////////// PARA LOS Direcciones de SuministroS START ////////////////////////////////////////////////
	public function get_service_PuntoSuministros_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		
		$Tipo_Vias = $this->Clientes_model->get_list_tipos_vias();
		$Provincias = $this->Clientes_model->get_list_providencias();
		$Tipo_Inmuebles = $this->Clientes_model->get_list_tipo_inmuebles();
		$arrayName = array('Fecha_Server' =>date('d/m/Y'),'Tipo_Vias'=>$Tipo_Vias,'Provincias'=>$Provincias,'Tipo_Inmuebles'=>$Tipo_Inmuebles);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_VariasConsultas','GET',null,$this->input->ip_address(),'ServicePuntoSuministro');
		$this->response($arrayName);		
	}
	public function BuscarXIDPunSumData_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodPunSum=$this->get('CodPunSum');		
		$data = $this->Clientes_model->get_xID_puntos_suministros($CodPunSum);
		if (empty($data)){
			$this->response(false);
			return false;
		}
		$DatosCliente=$this->Clientes_model->get_data_cliente($data->CodCliPunSum);
		if($DatosCliente==false)
		{
			$DatosClienteResponse=false;
		}
		else
		{
			$DatosClienteResponse=$DatosCliente->NumCifCli;
		}
		$arrayName = array('data' =>$data , 'NumCifCli' =>$DatosClienteResponse);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',$CodPunSum,$this->input->ip_address(),'Cargando Informaci??n de la Direcci??n de Suministro');				
		$this->response($arrayName);		
	}
	public function get_all_puntos_sum_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		//$hcliente=$this->get('hcliente');		
		$data = $this->Clientes_model->get_puntos_suministros_clientes();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',null,$this->input->ip_address(),'Cargando listado de Direcciones de Suministro');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function buscar_direccion_Soc_Fis_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$Cliente=$this->get('Cliente');
		$TipRegDir=$this->get('TipRegDir');	

		if($TipRegDir==1)	
		{
			$variable="a.CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,a.CodLocSoc,b.CodPro as CodProSoc,a.CPLocSoc";
			$response = $this->Clientes_model->get_direccion_Soc_Fis($Cliente,$variable);
			$data=$response;
		}
		elseif($TipRegDir==2)
		{
			$variable="a.CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,a.CodLocFis,c.CodPro as CodProFis,a.CPLocFis";
			$response = $this->Clientes_model->get_direccion_Soc_Fis($Cliente,$variable);
			$data=$response;
		}	
		else
		{
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',null,$this->input->ip_address(),'Cargando Lista de Direcciones de Suministros');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function crear_punto_suministro_cliente_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		if (isset($objSalida->CodPunSum))
		{
			$this->Clientes_model->actualizar_punto_suministro_cliente($objSalida->CodPunSum,$objSalida->CodCliPunSum,$objSalida->TipRegDir,$objSalida->CodTipVia,$objSalida->NomViaPunSum,$objSalida->NumViaPunSum,$objSalida->BloPunSum,$objSalida->EscPunSum,$objSalida->PlaPunSum,$objSalida->PuePunSum,$objSalida->CodProPunSum,$objSalida->CodLocPunSum,$objSalida->CodTipInm,$objSalida->Aclarador,$objSalida->RefCasPunSum,$objSalida->DimPunSum,$objSalida->ObsPunSum,$objSalida->TelPunSum,$objSalida->CPLocSoc);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','UPDATE',$objSalida->CodPunSum,$this->input->ip_address(),'Actualizando Direcciones de Suministro del Cliiente.');
		}
		else
		{
			$CodPunSum=$this->Clientes_model->agregar_punto_suministro_cliente($objSalida->CodCliPunSum,$objSalida->TipRegDir,$objSalida->CodTipVia,$objSalida->NomViaPunSum,$objSalida->NumViaPunSum,$objSalida->BloPunSum,$objSalida->EscPunSum,$objSalida->PlaPunSum,$objSalida->PuePunSum,$objSalida->CodProPunSum,$objSalida->CodLocPunSum,$objSalida->CodTipInm,$objSalida->Aclarador,$objSalida->RefCasPunSum,$objSalida->DimPunSum,$objSalida->ObsPunSum,$objSalida->TelPunSum,$objSalida->CPLocSoc);
			$objSalida->CodPunSum=$CodPunSum;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','INSERT',$objSalida->CodPunSum,$this->input->ip_address(),'Creando Direcci??n de Suministro del Cliente.');
		}
		
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function Motivos_Bloqueos_PunSum_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Clientes_model->get_list_motivos_bloqueos_PunSum();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',null,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos Direcciones de Suministros');
		/*if (empty($data)){
			$this->response(false);
			return false;
		}*/
		$arrayName = array('FechaServer' =>date('d/m/Y') ,'data'=> $data);		
		$this->response($arrayName);		
	}
	public function bloquear_PunSum_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if($objSalida->opcion==4)
		{
			$this->Clientes_model->update_status_PumSum($objSalida->CodCli,$objSalida->CodPunSum,2);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','UPDATE',$objSalida->CodPunSum,$this->input->ip_address(),'Actualizando Estatus del Direcci??n de Suministros');
			$CodBloq=$this->Clientes_model->agregar_motivo_bloqueo_PunSum($objSalida->FecBloPun,$objSalida->CodPunSum,$objSalida->MotBloPunSum,$objSalida->ObsBloPunSum);			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoPunto','INSERT',$objSalida->CodPunSum,$this->input->ip_address(),'Agregando Bloqueo De Direcci??n de Suministro');
		}
		if($objSalida->opcion==5)
		{
			$this->Clientes_model->update_status_PumSum($objSalida->CodCli,$objSalida->CodPunSum,1);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','UPDATE',$objSalida->CodPunSum,$this->input->ip_address(),'Actualizando Estatus del Direcci??n de Suministros');
		}			
		$this->db->trans_complete();
		$this->response(true);
	}
	public function getPunSumFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getPunSumFilter($objSalida->filtrar_PumSum);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Puntos de Suministros Filtradas');
		$this->db->trans_complete();
		$this->response($consulta);
	}
    ////////////////////////////////////// PARA LOS Direcciones de SuministroS END ////////////////////////////////////////////////

	////////////////////////////////////// PARA CONTACTOS CLIENTES START ///////////////////////////////////////////////////

	public function lista_contactos_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		//$CodCli=$this->get('CodCli');		
		$data = $this->Clientes_model->get_lista_contactos();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',null,$this->input->ip_address(),'Cargando Lista Contactos Clientes');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function BuscarXIDContactos_Data_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodConCli=$this->get('CodConCli');	
		$select="a.CodConCli,a.CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.CPLocFis,a.CodLocFis,a.NomConCli,a.NIFConCli,a.DocNIF,a.ConPrin,a.NumColeCon,a.TelFijConCli,a.TelCelConCli,a.EmaConCli,a.CarConCli,a.ObsConC,a.EstConCli,d.CodPro as CodProFis";	
		$data = $this->Clientes_model->get_xID_Contactos($CodConCli,$select);        
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$CodConCli,$this->input->ip_address(),'Cargando Informaci??n del Contacto');
		if (empty($data)){
			$this->response(false);
			return false;
		}
		$data->Tabla_Contacto=false;
		$data->Tabla_Contacto=$this->Clientes_model->get_xID_ContactosDetalleNuevoMetodo($CodConCli);
		$this->response($data);		
	}
	public function search_contact_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$NIFConCli=$this->get('NIFConCli');
		$select="a.*";		
		$data = $this->Clientes_model->get_xID_Contactos_Otro_Cliente($NIFConCli,$select);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$NIFConCli,$this->input->ip_address(),'Cargando Informaci??n del Contacto');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function search_contact_Filter_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$NIFConCli=$this->get('NIFConCli');
		$CodCli=$this->get('CodCli');		
		$contactoCliente=$this->Propuesta_model->Funcion_Verificadora2($NIFConCli,'T_ContactoCliente','NIFConCli','*','CodCli',$CodCli);
		if (!empty($contactoCliente))
		{
			$contactoCliente->status=200;
			$this->response($contactoCliente);
			return false;
		}
		$select="a.*";		
		$data = $this->Clientes_model->get_xID_Contactos_Otro_Cliente_Limit($NIFConCli,$select);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$NIFConCli,$this->input->ip_address(),'Cargando Informaci??n del Contacto');
		if (empty($data)){
			$this->response(false);
			return false;
		}
		$data->CodConCli=null;
		$data->status=202;		
		$this->response($data);
	}
	public function comprobar_cif_contacto_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->comprobar_cif_contacto_existencia($objSalida->NIFConCli);							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de DNI/NIE');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function Registro_Contacto_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	
		if (isset($objSalida->CodConCli))
		{					
			$validar_contacto=$this->Clientes_model->validar_CIF_NIF_Existente_UPDATE($objSalida->CodConCli);
			if($objSalida->NIFConCli!=null)
			{
				if($objSalida->NIFConCli!=$validar_contacto->NIFConCli)
				{
					$validar_contacto1=$this->Clientes_model->validar_CIF_NIF_Existente_NuevoMetodo($objSalida->NIFConCli);
					if (!empty($validar_contacto1))
					{
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',null,$this->input->ip_address(),'N??mero de CIF ya Existe');
						$arrayName = array('status' =>400 ,'menssage'=>'Este n??mero de CIF Ya se encuentra registado','objSalida'=>$objSalida,'response'=>'Error CIF');
						$this->db->trans_complete();
						$this->response($arrayName);
					}
					else
					{
						$this->Clientes_model->actualizar_contactoNuevoMetodo($objSalida->CodConCli,$objSalida->NomConCli,$objSalida->NumColeCon,$objSalida->NIFConCli,$objSalida->CarConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->CodTipViaFis,$objSalida->NomViaDomFis,$objSalida->NumViaDomFis,$objSalida->CPLocFis,$objSalida->CodLocFis,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->ConPrin);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->CodConCli,$this->input->ip_address(),'Actualizando registro del Contrato');					
						$arrayName = array('status' =>200 ,'menssage'=>'Contacto modificado de forma correcta','objSalida'=>$objSalida,'response'=>'Exito');
					}
				}
				else
				{
					$this->Clientes_model->actualizar_contactoNuevoMetodo($objSalida->CodConCli,$objSalida->NomConCli,$objSalida->NumColeCon,$objSalida->NIFConCli,$objSalida->CarConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->CodTipViaFis,$objSalida->NomViaDomFis,$objSalida->NumViaDomFis,$objSalida->CPLocFis,$objSalida->CodLocFis,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->ConPrin);
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->CodConCli,$this->input->ip_address(),'Actualizando registro del Contrato');
					$arrayName = array('status' =>200 ,'menssage'=>'Contacto modificado de forma correcta','objSalida'=>$objSalida,'response'=>'Exito');
				}				
			}
			else
			{
				$this->Clientes_model->actualizar_contactoNuevoMetodo($objSalida->CodConCli,$objSalida->NomConCli,$objSalida->NumColeCon,$objSalida->NIFConCli,$objSalida->CarConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->CodTipViaFis,$objSalida->NomViaDomFis,$objSalida->NumViaDomFis,$objSalida->CPLocFis,$objSalida->CodLocFis,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->ConPrin);
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->CodConCli,$this->input->ip_address(),'Actualizando registro del Contrato');
				$arrayName = array('status' =>200 ,'menssage'=>'Contacto modificado de forma correcta','objSalida'=>$objSalida,'response'=>'UPDATE');				
			}
			$this->Clientes_model->EliminarDetalleNuevoMetodo($objSalida->CodConCli);
			if($objSalida-> Tabla_Contacto!=false)
			{
				foreach ($objSalida-> Tabla_Contacto as $key => $value): 
				{					
					$this->Clientes_model->agregar_contactoDetalleNuevoMetodo($objSalida->CodConCli,$value-> CodCli,$value-> EsRepLeg,$value-> TieFacEsc,$value-> EsPrescritor,$value-> EsColaborador,$value-> DocPod,$value-> CanMinRep,$value-> TipRepr);
				}
				endforeach;
			}

			$this->db->trans_complete();
			$this->response($arrayName);			
		}
		else
		{
			if($objSalida->NIFConCli!=null)
			{
				$validar_contacto=$this->Clientes_model->validar_CIF_NIF_Existente_NuevoMetodo($objSalida->NIFConCli);
				if(!empty($validar_contacto))
				{
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',null,$this->input->ip_address(),'N??mero de CIF ya se encuentra registrado');
					$arrayName = array('status' =>400 ,'menssage'=>'El N??mero de Documento Ya Se Encuentra Registrado.','objSalida'=>$objSalida,'response'=>'Error CIF');
					$this->db->trans_complete();
					$this->response($arrayName);
				}
				else
				{
					$id = $this->Clientes_model->agregar_contactoNuevoMetodo($objSalida->NomConCli,$objSalida->NumColeCon,$objSalida->NIFConCli,$objSalida->CarConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->CodTipViaFis,$objSalida->NomViaDomFis,$objSalida->NumViaDomFis,$objSalida->CPLocFis,$objSalida->CodLocFis,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->ConPrin);
					$objSalida->CodConCli=$id;	
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',$objSalida->CodConCli,$this->input->ip_address(),'Creando Contacto.');
					$arrayName = array('status' =>200 ,'menssage'=>'Contacto creado de forma correcta','response'=>'UPDATE','objSalida'=>$objSalida);				
				}

			}
			else
			{
				$id = $this->Clientes_model->agregar_contactoNuevoMetodo($objSalida->NomConCli,$objSalida->NumColeCon,$objSalida->NIFConCli,$objSalida->CarConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->CodTipViaFis,$objSalida->NomViaDomFis,$objSalida->NumViaDomFis,$objSalida->CPLocFis,$objSalida->CodLocFis,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->ConPrin);
				$objSalida->CodConCli=$id;	
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',$objSalida->CodConCli,$this->input->ip_address(),'Creando Contacto.');
				$arrayName = array('status' =>200 ,'menssage'=>'Contacto creado de forma correcta','response'=>'UPDATE','objSalida'=>$objSalida);				
			}
			$this->Clientes_model->EliminarDetalleNuevoMetodo($id);
			if($objSalida-> Tabla_Contacto!=false)
			{
				foreach ($objSalida-> Tabla_Contacto as $key => $value): 
				{					
					$this->Clientes_model->agregar_contactoDetalleNuevoMetodo($id,$value-> CodCli,$value-> EsRepLeg,$value-> TieFacEsc,$value-> EsPrescritor,$value-> EsColaborador,$value-> DocPod,$value-> CanMinRep,$value-> TipRepr);
				}
				endforeach;
			}
			$this->db->trans_complete();
			$this->response($arrayName);
		}		
	}
	public function cambiar_estatus_contactos_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->update_status_Contacto($objSalida->EstConCli,$objSalida->CodConCli);							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->CodConCli,$this->input->ip_address(),'Actualizando Estatus del Contacto.');

		if($objSalida->EstConCli==2)
		{
			$CodBloCont=$this->Clientes_model->agregar_motivo_bloqueo_T_contacto($objSalida->CodConCli,$objSalida->FechBlo,$objSalida->MotBloqcontacto,$objSalida->ObsBloContacto);
			$objSalida->CodBloCont=$CodBloCont;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoContacto','INSERT',$CodBloCont,$this->input->ip_address(),'Agregando Motivo de Bloqueo de Contacto.');
		}
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function list_motivos_bloqueos_contactos_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Clientes_model->get_all_list_contactos();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','GET',null,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos.');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}
		$fecha=date('d/m/Y');
		$arrayName = array('FechaServer' =>$fecha ,'MotivosContactos' =>$data );		
		$this->response($arrayName);		
	}
	public function getContactosFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getContactosFilter($objSalida->filtrar_search);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Contactos Filtrados');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function BuscarPorNombreoDni_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$this->db->trans_start();
		$metodo=$this->get('metodo');
		$InputText=$this->get('InputText');
		if($metodo==1)
		{	
			$response=$this->Clientes_model->getPorDnioNombre($InputText,'a.NomConCli');

		}
		elseif ($metodo==2) {
			$response=$this->Clientes_model->getPorDnioNombre($InputText,'a.NIFConCli');
		}
		else
		{
			$response=false;
		}
		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',null,$this->input->ip_address(),'Buscando Contacto');
		$this->db->trans_complete();
		$this->response($response);		
	}
	public function ValidarContactoPrincipal_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');
		$ConPri=$this->get('ConPri');			
		$data = $this->Clientes_model->Get_valida_contacto_principal($CodCli,$ConPri);        
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$CodCli,$this->input->ip_address(),'Comprobando Contacto Principal');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function UpdateOldContacto_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodConCli=$this->get('CodConCli');	
		$data = $this->Clientes_model->UpdateOldContacto($CodConCli);        
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$CodConCli,$this->input->ip_address(),'Quitando Contacto Como Principal');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function agregar_documento_contactoClientes_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$metodo=$_POST['metodo'];
		$this->load->helper("file");
		if($metodo==1 ||$metodo==2)
		{
			$config['upload_path']          = './documentos/';
			$config['allowed_types']        = '*';
			$config['encrypt_name']        = false;		
			
		}
		$this->load->library('upload', $config);
		$this->db->trans_start();
		$data = $this->upload->do_upload('file');
		if (!$data)
		{
			$error = array('status'=>0,'nombre'=>$this->upload->display_errors());	
			return 	$this->response($error);
		}
		else
		{
			$data = array($this->upload->data());
			$this->db->trans_complete();	
			$this->response(array('file_ext'=>$data[0]['file_ext'],'metodo'=>$metodo,'file_name'=>$data[0]['raw_name'],'DocName'=>'documentos/'.$data[0]['file_name'],'status' =>200,'statusText' =>'OK','menssage'=>'Archivo cargado correctamente.'));
		}		
	}

	////////////////////////////////////// PARA CONTACTOS CLIENTES END ////////////////////////////////////////////////////


	////////////////////////////////////// PARA CUENTAS BANCARIAS CLIENTES START ///////////////////////////////////////////////////
	public function get_cuentas_bancarias_cliente_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}				
		$data = $this->Clientes_model->get_all_Cuentas_Bancarias_clientes();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','GET',null,$this->input->ip_address(),'Cargando listado de Cuentas Bancarias del Cliente');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function BuscarXIDCuenta_Data_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCueBan=$this->get('CodCueBan');		
		$data = $this->Clientes_model->get_xID_CuentaBancaria($CodCueBan);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','GET',$CodCueBan,$this->input->ip_address(),'Cargando Informaci??n de la Cuenta Bancaria');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function Comprobar_Cuenta_Bancaria_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$result=$this->Clientes_model->buscar_NumIBan($objSalida->NumIBan,$objSalida->CodBan);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','SEARCH',null,$this->input->ip_address(),'Buscando N??mero IBAN');
		$this->db->trans_complete();
		$this->response($result);
	}
	public function crear_cuenta_bancaria_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		if (isset($objSalida->CodCueBan))
		{
			
			$this->Clientes_model->actualizar_numero_cuenta($objSalida->CodCueBan,$objSalida->CodCli,$objSalida->NumIBan,$objSalida->CodBan);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','UPDATE',$objSalida->CodCueBan,$this->input->ip_address(),'Actualizando N??mero de Cuenta Cliente');
		}
		else
		{
			$CodCueBan=$this->Clientes_model->agregar_numero_cuenta($objSalida->CodCli,$objSalida->NumIBan,$objSalida->CodBan);
			$objSalida->CodCueBan=$CodCueBan;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','INSERT',$objSalida->CodCueBan,$this->input->ip_address(),'Creando N??mero de Cuenta Cliente.');
		}
		
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function update_status_CueBan_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$result=$this->Clientes_model->update_status_CueBan($objSalida->CodCli,$objSalida->CodCueBan,$objSalida->EstCue);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','UPDATE',$objSalida->CodCueBan,$this->input->ip_address(),'Actualizando Estatus de la Cuenta Bancaria');			
		$this->db->trans_complete();
		$this->response($result);
	}
	public function getCuentasBancariasFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getCuentasBancariasFilter($objSalida->filtrar_search);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Contactos Filtrados');
		$this->db->trans_complete();
		$this->response($consulta);
	}


	
	////////////////////////////////////// PARA CUENTAS BANCARIAS CLIENTES END /////////////////////////////////////////////////////

	////////////////////////////////////// PARA DOCUMENTOS CLIENTES START ////////////////////////////////////////////////
	public function get_all_documentos_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Clientes_model->get_all_documentos();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','GET',null,$this->input->ip_address(),'Cargando listado de Documentos del Cliente');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
	}
	public function getDocumentosFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getDocumentosFilter($objSalida->filtrar_search);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Documentos Filtrados');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function Buscar_xID_Documentos_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTipDocAI=$this->get('CodTipDocAI');		
		$data = $this->Clientes_model->get_xID_Documentos($CodTipDocAI);        
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','GET',$CodTipDocAI,$this->input->ip_address(),'Cargando Informaci??n del Documento');
		if (empty($data)){
			$this->response(false);
			return false;
		}	
		$DatosCliente = $this->Clientes_model->get_data_cliente($data->CodCli);
		$data->NumCifCli=$DatosCliente->NumCifCli;	
		$this->response($data);		
	}
	public function Registrar_Documentos_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTipDocAI))
		{		
			$this->Clientes_model->actualizar_documentos($objSalida->CodTipDocAI,$objSalida->CodCli,$objSalida->CodTipDoc,$objSalida->DesDoc,$objSalida->ArcDoc,$objSalida->TieVen,$objSalida->FecVenDocAco,$objSalida->ObsDoc);		
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','UPDATE',$objSalida->CodTipDocAI,$this->input->ip_address(),'Actualizando Documentos');
		}
		else
		{
			$id = $this->Clientes_model->agregar_documentos($objSalida->CodCli,$objSalida->CodTipDoc,$objSalida->DesDoc,$objSalida->ArcDoc,$objSalida->TieVen,$objSalida->FecVenDocAco,$objSalida->ObsDoc);
			$objSalida->CodTipDocAI=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','INSERT',$objSalida->CodTipDocAI,$this->input->ip_address(),'Creando Documentos.');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
	}	
	////////////////////////////////////// PARA DOCUMENTOS CLIENTES END ////////////////////////////////////////////////////////



}
?>