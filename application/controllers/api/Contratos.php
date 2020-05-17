<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Contratos extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Contratos_model');
		$this->load->model('Clientes_model');
		$this->load->model('Propuesta_model');		
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    
     public function get_list_contratos_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}			
        $Contratos = $this->Contratos_model->get_list_contratos();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contratos','GET',null,$this->input->ip_address(),'Cargando Lista de Contatros.');        
		if (empty($Contratos))
		{		
			$this->response(false);
			return false;
		}
		$this->response($Contratos);
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
		$consulta=$this->Clientes_model->getclientessearch($objSalida->NumCifCli);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function get_valida_datos_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$NumCifCli=$this->get('NumCifCli');
		$tabla="T_Cliente";
		$where="NumCifCli";	
		$select='CodCli,NumCifCli'; 
		$Cliente = $this->Propuesta_model->Funcion_Verificadora($NumCifCli,$tabla,$where,$select);        
		if (empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',null,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$Cliente->CodCli,$this->input->ip_address(),'Número de CIF Encontrado.');	
		$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobada($Cliente->CodCli,1); 
		if($BuscarPropuestaAprobada==false)
		{
			$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial con estatus aprobada.','statusText'=>'Error');
			$this->response($response);	
			return false;
		}
		$response = array('status' =>true ,'menssage' =>'Datos Encontrados','statusText'=>'Contrato','Cliente'=>$Cliente);	
		/*$tabla="T_PropuestaComercial";
		$where="CodCli";
		$BuscarPropuesta=$this->Propuesta_model->Buscar_Propuesta($Cliente->CodCli,$tabla,$where);
		if($BuscarPropuesta!=false)
		{
			$response = array('status' =>false ,'menssage' =>'El Cliente tiene una Propuesta Comercial con estatus pendiente con número de referencia: '.$BuscarPropuesta->RefProCom,'statusText'=>'Error');
			$this->response($response);	
			return false;
		}	
		$BuscarContrato=$this->Propuesta_model->Buscar_Contratos($Cliente->CodCli);
		if($BuscarContrato==false)
		{
			$response = array('status' =>true ,'menssage' =>'Cliente sin ningun contrato puede generar una propuesta.','statusText'=>'Propuesta_Nueva','CodCli'=>$Cliente->CodCli);
			$this->response($response);
			return false;
		}
		if($BuscarContrato->ProRenPen==1)
		{
			$response = array('status' =>true ,'menssage' =>'Tiene contrato Pero debe crear propuesta porque se solicito con modificaciones la propuesta.','statusText'=>'Contrato','Contrato'=>$BuscarContrato);
		}
		else
		{
			$response = array('status' =>false ,'menssage' =>'Este cliente ya tiene un contrato vigente.','statusText'=>'Error');
		}*/
		$this->response($response);
    }
    public function BuscarXIDPropuestaContrato_get()
    {
    	$CodCli=$this->get('CodCli');
		$tabla="T_Cliente";
		$where="CodCli";	
		$select='CodCli,NumCifCli,RazSocCli'; 
		$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select); 
		if(empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobada($Cliente->CodCli,1); 
		if($BuscarPropuestaAprobada==false)
		{
			$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial con estatus aprobada.','statusText'=>'Error');
			$this->response($response);	
			return false;
		}
		$ReferenciaContrato=$this->generar_RefProContrato();
		$Fecha=date('d/m/Y');
		$arrayName = array('Cliente' =>$Cliente,'List_Propuesta'=>$BuscarPropuestaAprobada,'RefCon'=>$ReferenciaContrato,'FechaServer'=>$Fecha);
		$this->response($arrayName);
	}
	public function BuscarXIDContrato_get()
    {
    	$CodCli=$this->get('CodCli');
    	$CodConCom=$this->get('CodConCom');
    	$CodProCom=$this->get('CodProCom');
		$tabla="T_Cliente";
		$where="CodCli";	
		$select='CodCli,NumCifCli,RazSocCli'; 
		$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select); 
		if(empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		$BuscarPropuestaList=$this->Contratos_model->BuscarPropuestaAprobada($CodCli,2); 
		$tabla="T_Contrato";
		$where="CodConCom";	
		$select='CodCli,CodConCom,CodProCom,DocConRut,DocGenCom,DurCon,EstBajCon,EstRen,DATE_FORMAT(FecBajCon,"%d/%m/%Y") as FecBajCon,DATE_FORMAT(FecConCom,"%d/%m/%Y") as FecConCom,DATE_FORMAT(FecFinCon,"%d/%m/%Y") as FecFinCon,DATE_FORMAT(FecIniCon,"%d/%m/%Y") as FecIniCon,DATE_FORMAT(FecVenCon,"%d/%m/%Y") as FecVenCon,JusBajCon,ObsCon,ProRenPen,RefCon,RenMod,UltTipSeg'; 
		$Contratos = $this->Propuesta_model->Funcion_Verificadora($CodConCom,$tabla,$where,$select);
		//$List_Pro = array('List' => $BuscarPropuestaList);
		/*$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobada($Cliente->CodCli); 
		if($BuscarPropuestaAprobada==false)
		{
			$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial con estatus aprobada.','statusText'=>'Error');
			$this->response($response);	
			return false;
		}
		$ReferenciaContrato=$this->generar_RefProContrato();
		$Fecha=date('d/m/Y');*/
		$arrayName = array('Cliente' =>$Cliente,'List_Pro' =>$BuscarPropuestaList,'Contrato' =>$Contratos);
		$this->response($arrayName);
	}
    public function generar_RefProContrato()
    {
    	$nCaracteresFaltantes = 0;
		$numero_a = " ";
		/*Ahora necesitamos el numero de la Referencia de la Propuesta*/
		$queryIdentificador = $this->db->query("SELECT CodMov,DesMov,NrMov FROM T_Movimientos WHERE CodMov=2");
		$rowIdentificador = $queryIdentificador->row();
		//buscamos que longitud tiene el numero generado por la base de datos y completamos con ceros a la izquierda
		$nCaracteresFaltantes = 12 - strlen($rowIdentificador->NrMov) ;
		$numero_a = str_repeat('0',$nCaracteresFaltantes);
		$numeroproximo = $rowIdentificador->NrMov + 1;
		$nCaracteresFaltantesC = 12 - strlen($rowIdentificador->NrMov); //VERIFICAR CUANDO PASE DE 100
		$numero_aC = str_repeat('0',$nCaracteresFaltantesC);
		$numeroproximoC = $rowIdentificador->NrMov + 1;
		$numeroC = $numero_aC . (string)$rowIdentificador->NrMov;
		$this->db->query("UPDATE T_Movimientos SET NrMov=".$numeroproximo." WHERE CodMov=2");
		return $numeroC;		
    }
    public function calcular_vencimiento_post()
    {
    	$objSalida = json_decode(file_get_contents("php://input"));    	
    	$FechaServer=date("d/m/Y");
    	$FechaCalcular=explode("/", $objSalida->FechaCalcular);
    	$Fecha_Volteada=$FechaCalcular[2]."-".$FechaCalcular[1]."-".$FechaCalcular[0];

    	if(date($Fecha_Volteada)<date('Y-m-d'))
    	{
    		$arrayName = array('status' =>false ,'menssage'=>'La Fecha de Inicio no puede ser menor a la fecha del servidor.','statusText'=>'Fecha','FechaServer'=>$FechaServer);
    		$this->response($arrayName);
    	}
    	    	
    	$actual = strtotime($Fecha_Volteada);
  		$mesmenos = date("Y-m-d", strtotime("+".$objSalida->DurCon." month", $actual));
  		$FechaVenC=explode("-", $mesmenos);  		
  		$Fecha_Volteada=$FechaVenC[2]."/".$FechaVenC[1]."/".$FechaVenC[0];
  		$objSalida->FecVenc=$Fecha_Volteada;
    	$this->response($objSalida);	
	
    }
    public function registrar_contratos_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));	
		if($objSalida->tipo=='nuevo')
		{
			$this->db->trans_start();
			$CodConCom=$this->Contratos_model->agregar_contrato($objSalida->CodCli,$objSalida->CodProCom,date('Y-m-d'),false,false,false,$objSalida->FecIniCon,$objSalida->DurCon,$objSalida->FecVenCon,$objSalida->RefCon,$objSalida->ObsCon,$objSalida->DocConRut);
			$objSalida->CodConCom=$CodConCom;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','INSERT',$CodConCom,$this->input->ip_address(),'Generando Contrato Comercial.');			
			$tabla="T_PropuestaComercial";
			$where="CodProCom";	
			$select='*'; 
			$PropuestaComercial = $this->Propuesta_model->Funcion_Verificadora($objSalida->CodProCom,$tabla,$where,$select);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','GET',$objSalida->CodProCom,$this->input->ip_address(),'Consultando Propuesta Comercial En Contratos.');
			$update_CUPsEle=$this->Contratos_model->update_CUPsEleDB($PropuestaComercial->CodCupsEle,$PropuestaComercial->CodTarEle,$PropuestaComercial->PotConP1,$PropuestaComercial->PotConP2,$PropuestaComercial->PotConP3,$PropuestaComercial->PotConP4,$PropuestaComercial->PotConP5,$PropuestaComercial->PotConP6);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CUPsElectrico','UPDATE',$PropuestaComercial->CodCupsEle,$this->input->ip_address(),'Actualizando CUPs Eléctrico Generando Contrato Comercial.');
			$update_CUPsGas=$this->Contratos_model->update_CUPsGasDB($PropuestaComercial->CodCupsGas,$PropuestaComercial->CodTarGas,$PropuestaComercial->Consumo);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CUPsGas','UPDATE',$PropuestaComercial->CodCupsGas,$this->input->ip_address(),'Actualizando CUPs Gas Generando Contrato Comercial.');
			$update_propuesta=$this->Contratos_model->update_propuesta($objSalida->CodProCom,'C',$objSalida->CodCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Propuesta Comercial ha C Desde Contrato Comercial');
			$arrayName = array('status'=>200 ,'menssage'=>'Contrato Comercial generado correctamente bajo el número de contrato: '.$objSalida->RefCon,'statusText'=>'OK','objSalida' =>$objSalida);			
			$this->db->trans_complete();
			$this->response($arrayName);			
		}
		elseif($objSalida->tipo=='ver')
		{
			$this->db->trans_start();
			$update_CUPsGas=$this->Contratos_model->update_contrato_documento($objSalida->CodConCom,$objSalida->DocConRut);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Contrato Documento.');
			$this->db->trans_complete();
			$arrayName = array('status' =>200,'menssage'=>'Contrato actualizado correctamente.','statusText'=>"OK" );
			$this->response($arrayName);
		}
		elseif($objSalida->tipo=='editar')
		{
			$this->db->trans_start();
			

			if(date($objSalida->FecIniCon)<date('Y-m-d'))
	    	{
	    		$arrayName = array('status' =>false ,'menssage'=>'Error la fecha de inicio es menor a la fecha actual','statusText'=>'Fecha');
	    		$this->response($arrayName);
	    	}

			$this->Contratos_model->update_DBcontrato($objSalida->CodCli,$objSalida->CodProCom,$objSalida->FecIniCon,$objSalida->DurCon,$objSalida->FecVenCon,$objSalida->ObsCon,$objSalida->DocConRut,$objSalida->CodConCom);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Contrato Comercial.');
			$this->db->trans_complete();
			$arrayName = array('status' =>200,'menssage'=>'Contrato actualizado correctamente.','statusText'=>"OK" );
			$this->response($arrayName);
		}
		else
		{
			$arrayName = array('status' =>false,'menssage'=>'Ruta invalida ingrese modulo/nueva.','statusText'=>"Error" );
			$this->response($arrayName);
		}
	}
	public function dandobajaContrato_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));			
		$this->db->trans_start();	
		$this->Contratos_model->update_bajaContrato($objSalida->CodConCom,$objSalida->FecBajCon,$objSalida->JusBajCon,1);		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Dando Baja Contrato Comercial.');			
		$arrayName = array('status'=>200 ,'menssage'=>'Contrato Comercial Dado de Baja Correctamente. ','statusText'=>'OK');		
		$this->db->trans_complete();
		$this->response($arrayName);			
				
	}
	public function verificar_renovacion_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		//$consulta=$this->Clientes_model->getclientessearch($objSalida->NumCifCli);						
		$FechaServer=date('Y-m-d');
		$FecVenConVolteada=   explode("/", $objSalida->FecVenCon);
		$FecVenConVolteadaFin=$FecVenConVolteada[2]."-".$FecVenConVolteada[1]."-".$FecVenConVolteada[0];
		if(date($FechaServer)<date($FecVenConVolteadaFin))
		{
			$arrayName = array('status' =>203 ,'menssage'=>'Este Contrato aun no se ha vencido. Fecha de renovación anticipada.','statusText'=>'Error');
			$this->response($arrayName);
		}
		elseif(date($FechaServer)>date($FecVenConVolteadaFin))
		{
			$arrayName = array('status' =>200 ,'menssage'=>'Contrato Vencido se procede a solicitar renovación.','statusText'=>'OK' );
			$this->response($arrayName);
		}



		//$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function RenovarContrato_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		if($objSalida->SinMod==false && $objSalida->ConMod==false)
		{
			$arrayName = array('status' =>203,'menssage'=>'Debe indicar que tipo de renovación es el contrato.','statusText'=>'Error' );
			$this->db->trans_complete();
			$this->response($arrayName);
		}
		elseif($objSalida->SinMod==true && $objSalida->ConMod==false)
		{
			if(date($objSalida->FecIniCon)<date('Y-m-d'))
	    	{
	    		$arrayName = array('status' =>203 ,'menssage'=>'La Fecha de Inicio no puede ser menor a la fecha del servidor '.date('d/m/Y'),'statusText'=>'Error');
	    		$this->response($arrayName);
	    	}

		    $actual = strtotime($objSalida->FecIniCon);
	  		$FecVenCon = date("Y-m-d", strtotime("+".$objSalida->DurCon." month", $actual));	  		
	  		$ReferenciaContrato=$this->generar_RefProContrato();
	  		$tabla="T_Contrato";
			$where="CodConCom";	
			$select='ObsCon,DocConRut'; 
			$ContratoComercial = $this->Propuesta_model->Funcion_Verificadora($objSalida->CodConCom,$tabla,$where,$select);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','GET',$objSalida->CodConCom,$this->input->ip_address(),'Consultando Propuesta Comercial En Contratos.');	    	
	    	$CodConCom=$this->Contratos_model->agregar_contrato($objSalida->CodCli,$objSalida->CodProCom,date('Y-m-d'),false,false,false,$objSalida->FecIniCon,$objSalida->DurCon,$FecVenCon,$ReferenciaContrato,$ContratoComercial->ObsCon,$ContratoComercial->DocConRut);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','INSERT',$CodConCom,$this->input->ip_address(),'Generando Contrato Comercial.');			
			$this->Contratos_model->update_status_contrato_old($objSalida->CodConCom,3);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Estatus Contrato a Renovado.');
			$arrayName = array('status' =>200 ,'menssage'=>'Contrato renovado correctamente.','statusText'=>'OK');
			$this->db->trans_complete();
			$this->response($arrayName);
		}
		elseif($objSalida->SinMod==false && $objSalida->ConMod==true)
		{
			
			$this->Contratos_model->update_status_contrato_modificaciones($objSalida->CodCli,$objSalida->CodConCom,0,1,1,3);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Estatus Contrato Con modificaciones.');
			$arrayName = array('status' =>200,'menssage'=>'Valla a Propuesta Comercial para solicitar la modificion del contrato.','statusText'=>'OK' );
			$this->db->trans_complete();
			$this->response($arrayName);
		}
		else
		{
			$arrayName = array('status' =>203,'menssage'=>'Error en Tipo de Renovación..','statusText'=>'Error' );
			$this->db->trans_complete();
			$this->response($arrayName);
		}	
	}
      

}
?>