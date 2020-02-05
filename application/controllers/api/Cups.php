<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Cups extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Cups_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }


////////////////////////////////////////////////////////////////////////// PARA CUPS START //////////////////////////////////////////////////////////////////////////
     public function get_all_functions_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	 	$Cups = $this->Cups_model->get_list_cups();        
        	$Fecha=date('Y/m/d');        
        	$data= array('Cups' =>$Cups,'Fecha_Server'=>$Fecha);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_V_T','GET',0,$this->input->ip_address(),'Cargando Lista de Cups');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
     public function get_all_cups_PumSum_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	 	$CodPunSum=$this->get('CodPunSum');
       	 	$Fecha=date('Y/m/d');        	 	
       	 	$Cups = $this->Cups_model->get_list_cups_PunSum($CodPunSum);
       	 	$Result = $this->Cups_model->get_data_PunSum($CodPunSum);
       	 	/*if($Result==false)
       	 	{       	 		
       	 		$NumCifCli=null;
				$RazSocCli=null;
				$DesTipVia=null;
				$NomViaPunSum=null;
				$NumViaPunSum=null;
				$BloPunSum=null;
				$EscPunSum=null;
				$PlaPunSum=null;
				$PuePunSum=null;
				$DesPro=null;
				$DesLoc=null;
				$CPLoc=null;
       	 	}
       	 	else
       	 	{
       	 		$NumCifCli=$Result->NumCifCli;
				$RazSocCli=$Result->RazSocCli;
				$DesTipVia=$Result->DesTipVia;
				$NomViaPunSum=$Result->NomViaPunSum;
				$NumViaPunSum=$Result->NumViaPunSum;
				$BloPunSum=$Result->BloPunSum;
				$EscPunSum=$Result->EscPunSum;
				$PlaPunSum=$Result->PlaPunSum;
				$PuePunSum=$Result->PuePunSum;
				$DesPro=$Result->DesPro;
				$DesLoc=$Result->DesLoc;
				$CPLoc=$Result->CPLoc;
       	 	}*/
       	 	$arrayName = array('Cups' => $Cups,'Datos_Puntos' => $Result,'Fecha' => $Fecha);
	        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_V_T','GET',0,$this->input->ip_address(),'Cargando Lista de Cups');
			if (empty($arrayName))
			{
				$this->response(false);
				return false;
			}		
			$this->response($arrayName);		
    }
    public function Datos_PunSum_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	 	$CodPunSum=$this->get('CodPunSum');
       	 	$Result = $this->Cups_model->get_data_PunSum($CodPunSum); 
	        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',0,$this->input->ip_address(),'Cargando Datos Puntos de Suministro');
			if (empty($Result)){
				$this->response(false);
				return false;
			}		
			$this->response($Result);		
    }
    public function Por_Servicios_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();
	//$consulta=$this->Clientes_model->comprobar_cif_existencia($objSalida->Clientes_CIF);							
	
	if($objSalida->TipServ==1)
	{
		$Where="TipSerDis";
		$Variable=0;
		$Distribuidoras=$this->Cups_model->get_Distribuidoras($Where,$Variable);
		$Select_Tarifa="CodTarEle as CodTar,NomTarEle as NomTar";
		$Tarifas_Electricas=$this->Cups_model->get_Tarifas('T_TarifaElectrica',$Select_Tarifa);
		$data= array('Distribuidoras' => $Distribuidoras,'Tarifas'=>$Tarifas_Electricas);
	}
	elseif ($objSalida->TipServ==2) 
	{
		$Where="TipSerDis";
		$Variable=1;
		$Distribuidoras=$this->Cups_model->get_Distribuidoras($Where,$Variable);
		$Select_Tarifa="CodTarGas as CodTar,NomTarGas as NomTar";
		$Tarifa_Gas=$this->Cups_model->get_Tarifas('T_TarifaGas',$Select_Tarifa);
		$data= array('Distribuidoras' => $Distribuidoras,'Tarifas'=>$Tarifa_Gas);
	}
	else
	{
		$response_fail= array('status' =>false ,'response' =>'El Tipo de Servicio es Incorrecto Intente Nuevamente.');
		$this->response($response_fail);
		return false;
	}
	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidora','SEARCH',0,$this->input->ip_address(),'Distribuidora con Servicio Eléctrico o Gas');
	$this->db->trans_complete();
	$this->response($data);
}
 public function Registrar_Cups_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();
	$FecAltCupVoltiada=explode("/", $objSalida->FecAltCup);
	$FecAltCupVoltiada2=$FecAltCupVoltiada[2].'-'.$FecAltCupVoltiada[1].'-'.$FecAltCupVoltiada[0];
	$FecUltLec=explode("/", $objSalida->FecUltLec);
	$FecUltLecVoltiada2=$FecUltLec[2].'-'.$FecUltLec[1].'-'.$FecUltLec[0];
	if($objSalida->TipServ==1)
	{
		if (isset($objSalida->CodCup))
		{	
			$Tabla="T_CUPsElectrico";
			if($objSalida->TipServAnt==2)
			{
				$Tabla_Delete="T_CUPsGas";
				$this->Cups_model->borrar_registro_anterior_CUPs($Tabla_Delete,'CodCupGas',$objSalida->CodCup);
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'DELETE',$objSalida->CodCup,$this->input->ip_address(),'Borrando Cups');			
				$id = $this->Cups_model->agregar_CUPs($Tabla,$objSalida->TipServ,$objSalida->cups.''.$objSalida->cups1.''.$objSalida->cups2,$objSalida->CodDis,$objSalida->CodTar,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->PotMaxBie,$FecAltCupVoltiada2,$FecUltLecVoltiada2,$objSalida->ConAnuCup,$objSalida->CodPunSum);
				$objSalida->TipServAnt=$objSalida->TipServ;	
				$objSalida->CodCup=$id;	
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'INSERT',$objSalida->CodCup,$this->input->ip_address(),'Creando Cups');
			}
			else
			{
				$this->Cups_model->actualizar_CUPs($Tabla,$objSalida->CodCup,$objSalida->TipServ,$objSalida->cups.''.$objSalida->cups1.''.$objSalida->cups2,$objSalida->CodDis,$objSalida->CodTar,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->PotMaxBie,$FecAltCupVoltiada2,$FecUltLecVoltiada2,$objSalida->ConAnuCup,$objSalida->CodPunSum,'CodCupsEle');	
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'UPDATE',$objSalida->CodCup,$this->input->ip_address(),'Actualizando Datos Del Clientes');
			}
		}
		else
		{
			$Tabla="T_CUPsElectrico";
			$id = $this->Cups_model->agregar_CUPs($Tabla,$objSalida->TipServ,$objSalida->cups.''.$objSalida->cups1.''.$objSalida->cups2,$objSalida->CodDis,$objSalida->CodTar,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->PotMaxBie,$FecAltCupVoltiada2,$FecUltLecVoltiada2,$objSalida->ConAnuCup,$objSalida->CodPunSum);
			$objSalida->TipServAnt=$objSalida->TipServ;	
			$objSalida->CodCup=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'INSERT',$objSalida->CodCup,$this->input->ip_address(),'Creando Cups');		
		}
	}
	elseif ($objSalida->TipServ==2) 
	{
		if (isset($objSalida->CodCup))
		{		
			$Tabla="T_CUPsGas";
			if($objSalida->TipServAnt==1)
			{
				$Tabla_Delete="T_CUPsElectrico";
				$this->Cups_model->borrar_registro_anterior_CUPs($Tabla_Delete,'CodCupsEle',$objSalida->CodCup);
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'DELETE',$objSalida->CodCup,$this->input->ip_address(),'Borrando Cups');
				$id = $this->Cups_model->agregar_CUPs($Tabla,$objSalida->TipServ,$objSalida->cups.''.$objSalida->cups1.''.$objSalida->cups2,$objSalida->CodDis,$objSalida->CodTar,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->PotMaxBie,$FecAltCupVoltiada2,$FecUltLecVoltiada2,$objSalida->ConAnuCup,$objSalida->CodPunSum);
				$objSalida->TipServAnt=$objSalida->TipServ;	
				$objSalida->CodCup=$id;	
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'INSERT',$objSalida->CodCup,$this->input->ip_address(),'Creando Cups');
			}
			else
			{
				$this->Cups_model->actualizar_CUPs($Tabla,$objSalida->CodCup,$objSalida->TipServ,$objSalida->cups.''.$objSalida->cups1.''.$objSalida->cups2,$objSalida->CodDis,$objSalida->CodTar,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->PotMaxBie,$FecAltCupVoltiada2,$FecUltLecVoltiada2,$objSalida->ConAnuCup,$objSalida->CodPunSum,'CodCupGas');		
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'UPDATE',$objSalida->CodCup,$this->input->ip_address(),'Actualizando Datos Del Clientes');
			}
		}
		else
		{
			$Tabla="T_CUPsGas";
			$id = $this->Cups_model->agregar_CUPs($Tabla,$objSalida->TipServ,$objSalida->cups.''.$objSalida->cups1.''.$objSalida->cups2,$objSalida->CodDis,$objSalida->CodTar,$objSalida->PotConP1,$objSalida->PotConP2,$objSalida->PotConP3,$objSalida->PotConP4,$objSalida->PotConP5,$objSalida->PotConP6,$objSalida->PotMaxBie,$FecAltCupVoltiada2,$FecUltLecVoltiada2,$objSalida->ConAnuCup,$objSalida->CodPunSum);
			$objSalida->TipServAnt=$objSalida->TipServ;
			$objSalida->CodCup=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'INSERT',$objSalida->CodCup,$this->input->ip_address(),'Creando Cups');			
		}
	}
	else
	{
		$response_fail= array('status' =>false ,'response' =>'El Tipo de Servicio es Incorrecto Intente Nuevamente.');
		$this->response($response_fail);
		return false;
	}

	//$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidora','SEARCH',0,$this->input->ip_address(),'Distribuidora con Servicio Eléctrico o Gas');
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function Buscar_XID_Servicio_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	 	$TipServ=$this->get('TipServ');
       	 	$CodCup=$this->get('CodCup');
       	 	if($TipServ==1)
       	 	{
       	 		$Select="CodCupsEle as CodCup,CodPunSum,SUBSTRING(CUPsEle,1,2)AS cups,SUBSTRING(CUPsEle,3,16)AS cups1,SUBSTRING(CUPsEle,19,20)AS cups2,CodTarElec as CodTar,PotConP1,PotConP2,PotConP3,PotConP4,PotConP5,PotConP6,PotMaxBie,CodDis,DATE_FORMAT(FecAltCup,'%d/%m/%Y') as FecAltCup,DATE_FORMAT(FecUltLec,'%d/%m/%Y') as FecUltLec,TipServ,ConAnuCup,TipServ AS TipServAnt";
       	 		$Tabla="T_CUPsElectrico";
       	 		$Where="CodCupsEle";
       	 		$Result = $this->Cups_model->get_data_Cups($Select,$Tabla,$Where,$CodCup); 
       	 	}
       	 	elseif ($TipServ==2) 
       	 	{
       	 		$Select="CodCupGas as CodCup,CodPunSum,SUBSTRING(CupsGas,1,2)AS cups,SUBSTRING(CupsGas,3,16)AS cups1,SUBSTRING(CupsGas,19,20)AS cups2,CodTarGas as CodTar,CodDis,
				DATE_FORMAT(FecAltCup,'%d/%m/%Y') as FecAltCup,DATE_FORMAT(FecUltLec,'%d/%m/%Y') as FecUltLec,TipServ,ConAnuCup,TipServ AS TipServAnt";
       	 		$Tabla="T_CUPsGas";
       	 		$Where="CodCupGas";
       	 		$Result = $this->Cups_model->get_data_Cups($Select,$Tabla,$Where,$CodCup);
       	 	}
       	 	else
       	 	{
       	 		$Result = array('response' =>'El Tipo de servicio es incorrecto','status'=>false );
       	 		return false;
       	 	}       	 	
	        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',$CodCup,$this->input->ip_address(),'Cargando Cups Por ID');
			if (empty($Result)){
				$this->response(false);
				return false;
			}		
			$this->response($Result);		
    }
    public function list_motivos_bloqueo_CUPs_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$Result = $this->Cups_model->get_motivo_cups(); 
	    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCUPs','GET',0,$this->input->ip_address(),'Cargando Lista de Motivos de Bloqueo de CUPs');
		if (empty($Result))
		{
			$this->response(false);
			return false;
		}		
		$this->response($Result);		
    }
     public function Dar_Baja_Cups_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();
	//$consulta=$this->Clientes_model->comprobar_cif_existencia($objSalida->Clientes_CIF);							
	
	if($objSalida->TipServ=="Gas")
	{
		
		$Tabla_Update="T_CUPsGas";
		$Where="CodCupGas";
		$Tabla_Insert="T_BloqueoCUPsGas";
		$Estatus="EstCUPs";
		$Result_Update=$this->Cups_model->update_status_cups($Tabla_Update,$Where,$objSalida->CodCUPs,$Estatus);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Update,'UPDATE',0,$this->input->ip_address(),'Actualizando Estatus CUPs Gas');
		$Result_Insert=$this->Cups_model->insert_motiv_blo_cups($Tabla_Insert,$objSalida->CodCUPs,$objSalida->MotBloq,$objSalida->ObsMotCUPs,date('Y-m-d'));
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Insert,'INSERT',$Result_Insert,$this->input->ip_address(),'Agregando Motivo de Baja de CUPs Gas');
	}
	elseif ($objSalida->TipServ=="Eléctrico") 
	{
		$Tabla_Update="T_CUPsElectrico";
		$Where="CodCupsEle";
		$Tabla_Insert="T_BloqueoCUPsElectrico";
		$Estatus="EstCUPs";
		$Result_Update=$this->Cups_model->update_status_cups($Tabla_Update,$Where,$objSalida->CodCUPs,$Estatus);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Update,'UPDATE',0,$this->input->ip_address(),'Actualizando Estatus CUPs Eléctrico');
		$Result_Insert=$this->Cups_model->insert_motiv_blo_cups($Tabla_Insert,$objSalida->CodCUPs,$objSalida->MotBloq,$objSalida->ObsMotCUPs,date('Y-m-d'));
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Insert,'INSERT',$Result_Insert,$this->input->ip_address(),'Agregando Motivo de Baja de CUPs Eléctrico');
	}
	else
	{
		$response_fail= array('status' =>false ,'response' =>'El Tipo de Servicio es Incorrecto Intente Nuevamente.');
		$this->response($response_fail);
		return false;
	}	
	$this->db->trans_complete();
	$this->response($objSalida);
}
 	public function Buscar_Tarifas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	$TipServ=$this->get('TipServ');
       	if($TipServ=="Gas")
       	{
       		$Select="CodTarGas as CodTar,NomTarGas as NomTar,MinConAnu,MaxConAnu";
       		$Tabla="T_TarifaGas";
       		$data = $this->Cups_model->get_list_tarifas_filtros($Tabla,$Select);
       	}
       	elseif($TipServ=="Electrico")
       	{
       		$Tabla="T_TarifaElectrica";
       		$Select="CodTarEle as CodTar,NomTarEle as NomTar,CanPerTar,MinPotCon,MaxPotCon";
       		$data = $this->Cups_model->get_list_tarifas_filtros($Tabla,$Select);

       	}
       	else
       	{
       		$Tabla="SIN TABLA";
       		$this->response(false);
       	}
        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'Cargando Lista de Tarifas '.$TipServ);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
