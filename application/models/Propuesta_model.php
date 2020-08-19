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
    public function Funcion_Verificadora2($Variable,$tabla,$where,$select,$where2,$Variable2)
    {
        $this->db->select($select,false);
        $this->db->from($tabla);       
        $this->db->where($where,$Variable);
        $this->db->where($where2,$Variable2);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function get_list_propuesta_clientes_all()
    {
        $this->db->select('*',false);
        $this->db->from('VPropuestaSencillas');
        $this->db->order_by('FecProCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function get_list_propuesta_comerciales_filtro($where,$Variable)
    {
        $this->db->select('*',false);
        $this->db->from('VPropuestaSencillas');
        $this->db->where($where,$Variable);
        $this->db->order_by('FecProCom DESC');              
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
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom');   
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
    public function agregar_propuesta($FecProCom,$TipProCom,$PorAhoTot,$ImpAhoTot,$EstProCom,$JusRecProCom,$CodCom,$CodPro,$CodAnePro,$TipPre,$ObsProCom,$RefProCom)
    {
        $this->db->insert('T_PropuestaComercial',array('FecProCom'=>$FecProCom,'TipProCom'=>$TipProCom,'PorAhoTot'=>$PorAhoTot,'ImpAhoTot'=>$ImpAhoTot,'EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom,'CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ObsProCom'=>$ObsProCom,'RefProCom'=>$RefProCom));
        return $this->db->insert_id();
    }
    public function agregar_propuesta_comercial_clientes($CodProCom,$CodCli)
    {
        $this->db->insert('T_Propuesta_Comercial_Clientes',array('CodProCom'=>$CodProCom,'CodCli'=>$CodCli));
        return $this->db->insert_id();
    }
    public function agregar_detallesCUPs($CodProComCli,$CodPunSum,$CodCups,$CodTar,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$RenCon,$ImpAho,$PorAho,$ObsCup,$ConCUPs,$CauDia,$TipServ)
    {
        $this->db->insert('T_Propuesta_Comercial_CUPs',array('CodProComCli'=>$CodProComCli,'CodPunSum'=>$CodPunSum,'CodCup'=>$CodCups,'CodTar'=>$CodTar,'PotEleConP1'=>$PotConP1,'PotEleConP2'=>$PotConP2,'PotEleConP3'=>$PotConP3,'PotEleConP4'=>$PotConP4,'PotEleConP5'=>$PotConP5,'PotEleConP6'=>$PotConP6,'RenCup'=>$RenCon,'ImpAho'=>$ImpAho,'PorAho'=>$PorAho,'ObsCup'=>$ObsCup,'ConCup'=>$ConCUPs,'CauDiaGas'=>$CauDia,'TipCups'=>$TipServ));
        return $this->db->insert_id();
    }
    public function agregar_detallesHistorialCUPs($CodProComCli,$CodPunSum,$CodCups,$CodTar,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$RenCon,$ImpAho,$PorAho,$ObsCup,$ConCUPs,$CauDia,$TipServ)
    {
        $this->db->insert('T_Propuesta_Comercial_Historial_CUPs',array('CodProComCli'=>$CodProComCli,'CodPunSum'=>$CodPunSum,'CodCup'=>$CodCups,'CodTar'=>$CodTar,'PotEleConP1'=>$PotConP1,'PotEleConP2'=>$PotConP2,'PotEleConP3'=>$PotConP3,'PotEleConP4'=>$PotConP4,'PotEleConP5'=>$PotConP5,'PotEleConP6'=>$PotConP6,'RenCup'=>$RenCon,'ImpAho'=>$ImpAho,'PorAho'=>$PorAho,'ObsCup'=>$ObsCup,'ConCup'=>$ConCUPs,'CauDiaGas'=>$CauDia,'TipCups'=>$TipServ));
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
    public function update_view_propuesta($CodProCom,$JusRecProCom,$EstProCom)
    {   
        $this->db->where('CodProCom', $CodProCom);   
        return $this->db->update('T_PropuestaComercial',array('EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom));
    }
    public function update_edit_propuesta($CodProCom,$CodCom,$CodPro,$CodAnePro,$TipPre,$ImpAhoTot,$PorAhoTot,$EstProCom,$RefProCom,$JusRecProCom)
    {   
        $this->db->where('CodProCom', $CodProCom); 
        return $this->db->update('T_PropuestaComercial',array('CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ImpAhoTot'=>$ImpAhoTot,'PorAhoTot'=>$PorAhoTot,'EstProCom'=>$EstProCom,'RefProCom'=>$RefProCom,'JusRecProCom'=>$JusRecProCom));
    }
    
    public function BuscandoGestiones($Tabla,$order_by,$select,$where,$CodCli)
    {
        $this->db->select($select,false);
        $this->db->from($Tabla);
        $this->db->where($where,$CodCli); 
        $this->db->order_by($order_by); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }

     public function save_seguimientos($CodCli,$CodRef,$FecSeg,$NumSeg,$ObsSeg,$RefSeg,$ResSeg,$TipSeg,$DesSeg)
    {
        $this->db->insert('T_Seguimiento',array('TipSeg'=>$TipSeg,'CodRef'=>$CodRef,'FecSeg'=>$FecSeg,'RefSeg'=>$RefSeg,'NumSeg'=>$NumSeg,'EstNotSeg'=>false,'ResSeg'=>$ResSeg,'ObsSeg'=>$ObsSeg,'CodCli'=>$CodCli,'DesSeg'=>$DesSeg));
        return $this->db->insert_id();
    }
    public function update_PropuestaComercial($CodCli,$CodRef,$ResSeg)
    {   
        $this->db->where('CodCli', $CodCli); 
        $this->db->where('CodProCom', $CodRef);       
        return $this->db->update('T_PropuestaComercial',array('UltTipSeg'=>$ResSeg));
    }
     public function update_ContratoComercial($CodCli,$CodRef,$ResSeg)
    {   
        $this->db->where('CodCli', $CodCli); 
        $this->db->where('CodConCom', $CodRef);       
        return $this->db->update('T_Contrato',array('UltTipSeg'=>$ResSeg));
    }
    public function update_OtrasGestionesComercial($CodCli,$CodRef,$ResSeg)
    {   
        $this->db->where('CodCli', $CodCli); 
        $this->db->where('CodGesGen', $CodRef);       
        return $this->db->update('T_OtrasGestiones',array('UltTipSeg'=>$ResSeg));
    }
     public function get_seguimientos($TipSeg,$CodRef,$CodCli)
    {
        $this->db->select('CodSeg,TipSeg,CodCli,CodRef,date_format(FecSeg,"%d/%m/%Y") as FecSeg,RefSeg,NumSeg,DesSeg,EstNotSeg,ResSeg,ObsSeg',false);
        $this->db->from('T_Seguimiento');
        $this->db->where('TipSeg',$TipSeg);
        $this->db->where('CodRef',$CodRef); 
        $this->db->where('CodCli',$CodCli);  
        $this->db->order_by('FecSeg desc'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function updateemailseguimiento($CodSeg,$EstNotSeg)
    {   
        $this->db->where('CodSeg', $CodSeg);  
        return $this->db->update('T_Seguimiento',array('EstNotSeg'=>$EstNotSeg));
    }
    public function getPropuestaComercialesFilter($SearchText)
    {
        $this->db->select('*',false);
        $this->db->from('VPropuestaSencillas');
        $this->db->like('DATE_FORMAT(FecProCom,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('NumCifCli',$SearchText);
        $this->db->or_like('RazSocCli',$SearchText);
        $this->db->or_like('CUPsEle',$SearchText);
        $this->db->or_like('CodCli',$SearchText);
        $this->db->or_like('CupsGas',$SearchText);
        $this->db->or_like('RefProCom',$SearchText);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;
    }
    public function PropuestasSencillas()
    {
        $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") AS FecProCom,b.CodCli,c.NumCifCli,c.RazSocCli,
(SELECT e.CUPsEle 
FROM T_Propuesta_Comercial_CUPs d 
left JOIN T_CUPsElectrico e ON e.CodCupsEle=d.CodCup 
left JOIN T_PuntoSuministro f ON f.CodPunSum=e.CodPunSum 
WHERE f.CodCli=c.CodCli and b.CodProComCli=d.CodProComCli and d.TipCups=1) AS CUPsEle
,(SELECT g.CupsGas 
FROM T_Propuesta_Comercial_CUPs i 
left JOIN T_CUPsGas g ON i.CodCup =g.CodCupGas 
left JOIN T_PuntoSuministro h ON h.CodPunSum=g.CodPunSum
WHERE h.CodCli=c.CodCli AND b.CodProComCli=i.CodProComCli and i.TipCups=2) AS CupsGas,a.EstProCom,a.RefProCom',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
        $this->db->join('T_Cliente c','b.CodCli=c.CodCli',"left");        
        $this->db->order_by('DATE_FORMAT(a.FecProCom,"%d/%m/%Y") DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
     public function BuscarDetallesCUPsSencilla($CodProComCli)
    {
        $this->db->select('*',false);
        $this->db->from('T_Propuesta_Comercial_CUPs');
        $this->db->where('CodProComCli',$CodProComCli);      
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function SelectHistorialCUPs($CodProComCli)
    {
        $this->db->select('*',false);
        $this->db->from('T_Propuesta_Comercial_CUPs');
        $this->db->where('CodProComCli',$CodProComCli);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function EliminarCUPs($CodProComCli)
    { 
        return $this->db->delete('T_Propuesta_Comercial_CUPs', array('CodProComCli' => $CodProComCli));
    }





///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL END ////////////////////////////////////////////////
}

?>
