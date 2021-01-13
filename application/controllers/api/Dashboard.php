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
		$this->load->model('Dashboard_model');
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
		$PrimeraLetra = substr($objSalida->searchText, 0,2);
		if($PrimeraLetra=="ES" || $PrimeraLetra=='es')
		{
			$consulta1=$this->Clientes_model->getporcups($objSalida->searchText);
			$detalleFinal = Array();
			foreach ($consulta1 as $key => $value):
			{
				$detalleG = $this->Clientes_model->getDataClientesCUPs($value->CodCli);
				array_push($detalleFinal, $detalleG);
			}
			endforeach;
			$consulta=$detalleFinal;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Busqueda de Clientes Para Dashboard Por CUPs');	
		}
		else
		{
			$consulta=$this->Clientes_model->getclientessearch($objSalida->searchText);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Busqueda de Clientes Para Dashboard Normal');
		}
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
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidades','GET',null,$this->input->ip_address(),'Cargando Provincias');
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
    public function DirCliente_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}  
		$CodCli=$this->get('CodCli');
		$Response= $this->Dashboard_model->get_data_cliente($CodCli);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$CodCli,$this->input->ip_address(),'Cargando Dirección del Cliente para Dashboard');  
		$this->response($Response);		
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
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localidad','GET',null,$this->input->ip_address(),'Cargando Listado de Localidades Por Código Postal');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
	}
    public function comprobar_cif_contacto_Cliente_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		//$objSalida = json_decode(file_get_contents("php://input"));

		$this->db->trans_start();
		$CodCli=$this->get('CodCli');
		$NIFConCli=$this->get('NIFConCli');
		$consulta=$this->Clientes_model->comprobar_cif_contacto_existencia($NIFConCli);							
		if($consulta!=false)
		{	
			foreach ($consulta as $key => $value):
			{
				if($value-> CodCli==$CodCli)
				{
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$value-> CodConCli,$this->input->ip_address(),'DNI/NIE/CIF ya se encuentra asignado a este cliente.');
					$this->db->trans_complete();
					$this->response(array('status' =>202 ,'menssage' =>'El número de DNI/NIE/CIF ya se encuentra registrado y asignado a este cliente','statusText'=>'Error'  ));
					return false;
				}
				else
				{
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$value-> CodConCli,$this->input->ip_address(),'Se Encontro DNI/NIE/CIF para asignar a cliente .');
					$this->db->trans_complete();
					$this->response(array('status' =>200 ,'menssage' =>$value,'statusText'=>'OK'));
				}	
			}
			endforeach;
		}
		else
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',null,$this->input->ip_address(),'No Se Encontro DNI/NIE/CIF. se puede registrar');
			$this->db->trans_complete();
			$this->response(array('status' =>201 ,'menssage' =>'Registrar Contacto','statusText'=>'OK'));
		}
	}
	public function agregar_documento_dashboard_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$metodo=$_POST['metodo'];
		$this->load->helper("file");
		if($metodo==1 ||$metodo==2 || $metodo==4)
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
			$this->response(array('file_ext'=>$data[0]['file_ext'],'metodo'=>$metodo,'file_name'=>$data[0]['raw_name'],'DocNIF'=>'documentos/'.$data[0]['file_name'],'status' =>200,'statusText' =>'OK','menssage'=>'Archivo cargado correctamente.'));
		}		
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
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$CodCli,$this->input->ip_address(),'Comprobando Contacto Principal del Cliente');
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
			if($objSalida->CodCli!=$validar_contacto->CodCli && $objSalida->NIFConCli==$validar_contacto->NIFConCli)
			{
				$validar_contacto1=$this->Clientes_model->validar_CIF_NIF_Existente($objSalida->NIFConCli,$objSalida->CodCli);
				if (!empty($validar_contacto1))
				{
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',null,$this->input->ip_address(),'El Contacto ya se encuentra asignado');
					$arrayName = array('status' =>false ,'menssage'=>'El número de documento ya se encuentra asignado a este Cliente','objSalida'=>$objSalida,'response'=>false);
					$this->db->trans_complete();
					$this->response($arrayName);
				}
				else
				{
					$this->Clientes_model->actualizar_contacto($objSalida->CodConCli,$objSalida->NIFConCli,$objSalida->EsRepLeg,$objSalida->TieFacEsc,$objSalida->CanMinRep,$objSalida->CodCli,$objSalida->CodTipCon,$objSalida->CarConCli,$objSalida->NomConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->TipRepr,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->DocPod,$objSalida->NumColeCon,$objSalida->ConPrin);
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->CodConCli,$this->input->ip_address(),'Actualizando registro del Contrato');
					$updateDirCli=$this->Clientes_model->actualizar_DirCLi($objSalida->CodCli,$objSalida->CodTipViaSoc,$objSalida->NomViaDomSoc,$objSalida->NumViaDomSoc,$objSalida->BloDomSoc,$objSalida->EscDomSoc,$objSalida->PlaDomSoc,$objSalida->PueDomSoc,$objSalida->CodLocSoc,$objSalida->CPLocSoc);
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','UPDATE',$objSalida->CodCli,$this->input->ip_address(),'Actualizando Dirección del Cliente desde Contactos');
					$arrayName = array('status' =>true ,'menssage'=>'Contacto modificado de forma correcta','objSalida'=>$objSalida,'response'=>true);
					
					$this->db->trans_complete();
					$this->response($arrayName);				
				}
			}
			else
			{
				$this->Clientes_model->actualizar_contacto($objSalida->CodConCli,$objSalida->NIFConCli,$objSalida->EsRepLeg,$objSalida->TieFacEsc,$objSalida->CanMinRep,$objSalida->CodCli,$objSalida->CodTipCon,$objSalida->CarConCli,$objSalida->NomConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->TipRepr,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->DocPod,$objSalida->NumColeCon,$objSalida->ConPrin);
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','UPDATE',$objSalida->CodConCli,$this->input->ip_address(),'Actualizando registro del Contrato Desde Dashboard');
				$updateDirCli=$this->Clientes_model->actualizar_DirCLi($objSalida->CodCli,$objSalida->CodTipViaSoc,$objSalida->NomViaDomSoc,$objSalida->NumViaDomSoc,$objSalida->BloDomSoc,$objSalida->EscDomSoc,$objSalida->PlaDomSoc,$objSalida->PueDomSoc,$objSalida->CodLocSoc,$objSalida->CPLocSoc);
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','UPDATE',$objSalida->CodCli,$this->input->ip_address(),'Actualizando Dirección del Cliente Desde Dashboard');
				$arrayName = array('status' =>true ,'menssage'=>'Contacto modificado de forma correcta','objSalida'=>$objSalida,'response'=>true);
				$this->db->trans_complete();
				$this->response($arrayName);
			}			
		}
		else
		{
			$validar_contacto=$this->Clientes_model->validar_CIF_NIF_Existente($objSalida->NIFConCli,$objSalida->CodCli);
			if (!empty($validar_contacto))
			{
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',null,$this->input->ip_address(),'El Contacto ya se encuentra asignado');
				$arrayName = array('status' =>false ,'menssage'=>'El Número de Documento Ya Se Encuentra Registrado y Asignado ha Este Cliente.','objSalida'=>$objSalida,'response'=>false);
				$this->db->trans_complete();
				$this->response($arrayName);
			}
			else
			{
				$id = $this->Clientes_model->agregar_contacto($objSalida->NIFConCli,$objSalida->EsRepLeg,$objSalida->TieFacEsc,$objSalida->CanMinRep,$objSalida->CodCli,$objSalida->CodTipCon,$objSalida->CarConCli,$objSalida->NomConCli,$objSalida->TelFijConCli,$objSalida->TelCelConCli,$objSalida->EmaConCli,$objSalida->TipRepr,$objSalida->DocNIF,$objSalida->ObsConC,$objSalida->DocPod,$objSalida->NumColeCon,$objSalida->ConPrin);
				$objSalida->CodConCli=$id;	
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','INSERT',$objSalida->CodConCli,$this->input->ip_address(),'Creando Contacto.');	
				$updateDirCli=$this->Clientes_model->actualizar_DirCLi($objSalida->CodCli,$objSalida->CodTipViaSoc,$objSalida->NomViaDomSoc,$objSalida->NumViaDomSoc,$objSalida->BloDomSoc,$objSalida->EscDomSoc,$objSalida->PlaDomSoc,$objSalida->PueDomSoc,$objSalida->CodLocSoc,$objSalida->CPLocSoc);
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','UPDATE',$objSalida->CodCli,$this->input->ip_address(),'Actualizando Dirección del Cliente Desde Dashboard');
				$arrayName = array('status' =>true ,'menssage'=>'Contacto creado de forma correcta','response'=>true,'objSalida'=>$objSalida);
				$this->db->trans_complete();
				$this->response($arrayName);	
			}		
		}		
	}
	////////////////////////////////////// PARA CONTACTOS CLIENTES END ////////////////////////////////////////////////////////

	
	////////////////////////////////////// PARA CUPS CLIENTES START ////////////////////////////////////////////////////////
	
	////////////////////////////////////// PARA CUPS CLIENTES END ////////////////////////////////////////////////////////



	////////////////////////////////////// PARA CUENTAS BANCRIAS CLIENTES START ////////////////////////////////////////////////////////
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
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','SEARCH',null,$this->input->ip_address(),'Buscando Número IBAN');
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
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','UPDATE',$objSalida->CodCueBan,$this->input->ip_address(),'Actualizando Número de Cuenta Cliente');
		}
		else
		{
			$CodCueBan=$this->Clientes_model->agregar_numero_cuenta($objSalida->CodCli,$objSalida->NumIBan,$objSalida->CodBan);
			$objSalida->CodCueBan=$CodCueBan;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','INSERT',$objSalida->CodCueBan,$this->input->ip_address(),'Creando Número de Cuenta Cliente.');
		}
		
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	////////////////////////////////////// PARA CUENTAS BANCRIAS CLIENTES END ////////////////////////////////////////////////////////


	////////////////////////////////////// PARA DOCUMENTOS CLIENTES START ////////////////////////////////////////////////////////
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
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','UPDATE',$objSalida->CodTipDocAI,$this->input->ip_address(),'Actualizando Documentos Desde Dashboard');
		}
		else
		{
			$id = $this->Clientes_model->agregar_documentos($objSalida->CodCli,$objSalida->CodTipDoc,$objSalida->DesDoc,$objSalida->ArcDoc,$objSalida->TieVen,$objSalida->FecVenDocAco,$objSalida->ObsDoc);
			$objSalida->CodTipDocAI=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','INSERT',$objSalida->CodTipDocAI,$this->input->ip_address(),'Creando Documentos Desde Dashboard.');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
	}	
	////////////////////////////////////// PARA DOCUMENTOS CLIENTES END ////////////////////////////////////////////////////////

}
?>