<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *"); 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<style>
  #sinborde {
    border: 0;
  background: inherit;
  background-color:transparent;
  width: 120px;
  }
  #sinbordeAJUST {
    border: 0;
  background: inherit;
  background-color:transparent;
  }
  .table-responsive {
    min-height: .01%;
    overflow-x: auto
}

@media screen and (max-width:767px) {
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd
    }

    .table-responsive > .table {
        margin-bottom: 0
    }

    .table-responsive > .table > tbody > tr > td, .table-responsive > .table > tbody > tr > th,
    .table-responsive > .table > tfoot > tr > td, .table-responsive > .table > tfoot > tr > th,
    .table-responsive > .table > thead > tr > td, .table-responsive > .table > thead > tr > th {
        white-space: nowrap
    }

    .table-responsive > .table-bordered {
        border: 0
    }

    .table-responsive > .table-bordered > tbody > tr > td:first-child, .table-responsive > .table-bordered > tbody > tr > th:first-child,
    .table-responsive > .table-bordered > tfoot > tr > td:first-child, .table-responsive > .table-bordered > tfoot > tr > th:first-child,
    .table-responsive > .table-bordered > thead > tr > td:first-child, .table-responsive > .table-bordered > thead > tr > th:first-child {
        border-left: 0
    }

    .table-responsive > .table-bordered > tbody > tr > td:last-child, .table-responsive > .table-bordered > tbody > tr > th:last-child,
    .table-responsive > .table-bordered > tfoot > tr > td:last-child, .table-responsive > .table-bordered > tfoot > tr > th:last-child,
    .table-responsive > .table-bordered > thead > tr > td:last-child, .table-responsive > .table-bordered > thead > tr > th:last-child {
        border-right: 0
    }

    .table-responsive > .table-bordered > tbody > tr:last-child > td, .table-responsive > .table-bordered > tbody > tr:last-child > th,
    .table-responsive > .table-bordered > tfoot > tr:last-child > td, .table-responsive > .table-bordered > tfoot > tr:last-child > th {
        border-bottom: 0
    }
}
.datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Anexos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bullseye"></i> Anexos</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bullseye"></i>Anexos</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">
              <div id="t-0002">
      <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
        <div class="t-0029">
            <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.NumCifCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                        <li><input type="checkbox" ng-model="vm.RazSocCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Razón Social</b></li>
                        <li><input type="checkbox" ng-model="vm.CodAneTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Producto</b></li></li>
                        <li><input type="checkbox" ng-model="vm.DesAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Descripción Anexo</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerGasAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Servicio Gas</b></li>
                        <li><input type="checkbox" ng-model="vm.SerTEleAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Servicio Eléctrico</b></li>
                        <li><input type="checkbox" ng-model="vm.TipPreAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Precio</b></li>
                        <li><input type="checkbox" ng-model="vm.CodTipComAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Comisión</b></li>
                        <li><input type="checkbox" ng-model="vm.ObsAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Observación</b></li>
                        <li><input type="checkbox" ng-model="vm.FecIniAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Fecha de Inicio</b></li>   <li><input type="checkbox" ng-model="vm.EstAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Accion</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Anexos/{{vm.reporte_pdf_anexos}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Anexos/{{vm.reporte_excel_anexos}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtrar Productos' data-target="#modal_filtros_anexos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
          </div>
        </div>
    </div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_anexos" minlength="1" id="exampleInputEmail22" placeholder="Escribe para filtrar...">
                    </div>                 
                    <a style="margin-right: 10px;" class="btn btn-info" title="Agregar Anexos" href="#/Add_Anexos"><i class="fa fa-plus-square"></i></a>
                  </form>                    
                  </div>
            </div>
  </div>  
<!--t-0002 end--> 
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.NumCifCom==true"><i class="icon_cogs"></i> CIF</th>
                    <th ng-show="vm.RazSocCom==true"><i class="icon_cogs"></i> Razón Social</th>
                    <th ng-show="vm.CodAneTPro==true"><i class="icon_cogs"></i> Producto</th>
                    <th ng-show="vm.DesAnePro==true"><i class="icon_cogs"></i> Anexos</th>
                    <th ng-show="vm.SerGasAne==true"><i class="icon_cogs"></i> Ser. Gas</th>
                    <th ng-show="vm.SerTEleAne==true"><i class="icon_cogs"></i> Ser. Eléctrico</th>
                    <th ng-show="vm.TipPreAne==true"><i class="icon_cogs"></i> Tipo Precio</th>
                    <th ng-show="vm.CodTipComAne==true"><i class="icon_cogs"></i> Tipo Comisión</th>
                    <th ng-show="vm.ObsAnePro==true"><i class="icon_cogs"></i> Observación</th>
                    <th ng-show="vm.FecIniAne==true"><i class="icon_cogs"></i> Fecha Inicio</th>
                    <th ng-show="vm.EstAne==true"><i class="icon_cogs"></i> Estatus</th>
                    <th ng-show="vm.AccTAne==true"><i class="icon_cogs"></i> Acción</th>
                  </tr> 
                  <tr ng-show="vm.TAnexos.length==0"> 
                    <td colspan="12" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TAnexos | filter:paginate2 | filter:vm.filtrar_anexos" ng-class-odd="odd">                    
                    <td ng-show="vm.NumCifCom==true">{{dato.NumCifCom}}</td>
                    <td ng-show="vm.RazSocCom==true">{{dato.RazSocCom}}</td>
                    <td ng-show="vm.CodAneTPro==true">{{dato.DesPro}}</td>                  
                    <td ng-show="vm.DesAnePro==true">{{dato.DesAnePro}}</td>
                    <td ng-show="vm.SerGasAne==true">{{dato.SerGas}}</td>
                    <td ng-show="vm.SerTEleAne==true">{{dato.SerEle}}</td>
                    <td ng-show="vm.TipPreAne==true">{{dato.TipPre}}</td>
                    <td ng-show="vm.CodTipComAne==true">{{dato.DesTipCom}}</td>
                    <td ng-show="vm.ObsAnePro==true">{{dato.ObsAnePro}}</td>
                    <td ng-show="vm.FecIniAne==true">{{dato.FecIniAne}}</td>
                    
                    
                    <td ng-show="vm.EstAne==true">
                      <span class="label label-info" ng-show="dato.EstAne=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstAne}}</span>
                      <span class="label label-danger" ng-show="dato.EstAne=='BLOQUEADO'"><i class="fa fa-ban"></i> {{dato.EstAne}}</span>
                    </td>
                    <td ng-show="vm.AccTAne==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_anexos" name="opciones_anexos" ng-model="vm.opciones_anexos[$index]" ng-change="vm.validar_opcion_anexos($index,vm.opciones_anexos[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>
                     <th ng-show="vm.NumCifCom==true"><i class="icon_cogs"></i> CIF</th>
                    <th ng-show="vm.RazSocCom==true"><i class="icon_cogs"></i> Razón Social</th>
                    <th ng-show="vm.CodAneTPro==true"><i class="icon_cogs"></i> Producto</th>
                    <th ng-show="vm.DesAnePro==true"><i class="icon_cogs"></i> Anexos</th>
                    <th ng-show="vm.SerGasAne==true"><i class="icon_cogs"></i> Ser. Gas</th>
                    <th ng-show="vm.SerTEleAne==true"><i class="icon_cogs"></i> Ser. Eléctrico</th>
                    <th ng-show="vm.TipPreAne==true"><i class="icon_cogs"></i> Tipo Precio</th>
                    <th ng-show="vm.CodTipComAne==true"><i class="icon_cogs"></i> Tipo Comisión</th>
                    <th ng-show="vm.ObsAnePro==true"><i class="icon_cogs"></i> Observación</th>
                    <th ng-show="vm.FecIniAne==true"><i class="icon_cogs"></i> Fecha Inicio</th>
                    <th ng-show="vm.EstAne==true"><i class="icon_cogs"></i> Estatus</th>
                    <th ng-show="vm.AccTAne==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
          <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_anexos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>

    <div ng-show="vm.comisiones==true">

      <div align="center"><label class="font-weight-bold nexa-dark" style="color:#394a59;"><b>COMISIONES</b></label></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
        <input type="text" name="CIFComision" id="CIFComision" class="form-control" ng-model="vm.CIFComision" readonly="readonly">       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
        <input type="text" name="ComerComision" id="ComerComision" class="form-control" ng-model="vm.ComerComision" readonly="readonly">     
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Producto <b style="color:red;">(*)</b></label>
        <input type="text" name="ProComision" id="ProComision" class="form-control" ng-model="vm.ProComision" readonly="readonly">     
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Anexo <b style="color:red;">(*)</b></label>
        <input type="text" name="AneComision" id="AneComision" class="form-control" ng-model="vm.AneComision" readonly="readonly">     
       </div>
       </div>
       </div>
       <br>
           
           <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th><i class="fa fa-arrow-down"></i></th>
                    <th><i class="fa fa-arrow-down"></i> Tipo de Servicio</th>
                    <th><i class="fa fa-arrow-down"></i> Tipo de Precio</th>
                    <th><i class="fa fa-arrow-down"></i> Tarifa</th>
                  </tr> 
                  <tr ng-show="vm.TComisionesDet.length==0"> 
                    <td colspan="4" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TComisionesDet | filter:paginate3" ng-class-odd="odd">                    
                    <td>
                      <button type="button"  ng-click="vm.agregar_detalle_comision($index,dato.CodDetAneTarEle,dato)" title="Agregar {{dato.NomTarEle}}" ng-show="!vm.select_det_com[dato.CodDetAneTarEle]"><i class="fa fa fa-square-o" title="Agregar {{dato.NomTarEle}}" style="color:black;"></i></button>                        

                        <button type="button" ng-show="vm.select_det_com[dato.CodDetAneTarEle]" ng-click="vm.quitar_detalle_comision($index,dato.CodDetAneTarEle,dato)"><i class="fa fa fa-check-circle" title="Quitar {{dato.NomTarEle}}" style="color:green;"></i></button>



                      <!--input type="checkbox" name="checkbox" id="checkbox" ng-model="vm.TComisionesDet.checkbox[$index]" ng-click="vm.agregar_detalle_comision(vm.TComisionesDet.checkbox[$index],$index,dato)"--></td>
                    <td>{{dato.TipServ}}</td>
                    <td>{{dato.TipPre}}</td>                  
                    <td>{{dato.NomTarEle}}</td>
                  </tr>
                </tbody>
                <tfoot>
                    <th><i class="fa fa-arrow-up"></i></th>
                    <th><i class="fa fa-arrow-up"></i> Tipo de Servicio</th>
                    <th><i class="fa fa-arrow-up"></i> Tipo de Precio</th>
                    <th><i class="fa fa-arrow-up"></i> Tarifa</th>
                </tfoot>
              </table>
        <div align="center">
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>

<br>  

   <div align="right" style="margin-right: 50px;">
         <span class="store-qty"> <a title='Quitar' class="btn btn-info"><div><i class="fa fa-minus-square" style="color:white;"></i></div></a></span>
         <span class="store-qty"> <a title='Agregar' ng-click="vm.agregardetalle()" class="btn btn-info"><div><i class="fa fa-plus" style="color:white;"></i></div></a></span>
        </div> <br>
        <div class="table-responsive">
        <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th><i class="fa fa-arrow-down"></i>Rango de Consumo</th>
                    <th><i class="fa fa-arrow-down"></i> Consumo Mínimo Anual</th>
                    <th><i class="fa fa-arrow-down"></i> Consumo Máximo Anual</th>
                    <th><i class="fa fa-arrow-down"></i> Comisión Servicio</th>
                    <th><i class="fa fa-arrow-down"></i> Comisión Certificado Verde</th>
                  </tr> 
                  <tr ng-show="vm.TComisionesRangoGrib.length==0"> 
                    <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TComisionesRangoGrib | filter:paginate4" ng-class-odd="odd">                    
                    <td><input type="text" name="RanConsu" id="RanConsu[$index]" ng-model="vm.TComisionesRangoGrib[$index].RanConsu"></td>
                    <td><input type="text" name="ConMinAn" id="ConMinAn[$index]" ng-model="vm.TComisionesRangoGrib[$index].ConMinAn"></td>
                    <td><input type="text" name="ConMaxAn" id="ConMaxAn[$index]" ng-model="vm.TComisionesRangoGrib[$index].ConMaxAn"></td>                  
                    <td><input type="text" name="ConServ" id="ConServ[$index]" ng-model="vm.TComisionesRangoGrib[$index].ConServ"></td>
                    <td><input type="text" name="ConCerVer" id="ConCerVer[$index]" ng-model="vm.TComisionesRangoGrib[$index].ConCerVer"></td>
                  </tr>
                </tbody>
                <tfoot>
                    <th><i class="fa fa-arrow-up"></i>Rango de Consumo</th>
                    <th><i class="fa fa-arrow-up"></i> Consumo Mínimo Anual</th>
                    <th><i class="fa fa-arrow-up"></i> Consumo Máximo Anual</th>
                    <th><i class="fa fa-arrow-up"></i> Comisión Servicio</th>
                    <th><i class="fa fa-arrow-up"></i> Comisión Certificado Verde</th>
                </tfoot>
              </table></div>


               <div class="form-group" >
          <div align="right">
            <button class="btn btn-info" ng-click="vm.datos_finales()" ><i class="fa fa-save"></i> GUARDAR</button>           
            <button class="btn btn-primary" type="button" style="margin-top: 10px;"><i class="fa fa-arrow-left"></i> REGRESAR</button>
          </div>
        </div>


        <div align="center">
          <div class='btn-group' align="center">
            <pagination total-items="totalItems4" ng-model="currentPage4" max-size="5" boundary-links="true" items-per-page="numPerPage4" class="pagination-sm">  
            </pagination>
          </div>
        </div>








        </div>
 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_anexos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroAnexos" name="frmfiltroAnexos" ng-submit="SubmitFormFiltrosAnexos($event)">                 
 
      <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="ttipofiltrosAnexos" name="ttipofiltrosAnexos" required ng-model="vm.tmodal_anexos.ttipofiltrosAnexos">
          <option ng-repeat="dato in vm.ttipofiltrosAnexos" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodCom" ng-model="vm.tmodal_anexos.CodCom">
        <option ng-repeat="dato in vm.Tcomercializadoras | orderBy:'+RazSocCom'" value="{{dato.NumCifCom}}">{{dato.NumCifCom}} - {{dato.RazSocCom}}</option>                        
      </select>   
     </div>
     </div>
    </div> 

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="DesPro" name="DesPro" ng-model="vm.tmodal_anexos.DesPro">
        <option ng-repeat="dato in vm.TProductos| orderBy:'+DesPro'" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==3">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipServ3" name="TipServ" ng-model="vm.tmodal_anexos.TipServ">
        <option value="1">SERVICIO GAS</option>
        <option value="2">SERVICIO ELÉCTRICO</option> 
        <!--option value="3">AMBOS</option-->                         
      </select>   
     </div>
     </div>
    </div> 
     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==3 && vm.tmodal_anexos.TipServ!=undefined">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="Select1" name="Select" ng-model="vm.tmodal_anexos.Select">
        <option value="SI">SI</option>
        <option value="NO">NO</option> 
        <!--option value="3">AMBOS</option-->                         
      </select>   
     </div>
     </div>
    </div> 
    
    <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==4">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="DesTipCom1" name="DesTipCom" ng-model="vm.tmodal_anexos.DesTipCom">
        <option ng-repeat="dato in vm.Tipos_Comision| orderBy:'+DesTipCom'" value="{{dato.DesTipCom}}">{{dato.DesTipCom}}</option>                        
      </select>   
     </div>
     </div>
    </div> 

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==5">
     <div class="form">                          
     <div class="form-group">     
      
      <input type="text" name="FecIniAne" id="FecIniAne" class="form-control datepicker" ng-model="vm.tmodal_anexos.FecIniAne" placeholder="EJ: DD/MM/YYYY" ng-change="vm.validarsifechaanexos(vm.tmodal_anexos.FecIniAne,1)" maxlength="10">  


     </div>
     </div>
    </div> 

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==6">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="EstAne" name="EstAne" ng-model="vm.tmodal_anexos.EstAne">
        <option value="ACTIVO">ACTIVO</option>
        <option value="BLOQUEADO">BLOQUEADO</option>                          
      </select>   
     </div>
     </div>
    </div> 

    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroAnexos.$invalid"><i class="fa fa-check-circle"></i> APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.quitar_filtro_anexos()" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos>0"><i class="fa fa-trash"></i> LIMPIAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_anexos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> Bloqueo de Anexos</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
    <input type="hidden" class="form-control" ng-model="vm.anexos_motivo_bloqueos.CodAnePro" required readonly />
      <form class="form-validate" id="form_lock_Anexos" name="form_lock_Anexos" ng-submit="submitFormlockAnexos($event)">                 
     
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">COMERCIALIZADORA</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCom_BloAne" required readonly/>     
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">PRODUCTO</label>
      <input type="text" class="form-control" ng-model="vm.DesPro_BloAne" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">ANEXO</label>
      <input type="text" class="form-control" ng-model="vm.DesAnePro_BloAne" required readonly />     
     </div>
     </div>
<div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">MOTIVO DEL BLOQUEO</label>
       <input type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.MotBloAne" required/> 
     </div>
     </div>
    
</div>
    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control datepicker2" id="FecBloAne" name="FecBloAne" ng-model="vm.FecBloAne" required maxlength="10" ng-change="vm.validarsifechaanexos(vm.FecBloAne,2)" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.ObsMotBloAne" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_Anexos.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->


<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniAne').on('changeDate', function() 
  {
     var FecIniAne=document.getElementById("FecIniAne").value;
     console.log("FecIniAne: "+FecIniAne);
  });

  $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecBloAne').on('changeDate', function() 
  {
     var FecBloAne=document.getElementById("FecBloAne").value;
     console.log("FecBloAne: "+FecBloAne);
  });

</script>


</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Datos del Modulo, Por Favor Espere..."></div>
<div id="List_Anex" class="loader loader-default"  data-text="Cargando lista de Anexos, Por Favor Espere..."></div>
<div id="Car_Det" class="loader loader-default"  data-text="Cargando Detalles, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Cliente, Por Favor Espere..."></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere..."></div>

</html>
