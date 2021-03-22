<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
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
		$this->load->helper('cookie');
		$this->load->library('user_agent');  
        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper("file");
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = '*';
		$config['encrypt_name']        = false;		
		$this->load->library('upload', $config);
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
		
		if($objSalida->metodo==1 && $consulta==false)
		{
			$consulta=$this->Clientes_model->getColaboradoressearch($objSalida->NumCifCli);
		}

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
			$tabla="T_ContactoCliente";
			$where="NIFConCli";	
			$select='CodConCli as CodCli,NIFConCli as NumCifCli'; 
			$Cliente = $this->Propuesta_model->Funcion_Verificadora($NumCifCli,$tabla,$where,$select);			
			if(empty($Cliente))
			{
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',null,$this->input->ip_address(),'Número de CIF Colaborador no Registrado.');
				$this->response(false);
			    return false;
			}
			else
			{
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$Cliente->CodCli,$this->input->ip_address(),'Número de CIF Encontrado.');	
				$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobadaNewVer($Cliente->CodCli,3); 
				if($BuscarPropuestaAprobada==false)
				{
					$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial MultiCliente con estatus aprobada.','statusText'=>'Error');
					$this->response($response);				
					return false;
				}
				$response = array('status' =>true ,'menssage' =>'Datos Encontrados','statusText'=>'Contrato','Cliente'=>$Cliente);	
			}
		}
		else
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$Cliente->CodCli,$this->input->ip_address(),'Número de CIF Encontrado.');	
			$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobadaNewVer($Cliente->CodCli,1); 
			if($BuscarPropuestaAprobada==false)
			{
				$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial Sencilla o Uni Cliente con estatus aprobada.','statusText'=>'Error');
				$this->response($response);				
				return false;
			}
			$response = array('status' =>true ,'menssage' =>'Datos Encontrados','statusText'=>'Contrato','Cliente'=>$Cliente);	
		}
		
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
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    	$CodCli=$this->get('CodCli');
		$tabla="T_Cliente";
		$where="CodCli";	
		$select='CodCli,NumCifCli,RazSocCli'; 
		$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select); 
		//$this->response($Cliente);
		if(empty($Cliente))
		{
				$tabla="T_ContactoCliente";
				$where="CodConCli";	
				$select='CodConCli as CodCli,NIFConCli as NumCifCli,NomConCli as RazSocCli'; 
				$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select);	
				if(empty($Cliente))
				{
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$CodCli,$this->input->ip_address(),'Número de Representante Legal no Registrado.');
					$this->response(false);
				    return false;
				}
				$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobadaNewVer($Cliente->CodCli,3); 
				if($BuscarPropuestaAprobada==false)
				{
					$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial MultiCliente con estatus aprobada.','statusText'=>'Error');
					$this->response($response);				
					return false;
				}
				$response = array('Cliente' =>$Cliente,'List_Propuesta'=>$BuscarPropuestaAprobada,'RefCon'=>$ReferenciaContrato,'FechaServer'=>$Fecha);
				$this->response($response);
		}
		else
		{
			$ReferenciaContrato=$this->generar_RefProContrato();
			$Fecha=date('d/m/Y');
			$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobadaNewVer($Cliente->CodCli,1); 
			if($BuscarPropuestaAprobada==false)
			{				
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','GET',$CodCli,$this->input->ip_address(),'No se encontraron propuesta aprobadas para este cliente verificacion Con Representante Legal.');
				$tabla="T_ContactoCliente";
				$where="CodConCli";	
				$select='CodConCli as CodCli,NIFConCli as NumCifCli,NomConCli as RazSocCli'; 
				$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select);	
				if(empty($Cliente))
				{
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$CodCli,$this->input->ip_address(),'Número de Representante Legal no Registrado.');
					$this->response(false);
				    return false;
				}
				$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobadaNewVer($Cliente->CodCli,3); 
				if($BuscarPropuestaAprobada==false)
				{
					$response = array('status' =>false ,'menssage' =>'El Cliente no tiene una Propuesta Comercial MultiCliente con estatus aprobada.','statusText'=>'Error');
					$this->response($response);				
					return false;
				}
				$response = array('Cliente' =>$Cliente,'List_Propuesta'=>$BuscarPropuestaAprobada,'RefCon'=>$ReferenciaContrato,'FechaServer'=>$Fecha);
				$this->response($response);				
			}
			else
			{
				$response = array('Cliente' =>$Cliente,'List_Propuesta'=>$BuscarPropuestaAprobada,'RefCon'=>$ReferenciaContrato,'FechaServer'=>$Fecha);
				$this->response($response);	
			}
			//$this->response($BuscarPropuestaAprobada);
		}		
	}
	public function PropuestaMultiCliente_get()
    {
    	$CodCli=$this->get('CodCol');
		$tabla="T_ContactoCliente";
		$where="CodConCli";	
		$select='CodConCli as CodCli,NIFConCli as NumCifCli,NomConCli as RazSocCli'; 
		$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select); 
		if(empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		$BuscarPropuestaAprobada=$this->Contratos_model->BuscarPropuestaAprobadaNewVer($Cliente->CodCli,3); 
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
		$tabla="T_PropuestaComercial";
		$where="CodProCom";	
		$select='*';
		$PropuestaValidarTipProCom = $this->Propuesta_model->Funcion_Verificadora($CodProCom,$tabla,$where,$select);
		if(empty($PropuestaValidarTipProCom))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','GET',$CodCli,$this->input->ip_address(),'Propuesta Comercial no Existe.');
			$this->response(false);
			return false;
		}
		if($PropuestaValidarTipProCom->TipProCom==1 || $PropuestaValidarTipProCom->TipProCom==2)
		{
			$tabla="T_Cliente";
			$where="CodCli";	
			$select='CodCli,NumCifCli,RazSocCli';
		}
		else
		{
			$tabla="T_ContactoCliente";
			$where="CodConCli";	
			$select='CodConCli as CodCli,NIFConCli as NumCifCli,NomConCli as RazSocCli';
		}
		$Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select); 
		if(empty($Cliente)) 
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		//$Contratos=false;
		$BuscarPropuestaList=$this->Contratos_model->BuscarPropuestaAprobada($CodCli,2); 
		$tabla="T_Contrato";
		$where="CodConCom";	
		$select='CodCli,CodConCom,CodProCom,DocConRut,DocGenCom,DurCon,EstBajCon,EstRen,DATE_FORMAT(FecBajCon,"%d/%m/%Y") as FecBajCon,DATE_FORMAT(FecConCom,"%d/%m/%Y") as FecConCom,DATE_FORMAT(FecFinCon,"%d/%m/%Y") as FecFinCon,DATE_FORMAT(FecIniCon,"%d/%m/%Y") as FecIniCon,DATE_FORMAT(FecVenCon,"%d/%m/%Y") as FecVenCon,JusBajCon,ObsCon,ProRenPen,RefCon,RenMod,UltTipSeg,DATE_FORMAT(FecFirmCon,"%d/%m/%Y") as FecFirmCon,DATE_FORMAT(FecAct,"%d/%m/%Y") as FecAct'; 
		$Contratos = $this->Propuesta_model->Funcion_Verificadora($CodConCom,$tabla,$where,$select);
		if($Contratos!=false)
		{
			$List_Archivos=$this->Contratos_model->getDocumentosContratos($CodConCom);
		}
		else
		{
			$List_Archivos=false;
		}
		//// comentado antes start ///
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
		//// comentado antes emnd ///

		$arrayName = array('Cliente' =>$Cliente,'List_Pro' =>$BuscarPropuestaList,'Contrato' =>$Contratos,'List_Archivos' =>$List_Archivos);
		$this->response($arrayName);
	}
	public function GetDetallesCUPsTipProCom_get()
    {
    	$TipProCom=$this->get('TipProCom');
    	$CodProComCli=$this->get('CodProComCli');
    	$BuscarDetallesCUPs=$this->Propuesta_model->GetDetallesCUPs($CodProComCli); 
    	if($BuscarDetallesCUPs==false)
    	{
    		$arrayName = array('status' =>404,'menssage' =>'no se encontraron detalles para esta propuesta comercial','statusText' =>'Error');
			$this->response($arrayName);
			return false;
    	}
    	$arrayName = array('status' =>200,'menssage' =>'Cargando CUPs para contrato','statusText' =>'CUPs','BuscarDetallesCUPs'=>$BuscarDetallesCUPs);
    	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','GET',$CodProComCli,$this->input->ip_address(),'Cargando CUPs para Contrato');
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
    	if($objSalida->tipo=='nuevo')
    	{
    		if(date($Fecha_Volteada)<date('Y-m-d'))
	    	{
	    		$arrayName = array('status' =>false ,'menssage'=>'La Fecha de Inicio no puede ser menor a la fecha del servidor.','statusText'=>'Fecha','FechaServer'=>$FechaServer);
	    		$this->response($arrayName);
	    	}
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
			$CodConCom=$this->Contratos_model->agregar_contrato($objSalida->CodCli,$objSalida->CodProCom,date('Y-m-d'),false,false,false,$objSalida->FecIniCon,$objSalida->DurCon,$objSalida->FecVenCon,$objSalida->RefCon,$objSalida->ObsCon,null,$objSalida->FecAct);
			$objSalida->CodConCom=$CodConCom;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','INSERT',$CodConCom,$this->input->ip_address(),'Generando Contrato Comercial.');
			if(!empty($objSalida->detalleCUPs))
			{
				foreach ($objSalida->detalleCUPs as $key => $value):
				{
					$FecActCUPs='';
					$FecActCUPsFinal='';
					if($value->FecActCUPs==null)
					{
						$this->Propuesta_model->update_detallesCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$value->FecActCUPs);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Activación CUPs.');
					}
					else
					{
						$FecActCUPs=explode("/", $value->FecActCUPs);
						$FecActCUPsFinal=$FecActCUPs[2].'-'.$FecActCUPs[1].'-'.$FecActCUPs[0];
						$this->Propuesta_model->update_detallesCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$FecActCUPsFinal);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Activación CUPs.');
					}
					$FecVenCUPs='';
					$FecVenCUPsFinal='';						
					if($value->FecVenCUPs==null)
					{
						$this->Propuesta_model->update_detallesCUPsFecVenCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$value->FecVenCUPs);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Vencimiento CUPs.');
					}
					else
					{
						$FecVenCUPs=explode("/", $value->FecVenCUPs);
						$FecVenCUPsFinal=$FecVenCUPs[2].'-'.$FecVenCUPs[1].'-'.$FecVenCUPs[0];
						$this->Propuesta_model->update_detallesCUPsFecVenCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$FecVenCUPsFinal);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Vencimiento CUPs.');
					}
				}
				endforeach;
			}
			/*$tabla="T_PropuestaComercial";
			$where="CodProCom";	
			$select='*'; 
			$PropuestaComercial = $this->Propuesta_model->Funcion_Verificadora($objSalida->CodProCom,$tabla,$where,$select);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','GET',$objSalida->CodProCom,$this->input->ip_address(),'Consultando Propuesta Comercial En Contratos.');			
			$update_CUPsEle=$this->Contratos_model->update_CUPsEleDB($PropuestaComercial->CodCupsEle,$PropuestaComercial->CodTarEle,$PropuestaComercial->PotConP1,$PropuestaComercial->PotConP2,$PropuestaComercial->PotConP3,$PropuestaComercial->PotConP4,$PropuestaComercial->PotConP5,$PropuestaComercial->PotConP6);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CUPsElectrico','UPDATE',$PropuestaComercial->CodCupsEle,$this->input->ip_address(),'Actualizando CUPs Eléctrico Generando Contrato Comercial.');
			$update_CUPsGas=$this->Contratos_model->update_CUPsGasDB($PropuestaComercial->CodCupsGas,$PropuestaComercial->CodTarGas,$PropuestaComercial->Consumo);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CUPsGas','UPDATE',$PropuestaComercial->CodCupsGas,$this->input->ip_address(),'Actualizando CUPs Gas Generando Contrato Comercial.');*/
			$update_propuesta=$this->Contratos_model->update_propuesta($objSalida->CodProCom,'C');
			$objSalida->tipo='editar';
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Propuesta Comercial ha C Desde Contrato Comercial');
			$arrayName = array('status'=>200 ,'menssage'=>'Contrato Comercial generado correctamente bajo el número de contrato: '.$objSalida->RefCon,'statusText'=>'OK','objSalida' =>$objSalida);			
			$this->db->trans_complete();
			$this->response($arrayName);			
		}
		elseif($objSalida->tipo=='ver')
		{
			$this->db->trans_start();
			$update_CUPsGas=$this->Contratos_model->update_contrato_documento($objSalida->CodConCom,null);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Contrato Documento.');
			$this->db->trans_complete();
			$arrayName = array('status' =>200,'menssage'=>'Contrato actualizado de forma correcta','statusText'=>"OK",'objSalida' =>$objSalida );
			$this->response($arrayName);
		}
		elseif($objSalida->tipo=='editar')
		{
			$this->db->trans_start();			
			/*if(empty($objSalida->CodConCom))
			{	
				if(date($objSalida->FecIniCon)<date('Y-m-d'))
		    	{
		    		$arrayName = array('status' =>false ,'menssage'=>'Error la fecha de inicio es menor a la fecha actual','statusText'=>'Fecha');
		    		$this->response($arrayName);
		    	}
			}*/
			$this->Contratos_model->update_DBcontrato($objSalida->CodCli,$objSalida->CodProCom,$objSalida->FecIniCon,$objSalida->DurCon,$objSalida->FecVenCon,$objSalida->ObsCon,null,$objSalida->CodConCom,$objSalida->RefCon,$objSalida->FecFirmCon,$objSalida->FecAct);
			if(!empty($objSalida->detalleCUPs))
			{
				foreach ($objSalida->detalleCUPs as $key => $value):
				{
					$FecActCUPs='';
					$FecActCUPsFinal='';
					if($value->FecActCUPs==null)
					{
						$this->Propuesta_model->update_detallesCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$value->FecActCUPs);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Activación CUPs.');
					}
					else
					{
						$FecActCUPs=explode("/", $value->FecActCUPs);
						$FecActCUPsFinal=$FecActCUPs[2].'-'.$FecActCUPs[1].'-'.$FecActCUPs[0];
						$this->Propuesta_model->update_detallesCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$FecActCUPsFinal);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Activación CUPs.');
					}
					$FecVenCUPs='';
					$FecVenCUPsFinal='';						
					if($value->FecVenCUPs==null)
					{
						$this->Propuesta_model->update_detallesCUPsFecVenCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$value->FecVenCUPs);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Vencimiento CUPs.');
					}
					else
					{
						$FecVenCUPs=explode("/", $value->FecVenCUPs);
						$FecVenCUPsFinal=$FecVenCUPs[2].'-'.$FecVenCUPs[1].'-'.$FecVenCUPs[0];
						$this->Propuesta_model->update_detallesCUPsFecVenCUPs($value->CodProComCup,$value->CodCups,$value->CodProComCli,$value->TipServ,$FecVenCUPsFinal);
						$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Propuesta_Comercial_CUPs','UPDATE',$value->CodCups,$this->input->ip_address(),'Actualizando Fecha de Vencimiento CUPs.');
					}
				}
				endforeach;
			}
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Contrato Comercial.');
			$this->db->trans_complete();
			$arrayName = array('status' =>200,'menssage'=>'Contrato actualizado de forma correcta','statusText'=>"OK",'objSalida' =>$objSalida );
			$this->response($arrayName);
		}
		else
		{
			$arrayName = array('status' =>false,'menssage'=>'Ruta invalida introduzca modulo/nueva.','statusText'=>"Error" );
			$this->response($arrayName);
		}
	}
	public function dandobajaContrato_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));			
		$this->db->trans_start();	
		$this->Contratos_model->update_bajaContrato($objSalida->CodConCom,$objSalida->FecBajCon,$objSalida->JusBajCon,1);		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Dando Baja Contrato Comercial.');			
		$arrayName = array('status'=>200 ,'menssage'=>'Contrato Comercial Dado de Baja de forma correcta ','statusText'=>'OK');		
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
		$Explode=explode("/", $objSalida->FecVenCon);
		$FechaServer=$Explode[2].'-'.$Explode[1].'-'.$Explode[0];	
		$diasAnticipacion=date("Y-m-d",strtotime($FechaServer."+ 60 days")); 
		$VerificarRenovacion=$this->Contratos_model	->validar_renovacion($objSalida->CodCli,$objSalida->CodConCom,$FechaServer,$diasAnticipacion);
		if(empty($VerificarRenovacion))
		{
			$arrayName = array('status' =>201 , 'message'=>'Esta intentando hacer una renovación anticipada y su contrato tiene una fecha de vencimiento para la fecha: '.$objSalida->FecVenCon.' lo que quiere decir que hara cambios en el documento si esta de acuerdo puede continuar.','statusText'=>'Renovación Anticipada' );
			$this->db->trans_complete();
			$this->response($arrayName);
		}
		else
		{
			$arrayName = array('status' =>200 , 'message'=>'Procesando Renovación de Contrato Comercial.','statusText'=>'OK' );
			$this->db->trans_complete();
			$this->response($arrayName);
		}
		//$objSalida->FechaServer=$FechaServer;
		//$objSalida->diasAnticipacion=$diasAnticipacion;
		//$objSalida->VerificarRenovacion=$VerificarRenovacion;
		/*$FecVenConVolteada=   explode("/", $objSalida->FecVenCon);
		$FecVenConVolteadaFin=$FecVenConVolteada[2]."-".$FecVenConVolteada[1]."-".$FecVenConVolteada[0];*/
		/*if(date($FechaServer)<date($FecVenConVolteadaFin))
		{
			$arrayName = array('status' =>203 ,'menssage'=>'Este Contrato aun no se ha vencido. Fecha de renovación anticipada.','statusText'=>'Error','FechaAnticipacion'=>$diasAnticipacion);
			$this->response($arrayName);
		}
		elseif(date($FechaServer)>date($FecVenConVolteadaFin))
		{
			$arrayName = array('status' =>200 ,'menssage'=>'Contrato Vencido se procede a solicitar renovación.','statusText'=>'OK' );
			$this->response($arrayName);
		}*/
		//$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		//$this->response($VerificarRenovacion);
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
			$arrayName = array('status' =>200 ,'menssage'=>'Contrato renovado de forma correcta','statusText'=>'OK');
			$this->db->trans_complete();
			$this->response($arrayName);
		}
		elseif($objSalida->SinMod==false && $objSalida->ConMod==true)
		{			
			$this->Contratos_model->update_status_contrato_modificaciones($objSalida->CodCli,$objSalida->CodConCom,0,1,1,4);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Estatus Contrato Con modificaciones.');
			$arrayName = array('status' =>200,'menssage'=>'Debe registrar una nueva Propuesta Comercial','statusText'=>'OK' );
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
	public function getContratosFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Contratos_model->getContratosFilter($objSalida->filtrar_search);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Contratos Comerciales Filtrados');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function generar_audax_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		
		$Contactos=$this->Contratos_model->getaudaxcontactos($objSalida->CodCli,$objSalida->CodConCom,$objSalida->CodProCom);
		$CuentasBancarias=$this->Contratos_model->getaudaxcuentasbancarias($objSalida->CodCli);	
		$arrayName = array('Contactos' =>$Contactos ,'CuentasBancarias'=>$CuentasBancarias );
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','SEARCH',null,$this->input->ip_address(),'Comprobando Representante Legal');
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','SEARCH',null,$this->input->ip_address(),'Comprobando Cuentas Bancarias');
		$this->db->trans_complete();
		$this->response($arrayName);
	}
	public function HuerImpli_get()
	{
		$opcion_select=$this->get('opcion_select');
		$CodConCom=$this->get('CodConCom');
		$CambiarEstatus=$this->Contratos_model->NuevoEstatusContratos($CodConCom,$opcion_select);	
		$this->response($CambiarEstatus);
	}
	public function GenerarSepaClientes_get()
	{
		//$opcion_select=$this->get('opcion_select');
		$CodCli=$this->get('CodCli');
		$CodProCom=$this->get('CodProCom');
		$CodConCom=$this->get('CodConCom');
		$DatosClienteCuentasBancarias=$this->Contratos_model->getaudaxcuentasbancariasColaboradores($CodCli,$CodProCom,$CodConCom);	
		$detalleFinal = Array();
		$detalleFinal2 = Array();
		foreach ($DatosClienteCuentasBancarias as $key => $value):
		{
			$detalleG = $this->Contratos_model->getCuentasClientes($value->CodCli);			
			if($detalleG!=false)
			{
				foreach ($detalleG as $key => $valueDetalleG): 
				{
					array_push($detalleFinal2, $valueDetalleG);
				}
				endforeach;
			}
		}
		endforeach;
		$this->response($detalleFinal2);
	}
	public function AsignarPropuestaContrato_get()
	{
		$CodCli=$this->get('CodCli');
		$RefProCom=$this->generar_RefProCom();
		$FecProCom=date('d/m/Y');
		$Puntos_Suministros=$this->Clientes_model->get_data_puntos_suministros($CodCli);
		$tabla_Ele="T_TarifaElectrica";
		$orderby="NomTarEle ASC";
		$TarEle=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
		$tabla_Gas="T_TarifaGas";
		$orderby="NomTarGas ASC";
		$TarGas=$this->Propuesta_model->Tarifas($tabla_Gas,$orderby);
		$T_Comercializadora="T_Comercializadora";
		$orderby="RazSocCom ASC";
		$Comercializadoras=$this->Propuesta_model->Tarifas($T_Comercializadora,$orderby);


		$arrayName = array('RefProCom' =>$RefProCom ,'FecProCom' =>$FecProCom,'Puntos_Suministros' =>$Puntos_Suministros,'TarEle' =>$TarEle,'TarGas' =>$TarGas,'Comercializadoras'=>$Comercializadoras);
		$this->response($arrayName);
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
	public function realizar_filtro_get()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$metodo=$this->get('metodo');	
		$PrimaryKey=$this->get('PrimaryKey');	
	    
		if($metodo==1)
		{
			$tabla="T_Producto";
			$buscando="Buscando Productos de Las Comercializadoras";
			$response=$this->Propuesta_model->ProductosComercia($PrimaryKey);
		}
		elseif ($metodo==2) 
		{
			$tabla="T_AnexoProducto";
			$buscando="Buscando Anexos de Las Comercializadoras";
			$response=$this->Propuesta_model->ProductosAnexos($PrimaryKey);
		}
		elseif ($metodo==3) 
		{
			$tabla="T_AnexoProducto";
			$buscando="Buscando Tipo de Precio del Anexo";			
			$where="CodAnePro";	
			$select='TipPre';	
	        $response = $this->Propuesta_model->Funcion_Verificadora($PrimaryKey,$tabla,$where,$select); 
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$PrimaryKey,$this->input->ip_address(),$buscando);
		$this->response($response);		
	}       
	public function generar_RefProCom()
    {
    	$nCaracteresFaltantes = 0;
		$numero_a = " ";
		/*Ahora necesitamos el numero de la Referencia de la Propuesta*/
		$queryIdentificador = $this->db->query("SELECT CodMov,DesMov,NrMov FROM T_Movimientos WHERE CodMov=1");
		$rowIdentificador = $queryIdentificador->row();
		//buscamos que longitud tiene el numero generado por la base de datos y completamos con ceros a la izquierda
		$nCaracteresFaltantes = 12 - strlen($rowIdentificador->NrMov) ;
		$numero_a = str_repeat('0',$nCaracteresFaltantes);
		$numeroproximo = $rowIdentificador->NrMov + 1;
		$nCaracteresFaltantesC = 12 - strlen($rowIdentificador->NrMov); //VERIFICAR CUANDO PASE DE 100
		$numero_aC = str_repeat('0',$nCaracteresFaltantesC);
		$numeroproximoC = $rowIdentificador->NrMov + 1;
		$numeroC = $numero_aC . (string)$rowIdentificador->NrMov;
		$this->db->query("UPDATE T_Movimientos SET NrMov=".$numeroproximo." WHERE CodMov=1");
		return $numeroC;		
    }
    public function AsignarPropuestaContrato_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		
		$CodProCom=$this->Contratos_model->AsignarPropuesta($objSalida-> CodCli,$objSalida-> FecProCom,$objSalida-> CodPunSum,$objSalida-> CodCupSEle,$objSalida-> CodTarEle,$objSalida-> PotConP1,$objSalida-> PotConP2,$objSalida-> PotConP3,$objSalida-> PotConP4,$objSalida-> PotConP5,$objSalida-> PotConP6,$objSalida-> ImpAhoEle,$objSalida-> PorAhoEle,$objSalida-> RenConEle,$objSalida-> ObsAhoEle,$objSalida-> CodCupGas,$objSalida-> CodTarGas,$objSalida-> Consumo,$objSalida-> CauDia,$objSalida-> ImpAhoGas,$objSalida-> PorAhoGas,$objSalida-> RenConGas,$objSalida-> ObsAhoGas,$objSalida-> PorAhoTot,$objSalida-> ImpAhoTot,$objSalida-> CodCom,$objSalida-> CodPro,$objSalida-> CodAnePro,$objSalida-> TipPre,$objSalida-> ObsProCom,$objSalida-> RefProCom);
		$objSalida-> CodProCom=$CodProCom;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','INSERT',$CodProCom,$this->input->ip_address(),'Asignado Propuesta Comercial a Contrato');
		$Contrato=$this->Contratos_model->UpdateContratoFromPropuesta($objSalida-> CodConCom,$objSalida-> CodCli,$CodProCom);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida-> CodConCom,$this->input->ip_address(),'Actualizando Contrato Comercial');
		$arrayName = array('status' =>200 ,'statusText'=>'OK','objSalida'=>$objSalida,'menssage'=>'Propuesta Comercial Asignada correctamente ahora puede solicitar la renovación del contrato.' );		
		$this->db->trans_complete();
		$this->response($arrayName);
	}
	public function agregar_documento_contrato_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		if($_POST['CodConCom']=="undefined")
		{
			$this->response(array('status'=>404,'menssage'=>'Error debe generar un número de contrato primero para poder guardar un documento.','statusText'=>'Error'));
			return false;
		}
		$this->db->trans_start();
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
			$CodDetDocCon=$this->Contratos_model->agregar_documentos($_POST['CodConCom'],$data[0]['file_name'],$data[0]['file_ext'],$data[0]['raw_name']);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_DetalleDocumentosContratos','INSERT',$CodDetDocCon,$this->input->ip_address(),'Registro de Documento del Contrato');
			$this->db->trans_complete();	
			$this->response(array('CodDetDocCon'=>$CodDetDocCon,'file_ext'=>$data[0]['file_ext'],'CodConCom'=>$_POST['CodConCom'],'DocGenCom'=>$data[0]['raw_name'],'DocConRut'=>$data[0]['file_name'],'status' =>200,'statusText' =>'OK','menssage'=>'Archivo cargado correctamente.'));
		}		
	}
	public function borrar_documento_contrato_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    	$CodDetDocCon=$this->get('CodDetDocCon');
    	$tabla="T_DetalleDocumentosContratos";
		$where="CodDetDocCon";	
		$select='*'; 
		$DocumentoArchivo = $this->Propuesta_model->Funcion_Verificadora($CodDetDocCon,$tabla,$where,$select);
		if($DocumentoArchivo==false)
		{
			$arrayName = array('status' =>404,'menssage' =>'Error Con el archivo o no existe','statusText' =>'Error');
			$this->response($arrayName);
			return false;
		}
		$path_to_file = './uploads/'.$DocumentoArchivo-> DocConRut;
		//$path_to_file = './uploads/emmy.jpg';
		$exists = file_exists($path_to_file);
		if($exists==true)
		{
			if(unlink($path_to_file)) 
			{
			    $statusFile='Delete success';
			}
			else
			{
			    $statusFile='errors occured';
			}
		}
		else
		{
			$statusFile='El archivo que esta intentado borrar no existe en nuestro servidor.';
		}
		$DocumentoArchivo = $this->Contratos_model->borrar_documentoDB($CodDetDocCon);		
		$arrayName = array('status' =>200,'menssage' =>'Archivo borrado correctamente.','statusText' =>'OK','DocumentoArchivo'=>$DocumentoArchivo,'statusFile'=>$statusFile);
    	$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'DELETE',$CodDetDocCon,$this->input->ip_address(),'Borrando archivo de contrato');
    	$this->response($arrayName);
	}
	public function TramitarConAudaxAPI_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));			
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://webservice.audaxenergia.com:8080/WSAudaxTest/Login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"UserId": "EnerSpain",
			"Password": "1404"
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

	}

	public function DatosParaAudax_post()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));	
		$this->db->trans_start();				
		if($objSalida-> TipProCom==1 || $objSalida-> TipProCom==2)
		{
			$Cliente = $this->Contratos_model->DatosClientesAudax($objSalida->CodCli);
			$DatosContactoCliente=$this->Contratos_model->DatosContactosClientesAudax($objSalida->CodCli);
			$DatosCuentaClientes=$this->Contratos_model->DatosCuentaClientesAudax($objSalida->CodCli);
		}
		else
		{
			$Cliente = $this->Contratos_model->DatosClientesColaboradorAudax($objSalida->CodCli);
			$DatosContactoCliente=false;
			$DatosCuentaClientes=false;
		}		
		if($DatosContactoCliente==false)
		{
			$NomConCli='';
            $CarConCli='';
            $NIFConCli='';
            $direccion_contacto='';
            $tipovia_contacto='';
            $numdire_contacto='';
            $pisodire_contacto='';
            $cp_contacto='';
            $TelCelConCli='';
            $TelFijConCli='';                       
            $EmaConCli='';
		}
		else
		{
			$NomConCli=$DatosContactoCliente-> NomConCli;
            $CarConCli=$DatosContactoCliente-> CarConCli;
            $NIFConCli=$DatosContactoCliente-> NIFConCli;
            $direccion_contacto='';
            $tipovia_contacto='';
            $numdire_contacto='';
            $pisodire_contacto='';
            $cp_contacto='';
            $TelCelConCli=$DatosContactoCliente-> TelCelConCli;
            $TelFijConCli=$DatosContactoCliente-> TelFijConCli;                       
            $EmaConCli=$DatosContactoCliente-> EmaConCli;
		}		
		if($DatosCuentaClientes==false)
		{
			$iban='';
			$entidad='';
			$sucursal='';
			$dc='';
			$cuenta='';
		}
		else
		{
			$iban=$DatosCuentaClientes-> iban;
			$entidad=$DatosCuentaClientes-> entidad;
			$sucursal=$DatosCuentaClientes-> sucursal;
			$dc=$DatosCuentaClientes-> dc;
			$cuenta=$DatosCuentaClientes-> cuenta;
		}
		$DatosContrato=$this->Contratos_model->DatosContratoClientesAudax($objSalida->CodConCom);
		if($DatosContrato!=false)
		{
			$duracion=$DatosContrato-> DurCon;
			$tipo_contrato_comentario=$DatosContrato-> ObsProCom;
			$tipo_contrato=$DatosContrato-> TipPre;
			$fecha_firma=$DatosContrato-> FecFirmCon;
			$fecha_inicio_corporate=$DatosContrato-> FecConCom;
		}
		else
		{
			$duracion='';
			$tipo_contrato_comentario='';
			$tipo_contrato='';
			$fecha_firma='';
			$fecha_inicio_corporate='';
		}
		$DetallesCUPs=$this->Contratos_model->DatosDetallesCUPsClientesAudax($objSalida->CodProCom);
		$arrayResponseByAudax = array('CPLocSoc'=> $Cliente-> CPLocSoc,'DesLoc'=> $Cliente-> DesLoc,'DesPro'=> $Cliente-> DesPro,'DesTipVia'=> $Cliente-> DesTipVia,'EscDomCliEnv'=> $Cliente-> EscDomCliEnv,'EscDomSoc'=> $Cliente-> EscDomSoc,'IniTipVia'=> $Cliente-> IniTipVia,'NomViaDomSoc'=> $Cliente-> NomViaDomSoc,'NumCifCli'=> $Cliente-> NumCifCli,'NumViaDomSoc'=> $Cliente-> NumViaDomSoc,'PueDomCliEnv'=> $Cliente-> PueDomCliEnv,'PueDomSoc'=> $Cliente-> PueDomSoc,'RazSocCli'=> $Cliente-> RazSocCli,'TelFijCli'=>$Cliente-> TelFijCli,'TelMovCli'=>$Cliente-> TelMovCli,'EmaCli'=>$Cliente-> EmaCli,
		'NomConCli'=>$NomConCli, 'CarConCli'=>$CarConCli, 'NIFConCli'=>$NIFConCli, 'direccion_contacto'=>$direccion_contacto, 'tipovia_contacto'=>$tipovia_contacto, 'numdire_contacto'=>$numdire_contacto, 'pisodire_contacto'=>$pisodire_contacto, 'cp_contacto'=>$cp_contacto, 'TelCelConCli'=>$TelCelConCli, 'TelFijConCli'=>$TelFijConCli, 'EmaConCli'=>$EmaConCli,

		'iban'=>$iban,'entidad'=>$entidad,'sucursal'=>$sucursal,'dc'=>$dc,'cuenta'=>$cuenta,

		'DetallesCUPs'=>$DetallesCUPs,

		'duracion'=>$duracion,'tipo_contrato_comentario'=>$tipo_contrato_comentario,'tipo_contrato'=>$tipo_contrato,'fecha_firma'=>$fecha_firma,'fecha_inicio_corporate'=>$fecha_inicio_corporate,

		 );
		

		$this->db->trans_complete();
		$this->response($arrayResponseByAudax);			
	}
}
?>