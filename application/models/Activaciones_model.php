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
        $sql = $this->db->query("SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom,e.RazSocCli,e.NumCifCli,f.CUPsEle AS CUPsName,f.CodCupsEle AS CodCups,g.NomTarEle AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6,a.CodPunSum,b.CodCli,c.CodCom,c.CodAnePro,c.TipPre,a.ObsCup,a.CauDiaGas 
        	FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT JOIN T_Cliente e ON e.CodCli=b.CodCli 
			LEFT JOIN T_CUPsElectrico f ON f.CodCupsEle=a.CodCup 
			LEFT JOIN T_TarifaElectrica g ON g.CodTarEle=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=1 OR a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=2 
			UNION all
			SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, j.RazSocCli,j.NumCifCli,f.CUPsEle AS CUPsName,
			f.CodCupsEle AS CodCups,g.NomTarEle AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,
			date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup ,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,
			a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6,a.CodPunSum,j.CodCli,c.CodCom,c.CodAnePro,c.TipPre,a.ObsCup,a.CauDiaGas
			FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT JOIN T_Colaborador e ON e.CodCol=b.CodCli 
			LEFT JOIN T_CUPsElectrico f ON f.CodCupsEle=a.CodCup 
			JOIN T_PuntoSuministro i ON i.CodPunSum=f.CodPunSum
			JOIN T_Cliente j ON j.CodCli=i.CodCli
			LEFT JOIN T_TarifaElectrica g ON g.CodTarEle=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro WHERE a.CodCup='$CodCup' AND a.TipCups=1 AND c.TipProCom=3
			
			ORDER BY FecVenCon desc");
			        if ($sql->num_rows() > 0)
			          return $sql->result();
			        else  
			        return false;        
	}
	public function GetInformacionCUPsGas($CodCup) 
    {
        $sql = $this->db->query("SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, e.RazSocCli,e.NumCifCli,f.CupsGas AS CUPsName,f.CodCupGas AS CodCups,g.NomTarGas AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6,a.CodPunSum,b.CodCli,c.CodCom,c.CodAnePro,c.TipPre,a.ObsCup,a.CauDiaGas 
        	FROM T_Propuesta_Comercial_CUPs a 
			LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
			LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
			LEFT JOIN T_Cliente e ON e.CodCli=b.CodCli 
			LEFT JOIN T_CUPsGas f ON f.CodCupGas=a.CodCup 
			LEFT JOIN T_TarifaGas g ON g.CodTarGas=a.CodTar
			LEFT JOIN T_Producto h ON h.CodPro=c.CodPro where a.CodCup='$CodCup' AND a.TipCups=2 AND c.TipProCom=1 OR a.CodCup='$CodCup' AND a.TipCups=2 AND c.TipProCom=2 

			UNION all

			SELECT a.CodProComCup,a.CodProComCli,b.CodProCom,c.TipProCom,d.CodConCom, j.RazSocCli,j.NumCifCli,f.CupsGas AS CUPsName,f.CodCupGas AS CodCups,g.NomTarGas AS NomTar,h.DesPro,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs,a.ConCup ,d.FecVenCon,a.TipCups,a.EstConCups,a.CodTar,c.CodPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6,a.CodPunSum,j.CodCli,c.CodCom,c.CodAnePro,c.TipPre,a.ObsCup,a.CauDiaGas
            FROM T_Propuesta_Comercial_CUPs a 
            LEFT JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
            LEFT JOIN T_PropuestaComercial  c ON b.CodProCom=c.CodProCom
            LEFT JOIN T_Contrato d ON d.CodProCom=c.CodProCom
            LEFT JOIN T_Colaborador e ON e.CodCol=b.CodCli 
            LEFT JOIN T_CUPsGas f ON f.CodCupGas=a.CodCup 
            JOIN T_PuntoSuministro i ON i.CodPunSum=f.CodPunSum
            JOIN T_Cliente j ON j.CodCli=i.CodCli
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
    public function get_list_comercializadora_Act()
    {
        $this->db->select('a.CodCom,a.RazSocCom,a.NomComCom,a.NumCifCom,d.DesTipVia,d.IniTipVia,a.NomViaDirCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,b.DesLoc as CodLoc,b.CPLoc,c.DesPro as ProDirCom,a.TelFijCom,a.EmaCom,a.PagWebCom,a.NomConCom,a.CarConCom,case a.SerGas when 0 then "NO" WHEN 1 THEN "SI" end as SerGas,case a.SerEle when 0 then "NO" WHEN 1 THEN "SI" end as SerEle,case a.SerEsp when 0 then "NO" WHEN 1 THEN "SI" end as SerEsp,a.DocConCom,DATE_FORMAT(a.FecConCom,"%d/%m/%Y") as FecConCom,a.DurConCom,case a.RenAutConCom when 0 then "NO" WHEN 1 THEN "SI" end as RenAutConCom,DATE_FORMAT(a.FecVenConCom,"%d/%m/%Y") as FecVenConCom,DATE_FORMAT(a.FecIniCom,"%d/%m/%Y") as FecIniCom,a.ObsCom,case a.EstCom when 1 then "Activa" WHEN 2 THEN "Suspendida" end as EstCom',false);
        $this->db->from('T_Comercializadora a');
        $this->db->JOIN('T_Localidad b','a.CodLoc=b.CodLoc','LEFT');
        $this->db->JOIN('T_Provincia c','c.CodPro=b.CodPro','LEFT');
        $this->db->JOIN('T_TipoVia d','a.CodTipVia=d.CodTipVia','LEFT');
        $this->db->where('EstCom=1');
        $this->db->order_by('a.NomComCom ASC');
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
    public function ProductosComercia($CodCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_Producto');
        $this->db->where('CodCom',$CodCom); 
        $this->db->order_by('DesPro ASC'); 
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
    }
    public function Funcion_ComprobarCUPs($Variable,$tabla,$where,$select)
    {
        $this->db->select($select,false);
	    $this->db->from($tabla);       
	    $this->db->where($where,$Variable);               
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
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
    public function CrearPropuestaComercial($FecProCom,$TipProCom,$CodCon,$PorAhoTot,$ImpAhoTot,$EstProCom,$JusRecProCom,$CodCom,$CodPro,$CodAnePro,$TipPre,$UltTipSeg,$ObsProCom,$RefProCom)
    {
        $this->db->insert('T_PropuestaComercial',array('FecProCom'=>$FecProCom,'TipProCom'=>$TipProCom,'CodCon'=>$CodCon,'PorAhoTot'=>$PorAhoTot,'ImpAhoTot'=>$ImpAhoTot,'EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom,'CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'UltTipSeg'=>$UltTipSeg,'ObsProCom'=>$ObsProCom,'RefProCom'=>$RefProCom));
        return $this->db->insert_id();
    }
    public function CrearPropuestaComercialCliente($PropuestaComercial,$CodCli)
    {
        $this->db->insert('T_Propuesta_Comercial_Clientes',array('CodProCom'=>$PropuestaComercial,'CodCli'=>$CodCli));
        return $this->db->insert_id();
    }
    public function CrearPropuestaComercialClienteCUPs($CodProComCli,$CodPunSum,$CodCups,$CodTar,$PotEleConP1,$PotEleConP2,$PotEleConP3,$PotEleConP4,$PotEleConP5,$PotEleConP6,$FecActCUPs,$FecVenCUPs,$RenCup,$ImpAho,$PorAho,$ObsCup,$ConCUPs,$CauDia,$TipServ,$EstConCups)
    {
        $this->db->insert('T_Propuesta_Comercial_CUPs',array('CodProComCli'=>$CodProComCli,'CodPunSum'=>$CodPunSum,'CodCup'=>$CodCups,'CodTar'=>$CodTar,'PotEleConP1'=>$PotEleConP1,'PotEleConP2'=>$PotEleConP2,'PotEleConP3'=>$PotEleConP3,'PotEleConP4'=>$PotEleConP4,'PotEleConP5'=>$PotEleConP5,'PotEleConP6'=>$PotEleConP6,'FecActCUPs'=>$FecActCUPs,'FecVenCUPs'=>$FecVenCUPs,'RenCup'=>$RenCup,'ImpAho'=>$ImpAho,'PorAho'=>$PorAho,'ObsCup'=>$ObsCup,'ConCup'=>$ConCUPs,'CauDiaGas'=>$CauDia,'TipCups'=>$TipServ,'EstConCups'=>$EstConCups));
        return $this->db->insert_id();
    }
    public function CrearContratoRapido($CodProCom,$CodCli
            ,$FecConCom,$EstRen,$RenMod,$ProRenPen,$FecIniCon,$DurCon,$FecVenCon,$FecFirmCon,$FecAct,$FecFinCon,$RefCon,$ObsCon,$UltTipSeg,$DocGenCom,$EstBajCon,$FecBajCon,$JusBajCon,$DocConRut,$CodProComCup)
    {
        $this->db->insert('T_Contrato',array('CodProCom'=>$CodProCom,'CodCli'=>$CodCli,'FecConCom'=>$FecConCom,'EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen,'FecIniCon'=>$FecIniCon,'DurCon'=>$DurCon,'FecVenCon'=>$FecVenCon,'FecFirmCon'=>$FecFirmCon,'FecAct'=>$FecAct,'FecFinCon'=>$FecFinCon,'RefCon'=>$RefCon,'ObsCon'=>$ObsCon,'UltTipSeg'=>$UltTipSeg,'DocGenCom'=>$DocGenCom,'EstBajCon'=>$EstBajCon,'FecBajCon'=>$FecBajCon,'JusBajCon'=>$JusBajCon,'DocConRut'=>$DocConRut,'CodProComCup'=>$CodProComCup));
        return $this->db->insert_id();
    }
    public function RegistrarDocmuentosContrato($TipDoc,$file_ext,$CodConCom,$DocGenCom,$DocConRut)
    {
        $this->db->insert('T_DetalleDocumentosContratos',array('TipDoc'=>$TipDoc,'file_ext'=>$file_ext,'CodConCom'=>$CodConCom,'DocGenCom'=>$DocGenCom,'DocConRut'=>$DocConRut));
        return $this->db->insert_id();
    }

   
}

?>
