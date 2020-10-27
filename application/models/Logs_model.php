<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logs_model extends CI_Model 
{
    public function get_list_Logs($metodo,$huser)
    {
        $this->db->select('a.hora,a.operacion,a.ip,NULL as navegador,a.evento,b.username',false);
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
            return $query->result(); 
        } 
        else
        {
            return false;
        }       
    }

}