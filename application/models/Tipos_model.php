<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tipos_model extends CI_Model 
{
     /// PARA TIPO CLIENTE START/////
    public function get_list_tipo_clientes()
    {
        $this->db->select('*');
        $this->db->from('T_TipoCliente');
        $this->db->order_by('DesTipCli ASC');              
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
    public function agregar_tipo_cliente($DesTipCli,$ObsTipCli)
    {
        $this->db->insert('T_TipoCliente',array('DesTipCli'=>$DesTipCli,'ObsTipCli'=>$ObsTipCli));
        return $this->db->insert_id();
    }
    public function actualizar_tipo_cliente($CodTipCli,$DesTipCli,$ObsTipCli)
    {   
        $this->db->where('CodTipCli', $CodTipCli);        
        return $this->db->update('T_TipoCliente',array('DesTipCli'=>$DesTipCli,'ObsTipCli'=>$ObsTipCli));
    }
    public function borrar_tipo_cliente_data($CodTipCli)
    { 
        return $this->db->delete('T_TipoCliente', array('CodTipCli' => $CodTipCli));
    }
    public function get_tipo_cliente_data($CodTipCli)
    {
        $this->db->select('*');
        $this->db->from('T_TipoCliente');  
        $this->db->where('CodTipCli',$CodTipCli);          
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
    /// PARA TIPO CLIENTE END//////



    /// PARA TIPO SECTOR START/////
    public function get_list_tipo_sector()
    {
        $this->db->select('*');
        $this->db->from('T_SectorCliente');
        $this->db->order_by('DesSecCli ASC');              
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
     public function agregar_tipo_Sector($DesSecCli,$ObsSecCli)
    {
        $this->db->insert('T_SectorCliente',array('DesSecCli'=>$DesSecCli,'ObsSecCli'=>$ObsSecCli));
        return $this->db->insert_id();
    }
    public function actualizar_tipo_Sector($CodSecCli,$DesSecCli,$ObsSecCli)
    {   
        $this->db->where('CodSecCli', $CodSecCli);        
        return $this->db->update('T_SectorCliente',array('DesSecCli'=>$DesSecCli,'ObsSecCli'=>$ObsSecCli));
    }
     public function borrar_tipo_sector_data($CodSecCli)
    { 
        return $this->db->delete('T_SectorCliente', array('CodSecCli' => $CodSecCli));
    }
    public function get_tipo_sector_data($CodSecCli)
    {
        $this->db->select('*');
        $this->db->from('T_SectorCliente');  
        $this->db->where('CodSecCli',$CodSecCli);         
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
  
    /// PARA TIPO SECTOR END//////


    /// PARA TIPO CONTACTO START/////
    public function get_list_tipo_contacto()
    {
        $this->db->select('*');
        $this->db->from('T_TipoContacto');
        $this->db->order_by('DesTipCon ASC');              
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
    public function agregar_tipo_contacto($DesTipCon,$ObsTipCon)
    {
        $this->db->insert('T_TipoContacto',array('DesTipCon'=>$DesTipCon,'ObsTipCon'=>$ObsTipCon));
        return $this->db->insert_id();
    }
    public function actualizar_tipo_contacto($CodTipCon,$DesTipCon,$ObsTipCon)
    {   
        $this->db->where('CodTipCon', $CodTipCon);        
        return $this->db->update('T_TipoContacto',array('DesTipCon'=>$DesTipCon,'ObsTipCon'=>$ObsTipCon));
    }
     public function borrar_tipo_contacto_data($CodTipCon)
    { 
        return $this->db->delete('T_TipoContacto', array('CodTipCon' => $CodTipCon));
    }
    public function get_tipo_contacto_data($CodTipCon)
    {
        $this->db->select('*');
        $this->db->from('T_TipoContacto');  
        $this->db->where('CodTipCon',$CodTipCon);         
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
    /// PARA TIPO CONTACTO END//////





   
    /////////////////////////////////////////////////////////////////////////// PARA TIPO DOCUMENTO START///////////////////////////////////////////////////////////
    public function get_list_tipo_documentos()
    {
        $this->db->select('CodTipDoc,DesTipDoc,ObsTipDoc,case EstReq when 0 then "NO" WHEN 1 THEN "SI" end as EstReq',false);
        $this->db->from('T_TipoDocumento');
        $this->db->order_by('DesTipDoc ASC');              
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
    public function agregar_tipo_documentos($DesTipDoc,$ObsTipDoc,$EstReq)
    {
        $this->db->insert('T_TipoDocumento',array('DesTipDoc'=>$DesTipDoc,'ObsTipDoc'=>$ObsTipDoc,'EstReq'=>$EstReq));
        return $this->db->insert_id();
    }
    public function actualizar_tipo_documentos($CodTipDoc,$DesTipDoc,$ObsTipDoc,$EstReq)
    {   
        $this->db->where('CodTipDoc', $CodTipDoc);        
        return $this->db->update('T_TipoDocumento',array('DesTipDoc'=>$DesTipDoc,'ObsTipDoc'=>$ObsTipDoc,'EstReq'=>$EstReq));
    }
     public function borrar_tipo_documento_data($CodTipDoc)
    { 
        return $this->db->delete('T_TipoDocumento', array('CodTipDoc' => $CodTipDoc));
    }
    public function get_tipo_documentos_data($CodTipDoc)
    {
        $this->db->select('*');
        $this->db->from('T_TipoDocumento');  
        $this->db->where('CodTipDoc',$CodTipDoc);         
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

  
    /////////////////////////////////////////////////////////////////////////// PARA TIPO DOCUMENTO END////////////////////////////////////////////////////////////
    
}