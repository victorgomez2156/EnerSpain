<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model 
{
    
 	public function get_Menu($huser) 
    {
        $this->db->select('a.*,b.*',FALSE);
        $this->db->from('T_MenuUsers a'); 
        $this->db->join('T_Menu b','a.CodMenuAsi=b.id'); 
        $this->db->where('a.huser',$huser);   
        $this->db->where('b.EstMenu=1'); 
        $this->db->order_by('b.orden ASC');              
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
?>