<?php
class Cups_model extends CI_Model 
{
	public function get_list_cups()
    {
       $sql = $this->db->query('SELECT a.CodCupGas,a.CupsGas,case a.TipServ when 2 then "Gas" END AS TipServ,b.NomTarGas,a.CodPunSum,a.CodDis,c.CodCli FROM T_CUPsGas a 
		JOIN T_TarifaGas b ON a.CodTarGas=b.CodTarGas JOIN T_PuntoSuministro c ON a.CodPunSum=c.CodPunSum UNION SELECT a.CodCupsEle,a.CUPsEle,case a.TipServ when 1 then "Eléctrico" END AS TipServ,b.NomTarEle,a.CodPunSum,a.CodDis,c.CodCli FROM T_CUPsElectrico a JOIN T_TarifaElectrica b ON a.CodTarElec=b.CodTarEle JOIN T_PuntoSuministro c ON a.CodPunSum=c.CodPunSum');
        if ($sql->num_rows() > 0)
          return $sql->result();
        else  
        return false;      
    }    

    public function get_list_cups_PunSum() 
    {
        $sql = $this->db->query("SELECT * FROM V_CupsGrib");
        if ($sql->num_rows() > 0)
          return $sql->result();
        else  
        return false;        
    }
    public function get_data_PunSum($CodPunSum) 
    {
        $this->db->select('b.NumCifCli,b.RazSocCli,e.DesTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,c.DesLoc,d.DesPro,c.CPLoc',FALSE);
        $this->db->from('T_PuntoSuministro a'); 
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc');
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        $this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia');
        $this->db->where('a.CodPunSum',$CodPunSum); 
       // $this->db->order_by('CupsGas ASC');              
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
    public function get_PumSum_for_cups($CodCli) 
    {
        $this->db->select('a.CodPunSum,b.NumCifCli,b.RazSocCli,e.DesTipVia,a.NomViaPunSum,a.NumViaPunSum,a.BloPunSum,a.EscPunSum,a.PlaPunSum,a.PuePunSum,c.DesLoc,d.DesPro,c.CPLoc',FALSE);
        $this->db->from('T_PuntoSuministro a'); 
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->join('T_Localidad c','a.CodLoc=c.CodLoc');
        $this->db->join('T_Provincia d','c.CodPro=d.CodPro');
        $this->db->join('T_TipoVia e','a.CodTipVia=e.CodTipVia');
        $this->db->where('a.CodCli',$CodCli); 
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
    public function get_Distribuidoras($Where,$Variable) 
    {
        $this->db->select('*',FALSE);
        $this->db->from('T_Distribuidora');
        $this->db->where($Where,$Variable); 
        $this->db->or_where('TipSerDis=2');              
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
    public function get_Tarifas($Tabla,$Select_Tarifa) 
    {
        $this->db->select($Select_Tarifa,FALSE);
        $this->db->from($Tabla);
        //$this->db->where($Where,$Variable); 
       // $this->db->order_by('CupsGas ASC');              
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
    public function agregar_CUPs($Tabla,$TipServ,$cups,$CodDis,$CodTar,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$PotMaxBie,$FecAltCup,$FecUltLec,$ConAnuCup,$CodPunSum)
    {
        if($TipServ==1)
        {
        	$this->db->insert($Tabla,array('CodPunSum'=>$CodPunSum,'CodDis'=>$CodDis,'CUPsEle'=>$cups,'CodTarElec'=>$CodTar,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6,'PotMaxBie'=>$PotMaxBie,'FecAltCup'=>$FecAltCup,'FecUltLec'=>$FecUltLec,'ConAnuCup'=>$ConAnuCup));
        	return $this->db->insert_id();
        }
        if($TipServ==2)
        {
        	$this->db->insert($Tabla,array('CodPunSum'=>$CodPunSum,'CupsGas'=>$cups,'CodTarGas'=>$CodTar,'CodDis'=>$CodDis,'FecAltCup'=>$FecAltCup,'FecAltCup'=>$FecAltCup,'FecUltLec'=>$FecUltLec,'ConAnuCup'=>$ConAnuCup));
        	return $this->db->insert_id();
        }
        
    }
    public function actualizar_CUPs($Tabla,$CodCup,$TipServ,$cups,$CodDis,$CodTar,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$PotMaxBie,$FecAltCup,$FecUltLec,$ConAnuCup,$CodPunSum,$Where)
    {   
        if($TipServ==1)
        {
        	$this->db->where($Where, $CodCup);      
        	return $this->db->update($Tabla,array('CodPunSum'=>$CodPunSum,'CodDis'=>$CodDis,'CUPsEle'=>$cups,'CodTarElec'=>$CodTar,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6,'PotMaxBie'=>$PotMaxBie,'FecAltCup'=>$FecAltCup,'FecUltLec'=>$FecUltLec,'ConAnuCup'=>$ConAnuCup));
        }
         if($TipServ==2)
        {
        	$this->db->where($Where, $CodCup);      
        	return $this->db->update($Tabla,array('CodPunSum'=>$CodPunSum,'CodDis'=>$CodDis,'CupsGas'=>$cups,'CodTarGas'=>$CodTar,'FecAltCup'=>$FecAltCup,'FecUltLec'=>$FecUltLec,'ConAnuCup'=>$ConAnuCup));
        }
        
    }
    public function borrar_registro_anterior_CUPs($Tabla_Delete,$where,$CodCup)
    { 
        return $this->db->delete($Tabla_Delete, array($where => $CodCup));
    }
    public function get_data_Cups2($Select,$Tabla,$Where,$CodCup,$TipServ) 
    {
        $this->db->select($Select,FALSE);
        $this->db->from($Tabla);
        //$this->db->join("T_PuntoSuministro b",'b.CodPunSum=a.CodPunSum');
        //$this->db->join("T_Cliente c",'c.CodCli=b.CodCli');    
        if($TipServ==1)
        {
            $this->db->join("T_TarifaElectrica d",'d.CodTarEle=a.CodTarEle');
        }
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
     public function get_data_Cups($Select,$Tabla,$Where,$CodCup,$TipServ) 
    {
        $this->db->select($Select,FALSE);
        $this->db->from($Tabla);
        $this->db->join("T_PuntoSuministro b",'b.CodPunSum=a.CodPunSum');
        $this->db->join("T_Cliente c",'c.CodCli=b.CodCli');    
        if($TipServ==1)
        {
            $this->db->join("T_TarifaElectrica d",'d.CodTarEle=a.CodTarElec');
        }
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
     public function get_motivo_cups() 
    {
        $this->db->select('*',FALSE);
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

     public function update_status_cups($Tabla_Update,$Where,$CodCUPs,$Estatus)
    {   
        $this->db->where($Where,$CodCUPs);      
        return $this->db->update($Tabla_Update,array($Estatus=>2));       
    }
     public function insert_motiv_blo_cups($Tabla_Insert,$CodCUPs,$MotBloq,$ObsMotCUPs,$Fecha)
    {
       $this->db->insert($Tabla_Insert,array('CodCUPs'=>$CodCUPs,'FecBloCUPs'=>$Fecha,'CodMotBloCUPs'=>$MotBloq,'ObsMotCUPs'=>$ObsMotCUPs));
        	return $this->db->insert_id(); 
    }
     public function get_list_tarifas_filtros($Tabla,$Select) 
    {
        $this->db->select($Select,FALSE);
        $this->db->from($Tabla);
        //$this->db->where($Where,$Variable); 
        //$this->db->order_by('CupsGas ASC');              
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

    public function generar_historial_consumo_cups($desde,$hasta,$CodCup,$Tabla,$Where,$VariableCon) 
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
    public function sum_consumo_cups($desde,$hasta,$CodCup,$Tabla,$Where,$VariableCon) 
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
    public function getCUPssearchFilter($SearchText) 
    {
         $this->db->select('*',FALSE);
        $this->db->from('V_CupsGrib'); 
        $this->db->like('Cups_Cif',$SearchText);
        $this->db->or_like('CupsGas',$SearchText); 
        $this->db->or_like('Cups_RazSocCli',$SearchText);
        $this->db->or_like('DesPro',$SearchText);
        $this->db->or_like('DesLoc',$SearchText);
        $this->db->or_like('TipServ',$SearchText); 
        $this->db->or_like('NomTarGas',$SearchText);
        $this->db->or_like('EstCUPs',$SearchText);
       // $this->db->order_by('CupsGas ASC');              
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








//////////////////////////////////////////////////////////// PARA CONSUMO CUPS START ////////////////////////////////////////////////
public function get_list_consumos_cups($Select,$Tabla,$Join,$Joinb,$Join2,$Joinc,$Where,$CodCup) 
    {
        $this->db->select($Select,FALSE);
        $this->db->from($Tabla);
        $this->db->join($Join,$Joinb);
        $this->db->join($Join2,$Joinc);
        $this->db->where($Where,$CodCup);
        $this->db->order_by('a.FecIniCon DESC');              
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
     public function agregar_Consumo_CUPs($Tabla,$CodTar,$TipServ,$PotCon1,$PotCon2,$PotCon3,$PotCon4,$PotCon5,$PotCon6,$FecIniCon,$FecFinCon,$ConCup,$CodCup)
    {
        if($TipServ==1)
        {
            $this->db->insert($Tabla,array('CodCupEle'=>$CodCup,'CodTarEle'=>$CodTar,'PotCon1'=>$PotCon1,'PotCon2'=>$PotCon2,'PotCon3'=>$PotCon3,'PotCon4'=>$PotCon4,'PotCon5'=>$PotCon5,'PotCon6'=>$PotCon6,'FecIniCon'=>$FecIniCon,'FecFinCon'=>$FecFinCon,'TipServ'=>$TipServ,'EstConCupEle'=>1,'ConCup'=>$ConCup));
            return $this->db->insert_id();
        }
        if($TipServ==2)
        {
            $this->db->insert($Tabla,array('CodCupGas'=>$CodCup,'CodTarGas'=>$CodTar,'FecIniCon'=>$FecIniCon,'FecFinCon'=>$FecFinCon,'ConCup'=>$ConCup,'TipServ'=>2,'EstConCupGas'=>1));
            return $this->db->insert_id();
        }        
    }
    public function actualizar_Consumo_CUPs($Tabla,$CodConCup,$CodTar,$TipServ,$PotCon1,$PotCon2,$PotCon3,$PotCon4,$PotCon5,$PotCon6,$FecIniCon,$FecFinCon,$ConCup,$CodCup,$Where)
    {   
        if($TipServ==1)
        {
            $this->db->where($Where, $CodConCup);      
            return $this->db->update($Tabla,array('CodTarEle'=>$CodTar,'PotCon1'=>$PotCon1,'PotCon2'=>$PotCon2,'PotCon3'=>$PotCon3,'PotCon4'=>$PotCon4,'PotCon5'=>$PotCon5,'PotCon6'=>$PotCon6,'FecIniCon'=>$FecIniCon,'FecFinCon'=>$FecFinCon,'ConCup'=>$ConCup));
        }
         if($TipServ==2)
        {
            $this->db->where($Where, $CodConCup);      
            return $this->db->update($Tabla,array('FecIniCon'=>$FecIniCon,'FecFinCon'=>$FecFinCon,'ConCup'=>$ConCup));
        }
        
    }


///////////////////////////////////////////////////// PARA CONSUMO CUPS END //////////////////////////////////////////////////////

}
?>
