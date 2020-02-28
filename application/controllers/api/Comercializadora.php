<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Comercializadora extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Comercializadora_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }

    ////////////////////////////////////////////////////////////////////////COMERCIALIZADORAS START ////////////////////////////////////////////////////////////////////
     public function get_list_comercializadora_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}			
        $data = $this->Comercializadora_model->get_list_comercializadora();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'Cargando Listado de Comercializadoras');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function get_all_functions_comercializadora_get()
    { 
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $Provincias = $this->Comercializadora_model->get_list_providencias();
        $Localidades = $this->Comercializadora_model->get_list_localidad();
        $Tipos_Vias = $this->Comercializadora_model->get_list_tipos_vias();
        $Comercializadora = $this->Comercializadora_model->get_list_comercializadora();
        $Productos = $this->Comercializadora_model->get_list_productos();
        $Anexos = $this->Comercializadora_model->get_list_anexos();
        $Servicios_Especiales = $this->Comercializadora_model->get_list_servicos_especiales();
        $ComAct = $this->Comercializadora_model->get_list_ComAct();
       	$ProAct = $this->Comercializadora_model->get_list_ProAct();
       	$TioCom = $this->Comercializadora_model->get_list_TipCom();
       	$Tarifa_Gas= $this->Comercializadora_model->get_list_tarifa_Gas();
       	$Tarifa_Ele= $this->Comercializadora_model->list_tarifa_electricas();
       	$fecha=date('d/m/Y');

        $data=array('Provincias'=>$Provincias,'Localidades'=>$Localidades,'Tipos_Vias'=>$Tipos_Vias,'Comercializadora'=>$Comercializadora,'Productos'=>$Productos,'Anexos'=>$Anexos,'Servicios_Especiales'=>$Servicios_Especiales,'TProComercializadoras' =>$ComAct,'TProductosActivos' =>$ProAct,'Tipos_Comision' =>$TioCom,'Tarifa_Gas' =>$Tarifa_Gas,'Tarifa_Ele' =>$Tarifa_Ele,'fecha' =>$fecha);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_V_T','GET',0,$this->input->ip_address(),'Cargando Array de Consultas.');
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
			$this->Comercializadora_model->actualizar_comercializadora($objSalida->CodCom,$objSalida->BloDirCom,$objSalida->CarConCom,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->DurConCom,$objSalida->EmaCom,$objSalida->EscDirCom,$objSalida->FecConCom,$objSalida->FecVenConCom,$objSalida->NomComCom,$objSalida->NomConCom,$objSalida->NomViaDirCom,$objSalida->NumCifCom,$objSalida->NumViaDirCom,$objSalida->ObsCom,$objSalida->PagWebCom,$objSalida->PlaDirCom,$objSalida->PueDirCom,$objSalida->RazSocCom,$objSalida->RenAutConCom,$objSalida->SerEle,$objSalida->SerEsp,$objSalida->SerGas,$objSalida->TelFijCom,$objSalida->DocConCom,$objSalida->FecIniCom,$objSalida->ZonPos);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','UPDATE',$objSalida->CodCom,$this->input->ip_address(),'Actualizando Comercializadora');
		}
		else
		{
			$id = $this->Comercializadora_model->agregar_comercializadora($objSalida->BloDirCom,$objSalida->CarConCom,$objSalida->CodLoc,$objSalida->CodTipVia,$objSalida->DurConCom,$objSalida->EmaCom,$objSalida->EscDirCom,$objSalida->FecConCom,$objSalida->FecVenConCom,$objSalida->NomComCom,$objSalida->NomConCom,$objSalida->NomViaDirCom,$objSalida->NumCifCom,$objSalida->NumViaDirCom,$objSalida->ObsCom,$objSalida->PagWebCom,$objSalida->PlaDirCom,$objSalida->PueDirCom,$objSalida->RazSocCom,$objSalida->RenAutConCom,$objSalida->SerEle,$objSalida->SerEsp,$objSalida->SerGas,$objSalida->TelFijCom,$objSalida->FecIniCom,$objSalida->DocConCom,$objSalida->ZonPos);		
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
        $data = $this->Comercializadora_model->get_CodCom($CodCom);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',$CodCom,$this->input->ip_address(),'Consultando Datos de la Comercializadora');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function comprobar_cif_comercializadora_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$result = $this->Comercializadora_model->consultar_cif_comercializadora($objSalida->NumCifCom);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'Comprobando CIF Comercializadora');	
		$this->db->trans_complete();
		$this->response($result);
    }
    public function list_MotBloCom_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Comercializadora_model->get_list_MotBloCom();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de Bloqueos Comercializadora');
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
		$resultado = $this->Comercializadora_model->update_status_comercializadora($objSalida->CodCom,$objSalida->EstCom);
		


		if($objSalida->EstCom==2)
		{
			
			$CodBloCom=$this->Comercializadora_model->agregar_bloqueo_Com($objSalida->CodCom,$objSalida->FecBlo,$objSalida->MotBloq,$objSalida->ObsBloCom);
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
        $data = $this->Comercializadora_model->delete_comercializadora($CodCom);
		if (empty($data))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','DELETE',$CodCom,$this->input->ip_address(),'Borrando Comercializadora Fallido.');
			$this->response(false);
			return false;
		}		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','DELETE',$CodCom,$this->input->ip_address(),'Borrando Comercializadora.');
		$this->response($data);
				
    }
    //////////////////////////////////////////////////////////////////////// COMERCIALIZADORAS END ////////////////////////////////////////////////////////////////////
    

    //////////////////////////////////////////////////////////////////////// PRODUCTOS START ////////////////////////////////////////////////////////////////////
	
