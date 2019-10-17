<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('MYPDF.php');

class Exportar_Pdf extends CI_Controller
{
	
	public $encabezadoreporte = null;
	public $piepaginareporte = null;
	
	function __construct()
	{
		parent::__construct(); 
		$this->load->model('Reportes_model'); 	
		$this->load->helper('array');	
		/*$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}*/	 
	} 


	public function Consultas_Usuarios($huser)
	{
		//echo $huser;
		$datos_del_usuario=$this->Reportes_model->datos_del_usuario($huser);
		$perfiles_asignados=$this->Reportes_model->get_detalle_tabla_acceso_departamentos($huser);
		$carpetas_asignadas=$this->Reportes_model->get_detalle_tabla_acceso_carpetas($huser);
		$sistemas_asignados=$this->Reportes_model->get_detalle_tabla_acceso_sistemas($huser);
		$controladores_asignados=$this->Reportes_model->get_detalle_controladores($huser);
		//var_dump($perfiles_asignados);
		if($datos_del_usuario->nivel==1)
		{
			$nivel="SuperAdmin";
		}
		if($datos_del_usuario->nivel==2)
		{
			$nivel="Coordinador";
		}
		if($datos_del_usuario->nivel==3)
		{
			$nivel="Usuario";
		}
		//var_dump($datos_del_usuario);
		$pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Usuario: '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos);
		$pdf->SetAuthor(TITULO);		
		//$pdf->SetSubject('Factura');
		$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(15 , 30 ,15 ,true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', ' ', 9, ' ', true);
		$pdf->AddPage();		
		$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';		
		
		$html .= '	<h2 align="center">'.TITULO.'</h2>';

		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
			<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Datos del Usuario</h4></td>
			</tr>
           <tr>
	           <th align="left"><b>Nombre y Apellidos:</b></th>
	           <td align="left" colspan="4">'.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'</td>
			</tr>
			<tr>
				<th align="left"><b>Usuario:</b></th>
				<td align="left" colspan="4">'.$datos_del_usuario->usuario.'</td>
			</tr>				          
			<tr>
				<th align="left"><b>Correo Electrónico:</b></th>
				<td align="left" colspan="4">'.$datos_del_usuario->correo_electronico.'</td>
			</tr>
			<tr>
				<th align="left"><b>Nivel:</b></th>
				<td align="left" colspan="4">'.$nivel.'</td>
			</tr>
			<tr>
				<th align="left"><b>Oficina:</b></th>
				<td align="left" colspan="4">'.$datos_del_usuario->nombre_oficina.'</td>
			</tr>
			<tr>
				<th align="left"><b>Registrado el:</b></th>
				<td align="left" colspan="4">'.$datos_del_usuario->fecha_registro.'</td></tr>';			
		 	$html .= '</table>' ;
		 	
		 	

		 	if($perfiles_asignados!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Pertenece a los Perfiles</h4></td>
				</tr>';			
		 		$html.='<tr>
							<td align="left" colspan="4"><b>Perfiles:</b></td> 
							</tr>';
		 		foreach ($perfiles_asignados as $record): 
		 		{
		 			$html.='<tr>
							<td align="left" colspan="4">'.$record->nombre_departamento.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Pertenece a los Perfiles</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene perfiles asignados.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}

		 	if($carpetas_asignadas!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Tiene acceso a las carpetas</h4></td>
				</tr>';			
		 		$html.='<tr>
							<td align="left" colspan="4"><b>Carpetas:</b></td> 
							</tr>';
		 		foreach ($carpetas_asignadas as $record): 
		 		{
		 			$html.='<tr>
							<td align="left" colspan="4">'.$record->nombre_carpeta.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Tiene acceso a las carpetas</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene carpetas asignadas.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}

		 	if($sistemas_asignados!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Tiene acceso a los sistemas</h4></td>
				</tr>';			
		 		$html.='<tr>
							<td align="left" colspan="2"><b>Nombre Sistema</b></td> <td align="left" colspan="2"><b>Url del Sistema</b></td>
							</tr>';
		 		foreach ($sistemas_asignados as $record): 
		 		{
		 			
		 			$html.='<tr>
							<td align="left" colspan="2">'.$record->nombre_sistema.'</td> <td align="left" colspan="2">'.$record->url_sistema.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Tiene acceso a los sistemas</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene sistemas asignados.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}

		 	/*if($controladores_asignados!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Tiene acceso a los controladores</h4></td>
				</tr>';			
		 		$html.='<tr>
							<td align="left" colspan="2"><b>Controladores</b></td>
							</tr>';
		 		foreach ($controladores_asignados as $record): 
		 		{		 			
		 			$html.='<tr>
							<td align="left" colspan="2">'.$record->controller.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Tiene acceso a los controladores</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene controladores asignados.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}*/
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		//var_dump($html);	
		$pdf->lastPage();
		$pdf->Output('Consultas de Usuarios: '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'.pdf', 'I');
	}
	public function Consultas_Carpetas($hcarpeta)
	{
		$nombre_carpeta=$this->Reportes_model->nombre_carpeta($hcarpeta);
		$usuarios_asignados=$this->Reportes_model->get_users_folders($hcarpeta);
		$perfiles_asignados=$this->Reportes_model->get_users_room($hcarpeta);
		$pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Carpeta: '.$nombre_carpeta->nombre_carpeta);
		$pdf->SetAuthor(TITULO);		
		//$pdf->SetSubject('Factura');
		$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(15 , 30 ,15 ,true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', ' ', 9, ' ', true);
		$pdf->AddPage();		
		$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';			 
		$html .= '<h2 align="center">'.TITULO.'</h2>';

		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
			<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Carpeta: '.$nombre_carpeta->nombre_carpeta.'</h4></td>
			</tr>';			
		$html .= '</table><br><br><br>';	

		 	if($usuarios_asignados!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Usuarios que pueden acceder a esta carpeta:</h4></td>
				</tr>';
		 		
		 		$html.='<tr>
							<td align="left" colspan="2"><b>Usuarios</b></td> <td align="left" colspan="2"><b>Oficina</b></td>
							</tr>';
		 		foreach ($usuarios_asignados as $record): 
		 		{
		 			$html.='<tr>
							<td align="left" colspan="2">'.$record->nombres.' '.$record->apellidos.'</td> <td align="left" colspan="2">'.$record->nombre_oficina.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Usuarios que pueden acceder a esta carpeta:</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente esta carpeta no tiene usuarios asignados.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}

		 	if($perfiles_asignados!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Perfiles que tienen asignada esta carpeta:</h4></td>
				</tr>';
		 		
		 		$html.='<tr>
							<td align="left" colspan="r"><b>Perfiles:</b></td> 
							</tr>';
		 		foreach ($perfiles_asignados as $record): 
		 		{
		 			$html.='<tr>
							<td align="left" colspan="2">'.$record->nombre_departamento.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Perfiles que tienen asignada esta carpeta:</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente esta carpeta no tiene usuarios asignados.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}		 
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		//var_dump($html);	
		$pdf->lastPage();
		$pdf->Output('Consultas de Carpeta: '.$nombre_carpeta->nombre_carpeta.'.pdf', 'I');
	}
	public function Consultas_Perfiles($hdepartamento)
	{
		$nombre_perfil=$this->Reportes_model->nombre_perfil($hdepartamento);
		$usuarios_asignados=$this->Reportes_model->get_users_departamentos($hdepartamento);
		$carpetas_asociadas=$this->Reportes_model->get_users_folders_pertenecen($hdepartamento);
		$pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Perfil: '.$nombre_perfil->nombre_departamento);
		$pdf->SetAuthor(TITULO);		
		//$pdf->SetSubject('Factura');
		$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(15 , 30 ,15 ,true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', ' ', 9, ' ', true);
		$pdf->AddPage();		
		$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';			 
		$html .= '<h2 align="center">'.TITULO.'</h2>';

		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
			<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Perfil: '.$nombre_perfil->nombre_departamento.'</h4></td>
			</tr>';			
		$html .= '</table><br><br><br>';	

		 	if($usuarios_asignados!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Usuarios que pueden acceder a este perfil:</h4></td>
				</tr>';
		 		
		 		$html.='<tr>
							<td align="left" colspan="2"><b>Usuarios:</b></td> <td align="left" colspan="2"><b>Oficina</b></td>
							</tr>';
		 		foreach ($usuarios_asignados as $record): 
		 		{
		 			$html.='<tr>
							<td align="left" colspan="2">'.$record->nombres.' '.$record->apellidos.'</td> <td align="left" colspan="2">'.$record->nombre_oficina.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Usuarios que pueden acceder a este perfil:</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente este perfil no tiene usuarios asignados.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}

		 	if($carpetas_asociadas!=false)
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Carpetas asociadas al Perfil:</h4></td>
				</tr>';
		 		
		 		$html.='<tr>
							<td align="left" colspan="r"><b>Carpetas:</b></td> 
							</tr>';
		 		foreach ($carpetas_asociadas as $record): 
		 		{
		 			$html.='<tr>
							<td align="left" colspan="2">'.$record->nombre_carpeta.'</td>
							</tr>';		
		 		}
		 		endforeach;
		 		$html .= '</table>' ;
		 	}
		 	else
		 	{
		 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Carpetas asociadas al Perfil:</h4></td>
				</tr>
           		<tr>
	           	<td align="center" colspan="4"><b>Actualmente este perfil no tiene carpetas asignadas.</b></td>	           
				</tr>';			
		 		$html .= '</table>' ;
		 	}	 
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		//var_dump($html);	
		$pdf->lastPage();
		$pdf->Output('Consultas de Perfiles: '.$nombre_perfil->nombre_departamento.'.pdf', 'I');
	}
	public function Consultas_Horarios($huser)
	{
		$datos_del_usuario=$this->Reportes_model->datos_del_usuario($huser);
		$contratos_usuarios=$this->Reportes_model->get_contratos($huser);
		if($contratos_usuarios!=false)
		{

			//$horarios_entradas=$this->Reportes_model->get_horarios_entradas($huser);
			$vacaciones_usuarios=$this->Reportes_model->buscar_fechas_vacaciones($huser,$contratos_usuarios->id);
			if($contratos_usuarios!=false)
			{
				$dias_laborables=$this->Reportes_model->get_detalle_dias_laborables($contratos_usuarios->id,$huser);
			}
			else
			{
				$dias_laborables=false;
			}	
			$pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetTitle('Horarios: '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos );
			$pdf->SetAuthor(TITULO);		
			//$pdf->SetSubject('Factura');
			$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(15 , 30 ,15 ,true);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->setFontSubsetting(true);
			$pdf->SetFont('helvetica', ' ', 9, ' ', true);
			$pdf->AddPage();
			if($datos_del_usuario->nivel==1)
			{
				$nivel="SuperAdmin";
			}
			if($datos_del_usuario->nivel==2)
			{
				$nivel="Coordinador";
			}
			if($datos_del_usuario->nivel==3)
			{
				$nivel="Usuario";
			}		
			$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';			 
			$html .= '<h2 align="center">'.TITULO.'</h2>';

			$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4>Datos del Usuario</h4></td>
				</tr>
	           <tr>
		           <th align="left"><b>Nombre y Apellidos:</b></th>
		           <td align="left" colspan="4">'.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'</td>
				</tr>
				<tr>
					<th align="left"><b>Usuario:</b></th>
					<td align="left" colspan="4">'.$datos_del_usuario->usuario.'</td>
				</tr>				          
				<tr>
					<th align="left"><b>Correo Electrónico:</b></th>
					<td align="left" colspan="4">'.$datos_del_usuario->correo_electronico.'</td>
				</tr>
				<tr>
					<th align="left"><b>Nivel:</b></th>
					<td align="left" colspan="4">'.$nivel.'</td>
				</tr>
				<tr>
					<th align="left"><b>Oficina:</b></th>
					<td align="left" colspan="4">'.$datos_del_usuario->nombre_oficina.'</td>
				</tr>
				<tr>
					<th align="left"><b>Registrado el:</b></th>
					<td align="left" colspan="4">'.$datos_del_usuario->fecha_registro.'</td></tr>';			
			 	$html .= '</table>' ;

			if($contratos_usuarios!=false)
			 	{
			 		if($contratos_usuarios->estatus==1)
			 		{
			 			$estatus="Activo";
			 		}
			 		if($contratos_usuarios->estatus==2)
			 		{
			 			$estatus="Renuncia";
			 		}
			 		if($contratos_usuarios->estatus==3)
			 		{
			 			$estatus="Finalizado";
			 		}
			 		if($contratos_usuarios->estatus==4)
			 		{
			 			$estatus="Despido";
			 		}
			 		if($contratos_usuarios->tipo_contrato==0)
			 		{
			 			$tipo_contrato="Sin Definir Contrato";
			 		}
			 		if($contratos_usuarios->tipo_contrato==1)
			 		{
			 			$tipo_contrato="Indefinido";
			 		}
			 		if($contratos_usuarios->tipo_contrato==2)
			 		{
			 			$tipo_contrato="Término Fijo";
			 		}
			 		if($contratos_usuarios->tipo_contrato==3)
			 		{
			 			$tipo_contrato="Prestación de Servicios";
			 		}
			 		if($contratos_usuarios->tipo_contrato==4)
			 		{
			 			$tipo_contrato="Conv. Prácticas Curriculares";
			 		}
			 		if($contratos_usuarios->tipo_contrato==5)
			 		{
			 			$tipo_contrato="Conv. Prácticas Extracurriculares";
			 		}
			 		if($contratos_usuarios->tipo_contrato==6)
			 		{
			 			$tipo_contrato="Contrato de Prácticas";
			 		}

			 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
					<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4> Contrato</h4></td>
					</tr>'; 
			 		$html.='<tr>
								<td align="left" colspan="2"><b>Fecha Contrato:</b></td> 
								<td align="left" colspan="2"><b>Fecha Fin Periodo de Prueba:</b></td>								
							</tr>
			 				<tr>
								<td align="left" colspan="2">'.$contratos_usuarios->fecha_inicio_contrato.'</td> 
								<td align="left" colspan="2">'.$contratos_usuarios->fecha_perioro_prueba.'</td>								
							</tr>
							<tr>
								<td align="left" colspan="2"><b>Fecha Fin Contrato:</b></td> 
								<td align="left" colspan="2"><b>Estatus</b></td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$contratos_usuarios->fecha_fin_contrato.'</td> 
								<td align="left" colspan="2">'.$estatus.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2"><b>Tipo Contrato:</b></td> 								
							</tr>
							<tr>
								<td align="left" colspan="2">'.$tipo_contrato.'</td> 								
							</tr>';							
			 		$html .= '</table>';
			 	}
			 	else
			 	{
			 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
					<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4>Contrato</h4></td>
					</tr>
	           		<tr>
		           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene fechas de contrato asignadas.</b></td>	           
					</tr>';			
			 		$html .= '</table>' ;
			 	}			 
			 	if($vacaciones_usuarios!=false)
			 	{
			 		
			 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
					<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4>Vacaciones</h4></td>
					</tr>';
			 		$html.='<tr>
								<td align="left"><b>Fecha Vacaciones Desde:</b></td> 
								<td align="left"><b>Fecha Vacaciones Hasta:</b></td>								
								<td align="left"><b>Estatus:</b></td>
							</tr>
			 				';
			 		foreach ($vacaciones_usuarios as $record):
			 		{
					 		if($record->estatus==1)
					 		{
					 			$estatus="Activas";
					 		}
					 		if($record->estatus==2)
					 		{
					 			$estatus="Pendientes";
					 		}
					 		if($record->estatus==3)
					 		{
					 			$estatus="Vencidas";
					 		}
					 		if($record->estatus==4)
					 		{
					 			$estatus="Cumplidas";
					 		}
					 		if($record->estatus==5)
					 		{
					 			$estatus="Interrumpidas";
					 		}
					 		if($record->estatus==6)
					 		{
					 			$estatus="Canceladas";
					 		}
			 			$html.='<tr>
								<td align="left">'.$record->fecha_desde.'</td> 
								<td align="left">'.$record->fecha_hasta.'</td>								
								<td align="left">'.$estatus.'</td>
							</tr>';
			 		}
			 		endforeach;

			 		$html .= '</table>';

			 		/*<tr>
								<td align="left" colspan="2">'.$vacaciones_usuarios->fecha_desde.'</td> 
								<td align="left" colspan="2">'.$vacaciones_usuarios->dias_vacaciones.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2"><b>Fecha Vacaciones Hasta:</b></td> 
								<td align="left" colspan="2"><b>Estatus:</b></td> 
							</tr>
							<tr>
								<td align="left" colspan="2">'.$vacaciones_usuarios->fecha_hasta.'</td>
								<td align="left" colspan="2">'.$estatus.'</td> 
							</tr>*/
			 	}
			 	else
			 	{
			 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
					<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4>Vacaciones:</h4></td>
					</tr>
	           		<tr>
		           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene vacaciones asignadas.</b></td>	           
					</tr>';			
			 		$html .= '</table>' ;
			 	}
			 	if($dias_laborables!=false)
			 	{
			 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
					<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4>Días Laborables:</h4></td>
					</tr>'; 		
			 	/**/
			 		
			 		$html.='<tr>
							<td align="left" ><b>Día Laborable:</b></td>
							<td align="left" ><b>Hora Entrada:</b></td>
							<td align="left" ><b>Hora Salida:</b></td>
								</tr>';			 		
			 		
			 		foreach ($dias_laborables as $record):
			 		{
			 			$html.='<tr>
								<td align="left">'.$record->dia_laborable.'</td> 
								<td align="left">'.$record->hora_entrada.'</td>
								<td align="left">'.$record->hora_salida.'</td>
							</tr>';
			 		}
			 		endforeach;
			 		$html .= '</table>' ;
			 	}
			 	else
			 	{
			 		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
					<tr bgcolor="#E5E5E5">
				    <td border="0" colspan="4"><h4>Días Laborables:</h4></td>
					</tr>
	           		<tr>
		           	<td align="center" colspan="4"><b>Actualmente este usuario no tiene días laborables asignados.</b></td>	           
					</tr>';			
			 		$html .= '</table>' ;
			 	}
		}
		else
		{
			echo '<p align="center">Actualmente el Empleado: <b>'.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'</b> no tiene contrato asignado aun por lo que no podemos cargar un historial laboral.</p>';
			return false;
		}

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		//var_dump($html);	
		$pdf->lastPage();
		$pdf->Output('Consultas de Horarios: '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'.pdf', 'I');
	}
	public function Asistencia($huser,$fecha_desde_fea,$fecha_hasta_fea)
	{
		//echo $huser;
		$fecha_desde_voltear=explode("-",$fecha_desde_fea);
		$dia_desde=$fecha_desde_voltear[0];
		$mes_desde=$fecha_desde_voltear[1];
		$ano_desde=$fecha_desde_voltear[2];
		$fecha_hasta_voltear=explode("-",$fecha_hasta_fea);
		$dia_hasta=$fecha_hasta_voltear[0];
		$mes_hasta=$fecha_hasta_voltear[1];
		$ano_hasta=$fecha_hasta_voltear[2];
		$fecha_desde=$ano_desde.'-'.$mes_desde.'-'.$dia_desde;
		$fecha_hasta=$ano_hasta.'-'.$mes_hasta.'-'.$dia_hasta;
		$configuraciones_sistemas=$this->Reportes_model->get_configuraciones_sistemas();
		$datos_del_usuario=$this->Reportes_model->datos_del_usuario($huser);
		$asistencia=$this->Reportes_model->get_asistencia_rango_fecha($huser,$fecha_desde,$fecha_hasta);
		
		$acumulador_horas=0;
		$acumulador_minutos=0;
		$acumulador_segundos=0;
		if($datos_del_usuario->dni==null)
		{
			$dni='Sin DNI Asignado';
		}
		else
		{
			$dni=$datos_del_usuario->dni;
		}		
		
		$pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Empleado: '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.' Asistencia Desde: '.$dia_desde.'-'.$mes_desde.'-'.$ano_desde.' '.'Hasta: '.$dia_hasta.'-'.$mes_hasta.'-'.$ano_hasta);
		$pdf->SetAuthor($configuraciones_sistemas->nombre_sistema);			
		$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(15 , 30 ,15 ,true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', ' ', 9, ' ', true);
		$pdf->AddPage();		
		$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';		
		
		$html .= '	<h2 align="center">'.$configuraciones_sistemas->nombre_sistema.'</h2>';

		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
			<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Datos del Usuario</h4></td>
			</tr>
           <tr>
	           <th align="left"><b>Nombre y Apellidos:</b></th>
	           <td align="left" colspan="4">'.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'</td>
			</tr>
			<tr>
				<th align="left"><b>DNI:</b></th>
				<td align="left" colspan="4">'.$dni.'</td>
			</tr>				          
						
			<tr>
				<th align="left"><b>Oficina:</b></th>
				<td align="left" colspan="4">'.$datos_del_usuario->nombre_oficina.'</td>
			</tr>
			<tr>
				<th align="left"><b>Fecha Documento:</b></th>
				<td align="left" colspan="4">'.date('d/m/Y G:i:s').'</td></tr>';			
		 	$html .= '</table>' ;	 	

		 	$html.='<table width="100%" border="0" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Informe de Asistencia</h4></td>
				</tr>';

				
			$html.='<tr>
						<td align="left" colspan="4"><b>Rango de Consulta:</b></td> 
					</tr>
					<tr>
						<td align="left" colspan="4"><b>Desde:</b> '.$dia_desde.'/'.$mes_desde.'/'.$ano_desde.'</td> 
					</tr>
					<tr>
						<td align="left" colspan="4"><b>Hasta:</b> '.$dia_hasta.'/'.$mes_hasta.'/'.$ano_hasta.'</td> 
					</tr>';	
			$html.='<tr align="center">						
						<td><b>Fecha:</b></td> 
						<td><b>Entrada:</b></td>
						<td><b>Salida:</b></td>
						<td><b>Total Horas:</b></td>
					</tr>';	
			foreach ($asistencia as $record_asistencia):
		 	{
		 		
		 		if($record_asistencia->type==4)
		 		{
		 			$hora_entrada=$record_asistencia->horario_entrada;
		 			$hora_salida=$record_asistencia->horario_salida;
					$fecha1 = new DateTime($hora_entrada);//fecha inicial
					$fecha2 = new DateTime($hora_salida);//fecha de cierre
					$intervalo = $fecha1->diff($fecha2);
					//$tiempo_total= $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
					$horas_acumuladas= $intervalo->format('%H');
					$minutos_acumulados= $intervalo->format('%i');
					$segundos_acumulados= $intervalo->format('%s');
					if($minutos_acumulados<10 or $minutos_acumulados==0)
					{
						$minutos_acumulados='0'.$minutos_acumulados;
					}
					if($segundos_acumulados<10 or $segundos_acumulados==0)
					{
						$segundos_acumulados='0'.$segundos_acumulados;
					}					
					$tiempo_total=$horas_acumuladas.':'.$minutos_acumulados.':'.$segundos_acumulados;
					$acumulador_horas=$acumulador_horas+$horas_acumuladas;
					$acumulador_minutos=$acumulador_minutos+$minutos_acumulados;
					$acumulador_segundos=$acumulador_segundos+$segundos_acumulados;
					if($acumulador_horas<10)
					{
						$acumulador_horas='0'.$acumulador_horas;
					}
					if($acumulador_minutos<10)
					{
						$acumulador_minutos='0'.$acumulador_minutos;
					}
					if($acumulador_segundos<10)
					{
						$acumulador_segundos='0'.$acumulador_segundos;
					}
					
					if($acumulador_segundos>=60)
					{
						$acumulador_minutos=$acumulador_minutos+1;
						$acumulador_segundos=$acumulador_segundos-60;
						if($acumulador_minutos<10)
						{
							$acumulador_minutos='0'.$acumulador_minutos;
						}
						if($acumulador_segundos<10)
						{
							$acumulador_segundos='0'.$acumulador_segundos;
						}
					}
					if($acumulador_minutos>=60)
					{
						$acumulador_horas=$acumulador_horas+1;
						$acumulador_minutos=$acumulador_minutos-60;
						if($acumulador_minutos<10)
						{
							$acumulador_minutos='0'.$acumulador_minutos;
						}
					}
		 		}
		 		else
		 		{
		 			$hora_entrada=$record_asistencia->horario_entrada;
		 			$hora_salida='Sin Marcar Salida';
		 			$tiempo_total= 'Sin Calcular Tiempo';
		 		}
		 		$html.='<tr align="center">
		 		
						<td>'.$record_asistencia->fecha.'</td> 
						<td>'.$hora_entrada.'</td>
						<td>'.$hora_salida.'</td>
						<td>'.$tiempo_total.'</td>
					</tr>';
		 	}
		 	endforeach;			
		 	$html.='<tr>
						<td></td> 
						<td></td>
						<td></td>
						<td><b>'.$acumulador_horas.':'.$acumulador_minutos.':'.$acumulador_segundos.'</b></td>
					</tr>';
			$html .= '</table>' ;		 	
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);		
		$pdf->lastPage();
		$pdf->Output('Control de Asistencia Empleado:  '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.' Desde: '.$dia_desde.'-'.$mes_desde.'-'.$ano_desde.' '.'Hasta: '.$dia_hasta.'-'.$mes_hasta.'-'.$ano_hasta.'.pdf', 'I');
	}
	//public function Asistencia_Detallada($huser,$dia_desde,$mes_desde,$ano_desde,$dia_hasta,$mes_hasta,$ano_hasta)
	public function Asistencia_Detallada($huser,$fecha_desde_fea,$fecha_hasta_fea)
	{
		$fecha_desde_voltear=explode("-",$fecha_desde_fea);
		$dia_desde=$fecha_desde_voltear[0];
		$mes_desde=$fecha_desde_voltear[1];
		$ano_desde=$fecha_desde_voltear[2];
		$fecha_hasta_voltear=explode("-",$fecha_hasta_fea);
		$dia_hasta=$fecha_hasta_voltear[0];
		$mes_hasta=$fecha_hasta_voltear[1];
		$ano_hasta=$fecha_hasta_voltear[2];
		$fecha_desde=$ano_desde.'-'.$mes_desde.'-'.$dia_desde;
		$fecha_hasta=$ano_hasta.'-'.$mes_hasta.'-'.$dia_hasta;
		$configuraciones_sistemas=$this->Reportes_model->get_configuraciones_sistemas();
		$datos_del_usuario=$this->Reportes_model->datos_del_usuario($huser);
		$acumulador_horas=0;
		$acumulador_minutos=0;
		$acumulador_segundos=0;

		$acumulador_horas_reunion=0;
		$acumulador_minutos_reunion=0;
		$acumulador_segundos_reunion=0;
		if($datos_del_usuario->dni==null)
		{
			$dni='Sin DNI Asignado';
		}
		else
		{
			$dni=$datos_del_usuario->dni;
		}		
		
		$pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Empleado: '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.' Asistencia Desde: '.$dia_desde.'-'.$mes_desde.'-'.$ano_desde.' '.'Hasta: '.$dia_hasta.'-'.$mes_hasta.'-'.$ano_hasta);
		$pdf->SetAuthor($configuraciones_sistemas->nombre_sistema);			
		$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(15 , 30 ,15 ,true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('helvetica', ' ', 9, ' ', true);
		$pdf->AddPage();		
		$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';		
		
		$html .= '	<h2 align="center">'.$configuraciones_sistemas->nombre_sistema.'</h2>';

		$html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
			<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="4"><h4>Datos del Usuario</h4></td>
			</tr>
           <tr>
	           <th align="left"><b>Nombre y Apellidos:</b></th>
	           <td align="left" colspan="4">'.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.'</td>
			</tr>
			<tr>
				<th align="left"><b>DNI:</b></th>
				<td align="left" colspan="4">'.$dni.'</td>
			</tr>				          
						
			<tr>
				<th align="left"><b>Oficina:</b></th>
				<td align="left" colspan="4">'.$datos_del_usuario->nombre_oficina.'</td>
			</tr>
			<tr>
				<th align="left"><b>Fecha Documento:</b></th>
				<td align="left" colspan="4">'.date('d/m/Y G:i:s').'</td></tr>';			
		 	$html .= '</table>' ;	 	

		 	$html.='<table width="100%" border="0" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				<tr bgcolor="#E5E5E5">
			    <td border="0" colspan="8"><h4>Informe de Asistencia</h4></td>
				</tr>';

				
			$html.='<tr>
						<td align="left" colspan="8"><b>Rango de Consulta:</b></td> 
					</tr>
					<tr>
						<td align="left" colspan="8"><b>Desde:</b> '.$dia_desde.'/'.$mes_desde.'/'.$ano_desde.'</td> 
					</tr>
					<tr>
						<td align="left" colspan="8"><b>Hasta:</b> '.$dia_hasta.'/'.$mes_hasta.'/'.$ano_hasta.'</td> 
					</tr>';	
			$html.='<tr bgcolor="#E5E5E5">
						<td><b>Fecha:</b></td> 
						<td><b>Entrada:</b></td>
						<td><b>Salida:</b></td>
						<td><b>Total Jornada:</b></td>
						<td><b>Break:</b></td>
						<td><b>Reunión:</b></td>
						<td><b>Inactividad:</b></td>
						<td><b>Total Horas:</b></td>
					</tr>';	
			$asistencia=$this->Reportes_model->get_asistencia_rango_fecha($huser,$fecha_desde,$fecha_hasta);
			if($asistencia!=false)
			{
				$acumulador_horas_jornada=0;
				$acumulador_minutos_jornada=0;
				$acumulador_segundos_jornada=0;				
				$total_jornada_acumulada=0;				
				$acumulador_horas_breaks=0;
				$acumulador_minutos_breaks=0;
				$acumulador_segundos_breaks=0;
				$total_breaks_acumulada=0;
				$acumulador_horas_reunion=0;
				$acumulador_minutos_reunion=0;
				$acumulador_segundos_reunion=0;
				$total_reunion_acumulada=0;
				$acumulador_horas_inactividad=0;
				$acumulador_minutos_inactividad=0;
				$acumulador_segundos_inactividad=0;
				$total_inactividad_acumulada=0;
				$acumulador_horas_descontar=0;
				$acumulador_minutos_descontar=0;
				$acumulador_segundos_descontar=0;
				$total_descontar_acumulada=0;
				foreach ($asistencia as $key => $mi_asistencia):
				{					
					if($mi_asistencia->type==4)
					{
						$total_jornada=$mi_asistencia->total_jornada;
						$total_horas_jornada_descontar=$mi_asistencia->total_horas;
						if(empty($mi_asistencia->breaks))
						{
							$breaks='00:00:00';
						}
						else
						{
							$breaks=$mi_asistencia->breaks;	
						}
						if(empty($mi_asistencia->reunion))
						{
							$reunion='00:00:00';
						}
						else
						{
							$reunion=$mi_asistencia->reunion;	
						}
						if(empty($mi_asistencia->inactividad))
						{
							$inactividad='00:00:00';
						}
						else
						{
							$inactividad=$mi_asistencia->inactividad;	
						}
						$total_jornada_laboral=explode(":",$total_jornada);					
						$horas_jornada_suma=$total_jornada_laboral[0];
						$minutos_jornada_suma=$total_jornada_laboral[1];
						$segundos_jornada_suma=$total_jornada_laboral[2];
						$acumulador_horas_jornada=$acumulador_horas_jornada+$horas_jornada_suma;
						$acumulador_minutos_jornada=$acumulador_minutos_jornada+$minutos_jornada_suma;
						$acumulador_segundos_jornada=$acumulador_segundos_jornada+$segundos_jornada_suma;
						if($acumulador_minutos_jornada==0 or $acumulador_minutos_jornada<10)
		 				{
		 					$acumulador_minutos_jornada='0'.$acumulador_minutos_jornada;
		 				}
		 				if($acumulador_segundos_jornada==0 or $acumulador_segundos_jornada<10)
		 				{
		 					$acumulador_segundos_jornada='0'.$acumulador_segundos_jornada;
		 				}
						if($acumulador_segundos_jornada>=60)
		 				{
		 					$acumulador_minutos_jornada=$acumulador_minutos_jornada+1;
		 					$acumulador_segundos_jornada=$acumulador_segundos_jornada-60;
		 					if($acumulador_minutos_jornada==0 or $acumulador_minutos_jornada<10)
			 				{
			 					$acumulador_minutos_jornada='0'.$acumulador_minutos_jornada;
			 				}
			 				if($acumulador_segundos_jornada==0 or $acumulador_segundos_jornada<10)
			 				{
			 					$acumulador_segundos_jornada='0'.$acumulador_segundos_jornada;
			 				}
		 				}
		 				if($acumulador_minutos_jornada>=60)
		 				{
		 					$acumulador_horas_jornada=$acumulador_horas_jornada+1;
		 					$acumulador_minutos_jornada=$acumulador_minutos_jornada-60;
		 					if($acumulador_minutos_jornada==0 or $acumulador_minutos_jornada<10)
			 				{
			 					$acumulador_minutos_jornada='0'.$acumulador_minutos_jornada;
			 				}			 				
		 				}
						$total_jornada_acumulada=$acumulador_horas_jornada.':'.$acumulador_minutos_jornada.':'.$acumulador_segundos_jornada;
						$total_jornada_laboral_breaks=explode(":",$breaks);					
						$horas_breaks_suma=$total_jornada_laboral_breaks[0];
						$minutos_breaks_suma=$total_jornada_laboral_breaks[1];
						$segundos_breaks_suma=$total_jornada_laboral_breaks[2];
						$acumulador_horas_breaks=$acumulador_horas_breaks+$horas_breaks_suma;
						$acumulador_minutos_breaks=$acumulador_minutos_breaks+$minutos_breaks_suma;
						$acumulador_segundos_breaks=$acumulador_segundos_breaks+$segundos_breaks_suma;
						if($acumulador_horas_breaks==0 or $acumulador_horas_breaks<10)
		 				{
		 					$acumulador_horas_breaks='0'.$acumulador_horas_breaks;
		 				}
						if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
		 				{
		 					$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
		 				}
		 				if($acumulador_segundos_breaks==0 or $acumulador_segundos_breaks<10)
		 				{
		 					$acumulador_segundos_breaks='0'.$acumulador_segundos_breaks;
		 				}
						if($acumulador_segundos_breaks>=60)
		 				{
		 					$acumulador_minutos_breaks=$acumulador_minutos_breaks+1;
		 					$acumulador_segundos_breaks=$acumulador_segundos_breaks-60;
		 					if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
			 				{
			 					$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
			 				}
			 				if($acumulador_segundos_breaks==0 or $acumulador_segundos_breaks<10)
			 				{
			 					$acumulador_segundos_breaks='0'.$acumulador_segundos_breaks;
			 				}
		 				}
		 				if($acumulador_minutos_breaks>=60)
		 				{
		 					$acumulador_horas_breaks=$acumulador_horas_breaks+1;
		 					$acumulador_minutos_breaks=$acumulador_minutos_breaks-60;
		 					if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
			 				{
			 					$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
			 				}			 				
		 				}
						$total_breaks_acumulada=$acumulador_horas_breaks.':'.$acumulador_minutos_breaks.':'.$acumulador_segundos_breaks;
						$total_jornada_laboral_reunion=explode(":",$reunion);					
						$horas_reunion_suma=$total_jornada_laboral_reunion[0];
						$minutos_reunion_suma=$total_jornada_laboral_reunion[1];
						$segundos_reunion_suma=$total_jornada_laboral_reunion[2];
						$acumulador_horas_reunion=$acumulador_horas_reunion+$horas_reunion_suma;
						$acumulador_minutos_reunion=$acumulador_minutos_reunion+$minutos_reunion_suma;
						$acumulador_segundos_reunion=$acumulador_segundos_reunion+$segundos_reunion_suma;
						if($acumulador_horas_reunion==0 or $acumulador_horas_reunion<10)
		 				{
		 					$acumulador_horas_reunion='0'.$acumulador_horas_reunion;
		 				}
						if($acumulador_minutos_reunion==0 or $acumulador_minutos_reunion<10)
		 				{
		 					$acumulador_minutos_reunion='0'.$acumulador_minutos_reunion;
		 				}
		 				if($acumulador_segundos_reunion==0 or $acumulador_segundos_reunion<10)
		 				{
		 					$acumulador_segundos_reunion='0'.$acumulador_segundos_reunion;
		 				}
						if($acumulador_segundos_reunion>=60)
		 				{
		 					$acumulador_minutos_reunion=$acumulador_minutos_reunion+1;
		 					$acumulador_segundos_reunion=$acumulador_segundos_reunion-60;
		 					if($acumulador_minutos_reunion==0 or $acumulador_minutos_reunion<10)
			 				{
			 					$acumulador_minutos_reunion='0'.$acumulador_minutos_reunion;
			 				}
			 				if($acumulador_segundos_reunion==0 or $acumulador_segundos_reunion<10)
			 				{
			 					$acumulador_segundos_reunion='0'.$acumulador_segundos_reunion;
			 				}
		 				}
		 				if($acumulador_minutos_reunion>=60)
		 				{
		 					$acumulador_horas_reunion=$acumulador_horas_reunion+1;
		 					$acumulador_minutos_reunion=$acumulador_minutos_reunion-60;
		 					if($acumulador_minutos_reunion==0 or $acumulador_minutos_reunion<10)
			 				{
			 					$acumulador_minutos_reunion='0'.$acumulador_minutos_reunion;
			 				}			 				
		 				}
						$total_reunion_acumulada=$acumulador_horas_reunion.':'.$acumulador_minutos_reunion.':'.$acumulador_segundos_reunion;
						$total_jornada_laboral_inactividad=explode(":",$inactividad);					
						$horas_inactividad_suma=$total_jornada_laboral_inactividad[0];
						$minutos_inactividad_suma=$total_jornada_laboral_inactividad[1];
						$segundos_inactividad_suma=$total_jornada_laboral_inactividad[2];
						$acumulador_horas_inactividad=$acumulador_horas_inactividad+$horas_inactividad_suma;
						$acumulador_minutos_inactividad=$acumulador_minutos_inactividad+$minutos_inactividad_suma;
						$acumulador_segundos_inactividad=$acumulador_segundos_inactividad+$segundos_inactividad_suma;
						if($acumulador_horas_inactividad==0 or $acumulador_horas_inactividad<10)
		 				{
		 					$acumulador_horas_inactividad='0'.$acumulador_horas_inactividad;
		 				}
						if($acumulador_minutos_inactividad==0 or $acumulador_minutos_inactividad<10)
		 				{
		 					$acumulador_minutos_inactividad='0'.$acumulador_minutos_inactividad;
		 				}
		 				if($acumulador_segundos_inactividad==0 or $acumulador_segundos_inactividad<10)
		 				{
		 					$acumulador_segundos_inactividad='0'.$acumulador_segundos_inactividad;
		 				}
						if($acumulador_segundos_inactividad>=60)
		 				{
		 					$acumulador_minutos_inactividad=$acumulador_minutos_inactividad+1;
		 					$acumulador_segundos_inactividad=$acumulador_segundos_inactividad-60;
		 					if($acumulador_minutos_inactividad==0 or $acumulador_minutos_inactividad<10)
			 				{
			 					$acumulador_minutos_inactividad='0'.$acumulador_minutos_inactividad;
			 				}
			 				if($acumulador_segundos_inactividad==0 or $acumulador_segundos_inactividad<10)
			 				{
			 					$acumulador_segundos_inactividad='0'.$acumulador_segundos_inactividad;
			 				}
		 				}
		 				if($acumulador_minutos_inactividad>=60)
		 				{
		 					$acumulador_horas_inactividad=$acumulador_horas_inactividad+1;
		 					$acumulador_minutos_inactividad=$acumulador_minutos_inactividad-60;
		 					if($acumulador_minutos_inactividad==0 or $acumulador_minutos_inactividad<10)
			 				{
			 					$acumulador_minutos_inactividad='0'.$acumulador_minutos_inactividad;
			 				}			 				
		 				}
						$total_inactividad_acumulada=$acumulador_horas_inactividad.':'.$acumulador_minutos_inactividad.':'.$acumulador_segundos_inactividad;
						$total_jornada_laboral_descontar=explode(":",$total_horas_jornada_descontar);					
						$horas_descontar_suma=$total_jornada_laboral_descontar[0];
						$minutos_descontar_suma=$total_jornada_laboral_descontar[1];
						$segundos_descontar_suma=$total_jornada_laboral_descontar[2];
						$acumulador_horas_descontar=$acumulador_horas_descontar+$horas_descontar_suma;
						$acumulador_minutos_descontar=$acumulador_minutos_descontar+$minutos_descontar_suma;
						$acumulador_segundos_descontar=$acumulador_segundos_descontar+$segundos_descontar_suma;
						if($acumulador_horas_descontar==0 or $acumulador_horas_descontar<10)
		 				{
		 					$acumulador_horas_descontar='0'.$acumulador_horas_descontar;
		 				}
						if($acumulador_minutos_descontar==0 or $acumulador_minutos_descontar<10)
		 				{
		 					$acumulador_minutos_descontar='0'.$acumulador_minutos_descontar;
		 				}
		 				if($acumulador_segundos_descontar==0 or $acumulador_segundos_descontar<10)
		 				{
		 					$acumulador_segundos_descontar='0'.$acumulador_segundos_descontar;
		 				}
						if($acumulador_segundos_descontar>=60)
		 				{
		 					$acumulador_minutos_descontar=$acumulador_minutos_descontar+1;
		 					$acumulador_segundos_descontar=$acumulador_segundos_descontar-60;
		 					if($acumulador_minutos_descontar==0 or $acumulador_minutos_descontar<10)
			 				{
			 					$acumulador_minutos_descontar='0'.$acumulador_minutos_descontar;
			 				}
			 				if($acumulador_segundos_descontar==0 or $acumulador_segundos_descontar<10)
			 				{
			 					$acumulador_segundos_descontar='0'.$acumulador_segundos_descontar;
			 				}
		 				}
		 				if($acumulador_minutos_descontar>=60)
		 				{
		 					$acumulador_horas_descontar=$acumulador_horas_descontar+1;
		 					$acumulador_minutos_descontar=$acumulador_minutos_descontar-60;
		 					if($acumulador_minutos_descontar==0 or $acumulador_minutos_descontar<10)
			 				{
			 					$acumulador_minutos_descontar='0'.$acumulador_minutos_descontar;
			 				}			 				
		 				}
						$total_descontar_acumulada=$acumulador_horas_descontar.':'.$acumulador_minutos_descontar.':'.$acumulador_segundos_descontar;
					}
					else
					{
						$total_jornada='Sin Culminar';
						$total_horas_jornada_descontar='Sin Determinar';
						if(empty($mi_asistencia->breaks))
						{
							$breaks='00:00:00';
						}
						else
						{
							$breaks=$mi_asistencia->breaks;	
						}
						if(empty($mi_asistencia->reunion))
						{
							$reunion='00:00:00';
						}
						else
						{
							$reunion=$mi_asistencia->reunion;	
						}
						if(empty($mi_asistencia->inactividad))
						{
							$inactividad='00:00:00';
						}
						else
						{
							$inactividad=$mi_asistencia->inactividad;	
						}
					}
					$html.='<tr>
						<td>'.$mi_asistencia->fecha.'</td> 
						<td>'.$mi_asistencia->horario_entrada.'</td>
						<td>'.$mi_asistencia->horario_salida.'</td>
						<td>'.$total_jornada.'</td>
						<td>'.$breaks.'</td>
						<td>'.$reunion.'</td>
						<td>'.$inactividad.'</td>
						<td>'.$total_horas_jornada_descontar.'</td>
					</tr>';
				}
				endforeach;	
				$html.='<tr>
						<td></td> 
						<td></td>
						<td></td>
						<td><b>'.$total_jornada_acumulada.'</b></td>
						<td><b>'.$total_breaks_acumulada.'</b></td>
						<td><b>'.$total_reunion_acumulada.'</b></td>
						<td><b>'.$total_inactividad_acumulada.'</b></td>
						<td><b>'.$total_descontar_acumulada.'</b></td>
					</tr>';		 	
				$html .= '</table>';
			}
			else
			{
				$html.='<tr>
						<td colspan="7" align="center">No se han encontrados datos en el rango de fecha seleccionados</td>
						</tr>';
				$html .='</table>';
			}
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$pdf->lastPage();
		$pdf->Output('Control de Asistencia Empleado:  '.$datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos.' Desde: '.$dia_desde.'-'.$mes_desde.'-'.$ano_desde.' '.'Hasta: '.$dia_hasta.'-'.$mes_hasta.'-'.$ano_hasta.'.pdf', 'I');
	}
}
?>
