<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Renovacionesmasivas_model extends CI_Model 
{
 
	public function get_list_comercializadora()
    {
        $this->db->select('a.CodCom,a.RazSocCom,a.NomComCom,a.NumCifCom,d.DesTipVia,d.IniTipVia,a.NomViaDirCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,b.DesLoc as CodLoc,b.CPLoc,c.DesPro as ProDirCom,a.TelFijCom,a.EmaCom,a.PagWebCom,a.NomConCom,a.CarConCom,case a.SerGas when 0 then "NO" WHEN 1 THEN "SI" end as SerGas,case a.SerEle when 0 then "NO" WHEN 1 THEN "SI" end as SerEle,case a.SerEsp when 0 then "NO" WHEN 1 THEN "SI" end as SerEsp,a.DocConCom,DATE_FORMAT(a.FecConCom,"%d/%m/%Y") as FecConCom,a.DurConCom,case a.RenAutConCom when 0 then "NO" WHEN 1 THEN "SI" end as RenAutConCom,DATE_FORMAT(a.FecVenConCom,"%d/%m/%Y") as FecVenConCom,DATE_FORMAT(a.FecIniCom,"%d/%m/%Y") as FecIniCom,a.ObsCom,case a.EstCom when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCom',false);
        $this->db->from('T_Comercializadora a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc','LEFT');
        $this->db->join('T_Provincia c','c.CodPro=b.CodPro','LEFT');
         $this->db->join('T_TipoVia d','a.CodTipVia=d.CodTipVia','LEFT');
        $this->db->order_by('a.RazSocCom ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return  $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function getProductosComercializadora($CodFilter)
    {
        $this->db->select('a.CodPro,a.DesPro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,a.ObsPro,DATE_FORMAT(a.FecIniPro,"%d/%m/%Y")as FecIniPro,case a.EstPro when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstPro,a.CodCom',FALSE);
        $this->db->from('T_Producto a');
        $this->db->where('CodCom',$CodFilter);
        $this->db->order_by('a.DesPro ASC');          
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
    public function getAnexosProductos($CodFilter)
    {
        $this->db->select('a.CodAnePro,a.DesAnePro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,case a.EstAne when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstAne,a.ObsAnePro,date_format(a.FecIniAne,"%d/%m/%Y") as FecIniAne,,a.DocAnePro,a.EstCom,a.CodTipCom,a.TipPre',FALSE);
        $this->db->from('T_AnexoProducto a');
        $this->db->where('a.CodPro',$CodFilter);
        $this->db->order_by('a.DesAnePro ASC');          
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
    public function getContratosFilters($FecDesde,$FecHasta,$CodCom,$CodPro,$CodAnePro)
    {
        $this->db->distinct();
        $this->db->select('DATE_FORMAT(a.FecVenCon,"%d/%m%/%Y") as FecVenCon,c.RazSocCli,d.DesPro,e.DesAnePro,a.CodConCom,a.CodProCom,c.CodCli,a.DurCon,b.CodCom,b.CodPro,b.CodAnePro',FALSE);
        $this->db->from('T_Contrato a');
        $this->db->join('T_PropuestaComercial b','b.CodProCom=a.CodProCom');
        $this->db->join('T_Cliente c','c.CodCli=a.CodCli');
        $this->db->join('T_Producto d','b.CodPro=d.CodPro');
        $this->db->join('T_AnexoProducto e','e.CodAnePro=b.CodAnePro');
        $this->db->where('a.FecVenCon BETWEEN "'. $FecDesde. '" AND "'.$FecHasta.'"');
        $this->db->where('b.CodCom',$CodCom);
        if($CodPro==0)
        {
        	$this->db->where('b.CodPro>0');
        }
        else
        {
        	$this->db->where('b.CodPro',$CodPro);
        }
        if($CodAnePro==0)
        {
        	$this->db->where('b.CodAnePro>0');
        }
        else
        {
        	$this->db->where('b.CodAnePro',$CodAnePro);
        }
        $this->db->where('a.EstBajCon=0');
        $this->db->order_by('a.FecVenCon ASC');
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
    public function Save_Renovaciones_Contratos($CodProCom,$CodCli,$FecIniCon,$EstRen,$RenMod,$ProRenPen,$FecIniCon,$DurCon,$NewFecVenCon,$FecIniCon,$NewFecVenCon)
    {        
    	
        $this->db->insert('T_Contrato',array('CodProCom'=>$CodProCom,'CodCli'=>$CodCli,'FecConCom'=>$FecIniCon,'EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen,'FecIniCon'=>$FecIniCon,'DurCon'=>$DurCon,'FecVenCon'=>$NewFecVenCon,'FecFirmCon'=>$FecIniCon,'FecFinCon'=>$NewFecVenCon));
        return $this->db->insert_id();
    }
    public function Update_Renovaciones_Contratos($CodConCom,$EstBajCon)
    {       	
        $this->db->where('CodConCom', $CodConCom);   
        return $this->db->update('T_Contrato',array('EstBajCon'=>$EstBajCon));
    }
    public function Update_Propuestas_Contratos($CodProCom,$CodPro,$CodAnePro)
    {       	
        $this->db->where('CodProCom', $CodProCom);   
        return $this->db->update('T_PropuestaComercial',array('CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro));
    }











}
?>