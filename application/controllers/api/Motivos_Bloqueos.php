<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class Motivos_Bloqueos extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Motivos_bloqueos_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301); 
		}
    }
///////////////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS CLIENTES START///////////////////////////////////////////////////////////////////////
public function list_motivo_clientes_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
	$data = $this->Motivos_bloqueos_model->get_list_motivos_bloqueos_clientes();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',0,$this->input->ip_address(),'Cargando Lista Motivos Bloqueos Clientes');
	if (empty($data)){
		$this->response(false);
		return false;
	}		
	$this->response($data);
}
public function crear_motivo_bloqueo_cliente_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();		
	if (isset($objSalida->CodMotBloCli))
	{		
		$this->Motivos_bloqueos_model->actualizar_motivo_bloqueo_cliente($objSalida->CodMotBloCli,$objSalida->DesMotBloCli,$objSalida->ObsMotBloCli);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','UPDATE',$objSalida->CodMotBloCli,$this->input->ip_address(),'Actualizando Motivo Bloqueo Cliente');
	}
	else
	{
		$id = $this->Motivos_bloqueos_model->agregar_motivo_bloqueo_cliente($objSalida->DesMotBloCli,$objSalida->ObsMotBloCli);		
		$objSalida->CodMotBloCli=$id;			
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','INSERT',$objSalida->CodMotBloCli,$this->input->ip_address(),'Creando Motivo Bloqueo Cliente');
	}		
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function buscar_xID_MotBloCli_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$CodMotBloCli=$this->get('CodMotBloCli');		
    $data = $this->Motivos_bloqueos_model->get_tipo_motivo_bloqueo_cliente($CodMotBloCli);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','GET',$CodMotBloCli,$this->input->ip_address(),'Consultando Motivo Bloqueo Cliente');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}				
	$this->response($data);		
}
public function borrar_row_MotBloCli_delete()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}	
	$CodMotBloCli=$this->get('CodMotBloCli');
    $data = $this->Motivos_bloqueos_model->borrar_MotBloCli($CodMotBloCli);
	if (empty($data))
	{
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','DELETE',$CodMotBloCli,$this->input->ip_address(),'Borrando Motivo Bloqueo Clientes Fallido.');
		$this->response(false);
		return false;
	}
	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCli','DELETE',$CodMotBloCli,$this->input->ip_address(),'Borrando Motivo Bloqueo Clientes.');		
	$this->response($data);
}
///////////////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS CLIENTES END/////////////////////////////////////////////////////////////////////////
 


///////////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS ACTIVIDADES START////////////////////////////////////////////////////////////////////////
 
public function list_motivo_actividades_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
	$data = $this->Motivos_bloqueos_model->get_list_motivos_bloqueos_actividades();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',0,$this->input->ip_address(),'Cargando Lista Motivos Bloqueos Actividades');
	if (empty($data)){
		$this->response(false);
		return false;
	}		
	$this->response($data);
}    
public function crear_motivo_bloqueo_actividad_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();		
	if (isset($objSalida->CodMotBloAct))
	{		
		$this->Motivos_bloqueos_model->actualizar_motivo_bloqueo_actividad($objSalida->CodMotBloAct,$objSalida->DesMotBloAct,$objSalida->ObsMotBloAct);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','UPDATE',$objSalida->CodMotBloAct,$this->input->ip_address(),'Actualizando Motivo Bloqueo Cliente');
	}
	else
	{
		$id = $this->Motivos_bloqueos_model->agregar_motivo_bloqueo_actividad($objSalida->DesMotBloAct,$objSalida->ObsMotBloAct);		
		$objSalida->CodMotBloAct=$id;			
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','INSERT',$objSalida->CodMotBloAct,$this->input->ip_address(),'Creando Motivo Bloqueo Actividad');
	}		
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function buscar_xID_MotBloAct_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$CodMotBloAct=$this->get('CodMotBloAct');		
    $data = $this->Motivos_bloqueos_model->get_tipo_motivo_bloqueo_actividad($CodMotBloAct);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','GET',$CodMotBloAct,$this->input->ip_address(),'Consultando Motivo Bloqueo Actividad');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}				
	$this->response($data);		
}
public function borrar_row_MotBloAct_delete()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}	
	$CodMotBloAct=$this->get('CodMotBloAct');
    $data = $this->Motivos_bloqueos_model->borrar_MotBloAct($CodMotBloAct);
	if (empty($data))
	{
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','DELETE',$CodMotBloAct,$this->input->ip_address(),'Borrando Motivo Bloqueo Actividades Fallido.');
		$this->response(false);
		return false;
	}
	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloAct','DELETE',$CodMotBloAct,$this->input->ip_address(),'Borrando Motivo Bloqueo Actividades.');		
	$this->response($data);
}
///////////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS ACTIVIDADES END////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS PUNTOS SUMINISTROS START////////////////////////////////////////////////////////////////////////
public function list_motivo_punto_sumininistro_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
	$data = $this->Motivos_bloqueos_model->get_list_motivos_bloqueos_PunSum();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',0,$this->input->ip_address(),'Cargando Lista Motivos Bloqueos Puntos Suministros');
	if (empty($data)){
		$this->response(false);
		return false;
	}		
	$this->response($data);
}
   
