<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
			//Page header
			public $titulo1 = null;
			public $titulo2 = null;
			public $titulo3 = null;
			public $titulo4 = null;
			public $usuario=  null;
			/*se usa esta variable para indicar el nombre del reporte y automatizar el footer de firmas, en función a configuración de base de datos
			en la table llamada tblfirmas*/
			public $nombrereporte = null;
			public $firmas = null;

		public function Header() {
			// Logo
			$this->SetCreator(PDF_CREATOR);
			$this->SetAuthor('SomosTuWebMaster.es');
			$this->SetTitle('Eadic, Escuela Tecnica');
			$this->SetSubject('Reportes');
			
			
			//$image_file = '../eadic/application/img/'.PDF_HEADER_LOGO;
			$this->Image($image_file, 10, 10, 120, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			//$image_file2 = '../eadic/application/img/logo_derecho.jpg';
			$this->Image($image_file2, 225, 10, 50,10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			// set margins
			$this->SetHeaderMargin(PDF_MARGIN_HEADER);
			$this->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$this->setFontSubsetting(true);
			$this->SetFont('helvetica', ' ', 7, ' ', true);
			
		}
		// Page footer
		
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			$fecha=date("d/m/Y");
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,10, 'Impreso por '.$this->usuario, 0, false, 'R', 0, '', 0, false, 'T', 'M');
				
				
		}
}
?>