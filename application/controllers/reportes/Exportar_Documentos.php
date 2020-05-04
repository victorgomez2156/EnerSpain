<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('MYPDF.php');
require(APPPATH. 'third_party/PHPExcel.php');
require(APPPATH. 'third_party/PHPExcel/IOFactory.php');
header('Content-Type: text/html; charset=utf-8');

class Exportar_Documentos extends CI_Controller
{
    public $encabezadoreporte = null;
	public $piepaginareporte = null;	
	function __construct()
	{
		parent::__construct(); 
        $this->load->model('Reportes_model'); 
        $this->load->model('Auditoria_model'); 	
        $this->load->helper('array');	
        $this->load->library('user_agent');  
        $this->load->helper('cookie');
		$datausuario=$this->session->all_userdata();	
		/*if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
        }*/       
    } 
    function index()
    {
        $mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
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
		$cookie_sesion=$this->input->cookie('EnerSpain');
		$hora_nueva=date('d/m/Y G:i:s');
        echo $mes[date('m')].' '.$dia[date('l')].' '.$hora_nueva;
        echo '<br>';
        echo 'Este módulo muestra los Reportes en formato Excel y PDF';
        echo '<br>';
        echo '<b>Datos de Conexión al Servidor:</b>';
        echo '<br>';
        echo 'Tu Dirección IP es: '.$this->input->ip_address().' <br><b>Cookie:</b>'.$cookie_sesion;
        echo '<br>';
        echo '<b>Sistema Operativo:</b> '. $os.' Con el <b>Navegador:</b> '.$agent.' <b>Versión:</b> '.$version;
        echo '<br>';
    }
    public function Clientes_Doc_PDF()
	{
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos los Clientes";
           $Tipo_Cliente="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {               
                $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Cliente";
            $Tipo_Cliente = $this->uri->segment(5);
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Cliente';
                return false;
            }
            else
            {
                $CodTipCli=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoCliente','DesTipCli',$Tipo_Cliente); 
                if($CodTipCli!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodTipCli',$CodTipCli->CodTipCli);
                }
                else
                {
                    echo 'Error o el Tipo de Filtro no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Sector Cliente";
            $Tipo_Cliente = $this->uri->segment(5);
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Sector';
                return false;
            }
            else
            {
                $CodTipCli=$this->Reportes_model->get_tipo_filtro_busqueda('T_SectorCliente','DesSecCli',$Tipo_Cliente); 
                if($CodTipCli!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodSecCli',$CodTipCli->CodSecCli);
                }
                else
                {
                    echo 'Error o el Tipo de Sector no se encuentra registrado';
                    return false;
                }
            }
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Provincia Fiscal";
            $Tipo_Cliente= urldecode($this->uri->segment(5));         
           if($Tipo_Cliente==null)
           {
                echo 'Error o no introdujo la Provincia';
                return false;
           }
           else
           {
                $Provincia_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Provincia','DesPro',$Tipo_Cliente);
                if($Provincia_Resultado!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('b.CodPro',$Provincia_Resultado->CodPro);
                } 
                else
                {
                    echo 'Error o la Provincia no se encuentra registrada';
                    return false; 
                }
           }             
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Localidad Fiscal";
            $Provincia= urldecode($this->uri->segment(5));
            $Tipo_Cliente= urldecode($this->uri->segment(6));           
            if($Provincia==null)
            {
                echo 'La Provincia no puede estar vacía';
                return false;
            }
            if($Tipo_Cliente==null)
            {
                echo 'La Localidad no puede estar vacía';
                return false;
            }
            if($Provincia!=null && $Tipo_Cliente!=null)
            {
                $Localidad_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Localidad','DesLoc',$Tipo_Cliente);
                if($Localidad_Resultado!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodLocFis',$Localidad_Resultado->CodLoc); 
                }
                else
                {
                    echo 'Error o la Localidad no se encuentra registrada';
                    return false; 
                }
            }
        }
        elseif($tipo_filtro==5)
        {
            $Tipo_Cliente= urldecode($this->uri->segment(5));
            $nombre_filtro="Comercial";
            if($Tipo_Cliente==null)
            {
                echo 'El Comercial no puede estar vacío';
                return false;
            }
            else
            {
                $Comercial_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercial','NomCom',$Tipo_Cliente);
                if($Comercial_Resultado!=false)
                {   
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodCom',$Comercial_Resultado->CodCom);
                }
                else
                {
                    echo 'Error o el Comercial no se encuentra registrado';
                    return false;
                }
            }
        }
        elseif($tipo_filtro==6)
        {
            $Tipo_Cliente= urldecode($this->uri->segment(5));
            $nombre_filtro="Colaborador";
            if($Tipo_Cliente==null)
            {
                echo 'El Colaborador no puede estar vacío';
                return false;
            }
            else
            {
                $Colaborador_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Colaborador','NomCol',$Tipo_Cliente);
                if($Colaborador_Resultado!=false)
                {   
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodCol',$Colaborador_Resultado->CodCol);
                }
                else
                {
                    echo 'Error o el Colaborador no se encuentra registrado';
                    return false;
                }
            }
        }
        else
        {
            $Tipo_Cliente=urldecode($this->uri->segment(5));
            $nombre_filtro="Estatus Cliente";
            if($Tipo_Cliente==null)
            {
                echo 'El Estatus del Cliente no puede estar vacío';
                return false;
            }
            else
            {                
                $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.EstCli',$Tipo_Cliente);
                if($Tipo_Cliente==3)
                {
                    $Tipo_Cliente="ACTIVO";
                }
                elseif($Tipo_Cliente==4) {
                    $Tipo_Cliente="BLOQUEADO";
                }
                else {
                    $Tipo_Cliente="Estatus de Cliente incorrecto";
                }
            }
        }
        $pdf = new TCPDF ('P','mm', 'A2', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Listado de Clientes PDF '.date('d/m/Y'));
		$pdf->SetAuthor(TITULO);		
		$pdf->SetSubject('Clientes_Doc_PDF');
		$pdf->SetHeaderData(PDF_HEADER_LOGO,80);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(15 , 30 ,15 ,true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('times', ' ', 10, ' ', true);
		$pdf->AddPage();		
		$html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';		
		$html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
			<tr>
                <td border="0" align="left"><h4>LISTADO DE CLIENTES</h4></td>
                <td border="0"><h4></h4></td>
                <td border="0"><h4></h4></td>
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.': '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;			
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
				';			
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CIF</td>
            <td style="color:white;">RAZÓN SOCIAL</td> 
            <td style="color:white;">NOMBRE COMERCIAL</td>            
            <td style="color:white;">DOMICILIO SOCIAL</td>
            <td style="color:white;">DOMICILIO FISCAL</td>
            <td style="color:white;">TELÉFONO</td>
            <td style="color:white;">EMAIL</td>
            <td style="color:white;">TIPO CLIENTE</td>
            <td style="color:white;">SECTOR</td>
            <td style="color:white;">COMERCIAL</td>
            <td style="color:white;">COLABORADOR</td>
            <td style="color:white;">FECHA INICIO</td>
            <td style="color:white;">ESTATUS</td>
		</tr>';
        if($Resultado_PropuestaComercial!=false)
		{
		 	foreach ($Resultado_PropuestaComercial as $record): 
		 	{
		 		$html.='<tr>
                        <td>'.$record->NumCifCli.'</td>
                        <td>'.$record->RazSocCli.'</td> 
                        <td>'.$record->NomComCli.'</td>
                        <td>'.$record->DesTipVia.' '.$record->NomViaDomSoc.' '.$record->NumViaDomSoc.' '.$record->BloDomSoc.' '.$record->EscDomSoc.' '.$record->PlaDomSoc.' '.$record->PueDomSoc.' '.$record->DesPro.' '.$record->DesLoc.'</td> 
                        <td>'.$record->DesTipViaFis.' '.$record->NomViaDomFis.' '.$record->NumViaDomFis.' '.$record->BloDomFis.' '.$record->EscDomFis.' '.$record->PlaDomFis.' '.$record->PueDomFis.' '.$record->DesProFis.' '.$record->DesLocFis.'</td>
                        <td>'.$record->TelFijCli.'</td>
                        <td>'.$record->EmaCli.'</td>                         
                         <td>'.$record->DesTipCli.'</td>
                         <td>'.$record->DesSecCli.'</td>
                         <td>'.$record->NomCom.'</td>
                         <td>'.$record->NomCol.'</td>
                         <td>'.$record->FecIniCli.'</td>
                         <td>'.$record->EstCli.'</td> 
					</tr>';		
		 		}
		 		endforeach;
		 	}
		 	else
		 	{
		 		$html.='
           		<tr>
	           	<td align="center" colspan="6"><b>No existen Clientes registrados</b></td>	           
				</tr>';	
		 	}   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF CLIENTES FILTRADOS');
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$pdf->lastPage();
		$pdf->Output('Clientes_Doc_PDF'.'.pdf', 'I');
    }
    public function Clientes_Doc_Excel()
	{
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos los Clientes";
           $Tipo_Cliente="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {               
                $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Cliente";
            $Tipo_Cliente = $this->uri->segment(5);
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Cliente';
                return false;
            }
            else
            {
                $CodTipCli=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoCliente','DesTipCli',$Tipo_Cliente); 
                if($CodTipCli!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodTipCli',$CodTipCli->CodTipCli);
                }
                else
                {
                    echo 'Error o el Tipo de Filtro no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Sector Cliente";
            $Tipo_Cliente = $this->uri->segment(5);
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Sector';
                return false;
            }
            else
            {
                $CodTipCli=$this->Reportes_model->get_tipo_filtro_busqueda('T_SectorCliente','DesSecCli',$Tipo_Cliente); 
                if($CodTipCli!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodSecCli',$CodTipCli->CodSecCli);
                }
                else
                {
                    echo 'Error o el Tipo de Sector no se encuentra Registrado';
                    return false;
                }
            }
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Provincia Fiscal";
            $Tipo_Cliente= urldecode($this->uri->segment(5));         
           if($Tipo_Cliente==null)
           {
                echo 'Error o no introdujo la Provincia';
                return false;
           }
           else
           {
                $Provincia_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Provincia','DesPro',$Tipo_Cliente);
                if($Provincia_Resultado!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('b.CodPro',$Provincia_Resultado->CodPro);
                } 
                else
                {
                    echo 'Error o la Provincia no se encuentra registrada';
                    return false; 
                }
           }             
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Localidad Fiscal";
            $Provincia= urldecode($this->uri->segment(5));
            $Tipo_Cliente= urldecode($this->uri->segment(6));           
            if($Provincia==null)
            {
                echo 'La Provincia no puede estar vacía';
                return false;
            }
            if($Tipo_Cliente==null)
            {
                echo 'La Localidad no puede estar vacía';
                return false;
            }
            if($Provincia!=null && $Tipo_Cliente!=null)
            {
                $Localidad_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Localidad','DesLoc',$Tipo_Cliente);
                if($Localidad_Resultado!=false)
                {
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodLocFis',$Localidad_Resultado->CodLoc); 
                }
                else
                {
                    echo 'Error o la Localidad no se encuentra registrada';
                    return false; 
                }
            }
        }
        elseif($tipo_filtro==5)
        {
            $Tipo_Cliente= urldecode($this->uri->segment(5));
            $nombre_filtro="Comercial";
            if($Tipo_Cliente==null)
            {
                echo 'El Comercial no puede estar vacío';
                return false;
            }
            else
            {
                $Comercial_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercial','NomCom',$Tipo_Cliente);
                if($Comercial_Resultado!=false)
                {   
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodCom',$Comercial_Resultado->CodCom);
                }
                else
                {
                    echo 'Error o el Comercial no se encuentra registrado';
                    return false;
                }
            }
        }
        elseif($tipo_filtro==6)
        {
            $Tipo_Cliente= urldecode($this->uri->segment(5));
            $nombre_filtro="Colaborador";
            if($Tipo_Cliente==null)
            {
                echo 'El Colaborador no puede estar vacío';
                return false;
            }
            else
            {
                $Colaborador_Resultado=$this->Reportes_model->get_tipo_filtro_busqueda('T_Colaborador','NomCol',$Tipo_Cliente);
                if($Colaborador_Resultado!=false)
                {   
                    $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.CodCol',$Colaborador_Resultado->CodCol);
                }
                else
                {
                    echo 'Error o el Colaborador no se encuentra registrado';
                    return false;
                }
            }
        }
        else
        {
            $Tipo_Cliente=urldecode($this->uri->segment(5));
            $nombre_filtro="Estatus Cliente";
            if($Tipo_Cliente==null)
            {
                echo 'El Estatus del Cliente no puede estar vacío';
                return false;
            }
            else
            {
                
                $Resultado_PropuestaComercial=$this->Reportes_model->get_data_cliente('a.EstCli',$Tipo_Cliente);
                if($Tipo_Cliente==3)
                {
                    $Tipo_Cliente="ACTIVO";
                }
                elseif($Tipo_Cliente==4) {
                    $Tipo_Cliente="BLOQUEADO";
                }
                else {
                    $Tipo_Cliente="Estatus de Cliente incorrecto";
                }
            }
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize'  => '15MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    	$datausuario=$this->session->all_userdata();	
		$fecha= date('Y-m-d_H:i:s');		
		$nombre_reporte='Clientes_Doc_Excel_'.$fecha.".xls";
		$objPHPExcel = new PHPExcel(); //nueva instancia		 
		$objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
		$objPHPExcel->getProperties()->setTitle("Clientes Doc Excel"); //titulo	
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));	
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));	
        $titulo->applyFromArray(
		  array('alignment' => array( //alineacion
		      'wrap' => false,
		      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
		    ),
		    'font' => array( //fuente
		      'bold' => true,
		      'size' => 20,'name'=>'Arial'
		    )
		));		 
		$subtitulo = new PHPExcel_Style(); //nuevo estilo		 
		$subtitulo->applyFromArray(
		  array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
		      'type' => PHPExcel_Style_Fill::FILL_SOLID,
		      //'color' => array('rgb' => '7a7a7a')
		    ),
		    'borders' => array( //bordes
		      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    )
		));	
		$bordes = new PHPExcel_Style(); //nuevo estilo
		$bordes->applyFromArray(
		  array('borders' => array(
		      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    )
		));
		//fin estilos		 
		$objPHPExcel->createSheet(0);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle("Clientes Doc Excel"); 
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);		
		$margin = 0.5 / 2.54; 
		$marginBottom = 1.2 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
		$objDrawing->setHeight(75);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
		$objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
		$objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);		
		$objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE CLIENTES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:B6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:B6");
       	
		$objPHPExcel->getActiveSheet()->SetCellValue("A9", "CIF");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "RAZÓN SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "NOMBRE COMERCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "DOMICILIO SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "PROVINCIA SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "LOCALIDAD SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "DOMICILIO FISCAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $objPHPExcel->getActiveSheet()->SetCellValue("H9", "PROVINCIA FISCAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
        $objPHPExcel->getActiveSheet()->SetCellValue("I9", "LOCALIDAD FISCAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I9");
        $objPHPExcel->getActiveSheet()->SetCellValue("J9", "TELÉFONO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J9");
        $objPHPExcel->getActiveSheet()->SetCellValue("K9", "EMAIL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K9");
        $objPHPExcel->getActiveSheet()->SetCellValue("L9", "TIPO CLIENTE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "L9");
        $objPHPExcel->getActiveSheet()->SetCellValue("M9", "SECTOR");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M9");
        $objPHPExcel->getActiveSheet()->SetCellValue("N9", "COMERCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "N9");
        $objPHPExcel->getActiveSheet()->SetCellValue("O9", "COLABORADOR");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O9");
        $objPHPExcel->getActiveSheet()->SetCellValue("P9", "FECHA INICIO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "P9");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
		$fila=9;
		for($i=0; $i<count($Resultado_PropuestaComercial); $i++) 
		{
			$fila+=1;
			$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_PropuestaComercial[$i]->NumCifCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_PropuestaComercial[$i]->RazSocCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_PropuestaComercial[$i]->NomComCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_PropuestaComercial[$i]->DesTipVia.' '.$Resultado_PropuestaComercial[$i]->NomViaDomSoc.' '.$Resultado_PropuestaComercial[$i]->NumViaDomSoc.' '.$Resultado_PropuestaComercial[$i]->BloDomSoc.' '.$Resultado_PropuestaComercial[$i]->EscDomSoc.' '.$Resultado_PropuestaComercial[$i]->PlaDomSoc.' '.$Resultado_PropuestaComercial[$i]->PueDomSoc);
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_PropuestaComercial[$i]->DesPro);
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_PropuestaComercial[$i]->DesLoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado_PropuestaComercial[$i]->DesTipViaFis.' '.$Resultado_PropuestaComercial[$i]->NomViaDomFis.' '.$Resultado_PropuestaComercial[$i]->NumViaDomFis.' '.$Resultado_PropuestaComercial[$i]->BloDomFis.' '.$Resultado_PropuestaComercial[$i]->EscDomFis.' '.$Resultado_PropuestaComercial[$i]->PlaDomFis.' '.$Resultado_PropuestaComercial[$i]->PueDomFis);
            $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado_PropuestaComercial[$i]->DesProFis);
            $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $Resultado_PropuestaComercial[$i]->DesLocFis);
            $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $Resultado_PropuestaComercial[$i]->TelFijCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", $Resultado_PropuestaComercial[$i]->EmaCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", $Resultado_PropuestaComercial[$i]->DesTipCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", $Resultado_PropuestaComercial[$i]->DesSecCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("N$fila", $Resultado_PropuestaComercial[$i]->NomCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("O$fila", $Resultado_PropuestaComercial[$i]->NomCol);
            $objPHPExcel->getActiveSheet()->SetCellValue("P$fila", $Resultado_PropuestaComercial[$i]->FecIniCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", $Resultado_PropuestaComercial[$i]->EstCli); 
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:Q$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
		}		 
		//insertar formula
		/*$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/		 
		//recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'Q') as $columnID) 
		{
		  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(35);
		}
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename='.$nombre_reporte.'');		
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL CLIENTES FILTRADOS');
		$objWriter->save('php://output');
		exit;	
    }
      public function Clientes_Doc_PDF_Actividades()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todas las Actividades";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Fecha de Inicio";
            $Tipo_Filtro = $this->uri->segment(5);
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo Fecha de Inicio de la Actividad';
                return false;
            }
            else
            {
                $separar_fecha=explode("-",$Tipo_Filtro); 
                $nueva_fecha=$separar_fecha[2].'-'.$separar_fecha[1].'-'.$separar_fecha[0];
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all_filtro('a.FecIniAct',$nueva_fecha);
            } 
        }
        elseif($tipo_filtro==2)
        {
            $Tipo_Filtro=urldecode($this->uri->segment(5));
            $nombre_filtro="Estatus de la Actividad";
            if($Tipo_Filtro==null)
            {
                echo 'El estatus de la Actividad no puede estar vacío';
                return false;
            }
            else
            {   
                if($Tipo_Filtro=="Activa")
                {
                    $EstAct=1;
                }
                else
                {
                   $EstAct=2; 
                }
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all_filtro('a.EstAct',$EstAct); 
            }
        }
        elseif($tipo_filtro==3)
        {
            $Tipo_Filtro=urldecode($this->uri->segment(5));
            $nombre_filtro="Clientes";
            if($Tipo_Filtro==null)
            {
                echo 'El código de Cliente no puede estar vacío';
                return false;
            }
            else
            {                
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all_filtro('a.CodCli',$Tipo_Filtro); 
            }
        }
        else
        {
            echo 'Tipo de filtro incorrecto';
            return false;
        }
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Actividades PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Clientes_Doc_PDF_Actividades');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="2"><h4>LISTADO DE ACTIVIDADES</h4></td>
                <td border="0"><h4></h4></td>
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.': '.$Tipo_Filtro.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CLIENTES</td>
            <td style="color:white;">CÓDIGO CNAE</td> 
            <td style="color:white;">DESCRIPCIÓN</td> 
            <td style="color:white;">GRUPO</td>
            <td style="color:white;">SUB-GRUPO</td>
            <td style="color:white;">SECCIÓN</td>            
            <td style="color:white;">FECHA ACTIVIDAD</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Actividades!=false)
        {
            foreach ($Resultado_Filtro_Actividades as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCli.' - '.$record->RazSocCli.'</td>
                        <td>'.$record->CodActCNAE.'</td>
                        <td>'.$record->DesActCNAE.'</td>
                        <td>'.$record->GruActCNAE.'</td>
                        <td>'.$record->SubGruActCNAE.'</td>
                        <td>'.$record->SecActCNAE.'</td>
                        <td>'.$record->FecIniAct.'</td>
                        <td>'.$record->EstAct.'</td>
                        
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="6"><b>No existen Actividades registradas</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF ACTIVIDADES FILTRADAS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Clientes_Doc_PDF_Actividades'.'.pdf', 'I');
    }
    public function Clientes_Doc_Excel_Actividades()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todas las Actividades";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Fecha de Inicio";
            $Tipo_Filtro = $this->uri->segment(5);
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo la Fecha de Inicio de la Actividad';
                return false;
            }
            else
            {
                $separar_fecha=explode("-",$Tipo_Filtro); 
                $nueva_fecha=$separar_fecha[2].'-'.$separar_fecha[1].'-'.$separar_fecha[0];
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all_filtro('a.FecIniAct',$nueva_fecha);
            } 
        }
        elseif($tipo_filtro==2)
        {
            $Tipo_Filtro=urldecode($this->uri->segment(5));
            $nombre_filtro="Estatus de la Actividad";
            if($Tipo_Filtro==null)
            {
                echo 'El estatus de la Actividad no puede estar vacío';
                return false;
            }
            else
            {   
                if($Tipo_Filtro=="Activa")
                {
                    $EstAct=1;
                }
                else
                {
                   $EstAct=2; 
                }
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all_filtro('a.EstAct',$EstAct); 
            }
        }
        elseif($tipo_filtro==3)
        {
            $Tipo_Filtro=urldecode($this->uri->segment(5));
            $nombre_filtro="CLIENTES";
            if($Tipo_Filtro==null)
            {
                echo 'El código de Cliente no puede estar vacío';
                return false;
            }
            else
            {                
                $Resultado_Filtro_Actividades=$this->Reportes_model->get_data_activity_all_filtro('a.CodCli',$Tipo_Filtro); 
            }
        }
        else
        {
            echo 'Tipo de filtro incorrecto';
            return false;
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Clientes_Doc_Excel_Activiades_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Clientes Doc Excel Actividades"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Clientes Doc Excel Actividades"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE ACTIVIADES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:B6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:B6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CLIENTES");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "CÓDIGO CNAE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "GRUPO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "SUB-GRUPO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "SECCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "FECHA INICIO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $objPHPExcel->getActiveSheet()->SetCellValue("H9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Actividades); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Actividades[$i]->NumCifCli .' - '.$Resultado_Filtro_Actividades[$i]->RazSocCli );
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Actividades[$i]->CodActCNAE);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Actividades[$i]->DesActCNAE);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Actividades[$i]->GruActCNAE);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Actividades[$i]->SubGruActCNAE);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_Filtro_Actividades[$i]->SecActCNAE);
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado_Filtro_Actividades[$i]->FecIniAct);
            $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado_Filtro_Actividades[$i]->EstAct);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:H$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Filtro);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'H') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ActividadCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL ACTIVIDADES FILTRADAS');
        $objWriter->save('php://output');
        exit;   
    }

     public function Clientes_Doc_PDF_Puntos_Suministros()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos las Direcciones de Suministro";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el tipo de filtro';
                return false;
            }
            else 
            {
                $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_Puntos_Suministros_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CLIENTE";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el código de Cliente';
                return false;
            }
            else
            {
               $Cliente=$this->Reportes_model->get_tipo_filtro_busqueda('T_Cliente','CodCli',$Tipo_Filtro);
                if($Cliente!=false)
                {
                    $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.CodCli',$Tipo_Filtro);
                    $Tipo_Filtro=$Cliente->NumCifCli.' - '.$Cliente->RazSocCli;
                }
                else
                {
                    echo 'Error o el Cliente no se encuentra registrado';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="LOCALIDAD";
            //$Provincia=urldecode($this->uri->segment(6));
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            //var_dump($Tipo_Filtro);
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo la Localidad';
                return false;
            }
           else
            {
                $Localidad=$this->Reportes_model->get_tipo_filtro_busqueda('T_Localidad','DesLoc',$Tipo_Filtro);
                if($Localidad!=false)
                {
                    $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.CodLoc',$Localidad->CodLoc);
                }
                else
                {
                    echo 'Error o la Localidad no se encuentra registrada';
                    return false; 
                }
            }
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Provincia";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo la Provincia';
                return false;
            }
            else
            {               
                $Provincia=$this->Reportes_model->get_tipo_filtro_busqueda('T_Provincia','DesPro',$Tipo_Filtro);
                if($Provincia!=false)
                {
                   //var_dump($Tipo_Inmueble);
                   $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('d.CodPro',$Provincia->CodPro);
                }
                else
                {
                    echo 'Error o la Provincia no se encuentra registrada';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Tipo de Inmueble";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Inmueble';
                return false;
            }
            else
            {               
                $Tipo_Inmueble=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoInmueble','DesTipInm',$Tipo_Filtro);
                if($Tipo_Inmueble!=false)
                {
                 $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.CodTipInm',$Tipo_Inmueble->CodTipInm);
                }
                else
                {
                    echo 'Error o el Tipo de Inmueble no se encuentra registrado';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==5)
        {
            $nombre_filtro="Estatus";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Estatus';
                return false;
            }
            else
            {               
               if($Tipo_Filtro=="Activo")
               {
                  $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.EstPunSum',1);
               }
               elseif ($Tipo_Filtro=="Bloqueado") 
               {
                  $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.EstPunSum',2);
               }
               else
               {
                   echo 'Error o no introdujo el Tipo de Estatus';
                    return false;   
               }
            } 
        }
        else
        {
            echo 'Error o el Tipo de Filtro es incorrecto';
            return false;          
        }
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Direcciones de Suministro PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Clientes_Doc_PDF_Puntos_Suministros');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="2"><h4>LISTADO DE Direcciones de SuministroS</h4></td>
                <td border="0"><h4></h4></td>
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.': '.$Tipo_Filtro.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CLIENTES</td> 
            <td style="color:white;">DIRECCIÓN</td>
            <td style="color:white;">PROVINCIA</td>
            <td style="color:white;">LOCALIDAD</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Puntos_Suministros!=false)
        {
            foreach ($Resultado_Filtro_Puntos_Suministros as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCli.' - '.$record->RazSocCli.'</td>
                        <td>'.$record->DesTipVia.' '.$record->NomViaPunSum.' '.$record->NumViaPunSum.' '.$record->BloPunSum.' '.$record->EscPunSum.' '.$record->PlaPunSum.' '.$record->PuePunSum.'</td>
                        <td>'.$record->DesPro.'</td>
                        <td>'.$record->DesLoc.'</td>
                        <td>'.$record->EstPunSum.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="8"><b>Actualmente no hemos encontrados Direcciones de Suministros Registrados.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF Direcciones de SuministroS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Clientes_Doc_PDF_Puntos_Suministros'.'.pdf', 'I');
    }
    public function Clientes_Doc_Excel_Puntos_Suministros()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todas las Direcciones de Suministro";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {
                $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_Puntos_Suministros_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Cliente";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el código de Cliente';
                return false;
            }
            else
            {
               $Cliente=$this->Reportes_model->get_tipo_filtro_busqueda('T_Cliente','CodCli',$Tipo_Filtro);
                if($Cliente!=false)
                {
                    $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.CodCli',$Tipo_Filtro);
                    $Tipo_Filtro=$Cliente->NumCifCli.' - '.$Cliente->RazSocCli;
                }
                else
                {
                    echo 'Error o el Cliente no se encuentra registrado';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Localidad";
            //$Provincia=urldecode($this->uri->segment(6));
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            //var_dump($Tipo_Filtro);
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo la Localidad';
                return false;
            }
           else
            {
                $Localidad=$this->Reportes_model->get_tipo_filtro_busqueda('T_Localidad','DesLoc',$Tipo_Filtro);
                if($Localidad!=false)
                {
                    $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.CodLoc',$Localidad->CodLoc);
                }
                else
                {
                    echo 'Error o la Localidad no se encuentra registrada';
                    return false; 
                }
            }
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Provincia";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo la Provincia';
                return false;
            }
            else
            {               
                $Provincia=$this->Reportes_model->get_tipo_filtro_busqueda('T_Provincia','DesPro',$Tipo_Filtro);
                if($Provincia!=false)
                {
                   //var_dump($Tipo_Inmueble);
                   $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('d.CodPro',$Provincia->CodPro);
                }
                else
                {
                    echo 'Error o la Provincia no se encuentra registrada';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Tipo de Inmueble";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Inmueble';
                return false;
            }
            else
            {               
                $Tipo_Inmueble=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoInmueble','DesTipInm',$Tipo_Filtro);
                if($Tipo_Inmueble!=false)
                {
                 $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.CodTipInm',$Tipo_Inmueble->CodTipInm);
                }
                else
                {
                    echo 'Error o el Tipo de Inmueble no se encuentra registrado';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==5)
        {
            $nombre_filtro="Estatus";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Estatus';
                return false;
            }
            else
            {               
               if($Tipo_Filtro=="Activo")
               {
                  $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.EstPunSum',1);
               }
               elseif ($Tipo_Filtro=="Bloqueado") 
               {
                  $Resultado_Filtro_Puntos_Suministros=$this->Reportes_model->get_data_PumSum_all_filtro('a.EstPunSum',2);
               }
               else
               {
                   echo 'Error o no introdujo el Tipo de Estatus';
                    return false;   
               }
            } 
        }
        else
        {
            echo 'Error o el Tipo de Estatus es incorrecto';
            return false;          
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Clientes_Doc_Excel_Puntos_de_Suministros_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Clientes Doc Excel Direcciones de Suministros"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Clientes Doc Excel Dirección de Suministros"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE Direcciones de SuministroS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CLIENTES");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "DIRECCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "PROVINCIA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "LOCALIDAD");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Puntos_Suministros); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Puntos_Suministros[$i]->NumCifCli.' - '.$Resultado_Filtro_Puntos_Suministros[$i]->RazSocCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Puntos_Suministros[$i]->DesTipVia.' '.$Resultado_Filtro_Puntos_Suministros[$i]->NomViaPunSum.' '.$Resultado_Filtro_Puntos_Suministros[$i]->NumViaPunSum.' '.$Resultado_Filtro_Puntos_Suministros[$i]->BloPunSum.' '.$Resultado_Filtro_Puntos_Suministros[$i]->EscPunSum.' '.$Resultado_Filtro_Puntos_Suministros[$i]->PlaPunSum.' '.$Resultado_Filtro_Puntos_Suministros[$i]->PuePunSum);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Puntos_Suministros[$i]->DesPro);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Puntos_Suministros[$i]->DesLoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Puntos_Suministros[$i]->EstPunSum);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:E$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Filtro);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'G') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_PuntoSuministro','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL Direcciones de SuministroS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
     public function Clientes_Doc_PDF_Contactos()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos los Contactos";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {
             $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contactos_all(); 
            }
        }
       elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Contacto";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Contacto';
                return false;
            }
            else
            {                
                $Contacto=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoContacto','DesTipCon',$Tipo_Filtro);
                if($Contacto!=false)
                {
                    $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.CodTipCon',$Contacto->CodTipCon);
                }
                else
                {
                    echo 'Error o el Tipo de Contacto no se encuentra registrado';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Representante Legal";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Representante Legal';
                return false;
            }
            else
            {               
                if($Tipo_Filtro=="SI")
                {
                    $Tipo_Filtro=1;
                }  
                elseif($Tipo_Filtro=="NO")
                {
                    $Tipo_Filtro=0;
                }
                else
                {
                   echo 'Error o el Representante Legal es incorrecto';
                    return false; 
                }
                $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.EsRepLeg',$Tipo_Filtro);
                if($Tipo_Filtro==1)
                {
                    $Tipo_Filtro="SI";
                }  
                else
                {
                    $Tipo_Filtro="NO";
                }
            } 
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Tipo de Representación";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Representación';
                return false;
            }
            else
            {
                if($Tipo_Filtro=="Independiente")
                {
                    $Tipo_Filtro=1;
                }
                elseif($Tipo_Filtro=="Mancomunada")
                {
                    $Tipo_Filtro=2;
                }  
                else
                {
                     echo 'Error o el Tipo de Representación es incorrecto';
                    return false;
                }
                $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.TipRepr',$Tipo_Filtro);
                if($Tipo_Filtro==1)
                {
                    $Tipo_Filtro="Independiente";
                }  
                else
                {
                    $Tipo_Filtro="Mancomunada";
                }
            } 
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Estatus del Contacto";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Estatus del Contacto';
                return false;
            }
            else
            {
                if($Tipo_Filtro=="ACTIVO")
                {
                    $Tipo_Filtro=1;
                }  
                elseif($Tipo_Filtro=="BLOQUEADO")
                {
                    $Tipo_Filtro=2;
                }
                else
                {   
                    echo 'El Estatus del Contacto es incorrecto';
                    return false;

                }
                $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.EstConCli',$Tipo_Filtro);
                if($Tipo_Filtro==1)
                {
                    $Tipo_Filtro="ACTIVO";
                }  
                else
                {
                    $Tipo_Filtro="BLOQUEADO";
                }
            } 
        }
        else
        {
           echo 'El Tipo de Filtro es incorrecto';
            return false; 
        }        
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Contactos PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Clientes_Doc_PDF_Contactos');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE CONTACTOS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.': '.$Tipo_Filtro.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CLIENTES</td>
            <td style="color:white;">NOMBRE</td> 
            <td style="color:white;">NIF</td>
            <td style="color:white;">TELÉFONO FIJO</td>
            <td style="color:white;">TELÉFONO CELULAR</td>
            <td style="color:white;">EMAIL</td>
            <td style="color:white;">TIPO CONTACTO</td>
            <td style="color:white;">CARGO</td>
            <td style="color:white;">REPRESENTANTE LEGAL</td>
            <td style="color:white;">TIPO REPRESENTACIÓN</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Contactos!=false)
        {
            foreach ($Resultado_Filtro_Contactos as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCli.' - '.$record->RazSocCli.' </td>
                        <td>'.$record->NomConCli.'</td>
                        <td>'.$record->NIFConCli.'</td>
                        <td>'.$record->TelFijConCli.'</td>
                        <td>'.$record->TelCelConCli.'</td>
                        <td>'.$record->EmaConCli.'</td>
                        <td>'.$record->DesTipCon.'</td>
                        <td>'.$record->CarConCli.'</td>
                        <td>'.$record->EsRepLeg.'</td>
                        <td>'.$record->TipRepr.'</td>
                        <td>'.$record->EstConCli.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="11"><b>Actualmente no hemos encontrados Contactos Registrados.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF CONTACTOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Clientes_Doc_PDF_Contactos'.'.pdf', 'I');
    }
    public function Clientes_Doc_Excel_Contactos()
    {
       $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos los Contactos";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el tipo de filtro';
                return false;
            }
            else 
            {
             $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contactos_all(); 
            }
        }
       elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Contacto";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Contacto';
                return false;
            }
            else
            {                
                $Contacto=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoContacto','DesTipCon',$Tipo_Filtro);
                if($Contacto!=false)
                {
                    $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.CodTipCon',$Contacto->CodTipCon);
                }
                else
                {
                    echo 'Error o el Tipo de Contacto no se encuentra registrado';
                    return false; 
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Representante Legal";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Representante Legal';
                return false;
            }
            else
            {               
                if($Tipo_Filtro=="SI")
                {
                    $Tipo_Filtro=1;
                }  
                elseif($Tipo_Filtro=="NO")
                {
                    $Tipo_Filtro=0;
                }
                else
                {
                   echo 'Error o la Representación Legal es incorrecta';
                    return false; 
                }
                $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.EsRepLeg',$Tipo_Filtro);
                if($Tipo_Filtro==1)
                {
                    $Tipo_Filtro="SI";
                }  
                else
                {
                    $Tipo_Filtro="NO";
                }
            } 
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Tipo de Representación";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Representación';
                return false;
            }
            else
            {
                if($Tipo_Filtro=="Independiente")
                {
                    $Tipo_Filtro=1;
                }
                elseif($Tipo_Filtro=="Mancomunada")
                {
                    $Tipo_Filtro=2;
                }  
                else
                {
                     echo 'Error o el Tipo de Representación es incorrecto';
                    return false;
                }
                $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.TipRepr',$Tipo_Filtro);
                if($Tipo_Filtro==1)
                {
                    $Tipo_Filtro="Independiente";
                }  
                else
                {
                    $Tipo_Filtro="Mancomunada";
                }
            } 
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Estatus del Contacto";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Estatus del Contacto';
                return false;
            }
            else
            {
                if($Tipo_Filtro=="ACTIVO")
                {
                    $Tipo_Filtro=1;
                }  
                elseif($Tipo_Filtro=="BLOQUEADO")
                {
                    $Tipo_Filtro=2;
                }
                else
                {   
                    echo 'El Estatus del Contacto es incorrecto';
                    return false;

                }
                $Resultado_Filtro_Contactos=$this->Reportes_model->get_data_contacto_all_filtro('a.EstConCli',$Tipo_Filtro);
                if($Tipo_Filtro==1)
                {
                    $Tipo_Filtro="ACTIVO";
                }  
                else
                {
                    $Tipo_Filtro="BLOQUEADO";
                }
            } 
        }
        else
        {
           echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Clientes_Doc_Excel_Contactos_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Clientes Doc Excel Contactos"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Clientes Doc Excel"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE CONTACTOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CLIENTES");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "NOMBRE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "NIF");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "TELÉFONO FIJO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "TELÉFONO CELULAR");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "EMAIL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "TIPO CONTACTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $objPHPExcel->getActiveSheet()->SetCellValue("H9", "CARGO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
        $objPHPExcel->getActiveSheet()->SetCellValue("I9", "REPRESENTANTE LEGAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I9");
        $objPHPExcel->getActiveSheet()->SetCellValue("J9", "TIPO REPRESENTACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J9");
        $objPHPExcel->getActiveSheet()->SetCellValue("K9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Contactos); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Contactos[$i]->NumCifCli.' - '.$Resultado_Filtro_Contactos[$i]->RazSocCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Contactos[$i]->NomConCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Contactos[$i]->NIFConCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Contactos[$i]->TelFijConCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Contactos[$i]->TelCelConCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_Filtro_Contactos[$i]->EmaConCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado_Filtro_Contactos[$i]->DesTipCon);
            $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado_Filtro_Contactos[$i]->CarConCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $Resultado_Filtro_Contactos[$i]->EsRepLeg);
            $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $Resultado_Filtro_Contactos[$i]->TipRepr);
            $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", $Resultado_Filtro_Contactos[$i]->EstConCli);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:K$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Filtro);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'K') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ContactoCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL CONTACTOS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }

    public function Clientes_Doc_PDF_Bancos()
    {
        $tipo_filtro = $this->uri->segment(4);        
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos los Bancos";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            { 
                $Resultado_Filtro_Bancos=$this->Reportes_model->get_data_bank_all(); 
            }
        }
       elseif($tipo_filtro==1)
        {
            $nombre_filtro="BANCO";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Banco';
                return false;
            }
            else
            {
                $Banco=$this->Reportes_model->get_tipo_filtro_busqueda('T_Banco','CodBan',$Tipo_Filtro);
                if($Banco!=false)
                {
                    $Resultado_Filtro_Bancos=$this->Reportes_model->get_data_banco_all_filtro('a.CodBan',$Banco->CodBan);
                    $Tipo_Filtro=$Banco->DesBan;
                }
                else
                {
                    echo 'Error o el Banco no se encuentra registrado';
                    return false; 
                }
            } 
        }    
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Cliente";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Código de Cliente';
                return false;
            }
            else
            {
                $Cliente=$this->Reportes_model->get_tipo_filtro_busqueda('T_Cliente','CodCli',$Tipo_Filtro);
                if($Cliente!=false)
                {
                    $Resultado_Filtro_Bancos=$this->Reportes_model->get_data_banco_all_filtro('a.CodCli',$Cliente->CodCli);
                    $Tipo_Filtro=$Cliente->NumCifCli.' - '.$Cliente->RazSocCli;
                }
                else
                {
                    echo 'Error o el Banco no se encuentra registrado';
                    return false; 
                }
            } 
        }        
        else
        {
           echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        }        
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Bancos PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Clientes_Doc_PDF_Bancos');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE BANCOS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.': '.$Tipo_Filtro.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CLIENTES</td>
            <td style="color:white;">BANCO</td> 
            <td style="color:white;">IBAN</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Bancos!=false)
        {
            foreach ($Resultado_Filtro_Bancos as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCli.' - '.$record->RazSocCli.'</td>
                        <td>'.$record->DesBan.'</td>
                        <td>'.$record->NumIBan.'</td>
                        <td>'.$record->EstCue.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="8"><b>Actualmente no hemos encontrados Cuenta Bancarias Registradas.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF CUENTAS BANCARIAS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Clientes_Doc_PDF_Bancos'.'.pdf', 'I');
    }
    public function Clientes_Doc_Excel_Bancos()
    {
        $tipo_filtro = $this->uri->segment(4);        
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todos los Bancos";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            { 
                $Resultado_Filtro_Bancos=$this->Reportes_model->get_data_bank_all(); 
            }
        }
       elseif($tipo_filtro==1)
        {
            $nombre_filtro="BANCO";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el Banco';
                return false;
            }
            else
            {
                $Banco=$this->Reportes_model->get_tipo_filtro_busqueda('T_Banco','CodBan',$Tipo_Filtro);
                if($Banco!=false)
                {
                    $Resultado_Filtro_Bancos=$this->Reportes_model->get_data_banco_all_filtro('a.CodBan',$Banco->CodBan);
                    $Tipo_Filtro=$Banco->DesBan;
                }
                else
                {
                    echo 'Error o el Banco no se encuentra registrado';
                    return false; 
                }
            } 
        }    
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Cliente";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'Error o no introdujo el código de Cliente';
                return false;
            }
            else
            {
                $Cliente=$this->Reportes_model->get_tipo_filtro_busqueda('T_Cliente','CodCli',$Tipo_Filtro);
                if($Cliente!=false)
                {
                    $Resultado_Filtro_Bancos=$this->Reportes_model->get_data_banco_all_filtro('a.CodCli',$Cliente->CodCli);
                    $Tipo_Filtro=$Cliente->NumCifCli.' - '.$Cliente->RazSocCli;
                }
                else
                {
                    echo 'Error o el Banco no se encuentra registrado';
                    return false; 
                }
            } 
        }        
        else
        {
           echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Clientes_Doc_Excel_Bancos_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Clientes Doc Excel Bancos"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Clientes Doc Excel Bancos"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE BANCOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CLIENTE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "BANCO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "IBAN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Bancos); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Bancos[$i]->NumCifCli.' - '.$Resultado_Filtro_Bancos[$i]->RazSocCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Bancos[$i]->DesBan);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Bancos[$i]->NumIBan);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Bancos[$i]->EstCue);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:D$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Filtro);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'J') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_CuentaBancaria','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL CUENTAS BANCARIAS ');
        $objWriter->save('php://output');
        exit;   
    }

     public function Doc_PDF_Comercializadora()
    {
        $tipo_filtro = $this->uri->segment(4);        
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todas las Comercializadoras";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {              
                
                $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Servicio = urldecode($this->uri->segment(5));

            if($Tipo_Servicio==null)
            {
               echo 'Error o no introdujo el Tipo de Suministro';
                return false; 
            }
            $Tipo_Filtro = urldecode($this->uri->segment(6));
            if($Tipo_Filtro==null)
            {
               echo 'Error o no introdujo el Tipo de Filtro';
                return false; 
            }
            if($Tipo_Servicio==1)
            {
                if( $Tipo_Filtro=="SI")
                {
                  $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerGas',1);   
                }
                elseif ($Tipo_Filtro=="NO") 
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerGas',0);                 
                }   
                else
                {
                    echo "El Tipo de Filtro que introdujo es incorrecto";
                    return false;
                } 
                $Tipo_Filtro="GAS".": ".$Tipo_Filtro;
            }
            if($Tipo_Servicio==2)
            {
                if( $Tipo_Filtro=="SI")
                {
                  $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEle',1);   
                }
                elseif ($Tipo_Filtro=="NO") 
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEle',0);                 
                }   
                else
                {
                    echo "El Tipo de Filtro que introdujo es incorrecto";
                    return false;
                } 
                $Tipo_Filtro="ELÉCTRICO".": ".$Tipo_Filtro;
            }
            if($Tipo_Servicio==3)
            {
                if( $Tipo_Filtro=="SI")
                {
                  $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEsp',1);   
                }
                elseif ($Tipo_Filtro=="NO") 
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEsp',0);                 
                }   
                else 
                {
                    echo "El Tipo de Filtro que introdujo es incorrecto";
                    return false;
                } 
                $Tipo_Filtro="ESPECIAL".": ".$Tipo_Filtro;
            }
        } 
         elseif($tipo_filtro==2)
        {
            $nombre_filtro="Provincia";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            $Resultado_Provincia=$this->Reportes_model->get_tipo_filtro_busqueda('T_Provincia','Despro',$Tipo_Filtro);
            
            if($Resultado_Provincia!=false)
            {
                $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('c.CodPro',$Resultado_Provincia->CodPro); 
            }
            else
            {
               echo "Error o la Provincia no se encuentra registrada";
                return false;  
            } 
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Localidad";
            $Provincia = urldecode($this->uri->segment(5));
            $Tipo_Filtro = urldecode($this->uri->segment(6));
            if($Tipo_Filtro==null)
            {
               echo "Error o no introdujo la Localidad";
               return false;  
            }
            else
            {
               $Resultado_Localidad=$this->Reportes_model->get_tipo_filtro_busqueda('T_Localidad','DesLoc',$Tipo_Filtro);
               if($Resultado_Localidad!=false)
               {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.CodLoc',$Resultado_Localidad->CodLoc);
                    //$Resultado_Filtro_Comercializadoras=false; 
               }
               else
               {
                    echo "Error o la Localidad no se encuentra registrada";
                    return false;
               }               
            }            
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Estatus";
            $Tipo_Filtro = urldecode($this->uri->segment(5));            
            if($Tipo_Filtro==null)
            {
               echo "Error o no introdujo el Estatus de la Comercializadora";
               return false;  
            }
            else
            {
                if($Tipo_Filtro=="ACTIVA")
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.EstCom',1);
                }
                elseif ($Tipo_Filtro=="BLOQUEADA") 
                {
                   $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.EstCom',2);
                }
                else
                {
                    echo "Error o el Estatus es incorrecto";
                    return false; 
                }                            
            }            
        }

        else
        {
           echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        }
        
        $pdf = new TCPDF ('P','mm', 'A3', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Comercializadora PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Comercializadora');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE COMERCIALIZADORAS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.''.$Tipo_Filtro.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CIF</td> 
            <td style="color:white;">RAZÓN SOCIAL</td>
            <td style="color:white;">NOMBRE COMERCIAL</td>
            <td style="color:white;">DIRECCIÓN</td>
            <td style="color:white;">PROVINCIA</td>
            <td style="color:white;">LOCALIDAD</td>
            <td style="color:white;">TELÉFONO</td>
            <td style="color:white;">EMAIL</td>
            <td style="color:white;">PERSONA CONTACTO</td>        
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Comercializadoras!=false)
        {
            foreach ($Resultado_Filtro_Comercializadoras as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCom.'</td>
                        <td>'.$record->RazSocCom.'</td>
                        <td>'.$record->NomComCom.'</td>
                        <td>'.$record->DesTipVia.' '.$record->NomViaDirCom.' '.$record->NumViaDirCom.' '.$record->BloDirCom.' '.$record->EscDirCom.' '.$record->PlaDirCom.' '.$record->PueDirCom.'</td>
                        <td>'.$record->DesPro.'</td>
                        <td>'.$record->DesLoc.'</td>
                        <td>'.$record->TelFijCom.'</td>
                        <td>'.$record->EmaCom.'</td>
                        <td>'.$record->NomConCom.'</td>
                        <td>'.$record->EstCom.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="15"><b>Actualmente no hemos encontrados Comercializadoras Registradas.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF COMERCIALIZADORAS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Comercializadora'.'.pdf', 'I');
    }
    public function Doc_Excel_Comercializadora()
    {
       
        $tipo_filtro = $this->uri->segment(4);        
        if($tipo_filtro==0)
        {
           $nombre_filtro="Todas las Comercializadoras";
           $Tipo_Filtro="";
            if($tipo_filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
            }
            else 
            {              
                
                $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all(); 
            }
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Filtro";
            $Tipo_Servicio = urldecode($this->uri->segment(5));

            if($Tipo_Servicio==null)
            {
               echo 'Error o no introdujo el Tipo de Suministro';
                return false; 
            }
            $Tipo_Filtro = urldecode($this->uri->segment(6));
            if($Tipo_Filtro==null)
            {
               echo 'Error o no introdujo el Tipo de Filtro';
                return false; 
            }
            if($Tipo_Servicio==1)
            {
                if( $Tipo_Filtro=="SI")
                {
                  $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerGas',1);   
                }
                elseif ($Tipo_Filtro=="NO") 
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerGas',0);                 
                }   
                else
                {
                    echo "El Tipo de Filtro que introdujo es incorrecto";
                    return false;
                } 
                $Tipo_Filtro="GAS".": ".$Tipo_Filtro;
            }
            if($Tipo_Servicio==2)
            {
                if( $Tipo_Filtro=="SI")
                {
                  $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEle',1);   
                }
                elseif ($Tipo_Filtro=="NO") 
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEle',0);                 
                }   
                else
                {
                    echo "El Tipo de Filtro que introdujo es incorrecto";
                    return false;
                } 
                $Tipo_Filtro="ELÉCTRICO".": ".$Tipo_Filtro;
            }
            if($Tipo_Servicio==3)
            {
                if( $Tipo_Filtro=="SI")
                {
                  $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEsp',1);   
                }
                elseif ($Tipo_Filtro=="NO") 
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.SerEsp',0);                 
                }   
                else 
                {
                    echo "El Tipo de Filtro que introdujo es incorrecto";
                    return false;
                } 
                $Tipo_Filtro="ESPECIAL".": ".$Tipo_Filtro;
            }
        } 
         elseif($tipo_filtro==2)
        {
            $nombre_filtro="Provincia";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            $Resultado_Provincia=$this->Reportes_model->get_tipo_filtro_busqueda('T_Provincia','Despro',$Tipo_Filtro);
            
            if($Resultado_Provincia!=false)
            {
                $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('c.CodPro',$Resultado_Provincia->CodPro); 
            }
            else
            {
               echo "Error o la Provincia no se encuentra registrada";
                return false;  
            } 
        }
        elseif($tipo_filtro==3)
        {
            $nombre_filtro="Localidad";
            $Provincia = urldecode($this->uri->segment(5));
            $Tipo_Filtro = urldecode($this->uri->segment(6));
            if($Tipo_Filtro==null)
            {
               echo "Error o no introdujo la Localidad";
               return false;  
            }
            else
            {
               $Resultado_Localidad=$this->Reportes_model->get_tipo_filtro_busqueda('T_Localidad','DesLoc',$Tipo_Filtro);
               if($Resultado_Localidad!=false)
               {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.CodLoc',$Resultado_Localidad->CodLoc);
               }
               else
               {
                    echo "Error o la Localidad no se encuentra registrada";
                    return false;
               }               
            }            
        }
        elseif($tipo_filtro==4)
        {
            $nombre_filtro="Estatus";
            $Tipo_Filtro = urldecode($this->uri->segment(5));            
            if($Tipo_Filtro==null)
            {
               echo "Error o no introdujo el Estatus de la Comercializadora";
               return false;  
            }
            else
            {
                if($Tipo_Filtro=="ACTIVA")
                {
                    $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.EstCom',1);
                }
                elseif ($Tipo_Filtro=="BLOQUEADA") 
                {
                   $Resultado_Filtro_Comercializadoras=$this->Reportes_model->get_data_comercializadora_all_filtradas('a.EstCom',2);
                }
                else
                {
                    echo "Error o el Estatus que introdujo es incorrecto";
                    return false; 
                }                            
            }            
        }

        else
        {
           echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Comercializadoras_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Comercializadora"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Comercializadora"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE COMERCIALIZADORAS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CIF");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "RAZÓN SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "NOMBRE COMERCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "DIRECCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "PROVINCIA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "LOCALIDAD");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "TELÉFONO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $objPHPExcel->getActiveSheet()->SetCellValue("H9", "EMAIL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
        $objPHPExcel->getActiveSheet()->SetCellValue("I9", "PERSONA CONTACTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I9");
        $objPHPExcel->getActiveSheet()->SetCellValue("J9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Comercializadoras); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Comercializadoras[$i]->NumCifCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Comercializadoras[$i]->RazSocCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Comercializadoras[$i]->NomComCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Comercializadoras[$i]->DesTipVia.' '.$Resultado_Filtro_Comercializadoras[$i]->NomViaDirCom.' '.$Resultado_Filtro_Comercializadoras[$i]->NumViaDirCom.' '.$Resultado_Filtro_Comercializadoras[$i]->BloDirCom.' '.$Resultado_Filtro_Comercializadoras[$i]->EscDirCom.' '.$Resultado_Filtro_Comercializadoras[$i]->PlaDirCom.' '.$Resultado_Filtro_Comercializadoras[$i]->PueDirCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Comercializadoras[$i]->DesPro);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_Filtro_Comercializadoras[$i]->DesLoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado_Filtro_Comercializadoras[$i]->TelFijCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado_Filtro_Comercializadoras[$i]->EmaCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $Resultado_Filtro_Comercializadoras[$i]->NomConCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $Resultado_Filtro_Comercializadoras[$i]->EstCom);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:J$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Filtro);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'J') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercializadora','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL COMERCIALIZADORAS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Productos()
    {
        $tipo_filtro = $this->uri->segment(4);        
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
         }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Productos";
            $Tipo_Filtro="";
            $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all(); 
           
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CIF de la Comercializadora";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
               echo 'Error o no introdujo el CIF de la Comercializadora';
                return false; 
            }
            $Resultado_Filtro=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercializadora','NumCifCom',$Tipo_Filtro);
            if($Resultado_Filtro!=false)
            {
                $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.CodCom',$Resultado_Filtro->CodCom); 
            }
            else
            {
                echo 'Error o el CIF de la Comercializadora no se encuentra registrado';
                return false;
            }
        } 
        elseif ($tipo_filtro==2) 
        {
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Servicio = urldecode($this->uri->segment(5));
            $Tipo_Servicio_Filtro = urldecode($this->uri->segment(6));
            if($Tipo_Servicio==null)
            {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;    
            }
            if($Tipo_Servicio_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;    
            }
            if($Tipo_Servicio==1)
            {
                $Tipo_Filtro="GAS".": ".$Tipo_Servicio_Filtro;
                if($Tipo_Servicio_Filtro=="SI")
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerGas',1); 
                }
                elseif($Tipo_Servicio_Filtro=="NO")
                {
                     $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerGas',0);
                }
                else
                {
                    echo "El Tipo de Filtro debe ser SI o NO";
                    return false;
                }
            }
            elseif ($Tipo_Servicio==2) 
            {
               $Tipo_Filtro="ELÉCTRICO".": ".$Tipo_Servicio_Filtro;
               if($Tipo_Servicio_Filtro=="SI")
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerEle',1); 
                }
                elseif($Tipo_Servicio_Filtro=="NO")
                {
                     $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerEle',0);
                }
                else
                {
                    echo "El Tipo de Filtro debe ser SI o NO";
                    return false;
                }
            }
            else
            {
                echo 'Error o el Tipo de Suministro es incorrecto';
                return false;  
            }            
        }
        elseif($tipo_filtro==3) 
        {
            $nombre_filtro="Fecha de Inicio";
            $dia = urldecode($this->uri->segment(5));
            $mes = urldecode($this->uri->segment(6));
            $ano = urldecode($this->uri->segment(7));
            if($dia==null)
            {
               echo 'Error o no introdujo el Día';
                return false; 
            }
            if($mes==null)
            {
               echo 'Error o no introdujo el Mes';
                return false; 
            }
            if($ano==null)
            {
               echo 'Error o no introdujo el Año';
                return false; 
            }
            $fecha_busqueda=$ano."-".$mes."-".$dia;
            $Tipo_Filtro=$dia."/".$mes."/".$ano;
            $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.FecIniPro',$fecha_busqueda);                      
        }
        elseif($tipo_filtro==4) 
        {
            $nombre_filtro="Estatus";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'No introdujo el Tipo de Filtro';
            return false;
            } 
                if($Tipo_Filtro=="ACTIVO")
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.EstPro',1);
                }
                elseif ($Tipo_Filtro=="BLOQUEADO") 
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.EstPro',2);
                }
                else
                {
                    echo "Tipo de Filtro incorrecto";
                    return false;
                }                     
        }        
        else
        {
            echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        }        
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Productos PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Productos');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE PRODUCTOS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.''.$Tipo_Filtro.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">COMERCIALIZADORA</td> 
            <td style="color:white;">PRODUCTO</td>
            <td style="color:white;">SER. GAS</td>
            <td style="color:white;">SER. ELÉCTRICO</td>
            <td style="color:white;">FECHA</td>        
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Productos!=false)
        {
            foreach ($Resultado_Filtro_Productos as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCom.'-'.$record->RazSocCom.'</td>
                        <td>'.$record->DesPro.'</td>
                        <td>'.$record->SerGas.'</td>
                        <td>'.$record->SerEle.'</td>
                        <td>'.$record->FecIniPro.'</td>
                        <td>'.$record->EstPro.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="15"><b>Actualmente no hemos encontrados Productos Registrados.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Producto','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF PRODUCTOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Productos'.'.pdf', 'I');
    }
     public function Doc_Excel_Productos()
    {
        $tipo_filtro = $this->uri->segment(4);        
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
         }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Productos";
            $Tipo_Filtro="";
            $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all(); 
           
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CIF de la Comercializadora";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
               echo 'Error o no introdujo el CIF de la Comercializadora';
                return false; 
            }
            $Resultado_Filtro=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercializadora','NumCifCom',$Tipo_Filtro);
            if($Resultado_Filtro!=false)
            {
                $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.CodCom',$Resultado_Filtro->CodCom); 
            }
            else
            {
                echo 'Error o el CIF de la Comercializadora no se encuentra registrado';
                return false;
            }
        } 
        elseif ($tipo_filtro==2) 
        {
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Servicio = urldecode($this->uri->segment(5));
            $Tipo_Servicio_Filtro = urldecode($this->uri->segment(6));
            if($Tipo_Servicio==null)
            {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;    
            }
            if($Tipo_Servicio_Filtro==null)
            {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;    
            }
            if($Tipo_Servicio==1)
            {
                $Tipo_Filtro="GAS".": ".$Tipo_Servicio_Filtro;
                if($Tipo_Servicio_Filtro=="SI")
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerGas',1); 
                }
                elseif($Tipo_Servicio_Filtro=="NO")
                {
                     $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerGas',0);
                }
                else
                {
                    echo "El Tipo de Filtro debe ser SI o NO";
                    return false;
                }
            }
            elseif ($Tipo_Servicio==2) 
            {
               $Tipo_Filtro="ELÉCTRICO".": ".$Tipo_Servicio_Filtro;
               if($Tipo_Servicio_Filtro=="SI")
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerEle',1); 
                }
                elseif($Tipo_Servicio_Filtro=="NO")
                {
                     $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.SerEle',0);
                }
                else
                {
                    echo "El Tipo de Filtro debe ser SI o NO";
                    return false;
                }
            }
            else
            {
                echo 'Error o el Tipo de Suministro es incorrecto';
                return false;  
            }            
        }
        elseif($tipo_filtro==3) 
        {
            $nombre_filtro="Fecha de Inicio";
            $dia = urldecode($this->uri->segment(5));
            $mes = urldecode($this->uri->segment(6));
            $ano = urldecode($this->uri->segment(7));
            if($dia==null)
            {
               echo 'Error o no introdujo el Día';
                return false; 
            }
            if($mes==null)
            {
               echo 'Error o no introdujo el Mes';
                return false; 
            }
            if($ano==null)
            {
               echo 'Error o no introdujo el Año';
                return false; 
            }
            $fecha_busqueda=$ano."-".$mes."-".$dia;
            $Tipo_Filtro=$dia."/".$mes."/".$ano;
            $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.FecIniPro',$fecha_busqueda);                      
        }
        elseif($tipo_filtro==4) 
        {
            $nombre_filtro="Estatus";
            $Tipo_Filtro = urldecode($this->uri->segment(5));
            if($Tipo_Filtro==null)
            {
                echo 'No ha introdujo el Tipo de Filtro';
            return false;
            } 
                if($Tipo_Filtro=="ACTIVO")
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.EstPro',1);
                }
                elseif ($Tipo_Filtro=="BLOQUEADO") 
                {
                    $Resultado_Filtro_Productos=$this->Reportes_model->get_data_productos_all_filtrados('a.EstPro',2);
                }
                else
                {
                    echo "Tipo de Filtro incorrecto";
                    return false;
                }                     
        }        
        else
        {
            echo 'El Tipo de Filtro que introdujo es incorrecto';
            return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Productos_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Productos"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Productos"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE PRODUCTOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "COMERCIALIZADORA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "PRODUCTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "Suministro Gas");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "Suministro Eléctrico");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "FECHA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");       
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Productos); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Productos[$i]->NumCifCom."-".$Resultado_Filtro_Productos[$i]->RazSocCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Productos[$i]->DesPro);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Productos[$i]->SerGas);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Productos[$i]->SerEle);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Productos[$i]->FecIniPro);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_Filtro_Productos[$i]->EstPro);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:F$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Filtro);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Productos','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL PRODUCTOS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Anexos()
    {
        $tipo_filtro = $this->uri->segment(4);
        //var_dump($tipo_filtro);
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
        }
        if($tipo_filtro==0)
        { 
           $nombre_filtro="Todos los Anexos";
           $Tipo_Cliente="";
           $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos();
            
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CIF de Comercializadora:";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el CIF de la Comercializadora';
                return false;
            }
            else
            {
               $Comercializadora=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercializadora','NumCifCom',$Tipo_Cliente); 
                if($Comercializadora!=false)
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('c.CodCom',$Comercializadora->CodCom);
                }
                else
                {
                    echo 'Error o el CIF de la Comercializadora no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Producto";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Producto';
                return false;
            }
            else
            {
               $Producto=$this->Reportes_model->get_tipo_filtro_busqueda('T_Producto','DesPro',$Tipo_Cliente); 
                if($Producto!=false)
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.CodPro',$Producto->CodPro);
                }
                else
                {
                    echo 'Error o el Producto no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif ($tipo_filtro==3) 
        {  
           $Tipo_Servicio = urldecode($this->uri->segment(5));
           $Tipo_Filtro = urldecode($this->uri->segment(6));           
           $nombre_filtro="Tipo de Suministro ";
           if($Tipo_Servicio==null)
           {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;
           }
            if($Tipo_Filtro==null)
           {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
           }
           if($Tipo_Servicio=="GAS")
           {
                if($Tipo_Filtro=="SI")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerGas',1);
                }
                elseif($Tipo_Filtro=="NO")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerGas',0);
                }
                else
                {
                   echo 'Error o el Tipo de Filtro es incorrecto';
                    return false;
                }
           }
           elseif($Tipo_Servicio=="ELÉCTRICO")
           {
                if($Tipo_Filtro=="SI")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerEle',1);
                }
                elseif($Tipo_Filtro=="NO")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerEle',0);
                }
                else
                {
                   echo 'Error o el Tipo de Filtro es incorrecto';
                    return false;
                }
           }
           else
           {
                echo 'Error o el Tipo de Suministro es incorrecto';
                return false;
           }

           $Tipo_Cliente= $Tipo_Servicio.": ".$Tipo_Filtro;          
        }
        elseif ($tipo_filtro==4) 
        {
            $nombre_filtro="Tipo de Comisión";
            $Tipo_Cliente=urldecode($this->uri->segment(5)); 
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Comisión';
                return false;
            }
            $Tipo_Comision=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoComision','DesTipCom',$Tipo_Cliente);   
            if($Tipo_Comision!=false)
            {
               //$Resultado_Filtro_Anexos=false; 
               $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.CodTipCom',$Tipo_Comision->CodTipCom);
            }
            else
            {
                 echo 'Error o el Tipo de Comisión no se encuentra registrada';
                return false;
            }            
        }
        elseif ($tipo_filtro==5) 
        {
            $nombre_filtro="Fecha de Inicio";
            $dia=$this->uri->segment(5);
            $mes=$this->uri->segment(6);
            $ano=$this->uri->segment(7);
            if($dia==null)
            {
                echo 'Error o no introdujo el Día';
                return false;
            }
            if($mes==null)
            {
                echo 'Error o no introdujo el Mes';
                return false;
            }
            if($ano==null)
            {
                echo 'Error o no introdujo el Año';
                return false;
            }
            $Tipo_Cliente=$dia."/".$mes."/".$ano;
            $fecha_busqueda=$ano."-".$mes."-".$dia;
            $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.FecIniAne',$fecha_busqueda);
        }
        elseif ($tipo_filtro==6) 
        {
            $nombre_filtro="Estatus Anexo";
            $Tipo_Cliente=urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Estatus del Anexo';
                return false;  
            }
            if($Tipo_Cliente=="ACTIVO")
            {
               $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.EstAne',1);
            }
            elseif($Tipo_Cliente=="BLOQUEADO")
            {
                 $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.EstAne',2);
            }
            else
            {
                echo 'Error o el Estatus del Anexo es incorrecto';
                return false;
            }
           
            //$this->Reportes_model->get_data_all_anexos_filtradas('a.FecIniAne',$fecha_busqueda);
        }
        else
        {
            echo 'Error o Tipo de Filtro incorrecto';
            return false;
        }
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Anexos PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Anexos');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left"><h4>LISTADO DE ANEXOS</h4></td>
                <td border="0"><h4></h4></td>
                <td border="0"><h4></h4></td>
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">COMERCIALIZADORA</td> 
            <td style="color:white;">PRODUCTO</td>
            <td style="color:white;">ANEXO</td>
            <td style="color:white;">SER. GAS</td>
            <td style="color:white;">SER. ELÉCTRICO</td>
            <td style="color:white;">TIPO PRECIO</td>
            <td style="color:white;">TIPO COMISIÓN</td>
            <td style="color:white;">FECHA</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Anexos!=false)
        {
            foreach ($Resultado_Filtro_Anexos as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCom.' - '.$record->RazSocCom.'</td>
                        <td>'.$record->DesPro.'</td>
                        <td>'.$record->DesAnePro.'</td>
                        <td>'.$record->SerGas.'</td>
                        <td>'.$record->SerEle.'</td>
                        <td>'.$record->TipPre.'</td>
                        <td>'.$record->DesTipCom.'</td>
                        <td>'.$record->FecIniAne.'</td>
                        <td>'.$record->EstAne.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>Actualmente no hemos encontrados Anexos Registrados.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF ANEXOS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Anexos'.'.pdf', 'I');
    }
     public function Doc_Excel_Anexos()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
        }
        if($tipo_filtro==0)
        { 
           $nombre_filtro="Todos los Anexos";
           $Tipo_Cliente="";
           $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos();
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CIF de Comercializadora:";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el CIF de la Comercializadora';
                return false;
            }
            else
            {
               $Comercializadora=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercializadora','NumCifCom',$Tipo_Cliente); 
                if($Comercializadora!=false)
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('c.CodCom',$Comercializadora->CodCom);
                }
                else
                {
                    echo 'Error o el CIF de la Comercializadora no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="PRODUCTO:";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Producto';
                return false;
            }
            else
            {
               $Producto=$this->Reportes_model->get_tipo_filtro_busqueda('T_Producto','DesPro',$Tipo_Cliente); 
                if($Producto!=false)
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.CodPro',$Producto->CodPro);
                }
                else
                {
                    echo 'Error o el Producto no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif ($tipo_filtro==3) 
        {  
           $Tipo_Servicio = urldecode($this->uri->segment(5));
           $Tipo_Filtro = urldecode($this->uri->segment(6));           
           $nombre_filtro="Tipo de Suministro ";
           if($Tipo_Servicio==null)
           {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;
           }
            if($Tipo_Filtro==null)
           {
                echo 'Error o no introdujo el Tipo de Filtro';
                return false;
           }
           if($Tipo_Servicio=="GAS")
           {
                if($Tipo_Filtro=="SI")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerGas',1);
                }
                elseif($Tipo_Filtro=="NO")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerGas',0);
                }
                else
                {
                   echo 'Error o el Tipo de Filtro es incorrecto';
                    return false;
                }
           }
           elseif($Tipo_Servicio=="ELÉCTRICO")
           {
                if($Tipo_Filtro=="SI")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerEle',1);
                }
                elseif($Tipo_Filtro=="NO")
                {
                    $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.SerEle',0);
                }
                else
                {
                   echo 'Error o el Tipo de Filtro es incorrecto';
                    return false;
                }
           }
           else
           {
                echo 'Error o el Tipo de Suministro es incorrecto';
                return false;
           }

           $Tipo_Cliente= $Tipo_Servicio.": ".$Tipo_Filtro;          
        }
        elseif ($tipo_filtro==4) 
        {
            $nombre_filtro="TIPO DE COMISIÓN: ";
            $Tipo_Cliente=urldecode($this->uri->segment(5)); 
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Comisión';
                return false;
            }
            $Tipo_Comision=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoComision','DesTipCom',$Tipo_Cliente);   
            if($Tipo_Comision!=false)
            {
               //$Resultado_Filtro_Anexos=false; 
               $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.CodTipCom',$Tipo_Comision->CodTipCom);
            }
            else
            {
                 echo 'Error o el Tipo de Comisión no se encuentra registrada';
                return false;
            }            
        }
        elseif ($tipo_filtro==5) 
        {
            $nombre_filtro="Fecha de Inicio";
            $dia=$this->uri->segment(5);
            $mes=$this->uri->segment(6);
            $ano=$this->uri->segment(7);
            if($dia==null)
            {
                echo 'Error o no introdujo el Día';
                return false;
            }
            if($mes==null)
            {
                echo 'Error o no introdujo el Mes';
                return false;
            }
            if($ano==null)
            {
                echo 'Error o no introdujo el Año';
                return false;
            }
            $Tipo_Cliente=$dia."/".$mes."/".$ano;
            $fecha_busqueda=$ano."-".$mes."-".$dia;
            $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.FecIniAne',$fecha_busqueda);
        }
        elseif ($tipo_filtro==6) 
        {
            $nombre_filtro="Estatus Anexo";
            $Tipo_Cliente=urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Estatus del Anexo';
                return false;  
            }
            if($Tipo_Cliente=="ACTIVO")
            {
               $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.EstAne',1);
            }
            elseif($Tipo_Cliente=="BLOQUEADO")
            {
                 $Resultado_Filtro_Anexos=$this->Reportes_model->get_data_all_anexos_filtradas('a.EstAne',2);
            }
            else
            {
                echo 'Error o el Estatus del Anexo es incorrecto';
                return false;
            }
           
            //$this->Reportes_model->get_data_all_anexos_filtradas('a.FecIniAne',$fecha_busqueda);
        }
        else
        {
            echo 'Error o Tipo de Filtro incorrecto';
            return false;
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Anexos_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Anexos"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Anexos"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE ANEXOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "COMERCIALIZADORA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "PRODUCTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "ANEXO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "Suministro Gas");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "Suministro Eléctrico");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "TIPO PRECIO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "TIPO COMISIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $objPHPExcel->getActiveSheet()->SetCellValue("H9", "FECHA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
        $objPHPExcel->getActiveSheet()->SetCellValue("I9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I9");       
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Anexos); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Anexos[$i]->NumCifCom." - ".$Resultado_Filtro_Anexos[$i]->RazSocCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Anexos[$i]->DesPro);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Anexos[$i]->DesAnePro);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Anexos[$i]->SerGas);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Anexos[$i]->SerEle);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_Filtro_Anexos[$i]->TipPre);
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado_Filtro_Anexos[$i]->DesTipCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado_Filtro_Anexos[$i]->FecIniAne);
            $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $Resultado_Filtro_Anexos[$i]->EstAne);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:I$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'I') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_AnexoProducto','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL ANEXOS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Servicios_Especiales()
    {
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
        }
        if($tipo_filtro==0)
        { 
           $nombre_filtro="Todos los Servicios Especiales.";
           $Tipo_Cliente="";
           $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicios_especiales();
            
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CIF de Comercializadora:";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el CIF de la Comercializadora';
                return false;
            }
            else
            {
               $Comercializadora=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercializadora','NumCifCom',$Tipo_Cliente); 
                if($Comercializadora!=false)
                {
                    $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.CodCom',$Comercializadora->CodCom);
                }
                else
                {
                    echo 'Error o el CIF de la Comercializadora no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif ($tipo_filtro==2) 
        {  
           $Tipo_Servicio = urldecode($this->uri->segment(5));          
           $nombre_filtro="Tipo de Suministro";
           if($Tipo_Servicio==null)
           {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;
           }
           if($Tipo_Servicio=="GAS")
           {
                 $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipSumSerEsp',0);
               
           }
           elseif($Tipo_Servicio=="ELÉCTRICO")
           {
                $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipSumSerEsp',1);               
           }
           elseif($Tipo_Servicio=="AMBOS")
           {
                $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipSumSerEsp',2);               
           }
           else
           {
                echo 'Error o Tipo de Filtro incorrecto';
                return false;
           }     
           $Tipo_Cliente= $Tipo_Servicio;    
        }
         elseif ($tipo_filtro==3) 
        {  
           $Tipo_Cliente = urldecode($this->uri->segment(5));           
           $nombre_filtro="Tipo de Cliente";
           if($Tipo_Cliente==null)
           {
                echo 'Error o no introdujo el Tipo de Cliente';
                return false;
           }
           if($Tipo_Cliente=="NEGOCIO")
           {
                 $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipCli',1);
               
           }
           elseif($Tipo_Cliente=="PARTICULAR")
           {
                $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipCli',0);               
           }
           else
           {
                echo 'Error o Tipo de Cliente incorrecto';
                return false;
           } 
        }
        elseif ($tipo_filtro==4) 
        {
            $nombre_filtro="Tipo de Comisión";
            $Tipo_Cliente=urldecode($this->uri->segment(5)); 
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Comisión';
                return false;
            }
            $Tipo_Comision=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoComision','DesTipCom',$Tipo_Cliente);   
            if($Tipo_Comision!=false)
            {
               $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.CodTipCom',$Tipo_Comision->CodTipCom);
            }
            else
            {
                 echo 'Error o el Tipo de Comisión no se encuentra registrada';
                return false;
            }            
        }
        elseif ($tipo_filtro==5) 
        {
            $nombre_filtro="Fecha de Inicio";
            $dia=$this->uri->segment(5);
            $mes=$this->uri->segment(6);
            $ano=$this->uri->segment(7);
            if($dia==null)
            {
                echo 'Error o no introdujo el Día';
                return false;
            }
            if($mes==null)
            {
                echo 'Error o no introdujo el Mes';
                return false;
            }
            if($ano==null)
            {
                echo 'Error o no introdujo el Año';
                return false;
            }
            $Tipo_Cliente=$dia."/".$mes."/".$ano;
            $fecha_busqueda=$ano."-".$mes."-".$dia;
            $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.FecIniSerEsp',$fecha_busqueda);
        }
       elseif ($tipo_filtro==6) 
        {
            $nombre_filtro="Estatus Anexo";
            $Tipo_Cliente=urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Estatus del Anexo';
                return false;  
            }
            if($Tipo_Cliente=="ACTIVO")
            {
               $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.EstSerEsp',1);
            }
            elseif($Tipo_Cliente=="BLOQUEADO")
            {
                 $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.EstSerEsp',2);
            }
            else
            {
                echo 'Error o el Estatus del Anexo es incorrecto';
                return false;
            }
        }
        else
        {
            echo 'Error o Tipo de Filtro incorrecto';
            return false;
        }
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Listado de Servicios Especiales PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Servicios_Especiales');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped">            
            <tr>
                <td border="0" colspan="3" align="left"><h4>LISTADO DE SERVICIOS ESPECIALES</h4></td>                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">COMERCIALIZADORA</td> 
            <td style="color:white;">SERVICIO ESPECIAL</td>
            <td style="color:white;">CARACTERISTICA DEL SERVICIO</td>
            <td style="color:white;">TIPO CLIENTE</td>
            <td style="color:white;">TIPO SUMINISTRO</td>
            <td style="color:white;">TIPO COMISIÓN</td>
            <td style="color:white;">FECHA</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado_Filtro_Servicios_Especiales!=false)
        {
            foreach ($Resultado_Filtro_Servicios_Especiales as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCom.' - '.$record->RazSocCom.'</td>
                        <td>'.$record->DesSerEsp.'</td>
                        <td>'.$record->CarSerEsp.'</td>
                        <td>'.$record->TipCli.'</td>
                        <td>'.$record->TipSumSerEsp.'</td>
                        <td>'.$record->DesTipCom.'</td>
                        <td>'.$record->FecIniSerEsp.'</td>
                        <td>'.$record->EstSerEsp.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>Actualmente no hemos encontrados Anexos Registrados.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF SERVICIOS ESPECIALES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Servicios_Especiales'.'.pdf', 'I');
    }
    public function Doc_Excel_Servicios_Especiales()
    {       
        $tipo_filtro = $this->uri->segment(4);
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
        }
        if($tipo_filtro==0)
        { 
           $nombre_filtro="Todos los Servicios Especiales";
           $Tipo_Cliente="";
           $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicios_especiales();
            
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="CIF de Comercializadora:";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el CIF de la Comercializadora';
                return false;
            }
            else
            {
               $Comercializadora=$this->Reportes_model->get_tipo_filtro_busqueda('T_Comercializadora','NumCifCom',$Tipo_Cliente); 
                if($Comercializadora!=false)
                {
                    $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.CodCom',$Comercializadora->CodCom);
                }
                else
                {
                    echo 'Error o el CIF de la Comercializadora no se encuentra registrado';
                    return false;
                }
            } 
        }
        elseif ($tipo_filtro==2) 
        {  
           $Tipo_Servicio = urldecode($this->uri->segment(5));          
           $nombre_filtro="Tipo de Suministro";
           if($Tipo_Servicio==null)
           {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;
           }
           if($Tipo_Servicio=="GAS")
           {
                 $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipSumSerEsp',0);
               
           }
           elseif($Tipo_Servicio=="ELÉCTRICO")
           {
                $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipSumSerEsp',1);               
           }
           elseif($Tipo_Servicio=="AMBOS")
           {
                $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipSumSerEsp',2);               
           }
           else
           {
                echo 'Error o Tipo de Filtro incorrecto';
                return false;
           }

           //$Tipo_Cliente= $Tipo_Servicio.": ".$Tipo_Filtro;      
           $Tipo_Cliente= $Tipo_Servicio;    
        }
         elseif ($tipo_filtro==3) 
        {  
           $Tipo_Cliente = urldecode($this->uri->segment(5));           
           $nombre_filtro="Tipo de Cliente";
           if($Tipo_Cliente==null)
           {
                echo 'Error o no introdujo el Tipo de Cliente';
                return false;
           }
           if($Tipo_Cliente=="NEGOCIO")
           {
                 $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipCli',1);
               
           }
           elseif($Tipo_Cliente=="PARTICULAR")
           {
                $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.TipCli',0);               
           }
           else
           {
                echo 'Error o Tipo de Cliente incorrecto';
                return false;
           } 
        }
        elseif ($tipo_filtro==4) 
        {
            $nombre_filtro="Tipo de Comisión";
            $Tipo_Cliente=urldecode($this->uri->segment(5)); 
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Comisión';
                return false;
            }
            $Tipo_Comision=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoComision','DesTipCom',$Tipo_Cliente);   
            if($Tipo_Comision!=false)
            {
               $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.CodTipCom',$Tipo_Comision->CodTipCom);
            }
            else
            {
                 echo 'Error o el Tipo de Comisión no se encuentra registrada';
                return false;
            }            
        }
        elseif ($tipo_filtro==5) 
        {
            $nombre_filtro="Fecha de Inicio";
            $dia=$this->uri->segment(5);
            $mes=$this->uri->segment(6);
            $ano=$this->uri->segment(7);
            if($dia==null)
            {
                echo 'Error o no introdujo el Día';
                return false;
            }
            if($mes==null)
            {
                echo 'Error o no introdujo el Mes';
                return false;
            }
            if($ano==null)
            {
                echo 'Error o no introdujo el Año';
                return false;
            }
            $Tipo_Cliente=$dia."/".$mes."/".$ano;
            $fecha_busqueda=$ano."-".$mes."-".$dia;
            $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.FecIniSerEsp',$fecha_busqueda);
        }
       elseif ($tipo_filtro==6) 
        {
            $nombre_filtro="Estatus Anexo";
            $Tipo_Cliente=urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Estatus del Anexo';
                return false;  
            }
            if($Tipo_Cliente=="ACTIVO")
            {
               $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.EstSerEsp',1);
            }
            elseif($Tipo_Cliente=="BLOQUEADO")
            {
                 $Resultado_Filtro_Servicios_Especiales=$this->Reportes_model->get_data_all_servicio_especiales_filtradas('a.EstSerEsp',2);
            }
            else
            {
                echo 'Error o Estatus del Anexo es incorrecto';
                return false;
            }
        }
        else
        {
            echo 'Error o Tipo de Filtro incorrecto';
            return false;
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Servicios_Especiales_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Servicios Especiales"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Servicios Especiales"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE DE SERVICIOS ESPECIALES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "COMERCIALIZADORA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "SERVICIO ESPECIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "CARACTERISTICA DEL SERVICIO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "TIPO CLIENTE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "TIPO SUMINISTRO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "TIPO COMISIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "FECHA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $objPHPExcel->getActiveSheet()->SetCellValue("H9", "ESTATUS"); 
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");    
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado_Filtro_Servicios_Especiales); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado_Filtro_Servicios_Especiales[$i]->NumCifCom." - ".$Resultado_Filtro_Servicios_Especiales[$i]->RazSocCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado_Filtro_Servicios_Especiales[$i]->DesSerEsp);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado_Filtro_Servicios_Especiales[$i]->CarSerEsp);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado_Filtro_Servicios_Especiales[$i]->TipCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado_Filtro_Servicios_Especiales[$i]->TipSumSerEsp);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado_Filtro_Servicios_Especiales[$i]->DesTipCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado_Filtro_Servicios_Especiales[$i]->FecIniSerEsp);
            $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado_Filtro_Servicios_Especiales[$i]->EstSerEsp);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:H$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'H') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_ServicioEspecial','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL SERVICIOS ESPECIALES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Distribuidora()
    {
        $tipo_filtro = $this->uri->segment(4);
        //var_dump($tipo_filtro);
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
        }
        if($tipo_filtro==0)
        { 
           $nombre_filtro="Todos las Distribuidoras";
           $Tipo_Cliente="";
           $Resultado=$this->Reportes_model->get_data_all_distribuidoras();
            
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;
            }
            else
            {
               if($Tipo_Cliente=="ELÉCTRICO")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('TipSerDis',0);
               }
               elseif($Tipo_Cliente=="GAS")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('TipSerDis',1);
               }
               elseif($Tipo_Cliente=="AMBOS SERVICIOS")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('TipSerDis',2);
               }
               else
               {
                    echo 'Error o Tipo de Suministro incorrecto';
                    return false;
               }
               
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="Estatus";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Estatus';
                return false;
            }
            else
            {
               if($Tipo_Cliente=="ACTIVO")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('EstDist',1);
               }
               elseif($Tipo_Cliente=="BLOQUEADO")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('EstDist',2);
               }
               else
               {
                    echo 'Error o el Estatus es incorrecto';
                    return false;
               }
            } 
        }        
        else
        {
            echo 'Error en Tipo de Filtro';
            return false;
        }
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Distribuidoras PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Distribuidoras');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE DISTRIBUIDORAS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CIF</td> 
            <td style="color:white;">RAZÓN SOCIAL</td>
            <td style="color:white;">TELÉFONO</td>
            <td style="color:white;">TIPO SUMINISTRO</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifDis.'</td>
                        <td>'.$record->RazSocDis.'</td>
                        <td>'.$record->TelFijDis.'</td>
                        <td>'.$record->TipSerDis.'</td>
                        <td>'.$record->EstDist.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>Actualmente no hemos encontrados Distribuidoras Registradas.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF DISTRIBUIDORAS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Distribuidora'.'.pdf', 'I');
    }
    public function Doc_Excel_Distribuidora()
    {       
       $tipo_filtro = $this->uri->segment(4);
        //var_dump($tipo_filtro);
        if($tipo_filtro==null)
        {
            echo 'Error o no introdujo el Tipo de Filtro';
            return false;
        }
        if($tipo_filtro==0)
        { 
           $nombre_filtro="Todos las Distribuidoras";
           $Tipo_Cliente="";
           $Resultado=$this->Reportes_model->get_data_all_distribuidoras();
            
        }
        elseif($tipo_filtro==1)
        {
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Tipo de Suministro';
                return false;
            }
            else
            {
               if($Tipo_Cliente=="ELÉCTRICO")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('TipSerDis',0);
               }
               elseif($Tipo_Cliente=="GAS")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('TipSerDis',1);
               }
               elseif($Tipo_Cliente=="AMBOS SERVICIOS")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('TipSerDis',2);
               }
               else
               {
                    echo 'Error o Tipo de Suministro incorrecto';
                    return false;
               }
               
            } 
        }
        elseif($tipo_filtro==2)
        {
            $nombre_filtro="ESTATUS";
            $Tipo_Cliente = urldecode($this->uri->segment(5));
            if($Tipo_Cliente==null)
            {
                echo 'Error o no introdujo el Estatus';
                return false;
            }
            else
            {
               if($Tipo_Cliente=="ACTIVO")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('EstDist',1);
               }
               elseif($Tipo_Cliente=="BLOQUEADO")
               {
                    $Resultado=$this->Reportes_model->get_data_all_distribuidoras_filtradas('EstDist',2);
               }
               else
               {
                    echo 'Error o el Estatus es incorrecto';
                    return false;
               }
            } 
        }        
        else
        {
            echo 'Error o el Tipo de Filtro es incorrecto';
            return false;
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Distribuidoras_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Distribuidoras"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Distribuidoras"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE DISTRIBUIDORAS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CIF");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "RAZÓN SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "TELÉFONO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "TIPO SUMINISTRO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->NumCifDis);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->RazSocDis);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->TelFijDis);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->TipSerDis);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->EstDist);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:E$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'E') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL DISTRIBUIDORAS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }

     public function Doc_PDF_Tarifa_Electrica()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro=="AMBAS")
        {
            $nombre_filtro="Tipo de Tensión";
            $Tipo_Cliente=$tipo_filtro;
            $Resultado=$this->Reportes_model->get_data_all_tarifas();
        }
        elseif ($tipo_filtro=="BAJA")
        {
            $nombre_filtro="Tipo de Tensión:";
            $Tipo_Cliente=$tipo_filtro;
            $Resultado=$this->Reportes_model->get_data_all_tarifas_filtradas('TipTen',0);
        }
        elseif ($tipo_filtro=="ALTA")
        {
            $nombre_filtro="Tipo de Tensión:";
            $Tipo_Cliente=$tipo_filtro;
            $Resultado=$this->Reportes_model->get_data_all_tarifas_filtradas('TipTen',1);
        }
        else
        {
            echo "El Tipo de Tensión es incorrecto";
            return false;
        }       
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Tarifas Eléctricas PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Tarifa_Eléctrica');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE TARIFAS ELÉCTRICAS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;
        
        
        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped"  >
                ';          
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">TIPO TENSIÓN</td> 
            <td style="color:white;">NOMBRE TENSIÓN</td>
            <td style="color:white;">PERIODOS</td>
            <td style="color:white;">POTENCIA MÍNIMA</td>
            <td style="color:white;">POTENCIA MÁXIMA</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->TipTen.'</td>
                        <td>'.$record->NomTarEle.'</td>
                        <td>'.$record->CanPerTar.'</td>
                        <td>'.$record->MinPotCon.' kw</td>
                        <td>'.$record->MaxPotCon.' kw</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>Actualmente no hemos encontrados datos con el tipo de tensión.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Distribuidoras','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF TARIFA ELÉCTRICAS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Tarifa_Eléctrica'.'.pdf', 'I');
    }
    public function Doc_Excel_Tarifa_Electrica()
    {       
       $tipo_filtro = urldecode($this->uri->segment(4));
        
        if($tipo_filtro==null)
        {
           echo "Debe introducir un Tipo de Filtro";
            return false; 
        }

        if($tipo_filtro=="AMBAS")
        {
            $nombre_filtro="Tipo de Tensión";
            $Tipo_Cliente=$tipo_filtro;
            $Resultado=$this->Reportes_model->get_data_all_tarifas();

        }
        elseif ($tipo_filtro=="BAJA")
        {
            $nombre_filtro="Tipo de Tensión";
            $Tipo_Cliente=$tipo_filtro;
            $Resultado=$this->Reportes_model->get_data_all_tarifas_filtradas('TipTen',0);
        }
        elseif ($tipo_filtro=="ALTA")
        {
            $nombre_filtro="Tipo de Tensión";
            $Tipo_Cliente=$tipo_filtro;
            $Resultado=$this->Reportes_model->get_data_all_tarifas_filtradas('TipTen',1);
        }
        else
        {
            echo "El Tipo de Tensión es incorrecto";
            return false;
        }
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Tipos_Tensión_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Tipo Tensión"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Tipo de Tensión"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE TIPO DE TENSIÓN");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "TIPO TENSIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "NONENCLATURA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "PERIODOS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "POTENCIA MÍNIMA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "POTENCIA MÁXIMA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        //$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A9:G9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->TipTen);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->NomTarEle);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->CanPerTar);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->MinPotCon." kw");
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->MaxPotCon." kw");
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:E$fila");           
            //$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
        }        
        //insertar formula
        /*$fila+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/        
        //recorrer las columnas
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("F2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F2");
        $objPHPExcel->getActiveSheet()->SetCellValue("F3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "F3");
        $objPHPExcel->getActiveSheet()->SetCellValue("G2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G2");
        $objPHPExcel->getActiveSheet()->SetCellValue("G3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "G3"); 
              
        foreach (range('A', 'E') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL TIPO DE TENSIÓN FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Tarifa_Gas()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TARIFA GAS";
            $Tipo_Cliente="TODAS";
            $Resultado=$this->Reportes_model->get_data_all_tarifas_gas();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Tarifas Gas PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Tarifa_Gas');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE TARIFAS GAS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">NOMBRE TARIFA</td>
            <td style="color:white;">CONSUMO MÍNIMO</td>
            <td style="color:white;">CONSUMO MÁXIMO</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NomTarGas.'</td>
                        <td>'.$record->MinConAnu.' kWh</td>
                        <td>'.$record->MaxConAnu.' kWh</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>Actualmente no hemos encontrados datos con la tarifa de gas.</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF TARIFA GAS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Tarifa_Gas'.'.pdf', 'I');
    }
    public function Doc_Excel_Tarifa_Gas()
    {       
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TARIFA GAS";
            $Tipo_Cliente="TODAS";
            $Resultado=$this->Reportes_model->get_data_all_tarifas_gas();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Tarifa_Gas_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Tarifa Gas"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Tarifa Gas"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE TARIFA GAS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "NOMBRE TARIFA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "CONSUMO MÍNIMO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "CONSUMO MÁXIMO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->NomTarGas);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->MinConAnu." kWh");
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->MaxConAnu." kWh");
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:C$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'E') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL TARIFA GAS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Colaboradores()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Colaboradores";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_colaboradores();
        }
        elseif($tipo_filtro==1)
        {
            $Tipo_Colaborador = urldecode($this->uri->segment(5)); 
            $nombre_filtro="Tipo de Colaborador";
            if($Tipo_Colaborador==1)
            {
                $Tipo_Cliente="Persona Física";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('TipCol',$Tipo_Colaborador);
            }
            elseif($Tipo_Colaborador==2)
            {
                $Tipo_Cliente="Empresa";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('TipCol',$Tipo_Colaborador);
            }
            else
            {
                echo "Error en Tipo de Colaborador";
                return false;
            } 
        } 
        elseif($tipo_filtro==2)
        {
            $Estatus = urldecode($this->uri->segment(5)); 
            $nombre_filtro="Estatus Colaborador";
            if($Estatus==1)
            {
                $Tipo_Cliente="ACTIVO";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('EstCol',$Estatus);
            }
            elseif($Estatus==2)
            {
                $Tipo_Cliente="BLOQUEADO";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('EstCol',$Estatus);
            }
            else
            {
                echo "Error en Estatus del Colaborador";
                return false;
            } 
        }     
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Colaboradores PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Colaboradores');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE COLABORADORES</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">NOMBRE</td>
            <td style="color:white;">CIF/NIF</td>
            <td style="color:white;">TIPO COLABODRADOR</td>
            <td style="color:white;">% BENEFICIO</td>
            <td style="color:white;">TELÉFONO CELULAR</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NomCol.'</td>
                        <td>'.$record->NumIdeFis.'</td>
                        <td>'.$record->TipCol.'</td>
                        <td>'.$record->PorCol.'</td>
                        <td>'.$record->TelCelCol.'</td>
                        <td>'.$record->EstCol.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF COLABORADORES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Colaboradores'.'.pdf', 'I');
    }
   public function Doc_Excel_Colaboradores()
    {       
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Colaboradores";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_colaboradores();
        }
        elseif($tipo_filtro==1)
        {
            $Tipo_Colaborador = urldecode($this->uri->segment(5)); 
            $nombre_filtro="Tipo de Colaborador";
            if($Tipo_Colaborador==1)
            {
                $Tipo_Cliente="Persona Física";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('TipCol',$Tipo_Colaborador);
            }
            elseif($Tipo_Colaborador==2)
            {
                $Tipo_Cliente="Empresa";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('TipCol',$Tipo_Colaborador);
            }
            else
            {
                echo "Error en Tipo de Colaborador";
                return false;
            } 
        } 
        elseif($tipo_filtro==2)
        {
            $Estatus = urldecode($this->uri->segment(5)); 
            $nombre_filtro="Estatus Colaborador";
            if($Estatus==1)
            {
                $Tipo_Cliente="ACTIVO";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('EstCol',$Estatus);
            }
            elseif($Estatus==2)
            {
                $Tipo_Cliente="BLOQUEADO";
                $Resultado=$this->Reportes_model->get_data_all_colaboradores_filtradas('EstCol',$Estatus);
            }
            else
            {
                echo "Error en Estatus del Colaborador";
                return false;
            } 
        }     
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Colaboradores_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Colaboradores"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Colaboradores"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE COLABORADORES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "NOMBRE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "CIF/NIF");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "TIPO COLABORADOR");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
         $objPHPExcel->getActiveSheet()->SetCellValue("D9", "% BENEFICIO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
         $objPHPExcel->getActiveSheet()->SetCellValue("E9", "TELÉFONO CELULAR");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
         $objPHPExcel->getActiveSheet()->SetCellValue("F9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->NomCol);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->NumIdeFis);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->TipCol);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->PorCol);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->TelCelCol);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado[$i]->EstCol);            
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:F$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL COLABORADORES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Comercial()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Comerciales";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_comerciales();
        }
        elseif($tipo_filtro==1)
        {
            $EstCom = urldecode($this->uri->segment(5)); 
            $nombre_filtro="Estatus del Comercial";
            if($EstCom==1)
            {
                $Tipo_Cliente="ACTIVO";
                $Resultado=$this->Reportes_model->get_data_all_comerciales_filtradas('EstCom',$EstCom);
            }
            elseif($EstCom==2)
            {
                $Tipo_Cliente="BLOQUEADO";
                $Resultado=$this->Reportes_model->get_data_all_comerciales_filtradas('EstCom',$EstCom);
            }
            else
            {
                echo "Error en Estatus del Comercial";
                return false;
            } 
        }            
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Comerciales PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Comerciales');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE COMERCIALES</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">NOMBRE</td>
            <td style="color:white;">DNI/NIE</td>
            <td style="color:white;">TELÉFONO FIJO</td>            
            <td style="color:white;">TELÉFONO CELULAR</td>
            <td style="color:white;">EMAIL</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NomCom.'</td>
                        <td>'.$record->NIFCom.'</td>
                        <td>'.$record->TelFijCom.'</td>
                        <td>'.$record->TelCelCom.'</td>
                        <td>'.$record->EmaCom.'</td>
                        <td>'.$record->EstCom.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF COMERCIALES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_Pdf_Comerciales'.'.pdf', 'I');
    }
    public function Doc_Excel_Comercial()
    {       
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Comerciales";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_comerciales();
        }
        elseif($tipo_filtro==1)
        {
            $EstCom = urldecode($this->uri->segment(5)); 
            $nombre_filtro="Estatus del Comercial";
            if($EstCom==1)
            {
                $Tipo_Cliente="ACTIVO";
                $Resultado=$this->Reportes_model->get_data_all_comerciales_filtradas('EstCom',$EstCom);
            }
            elseif($EstCom==2)
            {
                $Tipo_Cliente="BLOQUEADO";
                $Resultado=$this->Reportes_model->get_data_all_comerciales_filtradas('EstCom',$EstCom);
            }
            else
            {
                echo "Error en Estatus del Comercial";
                return false;
            } 
        }            
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Comerciales_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Comerciales"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Comercial"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE COMERCIALES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "NOMBRE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "DNI/NIE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "TELÉFONO FIJO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
         $objPHPExcel->getActiveSheet()->SetCellValue("D9", "TELÉFONO CELULAR");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
         $objPHPExcel->getActiveSheet()->SetCellValue("E9", "EMAIL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
         $objPHPExcel->getActiveSheet()->SetCellValue("F9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->NomCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->NIFCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->TelFijCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->TelCelCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->EmaCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado[$i]->EstCom);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:F$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Comercial','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL COMERCIALES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Tipo_Cliente()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Cliente";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipos_cliente();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Listado de Tipos de Cliente PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Tipos_Clientes');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE TIPOS CLIENTES</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesTipCli.'</td>
                        <td>'.$record->ObsTipCli.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF TIPOS CLIENTES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_Pdf_Tipos_Clientes'.'.pdf', 'I');
    }
    public function Doc_Excel_Tipo_Cliente()
    {   
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Clientes";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipos_cliente();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Tipos_Clientes_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Tipos Clientes"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Tipos Clientes"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE TIPOS CLIENTES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
         $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesTipCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsTipCli);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL TIPOS CLIENTES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Tipo_Sector()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Sector";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipos_sector();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Tipos de Sector PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Tipos_Sector');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE TIPOS SECTOR</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesSecCli.'</td>
                        <td>'.$record->ObsSecCli.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF TIPOS SECTOR FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_Pdf_Tipos_Sector'.'.pdf', 'I');
    }
    public function Doc_Excel_Tipo_Sector()
    {   
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Sector";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipos_sector();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Tipos_Sector_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Tipos Sector"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Tipos Sector"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE TIPOS DE SECTOR");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
         $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesSecCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsSecCli);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_SectorCliente','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL TIPOS SECTOR FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
     public function Doc_PDF_Tipo_Contacto()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Contacto";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipos_contacto();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Listado de Tipos Contacto PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Tipos_Contacto');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE TIPO CONTACTO</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesTipCon.'</td>
                        <td>'.$record->ObsTipCon.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF TIPO CONTACTO FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Tipo_Contacto'.'.pdf', 'I');
    }
    public function Doc_Excel_Tipo_Contacto()
    {   
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Contacto";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipos_contacto();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Tipos_Contacto_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Tipos Contacto"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Tipos Contacto"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE TIPOS CONTACTO");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
         $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesTipCon);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsTipCon);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoContacto','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL TIPOS CONTACTO FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Tipo_Documento()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Documentos";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_tipo_documentos();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Tipo Documento PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Tipos_Documento');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE TIPO DOCUMENTOS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
            <td style="color:white;">es requerido</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesTipDoc.'</td>
                        <td>'.$record->ObsTipDoc.'</td>
                        <td>'.$record->EstReq.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF TIPO DOCUMENTOS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_Pdf_Tipo_Documento'.'.pdf', 'I');
    }
    public function Doc_Excel_Tipo_Documento()
    {   
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Tipos de Documentos";
            $Resultado=$this->Reportes_model->get_data_all_tipo_documentos();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Tipo_Documentos_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Tipo Documento"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Tipo Documento"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE TIPO DE DOCUMENTOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "es requerido");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesTipDoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsTipDoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->EstReq);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:C$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL TIPO DE DOCUMENTO FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
     public function Doc_PDF_Motivo_Bloqueo_Cliente()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Motivos de Bloqueo de Clientes";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_bloqueos();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Motivos Clientes PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Motivos_Clientes');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO MOTIVOS BLOQUEO CLIENTES</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesMotBloCli.'</td>
                        <td>'.$record->ObsMotBloCli.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%20Clientes");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF MOTIVOS BLOQUEOS CLIENTES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Doc_Excel_Motivo_Bloqueo_Cliente()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Motivos de Bloqueo de Clientes";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_bloqueos();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }    
       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Motivos_Bloqueos_Clientes_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Motivos Clientes"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Motivos Clientes"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE MOTIVOS BLOQUEOS CLIENTES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesMotBloCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsMotBloCli);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TipoDocumento','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL MOTIVOS BLOQUEOS CLIENTES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Motivo_Bloqueo_Actividad()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Motivos de Bloqueo de Actividad";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_actividad();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Motivos Actividad PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Motivos_Actividad');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO MOTIVOS BLOQUEO ACTIVIDADES</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesMotBloAct.'</td>
                        <td>'.$record->ObsMotBloAct.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%Actividades");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF MOTIVOS BLOQUEOS ACTIVIDADES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Doc_Excel_Motivo_Bloqueo_Actividad()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Motivos de Bloqueo de Actividad";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_actividad();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }   
       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Motivos_Bloqueos_Actividad_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Motivos Actividad"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Motivos Actividades"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE MOTIVOS BLOQUEOS ACTIVIDADES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesMotBloAct);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsMotBloAct);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL MOTIVOS BLOQUEOS ACTIVIDADES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Motivo_Bloqueo_Punto_Suministro()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Motivos de Bloqueo de Direcciones de Suministro";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_PunSum();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Listado de Motivos Dirección Suministro PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Motivos_Punto_Suministro');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO MOTIVOS BLOQUEO PUNTOS SUMINISTROS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesMotBloPun.'</td>
                        <td>'.$record->ObsMotBloPun.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%Puntos Suministros");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF MOTIVOS BLOQUEOS PUNTOS SUMINISTROS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Doc_Excel_Motivo_Bloqueo_Punto_Suministro()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="Todos los Motivos de Bloqueo de Direcciones de Suministro";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_PunSum();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }   
       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Motivos_Bloqueos_Puntos_Suministros_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Motivos Direcciones Suministros"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Motivos Direcciones Suministros"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE MOTIVOS BLOQUEOS DIRECCIONES DE SUMINISTRO");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesMotBloPun);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsMotBloPun);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL MOTIVOS BLOQUEOS PUNTOS SUMINSITROS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Motivo_Bloqueo_Contacto()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS MOTIVOS BLOQUEO Dirección de Suministro";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_Contactos();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Motivos Contacto PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Motivos_Contacto');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO MOTIVOS BLOQUEO CONTACTO</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesMotBlocon.'</td>
                        <td>'.$record->ObsMotBloCon.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%20Contactos");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF MOTIVOS BLOQUEOS CONTACTOS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Doc_Excel_Motivo_Bloqueo_Contacto()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS MOTIVOS BLOQUEO CONTACTOS";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_Contactos();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }   
       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Motivos_Bloqueos_Contactos_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Motivos Contactos"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Motivos Contactos"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE MOTIVOS BLOQUEOS CONTACTOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesMotBlocon);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsMotBloCon);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL MOTIVOS BLOQUEOS CONTACTOS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Motivo_Bloqueo_Comercializadora()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS MOTIVOS BLOQUEO COMERCIALIZADORA";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_Comercializadora();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Motivos Comercializadora PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Motivos_Comercializadora');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO MOTIVOS BLOQUEO COMERCIALIZADORA</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesMotBloCom.'</td>
                        <td>'.$record->ObsMotBloCom.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%20Comercializadora");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF MOTIVOS BLOQUEOS COMERCIALIZADORAS FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Doc_Excel_Motivo_Bloqueo_Comercializadora()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS MOTIVOS BLOQUEO COMERCIALIZADORA";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_Comercializadora();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Motivos_Bloqueos_Comercializadora_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Motivos Comercializadora"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Motivos Comercializadora"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE MOTIVOS BLOQUEOS COMERCIALIZADORA");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesMotBloCom);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsMotBloCom);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL MOTIVOS BLOQUEOS COMERCIALIZADORAS FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Doc_PDF_Motivo_Bloqueo_CUPs()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS MOTIVOS BLOQUEO CUPs";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_CUPs();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Motivos CUPs PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Motivos_CUPs');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO MOTIVOS BLOQUEO COMERCIALIZADORA</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">DESCRIPCIÓN</td>
            <td style="color:white;">OBSERVACIÓN</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->DesMotBloCUPs.'</td>
                        <td>'.$record->ObsMotBloCUPs.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%20CUPs");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCUPs','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF MOTIVOS BLOQUEOS CUPs FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Doc_Excel_Motivo_Bloqueo_CUPs()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS MOTIVOS BLOQUEO CUPs";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_data_all_motivos_CUPs();
        }   
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Motivos_Bloqueos_CUPs_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Motivos CUPs"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Motivos CUPs"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE MOTIVOS BLOQUEOS CUPs");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "DESCRIPCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "OBSERVACIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->DesMotBloCUPs);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->ObsMotBloCUPs);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'F') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCUPs','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL MOTIVOS BLOQUEOS CUPs FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
    public function Clientes_Doc_PDF_Documentos()
    {
        $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS DOCUMENTOS";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_all_documentos();
        }
        elseif($tipo_filtro==1)
        {
            $CodCli = urldecode($this->uri->segment(5));
            if($CodCli==null)
            {
                echo "Debe introducir un Código de Cliente";
                return false; 
            }
            $ResCodCli=$this->Reportes_model->get_tipo_filtro_busqueda('T_Cliente','CodCli',$CodCli);
            if($ResCodCli!=false)
            {
                $nombre_filtro="Cliente";
                $Tipo_Cliente=$ResCodCli->NumCifCli." - ".$ResCodCli->RazSocCli;
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.CodCli',$CodCli);
            } 
            else
            {
               echo "El Código de Cliente no se encuentra registrado";
                return false;   
            }            
        } 
        elseif($tipo_filtro==2)
        {
            $Tipo_Documento = urldecode($this->uri->segment(5));
            if($Tipo_Documento==null)
            {
                echo "Debe introducir un Tipo de Documento";
                return false; 
            }
            $ResDocumento=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoDocumento','CodTipDoc',$Tipo_Documento);
            if($ResDocumento!=false)
            {
                $nombre_filtro="Documento";
                $Tipo_Cliente=$ResDocumento->DesTipDoc;
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.CodTipDoc',$Tipo_Documento);
            } 
            else
            {
               echo "El Tipo de Documento no se encuentra registrado";
                return false;   
            }            
        } 
        elseif($tipo_filtro==3)
        {
            $Tiene_Venci = urldecode($this->uri->segment(5));
            if($Tiene_Venci==null)
            {
                echo "Debe indicar si el Documento tiene o no vencimiento";
                return false; 
            }

            if($Tiene_Venci==1)
            {
                $nombre_filtro="Tiene Vencimiento";
                $Tipo_Cliente="SI";
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.TieVen',1);
            }
            elseif ($Tiene_Venci==2)
            {
                $nombre_filtro="Tiene Vencimiento";
                $Tipo_Cliente="NO";
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.TieVen',2);
            }
            else
            {  
                echo "El Tipo de Vencimiento es Incorrecto";
                return false;
                
            }            
        }     
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }  
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Documentos PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Documentos_Clientes');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE DOCUMENTOS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CLIENTES</td>
            <td style="color:white;">TIPO DOCUMENTO</td>
            <td style="color:white;">NOMBRE DEL FICHERO</td>
            <td style="color:white;">TIENE VENCIMIENTO</td>
            <td style="color:white;">FECHA VENCIMIENTO</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->NumCifCli.' - '.$record->RazSocCli.'</td>
                        <td>'.$record->DesTipDoc.'</td>
                        <td>'.$record->DesDoc.'</td>
                        <td>'.$record->TieVenDes.'</td>
                        <td>'.$record->FecVenDoc.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="2"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20Motivos%20Bloqueos%20Comercializadora");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF DOCUMENTOS CLIENTES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Clientes_Doc_Excel_Documentos()
    {
       $tipo_filtro = urldecode($this->uri->segment(4));        
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
        if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS DOCUMENTOS";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_all_documentos();
        }
        elseif($tipo_filtro==1)
        {
            $CodCli = urldecode($this->uri->segment(5));
            if($CodCli==null)
            {
                echo "Debe introducir un Código de Cliente";
                return false; 
            }
            $ResCodCli=$this->Reportes_model->get_tipo_filtro_busqueda('T_Cliente','CodCli',$CodCli);
            if($ResCodCli!=false)
            {
                $nombre_filtro="CLIENTE: ";
                $Tipo_Cliente=$ResCodCli->NumCifCli." - ".$ResCodCli->RazSocCli;
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.CodCli',$CodCli);
            } 
            else
            {
               echo "El Código de Cliente no se encuentra registrado";
                return false;   
            }            
        } 
        elseif($tipo_filtro==2)
        {
            $Tipo_Documento = urldecode($this->uri->segment(5));
            if($Tipo_Documento==null)
            {
                echo "Debe introducir un Tipo de Documento";
                return false; 
            }
            $ResDocumento=$this->Reportes_model->get_tipo_filtro_busqueda('T_TipoDocumento','CodTipDoc',$Tipo_Documento);
            if($ResDocumento!=false)
            {
                $nombre_filtro="DOCUMENTO: ";
                $Tipo_Cliente=$ResDocumento->DesTipDoc;
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.CodTipDoc',$Tipo_Documento);
            } 
            else
            {
               echo "El Tipo de Documento no se encuentra registrado";
                return false;   
            }            
        } 
        elseif($tipo_filtro==3)
        {
            $Tiene_Venci = urldecode($this->uri->segment(5));
            if($Tiene_Venci==null)
            {
                echo "Debe indicar si el Documento tiene o no vencimiento";
                return false; 
            }

            if($Tiene_Venci==1)
            {
                $nombre_filtro="Tiene Vencimiento";
                $Tipo_Cliente="SI";
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.TieVen',1);
            }
            elseif ($Tiene_Venci==2)
            {
                $nombre_filtro="Tiene Vencimiento";
                $Tipo_Cliente="NO";
                $Resultado=$this->Reportes_model->get_all_documentos_filtrado('a.TieVen',2);
            }
            else
            {  
                echo "El Tipo de Vencimiento es Incorrecto";
                return false;
                
            }            
        }     
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }       
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Documentos_Clientes_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Documentos Clientes"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Documentos Clientes"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTA DE DOCUMENTOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CLIENTES");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "TIPO DOCUMENTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "NOMBRE DEL FICHERO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "TIENE VENCIMIENTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "FECHA VENCIMIENTO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->NumCifCli.' '.$Resultado[$i]->RazSocCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->DesTipDoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->DesDoc);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->TieVenDes);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->FecVenDoc);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:E$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'E') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL DOCUMENTOS CLIENTES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }

    public function Gestionar_Cups_Pdf()
    {      
        $tipo_filtro = urldecode($this->uri->segment(4));
        $CodPunSum=  urldecode($this->uri->segment(5));      
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
       if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS CUPS";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_all_cups();
        }
       elseif($tipo_filtro==1)
        {
            $TipServ = urldecode($this->uri->segment(5));
            $CodPunSum=  urldecode($this->uri->segment(6));
            if($TipServ=="Gas")
            {
                $nombre_filtro="Tipo de Suministro";
                $Tipo_Cliente=$TipServ;
                $Where="TipServ";
                $AND="CodPunSum";

                $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda($Where,$TipServ);
            }
            elseif($TipServ=="Eléctrico")
            {
                $nombre_filtro="Tipo de Suministro";
                $Tipo_Cliente=$TipServ;
                $Where="TipServ";
                $AND="CodPunSum";
                $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda($Where,$TipServ);
            }
            else
            {
                echo "El Tipo de Suministro debe ser Gas o Eléctrico";
                return false;
            } 
        } 
        elseif($tipo_filtro==2)
        {
            $TipServ = urldecode($this->uri->segment(5));
            $NomTar = urldecode($this->uri->segment(6));
            $CodPunSum = urldecode($this->uri->segment(7));
             if($TipServ=="Gas")
            {
                $nombre_filtro="TARIFA GAS: ";                
                $Tarifa=$this->Reportes_model->get_tipo_filtro_busqueda('T_TarifaGas','NomTarGas',$NomTar);
                if($Tarifa)
                {
                    //,b.NomTarGas,case a.EstCUPs when 1 'ACTIVO' WHEN 2 THEN 'DADO DE BAJA' end as EstCUPs
                    $Select="a.CupsGas,case a.TipServ when 2 then 'Gas' end as TipServ, b.NomTarGas,case a.EstCUPs when 1 then 'ACTIVO' when 2 then 'DADO DE BAJO' end as EstCUPs";
                    $Tabla='T_CUPsGas a';                    
                    $Join="T_TarifaGas b";
                    $ON="a.CodTarGas=b.CodTarGas";
                    $Order_BY="a.CupsGas ASC";
                    $Where='a.CodTarGas';
                    $AND="a.CodPunSum";
                    $Tipo_Cliente=$Tarifa->NomTarGas;
                    $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda_Tar($Select,$Tabla,$Join,$ON,$Where,$Tarifa->CodTarGas,$Order_BY);
                }
                else
                {
                    echo "Error la tarifa no puede ser encontrada verifique he intente nuevamente.";
                    return false;
                }
            }
            elseif($TipServ=="Electrico")
            {
                $nombre_filtro="TARIFA ELÉCTRICA: ";                
                $Tarifa=$this->Reportes_model->get_tipo_filtro_busqueda('T_TarifaElectrica','NomTarEle',$NomTar);
                if($Tarifa!=false)
                {
                    $Select="a.CUPsEle as CupsGas,case a.TipServ when 1 then 'Eléctrico' end as TipServ, b.NomTarEle as NomTarGas,case a.EstCUPs when 1 then 'ACTIVO' when 2 then 'DADO DE BAJO' end as EstCUPs";
                    $Tabla='T_CUPsElectrico a';                    
                    $Join="T_TarifaElectrica b";
                    $ON="a.CodTarElec=b.CodTarEle";
                    $Order_BY="a.CUPsEle ASC";
                    $Where='a.CodTarElec';
                    $AND="a.CodPunSum";
                    $Tipo_Cliente=$Tarifa->NomTarEle;
                    $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda_Tar($Select,$Tabla,$Join,$ON,$Where,$Tarifa->CodTarEle,$Order_BY);
                }
                else
                {
                    echo "No existen Tarifas registradas";
                    return false;
                }               
            }
            else
            {
                echo "El Tipo de Suministro debe ser Gas o Eléctrico";
                return false;
            }         
        } 
        elseif($tipo_filtro==3)
        {
            $Estatus = urldecode($this->uri->segment(5));
            $CodPunSum = urldecode($this->uri->segment(6));
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Cliente=$Estatus;
            $Where="EstCUPs";
            $AND="CodPunSum";
            $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda($Where,$Estatus);       
        }     
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de CUPs PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_CUPs');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE CUPS</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Filtro Aplicado</td>
                <td border="0" colspan="2">'.$nombre_filtro.' '.$Tipo_Cliente.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">CUPS</td>
            <td style="color:white;">TIPO SUMINISTRO</td>
            <td style="color:white;">TARIFA</td>
            <td style="color:white;">ESTATUS</td>
        </tr>';
        if($Resultado!=false)
        {
            foreach ($Resultado as $record): 
            {
                $html.='<tr>
                        <td>'.$record->CupsGas.'</td>
                        <td>'.$record->TipServ.'</td>
                        <td>'.$record->NomTarGas.'</td>
                        <td>'.$record->EstCUPs.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="4"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $nombre_reporte_salida=urldecode("Doc%20Pdf%20CUPs");
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_CUPs','GET',NULL,$this->input->ip_address(),'GENERANDO REPORTE PDF LISTADO DE CUPS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    } 
    public function Gestionar_Cups_Excel()
    {
       $tipo_filtro = urldecode($this->uri->segment(4));
        $CodPunSum=  urldecode($this->uri->segment(5));      
        if($tipo_filtro==null)
        {
            echo "Debe introducir un Tipo de Filtro";
            return false; 
        }
       if($tipo_filtro==0)
        {
            $nombre_filtro="TODOS LOS CUPS";
            $Tipo_Cliente="";
            $Resultado=$this->Reportes_model->get_all_cups('CodPunSum',$CodPunSum);
        }
       elseif($tipo_filtro==1)
        {
            $TipServ = urldecode($this->uri->segment(5));
            $CodPunSum=  urldecode($this->uri->segment(6));
            if($TipServ=="Gas")
            {
                $nombre_filtro="Tipo de Suministro";
                $Tipo_Cliente=$TipServ;
                $Where="TipServ";
                $AND="CodPunSum";

                $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda($Where,$TipServ,$AND,$CodPunSum);
            }
            elseif($TipServ=="Eléctrico")
            {
                $nombre_filtro="Tipo de Suministro";
                $Tipo_Cliente=$TipServ;
                $Where="TipServ";
                $AND="CodPunSum";
                $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda($Where,$TipServ,$AND,$CodPunSum);
            }
            else
            {
                echo "El Tipo de Suministro debe ser Gas o Eléctrico";
                return false;
            } 
        } 
        elseif($tipo_filtro==2)
        {
            $TipServ = urldecode($this->uri->segment(5));
            $NomTar = urldecode($this->uri->segment(6));
            $CodPunSum = urldecode($this->uri->segment(7));
             if($TipServ=="Gas")
            {
                $nombre_filtro="TARIFA GAS: ";                
                $Tarifa=$this->Reportes_model->get_tipo_filtro_busqueda('T_TarifaGas','NomTarGas',$NomTar);
                if($Tarifa)
                {
                    //,b.NomTarGas,case a.EstCUPs when 1 'ACTIVO' WHEN 2 THEN 'DADO DE BAJA' end as EstCUPs
                    $Select="a.CupsGas,case a.TipServ when 2 then 'Gas' end as TipServ, b.NomTarGas,case a.EstCUPs when 1 then 'ACTIVO' when 2 then 'DADO DE BAJO' end as EstCUPs";
                    $Tabla='T_CUPsGas a';                    
                    $Join="T_TarifaGas b";
                    $ON="a.CodTarGas=b.CodTarGas";
                    $Order_BY="a.CupsGas ASC";
                    $Where='a.CodTarGas';
                    $AND="a.CodPunSum";
                    $Tipo_Cliente=$Tarifa->NomTarGas;
                    $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda_Tar($Select,$Tabla,$Join,$ON,$Where,$AND,$CodPunSum,$Tarifa->CodTarGas,$Order_BY);
                }
                else
                {
                    echo "Error la tarifa no puede ser encontrada verifique he intente nuevamente.";
                    return false;
                }
            }
            elseif($TipServ=="Electrico")
            {
                $nombre_filtro="TARIFA ELÉCTRICA: ";                
                $Tarifa=$this->Reportes_model->get_tipo_filtro_busqueda('T_TarifaElectrica','NomTarEle',$NomTar);
                if($Tarifa!=false)
                {
                    $Select="a.CUPsEle as CupsGas,case a.TipServ when 1 then 'Eléctrico' end as TipServ, b.NomTarEle as NomTarGas,case a.EstCUPs when 1 then 'ACTIVO' when 2 then 'DADO DE BAJO' end as EstCUPs";
                    $Tabla='T_CUPsElectrico a';                    
                    $Join="T_TarifaElectrica b";
                    $ON="a.CodTarElec=b.CodTarEle";
                    $Order_BY="a.CUPsEle ASC";
                    $Where='a.CodTarElec';
                    $AND="a.CodPunSum";
                    $Tipo_Cliente=$Tarifa->NomTarEle;
                    $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda_Tar($Select,$Tabla,$Join,$ON,$Where,$AND,$CodPunSum,$Tarifa->CodTarEle,$Order_BY);
                }
                else
                {
                    echo "No existen Tarifas registradas";
                    return false;
                }               
            }
            else
            {
                echo "El Tipo de Suministro debe ser Gas o Eléctrico";
                return false;
            }         
        } 
        elseif($tipo_filtro==3)
        {
            $Estatus = urldecode($this->uri->segment(5));
            $CodPunSum = urldecode($this->uri->segment(6));
            $nombre_filtro="Tipo de Suministro";
            $Tipo_Cliente=$Estatus;
            $Where="EstCUPs";
            $AND="CodPunSum";
            $Resultado=$this->Reportes_model->get_all_cups_filtro_busqueda($Where,$Estatus,$AND,$CodPunSum);       
        }     
        else
        {
          echo "El Tipo de Filtro es incorrecto"; 
          return false; 
        }    
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Gestionar_CUPs_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Gestionar CUPs"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Gestionar CUPs"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE CUPs");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "CUPS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "TIPO SUMINISTRO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "TARIFA");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "ESTATUS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->CupsGas);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->TipServ);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->NomTarGas);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->EstCUPs);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:D$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Filtro Aplicado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $nombre_filtro);
        $objPHPExcel->getActiveSheet()->SetCellValue("C7", $Tipo_Cliente);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A7:C7");                 
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3"); 
              
        foreach (range('A', 'E') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Documentos','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL DOCUMENTOS CLIENTES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    } 

     public function Historial_Consumo_CUPs_PDF()
    {  
        $nombre_filtro="Historial de Consumos CUPs";
        $desde = urldecode($this->uri->segment(4));
        $hasta= urldecode($this->uri->segment(5));
        $CodPunSum= urldecode($this->uri->segment(6));
        $TipServ= urldecode($this->uri->segment(7));
        $Resultado=false;
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Historial de CUPs Desde: '.$desde .' Hasta: '.$hasta);
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Historial_CUPs');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>HISTORIAL DE CONSUMO CUPs</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left"></td>
                <td border="0" colspan="2"></td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';     
        if($TipServ=="Gas")
        {
            $html.='
            <tr bgcolor="#636161">
                <td style="color:white;">Fecha Inicio</td>
                <td style="color:white;">Fecha Final</td>
                <td style="color:white;">Consumo</td>
            </tr>';
            $Tabla="T_HistorialCUPsGas";
            $Where="CodCupGas";
            $Resultado=$this->Reportes_model->generar_historial_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
                foreach ($Resultado as $record): 
                {
                    $html.='<tr>
                            <td>'.$record->FecIniCon.'</td>
                            <td>'.$record->FecFinCon.'</td>
                            <td>'.$record->ConCup.'</td>
                        </tr>';     
                    }
                    endforeach;
                   $html.='<tr>
                            <td colspan="2" align="left">Total Consumo: </td>
                            
                            <td>'.$total_consumo->AcumConCup.'</td>
                        </tr>';  
                }
                else
                {
                    $html.='
                    <tr>
                    <td align="center" colspan="3"><b>No existen datos registrados</b></td>              
                    </tr>'; 
                }   
            $html .= '</table>' ;
        }
        elseif ($TipServ=="Eléctrico") 
        {
            $Tabla="T_HistorialCUPsElectrico";
            $Where="CodCupEle";
            
            $html.='
            <tr bgcolor="#636161">
            <td style="color:white;">PotCon1</td>
            <td style="color:white;">PotCon2</td>
            <td style="color:white;">PotCon3</td>
            <td style="color:white;">PotCon4</td>
            <td style="color:white;">PotCon5</td>
            <td style="color:white;">PotCon6</td>
            <td style="color:white;">Fecha Inicio</td>
            <td style="color:white;">Fecha Final</td>
            <td style="color:white;">Consumo</td>
            </tr>';
            $Resultado=$this->Reportes_model->generar_historial_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
            //$Resultado=false;
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
                foreach ($Resultado as $record): 
                {
                    $html.='<tr>
                    <td>'.$record->PotCon1.'</td>
                    <td>'.$record->PotCon2.'</td>
                    <td>'.$record->PotCon3.'</td>
                    <td>'.$record->PotCon4.'</td>
                    <td>'.$record->PotCon5.'</td>
                    <td>'.$record->PotCon6.'</td>
                    <td>'.$record->FecIniCon.'</td>
                    <td>'.$record->FecFinCon.'</td>
                    <td>'.$record->ConCup.'</td>
                    </tr>';     
                }
                endforeach;
                $html.='<tr>
                        <td colspan="8" align="left">Total Consumo: </td>
                        <td>'.$total_consumo->AcumConCup.'</td>
                        </tr>'; 
            }
            else
            {
               $html.='
                <tr>
                <td align="center" colspan="9"><b>No existen datos registrados</b></td>              
                </tr>';  
            }
            $html .= '</table>' ;
        }
        $nombre_reporte_salida=urldecode("Historial Consumo CUPs ".$desde.' '.$hasta);
        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'GENERANDO REPORTE HISTORIAL CONSUMO CUPS '.$TipServ);
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    }
    public function Historial_Consumo_CUPs_Excel()
    {
        $nombre_filtro="Historial de Consumos CUPs";
        $desde = urldecode($this->uri->segment(4));
        $hasta= urldecode($this->uri->segment(5));
        $CodPunSum= urldecode($this->uri->segment(6));
        $TipServ= urldecode($this->uri->segment(7));


        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Historial_Consumo_CUPs_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Historial Consumo CUPs"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Historial Consumo CUPs"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "Historial de Consumo CUPs ".$TipServ);
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6"); 
        if($TipServ=="Eléctrico")
        {
            $Tabla="T_HistorialCUPsElectrico";
            $Where="CodCupEle";
            $Resultado=$this->Reportes_model->generar_historial_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
                $objPHPExcel->getActiveSheet()->SetCellValue("A9", "PotCon1");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
                $objPHPExcel->getActiveSheet()->SetCellValue("B9", "PotCon2");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
                $objPHPExcel->getActiveSheet()->SetCellValue("C9", "PotCon3");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
                $objPHPExcel->getActiveSheet()->SetCellValue("D9", "PotCon4");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("E9", "PotCon5");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("F9", "PotCon6");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("G9", "Fecha Inicio");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("H9", "Fecha Final");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("I9", "Consumo");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I9");
                $fila=9;
                for($i=0; $i<count($Resultado); $i++) 
                {
                    $fila+=1;
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->PotCon1);
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->PotCon2);
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->PotCon3);
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->PotCon4);
                    $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->PotCon5);
                    $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado[$i]->PotCon6);
                    $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado[$i]->FecIniCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado[$i]->FecFinCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $Resultado[$i]->ConCup);
                    $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:I$fila");  
                }
                $fila+=1;                
                $objPHPExcel->getActiveSheet()->SetCellValue("A$fila",'TOTAL CONSUMO:'); #$total_consumo->AcumConCup);
                $objPHPExcel->getActiveSheet()->SetCellValue("I$fila",$total_consumo->AcumConCup); #$total_consumo->AcumConCup);
                $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:I$fila");                
            }           
        }
        elseif ($TipServ=="Gas") 
        {
            $Tabla="T_HistorialCUPsGas";
            $Where="CodCupGas";
            $Resultado=$this->Reportes_model->generar_historial_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups($desde,$hasta,$CodPunSum,$Tabla,$Where);
                $objPHPExcel->getActiveSheet()->SetCellValue("A9", "Fecha Inicio");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
                $objPHPExcel->getActiveSheet()->SetCellValue("B9", "Fecha Final");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
                $objPHPExcel->getActiveSheet()->SetCellValue("C9", "Consumo");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
                $fila=9;
                for($i=0; $i<count($Resultado); $i++) 
                {
                    $fila+=1;
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->FecIniCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->FecFinCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->ConCup);
                    $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:C$fila");  
                }
                $fila+=1;                
                $objPHPExcel->getActiveSheet()->SetCellValue("A$fila",'TOTAL CONSUMO:'); 
                $objPHPExcel->getActiveSheet()->SetCellValue("C$fila",$total_consumo->AcumConCup);
                $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:C$fila");                
            } 
        }              
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3");
        foreach (range('A', 'I') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'GENERANDO REPORTE EXCEL HISTORIAL CONSUMO CUPS '.$TipServ);
        $objWriter->save('php://output');
        exit;   
    } 
    public function Gestionar_Consumo_Cups_Pdf()
    {
        $CodCup = urldecode($this->uri->segment(4));   
        $TipServ = urldecode($this->uri->segment(5));      
        $CodPunSum = urldecode($this->uri->segment(7));
        $nombre_filtro="Gestionar Consumos de CUPs ".$TipServ;         
        if($TipServ=="Gas")
        {
            $Select2="a.CupsGas as CUPs,b.NomTarGas as NomTar,b.CodTarGas as CodTar";
            $Tabla2="T_CUPsGas a";
            $Join3="T_TarifaGas b";
            $JoinWhere="a.CodTarGas=b.CodTarGas";
            $Where="a.CodCupGas";              
            $Name_CUPs = $this->Reportes_model->get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup);
            if($Name_CUPs!=false)
            {
                $CUPs=$Name_CUPs->CUPs;
                $NomTar=$Name_CUPs->NomTar;
            }
            else
            {
                $CUPs="Sin Identificar";
                $NomTar="Sin Identificar";
            }            
        }
        else
        {
            $Select2="a.CUPsEle as CUPs,b.NomTarEle as NomTar,b.CodTarEle as CodTar";
            $Tabla2="T_CUPsElectrico a";
            $Join3="T_TarifaElectrica b";
            $JoinWhere="a.CodTarElec=b.CodTarEle";
            $Where="a.CodCupsEle";            
            $Name_CUPs = $this->Reportes_model->get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup);
            if($Name_CUPs!=false)
            {
                $CUPs=$Name_CUPs->CUPs;
                $NomTar=$Name_CUPs->NomTar;
            }
            else
            {
                $CUPs="Sin Identificar";
                $NomTar="Sin Identificar";
            }
        } 
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Gestionar Consumo de CUPs PDF');
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_Pdf_Gestionar_Consumo_CUPs');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>GESTIONAR CONSUMO DE CUPs '.$TipServ.'</h4></td>               
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left" colspan="3"><b>CUPs:</b> '.$CUPs.' <b>Tarifa:</b> '.$NomTar.'</td>
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';     
        if($TipServ=="Gas")
        {
            $html.='
            <tr bgcolor="#636161">
                <td style="color:white;">Fecha Inicio</td>
                <td style="color:white;">Fecha Final</td>
                <td style="color:white;">Consumo</td>
            </tr>';
            $Select="DATE_FORMAT(FecIniCon,'%d-%m-%Y') as FecIniCon,DATE_FORMAT(FecFinCon,'%d-%m-%Y') as FecFinCon,ConCup";
            $Tabla="T_HistorialCUPsGas";
            $Where="CodCupGas";
            $Resultado=$this->Reportes_model->generar_consumo_cups($CodPunSum,$Select,$Tabla,$Where,$CodCup);
            //$Resultado=false;
            if($Resultado!=false)
            {                
                $total_consumo=$this->Reportes_model->sum_consumo_cups($CodCup,$Tabla,$Where);
                foreach ($Resultado as $record): 
                {
                    $html.='<tr>
                            <td>'.$record->FecIniCon.'</td>
                            <td>'.$record->FecFinCon.'</td>
                            <td>'.$record->ConCup.'</td>
                        </tr>';     
                    }
                    endforeach;
                   $html.='<tr>
                            <td colspan="2" align="left">Total Consumo: </td>
                            <td>'.$total_consumo->AcumConCup.'</td>
                        </tr>';  
                }
                else
                {
                    $html.='
                    <tr>
                    <td align="center" colspan="3"><b>No existen datos registrados</b></td>              
                    </tr>'; 
                }   
            $html .= '</table>' ;
        }
        elseif ($TipServ=="Eléctrico") 
        {
            $html.='
            <tr bgcolor="#636161">
            <td style="color:white;">PotCon1</td>
            <td style="color:white;">PotCon2</td>
            <td style="color:white;">PotCon3</td>
            <td style="color:white;">PotCon4</td>
            <td style="color:white;">PotCon5</td>
            <td style="color:white;">PotCon6</td>
            <td style="color:white;">Fecha Inicio</td>
            <td style="color:white;">Fecha Final</td>
            <td style="color:white;">Consumo</td>
            </tr>';
            $Select="PotCon1,PotCon2,PotCon3,PotCon4,PotCon5,PotCon6,DATE_FORMAT(FecIniCon,'%d-%m-%Y') as FecIniCon,DATE_FORMAT(FecFinCon,'%d-%m-%Y') as FecFinCon,ConCup";
            $Tabla="T_HistorialCUPsElectrico";
            $Where="CodCupEle";
            $Resultado=$this->Reportes_model->generar_consumo_cups($CodPunSum,$Select,$Tabla,$Where,$CodCup);
           
            //$Resultado=false;
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups($CodCup,$Tabla,$Where);
                foreach ($Resultado as $record): 
                {
                    $html.='<tr>
                    <td>'.$record->PotCon1.'</td>
                    <td>'.$record->PotCon2.'</td>
                    <td>'.$record->PotCon3.'</td>
                    <td>'.$record->PotCon4.'</td>
                    <td>'.$record->PotCon5.'</td>
                    <td>'.$record->PotCon6.'</td>
                    <td>'.$record->FecIniCon.'</td>
                    <td>'.$record->FecFinCon.'</td>
                    <td>'.$record->ConCup.'</td>
                    </tr>';     
                }
                endforeach;
                $html.='<tr>
                        <td colspan="8" align="left">Total Consumo: </td>
                        <td>'.$total_consumo->AcumConCup.'</td>
                        </tr>'; 
            }
            else
            {
               $html.='
                <tr>
                <td align="center" colspan="9"><b>No existen datos registrados</b></td>              
                </tr>';  
            }
            $html .= '</table>' ;
        }
        $nombre_reporte_salida=urldecode("Gestionar Consumo de CUPs ".$TipServ);
        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'GENERANDO REPORTE GESTION CONSUMO DE CUPS '.$TipServ);
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output($nombre_reporte_salida.'.pdf', 'I');
    } 

 public function Gestionar_Consumo_Cups_Excel()
    {
        $CodCup = urldecode($this->uri->segment(4));   
        $TipServ = urldecode($this->uri->segment(5));      
        $CodPunSum = urldecode($this->uri->segment(7));
        $nombre_filtro="Gestionar Consumos de CUPs ".$TipServ;         
        if($TipServ=="Gas")
        {
            $Select2="a.CupsGas as CUPs,b.NomTarGas as NomTar,b.CodTarGas as CodTar";
            $Tabla2="T_CUPsGas a";
            $Join3="T_TarifaGas b";
            $JoinWhere="a.CodTarGas=b.CodTarGas";
            $Where="a.CodCupGas";              
            $Name_CUPs = $this->Reportes_model->get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup);
            if($Name_CUPs!=false)
            {
                $CUPs=$Name_CUPs->CUPs;
                $NomTar=$Name_CUPs->NomTar;
            }
            else
            {
                $CUPs="Sin Identificar";
                $NomTar="Sin Identificar";
            }            
        }
        else
        {
            $Select2="a.CUPsEle as CUPs,b.NomTarEle as NomTar,b.CodTarEle as CodTar";
            $Tabla2="T_CUPsElectrico a";
            $Join3="T_TarifaElectrica b";
            $JoinWhere="a.CodTarElec=b.CodTarEle";
            $Where="a.CodCupsEle";            
            $Name_CUPs = $this->Reportes_model->get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup);
            if($Name_CUPs!=false)
            {
                $CUPs=$Name_CUPs->CUPs;
                $NomTar=$Name_CUPs->NomTar;
            }
            else
            {
                $CUPs="Sin Identificar";
                $NomTar="Sin Identificar";
            }
        } 
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Gestionar_Consumo_CUPs_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Gestionar Consumo CUPs"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Gestionar Consumo CUPs"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "Gestionar Consumo de CUPs ".$TipServ);
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6"); 
        //$Tabla="T_HistorialCUPsElectrico";
        if($TipServ=="Eléctrico")
        {
            $Select="PotCon1,PotCon2,PotCon3,PotCon4,PotCon5,PotCon6,DATE_FORMAT(FecIniCon,'%d-%m-%Y') as FecIniCon,DATE_FORMAT(FecFinCon,'%d-%m-%Y') as FecFinCon,ConCup";
            $Tabla="T_HistorialCUPsElectrico";
            $Where="CodCupEle";
            $Resultado=$this->Reportes_model->generar_consumo_cups($CodPunSum,$Select,$Tabla,$Where,$CodCup);
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups2($CodCup,$Tabla,$Where);
                $objPHPExcel->getActiveSheet()->SetCellValue("A9", "PotCon1");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
                $objPHPExcel->getActiveSheet()->SetCellValue("B9", "PotCon2");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
                $objPHPExcel->getActiveSheet()->SetCellValue("C9", "PotCon3");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
                $objPHPExcel->getActiveSheet()->SetCellValue("D9", "PotCon4");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("E9", "PotCon5");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("F9", "PotCon6");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("G9", "Fecha Inicio");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("H9", "Fecha Final");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H9");
                 $objPHPExcel->getActiveSheet()->SetCellValue("I9", "Consumo");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I9");
                $fila=9;
                for($i=0; $i<count($Resultado); $i++) 
                {
                    $fila+=1;
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->PotCon1);
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->PotCon2);
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->PotCon3);
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->PotCon4);
                    $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $Resultado[$i]->PotCon5);
                    $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado[$i]->PotCon6);
                    $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado[$i]->FecIniCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $Resultado[$i]->FecFinCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $Resultado[$i]->ConCup);
                    $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:I$fila");  
                }
                $fila+=1;                
                $objPHPExcel->getActiveSheet()->SetCellValue("A$fila",'TOTAL CONSUMO:'); #$total_consumo->AcumConCup);
                $objPHPExcel->getActiveSheet()->SetCellValue("I$fila",$total_consumo->AcumConCup); #$total_consumo->AcumConCup);
                $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:I$fila");                
            }           
        }
        elseif ($TipServ=="Gas") 
        {
            $Select="DATE_FORMAT(FecIniCon,'%d-%m-%Y') as FecIniCon,DATE_FORMAT(FecFinCon,'%d-%m-%Y') as FecFinCon,ConCup";
            $Tabla="T_HistorialCUPsGas";
            $Where="CodCupGas";
            $Resultado=$this->Reportes_model->generar_consumo_cups($CodPunSum,$Select,$Tabla,$Where,$CodCup);
            if($Resultado!=false)
            {
                $total_consumo=$this->Reportes_model->sum_consumo_cups2($CodCup,$Tabla,$Where);
                $objPHPExcel->getActiveSheet()->SetCellValue("A9", "Fecha Inicio");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
                $objPHPExcel->getActiveSheet()->SetCellValue("B9", "Fecha Final");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
                $objPHPExcel->getActiveSheet()->SetCellValue("C9", "Consumo");
                $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
                $fila=9;
                for($i=0; $i<count($Resultado); $i++) 
                {
                    $fila+=1;
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->FecIniCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->FecFinCon);
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->ConCup);
                    $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:C$fila");  
                }
                $fila+=1;                
                $objPHPExcel->getActiveSheet()->SetCellValue("A$fila",'TOTAL CONSUMO:'); 
                $objPHPExcel->getActiveSheet()->SetCellValue("C$fila",$total_consumo->AcumConCup);
                $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:C$fila");                
            } 
        }             
        $objPHPExcel->getActiveSheet()->SetCellValue("D2", "FECHA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D2");
        $objPHPExcel->getActiveSheet()->SetCellValue("D3", "HORA:");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "D3");
        $objPHPExcel->getActiveSheet()->SetCellValue("E2", date('d/m/Y'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E2");
        $objPHPExcel->getActiveSheet()->SetCellValue("E3", date('G:i:s'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "E3");
        foreach (range('A', 'I') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(30);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),$Tabla,'GET',NULL,$this->input->ip_address(),'GENERANDO REPORTE EXCEL GESTIONAR CONSUMO CUPS '.$TipServ);
        $objWriter->save('php://output');
        exit;   
    } 
    public function Doc_PDF_Clientes_x_Colaboradores()
    {
        
        $CodCol = urldecode($this->uri->segment(4));   
        $Resultado=$this->Reportes_model->get_clientes_x_colaborador($CodCol);
          
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Lista de Colaboradores PDF '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Doc_PDF_Colaboradores');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h4 align="left">'.TITULO.'</h4>';        
        $html.='<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped"  >
            <tr>
                <td border="0" align="left" colspan="3"><h4>LISTADO DE CLIENTES POR COLABORADOR</h4></td>
                
                <td border="0" >FECHA: '.date('d/m/Y').'</td>
            </tr>
            <tr>
                <td border="0" align="left">Colaborador Consultado:</td>
                <td border="0" colspan="2">'.$Resultado[0]->NomCol.'</td>
                
                <td border="0" >HORA: '.date('G:i:s').'</td>
            </tr>'
            ;           
        $html .= '</table>' ;        
        $html.='<br><br><br><br><br><br><table width="100%" border="1" celpadding="0" cellspacing="0" align="center" class="table table-bordered table-striped">';
        $html.='
        <tr bgcolor="#636161">
            <td style="color:white;">NOMBRE</td>
            <td style="color:white;">CIF/NIF</td>
            <td style="color:white;">RAZÓN SOCIAL</td>
            <td style="color:white;">CUPS</td>
            <td style="color:white;">DIRECCION FISCAL</td>
            <td style="color:white;">EMAIL</td>
            <td style="color:white;">TELÉFONO</td>
        </tr>';
        if($Resultado!=false)
        {

            foreach ($Resultado as $record): 
            {
                //VAR_DUMP($record->NomViaDomFis);
                $CONCATENADA = $record->NomViaDomFis+ ' '+$record->NumViaDomFis+' '+$record->BloDomFis+' '
                +$record->EscDomFis+' '+$record->PlaDomFis+' '+$record->PueDomFis+' '+$record->DesLocFis;
                
                $DIRECCION = ($record->DireccionBBDD!='') ? $record->DireccionBBDD : $CONCATENADA;
                $html.='<tr>
                        <td>'.$record->NomComCli.'</td>
                        <td>'.$record->NumCifCli.'</td>
                        <td>'.$record->RazSocCli.'</td>
                        <td>'.$record->Cups.'</td>
                        <td>'.$DIRECCION.'</td>
                        <td>'.$record->EmaCli.'</td>
                        <td>'.$record->TelFijCli.'</td>
                    </tr>';     
                }
                endforeach;
            }
            else
            {
                $html.='
                <tr>
                <td align="center" colspan="9"><b>No existen datos registrados</b></td>              
                </tr>'; 
            }   
        $html .= '</table>' ;
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',0,$this->input->ip_address(),'GENERANDO REPORTE PDF COLABORADORES FILTRADOS');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Doc_PDF_Clientes_x_Colaboradores'.'.pdf', 'I');
    }

    public function Doc_Excel_Clientes_x_Colaboradores()
    {       
        $CodCol = urldecode($this->uri->segment(4));   
        $Resultado=$this->Reportes_model->get_clientes_x_colaborador($CodCol);
        
        
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize'  => '15MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $datausuario=$this->session->all_userdata();    
        $fecha= date('Y-m-d_H:i:s');        
        $nombre_reporte='Doc_Excel_Colaboradores_'.$fecha.".xls";
        $objPHPExcel = new PHPExcel(); //nueva instancia         
        $objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
        $objPHPExcel->getProperties()->setTitle("Doc Excel Colaboradores"); //titulo 
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo2 = new PHPExcel_Style(); //nuevo estilo
        $titulo3 = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte = new PHPExcel_Style(); //nuevo estilo
        $titulo_reporte->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 16,
                'name'=>'Arial',
                //'color'=>array('rgb'=>'ffffff')
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //'color' => array('rgb' => '7a7a7a')
              )
          ));   
        $titulo3->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 10,
                'name'=>'Arial','color'=>array('rgb'=>'ffffff')
              ),'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
              ),'fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '7a7a7a')
              )
          ));
          $sin_bordes = new PHPExcel_Style(); //nuevo estilo
          $sin_bordes->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              ),
              'font' => array( //fuente               
                'size' => 12,
                'name'=>'Arial',
              )
          ));
        $titulo2->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              ),
              'font' => array( //fuente
                'bold' => true,
                'size' => 20,'name'=>'Arial'
              )
          ));   
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20,'name'=>'Arial'
            )
        ));      
        $subtitulo = new PHPExcel_Style(); //nuevo estilo        
        $subtitulo->applyFromArray(
          array('font' => array( //fuente
           'name'=>'Arial','size' => 12,
          ),'fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              //'color' => array('rgb' => '7a7a7a')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )); 
        $bordes = new PHPExcel_Style(); //nuevo estilo
        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Colaboradores"); 
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);      
        $margin = 0.5 / 2.54; 
        $marginBottom = 1.2 / 2.54;
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_destock.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
        $objPHPExcel->getActiveSheet()->mergeCells("A5:C5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($sin_bordes, "A5:C5");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "LISTADO DE COLABORADORES");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo_reporte, "A6:C6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("A9", "NOMBRE");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A9");
        $objPHPExcel->getActiveSheet()->SetCellValue("B9", "CIF/NIF");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B9");
        $objPHPExcel->getActiveSheet()->SetCellValue("C9", "RAZÓN SOCIAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C9");
        $objPHPExcel->getActiveSheet()->SetCellValue("D9", "CUPS");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D9");
        $objPHPExcel->getActiveSheet()->SetCellValue("E9", "DIRECCIÓN");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E9");
        $objPHPExcel->getActiveSheet()->SetCellValue("F9", "EMAIL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F9");
        $objPHPExcel->getActiveSheet()->SetCellValue("G9", "TELÉFONO");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G9");
        $fila=9;
        for($i=0; $i<count($Resultado); $i++) 
        {
            $CONCATENADA = $Resultado[$i]->NomViaDomFis+ ' '+$Resultado[$i]->NumViaDomFis+' '+$Resultado[$i]->BloDomFis+' '
            +$Resultado[$i]->EscDomFis+' '+$Resultado[$i]->PlaDomFis+' '+$Resultado[$i]->PueDomFis+' '+$Resultado[$i]->DesLocFis;
            
            $DIRECCION = ($Resultado[$i]->DireccionBBDD!='') ? $Resultado[$i]->DireccionBBDD : $CONCATENADA;
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Resultado[$i]->NomComCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Resultado[$i]->NumCifCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Resultado[$i]->RazSocCli);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $Resultado[$i]->Cups);
            $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $DIRECCION);
            $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $Resultado[$i]->EmaCli);            
            $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $Resultado[$i]->TelFijCli);
            $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:G$fila");  
        } 
        $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Colaborador Consultado:");
        $objPHPExcel->getActiveSheet()->SetCellValue("B7", $Resultado[0]->NomCol);

        foreach (range('A', 'G') as $columnID) 
        {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename='.$nombre_reporte.'');        
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Colaborador','GET',0,$this->input->ip_address(),'GENERANDO REPORTE EXCEL COLABORADORES FILTRADOS');
        $objWriter->save('php://output');
        exit;   
    }
     public function Doc_Propuesta_Comercial_Cliente_PDF()
    {
        $nombre_filtro=null;
        $Tipo_Cliente=null;
        $Resultado_PropuestaComercial=false;
        $pdf = new TCPDF ('P','mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Propuesta Comercial '.date('d/m/Y'));
        $pdf->SetAuthor(TITULO);        
        $pdf->SetSubject('Propuesta Comercial');
        $pdf->SetHeaderData(PDF_HEADER_LOGO,80);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15 , 30 ,15 ,true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', ' ', 10, ' ', true);
        $pdf->AddPage();        
        $html  = '<style>table{ padding:6px;}.borde{ border:1px solid #4D4D4D; }.edoTable{border-top:1px solid #7F7F7F;border-left:1px solid #7F7F7F;border-right:1px solid #7F7F7F;border-bottom:1px solid #7F7F7F;}br{line-height:5px;}</style>';     
        $html .= '<h1 align="center">Propuesta Comercial</h1>';
        $html .= '<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped">  
        <tr>
            <td border="0" align="left" colspan="4">Propuesta Nº: </td>
            <td border="0" colspan="1">Fecha: '.date('d/m/Y').'</td>
        </tr>
        </table>'; 

        $html .= '<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped">  
        <tr bgcolor="#636161">
            <td style="color:white;" align="center"><b>DATOS DEL CLIENTE</b></td>            
        </tr>
        </table>'; 


         $html .= '<table width="100%" border="0"   celpadding="0" cellspacing="0" class="table table-bordered table-striped">  
        <tr>
            <td border="1" colspan="3">Razón Social: </td>
            <td border="1" colspan="2">CIF: '.date('d/m/Y').'</td> 
        </tr>
        </table>'; 
       
/*<tr bgcolor="#636161">
            <td style="color:white;">CLIENTES</td>
            <td style="color:white;">BANCO</td> 
            <td style="color:white;">IBAN</td>
            <td style="color:white;">ESTATUS</td>
        </tr>'*/


        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_PropuestaComercial','GET',null,$this->input->ip_address(),'GENERANDO REPORTE PDF PROPUESTA COMERCIAL');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->lastPage();
        $pdf->Output('Propuesta Comercial'.'.pdf', 'I');
    }

}?>