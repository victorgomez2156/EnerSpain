<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logs_model extends CI_Model 
{
    public function get_list_Logs($metodo,$huser)
    {
        $this->db->select('date_format(a.hora,"%d/%m/%Y %H:%i:%s") as hora,a.operacion,a.ip,a.navegador,a.evento,b.username',false);
        $this->db->from('tblauditorias a');
        $this->db->join('T_Usuarios_Session b','a.huser=b.id');
        if($metodo==2)
        {
            $this->db->where('a.huser',$huser);
        }  
        $this->db->order_by('a.hora DESC');            
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            if($metodo==1)
            {
                return $query->result();
            }
            if($metodo==2)
            {
                return false;
            }   
        } 
        else
        {
            return false;
        }       
    }

}