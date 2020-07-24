<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Colaboradores_model extends CI_Model 
{
   /////PARA LAS COLABORADORES START////   
    public function get_list_colaboradores($SearchText)
    {
        $this->db->select('*');
        $this->db->from('T_Colaborador');
        $this->db->like('NumIdeFis',$SearchText);
        $this->db->or_like('NomCol',$SearchText);
        $this->db->or_like('TelCelCol',$SearchText);
        $this->db->or_like('CodCol',$SearchText);
        $this->db->or_like('EmaCol',$SearchText);
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
    public function comprobar_dni_nie($NumIdeFis)
    {
        $this->db->select('NumIdeFis');
        $this->db->from('T_Colaborador');
        $this->db->where('NumIdeFis',$NumIdeFis);
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
    public function borrar_colaborador_data($CodCol)
    { 
        return $this->db->delete('T_Colaborador', array('CodCol' => $CodCol));
    }
    public function get_colaborador_data($CodCol)
    {
        $this->db->select('a.CodCol,a.TipCol,a.NumIdeFis,a.NomCol,a.CodTipVia,a.NomViaDir,a.NumViaDir,a.BloDir,a.EscDir,a.PlaDir,a.PueDir,b.CodPro,a.CodLoc,a.CPLoc,a.TelFijCol,a.TelCelCol,a.EmaCol,a.ObsCol,a.PorCol,a.EstCol');
        $this->db->from('T_Colaborador a');
        $this->db->join('T_Localidad b','a.CodLoc=b.CodLoc','left');  
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
   public function agregar_colaborador($BloDir,$CodLoc,$CodTipVia,$EmaCol,$EscDir,$NomCol,$NomViaDir,$NumIdeFis,$NumViaDir,$ObsCol,$PlaDir,$PorCol,$PueDir,$TelCelCol,$TelFijCol,$TipCol,$CPLoc)
    {
        $this->db->insert('T_Colaborador',array('BloDir'=>$BloDir,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'EmaCol'=>$EmaCol,'EscDir'=>$EscDir,'NomCol'=>$NomCol,'NomViaDir'=>$NomViaDir,'NumIdeFis'=>$NumIdeFis,'NumViaDir'=>$NumViaDir,'ObsCol'=>$ObsCol,'PlaDir'=>$PlaDir,'PorCol'=>$PorCol,'PueDir'=>$PueDir,'TelCelCol'=>$TelCelCol,'TelFijCol'=>$TelFijCol,'TipCol'=>$TipCol,'CPLoc'=>$CPLoc));
        return $this->db->insert_id();
    }
    public function actualizar_colaborador($CodCol,$BloDir,$CodLoc,$CodTipVia,$EmaCol,$EscDir,$NomCol,$NomViaDir,$NumIdeFis,$NumViaDir,$ObsCol,$PlaDir,$PorCol,$PueDir,$TelCelCol,$TelFijCol,$TipCol,$CPLoc)
    {   
        $this->db->where('CodCol', $CodCol);        
        return $this->db->update('T_Colaborador',array('BloDir'=>$BloDir,'CodLoc'=>$CodLoc,'CodTipVia'=>$CodTipVia,'EmaCol'=>$EmaCol,'EscDir'=>$EscDir,'NomCol'=>$NomCol,'NomViaDir'=>$NomViaDir,'NumViaDir'=>$NumViaDir,'ObsCol'=>$ObsCol,'PlaDir'=>$PlaDir,'PorCol'=>$PorCol,'PueDir'=>$PueDir,'TelCelCol'=>$TelCelCol,'TelFijCol'=>$TelFijCol,'TipCol'=>$TipCol,'CPLoc'=>$CPLoc));
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
    public function update_status_Colaborador($CodCol,$opcion)
    {   
        $this->db->where('CodCol', $CodCol);        
        return $this->db->update('T_Colaborador',array('EstCol'=>$opcion));
    } 
    public function agregar_bloqueo_Colaborador($CodCol,$FecBloCol,$MotBloqColBlo,$ObsBloColBlo)
    {
        $this->db->insert('T_BloqueoColaborador',array('CodCol'=>$CodCol,'FecBloCol'=>$FecBloCol,'MotBloCol'=>$MotBloqColBlo,'ObsBloCol'=>$ObsBloColBlo));
        return $this->db->insert_id();
    }
    public function get_clientes_x_colaborador($CodCol){

        $this->db->select("c.CodCol,c.NomCol,a.NumCifCli,a.RazSocCli,d.CUPsEle,e.NomTarEle,(SELECT SUM(ConCup) FROM T_HistorialCUPsElectrico WHERE CodCupEle=d.CodCupsEle) AS ConCupEle,NULL AS CodProEle,f.CupsGas,g.NomTarGas,(SELECT SUM(ConCup) FROM T_HistorialCUPsGas WHERE CodCupGas=f.CodCupGas) AS ConCupGas,NULL AS CodProGas,NULL AS CodCom,a.NomViaDomSoc,a.NumViaDomSoc,a.BloDomSoc,a.EscDomSoc,a.PlaDomSoc,a.PueDomSoc,a.NomViaDomFis,a.NumViaDomFis,a.BloDomFis,a.EscDomFis,a.PlaDomFis,a.PueDomFis,a.DireccionBBDD,(CASE WHEN c.TipCol =1 THEN 'Persona Física' WHEN c.TipCol = 2 THEN 'Empresa' ELSE 'incorrecto' END) AS Tipo_Colaborador,a.EmaCli",false);
		$this->db->from('T_Cliente a');
        $this->db->join('T_Colaborador c', 'a.CodCol = c.CodCol');
        $this->db->join('T_PuntoSuministro b', 'a.CodCli = b.CodCli','left');
		$this->db->join('T_CUPsElectrico d', 'b.CodPunSum = d.CodPunSum','left');
		$this->db->join('T_TarifaElectrica e', 'e.CodTarEle=d.CodTarElec','left');
        $this->db->join('T_CUPsGas f', 'f.CodPunSum=b.CodPunSum','left');
        $this->db->join('T_TarifaGas g', 'g.CodTarGas=f.CodTarGas','left');
        $this->db->where('c.CodCol',$CodCol);
        $this->db->order_by('a.RazSocCli ASC');
        $query = $this->db->get();        
		return $query->result();
    }
    public function getColabordoresFilters($SearchText)
    {
        $this->db->select('*');
        $this->db->from('T_Colaborador');
        $this->db->like('NomCol',$SearchText);
        $this->db->or_like('NumIdeFis',$SearchText);
        $this->db->or_like('TelFijCol',$SearchText);
        $this->db->or_like('TelCelCol',$SearchText);
        $this->db->or_like('EmaCol',$SearchText);
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
    public function FilterLocalidades($CodPro)
    {
        $this->db->select('*');
        $this->db->from('T_Localidad');
        $this->db->where('CodPro',$CodPro);
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