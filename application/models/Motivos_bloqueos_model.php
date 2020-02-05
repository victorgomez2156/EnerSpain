<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Motivos_bloqueos_model extends CI_Model 
{
//////////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS CLIENTES START/////////////////////////////////////////////////////////
public function get_list_motivos_bloqueos_clientes()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCli');
    $this->db->order_by('DesMotBloCli ASC');              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->result();
    }else
    { 
        return false;
    }       
}
public function agregar_motivo_bloqueo_cliente($DesMotBloCli,$ObsMotBloCli)
{
    $this->db->insert('T_MotivoBloCli',array('DesMotBloCli'=>$DesMotBloCli,'ObsMotBloCli'=>$ObsMotBloCli));
    return $this->db->insert_id();
}
public function actualizar_motivo_bloqueo_cliente($CodMotBloCli,$DesMotBloCli,$ObsMotBloCli)
{   
    $this->db->where('CodMotBloCli', $CodMotBloCli);        
    return $this->db->update('T_MotivoBloCli',array('DesMotBloCli'=>$DesMotBloCli,'ObsMotBloCli'=>$ObsMotBloCli));
}
public function get_tipo_motivo_bloqueo_cliente($CodMotBloCli)
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCli');
    $this->db->where('CodMotBloCli',$CodMotBloCli);              
    $query = $this->db->get(); 
    if($query->num_rows()==1)
    {
        return $query->row();
    }else
    {
        return false;
    }       
}
public function borrar_MotBloCli($CodMotBloCli)
{ 
    return $this->db->delete('T_MotivoBloCli', array('CodMotBloCli' => $CodMotBloCli));
}
//////////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS CLIENTES END////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS ACTIVIDADES START////////////////////////////////////////////////////////////
public function get_list_motivos_bloqueos_actividades()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloAct');
    $this->db->order_by('DesMotBloAct ASC');              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->result();
    }else
    {
        return false;
    }       
}
public function agregar_motivo_bloqueo_actividad($DesMotBloAct,$ObsMotBloAct)
{
    $this->db->insert('T_MotivoBloAct',array('DesMotBloAct'=>$DesMotBloAct,'ObsMotBloAct'=>$ObsMotBloAct));
    return $this->db->insert_id();
}
public function actualizar_motivo_bloqueo_actividad($CodMotBloAct,$DesMotBloAct,$ObsMotBloAct)
{   
    $this->db->where('CodMotBloAct', $CodMotBloAct);        
    return $this->db->update('T_MotivoBloAct',array('DesMotBloAct'=>$DesMotBloAct,'ObsMotBloAct'=>$ObsMotBloAct));
}
public function get_tipo_motivo_bloqueo_actividad($CodMotBloAct)
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloAct');
    $this->db->where('CodMotBloAct',$CodMotBloAct);              
    $query = $this->db->get(); 
    if($query->num_rows()==1)
    {
        return $query->row();
    }else
    {
        return false;
    }       
}
public function borrar_MotBloAct($CodMotBloAct)
{ 
    return $this->db->delete('T_MotivoBloAct', array('CodMotBloAct' => $CodMotBloAct));
}



