<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comercial_model extends CI_Model 
{
   /////PARA COMERCIALES START////
    public function get_list_comerciales()
    {
        $this->db->select('*');
        $this->db->from('T_Comercial');
        $this->db->order_by('NomCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
     public function get_numero_dni_nie($NumDNI_NIECli)
    {
        $this->db->select('NIFCom');
        $this->db->from('T_Comercial');
        $this->db->where('NIFCom',$NumDNI_NIECli);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }       
    }
    public function get_comercial_data($CodCom)
    {
        $this->db->select('*');
        $this->db->from('T_Comercial');  
        $this->db->where('CodCom',$CodCom);     
        $this->db->order_by('NomCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function agregar_comercial($NomCom,$NIFCom,$TelCelCom,$TelFijCom,$EmaCom,$CarCom,$PorComCom,$ObsCom)
    {
        $this->db->insert('T_Comercial',array('NomCom'=>$NomCom,'NIFCom'=>$NIFCom,'TelCelCom'=>$TelCelCom,'TelFijCom'=>$TelFijCom,'EmaCom'=>$EmaCom,'CarCom'=>$CarCom,'FecIniCom'=>date('Y-m-d'),'PorComCom'=>$PorComCom,'ObsCom'=>$ObsCom));
        return $this->db->insert_id();
    }
    public function actualizar_comercial($CodCom,$NomCom,$NIFCom,$TelCelCom,$TelFijCom,$EmaCom,$CarCom,$PorComCom,$ObsCom)
    {   
        $this->db->where('CodCom', $CodCom);
        $this->db->where('NIFCom', $NIFCom);        
        return $this->db->update('T_Comercial',array('NomCom'=>$NomCom,'TelCelCom'=>$TelCelCom,'TelFijCom'=>$TelFijCom,'EmaCom'=>$EmaCom,'CarCom'=>$CarCom,'PorComCom'=>$PorComCom,'ObsCom'=>$ObsCom));
    }
     public function borrar_comercial_data($CodCom)
    { 
        return $this->db->delete('T_Comercial', array('CodCom' => $CodCom));
    }
     public function update_status_comercial($CodCom,$EstCom)
    {   
        $this->db->where('CodCom', $CodCom);       
        return $this->db->update('T_Comercial',array('EstCom'=>$EstCom));
    }
     public function agregar_bloqueo_Comercial($CodCom,$FecBloCom,$MotBloqCom,$ObsBloCom)
    {
        $this->db->insert('T_BloqueoComercial',array('CodCom'=>$CodCom,'FecBloCom'=>$FecBloCom,'MotBloqCom'=>$MotBloqCom,'ObsBloCom'=>$ObsBloCom));
        return $this->db->insert_id();
    }
    /////PARA COMERCIALES END////
}