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
        $sql = $this->db->query("SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.RazSocCli,e.NumCifCli,f.CUPsEle AS CUPsName,f.CodCupsEle AS CodCups,g.NomTarEle AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6 FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT join T_Cliente e ON e.CodCli=b.CodCli 
			LEFT JOIN T_CUPsElectrico f ON f.CodCupsEle=a.CodCup 
			LEFT JOIN T_TarifaElectrica g ON g.CodTarEle=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=1 OR a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=2 
			UNION all

			SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.NomCol as RazSocCli,e.NumIdeFis as NumCifCli,f.CUPsEle AS CUPsName,f.CodCupsEle AS CodCups,g.NomTarEle AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup ,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6
			FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT join T_Colaborador e ON e.CodCol=b.CodCli 
			LEFT JOIN T_CUPsElectrico f ON f.CodCupsEle=a.CodCup 
			LEFT JOIN T_TarifaElectrica g ON g.CodTarEle=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=3 

			ORDER BY FecVenCon desc");
			        if ($sql->num_rows() > 0)
			          return $sql->result();
			        else  
			        return false;        
	}
	public function GetInformacionCUPsGas($CodCup) 
    {
        $sql = $this->db->query("SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.RazSocCli,e.NumCifCli,f.CupsGas AS CUPsName,f.CodCupGas AS CodCups,g.NomTarGas AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6 FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT join T_Cliente e ON e.CodCli=b.CodCli 
			LEFT JOIN T_CUPsGas f ON f.CodCupGas=a.CodCup 
			LEFT JOIN T_TarifaGas g ON g.CodTarGas=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=2 AND c.TipProCom=1 OR a.CodCup='$CodCup' AND a.TipCups=2 AND c.TipProCom=2 

			UNION all

			SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.NomCol as RazSocCli,e.NumIdeFis as NumCifCli,f.CupsGas AS CUPsName,f.CodCupGas AS CodCups,g.NomTarGas AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup ,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6
			FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT join T_Colaborador e ON e.CodCol=b.CodCli 
			LEFT JOIN T_CUPsGas f ON f.CodCupGas=a.CodCup 
			LEFT JOIN T_TarifaGas g ON g.CodTarGas=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=2 AND c.TipProCom=3 

			ORDER BY FecVenCon desc");
			        if ($sql->num_rows() > 0)
			          return $sql->result();
			        else  
			        return false;        
	}
    public function UpdateInformationContratos($CodConCom,$CodCups,$CodProCom,$CodProComCli,$CodProComCup,$ConCup,$FecActCUPs,$FecVenCUPs,$TipCups,$CodTar,$EstConCups,$PotEleConP1,$PotEleConP2,$PotEleConP3,$PotEleConP4,$PotEleConP5,$PotEleConP6)
    {   
        $this->db->where('CodProComCup', $CodProComCup);
        return $this->db->update('T_Propuesta_Comercial_CUPs',array('FecActCUPs'=>$FecActCUPs,'FecVenCUPs'=>$FecVenCUPs,'ConCup'=>$ConCup,'CodTar'=>$CodTar,'EstConCups'=>$EstConCups,'PotEleConP1'=>$PotEleConP1,'PotEleConP2'=>$PotEleConP2,'PotEleConP3'=>$PotEleConP3,'PotEleConP4'=>$PotEleConP4,'PotEleConP5'=>$PotEleConP5,'PotEleConP6'=>$PotEleConP6));
    }
    public function UpdateInformationContratosPropuesta($CodProCom,$CodPro)
    {   
        $this->db->where('CodProCom', $CodProCom);
        return $this->db->update('T_PropuestaComercial',array('CodPro'=>$CodPro));
    }
    public function list_tarifa_electricas()
    {
        $this->db->select('CodTarEle as CodTar,case TipTen WHEN 0 THEN "BAJA" WHEN 1 THEN "ALTA" END as TipTen,NomTarEle as NomTar,CanPerTar,MinPotCon,MaxPotCon,EstTarEle as EstTar',FALSE);
        $this->db->from('T_TarifaElectrica');
        $this->db->where('EstTarEle=1');
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
     public function get_list_tarifa_Gas()
    {
        $this->db->select('CodTarGas as CodTar, NULL as TipTen,NomTarGas as NomTar, NULL as CanPerTar,MinConAnu as MinPotCon,MaxConAnu as MaxPotCon,EstTarGas as EstTar ',false);
        $this->db->from('T_TarifaGas');
        $this->db->where('EstTarGas=1');
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
    public function get_listProductos()
    {
        $this->db->select('*');
        $this->db->from('T_Producto');
        $this->db->where('EstPro=1');
        $this->db->order_by('DesPro ASC');        
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

   
}

?>
