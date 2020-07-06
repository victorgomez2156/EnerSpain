<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
//require(APPPATH. 'libraries/Mail-1.4.1/Mail.php');
//require(APPPATH. 'libraries/Mail-1.4.1/mime.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Seguimientos extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default'); 
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Otrasgestiones_model');
		$this->load->model('Clientes_model');
		$this->load->model('Propuesta_model');
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
		$consulta=$this->Clientes_model->getclientessearch($objSalida->NumCifCli);						
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',null,$this->input->ip_address(),'Comprobando Registro de CIF');
		$this->db->trans_complete();
		$this->response($consulta);
	}
	public function datos_server_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$FechaServer=date('d/m/Y');
		$nrSeguimiento=	$this->generar_RefSeguimiento();		
		$response = array('status' =>200 ,'menssage' =>'Datos Encontrados','statusText'=>'OK','FechaServer'=>$FechaServer,'nrSeguimiento'=>$nrSeguimiento);		
		$this->response($response);
    }
    public function generar_RefSeguimiento()
    {
    	$nCaracteresFaltantes = 0;
		$numero_a = " ";
		/*Ahora necesitamos el numero de la Referencia de la Propuesta*/
		$queryIdentificador = $this->db->query("SELECT CodMov,DesMov,NrMov FROM T_Movimientos WHERE CodMov=4");
		$rowIdentificador = $queryIdentificador->row();
		//buscamos que longitud tiene el numero generado por la base de datos y completamos con ceros a la izquierda
		$nCaracteresFaltantes = 12 - strlen($rowIdentificador->NrMov) ;
		$numero_a = str_repeat('0',$nCaracteresFaltantes);
		$numeroproximo = $rowIdentificador->NrMov + 1;
		$nCaracteresFaltantesC = 12 - strlen($rowIdentificador->NrMov); //VERIFICAR CUANDO PASE DE 100
		$numero_aC = str_repeat('0',$nCaracteresFaltantesC);
		$numeroproximoC = $rowIdentificador->NrMov + 1;
		$numeroC = $numero_aC . (string)$rowIdentificador->NrMov;
		$this->db->query("UPDATE T_Movimientos SET NrMov=".$numeroproximo." WHERE CodMov=4");
		return $numeroC;		
    }
    public function BuscarGestionComercial_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		
		if($objSalida->TipSeg=="P")
		{
			$tabla="T_PropuestaComercial";			
			$order_by="FecProCom DESC";
			$select	="CodProCom as CodRef,CodCli,DATE_FORMAT(FecProCom,'%d/%m/%Y') as FecGes,RefProCom as NumGes,RefProCom as RefGes,UltTipSeg";
			$where="CodCli";

			$response=$this->Propuesta_model->BuscandoGestiones($tabla,$order_by,$select,$where,$objSalida->CodCli);	
		}
		elseif($objSalida->TipSeg=="C")
		{
			$tabla="T_Contrato";			
			$order_by="FecConCom DESC";
			$select	="CodConCom as CodRef,CodCli,DATE_FORMAT(FecConCom,'%d/%m/%Y') as FecGes,RefCon as NumGes,RefCon as RefGes,UltTipSeg";
			$where="CodCli";
			$response=$this->Propuesta_model->BuscandoGestiones($tabla,$order_by,$select,$where,$objSalida->CodCli);
		}
		elseif($objSalida->TipSeg=="G")
		{
			$tabla="T_OtrasGestiones";			
			$order_by="FecGesGen DESC";
			$select	="CodGesGen as CodRef,CodCli,DATE_FORMAT(FecGesGen,'%d/%m/%Y') as FecGes,NGesGen as NumGes,RefGesGen as RefGes,UltTipSeg";
			$where="CodCli";
			$response=$this->Propuesta_model->BuscandoGestiones($tabla,$order_by,$select,$where,$objSalida->CodCli);//false;
		}
		else
		{
			$tabla="NULL";
		}		
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',null,$this->input->ip_address(),'Buscando Gestión Comercial por Tipo de Seguimiento');
		$this->db->trans_complete();
		$this->response($response);
	}
	public function registrar_seguimiento_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if($objSalida->TipSeg=="P")
		{
			$tabla="T_PropuestaComercial";			
			$update_PropuestaComercial=$this->Propuesta_model->update_PropuestaComercial($objSalida->CodCli,$objSalida->CodRef,$objSalida->ResSeg);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$objSalida->CodRef,$this->input->ip_address(),'Actualizando UltTipSeg De Propuesta Comercial.');
					
		}
		elseif($objSalida->TipSeg=="C")
		{
			$tabla="T_Contrato";
			$update_ContratoComercial=$this->Propuesta_model->update_ContratoComercial($objSalida->CodCli,$objSalida->CodRef,$objSalida->ResSeg);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$objSalida->CodRef,$this->input->ip_address(),'Actualizando UltTipSeg De Contrato Comercial.');			
			
		}
		elseif($objSalida->TipSeg=="G")
		{
			$tabla="T_OtrasGestiones";	
			$update_OtrasGestionesComercial=$this->Propuesta_model->update_OtrasGestionesComercial($objSalida->CodCli,$objSalida->CodRef,$objSalida->ResSeg);
			$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla,'GET',$objSalida->CodRef,$this->input->ip_address(),'Actualizando UltTipSeg De Otras Gestiones Comercial.');
		}
		else
		{
			$tabla="NULL";
		}		
		if(isset($objSalida->CodSeg))
		{

		}
		else
		{
			$CodSeg=$this->Propuesta_model->save_seguimientos($objSalida->CodCli,$objSalida->CodRef,$objSalida->FecSeg,$objSalida->NumSeg,$objSalida->ObsSeg,$objSalida->RefSeg,$objSalida->ResSeg,$objSalida->TipSeg,$objSalida->DesSeg);
			$objSalida->CodSeg=$CodSeg;
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Seguimiento' ,'INSERT',$CodSeg,$this->input->ip_address(),'Proceso de Registro de Seguimiento');
			$tabla="T_Cliente";
			$where="CodCli";
			$select="CodCli,EmaCli,RazSocCli,NumCifCli";
			$DatosCliente=$this->Propuesta_model->Funcion_Verificadora($objSalida->CodCli,$tabla,$where,$select);
			if($DatosCliente->EmaCli!=null)
			{
				if($objSalida->ResSeg=="P"){$Resultado="Pendiente";}elseif($objSalida->ResSeg=="C"){$Resultado="Completado";}
				elseif($objSalida->ResSeg=="R"){$Resultado="Rechazado";}else{$Resultado="N/A";}
				$this->sendMailCliente($DatosCliente->EmaCli,$DatosCliente->RazSocCli,$DatosCliente->NumCifCli,$objSalida->FecSeg,$objSalida->NumSeg,$objSalida->DesSeg,$Resultado,$objSalida->ObsSeg,$objSalida->RefSeg,$objSalida->CodCli,$objSalida->ResSeg,$objSalida->CodRef,$objSalida->TipSeg);
				$updatesegumiento=$this->Propuesta_model->updateemailseguimiento($CodSeg,true);

			}
		}
		$objSalida->UltTipSeg=$objSalida->ResSeg;		
		$this->db->trans_complete();
		$this->response($objSalida);
	}
	public function sendMailCliente($EmaCli,$RazSocCli,$NumCifCli,$FecSeg,$NumSeg,$DesSeg,$Resultado,$ObsSeg,$RefSeg,$CodCli,$ResSeg,$CodRef,$TipSeg)
	{
		$tabla="T_ConfiguracionesSistema";
		$where="id";
		$select="*";
		$get_configuraciones=$this->Propuesta_model->Funcion_Verificadora(1,$tabla,$where,$select);		
		//$fullname=$obj->nombres.' '.$obj->apellidos;				
		$nombre_sistema = $get_configuraciones->nombre_sistema.' '.$get_configuraciones->version_sistema;
		$banner=$get_configuraciones->url.'application/libraries/estilos/img/logo-enerspain.png';
		$sender = $get_configuraciones->smtp_user;// Your name and email address 
	    $recipient = $EmaCli;// The Recipients name and email address 
	    $subject = "Seguimiento de Gestión Comercial";// Subject for the email 
    	$html='<div class=""><div class="aHl"></div><div id=":aq" tabindex="-1"></div><div id=":af" class="ii gt"><div id=":ae" class="a3s aXjCH msg1052756172818050662"><u></u><div marginwidth="0" marginheight="0"><center><table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="m_1052756172818050662bodyTable"><tbody><tr><td align="center" valign="top" id="m_1052756172818050662bodyCell"><table border="0" cellpadding="0" cellspacing="0" id="m_1052756172818050662templateContainer"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateHeader"><tbody><tr><td valign="top" class="m_1052756172818050662headerContent"></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateBody"><tbody><tr><td valign="top" class="m_1052756172818050662bodyContent"><table style="height:919px;width:550px" border="0" align="center"><tbody><tr><td><table border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td colspan="2" align="left"><span style="font-size:small"><img src='.$banner.' alt="" width="530" height="75" class="CToWUd">&nbsp;</span></td></tr><tr><td colspan="2" align="center"><span style="font-size:small">&nbsp;</span></td></tr></tbody></table></td></tr><tr><td height="310"><span class="im"><p><span style="font-size:small">Estimado Cliente: '.$NumCifCli.' - '.$RazSocCli.',</span></p><p style="text-align:center"><span style="font-size:small"><strong>El email contiene información del Seguimiento a la Gestión Comercial</strong></span></p><p><span style="font-size:small">Gracias por solicitar nuestros servicios, este email es para informarle sobre el seguimiento realizado a su Gestión Comercial</span></p><p><span style="font-size:small"><strong>Informacíon del seguimiento</strong></span></p><p><span style="font-size:small">Fecha: '.$FecSeg.'</span><br><span style="font-size:small">Nº Seguimiento: '.$NumSeg.'</span><br><span style="font-size:small">Descripción: '.$DesSeg.'</span><br><span style="font-size:small">Referencia: '.$RefSeg.'</span><br><span style="font-size:small">Resultado: '.$Resultado.'</span><br><span style="font-size:small">Observación: '.$ObsSeg.'</span><br><span class="im"><p><span style="font-size:small"><a href='.$get_configuraciones->url.'reportes/Exportar_Documentos/Doc_Reporte_Seguimiento_PDF/'.$CodCli.'/'.$TipSeg.'/'.$CodRef.'>URL PDF SEGUIMIENTO:</a></span></p></td></tr><tr><td><p style="text-align:center"><span style="font-size:small">'.$nombre_sistema.' ©</span></p><div style="text-align:center"><span style="font-size:small">&nbsp;</span></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateFooter"><tbody><tr><td valign="top" class="m_1052756172818050662footerContent"><br><div align="center">Copyright © '.$nombre_sistema.', All rights reserved.</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center><div class="yj6qo"></div><div class="adL"></div></div><div class="adL"></div></div></div><div id=":au" class="ii gt" style="display:none"><div id=":av" class="a3s aXjCH undefined"></div></div><div class="hi"></div></div>';   
		    $crlf = "\n"; 
		    $headers = array(
		    'From'   => $sender, 
		    'To'=>$EmaCli, 
		    'Return-Path' => $sender, 
		    'Subject'  => $subject,
		    'X-Priority' =>1,
		    'Errors-To'=>$get_configuraciones->correo_cc
		    ); 
		    //Creating the Mime message 
		    $mime = new Mail_mime($crlf); 
		    //$mime->setTXTBody($text); 
		    $mime->setHTMLBody($html); 
		    $mimeparams=array();
		    $mimeparams['text_encoding']="7bit";
		    $mimeparams['text_charset']="UTF-8";
		    $mimeparams['html_charset']="UTF-8";
		    $body = $mime->get($mimeparams); 
		    $headers = $mime->headers($headers); 
		    $params["host"] = $get_configuraciones->smtp_host;
			$params["port"] = $get_configuraciones->smtp_port;
			$params["auth"] = true;
			$params["username"] = $get_configuraciones->smtp_user;
			$params["password"] = $get_configuraciones->smtp_pass;
		    $mail = Mail::factory($get_configuraciones->protocol, $params); 
		    $mail->send($recipient, $headers, $body);
		//return $get_configuraciones;

	}
	public function get_seguimientos_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$TipSeg=$this->get('TipSeg');
		$CodRef=$this->get('CodRef');
		$CodCli=$this->get('CodCli');
		$ListSeguimientos=$this->Propuesta_model->get_seguimientos($TipSeg,$CodRef,$CodCli);
		if(empty($ListSeguimientos))
		{
			$this->response(false);	
			return false;
		}	
		$this->response($ListSeguimientos);
    }
      

}
?>