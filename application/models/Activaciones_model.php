<?php
class Activaciones_model extends CI_Model 
{
	public function GetDatosCUPsForActivaciones($CUPs) 
    {
        $sql = $this->db->query("SELECT * FROM V_CupsGrib where CupsGas='$CUPs'");
        if ($sql->num_rows() > 0)
          return $sql->row();
        else  
        return false;        
    }
    public function GetInformacionCUPsElectrico($CodCup) 
    {
        $sql = $this->db->query("SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.RazSocCli,e.NumCifCli,f.CUPsEle AS CUPsName,f.CodCupsEle AS CodCups,g.NomTarEle AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup,d.FecVenCon,a.TipCups FROM T_Propuesta_Comercial_CUPs a 
JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
JOIN T_Contrato d ON d.CodProCom=c.CodProCom
join T_Cliente e ON e.CodCli=b.CodCli 
JOIN T_CUPsElectrico f ON f.CodCupsEle=a.CodCup 
JOIN T_TarifaElectrica g ON g.CodTarEle=a.CodTar
JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=1 OR a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=2 

UNION all

SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.NomCol as RazSocCli,e.NumIdeFis as NumCifCli,f.CUPsEle AS CUPsName,f.CodCupsEle AS CodCups,g.NomTarEle AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup ,d.FecVenCon,a.TipCups
FROM T_Propuesta_Comercial_CUPs a 
JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
JOIN T_Contrato d ON d.CodProCom=c.CodProCom
join T_Colaborador e ON e.CodCol=b.CodCli 
JOIN T_CUPsElectrico f ON f.CodCupsEle=a.CodCup 
JOIN T_TarifaElectrica g ON g.CodTarEle=a.CodTar
JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=3 

ORDER BY FecVenCon desc");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else  
        return false;        
    }
    public function UpdateInformationContratos($CodConCom,$CodCups,$CodProCom,$CodProComCli,$CodProComCup,$ConCup,$FecActCUPs,$FecVenCUPs,$TipCups)
    {   
        $this->db->where('CodProComCup', $CodProComCup);        
        return $this->db->update('T_Propuesta_Comercial_CUPs',array('FecActCUPs'=>$FecActCUPs,'FecVenCUPs'=>$FecVenCUPs,'ConCup'=>$ConCup));
    }

   
}

?>
