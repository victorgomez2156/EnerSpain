<?php
class Otrasgestiones_model extends CI_Model 
{
	
///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL START ///////////////////////////////////////////////

	public function get_tipos_gestiones()
    {
        $this->db->select('*',false);
        $this->db->from('T_TipoGestion');
        $this->db->where('ActTipGes=1'); 
        $this->db->order_by('DesTipGes ASC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
	public function get_cups($tabla_PunSum,$tabla_cups,$onCUps,$tabla_Dist,$onDist,$select,$orderby,$where,$CodCli)
    {
        $this->db->select($select,false);
        $this->db->from($tabla_PunSum);
        $this->db->join($tabla_cups,$onCUps);
        $this->db->join($tabla_Dist,$onDist);
        $this->db->where($where,$CodCli); 
        $this->db->order_by($orderby); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
     public function update_gestion_comercial($CodGesGen,$CodCli,$FecGesGen,$TipGesGen,$RefGesGen,$MecGesGen,$EstGesGen,$PreGesGen,$CodCups,$DesAnaGesGen,$ObsGesGen,$TipCups,$NGesGen)
    {   
    	if($TipCups==0)
    	{
    		$CUPS='CodCupsEle';
    	}
    	if($TipCups==1)
    	{
    		$CUPS='CodCupsGas';
    	}
        $this->db->where('CodGesGen', $CodGesGen); 
        $this->db->where('NGesGen', $NGesGen);       
        return $this->db->update('T_OtrasGestiones',array('FecGesGen'=>$FecGesGen,'TipGesGen'=>$TipGesGen,'RefGesGen'=>$RefGesGen,'MecGesGen'=>$MecGesGen,'PreGesGen'=>$PreGesGen,'DesAnaGesGen'=>$DesAnaGesGen,'ObsGesGen'=>$ObsGesGen,$CUPS=>$CodCups));
    }
    public function save_gestion_comercial($CodCli,$FecGesGen,$TipGesGen,$RefGesGen,$MecGesGen,$EstGesGen,$PreGesGen,$CodCups,$DesAnaGesGen,$ObsGesGen,$TipCups,$NGesGen)
    {        
    	if($TipCups==0)
    	{
    		$CUPS='CodCupsEle';
    	}
    	if($TipCups==1)
    	{
    		$CUPS='CodCupsGas';
    	}
        $this->db->insert('T_OtrasGestiones',array('CodCli'=>$CodCli,'FecGesGen'=>$FecGesGen,'TipGesGen'=>$TipGesGen,'RefGesGen'=>$RefGesGen,'MecGesGen'=>$MecGesGen,'EstGesGen'=>$EstGesGen,'PreGesGen'=>$PreGesGen,'DesAnaGesGen'=>$DesAnaGesGen,'ObsGesGen'=>$ObsGesGen,$CUPS=>$CodCups,'NGesGen'=>$NGesGen));
        return $this->db->insert_id();
    }
    public function get_list_gestiones()
    {
        $this->db->select('a.CodGesGen,a.CodCli,c.RazSocCli,c.NumCifCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,b.DesTipGes,a.PreGesGen,a.RefGesGen,a.EstGesGen,d.CUPsEle,e.CupsGas',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_TipoGestion b','a.TipGesGen=b.CodTipGes');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->join('T_CUPsElectrico d','d.CodCupsEle=a.CodCupsEle','LEFT');
        $this->db->join('T_CUPsGas e','e.CodCupGas=a.CodCupsGas','LEFT'); 
        $this->db->order_by('a.FecGesGen DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function get_FilterGestiones($SearchText)
    {
        $this->db->select('a.CodGesGen,a.CodCli,c.RazSocCli,c.NumCifCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,b.DesTipGes,a.PreGesGen,a.RefGesGen,a.EstGesGen,d.CUPsEle,e.CupsGas',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_TipoGestion b','a.TipGesGen=b.CodTipGes');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->join('T_CUPsElectrico d','d.CodCupsEle=a.CodCupsEle','LEFT');
        $this->db->join('T_CUPsGas e','e.CodCupGas=a.CodCupsGas','LEFT'); 
        $this->db->like('c.NumCifCli',$SearchText);
        $this->db->or_like('b.DesTipGes',$SearchText);
        $this->db->or_like('c.RazSocCli',$SearchText);
        $this->db->or_like('a.PreGesGen',$SearchText);
        $this->db->or_like('a.RefGesGen',$SearchText);
        $this->db->or_like('d.CUPsEle',$SearchText);
        $this->db->or_like('e.CupsGas',$SearchText);
        $this->db->order_by('a.FecGesGen DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }
    public function get_gestionComercial($CodGesGen)
    {
        $this->db->select('a.CodGesGen,a.CodCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,a.NGesGen,a.RefGesGen,a.MecGesGen,a.EstGesGen,a.PreGesGen,a.CodCupsEle,a.CodCupsGas,a.DesAnaGesGen,a.ObsGesGen,a.UltTipSeg,b.RazSocCli,b.NumCifCli',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_Cliente b','a.CodCli=b.CodCli');
        $this->db->where('CodGesGen',$CodGesGen); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->row();
        else
        return false;              
    }
    public function getOtrasGestionesFilter($SearchText)
    {
        $this->db->select('a.CodGesGen,a.CodCli,c.RazSocCli,c.NumCifCli,DATE_FORMAT(a.FecGesGen,"%d/%m/%Y") as FecGesGen,a.TipGesGen,b.DesTipGes,a.PreGesGen,a.RefGesGen,a.EstGesGen',false);
        $this->db->from('T_OtrasGestiones a');
        $this->db->join('T_TipoGestion b','a.TipGesGen=b.CodTipGes');
        $this->db->join('T_Cliente c','a.CodCli=c.CodCli');
        $this->db->like('DATE_FORMAT(a.FecGesGen,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('b.DesTipGes',$SearchText);
        $this->db->or_like('c.NumCifCli',$SearchText);
        $this->db->or_like('c.RazSocCli',$SearchText);
        $this->db->or_like('a.PreGesGen',$SearchText);
        $this->db->or_like('a.RefGesGen',$SearchText);
        $this->db->order_by('a.FecGesGen DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        return $query->result();
        else
        return false;              
    }






///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL END ////////////////////////////////////////////////
}

?>
