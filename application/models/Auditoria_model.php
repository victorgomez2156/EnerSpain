<?php
class Auditoria_model extends CI_Model 
{
	

    public function agregar($huser,$tablaafectada,$operacion,$idafectado,$ip,$evento)
    {
        $fecha=date('Y-m-d');
        $this->load->library('user_agent');
        if ($this->agent->is_browser())
        {
            $agent = $this->agent->browser(); 
            $version= $this->agent->version();
        }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
                $version= $this->agent->version();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
                $version= $this->agent->version();
            }       
            else
            {
                $agent = 'Unidentified User Agent';
                $version= null;
            }
        $this->db->insert('tblauditorias',array('huser'=>$huser,'tablaafectada'=>$tablaafectada,'operacion'=>$operacion,'idafectado'=>$idafectado,'ip'=>$ip,'evento'=>$evento,'fecha'=>$fecha,'navegador'=>$agent.' '.$version));
		return $this->db->insert_id();
    }
    public function agregar1($huser,$tablaafectada,$operacion,$idafectado,$ip,$evento)
    {
        $this->load->library('user_agent');
        if ($this->agent->is_browser())
        {
            $agent = $this->agent->browser(); 
            $version= $this->agent->version();
        }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
                $version= $this->agent->version();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
                $version= $this->agent->version();
            }       
            else
            {
                $agent = 'Unidentified User Agent';
                $version= null;
            }
        $this->db->insert('tblauditorias',array('huser'=>$huser,'tablaafectada'=>$tablaafectada,'operacion'=>$operacion,'idafectado'=>$idafectado,'ip'=>$ip,'evento'=>$evento,'navegador'=>$agent.' '.$version,'fecha'=>date('Y-m-d')));
		return $this->db->insert_id();
    }   
}
?>
