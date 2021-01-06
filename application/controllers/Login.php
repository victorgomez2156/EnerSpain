<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require(APPPATH. 'libraries/Mail-1.4.1/Mail.php');
//require(APPPATH. 'libraries/Mail-1.4.1/mime.php');
class Login extends CI_Controller

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
       	$this->load->model('Usuarios_model');
		
    }

	public function index() 
	{ 
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		if($dia[date('l')]=="Domingo1" )
		{
			date_default_timezone_set('America/La_Paz');
			$hora_nueva=date('g:i:s A'); 
			echo ' '.$hora_nueva;
			$this->load->view('view_sin_servicio');
		}
		else
		{
			if ($this->agent->is_browser())
			{
		        $agent = $this->agent->browser(); 
        		$version= $this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
				$agent = $this->agent->robot();
				$version= $this->agent->version();
			}
			elseif ($this->agent->is_mobile())
			{
		        $agent = $this->agent->mobile();
		        $version= $this->agent->version();
			}		
			else
			{
        		$agent = 'Unidentified User Agent';
        		$version= null;
			}
			$ip=$this->input->ip_address();
			$os=$this->agent->platform();			
			$cookie_sesion=$this->input->cookie('EnerSpain');
			$hora_nueva=date('Y-m-d G:i:s');
			//var_dump($cookie_sesion);				
			if($cookie_sesion==NULL)
			{
				redirect(base_url());	
			}
			else
			{
				$datausuario=$this->session->all_userdata();
				if (!isset($datausuario['sesion_clientes']))
				{
					//$this->session->sess_destroy();
					$this->load->view('view_login');
				}
				else
				{
					redirect(base_url("Principal#/Home/"), 'location', 301);
				}
			}
			/*if (!isset($datausuario['sesion_clientes']))
			{
				//$this->session->sess_destroy();
				redirect(base_url(), 'location', 301);
			}
			else 
			{
				redirect(base_url("Principal#/Dashboard/"), 'location', 301);
			}*/
			/*if($cookie_sesion==NULL)
			{
				redirect(base_url());	
			}
			else
			{
				$objsesion=$this->Usuarios_model->consultar_cookie($cookie_sesion);
				if($objsesion!=false)
				{
					if($objsesion->huser==null && $objsesion->estatus==0)
					{
						$this->session->sess_destroy();
						$this->load->view('view_login');
					}
					else
					{
						
						if($objsesion->huser>0 && $objsesion->estatus==0)
						{
							$datausuario=$this->session->all_userdata();	
							if (!isset($datausuario['sesion_clientes']))
							{
								//$this->session->sess_destroy();
								redirect(base_url(), 'location', 301);
							}
							else 
							{
								redirect(base_url("Principal#/Dashboard/"), 'location', 301);
							}	
						}
						elseif ($objsesion->huser>0 && $objsesion->estatus==1) 
						{
							//$this->session->sess_destroy();
							redirect(base_url(), 'location', 301);
						}
					}				
				}
				else
				{					
					//$this->session->sess_destroy();
					$this->Usuarios_model->sesion_cookies($this->input->ip_address(),$agent,$version,$os,$cookie_sesion,$hora_nueva);					
					$this->load->view('view_login');
				}			
			}*/
		}
	}
	 

	public function accesando()
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
		$userid = $this->input->post('usuario');
		$password = md5($this->input->post('password'));
		$remember = $this->input->post('remember-me');		
		$ano=date('Y');		
		/**/
		#Buscaremos en la base de datos si el usuario esta registrado 
		$FuncionBuscarUsuarios=$this->Usuarios_model->get_usuarios_buscar($userid);
		if($FuncionBuscarUsuarios!=false)
		{
			$FuncionBloqueadoUser=$this->Usuarios_model->get_usuarios_bloqueado($userid);
			if($FuncionBloqueadoUser!=false)
			{
				$datausuario = $this->Usuarios_model->get_usuario($userid,$password);
				if($datausuario!=false)
				{	
					//$this->Usuarios_model->actualizar_cookie($datausuario->id,$datausuario->nivel,$ip,$agent,$version,$os,$this->input->cookie('EnerSpain'));
					$newdata = array('id'=>$datausuario->id,'username'=>$datausuario->username,'nivel'=>$datausuario->nivel,'sesion_clientes'=>TRUE,'key'=>$datausuario->key,'correo_electronico'=>$datausuario->correo_electronico,'nombres'=>$datausuario->nombres,'apellidos'=>$datausuario->apellidos);
					$this->session->set_userdata($newdata);
					//echo 2;

					$respuesta = array('status'=>TRUE,'message'=>'Iniciando Sesión, por favor espere ...','data'=>$datausuario);
        			echo json_encode($respuesta,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
				  	/*$sender = $configuraciones->smtp_user;        // Your name and email address 
				    $recipient = $datausuario->correo_electronico;// The Recipients name and email address 
				    $subject = "Alerta de Seguridad";           // Subject for the email 
				    $html='<div id=":ab" class="ii gt"><div id=":aa" class="a3s aXjCH msg-1530226089000420248"><u></u><div bgcolor="#FFFFFF" style="margin:0;padding:0"><table border="0" cellpadding="0" cellspacing="0" height="100%" lang="es" style="min-width:348px" width="100%"><tbody><tr height="32" style="height:32px"><td></td></tr><tr align="center"><td><div><div></div></div><table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:20px;max-width:516px;min-width:220px"><tbody><tr><td style="width:8px" width="8"></td><td><div align="center" class="m_-1530226089000420248mdv2rw" style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px"><img height="24" src="https://wayak.es/wp-content/uploads/2018/07/Wayak.jpg" style="width:75px;height:24px;margin-bottom:16px" width="100" class="CToWUd"><div style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word"><div style="font-size:24px">Se ha iniciado sesión en un dispositivo nuevo&nbsp;en</div><table align="center" style="margin-top:8px"><tbody><tr style="line-height:normal"><td align="right" style="padding-right:8px"><img height="20" src="https://ci4.googleusercontent.com/proxy/QpsGaULeBaBhhOTpb-uwGsICda8b1ae95rM7JtYlDtcjbrJ_fDlrGcQ9nUwocVilT_dWdlntnRieTr4GY_IFycf2zxXXuPXiHCdY7G5yRw7uJHHhalp2NYvY=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/anonymous_profile_photo.png" style="width:20px;height:20px;vertical-align:sub;border-radius:50%" width="20" class="CToWUd"></td><td><a style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:14px;line-height:20px">'.$datausuario->correo_electronico.'</a></td></tr></tbody></table></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:center">Se ha iniciado sesión en tu cuenta de  desde un dispositivo nuevo ('.$os.'). Te hemos enviado este correo electrónico para comprobar que la has iniciado tú.<div style="padding-top:32px;text-align:center"><a href='.$configuraciones->url_cliente.'>Ver actividad</a></div></div></div><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center"><div>Te hemos enviado este correo electrónico para informarte de cambios importantes en tu cuenta y en los servicios de nuestra empresa. No responder a este correo electrónico porque no sera atendido por nuestro sistema</div><div style="direction:ltr">© 2018-'.$ano.' SistemaOnline2018 C.A,<a class="m_-1530226089000420248afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center"> '.$configuraciones->direccion.', Venezuela</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1547398360000000</div></div></td><td style="width:8px" width="8"></td></tr></tbody></table></td></tr><tr height="32" style="height:32px"><td></td></tr></tbody></table><img height="1" src="https://ci5.googleusercontent.com/proxy/lehYhn8ZDmZju4Mu6M5sfyPk7-YqtRGnix_Fr5ZDDKOy1rnaQRtSYlbi1PVmY4mJ84t8KFVt5bvjY4a-6GBFB3OoR0U7YQwZjthqlqszZn75Nr-12D58Esoph5V6CjUwztlv5wuMebA90UeR1u0bvF-s72OFKtHuGiXrXuP6vdynPYDrEyqNBnkb45u6OXOVfibOrGhqtnePW5l0Lahh5LC6KEcOlbrjMEs6t9zJUSVFOTF3DHj-qLgDr6IIcNSfkjYrGd9-Hjxda6yWjSYZJLzlwuJSis616WM3A5h3R6F9Wc_-ly1L_6D_oXvSKuDyYwRTI_KeJ8g-daQacMgrFUHQRczJtxqH06ltVR6JPeGNxige1HhZQP6PfHFvL9Utrk-z2WY-DEtKyBcfjs1rEaCtR1gFpLDJU_0yhr8gNfP5QVNDiDJYIz05vHifyKcMkNesPozlsv-EW3cCzmwRsdQk5xrwIoyAng=s0-d-e1-ft#https://notifications.googleapis.com/email/t/AFG8qyVChqlooQDPoY-b8gVxOhRBNj_fGxPp7YZr_yWCStmWSzudyYdIC62_KTf-yGV25ru1RYi3t-ks7Wn-gZM6duNFvZ0Kq3QOso0Rh7tojWBdNJHD9VtcA0vKb-31nJ6CsDq-kfU7SQk55F1i_0sWRCshcsIfXpeI2I-jpXcEdsBpByoLMK1Kod7XeZepv4K60Z20SpOLEa8Lt3XBpdzuVIDQMzGrLJPIqmUYHUOqpLyJdK-w7QgM10h-Vm25kXgt4S_u0bG_e1NIvzYDXvD9LwPZrHmw8g/a.gif" width="1" class="CToWUd"></div></div><div class="yj6qo"></div></div>';   
				    $crlf = "\n"; 
				    $headers = array('From'=>$sender,'To'=>$datausuario->correo_electronico,'Return-Path' => $sender,'Subject'  => $subject,'X-Priority' =>1,'Errors-To'=>$configuraciones->correo_paypal);     
				    $mime = new Mail_mime($crlf);
				    $mime->setHTMLBody($html); 
				    $mimeparams=array();
					$mimeparams['text_encoding']="7bit";
					$mimeparams['text_charset']="UTF-8";
					$mimeparams['html_charset']="UTF-8";
				    $body = $mime->get($mimeparams); 
				    $headers = $mime->headers($headers); 
				    $params["host"] = $configuraciones->smtp_host;					
					$params["port"] = $configuraciones->smtp_port;				
					$params["auth"] = true;
					$params["username"] = $configuraciones->smtp_user;				
					$params["password"] = $configuraciones->smtp_pass;
				    $mail = Mail::factory($configuraciones->protocol, $params); 
				    $mail->send($recipient, $headers, $body);*/
				}
				else
				{
					$respuesta = array('status'=>$datausuario,'message'=>'Error en Usuario o Contraseña, por favor verifique','data'=>3);
        			echo json_encode($respuesta,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
				}
			}
			else
			{
				$respuesta = array('status'=>$FuncionBloqueadoUser,'message'=>'Usuario Bloqueado.','data'=>2);
        		echo json_encode($respuesta,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
			}
		}
			else
			{
				$respuesta = array('status'=>$FuncionBuscarUsuarios,'message'=>'Usuario No Registrado','data'=>1);
        		echo json_encode($respuesta,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
			}
	}

	public function desconectar()
	{
		/*$cookie_sesion=$this->input->cookie('EnerSpain');
		$id_usuario=$this->session->userdata('id');
		$objfinal= $this->Usuarios_model->actualizar_estado_sesion($cookie_sesion,$id_usuario);
		if($objfinal!=false)
		{
			$this->session->sess_destroy();
			redirect(base_url(), 'location', 301,'refresh');
		}*/
		$this->session->sess_destroy();
			redirect(base_url(), 'location', 301,'refresh');
	}

public function enviar()
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
   	$correo_electronico = $this->input->post('correo');
	#Buscaremos en la base de datos si el usuario esta registrado 
	$FuncionBuscarUsuarios=$this->Usuarios_model->get_usuarios_buscar($correo_electronico);
	if($FuncionBuscarUsuarios!=false)
	{
       $Obtener_Contrasena=$this->Usuarios_model->obtener_contrasena($correo_electronico); 	
       if($Obtener_Contrasena!=false)
	   {
		   	$clave_sin_cifrar= $Obtener_Contrasena->clave_sin_cifrar;
		   	$nombre_usuario=$Obtener_Contrasena->nombres;
		   	$apellido_usuario=$Obtener_Contrasena->apellidos;
		   	$fullname=$nombre_usuario.' '.$apellido_usuario;
		   	$configuraciones=$this->Dependencias_model->get_configuracion();
			$sender = $configuraciones->smtp_user;        // Your name and email address 
			$recipient = $correo_electronico;// The Recipients name and email address 
			$subject = "Recuperación de Contraseña";           // Subject for the email 
			$html='<div id=":ab" class="ii gt"><div id=":aa" class="a3s aXjCH msg-1530226089000420248"><u></u><div bgcolor="#FFFFFF" style="margin:0;padding:0"><table border="0" cellpadding="0" cellspacing="0" height="100%" lang="es" style="min-width:348px" width="100%"><tbody><tr height="32" style="height:32px"><td></td></tr><tr align="center"><td><div><div></div></div><table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:20px;max-width:516px;min-width:220px"><tbody><tr><td style="width:8px" width="8"></td><td><div align="center" class="m_-1530226089000420248mdv2rw" style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px"><img height="24" src="https://wayak.es/wp-content/uploads/2018/07/Wayak.jpg" style="width:75px;height:24px;margin-bottom:16px" width="100" class="CToWUd"><div style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word"><div style="font-size:24px">Solucitud de&nbsp;Contraseña del Correo Electrónico</div><table align="center" style="margin-top:8px"><tbody><tr style="line-height:normal"><td align="right" style="padding-right:8px"><img height="20" src="https://ci4.googleusercontent.com/proxy/QpsGaULeBaBhhOTpb-uwGsICda8b1ae95rM7JtYlDtcjbrJ_fDlrGcQ9nUwocVilT_dWdlntnRieTr4GY_IFycf2zxXXuPXiHCdY7G5yRw7uJHHhalp2NYvY=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/anonymous_profile_photo.png" style="width:20px;height:20px;vertical-align:sub;border-radius:50%" width="20" class="CToWUd"></td><td><a style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:14px;line-height:20px">'.$correo_electronico.'</a></td></tr></tbody></table></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:center">Estimado Usuario hemos dectatado que ha solicitado su contraseña desde un dispositivo nuevo ('.$os.'). Con la Dirección IP: '.$ip.' tu contraseña es <b>'.$clave_sin_cifrar.'</b>Te hemos enviado este correo electrónico para comprobar que lo hiciste tú.<div style="padding-top:32px;text-align:center"><a href="#">Ver actividad</a></div></div></div><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center"><div>Te hemos enviado este correo electrónico para informarte de cambios importantes en tu cuenta y en los servicios de nuestra empresa. No responder a este correo electrónico porque no sera atendido por nuestro sistema</div><div style="direction:ltr">© 2018-'.$ano.' SistemaOnline2018 C.A,<a class="m_-1530226089000420248afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center"> La Morita II Av. Principal Santa Ines, Venezuela</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1547398360000000</div></div></td><td style="width:8px" width="8"></td></tr></tbody></table></td></tr><tr height="32" style="height:32px"><td></td></tr></tbody></table><img height="1" src="https://ci5.googleusercontent.com/proxy/lehYhn8ZDmZju4Mu6M5sfyPk7-YqtRGnix_Fr5ZDDKOy1rnaQRtSYlbi1PVmY4mJ84t8KFVt5bvjY4a-6GBFB3OoR0U7YQwZjthqlqszZn75Nr-12D58Esoph5V6CjUwztlv5wuMebA90UeR1u0bvF-s72OFKtHuGiXrXuP6vdynPYDrEyqNBnkb45u6OXOVfibOrGhqtnePW5l0Lahh5LC6KEcOlbrjMEs6t9zJUSVFOTF3DHj-qLgDr6IIcNSfkjYrGd9-Hjxda6yWjSYZJLzlwuJSis616WM3A5h3R6F9Wc_-ly1L_6D_oXvSKuDyYwRTI_KeJ8g-daQacMgrFUHQRczJtxqH06ltVR6JPeGNxige1HhZQP6PfHFvL9Utrk-z2WY-DEtKyBcfjs1rEaCtR1gFpLDJU_0yhr8gNfP5QVNDiDJYIz05vHifyKcMkNesPozlsv-EW3cCzmwRsdQk5xrwIoyAng=s0-d-e1-ft#https://notifications.googleapis.com/email/t/AFG8qyVChqlooQDPoY-b8gVxOhRBNj_fGxPp7YZr_yWCStmWSzudyYdIC62_KTf-yGV25ru1RYi3t-ks7Wn-gZM6duNFvZ0Kq3QOso0Rh7tojWBdNJHD9VtcA0vKb-31nJ6CsDq-kfU7SQk55F1i_0sWRCshcsIfXpeI2I-jpXcEdsBpByoLMK1Kod7XeZepv4K60Z20SpOLEa8Lt3XBpdzuVIDQMzGrLJPIqmUYHUOqpLyJdK-w7QgM10h-Vm25kXgt4S_u0bG_e1NIvzYDXvD9LwPZrHmw8g/a.gif" width="1" class="CToWUd"></div></div><div class="yj6qo"></div></div>';   
			$crlf = "\n"; 
			$headers = array('From'=>$sender,'To'=>$correo_electronico,'Return-Path' => $sender,'Subject'  => $subject,'X-Priority' =>1,'Errors-To'=>$configuraciones->correo_paypal);     
			$mime = new Mail_mime($crlf);
			$mime->setHTMLBody($html); 
			$mimeparams=array();
			$mimeparams['text_encoding']="7bit";
			$mimeparams['text_charset']="UTF-8";
			$mimeparams['html_charset']="UTF-8";
			$body = $mime->get($mimeparams); 
			$headers = $mime->headers($headers); 
			$params["host"] = $configuraciones->smtp_host;					
			$params["port"] = $configuraciones->smtp_port;				
			$params["auth"] = true;
			$params["username"] = $configuraciones->smtp_user;				
			$params["password"] = $configuraciones->smtp_pass;
			$mail = Mail::factory($configuraciones->protocol, $params); 
			$mail->send($recipient, $headers, $body);
			if (PEAR::isError($mail)) 
			{ 
				$this->session->set_flashdata('envio', 'Error al enviar correo electrónico, intente nuevamente');
			} 
			else 
			{ 
			   $this->session->set_flashdata('envio', 'Hemos enviado Contraseña al Correo Electrónico <b>'.$correo_electronico.'</b>');	
			}
			redirect(base_url());
		   /* $config['protocol'] = 'smtp';      
		    $config["smtp_host"] = 'ssl://mail.sistemasonline2018.com.ve';      
		    $config["smtp_user"] = 'soporte@sistemasonline2018.com.ve';     
		    $config["smtp_pass"] = 'master170726..';      
		    $config["smtp_port"] = '465';      
		    $config['charset'] = 'utf-8';    
		    $config['wordwrap'] = TRUE;       
		    $config['validate'] = true;    
		    $this->email->initialize($config);     
		    $this->email->from('soporte@sistemasonline2018.com.ve', 'Soporte Tecnico');    
		    $this->email->to($correo_electronico, $fullname);     
		    $this->email->subject('Recuperación de Contraseña');		    
			$this->email->message("Sr(a): ".$fullname." hemos recibido una solicitud de repuración de contraseña al correo electrónico ".$correo_electronico. " le informamos que su contraseña para acceder a nuestro sistema de fotografias es: ".$clave_sin_cifrar." por motivos de seguridad si no esta en un PC que sea de propiedad una vez vista la clave le recomendamos que borre este correo electrónico Por Seguridad Muchas Gracias Por Usar Nuestros Servicios."); 
		    if($this->email->send())
		    {
		    	$this->session->set_flashdata('envio', 'Se te ha enviado la contraseña a tu correo electrónico revisa tu BANDEJA PRINCIPAL o SPAM...');
		    }
			else
			{
				$this->session->set_flashdata('envio', 'Hubo un Error al enviar el correo electrónico porfavor intente nuevamente!!');
			}        
				redirect(base_url());*/	
		}
	}
	else
	{	
		$this->session->set_flashdata('envio', 'Usuario No Registrado');
		 redirect(base_url());			
	}

    
   } 
public function consultar_correo()
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
	$numero_identificacion=$this->input->post('identificacion');
	$FuncionBuscarDNI=$this->Usuarios_model->get_numero_identificacion($numero_identificacion);
	if($FuncionBuscarDNI!=false)
	{
		$configuraciones=$this->Dependencias_model->get_configuracion();
		$correo_electronico=$FuncionBuscarDNI->correo_electronico;
		$nombres=$FuncionBuscarDNI->nombres;
		$apellidos=$FuncionBuscarDNI->apellidos;
		$full_name=$nombres.' '. $apellidos;
		$ip=$this->input->ip_address();
		$sender = $configuraciones->smtp_user;        // Your name and email address 
		$recipient = $correo_electronico;// The Recipients name and email address 
		$subject = "Solicitud de Correo Electrónico";           // Subject for the email 
		$html='<div id=":ab" class="ii gt"><div id=":aa" class="a3s aXjCH msg-1530226089000420248"><u></u><div bgcolor="#FFFFFF" style="margin:0;padding:0"><table border="0" cellpadding="0" cellspacing="0" height="100%" lang="es" style="min-width:348px" width="100%"><tbody><tr height="32" style="height:32px"><td></td></tr><tr align="center"><td><div><div></div></div><table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:20px;max-width:516px;min-width:220px"><tbody><tr><td style="width:8px" width="8"></td><td><div align="center" class="m_-1530226089000420248mdv2rw" style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px"><img height="24" src="https://wayak.es/wp-content/uploads/2018/07/Wayak.jpg" style="width:75px;height:24px;margin-bottom:16px" width="100" class="CToWUd"><div style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word"><div style="font-size:24px">Solicitud de Correo Electrónico en el modulo&nbsp;Recuperación de Correo Electrónico</div><table align="center" style="margin-top:8px"><tbody><tr style="line-height:normal"><td align="right" style="padding-right:8px"><img height="20" src="https://ci4.googleusercontent.com/proxy/QpsGaULeBaBhhOTpb-uwGsICda8b1ae95rM7JtYlDtcjbrJ_fDlrGcQ9nUwocVilT_dWdlntnRieTr4GY_IFycf2zxXXuPXiHCdY7G5yRw7uJHHhalp2NYvY=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/anonymous_profile_photo.png" style="width:20px;height:20px;vertical-align:sub;border-radius:50%" width="20" class="CToWUd"></td><td><a style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:14px;line-height:20px">'.$correo_electronico.'</a></td></tr></tbody></table></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:center">Estimado Usuario hemos dectatado que ha solicitado la recuperacion de su correo electrónico desde un dispositivo nuevo ('.$os.'). Con la Dirección IP: '.$ip.' Te hemos enviado este correo electrónico para comprobar que lo hiciste tú.<div style="padding-top:32px;text-align:center"><a href="#">Ver actividad</a></div></div></div><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center"><div>Te hemos enviado este correo electrónico para informarte de cambios importantes en tu cuenta y en los servicios de nuestra empresa. No responder a este correo electrónico porque no sera atendido por nuestro sistema</div><div style="direction:ltr">© 2018-'.$ano.' SistemaOnline2018 C.A,<a class="m_-1530226089000420248afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:11px;line-height:18px;padding-top:12px;text-align:center"> La Morita II Av. Principal Santa Ines, Venezuela</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1547398360000000</div></div></td><td style="width:8px" width="8"></td></tr></tbody></table></td></tr><tr height="32" style="height:32px"><td></td></tr></tbody></table><img height="1" src="https://ci5.googleusercontent.com/proxy/lehYhn8ZDmZju4Mu6M5sfyPk7-YqtRGnix_Fr5ZDDKOy1rnaQRtSYlbi1PVmY4mJ84t8KFVt5bvjY4a-6GBFB3OoR0U7YQwZjthqlqszZn75Nr-12D58Esoph5V6CjUwztlv5wuMebA90UeR1u0bvF-s72OFKtHuGiXrXuP6vdynPYDrEyqNBnkb45u6OXOVfibOrGhqtnePW5l0Lahh5LC6KEcOlbrjMEs6t9zJUSVFOTF3DHj-qLgDr6IIcNSfkjYrGd9-Hjxda6yWjSYZJLzlwuJSis616WM3A5h3R6F9Wc_-ly1L_6D_oXvSKuDyYwRTI_KeJ8g-daQacMgrFUHQRczJtxqH06ltVR6JPeGNxige1HhZQP6PfHFvL9Utrk-z2WY-DEtKyBcfjs1rEaCtR1gFpLDJU_0yhr8gNfP5QVNDiDJYIz05vHifyKcMkNesPozlsv-EW3cCzmwRsdQk5xrwIoyAng=s0-d-e1-ft#https://notifications.googleapis.com/email/t/AFG8qyVChqlooQDPoY-b8gVxOhRBNj_fGxPp7YZr_yWCStmWSzudyYdIC62_KTf-yGV25ru1RYi3t-ks7Wn-gZM6duNFvZ0Kq3QOso0Rh7tojWBdNJHD9VtcA0vKb-31nJ6CsDq-kfU7SQk55F1i_0sWRCshcsIfXpeI2I-jpXcEdsBpByoLMK1Kod7XeZepv4K60Z20SpOLEa8Lt3XBpdzuVIDQMzGrLJPIqmUYHUOqpLyJdK-w7QgM10h-Vm25kXgt4S_u0bG_e1NIvzYDXvD9LwPZrHmw8g/a.gif" width="1" class="CToWUd"></div></div><div class="yj6qo"></div></div>';   
				    $crlf = "\n"; 
				    $headers = array('From'=>$sender,'To'=>$correo_electronico,'Return-Path' => $sender,'Subject'  => $subject,'X-Priority' =>1,'Errors-To'=>$configuraciones->correo_paypal);     
				    $mime = new Mail_mime($crlf);
				    $mime->setHTMLBody($html); 
				    $mimeparams=array();
					$mimeparams['text_encoding']="7bit";
					$mimeparams['text_charset']="UTF-8";
					$mimeparams['html_charset']="UTF-8";
				    $body = $mime->get($mimeparams); 
				    $headers = $mime->headers($headers); 
				    $params["host"] = $configuraciones->smtp_host;					
					$params["port"] = $configuraciones->smtp_port;				
					$params["auth"] = true;
					$params["username"] = $configuraciones->smtp_user;				
					$params["password"] = $configuraciones->smtp_pass;
				    $mail = Mail::factory($configuraciones->protocol, $params); 
				    $mail->send($recipient, $headers, $body);
				  /*  if (PEAR::isError($mail)) 
					{ 
						$this->session->set_flashdata('envio', 'Hubo un Error al enviar el correo electrónico porfavor intente nuevamente!!');
					} 
					else 
					{*/ 
					   $this->session->set_flashdata('envio', 'Su Correo Electrónico es: <b>'.$correo_electronico.'</b> Introduzca Contraseña, si no la recuerda recupérela a través del Correo Electrónico');	
					//}
					redirect(base_url());	

		/*$config['protocol'] = 'smtp';      
	    $config["smtp_host"] = 'ssl://mail.sistemasonline2018.com.ve';      
	    $config["smtp_user"] = 'soporte@sistemasonline2018.com.ve';     
	    $config["smtp_pass"] = 'master170726..';      
	    $config["smtp_port"] = '465';      
	    $config['charset'] = 'utf-8';    
	    $config['wordwrap'] = TRUE;       
	    $config['validate'] = true;    
	    $this->email->initialize($config);     
	    $this->email->from('soporte@sistemasonline2018.com.ve', 'Soporte Tecnico');    
	    $this->email->to($correo_electronico, $full_name);     
	    $this->email->subject('Solicitud de Correo Electrónico');		    
		$this->email->message("Estimado Cliente: ".$full_name." Hemos Recibido Una Solicitud de Correo Electrónico En El Sesión Recuperación de Correo Con La Dirección Ip:  ".$ip." Nuestro Es Deber Es Proteger Tu Cuenta Revisa Esa Actividad"); 
	    if($this->email->send())
	    {
	    	$this->session->set_flashdata('envio', "Estimado Cliente: ".$full_name." Su Dirección de Correo Electrónico Es: ".$correo_electronico." Introduzca su Contraseña");
	    }
	    else
	    {
	        $this->session->set_flashdata('envio', 'Hubo un Error al intentar solicitar el correo electrónico por favor intente nuevamente!!');
	    }        
	    redirect(base_url());*/
	}
	else
	{
		$this->session->set_flashdata('envio', 'DNI no se encuentra registrado');
				 redirect(base_url());
	}
	redirect(base_url());
}


public function generate_token($len = 40)
    {
        //un array perfecto para crear claves
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        //desordenamos el array chars
        shuffle($chars);
        $num_chars = count($chars) - 1;
        $token = '';
 
        //creamos una key de 40 carácteres
        for ($i = 0; $i < $len; $i++)
        {
            $token .= $chars[mt_rand(0, $num_chars)];
        }
        return $token;
    }

}

?>