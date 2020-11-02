<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Usuarios extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Usuarios_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    public function borrar_row_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$huser=$this->get('huser');
        $data = $this->Usuarios_model->borrar_empleados_data($huser);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','DELETE',$huser,$this->input->ip_address(),'Borrando Empleado.');		
    }
    public function list_empleados_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Usuarios_model->get_list_empleados();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','GET',null,$this->input->ip_address(),'Cargando Lista de Empleados');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function cargar_menu_users_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
        $data = $this->Usuarios_model->get_list_menu();
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Menu','GET',null,$this->input->ip_address(),'Cargando Lista de Menu');
		if (empty($data)){
			$this->response(false);
			return false;
		}		
		$this->response($data);		
    }
    public function newApiKey_get()
    {
            $generate = $this->Usuarios_model->new_api_key($level = false,$ignore_limits = false,$is_private_key = false,$ip_addresses = $this->input->ip_address());
			$this->response($generate);
    }
    public function buscar_xID_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$huser=$this->get('huser');		
        $data = $this->Usuarios_model->get_users_data($huser);
        $this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','GET',$huser,$this->input->ip_address(),'Consultando datos del Usuario');
		if (empty($data)){
			$this->response(false);
			return false;
		}
		$data->detalle = $this->obtener_detalle($data->id);	
		$data->detalle_menu = $this->obtener_detalle_menu($data->id);		
		

		$this->response($data);		
    }
    public function obtener_detalle($id)
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    	$detalleG = $this->Usuarios_model->get_detalle_access_all($id);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
	public function obtener_detalle_menu($id)
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    	$detalleG = $this->Usuarios_model->get_detalle_menu_all($id);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
    public function crear_usuario_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$detalle = $objSalida->detalle;	
		$detalle_menu = $objSalida->detalle_menu;		
		$this->db->trans_start();		
		if (isset($objSalida->id))
		{
			$this->Usuarios_model->eliminar_all($objSalida->id,$objSalida->key);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'controllers','DELETE',null,$this->input->ip_address(),'Limpiando Detalle de Controladores');
			$this->Usuarios_model->eliminar_all_detalle_menu($objSalida->id);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MenuUsers','DELETE',null,$this->input->ip_address(),'Limpiando Detalle de Menu');		
			$this->Usuarios_model->actualizar($objSalida->id,$objSalida->nombres,$objSalida->apellidos,$objSalida->username,$objSalida->correo_electronico,$objSalida->nivel,$objSalida->bloqueado);
			if(!empty($detalle))
			{
				foreach ($detalle as $controller => $my_controller): 
				{
					$this->Usuarios_model->agregar_detalle_controladores($objSalida->key,$my_controller->controller,$my_controller->id,$objSalida->id);
				}
				endforeach;
				$this->Auditoria_model->agregar($this->session->userdata('id'),'controllers','INSERT',null,$this->input->ip_address(),'Agregando Detalle de Controladores');
			}
			if(!empty($detalle_menu))
			{
				foreach ($detalle_menu as $menu => $mymenu): 
				{
					$this->Usuarios_model->agregar_detalle_menu($mymenu->CodMenuAsi,$objSalida->id);
				}
				endforeach;
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MenuUsers','INSERT',null,$this->input->ip_address(),'Agregnado Detalle de Menu');
			}
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','UPDATE',$objSalida->id,$this->input->ip_address(),'Actualizando Datos Del Usuario');
		}
		else
		{
			$id = $this->Usuarios_model->agregar($objSalida->nombres,$objSalida->apellidos,$objSalida->username,$objSalida->correo_electronico,md5($objSalida->contrasena),$objSalida->contrasena,$objSalida->nivel,$objSalida->key,$objSalida->bloqueado);
			$this->Usuarios_model->update_key($objSalida->key,$id);
			$objSalida->id=$id;			
			if(!empty($detalle))
			{
				foreach ($detalle as $controller => $my_controller): 
				{
					$this->Usuarios_model->agregar_detalle_controladores($objSalida->key,$my_controller->controller,$my_controller->id,$objSalida->id);
				}
				endforeach;
				$this->Auditoria_model->agregar($this->session->userdata('id'),'controllers','INSERT',null,$this->input->ip_address(),'Agregando Detalle de Controladores');
			}
			if(!empty($detalle_menu))
			{
				foreach ($detalle_menu as $menu => $mymenu): 
				{
					$this->Usuarios_model->agregar_detalle_menu($mymenu->CodMenuAsi,$objSalida->id);
				}
				endforeach;
				$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MenuUsers','INSERT',null,$this->input->ip_address(),'Agregnado Detalle de Menu');
			}			
			$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','INSERT',$objSalida->id,$this->input->ip_address(),'Creando Usuario para Login');			
		}		
		$this->db->trans_complete();
		$this->response($objSalida);
    }
    public function comprobar_email_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$email=$this->get('email');
        $data = $this->Usuarios_model->comprobar_email_disponible($email);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response(true);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','GET',$huser,$this->input->ip_address(),'Verificando Disponibilidad Email.');		
    }
    public function comprobar_username_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
		$username=$this->get('username');
        $data = $this->Usuarios_model->comprobar_username_disponible($username);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','GET',$huser,$this->input->ip_address(),'Verificando Disponibilidad Username.');		
    }
    public function cargar_controladores_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}	
        $data = $this->Usuarios_model->get_controladores();
		if (empty($data))
		{
			$this->response(false);
			return false;
		}		
		$this->response($data);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'controller','GET',0,$this->input->ip_address(),'Cargando lista de controladores.');		
    }
    public function getUsuariosFilter_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		$consulta=$this->Usuarios_model->getUsuariosFilter($objSalida->filter_search);		
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','SEARCH',null,$this->input->ip_address(),'Filtrando Lista de Usuarios');
		$this->db->trans_complete();
		$this->response($consulta);
    }
    public function ChangePassword_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));			
		$this->db->trans_start();		
		
		if($objSalida->newpassword!=$objSalida->repassword)
		{
			$this->db->trans_complete();
			$this->response(false);
		}
		$update=$this->Usuarios_model->updatePassword($objSalida->id,$objSalida->newpassword);			
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_Usuarios_Session','UPDATE',$objSalida->id,$this->input->ip_address(),'Cambio de contraseña del usuario');				
		$this->db->trans_complete();
		$this->response($update);
    }
	
}
?>