//////////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS ACTIVIDADES END////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS PUNTOS SUMINISTROS START////////////////////////////////////////////////////////////
public function get_list_motivos_bloqueos_PunSum()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloPun');
    $this->db->order_by('DesMotBloPun ASC');              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->result();
    }else
    {
        return false;
    }       
}
public function agregar_motivo_bloqueo_PunSum($DesMotBloPun,$ObsMotBloPun)
{
    $this->db->insert('T_MotivoBloPun',array('DesMotBloPun'=>$DesMotBloPun,'ObsMotBloPun'=>$ObsMotBloPun));
    return $this->db->insert_id();
}
public function actualizar_motivo_bloqueo_PunSum($CodMotBloPun,$DesMotBloPun,$ObsMotBloPun)
{   
    $this->db->where('CodMotBloPun', $CodMotBloPun);        
    return $this->db->update('T_MotivoBloPun',array('DesMotBloPun'=>$DesMotBloPun,'ObsMotBloPun'=>$ObsMotBloPun));
}
public function get_tipo_motivo_bloqueo_PunSum($CodMotBloPun)
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloPun');
    $this->db->where('CodMotBloPun',$CodMotBloPun);              
    $query = $this->db->get(); 
    if($query->num_rows()==1)
    {
        return $query->row();
    }else
    {
        return false;
    }       
}
public function borrar_MotBloPunSum($CodMotBloPun)
{ 
    return $this->db->delete('T_MotivoBloPun', array('CodMotBloPun' => $CodMotBloPun));
}
////////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS PUNTOS SUMINISTROS END////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS CONTACTOS START////////////////////////////////////////////////////////////
public function get_list_motivos_bloqueos_contacto()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCon');
    $this->db->order_by('DesMotBlocon ASC');              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->result();
    }else
    {
        return false;
    }       
}

public function agregar_motivo_bloqueo_Contacto($DesMotBlocon,$ObsMotBloCon)
{
    $this->db->insert('T_MotivoBloCon',array('DesMotBlocon'=>$DesMotBlocon,'ObsMotBloCon'=>$ObsMotBloCon));
    return $this->db->insert_id();
}
public function actualizar_motivo_bloqueo_Contacto($CodMotBloCon,$DesMotBlocon,$ObsMotBloCon)
{   
    $this->db->where('CodMotBloCon', $CodMotBloCon);        
    return $this->db->update('T_MotivoBloCon',array('DesMotBlocon'=>$DesMotBlocon,'ObsMotBloCon'=>$ObsMotBloCon));
}
public function get_tipo_motivo_bloqueo_Contacto($CodMotBloCon)
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCon');
    $this->db->where('CodMotBloCon',$CodMotBloCon);              
    $query = $this->db->get(); 
    if($query->num_rows()==1)
    {
        return $query->row();
    }else
    {
        return false;
    }       
}
public function borrar_MotBloContacto($CodMotBloCon)
{ 
    return $this->db->delete('T_MotivoBloCon', array('CodMotBloCon' => $CodMotBloCon));
}

///////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS CONTACTOS END////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS CONTACTOS START////////////////////////////////////////////////////////////
public function get_list_motivos_bloqueos_comercializadora()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCom');
    $this->db->order_by('DesMotBloCom ASC');              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->result();
    }else
    {
        return false;
    }       
}

public function agregar_motivo_bloqueo_Comercializadora($DesMotBloCom,$ObsMotBloCom)
{
    $this->db->insert('T_MotivoBloCom',array('DesMotBloCom'=>$DesMotBloCom,'ObsMotBloCom'=>$ObsMotBloCom));
    return $this->db->insert_id();
}
public function actualizar_motivo_bloqueo_Comercializadora($CodMotBloCom,$DesMotBloCom,$ObsMotBloCom)
{   
    $this->db->where('CodMotBloCom', $CodMotBloCom);        
    return $this->db->update('T_MotivoBloCom',array('DesMotBloCom'=>$DesMotBloCom,'ObsMotBloCom'=>$ObsMotBloCom));
}
public function get_tipo_motivo_bloqueo_Comercializadora($CodMotBloCom)
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCom');
    $this->db->where('CodMotBloCom',$CodMotBloCom);              
    $query = $this->db->get(); 
    if($query->num_rows()==1)
    {
        return $query->row();
    }else
    {
        return false;
    }       
}
public function borrar_MotBlocomercializadora($CodMotBloCom)
{ 
    return $this->db->delete('T_MotivoBloCom', array('CodMotBloCom' => $CodMotBloCom));
}

///////////////////////////////////////////////////////// PARA LOS MOTIVOS BLOQUEOS CONTACTOS END////////////////////////////////////////////////////////////




}