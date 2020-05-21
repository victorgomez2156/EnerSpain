<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tarifas_model extends CI_Model 
{
     /////PARA LAS TARIFAS ELECTRICAS START////   
    public function list_tarifa_electricas()
    {
        $this->db->select('CodTarEle,case TipTen WHEN 0 THEN "BAJA" WHEN 1 THEN "ALTA" END as TipTen,NomTarEle,CanPerTar,MinPotCon,MaxPotCon ',FALSE);
        $this->db->from('T_TarifaElectrica');
        $this->db->order_by('NomTarEle ASC');
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
     public function borrar_tarifa_electrica($CodTarEle)
    { 
        return $this->db->delete('T_TarifaElectrica', array('CodTarEle' => $CodTarEle));
    }
    public function agregar_tarifa_electrica($TipTen,$NomTarEle,$CanPerTar,$MinPotCon,$MaxPotCon)
    {
        $this->db->insert('T_TarifaElectrica',array('TipTen'=>$TipTen,'NomTarEle'=>$NomTarEle,'CanPerTar'=>$CanPerTar,'MinPotCon'=>$MinPotCon,'MaxPotCon'=>$MaxPotCon));
        return $this->db->insert_id();
    }
    public function actualizar_tarifa_electrica($CodTarEle,$TipTen,$NomTarEle,$CanPerTar,$MinPotCon,$MaxPotCon)
    {   
        $this->db->where('CodTarEle', $CodTarEle);        
        return $this->db->update('T_TarifaElectrica',array('TipTen'=>$TipTen,'NomTarEle'=>$NomTarEle,'CanPerTar'=>$CanPerTar,'MinPotCon'=>$MinPotCon,'MaxPotCon'=>$MaxPotCon));
    }
     public function get_tarifa_electrica($CodTarEle)
    {
        $this->db->select('*');
        $this->db->from('T_TarifaElectrica');  
        $this->db->where('CodTarEle',$CodTarEle);            
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
    public function getTarEleFilter($SearchText)
    {
        $this->db->select('CodTarEle,case TipTen WHEN 0 THEN "BAJA" WHEN 1 THEN "ALTA" END as TipTen,NomTarEle,CanPerTar,MinPotCon,MaxPotCon ',FALSE);
        $this->db->from('T_TarifaElectrica');
        $this->db->like('NomTarEle',$SearchText);
        $this->db->or_like('CanPerTar',$SearchText);
        $this->db->or_like('MinPotCon',$SearchText);
        $this->db->or_like('MaxPotCon',$SearchText);
        $this->db->order_by('NomTarEle ASC');
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
     /////////////////////////////////////////////// PARA LAS TARIFAS ELECTRICAS END /////////////////////////////////////// 

    /////////////////////////////////////////////// PARA LAS TARIFAS GAS START ///////////////////////////////////////////////////
    public function get_list_tarifa_Gas()
    {
        $this->db->select('*');
        $this->db->from('T_TarifaGas');
        $this->db->order_by('NomTarGas ASC');
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
      public function borrar_tarifa_gas($CodTarGas)
    { 
        return $this->db->delete('T_TarifaGas', array('CodTarGas' => $CodTarGas));
    }
    public function agregar_tarifa_gas($MaxConAnu,$MinConAnu,$NomTarGas)
    {
        $this->db->insert('T_TarifaGas',array('MaxConAnu'=>$MaxConAnu,'MinConAnu'=>$MinConAnu,'NomTarGas'=>$NomTarGas));
        return $this->db->insert_id();
    }
    public function actualizar_tarifa_gas($CodTarGas,$MaxConAnu,$MinConAnu,$NomTarGas)
    {   
        $this->db->where('CodTarGas', $CodTarGas);        
        return $this->db->update('T_TarifaGas',array('MaxConAnu'=>$MaxConAnu,'MinConAnu'=>$MinConAnu,'NomTarGas'=>$NomTarGas));
    }
     public function get_tarifa_gas($CodTarGas)
    {
        $this->db->select('*');
        $this->db->from('T_TarifaGas');  
        $this->db->where('CodTarGas',$CodTarGas);            
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
    public function getTarGasFilter($SearchText)
    {        
        $this->db->select('*');
        $this->db->from('T_TarifaGas');
        $this->db->like('NomTarGas',$SearchText);
        $this->db->or_like('MinConAnu',$SearchText); 
        $this->db->or_like('MaxConAnu',$SearchText);  
        $this->db->order_by('NomTarGas ASC');
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
    ///////////////////////////////////////PARA LAS TARIFAS GAS END///////////////////////////////////////////////////
}