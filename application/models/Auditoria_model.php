<?php
class Auditoria_model extends CI_Model 
{
	public function agregar($huser,$tablaafectada,$operacion,$idafectado,$ip,$evento)
    {
        $fecha=date('y-m-d');
        $this->db->insert('tblauditorias',array('huser'=>$huser,'tablaafectada'=>$tablaafectada,'operacion'=>$operacion,'idafectado'=>$idafectado,'ip'=>$ip,'evento'=>$evento,'fecha'=>$fecha));
		return $this->db->insert_id();
    }
    public function agregar1($huser,$tablaafectada,$operacion,$idafectado,$ip,$evento)
    {
        $this->db->insert('tblauditorias',array('huser'=>$huser,'tablaafectada'=>$tablaafectada,'operacion'=>$operacion,'idafectado'=>$idafectado,'ip'=>$ip,'evento'=>$evento));
		return $this->db->insert_id();
    }   
}
?>
