<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clientes_model extends CI_Model 
{ 
/////////////////////////////////////////// CLIENTES START ///////////////////////////////////////
    public function get_list_clientes() 
    {
        $this->db->select('a.CodCli,a.NumCifCli,a.RazSocCli,a.TelFijCli,a.NomComCli,b.DesTipVia as CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,d.DesPro as CodPro,c.DesLoc as CodLoc,a.EmaCli,a.WebCli,e.DesTipCli as CodTipCli,DATE_FORMAT(a.FecIniCli,"%d/%m/%Y") as FecIniCli,f.NomCom as CodCom,a.ObsCli,a.EstCli,g.DesSecCli AS CodSecCli,h.NomCol AS CodCol,i.DesTipVia as CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,k.DesPro as CodProFis,j.DesLoc as CodLocFis,CASE a.EstCli WHEN 1 THEN "ACTIVO" WHEN 2 THEN "SUSPENDIDO" END AS EstCliN,a.CodTipViaSoc as CodTipViaSoc1,a.CodLocSoc as CodLocSoc1,c.CodPro as CodProSoc2,a.CodTipCli as CodTipCliSoc2,a.CodSecCli as CodSecCliSoc2,c.CPLoc as CPLocSoc,a.CodTipViaFis as CodTipViaFis2,a.CodLocFis as CodLocFis2,j.CodPro as CodProFis2,j.CPLoc as CPLocFis,a.CodCom as CodCom2,a.CodCol as CodCol2 ',FALSE);
        $this->db->from('T_Cliente a'); 
        $this->db->join('T_TipoVia b','a.CodTipViaSoc=b.CodTipVia','LEFT');       
        $this->db->join('T_Localidad c','a.CodLocSoc=c.CodLoc','LEFT'); 
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro','LEFT');
        $this->db->join('T_TipoCliente e','a.CodTipCli=e.CodTipCli','LEFT');
        $this->db->join('T_Comercial f','a.CodCom=f.CodCom','LEFT');
        $this->db->join('T_SectorCliente g','a.CodSecCli=g.CodSecCli','LEFT');
        $this->db->join('T_Colaborador h','a.CodCol=h.CodCol','LEFT'); 
        $this->db->join('T_TipoVia i','a.CodTipViaFis=i.CodTipVia','LEFT');
        $this->db->join('T_Localidad j','a.CodLocFis=j.CodLoc','LEFT'); 
        $this->db->join('T_Provincia k','j.CodPro=k.CodPro','LEFT');       
        $this->db->order_by('a.RazSocCli ASC');              
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
    public function agregar($BloDomFis,$BloDomSoc,$CodCol,$CodCom,$CodLocFis,$CodLocSoc,$CodProFis,$CodProSoc,$CodSecCli,$CodTipCli,$CodTipViaFis,$CodTipViaSoc,$EmaCli,$EscDomFis,$EscDomSoc,$FecIniCli,$NomComCli,$NomViaDomFis,$NomViaDomSoc,$NumCifCli,$NumViaDomFis,$NumViaDomSoc,$ObsCli,$PlaDomFis,$PlaDomSoc,$PueDomFis,$PueDomSoc,$RazSocCli,$TelFijCli,$WebCli,$CPLocSoc,$CPLocFis,$TelMovCli,$EmaCliOpc)
    {
        $this->db->select('NumCifCli');
        $this->db->from('T_Cliente');
        $this->db->where('NumCifCli', $NumCifCli);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return false;
        }
        else
        {
            $this->db->insert('T_Cliente',array('RazSocCli'=>$RazSocCli,'NomComCli'=>$NomComCli,'NumCifCli'=>$NumCifCli,'CodTipViaSoc'=>$CodTipViaSoc,'NomViaDomSoc'=>$NomViaDomSoc,'NumViaDomSoc'=>$NumViaDomSoc,'BloDomSoc'=>$BloDomSoc,'EscDomSoc'=>$EscDomSoc,'PlaDomSoc'=>$PlaDomSoc,'PueDomSoc'=>$PueDomSoc,'CodLocSoc'=>$CodLocSoc,'CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'BloDomFis'=>$BloDomFis,'EscDomFis'=>$EscDomFis,'PlaDomFis'=>$PlaDomFis,'PueDomFis'=>$PueDomFis,'CodLocFis'=>$CodLocFis,'TelFijCli'=>$TelFijCli,'EmaCli'=>$EmaCli,'WebCli'=>$WebCli,'CodTipCli'=>$CodTipCli,'CodSecCli'=>$CodSecCli,'FecIniCli'=>$FecIniCli,'CodCom'=>$CodCom,'CodCol'=>$CodCol,'ObsCli'=>$ObsCli,'CPLocSoc'=>$CPLocSoc,'CPLocFis'=>$CPLocFis,'TelMovCli'=>$TelMovCli,'EmaCliOpc'=>$EmaCliOpc));
            return $this->db->insert_id();
        } 
    }
    public function actualizar($CodCli,$BloDomFis,$BloDomSoc,$CodCol,$CodCom,$CodLocFis,$CodLocSoc,$CodProFis,$CodProSoc,$CodSecCli,$CodTipCli,$CodTipViaFis,$CodTipViaSoc,$EmaCli,$EscDomFis,$EscDomSoc,$NomComCli,$NomViaDomFis,$NomViaDomSoc,$NumViaDomFis,$NumViaDomSoc,$ObsCli,$PlaDomFis,$PlaDomSoc,$PueDomFis,$PueDomSoc,$RazSocCli,$TelFijCli,$WebCli,$FecIniCli,$CPLocSoc,$CPLocFis,$TelMovCli,$EmaCliOpc)
    {   
        $this->db->where('CodCli', $CodCli);        
        return $this->db->update('T_Cliente',array('RazSocCli'=>$RazSocCli,'NomComCli'=>$NomComCli,'CodTipViaSoc'=>$CodTipViaSoc,'NomViaDomSoc'=>$NomViaDomSoc,'NumViaDomSoc'=>$NumViaDomSoc,'BloDomSoc'=>$BloDomSoc,'EscDomSoc'=>$EscDomSoc,'PlaDomSoc'=>$PlaDomSoc,'PueDomSoc'=>$PueDomSoc,'CodLocSoc'=>$CodLocSoc,'CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'BloDomFis'=>$BloDomFis,'EscDomFis'=>$EscDomFis,'PlaDomFis'=>$PlaDomFis,'PueDomFis'=>$PueDomFis,'CodLocFis'=>$CodLocFis,'TelFijCli'=>$TelFijCli,'EmaCli'=>$EmaCli,'WebCli'=>$WebCli,'CodTipCli'=>$CodTipCli,'CodSecCli'=>$CodSecCli,'CodCom'=>$CodCom,'CodCol'=>$CodCol,'ObsCli'=>$ObsCli,'FecIniCli'=>$FecIniCli,'CPLocSoc'=>$CPLocSoc,'CPLocFis'=>$CPLocFis,'TelMovCli'=>$TelMovCli,'EmaCliOpc'=>$EmaCliOpc));
    }
    public function get_data_cliente($CodCli)
    { 
        $sql = $this->db->query("SELECT a.CodCli,a.RazSocCli,a.NomComCli,a.NumCifCli,d.IniTipVia AS IniTipViasSoc,d.DesTipVia as DesTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,b.DesLoc as DesLocSoc,c.DesPro as DesProSoc,a.CodLocSoc,b.CodPro,a.CPLocSoc as CPLocSoc,g.IniTipVia as IniTipViaFis,g.DesTipVia as DesTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,e.DesLoc as DesLocFis,a.CodLocFis,f.DesPro as DesProFis,f.CodPro as CodProFis,a.TelFijCli,a.EmaCli,a.TelMovCli,a.EmaCliOpc,a.CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,a.CodLocSoc,b.CodPro as CodProSoc,a.CPLocSoc
            FROM T_Cliente a 
            left JOIN T_Localidad b on b.CodLoc=a.CodLocSoc
            left JOIN T_Provincia c on b.CodPro=c.CodPro
            left JOIN T_TipoVia   d on a.CodTipViaSoc=d.CodTipVia
            left JOIN T_Localidad e on a.CodLocFis=e.CodLoc
            left JOIN T_Provincia f on e.CodPro=f.CodPro
            left JOIN T_TipoVia   g on a.CodTipViaFis=g.CodTipVia
            where CodCli='$CodCli'");
        if ($sql->num_rows() > 0)
          return $sql->row();
      else
        return false;     
}
public function get_data_puntos_suministros($CodCli)
{
    $sql = $this->db->query("SELECT a.CodPunSum,a.CodCli,CONCAT(a.NomViaPunSum,' ',a.NumViaPunSum) AS DirPumSum,c.DesPro,b.DesLoc,a.EscPunSum,a.PlaPunSum,a.PuePunSum,a.CPLocSoc from T_PuntoSuministro a
        JOIN T_Localidad b on b.CodLoc=a.CodLoc
        JOIN T_Provincia c on b.CodPro=c.CodPro
        JOIN T_TipoVia   d on a.CodTipVia=d.CodTipVia where CodCli='$CodCli'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;     
}
public function get_CUPs_Electricos_Dashboard($CodCli)
{
    $sql = $this->db->query("SELECT a.CodCupsEle,b.CodCli,a.CUPsEle,g.RazSocDis,f.NomTarEle,CONCAT(b.NomViaPunSum,' ',b.NumViaPunSum,' ',d.DesPro,' ',c.DesLoc) AS DirPumSum,CONCAT(b.EscPunSum,' ',b.PlaPunSum,' ',b.PuePunSum) AS EscPlaPue,b.CPLocSoc,f.CanPerTar,a.PotConP1,a.PotConP2,a.PotConP3,a.PotConP4,a.PotConP5,a.PotConP6,case a.TipServ when 1 then 'E' end as TipServ,(SELECT h.EstConCups FROM T_Propuesta_Comercial_CUPs h WHERE a.CodCupsEle=h.CodCup AND h.TipCups=1 ORDER BY h.CodProComCup DESC LIMIT 1) AS EstConCups
        FROM T_CUPsElectrico a 
        LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum 
        LEFT JOIN T_Localidad c on c.CodLoc=b.CodLoc
        LEFT JOIN T_Provincia d on d.CodPro=c.CodPro
        LEFT JOIN T_TipoVia   e on b.CodTipVia=e.CodTipVia
        LEFT JOIN T_TarifaElectrica f ON a.CodTarElec=f.CodTarEle
        LEFT JOIN T_Distribuidora g ON a.CodDis=g.CodDist where CodCli='$CodCli'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;     
}
public function get_CUPs_Gas_Dashboard($CodCli)
{
    $sql = $this->db->query("SELECT a.CodCupGas,b.CodCli,a.CupsGas,g.RazSocDis,f.NomTarGas,CONCAT(b.NomViaPunSum,' ',b.NumViaPunSum,' ',d.DesPro,' ',c.DesLoc) AS DirPumSum,CONCAT(b.EscPunSum,' ',b.PlaPunSum,' ',b.PuePunSum) AS EscPlaPue,b.CPLocSoc,case a.TipServ when 2 then 'G' end as TipServ,(SELECT h.EstConCups FROM T_Propuesta_Comercial_CUPs h WHERE a.CodCupGas=h.CodCup AND h.TipCups=2 ORDER BY h.CodProComCup DESC LIMIT 1) AS EstConCups
        FROM T_CUPsGas a 
        LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum
        LEFT JOIN T_Localidad c on c.CodLoc=b.CodLoc
        LEFT JOIN T_Provincia d on d.CodPro=c.CodPro
        LEFT JOIN T_TipoVia   e on b.CodTipVia=e.CodTipVia
        LEFT JOIN T_TarifaGas f ON a.CodTarGas=f.CodTarGas
        LEFT JOIN T_Distribuidora g ON a.CodDis=g.CodDist where CodCli='$CodCli'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;     
}
public function getCupsEleGas($CodCli)
{
    $sql = $this->db->query("SELECT a.CodCupsEle AS CodCups,b.CodCli,a.CUPsEle AS CUPsName,g.RazSocDis,f.NomTarEle,CONCAT(b.NomViaPunSum,' ',b.NumViaPunSum,' ',d.DesPro,' ',c.DesLoc) AS DirPumSum,
        CONCAT(b.EscPunSum,' ',b.PlaPunSum,' ',b.PuePunSum) AS EscPlaPue,b.CPLocSoc,f.CanPerTar,a.PotConP1,a.PotConP2,a.PotConP3,a.PotConP4,a.PotConP5,
        a.PotConP6,case a.TipServ when 1 then 'E' end as TipServ
        FROM T_CUPsElectrico a 
        LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum 
        LEFT JOIN T_Localidad c on c.CodLoc=b.CodLoc
        LEFT JOIN T_Provincia d on d.CodPro=c.CodPro
        LEFT JOIN T_TipoVia   e on b.CodTipVia=e.CodTipVia
        LEFT JOIN T_TarifaElectrica f ON a.CodTarElec=f.CodTarEle
        LEFT JOIN T_Distribuidora g ON a.CodDis=g.CodDist where CodCli='$CodCli'
        UNION 
        SELECT a.CodCupGas AS CodCups,b.CodCli,a.CupsGas AS CUPsName,g.RazSocDis,f.NomTarGas,CONCAT(b.NomViaPunSum,' ',b.NumViaPunSum,' ',d.DesPro,' ',c.DesLoc) AS DirPumSum,
        CONCAT(b.EscPunSum,' ',b.PlaPunSum,' ',b.PuePunSum) AS EscPlaPue,b.CPLocSoc,NULL as CanPerTar,NULL as PotConP1,NULL as PotConP2,NULL as PotConP3,NULL as PotConP4,NULL as PotConP5,
        NULL as PotConP6,case a.TipServ when 2 then 'G' end as TipServ
        FROM T_CUPsGas a 
        LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum
        LEFT JOIN T_Localidad c on c.CodLoc=b.CodLoc
        LEFT JOIN T_Provincia d on d.CodPro=c.CodPro
        LEFT JOIN T_TipoVia   e on b.CodTipVia=e.CodTipVia
        LEFT JOIN T_TarifaGas f ON a.CodTarGas=f.CodTarGas
        LEFT JOIN T_Distribuidora g ON a.CodDis=g.CodDist where CodCli='$CodCli'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;     
}
public function GetCUPsContratosElectricosGas($CodCups,$CodCli,$TipCups)
{
    if($TipCups==1)
    {
        $this->db->select('c.TipProCom,b.CodCli,a.EstConCups,a.FecActCUPs,a.FecVenCUPs,d.RefCon,e.RazSocCom,NULL AS TipCon,g.NomTarEle AS NomTar,NULL AS Agente,a.ConCup,d.CodConCom,c.CodProCom',false);
    }
    else
    {
        $this->db->select('c.TipProCom,b.CodCli,a.EstConCups,a.FecActCUPs,a.FecVenCUPs,d.RefCon,e.RazSocCom,NULL AS TipCon,g.NomTarGas AS NomTar,NULL AS Agente,a.ConCup,d.CodConCom,c.CodProCom',false);
    }
    $this->db->from('T_Propuesta_Comercial_CUPs a');
    $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProComCli=b.CodProComCli');
    $this->db->join('T_PropuestaComercial c','b.CodProCom=c.CodProCom');
    $this->db->join('T_Contrato d','d.CodProCom=c.CodProCom');
    $this->db->join('T_Comercializadora e','c.CodCom=e.CodCom','LEFT');
    
    if($TipCups==1)
    {
        $this->db->join('T_CUPsElectrico f','f.CodCupsEle=a.CodCup');
        $this->db->join('T_TarifaElectrica g','g.CodTarEle=f.CodTarElec','LEFT');
    }
    else
    {
        $this->db->join('T_CUPsGas f','f.CodCupGas=a.CodCup');
        $this->db->join('T_TarifaGas g','g.CodTarGas=f.CodTarGas','LEFT');
    }
    $this->db->where('a.CodCup',$CodCups); 
    //$this->db->where('b.CodCli',$CodCli);        
    $this->db->where('a.TipCups',$TipCups);        
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
public function get_data_cliente_contactos($CodCli)
{/*CodConCli,NomConCli,NIFConCli,CarConCli,case TipRepr when 1 then "INDEPENDIENTE" when 2 then "MANCOMUNADA" end as TipRepr,EsRepLeg,DocNIF,DocPod*/
    $this->db->select('b.CodConCli,b.NomConCli,b.NIFConCli,b.CarConCli,case a.TipRepr when 1 then "INDEPENDIENTE" when 2 then "MANCOMUNADA" end as TipRepr,a.EsRepLeg,b.DocNIF,a.DocPod',false);    
    $this->db->from('T_ContactoDetalleCliente a');
    $this->db->join('T_ContactoCliente b','a.CodConCli=b.CodConCli');
    $this->db->where('a.CodCli',$CodCli);
    //$this->db->where('EsRepLeg=1');         
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
public function get_data_cliente_cuentas($CodCli)
{
    $this->db->select('a.*,b.DesBan');
    $this->db->from('T_CuentaBancaria a');
    $this->db->join('T_Banco b','a.CodBan=b.CodBan','LEFT');
    $this->db->where('CodCli',$CodCli);        
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
public function get_data_cliente_documentos($CodCli)
{
    $this->db->select('a.CodTipDocAI,b.DesTipDoc,a.DesDoc,a.ArcDoc,a.CodTipDoc');
    $this->db->from('T_Documentos a');
    $this->db->join('T_TipoDocumento b','a.CodTipDoc=b.CodTipDoc','left');
    $this->db->where('CodCli',$CodCli);        
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
public function get_CUPs_Gas($CodPunSum)
{
    $sql = $this->db->query("SELECT a.CodCupGas,a.CupsGas,c.RazSocDis,b.NomTarGas,a.CodTarGas,a.ConAnuCup from T_CUPsGas a
        left JOIN T_TarifaGas b on a.CodTarGas=b.CodTarGas
        left JOIN T_Distribuidora c on a.CodDis=c.CodDist
        where a.CodPunSum='$CodPunSum'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;   
}
public function get_CUPs_Electricos($CodPunSum)
{
 $sql = $this->db->query("SELECT a.CodCupsEle,a.CUPsEle,c.RazSocDis,b.NomTarEle,a.CodTarElec,a.PotConP1,a.PotConP2,a.PotConP3,a.PotConP4,a.PotConP5,a.PotConP6,b.CanPerTar from T_CUPsElectrico a
    left JOIN T_TarifaElectrica b on a.CodTarElec=b.CodTarEle
    left JOIN T_Distribuidora c on a.CodDis=c.CodDist    
    where a.CodPunSum='$CodPunSum'");
 if ($sql->num_rows() > 0)
    return $sql->result();
else
    return false;    
}
public function getClientessearchFilter($filtrar_clientes) 
{
    $this->db->select('a.CodCli,a.NumCifCli,a.RazSocCli,a.TelFijCli,a.NomComCli,b.DesTipVia as CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,d.DesPro as CodPro,c.DesLoc as CodLoc,a.EmaCli,a.WebCli,e.DesTipCli as CodTipCli,DATE_FORMAT(a.FecIniCli,"%d/%m/%Y") as FecIniCli,f.NomCom as CodCom,a.ObsCli,a.EstCli,g.DesSecCli AS CodSecCli,h.NomCol AS CodCol,i.DesTipVia as CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,k.DesPro as CodProFis,j.DesLoc as CodLocFis,CASE a.EstCli WHEN 1 THEN "ACTIVO" WHEN 2 THEN "SUSPENDIDO" END AS EstCliN,a.CodTipViaSoc as CodTipViaSoc1,a.CodLocSoc as CodLocSoc1,c.CodPro as CodProSoc2,a.CodTipCli as CodTipCliSoc2,a.CodSecCli as CodSecCliSoc2,c.CPLoc as CPLocSoc,a.CodTipViaFis as CodTipViaFis2,a.CodLocFis as CodLocFis2,j.CodPro as CodProFis2,j.CPLoc as CPLocFis,a.CodCom as CodCom2,a.CodCol as CodCol2 ',FALSE);
    $this->db->from('T_Cliente a'); 
    $this->db->join('T_TipoVia b','a.CodTipViaSoc=b.CodTipVia','LEFT');       
    $this->db->join('T_Localidad c','a.CodLocSoc=c.CodLoc','LEFT'); 
    $this->db->join('T_Provincia d','c.CodPro=d.CodPro','LEFT');
    $this->db->join('T_TipoCliente e','a.CodTipCli=e.CodTipCli','LEFT');
    $this->db->join('T_Comercial f','a.CodCom=f.CodCom','LEFT');
    $this->db->join('T_SectorCliente g','a.CodSecCli=g.CodSecCli','LEFT');
    $this->db->join('T_Colaborador h','a.CodCol=h.CodCol','LEFT'); 
    $this->db->join('T_TipoVia i','a.CodTipViaFis=i.CodTipVia','LEFT');
    $this->db->join('T_Localidad j','a.CodLocFis=j.CodLoc','LEFT'); 
    $this->db->join('T_Provincia k','j.CodPro=k.CodPro','LEFT');       
    $this->db->like('a.NumCifCli',$filtrar_clientes);
    $this->db->or_like('a.CodCli',$filtrar_clientes); 
    $this->db->or_like('a.RazSocCli',$filtrar_clientes);        
    $this->db->or_like('a.TelFijCli',$filtrar_clientes);
    $this->db->or_like('g.DesSecCli',$filtrar_clientes);
    $this->db->or_like('a.NomComCli',$filtrar_clientes);
    $this->db->or_like('a.EmaCli',$filtrar_clientes);
    $this->db->or_like('DATE_FORMAT(a.FecIniCli,"%d/%m/%Y")',$filtrar_clientes);
    $this->db->order_by('a.RazSocCli ASC');              
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
public function get_localidadesProvincia($CodPro)
{
    $this->db->select('*');
    $this->db->from('T_Localidad');
    //$this->db->join('T_TipoDocumento b','a.CodTipDoc=b.CodTipDoc');
    $this->db->where('CodPro',$CodPro);
    $this->db->order_by('DesLoc ASC');        
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
public function get_LocalidadByCPLoc($CPLoc)
{
        /*$this->db->select('a.CodLoc,a.CodPro,a.DesLoc,a.CPLoc,b.DesPro',false);
        $this->db->from('T_Localidad a');
        $this->db->join('T_Provincia b','a.CodPro=b.CodPro');
      
        $this->db->where('LIKE a.CPLoc',$CPLoc);              
        $this->db->order_by('a.DesLoc ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {return  $query->result();}else{return false;*/
            $sql = $this->db->query("SELECT a.CodLoc,a.CodPro,a.DesLoc,a.CPLoc,b.DesPro FROM T_Localidad a join T_Provincia b on a.CodPro=b.CodPro where a.CPLoc like '%$CPLoc%' ORDER BY a.DesLoc ASC");
            if ($sql->num_rows() > 0)
              return $sql->result();
          else
            return false;                      
    }
////////////////////////////////////// CLIENTES END /////////////////////////////////////////////////

    
    //////////////////////////////////////////////////// ACTIVIDADES START ///////////////////////////////////////////////////////
    public function get_activity_clientes()
    {
     $sql = $this->db->query("SELECT a.*,b.*,case a.EstAct when 1 then 'Activa' when 2 then 'Suspendida' end as EstAct ,DATE_FORMAT(a.FecIniAct, '%d/%m/%Y') as FecIniAct,c.NumCifCli,c.RazSocCli FROM T_ActividadCliente a join T_CNAE b on a.CodActCNAE=b.id join T_Cliente c on c.CodCli=a.CodCli  order by b.DesActCNAE asc");
     if ($sql->num_rows() > 0)
      return $sql->result();
  else
    return false;      
}
public function get_all_activity_clientes()
{
    $this->db->select('*');
    $this->db->from('T_ActividadEconomica');
    $this->db->order_by('DesSec,DesGru,DesEpi ASC');
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
public function Buscar_CNAECod($CodActCNAE)
{
    $this->db->select('*');
    $this->db->from('T_CNAE');
    $this->db->where('CodActCNAE',$CodActCNAE);        
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function agregar_actividad($id,$CodCli,$FecIniAct)
{
    $this->db->insert('T_ActividadCliente',array('CodCli'=>$CodCli,'CodActCNAE'=>$id,'FecIniAct'=>$FecIniAct));
    return $this->db->insert_id();
}
public function actualizar_actividad($id,$CodCli,$FecIniAct,$CodTActCli)
{   
    $this->db->where('CodTActCli', $CodTActCli);  
    $this->db->where('CodCli', $CodCli);      
    return $this->db->update('T_ActividadCliente',array('CodActCNAE'=>$id,'FecIniAct'=>$FecIniAct));
}
public function verificar_actividad($id,$CodCli)
{
    $this->db->select('*');
    $this->db->from('T_ActividadCliente');
    $this->db->where('CodActCNAE',$id);
    $this->db->where('CodCli',$CodCli);        
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function update_actividad_cliente($opcion,$CodTActCli,$CodCli)
{   
    $this->db->where('CodTActCli', $CodTActCli);
    $this->db->where('CodCli', $CodCli);          
    return $this->db->update('T_ActividadCliente',array('EstAct'=>$opcion));
}
public function agregar_motivo_bloqueo_actividad($CodCli,$CodActEco,$fecha,$MotBloq,$ObsBloAct)
{
    $this->db->insert('T_BloqueoActividad',array('CodCli'=>$CodCli,'CodActEco'=>$CodActEco,'FecBloAct'=>$fecha,'CodMotBloAct'=>$MotBloq,'ObsBloAct'=>$ObsBloAct));
    return $this->db->insert_id();
}
public function get_list_motivos_bloqueos_actividades()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloAct');       
    $this->db->order_by('DesMotBloAct ASC');              
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
public function getActividadesFilter($filtrar_search)
{
 $this->db->select('a.*,b.*,case a.EstAct when 1 then "Activa" when 2 then "SUSPENDIDA" end as EstAct ,DATE_FORMAT(a.FecIniAct, "%d/%m/%Y") as FecIniAct,c.NumCifCli,c.RazSocCli',FALSE);
 $this->db->from('T_ActividadCliente a'); 
 $this->db->join('T_CNAE b','a.CodActCNAE=b.id');       
 $this->db->join('T_Cliente c','c.CodCli=a.CodCli');  
 $this->db->like('c.NumCifCli',$filtrar_search);
 $this->db->or_like('c.RazSocCli',$filtrar_search);        
 $this->db->or_like('b.CodActCNAE',$filtrar_search);
 $this->db->or_like('b.DesActCNAE',$filtrar_search);
 $this->db->or_like('c.CodCli',$filtrar_search);
 $this->db->or_like("DATE_FORMAT(a.FecIniAct, '%d/%m/%Y')",$filtrar_search);
 $this->db->order_by('b.DesActCNAE ASC');              
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

    //////////////////////////////////////////////// ACTIVIDADES END //////////////////////////////////////////


    /////////////////////////////////////////// Direcciones de SuministroS START ///////////////////////////////////////////////

    /* public function get_puntos_suministros_clientes()
    {
       $sql = $this->db->query("SELECT b.NumCifCli,b.RazSocCli FROM T_PuntoSuministro a join T_Cliente b on a.CodCli=b.CodCli");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else
        return false;      
    }*/
    public function get_xID_puntos_suministros($CodPunSum)
    {
        $this->db->select('a.CodPunSum,a.CodCli as CodCliPunSum,a.TipRegDir,a.CodTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,b.CodPro as CodProPunSum,b.CodLoc as CodLocPunSum,a.CPLocSoc,a.CodTipInm,a.RefCasPunSum,a.DimPunSum,a.ObsPunSum,a.AclPunSum as Aclarador',FALSE);
        $this->db->from('T_PuntoSuministro a');   
        //$this->db->join('T_Cliente b','a.CodCli=b.CodCli'); 
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        //$this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        //$this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia');
        $this->db->where('a.CodPunSum',$CodPunSum);    
        //$this->db->order_by('b.RazSocCli ASC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_puntos_suministros_clientes()
    {
        $this->db->select('b.NumCifCli,b.RazSocCli,c.DesLoc,d.DesPro,a.EstPunSum,CASE a.EstPunSum WHEN 1 THEN "ACTIVO" WHEN 2 THEN "SUSPENDIDO" END AS EstPunSum,e.DesTipVia,e.IniTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,a.CodPunSum,a.CodCli,f.DesTipInm,a.TipRegDir,a.CodTipVia,a.CodLoc,c.CodPro,c.CPLoc,a.CodTipInm,a.RefCasPunSum,a.DimPunSum,a.ObsPunSum',FALSE);
        $this->db->from('T_PuntoSuministro a');   
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli','LEFT'); 
        $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc','LEFT');
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro','LEFT');
        $this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia','LEFT');
        $this->db->join('T_TipoInmueble f','a.CodTipInm=f.CodTipInm','LEFT');    
        $this->db->order_by('b.RazSocCli ASC');              
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
    public function get_direccion_Soc_Fis($Cliente,$variable)
    {
        $this->db->select($variable);
        $this->db->from('T_Cliente a');
        $this->db->join('T_Localidad b','a.CodLocSoc=b.CodLoc','left');
        $this->db->join('T_Localidad c','a.CodLocFis=c.CodLoc','left');
        $this->db->where('a.CodCli', $Cliente);     
        //$this->db->order_by('RazSocCli ASC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function agregar_punto_suministro_cliente($CodCliPunSum,$TipRegDir,$CodTipVia,$NomViaPunSum,$NumViaPunSum,$BloPunSum,$EscPunSum,$PlaPunSum,$PuePunSum,$CodProPunSum,$CodLocPunSum,$CodTipInm,$Aclarador,$RefCasPunSum,$DimPunSum,$ObsPunSum,$TelPunSum,$CPLocSoc)
    {
        $this->db->insert('T_PuntoSuministro',array('CodCli'=>$CodCliPunSum,'TipRegDir'=>$TipRegDir,'CodTipVia'=>$CodTipVia,'NomViaPunSum'=>$NomViaPunSum,'NumViaPunSum'=>$NumViaPunSum,'BloPunSum'=>$BloPunSum,'EscPunSum'=>$EscPunSum,'PlaPunSum'=>$PlaPunSum,'PuePunSum'=>$PuePunSum,'AclPunSum'=>$Aclarador,'CodLoc'=>$CodLocPunSum,'TelPunSum'=>$TelPunSum,'CodTipInm'=>$CodTipInm,'RefCasPunSum'=>$RefCasPunSum,'DimPunSum'=>$DimPunSum,'ObsPunSum'=>$ObsPunSum,'EstPunSum'=>1,'CPLocSoc'=>$CPLocSoc));
        return $this->db->insert_id();
    }
    public function actualizar_punto_suministro_cliente($CodPunSum,$CodCliPunSum,$TipRegDir,$CodTipVia,$NomViaPunSum,$NumViaPunSum,$BloPunSum,$EscPunSum,$PlaPunSum,$PuePunSum,$CodProPunSum,$CodLocPunSum,$CodTipInm,$Aclarador,$RefCasPunSum,$DimPunSum,$ObsPunSum,$TelPunSum,$CPLocSoc)
    {   
        $this->db->where('CodPunSum', $CodPunSum);
        $this->db->where('CodCli', $CodCliPunSum);                   
        return $this->db->update('T_PuntoSuministro',array('TipRegDir'=>$TipRegDir,'CodTipVia'=>$CodTipVia,'NomViaPunSum'=>$NomViaPunSum,'NumViaPunSum'=>$NumViaPunSum,'BloPunSum'=>$BloPunSum,'EscPunSum'=>$EscPunSum,'PlaPunSum'=>$PlaPunSum,'PuePunSum'=>$PuePunSum,'AclPunSum'=>$Aclarador,'CodLoc'=>$CodLocPunSum,'TelPunSum'=>$TelPunSum,'CodTipInm'=>$CodTipInm,'RefCasPunSum'=>$RefCasPunSum,'DimPunSum'=>$DimPunSum,'ObsPunSum'=>$ObsPunSum,'CPLocSoc'=>$CPLocSoc));
    }

    public function get_list_motivos_bloqueos_PunSum()
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloPun');       
        $this->db->order_by('DesMotBloPun ASC');              
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
    public function update_status_PumSum($CodCli,$CodPunSum,$opcion)
    {   
        $this->db->where('CodCli', $CodCli);
        $this->db->where('CodPunSum', $CodPunSum);         
        return $this->db->update('T_PuntoSuministro',array('EstPunSum'=>$opcion));
    }
    public function agregar_motivo_bloqueo_PunSum($fecha,$CodPunSum,$MotBloPunSum,$ObsBloPun)
    {
        $this->db->insert('T_BloqueoPunto',array('CodPunSum'=>$CodPunSum,'FecBloPun'=>$fecha,'CodMotBloPun'=>$MotBloPunSum,'ObsBloPun'=>$ObsBloPun));
        return true;//$this->db->insert_id();
    }
    public function getPunSumFilter($filtrar_search)
    {
     $this->db->select('b.NumCifCli,b.RazSocCli,c.DesLoc,d.DesPro,a.EstPunSum,CASE a.EstPunSum WHEN 1 THEN "Activo" WHEN 2 THEN "SUSPENDIDO" END AS EstPunSum,e.DesTipVia,e.IniTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,a.CodPunSum,a.CodCli,f.DesTipInm,a.TipRegDir,a.CodTipVia,a.CodLoc,c.CodPro,c.CPLoc,a.CodTipInm,a.RefCasPunSum,a.DimPunSum,a.ObsPunSum,b.CodCli',FALSE);
     $this->db->from('T_PuntoSuministro a');   
     $this->db->join('T_Cliente b','a.CodCli=b.CodCli','LEFT'); 
     $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc','LEFT');
     $this->db->join('T_Provincia d','c.CodPro=d.CodPro','LEFT');
     $this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia','LEFT');
     $this->db->join('T_TipoInmueble f','a.CodTipInm=f.CodTipInm','LEFT'); 
     $this->db->like('b.NumCifCli',$filtrar_search); 
     $this->db->or_like('b.CodCli',$filtrar_search);
     $this->db->or_like('b.RazSocCli',$filtrar_search);
     $this->db->or_like('d.DesPro',$filtrar_search);   
     $this->db->or_like('c.DesLoc',$filtrar_search);
     $this->db->or_like('d.DesPro',$filtrar_search);
     $this->db->or_like('b.EmaCli',$filtrar_search);
     $this->db->order_by('b.RazSocCli ASC');              
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

    /////////////////////////////////////////////////// Direcciones de SuministroS END ///////////////////////////////////////////////






///////////////////////////////////////////////////////////// CONTACTOS START ////////////////////////////////////////////

public function agregar_contactoNuevoMetodo($NomConCli,$NumColeCon,$NIFConCli,$CarConCli,$TelFijConCli,$TelCelConCli,$EmaConCli,$CodTipViaFis,$NomViaDomFis,$NumViaDomFis,$CPLocFis,$CodLocFis,$DocNIF,$ObsConC,$ConPrin)
{
    $this->db->insert('T_ContactoCliente',array('CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'CPLocFis'=>$CPLocFis,'CodLocFis'=>$CodLocFis,'NomConCli'=>$NomConCli,'NIFConCli'=>$NIFConCli,'DocNIF'=>$DocNIF,'ConPrin'=>$ConPrin,'NumColeCon'=>$NumColeCon,'TelFijConCli'=>$TelFijConCli,'TelCelConCli'=>$TelCelConCli,'EmaConCli'=>$EmaConCli,'CarConCli'=>$CarConCli,'ObsConC'=>$ObsConC,'EstConCli'=>1));
    return $this->db->insert_id();
}
public function actualizar_contactoNuevoMetodo($CodConCli,$NomConCli,$NumColeCon,$NIFConCli,$CarConCli,$TelFijConCli,$TelCelConCli,$EmaConCli,$CodTipViaFis,$NomViaDomFis,$NumViaDomFis,$CPLocFis,$CodLocFis,$DocNIF,$ObsConC,$ConPrin)
{   
    $this->db->where('CodConCli', $CodConCli);        
    return $this->db->update('T_ContactoCliente',array('CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'CPLocFis'=>$CPLocFis,'CodLocFis'=>$CodLocFis,'NomConCli'=>$NomConCli,'NIFConCli'=>$NIFConCli,'DocNIF'=>$DocNIF,'ConPrin'=>$ConPrin,'NumColeCon'=>$NumColeCon,'TelFijConCli'=>$TelFijConCli,'TelCelConCli'=>$TelCelConCli,'EmaConCli'=>$EmaConCli,'CarConCli'=>$CarConCli,'ObsConC'=>$ObsConC));
}
public function validar_CIF_NIF_Existente_NuevoMetodo($NIFConCli)
{
    $this->db->select('*',FALSE);
    $this->db->from('T_ContactoCliente');
    $this->db->where('NIFConCli',$NIFConCli);
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function agregar_contactoDetalleNuevoMetodo($CodConCli,$CodCli,$EsRepLeg,$TieFacEsc,$EsPrescritor,$EsColaborador,$DocPod,$CanMinRep,$TipRepr)
{
    $this->db->insert('T_ContactoDetalleCliente',array('CodConCli'=>$CodConCli,'CodCli'=>$CodCli,'EsRepLeg'=>$EsRepLeg,'TieFacEsc'=>$TieFacEsc,'EsPrescritor'=>$EsPrescritor,'EsColaborador'=>$EsColaborador,'DocPod'=>$DocPod,'CanMinRep'=>$CanMinRep,'TipRepr'=>$TipRepr,'EstCliCol'=>1));
    return $this->db->insert_id();
}
public function EliminarDetalleNuevoMetodo($CodConCli)
{ 
    return $this->db->delete('T_ContactoDetalleCliente', array('CodConCli' => $CodConCli));
}
public function get_xID_ContactosDetalleNuevoMetodo($CodConCli)
{
    $this->db->select('a.*,b.RazSocCli,b.NumCifCli',FALSE);
    $this->db->from('T_ContactoDetalleCliente a');
    $this->db->join('T_Cliente b','a.CodCli=b.CodCli');  
    $this->db->where('a.CodConCli',$CodConCli);    
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




























public function validar_CIF_NIF_Existente($NIFConCli,$CodCli)
{
    $this->db->select('*',FALSE);
    $this->db->from('T_ContactoCliente');
    $this->db->where('NIFConCli',$NIFConCli); 
    $this->db->where('CodCli',$CodCli);
    $this->db->limit('1');           
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function validar_CIF_NIF_Existente_UPDATE($CodConCli)
{
 $sql = $this->db->query("SELECT * FROM T_ContactoCliente WHERE CodConCli=".$CodConCli."");
 if ($sql->num_rows() > 0)
  return $sql->row();
else
    return false;      
}

public function get_lista_contactos()
{
 $sql = $this->db->query("SELECT a.*,(SELECT COUNT(*) FROM T_ContactoDetalleCliente c WHERE a.CodConCli=c.CodConCli) AS TotalClientes,case a.EstConCli WHEN 1 THEN 'ACTIVO' WHEN 2 THEN 'SUSPENDIDO' END as EstConCli
 FROM T_ContactoCliente a
 LEFT JOIN T_TipoContacto b on a.CodTipCon=b.CodTipCon ORDER BY a.NomConCli ASC");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;        
}
public function get_xID_Contactos($CodConCli,$select)
{
    $this->db->select($select,FALSE);
    $this->db->from('T_ContactoCliente a');   
    $this->db->join('T_Localidad b','a.CodLocFis=b.CodLoc','LEFT');
    $this->db->join('T_Provincia d','b.CodPro=d.CodPro','LEFT');
   	$this->db->where('a.CodConCli',$CodConCli);    
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function get_xID_Contactos_Otro_Cliente_Limit($NIFConCli,$select)
{
    $this->db->select($select,FALSE);
    $this->db->from('T_ContactoCliente a');
    $this->db->where('a.NIFConCli',$NIFConCli);             
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function get_xID_Contactos_Otro_Cliente($NIFConCli,$select)
{
    $this->db->select($select,FALSE);
    $this->db->from('T_ContactoCliente a');   
        //$this->db->join('T_Cliente b','a.CodCli=b.CodCli'); 
       // $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        //$this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        //$this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia');
    $this->db->where('a.NIFConCli',$NIFConCli);    
    //$this->db->order_by('b.RazSocCli ASC');              
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
public function comprobar_cif_contacto_existencia($NIFConCli)
{
    $this->db->select('*');
    $this->db->from('T_ContactoCliente');
    $this->db->where('NIFConCli',$NIFConCli);              
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
public function agregar_contacto($NIFConCli,$EsRepLeg,$TieFacEsc,$CanMinRep,$CodCli,$CodTipCon,$CarConCli,$NomConCli,$TelFijConCli,$TelCelConCli,$EmaConCli,$TipRepr,$DocNIF,$ObsConC,$DocPod,$NumColeCon,$ConPrin)
{
    $this->db->insert('T_ContactoCliente',array('CodCli'=>$CodCli,'CodTipCon'=>$CodTipCon,'EsRepLeg'=>$EsRepLeg,'CanMinRep'=>$CanMinRep,'NomConCli'=>$NomConCli,'NIFConCli'=>$NIFConCli,'DocNIF'=>$DocNIF,'TieFacEsc'=>$TieFacEsc,'DocPod'=>$DocPod,'TelFijConCli'=>$TelFijConCli,'TelCelConCli'=>$TelCelConCli,'EmaConCli'=>$EmaConCli,'TipRepr'=>$TipRepr,'CarConCli'=>$CarConCli,'ObsConC'=>$ObsConC,'NumColeCon'=>$NumColeCon,'ConPrin'=>$ConPrin));
    return $this->db->insert_id();
}
public function actualizar_contacto($CodConCli,$NIFConCli,$EsRepLeg,$TieFacEsc,$CanMinRep,$CodCli,$CodTipCon,$CarConCli,$NomConCli,$TelFijConCli,$TelCelConCli,$EmaConCli,$TipRepr,$DocNIF,$ObsConC,$DocPod,$NumColeCon,$ConPrin)
{   
    $this->db->where('CodConCli', $CodConCli);        
    return $this->db->update('T_ContactoCliente',array('CodTipCon'=>$CodTipCon,'EsRepLeg'=>$EsRepLeg,'CanMinRep'=>$CanMinRep,'NomConCli'=>$NomConCli,'DocNIF'=>$DocNIF,'TieFacEsc'=>$TieFacEsc,'DocPod'=>$DocPod,'TelFijConCli'=>$TelFijConCli,'TelCelConCli'=>$TelCelConCli,'EmaConCli'=>$EmaConCli,'TipRepr'=>$TipRepr,'CarConCli'=>$CarConCli,'ObsConC'=>$ObsConC,'CodCli'=>$CodCli,'NumColeCon'=>$NumColeCon,'ConPrin'=>$ConPrin));
}
public function actualizar_DirCLi($CodCli,$CodTipViaSoc,$NomViaDomSoc,$NumViaDomSoc,$BloDomSoc,$EscDomSoc,$PlaDomSoc,$PueDomSoc,$CodLocSoc,$CPLocSoc)
{   
    $this->db->where('CodCli', $CodCli);        
    return $this->db->update('T_Cliente',array('CodTipViaSoc'=>$CodTipViaSoc,'NomViaDomSoc'=>$NomViaDomSoc,'NumViaDomSoc'=>$NumViaDomSoc,'BloDomSoc'=>$BloDomSoc,'EscDomSoc'=>$EscDomSoc,'PlaDomSoc'=>$PlaDomSoc,'PueDomSoc'=>$PueDomSoc,'CodLocSoc'=>$CodLocSoc,'CPLocSoc'=>$CPLocSoc));
}   
public function update_status_Contacto($EstCom,$CodConCli)
{   
    $this->db->where('CodConCli', $CodConCli);              
    return $this->db->update('T_ContactoCliente',array('EstConCli'=>$EstCom));
}
public function agregar_motivo_bloqueo_T_contacto($CodConCli,$FecBloCon,$MotBloqcontacto,$ObsBloContacto)
{
    $this->db->insert('T_BloqueoContacto',array('CodConCli'=>$CodConCli,'FecBloCon'=>$FecBloCon,'CodMotBloCon'=>$MotBloqcontacto,'ObsBloCon'=>$ObsBloContacto));
    return $this->db->insert_id();
}
public function get_all_list_contactos()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCon');
    $this->db->order_by('DesMotBlocon ASC');
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
public function getContactosFilter($SearchText)
{
    $this->db->select("a.CodConCli,a.CodCli,b.CodTipCon,b.DesTipCon,case a.EsRepLeg WHEN 0 then 'NO' WHEN 1 THEN 'SI' end as EsRepLeg,a.CanMinRep,a.NomConCli,a.NIFConCli,a.DocNIF,case a.TieFacEsc WHEN 0 then 'NO' WHEN 1 THEN 'SI' end as TieFacEsc,a.DocPod,a.TelFijConCli,a.TelCelConCli,a.EmaConCli,a.TipRepr,a.CarConCli,a.ObsConC,case a.EstConCli WHEN 1 THEN 'ACTIVO' WHEN 2 THEN 'SUSPENDIDO' END as EstConCli,case a.TipRepr WHEN 1 THEN 'INDEPENDIENTE' WHEN 2 THEN 'MANCOMUNADA' END as representacion,c.NumCifCli,c.RazSocCli",false);
    $this->db->from('T_ContactoCliente a');
    $this->db->join('T_TipoContacto b','a.CodTipCon=b.CodTipCon');
    $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
    $this->db->like('c.NumCifCli',$SearchText);
    $this->db->or_like('a.CodCli',$SearchText);
    $this->db->or_like('a.NomConCli',$SearchText);
    $this->db->or_like('a.NIFConCli',$SearchText);
    $this->db->or_like('a.EmaConCli',$SearchText);
    $this->db->or_like('c.RazSocCli',$SearchText);
    $this->db->order_by('a.NomConCli ASC');
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
public function Get_valida_contacto_principal($CodCli,$ConPri)
{
    $this->db->select('CodConCli,ConPrin');
    $this->db->from('T_ContactoCliente');
    $this->db->where('CodCli',$CodCli);
    $this->db->where('ConPrin',$ConPri);
    $query = $this->db->get(); 
    if($query->num_rows()>0)
        {return $query->row();}
    else{return false;}       
}
public function UpdateOldContacto($CodConCli)
{   
    $this->db->where('CodConCli', $CodConCli);              
    return $this->db->update('T_ContactoCliente',array('ConPrin'=>0));
}
public function getPorDnioNombre($SearchText,$like)
{
    $this->db->select("a.*,b.CodPro",false);
    $this->db->from('T_ContactoCliente a');
    $this->db->JOIN('T_Localidad b','a.CodLocFis=b.CodLoc','LEFT');
    $this->db->like($like,$SearchText);
    $this->db->order_by('a.NomConCli ASC');
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
///////////////////////////////////////////////////////////////////// CONTACTOS END ////////////////////////////////////////



//////////////////////////////////////////////////////// CUENTAS BANCARIAS START //////////////////////////////////////////////

public function get_all_Cuentas_Bancarias_clientes()
{
 $sql = $this->db->query("SELECT a.CodCueBan,a.CodBan,b.DesBan,a.CodCli,SUBSTRING(a.NumIBan,1,4)AS CodEur,SUBSTRING(a.NumIBan,5,4)AS IBAN1,SUBSTRING(a.NumIBan,9,4)AS IBAN2,SUBSTRING(a.NumIBan,13,4)AS IBAN3,SUBSTRING(a.NumIBan,17,4)AS IBAN4,SUBSTRING(a.NumIBan,21,4)AS IBAN5,a.EstCue,CASE EstCue WHEN 1 THEN 'ACTIVA' WHEN 2 THEN 'SUSPENDIDA' END AS EstaCue,c.NumCifCli,c.RazSocCli from T_CuentaBancaria a LEFT JOIN T_Banco b ON a.CodBan=b.CodBan LEFT JOIN T_Cliente c ON a.CodCli=c.CodCli ORDER BY c.RazSocCli ASC");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;        
}
public function get_xID_CuentaBancaria($CodConCli)
{
    $sql = $this->db->query("SELECT a.CodCueBan,a.CodBan,b.DesBan,a.CodCli,SUBSTRING(a.NumIBan,1,4)AS CodEur,SUBSTRING(a.NumIBan,5,4)AS IBAN1,SUBSTRING(a.NumIBan,9,4)AS IBAN2,SUBSTRING(a.NumIBan,13,4)AS IBAN3,SUBSTRING(a.NumIBan,17,4)AS IBAN4,SUBSTRING(a.NumIBan,21,4)AS IBAN5,a.EstCue,CASE EstCue WHEN 1 THEN 'ACTIVA' WHEN 2 THEN 'SUSPENDIDA' END AS EstaCue,c.NumCifCli,c.RazSocCli,a.ObserCuenBan from T_CuentaBancaria a LEFT JOIN T_Banco b ON a.CodBan=b.CodBan LEFT JOIN T_Cliente c ON a.CodCli=c.CodCli where a.CodCueBan='$CodConCli'");
    if ($sql->num_rows() > 0)
      return $sql->row();
  else
    return false;       
}
public function buscar_NumIBan($NumIBan,$CodBan)
{
    $this->db->select('NumIBan');
    $this->db->from('T_CuentaBancaria');
    $this->db->where('NumIBan',$NumIBan);
    $query = $this->db->get(); 
    if($query->num_rows()>0)
        return true;
    else
        return false;
}   

public function actualizar_numero_cuenta($CodCueBan,$CodCli,$NumIBan,$CodBan,$ObserCuenBan)
{   
    $this->db->where('CodCueBan', $CodCueBan);
    return $this->db->update('T_CuentaBancaria',array('NumIBan'=>$NumIBan,'CodBan'=>$CodBan,'CodCli'=>$CodCli,'ObserCuenBan'=>$ObserCuenBan));
}
public function agregar_numero_cuenta($CodCli,$NumIBan,$CodBan,$ObserCuenBan)
{
    $this->db->insert('T_CuentaBancaria',array('CodCli'=>$CodCli,'NumIBan'=>$NumIBan,'CodBan'=>$CodBan,'ObserCuenBan'=>$ObserCuenBan));
    return $this->db->insert_id();
}
public function getCuentasBancariasFilter($SearchText)
{
        //return false;
    $this->db->select("a.CodCueBan,a.CodBan,b.DesBan,a.CodCli,SUBSTRING(a.NumIBan,1,4)AS CodEur,SUBSTRING(a.NumIBan,5,4)AS IBAN1,SUBSTRING(a.NumIBan,9,4)AS IBAN2,SUBSTRING(a.NumIBan,13,4)AS IBAN3,SUBSTRING(a.NumIBan,17,4)AS IBAN4,SUBSTRING(a.NumIBan,21,4)AS IBAN5,a.EstCue,CASE EstCue WHEN 1 THEN 'ACTIVA' WHEN 2 THEN 'SUSPENDIDA' END AS EstaCue,c.NumCifCli,c.RazSocCli",false);
    $this->db->from('T_CuentaBancaria a');
    $this->db->join('T_Banco b','a.CodBan=b.CodBan','left');
    $this->db->join('T_Cliente c','a.CodCli=c.CodCli','left');
    $this->db->like('c.NumCifCli',$SearchText);
    $this->db->or_like('c.RazSocCli',$SearchText);
    $this->db->or_like('b.DesBan',$SearchText); 
    $this->db->or_like('a.CodCli',$SearchText);        
    $this->db->or_like('a.NumIBan',$SearchText);
    $this->db->order_by('c.RazSocCli ASC');
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
///////////////////////////////////////////////// CUENTAS BANCARIAS END ///////////////////////////////////////////


///////////////////////////////////// DOCUMENTOS START ///////////////////////////////////////////////////
public function get_all_documentos()
{
 $this->db->select('a.CodTipDocAI,b.NumCifCli,b.RazSocCli,,a.CodCli,c.DesTipDoc,a.CodTipDoc,a.DesDoc,a.TieVen,DATE_FORMAT(a.FecVenDoc,"%d/%m/%Y") as FecVenDoc,a.ObsDoc,CASE TieVen WHEN 1 THEN "SI" WHEN 2 THEN "NO" END AS TieVenDes,a.ArcDoc',false);
 $this->db->from('T_Documentos a');
 $this->db->join('T_Cliente b','a.CodCli=b.CodCli','left');
 $this->db->join('T_TipoDocumento c','a.CodTipDoc=c.CodTipDoc');

 $this->db->order_by('a.DesDoc ASC');
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
public function getDocumentosFilter($SearchText)
{
    $this->db->select('a.CodTipDocAI,b.NumCifCli,b.RazSocCli,a.CodCli,c.DesTipDoc,a.CodTipDoc,a.DesDoc,a.TieVen,DATE_FORMAT(a.FecVenDoc,"%d/%m/%Y") as FecVenDoc,a.ObsDoc,CASE TieVen WHEN 1 THEN "SI" WHEN 2 THEN "NO" END AS TieVenDes,a.ArcDoc',false);
    $this->db->from('T_Documentos a');
    $this->db->join('T_Cliente b','a.CodCli=b.CodCli','left');
    $this->db->join('T_TipoDocumento c','a.CodTipDoc=c.CodTipDoc','left');
    $this->db->like('b.NumCifCli',$SearchText);
    $this->db->or_like('b.RazSocCli',$SearchText);
    $this->db->or_like('c.DesTipDoc',$SearchText);
    $this->db->or_like('a.DesDoc',$SearchText);
    $this->db->or_like('a.CodCli',$SearchText);
    $this->db->or_like('DATE_FORMAT(a.FecVenDoc,"%d/%m/%Y")',$SearchText);
    $this->db->order_by('a.DesDoc ASC');
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
public function get_xID_Documentos($CodTipDocAI)
{
    $sql = $this->db->query("SELECT CodTipDocAI,CodCli,CodTipDoc,DesDoc,ArcDoc,DATE_FORMAT(FecCarDoc,'%d/%m/%Y') as FecCarDoc,TieVen,DATE_FORMAT(FecVenDoc,'%d/%m/%Y') as FecVenDoc,ObsDoc from T_Documentos where CodTipDocAI='$CodTipDocAI'");
    if ($sql->num_rows() > 0)
      return $sql->row();
  else
    return false;       
}
public function get_list_tipos_documentos() 
{
    $this->db->select('*');
    $this->db->from('T_TipoDocumento'); 
    $this->db->order_by('DesTipDoc ASC');              
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
public function actualizar_documentos($CodTipDocAI,$CodCli,$CodTipDoc,$DesDoc,$ArcDoc,$TieVen,$FecVenDocAco,$ObsDoc)
{   
    $this->db->where('CodTipDocAI', $CodTipDocAI);
    return $this->db->update('T_Documentos',array('CodCli'=>$CodCli,'CodTipDoc'=>$CodTipDoc,'DesDoc'=>$DesDoc,'ArcDoc'=>$ArcDoc,'TieVen'=>$TieVen,'FecVenDoc'=>$FecVenDocAco,'ObsDoc'=>$ObsDoc,'FecCarDoc'=>date('Y-m-d')));
}
public function agregar_documentos($CodCli,$CodTipDoc,$DesDoc,$ArcDoc,$TieVen,$FecVenDocAco,$ObsDoc)
{
    $this->db->insert('T_Documentos',array('CodCli'=>$CodCli,'CodTipDoc'=>$CodTipDoc,'DesDoc'=>$DesDoc,'ArcDoc'=>$ArcDoc,'TieVen'=>$TieVen,'FecVenDoc'=>$FecVenDocAco,'ObsDoc'=>$ObsDoc,'FecCarDoc'=>date('Y-m-d')));
    return $this->db->insert_id();
}

///////////////////////////////////////////////////////// DOCUMENTOS END //////////////////////////////////////////////////////////





public function get_list_motivos_bloqueos()
{
    $this->db->select('*');
    $this->db->from('T_MotivoBloCli');       
    $this->db->order_by('DesMotBloCli ASC');              
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

public function get_list_tipo_inmuebles()
{
    $this->db->select('*');
    $this->db->from('T_TipoInmueble');       
    $this->db->order_by('DesTipInm ASC');              
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


public function get_list_tipos_vias()
{
    $this->db->select('*');
    $this->db->from('T_TipoVia');       
    $this->db->order_by('DesTipVia ASC');              
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
public function get_list_sector_cliente()
{
    $this->db->select('*');
    $this->db->from('T_SectorCliente');       
    $this->db->order_by('DesSecCli ASC');              
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
public function get_list_tipo_contacto()
{
    $this->db->select('*');
    $this->db->from('T_TipoContacto');       
    $this->db->order_by('DesTipCon ASC');              
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
public function get_list_colaboradores()
{
    $this->db->select('*');
    $this->db->from('T_Colaborador');       
    $this->db->order_by('NomCol ASC');              
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
public function agregar_motivo_bloqueo($hcliente,$fecha,$CodMotBloCli,$ObsBloCli)
{
    $this->db->insert('T_BloqueoCliente',array('CodCli'=>$hcliente,'FecBloCli'=>$fecha,'CodMotBloCli'=>$CodMotBloCli,'ObsBloCli'=>$ObsBloCli));
    return $this->db->insert_id();
}


public function get_clientes_data($huser)
{
    $this->db->select('a.CodCli,a.RazSocCli,a.NomComCli,a.NumCifCli,a.CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,
        a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,a.CodLocSoc as CodLocSoc,a.TelFijCli,a.EmaCli,
        a.WebCli,a.CodTipCli,DATE_FORMAT(a.FecIniCli,"%d/%m/%Y") as FecIniCli,a.CodCom,a.ObsCli,a.EstCli,
        a.CPLocSoc,b.CodPro as CodProSoc,a.CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,
        a.EscDomFis,a.PlaDomFis,a.PueDomFis,a.CodLocFis,a.CodSecCli,a.CodCol,c.CodPro as CodProFis,
        a.CPLocFis,a.DireccionBBDD,a.TelMovCli,a.EmaCliOpc',false);
    $this->db->from('T_Cliente a'); 
    $this->db->join('T_Localidad b','a.CodLocSoc=b.CodLoc','left');
    $this->db->join('T_Localidad c','a.CodLocFis=c.CodLoc','left');         
    $this->db->where('a.CodCli',$huser);     
    $this->db->order_by('a.RazSocCli DESC');              
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
public function GetContactoPrincipal($CodCli)
{
    $this->db->select('*',false);
    $this->db->from('T_ContactoCliente a');     
    $this->db->where('a.CodCli',$CodCli);     
    $this->db->where('a.ConPrin',1);           
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
public function borrar_clientes_data($hcliente)
{ 
    return $this->db->delete('T_Cliente', array('CodCli' => $hcliente));
}
public function get_list_providencias()
{
    $this->db->select('*');
    $this->db->from('T_Provincia');
    $this->db->order_by('CodPro ASC');              
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
public function get_list_localidades()
{
    $this->db->select('*');
    $this->db->from('T_Localidad a');
    $this->db->join('T_Provincia b','a.CodPro=b.CodPro');
    $this->db->order_by('DesLoc ASC');              
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
public function get_list_bancos()
{
    $this->db->select('CodBan,CodEur,SUBSTRING(CodEur,1,2) as CodEurMod,DesBan');
    $this->db->from('T_Banco');
    $this->db->order_by('DesBan ASC');              
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
public function get_list_tipo_Cliente()
{
    $this->db->select('*');
    $this->db->from('T_TipoCliente');
    $this->db->order_by('DesTipCli DESC');              
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
public function get_list_comerciales()
{
    $this->db->select('*');
    $this->db->from('T_Comercial');
    $this->db->order_by('NomCom DESC');              
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
public function comprobar_cif_existencia($NumCifCli)
{
    $this->db->select('NumCifCli,CodCli');
    $this->db->from('T_Cliente');
    $this->db->where('NumCifCli',$NumCifCli);              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}

public function get_data_clientes($NumCifCli)
{
    $this->db->select('*');
    $this->db->from('T_Cliente');
    $this->db->where('NumCifCli',$NumCifCli);              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
    {
        return $query->row();
    }
    else
    {
        return false;
    }       
}
public function update_status_cliente($opcion,$hcliente)
{   
    $this->db->where('CodCli', $hcliente);        
    return $this->db->update('T_Cliente',array('EstCli'=>$opcion));
}
public function update_status_CueBan($CodCli,$CodCueBan,$EstCue)
{   
    $this->db->where('CodCli', $CodCli);
    $this->db->where('CodCueBan', $CodCueBan);         
    return $this->db->update('T_CuentaBancaria',array('EstCue'=>$EstCue));
}   
public function getclientessearch($SearchText)
{

 $sql = $this->db->query("SELECT CodCli,RazSocCli,NomComCli,NumCifCli,TelFijCli,EmaCli FROM T_Cliente where RazSocCli like '%$SearchText%' or NomComCli like '%$SearchText%' or NumCifCli like '%$SearchText%' or EmaCli like '%$SearchText%' or CodCli like '%$SearchText%' ORDER BY RazSocCli ASC");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;
}
public function getporcups($SearchText)
{ 
    $this->db->distinct();
    $this->db->select("CodCli",false);
    $this->db->from('View_CUPsPorClientes');
    $this->db->like('CUPsName',$SearchText);
    $this->db->order_by('CodCli ASC');
    $query = $this->db->get();        
    return $query->result();
}
public function getDataClientesCUPs($CodCli)
{
    $this->db->select('*');
    $this->db->from('T_Cliente');
    $this->db->where('CodCli',$CodCli);
    $query = $this->db->get(); 
    if($query->num_rows()>0){
        return $query->row();
    }else{
        return false;
    }       
}

public function getColaboradoressearch($SearchText)
{

 $sql = $this->db->query("SELECT CodCol as CodCli,NomCol as RazSocCli,NomCol as NomComCli,NumIdeFis as NumCifCli,TelFijCol as TelFijCli,EmaCol as EmaCli FROM T_Colaborador where NomCol like '%$SearchText%' or NomCol like '%$SearchText%' or NumIdeFis like '%$SearchText%' or EmaCol like '%$SearchText%' or CodCol like '%$SearchText%' ORDER BY NomCol ASC");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;
}
public function getclientesRepresentanteLegalsearch($CodCli,$NIFConCli)
{
    /*SELECT  FROM T_ContactoDetalleCliente a 
JOIN T_Cliente b ON b.CodCli=a.CodCli JOIN T_ContactoCliente c ON a.CodConCli=c.CodConCli WHERE =163*/


 $sql = $this->db->query("SELECT b.CodCli,c.NIFConCli,b.RazSocCli,c.NomConCli,b.NomComCli,b.NumCifCli,b.TelFijCli,b.EmaCli FROM T_ContactoDetalleCliente a 
JOIN T_Cliente b ON b.CodCli=a.CodCli JOIN T_ContactoCliente c ON a.CodConCli=c.CodConCli 
WHERE a.CodConCli='$CodCli' AND b.NumCifCli LIKE '%$NIFConCli%' OR a.CodConCli='$CodCli' AND b.RazSocCli LIKE '%$NIFConCli%' ORDER BY b.RazSocCli ASC");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;
}
public function getRepresentantelLegalSearch($SearchText)
{

 $sql = $this->db->query("SELECT CodConCli as CodCli,NomConCli as RazSocCli,NIFConCli as NumCifCli,TelFijConCli as TelFijCli,EmaConCli as EmaCli FROM T_ContactoCliente where NomConCli like '%$SearchText%' or NIFConCli like '%$SearchText%' or EmaConCli like '%$SearchText%' or CodConCli like '%$SearchText%' ORDER BY NomConCli ASC");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;
}
public function get_all_contactos($CodCli)
{
 $sql = $this->db->query("SELECT a.CodPunSum,a.CodCli,a.TipRegDir,case a.TipRegDir when 0 then 'Nuevo' when 1 then 'Misma Dirección Social' when 2 then 'Misma Dirección Fiscal' end as TipDir,b.DesTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,d.DesPro,c.DesLoc,c.CPLoc,e.DesTipInm,a.RefCasPunSum,a.DimPunSum,a.ObsPunSum,a.TelPunSum,a.EstPunSum,case a.EstPunSum when 1 then 'Activo' when 2 then 'SUSPENDIDO' end as EstuPunSum,c.CodLoc as CodLocPunSum,d.CodPro as CodProPunSum,a.CodTipVia,a.CodTipInm,c.CPLoc as ZonPosPunSum FROM T_PuntoSuministro a JOIN T_TipoVia b on a.CodTipVia=b.CodTipVia JOIN T_Localidad c ON a.CodLoc=c.CodLoc JOIN T_Provincia d ON c.CodPro=d.CodPro JOIN T_TipoInmueble e ON a.CodTipInm=e.CodTipInm where CodCli='$CodCli'");
 if ($sql->num_rows() > 0)
  return $sql->result();
else
    return false;        
}
public function asignar_actividad_cliente($CodCli,$CodActEco,$FecIniAct)
{
    $this->db->insert('T_ActividadCliente',array('CodCli'=>$CodCli,'CodActEco'=>$CodActEco,'FecIniAct'=>$FecIniAct));
    return $this->db->insert_id();
}    
}