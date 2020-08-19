<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class RenovacionMasiva extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('RenovacionesMasivas_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    public function DatosServer_get() 
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}  
		$Desde=date("Y-m-d"); 
        $FecDesde=explode("-", $Desde);         
        $FecDesdeVol=$FecDesde[2]."/".$FecDesde[1]."/".$FecDesde[0];
        $actual = strtotime($Desde);
        $Hasta = date("Y-m-d", strtotime("+ 60 days", $actual));
        $FecHasta=explode("-", $Hasta);         
        $FecHastaVol=$FecHasta[2]."/".$FecHasta[1]."/".$FecHasta[0];
        $Comercializadoras=$this->RenovacionesMasivas_model->get_list_comercializadora();
        $data = array('FecDesde' =>$FecDesdeVol ,'FecHasta' =>$FecHastaVol ,'Comercializadoras' =>$Comercializadoras);		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_V_T','GET',null,$this->input->ip_address(),'Cargando Datos para las renovaciones masivas');				
		$this->response($data);		
        
    }
    public function SearchFilterProdAne_get() 
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}  
		$CodFilter=$this->get('CodFilter');
		$Metodo=$this->get('Metodo');	
		if($Metodo==1)
		{
			$Tabla="T_Productos";
			$response=$this->RenovacionesMasivas_model->getProductosComercializadora($CodFilter);
		}
		elseif($Metodo==2)
		{
			$Tabla="T_AnexoProducto";
			$response=$this->RenovacionesMasivas_model->getAnexosProductos($CodFilter);
		}
		elseif($Metodo==3)
		{
			$Tabla="T_AnexoProducto";
			$response=$this->RenovacionesMasivas_model->getAnexosProductos($CodFilter);
		}
		else
		{
			$Tabla="";
			$response=false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',null,$this->input->ip_address(),'Filtrando '.$Tabla);				
		$this->response($response);		
        
    }
    public function Consultar_Contratos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$ContratosVencidos=$this->RenovacionesMasivas_model->getContratosFilters($objSalida->FecDesde,$objSalida->FecHasta,$objSalida->CodCom,$objSalida->CodPro,$objSalida->CodAnePro);
		$objSalida->response=$ContratosVencidos;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','GET',null,$this->input->ip_address(),'Consultando Contratos');
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function RenovarMasivamenteContratos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		
		/*if($objSalida->CambiarProAne!=false)
		{
			$CodPro=$objSalida->CodPro;
			$CodAnePro=$objSalida->CodAnePro;
		}
		else
		{
			$CodPro=null;
			$CodAnePro=null;
		}*/
		foreach ($objSalida->detalle as $key => $value): 
		{
			$FecVenCon=explode("/", $value->FecVenCon);
	    	$FecVenCon_Final=$FecVenCon[2]."-".$FecVenCon[1]."-".$FecVenCon[0];			
	    	$FecVenConStrToTime = strtotime($FecVenCon_Final);
			$FecIniCon = date("Y-m-d", strtotime("+ 1 days", $FecVenConStrToTime));
			$NewFecVenConStrToTime = strtotime($FecIniCon);
			$NewFecVenCon = date("Y-m-d", strtotime("+".$value->DurCon." month", $NewFecVenConStrToTime));			
			$Save_Renovacion=$this->RenovacionesMasivas_model->Save_Renovaciones_Contratos($value->CodProCom,$value->CodCli,$FecIniCon,1,0,0,$FecIniCon,$value->DurCon,$NewFecVenCon,$FecIniCon,$NewFecVenCon);			
			$Update_Contratos=$this->RenovacionesMasivas_model->Update_Renovaciones_Contratos($value->CodConCom,3);
			if($objSalida->CambiarProAne!=false)
			{
				$Update_Propuestas=$this->RenovacionesMasivas_model->Update_Propuestas_Contratos($value->CodProCom,$objSalida->CodPro,$objSalida->CodAnePro);				
			}

		}
		endforeach;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','POST',null,$this->input->ip_address(),'Generando Renovación Masiva de Contratos');
		$this->db->trans_complete();
		$this->response($objSalida);
    }

   
	
}
?>