public function get_list_productos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	//$CodCom=$this->get('CodCom');
    $data = $this->Comercializadora_model->get_list_productos();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','GET',null,$this->input->ip_address(),'Cargando Lista de Productos Por Comercializadora.');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}		
	$this->response($data);		
}
public function Buscar_xID_Productos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$CodPro=$this->get('CodPro');
    $data = $this->Comercializadora_model->get_all_data_productos($CodPro);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','GET',$CodPro,$this->input->ip_address(),'Buscando Datos Con el ID del Producto.');
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
			$this->Comercializadora_model->actualizar_productos($objSalida->CodTPro,$objSalida->CodTProCom,$objSalida->DesPro,$objSalida->CodTProCom,$objSalida->SerGas,$objSalida->SerEle,$objSalida->ObsPro,$objSalida->FecIniPro);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','UPDATE',$objSalida->CodTPro,$this->input->ip_address(),'Actualizando Productos.');	
		}
		else
		{			
			$id = $this->Comercializadora_model->agregar_productos($objSalida->CodTProCom,$objSalida->DesPro,$objSalida->CodTProCom,$objSalida->SerGas,$objSalida->SerEle,$objSalida->ObsPro,$objSalida->FecIniPro);		
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
		$resultado = $this->Comercializadora_model->update_status_productos($objSalida->CodPro,$objSalida->EstPro);
		if($objSalida->EstPro==2)
		{
			$CodMotBloPro=$this->Comercializadora_model->agregar_bloqueo_productos($objSalida->CodPro,$objSalida->FecBlo,$objSalida->MotBloqPro,$objSalida->ObsBloPro);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_BloqueoProducto','INSERT',$CodMotBloPro,$this->input->ip_address(),'Bloqueo de Producto.');
		}
		$objSalida->resultado=$resultado;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','UPDATE',$objSalida->CodPro,$this->input->ip_address(),'Actualizando Estatus de la Comercializadora');		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
//////////////////////////////////////////////////////////////////////// PRODUCTOS END ////////////////////////////////////////////////////////////


    
///////////////////////////////////////////PARA LOS ANEXOS START////////////////////////////////////////////////////////////////////////////////////
public function get_list_anexos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	//$CodCom=$this->get('CodCom');
    $data = $this->Comercializadora_model->get_list_anexos();
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
		$this->Comercializadora_model->eliminar_detalles_anexos($objSalida->CodAnePro);
		$this->Comercializadora_model->actualizar_anexos($objSalida->CodAnePro,$objSalida->CodPro,$objSalida->DesAnePro,$objSalida->SerGas,$objSalida->SerEle,$objSalida->DocAnePro,$objSalida->ObsAnePro,$objSalida->CodTipCom,0,$TipPre,$objSalida->FecIniAneA);
		if($T_DetalleAnexoTarifaGas!=false)
		{
			foreach ($T_DetalleAnexoTarifaGas as $T_DetalleAnexoTarifaGas => $record_Tarifa_Gas):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_gas($objSalida->CodAnePro,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecBaj!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecBaj as $T_DetalleAnexoTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Baja($objSalida->CodAnePro,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecAlt!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecAlt as $T_DetalleAnexoTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Alta($objSalida->CodAnePro,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','UPDATE',$objSalida->CodAnePro,$this->input->ip_address(),'Actualizando Productos.');	
	}
	else
	{			
		$id = $this->Comercializadora_model->agregar_anexos($objSalida->CodPro,$objSalida->DesAnePro,$objSalida->SerGas,$objSalida->SerEle,$objSalida->DocAnePro,$objSalida->ObsAnePro,$objSalida->FecIniAneA,$objSalida->CodTipCom,0,1,$TipPre);		
			$objSalida->CodAnePro=$id;
		if($T_DetalleAnexoTarifaGas!=false)
		{
			foreach ($T_DetalleAnexoTarifaGas as $T_DetalleAnexoTarifaGas => $record_Tarifa_Gas):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_gas($objSalida->CodAnePro,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecBaj!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecBaj as $T_DetalleAnexoTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Baja($objSalida->CodAnePro,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleAnexoTarifaElecAlt!=false)
		{
			foreach ($T_DetalleAnexoTarifaElecAlt as $T_DetalleAnexoTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Alta($objSalida->CodAnePro,$record_Tarifa_Elec_Alta->CodTarEle);
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
    $data_anexos = $this->Comercializadora_model->get_anexos_data($CodAnePro);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','GET',$CodAnePro,$this->input->ip_address(),'Buscando Anexos Por CodAnePro');
	if (empty($data_anexos))
	{
		$this->response(false);
		return false;
	}	

	if($data_anexos->SerGas==1)
	{
		$data_detalle_tarifa_gas = $this->Comercializadora_model->get_detalle_tarifa_gas($CodAnePro);
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
    	$detalleG = $this->Comercializadora_model->obtener_detalle_tarifa_electrica($CodAnePro);
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
		$resultado = $this->Comercializadora_model->update_status_anexos($objSalida->CodAnePro,$objSalida->EstAne);
		


		if($objSalida->EstAne==2)
		{
			$CodMotBloPro=$this->Comercializadora_model->agregar_bloqueo_anexos($objSalida->CodAnePro,$objSalida->FecBlo,$objSalida->MotBloAne,$objSalida->ObsMotBloAne);
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
    $data = $this->Comercializadora_model->get_list_servicos_especiales();
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
		$this->Comercializadora_model->eliminar_detalles_servicios_especiales($objSalida->CodSerEsp);
		$this->Comercializadora_model->actualizar_servicio_especial($objSalida->CodSerEsp,$objSalida->CodCom,$objSalida->DesSerEsp,$TipSumSerEsp,$objSalida->TipCli,$objSalida->CarSerEsp,$objSalida->CodTipCom,$objSalida->OsbSerEsp,$objSalida->FecIniSerEspForm);		
		if($T_DetalleServicioEspecialTarifaElecBaj!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecBaj as $T_DetalleServicioEspecialTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Baja_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleServicioEspecialTarifaElecAlt!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecAlt as $T_DetalleServicioEspecialTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Alta_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleServicioEspecialTarifaGas!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaGas as $T_DetalleServicioEspecialTarifaGas => $record_Tarifa_Gas):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_gas_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Gas->CodTarGas);
			}
			endforeach;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','UPDATE',$objSalida->CodSerEsp,$this->input->ip_address(),'Actualizando Servicio Especial.');	
	}
	else
	{
		$id = $this->Comercializadora_model->agregar_servicio_especial($objSalida->CodCom,$objSalida->DesSerEsp,$objSalida->FecIniSerEspForm,$TipSumSerEsp,$objSalida->TipCli,$objSalida->CarSerEsp,$objSalida->CodTipCom,$objSalida->OsbSerEsp);		
			$objSalida->CodSerEsp=$id;
	
		if($T_DetalleServicioEspecialTarifaElecBaj!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecBaj as $T_DetalleServicioEspecialTarifaElecBaj => $record_Tarifa_Elec_Baja):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Baja_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Baja->CodTarEle);
			}
			endforeach;
		}
		if($T_DetalleServicioEspecialTarifaElecAlt!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaElecAlt as $T_DetalleServicioEspecialTarifaElecAlt => $record_Tarifa_Elec_Alta):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_Elec_Alta_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Elec_Alta->CodTarEle);
			}
			endforeach;
		}
			if($T_DetalleServicioEspecialTarifaGas!=false)
		{
			foreach ($T_DetalleServicioEspecialTarifaGas as $T_DetalleServicioEspecialTarifaGas => $record_Tarifa_Gas):
			{
				$this->Comercializadora_model->agregar_detalle_tarifa_gas_SerEsp($objSalida->CodSerEsp,$record_Tarifa_Gas->CodTarGas);
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
    $data_servicio_especial = $this->Comercializadora_model->get_servicio_especial_data($CodSerEsp);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','GET',$CodSerEsp,$this->input->ip_address(),'Buscando Servicio Especial Por CodSerEsp');
	if (empty($data_servicio_especial))
	{
		$this->response(false);
		return false;
	}	

	if($data_servicio_especial->SerGas=="SI")
	{
		$data_detalle_tarifa_gas = $this->Comercializadora_model->get_detalle_tarifa_gas_SerEsp($CodSerEsp);
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
    	$detalleG = $this->Comercializadora_model->obtener_detalle_tarifa_electrica_SerEsp($CodSerEsp);
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
		$resultado = $this->Comercializadora_model->update_status_servicio_especial($objSalida->CodSerEsp,$objSalida->EstSerEsp);
		


		if($objSalida->EstSerEsp==2)
		{
			$CodMotBloPro=$this->Comercializadora_model->agregar_bloqueo_servicio_especial($objSalida->CodSerEsp,$objSalida->FecBlo,$objSalida->MotBloSerEsp,$objSalida->ObsMotBloSerEsp);
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