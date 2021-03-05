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
        /*$sql = $this->db->query("SELECT DISTINCT DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli
        ,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsEle as CUPsName
        FROM T_Propuesta_Comercial_CUPs a 
        JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
        JOIN T_PropuestaComercial c ON b.CodProCom=c.CodProCom
        JOIN T_Cliente d ON b.CodCli=d.CodCli AND c.TipProCom!=3
        JOIN T_CUPsElectrico e ON a.CodCup=e.CodCupsEle AND a.TipCups=1
        JOIN T_TarifaElectrica f ON a.CodTar=f.CodTarEle
        JOIN T_Comercializadora g ON c.CodCom=g.CodCom
        JOIN T_Contrato h ON c.CodProCom=h.CodProCom 
        JOIN T_Producto i ON c.CodPro=i.CodPro
        JOIN T_AnexoProducto j ON j.CodAnePro=c.CodAnePro
        where a.FecVenCUPs BETWEEN '$FecDesde' AND '$FecHasta' AND c.CodCom='$CodCom' and '$CodProWhere' and '$CodAneProWhere'
        
        UNION ALL
        
        SELECT DISTINCT DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli
        ,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsGas as CUPsName
        FROM T_Propuesta_Comercial_CUPs a 
        JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
        JOIN T_PropuestaComercial c ON b.CodProCom=c.CodProCom
        JOIN T_Cliente d ON b.CodCli=d.CodCli AND c.TipProCom!=3
        JOIN T_CUPsGas e ON a.CodCup=e.CodCupGas AND a.TipCups=2
        JOIN T_TarifaGas f ON a.CodTar=f.CodTarGas
        JOIN T_Comercializadora g ON c.CodCom=g.CodCom         
        JOIN T_Contrato h ON c.CodProCom=h.CodProCom 
        JOIN T_Producto i ON c.CodPro=i.CodPro
        JOIN T_AnexoProducto j ON j.CodAnePro=c.CodAnePro
        where a.FecVenCUPs BETWEEN '$FecDesde' and '$FecHasta' AND c.CodCom='$CodCom' and '$CodProWhere' and '$CodAneProWhere'

        UNION ALL

        SELECT DISTINCT DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.NomConCli as RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli
        ,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsEle as CUPsName
        FROM T_Propuesta_Comercial_CUPs a 
        JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
        JOIN T_PropuestaComercial c ON b.CodProCom=c.CodProCom
        JOIN T_ContactoCliente d ON b.CodCli=d.CodConCli AND c.TipProCom=3
        JOIN T_CUPsElectrico e ON a.CodCup=e.CodCupsEle AND a.TipCups=1
        JOIN T_TarifaElectrica f ON a.CodTar=f.CodTarEle
        JOIN T_Comercializadora g ON c.CodCom=g.CodCom
        JOIN T_Contrato h ON c.CodProCom=h.CodProCom
        JOIN T_Producto i ON c.CodPro=i.CodPro
        JOIN T_AnexoProducto j ON j.CodAnePro=c.CodAnePro
        where a.FecVenCUPs BETWEEN '$FecDesde' and '$FecHasta' AND c.CodCom='$CodCom' and '$CodProWhere' and '$CodAneProWhere'

        UNION ALL

        SELECT DISTINCT DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.NomConCli as RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli
        ,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsGas as CUPsName
        FROM T_Propuesta_Comercial_CUPs a 
        JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
        JOIN T_PropuestaComercial c ON b.CodProCom=c.CodProCom
        JOIN T_ContactoCliente d ON b.CodCli=d.CodConCli AND c.TipProCom=3
        JOIN T_CUPsGas e ON a.CodCup=e.CodCupGas AND a.TipCups=2
        JOIN T_TarifaGas f ON a.CodTar=f.CodTarGas
        JOIN T_Comercializadora g ON c.CodCom=g.CodCom
        JOIN T_Contrato h ON c.CodProCom=h.CodProCom
        JOIN T_Producto i ON c.CodPro=i.CodPro
        JOIN T_AnexoProducto j ON j.CodAnePro=c.CodAnePro
        where a.FecVenCUPs BETWEEN '$FecDesde' and '$FecHasta' AND c.CodCom='$CodCom' and '$CodProWhere' and '$CodAneProWhere'

        ORDER BY FecVenCUPs DESC");
            if ($sql->num_rows() > 0)
              return $sql->result();
            else  
            return false; */

            $this->db->distinct();
            $this->db->select("DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsEle as CUPsName,a.EstConCups");
            $this->db->from('T_Propuesta_Comercial_CUPs as a');
            $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProComCli=b.CodProComCli');
            $this->db->join('T_PropuestaComercial c','b.CodProCom=c.CodProCom AND c.TipProCom!=3');
            $this->db->join('T_Cliente d','b.CodCli=d.CodCli');
            $this->db->join('T_CUPsElectrico e','a.CodCup=e.CodCupsEle AND a.TipCups=1');
            $this->db->join('T_TarifaElectrica f','a.CodTar=f.CodTarEle');
            $this->db->join('T_Comercializadora g','c.CodCom=g.CodCom');
            $this->db->join('T_Contrato h','h.CodProCom=c.CodProCom');
            $this->db->join('T_Producto i','c.CodPro=i.CodPro');
            $this->db->join('T_AnexoProducto j','j.CodAnePro=c.CodAnePro');
            $this->db->where('a.FecVenCUPs BETWEEN "'. $FecDesde. '" AND "'.$FecHasta.'"');
            $this->db->where('c.CodCom',$CodCom);
            if($CodPro==0)
            {
                $this->db->where('c.CodPro>0');
            }
            else
            {
                $this->db->where('c.CodPro',$CodPro);
            }
            if($CodAnePro==0)
            {
                $this->db->where('c.CodAnePro>0');
            }
            else
            {
                $this->db->where('c.CodAnePro',$CodAnePro);
            }
            $query1 = $this->db->get_compiled_select();
            $this->db->distinct();
            $this->db->select("DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsGas as CUPsName,a.EstConCups");
            $this->db->from('T_Propuesta_Comercial_CUPs as a');
            $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProComCli=b.CodProComCli');
            $this->db->join('T_PropuestaComercial c','b.CodProCom=c.CodProCom AND c.TipProCom!=3');
            $this->db->join('T_Cliente d','b.CodCli=d.CodCli');
            $this->db->join('T_CUPsGas e','a.CodCup=e.CodCupGas AND a.TipCups=2');
            $this->db->join('T_TarifaGas f','a.CodTar=f.CodTarGas');
            $this->db->join('T_Comercializadora g','c.CodCom=g.CodCom');
            $this->db->join('T_Contrato h','h.CodProCom=c.CodProCom');
            $this->db->join('T_Producto i','c.CodPro=i.CodPro');
            $this->db->join('T_AnexoProducto j','j.CodAnePro=c.CodAnePro');
            $this->db->where('a.FecVenCUPs BETWEEN "'. $FecDesde. '" AND "'.$FecHasta.'"');
            $this->db->where('c.CodCom',$CodCom);
            if($CodPro==0)
            {
                $this->db->where('c.CodPro>0');
            }
            else
            {
                $this->db->where('c.CodPro',$CodPro);
            }
            if($CodAnePro==0)
            {
                $this->db->where('c.CodAnePro>0');
            }
            else
            {
                $this->db->where('c.CodAnePro',$CodAnePro);
            }
            $query2 = $this->db->get_compiled_select();
            $this->db->distinct();
            $this->db->select("DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.NomConCli as RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsEle as CUPsName,a.EstConCups");
            $this->db->from('T_Propuesta_Comercial_CUPs as a');
            $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProComCli=b.CodProComCli');
            $this->db->join('T_PropuestaComercial c','b.CodProCom=c.CodProCom AND c.TipProCom=3');
            $this->db->join('T_ContactoCliente d','b.CodCli=d.CodConCli');
            $this->db->join('T_CUPsElectrico e','a.CodCup=e.CodCupsEle AND a.TipCups=1');
            $this->db->join('T_TarifaElectrica f','a.CodTar=f.CodTarEle');
            $this->db->join('T_Comercializadora g','c.CodCom=g.CodCom');
            $this->db->join('T_Contrato h','h.CodProCom=c.CodProCom');
            $this->db->join('T_Producto i','c.CodPro=i.CodPro');
            $this->db->join('T_AnexoProducto j','j.CodAnePro=c.CodAnePro');
            $this->db->where('a.FecVenCUPs BETWEEN "'. $FecDesde. '" AND "'.$FecHasta.'"');
            $this->db->where('c.CodCom',$CodCom);
            if($CodPro==0)
            {
                $this->db->where('c.CodPro>0');
            }
            else
            {
                $this->db->where('c.CodPro',$CodPro);
            }
            if($CodAnePro==0)
            {
                $this->db->where('c.CodAnePro>0');
            }
            else
            {
                $this->db->where('c.CodAnePro',$CodAnePro);
            }
            $query3 = $this->db->get_compiled_select();
            $this->db->distinct();
            $this->db->select("DATE_FORMAT(a.FecVenCUPs,'%d/%m%/%Y') as FecVenCon,d.NomConCli as RazSocCli,i.DesPro,j.DesAnePro,a.CodProComCup,a.CodProComCli,b.CodProCom,c.CodCom,c.CodPro,c.CodAnePro,b.CodCli,h.CodConCom,a.FecVenCUPs,a.TipCups,e.CUPsGas as CUPsName,a.EstConCups");
            $this->db->from('T_Propuesta_Comercial_CUPs as a');
            $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProComCli=b.CodProComCli');
            $this->db->join('T_PropuestaComercial c','b.CodProCom=c.CodProCom AND c.TipProCom=3');
            $this->db->join('T_ContactoCliente d','b.CodCli=d.CodConCli');
            $this->db->join('T_CUPsGas e','a.CodCup=e.CodCupGas AND a.TipCups=2');
            $this->db->join('T_TarifaGas f','a.CodTar=f.CodTarGas');
            $this->db->join('T_Comercializadora g','c.CodCom=g.CodCom');
            $this->db->join('T_Contrato h','h.CodProCom=c.CodProCom');
            $this->db->join('T_Producto i','c.CodPro=i.CodPro');
            $this->db->join('T_AnexoProducto j','j.CodAnePro=c.CodAnePro');
            $this->db->where('a.FecVenCUPs BETWEEN "'. $FecDesde. '" AND "'.$FecHasta.'"');
            $this->db->where('c.CodCom',$CodCom);
            if($CodPro==0)
            {
                $this->db->where('c.CodPro>0');
            }
            else
            {
                $this->db->where('c.CodPro',$CodPro);
            }
            if($CodAnePro==0)
            {
                $this->db->where('c.CodAnePro>0');
            }
            else
            {
                $this->db->where('c.CodAnePro',$CodAnePro);
            }
            $query4 = $this->db->get_compiled_select();
            return $this->db->query($query1." UNION ALL ".$query2." UNION ALL ".$query3." UNION ALL ".$query4)->result();
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