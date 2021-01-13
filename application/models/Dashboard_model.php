<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model 
{ 
    public function Funcion_Verificadora($Variable,$tabla,$where,$select)
    {
        $this->db->select($select,false);
        $this->db->from($tabla);       
        $this->db->where($where,$Variable);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function get_data_cliente($CodCli)
    { 
        $sql = $this->db->query("SELECT a.*,e.CodPro as CodProSoc
            FROM T_Cliente a 
            left JOIN T_Localidad b on b.CodLoc=a.CodLocSoc
            left JOIN T_Localidad e on a.CodLocFis=e.CodLoc
            /*left JOIN T_Provincia c on b.CodPro=c.CodPro
            left JOIN T_TipoVia   d on a.CodTipViaSoc=d.CodTipVia
            left JOIN T_Localidad e on a.CodLocFis=e.CodLoc
            left JOIN T_Provincia f on e.CodPro=f.CodPro
            left JOIN T_TipoVia g on a.CodTipViaFis=g.CodTipVia*/
            where CodCli='$CodCli'");
        if ($sql->num_rows() > 0)
          return $sql->row();
      else
        return false;     
}
}