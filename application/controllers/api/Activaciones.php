<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Activaciones extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Activaciones_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    } 
    public function getCUPsActivaciones_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CUPs=$this->get('CUPsName');		
        $data = $this->Activaciones_model->GetDatosCUPsForActivaciones($CUPs);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'V_CupsGrib','GET',null,$this->input->ip_address(),'Buscando CUPs Para Activación');
		if (empty($data))
		{
			$this->response(false);
			return false;
		}
		if($data-> TipServ=='E' || $data-> TipServ=='Eléctrico')
		{
			$dataCUPS=$this->Activaciones_model->GetInformacionCUPsElectrico($data-> CodCupGas);
			if (empty($dataCUPS))
			{
				$this->response(array('status'=>400,'menssage'=>'No se encontraron contratos asignados a este CUPs.','statusText'=>'CUPs Sin Contrato'));
				return false;
			}
			$arrayName = array('status'=>200,'menssage'=>'Se encontraron contratos registrados.','statusText'=>'Contratos','ListContratos'=>$dataCUPS);
		}
		elseif ($data-> TipServ=='G' || $data-> TipServ=='Gas') 
		{
			
			$dataCUPS=$this->Activaciones_model->GetInformacionCUPsGas($data-> CodCupGas);
			if (empty($dataCUPS))
			{
				$this->response(array('status'=>400,'menssage'=>'No se encontraron contratos asignados a este CUPs.','statusText'=>'CUPs Sin Contrato'));
				return false;
			}
			$arrayName = array('status'=>200,'menssage'=>'Se encontraron contratos registrados.','statusText'=>'Contratos','ListContratos'=>$dataCUPS);
		}	
		else
		{
			$arrayName = array('status'=>305,'menssage'=>'Error en Tipo de Servicio del CUPs.','statusText'=>'CUPs');
		}	
		$this->response($arrayName);		
    }
    public function UpdateInformationContratos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$respose=$this->Activaciones_model->UpdateInformationContratos($objSalida->CodConCom,$objSalida->CodCups,$objSalida->CodProCom,$objSalida->CodProComCli,$objSalida->CodProComCup,$objSalida->ConCup,$objSalida->FecActCUPs,$objSalida->FecVenCUPs,$objSalida->TipCups	
		,$objSalida->CodTar,$objSalida->EstConCups,$objSalida->PotEleConP1,$objSalida->PotEleConP2,$objSalida->PotEleConP3,$objSalida->PotEleConP4,$objSalida->PotEleConP5,$objSalida->PotEleConP6);
		$this->Activaciones_model->UpdateInformationContratosPropuesta($objSalida->CodProCom,$objSalida->CodPro);
		
		if($respose==false)
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$objSalida->CodProComCup,$this->input->ip_address(),'Error Actualizando Desde Activiciones');
			$this->response(false);
			return false;
		}		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$objSalida->CodProComCup,$this->input->ip_address(),'Actualizando Propuesta Comercial FecActCUPs,FecVenCUPs,ConCup Desde Activiciones');	
		$this->db->trans_complete();
		$this->response($respose);
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
			$Response = $this->Activaciones_model->list_tarifa_electricas();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','GET',null,$this->input->ip_address(),'Cargando lista de Tárifas Eléctricas para Activaciones');
		}
		elseif ($metodo==2) {
			$Response = $this->Activaciones_model->get_list_tarifa_Gas();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',null,$this->input->ip_address(),'Cargando lista de Tárifas Gas para Activaciones');
		}
		elseif ($metodo==3) {
			$Response = $this->Activaciones_model->get_listProductos();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',null,$this->input->ip_address(),'Cargando lista de Tárifas Gas para Activaciones');
		}	
		elseif ($metodo==4) {
			$Response = $this->Activaciones_model->get_list_comercializadora_Act();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',null,$this->input->ip_address(),'Cargando lista de de Comercializadoras para Contrato Rapido');
		}	
		
		else
		{
			$Response =array('status' =>201 ,'statusText'=>'Error','menssage'=>'Estatus del Clientes');
			$this->Auditoria_model->agregar($this->session->userdata('id'),'Estatus','GET',null,$this->input->ip_address(),'Estatus');
		}		
		$this->response($Response);		
	}
	public function realizar_filtro_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$metodo=$this->get('metodo');	
		$PrimaryKey=$this->get('PrimaryKey');	
	    $arrayName = Array();
		if($metodo==1)
		{
			$tabla="T_Producto";
			$buscando="Buscando Productos de Las Comercializadoras";
			$response=$this->Activaciones_model->ProductosComercia($PrimaryKey);
		}
		elseif ($metodo==2) 
		{
			$tabla="T_AnexoProducto";
			$buscando="Buscando Anexos de Las Comercializadoras";
			$response=$this->Activaciones_model->ProductosAnexos($PrimaryKey);
		}
		elseif ($metodo==3) 
		{
			$tabla="T_AnexoProducto";
			$buscando="Buscando Tipo de Precio del Anexo";			
			$where="CodAnePro";	
			$select='TipPre';	
	        $response = $this->Activaciones_model->Funcion_Verificadora($PrimaryKey,$tabla,$where,$select); 
		}
		elseif ($metodo==4) 
		{
			$tabla="T_CUPsElectrico";
			$buscando="Buscando CUPs Eléctrico desde Activaciones";			
			$where="CodCupsEle";	
			$select='*';	
	        $response = $this->Activaciones_model->Funcion_ComprobarCUPs($PrimaryKey,$tabla,$where,$select);
		}
		elseif ($metodo==5) 
		{
			$tabla="T_CUPsGas";
			$buscando="Buscando CUPs Gas desde Activaciones";			
			$where="CodCupGas";	
			$select='*';	
	        $response = $this->Activaciones_model->Funcion_ComprobarCUPs($PrimaryKey,$tabla,$where,$select);
		}
		elseif ($metodo==6) 
		{
			$tabla="T_PuntoSuministro";
			$buscando="Buscando Direcciones de Suministros desde Activaciones";
	        $response = $this->Activaciones_model->get_data_puntos_suministros($PrimaryKey);
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$PrimaryKey,$this->input->ip_address(),$buscando);
		$this->response($response);		
	}
	public function agregar_documento_contrato_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = '*';
		$config['encrypt_name']        = false;		
		$this->load->library('upload', $config);	
		$data = $this->upload->do_upload('file');
		//$api=$this->get('x-api-key');
		if (!$data)
		{
			$error = array('status'=>0,'nombre'=>$this->upload->display_errors());	
			return 	$this->response($error);
		}
		else
		{
			$data = array($this->upload->data());
			$this->response(array('file_ext'=>$data[0]['file_ext'],'DocGenCom'=>$data[0]['raw_name'],'DocConRut'=>$data[0]['file_name'],'status' =>200,'statusText' =>'OK','menssage'=>'Archivo cargado correctamente.'));
		}		
	}
	public function Generar_Contrato_Rapido_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();

		$PropuestaComercial=$this->Activaciones_model->CrearPropuestaComercial(date('Y-m-d'),1,0,'0.00','0.00','C',null,$objSalida-> CodCom, $objSalida-> CodPro,$objSalida-> CodAnePro,$objSalida-> TipPre,null,null,'0');
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','INSERT',$PropuestaComercial,$this->input->ip_address(),'Creando Propuesta Comerciales desde Activaciones');	

		$PropuestaComercialClientes=$this->Activaciones_model->CrearPropuestaComercialCliente($PropuestaComercial,$objSalida-> CodCli);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_Clientes','INSERT',$PropuestaComercial,$this->input->ip_address(),'Creando Relación Propuesta Comercial y Cliente desde Activaciones');

		if(!empty($objSalida-> detalleCUPs))
		{
			foreach ($objSalida-> detalleCUPs as $key => $value) {
				
				$PropuestaComercialClientesCUPs='';
				$PropuestaComercialClientesCUPs=$this->Activaciones_model->CrearPropuestaComercialClienteCUPs($PropuestaComercialClientes,$objSalida-> CodPunSum,$value-> CodCups,$value-> CodTar,$value-> PotConP1,$value-> PotConP2,$value-> PotConP3,$value-> PotConP4,$value-> PotConP5,$value-> PotConP6,$value-> FecActCUPs,$value-> FecVenCUPs,0,'0.00','0.00',$value-> ObsCup,$value-> ConCUPs,$value-> CauDia,$value-> TipServ,1);
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','INSERT',$PropuestaComercialClientesCUPs,$this->input->ip_address(),'Creando Detalle CUPs desde Activaciones');
			}						
		}
		else
		{
			$PropuestaComercialClientesCUPs=null;
		}
		$ContratoRapido=$this->Activaciones_model->CrearContratoRapido($PropuestaComercial,$objSalida-> CodCli
			,date('Y-m-d'),false,false,false,date('Y-m-d'),'12',null,null,null,null,null,$objSalida-> ObsCon,null,null,0,null,null,null,$PropuestaComercialClientesCUPs);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','INSERT',$ContratoRapido,$this->input->ip_address(),'Creando Contrato Comercial desde Activaciones');
		if(!empty($objSalida-> TDocumentosContratos))
		{
			foreach ($objSalida-> TDocumentosContratos as $key => $value) {
				
				$DocumentosContratos=$this->Activaciones_model->RegistrarDocmuentosContrato(0,$value-> file_ext,$ContratoRapido,$value-> DocGenCom,$value-> DocConRut);
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_DetalleDocumentosContratos','INSERT',$DocumentosContratos,$this->input->ip_address(),'Guardando Documentos Contratos desde Activaciones');
			}						
		}
		$response = array('CodCli' =>$objSalida-> CodCli ,'CodConCom' =>$ContratoRapido ,'CodProCom' =>$PropuestaComercial);		
		$this->db->trans_complete();
		$this->response($response);
    }
}
?>