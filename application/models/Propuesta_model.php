<?php
class Propuesta_model extends CI_Model 
{	
///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL START ///////////////////////////////////////////////
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
    } ##case a.EstProCom when "P" then "Pendiente" when "A" then "Aprobada" when "C" then "Completada" when "R" then "Rechazada" end as EstProCom,
    public function get_list_propuesta_clientes_all()
    {
        $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,b.RazSocCli,b.NumCifCli,c.CUPsEle,d.CupsGas,a.CodCli,a.EstProCom',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_CUPsElectrico c','a.CodCupsEle=c.CodCupsEle');
        $this->db->join('T_CUPsGas d','a.CodCupsGas=d.CodCupGas');
        $this->db->order_by('a.FecProCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function get_list_propuesta_comerciales_filtro($where,$Variable)
    {
        $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,b.RazSocCli,b.NumCifCli,c.CUPsEle,d.CupsGas,a.CodCli,a.EstProCom',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_CUPsElectrico c','a.CodCupsEle=c.CodCupsEle');
        $this->db->join('T_CUPsGas d','a.CodCupsGas=d.CodCupGas');
        $this->db->where($where,$Variable);
        $this->db->order_by('a.FecProCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }     
    public function Buscar_Propuesta($Variable,$tabla,$where)
    {
        $this->db->select('*',false);
        $this->db->from($tabla);       
        $this->db->where($where,$Variable);
        $this->db->where('EstProCom','P');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->row();
        else
        return false;              
    } 
    public function Buscar_Contratos($Variable)
    {
        $this->db->select('*',false);
        $this->db->from('T_Contrato');       
        $this->db->where('CodCli',$Variable);          
        $this->db->order_by('FecConCom DESC');   
        //$this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function Buscar_Contratos_Vali($Variable,$CodConCom,$CodProCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_Contrato');       
        $this->db->where('CodCli',$Variable);
        $this->db->where('CodConCom',$CodConCom);
        $this->db->where('CodProCom',$CodProCom);
        $this->db->order_by('FecConCom DESC');   
        $this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->row();
        else
        return false;              
    }
    public function Buscar_Propuesta_Vali($CodCli,$CodProCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_PropuestaComercial');       
        $this->db->where('CodCli',$CodCli);
        $this->db->where('CodProCom',$CodProCom);
        $this->db->order_by('FecProCom DESC');   
        $this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->row();
        else
        return false;              
    }
    public function Tarifas($Tabla,$order_by)
    {
        $this->db->select('*',false);
        $this->db->from($Tabla); 
        $this->db->order_by($order_by); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function ProductosComercia($CodCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_Producto');
        $this->db->where('CodCom',$CodCom); 
        $this->db->order_by('DesPro DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function ProductosAnexos($CodAne)
    {
        $this->db->select('*',false);
        $this->db->from('T_AnexoProducto');
        $this->db->where('CodPro',$CodAne); 
        $this->db->order_by('DesAnePro DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function agregar_propuesta($CodCli,$FecProCom,$CodPunSum,$CodCupSEle,$CodTarEle,$ImpAhoEle,$PorAhoEle,$RenConEle,$ObsAhoEle,$CodCupGas,$CodTarGas,$ImpAhoGas,$PorAhoGas,$RenConGas,$ObsAhoGas,$PorAhoTot,$ImpAhoTot,$EstProCom,$JusRecProCom,$CodCom,$CodPro,$CodAnePro,$TipPre,$ObsProCom,$RefProCom,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$CauDia,$Consumo)
    {
        $this->db->insert('T_PropuestaComercial',array('CodCli'=>$CodCli,'FecProCom'=>$FecProCom,'CodPunSum'=>$CodPunSum,'CodCupsEle'=>$CodCupSEle,'CodTarEle'=>$CodTarEle,'ImpAhoEle'=>$ImpAhoEle,'PorAhoEle'=>$PorAhoEle,'RenConEle'=>$RenConEle,'ObsAhoEle'=>$ObsAhoEle,'CodCupsGas'=>$CodCupGas,'CodTarGas'=>$CodTarGas,'ImpAhoGas'=>$ImpAhoGas,'PorAhoGas'=>$PorAhoGas,'RenConGas'=>$RenConGas,'ObsAhoGas'=>$ObsAhoGas,'PorAhoTot'=>$PorAhoTot,'ImpAhoTot'=>$ImpAhoTot,'EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom,'CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ObsProCom'=>$ObsProCom,'RefProCom'=>$RefProCom,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6,'CauDia'=>$CauDia,'Consumo'=>$Consumo));
        return $this->db->insert_id();
    }
    public function update_contrato_cliente($CodCli,$CodConCom,$EstRen,$RenMod,$ProRenPen)
    {   
        $this->db->where('CodConCom', $CodConCom); 
        $this->db->where('CodCli', $CodCli);       
        return $this->db->update('T_Contrato',array('EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen));
    }
    public function update_CUPs_Ele($CodCupsEle,$CodPunSum,$CodTarElec,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6)
    {   
        $this->db->where('CodCupsEle', $CodCupsEle);
        return $this->db->update('T_CUPsElectrico',array('CodTarElec'=>$CodTarElec,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6));
    }
    public function update_CUPs_Gas($CodCupGas,$CodPunSum,$CodTarGas,$Consumo)
    {   
        $this->db->where('CodCupGas', $CodCupGas);  
        return $this->db->update('T_CUPsGas',array('CodTarGas'=>$CodTarGas,'ConAnuCup'=>$Consumo));
    }
    public function update_view_propuesta($CodProCom,$JusRecProCom,$CodCli,$EstProCom)
    {   
        $this->db->where('CodProCom', $CodProCom); 
        $this->db->where('CodCli', $CodCli);       
        return $this->db->update('T_PropuestaComercial',array('EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom));
    }
    public function update_edit_propuesta($CauDia,$CodAnePro,$CodCli,$CodCom,$CodCupGas,$CodCupSEle,$CodPro,$CodProCom,$CodPunSum,$CodTarEle,$CodTarGas,$Consumo,$EstProCom,$FecProCom,$ImpAhoEle,$ImpAhoGas,$ImpAhoTot,$JusRecProCom,$ObsAhoEle,$ObsAhoGas,$ObsProCom,$PorAhoEle,$PorAhoGas,$PorAhoTot,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$RefProCom,$RenConEle,$RenConGas,$TipPre)
    {   
        $this->db->where('CodProCom', $CodProCom); 
        $this->db->where('CodCli', $CodCli);       
        return $this->db->update('T_PropuestaComercial',array('CodPunSum'=>$CodPunSum,'CodCupsEle'=>$CodCupSEle,'CodTarEle'=>$CodTarEle,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6,'ImpAhoEle'=>$ImpAhoEle,'PorAhoEle'=>$PorAhoEle,'RenConEle'=>$RenConEle,'ObsAhoEle'=>$ObsAhoEle,'CodCupsGas'=>$CodCupGas,'CodTarGas'=>$CodTarGas,'Consumo'=>$Consumo,'CauDia'=>$CauDia,'ImpAhoGas'=>$ImpAhoGas,'PorAhoGas'=>$PorAhoGas,'RenConGas'=>$RenConGas,'ObsAhoGas'=>$ObsAhoGas,'PorAhoTot'=>$PorAhoTot,'ImpAhoTot'=>$ImpAhoTot,'EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom,'CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ObsProCom'=>$ObsProCom,'RefProCom'=>$RefProCom));
    }
    








///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL END ////////////////////////////////////////////////
}

?>
