<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comercializadora_model extends CI_Model 
{

//////////////////////////////////////////////////////////////////////// COMERCIALIZADORAS START ////////////////////////////////////////////////////////////////    
    public function get_list_comercializadora()
    {
        $this->db->select('a.CodCom,a.RazSocCom,a.NomComCom,a.NumCifCom,d.DesTipVia,d.IniTipVia,a.NomViaDirCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,b.DesLoc as CodLoc,b.CPLoc,c.DesPro as ProDirCom,a.TelFijCom,a.EmaCom,a.PagWebCom,a.NomConCom,a.CarConCom,case a.SerGas when 0 then "NO" WHEN 1 THEN "SI" end as SerGas,case a.SerEle when 0 then "NO" WHEN 1 THEN "SI" end as SerEle,case a.SerEsp when 0 then "NO" WHEN 1 THEN "SI" end as SerEsp,a.DocConCom,DATE_FORMAT(a.FecConCom,"%d/%m/%Y") as FecConCom,a.DurConCom,case a.RenAutConCom when 0 then "NO" WHEN 1 THEN "SI" end as RenAutConCom,DATE_FORMAT(a.FecVenConCom,"%d/%m/%Y") as FecVenConCom,DATE_FORMAT(a.FecIniCom,"%d/%m/%Y") as FecIniCom,a.ObsCom,case a.EstCom when 1 then "ACTIVA" WHEN 2 THEN "BLOQUEADA" end as EstCom',false);
        $this->db->from('T_Comercializadora a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        $this->db->join('T_Provincia c','c.CodPro=b.CodPro');
         $this->db->join('T_TipoVia d','a.CodTipVia=d.CodTipVia');
        $this->db->order_by('a.NomComCom DESC');
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
     public function get_list_localidad()
    {
        $this->db->select('a.CodLoc,b.DesPro,a.DesLoc,a.CPLoc,a.CodPro');
        $this->db->from('T_Localidad a');
        $this->db->join('T_Provincia b','a.CodPro=b.CodPro');
        $this->db->order_by('b.DesPro,a.DesLoc ASC');
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
        $this->db->order_by('DesTipVia DESC');              
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
    public function get_list_ComAct()
    {
        $this->db->select('*');
        $this->db->from('T_Comercializadora');
        $this->db->where('EstCom=1');
        $this->db->order_by('RazSocCom ASC');
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
      public function get_list_ProAct()
    {
        $this->db->select('*');
        $this->db->from('T_Producto');
        $this->db->where('EstPro=1');
        $this->db->order_by('DesPro ASC');
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
     public function get_list_TipCom()
    {
        $this->db->select('*');
        $this->db->from('T_TipoComision');
        $this->db->order_by('DesTipCom ASC');
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
         /////PARA LAS TARIFAS GAS START////   
    public function get_list_tarifa_Gas()
    {
        $this->db->select('*');
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
     public function list_tarifa_electricas()
    {
        $this->db->select('CodTarEle,case TipTen WHEN 0 THEN "BAJA" WHEN 1 THEN "ALTA" END as TipTen,NomTarEle,CanPerTar,MinPotCon,MaxPotCon ',FALSE);
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
    public function get_CodCom($CodCom)
    {
        $this->db->select('a.CodCom,a.RazSocCom,a.NomComCom,a.NumCifCom,a.CodTipVia,a.NomViaDirCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,b.CodPro,a.CodLoc,,DATE_FORMAT(a.FecIniCom,"%d/%m/%Y") as FecIniCom,a.TelFijCom,a.EmaCom,a.PagWebCom,a.NomConCom,a.CarConCom,a.SerGas,a.SerEle,a.SerEsp,a.DocConCom,DATE_FORMAT(a.FecConCom,"%d/%m/%Y") as FecConCom,a.DurConCom,a.RenAutConCom,,DATE_FORMAT(a.FecVenConCom,"%d/%m/%Y") as FecVenConCom,a.ObsCom,a.CPLoc as ZonPos',false);
        $this->db->from('T_Comercializadora a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');
        $this->db->join('T_Provincia c','c.CodPro=b.CodPro');
         $this->db->join('T_TipoVia d','a.CodTipVia=d.CodTipVia');
        $this->db->where('a.CodCom',$CodCom);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return  $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function actualizar_comercializadora($CodCom,$BloDirCom,$CarConCom,$CodLoc,$CodTipVia,$DurConCom,$EmaCom,$EscDirCom,$FecConCom,$FecVenConCom,$NomComCom,$NomConCom,$NomViaDirCom,$NumCifCom,$NumViaDirCom,$ObsCom,$PagWebCom,$PlaDirCom,$PueDirCom,$RazSocCom,$RenAutConCom,$SerEle,$SerEsp,$SerGas,$TelFijCom,$DocConCom,$fecha,$ZonPos)
    {   
        $this->db->where('CodCom', $CodCom);        
        return $this->db->update('T_Comercializadora',array('BloDirCom'=>$BloDirCom,'CarConCom'=>$CarConCom,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'DurConCom'=>$DurConCom,'EmaCom'=>$EmaCom,'EscDirCom'=>$EscDirCom,'FecConCom'=>$FecConCom,'FecVenConCom'=>$FecVenConCom,'NomComCom'=>$NomComCom,'NomConCom'=>$NomConCom,'NomViaDirCom'=>$NomViaDirCom,'NumViaDirCom'=>$NumViaDirCom,'ObsCom'=>$ObsCom,'PagWebCom'=>$PagWebCom,'PlaDirCom'=>$PlaDirCom,'PueDirCom'=>$PueDirCom,'RazSocCom'=>$RazSocCom,'RenAutConCom'=>$RenAutConCom,'SerEle'=>$SerEle,'SerEsp'=>$SerEsp,'SerGas'=>$SerGas,'TelFijCom'=>$TelFijCom,'DocConCom'=>$DocConCom,'FecIniCom'=>$fecha,'CPLoc'=>$ZonPos));
    }
    public function agregar_comercializadora($BloDirCom,$CarConCom,$CodLoc,$CodTipVia,$DurConCom,$EmaCom,$EscDirCom,$FecConCom,$FecVenConCom,$NomComCom,$NomConCom,$NomViaDirCom,$NumCifCom,$NumViaDirCom,$ObsCom,$PagWebCom,$PlaDirCom,$PueDirCom,$RazSocCom,$RenAutConCom,$SerEle,$SerEsp,$SerGas,$TelFijCom,$fecha,$DocConCom,$ZonPos)
    {
        $this->db->insert('T_Comercializadora',array('BloDirCom'=>$BloDirCom,'CarConCom'=>$CarConCom,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'DurConCom'=>$DurConCom,'EmaCom'=>$EmaCom,'EscDirCom'=>$EscDirCom,'FecConCom'=>$FecConCom,'FecVenConCom'=>$FecVenConCom,'NomComCom'=>$NomComCom,'NomConCom'=>$NomConCom,'NomViaDirCom'=>$NomViaDirCom,'NumCifCom'=>$NumCifCom,'NumViaDirCom'=>$NumViaDirCom,'ObsCom'=>$ObsCom,'PagWebCom'=>$PagWebCom,'PlaDirCom'=>$PlaDirCom,'PueDirCom'=>$PueDirCom,'RazSocCom'=>$RazSocCom,'RenAutConCom'=>$RenAutConCom,'SerEle'=>$SerEle,'SerEsp'=>$SerEsp,'SerGas'=>$SerGas,'TelFijCom'=>$TelFijCom,'FecIniCom'=>$fecha,'DocConCom'=>$DocConCom,'CPLoc'=>$ZonPos));
        return $this->db->insert_id();
    }
      public function consultar_cif_comercializadora($NumCifCom)
    {
        $this->db->select('NumCifCom');
        $this->db->from('T_Comercializadora');  
        $this->db->where('NumCifCom',$NumCifCom);          
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }       
    }
     public function get_list_MotBloCom()
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloCom');
        $this->db->order_by('DesMotBloCom  ASC');
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
     public function update_status_comercializadora($CodCom,$EstCom)
    {   
        $this->db->where('CodCom', $CodCom);        
        return $this->db->update('T_Comercializadora',array('EstCom'=>$EstCom));
    }
      public function delete_comercializadora($CodCom)
    { 
        return $this->db->delete('T_Comercializadora', array('CodCom' => $CodCom));
    }
     public function agregar_bloqueo_Com($CodCom,$fecha,$MotBloq,$ObsBloCom)
    {
        $this->db->insert('T_BloqueoComercializadora',array('CodCom'=>$CodCom,'FecBloCom'=>$fecha,'CodMotBloCom'=>$MotBloq,'ObsBloCom'=>$ObsBloCom));
        return $this->db->insert_id();
    }
//////////////////////////////////////////////////////////////////////// COMERCIALIZADORAS END ////////////////////////////////////////////////////////////////    
 


///////////////////////////////////////////PARA LOS PRODUCTOS START////////////////////////////////////////////////////////////////////////////////////

public function get_list_productos()
{
    $this->db->select('a.CodPro,b.RazSocCom,b.NumCifCom,a.DesPro,case a.SerGas when 0 then "NO" when 1 then "SI" end SerGas,case a.SerEle when 0 then "NO" when 1 then "SI" end SerEle,a.ObsPro,DATE_FORMAT(a.FecIniPro,"%d/%m/%Y")as FecIniPro,case a.EstPro when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstPro,a.CodCom',FALSE);
    $this->db->from('T_Producto a');
    $this->db->join('T_Comercializadora b','a.CodCom=b.CodCom');
   // $this->db->where('CodCom',$CodCom);
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
    public function actualizar_productos($CodTPro,$CodTProCom,$DesPro,$CodTProCom,$SerGas,$SerEle,$ObsPro,$FecIniPro)
    {   
        $this->db->where('CodPro', $CodTPro);        
        return $this->db->update('T_Producto',array('CodCom'=>$CodTProCom,'DesPro'=>$DesPro,'SerGas'=>$SerGas,'SerEle'=>$SerEle,'ObsPro'=>$ObsPro,'FecIniPro'=>$FecIniPro));
    }
    public function agregar_productos($CodTProCom,$DesPro,$CodTProCom,$SerGas,$SerEle,$ObsPro,$FecIniPro)
    {
        $this->db->insert('T_Producto',array('CodCom'=>$CodTProCom,'DesPro'=>$DesPro,'SerGas'=>$SerGas,'SerEle'=>$SerEle,'ObsPro'=>$ObsPro,'FecIniPro'=>$FecIniPro));
        return $this->db->insert_id();
    }
     public function update_status_productos($CodPro,$EstPro)
    {   
        $this->db->where('CodPro', $CodPro);        
        return $this->db->update('T_Producto',array('EstPro'=>$EstPro));
    }
    public function agregar_bloqueo_productos($CodPro,$fecha,$MotBloPro,$ObsBloPro)
    {
        $this->db->insert('T_BloqueoProducto',array('CodPro'=>$CodPro,'MotBloPro'=>$MotBloPro,'FecBlo'=>$fecha,'ObsMotBlo'=>$ObsBloPro));
        return $this->db->insert_id();
    }
    public function get_all_data_productos($CodPro)
    {
        $this->db->select('CodPro,CodCom,DesPro,SerGas,SerEle,ObsPro,DATE_FORMAT(FecIniPro,"%d/%m/%Y") as FecIniPro,EstPro');
        $this->db->from('T_Producto');
        $this->db->where('CodPro',$CodPro);
        //$this->db->order_by('DesPro ASC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return  $query->row();
        }
        else
        {
            return false;
        }       
    }
///////////////////////////////////////////PARA LOS PRODUCTOS END /////////////////////////////////////////////////////

///////////////////////////////////////////PARA LOS ANEXOS START///////////////////////////////////////////////////////

    public function get_list_anexos()
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
    public function agregar_anexos($CodPro,$DesAnePro,$SerGas,$SerEle,$DocAnePro,$ObsAnePro,$FecIniAne,$CodTipCom,$EstCom,$EstAne,$TipPre)
    {
        $this->db->insert('T_AnexoProducto',array('CodPro'=>$CodPro,'DesAnePro'=>$DesAnePro,'SerGas'=>$SerGas,'SerEle'=>$SerEle,'DocAnePro'=>$DocAnePro,'ObsAnePro'=>$ObsAnePro,'FecIniAne'=>$FecIniAne,'CodTipCom'=>$CodTipCom,'EstCom'=>$EstCom,'EstAne'=>$EstAne,'TipPre'=>$TipPre));
        return $this->db->insert_id();
    }
    public function actualizar_anexos($CodAnePro,$CodPro,$DesAnePro,$SerGas,$SerEle,$DocAnePro,$ObsAnePro,$CodTipCom,$EstCom,$TipPre,$FecIniAne)
    {   
        $this->db->where('CodAnePro', $CodAnePro);        
        return $this->db->update('T_AnexoProducto',array('CodPro'=>$CodPro,'DesAnePro'=>$DesAnePro,'SerGas'=>$SerGas,'SerEle'=>$SerEle,'DocAnePro'=>$DocAnePro,'ObsAnePro'=>$ObsAnePro,'CodTipCom'=>$CodTipCom,'EstCom'=>$EstCom,'TipPre'=>$TipPre,'FecIniAne'=>$FecIniAne));
    }
    public function agregar_detalle_tarifa_gas($CodAnePro,$CodTarGas)
    {
        $this->db->insert('T_DetalleAnexoTarifaGas',array('CodAnePro'=>$CodAnePro,'CodTarGas'=>$CodTarGas));
        return $this->db->insert_id();
    }
    public function agregar_detalle_tarifa_Elec_Baja($CodAnePro,$CodTarEle)
    {
        $this->db->insert('T_DetalleAnexoTarifaElectrica',array('CodAnePro'=>$CodAnePro,'CodTarEle'=>$CodTarEle));
        return $this->db->insert_id();
    }
    public function agregar_detalle_tarifa_Elec_Alta($CodAnePro,$CodTarEle)
    {
        $this->db->insert('T_DetalleAnexoTarifaElectrica',array('CodAnePro'=>$CodAnePro,'CodTarEle'=>$CodTarEle));
        return $this->db->insert_id();
    }
      public function eliminar_detalles_anexos($CodAnePro)
    {           
               $this->db->delete('T_DetalleAnexoTarifaGas', array('CodAnePro' => $CodAnePro));  
        return $this->db->delete('T_DetalleAnexoTarifaElectrica', array('CodAnePro' => $CodAnePro));
    }
    public function get_anexos_data($CodAnePro)
    {
        $this->db->select('a.CodAnePro,a.CodPro,b.CodCom,a.DesAnePro,a.SerGas,a.SerEle,a.DocAnePro,a.ObsAnePro,DATE_FORMAT(a.FecIniAne,"%d/%m/%Y") as FecIniAne,a.CodTipCom,a.EstCom,a.EstAne,a.TipPre');
        $this->db->from('T_AnexoProducto a');
        $this->db->join('T_Producto b','a.CodPro=b.CodPro');   
        $this->db->where('a.CodAnePro',$CodAnePro);          
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
    public function get_select_data_tarifa_elec($CodAnePro)
    {
        $this->db->select('*');
        $this->db->from('T_DetalleAnexoTarifaElectrica');  
        $this->db->where('CodAnePro',$CodAnePro);          
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
     public function get_detalle_tarifa_gas($CodAnePro)
    {
        $this->db->select('CodTarGas');
        $this->db->from('T_DetalleAnexoTarifaGas');  
        $this->db->where('CodAnePro',$CodAnePro);          
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
   
     public function get_select_data_tarifa_elec_detalle($CodTarEle)
    {
       
        $this->db->select('*');
        $this->db->from('T_TarifaElectrica');  
        $this->db->where('CodTarEle',$CodTarEle);   
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
    public function obtener_detalle_tarifa_electrica($CodAnePro)
    {
        $this->db->select('a.CodTarEle,b.TipTen');
        $this->db->from('T_DetalleAnexoTarifaElectrica a');
        $this->db->join('T_TarifaElectrica b','a.CodTarEle=b.CodTarEle'); 
        $this->db->where('a.CodAnePro',$CodAnePro);          
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
    public function update_status_anexos($CodAnePro,$EstAne)
    {   
        $this->db->where('CodAnePro', $CodAnePro);        
        return $this->db->update('T_AnexoProducto',array('EstAne'=>$EstAne));
    }
     public function agregar_bloqueo_anexos($CodAnePro,$FecBloAne,$MotBloAne,$ObsMotBloAne)
    {
        $this->db->insert('T_BloqueoAnexo',array('CodAnePro'=>$CodAnePro,'MotBloAne'=>$MotBloAne,'FecBloAne'=>$FecBloAne,'ObsMotBloAne'=>$ObsMotBloAne));
        return $this->db->insert_id();
    }
    
    public function get_detalle_anexo($CodAnePro)
    {
        $this->db->select('*');
        $this->db->from('V_DetAneTar');
        $this->db->where('CodAnePro',$CodAnePro);          
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
    public function agregar_comisiones_anexos($CodDetAneTarEle,$CodAnePro,$RanConsu,$ConMinAn,$ConMaxAn,$ConServ,$ConCerVer)
    {
       $this->db->insert('T_DetalleComisionesAnexos',array('CodAnePro'=>$CodAnePro,'CodDetAne'=>$CodDetAneTarEle,'RanCon'=>$RanConsu,'ConMinAnu'=>$ConMinAn,'ConMaxAnu'=>$ConMaxAn,'ConSer'=>$ConServ,'ConCerVer'=>$ConCerVer));
        return $this->db->insert_id();   
    }
    public function get_detalle_comisiones_anexos($CodAnePro)
    {
        $this->db->select('*');
        $this->db->from('T_DetalleComisionesAnexos');
        $this->db->where('CodAnePro',$CodAnePro);          
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
    public function eliminar_detalles_comisiones_anexos($CodAnePro)
    {
        return $this->db->delete('T_DetalleComisionesAnexos', array('CodAnePro' => $CodAnePro));
    }
///////////////////////////////////////////PARA LOS ANEXOS END////////////////////////////////////////////////////////////////////////////////////





///////////////////////////////////////////PARA LOS SERVICIOS ESPECIALES START ////////////////////////////////////////////////////////////////////


    public function get_list_servicos_especiales()
    {
        $this->db->select('a.CodSerEsp,a.CodCom,b.RazSocCom,b.NumCifCom,a.DesSerEsp,case a.TipSumSerEsp when 0 then "SI" when 1 then "NO" WHEN 2 THEN "SI" end SerEle,
case a.TipSumSerEsp when 1 then "SI" when 0 then "NO" WHEN 2 THEN "SI" end SerGas,a.CarSerEsp,case a.TipCli when 0 then "PARTICULAR" when 1 then "NEGOCIO" end TipCli,date_format(a.FecIniSerEsp,"%d/%m/%Y") as FecIniSerEsp,c.DesTipCom,a.CodTipCom,a.OsbSerEsp,case a.EstSerEsp when 1 then "ACTIVO" when 2 then "BLOQUEADO" end EstSerEsp',FALSE);
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
    public function agregar_servicio_especial($CodCom,$DesSerEsp,$FecIniSerEsp,$TipSumSerEsp,$TipCli,$CarSerEsp,$CodTipCom,$OsbSerEsp)
    {
        $this->db->insert('T_ServicioEspecial',array('CodCom'=>$CodCom,'DesSerEsp'=>$DesSerEsp,'TipSumSerEsp'=>$TipSumSerEsp,'CarSerEsp'=>$CarSerEsp,'TipCli'=>$TipCli,
            'FecIniSerEsp'=>$FecIniSerEsp,'CodTipCom'=>$CodTipCom,'OsbSerEsp'=>$OsbSerEsp));
        return $this->db->insert_id();
    }
    public function actualizar_servicio_especial($CodSerEsp,$CodCom,$DesSerEsp,$TipSumSerEsp,$TipCli,$CarSerEsp,$CodTipCom,$OsbSerEsp,$FecIniSerEsp)
    {   
        $this->db->where('CodSerEsp', $CodSerEsp);        
        return $this->db->update('T_ServicioEspecial',array('CodCom'=>$CodCom,'DesSerEsp'=>$DesSerEsp,'TipSumSerEsp'=>$TipSumSerEsp,'CarSerEsp'=>$CarSerEsp,'TipCli'=>$TipCli,'CodTipCom'=>$CodTipCom,'OsbSerEsp'=>$OsbSerEsp,'FecIniSerEsp'=>$FecIniSerEsp));
    }

    public function agregar_detalle_tarifa_Elec_Baja_SerEsp($CodSerEsp,$CodTarEle)
    {
        $this->db->insert('T_DetalleServicioTarifaElectrica',array('CodSerEsp'=>$CodSerEsp,'CodTarEle'=>$CodTarEle));
        return $this->db->insert_id();
    }
    public function agregar_detalle_tarifa_Elec_Alta_SerEsp($CodSerEsp,$CodTarEle)
    {
        $this->db->insert('T_DetalleServicioTarifaElectrica',array('CodSerEsp'=>$CodSerEsp,'CodTarEle'=>$CodTarEle));
        return $this->db->insert_id();
    }
     public function agregar_detalle_tarifa_gas_SerEsp($CodSerEsp,$CodTarGas)
    {
        $this->db->insert('T_DetalleServicioTarifaGas',array('CodSerEsp'=>$CodSerEsp,'CodTarGas'=>$CodTarGas));
        return $this->db->insert_id();
    }
      public function eliminar_detalles_servicios_especiales($CodSerEsp)
    {           
               $this->db->delete('T_DetalleServicioTarifaGas', array('CodSerEsp' => $CodSerEsp));  
        return $this->db->delete('T_DetalleServicioTarifaElectrica', array('CodSerEsp' => $CodSerEsp));
    }

     public function get_servicio_especial_data($CodSerEsp)
    {
        $this->db->select('CodSerEsp,CodCom,DesSerEsp,case TipSumSerEsp when 0 then "SI" when 1 then "NO" WHEN 2 THEN "SI" end SerEle,case TipSumSerEsp when 1 then "SI" when 0 then "NO" WHEN 2 THEN "SI" end SerGas,CarSerEsp,TipCli,DATE_FORMAT(FecIniSerEsp,"%d/%m/%Y") as FecIniSerEsp,CodTipCom,OsbSerEsp,EstSerEsp',FALSE);
        $this->db->from('T_ServicioEspecial');
        $this->db->where('CodSerEsp',$CodSerEsp);          
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

     public function get_detalle_tarifa_gas_SerEsp($CodSerEsp)
    {
        $this->db->select('*');
        $this->db->from('T_DetalleServicioTarifaGas');  
        $this->db->where('CodSerEsp',$CodSerEsp);          
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
    public function obtener_detalle_tarifa_electrica_SerEsp($CodSerEsp)
    {
        $this->db->select('a.CodTarEle,b.TipTen');
        $this->db->from('T_DetalleServicioTarifaElectrica a');
        $this->db->join('T_TarifaElectrica b','a.CodTarEle=b.CodTarEle'); 
        $this->db->where('a.CodSerEsp',$CodSerEsp);          
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
    public function update_status_servicio_especial($CodSerEsp,$EstSerEsp)
    {   
        $this->db->where('CodSerEsp', $CodSerEsp);        
        return $this->db->update('T_ServicioEspecial',array('EstSerEsp'=>$EstSerEsp));
    }
     public function agregar_bloqueo_servicio_especial($CodSerEsp,$FecBloSerEsp,$MotBloSerEsp,$ObsMotBloSerEsp)
    {
        $this->db->insert('T_BloqueoServicioEspecial',array('CodSerEsp'=>$CodSerEsp,'MotBloSerEsp'=>$MotBloSerEsp,'FecBloSerEsp'=>$FecBloSerEsp,'ObsMotBloSerEsp'=>$ObsMotBloSerEsp));
        return $this->db->insert_id();
    }
    public function get_detalle_servicio_especial($CodSerEsp)
    {
        $this->db->select('*');
        $this->db->from('V_DetSerEsp');
        $this->db->where('CodSerEsp',$CodSerEsp);          
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
    public function get_detalle_comisiones_especiales($CodSerEsp)
    {
        $this->db->select('*');
        $this->db->from('T_DetalleComisionesServiciosEspeciales');
        $this->db->where('CodSerEsp',$CodSerEsp);          
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
     public function eliminar_detalles_comisiones_servicios_especial($CodSerEsp)
    {
        return $this->db->delete('T_DetalleComisionesServiciosEspeciales', array('CodSerEsp' => $CodSerEsp));
    }
     public function agregar_comisiones_servicios_especial($CodDetSer,$CodSerEsp,$RanCon,$ConMinAnu,$ConMaxAnu,$ConSer,$ConCerVer)
    {
       $this->db->insert('T_DetalleComisionesServiciosEspeciales',array('CodSerEsp'=>$CodSerEsp,'CodDetSerEsp'=>$CodDetSer,'RanCon'=>$RanCon,'ConMinAnu'=>$ConMinAnu,'ConMaxAnu'=>$ConMaxAnu,'ConSer'=>$ConSer,'ConCerVer'=>$ConCerVer));
        return $this->db->insert_id();   
    }




///////////////////////////////////////////PARA LOS SERVICIOS ESPECIALES END ////////////////////////////////////////////////




}