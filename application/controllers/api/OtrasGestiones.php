<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class OtrasGestiones extends REST_Controller
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
		$response = array('status' =>200 ,'menssage' =>'Datos Encontrados','statusText'=>'OK','Cliente'=>$Cliente);		
		$this->response($response);
    }
    public function generarnuevagestion_get()
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
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',null,$this->input->ip_address(),'Número de CIF no Registrado.');
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Cliente','GET',$Cliente->CodCli,$this->input->ip_address(),'Número de CIF Encontrado.');
		$List_Gestiones = $this->Otrasgestiones_model->get_tipos_gestiones();    
		$newref=$this->generar_RefProCom();
		$fechagestion=date('d/m/Y');
		$response = array('status' =>200 ,'menssage' =>'Datos Encontrados.','statusText'=>'OK','Cliente'=>$Cliente,'List_Gestiones'=>$List_Gestiones,'n_gestion'=>$newref,'fechagestion'=>$fechagestion);		
		$this->response($response);
    }
    public function generar_RefProCom()
    {
    	$nCaracteresFaltantes = 0;
		$numero_a = " ";
		/*Ahora necesitamos el numero de la Referencia de la Propuesta*/
		$queryIdentificador = $this->db->query("SELECT CodMov,DesMov,NrMov FROM T_Movimientos WHERE CodMov=3");
		$rowIdentificador = $queryIdentificador->row();
		//buscamos que longitud tiene el numero generado por la base de datos y completamos con ceros a la izquierda
		$nCaracteresFaltantes = 12 - strlen($rowIdentificador->NrMov) ;
		$numero_a = str_repeat('0',$nCaracteresFaltantes);
		$numeroproximo = $rowIdentificador->NrMov + 1;
		$nCaracteresFaltantesC = 12 - strlen($rowIdentificador->NrMov); //VERIFICAR CUANDO PASE DE 100
		$numero_aC = str_repeat('0',$nCaracteresFaltantesC);
		$numeroproximoC = $rowIdentificador->NrMov + 1;
		$numeroC = $numero_aC . (string)$rowIdentificador->NrMov;
		$this->db->query("UPDATE T_Movimientos SET NrMov=".$numeroproximo." WHERE CodMov=3");
		return $numeroC;		
    }
    public function buscar_cups_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$TipCups=$this->get('TipCups');
		$CodCli=$this->get('CodCli');
		if($TipCups==0)
		{
			$tabla_PunSum="T_PuntoSuministro a";			
			$tabla_cups="T_CUPsElectrico b";
			$onCUps="a.CodPunSum=b.CodPunSum";
			$tabla_Dist="T_Distribuidora c";
			$onDist="b.CodDis=c.CodDist";
			$select="b.CUPsEle as CUPsNom,b.CodCupsEle as CodCups,c.RazSocDis";
			$where="a.CodCli";
			$orderby="CUPsEle DESC";
			$Cups=$this->Otrasgestiones_model->get_cups($tabla_PunSum,$tabla_cups,$onCUps,$tabla_Dist,$onDist,$select,$orderby,$where,$CodCli);
		}
		if($TipCups==1)
		{
			$tabla_PunSum="T_PuntoSuministro a";			
			$tabla_cups="T_CUPsGas b";
			$onCUps="a.CodPunSum=b.CodPunSum";
			$tabla_Dist="T_Distribuidora c";
			$onDist="b.CodDis=c.CodDist";
			$select="b.CupsGas as CUPsNom,b.CodCupGas as CodCups,c.RazSocDis";
			$where="a.CodCli";
			$orderby="CupsGas DESC";
			$Cups=$this->Otrasgestiones_model->get_cups($tabla_PunSum,$tabla_cups,$onCUps,$tabla_Dist,$onDist,$select,$orderby,$where,$CodCli);
		}		
		$response = array('status' =>200 ,'menssage' =>'Datos Encontrados.','statusText'=>'OK','Cups'=>$Cups);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla_cups,'GET',null,$this->input->ip_address(),'Buscando CUPs de Cliente');		
		$this->response($response);
    }
    public function generargestioncomercial_post()
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();

		$CodGesGen=$this->Otrasgestiones_model->save_gestion_comercial($objSalida->CodCli,$objSalida->FecGesGen,$objSalida->TipGesGen,$objSalida->RefGesGen,$objSalida->MecGesGen,$objSalida->EstGesGen,$objSalida->PreGesGen,$objSalida->CodCups,$objSalida->DesAnaGesGen,$objSalida->ObsGesGen,$objSalida->TipCups,$objSalida->NGesGen);
		$objSalida->CodGesGen=$CodGesGen;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_OtrasGestiones','INSERT',$CodGesGen,$this->input->ip_address(),'Creando Gestión Comercial');
		
		$response = array('status' =>200 ,'menssage' =>'Gestión Comercial Registrada Correctamente.','statusText'=>'OK','Gestion'=>$objSalida);
		$this->db->trans_complete();
		$this->response($response);
	}
	public function get_list_gestiones_comerciales_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$Gestiones = $this->Otrasgestiones_model->get_list_gestiones();        
		if (empty($Gestiones))
		{
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_OtrasGestiones','GET',null,$this->input->ip_address(),'No se encontraron gestiones registradas.');
			$this->response(false);
			return false;
		}
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_OtrasGestiones','GET',null,$this->input->ip_address(),'Obteniendo Lista de Gestiones Comerciales');	
		$this->response($Gestiones);
    }
    public function buscarXIDGesGenData_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$CodGesGen=$this->get('CodGesGen');
		
		//$response = array('status' =>200 ,'menssage' =>'Datos Encontrados.','statusText'=>'OK','Cups'=>$Cups);
		$this->Auditoria_model->agregar($this->session->userdata('id'),$tabla_cups,'GET',$CodGesGen,$this->input->ip_address(),'Buscando Gestión Comercial');		
		$this->response($CodCli);
    }
      

}
?>