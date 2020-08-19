<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Distribuidoras_model extends CI_Model 
{
    public function get_list_distribuidoras()
    {
        $this->db->select('CodDist,NumCifDis,RazSocDis,NomComDis,TelFijDis,EmaDis,PagWebDis,PerConDis,case TipSerDis when 0 then "ELÉCTRICO" WHEN 1 THEN "GAS" WHEN 2 THEN "AMBOS SERVICIOS" end as TipSerDis,ObsDis,case EstDist when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstDist',false);
        $this->db->from('T_Distribuidora');       
        $this->db->order_by('RazSocDis ASC');              
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
    public function comprobar_cif_distribuidora($NumCifDis)
    {
        $this->db->select('*');
        $this->db->from('T_Distribuidora');       
        $this->db->where('NumCifDis',$NumCifDis);            
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
     public function agregar($EmaDis,$NomComDis,$NumCifDis,$ObsDis,$PagWebDis,$PerConDis,$RazSocDis,$TelFijDis,$TipSerDis,$PreCups)
    {
        $this->db->insert('T_Distribuidora',array('EmaDis'=>$EmaDis,'NomComDis'=>$NomComDis,'NumCifDis'=>$NumCifDis,'ObsDis'=>$ObsDis,'PagWebDis'=>$PagWebDis,'PerConDis'=>$PerConDis,'RazSocDis'=>$RazSocDis,'TelFijDis'=>$TelFijDis,'TipSerDis'=>$TipSerDis,'PreCups'=>$PreCups));
        return $this->db->insert_id();
    }
    public function actualizar($CodDist,$EmaDis,$NomComDis,$NumCifDis,$ObsDis,$PagWebDis,$PerConDis,$RazSocDis,$TelFijDis,$TipSerDis,$PreCups)
    {   
        $this->db->where('CodDist', $CodDist);  
        return $this->db->update('T_Distribuidora',array('EmaDis'=>$EmaDis,'NomComDis'=>$NomComDis,'ObsDis'=>$ObsDis,'PagWebDis'=>$PagWebDis,'PerConDis'=>$PerConDis,'RazSocDis'=>$RazSocDis,'TelFijDis'=>$TelFijDis,'TipSerDis'=>$TipSerDis,'NumCifDis'=> $NumCifDis,'PreCups'=>$PreCups));
    }
    public function get_distribuidora_data($CodDist)
    {
        $this->db->select('CodDist,NumCifDis,RazSocDis,NomComDis,TelFijDis,EmaDis,PagWebDis,PerConDis,TipSerDis,ObsDis,case EstDist when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstDist',false);
        $this->db->from('T_Distribuidora');       
        $this->db->where('CodDist',$CodDist);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function borrar_distribuidora_data($CodDist)
    { 
        return $this->db->delete('T_Distribuidora', array('CodDist' => $CodDist));
    }
    public function update_status_distribuidora($opcion,$CodDist)
    {   
        $this->db->where('CodDist', $CodDist);        
        return $this->db->update('T_Distribuidora',array('EstDist'=>$opcion));
    }
    public function agregar_motivo_bloqueo($CodDist,$fecha,$MotBloqDis,$ObsBloDis)
    {
        $this->db->insert('T_BloqueoDistribuidora',array('CodDist'=>$CodDist,'FecBloDis'=>$fecha,'MotBloqDis'=>$MotBloqDis,'ObsBloDis'=>$ObsBloDis));
        return $this->db->insert_id();
    }
    public function getDistribuidorasFilter($SearchText)
    {
        $this->db->select('CodDist,NumCifDis,RazSocDis,NomComDis,TelFijDis,EmaDis,PagWebDis,PerConDis,case TipSerDis when 0 then "ELÉCTRICO" WHEN 1 THEN "GAS" WHEN 2 THEN "AMBOS SERVICIOS" end as TipSerDis,ObsDis,case EstDist when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstDist',false);
        $this->db->from('T_Distribuidora');
        $this->db->like('NumCifDis',$SearchText);
        $this->db->or_like('RazSocDis',$SearchText); 
        $this->db->or_like('NomComDis',$SearchText);
        $this->db->or_like('TelFijDis',$SearchText);
        $this->db->or_like('EmaDis',$SearchText);     
        $this->db->order_by('RazSocDis ASC');              
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
}