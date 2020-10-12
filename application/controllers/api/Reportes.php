<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
require(APPPATH. 'third_party/PHPExcel.php');
require(APPPATH. 'third_party/PHPExcel/IOFactory.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Reportes extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
        $this->load->model('Propuesta_model');
        $this->load->model('Contratos_model');
        $this->load->model('Clientes_model');
		$this->load->model('Reportes_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301); 
		}
    }
    /////////////// PARA TIPO CLIENTE START/////
    public function Proyeccion_Ingresos_post()
    {
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize'  => '15MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();

		$fecha= date('Y-m-d_H:i:s');	
		$nombre_reporte='Proyección de Ingresos '.$objSalida->ano.' '.$fecha.".reporte.xls";
		$objSalida->nombre_reporte=$nombre_reporte;
		$objPHPExcel = new PHPExcel(); //nueva instancia		 
		$objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
		$objPHPExcel->getProperties()->setTitle("Doc Excel Proyección de Ingresos"); //titulo				 
		//inicio estilos
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
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Proyección de Ingresos"); 
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
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_desktop.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()->mergeCells("A1:D4"));
        $objPHPExcel->getActiveSheet()->SetCellValue("E1", 'Proyección de Ingresos - Año '.$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E1:AB4");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "E1:AB4");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6); 
            
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", "Comercializadora");
        $objPHPExcel->getActiveSheet()->mergeCells("A5:A6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A5:A6");

        $objPHPExcel->getActiveSheet()->SetCellValue("B5", "Producto");
        $objPHPExcel->getActiveSheet()->mergeCells("B5:B6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B5:B6");

        $objPHPExcel->getActiveSheet()->SetCellValue("C5", "Anexo");
        $objPHPExcel->getActiveSheet()->mergeCells("C5:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C5:C6");

        $objPHPExcel->getActiveSheet()->SetCellValue("D5", "Tipo Suministro");
        $objPHPExcel->getActiveSheet()->mergeCells("D5:D6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D5:D6");


        $objPHPExcel->getActiveSheet()->SetCellValue("E5", "Ene-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E5:F5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E5:F6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("E6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "E6");
        $objPHPExcel->getActiveSheet()->SetCellValue("F6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "F6");

        
        $objPHPExcel->getActiveSheet()->SetCellValue("G5", "Feb-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("G5:H5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G5:H6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("G6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "G6");
        $objPHPExcel->getActiveSheet()->SetCellValue("H6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "H6");

        $objPHPExcel->getActiveSheet()->SetCellValue("I5", "Mar-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("I5:J5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I5:J6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("I6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "I6");
        $objPHPExcel->getActiveSheet()->SetCellValue("J6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "J6");

        $objPHPExcel->getActiveSheet()->SetCellValue("K5", "Abr-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("K5:L5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K5:L6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("K6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "K6");
        $objPHPExcel->getActiveSheet()->SetCellValue("L6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "L6");

        $objPHPExcel->getActiveSheet()->SetCellValue("M5", "May-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("M5:N5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M5:N6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("M6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "M6");
        $objPHPExcel->getActiveSheet()->SetCellValue("N6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "N6");

        $objPHPExcel->getActiveSheet()->SetCellValue("O5", "Jun-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("O5:P5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O5:P6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("O6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "O6");
        $objPHPExcel->getActiveSheet()->SetCellValue("P6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "P6");

        $objPHPExcel->getActiveSheet()->SetCellValue("Q5", "Jul-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Q5:R5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q5:R6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("Q6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Q6");
        $objPHPExcel->getActiveSheet()->SetCellValue("R6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "R6");

        
        $objPHPExcel->getActiveSheet()->SetCellValue("S5", "Ago-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("S5:T5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S5:T6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("S6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "S6");
        $objPHPExcel->getActiveSheet()->SetCellValue("T6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "T6");

        $objPHPExcel->getActiveSheet()->SetCellValue("U5", "Sep-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("U5:V5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U5:V6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("U6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "U6");
        $objPHPExcel->getActiveSheet()->SetCellValue("V6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "V6");

        $objPHPExcel->getActiveSheet()->SetCellValue("W5", "Oct-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("W5:X5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W5:X6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("W6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "W6");
        $objPHPExcel->getActiveSheet()->SetCellValue("X6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "X6");

        $objPHPExcel->getActiveSheet()->SetCellValue("Y5", "Nov-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Y5:Z5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y5:Z6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("Y6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Y6");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Z6");

        $objPHPExcel->getActiveSheet()->SetCellValue("AA5", "Dic-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("AA5:AB5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA5:AB6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AA6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AA6");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AB6");

        $objPHPExcel->getActiveSheet()->SetCellValue("AC5", "Total Anual");
        $objPHPExcel->getActiveSheet()->mergeCells("AC5:AD5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC5:AD6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AC6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AC6");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD6", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AD6");     

        $objPHPExcel->getActiveSheet()->getStyle('A5:AD5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $fila=0;		
		$Contratos= $this->Reportes_model->Proyeccion_Ingresos($objSalida->ano);
		if(empty($Contratos))
		{     
            $fila=7;
			$objPHPExcel->getActiveSheet()->SetCellValue("A7", "Sin Datos Disponibles.");
            $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A7");
        	$objPHPExcel->getActiveSheet()->mergeCells("A7:Z7");
        	$objPHPExcel->getActiveSheet()->getStyle('A7:Z7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			
            $fila=6;
			for($i=0; $i<count($Contratos); $i++) 
			{
				$fila+=1;
				if($Contratos[$i]->SerGas=='NO' && $Contratos[$i]->SerEle=='SI')
				{$TipoSuministro='Eléctrico';}
				elseif ($Contratos[$i]->SerGas=='SI' && $Contratos[$i]->SerEle=='NO'){
					$TipoSuministro='Gas';}
				elseif($Contratos[$i]->SerGas=='SI' && $Contratos[$i]->SerEle=='SI'){
					$TipoSuministro='Ambos';}				
				else{$TipoSuministro='N/A';}
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Contratos[$i]->NomComCom);
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Contratos[$i]->DesPro);
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Contratos[$i]->DurCon.' Meses '/*.$Contratos[$i]->NomTarEle.' '.$Contratos[$i]->NomTarGas*/);
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $TipoSuministro);
			}
		}
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Acumulado Mensual");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "L$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("N$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "N$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("P$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "P$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("R$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "R$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("T$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "T$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("V$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "V$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("X$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "X$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Z$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AB$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AD$fila");
		//insertar formula
		/*$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/		 
		//recorrer las columnas
        $objSalida->fila=$fila;
		foreach(range('A5','Z5') as $columnID)
		{
		    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		 
		//establecer pie de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
		 
		//*************Guardar como excel 2003*********************************
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //Escribir archivo
		 
		// Establecer formado de Excel 2003
		header("Content-Type: application/vnd.ms-excel");
		 
		// nombre del archivo
		header('Content-Disposition: attachment; filename="'.$nombre_reporte.'"');
		//**********************************************************************		 
		//****************Guardar como excel 2007*******************************
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
		//
		//// Establecer formado de Excel 2007
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//
		//// nombre del archivo
		//header('Content-Disposition: attachment; filename="informe asistencia.xlsx"');
		//**********************************************************************
		//forzar a descarga por el navegador
		$objWriter->save('documentos/reportes/'.$nombre_reporte);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contratos','POST',null,$this->input->ip_address(),'GENERANDO REPORTE PROYECCIÓN DE INGRESOS');
		$this->db->trans_complete();		
		$this->response($objSalida);
		exit;	
    }
    public function Ingresos_Reales_post()
    {
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize'  => '15MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();

		$fecha= date('Y-m-d_H:i:s');	
		$nombre_reporte='Ingresos Reales '.$objSalida->ano.' '.$fecha.".reporte.xls";
		$objSalida->nombre_reporte=$nombre_reporte;
		$objPHPExcel = new PHPExcel(); //nueva instancia		 
		$objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
		$objPHPExcel->getProperties()->setTitle("Doc Excel Ingresos Reales ".$objSalida->ano); //titulo				 
		//inicio estilos
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
        $objPHPExcel->getActiveSheet()->setTitle("Doc Excel Ingresos Reales ".$objSalida->ano); 
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
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_desktop.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()->mergeCells("A1:D4"));
        $objPHPExcel->getActiveSheet()->SetCellValue("E1", 'Ingresos Generales - Año '.$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E1:AB4");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "E1:AB4");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6); 
            
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", "GESTIÓN DE CONTRATOS");
        $objPHPExcel->getActiveSheet()->mergeCells("A5:AD5");
        
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A5:AD5");
        $objPHPExcel->getActiveSheet()->SetCellValue("A6", "Comercializadora");
        $objPHPExcel->getActiveSheet()->mergeCells("A6:A7");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A6:A7");
        $objPHPExcel->getActiveSheet()->SetCellValue("B6", "Producto");
        $objPHPExcel->getActiveSheet()->mergeCells("B6:B7");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B6:B7");
        $objPHPExcel->getActiveSheet()->SetCellValue("C6", "Anexo");
        $objPHPExcel->getActiveSheet()->mergeCells("C6:C7");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C6:C7");

        $objPHPExcel->getActiveSheet()->SetCellValue("D6", "Tipo Suministro");
        $objPHPExcel->getActiveSheet()->mergeCells("D6:D7");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D6:D7");

        $objPHPExcel->getActiveSheet()->SetCellValue("E6", "Ene-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E6:F6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E6:F6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("E7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "E7");
        $objPHPExcel->getActiveSheet()->SetCellValue("F7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "F7");
        
        $objPHPExcel->getActiveSheet()->SetCellValue("G6", "Feb-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("G6:H6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G6:H6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("G7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "G7");
        $objPHPExcel->getActiveSheet()->SetCellValue("H7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "H7");

        $objPHPExcel->getActiveSheet()->SetCellValue("I6", "Mar-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("I6:J6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I6:J6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("I7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "I7");
        $objPHPExcel->getActiveSheet()->SetCellValue("J7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "J7");

        $objPHPExcel->getActiveSheet()->SetCellValue("K6", "Abr-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("K6:L6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K6:L6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("K7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "K7");
        $objPHPExcel->getActiveSheet()->SetCellValue("L7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "L7");

        $objPHPExcel->getActiveSheet()->SetCellValue("M6", "May-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("M6:N6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M6:N6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("M7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "M7");
        $objPHPExcel->getActiveSheet()->SetCellValue("N7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "N7");

        $objPHPExcel->getActiveSheet()->SetCellValue("O6", "Jun-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("O6:P6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O6:P6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("O7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "O7");
        $objPHPExcel->getActiveSheet()->SetCellValue("P7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "P7");

        $objPHPExcel->getActiveSheet()->SetCellValue("Q6", "Jul-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Q6:R6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q6:R6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("Q7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Q7");
        $objPHPExcel->getActiveSheet()->SetCellValue("R7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "R7");
       
        $objPHPExcel->getActiveSheet()->SetCellValue("S6", "Ago-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("S6:T6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S6:T6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("S7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "S7");
        $objPHPExcel->getActiveSheet()->SetCellValue("T7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "T7");

        $objPHPExcel->getActiveSheet()->SetCellValue("U6", "Sep-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("U6:V6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U6:V6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("U7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "U7");
        $objPHPExcel->getActiveSheet()->SetCellValue("V7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "V7");

        $objPHPExcel->getActiveSheet()->SetCellValue("W6", "Oct-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("W6:X6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W6:X6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("W7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "W7");
        $objPHPExcel->getActiveSheet()->SetCellValue("X7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "X7");

        $objPHPExcel->getActiveSheet()->SetCellValue("Y6", "Nov-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Y6:Z6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y6:Z6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("Y7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Y7");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Z7");

        $objPHPExcel->getActiveSheet()->SetCellValue("AA6", "Dic-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("AA6:AB6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA6:AB6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AA7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AA7");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AB7");

        $objPHPExcel->getActiveSheet()->SetCellValue("AC6", "Total Anual");
        $objPHPExcel->getActiveSheet()->mergeCells("AC6:AD6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC6:AD6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AC7", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AC7");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD7", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AD7");        //$objPHPExcel->getActiveSheet()->getStyle('A6:AD6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $fila=0;
        $fila1=0;		
		$Contratos=$this->Reportes_model->Proyeccion_Ingresos($objSalida->ano);
		if(empty($Contratos))
		{
			$fila=8;
            $fila1=9;
            $objPHPExcel->getActiveSheet()->SetCellValue("A8", "Sin Datos Disponibles.");
        	$objPHPExcel->getActiveSheet()->mergeCells("A8:AD8");
            $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A8:AD8");
        	 $objPHPExcel->getActiveSheet()->getStyle('A8:AD8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$fila=7;
			$fila1=8;
			for($i=0; $i<count($Contratos); $i++) 
			{
				$fila+=1;
				$fila1+=1;
				if($Contratos[$i]->SerGas=='NO' && $Contratos[$i]->SerEle=='SI')
				{$TipoSuministro='Eléctrico';}
				elseif ($Contratos[$i]->SerGas=='SI' && $Contratos[$i]->SerEle=='NO'){
					$TipoSuministro='Gas';}
				elseif($Contratos[$i]->SerGas=='SI' && $Contratos[$i]->SerEle=='SI'){
					$TipoSuministro='Ambos';}				
				else{$TipoSuministro='N/A';}
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Contratos[$i]->NomComCom);
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Contratos[$i]->DesPro);
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Contratos[$i]->DurCon.' Meses '/*.$Contratos[$i]->NomTarEle.' '.$Contratos[$i]->NomTarGas*/);
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $TipoSuministro);
			}
		}
        $fila+=1;
		$fila1+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Acumulado Mensual");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "L$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("N$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "N$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("P$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "P$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("R$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "R$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("T$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "T$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("V$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "V$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("X$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "X$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Z$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AB$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AD$fila");
        
        $fila+=2;
        $fila1+=1;
        
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "OTRAS GESTIONES");
        $objPHPExcel->getActiveSheet()->mergeCells("A$fila:AD$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila:AD$fila");
		
		$fila+=1;
		$fila1+=1;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Tipo de Gestión");
        $objPHPExcel->getActiveSheet()->mergeCells("A$fila:A$fila1");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila:A$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", "Descripción");
        $objPHPExcel->getActiveSheet()->mergeCells("B$fila:D$fila1");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila:D$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", "Ene-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E$fila:F$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E$fila:F$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "E$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "F$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", "Feb-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("G$fila:H$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G$fila:H$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "G$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("H$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "H$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", "Mar-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("I$fila:J$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I$fila:J$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "I$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("J$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "J$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", "Abr-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("K$fila:L$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K$fila:L$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "K$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "L$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "May-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("M$fila:N$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M$fila:N$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "M$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("N$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "N$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila", "Jun-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("O$fila:P$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O$fila:P$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "O$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("P$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "P$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", "Jul-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Q$fila:R$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q$fila:R$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Q$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("R$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "R$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila", "Ago-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("S$fila:T$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S$fila:T$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "S$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("T$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "T$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila", "Sep-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("U$fila:V$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U$fila:V$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "U$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("V$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "V$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila", "Oct-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("W$fila:X$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W$fila:X$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "W$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("X$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "X$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila", "Nov-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Y$fila:Z$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y$fila:Z$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Y$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Z$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila", "Dic-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("AA$fila:AB$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA$fila:AB$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AA$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AB$fila1");

        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila", "Total Anual");
        $objPHPExcel->getActiveSheet()->mergeCells("AC$fila:AD$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC$fila:AD$fila");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila1", "Renovaciones");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AC$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila1", "Ingreso Bruto");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AD$fila1");    
		
        ##### REPARAR SUPERSQL PARA ESTA CONSULTA #####
        $OtrasGestiones=$this->Reportes_model->Otras_Gestiones($objSalida->ano);
        if(empty($OtrasGestiones))
        {
            $fila1+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila1", "Sin Datos Disponibles.");
            $objPHPExcel->getActiveSheet()->mergeCells("A$fila1:AD$fila1");
            $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila1:AD$fila1");
        }
        else
        {
            for($i=0; $i<count($OtrasGestiones); $i++) 
            {
                $fila1+=1;
                if($OtrasGestiones[$i]->SerGas=='NO' && $OtrasGestiones[$i]->SerEle=='SI')
                {$TipoSuministro='Eléctrico';}
                elseif ($OtrasGestiones[$i]->SerGas=='SI' && $OtrasGestiones[$i]->SerEle=='NO'){
                    $TipoSuministro='Gas';}
                elseif($OtrasGestiones[$i]->SerGas=='SI' && $OtrasGestiones[$i]->SerEle=='SI'){
                    $TipoSuministro='Ambos';}               
                else{$TipoSuministro='N/A';}
                $objPHPExcel->getActiveSheet()->SetCellValue("A$fila1", $OtrasGestiones[$i]->NomComCom);
                $objPHPExcel->getActiveSheet()->SetCellValue("B$fila1", $OtrasGestiones[$i]->DesPro);
                $objPHPExcel->getActiveSheet()->mergeCells("B$fila1:D$fila1");
                
            }
        }        
        $objSalida->Contratos=$Contratos;
        $objSalida->OtrasGestiones=$OtrasGestiones;
		$fila+=1;
		$fila1+=1;

		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila1", "Acumulado Mensual");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("C$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("D$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("H$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("J$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "L$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("N$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "N$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("P$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "P$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("R$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "R$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("T$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "T$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("V$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "V$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("X$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "X$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Z$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AB$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AD$fila1");		
		$fila1+=2;

		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila1", "TOTAL GENERAL");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila1");       

        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila1");        
        $objPHPExcel->getActiveSheet()->mergeCells("B$fila1:D$fila1");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila1:D$fila1");        

        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("H$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("J$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "L$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("N$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "N$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("P$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "P$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("R$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "R$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("T$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "T$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("V$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "V$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("X$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "X$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Z$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AB$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC$fila1");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila1", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AD$fila1");
		
        //insertar formula
		/*$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/		 
		//recorrer las columnas
        $objSalida->fila=$fila;
        $objSalida->fila1=$fila1;
		foreach(range('A','Z') as $columnID)
		{
		    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		 
		//establecer pie de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
		 
		//*************Guardar como excel 2003*********************************
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //Escribir archivo
		 
		// Establecer formado de Excel 2003
		header("Content-Type: application/vnd.ms-excel");
		 
		// nombre del archivo
		header('Content-Disposition: attachment; filename="'.$nombre_reporte.'"');
		//**********************************************************************		 
		//****************Guardar como excel 2007*******************************
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
		//
		//// Establecer formado de Excel 2007
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//
		//// nombre del archivo
		//header('Content-Disposition: attachment; filename="informe asistencia.xlsx"');
		//**********************************************************************
		//forzar a descarga por el navegador
		$objWriter->save('documentos/reportes/'.$nombre_reporte);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contratos','POST',null,$this->input->ip_address(),'GENERANDO REPORTE PROYECCIÓN DE INGRESOS');
		$this->db->trans_complete();		
		$this->response($objSalida);
		exit;	
    }
    public function Proyectado_Vs_Reales_post()
    {
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize'  => '15MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();

		$fecha= date('Y m d H:i:s');	
		$nombre_reporte='Comparación Ingresos Proyectados vs Reales '.$objSalida->ano.' '.$fecha.".reporte.xls";
		$objSalida->nombre_reporte=$nombre_reporte;
		$objPHPExcel = new PHPExcel(); //nueva instancia		 
		$objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
		$objPHPExcel->getProperties()->setTitle("Comparación Ingresos Proyectados vs Reales"); //titulo				 
		//inicio estilos
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
        $objPHPExcel->getActiveSheet()->setTitle("Comparación Ingresos Proyectados vs Reales"); 
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
        $objDrawing->setPath('application/libraries/estilos/img/logo_web_desktop.png');
        $objDrawing->setHeight(75);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()->mergeCells("A1:D4"));
        $objPHPExcel->getActiveSheet()->SetCellValue("E1", 'Comparación Ingresos Proyectados vs Reales - Año '.$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E1:AB4");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "E1:AB4");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);        
        
            
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", "Comercializadora");
        $objPHPExcel->getActiveSheet()->mergeCells("A5:A6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A5:A6");

        $objPHPExcel->getActiveSheet()->SetCellValue("B5", "Producto");
        $objPHPExcel->getActiveSheet()->mergeCells("B5:B6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B5:B6");

        $objPHPExcel->getActiveSheet()->SetCellValue("C5", "Anexo");
        $objPHPExcel->getActiveSheet()->mergeCells("C5:C6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C5:C6");

        $objPHPExcel->getActiveSheet()->SetCellValue("D5", "Tipo Suministro");
        $objPHPExcel->getActiveSheet()->mergeCells("D5:D6");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D5:D6");


        $objPHPExcel->getActiveSheet()->SetCellValue("E5", "Ene-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("E5:F5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E5:F6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("E6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "E6");
        $objPHPExcel->getActiveSheet()->SetCellValue("F6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "F6");

        
        $objPHPExcel->getActiveSheet()->SetCellValue("G5", "Feb-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("G5:H5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G5:H6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("G6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "G6");
        $objPHPExcel->getActiveSheet()->SetCellValue("H6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "H6");

        $objPHPExcel->getActiveSheet()->SetCellValue("I5", "Mar-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("I5:J5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I5:J6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("I6", "Ren");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "I6");
        $objPHPExcel->getActiveSheet()->SetCellValue("J6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "J6");

        $objPHPExcel->getActiveSheet()->SetCellValue("K5", "Abr-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("K5:L5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K5:L6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("K6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "K6");
        $objPHPExcel->getActiveSheet()->SetCellValue("L6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "L6");

        $objPHPExcel->getActiveSheet()->SetCellValue("M5", "May-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("M5:N5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M5:N6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("M6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "M6");
        $objPHPExcel->getActiveSheet()->SetCellValue("N6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "N6");

        $objPHPExcel->getActiveSheet()->SetCellValue("O5", "Jun-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("O5:P5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O5:P6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("O6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "O6");
        $objPHPExcel->getActiveSheet()->SetCellValue("P6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "P6");

        $objPHPExcel->getActiveSheet()->SetCellValue("Q5", "Jul-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Q5:R5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q5:R6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("Q6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Q6");
        $objPHPExcel->getActiveSheet()->SetCellValue("R6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "R6");

        
        $objPHPExcel->getActiveSheet()->SetCellValue("S5", "Ago-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("S5:T5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S5:T6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("S6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "S6");
        $objPHPExcel->getActiveSheet()->SetCellValue("T6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "T6");

        $objPHPExcel->getActiveSheet()->SetCellValue("U5", "Sep-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("U5:V5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U5:V6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("U6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "U6");
        $objPHPExcel->getActiveSheet()->SetCellValue("V6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "V6");

        $objPHPExcel->getActiveSheet()->SetCellValue("W5", "Oct-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("W5:X5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W5:X6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("W6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "W6");
        $objPHPExcel->getActiveSheet()->SetCellValue("X6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "X6");

        $objPHPExcel->getActiveSheet()->SetCellValue("Y5", "Nov-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("Y5:Z5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y5:Z6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("Y6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Y6");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "Z6");

        $objPHPExcel->getActiveSheet()->SetCellValue("AA5", "Dic-".$objSalida->ano);
        $objPHPExcel->getActiveSheet()->mergeCells("AA5:AB5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA5:AB6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AA6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AA6");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AB6");

        $objPHPExcel->getActiveSheet()->SetCellValue("AC5", "Total Anual");
        $objPHPExcel->getActiveSheet()->mergeCells("AC5:AD5");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC5:AD6");        
        $objPHPExcel->getActiveSheet()->SetCellValue("AC6", "Proyectado");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AC6");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD6", "Real");
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "AD6");     

       $objPHPExcel->getActiveSheet()->getStyle('A5:AD5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);         
		
		//rellenar con contenido
		/*for ($i = 0; $i < 10; $i++) 
		{
		  $fila+=1;
		  $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Blog');
		  $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Kiuvox');
		 
		  //Establecer estilo
		  $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:B$fila");
		 
		}*/
		$Contratos= $this->Reportes_model->Proyeccion_Ingresos($objSalida->ano);
		if(empty($Contratos))
		{
			$fila=7;
            $objPHPExcel->getActiveSheet()->SetCellValue("A7", "Sin Datos Disponibles.");
        	$objPHPExcel->getActiveSheet()->mergeCells("A7:AD7");
            $objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A7:AD7");
        	
            $objPHPExcel->getActiveSheet()->getStyle('A7:AD7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$fila=6;
			for($i=0; $i<count($Contratos); $i++) 
			{
				$fila+=1;
				if($Contratos[$i]->SerGas=='NO' && $Contratos[$i]->SerEle=='SI')
				{$TipoSuministro='Eléctrico';}
				elseif ($Contratos[$i]->SerGas=='SI' && $Contratos[$i]->SerEle=='NO'){
					$TipoSuministro='Gas';}
				elseif($Contratos[$i]->SerGas=='SI' && $Contratos[$i]->SerEle=='SI'){
					$TipoSuministro='Ambos';}				
				else{$TipoSuministro='N/A';}
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $Contratos[$i]->NomComCom);
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $Contratos[$i]->DesPro);
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $Contratos[$i]->DurCon.' Meses '/*.$Contratos[$i]->NomTarEle.' '.$Contratos[$i]->NomTarGas*/);
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $TipoSuministro);
			}
		}
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Acumulado Mensual");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "A$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "B$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "C$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "D$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "E$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "F$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "G$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "H$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "I$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "J$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "K$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "L$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "M$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("N$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "N$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("O$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "O$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("P$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "P$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Q$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("R$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "R$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("S$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "S$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("T$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "T$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("U$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "U$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("V$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "V$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("W$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "W$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("X$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "X$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Y$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "Z$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AA$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AB$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AC$fila");
        $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila", "");
        $objPHPExcel->getActiveSheet()->setSharedStyle($titulo3, "AD$fila");
		//insertar formula
		/*$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/		 
		//recorrer las columnas
		foreach(range('A','Z') as $columnID)
		{
		    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		 
		//establecer pie de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
		 
		//*************Guardar como excel 2003*********************************
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //Escribir archivo
		 
		// Establecer formado de Excel 2003
		header("Content-Type: application/vnd.ms-excel");
		 
		// nombre del archivo
		header('Content-Disposition: attachment; filename="'.$nombre_reporte.'"');
		//**********************************************************************		 
		//****************Guardar como excel 2007*******************************
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
		//
		//// Establecer formado de Excel 2007
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//
		//// nombre del archivo
		//header('Content-Disposition: attachment; filename="informe asistencia.xlsx"');
		//**********************************************************************
		//forzar a descarga por el navegador
		$objWriter->save('documentos/reportes/'.$nombre_reporte);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contratos','POST',null,$this->input->ip_address(),'GENERANDO REPORTE Comparación Ingresos Proyectados vs Reales');
		$this->db->trans_complete();		
		$this->response($objSalida);
		exit;	
    }

    public function Fecha_Server_get()
    {
        $Desde=date("Y-m-d"); 
        $FecDesde=explode("-", $Desde);         
        $FecDesdeVol=$FecDesde[2]."/".$FecDesde[1]."/".$FecDesde[0];
        $actual = strtotime($Desde);
        $Hasta = date("Y-m-d", strtotime("+ 60 days", $actual));
        $FecHasta=explode("-", $Hasta);         
        $FecHastaVol=$FecHasta[2]."/".$FecHasta[1]."/".$FecHasta[0];
        $arrayName = array('FecDesde' =>$FecDesdeVol ,'FecHasta' =>$FecHastaVol);               
        $this->response($arrayName);
    }
    public function Generar_Rueda_post()
    {
        $datausuario=$this->session->all_userdata();    
        if (!isset($datausuario['sesion_clientes']))
        {
            redirect(base_url(), 'location', 301);
        }
        $objSalida = json_decode(file_get_contents("php://input"));             
        $this->db->trans_start();
        $ContratoComercial = $this->Reportes_model->Contratos_Para_Rueda($objSalida->FecDesde,$objSalida->FecHasta);
        if(empty($ContratoComercial))
        {
            $this->db->trans_complete();
            $this->response(false);
            return false;
        }
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','POST',null,$this->input->ip_address(),'Consultando Contratos Para Reporte Rueda.');
        $this->db->trans_complete();
        $this->response($ContratoComercial);
    }
    public function getContratosFilterRueda_post()
    {
        $datausuario=$this->session->all_userdata();    
        if (!isset($datausuario['sesion_clientes']))
        {
            redirect(base_url(), 'location', 301);
        }
        $objSalida = json_decode(file_get_contents("php://input"));             
        $this->db->trans_start();
        $consulta=$this->Reportes_model->Contratos_Para_Rueda_Filter($objSalida->FecDesde,$objSalida->FecHasta,$objSalida->filtrar_search);                       
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Contrato','SEARCH',null,$this->input->ip_address(),'Buscando Lista de Contratos Comerciales Filtrados');
        $this->db->trans_complete();
        $this->response($consulta);
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
        $Explode=explode("/", $objSalida->FecDesde);
        $FechaServer=$Explode[2]."-".$Explode[1]."-".$Explode[0]; 
        //var_dump($FechaServer);
        $diasAnticipacion=date("Y-m-d",strtotime($FechaServer."+ 60 days"));  
        //var_dump($diasAnticipacion);       
        $VerificarRenovacion=$this->Reportes_model ->validar_renovacion($objSalida->CodCli,$objSalida->CodConCom,$FechaServer,$diasAnticipacion);
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
        $this->db->trans_complete();
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
            $arrayName = array('status' =>200,'menssage'=>'Solicitud de Renovación de contrato con modificaciones solicitado. Sera Redireccionado Para Modificar la Propuesta Comercial.','statusText'=>'OK');
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
	
}
?>