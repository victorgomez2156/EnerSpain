<?php
class Tareas_programadas_model extends CI_Model 
{ 
	public function Validar_Ref_PropuestaComercial()
    {
        $this->db->select('count(*) as total');
        $this->db->from('T_PropuestaComercial');               
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
    public function all_propuestas()
    {
        $this->db->select('*');
        $this->db->from('T_PropuestaComercial');               
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
    public function update_RefProCom($CodProCom,$RefProCom)
    {   
        $this->db->where('CodProCom', $CodProCom);        
        return $this->db->update('T_PropuestaComercial',array('RefProCom'=>$RefProCom));
    }
    public function select_contratos_vencerse($Fecha)
    {
        $this->db->select('a.CodConCom,DATE_FORMAT(a.FecIniCon,"%d/%m/%Y") as FecIniCon,a.DurCon,DATE_FORMAT(a.FecVenCon,"%d/%m/%Y") as FecVenCon,a.ObsCon,b.RazSocCli,b.NumCifCli',false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli'); 
        $this->db->where('FecVenCon<=',$Fecha); 
        $this->db->where('EstBajCon=0');               
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
    public function update_Contratos($CodConCom,$EstBajCon)
    {   
        $this->db->where('CodConCom', $CodConCom);        
        return $this->db->update('T_Contrato',array('EstBajCon'=>$EstBajCon));
    }
    




 
}
?>