////////////////////////////////////////////////////////////////////////// PARA CUPS END //////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////// PARA CONSUMO CUPS START ///////////////////////////////////////////////////////////////////
public function get_Historicos_Consumos_CUPs_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	$TipServ=$this->get('TipServ');
       	$CodCup=$this->get('CodCup');
       	$CodPunSum=$this->get('CodPunSum');       	
       	$Punto_Suminstro = $this->Cups_model->get_data_PunSum($CodPunSum);
       	if($TipServ=="Gas")
       	{
       		$Select="a.CodConCupGas as CodConCup,b.CupsGas AS CUPs,case a.TipServ when 2 then 'Gas' end as TipServ,c.NomTarGas as NomTar,case a.EstConCupGas when 1 then 'ACTIVO' WHEN 2 THEN 'DADO DE BAJA' end as EstConCup,date_format(a.FecIniCon,'%d/%m/%Y') as FecIniCon,date_format(a.FecFinCon,'%d/%m/%Y') as FecFinCon,a.ConCup ";
       		$Tabla="T_HistorialCUPsGas a";
       		$Join="T_CUPsGas b";
       		$Joinb="a.CodCupGas=b.CodCupGas";
       		$Join2="T_TarifaGas c";
       		$Joinc="a.CodTarGas=c.CodTarGas";
       		$Where="a.CodCupGas";
       		$response = $this->Cups_model->get_list_consumos_cups($Select,$Tabla,$Join,$Joinb,$Join2,$Joinc,$Where,$CodCup);


       		$Select2="a.CupsGas as CUPs,b.NomTarGas as NomTar,b.CodTarGas as CodTar";
       		$Tabla2="T_CUPsGas a";
       		$Join3="T_TarifaGas b";
       		$JoinWhere="a.CodTarGas=b.CodTarGas";
       		$Where="a.CodCupGas";
       		$Name_CUPs = $this->Cups_model->get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup);       		
       		$data = array('Consumo_CUPs' =>$response,'Datos_Puntos' => $Punto_Suminstro,'Name_CUPs'=>$Name_CUPs );
        	$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'Cargando Lista de Consumo Cups Gas');
       	}
       	elseif ($TipServ=="Eléctrico") 
       	{
       		$Select="a.CodConCupEle as CodConCup,b.CUPsEle AS CUPs,case a.TipServ when 1 then 'Eléctrico' end as TipServ,c.NomTarEle as NomTar,case a.EstConCupEle when 1 then 'ACTIVO' WHEN 2 THEN 'DADO DE BAJA' end as EstConCup,date_format(a.FecIniCon,'%d/%m/%Y') as FecIniCon,date_format(a.FecFinCon,'%d/%m/%Y') as FecFinCon,a.ConCup";
       		$Tabla="T_HistorialCUPsElectrico a";
       		$Join="T_CUPsElectrico b";
       		$Joinb="a.CodCupEle=b.CodCupsEle";
       		$Join2="T_TarifaElectrica c";
       		$Joinc="a.CodTarEle=c.CodTarEle";
       		$Where="a.CodCupEle";
       		$response = $this->Cups_model->get_list_consumos_cups($Select,$Tabla,$Join,$Joinb,$Join2,$Joinc,$Where,$CodCup);
       		
       		$Select2="a.CUPsEle as CUPs,b.NomTarEle as NomTar,b.CodTarEle as CodTar";
       		$Tabla2="T_CUPsElectrico a";
       		$Join3="T_TarifaElectrica b";
       		$JoinWhere="a.CodTarElec=b.CodTarEle";
       		$Where="a.CodCupsEle";
       		$Name_CUPs = $this->Cups_model->get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup);       		
       		$data = array('Consumo_CUPs'=>$response,'Datos_Puntos'=>$Punto_Suminstro,'Name_CUPs'=>$Name_CUPs );
        	$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'Cargando Lista de Consumo Cups Gas');
       	}
       	else
       	{
       		$data = array('status' =>false,'response'=>'Error en Tipo de Servicio');
       		return false;
       	}


       	
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function Registar_Consumo_CUPs_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();
	$FecAltCupVoltiada=explode("/", $objSalida->FecIniCon);
	$FecIniCon=$FecAltCupVoltiada[2].'-'.$FecAltCupVoltiada[1].'-'.$FecAltCupVoltiada[0];
	$FecUltLecVoltiada2=explode("/", $objSalida->FecFinCon);
	$FecFinCon=$FecUltLecVoltiada2[2].'-'.$FecUltLecVoltiada2[1].'-'.$FecUltLecVoltiada2[0];
	if($objSalida->TipServ==1)
	{
		$Tabla="T_HistorialCUPsElectrico";
		if (isset($objSalida->CodConCup))
		{
			$this->Cups_model->actualizar_Consumo_CUPs($Tabla,$objSalida->CodConCup,$objSalida->CodTar,$objSalida->TipServ,$objSalida->PotCon1,$objSalida->PotCon2,$objSalida->PotCon3,$objSalida->PotCon4,$objSalida->PotCon5,$objSalida->PotCon6,$FecIniCon,$FecFinCon,$objSalida->ConCup,$objSalida->CodCup,'CodConCupEle');	
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'UPDATE',$objSalida->CodConCup,$this->input->ip_address(),'Actualizando del Consumo de CUPs Eléctrico');
		}
		else
		{
			
			$id = $this->Cups_model->agregar_Consumo_CUPs($Tabla,$objSalida->CodTar,$objSalida->TipServ,$objSalida->PotCon1,$objSalida->PotCon2,$objSalida->PotCon3,$objSalida->PotCon4,$objSalida->PotCon5,$objSalida->PotCon6,$FecIniCon,$FecFinCon,$objSalida->ConCup,$objSalida->CodCup);
			$objSalida->CodConCup=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'INSERT',$objSalida->CodConCup,$this->input->ip_address(),'Creando Consumo de Cups Eléctrico');
		}

	}
	elseif($objSalida->TipServ==2)
	{
		$Tabla="T_HistorialCUPsGas";
		if (isset($objSalida->CodConCup))
		{
			$this->Cups_model->actualizar_Consumo_CUPs($Tabla,$objSalida->CodConCup,$objSalida->CodTar,$objSalida->TipServ,$objSalida->PotCon1,$objSalida->PotCon2,$objSalida->PotCon3,$objSalida->PotCon4,$objSalida->PotCon5,$objSalida->PotCon6,$FecIniCon,$FecFinCon,$objSalida->ConCup,$objSalida->CodCup,'CodConCupGas');	
				$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'UPDATE',$objSalida->CodConCup,$this->input->ip_address(),'Actualizando del Consumo de CUPs Gas');
		}
		else
		{
			
			$id = $this->Cups_model->agregar_Consumo_CUPs($Tabla,$objSalida->CodTar,$objSalida->TipServ,$objSalida->PotCon1,$objSalida->PotCon2,$objSalida->PotCon3,$objSalida->PotCon4,$objSalida->PotCon5,$objSalida->PotCon6,$FecIniCon,$FecFinCon,$objSalida->ConCup,$objSalida->CodCup);
			$objSalida->CodConCup=$id;	
			$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'INSERT',$objSalida->CodConCup,$this->input->ip_address(),'Creando Consumo de Cups Gas');
		}

	}
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function buscar_datos_electrico_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}        
       	 	
       	 	$CodConCup=$this->get('CodConCup');
       	 	$Select="PotCon1,PotCon2,PotCon3,PotCon4,PotCon5,PotCon6";
       	 	$Tabla="T_HistorialCUPsElectrico";
       	 	$Where="CodConCupEle";
       	 	$Result = $this->Cups_model->get_data_Cups($Select,$Tabla,$Where,$CodConCup);        	 	      	 	
	        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',$CodConCup,$this->input->ip_address(),'Cargando Cups Por ID Eléctrico');
			if (empty($Result)){
				$this->response(false);
				return false;
			}		
			$this->response($Result);		
    }
     public function Dar_Baja_Consumo_Cups_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();
	//$consulta=$this->Clientes_model->comprobar_cif_existencia($objSalida->Clientes_CIF);							
	
	if($objSalida->TipServ=="Gas")
	{		
		$Tabla_Update="T_HistorialCUPsGas";
		$Where="CodConCupGas";
		$Estatus="EstConCupGas";
		//$Tabla_Insert="T_BloqueoCUPsGas";
		$Result_Update=$this->Cups_model->update_status_cups($Tabla_Update,$Where,$objSalida->CodConCup,$Estatus);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Update,'UPDATE',$objSalida->CodConCup,$this->input->ip_address(),'Actualizando Estatus CUPs Gas');
		/*$Result_Insert=$this->Cups_model->insert_motiv_blo_cups($Tabla_Insert,$objSalida->CodCUPs,$objSalida->MotBloq,$objSalida->ObsMotCUPs,date('Y-m-d'));
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Insert,'INSERT',$Result_Insert,$this->input->ip_address(),'Agregando Motivo de Baja de CUPs Gas');*/
	}
	elseif ($objSalida->TipServ=="Eléctrico") 
	{
		$Tabla_Update="T_HistorialCUPsElectrico";
		$Where="CodConCupEle";
		$Estatus="EstConCupEle";
		//$Tabla_Insert="T_BloqueoCUPsElectrico";
		$Result_Update=$this->Cups_model->update_status_cups($Tabla_Update,$Where,$objSalida->CodConCup,$Estatus);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Update,'UPDATE',$objSalida->CodConCup,$this->input->ip_address(),'Actualizando Estatus CUPs Eléctrico');
		/*$Result_Insert=$this->Cups_model->insert_motiv_blo_cups($Tabla_Insert,$objSalida->CodCUPs,$objSalida->MotBloq,$objSalida->ObsMotCUPs,date('Y-m-d'));
		$this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla_Insert,'INSERT',$Result_Insert,$this->input->ip_address(),'Agregando Motivo de Baja de CUPs Eléctrico');*/
	}
	else
	{
		$response_fail= array('status' =>false ,'response' =>'El Tipo de Servicio es Incorrecto Intente Nuevamente.');
		$this->response($response_fail);
		return false;
	}	
	$this->db->trans_complete();
	$this->response($objSalida);
}
 public function Historial_Consumo_CUPs_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();
	$desde_sin_convertir=explode("/", $objSalida->desde);
	$desde=$desde_sin_convertir[2]."-".$desde_sin_convertir[1]."-".$desde_sin_convertir[0];
	$hasta_sin_convertir=explode("/", $objSalida->hasta);
	$hasta=$hasta_sin_convertir[2]."-".$hasta_sin_convertir[1]."-".$hasta_sin_convertir[0];
	if($objSalida->TipServ=="Eléctrico")
	{
		$Tabla="T_HistorialCUPsElectrico";
		$Where="CodCupEle";
		$response=$this->Cups_model->generar_historial_consumo_cups($desde,$hasta,$objSalida->CodCup,$Tabla,$Where,'FecIniCon');
		if (empty($response))
		{
			$this->response(false);
			return false;
		}
		else
		{
			$total_consumo=$this->Cups_model->sum_consumo_cups($desde,$hasta,$objSalida->CodCup,$Tabla,$Where,'FecIniCon');
			$data = array('result' =>$response,'total_consumo'=>$total_consumo->AcumConCup,'desde'=>$desde,'hasta'=>$hasta,'CodCup'=>$objSalida->CodCup);
		}



	}
	elseif($objSalida->TipServ=="Gas")
	{
		$Tabla="T_HistorialCUPsGas";
		$Where="CodCupGas";
		$response=$this->Cups_model->generar_historial_consumo_cups($desde,$hasta,$objSalida->CodCup,$Tabla,$Where,'FecIniCon');
		if (empty($response))
		{
			$this->response(false);
			return false;
		}
		else
		{
			$total_consumo=$this->Cups_model->sum_consumo_cups($desde,$hasta,$objSalida->CodCup,$Tabla,$Where,'FecIniCon');
			$data = array('result' =>$response,'total_consumo'=>$total_consumo->AcumConCup,'desde'=>$desde,'hasta'=>$hasta,'CodCup'=>$objSalida->CodCup);
		}		
		
	}
	else
	{
		$this->response(false);
		return false;
	}
	$this->db->trans_complete();
	$this->response($data);
}





////////////////////////////////////////////////////////////////////////// PARA CONSUMO CUPS END ///////////////////////////////////////////////////////////////////

}
?>