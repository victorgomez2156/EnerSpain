<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require(APPPATH. 'libraries/Mail-1.4.1/Mail.php');
//require(APPPATH. 'libraries/Mail-1.4.1/mime.php');
class Tareas_Programadas extends CI_Controller
{
	function __construct()
	{
    	parent::__construct();
		$this->load->database('default');
        $this->load->library('form_validation');
        $this->load->library('user_agent');  
        $this->load->helper('form');
        $this->load->helper('url');  
        $this->load->library('email');
       	$this->load->helper('cookie');  
       	$this->load->model('Tareas_programadas_model'); 
       	$this->load->model('Propuesta_model');  	
	}
	public function index() 
	{ 
		if ($this->agent->is_browser())
		{
        	$agent = $this->agent->browser(); 
	 	    $version= $this->agent->version();
	 	}
	 	elseif ($this->agent->is_robot())
		{
        	$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
        	$agent = $this->agent->mobile();
		}
		else
		{
        	$agent = 'Unidentified User Agent';
        }
		$ip=$this->input->ip_address();
		$os=$this->agent->platform();        		
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miércoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="España, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final.' '.$hora_nueva;		
		echo $todo_unido;
	}
	public function Crear_RefProCom()
	{
		$Data_Propuestas=$this->Tareas_programadas_model->all_propuestas();
		if(empty($Data_Propuestas))
		{
			echo 'no ahi data';
			return false;
		}
		foreach ($Data_Propuestas as $key => $myPropuestas): 
		{
			if($myPropuestas-> RefProCom==null)
			{
				$RefProCom=$this->generar_RefProPropuesta();				
				$update_RefProCom=$this->Tareas_programadas_model->update_RefProCom($myPropuestas->CodProCom,$RefProCom);
				echo  'Se Actualizaron Las Siguientes Referencia: '.$myPropuestas-> CodProCom; echo'<br>';
			}
			else
			{
				$var='Estas Propuestas Comerciales ya poseen Número de Referencia. <br>';
				echo $var;
			}
		}
		endforeach;		
	}
	public function Contratos_Vencidos()
	{
		$Fecha=date('Y-m-d');
		$Contratos=$this->Tareas_programadas_model->select_contratos_vencerse($Fecha);
		if(empty($Contratos))
		{
			echo 'No ahi Contratos para renovar.';
			return false;
		}
		$tabla="T_ConfiguracionesSistema";
		$where="id";
		$select="*";
		$get_configuraciones=$this->Propuesta_model->Funcion_Verificadora(1,$tabla,$where,$select);	
		$nombre_sistema = $get_configuraciones->nombre_sistema.' '.$get_configuraciones->version_sistema;
		$banner=$get_configuraciones->url.'application/libraries/estilos/img/logo-enerspain.png';
		$sender = $get_configuraciones->smtp_user; //Your name and email address 
	    $recipient = $get_configuraciones->correo_principal;// The Recipients name and email address 
	    $subject = "Contratos Vencidos";// Subject for the email 
    	$html='<div class=""><div class="aHl"></div><div id=":aq" tabindex="1"></div><div id=":af" class="ii gt"><div id=":ae" class="a3s aXjCH msg1052756172818050662"><u></u><div marginwidth="0" marginheight="0"><center><table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="m_1052756172818050662bodyTable"><tbody><tr><td align="center" valign="top" id="m_1052756172818050662bodyCell">
			<table border="0" cellpadding="0" cellspacing="0" id="m_1052756172818050662templateContainer"><tbody><tr><td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateHeader"><tbody><tr><td valign="top" class="m_1052756172818050662headerContent"><a href="" target="_blank" ></a></td></tr></tbody></table></td></tr><tr><td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateBody"><tbody><tr><td valign="top" class="m_1052756172818050662bodyContent"><table style="height:919px;width:550px" border="0" align="center"><tbody><tr><td><table border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td colspan="2" align="left"><span style="font-size:small"><img src='.$get_configuraciones->url.'application/libraries/estilos/img/logo-enerspain.png alt="" width="530" height="75" class="CToWUd">&nbsp;</span></td></tr><tr><td colspan="2" align="center"><span style="font-size:small">&nbsp;</span></td></tr></tbody></table></td></tr><tr><td height="310"><span class="im"><p style="text-align:center">
			<span style="font-size:small"><strong>Contratos Vencidos</strong></span></p><p style="text-align:center">
			</p><p><span style="font-size:small">  </span></p><p align="center"><span style="font-size:small"><strong >Listado de Contratos Vencidos:</strong></span></p>';
		foreach ($Contratos as $key => $myContratos): 
		{
			$update_Contratos=$this->Tareas_programadas_model->update_Contratos($myContratos->CodConCom,2);			
			$html.='<p>
			<span style="font-size:small"><b>Cliente:</b> '.$myContratos-> RazSocCli.' - '.$myContratos-> NumCifCli.' </span><br>
			<span style="font-size:small"><b>Fecha Inicio:</b> '.$myContratos-> FecIniCon.'</span><br>
			<span style="font-size:small"><b>Duración:</b> '.$myContratos-> DurCon.' Meses</span><br>
			<span style="font-size:small"><b>Fecha Vencimiento:</b> '.$myContratos-> FecVenCon.'</span><br>
			<span style="font-size:small"><b>Observación:</b> '.$myContratos-> ObsCon.'</span><br>			
			';
		}
		endforeach;
		$html.='<p style="text-align:center"><span style="font-size:small"><br>'.$get_configuraciones->nombre_sistema.' ©</span></p><div style="text-align:center"><span style="font-size:small">&nbsp;</span></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateFooter"><tbody><tr><td valign="top" class="m_1052756172818050662footerContent"><div align="center">Copyright © '.$get_configuraciones->nombre_sistema.', All rights reserved.</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center><div class="yj6qo"></div><div class="adL"></div></div><div class="adL"></div></div></div><div id=":au" class="ii gt" style="display:none"><div id=":av" class="a3s aXjCH undefined"></div></div><div class="hi"></div></div>';
			//echo $html;	
		 	$crlf = "\n"; 
		    $headers = array('From'=>$sender,'To'=>$get_configuraciones->correo_principal,'Return-Path' => $sender,'Subject'  => $subject,'X-Priority' =>1,'Errors-To'=>$get_configuraciones->correo_principal);
		    $mime = new Mail_mime($crlf); 
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
			if (PEAR::isError($mail)) 
			{
				echo '<p align="center"> Ha ocurrido un error al intentar enviar el correo electrónico, por favor intente nuevamente.</p>'; 
			}
			else
			{
				echo '<p align="center">Hemos Enviado un Correo Electrónico a: <b>'.$get_configuraciones->correo_principal.'</b> Con el Listado de los contratos vencidos.</p>'; 
			}
	}
	public function generar_RefProPropuesta()
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
}?>