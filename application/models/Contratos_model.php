<?php
class Contratos_model extends CI_Model 
{	
///////////////////////////////////////////////// PARA CONTRATOS START ///////////////////////////////////////////////

 	public function get_list_contratos()
    {
        $this->db->select("CodConCom,CodProCom,DATE_FORMAT(FecConCom,'%d/%m/%Y') as FecConCom,DurCon,DATE_FORMAT(FecVenCon,'%d/%m/%Y') as FecVenCon,EstBajCon,DATE_FORMAT(FecIniCon,'%d/%m/%Y') as FecIniCon,CodCli,NumCifCli,RazSocCli,CodCom,Anexo,NumCifCom,RefCon,CUPsEle,CupsGas,CodProComCli,TipProCom",false);
        $this->db->from('View_Contratos');
        $this->db->order_by('CodConCom DESC');
        //$this->db->order_by('DATE_FORMAT(FecVenCon,"%Y/%m/%d") ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }    
    public function BuscarPropuestaAprobada($CodCli,$metodo)
    {
        $this->db->select('a.CodProCom,b.CodCli,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,a.RefProCom,a.EstProCom,a.JusRecProCom,a.CodCom,a.CodPro,a.CodAnePro,case a.TipPre when 0 then "Fijo" when 1 then "Indexado" when 2 then "Ambos" end as TipPre,a.UltTipSeg,a.ObsProCom,j.NumCifCom,j.RazSocCom,k.DesPro as DesProducto,l.DesAnePro,a.TipProCom,b.CodProComCli',false);
        $this->db->from('T_PropuestaComercial a'); 
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom','LEFT');       
        $this->db->join('T_Comercializadora j','j.CodCom=a.CodCom','LEFT');
        $this->db->join('T_Producto k','k.CodPro=a.CodPro','LEFT');
        $this->db->join('T_AnexoProducto l','l.CodAnePro=a.CodAnePro','LEFT');
        $this->db->where('b.CodCli',$CodCli);
        if($metodo==1 /*|| $metodo==2*/)
        {
            $this->db->where('a.EstProCom','A');  
            //$this->db->where('a.TipProCom<=2');
        }
        /*if($metodo==3)
        {
            $this->db->where('a.EstProCom','A');  
            $this->db->where('a.TipProCom=3');
        }*/        
        $this->db->order_by('a.FecProCom DESC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
       	return $query->result();
        else
        return false;              
    }
    public function BuscarPropuestaAprobadaNewVer($CodCli,$metodo)
    {
        $this->db->select('a.CodProCom,b.CodCli,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,a.PorAhoTot,a.ImpAhoTot,a.EstProCom,a.JusRecProCom,a.CodCom,a.CodPro,a.CodAnePro,case a.TipPre when 0 then "Fijo" when 1 then "Indexado" when 2 then "Ambos" end as TipPre,a.UltTipSeg,a.ObsProCom,a.RefProCom,a.TipProCom,c.NumCifCom, c.RazSocCom,d.DesPro as DesProducto,e.DesAnePro,b.CodProComCli,a.CorpoGo',false);
        $this->db->from('T_PropuestaComercial a'); 
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom','LEFT');
        $this->db->join('T_Comercializadora c','c.CodCom=a.CodCom');
        $this->db->join('T_Producto d','d.CodPro=a.CodPro');
        $this->db->join('T_AnexoProducto e','e.CodAnePro=a.CodAnePro','LEFT');
        $this->db->where('b.CodCli',$CodCli);
        if($metodo==1)
        {
            $this->db->where('a.EstProCom','A');
            $this->db->where('a.TipProCom<=2');
        } 
        if($metodo==3)
        {
            $this->db->where('a.EstProCom','A');
            $this->db->where('a.TipProCom=3');
        }        
        $this->db->order_by('a.FecProCom DESC');
        //$this->db->limit(1);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function agregar_contrato($CodCli,$CodProCom,$FecConCom,$EstRen,$RenMod,$ProRenPen,$FecIniCon,$DurCon,$FecVenCon,$RefCon,$ObsCon,$DocConRut,$FecAct)
    {
        $this->db->insert('T_Contrato',array('CodProCom'=>$CodProCom,'CodCli'=>$CodCli,'FecConCom'=>$FecConCom,'EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen,'FecIniCon'=>$FecIniCon,'RefCon'=>$RefCon,'ObsCon'=>$ObsCon,'DocConRut'=>$DocConRut,'FecVenCon'=>$FecVenCon,'DurCon'=>$DurCon,'FecAct'=>$FecAct));
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
    public function NuevoEstatusContratos($CodConCom,$opcion_select)
    {   
        $this->db->where('CodConCom', $CodConCom);
        return $this->db->update('T_Contrato',array('EstBajCon'=>$opcion_select));
    }
    public function getContratosFilter($SearchText)
    {
        $this->db->select("CodConCom,CodProCom,DATE_FORMAT(FecConCom,'%d/%m/%Y') as FecConCom,DurCon,DATE_FORMAT(FecVenCon,'%d/%m/%Y') as FecVenCon,EstBajCon,DATE_FORMAT(FecIniCon,'%d/%m/%Y') as FecIniCon,CodCli,NumCifCli,RazSocCli,CodCom,Anexo,NumCifCom,RefCon,CUPsEle,CupsGas,TipProCom,CodProComCli",false);
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
        $this->db->order_by('DATE_FORMAT(FecVenCon,"%Y/%m/%d") DESC');              
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
        $this->db->where('EsRepLeg=1');            
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
    public function validar_renovacion($CodCli,$CodConCom,$FechaServer,$diasAnticipacion)
    {
        $this->db->select('*',false);
        $this->db->from('T_Contrato');       
        $this->db->where('CodCli',$CodCli);
        $this->db->where('CodConCom',$CodConCom);
        $this->db->where('FecVenCon BETWEEN "'. $FechaServer. '" AND "'.$diasAnticipacion.'"');
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
    public function getaudaxcuentasbancariasColaboradores($CodCli,$CodProCom,$CodConCom)
    {
        $sql = $this->db->query("SELECT DISTINCT(d.CodCli) AS CodCli FROM T_Propuesta_Comercial_Clientes a
            JOIN T_Propuesta_Comercial_CUPs b ON a.CodProComCli=b.CodProComCli
            JOIN T_PuntoSuministro c ON b.CodPunSum=c.CodPunSum 
            JOIN T_Cliente d ON c.CodCli=d.CodCli
            WHERE  a.CodCli='$CodCli' AND a.CodProCom='$CodProCom'");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else  
        return false;      
    }
    public function getCuentasClientes($CodCli)
    {
        $this->db->select('*',false);
        $this->db->from('T_CuentaBancaria');       
        $this->db->where('CodCli',$CodCli); 
        $this->db->where('EstCue=1'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function agregar_documentos($CodConCom,$DocConRut,$file_ext,$DocGenCom)
    {
        $this->db->insert('T_DetalleDocumentosContratos',array('CodConCom'=>$CodConCom,'DocConRut'=>$DocConRut,'file_ext'=>$file_ext,'DocGenCom'=>$DocGenCom));
        return $this->db->insert_id();
    }
    public function getDocumentosContratos($CodConCom)
    {
        $this->db->select("*",false);
        $this->db->from('T_DetalleDocumentosContratos');
        $this->db->where('CodConCom',$CodConCom);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function borrar_documentoDB($CodDetDocCon)
    {
       return $this->db->delete('T_DetalleDocumentosContratos', array('CodDetDocCon' => $CodDetDocCon));             
    }
    public function DatosClientesAudax($CodCli)
    {
        $this->db->select("a.RazSocCli,a.NumCifCli,b.IniTipVia,b.DesTipVia,a.EscDomSoc,a.PueDomSoc,NULL as EscDomCliEnv,NULL as PueDomCliEnv,c.DesLoc,d.DesPro,a.NomViaDomSoc,a.NumViaDomSoc,a.CPLocSoc,a.TelFijCli,a.TelMovCli,a.EmaCli",false);
        $this->db->from('T_Cliente a');
        $this->db->join('T_TipoVia b','a.CodTipViaSoc=b.CodTipVia');        
        $this->db->join('T_Localidad c','c.CodLoc=a.CodLocSoc');
        $this->db->join('T_Provincia d','d.CodPro=c.CodPro'); 
        $this->db->where('a.CodCli',$CodCli);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function DatosClientesColaboradorAudax($CodCol)
    {
        $this->db->select("a.NomConCli as RazSocCli,a.NIFConCli as NumCifCli,NULL AS IniTipVia,NULL AS DesTipVia,NULL as EscDomSoc,NULL AS PueDomSoc,NULL as EscDomCliEnv,NULL as PueDomCliEnv,NULL AS DesLoc,NULL AS DesPro,NULL AS  NomViaDomSoc,NULL AS NumViaDomSoc,NULL AS CPLocSoc,a.TelFijConCli as TelFijCli,a.TelCelConCli as TelMovCli,a.EmaConCli as EmaCli",false);
        $this->db->from('T_ContactoCliente a');
       /* $this->db->join('T_TipoVia b','a.CodTipVia=b.CodTipVia');        
        $this->db->join('T_Localidad c','c.CodLoc=a.CodLocSoc');
        $this->db->join('T_Provincia d','d.CodPro=c.CodPro');*/ 
        $this->db->where('a.CodConCli',$CodCol);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function DatosContactosClientesAudax($CodCli)
    {
        $this->db->select("a.*",false);
        $this->db->from('T_ContactoCliente a');
        $this->db->where('a.CodCli',$CodCli);
        $this->db->limit(1);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function DatosCuentaClientesAudax($CodCli)
    {
        $this->db->select("SUBSTRING(a.NumIBan,1,4)AS iban,SUBSTRING(a.NumIBan,5,4)AS entidad,SUBSTRING(a.NumIBan,9,4)AS sucursal,SUBSTRING(a.NumIBan,13,2)AS dc,SUBSTRING(a.NumIBan,15,24)AS cuenta",false);
        $this->db->from('T_CuentaBancaria a');
        $this->db->where('a.CodCli',$CodCli);
        $this->db->limit(1);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function DatosDetallesCUPsClientesAudax($CodProCom)
    {
        $sql = $this->db->query("SELECT d.CUPsEle AS CUPsName,f.IniTipVia,e.NomViaPunSum,e.NumViaPunSum,e.BloPunSum,e.EscPunSum,e.PlaPunSum,e.PuePunSum,e.CPLocSoc,g.DesLoc,h.DesPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6,i.NomTarEle as NomTar,SUBSTRING(j.DesPro,1,2) AS DesProGam,j.ObsPro AS ObsProGam,a.TipCups,a.ConCup
        	FROM T_Propuesta_Comercial_CUPs a 
			JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			JOIN T_PropuestaComercial c ON b.CodProCom=c.CodProCom
			JOIN T_CUPsElectrico d ON a.CodCup=d.CodCupsEle
			JOIN T_PuntoSuministro e ON a.CodPunSum=e.CodPunSum
			JOIN T_TipoVia f ON e.CodTipVia=f.CodTipVia
			JOIN T_Localidad g ON g.CodLoc=e.CodLoc
			JOIN T_Provincia h ON g.CodPro=h.CodPro
			JOIN T_TarifaElectrica i ON i.CodTarEle=a.CodTar
			JOIN T_Producto j ON j.CodPro=c.CodPro
			WHERE c.CodProCom='$CodProCom' AND a.TipCups=1
			UNION ALL
			SELECT d.CupsGas AS CUPsName,f.IniTipVia,e.NomViaPunSum,e.NumViaPunSum,e.BloPunSum,e.EscPunSum,e.PlaPunSum,e.PuePunSum,e.CPLocSoc,g.DesLoc,h.DesPro,a.PotEleConP1,a.PotEleConP2,a.PotEleConP3,a.PotEleConP4,a.PotEleConP5,a.PotEleConP6,i.NomTarGas as NomTar,SUBSTRING(j.DesPro,1,2) AS DesProGam,j.ObsPro AS ObsProGam,a.TipCups,a.ConCup 
			FROM T_Propuesta_Comercial_CUPs a 
			JOIN T_Propuesta_Comercial_Clientes b ON a.CodProComCli=b.CodProComCli
			JOIN T_PropuestaComercial c ON b.CodProCom=c.CodProCom
			JOIN T_CUPsGas d ON a.CodCup=d.CodCupGas
			JOIN T_PuntoSuministro e ON a.CodPunSum=e.CodPunSum
			JOIN T_TipoVia f ON e.CodTipVia=f.CodTipVia
			JOIN T_Localidad g ON g.CodLoc=e.CodLoc
			JOIN T_Provincia h ON g.CodPro=h.CodPro
			JOIN T_TarifaGas i ON i.CodTarGas=a.CodTar
			JOIN T_Producto j ON j.CodPro=c.CodPro
			WHERE c.CodProCom='$CodProCom' AND a.TipCups=2");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else  
        return false;              
    }
    public function DatosContratoClientesAudax($CodConCom)
    {
        $this->db->select("a.*,b.TipPre,b.ObsProCom",false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_PropuestaComercial b','a.CodProCom=b.CodProCom','LEFT');
        $this->db->where('a.CodConCom',$CodConCom);
        $this->db->limit(1);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }

    


///////////////////////////////////////////////// PARA CONTRATOS END ////////////////////////////////////////////////
}
?>