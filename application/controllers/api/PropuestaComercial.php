<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class PropuestaComercial extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Propuesta_model');
		$this->load->model('Clientes_model');
		$this->load->model('Contratos_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
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
		$tabla="T_PropuestaComercial a";
		$where="b.CodCli";
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
		else
		{
			$response = array('status' =>200 ,'menssage' =>'Se encontraron contratos asignados al cliente','statusText'=>'OK','Contratos'=>$BuscarContrato);
			$this->response($response);			
		}	

		
		/*foreach ($BuscarContrato as $record): 
		{
			if($record->ProRenPen==1)
			{
				$response = array('status' =>true ,'menssage' =>'Tiene contrato Pero debe crear propuesta porque se solicito con modificaciones la propuesta.','statusText'=>'Contrato','Contrato'=>$record);
			}
			else
			{
				$response = array('status' =>false ,'menssage' =>'Este cliente ya tiene un contrato vigente.','statusText'=>'Error');	
			}
		}
		endforeach;*/
		//$this->response($response);

		/*if($BuscarContrato->ProRenPen==1)
		{
			$response = array('status' =>true ,'menssage' =>'Tiene contrato Pero debe crear propuesta porque se solicito con modificaciones la propuesta.','statusText'=>'Contrato','Contrato'=>$BuscarContrato);
		}
		else
		{
			$response = array('status' =>false ,'menssage' =>'Este cliente ya tiene un contrato vigente.','statusText'=>'Error');
		}
		$this->response($response);*/

		
    }
    public function get_valida_datos_Colaborador_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$NumCifCli=$this->get('NumCifCli');
		$tabla="T_Colaborador";
		$where="NumIdeFis";	
		$select='CodCol as CodCli,NumIdeFis as NumCifCli';	
        $Colaborador = $this->Propuesta_model->Funcion_Verificadora($NumCifCli,$tabla,$where,$select);        
		if (empty($Colaborador))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',null,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',$Colaborador->CodCli,$this->input->ip_address(),'Número de CIF Encontrado.');		
		$tabla="T_PropuestaComercial a";
		$where="b.CodCli";
		$BuscarPropuesta=$this->Propuesta_model->Buscar_PropuestaCol($Colaborador->CodCli,$tabla,$where);
		if($BuscarPropuesta!=false)
		{
			$response = array('status' =>false ,'menssage' =>'El Cliente tiene una Propuesta Comercial con estatus pendiente con número de referencia: '.$BuscarPropuesta->RefProCom,'statusText'=>'Error');
			$this->response($response);	
			return false;
		}	
		$BuscarContrato=$this->Propuesta_model->Buscar_ContratosCol($Colaborador->CodCli);
		if($BuscarContrato==false)
		{
			$response = array('status' =>true ,'menssage' =>'Cliente sin ningun contrato puede generar una propuesta.','statusText'=>'Propuesta_Nueva','CodCli'=>$Colaborador->CodCli);
			$this->response($response);
			return false;
		}
		else
		{
			$response = array('status' =>200 ,'menssage' =>'Se encontraron contratos asignados al cliente','statusText'=>'OK','Contratos'=>$BuscarContrato);
			$this->response($response);			
		}		
    }
    public function getDataServerMultiClienteMultiPunto_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');
		$tabla="T_Colaborador";
		$where="CodCol";	
		$select='CodCol as CodCli,NumIdeFis as NumCifCli,NomCol as RazSocCli';	
        $Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select);        
		if (empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
		}
		$Tabla='T_Comercializadora';
		$order_by="RazSocCom ASC";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$Referencia=$this->generar_RefProCom();			
		$arrayName = array('CodCli'=>$Cliente-> CodCli,'NumCifCli'=>$Cliente-> NumCifCli,'RazSocCli'=>$Cliente-> RazSocCli,'Referencia'=>$Referencia,'Fecha_Propuesta'=>date('d/m/Y'),'Comercializadoras'=>$Comercializadoras);
		$this->response($arrayName);
	}
    public function get_list_propuesta_clientes_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}			
        $Propuestas = $this->Propuesta_model->get_list_propuesta_clientes_all();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','GET',null,$this->input->ip_address(),'Cargando Lista de Propuesta de Clientes.');        
		if (empty($Propuestas))
		{		
			$this->response(false);
			return false;
		}
		$this->response($Propuestas);
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
	public function getColaboradores_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		$consulta=$this->Clientes_model->getColaboraresSearch($objSalida->NumCifCli);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','SEARCH',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function get_data_clientes_propuestas_get()
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
		if (empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
		}
		$Referencia=$this->generar_RefProCom();
		$Cliente->Referencia=$Referencia;
		$Cliente->Fecha_Propuesta=date('d/m/Y');
		$Puntos_Suministros=$this->Clientes_model->get_data_puntos_suministros($CodCli);
		$tabla_Ele="T_TarifaElectrica";
		$orderby="NomTarEle ASC";
		$TarEle=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
		$tabla_Gas="T_TarifaGas";
		$orderby="NomTarGas ASC";
		$TarGas=$this->Propuesta_model->Tarifas($tabla_Gas,$orderby);
		$Tabla='T_Comercializadora';
		$order_by="RazSocCom ASC";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$TarGas=$this->Propuesta_model->Tarifas($tabla_Gas,$orderby);
			
		$arrayName = array('Cliente' =>$Cliente,'Puntos_Suministros' =>$Puntos_Suministros,'TarEle' => $TarEle,'TarGas'=>$TarGas,'Comercializadoras'=>$Comercializadoras);
		$this->response($arrayName);
	}
	public function getDataServer_get()
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
		if (empty($Cliente))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodCli,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
		}
		$Tabla='T_Comercializadora';
		$order_by="RazSocCom ASC";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$Referencia=$this->generar_RefProCom();			
		$arrayName = array('CodCli'=>$Cliente-> CodCli,'NumCifCli'=>$Cliente-> NumCifCli,'RazSocCli'=>$Cliente-> RazSocCli,'Referencia'=>$Referencia,'Fecha_Propuesta'=>date('d/m/Y'),'Comercializadoras'=>$Comercializadoras);
		$this->response($arrayName);
	}
	public function GetCUPsTar_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$MetodoCUPs=$this->get('MetodoCUPs');
		$CodCli=$this->get('CodCli');
			
		if($MetodoCUPs==1)
		{
			$CUPs=$this->Propuesta_model->get_CUPs_Electricos($CodCli);
			if(empty($CUPs))
			{
				$arrayName = array('status'=>404,'menssage'=>'No se encontraron CUPs Eléctricos asignados a este cliente' ,'statusText'=>false);
				$this->response($arrayName);
				return false;
			}
			$tabla_Ele="T_TarifaElectrica";
			$orderby="NomTarEle ASC";
			$TarEle=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
			$arrayName = array('status'=>200,'menssage'=>'CUPs Encontrados' ,'statusText'=>'OK','CUPs'=>$CUPs,'TarEle'=>$TarEle);
			$this->response($arrayName);
		}
		elseif ($MetodoCUPs==2) 
		{
			$CUPs=$this->Propuesta_model->get_CUPs_Gas($CodCli);
			if(empty($CUPs))
			{
				$arrayName = array('status'=>404,'menssage'=>'No se encontraron CUPs Gas asignados a este cliente' ,'statusText'=>false);
				$this->response($arrayName);
				return false;
			}
			$tabla_Ele="T_TarifaGas";
			$orderby="NomTarGas ASC";
			$TarGas=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
			$arrayName = array('status'=>200,'menssage'=>'CUPs Encontrados' ,'statusText'=>'OK','CUPs'=>$CUPs,'TarGas'=>$TarGas);
			$this->response($arrayName);
		
		}	
		else
		{

		}
		//$arrayName = array('CodCli'=>$Cliente-> CodCli,'NumCifCli'=>$Cliente-> NumCifCli,'RazSocCli'=>$Cliente-> RazSocCli,'Referencia'=>$Referencia,'Fecha_Propuesta'=>date('d/m/Y'),'Comercializadoras'=>$Comercializadoras);
		//$this->response($arrayName);
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
    public function generar_propuesta_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));	
		
		if($objSalida->EstProCom=="C")
		{
			$response = array('status' =>false ,'menssage' =>'Un Propuesta Completada no se puede modificar.','statusText'=>'Error');
				$this->response($response);	
				return false;	
		}
		if($objSalida->tipo=='nueva')
		{
			$this->db->trans_start();
			$tabla="T_PropuestaComercial a";
			$where="b.CodCli";
			$BuscarPropuesta=$this->Propuesta_model->Buscar_Propuesta($objSalida->CodCli,$tabla,$where);
			if($BuscarPropuesta!=false)
			{
				$response = array('status' =>false ,'menssage' =>'El Cliente tiene una Propuesta Comercial con estatus pendiente con número de referencia: '.$BuscarPropuesta->RefProCom,'statusText'=>'Error');
				$this->response($response);	
				return false;
			}
			//$BuscarContrato=$this->Propuesta_model->Buscar_Contratos($objSalida->CodCli);
			//if($BuscarContrato==false)
			//{
				$CodProCom=$this->Propuesta_model->agregar_propuesta($objSalida->FecProCom,$objSalida->TipProCom,$objSalida->PorAhoTot,$objSalida->ImpAhoTot,$objSalida->EstProCom,null,$objSalida->CodCom,$objSalida->CodPro,$objSalida->CodAnePro,$objSalida->TipPre,$objSalida->ObsProCom,$objSalida->RefProCom);
				$CodProComCli=$this->Propuesta_model->agregar_propuesta_comercial_clientes($CodProCom,$objSalida->CodCli);
				foreach ($objSalida->detalleCUPs as $key => $value):
				{					
					if($objSalida->TipProCom==1)
					{
						$CodPunSum=$objSalida-> CodPunSum;
					}
					else
					{
						$CodPunSum=$value-> CodPunSum;
					}
					$this->Propuesta_model->agregar_detallesCUPs($CodProComCli,$CodPunSum,$value->CodCups,$value->CodTar,$value->PotConP1,$value->PotConP2,$value->PotConP3,$value->PotConP4,$value->PotConP5,$value->PotConP6,$value->RenCon,$value->ImpAho,$value->PorAho,$value->ObsCup,$value->ConCUPs,$value->CauDia,$value->TipServ);
				}
				endforeach;					
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','INSERT',$CodProCom,$this->input->ip_address(),'Generando Propuesta Comercial Para Contrato.');
				$this->db->trans_complete();
				$this->response($objSalida);
			/*}
			else
			{
				$arrayName = array('status' =>false,'menssage'=>'Cliente con contrato valla al modulo de contrato para mas información.','statusText'=>"Error" );
				$this->response($arrayName);
			}*/
		}
		elseif($objSalida->tipo=='ver')
		{
			
			if($objSalida->Apro==true && $objSalida->Rech==false)
			{
				$updatePropuesta=$this->Propuesta_model->update_view_propuesta($objSalida->CodProCom,null,'A');
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada de forma correcta','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Aprobada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}
			}
			if($objSalida->Rech==true && $objSalida->Apro==false)
			{
				$updatePropuesta=$this->Propuesta_model->update_view_propuesta($objSalida->CodProCom,$objSalida->JusRecProCom,'R');
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada de forma correcta','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Rechazada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}				
			}
		}
		elseif($objSalida->tipo=='editar')
		{
			if($objSalida->Apro==true && $objSalida->Rech==false)
			{
				//$updatePropuesta=$this->Propuesta_model->update_edit_propuesta($objSalida->CauDia,$objSalida->CodAnePro,$objSalida->CodCli,$objSalida->CodCom,$objSalida->CodCupGas,$objSalida->CodCupSEle,$objSalida->CodPro,$objSalida->CodProCom,$objSalida->CodPunSum,$objSalida->CodTarEle,$objSalida->CodTarGas,$objSalida->Consumo,'A',$objSalida->FecProCom,$objSalida->ImpAhoEle,$objSalida->ImpAhoGas,$objSalida->ImpAhoTot,$objSalida->JusRecProCom,$objSalida->ObsAhoEle,$objSalida->ObsAhoGas,$objSalida->ObsProCom,$objSalida->PorAhoEle,$objSalida->PorAhoGas,$objSalida->PorAhoTot,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->RefProCom,$objSalida->RenConEle,$objSalida->RenConGas,$objSalida->TipPre,$objSalida->ConCupsEle);				
				$updatePropuesta=$this->Propuesta_model->update_edit_propuesta($objSalida-> CodProCom,$objSalida-> CodCom,$objSalida-> CodPro,$objSalida-> CodAnePro,$objSalida-> TipPre,$objSalida-> ImpAhoTot,$objSalida-> PorAhoTot,'A',$objSalida-> RefProCom,null);
				$SelectCUPsForHistorial=$this->Propuesta_model->SelectHistorialCUPs($objSalida-> CodProComCli);
				if($SelectCUPsForHistorial!=false)
				{
					foreach ($SelectCUPsForHistorial as $key => $value): {
					
					$this->Propuesta_model->agregar_detallesHistorialCUPs($value-> CodProComCli,$value->CodPunSum,$value->CodCup,$value->CodTar,$value->PotEleConP1,$value->PotEleConP2,$value->PotEleConP3,$value->PotEleConP4,$value->PotEleConP5,$value->PotEleConP6,$value->RenCup,$value->ImpAho,$value->PorAho,$value->ObsCup,$value->ConCup,$value->CauDiaGas,$value->TipCups);
					}
					endforeach;
				}
				$this->Propuesta_model->EliminarCUPs($objSalida-> CodProComCli);
				foreach ($objSalida->detalleCUPs as $key => $value):
				{					
					if($objSalida->TipProCom==1)
					{
						$CodPunSum=$objSalida-> CodPunSum;
					}
					else
					{
						$CodPunSum=$value-> CodPunSum;
					}
					$this->Propuesta_model->agregar_detallesCUPs($objSalida-> CodProComCli,$CodPunSum,$value->CodCups,$value->CodTar,$value->PotConP1,$value->PotConP2,$value->PotConP3,$value->PotConP4,$value->PotConP5,$value->PotConP6,$value->RenCon,$value->ImpAho,$value->PorAho,$value->ObsCup,$value->ConCUPs,$value->CauDia,$value->TipServ);
				}
				endforeach;
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada de forma correcta','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Aprobada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}
			}
			if($objSalida->Rech==true && $objSalida->Apro==false)
			{
				$updatePropuesta=$this->Propuesta_model->update_edit_propuesta($objSalida-> CodProCom,$objSalida-> CodCom,$objSalida-> CodPro,$objSalida-> CodAnePro,$objSalida-> TipPre,$objSalida-> ImpAhoTot,$objSalida-> PorAhoTot,'R',$objSalida-> RefProCom,$objSalida->JusRecProCom);


				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada de forma correcta','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Aprobada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}							
			}
		}
		elseif($objSalida->tipo=='renovar')
		{
			$CodProCom=$this->Propuesta_model->agregar_propuesta($objSalida->CodCli,$objSalida->FecProCom,$objSalida->CodPunSum,$objSalida->CodCupSEle,$objSalida->CodTarEle,$objSalida->ImpAhoEle,$objSalida->PorAhoEle,$objSalida->RenConEle,$objSalida->ObsAhoEle,$objSalida->CodCupGas,$objSalida->CodTarGas,$objSalida->ImpAhoGas,$objSalida->PorAhoGas,$objSalida->RenConGas,$objSalida->ObsAhoGas,$objSalida->PorAhoTot,$objSalida->ImpAhoTot,$objSalida->EstProCom,$objSalida->JusRecProCom,$objSalida->CodCom,$objSalida->CodPro,$objSalida->CodAnePro,$objSalida->TipPre,$objSalida->ObsProCom,$objSalida->RefProCom,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->CauDia,$objSalida->Consumo,$objSalida->ConCupsEle);			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','INSERT',$CodProCom,$this->input->ip_address(),'Generando Propuesta Comercial Para Contrato Con Modificaciones.');
			$this->Contratos_model->update_status_contrato_modificaciones($objSalida->CodCli,$objSalida->CodConCom,1,1,0,3);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Contrato Comercial Con Nuevo Propuesta Generada Con Modificaciones.');
			$this->db->trans_complete();
				$this->response($objSalida);
		}


		else
		{
			$arrayName = array('status' =>false,'menssage'=>'Ruta invalida introduzca modulo/nueva.','statusText'=>"Error" );
			$this->response($arrayName);
		}		
    }
    public function get_propuesta_comercial_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}			
        $CodProCom=$this->get('CodProCom');
        $select="CodProCom,date_format(FecProCom,'%d/%m/%Y') as FecProCom,RefProCom,EstProCom,CodCon,PorAhoTot,ImpAhoTot,JusRecProCom,CodCom,CodPro,CodAnePro,TipPre,ObsProCom,TipProCom,UltTipSeg";
        $tabla="T_PropuestaComercial";
		$where="CodProCom";
		$BuscarPropuesta=$this->Propuesta_model->Funcion_Verificadora($CodProCom,$tabla,$where,$select);		
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodProCom,$this->input->ip_address(),'Buscando Propuesta Comercial.');        
		if (empty($BuscarPropuesta))
		{		
			$this->response(false);
			return false;
		}
		$select="*";
        $tabla="T_Propuesta_Comercial_Clientes";
		$where="CodProCom";
		$T_Propuesta_Comercial_Clientes=$this->Propuesta_model->Funcion_Verificadora($CodProCom,$tabla,$where,$select);
		$select="RazSocCli,NumCifCli";
        $tabla="T_Cliente";
		$where="CodCli";
		$Cliente=$this->Propuesta_model->Funcion_Verificadora($T_Propuesta_Comercial_Clientes->CodCli,$tabla,$where,$select);
		$Puntos_Suministros=$this->Clientes_model->get_data_puntos_suministros($T_Propuesta_Comercial_Clientes->CodCli);
		$tabla_Ele="T_TarifaElectrica";
		$orderby="NomTarEle ASC";
		$TarEle=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
		$tabla_Gas="T_TarifaGas";
		$orderby="NomTarGas ASC";
		$TarGas=$this->Propuesta_model->Tarifas($tabla_Gas,$orderby);
		/*$CUPs_Gas=$this->Clientes_model->get_CUPs_Gas($BuscarPropuesta->CodPunSum);
	    $CUPs_Electricos=$this->Clientes_model->get_CUPs_Electricos($BuscarPropuesta->CodPunSum);*/
		$Tabla='T_Comercializadora';
		$order_by="RazSocCom ASC";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		if($BuscarPropuesta->RefProCom==null)
		{		
			$Referencia=$this->generar_RefProCom();
			$BuscarPropuesta->RefProCom=$Referencia;
		}
		$arrayName = array('Propuesta' =>$BuscarPropuesta,'Cliente' =>$Cliente,'Puntos_Suministros' =>$Puntos_Suministros,'Comercializadoras' =>$Comercializadoras,'TarEle' =>$TarEle,'TarGas' =>$TarGas,'CodProComCli'=>$T_Propuesta_Comercial_Clientes->CodProComCli,'CodCli'=>$T_Propuesta_Comercial_Clientes->CodCli   /*,'CUPs_Gas' =>$CUPs_Gas,'CUPs_Electricos' =>$CUPs_Electricos*/);
		$this->response($arrayName);
    }
    public function get_propuesta_renovacion_contrato_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}			
	        $CodCli=$this->get('CodCli');
	        $CodConCom=$this->get('CodConCom');
	        $CodProCom=$this->get('CodProCom');
	        $tabla="T_Cliente";
			$where="CodCli";
			$select="CodCli,RazSocCli,NumCifCli";
			$Cliente=$this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodCli,$this->input->ip_address(),'Buscando Datos del Cliente.');
			if (empty($Cliente))
			{		
				$this->response(false);
				return false;
			}
			$FechaServer=date('d/m/Y');
			$RefProCom=$this->generar_RefProCom();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Movimientos','GET',null,$this->input->ip_address(),'Generando Número de Referencia.');
			
			$select="CodProCom,CodCli,CodPunSum,CodCupsEle,CodTarEle,ImpAhoEle,PorAhoEle,RenConEle,ObsAhoEle,CodCupsGas,CodTarGas,ImpAhoGas,PorAhoGas,RenConGas,ObsAhoGas,PorAhoTot,ImpAhoTot,EstProCom,JusRecProCom,CodCom,CodPro,CodAnePro,TipPre,UltTipSeg,ObsProCom,PotConP1,PotConP2,PotConP3,PotConP4,PotConP5,PotConP6,PotConP1,Consumo,CauDia";
	        $tabla="T_PropuestaComercial";
			$where="CodProCom";
			$BuscarPropuesta=$this->Propuesta_model->Funcion_Verificadora2($CodProCom,$tabla,$where,$select,'CodCli',$CodCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodProCom,$this->input->ip_address(),'Buscando Propuesta Comercial.');			
			$Puntos_Suministros=$this->Clientes_model->get_data_puntos_suministros($CodCli);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',$CodProCom,$this->input->ip_address(),'Buscado Puntos de Suministros.');      
			$tabla_Ele="T_TarifaElectrica";
			$orderby="NomTarEle ASC";
			$TarEle=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla_Ele,'GET',null,$this->input->ip_address(),'Buscado Tarifas Eléctricas.');
			$tabla_Gas="T_TarifaGas";
			$orderby="NomTarGas ASC";
			$TarGas=$this->Propuesta_model->Tarifas($tabla_Gas,$orderby);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla_Gas,'GET',null,$this->input->ip_address(),'Buscado Tarifas de Gas.');
			$tabla="T_Comercializadora";
			$orderby="RazSocCom ASC";
			$Comercializadora=$this->Propuesta_model->Tarifas($tabla,$orderby);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',null,$this->input->ip_address(),'Buscando Lista de Comercializadoras.');





			$arrayName = array('Cliente' => $Cliente,'FechaServer'=>$FechaServer,'RefProCom'=>$RefProCom,'BuscarPropuesta' => $BuscarPropuesta,'Puntos_Suministros'=>$Puntos_Suministros,'TarEle'=>$TarEle,'TarGas'=>$TarGas,'Comercializadora'=>$Comercializadora);			
			$this->response($arrayName);
         /*$select="CodProCom,CodCli,DATE_FORMAT(FecProCom, '%d/%m/%Y') as FecProCom,CodPunSum,CodCupsEle,CodTarEle,ImpAhoEle,PorAhoEle,RenConEle,ObsAhoEle,CodCupsGas,CodTarGas,ImpAhoGas,PorAhoGas,RenConGas,ObsAhoGas,PorAhoTot,ImpAhoTot,EstProCom,JusRecProCom,CodCom,CodPro,CodAnePro,TipPre,UltTipSeg,ObsProCom,RefProCom,PotConP1,PotConP2,PotConP3,PotConP4,PotConP5,PotConP6,PotConP1,Consumo,CauDia";
        $tabla="T_PropuestaComercial";
		$where="CodProCom";
		$BuscarPropuesta=$this->Propuesta_model->Funcion_Verificadora($CodProCom,$tabla,$where,$select);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$CodProCom,$this->input->ip_address(),'Buscando Propuesta Comercial.');        
		if (empty($BuscarPropuesta))
		{		
			$this->response(false);
			return false;
		}
		$select="RazSocCli,NumCifCli";
        $tabla="T_Cliente";
		$where="CodCli";
		$Cliente=$this->Propuesta_model->Funcion_Verificadora($BuscarPropuesta->CodCli,$tabla,$where,$select);
		$Puntos_Suministros=$this->Clientes_model->get_data_puntos_suministros($BuscarPropuesta->CodCli);
		$tabla_Ele="T_TarifaElectrica";
		$orderby="NomTarEle ASC";
		$TarEle=$this->Propuesta_model->Tarifas($tabla_Ele,$orderby);
		$tabla_Gas="T_TarifaGas";
		$orderby="NomTarGas ASC";
		$TarGas=$this->Propuesta_model->Tarifas($tabla_Gas,$orderby);
		$CUPs_Gas=$this->Clientes_model->get_CUPs_Gas($BuscarPropuesta->CodPunSum);
	    $CUPs_Electricos=$this->Clientes_model->get_CUPs_Electricos($BuscarPropuesta->CodPunSum);
	    $Tabla='T_Comercializadora';
		$order_by="RazSocCom ASC";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$arrayName = array('Propuesta' =>$BuscarPropuesta,'Cliente' =>$Cliente,'Puntos_Suministros' =>$Puntos_Suministros,'TarEle' =>$TarEle,'TarGas' =>$TarGas,'CUPs_Gas' =>$CUPs_Gas,'CUPs_Electricos' =>$CUPs_Electricos,'Comercializadoras' =>$Comercializadoras);
		$this->response($arrayName);*/
    }
    public function FiltrarPropuestaComercial_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$TipFilProCom=$this->get('TipFilProCom');
		if($TipFilProCom==1)
		{
			$response=$this->Propuesta_model->PropuestasSencillas();
			$this->response($response);
		}
		elseif($TipFilProCom==2)
		{
			$response=$this->Propuesta_model->PropuestasUniCliente();
			$this->response($response);
		}
		elseif($TipFilProCom==3)
		{
			$response=$this->Propuesta_model->PropuestasMulCliente();
			$this->response($response);
		}
	}
	public function BuscarDetallesCUPsSencilla_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodProComCli=$this->get('CodProComCli');
		$response=$this->Propuesta_model->BuscarDetallesCUPsSencilla($CodProComCli);
		if($response==false)
		{
			$this->response(false);
			return false;
		}
		$this->response($response);
	}
	public function GetProComUniCli_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodProCom=$this->get('CodProCom');
		$response=$this->Propuesta_model->BuscarProComUniCliente($CodProCom);
		if($response==false)
		{
			$this->response(false);
			return false;
		}
		$Tabla='T_Comercializadora';
		$order_by="RazSocCom";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$tabla="T_Cliente";
		$where="CodCli";
		$select="CodCli,RazSocCli,NumCifCli";
		$Cliente=$this->Propuesta_model->Funcion_Verificadora($response-> CodCli,$tabla,$where,$select);
		$CUPs=$this->Propuesta_model->GetDetallesCUPs($response-> CodProComCli);
		/*$detalleFinal = Array();
		foreach ($data as $key => $value):
		{
			$detalleG = $this->Colaboradores_model->getDataColaboradores($value->CodCol);
			
			array_push($detalleFinal, $detalleG);
		}
		endforeach;*/


		$arrayName = array('status'=>200,'statusText'=>'OK','menssage'=>'Propuesta Comerical UniCliente - MultiPunto','Propuesta' =>$response,'FechaServer'=>date('d/m/Y'),'Comercializadora'=>$Comercializadoras,'Cliente'=>$Cliente,'detalleCUPs'=>$CUPs);
		$this->response($arrayName);
	}
	public function GetProComMulCli_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodProCom=$this->get('CodProCom');
		$response=$this->Propuesta_model->BuscarProComUniCliente($CodProCom);
		if($response==false)
		{
			$this->response(false);
			return false;
		}
		$Tabla='T_Comercializadora';
		$order_by="RazSocCom";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$tabla="T_Colaborador";
		$where="CodCol";
		$select="CodCol as CodCli,NomCol as RazSocCli,NumIdeFis as NumCifCli";
		$Cliente=$this->Propuesta_model->Funcion_Verificadora($response-> CodCli,$tabla,$where,$select);
		$CUPs=$this->Propuesta_model->GetDetallesCUPs($response-> CodProComCli);
		/*$detalleFinal = Array();
		foreach ($data as $key => $value):
		{
			$detalleG = $this->Colaboradores_model->getDataColaboradores($value->CodCol);
			
			array_push($detalleFinal, $detalleG);
		}
		endforeach;*/
		$arrayName = array('status'=>200,'statusText'=>'OK','menssage'=>'Propuesta Comerical MultiCliente - MultiPunto','Propuesta' =>$response,'FechaServer'=>date('d/m/Y'),'Comercializadora'=>$Comercializadoras,'Cliente'=>$Cliente,'detalleCUPs'=>$CUPs);
		$this->response($arrayName);
	}








	























	public function Datos_Propuesta_Comerciales_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodCli=$this->get('CodCli');
		$CodConCom=$this->get('CodConCom');
		$CodProCom=$this->get('CodProCom');
		$tabla="T_Cliente";
		$where="CodCli";	
		$select='CodCli,RazSocCli,NumCifCli,NomComCli';	
        $Cliente = $this->Propuesta_model->Funcion_Verificadora($CodCli,$tabla,$where,$select);        
		if (empty($Cliente))
		{
			$response = array('status' =>false ,'menssage' =>'Cliente No Registrado.','statusText'=>'Cliente');
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',null,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response($response);
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$Cliente->CodCli,$this->input->ip_address(),'Número de CIF Encontrado.');	
		/*$tabla="T_PropuestaComercial";
		$where="CodCli";
		$BuscarPropuesta=$this->Propuesta_model->Buscar_Propuesta($Cliente->CodCli,$tabla,$where);
		if($BuscarPropuesta!=false)
		{
			$response = array('status' =>false ,'menssage' =>'El Cliente tiene una Propuesta Comercial con estatus pendiente.','statusText'=>'Error');
			$this->response($response);	
			return false;
		}
		$BuscarContrato=$this->Propuesta_model->Buscar_Contratos_Vali($CodCli,$CodConCom,$CodProCom);
		if($BuscarContrato==false)
		{
			$response = array('status' =>false ,'menssage' =>'Datos de busqueda incorrectos.','statusText'=>'Error');
			$this->response($response);	
		}*/

		//$this->response($BuscarContrato);
		/*$select_cliente='CodCli,RazSocCli,NumCifCli,NomComCli';
		$Datos_Clientes=$this->Propuesta_model->Funcion_Verificadora($CodCli,"T_Cliente","CodCli",$select_cliente);*/
		$select_propuesta='*';
		$Propuesta=$this->Propuesta_model->Buscar_Propuesta_Vali($CodCli,$CodProCom);		
		$Puntos_Suministros=$this->Clientes_model->get_data_puntos_suministros($CodCli);
		/*$Tabla='T_Comercializadora';
		$order_by="RazSocCom";
		$Comercializadoras=$this->Propuesta_model->Tarifas($Tabla,$order_by);
		$ProductosComercializadoras=$this->Propuesta_model->ProductosComercia($Propuesta->CodCom);
		$ProductosAnexos=$this->Propuesta_model->ProductosAnexos($Propuesta->CodPro);*/

		
		/*$New_Ref=$this->generar_RefProCom();
		$Fecha_Server=date('d/m/Y');*/
		$arrayName = array('Cliente' => $Cliente,'Propuesta' => $Propuesta,'Puntos_Suministros'=>$Puntos_Suministros/*,'New_Ref'=>$New_Ref,'Fecha'=>$Fecha_Server,,'Comercializadoras'=>$Comercializadoras,'ProductosComercializadoras'=>$ProductosComercializadoras,'ProductosAnexos'=>$ProductosAnexos*/);
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
	public function getPropuestasFilter_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		if($objSalida->metodo==1)
		{
			$consulta=$this->Propuesta_model->getPropuestaComercialesFilter($objSalida->filtrar_search);						
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Propuesta Comerciales Filtrados Sencillas');
			$this->db->trans_complete();
			$this->response($consulta);
		}
		elseif ($objSalida->metodo==2) 
		{
			$consulta=$this->Propuesta_model->PropuestasUniClienteFilter($objSalida->filtrar_searchUniCliente);						
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Propuesta Comerciales Filtrados UniCliente - MultiPunto');
			$this->db->trans_complete();
			$this->response($consulta);
		}
		elseif ($objSalida->metodo==3) 
		{
			$consulta=$this->Propuesta_model->PropuestasMulClienteFilter($objSalida->filtrar_searchUniCliente);						
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Propuesta Comerciales Filtrados UniCliente - MultiPunto');
			$this->db->trans_complete();
			$this->response($consulta);
		}
		
	}  
    




    
    
}
?>