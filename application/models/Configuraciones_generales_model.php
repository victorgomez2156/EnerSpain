<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Configuraciones_generales_model extends CI_Model 
{
    /////PARA LAS PROVINCIAS START////   
    public function get_list_provincias()
    {
        $this->db->select('*');
        $this->db->from('T_Provincia'); 
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
    public function agregar($DesPro)
    {
        $this->db->insert('T_Provincia',array('DesPro'=>$DesPro));
        return $this->db->insert_id();
    }
    public function actualizar($CodPro,$DesPro)
    {    
        $this->db->where('CodPro', $CodPro);        
        return $this->db->update('T_Provincia',array('DesPro'=>$DesPro));
    }
     public function get_provincia_data($CodPro)
    {
        $this->db->select('*');
        $this->db->from('T_Provincia');  
        $this->db->where('CodPro',$CodPro);     
        $this->db->order_by('DesPro DESC');              
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
     public function borrar_provincia_data($CodPro)
    { 
        return $this->db->delete('T_Provincia', array('CodPro' => $CodPro));
    }
    /////PARA LAS PROVINCIAS END////

    /////PARA LAS LOCALIDADES START////
     public function get_localidad_data($CodLoc)
    {
        $this->db->select('*');
        $this->db->from('T_Localidad');  
        $this->db->where('CodLoc',$CodLoc);     
        $this->db->order_by('DesLoc DESC');              
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
        $this->db->select('a.CodLoc,a.DesLoc,b.CodPro,b.DesPro,a.CPLoc');
        $this->db->from('T_Localidad a');
        $this->db->join('T_Provincia b','a.CodPro=b.CodPro');
        $this->db->order_by('a.DesLoc ASC');              
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
    public function agregar_localidad($CodPro,$DesLoc,$CPLoc)
    {
        $this->db->insert('T_Localidad',array('CodPro'=>$CodPro,'DesLoc'=>$DesLoc,'CPLoc'=>$CPLoc));
        return $this->db->insert_id();
    }
    public function actualizar_localidad($CodLoc,$CodPro,$DesLoc,$CPLoc)
    {   
        $this->db->where('CodLoc', $CodLoc);        
        return $this->db->update('T_Localidad',array('CodPro'=>$CodPro,'DesLoc'=>$DesLoc,'CPLoc'=>$CPLoc));
    }
     public function borrar_localidad_data($CodLoc)
    { 
        return $this->db->delete('T_Localidad', array('CodLoc' => $CodLoc));
    }
    /////PARA LAS LOCALIDADES END////

     /////PARA LAS TARIFAS ELECTRICAS START////   
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
    public function borrar_tarifa_electrica($CodTarEle)
    { 
        return $this->db->delete('T_TarifaElectrica', array('CodTarEle' => $CodTarEle));
    }
    public function agregar_tarifa_electrica($TipTen,$NomTarEle,$CanPerTar,$MinPotCon,$MaxPotCon)
    {
        $this->db->insert('T_TarifaElectrica',array('TipTen'=>$TipTen,'NomTarEle'=>$NomTarEle,'CanPerTar'=>$CanPerTar,'MinPotCon'=>$MinPotCon,'MaxPotCon'=>$MaxPotCon));
        return $this->db->insert_id();
    }
    public function actualizar_tarifa_electrica($CodTarEle,$TipTen,$NomTarEle,$CanPerTar,$MinPotCon,$MaxPotCon)
    {   
        $this->db->where('CodTarEle', $CodTarEle);        
        return $this->db->update('T_TarifaElectrica',array('TipTen'=>$TipTen,'NomTarEle'=>$NomTarEle,'CanPerTar'=>$CanPerTar,'MinPotCon'=>$MinPotCon,'MaxPotCon'=>$MaxPotCon));
    }
     public function get_tarifa_electrica($CodTarEle)
    {
        $this->db->select('*');
        $this->db->from('T_TarifaElectrica');  
        $this->db->where('CodTarEle',$CodTarEle);            
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
     
    /////PARA LAS TARIFAS ELECTRICAS END////


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
    public function borrar_tarifa_gas($CodTarGas)
    { 
        return $this->db->delete('T_TarifaGas', array('CodTarGas' => $CodTarGas));
    }
     public function get_tarifa_gas($CodTarGas)
    {
        $this->db->select('*');
        $this->db->from('T_TarifaGas');  
        $this->db->where('CodTarGas',$CodTarGas);            
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
    public function agregar_tarifa_gas($NomTarGas,$MinConAnu,$MaxConAnu)
    {
        $this->db->insert('T_TarifaGas',array('NomTarGas'=>$NomTarGas,'MinConAnu'=>$MinConAnu,'MaxConAnu'=>$MaxConAnu));
        return $this->db->insert_id();
    }
    public function actualizar_tarifa_gas($CodTarGas,$NomTarGas,$MinConAnu,$MaxConAnu)
    {   
        $this->db->where('CodTarGas', $CodTarGas);        
        return $this->db->update('T_TarifaGas',array('NomTarGas'=>$NomTarGas,'MinConAnu'=>$MinConAnu,'MaxConAnu'=>$MaxConAnu));
    } 
    /////PARA LAS TARIFAS GAS END////

          /////PARA  LOS TIPOS DE COMISIONES START////   
    public function get_list_Tipo_Comision()
    {
        $this->db->select('*');
        $this->db->from('T_TipoComision');
        $this->db->order_by('DesTipCom ASC');
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
    public function get_tipo_comision($CodTipCom)
    {
        $this->db->select('*');
        $this->db->from('T_TipoComision');  
        $this->db->where('CodTipCom',$CodTipCom);            
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
   public function borrar_tipo_comision($CodTipCom)
    { 
        return $this->db->delete('T_TipoComision', array('CodTipCom' => $CodTipCom));
    }     
    public function agregar_tipo_comision($DesTipCom)
    {
        $this->db->insert('T_TipoComision',array('DesTipCom'=>$DesTipCom));
        return $this->db->insert_id();
    }
    public function actualizar_tipo_comision($CodTipCom,$DesTipCom)
    {   
        $this->db->where('CodTipCom', $CodTipCom);        
        return $this->db->update('T_TipoComision',array('DesTipCom'=>$DesTipCom));
    } 
    /////PARA LOS TIPOS DE COMISIONES END////

    /////PARA COMERCIALES START////
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
    public function get_comercial_data($CodCom)
    {
        $this->db->select('*');
        $this->db->from('T_Comercial');  
        $this->db->where('CodCom',$CodCom);     
        $this->db->order_by('NomCom DESC');              
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
    public function agregar_comercial($NomCom,$NIFCom,$TelCelCom,$TelFijCom,$EmaCom,$CarCom,$PorComCom,$ObsCom)
    {
        $this->db->insert('T_Comercial',array('NomCom'=>$NomCom,'NIFCom'=>$NIFCom,'TelCelCom'=>$TelCelCom,'TelFijCom'=>$TelFijCom,'EmaCom'=>$EmaCom,'CarCom'=>$CarCom,'FecIniCom'=>date('Y-m-d'),'PorComCom'=>$PorComCom,'ObsCom'=>$ObsCom));
        return $this->db->insert_id();
    }
    public function actualizar_comercial($CodCom,$NomCom,$NIFCom,$TelCelCom,$TelFijCom,$EmaCom,$CarCom,$PorComCom,$ObsCom)
    {   
        $this->db->where('CodCom', $CodCom);        
        return $this->db->update('T_Comercial',array('NomCom'=>$NomCom,'NIFCom'=>$NIFCom,'TelCelCom'=>$TelCelCom,'TelFijCom'=>$TelFijCom,'EmaCom'=>$EmaCom,'CarCom'=>$CarCom,'PorComCom'=>$PorComCom,'ObsCom'=>$ObsCom));
    }
     public function borrar_comercial_data($CodCom)
    { 
        return $this->db->delete('T_Comercial', array('CodCom' => $CodCom));
    }
    /////PARA COMERCIALES END////

    ///PARA TIPO CLIENTES START////
     public function get_list_tipo_clientes()
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
    public function get_tipo_cliente_data($CodTipCli)
    {
        $this->db->select('*');
        $this->db->from('T_TipoCliente');  
        $this->db->where('CodTipCli',$CodTipCli);     
        $this->db->order_by('DesTipCli DESC');              
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
     public function agregar_tipo_cliente($DesTipCli)
    {
        $this->db->insert('T_TipoCliente',array('DesTipCli'=>$DesTipCli));
        return $this->db->insert_id();
    }
    public function actualizar_tipo_cliente($CodTipCli,$DesTipCli)
    {   
        $this->db->where('CodTipCli', $CodTipCli);        
        return $this->db->update('T_TipoCliente',array('DesTipCli'=>$DesTipCli));
    }
     public function borrar_tipo_cliente_data($CodTipCli)
    { 
        return $this->db->delete('T_TipoCliente', array('CodTipCli' => $CodTipCli));
    }



    /// PARA TIPO CLIENTES END////

        /// PARA CONFIGURACIONES DEL SISTEMA END////


     public function get_configuracion_sistema()
    {
        $this->db->select('id,nombre_sistema,logo,telefono,direccion,version_sistema,correo_principal,correo_cc,url,protocol,smtp_host,smtp_user,smtp_pass,smtp_port,fecha_registro,DATE_FORMAT(fecha_ultima_actualizacion, "%d/%m/%Y" " %H:%i:%s") as fecha_ultima_actualizacion');
        $this->db->from('T_ConfiguracionesSistema');                      
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
    public function actualizar_configuracion_sistema($id,$nombre_sistema,$logo,$telefono,$direccion,$version_sistema,$correo_principal,$correo_cc,$url,$protocol,$smtp_host,$smtp_user,$smtp_pass,$smtp_port)
    {   
        $this->db->where('id', $id);        
        return $this->db->update('T_ConfiguracionesSistema',array('nombre_sistema'=>$nombre_sistema,'logo'=>$logo,'telefono'=>$telefono,'direccion'=>$direccion,'version_sistema'=>$version_sistema,'correo_principal'=>$correo_principal,'correo_cc'=>$correo_cc,'url'=>$url,'protocol'=>$protocol,'smtp_host'=>$smtp_host,'smtp_user'=>$smtp_user,'smtp_pass'=>$smtp_pass,'smtp_port'=>$smtp_port,'fecha_ultima_actualizacion'=>date('Y-m-d G:i:s')));
    }

    /// PARA CONFIGURACIONES DEL SISTEMA END////


     ///PARA LOS BANCOS START////
     public function get_list_bancos()
    {
        $this->db->select('*');
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
    public function borrar_bancos($CodBan)
    { 
        return $this->db->delete('T_Banco', array('CodBan' => $CodBan));
    }
    public function get_banco_data($CodBan)
    {
        $this->db->select('*');
        $this->db->from('T_Banco');  
        $this->db->where('CodBan',$CodBan);     
        $this->db->order_by('DesBan ASC');              
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
    public function actualizar_banco($CodBan,$CodEur,$DesBan)
    {   
        $this->db->where('CodBan', $CodBan);        
        return $this->db->update('T_Banco',array('CodEur'=>$CodEur,'DesBan'=>$DesBan));
    }
    public function agregar_banco($CodEur,$DesTipCli)
    {
        $this->db->insert('T_Banco',array('CodEur'=>$CodEur,'DesBan'=>$DesBan));
        return $this->db->insert_id();
    }
    

    /// PARA LOS BANCOS END////

    /// PARA LOS TIPOS DE VIAS START////
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
     public function borrar_tipos_vias($hvia)
    { 
        return $this->db->delete('T_TipoVia', array('CodTipVia' => $hvia));
    }
     public function get_tipo_via_data($CodTipVia)
    {
        $this->db->select('*');
        $this->db->from('T_TipoVia');  
        $this->db->where('CodTipVia',$CodTipVia);
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
     public function actualizar_tipo_vias($CodTipVia,$DesTipVia,$IniTipVia)
    {   
        $this->db->where('CodTipVia', $CodTipVia);        
        return $this->db->update('T_TipoVia',array('DesTipVia'=>$DesTipVia,'IniTipVia'=>$IniTipVia));
    }
    public function agregar_tipo_vias($DesTipVia,$IniTipVia)
    {
        $this->db->insert('T_TipoVia',array('DesTipVia'=>$DesTipVia,'IniTipVia'=>$IniTipVia));
        return $this->db->insert_id();
    }

    /// PARA LOS TIPOS DE VIAS END////

     /// PARA LOS MOTIVOS DE BLOQUEOS START////

     public function get_list_Motivos_Bloqueos()
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
    public function borrar_tMotivos_Bloqueos($CodMotBloCli)
    { 
        return $this->db->delete('T_MotivoBloCli', array('CodMotBloCli' => $CodMotBloCli));
    }
    public function get_tipo_tMotivo_Bloqueo($CodMotBloCli)
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloCli');  
        $this->db->where('CodMotBloCli',$CodMotBloCli);
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
     public function actualizar_motivo_bloqueo($CodMotBloCli,$DesMotBloCli)
    {   
        $this->db->where('CodMotBloCli', $CodMotBloCli);        
        return $this->db->update('T_MotivoBloCli',array('DesMotBloCli'=>$DesMotBloCli));
    }
    public function agregar_motivo_bloqueo($DesMotBloCli)
    {
        $this->db->insert('T_MotivoBloCli',array('DesMotBloCli'=>$DesMotBloCli));
        return $this->db->insert_id();
    }

     /// PARA LOS MOTIVOS DE BLOQUEOS END////


    /////PARA LOS MOTIVOS DE BLOQUEOS DE ACTIVIDADES START////   
    public function list_tMotivos_Bloqueos_Actividades()
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
     public function actualizar_motivo_bloqueo_actividades($CodMotBloAct,$DesMotBloAct)
    {   
        $this->db->where('CodMotBloAct', $CodMotBloAct);        
        return $this->db->update('T_MotivoBloAct',array('DesMotBloAct'=>$DesMotBloAct));
    }
    public function agregar_motivo_bloqueo_actividades($DesMotBloAct)
    {
        $this->db->insert('T_MotivoBloAct',array('DesMotBloAct'=>$DesMotBloAct));
        return $this->db->insert_id();
    }
     public function get_tipo_tMotivo_Bloqueo_Actividades($CodMotBloAct)
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloAct');  
        $this->db->where('CodMotBloAct',$CodMotBloAct);
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
    public function borrar_tMotivos_Bloqueos_Actividades($CodMotBloAct)
    { 
        return $this->db->delete('T_MotivoBloAct', array('CodMotBloAct' => $CodMotBloAct));
    }

      /// PARA LOS MOTIVOS DE BLOQUEOS DE ACTIVIDADES END////
     
    /////PARA LAS COLABORADORES START////   
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
    public function borrar_colaborador_data($CodCol)
    { 
        return $this->db->delete('T_Colaborador', array('CodCol' => $CodCol));
    }
    public function get_colaborador_data($CodCol)
    {
        $this->db->select('a.CodCol,a.TipCol,a.NumIdeFis,a.NomCol,a.CodTipVia,a.NomViaDir,a.NumViaDir,a.BloDir,a.EscDir,a.PlaDir,a.PueDir,b.CodPro,a.CodLoc,b.CPLoc,a.TelFijCol,a.TelCelCol,a.EmaCol,a.ObsCol,a.PorCol,a.EstCol');
        $this->db->from('T_Colaborador a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc');  
        $this->db->where('a.CodCol',$CodCol);
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
   public function agregar_colaborador($BloDir,$CodLoc,$CodTipVia,$EmaCol,$EscDir,$EstCol,$NomCol,$NomViaDir,$NumIdeFis,$NumViaDir,$ObsCol,$PlaDir,$PorCol,$PueDir,$TelCelCol,$TelFijCol,$TipCol)
    {
        $this->db->insert('T_Colaborador',array('BloDir'=>$BloDir,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'EmaCol'=>$EmaCol,'EscDir'=>$EscDir,'EstCol'=>$EstCol,'NomCol'=>$NomCol,'NomViaDir'=>$NomViaDir,'NumIdeFis'=>$NumIdeFis,'NumViaDir'=>$NumViaDir,'ObsCol'=>$ObsCol,'PlaDir'=>$PlaDir,'PorCol'=>$PorCol,'PueDir'=>$PueDir,'TelCelCol'=>$TelCelCol,'TelFijCol'=>$TelFijCol,'TipCol'=>$TipCol));
        return $this->db->insert_id();
    }
    public function actualizar_colaborador($CodCol,$BloDir,$CodLoc,$CodTipVia,$EmaCol,$EscDir,$EstCol,$NomCol,$NomViaDir,$NumIdeFis,$NumViaDir,$ObsCol,$PlaDir,$PorCol,$PueDir,$TelCelCol,$TelFijCol,$TipCol)
    {   
        $this->db->where('CodCol', $CodCol);        
        return $this->db->update('T_Colaborador',array('BloDir'=>$BloDir,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'EmaCol'=>$EmaCol,'EscDir'=>$EscDir,'EstCol'=>$EstCol,'NomCol'=>$NomCol,'NomViaDir'=>$NomViaDir,'NumIdeFis'=>$NumIdeFis,'NumViaDir'=>$NumViaDir,'ObsCol'=>$ObsCol,'PlaDir'=>$PlaDir,'PorCol'=>$PorCol,'PueDir'=>$PueDir,'TelCelCol'=>$TelCelCol,'TelFijCol'=>$TelFijCol,'TipCol'=>$TipCol));
    }    
    /////PARA LAS COLABORADORES END////

    /////PARA LAS SECTORES START////   
    public function get_list_sectores()
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
    public function borrar_sector_data($CodSecCli)
    { 
        return $this->db->delete('T_SectorCliente', array('CodSecCli' => $CodSecCli));
    }
    public function get_sector_data($CodSecCli)
    {
        $this->db->select('*');
        $this->db->from('T_SectorCliente'); 
        $this->db->where('CodSecCli',$CodSecCli);
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
   public function agregar_sector($DesSecCli)
    {
        $this->db->insert('T_SectorCliente',array('DesSecCli'=>$DesSecCli));
        return $this->db->insert_id();
    }
    public function actualizar_sector($CodSecCli,$DesSecCli)
    {   
        $this->db->where('CodSecCli', $CodSecCli);        
        return $this->db->update('T_SectorCliente',array('DesSecCli'=>$DesSecCli));
    }    
    /////PARA LAS SECTORES END////

    /////PARA LAS TIPOS DE INMUEBLES START////   
    public function get_list_inmuebles()
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
    public function agregar_inmueble($DesTipInm)
    {
        $this->db->insert('T_TipoInmueble',array('DesTipInm'=>$DesTipInm));
        return $this->db->insert_id();
    }
    public function actualizar_inmueble($CodTipInm,$DesTipInm)
    {   
        $this->db->where('CodTipInm', $CodTipInm);        
        return $this->db->update('T_TipoInmueble',array('DesTipInm'=>$DesTipInm));
    }
     public function get_inmueble_data($CodTipInm)
    {
        $this->db->select('*');
        $this->db->from('T_TipoInmueble');  
        $this->db->where('CodTipInm',$CodTipInm);     
        $this->db->order_by('DesTipInm DESC');              
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
    public function borrar_row_inmueble_delete($CodTipInm)
    { 
        return $this->db->delete('T_TipoInmueble', array('CodTipInm' => $CodTipInm));
    }
    /////PARA LAS TIPOS DE INMUEBLES END////


    /////PARA LAS COMERCIALIZADORAS START////

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
     public function actualizar_comercializadora($CodCom,$BloDirCom,$CarConCom,$CodLoc,$CodTipVia,$DurConCom,$EmaCom,$EscDirCom,$FecConCom,$FecVenConCom,$NomComCom,$NomConCom,$NomViaDirCom,$NumCifCom,$NumViaDirCom,$ObsCom,$PagWebCom,$PlaDirCom,$PueDirCom,$RazSocCom,$RenAutConCom,$SerEle,$SerEsp,$SerGas,$TelFijCom,$DocConCom)
    {   
        $this->db->where('CodCom', $CodCom);        
        return $this->db->update('T_Comercializadora',array('BloDirCom'=>$BloDirCom,'CarConCom'=>$CarConCom,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'DurConCom'=>$DurConCom,'EmaCom'=>$EmaCom,'EscDirCom'=>$EscDirCom,'FecConCom'=>$FecConCom,'FecVenConCom'=>$FecVenConCom,'NomComCom'=>$NomComCom,'NomConCom'=>$NomConCom,'NomViaDirCom'=>$NomViaDirCom,'NumViaDirCom'=>$NumViaDirCom,'ObsCom'=>$ObsCom,'PagWebCom'=>$PagWebCom,'PlaDirCom'=>$PlaDirCom,'PueDirCom'=>$PueDirCom,'RazSocCom'=>$RazSocCom,'RenAutConCom'=>$RenAutConCom,'SerEle'=>$SerEle,'SerEsp'=>$SerEsp,'SerGas'=>$SerGas,'TelFijCom'=>$TelFijCom,'DocConCom'=>$DocConCom));
    }
    public function agregar_comercializadora($BloDirCom,$CarConCom,$CodLoc,$CodTipVia,$DurConCom,$EmaCom,$EscDirCom,$FecConCom,$FecVenConCom,$NomComCom,$NomConCom,$NomViaDirCom,$NumCifCom,$NumViaDirCom,$ObsCom,$PagWebCom,$PlaDirCom,$PueDirCom,$RazSocCom,$RenAutConCom,$SerEle,$SerEsp,$SerGas,$TelFijCom,$fecha,$DocConCom)
    {
        $this->db->insert('T_Comercializadora',array('BloDirCom'=>$BloDirCom,'CarConCom'=>$CarConCom,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'DurConCom'=>$DurConCom,'EmaCom'=>$EmaCom,'EscDirCom'=>$EscDirCom,'FecConCom'=>$FecConCom,'FecVenConCom'=>$FecVenConCom,'NomComCom'=>$NomComCom,'NomConCom'=>$NomConCom,'NomViaDirCom'=>$NomViaDirCom,'NumCifCom'=>$NumCifCom,'NumViaDirCom'=>$NumViaDirCom,'ObsCom'=>$ObsCom,'PagWebCom'=>$PagWebCom,'PlaDirCom'=>$PlaDirCom,'PueDirCom'=>$PueDirCom,'RazSocCom'=>$RazSocCom,'RenAutConCom'=>$RenAutConCom,'SerEle'=>$SerEle,'SerEsp'=>$SerEsp,'SerGas'=>$SerGas,'TelFijCom'=>$TelFijCom,'FecIniCom'=>$fecha,'DocConCom'=>$DocConCom));
        return $this->db->insert_id();
    }
    public function get_CodCom($CodCom)
    {
        $this->db->select('a.CodCom,a.RazSocCom,a.NomComCom,a.NumCifCom,a.CodTipVia,a.NomViaDirCom,a.NumViaDirCom,a.BloDirCom,a.EscDirCom,a.PlaDirCom,a.PueDirCom,b.CodPro,a.CodLoc,,DATE_FORMAT(a.FecIniCom,"%d/%m/%Y") as FecIniCom,a.TelFijCom,a.EmaCom,a.PagWebCom,a.NomConCom,a.CarConCom,a.SerGas,a.SerEle,a.SerEsp,a.DocConCom,DATE_FORMAT(a.FecConCom,"%d/%m/%Y") as FecConCom,a.DurConCom,a.RenAutConCom,,DATE_FORMAT(a.FecVenConCom,"%d/%m/%Y") as FecVenConCom,a.ObsCom,b.CPLoc as ZonPos',false);
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
    public function update_status_comercializadora($CodCom,$EstCom)
    {   
        $this->db->where('CodCom', $CodCom);        
        return $this->db->update('T_Comercializadora',array('EstCom'=>$EstCom));
    }
      public function delete_comercializadora($CodCom)
    { 
        return $this->db->delete('T_Comercializadora', array('CodCom' => $CodCom));
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
     public function agregar_bloqueo_Com($CodCom,$fecha,$MotBloq,$ObsBloCom)
    {
        $this->db->insert('T_BloqueoComercializadora',array('CodCom'=>$CodCom,'FecBloCom'=>$fecha,'CodMotBloCom'=>$MotBloq,'ObsBloCom'=>$ObsBloCom));
        return $this->db->insert_id();
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







    /////PARA LAS COMERCIALIZADORAS END////








    /////PARA LOS BLOQUEOS DEL PUNTO DE SUMINISTRO  START////

       public function get_list_MotPumSum()
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
     public function actualizar_MotBloPunSum($CodMotBloPun,$DesMotBloPun)
    {   
        $this->db->where('CodMotBloPun', $CodMotBloPun);        
        return $this->db->update('T_MotivoBloPun',array('DesMotBloPun'=>$DesMotBloPun));
    }
    public function agregar_MotBloPunSum($DesMotBloPun)
    {
        $this->db->insert('T_MotivoBloPun',array('DesMotBloPun'=>$DesMotBloPun));
        return $this->db->insert_id();
    }
    public function get_MotBloPunSum($CodMotBloPun)
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloPun');  
        $this->db->where('CodMotBloPun',$CodMotBloPun);          
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
     public function borrar_MotBloPumSum($CodMotBloPun)
    { 
        return $this->db->delete('T_MotivoBloPun', array('CodMotBloPun' => $CodMotBloPun));
    }




    /////PARA LOS BLOQUEOS DEL PUNTO DE SUMINISTRO  END////

    /////PARA LOS BLOQUEOS MOTIVOS DE LAS COMERCIALIZADORA START////

       public function get_motivos_Comercializadora()
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
    public function actualizar_MotBloCom($CodMotBloCom,$DesMotBloCom)
    {   
        $this->db->where('CodMotBloCom', $CodMotBloCom);        
        return $this->db->update('T_MotivoBloCom',array('DesMotBloCom'=>$DesMotBloCom));
    }
    public function agregar_MotBloCom($DesMotBloCom)
    {
        $this->db->insert('T_MotivoBloCom',array('DesMotBloCom'=>$DesMotBloCom));
        return $this->db->insert_id();
    }
  public function get_MotBloCom($CodMotBloCom)
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloCom');  
        $this->db->where('CodMotBloCom',$CodMotBloCom);          
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
     public function borrar_MotBloCom($CodMotBloCom)
    { 
        return $this->db->delete('T_MotivoBloCom', array('CodMotBloCom' => $CodMotBloCom));
    }
    /////PARA LOS BLOQUEOS MOTIVOS DE LAS COMERCIALIZADORA END////








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
	public function actualizar_productos($CodTPro,$CodTProCom,$DesPro,$CodTProCom,$SerGas,$SerEle,$ObsPro)
    {   
        $this->db->where('CodPro', $CodTPro);        
        return $this->db->update('T_Producto',array('CodCom'=>$CodTProCom,'DesPro'=>$DesPro,'SerGas'=>$SerGas,'SerEle'=>$SerEle,'ObsPro'=>$ObsPro));
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


///////////////////////////////////////////PARA LOS PRODUCTOS END////////////////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////PARA LOS ANEXOS START////////////////////////////////////////////////////////////////////////////////////

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
    public function actualizar_anexos($CodAnePro,$CodPro,$DesAnePro,$SerGas,$SerEle,$DocAnePro,$ObsAnePro,$CodTipCom,$EstCom,$TipPre)
    {   
        $this->db->where('CodAnePro', $CodAnePro);        
        return $this->db->update('T_AnexoProducto',array('CodPro'=>$CodPro,'DesAnePro'=>$DesAnePro,'SerGas'=>$SerGas,'SerEle'=>$SerEle,'DocAnePro'=>$DocAnePro,'ObsAnePro'=>$ObsAnePro,'CodTipCom'=>$CodTipCom,'EstCom'=>$EstCom,'TipPre'=>$TipPre));
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



///////////////////////////////////////////PARA LOS ANEXOS END////////////////////////////////////////////////////////////////////////////////////







///////////////////////////////////////////PARA LOS SERVICIOS ESPECIALES START////////////////////////////////////////////////////////////////////////////////////


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
    public function actualizar_servicio_especial($CodSerEsp,$CodCom,$DesSerEsp,$TipSumSerEsp,$TipCli,$CarSerEsp,$CodTipCom,$OsbSerEsp)
    {   
        $this->db->where('CodSerEsp', $CodSerEsp);        
        return $this->db->update('T_ServicioEspecial',array('CodCom'=>$CodCom,'DesSerEsp'=>$DesSerEsp,'TipSumSerEsp'=>$TipSumSerEsp,'CarSerEsp'=>$CarSerEsp,'TipCli'=>$TipCli,'CodTipCom'=>$CodTipCom,'OsbSerEsp'=>$OsbSerEsp));
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






///////////////////////////////////////////PARA LOS SERVICIOS ESPECIALES END////////////////////////////////////////////////////////////////////////////////////










    /////PARA EL REGISTRO DE CONTACTOS CLIENTES START////   
    public function get_lista_contactos()
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
    public function agregar_contacto($DesTipCon)
    {
        $this->db->insert('T_TipoContacto',array('DesTipCon'=>$DesTipCon));
        return $this->db->insert_id();
    }
    public function actualizar_contacto($CodTipCon,$DesTipCon)
    {    
        $this->db->where('CodTipCon', $CodTipCon);        
        return $this->db->update('T_TipoContacto',array('DesTipCon'=>$DesTipCon));
    }
    public function get_contacto_data($CodTipCon)
    {
        $this->db->select('*');
        $this->db->from('T_TipoContacto');  
        $this->db->where('CodTipCon',$CodTipCon);     
        $this->db->order_by('DesTipCon DESC');              
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
     public function borrar_contacto_data($CodTipCon)
    { 
        return $this->db->delete('T_TipoContacto', array('CodTipCon' => $CodTipCon));
    }
    /////PARA EL REGISTRO DE CONTACTOS CLIENTES END////



    /////PARA LOS MOTIVOS DE BLOQUEOS CONTACTOS START////   
    public function get_lista_motivo_contactos()
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
    public function agregar_motivo_bloqueo_contacto($DesMotBlocon)
    {
        $this->db->insert('T_MotivoBloCon',array('DesMotBlocon'=>$DesMotBlocon));
        return $this->db->insert_id();
    }
    public function actualizar_motivo_bloqueo_contacto($CodMotBloCon,$DesMotBlocon)
    {    
        $this->db->where('CodMotBloCon', $CodMotBloCon);        
        return $this->db->update('T_MotivoBloCon',array('DesMotBlocon'=>$DesMotBlocon));
    }
     public function get_motivo_bloqueo_contacto_data($CodMotBloCon)
    {
        $this->db->select('*');
        $this->db->from('T_MotivoBloCon');  
        $this->db->where('CodMotBloCon',$CodMotBloCon);       
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
    public function borrar_motivo_bloqueo_contacto_data($CodMotBloCon)
    { 
        return $this->db->delete('T_MotivoBloCon', array('CodMotBloCon' => $CodMotBloCon));
    }
    /////PARA LOS MOTIVOS DE BLOQUEOS CONTACTOS END////
}