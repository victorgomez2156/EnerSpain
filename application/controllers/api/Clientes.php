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
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    public function Motivos_Bloqueos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_motivos_bloqueos();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function Motivos_Bloqueos_PunSum_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_motivos_bloqueos_PunSum();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos Puntos de Suministros');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function Motivos_Bloqueos_Actividades_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_motivos_bloqueos_actividades();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de BLoqueos Actividades');
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
        $data = $this->Clientes_model->get_list_tipos_vias();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoVias','GET',0,$this->input->ip_address(),'Cargando Lista de Tipos Vias');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function get_sector_cliente_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_sector_cliente();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',0,$this->input->ip_address(),'Cargando Lista de Sectores');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_colaboradores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_colaboradores();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'Cargando Lista de Colaboradores');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function Consulta_Fecha_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        	$fecha=date('Y/m/d');
		$this->response($fecha);		
    }
    public function list_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_clientes();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',0,$this->input->ip_address(),'Cargando Lista de Clientes');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_all_tipo_inmueble_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_tipo_inmuebles();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoInmueble','GET',0,$this->input->ip_address(),'Cargando Lista de Inmuebles');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
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
			$this->Clientes_model->actualizar($objSalida->CodCli,$objSalida->BloDomFis,$objSalida->BloDomSoc,$objSalida->CodCol,$objSalida->CodCom,$objSalida->CodLocFis,$objSalida->CodLocSoc,$objSalida->CodProFis,$objSalida->CodProSoc,$objSalida->CodSecCli,$objSalida->CodTipCli,$objSalida->CodTipViaFis,$objSalida->CodTipViaSoc,$objSalida->EmaCli,$objSalida->EscDomFis,$objSalida->EscDomSoc,$objSalida->NomComCli,$objSalida->NomViaDomFis,$objSalida->NomViaDomSoc,$objSalida->NumViaDomFis,$objSalida->NumViaDomSoc,$objSalida->ObsCli,$objSalida->PlaDomFis,$objSalida->PlaDomSoc,$objSalida->PueDomFis,$objSalida->PueDomSoc,$objSalida->RazSocCli,$objSalida->TelFijCli,$objSalida->WebCli);		
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','UPDATE',$objSalida->CodCli,$this->input->ip_address(),'Actualizando Datos Del Clientes');
		}
		else
		{
			$id = $this->Clientes_model->agregar($objSalida->BloDomFis,$objSalida->BloDomSoc,$objSalida->CodCol,$objSalida->CodCom,$objSalida->CodLocFis,$objSalida->CodLocSoc,$objSalida->CodProFis,$objSalida->CodProSoc,$objSalida->CodSecCli,$objSalida->CodTipCli,$objSalida->CodTipViaFis,$objSalida->CodTipViaSoc,$objSalida->EmaCli,$objSalida->EscDomFis,$objSalida->EscDomSoc,$objSalida->FecIniCli,$objSalida->NomComCli,$objSalida->NomViaDomFis,$objSalida->NomViaDomSoc,$objSalida->NumCifCli,$objSalida->NumViaDomFis,$objSalida->NumViaDomSoc,$objSalida->ObsCli,$objSalida->PlaDomFis,$objSalida->PlaDomSoc,$objSalida->PueDomFis,$objSalida->PueDomSoc,$objSalida->RazSocCli,$objSalida->TelFijCli,$objSalida->WebCli);
			$objSalida->CodCli=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','INSERT',$objSalida->CodCli,$this->input->ip_address(),'Creando Registro de Clientes');			
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
		$huser=$this->get('huser');		
        $data = $this->Clientes_model->get_clientes_data($huser);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$huser,$this->input->ip_address(),'Consultando datos del Cliente');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}
		$buscar_actividades=$this->Clientes_model->get_activity_clientes($huser);
		$data->activity_clientes=$buscar_actividades;
		$tActividadesEconomicas=$this->Clientes_model->get_all_activity_clientes();		
		$data->tActividadesEconomicas=$tActividadesEconomicas;
		$tPuntosSuminitros=$this->Clientes_model->get_all_Puntos_Suministros_clientes($huser);		
		$data->tPuntosSuminitros=$tPuntosSuminitros;
		$tCuentasBancarias=$this->Clientes_model->get_all_Cuentas_Bancarias_clientes($huser);		
		$data->tCuentasBancarias=$tCuentasBancarias;
		$this->response($data);		
    }
     public function borrar_row_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$hcliente=$this->get('hcliente');
        $data = $this->Clientes_model->borrar_clientes_data($hcliente);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','DELETE',$hcliente,$this->input->ip_address(),'Borrando Cliente.');		
    }
     public function get_providencias_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_providencias();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Provincia','GET',0,$this->input->ip_address(),'Cargando Lista de Providencias');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_localidad_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_localidades();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Localodad','GET',0,$this->input->ip_address(),'Cargando Lista de Localidades');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_all_bancos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_bancos();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Banco','GET',0,$this->input->ip_address(),'Cargando Lista de Bancos');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_tipo_cliente_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_tipo_Cliente();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',0,$this->input->ip_address(),'Cargando Lista de Tipo Clientes');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function get_Comerciales_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Clientes_model->get_list_comerciales();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',0,$this->input->ip_address(),'Cargando Lista Comercial');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function comprobar_cif_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->comprobar_cif_existencia($objSalida->NumCifCli);							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',0,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($consulta);
    }
    public function buscar_datos_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$NumCifCli=$this->get('NumCifCli');		
        $data = $this->Clientes_model->get_data_clientes($NumCifCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',0,$this->input->ip_address(),'Cargando Datos del Cliente');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
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
		$this->Clientes_model->update_status_cliente($objSalida->opcion,$objSalida->hcliente);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','UPDATE',$objSalida->opcion,$this->input->ip_address(),'Actualizando Estatus del Cliente a Activo');
		if($objSalida->opcion==4)
		{
			$CodBloq=$this->Clientes_model->agregar_motivo_bloqueo($objSalida->hcliente,date('Y-m-d'),$objSalida->CodMotBloCli,$objSalida->ObsBloCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoCliente','INSERT',$CodBloq,$this->input->ip_address(),'Actualizando Estatus del Cliente a Activo');
		}		
		$this->db->trans_complete();
		$this->response(true);
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
    public function bloquear_PunSum_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$this->Clientes_model->update_status_PumSum($objSalida->CodCli,$objSalida->CodPunSum,$objSalida->opcion);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','UPDATE',$objSalida->CodPunSum,$this->input->ip_address(),'Actualizando Estatus del Punto de Suministros');
		


		
		if($objSalida->opcion==2)
		{
			$CodBloq=$this->Clientes_model->agregar_motivo_bloqueo_PunSum(date('Y-m-d'),$objSalida->CodPunSum,$objSalida->MotBloPunSum,$objSalida->ObsPunSum);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','INSERT',$objSalida->CodPunSum,$this->input->ip_address(),'Agregando Motivo De Bloqueo De Punto de Suministro');
		}		
		$this->db->trans_complete();
		$this->response(true);
    }
    public function asignar_actividad_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->asignar_actividad_cliente($objSalida->CodCli,$objSalida->CodActEco,$objSalida->FecIniAct);							
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','INSERT',$objSalida->CodCli,$this->input->ip_address(),'Agregando actividad al cliente.');
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
			$CodBloAct=$this->Clientes_model->agregar_motivo_bloqueo_actividad($objSalida->CodCli,$objSalida->CodActEco,date('Y-m-d'),$objSalida->MotBloq,$objSalida->ObsBloAct);
			$objSalida->CodBloAct=$CodBloAct;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','INSERT',$CodBloAct,$this->input->ip_address(),'Agregando Motivo de Bloqueo de Actividad');
		}
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function all_actividades_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');		
        $data = $this->Clientes_model->get_activity_clientes($CodCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','GET',0,$this->input->ip_address(),'Cargando Lista de Actividades');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }

    //// PUNTOS DE SUMINISTROS CLIENTES///////////
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
			
			$this->Clientes_model->actualizar_punto_suministro_cliente($objSalida->CodPunSum,$objSalida->BloPunSum,$objSalida->CodCli,$objSalida->CodLocPunSum,$objSalida->CodTipInm,$objSalida->CodTipVia,$objSalida->DimPunSum,$objSalida->EscPunSum,$objSalida->NomViaPunSum,$objSalida->NumViaPunSum,$objSalida->ObsPunSum,$objSalida->PlaPunSum,$objSalida->PuePunSum,$objSalida->RefCasPunSum,$objSalida->TelPunSum,$objSalida->TipRegDir);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','UPDATE',$objSalida->CodPunSum,$this->input->ip_address(),'Actualizando Puntos de Suministro del Cliiente.');
		}
		else
		{
			$CodPunSum=$this->Clientes_model->agregar_punto_suministro_cliente($objSalida->BloPunSum,$objSalida->CodCli,$objSalida->CodLocPunSum,$objSalida->CodTipInm,$objSalida->CodTipVia,$objSalida->DimPunSum,$objSalida->EscPunSum,$objSalida->NomViaPunSum,$objSalida->NumViaPunSum,$objSalida->ObsPunSum,$objSalida->PlaPunSum,$objSalida->PuePunSum,$objSalida->RefCasPunSum,$objSalida->TelPunSum,$objSalida->TipRegDir);
			$objSalida->CodPunSum=$CodPunSum;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','INSERT',$objSalida->CodPunSum,$this->input->ip_address(),'Creando Punto de Suministro del Cliente.');
		}
		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function get_all_puntos_sum_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$hcliente=$this->get('hcliente');		
        $data = $this->Clientes_model->get_all_Puntos_Suministros_clientes($hcliente);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',0,$this->input->ip_address(),'Cargando Lista de Puntos de Suministros');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
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
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','SEARCH',0,$this->input->ip_address(),'Buscando Número IBAN.');
		$this->db->trans_complete();
		$this->response($result);
    }
     public function get_cuentas_bancarias_cliente_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');		
        $data = $this->Clientes_model->get_all_Cuentas_Bancarias_clientes($CodCli);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','GET',0,$this->input->ip_address(),'Cargando Lista Cuenta Bancarias del Cliente');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    
	
}
?>