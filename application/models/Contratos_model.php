<?php
class Contratos_model extends CI_Model 
{	
///////////////////////////////////////////////// PARA CONTRATOS START ///////////////////////////////////////////////

 	public function get_list_contratos()
    {
        $this->db->select("CodConCom,CodProCom,DATE_FORMAT(FecConCom,'%d/%m/%Y') as FecConCom,DurCon,DATE_FORMAT(FecVenCon,'%d/%m/%Y') as FecVenCon,EstBajCon,DATE_FORMAT(FecIniCon,'%d/%m/%Y') as FecIniCon,CodCli,NumCifCli,RazSocCli,CodCom,Anexo,NumCifCom,RefCon,CUPsEle,CupsGas",false);
        $this->db->from('View_Contratos');
        //$this->db->order_by('DATE_FORMAT(FecConCom,"%Y/%m/%d") ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function BuscarPropuestaAprobada($CodCli,$metodo)
    {
        $this->db->select('a.CodProCom,b.CodCli,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,a.RefProCom,a.EstProCom,a.JusRecProCom,a.CodCom,a.CodPro,a.CodAnePro,case a.TipPre when 0 then "Fijo" when 1 then "Indexado" when 2 then "Ambos" end as TipPre,a.UltTipSeg,a.ObsProCom,j.NumCifCom,j.RazSocCom,k.DesPro as DesProducto,l.DesAnePro,a.TipProCom,b.CodProComCli'





            /*'CONCAT(c.IniTipVia," - ", c.DesTipVia," ",b.NomViaPunSum," ",b.NumViaPunSum) as DirPunSum,b.BloPunSum,b.EscPunSum ,b.PlaPunSum,b.PuePunSum,b.CPLocSoc,d.DesLoc,e.DesPro,f.CUPsEle,g.NomTarEle,h.CupsGas,i.NomTarGas,g.CanPerTar'*/,false);
        $this->db->from('T_PropuestaComercial a'); 
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom','LEFT');
        //$this->db->join('T_PuntoSuministro b','a.CodPunSum=b.CodPunSum');
        ///$this->db->join('T_TipoVia c','b.CodTipVia=c.CodTipVia'); 
        //$this->db->join('T_Localidad d','b.CodLoc=d.CodLoc');
        //$this->db->join('T_Provincia e','e.CodPro=d.CodPro');     
        //$this->db->join('T_CUPsElectrico f','f.CodCupsEle=a.CodCupsEle',"left");
        //$this->db->join('T_TarifaElectrica g','g.CodTarEle=a.CodTarEle',"left");
        //$this->db->join('T_CUPsGas h','h.CodCupGas=a.CodCupsGas',"left");
        //$this->db->join('T_TarifaGas i','i.CodTarGas=a.CodTarGas',"left");
        $this->db->join('T_Comercializadora j','j.CodCom=a.CodCom','LEFT');
        $this->db->join('T_Producto k','k.CodPro=a.CodPro','LEFT');
        $this->db->join('T_AnexoProducto l','l.CodAnePro=a.CodAnePro','LEFT');
        $this->db->where('b.CodCli',$CodCli);
        if($metodo==1)
        {
            $this->db->where('a.EstProCom','A');  
        }        
        $this->db->order_by('a.FecProCom DESC');
        //$this->db->limit(1);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function BuscarPropuestaAprobadaNewVer($CodCli,$metodo)
    {
        $this->db->select('a.CodProCom,b.CodCli,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,a.PorAhoTot,a.ImpAhoTot,a.EstProCom,a.JusRecProCom,a.CodCom,a.CodPro,a.CodAnePro,case a.TipPre when 0 then "Fijo" when 1 then "Indexado" when 2 then "Ambos" end as TipPre,a.UltTipSeg,a.ObsProCom,a.RefProCom,a.TipProCom,c.NumCifCom, c.RazSocCom,d.DesPro as DesProducto,e.DesAnePro,b.CodProComCli',false);
        $this->db->from('T_PropuestaComercial a'); 
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom','LEFT');
        $this->db->join('T_Comercializadora c','c.CodCom=a.CodCom');
        $this->db->join('T_Producto d','d.CodPro=a.CodPro');
        $this->db->join('T_AnexoProducto e','e.CodAnePro=a.CodAnePro');


        $this->db->where('b.CodCli',$CodCli);
        if($metodo==1)
        {
            $this->db->where('a.EstProCom','A');  
        }        
        $this->db->order_by('a.FecProCom DESC');
        //$this->db->limit(1);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function agregar_contrato($CodCli,$CodProCom,$FecConCom,$EstRen,$RenMod,$ProRenPen,$FecIniCon,$DurCon,$FecVenCon,$RefCon,$ObsCon,$DocConRut)
    {
        $this->db->insert('T_Contrato',array('CodProCom'=>$CodProCom,'CodCli'=>$CodCli,'FecConCom'=>$FecConCom,'EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen,'FecIniCon'=>$FecIniCon,'RefCon'=>$RefCon,'ObsCon'=>$ObsCon,'DocConRut'=>$DocConRut,'FecVenCon'=>$FecVenCon,'DurCon'=>$DurCon));
        return $this->db->insert_id();
    }
    public function update_propuesta($CodProCom,$EstProCom)
    {   
        $this->db->where('CodProCom', $CodProCom);   
        return $this->db->update('T_PropuestaComercial',array('EstProCom'=>$EstProCom));
    }
    public function update_CUPsEleDB($CodCupsEle,$CodTarEle,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6)
    {   
        $this->db->where('CodCupsEle', $CodCupsEle);
        return $this->db->update('T_CUPsElectrico',array('CodTarElec'=>$CodTarEle,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6));
    }
    public function update_CUPsGasDB($CodCupsGas,$CodTarGas,$Consumo)
    {   
        $this->db->where('CodCupGas', $CodCupsGas); 
        return $this->db->update('T_CUPsGas',array('CodTarGas'=>$CodTarGas,'ConAnuCup'=>$Consumo));
    }
    public function update_contrato_documento($CodConCom,$DocConRut)
    {   
        $this->db->where('CodConCom', $CodConCom); 
        return $this->db->update('T_Contrato',array('DocConRut'=>$DocConRut));
    }
    public function update_DBcontrato($CodCli,$CodProCom,$FecIniCon,$DurCon,$FecVenCon,$ObsCon,$DocConRut,$CodConCom,$RefCon,$FecFirmCon,$FecAct)
    {   
        $this->db->where('CodConCom', $CodConCom);
        $this->db->where('CodCli', $CodCli);  
        return $this->db->update('T_Contrato',array('FecIniCon'=>$FecIniCon,'DurCon'=>$DurCon,'FecVenCon'=>$FecVenCon,'DocConRut'=>$DocConRut,'ObsCon'=>$ObsCon,'RefCon'=>$RefCon,'FecFirmCon'=>$FecFirmCon,'FecAct'=>$FecAct));
    }
    public function update_bajaContrato($CodConCom,$FecBajCon,$JusBajCon,$EstBajCon)
    {   
        $this->db->where('CodConCom', $CodConCom);
        return $this->db->update('T_Contrato',array('FecBajCon'=>$FecBajCon,'JusBajCon'=>$JusBajCon,'EstBajCon'=>$EstBajCon));
    }
    public function update_status_contrato_old($CodConCom,$EstBajCon)
    {   
        $this->db->where('CodConCom', $CodConCom);
        return $this->db->update('T_Contrato',array('EstBajCon'=>$EstBajCon));
    }
    public function update_status_contrato_modificaciones($CodCli,$CodConCom,$EstRen,$RenMod,$ProRenPen,$EstBajCon)
    {   
        $this->db->where('CodCli', $CodCli);
        $this->db->where('CodConCom', $CodConCom);
        return $this->db->update('T_Contrato',array('EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen,'EstBajCon'=>$EstBajCon));
    }
    public function getContratosFilter($SearchText)
    {
        $this->db->select("CodConCom,CodProCom,DATE_FORMAT(FecConCom,'%d/%m/%Y') as FecConCom,DurCon,DATE_FORMAT(FecVenCon,'%d/%m/%Y') as FecVenCon,EstBajCon,DATE_FORMAT(FecIniCon,'%d/%m/%Y') as FecIniCon,CodCli,NumCifCli,RazSocCli,CodCom,Anexo,NumCifCom,RefCon,CUPsEle,CupsGas",false);
        $this->db->from('View_Contratos');
        $this->db->like('DATE_FORMAT(FecConCom,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('NumCifCli',$SearchText);
        $this->db->or_like('RazSocCli',$SearchText);
        $this->db->or_like('CodCom',$SearchText);
        $this->db->or_like('NumCifCom',$SearchText);
        $this->db->or_like('Anexo',$SearchText);
        $this->db->or_like('DurCon',$SearchText);
        $this->db->or_like('DATE_FORMAT(FecVenCon,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('RefCon',$SearchText);
        $this->db->or_like('CodCli',$SearchText);
        //$this->db->order_by('FecIniCon DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;           
    }
    public function getaudaxcontactos($CodCli,$CodConCom,$CodProCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_ContactoCliente');       
        $this->db->where('CodCli',$CodCli);            
        $this->db->order_by('NomConCli ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function getaudaxcuentasbancarias($CodCli)
    {
        $this->db->select('*',false);
        $this->db->from('T_CuentaBancaria');       
        $this->db->where('CodCli',$CodCli);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function validar_renovacion($CodCli,$CodConCom,$diasAnticipacion)
    {
        $FechaActual=date('Y-m-d');
        $FecVenCon='FecVenCon';
        $this->db->select('*',false);
        $this->db->from('T_Contrato');       
        $this->db->where('CodCli',$CodCli);
        $this->db->where('CodConCom',$CodConCom);
        $this->db->where('FecVenCon BETWEEN "'. $FechaActual. '" AND "'.$diasAnticipacion.'"');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
	//$this->db->where("$accommodation BETWEEN $minvalue AND $maxvalue");
    public function Buscar_Contratos_TipRen($Variable)
    {
        $this->db->select('*',false);
        $this->db->from('T_Contrato');       
        $this->db->where('CodCli',$Variable); 
        $this->db->where('ProRenPen=1');         
        //$this->db->order_by('FecConCom DESC');   
        //$this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function AsignarPropuesta($CodCli,$FecProCom,$CodPunSum,$CodCupsEle,$CodTarEle,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$ImpAhoEle,$PorAhoEle,$RenConEle,$ObsAhoEle,$CodCupsGas,$CodTarGas,$Consumo,$CauDia,$ImpAhoGas,$PorAhoGas,$RenConGas,$ObsAhoGas,$PorAhoTot,$ImpAhoTot,$CodCom,$CodPro,$CodAnePro,$TipPre,$ObsProCom,$RefProCom)
    {
        $this->db->insert('T_PropuestaComercial',array('CodCli'=>$CodCli,'FecProCom'=>$FecProCom,'CodPunSum'=>$CodPunSum,'CodCupsEle'=>$CodCupsEle,'CodTarEle'=>$CodTarEle,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6,'ImpAhoEle'=>$ImpAhoEle,'PorAhoEle'=>$PorAhoEle,'RenConEle'=>$RenConEle,'ObsAhoEle'=>$ObsAhoEle,'CodCupsGas'=>$CodCupsGas,'CodTarGas'=>$CodTarGas,'Consumo'=>$Consumo,'CauDia'=>$CauDia,'ImpAhoGas'=>$ImpAhoGas,'PorAhoGas'=>$PorAhoGas,'RenConGas'=>$RenConGas,'ObsAhoGas'=>$ObsAhoGas,'PorAhoTot'=>$PorAhoTot,'ImpAhoTot'=>$ImpAhoTot  ,'EstProCom'=>'C'    ,'CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ObsProCom'=>$ObsProCom,'RefProCom'=>$RefProCom));
        return $this->db->insert_id();
    }
    public function UpdateContratoFromPropuesta($CodConCom,$CodCli,$CodProCom)
    {   
        $this->db->where('CodConCom', $CodConCom);
        $this->db->where('CodCli', $CodCli);
        return $this->db->update('T_Contrato',array('CodProCom'=>$CodProCom));
    }




///////////////////////////////////////////////// PARA CONTRATOS END ////////////////////////////////////////////////
}
?>