public function crear_motivo_bloqueo_PunSum_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();		
	if (isset($objSalida->CodMotBloPun))
	{		
		$this->Motivos_bloqueos_model->actualizar_motivo_bloqueo_PunSum($objSalida->CodMotBloPun,$objSalida->DesMotBloPun,$objSalida->ObsMotBloPun);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','UPDATE',$objSalida->CodMotBloPun,$this->input->ip_address(),'Actualizando Motivo Bloqueo Cliente');
	}
	else
	{
		$id = $this->Motivos_bloqueos_model->agregar_motivo_bloqueo_PunSum($objSalida->DesMotBloPun,$objSalida->ObsMotBloPun);		
		$objSalida->CodMotBloPun=$id;			
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','INSERT',$objSalida->CodMotBloPun,$this->input->ip_address(),'Creando Motivo Bloqueo Puntos Suministros');
	}		
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function buscar_xID_MotBloPunSum_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$CodMotBloPun=$this->get('CodMotBloPun');		
    $data = $this->Motivos_bloqueos_model->get_tipo_motivo_bloqueo_PunSum($CodMotBloPun);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','GET',$CodMotBloPun,$this->input->ip_address(),'Consultando Motivo Bloqueo Puntos Suministros');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}				
	$this->response($data);		
} 
public function borrar_row_MotBloPunSum_delete()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}	
	$CodMotBloPun=$this->get('CodMotBloPun');
    $data = $this->Motivos_bloqueos_model->borrar_MotBloPunSum($CodMotBloPun);
	if (empty($data))
	{
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','DELETE',$CodMotBloPun,$this->input->ip_address(),'Borrando Motivo Bloqueo Puntos Suministros Fallido.');
		$this->response(false);
		return false;
	}
	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloPun','DELETE',$CodMotBloPun,$this->input->ip_address(),'Borrando Motivo Bloqueo Puntos Suministros.');		
	$this->response($data);
}


////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS PUNTOS SUMINISTROS END////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////// PARA MOTIVOS BLOQUEOS CONTACTO START////////////////////////////////////////////////////////////////////////
public function list_motivo_contactos_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
	$data = $this->Motivos_bloqueos_model->get_list_motivos_bloqueos_contacto();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','GET',0,$this->input->ip_address(),'Cargando Lista Motivos Bloqueos Contacto');
	if (empty($data)){
		$this->response(false);
		return false;
	}		
	$this->response($data);
}

