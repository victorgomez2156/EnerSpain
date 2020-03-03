<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clientes_model extends CI_Model 
{ 
    //////////////////////////////////////////////// CLIENTES START /////////////////////////////////////////////////////////
    public function get_list_clientes() 
    {
        $this->db->select('a.CodCli,a.NumCifCli,a.RazSocCli,a.TelFijCli,a.NomComCli,b.DesTipVia as CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,d.DesPro as CodPro,c.DesLoc as CodLoc,a.EmaCli,a.WebCli,e.DesTipCli as CodTipCli,DATE_FORMAT(a.FecIniCli,"%d/%m/%Y") as FecIniCli,f.NomCom as CodCom,a.ObsCli,a.EstCli,g.DesSecCli AS CodSecCli,h.NomCol AS CodCol,i.DesTipVia as CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,k.DesPro as CodProFis,j.DesLoc as CodLocFis,CASE a.EstCli WHEN 3 THEN "ACTIVO" WHEN 4 THEN "BLOQUEADO" END AS EstCliN,a.CodTipViaSoc as CodTipViaSoc1,a.CodLocSoc as CodLocSoc1,c.CodPro as CodProSoc2,a.CodTipCli as CodTipCliSoc2,a.CodSecCli as CodSecCliSoc2,c.CPLoc as CPLocSoc,a.CodTipViaFis as CodTipViaFis2,a.CodLocFis as CodLocFis2,j.CodPro as CodProFis2,j.CPLoc as CPLocFis,a.CodCom as CodCom2,a.CodCol as CodCol2 ',FALSE);
        $this->db->from('T_Cliente a'); 
        $this->db->join('T_TipoVia b','a.CodTipViaSoc=b.CodTipVia');       
        $this->db->join('T_Localidad c','a.CodLocSoc=c.CodLoc'); 
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        $this->db->join('T_TipoCliente e','a.CodTipCli=e.CodTipCli');
        $this->db->join('T_Comercial f','a.CodCom=f.CodCom');
        $this->db->join('T_SectorCliente g','a.CodSecCli=g.CodSecCli');
        $this->db->join('T_Colaborador h','a.CodCol=h.CodCol','LEFT'); 
        $this->db->join('T_TipoVia i','a.CodTipViaFis=i.CodTipVia');
        $this->db->join('T_Localidad j','a.CodLocFis=j.CodLoc'); 
        $this->db->join('T_Provincia k','j.CodPro=k.CodPro');       
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
    public function agregar($BloDomFis,$BloDomSoc,$CodCol,$CodCom,$CodLocFis,$CodLocSoc,$CodProFis,$CodProSoc,$CodSecCli,$CodTipCli,$CodTipViaFis,$CodTipViaSoc,$EmaCli,$EscDomFis,$EscDomSoc,$FecIniCli,$NomComCli,$NomViaDomFis,$NomViaDomSoc,$NumCifCli,$NumViaDomFis,$NumViaDomSoc,$ObsCli,$PlaDomFis,$PlaDomSoc,$PueDomFis,$PueDomSoc,$RazSocCli,$TelFijCli,$WebCli)
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
            $this->db->insert('T_Cliente',array('RazSocCli'=>$RazSocCli,'NomComCli'=>$NomComCli,'NumCifCli'=>$NumCifCli,'CodTipViaSoc'=>$CodTipViaSoc,'NomViaDomSoc'=>$NomViaDomSoc,'NumViaDomSoc'=>$NumViaDomSoc,'BloDomSoc'=>$BloDomSoc,'EscDomSoc'=>$EscDomSoc,'PlaDomSoc'=>$PlaDomSoc,'PueDomSoc'=>$PueDomSoc,'CodLocSoc'=>$CodLocSoc,'CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'BloDomFis'=>$BloDomFis,'EscDomFis'=>$EscDomFis,'PlaDomFis'=>$PlaDomFis,'PueDomFis'=>$PueDomFis,'CodLocFis'=>$CodLocFis,'TelFijCli'=>$TelFijCli,'EmaCli'=>$EmaCli,'WebCli'=>$WebCli,'CodTipCli'=>$CodTipCli,'CodSecCli'=>$CodSecCli,'FecIniCli'=>$FecIniCli,'CodCom'=>$CodCom,'CodCol'=>$CodCol,'ObsCli'=>$ObsCli));
            return $this->db->insert_id();
        }   
        /*$check_exists_NumCifCli = $this->db->get_where("T_Cliente", array("NumCifCli"=> $NumCifCli));
        if($check_exists_NumCifCli->num_rows()>0)
        {
            return true;
        }
        else
        {
            $this->db->insert('T_Cliente',array('RazSocCli'=>$RazSocCli,'NomComCli'=>$NomComCli,'NumCifCli'=>$NumCifCli,'CodTipViaSoc'=>$CodTipViaSoc,'NomViaDomSoc'=>$NomViaDomSoc,'NumViaDomSoc'=>$NumViaDomSoc,'BloDomSoc'=>$BloDomSoc,'EscDomSoc'=>$EscDomSoc,'PlaDomSoc'=>$PlaDomSoc,'PueDomSoc'=>$PueDomSoc,'CodLocSoc'=>$CodLocSoc,'CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'BloDomFis'=>$BloDomFis,'EscDomFis'=>$EscDomFis,'PlaDomFis'=>$PlaDomFis,'PueDomFis'=>$PueDomFis,'CodLocFis'=>$CodLocFis,'TelFijCli'=>$TelFijCli,'EmaCli'=>$EmaCli,'WebCli'=>$WebCli,'CodTipCli'=>$CodTipCli,'CodSecCli'=>$CodSecCli,'FecIniCli'=>$FecIniCli,'CodCom'=>$CodCom,'CodCol'=>$CodCol,'ObsCli'=>$ObsCli));
            return $this->db->insert_id();
        }*/
    }
    public function actualizar($CodCli,$BloDomFis,$BloDomSoc,$CodCol,$CodCom,$CodLocFis,$CodLocSoc,$CodProFis,$CodProSoc,$CodSecCli,$CodTipCli,$CodTipViaFis,$CodTipViaSoc,$EmaCli,$EscDomFis,$EscDomSoc,$NomComCli,$NomViaDomFis,$NomViaDomSoc,$NumViaDomFis,$NumViaDomSoc,$ObsCli,$PlaDomFis,$PlaDomSoc,$PueDomFis,$PueDomSoc,$RazSocCli,$TelFijCli,$WebCli,$FecIniCli,$CPLocSoc,$CPLocFis)
    {   
        $this->db->where('CodCli', $CodCli);        
        return $this->db->update('T_Cliente',array('RazSocCli'=>$RazSocCli,'NomComCli'=>$NomComCli,'CodTipViaSoc'=>$CodTipViaSoc,'NomViaDomSoc'=>$NomViaDomSoc,'NumViaDomSoc'=>$NumViaDomSoc,'BloDomSoc'=>$BloDomSoc,'EscDomSoc'=>$EscDomSoc,'PlaDomSoc'=>$PlaDomSoc,'PueDomSoc'=>$PueDomSoc,'CodLocSoc'=>$CodLocSoc,'CodTipViaFis'=>$CodTipViaFis,'NomViaDomFis'=>$NomViaDomFis,'NumViaDomFis'=>$NumViaDomFis,'BloDomFis'=>$BloDomFis,'EscDomFis'=>$EscDomFis,'PlaDomFis'=>$PlaDomFis,'PueDomFis'=>$PueDomFis,'CodLocFis'=>$CodLocFis,'TelFijCli'=>$TelFijCli,'EmaCli'=>$EmaCli,'WebCli'=>$WebCli,'CodTipCli'=>$CodTipCli,'CodSecCli'=>$CodSecCli,'CodCom'=>$CodCom,'CodCol'=>$CodCol,'ObsCli'=>$ObsCli,'FecIniCli'=>$FecIniCli,'CPLocSoc'=>$CPLocSoc,'CPLocFis'=>$CPLocFis));
    }


    //////////////////////////////////////////////// CLIENTES END /////////////////////////////////////////////////////////




    
    ///////////////////////////////////////////////////////////////////// ACTIVIDADES START /////////////////////////////////////////////////////////////////


    public function get_activity_clientes()
    {
       $sql = $this->db->query("SELECT a.*,b.*,case a.EstAct when 1 then 'Activa' when 2 then 'Bloqueada' end as EstAct ,DATE_FORMAT(a.FecIniAct, '%d/%m/%Y') as FecIniAct,c.NumCifCli,c.RazSocCli FROM T_ActividadCliente a join T_CNAE b on a.CodActCNAE=b.id join T_Cliente c on c.CodCli=a.CodCli  order by b.DesActCNAE asc");
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
      
    ////////////////// ACTIVIDADES END ///////////////////////////////


    ////////////////////////////////////////////////////////////////////// PUNTOS DE SUMINISTROS START /////////////////////////////////////////////////////////////////

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
        $this->db->select('b.NumCifCli,b.RazSocCli,c.DesLoc,d.DesPro,a.EstPunSum,CASE a.EstPunSum WHEN 1 THEN "Activo" WHEN 2 THEN "Bloqueado" END AS EstPunSum,e.DesTipVia,e.IniTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,a.CodPunSum,a.CodCli,f.DesTipInm,a.TipRegDir,a.CodTipVia,a.CodLoc,c.CodPro,c.CPLoc,a.CodTipInm,a.RefCasPunSum,a.DimPunSum,a.ObsPunSum',FALSE);
        $this->db->from('T_PuntoSuministro a');   
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli'); 
        $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc');
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        $this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia');
        $this->db->join('T_TipoInmueble f','a.CodTipInm=f.CodTipInm');    
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
        $this->db->join('T_Localidad b','a.CodLocSoc=b.CodLoc');
        $this->db->join('T_Localidad c','a.CodLocFis=c.CodLoc');
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
    ///////////////////////////////////////////////////////////////////// PUNTOS DE SUMINISTROS END /////////////////////////////////////////////////////////////////






 ///////////////////////////////////////////////////////////////////// CONTACTOS START /////////////////////////////////////////////////////////////////


 public function get_lista_contactos()
    {
       $sql = $this->db->query("SELECT a.CodConCli,a.CodCli,b.CodTipCon,b.DesTipCon,case a.EsRepLeg WHEN 0 then 'NO' WHEN 1 THEN 'SI' end as EsRepLeg,a.CanMinRep,a.NomConCli,a.NIFConCli,a.DocNIF,case a.TieFacEsc WHEN 0 then 'NO' WHEN 1 THEN 'SI' end as TieFacEsc,a.DocPod,a.TelFijConCli,a.TelCelConCli,a.EmaConCli,a.TipRepr,a.CarConCli,a.ObsConC,case a.EstConCli WHEN 1 THEN 'ACTIVO' WHEN 2 THEN 'BLOQUEADO' END as EstConCli,case a.TipRepr WHEN 1 THEN 'INDEPENDIENTE' WHEN 2 THEN 'MANCOMUNADA' END as representacion,c.NumCifCli,c.RazSocCli FROM T_ContactoCliente a JOIN T_TipoContacto b on a.CodTipCon=b.CodTipCon JOIN T_Cliente c on a.CodCli=c.CodCli");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else
        return false;        
    }
    public function get_xID_Contactos($CodConCli)
    {
        $this->db->select('a.*',FALSE);
        $this->db->from('T_ContactoCliente a');   
        //$this->db->join('T_Cliente b','a.CodCli=b.CodCli'); 
       // $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        //$this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        //$this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia');
        $this->db->where('a.CodConCli',$CodConCli);    
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
     public function comprobar_cif_contacto_existencia($NIFConCli)
    {
        $this->db->select('NIFConCli,CodConCli');
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
     public function agregar_contacto($NIFConCli,$EsRepLeg,$TieFacEsc,$CanMinRep,$CodCli,$CodTipCon,$CarConCli,$NomConCli,$TelFijConCli,$TelCelConCli,$EmaConCli,$TipRepr,$DocNIF,$ObsConC,$DocPod)
    {
        $this->db->insert('T_ContactoCliente',array('CodCli'=>$CodCli,'CodTipCon'=>$CodTipCon,'EsRepLeg'=>$EsRepLeg,'CanMinRep'=>$CanMinRep,'NomConCli'=>$NomConCli,'NIFConCli'=>$NIFConCli,'DocNIF'=>$DocNIF,'TieFacEsc'=>$TieFacEsc,'DocPod'=>$DocPod,'TelFijConCli'=>$TelFijConCli,'TelCelConCli'=>$TelCelConCli,'EmaConCli'=>$EmaConCli,'TipRepr'=>$TipRepr,'CarConCli'=>$CarConCli,'ObsConC'=>$ObsConC));
        return $this->db->insert_id();
    }
    public function actualizar_contacto($CodConCli,$NIFConCli,$EsRepLeg,$TieFacEsc,$CanMinRep,$CodCli,$CodTipCon,$CarConCli,$NomConCli,$TelFijConCli,$TelCelConCli,$EmaConCli,$TipRepr,$DocNIF,$ObsConC,$DocPod)
    {   
        $this->db->where('CodConCli', $CodConCli);        
        return $this->db->update('T_ContactoCliente',array('CodTipCon'=>$CodTipCon,'EsRepLeg'=>$EsRepLeg,'CanMinRep'=>$CanMinRep,'NomConCli'=>$NomConCli,'DocNIF'=>$DocNIF,'TieFacEsc'=>$TieFacEsc,'DocPod'=>$DocPod,'TelFijConCli'=>$TelFijConCli,'TelCelConCli'=>$TelCelConCli,'EmaConCli'=>$EmaConCli,'TipRepr'=>$TipRepr,'CarConCli'=>$CarConCli,'ObsConC'=>$ObsConC,'CodCli'=>$CodCli));
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
///////////////////////////////////////////////////////////////////// CONTACTOS END /////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////// CUENTAS BANCARIAS START /////////////////////////////////////////////////////////////////

    public function get_all_Cuentas_Bancarias_clientes()
    {
       $sql = $this->db->query("SELECT a.CodCueBan,a.CodBan,b.DesBan,a.CodCli,SUBSTRING(a.NumIBan,1,4)AS CodEur,SUBSTRING(a.NumIBan,5,4)AS IBAN1,SUBSTRING(a.NumIBan,9,4)AS IBAN2,SUBSTRING(a.NumIBan,13,4)AS IBAN3,SUBSTRING(a.NumIBan,17,4)AS IBAN4,SUBSTRING(a.NumIBan,21,4)AS IBAN5,a.EstCue,CASE EstCue WHEN 1 THEN 'ACTIVA' WHEN 2 THEN 'BLOQUEADA' END AS EstaCue,c.NumCifCli,c.RazSocCli from T_CuentaBancaria a JOIN T_Banco b ON a.CodBan=b.CodBan JOIN T_Cliente c ON a.CodCli=c.CodCli");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else
        return false;        
    }
    public function get_xID_CuentaBancaria($CodConCli)
    {
        $sql = $this->db->query("SELECT a.CodCueBan,a.CodBan,b.DesBan,a.CodCli,SUBSTRING(a.NumIBan,1,4)AS CodEur,SUBSTRING(a.NumIBan,5,4)AS IBAN1,SUBSTRING(a.NumIBan,9,4)AS IBAN2,SUBSTRING(a.NumIBan,13,4)AS IBAN3,SUBSTRING(a.NumIBan,17,4)AS IBAN4,SUBSTRING(a.NumIBan,21,4)AS IBAN5,a.EstCue,CASE EstCue WHEN 1 THEN 'ACTIVA' WHEN 2 THEN 'BLOQUEADA' END AS EstaCue,c.NumCifCli,c.RazSocCli from T_CuentaBancaria a JOIN T_Banco b ON a.CodBan=b.CodBan JOIN T_Cliente c ON a.CodCli=c.CodCli where a.CodCueBan='$CodConCli'");
        if ($sql->num_rows() > 0)
          return $sql->row();
        else
        return false;       
    }
     public function buscar_NumIBan($NumIBan,$CodBan)
    {
        $this->db->select('NumIBan');
        $this->db->from('T_CuentaBancaria');
        //$this->db->where('CodBan',$CodBan);
        $this->db->where('NumIBan',$NumIBan);
        //$this->db->order_by('DesSec,DesGru,DesEpi ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return true;
        else
        return false;
    }   
     
     public function actualizar_numero_cuenta($CodCueBan,$CodCli,$NumIBan,$CodBan)
    {   
        $this->db->where('CodCueBan', $CodCueBan);
        return $this->db->update('T_CuentaBancaria',array('NumIBan'=>$NumIBan,'CodBan'=>$CodBan,'CodCli'=>$CodCli));
    }
    public function agregar_numero_cuenta($CodCli,$NumIBan,$CodBan)
    {
        $this->db->insert('T_CuentaBancaria',array('CodCli'=>$CodCli,'NumIBan'=>$NumIBan,'CodBan'=>$CodBan));
        return $this->db->insert_id();
    }



///////////////////////////////////////////////////////////////////// CUENTAS BANCARIAS END /////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////// DOCUMENTOS START /////////////////////////////////////////////////////////////////
 public function get_all_documentos()
    {
       $this->db->select('a.CodTipDocAI,b.NumCifCli,b.RazSocCli,,a.CodCli,c.DesTipDoc,a.CodTipDoc,a.DesDoc,a.TieVen,DATE_FORMAT(a.FecVenDoc,"%d/%m/%Y") as FecVenDoc,a.ObsDoc,CASE TieVen WHEN 1 THEN "SI" WHEN 2 THEN "NO" END AS TieVenDes,a.ArcDoc',false);
       $this->db->from('T_Documentos a');
       $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
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

///////////////////////////////////////////////////////////////////// DOCUMENTOS END /////////////////////////////////////////////////////////////////





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
        $this->db->select(  'a.CodCli,a.RazSocCli,a.NomComCli,a.NumCifCli,a.CodTipViaSoc,a.NomViaDomSoc,a.NumViaDomSoc,
                            a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,a.CodLocSoc as CodLocSoc,a.TelFijCli,a.EmaCli,
                            a.WebCli,a.CodTipCli,DATE_FORMAT(a.FecIniCli,"%d/%m/%Y") as FecIniCli,a.CodCom,a.ObsCli,a.EstCli,
                            a.CPLocSoc,b.CodPro as CodProSoc,a.CodTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,
                            a.EscDomFis,a.PlaDomFis,a.PueDomFis,a.CodLocFis,a.CodSecCli,a.CodCol,c.CodPro as CodProFis,
                            a.CPLocFis,a.DireccionBBDD');
        $this->db->from('T_Cliente a'); 
        $this->db->join('T_Localidad b','a.CodLocSoc=b.CodLoc');
        $this->db->join('T_Localidad c','a.CodLocFis=c.CodLoc');         
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

   





   
   
   
    public function get_all_contactos($CodCli)
    {
       $sql = $this->db->query("SELECT a.CodPunSum,a.CodCli,a.TipRegDir,case a.TipRegDir when 0 then 'Nuevo' when 1 then 'Misma Dirección Social' when 2 then 'Misma Dirección Fiscal' end as TipDir,b.DesTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,d.DesPro,c.DesLoc,c.CPLoc,e.DesTipInm,a.RefCasPunSum,a.DimPunSum,a.ObsPunSum,a.TelPunSum,a.EstPunSum,case a.EstPunSum when 1 then 'Activo' when 2 then 'Bloqueado' end as EstuPunSum,c.CodLoc as CodLocPunSum,d.CodPro as CodProPunSum,a.CodTipVia,a.CodTipInm,c.CPLoc as ZonPosPunSum FROM T_PuntoSuministro a JOIN T_TipoVia b on a.CodTipVia=b.CodTipVia JOIN T_Localidad c ON a.CodLoc=c.CodLoc JOIN T_Provincia d ON c.CodPro=d.CodPro JOIN T_TipoInmueble e ON a.CodTipInm=e.CodTipInm where CodCli='$CodCli'");
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