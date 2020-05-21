<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH. 'third_party/fpdf/fpdf.php');
//require(APPPATH. 'third_party/FPDI/src/Fpdi.php');
header('Content-Type: text/html; charset=utf-8');

class Exportar_Contratos extends CI_Controller
{
    public $encabezadoreporte = null;
	public $piepaginareporte = null;	
	function __construct()
	{
		parent::__construct(); 
        $this->load->model('Reportes_model'); 
        $this->load->model('Auditoria_model');
        $this->load->model('Contratos_model');
        $this->load->model('Propuesta_model'); 	
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
        echo 'Este módulo muestra los Reportes en formato PDF Audax';
        echo '<br>';
        echo '<b>Datos de Conexión al Servidor:</b>';
        echo '<br>';
        echo 'Tu Dirección IP es: '.$this->input->ip_address().' <br><b>Cookie:</b>'.$cookie_sesion;
        echo '<br>';
        echo '<b>Sistema Operativo:</b> '. $os.' Con el <b>Navegador:</b> '.$agent.' <b>Versión:</b> '.$version;
        echo '<br>';
    }

    public function Contrato_Comercial_Audax_PDF($CodCli,$CodConCom,$CodProCom)
    {
        /*$pdf = new FPDF();
        $pageCount = $pdf -> setSourceFile('storage/pdf/yoigo/Yoigo001.pdf');
        $pdf->addPage();*/
        $pdf=new FPDF();
        //Column titles
        $header=array('Day','Date','Job Code','Hours');
        //Data loading
        //$pdf->SetSourceFile("businesscard.pdf");
        $data=false;
        $fname2="No es Tu Peo";
        $lname2="No es Tu Peo";
        $wending='culo';
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Weekly Timesheet');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,100, "Employee: " . $fname2 . " " . $lname2,1,0,'');
        $pdf->Cell(40,10, "Week Ending: " . $wending,1,1,'');
        $pdf->SetFont('Arial','',14);
        //$pdf->FancyTable($header,$data);
        $pdf->Output();
            
    }   



}?>