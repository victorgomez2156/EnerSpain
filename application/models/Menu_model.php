<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model 
{
    
public function get_Menu($usuario)
{
        $this->db->order_by('CodMenu,hpadre','asc');
        $this->db->where('CodUser',$usuario);
        $query = $this->db->get('T_MenuUsers');
        return $query->result();
}
}
?>