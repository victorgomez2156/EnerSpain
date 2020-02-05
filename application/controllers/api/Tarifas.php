<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Tarifas extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Tarifas_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
     ////PARA LAS TARIFAS ELECTRICAS START///////
    public function get_list_tarifa_electricas_get()
    {
        $datausuario=$this->session->all_userdata();    
        if (!isset($datausuario['sesion_clientes']))
        {
            redirect(base_url(), 'location', 301);
        }       
        $data = $this->Tarifas_model->list_tarifa_electricas();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','GET',0,$this->input->ip_address(),'Cargando Lista de Tarifas Electricas');
        if (empty($data)){
            $this->response(false);
            return false;
        }       
        $this->response($data);     
    }
     public function borrar_tarifa_electrica_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTarEle=$this->get('CodTarEle');
        $data = $this->Tarifas_model->borrar_tarifa_electrica($CodTarEle);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','DELETE',$CodTarEle,$this->input->ip_address(),'Borrando Tarifa Electrica.');		
    }
     public function crear_tarifa_electrica_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTarEle))
		{		
			$this->Tarifas_model->actualizar_tarifa_electrica($objSalida->CodTarEle,$objSalida->TipTen,$objSalida->NomTarEle,$objSalida->CanPerTar,$objSalida->MinPotCon,$objSalida->MaxPotCon);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','UPDATE',$objSalida->CodTarEle,$this->input->ip_address(),'Actualizando Tarifa Electrica');
		}
		else
		{
			$id = $this->Tarifas_model->agregar_tarifa_electrica($objSalida->TipTen,$objSalida->NomTarEle,$objSalida->CanPerTar,$objSalida->MinPotCon,$objSalida->MaxPotCon);		
			$objSalida->CodTarEle=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','INSERT',$objSalida->CodTarEle,$this->input->ip_address(),'Creando Tarifa Eléctrica');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function buscar_XID_TarEle_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTarEle=$this->get('CodTarEle');		
        $data = $this->Tarifas_model->get_tarifa_electrica($CodTarEle);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaElectrica','GET',$CodTarEle,$this->input->ip_address(),'Consultando datos de la Tarifa Eléctrica');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    ////PARA LAS TARIFAS ELECTRICAS END///////





    /////////////////////////////////////////PARA LAS TARIFAS GAS START////////////////////////////
    public function get_list_tarifa_Gas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Tarifas_model->get_list_tarifa_Gas();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',0,$this->input->ip_address(),'Cargando Lista de Tarifas Gas');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function crear_tarifa_gas_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if (isset($objSalida->CodTarGas))
		{		
			$this->Tarifas_model->actualizar_tarifa_gas($objSalida->CodTarGas,$objSalida->MaxConAnu,$objSalida->MinConAnu,$objSalida->NomTarGas);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','UPDATE',$objSalida->CodTarGas,$this->input->ip_address(),'Actualizando Tarifa Gas');
		}
		else
		{
			$id = $this->Tarifas_model->agregar_tarifa_gas($objSalida->MaxConAnu,$objSalida->MinConAnu,$objSalida->NomTarGas);		
			$objSalida->CodTarGas=$id;			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','INSERT',$objSalida->CodTarGas,$this->input->ip_address(),'Creando Tarifa Gas');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
     public function buscar_XID_TarGas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$CodTarGas=$this->get('CodTarGas');		
        $data = $this->Tarifas_model->get_tarifa_gas($CodTarGas);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','GET',$CodTarGas,$this->input->ip_address(),'Consultando datos de la Tarifa Gas');
		if (empty($data)){
			$this->response(false);
			return false;
		}				
		$this->response($data);		
    }
    public function borrar_tarifa_gas_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$CodTarGas=$this->get('CodTarGas');
        $data = $this->Tarifas_model->borrar_tarifa_gas($CodTarGas);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_TarifaGas','DELETE',$CodTarGas,$this->input->ip_address(),'Borrando Tarifa Gas.');		
    }

    ///////////////////////////////////////////PARA LAS TARIFAS GAS END//////////////////////////////
   
	
}
?>