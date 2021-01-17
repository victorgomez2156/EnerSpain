<?php
class Activaciones_model extends CI_Model 
{
	public function GetDatosCUPsForActivaciones($CUPs) 
    {
        $sql = $this->db->query("SELECT * FROM V_CupsGrib where CupsGas='$CUPs'");
        if ($sql->num_rows() > 0)
          return $sql->row();
        else  
        return false;        
    }

   
}
?>
