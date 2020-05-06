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
		$tabla="T_PropuestaComercial";
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
		foreach ($BuscarContrato as $record): 
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
		endforeach;
		$this->response($response);

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
			$tabla="T_PropuestaComercial";
			$where="CodCli";
			$BuscarPropuesta=$this->Propuesta_model->Buscar_Propuesta($objSalida->CodCli,$tabla,$where);
			if($BuscarPropuesta!=false)
			{
				$response = array('status' =>false ,'menssage' =>'El Cliente tiene una Propuesta Comercial con estatus pendiente con número de referencia: '.$BuscarPropuesta->RefProCom,'statusText'=>'Error');
				$this->response($response);	
				return false;
			}
			$BuscarContrato=$this->Propuesta_model->Buscar_Contratos($objSalida->CodCli);
			if($BuscarContrato==false)
			{
				$CodProCom=$this->Propuesta_model->agregar_propuesta($objSalida->CodCli,$objSalida->FecProCom,$objSalida->CodPunSum,$objSalida->CodCupSEle,$objSalida->CodTarEle,$objSalida->ImpAhoEle,$objSalida->PorAhoEle,$objSalida->RenConEle,$objSalida->ObsAhoEle,$objSalida->CodCupGas,$objSalida->CodTarGas,$objSalida->ImpAhoGas,$objSalida->PorAhoGas,$objSalida->RenConGas,$objSalida->ObsAhoGas,$objSalida->PorAhoTot,$objSalida->ImpAhoTot,$objSalida->EstProCom,$objSalida->JusRecProCom,$objSalida->CodCom,$objSalida->CodPro,$objSalida->CodAnePro,$objSalida->TipPre,$objSalida->ObsProCom,$objSalida->RefProCom,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->CauDia,$objSalida->Consumo);			
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','INSERT',$CodProCom,$this->input->ip_address(),'Generando Propuesta Comercial Para Contrato.');
				$this->db->trans_complete();
				$this->response($objSalida);
			}
			else
			{
				$arrayName = array('status' =>false,'menssage'=>'Cliente con contrato valla al modulo de contrato para mas información.','statusText'=>"Error" );
				$this->response($arrayName);
			}
		}
		elseif($objSalida->tipo=='ver')
		{
			
			if($objSalida->Apro==true && $objSalida->Rech==false)
			{
				$updatePropuesta=$this->Propuesta_model->update_view_propuesta($objSalida->CodProCom,null,$objSalida->CodCli,'A');
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada correctamente.','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Aprobada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}
			}
			if($objSalida->Rech==true && $objSalida->Apro==false)
			{
				$updatePropuesta=$this->Propuesta_model->update_view_propuesta($objSalida->CodProCom,$objSalida->JusRecProCom,$objSalida->CodCli,'R');
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada correctamente.','statusText'=>"Propuesta Comercial" );
					
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
				$updatePropuesta=$this->Propuesta_model->update_edit_propuesta($objSalida->CauDia,$objSalida->CodAnePro,$objSalida->CodCli,$objSalida->CodCom,$objSalida->CodCupGas,$objSalida->CodCupSEle,$objSalida->CodPro,$objSalida->CodProCom,$objSalida->CodPunSum,$objSalida->CodTarEle,$objSalida->CodTarGas,$objSalida->Consumo,'A',$objSalida->FecProCom,$objSalida->ImpAhoEle,$objSalida->ImpAhoGas,$objSalida->ImpAhoTot,$objSalida->JusRecProCom,$objSalida->ObsAhoEle,$objSalida->ObsAhoGas,$objSalida->ObsProCom,$objSalida->PorAhoEle,$objSalida->PorAhoGas,$objSalida->PorAhoTot,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->RefProCom,$objSalida->RenConEle,$objSalida->RenConGas,$objSalida->TipPre);
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada correctamente.','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Aprobada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}
			}
			if($objSalida->Rech==true && $objSalida->Apro==false)
			{
				$updatePropuesta=$this->Propuesta_model->update_edit_propuesta($objSalida->CauDia,$objSalida->CodAnePro,$objSalida->CodCli,$objSalida->CodCom,$objSalida->CodCupGas,$objSalida->CodCupSEle,$objSalida->CodPro,$objSalida->CodProCom,$objSalida->CodPunSum,$objSalida->CodTarEle,$objSalida->CodTarGas,$objSalida->Consumo,'R',$objSalida->FecProCom,$objSalida->ImpAhoEle,$objSalida->ImpAhoGas,$objSalida->ImpAhoTot,$objSalida->JusRecProCom,$objSalida->ObsAhoEle,$objSalida->ObsAhoGas,$objSalida->ObsProCom,$objSalida->PorAhoEle,$objSalida->PorAhoGas,$objSalida->PorAhoTot,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->RefProCom,$objSalida->RenConEle,$objSalida->RenConGas,$objSalida->TipPre);
				if($updatePropuesta==true)
				{
					$arrayName = array('status' =>true,'menssage'=>'Propuesta Comercial actualizada correctamente.','statusText'=>"Propuesta Comercial" );
					
					$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','UPDATE',$objSalida->CodProCom,$this->input->ip_address(),'Actualizando Estatus de Propuesta Comercial a Aprobada.');
					$this->db->trans_complete();
					$this->response($arrayName);
				}							
			}
		}
		elseif($objSalida->tipo=='renovar')
		{
			$CodProCom=$this->Propuesta_model->agregar_propuesta($objSalida->CodCli,$objSalida->FecProCom,$objSalida->CodPunSum,$objSalida->CodCupSEle,$objSalida->CodTarEle,$objSalida->ImpAhoEle,$objSalida->PorAhoEle,$objSalida->RenConEle,$objSalida->ObsAhoEle,$objSalida->CodCupGas,$objSalida->CodTarGas,$objSalida->ImpAhoGas,$objSalida->PorAhoGas,$objSalida->RenConGas,$objSalida->ObsAhoGas,$objSalida->PorAhoTot,$objSalida->ImpAhoTot,$objSalida->EstProCom,$objSalida->JusRecProCom,$objSalida->CodCom,$objSalida->CodPro,$objSalida->CodAnePro,$objSalida->TipPre,$objSalida->ObsProCom,$objSalida->RefProCom,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->CauDia,$objSalida->Consumo);			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','INSERT',$CodProCom,$this->input->ip_address(),'Generando Propuesta Comercial Para Contrato Con Modificaciones.');
			$this->Contratos_model->update_status_contrato_modificaciones($objSalida->CodCli,$objSalida->CodConCom,1,1,0,3);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','UPDATE',$objSalida->CodConCom,$this->input->ip_address(),'Actualizando Contrato Comercial Con Nuevo Propuesta Generada Con Modificaciones.');
			$this->db->trans_complete();
				$this->response($objSalida);
		}


		else
		{
			$arrayName = array('status' =>false,'menssage'=>'Ruta invalida ingrese modulo/nueva.','statusText'=>"Error" );
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
        $select="CodProCom,CodCli,DATE_FORMAT(FecProCom, '%d/%m/%Y') as FecProCom,CodPunSum,CodCupsEle,CodTarEle,ImpAhoEle,PorAhoEle,RenConEle,ObsAhoEle,CodCupsGas,CodTarGas,ImpAhoGas,PorAhoGas,RenConGas,ObsAhoGas,PorAhoTot,ImpAhoTot,EstProCom,JusRecProCom,CodCom,CodPro,CodAnePro,TipPre,UltTipSeg,ObsProCom,RefProCom,PotConP1,PotConP2,PotConP3,PotConP4,PotConP5,PotConP6,PotConP1,Consumo,CauDia";
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
			$BuscarPropuesta=$this->Propuesta_model->Funcion_Verificadora($CodProCom,$tabla,$where,$select);
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
    




    
    
}
?>