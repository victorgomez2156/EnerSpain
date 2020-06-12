<?php
class Contratos_model extends CI_Model 
{	
///////////////////////////////////////////////// PARA CONTRATOS START ///////////////////////////////////////////////

 	public function get_list_contratos()
    {
        $this->db->select("a.CodConCom,a.CodProCom,b.RazSocCli,b.NumCifCli,DATE_FORMAT(a.FecConCom,'%d/%m/%Y') as FecConCom,a.DurCon,DATE_FORMAT(a.FecVenCon,'%d/%m/%Y') as FecVenCon,a.EstBajCon,
        	CONCAT(d.RazSocCom,' - ', d.NumCifCom) as CodCom,e.DesAnePro as Anexo,b.CodCli,DATE_FORMAT(a.FecIniCon,'%d/%m/%Y') as FecIniCon
        	"/*'a.CodProCom,,b.RazSocCli,b.NumCifCli,case a.EstProCom when "P" then "Pendiente" when "A" then "Aprobada" when "C" then "Completada" when "R" then "Rechazada" end as EstProCom,c.CUPsEle,d.CupsGas'*/,false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_PropuestaComercial c','c.CodProCom=a.CodProCom');
        $this->db->join('T_Comercializadora d','d.CodCom=c.CodCom');
        $this->db->join('T_AnexoProducto e','e.CodAnePro=c.CodAnePro');
        $this->db->order_by('a.FecIniCon desc');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function BuscarPropuestaAprobada($CodCli,$metodo)
    {
        $this->db->select('a.CodProCom,a.CodCli,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,a.CodPunSum,a.CodCupsEle,a.CodTarEle,a.PotConP1,a.PotConP2,a.PotConP3,a.PotConP4,a.PotConP5,a.PotConP6,a.ImpAhoEle,a.PorAhoEle,a.RenConEle,a.ObsAhoEle,a.CodCupsGas,a.CodTarGas,a.Consumo,a.CauDia,a.ImpAhoGas,a.PorAhoGas,a.RenConGas,a.ObsAhoGas,a.PorAhoTot,a.ImpAhoTot,a.EstProCom,a.JusRecProCom,a.CodCom,a.CodPro,a.CodAnePro,case a.TipPre when 0 then "Fijo" when 1 then "Indexado" when 2 then "Ambos" end as TipPre,a.UltTipSeg,a.ObsProCom,a.RefProCom,CONCAT(c.IniTipVia," - ", c.DesTipVia," ",b.NomViaPunSum," ",b.NumViaPunSum) as DirPunSum,b.BloPunSum,b.EscPunSum ,b.PlaPunSum,b.PuePunSum,b.CPLocSoc,d.DesLoc,e.DesPro,f.CUPsEle,g.NomTarEle,h.CupsGas,i.NomTarGas,CONCAT(j.RazSocCom," - ", j.NumCifCom) as NomCom,k.DesPro as DesProducto,l.DesAnePro,g.CanPerTar',false);
        $this->db->from('T_PropuestaComercial a'); 
        $this->db->join('T_PuntoSuministro b','a.CodPunSum=b.CodPunSum');
        $this->db->join('T_TipoVia c','b.CodTipVia=c.CodTipVia'); 
        $this->db->join('T_Localidad d','b.CodLoc=d.CodLoc');
        $this->db->join('T_Provincia e','e.CodPro=d.CodPro');     
        $this->db->join('T_CUPsElectrico f','f.CodCupsEle=a.CodCupsEle',"left");
        $this->db->join('T_TarifaElectrica g','g.CodTarEle=a.CodTarEle',"left");
        $this->db->join('T_CUPsGas h','h.CodCupGas=a.CodCupsGas',"left");
        $this->db->join('T_TarifaGas i','i.CodTarGas=a.CodTarGas',"left");
        $this->db->join('T_Comercializadora j','j.CodCom=a.CodCom');
        $this->db->join('T_Producto k','k.CodPro=a.CodPro');
        $this->db->join('T_AnexoProducto l','l.CodAnePro=a.CodAnePro');
        $this->db->where('a.CodCli',$CodCli);
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
    public function update_propuesta($CodProCom,$EstProCom,$CodCli)
    {   
        $this->db->where('CodProCom', $CodProCom); 
        $this->db->where('CodCli', $CodCli);       
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
    public function update_DBcontrato($CodCli,$CodProCom,$FecIniCon,$DurCon,$FecVenCon,$ObsCon,$DocConRut,$CodConCom,$RefCon)
    {   
        $this->db->where('CodConCom', $CodConCom);
        $this->db->where('CodCli', $CodCli);  
        return $this->db->update('T_Contrato',array('FecIniCon'=>$FecIniCon,'DurCon'=>$DurCon,'FecVenCon'=>$FecVenCon,'DocConRut'=>$DocConRut,'ObsCon'=>$ObsCon,'RefCon'=>$RefCon));
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
        $this->db->select("a.CodConCom,a.CodProCom,b.RazSocCli,b.NumCifCli,DATE_FORMAT(a.FecConCom,'%d/%m/%Y') as FecConCom,a.DurCon,DATE_FORMAT(a.FecVenCon,'%d/%m/%Y') as FecVenCon,a.EstBajCon,
            CONCAT(d.RazSocCom,' - ', d.NumCifCom) as CodCom,e.DesAnePro as Anexo,b.CodCli,DATE_FORMAT(a.FecIniCon,'%d/%m/%Y') as FecIniCon",false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_PropuestaComercial c','c.CodProCom=a.CodProCom');
        $this->db->join('T_Comercializadora d','d.CodCom=c.CodCom');
        $this->db->join('T_AnexoProducto e','e.CodAnePro=c.CodAnePro');
        $this->db->like('DATE_FORMAT(a.FecConCom,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('b.NumCifCli',$SearchText);
        $this->db->or_like('b.RazSocCli',$SearchText);
        $this->db->or_like('d.RazSocCom',$SearchText);
        $this->db->or_like('d.NumCifCom',$SearchText);
        $this->db->or_like('e.DesAnePro',$SearchText);
        $this->db->or_like('a.DurCon',$SearchText);
        $this->db->or_like('DATE_FORMAT(a.FecVenCon,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('a.RefCon',$SearchText);
        $this->db->order_by('a.FecIniCon DESC');              
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




///////////////////////////////////////////////// PARA CONTRATOS END ////////////////////////////////////////////////
}
?>