public function crear_motivo_bloqueo_Contacto_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();		
	if (isset($objSalida->CodMotBloCon))
	{		
		$this->Motivos_bloqueos_model->actualizar_motivo_bloqueo_Contacto($objSalida->CodMotBloCon,$objSalida->DesMotBlocon,$objSalida->ObsMotBloCon);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','UPDATE',$objSalida->CodMotBloCon,$this->input->ip_address(),'Actualizando Motivo Bloqueo Contactos');
	}
	else
	{
		$id = $this->Motivos_bloqueos_model->agregar_motivo_bloqueo_Contacto($objSalida->DesMotBlocon,$objSalida->ObsMotBloCon);		
		$objSalida->CodMotBloCon=$id;			
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','INSERT',$objSalida->CodMotBloCon,$this->input->ip_address(),'Creando Motivo Bloqueo Contactos');
	}		
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function buscar_xID_MotBloContacto_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$CodMotBloCon=$this->get('CodMotBloCon');		
    $data = $this->Motivos_bloqueos_model->get_tipo_motivo_bloqueo_Contacto($CodMotBloCon);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','GET',$CodMotBloCon,$this->input->ip_address(),'Consultando Motivo Bloqueo Contactos');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}				
	$this->response($data);		
}
public function borrar_row_MotBloContacto_delete()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}	
	$CodMotBloCon=$this->get('CodMotBloCon');
    $data = $this->Motivos_bloqueos_model->borrar_MotBloContacto($CodMotBloCon);
	if (empty($data))
	{
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','DELETE',$CodMotBloCon,$this->input->ip_address(),'Borrando Motivo Bloqueo Conctacto Fallido.');
		$this->response(false);
		return false;
	}
	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCon','DELETE',$CodMotBloCon,$this->input->ip_address(),'Borrando Motivo Bloqueo Conctacto.');		
	$this->response($data);
}
////////////////////////////////////////////////// PARA MOTIVOS CONTACTO END////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////// PARA MOTIVOS COMERCIALIZADORA START////////////////////////////////////////////////////////////////////////
public function list_motivo_comercializadora_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}		
	$data = $this->Motivos_bloqueos_model->get_list_motivos_bloqueos_comercializadora();
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',0,$this->input->ip_address(),'Cargando Lista Motivos Bloqueos Comercializadoras');
	if (empty($data)){
		$this->response(false);
		return false;
	}		
	$this->response($data);
}
public function crear_motivo_bloqueo_Comercializadora_post()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$objSalida = json_decode(file_get_contents("php://input"));				
	$this->db->trans_start();		
	if (isset($objSalida->CodMotBloCom))
	{		
		$this->Motivos_bloqueos_model->actualizar_motivo_bloqueo_Comercializadora($objSalida->CodMotBloCom,$objSalida->DesMotBloCom,$objSalida->ObsMotBloCom);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','UPDATE',$objSalida->CodMotBloCon,$this->input->ip_address(),'Actualizando Motivo Bloqueo Comercializadoras.');
	}
	else
	{
		$id = $this->Motivos_bloqueos_model->agregar_motivo_bloqueo_Comercializadora($objSalida->DesMotBloCom,$objSalida->ObsMotBloCom);		
		$objSalida->CodMotBloCom=$id;			
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','INSERT',$objSalida->CodMotBloCom,$this->input->ip_address(),'Creando Motivo Bloqueo Comercializadoras.');
	}		
	$this->db->trans_complete();
	$this->response($objSalida);
}
public function buscar_xID_MotBloComercializadora_get()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}
	$CodMotBloCom=$this->get('CodMotBloCom');		
    $data = $this->Motivos_bloqueos_model->get_tipo_motivo_bloqueo_Comercializadora($CodMotBloCom);
    $this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','GET',$CodMotBloCom,$this->input->ip_address(),'Consultando Motivo Bloqueo Comercializadoras.');
	if (empty($data))
	{
		$this->response(false);
		return false;
	}				
	$this->response($data);		
} 
public function borrar_row_MotBloComercializadora_delete()
{
	$datausuario=$this->session->all_userdata();	
	if (!isset($datausuario['sesion_clientes']))
	{
		redirect(base_url(), 'location', 301);
	}	
	$CodMotBloCom=$this->get('CodMotBloCom');
    $data = $this->Motivos_bloqueos_model->borrar_MotBlocomercializadora($CodMotBloCom);
	if (empty($data))
	{
		$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','DELETE',$CodMotBloCom,$this->input->ip_address(),'Borrando Motivo Bloqueo Comercializadoras Fallido.');
		$this->response(false);
		return false;
	}
	$this->Auditoria_model->agregar($this->session->userdata('id'),'T_MotivoBloCom','DELETE',$CodMotBloCom,$this->input->ip_address(),'Borrando Motivo Bloqueo Comercializadoras.');		
	$this->response($data);
}

////////////////////////////////////////////////// PARA MOTIVOS COMERCIALIZADORA END////////////////////////////////////////////////////////////////////////
	
}

?>