<?php
class Reportes_model extends CI_Model 
{ 
	public function get_tipo_filtro_busqueda($Tabla,$Columna,$Tipo_Cliente)
    {
        $this->db->select('*');
        $this->db->from($Tabla);
        $this->db->where($Columna,$Tipo_Cliente);          
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
    public function get_data_cliente_all()
    {
        $this->db->select('a.RazSocCli,a.NumCifCli,a.NomComCli,d.DesTipVia,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,             c.DesPro,b.DesLoc,g.DesTipVia as DesTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,f.DesPro as DesProFis,e.DesLoc as DesLocFis,a.TelFijCli,a.EmaCli,h.DesTipCli,i.DesSecCli,j.NomCom,k.NomCol,date_format(a.FecIniCli, "%d-%m-%Y") as FecIniCli,case a.EstCli when 3 then "ACTIVO" WHEN 4 THEN "BLOQUEADO" end as EstCli',FALSE);
        $this->db->from('T_Cliente a');
        $this->db->join('T_Localidad b','a.CodLocFis=b.CodLoc');
        $this->db->join('T_Provincia c','b.CodPro=c.CodPro');
        $this->db->join('T_TipoVia d','d.CodTipVia=a.CodTipViaSoc');
        $this->db->join('T_Localidad e','a.CodLocFis=e.CodLoc');
        $this->db->join('T_Provincia f','f.CodPro=e.CodPro');
        $this->db->join('T_TipoVia g','g.CodTipVia=a.CodTipViaFis');
        $this->db->join('T_TipoCliente h','a.CodTipCli=h.CodTipCli');
        $this->db->join('T_SectorCliente i','a.CodSecCli=i.CodSecCli');
        $this->db->join('T_Comercial j','j.CodCom=a.CodCom');
        $this->db->join('T_Colaborador k','k.CodCol=a.CodCol','LEFT');
        //$this->db->where($where,$CodTipCli);          
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
    public function get_data_cliente($where,$Variable)
    {
        $this->db->select('a.RazSocCli,a.NumCifCli,a.NomComCli,d.DesTipVia,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,             c.DesPro,b.DesLoc,g.DesTipVia as DesTipViaFis,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,f.DesPro as DesProFis,e.DesLoc as DesLocFis,a.TelFijCli,a.EmaCli,h.DesTipCli,i.DesSecCli,j.NomCom,k.NomCol,date_format(a.FecIniCli, "%d-%m-%Y") as FecIniCli      ,case a.EstCli when 3 then "ACTIVO" WHEN 4 THEN "BLOQUEADO" end as EstCli',FALSE);
        $this->db->from('T_Cliente a');
        $this->db->join('T_Localidad b','a.CodLocFis=b.CodLoc');
        $this->db->join('T_Provincia c','b.CodPro=c.CodPro');
        $this->db->join('T_TipoVia d','d.CodTipVia=a.CodTipViaSoc');
        $this->db->join('T_Localidad e','a.CodLocFis=e.CodLoc');
        $this->db->join('T_Provincia f','f.CodPro=e.CodPro');
        $this->db->join('T_TipoVia g','g.CodTipVia=a.CodTipViaFis');
        $this->db->join('T_TipoCliente h','a.CodTipCli=h.CodTipCli');
        $this->db->join('T_SectorCliente i','a.CodSecCli=i.CodSecCli');
        $this->db->join('T_Comercial j','j.CodCom=a.CodCom');
        $this->db->join('T_Colaborador k','k.CodCol=a.CodCol','LEFT');
        $this->db->where($where,$Variable);          
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
     public function get_data_activity_all()
    {
        $this->db->select('b.CodActCNAE,b.DesActCNAE,b.GruActCNAE,b.SubGruActCNAE,b.SecActCNAE,case a.EstAct when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstAct,DATE_FORMAT(a.FecIniAct,"%d/%m/%Y") as FecIniAct,c.NumCifCli,c.RazSocCli',FALSE);
        $this->db->from('T_ActividadCliente a');
        $this->db->join('T_CNAE b','a.CodActCNAE=b.id');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
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
     public function get_data_activity_all_filtro($where1,$Variable)
    {
        $this->db->select('b.CodActCNAE,b.DesActCNAE,b.GruActCNAE,b.SubGruActCNAE,b.SecActCNAE,case a.EstAct when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstAct,DATE_FORMAT(a.FecIniAct,"%d/%m/%Y") as FecIniAct,c.NumCifCli,c.RazSocCli',FALSE);
        $this->db->from('T_ActividadCliente a');        
        $this->db->join('T_CNAE b','a.CodActCNAE=b.id');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->where($where1,$Variable);          
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
     public function get_data_Puntos_Suministros_all()
    {
        $this->db->select('case a.TipRegDir when 0 then "NUEVO" WHEN 1 THEN "Misma Dirección Social" WHEN 2 THEN "Misma Dirección Fiscal"end as TipRegDir,b.DesTipVia,b.IniTipVia,a.NomViaPunSum,d.DesPro,c.DesLoc,a.TelPunSum,e.DesTipInm,case a.EstPunSum when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstPunSum,f.NumCifCli,f.RazSocCli,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum',FALSE);
        $this->db->from('T_PuntoSuministro a');
        $this->db->join('T_TipoVia b','a.CodTipVia=b.CodTipVia');
        $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc');
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        $this->db->join('T_TipoInmueble e','a.CodTipInm=e.CodTipInm');
        $this->db->join('T_Cliente f','a.CodCli=f.CodCli');
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
     public function get_data_PumSum_all_filtro($where,$Variable)
    {
        $this->db->select('f.NumCifCli,f.RazSocCli,b.DesTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,d.DesPro,c.DesLoc,case a.EstPunSum when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstPunSum',FALSE);
        $this->db->from('T_PuntoSuministro a');
        $this->db->join('T_TipoVia b','a.CodTipVia=b.CodTipVia');
        $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc');
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        $this->db->join('T_TipoInmueble e','a.CodTipInm=e.CodTipInm');
        $this->db->join('T_Cliente f','a.CodCli=f.CodCli');
        $this->db->where($where,$Variable);          
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
     public function get_data_contactos_all()
    {       
        $this->db->select('a.NomConCli,a.NIFConCli,a.TelFijConCli,a.TelCelConCli,a.EmaConCli,b.DesTipCon,a.CarConCli,case a.EsRepLeg when 0 then "NO" WHEN 1 THEN "SI" end as EsRepLeg,case a.TipRepr when 1 then "INDEPENDIENTE" WHEN 2 THEN "MANCOMUNADA" end as TipRepr,case a.EstConCli when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstConCli,c.NumCifCli,c.RazSocCli',FALSE);
        $this->db->from('T_ContactoCliente a');
        $this->db->join('T_TipoContacto b','a.CodTipCon=b.CodTipCon');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
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
    public function get_data_contacto_all_filtro($where,$Variable1)
    {       
        $this->db->select('a.NomConCli,a.NIFConCli,a.TelFijConCli,a.TelCelConCli,a.EmaConCli,b.DesTipCon,a.CarConCli,case a.EsRepLeg when 0 then "NO" when 1 THEN "SI" end as EsRepLeg,case a.TipRepr when 1 then "INDEPENDIENTE" WHEN 2 THEN "MANCOMUNADA" end as TipRepr,case a.EstConCli when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstConCli,c.NumCifCli,c.RazSocCli',FALSE);
        $this->db->from('T_ContactoCliente a');
        $this->db->join('T_TipoContacto b','a.CodTipCon=b.CodTipCon');
         $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->where($where,$Variable1);          
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
    public function get_data_bank_all()
    {       
        $this->db->select('b.DesBan,a.NumIBan,case a.EstCue when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCue,c.NumCifCli,c.RazSocCli',FALSE);
        $this->db->from('T_CuentaBancaria a');
        $this->db->join('T_Banco b','a.CodBan=b.CodBan');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->order_by('b.DesBan asc');           
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
    public function get_data_banco_all_filtro($where1,$Variable1)
    {       
        $this->db->select('b.DesBan,a.NumIBan,case a.EstCue when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCue,c.NumCifCli,c.RazSocCli',FALSE);
        $this->db->from('T_CuentaBancaria a');
        $this->db->join('T_Banco b','a.CodBan=b.CodBan');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->where($where1,$Variable1);
        $this->db->order_by('b.DesBan asc');           
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
    public function get_data_comercializadora_all()
    {
        $this->db->select('a.NumCifCom,a.RazSocCom,a.NomComCom,d.DesTipVia,a.NomViaDirCom,c.DesPro,b.DesLoc,a.TelFijCom,a.EmaCom,case a.EstCom when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,a.NomConCom',FALSE);
        $this->db->from('T_Comercializadora a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        $this->db->join('T_Provincia c','b.CodPro=c.CodPro');
        $this->db->join('T_TipoVia d','d.CodTipVia=a.CodTipVia');
        $this->db->order_by('a.NomComCom ASC');        
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
    public function get_data_comercializadora_all_filtradas($where,$Variable)
    {
        $this->db->select('a.NumCifCom,a.RazSocCom,a.NomComCom,d.DesTipVia,a.NomViaDirCom,c.DesPro,b.DesLoc,a.TelFijCom,a.EmaCom,case a.EstCom when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,a.NomConCom',FALSE);
        $this->db->from('T_Comercializadora a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        $this->db->join('T_Provincia c','b.CodPro=c.CodPro');
        $this->db->join('T_TipoVia d','d.CodTipVia=a.CodTipVia');
        $this->db->where($where,$Variable); 
        $this->db->order_by('a.NomComCom ASC');           
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
    public function get_data_productos_all()
    {
        $this->db->select('a.CodPro,b.RazSocCom,b.NumCifCom,a.DesPro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,a.ObsPro,DATE_FORMAT(a.FecIniPro,"%d/%m/%Y")as FecIniPro,case a.EstPro when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstPro,a.CodCom',FALSE);
        $this->db->from('T_Producto a');
        $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
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
     public function get_data_productos_all_filtrados($where,$variable)
    {
        $this->db->select('a.CodPro,b.RazSocCom,b.NumCifCom,a.DesPro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,a.ObsPro,DATE_FORMAT(a.FecIniPro,"%d/%m/%Y")as FecIniPro,case a.EstPro when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstPro,a.CodCom',FALSE);
        $this->db->from('T_Producto a');
        $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
        $this->db->where($where,$variable);
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
    public function get_data_all_anexos()
    {
        $this->db->select('a.CodAnePro,c.RazSocCom,c.NumCifCom,b.DesPro,a.DesAnePro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,case a.EstAne when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstAne,a.ObsAnePro,date_format(a.FecIniAne,"%d/%m/%Y") as FecIniAne,case a.TipPre when 0 then "FIJO" when 1 then "INDEXANDO" WHEN 2 THEN "AMBOS" end TipPre,a.DocAnePro,a.EstCom,a.CodTipCom,d.DesTipCom',FALSE);
        $this->db->from('T_AnexoProducto a');
        $this->db->join('T_Producto b','a.CodPro=b.CodPro');
        $this->db->join('T_Comercializadora c','b.CodCom=c.CodCom');
        $this->db->join('T_TipoComision d','a.CodTipCom=d.CodTipCom');
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
     public function get_data_all_anexos_filtradas($Where,$Variable)
    {
        $this->db->select('a.CodAnePro,c.RazSocCom,c.NumCifCom,b.DesPro,a.DesAnePro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,case a.EstAne when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstAne,a.ObsAnePro,date_format(a.FecIniAne,"%d/%m/%Y") as FecIniAne,case a.TipPre when 0 then "FIJO" when 1 then "INDEXANDO" WHEN 2 THEN "AMBOS" end TipPre,a.DocAnePro,a.EstCom,a.CodTipCom,d.DesTipCom',FALSE);
        $this->db->from('T_AnexoProducto a');
        $this->db->join('T_Producto b','a.CodPro=b.CodPro');
        $this->db->join('T_Comercializadora c','b.CodCom=c.CodCom');
        $this->db->join('T_TipoComision d','a.CodTipCom=d.CodTipCom');
        $this->db->where($Where,$Variable);
        $this->db->order_by('b.DesPro ASC');          
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
    public function get_data_all_servicios_especiales()
    {
        $this->db->select('a.CodSerEsp,a.CodCom,b.RazSocCom,b.NumCifCom,a.DesSerEsp,case a.TipSumSerEsp when 0 then "GAS" when 1 then "ELÉCTRICO" WHEN 2 THEN "AMBOS" end TipSumSerEsp,a.CarSerEsp,case a.TipCli when 0 then "PARTICULAR" when 1 then "NEGOCIO" end TipCli,date_format(a.FecIniSerEsp,"%d/%m/%Y") as FecIniSerEsp,c.DesTipCom,a.CodTipCom,a.OsbSerEsp,case a.EstSerEsp when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstSerEsp',FALSE);
        $this->db->from('T_ServicioEspecial a');
        $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
        $this->db->join('T_TipoComision c','a.CodTipCom=c.CodTipCom');  
        $this->db->order_by('a.DesSerEsp ASC');          
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
    public function get_data_all_servicio_especiales_filtradas($Where,$Variable)
    {
        $this->db->select('a.CodSerEsp,a.CodCom,b.RazSocCom,b.NumCifCom,a.DesSerEsp,case a.TipSumSerEsp when 0 then "GAS" when 1 then "ELÉCTRICO" WHEN 2 THEN "AMBOS" end TipSumSerEsp,a.CarSerEsp,case a.TipCli when 0 then "PARTICULAR" when 1 then "NEGOCIO" end TipCli,date_format(a.FecIniSerEsp,"%d/%m/%Y") as FecIniSerEsp,c.DesTipCom,a.CodTipCom,a.OsbSerEsp,case a.EstSerEsp when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstSerEsp',FALSE);
        $this->db->from('T_ServicioEspecial a');
        $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
        $this->db->join('T_TipoComision c','a.CodTipCom=c.CodTipCom');  
        $this->db->where($Where,$Variable); 
        $this->db->order_by('a.DesSerEsp ASC');          
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
    public function get_data_all_distribuidoras()
    {
        $this->db->select('CodDist,NumCifDis,RazSocDis,NomComDis,TelFijDis,EmaDis,PagWebDis,PerConDis,case TipSerDis when 0 then "ELÉCTRICO" WHEN 1 THEN "GAS" WHEN 2 THEN "AMBOS SERVICIOS" end as TipSerDis,ObsDis,case EstDist when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstDist',false);
        $this->db->from('T_Distribuidora');       
        $this->db->order_by('RazSocDis ASC');              
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
    public function get_data_all_distribuidoras_filtradas($Where,$Variable2)
    {
        $this->db->select('CodDist,NumCifDis,RazSocDis,NomComDis,TelFijDis,EmaDis,PagWebDis,PerConDis,case TipSerDis when 0 then "ELÉCTRICO" WHEN 1 THEN "GAS" WHEN 2 THEN "AMBOS SERVICIOS" end as TipSerDis,ObsDis,case EstDist when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" end as EstDist',false);
        $this->db->from('T_Distribuidora'); 
        $this->db->where($Where,$Variable2);              
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
    public function get_data_all_tarifas()
    {
        $this->db->select('CodTarEle,case TipTen when 0 then "BAJA" WHEN 1 THEN "ALTA" WHEN 2 THEN "AMBAS" end as TipTen,NomTarEle,CanPerTar,MinPotCon,MaxPotCon',false);
        $this->db->from('T_TarifaElectrica');    
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
     public function get_data_all_tarifas_filtradas($Where,$Variable)
    {
        $this->db->select('CodTarEle,case TipTen when 0 then "BAJA" WHEN 1 THEN "ALTA" WHEN 2 THEN "AMBAS" end as TipTen,NomTarEle,CanPerTar,MinPotCon,MaxPotCon',false);
        $this->db->from('T_TarifaElectrica');  
        $this->db->where($Where,$Variable);    
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
    public function get_data_all_tarifas_gas()
    {
        $this->db->select('CodTarGas,NomTarGas,MinConAnu,MaxConAnu',false);
        $this->db->from('T_TarifaGas');    
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
    public function get_data_all_colaboradores()
    {
        $this->db->select('NomCol,NumIdeFis,case TipCol when 1 then "Persona Física" when 2 THEN "Empresa" end as TipCol,PorCol,TelCelCol,case EstCol when 1 then "ACTIVO" when 2 THEN "BLOQUEADO" end as EstCol ',false);
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
    public function get_data_all_colaboradores_filtradas($Where,$Variable)
    {
        $this->db->select('NomCol,NumIdeFis,case TipCol when 1 then "Persona Física" when 2 THEN "Empresa" end as TipCol,PorCol,TelCelCol,case EstCol when 1 then "ACTIVO" when 2 THEN "BLOQUEADO" end as EstCol ',false);
        $this->db->from('T_Colaborador');
        $this->db->where($Where,$Variable);
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
    public function get_data_all_comerciales()
    {
        $this->db->select('NomCom,NIFCom,TelFijCom,TelCelCom,EmaCom,case EstCom when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" END as EstCom',false);
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
    public function get_data_all_comerciales_filtradas($Where,$Variable)
    {
        $this->db->select('NomCom,NIFCom,TelFijCom,TelCelCom,EmaCom,case EstCom when 1 then "ACTIVO" WHEN 2 THEN "BLOQUEADO" END as EstCom',false);
        $this->db->from('T_Comercial');
        $this->db->where($Where,$Variable);              
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
     public function get_data_all_tipos_cliente()
    {
        $this->db->select('*');
        $this->db->from('T_TipoCliente');
        $this->db->order_by('DesTipCli ASC');              
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
    public function get_data_all_tipos_sector()
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
     public function get_data_all_tipos_contacto()
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
     public function get_data_all_tipo_documentos()
    {
        $this->db->select('CodTipDoc,DesTipDoc,ObsTipDoc,case EstReq when 0 then "NO" WHEN 1 THEN "SI" end as EstReq',false);
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
     public function get_data_all_motivos_bloqueos()
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
    public function get_data_all_motivos_actividad()
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
    public function get_data_all_motivos_PunSum()
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
     public function get_data_all_motivos_Contactos()
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
    public function get_data_all_motivos_Comercializadora()
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloCom');
        $this->db->order_by('DesMotBloCom ASC');              
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
     public function get_data_all_motivos_CUPs()
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloCUPs');
        $this->db->order_by('DesMotBloCUPs ASC');              
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
     public function get_all_documentos()
    {
       $this->db->select('a.CodTipDocAI,b.NumCifCli,b.RazSocCli,,a.CodCli,c.DesTipDoc,a.CodTipDoc,a.DesDoc,a.TieVen,DATE_FORMAT(a.FecVenDoc,"%d-%m-%Y") as FecVenDoc,a.ObsDoc,CASE TieVen WHEN 1 THEN "SI" WHEN 2 THEN "NO" END AS TieVenDes',false);
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
    public function get_all_documentos_filtrado($Columna,$Variable)
    {
       $this->db->select('a.CodTipDocAI,b.NumCifCli,b.RazSocCli,,a.CodCli,c.DesTipDoc,a.CodTipDoc,a.DesDoc,a.TieVen,DATE_FORMAT(a.FecVenDoc,"%d-%m-%Y") as FecVenDoc,a.ObsDoc,CASE TieVen WHEN 1 THEN "SI" WHEN 2 THEN "NO" END AS TieVenDes',false);
       $this->db->from('T_Documentos a');
       $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
       $this->db->join('T_TipoDocumento c','a.CodTipDoc=c.CodTipDoc');
       $this->db->where($Columna,$Variable);
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
     public function get_all_cups()
    {
        $this->db->select('*',false);
        $this->db->from('V_CupsGrib');
        $this->db->order_by('CupsGas ASC');
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
    public function get_all_cups_filtro_busqueda($Where,$TipServ)
    {
        $this->db->select('*',false);
        $this->db->from('V_CupsGrib');
        $this->db->where($Where,$TipServ);
        $this->db->order_by('CupsGas ASC');
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
     public function get_all_cups_filtro_busqueda_Tar($Select,$Tabla,$Join,$ON,$Where,$Variable,$Order_BY)
    {
        $this->db->select($Select,false);
        $this->db->from($Tabla);
        $this->db->join($Join,$ON);
        $this->db->where($Where,$Variable);
        $this->db->order_by($Order_BY);
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
    public function generar_historial_consumo_cups($desde,$hasta,$CodCup,$Tabla,$Where) 
    {
        $this->db->select('*',FALSE);
        $this->db->from($Tabla);
        $this->db->where($Where,$CodCup); 
        $this->db->where('FecIniCon BETWEEN"'.$desde.'" and "'.$hasta.'"');
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
    public function sum_consumo_cups($desde,$hasta,$CodCup,$Tabla,$Where) 
    {
        $this->db->select('SUM(ConCup) AS AcumConCup',FALSE);
        $this->db->from($Tabla);
        $this->db->where($Where,$CodCup); 
        $this->db->where('FecIniCon BETWEEN"'.$desde.'" and "'.$hasta.'"');
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
     public function sum_consumo_cups2($CodCup,$Tabla,$Where) 
    {
        $this->db->select('SUM(ConCup) AS AcumConCup',FALSE);
        $this->db->from($Tabla);
        $this->db->where($Where,$CodCup); 
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
    public function get_list_consumos_cups($Select,$Tabla,$Join,$Joinb,$Join2,$Joinc,$Where,$CodCup) 
    {
        $this->db->select($Select,FALSE);
        $this->db->from($Tabla);
        $this->db->join($Join,$Joinb);
        $this->db->join($Join2,$Joinc);
        $this->db->where($Where,$CodCup);              
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
    public function get_data_CUPs_name($Select2,$Tabla2,$Join3,$JoinWhere,$Where,$CodCup) 
    {
       $this->db->select($Select2,FALSE);
        $this->db->from($Tabla2);
        $this->db->join($Join3,$JoinWhere);
        $this->db->where($Where,$CodCup);              
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
    public function generar_consumo_cups($CodPunSum,$Select,$Tabla,$Where,$CodCup) 
    {
        $this->db->select($Select,FALSE);
        $this->db->from($Tabla);
        $this->db->where($Where,$CodCup); 
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
    public function get_clientes_x_colaborador($CodCol){

        $this->db->select(  "c.CodCol,c.NomCol,c.NumIdeFis,(CASE WHEN c.TipCol =1 THEN 'Persona Física' WHEN c.TipCol = 2 THEN 'Empresa' ELSE 'Inválido' END) AS Tipo_Colaborador,
                            a.RazSocCli,a.NomComCli,a.NumCifCli,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,
                            a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,f.CodPro as CodProFis,a.CodLocFis,f.DesLoc as DesLocFis,a.TelFijCli,a.EmaCli,a.FecIniCli,
                            a.ObsCli,d.CUPsEle,d.CodTarElec,d.PotConP1,d.PotConP2,d.PotConP3,d.PotConP4,d.PotConP5,d.PotConP6,
                            d.PotMaxBie,e.CupsGas,e.CodTarGas,e.TipServ,
                            (CASE WHEN e.TipServ =2 THEN CONCAT('Gas: ',e.CupsGas) 
                            ELSE CONCAT('Eléctrico: ',d.CUPsEle) END) AS Cups,a.DireccionBBDD");
		$this->db->from('T_Cliente a');
        $this->db->join('T_Colaborador c', 'a.CodCol = c.CodCol');
        $this->db->join('T_Localidad f', 'a.CodLocFis = f.CodLoc');
        $this->db->join('T_PuntoSuministro b', 'a.CodCli = b.CodCli','left');
		$this->db->join('T_CUPsElectrico d', 'b.CodPunSum = d.CodPunSum','left');
		$this->db->join('T_CUPsGas e', 'b.CodPunSum = e.CodPunSum','left');	
		$this->db->where('c.CodCol',$CodCol);
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
    public function PropuestaComercial($CodProCom)
    {
        $this->db->select("a.RefProCom,DATE_FORMAT(a.FecProCom,'%d/%m%Y') as FecProCom,b.RazSocCli,b.NumCifCli,CONCAT(c.IniTipVia,'-',c.DesTipVia) as TipVia,b.NomViaDomSoc,b.NumViaDomSoc,b.BloDomSoc,b.EscDomSoc,b.PlaDomSoc,b.PueDomSoc,d.DesLoc,e.DesPro,b.CPLocSoc,f.CUPsEle,,CONCAT(h.IniTipVia,'-',h.DesTipVia) as TipViaPunSumEle,g.NomViaPunSum as NomViaPunSumEle,g.NumViaPunSum as NumViaPunSumEle,g.BloPunSum as BloPunSumEle,g.EscPunSum as EscPunSumEle,g.PlaPunSum as PlaPunSumEle,g.PuePunSum as PuePunSumEle,i.DesLoc as DesLocPunSumEle,j.DesPro as DesProPunSumEle,g.CPLocSoc as CPLocPunSumEle,k.NomTarEle,a.PotConP1,a.PotConP2,a.PotConP3,a.PotConP4,a.PotConP5,a.PotConP6,a.ImpAhoEle,a.PorAhoEle,(CASE WHEN a.RenConEle = 0 THEN 'NO' WHEN a.RenConEle = 1 THEN 'SI' ELSE 'N/A' END) AS RenConEle,a.ObsAhoEle,l.CupsGas,CONCAT(n.IniTipVia,'-',n.DesTipVia) as TipViaPunSumGas,m.NomViaPunSum as NomViaPunSumGas,m.NumViaPunSum as NumViaPunSumGas,m.BloPunSum as BloPunSumGas,m.EscPunSum as EscPunSumGas,m.PlaPunSum as PlaPunSumGas,m.PuePunSum as PuePunSumGas,o.DesLoc as DesLocPunSumGas,p.DesPro as DesProPunSumGas,m.CPLocSoc as CPLocPunSumGas,q.NomTarGas,a.Consumo,a.CauDia,a.ImpAhoGas,a.PorAhoGas,(CASE WHEN a.RenConGas = 0 THEN 'NO' WHEN a.RenConEle = 1 THEN 'SI' ELSE 'N/A' END) AS RenConGas,a.ObsAhoGas,a.ImpAhoTot,a.ObsProCom,CONCAT(r.RazSocCom,' - ',r.NumCifCom) as CodCom,t.DesAnePro,s.DesPro as DesProNom,(CASE WHEN a.TipPre = 0 THEN 'Fijo' WHEN a.TipPre = 1 THEN 'Indexado' WHEN a.TipPre=2 THEN 'Ambos' ELSE 'N/A' END) AS TipPre",false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Cliente b', 'a.CodCli = b.CodCli');
        $this->db->join('T_TipoVia c', 'b.CodTipViaSoc=c.CodTipVia');
        $this->db->join('T_Localidad d', 'd.CodLoc = b.CodLocSoc');
        $this->db->join('T_Provincia e', 'e.CodPro = d.CodPro');
        $this->db->join('T_CUPsElectrico f', 'f.CodCupsEle = a.CodCupsEle',"left");
        $this->db->join('T_PuntoSuministro g', 'g.CodPunSum = f.CodPunSum',"left");
        $this->db->join('T_TipoVia h', 'h.CodTipVia=g.CodTipVia',"left"); 
        $this->db->join('T_Localidad i', 'i.CodLoc = g.CodLoc',"left");
        $this->db->join('T_Provincia j', 'j.CodPro = i.CodPro',"left");
        $this->db->join('T_TarifaElectrica k', 'k.CodTarEle = a.CodTarEle',"left");
        $this->db->join('T_CUPsGas l', 'l.CodCupGas = a.CodCupsGas',"left");
        $this->db->join('T_PuntoSuministro m', 'm.CodPunSum = l.CodPunSum',"left");
        $this->db->join('T_TipoVia n', 'n.CodTipVia=m.CodTipVia',"left"); 
        $this->db->join('T_Localidad o', 'o.CodLoc = m.CodLoc',"left");
        $this->db->join('T_Provincia p', 'p.CodPro = o.CodPro',"left");
        $this->db->join('T_TarifaGas q', 'q.CodTarGas = a.CodTarGas',"left");
        $this->db->join('T_Comercializadora r', 'r.CodCom = a.CodCom');
        $this->db->join('T_Producto s', 's.CodPro = a.CodPro');
        $this->db->join('T_AnexoProducto t', 't.CodAnePro = a.CodAnePro'); 
        $this->db->where('a.CodProCom',$CodProCom);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {return $query->row();}else{return false;}  
    }
    public function get_list_contratos_comerciales_filtro($where,$Variable)
    {
        $this->db->select("a.CodConCom,a.CodProCom,b.RazSocCli,b.NumCifCli,DATE_FORMAT(a.FecConCom,'%d/%m/%Y') as FecConCom,a.DurCon,DATE_FORMAT(a.FecVenCon,'%d/%m/%Y') as FecVenCon,a.EstBajCon,
            CONCAT(d.RazSocCom,' - ', d.NumCifCom) as CodCom,e.DesAnePro as Anexo,b.CodCli,DATE_FORMAT(a.FecIniCon,'%d/%m/%Y') as FecIniCon",false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_PropuestaComercial c','c.CodProCom=a.CodProCom');
        $this->db->join('T_Comercializadora d','d.CodCom=c.CodCom');
        $this->db->join('T_AnexoProducto e','e.CodAnePro=c.CodAnePro');
        $this->db->where($where,$Variable);
        $this->db->order_by('a.FecConCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;            
    }
     public function get_list_gestiones()
    {
        $this->db->select('a.CodGesGen,a.CodCli,c.RazSocCli,c.NumCifCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,b.DesTipGes,a.PreGesGen,a.RefGesGen,a.EstGesGen',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_TipoGestion b','a.TipGesGen=b.CodTipGes');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->order_by('a.FecGesGen DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
     public function get_list_otras_gestiones_comerciales_filtro($where,$Variable)
    {
        $this->db->select('a.CodGesGen,a.CodCli,c.RazSocCli,c.NumCifCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,b.DesTipGes,a.PreGesGen,a.RefGesGen,a.EstGesGen',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_TipoGestion b','a.TipGesGen=b.CodTipGes');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->where($where,$Variable);
        $this->db->order_by('a.FecGesGen DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function get_gestionComercial($CodGesGen)
    {
        $this->db->select('a.CodGesGen,a.CodCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,a.NGesGen,a.RefGesGen,(CASE WHEN a.MecGesGen = 0 THEN "Plataforma On Line" WHEN a.MecGesGen = 1 THEN "Presencial" ELSE "N/A" END) AS MecGesGen
            ,(CASE WHEN a.EstGesGen = "P" THEN "Pendiente" WHEN a.EstGesGen = "R" THEN "Resuelto"  WHEN a.EstGesGen = "C" THEN "Cerrado" ELSE "N/A" END) AS EstGesGen,a.PreGesGen,a.CodCupsEle,a.CodCupsGas,a.DesAnaGesGen,a.ObsGesGen,a.UltTipSeg,b.RazSocCli,b.NumCifCli,c.DesTipGes',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_TipoGestion c','a.TipGesGen=c.CodTipGes');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        //$this->db->order_by('a.FecGesGen DESC');
        $this->db->where('CodGesGen',$CodGesGen); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }    
    public function getcomercializadorasearch($SearchText)
    {
        $this->db->select('a.NumCifCom,a.RazSocCom,a.NomComCom,d.DesTipVia,a.NomViaDirCom,c.DesPro,b.DesLoc,a.TelFijCom,a.EmaCom,case a.EstCom when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,a.NomConCom',FALSE);
        $this->db->from('T_Comercializadora a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        $this->db->join('T_Provincia c','b.CodPro=c.CodPro');
        $this->db->join('T_TipoVia d','d.CodTipVia=a.CodTipVia');
        $this->db->like('a.RazSocCom',$SearchText);
        $this->db->or_like('a.NomComCom',$SearchText);
        $this->db->or_like('a.NumCifCom',$SearchText);
        $this->db->or_like('a.EmaCom',$SearchText);
        $this->db->or_like('DATE_FORMAT(a.FecIniCom,"%d/%m/%Y")',$SearchText); 
        $this->db->order_by('a.RazSocCom ASC');           
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
    public function getProductossearch($SearchText)
    {
        $this->db->select('a.CodPro,b.RazSocCom,b.NumCifCom,a.DesPro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,a.ObsPro,DATE_FORMAT(a.FecIniPro,"%d/%m/%Y")as FecIniPro,case a.EstPro when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstPro,a.CodCom',FALSE);
        $this->db->from('T_Producto a');
        $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
        $this->db->like('b.RazSocCom',$SearchText);
        $this->db->or_like('b.NumCifCom',$SearchText);
        $this->db->or_like('a.DesPro',$SearchText);
        //$this->db->or_like('a.SerGas',$SearchText);
        //$this->db->or_like('a.SerEle',$SearchText);
        $this->db->or_like('DATE_FORMAT(a.FecIniPro,"%d/%m/%Y")',$SearchText);
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
     public function getAnexossearch($SearchText)
    {
        $this->db->select('a.CodAnePro,c.RazSocCom,c.NumCifCom,b.DesPro,a.DesAnePro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,case a.EstAne when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstAne,a.ObsAnePro,date_format(a.FecIniAne,"%d/%m/%Y") as FecIniAne,case a.TipPre when 0 then "FIJO" when 1 then "INDEXANDO" WHEN 2 THEN "AMBOS" end TipPre,a.DocAnePro,a.EstCom,a.CodTipCom,d.DesTipCom',FALSE);
        $this->db->from('T_AnexoProducto a');
        $this->db->join('T_Producto b','a.CodPro=b.CodPro');
        $this->db->join('T_Comercializadora c','b.CodCom=c.CodCom');
        $this->db->join('T_TipoComision d','a.CodTipCom=d.CodTipCom');
        $this->db->like('c.RazSocCom',$SearchText);
        $this->db->or_like('c.NumCifCom',$SearchText);
        $this->db->or_like('b.DesPro',$SearchText);
        $this->db->or_like('a.DesAnePro',$SearchText);
        $this->db->or_like('date_format(a.FecIniAne,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('d.DesTipCom',$SearchText);
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
    public function getServiciosEspecialessearch($SearchText)
    {
        $this->db->select('a.CodSerEsp,a.CodCom,b.RazSocCom,b.NumCifCom,a.DesSerEsp,case a.TipSumSerEsp when 0 then "GAS" when 1 then "ELÉCTRICO" WHEN 2 THEN "AMBOS" end TipSumSerEsp,a.CarSerEsp,case a.TipCli when 0 then "PARTICULAR" when 1 then "NEGOCIO" end TipCli,date_format(a.FecIniSerEsp,"%d/%m/%Y") as FecIniSerEsp,c.DesTipCom,a.CodTipCom,a.OsbSerEsp,case a.EstSerEsp when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstSerEsp',FALSE);
        $this->db->from('T_ServicioEspecial a');
        $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
        $this->db->join('T_TipoComision c','a.CodTipCom=c.CodTipCom');  
        $this->db->like('b.RazSocCom',$SearchText);
        $this->db->or_like('b.NumCifCom',$SearchText);
        $this->db->or_like('a.DesSerEsp',$SearchText);
        $this->db->or_like('date_format(a.FecIniSerEsp,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('c.DesTipCom',$SearchText);
        $this->db->order_by('a.DesSerEsp ASC');          
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