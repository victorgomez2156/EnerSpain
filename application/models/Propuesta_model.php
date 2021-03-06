<?php
class Propuesta_model extends CI_Model 
{	
///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL START ///////////////////////////////////////////////
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
    } ##case a.EstProCom when "P" then "Pendiente" when "A" then "Aprobada" when "C" then "Completada" when "R" then "Rechazada" end as EstProCom,
    public function Funcion_Verificadora2($Variable,$tabla,$where,$select,$where2,$Variable2)
    {
        $this->db->select($select,false);
        $this->db->from($tabla);       
        $this->db->where($where,$Variable);
        $this->db->where($where2,$Variable2);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    }
    public function get_list_propuesta_clientes_all()
    {
        $this->db->select('*',false);
        $this->db->from('VPropuestaSencillas');
        $this->db->order_by('FecProCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }
    public function get_list_propuesta_comerciales_filtro($where,$Variable)
    {
        $this->db->select('*',false);
        $this->db->from('VPropuestaSencillas');
        $this->db->where($where,$Variable);
        $this->db->order_by('FecProCom DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    } 
    public function Buscar_PropuestaCol($Variable,$tabla,$where)
    {
        $this->db->select('*',false);
        $this->db->from($tabla);
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom');   
        $this->db->where($where,$Variable);
        $this->db->where('a.EstProCom','P'); 
        $this->db->where('a.TipProCom=3');             
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    }     
    public function Buscar_Propuesta($Variable,$tabla,$where)
    {
        $this->db->select('*',false);
        $this->db->from($tabla);
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom');   
        $this->db->where($where,$Variable);
        $this->db->where('EstProCom','P');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    } 
    public function Buscar_Contratos($Variable)
    {
        $this->db->select('a.*,b.TipProCom',false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_PropuestaComercial b','a.CodProCom=b.CodProCom','left');        
        $this->db->where('CodCli',$Variable);          
        $this->db->order_by('FecConCom DESC');   
        //$this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }
    public function Buscar_ContratosCol($Variable)
    {
        $this->db->select('a.*',false);
        $this->db->from('T_Contrato a');
        $this->db->join('T_PropuestaComercial b','a.CodProCom=b.CodProCom');       
        $this->db->where('a.CodCli',$Variable); 
        $this->db->where('b.TipProCom=3');         
        $this->db->order_by('FecConCom DESC');   
        //$this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }
    public function Buscar_Contratos_Vali($Variable,$CodConCom,$CodProCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_Contrato');       
        $this->db->where('CodCli',$Variable);
        $this->db->where('CodConCom',$CodConCom);
        $this->db->where('CodProCom',$CodProCom);
        $this->db->order_by('FecConCom DESC');   
        $this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    }
    public function Buscar_Propuesta_Vali($CodCli,$CodProCom)
    {
        $this->db->select('*',false);
        $this->db->from('T_PropuestaComercial');       
        $this->db->where('CodCli',$CodCli);
        $this->db->where('CodProCom',$CodProCom);
        $this->db->order_by('FecProCom DESC');   
        $this->db->limit(1);           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    }
    public function get_Tarifas_Act($Tabla,$Select_Tarifa,$EstTar,$order_by) 
    {
        $this->db->select($Select_Tarifa,FALSE);
        $this->db->from($Tabla);
        $this->db->where($EstTar,1); 
        $this->db->order_by($order_by);              
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
    public function Tarifas($Tabla,$order_by)
    {
        $this->db->select('*',false);
        $this->db->from($Tabla); 
        $this->db->order_by($order_by); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
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
    public function agregar_propuesta($FecProCom,$TipProCom,$PorAhoTot,$ImpAhoTot,$EstProCom,$JusRecProCom,$CodCom,$CodPro,$CodAnePro,$TipPre,$ObsProCom,$RefProCom,$CorpoGo)
    {
        $this->db->insert('T_PropuestaComercial',array('FecProCom'=>$FecProCom,'TipProCom'=>$TipProCom,'PorAhoTot'=>$PorAhoTot,'ImpAhoTot'=>$ImpAhoTot,'EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom,'CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ObsProCom'=>$ObsProCom,'RefProCom'=>$RefProCom,'CorpoGo'=>$CorpoGo));
        return $this->db->insert_id();
    }
    public function agregar_propuesta_comercial_clientes($CodProCom,$CodCli)
    {
        $this->db->insert('T_Propuesta_Comercial_Clientes',array('CodProCom'=>$CodProCom,'CodCli'=>$CodCli));
        return $this->db->insert_id();
    }
    public function agregar_detallesCUPs($CodProComCli,$CodPunSum,$CodCups,$CodTar,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$RenCon,$ImpAho,$PorAho,$ObsCup,$ConCUPs,$CauDia,$TipServ,$FecActCUPs)
    {
        $this->db->insert('T_Propuesta_Comercial_CUPs',array('CodProComCli'=>$CodProComCli,'CodPunSum'=>$CodPunSum,'CodCup'=>$CodCups,'CodTar'=>$CodTar,'PotEleConP1'=>$PotConP1,'PotEleConP2'=>$PotConP2,'PotEleConP3'=>$PotConP3,'PotEleConP4'=>$PotConP4,'PotEleConP5'=>$PotConP5,'PotEleConP6'=>$PotConP6,'RenCup'=>$RenCon,'ImpAho'=>$ImpAho,'PorAho'=>$PorAho,'ObsCup'=>$ObsCup,'ConCup'=>$ConCUPs,'CauDiaGas'=>$CauDia,'TipCups'=>$TipServ,'FecActCUPs'=>$FecActCUPs));
        return $this->db->insert_id();
    }
    public function update_detallesCUPs($CodProComCup,$CodCups,$CodProComCli,$TipServ,$FecActCUPs)
    {   
        $this->db->where('CodProComCup', $CodProComCup); 
        $this->db->where('CodCup', $CodCups); 
        $this->db->where('CodProComCli', $CodProComCli);  
        $this->db->where('TipCups', $TipServ);      
        return $this->db->update('T_Propuesta_Comercial_CUPs',array('FecActCUPs'=>$FecActCUPs));
    }
    public function update_detallesCUPsFecVenCUPs($CodProComCup,$CodCups,$CodProComCli,$TipServ,$FecVenCUPs)
    {   
        $this->db->where('CodProComCup', $CodProComCup); 
        $this->db->where('CodCup', $CodCups); 
        $this->db->where('CodProComCli', $CodProComCli);  
        $this->db->where('TipCups', $TipServ);      
        return $this->db->update('T_Propuesta_Comercial_CUPs',array('FecVenCUPs'=>$FecVenCUPs));
    }
    public function agregar_detallesHistorialCUPs($CodProComCli,$CodPunSum,$CodCups,$CodTar,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6,$RenCon,$ImpAho,$PorAho,$ObsCup,$ConCUPs,$CauDia,$TipServ)
    {
        $this->db->insert('T_Propuesta_Comercial_Historial_CUPs',array('CodProComCli'=>$CodProComCli,'CodPunSum'=>$CodPunSum,'CodCup'=>$CodCups,'CodTar'=>$CodTar,'PotEleConP1'=>$PotConP1,'PotEleConP2'=>$PotConP2,'PotEleConP3'=>$PotConP3,'PotEleConP4'=>$PotConP4,'PotEleConP5'=>$PotConP5,'PotEleConP6'=>$PotConP6,'RenCup'=>$RenCon,'ImpAho'=>$ImpAho,'PorAho'=>$PorAho,'ObsCup'=>$ObsCup,'ConCup'=>$ConCUPs,'CauDiaGas'=>$CauDia,'TipCups'=>$TipServ));
        return $this->db->insert_id();
    }




    public function update_contrato_cliente($CodCli,$CodConCom,$EstRen,$RenMod,$ProRenPen)
    {   
        $this->db->where('CodConCom', $CodConCom); 
        $this->db->where('CodCli', $CodCli);       
        return $this->db->update('T_Contrato',array('EstRen'=>$EstRen,'RenMod'=>$RenMod,'ProRenPen'=>$ProRenPen));
    }
    public function update_CUPs_Ele($CodCupsEle,$CodPunSum,$CodTarElec,$PotConP1,$PotConP2,$PotConP3,$PotConP4,$PotConP5,$PotConP6)
    {   
        $this->db->where('CodCupsEle', $CodCupsEle);
        return $this->db->update('T_CUPsElectrico',array('CodTarElec'=>$CodTarElec,'PotConP1'=>$PotConP1,'PotConP2'=>$PotConP2,'PotConP3'=>$PotConP3,'PotConP4'=>$PotConP4,'PotConP5'=>$PotConP5,'PotConP6'=>$PotConP6));
    }
    public function update_CUPs_Gas($CodCupGas,$CodPunSum,$CodTarGas,$Consumo)
    {   
        $this->db->where('CodCupGas', $CodCupGas);  
        return $this->db->update('T_CUPsGas',array('CodTarGas'=>$CodTarGas,'ConAnuCup'=>$Consumo));
    }
    public function update_view_propuesta($CodProCom,$JusRecProCom,$EstProCom)
    {   
        $this->db->where('CodProCom', $CodProCom);   
        return $this->db->update('T_PropuestaComercial',array('EstProCom'=>$EstProCom,'JusRecProCom'=>$JusRecProCom));
    }
    public function update_edit_propuesta($CodProCom,$CodCom,$CodPro,$CodAnePro,$TipPre,$ImpAhoTot,$PorAhoTot,$EstProCom,$RefProCom,$JusRecProCom,$CorpoGo)
    {   
        $this->db->where('CodProCom', $CodProCom); 
        return $this->db->update('T_PropuestaComercial',array('CodCom'=>$CodCom,'CodPro'=>$CodPro,'CodAnePro'=>$CodAnePro,'TipPre'=>$TipPre,'ImpAhoTot'=>$ImpAhoTot,'PorAhoTot'=>$PorAhoTot,'EstProCom'=>$EstProCom,'RefProCom'=>$RefProCom,'JusRecProCom'=>$JusRecProCom,'CorpoGo'=>$CorpoGo));
    }
    
    public function BuscandoGestiones($Tabla,$order_by,$select,$where,$CodCli)
    {
        $this->db->select($select,false);
        $this->db->from($Tabla);
        $this->db->where($where,$CodCli); 
        $this->db->order_by($order_by); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }
    public function BuscandoGestionesPropuestas($CodCli)
    {
        $this->db->select('a.CodProCom as CodRef,b.CodCli,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecGes,a.RefProCom as NumGes,a.RefProCom as RefGes,a.UltTipSeg',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom');
        $this->db->where('b.CodCli',$CodCli); 
        $this->db->where('a.TipProCom<3'); 
        $this->db->order_by('a.FecProCom DESC'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;               
    }

    public function save_seguimientos($CodCli,$CodRef,$FecSeg,$NumSeg,$ObsSeg,$RefSeg,$ResSeg,$TipSeg,$DesSeg)
    {
        $this->db->insert('T_Seguimiento',array('TipSeg'=>$TipSeg,'CodRef'=>$CodRef,'FecSeg'=>$FecSeg,'RefSeg'=>$RefSeg,'NumSeg'=>$NumSeg,'EstNotSeg'=>false,'ResSeg'=>$ResSeg,'ObsSeg'=>$ObsSeg,'CodCli'=>$CodCli,'DesSeg'=>$DesSeg));
        return $this->db->insert_id();
    }
    public function update_PropuestaComercial($CodRef,$ResSeg)
    {   
        //$this->db->where('CodCli', $CodCli); 
        $this->db->where('CodProCom', $CodRef);       
        return $this->db->update('T_PropuestaComercial',array('UltTipSeg'=>$ResSeg));
    }
    public function update_ContratoComercial($CodCli,$CodRef,$ResSeg)
    {   
        $this->db->where('CodCli', $CodCli); 
        $this->db->where('CodConCom', $CodRef);       
        return $this->db->update('T_Contrato',array('UltTipSeg'=>$ResSeg));
    }
    public function update_OtrasGestionesComercial($CodCli,$CodRef,$ResSeg)
    {   
        $this->db->where('CodCli', $CodCli); 
        $this->db->where('CodGesGen', $CodRef);       
        return $this->db->update('T_OtrasGestiones',array('UltTipSeg'=>$ResSeg));
    }
    public function get_seguimientos($TipSeg,$CodRef,$CodCli)
    {
        $this->db->select('CodSeg,TipSeg,CodCli,CodRef,date_format(FecSeg,"%d/%m/%Y") as FecSeg,RefSeg,NumSeg,DesSeg,EstNotSeg,ResSeg,ObsSeg',false);
        $this->db->from('T_Seguimiento');
        $this->db->where('TipSeg',$TipSeg);
        $this->db->where('CodRef',$CodRef); 
        $this->db->where('CodCli',$CodCli);  
        $this->db->order_by('FecSeg desc'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }
    public function updateemailseguimiento($CodSeg,$EstNotSeg)
    {   
        $this->db->where('CodSeg', $CodSeg);  
        return $this->db->update('T_Seguimiento',array('EstNotSeg'=>$EstNotSeg));
    }
    public function getPropuestaComercialesFilter($SearchText)
    {
        $this->db->select('*',false);
        $this->db->from('VPropuestaSencillas');
        $this->db->like('DATE_FORMAT(FecProCom,"%d/%m/%Y")',$SearchText);
        $this->db->or_like('NumCifCli',$SearchText);
        $this->db->or_like('RazSocCli',$SearchText);
        $this->db->or_like('CUPsEle',$SearchText);
        $this->db->or_like('CodCli',$SearchText);
        $this->db->or_like('CupsGas',$SearchText);
        $this->db->or_like('RefProCom',$SearchText);
        $this->db->order_by('DATE_FORMAT(FecProCom,"%Y/%m/%d") DESC');           
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }
    public function PropuestasSencilla()
    {
        $this->db->select(' a.*,b.CodCli,b.CodProComCli',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
        $this->db->where('a.TipProCom=1');               
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    }
    public function PropuestasUniCliente()
    {
        $this->db->select(' a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") AS FecProCom,b.CodCli,c.NumCifCli,c.RazSocCli,a.EstProCom,a.RefProCom,(SELECT COUNT(*) FROM T_Propuesta_Comercial_CUPs WHERE CodProComCli=b.CodProComCli) AS TotalCUPs',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
        $this->db->join('T_Cliente c','b.CodCli=c.CodCli',"left");
        $this->db->where('a.TipProCom=2');        
        $this->db->order_by('DATE_FORMAT(a.FecProCom,"%Y/%m/%d") DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    } 
    public function PropuestasMulCliente()
    {
        $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") AS FecProCom,b.CodCli,c.NIFConCli as NumCifCli,c.NomConCli as RazSocCli,a.EstProCom,a.RefProCom,(SELECT COUNT(DISTINCT(c.CodConCli)) FROM T_Propuesta_Comercial_CUPs a LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum LEFT JOIN T_ContactoCliente c ON c.CodConCli=b.CodCli WHERE CodProComCli=b.CodProComCli) AS CantCli,(SELECT COUNT(*) FROM T_Propuesta_Comercial_CUPs WHERE CodProComCli=b.CodProComCli) AS CantCups',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
        $this->db->join('T_ContactoCliente c','b.CodCli=c.CodConCli',"left");
        $this->db->where('a.TipProCom=3');        
        $this->db->order_by('DATE_FORMAT(a.FecProCom,"%Y/%m/%d") DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    } 
    public function PropuestasUniClienteFilter($SearchText)
    {
        $this->db->select(' a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") AS FecProCom,b.CodCli,c.NumCifCli,c.RazSocCli,a.EstProCom,a.RefProCom,(SELECT COUNT(*) FROM T_Propuesta_Comercial_CUPs WHERE CodProComCli=b.CodProComCli) AS TotalCUPs',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
        $this->db->join('T_Cliente c','b.CodCli=c.CodCli',"left");
        $this->db->where('a.TipProCom=2');
        $this->db->like('DATE_FORMAT(FecProCom,"%d/%m/%Y")',$SearchText);
        $this->db->where('a.TipProCom=2');
        $this->db->or_like('b.CodCli',$SearchText);
        $this->db->where('a.TipProCom=2');
        $this->db->or_like('c.NumCifCli',$SearchText);
        $this->db->where('a.TipProCom=2');
        $this->db->or_like('c.RazSocCli',$SearchText);
        $this->db->where('a.TipProCom=2');
        $this->db->or_like('a.RefProCom',$SearchText);                
        $this->db->order_by('DATE_FORMAT(a.FecProCom,"%Y/%m/%d") DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }    
    public function PropuestasSencillas()
    {
        $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") AS FecProCom,b.CodCli,c.NumCifCli,c.RazSocCli,(SELECT e.CUPsEle FROM T_Propuesta_Comercial_CUPs d left JOIN T_CUPsElectrico e ON e.CodCupsEle=d.CodCup left JOIN T_PuntoSuministro f ON f.CodPunSum=e.CodPunSum WHERE f.CodCli=c.CodCli and b.CodProComCli=d.CodProComCli and d.TipCups=1) AS CUPsEle,(SELECT g.CupsGas FROM T_Propuesta_Comercial_CUPs i left JOIN T_CUPsGas g ON i.CodCup =g.CodCupGas left JOIN T_PuntoSuministro h ON h.CodPunSum=g.CodPunSum WHERE h.CodCli=c.CodCli AND b.CodProComCli=i.CodProComCli and i.TipCups=2) AS CupsGas,a.EstProCom,a.RefProCom',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
        $this->db->join('T_Cliente c','b.CodCli=c.CodCli',"left"); 
        $this->db->where('a.TipProCom=1');        
        $this->db->order_by('DATE_FORMAT(a.FecProCom,"%Y/%m/%d") DESC');              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;              
    }
    
    public function BuscarProComUniCliente($CodProCom)
    {
        $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") as FecProCom,a.TipProCom,a.CodCon,a.PorAhoTot,a.ImpAhoTot,a.EstProCom,a.JusRecProCom,a.CodCom,a.CodPro,a.CodAnePro,a.TipPre,a.UltTipSeg,a.ObsProCom,a.RefProCom,b.CodCli,b.CodProComCli,a.ImpAhoTot,a.PorAhoTot,a.CorpoGo',false);
        $this->db->from('T_PropuestaComercial a');
        $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom');
        $this->db->where('a.CodProCom',$CodProCom);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
            return $query->row();
        else
            return false;              
    }
    public function GetDetallesCUPs($CodProComCli)
    {
        $sql = $this->db->query("SELECT a.CodProComCup,a.CodProComCli,b.CUPsEle AS CUPsName,a.CauDiaGas AS CauDia,a.CodCup AS CodCups,a.CodPunSum,a.CodTar,a.ConCup AS ConCUPs
            ,(CASE WHEN d.BloPunSum IS NULL OR d.BloPunSum='' THEN CONCAT(d.NomViaPunSum,'  ',d.NumViaPunSum) ELSE CONCAT(d.NomViaPunSum,'  ',d.NumViaPunSum,'  ',d.BloPunSum) END) AS DirPunSum,a.ImpAho,c.NomTarEle AS NomTar,a.ObsCup,a.PorAho,a.PotEleConP1 AS PotConP1,a.PotEleConP2 AS PotConP2,a.PotEleConP3 AS PotConP3,a.PotEleConP4 AS
            PotConP4,a.PotEleConP5 AS PotConP5,a.PotEleConP6 AS PotConP6,a.RenCup AS RenCon,a.TipCups AS TipServ,RazSocCli,NumCifCli,c.CanPerTar,f.DesLoc,g.DesPro,d.CPLocSoc,d.EscPunSum,d.PlaPunSum,d.PuePunSum,date_format(a.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(a.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs
            FROM T_Propuesta_Comercial_CUPs a 
            JOIN T_CUPsElectrico b ON a.CodCup=b.CodCupsEle AND a.TipCups=1 
            left JOIN T_TarifaElectrica c ON a.CodTar=c.CodTarEle
            left JOIN T_PuntoSuministro d ON a.CodPunSum=d.CodPunSum
            left JOIN T_TipoVia e ON d.CodTipVia=e.CodTipVia
            left JOIN T_Localidad f ON f.CodLoc=d.CodLoc
            left JOIN T_Provincia g ON g.CodPro=f.CodPro 
            left JOIN T_Cliente h ON h.CodCli=d.CodCli
            WHERE a.CodProComCli='$CodProComCli'
            UNION ALL
            SELECT h.CodProComCup,h.CodProComCli,i.CupsGas AS CUPsName,h.CauDiaGas AS CauDia,h.CodCup AS CodCups,h.CodPunSum,h.CodTar,h.ConCup AS ConCUPs,(CASE WHEN k.BloPunSum IS NULL OR k.BloPunSum='' THEN CONCAT(k.NomViaPunSum,'  ',k.NumViaPunSum) ELSE CONCAT(k.NomViaPunSum,'  ',k.NumViaPunSum,'  ',k.BloPunSum) END) AS DirPunSum
            ,h.ImpAho,
            j.NomTarGas AS NomTar,h.ObsCup,h.PorAho,h.PotEleConP1 AS PotConP1,h.PotEleConP2 AS PotConP2,h.PotEleConP3 AS PotConP3,h.PotEleConP4 AS
            PotConP4,h.PotEleConP5 AS PotConP5,h.PotEleConP6 AS PotConP6,h.RenCup AS RenCon,h.TipCups AS TipServ,RazSocCli,NumCifCli,NULL as CanPerTar,m.DesLoc,n.DesPro,k.CPLocSoc,k.EscPunSum,k.PlaPunSum,k.PuePunSum,date_format(h.FecActCUPs,'%d/%m/%Y') as FecActCUPs,date_format(h.FecVenCUPs,'%d/%m/%Y') as FecVenCUPs
            FROM T_Propuesta_Comercial_CUPs h 
            JOIN T_CUPsGas i ON h.CodCup=i.CodCupGas AND h.TipCups=2 
            left JOIN T_TarifaGas j ON h.CodTar=j.CodTarGas
            left JOIN T_PuntoSuministro k ON h.CodPunSum=k.CodPunSum
            left JOIN T_TipoVia l ON k.CodTipVia=l.CodTipVia
            left JOIN T_Localidad m ON m.CodLoc=k.CodLoc
            left JOIN T_Provincia n ON n.CodPro=m.CodPro
            left JOIN T_Cliente o ON o.CodCli=k.CodCli WHERE h.CodProComCli='$CodProComCli'");
        if ($sql->num_rows() > 0)
          return $sql->result();
      else
        return false;     
}
public function BuscarDetallesCUPsSencilla($CodProComCli)
{
    $this->db->select('*',false);
    $this->db->from('T_Propuesta_Comercial_CUPs');
    $this->db->where('CodProComCli',$CodProComCli);      
    $query = $this->db->get(); 
    if($query->num_rows()>0)
        return $query->result();
    else
        return false;              
}
public function SelectHistorialCUPs($CodProComCli)
{
    $this->db->select('*',false);
    $this->db->from('T_Propuesta_Comercial_CUPs');
    $this->db->where('CodProComCli',$CodProComCli);
    $query = $this->db->get(); 
    if($query->num_rows()>0)
        return $query->result();
    else
        return false;              
}
public function EliminarCUPs($CodProComCli)
{ 
    return $this->db->delete('T_Propuesta_Comercial_CUPs', array('CodProComCli' => $CodProComCli));
}
public function get_CUPs_Electricos($CodCli)
{
    $sql = $this->db->query("SELECT a.CodCupsEle,b.CodCli,a.CUPsEle,g.RazSocDis,f.NomTarEle,(CASE WHEN b.BloPunSum IS NULL OR b.BloPunSum='' THEN CONCAT(b.NomViaPunSum,'  ',b.NumViaPunSum) ELSE CONCAT(b.NomViaPunSum,'  ',b.NumViaPunSum,'  ',b.BloPunSum) END) AS DirPunSum,d.DesPro,c.DesLoc,CONCAT(b.EscPunSum,' ',b.PlaPunSum,' ',b.PuePunSum) AS EscPlaPue,b.CPLocSoc,f.CanPerTar,a.PotConP1,a.PotConP2,a.PotConP3,a.PotConP4,a.PotConP5,a.PotConP6,case a.TipServ when 1 then 'El??ctrico' end as TipServ,a.CodTarElec,a.CodPunSum,h.RazSocCli,h.NumCifCli
        FROM T_CUPsElectrico a 
        LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum 
        LEFT JOIN T_Localidad c on c.CodLoc=b.CodLoc
        LEFT JOIN T_Provincia d on d.CodPro=c.CodPro
        LEFT JOIN T_TipoVia e on b.CodTipVia=e.CodTipVia
        LEFT JOIN T_TarifaElectrica f ON a.CodTarElec=f.CodTarEle
        LEFT JOIN T_Distribuidora g ON a.CodDis=g.CodDist 
        LEFT JOIN T_Cliente h ON h.CodCli=b.CodCli where b.CodCli='$CodCli'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;     
}
public function get_CUPs_Gas($CodCli)
{
    $sql = $this->db->query("SELECT a.CodCupGas,b.CodCli,a.CupsGas,g.RazSocDis,f.NomTarGas,
        (CASE WHEN b.BloPunSum IS NULL OR b.BloPunSum='' THEN CONCAT(b.NomViaPunSum,'  ',b.NumViaPunSum) ELSE CONCAT(b.NomViaPunSum,'  ',b.NumViaPunSum,'  ',b.BloPunSum) END) AS DirPunSum,d.DesPro,c.DesLoc,CONCAT(b.EscPunSum,' ',b.PlaPunSum,' ',b.PuePunSum) AS EscPlaPue,b.CPLocSoc,case a.TipServ when 2 then 'Gas' end as TipServ,a.CodPunSum,a.CodTarGas,h.RazSocCli,h.NumCifCli
        FROM T_CUPsGas a 
        LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum
        LEFT JOIN T_Localidad c on c.CodLoc=b.CodLoc
        LEFT JOIN T_Provincia d on d.CodPro=c.CodPro
        LEFT JOIN T_TipoVia   e on b.CodTipVia=e.CodTipVia
        LEFT JOIN T_TarifaGas f ON a.CodTarGas=f.CodTarGas
        LEFT JOIN T_Distribuidora g ON a.CodDis=g.CodDist 
        LEFT JOIN T_Cliente h ON h.CodCli=b.CodCli where b.CodCli='$CodCli'");
    if ($sql->num_rows() > 0)
        return $sql->result();
    else
        return false;     
}
public function PropuestasMulClienteFilter($SearchText)
{
    $this->db->select('a.CodProCom,DATE_FORMAT(a.FecProCom,"%d/%m/%Y") AS FecProCom,b.CodCli,c.NumIdeFis as NumCifCli,c.NomCol as RazSocCli,a.EstProCom,a.RefProCom,(SELECT COUNT(DISTINCT(c.CodCli)) FROM T_Propuesta_Comercial_CUPs a LEFT JOIN T_PuntoSuministro b ON a.CodPunSum=b.CodPunSum LEFT JOIN T_Cliente c ON c.CodCli=b.CodCli WHERE CodProComCli=b.CodProComCli) AS CantCli,(SELECT COUNT(*) FROM T_Propuesta_Comercial_CUPs WHERE CodProComCli=b.CodProComCli) AS CantCups',false);
    $this->db->from('T_PropuestaComercial a');
    $this->db->join('T_Propuesta_Comercial_Clientes b','a.CodProCom=b.CodProCom',"left");
    $this->db->join('T_Colaborador c','b.CodCli=c.CodCol',"left");
    $this->db->where('a.TipProCom=3');
    $this->db->like('DATE_FORMAT(FecProCom,"%d/%m/%Y")',$SearchText);
    $this->db->where('a.TipProCom=3');
    $this->db->or_like('b.CodCli',$SearchText);
    $this->db->where('a.TipProCom=3');
    $this->db->or_like('c.NumIdeFis',$SearchText);
    $this->db->where('a.TipProCom=3');
    $this->db->or_like('c.NomCol',$SearchText);
    $this->db->where('a.TipProCom=3');
    $this->db->or_like('a.RefProCom',$SearchText);                
    $this->db->order_by('DATE_FORMAT(a.FecProCom,"%Y/%m/%d") DESC');              
    $query = $this->db->get(); 
    if($query->num_rows()>0)
        return $query->result();
    else
        return false;              
}    





///////////////////////////////////////////////// PARA PROPUESTA COMERCIAL END ////////////////////////////////////////////////
}

?>
