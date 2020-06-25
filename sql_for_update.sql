
UPDATE `T_PropuestaComercial` SET RefProCom=null;

UPDATE T_PropuestaComercial set CodCupsEle=null,CodTarEle=null,PotConP1=null,PotConP2=null,PotConP3=null,PotConP4=null,PotConP5=null,
PotConP6=null,ImpAhoEle=null,PorAhoEle=null,RenConEle=null,ObsAhoEle=null where CodCupsEle=0;

UPDATE T_PropuestaComercial set CodCupsGas=null,CodTarGas=null,Consumo=null,CauDia=null,ImpAhoGas=null,PorAhoGas=null,RenConGas=null,
ObsAhoGas=null where CodCupsGas=0;

UPDATE T_Contrato set FecBajCon=null,JusBajCon=null;