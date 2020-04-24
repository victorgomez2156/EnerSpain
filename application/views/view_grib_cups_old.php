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
</style>
<body>
 <div ng-controller="Controlador_Cups as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de CUPs</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Cups</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">


    <div class="panel-body"> 

  <div id="tabs_clientes" class="ui-tabs-nav ui-corner-all">
      <ul>
      <li>
        <a href="#tabs-1"><i class="fa fa-cube"></i> Cups</a>
      </li>      
     </ul>
    <!--/TABS 1 START-->
    <div id="tabs-1">  

    	<div ng-show="vm.TVistaCups==true">
      <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
        <div class="btn-group">
          <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><input type="checkbox" ng-model="vm.Cups"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CUPS</b></li>
            <li><input type="checkbox" ng-model="vm.Cups_Ser"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIPO SUMINISTRO</b></li></li>
            <li><input type="checkbox" ng-model="vm.Cups_Tar"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TARIFA</b></li></li>
            <li><input type="checkbox" ng-model="vm.EstCUPs"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ESTATUS</b></li></li>
            <li><input type="checkbox" ng-model="vm.Cups_Acc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
          </ul> 
        </div>                    
        <div class="btn-group">
          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
            <ul class="dropdown-menu">
              <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Gestionar_Cups_Pdf/{{vm.ruta_reportes_pdf_cups}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
              <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Gestionar_Cups_Excel/{{vm.ruta_reportes_excel_cups}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
            </ul>
        </div>
        <div class="btn-group">
          <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_cups" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
        </div>
      </div>
    </div>
   </div>              
<div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
  <div class="t-0029">
   <form class="form-inline" role="form">
      <div class="form-group">
        <input type="text" class="form-control" ng-model="vm.filtrar_cups" minlength="1" placeholder="Escribe para filtrar...">
      </div>                 
      <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Cups" ng-disabled="vm.disabled_button_add_punt==false" ng-click="vm.agregar_cups()"><i class="fa fa-plus-square"></i></button>
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
                    <th ng-show="vm.Cups==true">CUPS</th>
                    <th ng-show="vm.Cups_Ser==true">TIPO SUMINISTRO</th>                                                            
                    <th ng-show="vm.Cups_Tar==true"><i class="fa fa-archive"></i> TARIFA</th> 
                    <th ng-show="vm.EstCUPs==true"><i class="fa fa-archive"></i> ESTATUS</th>      
                    <th ng-show="vm.Cups_Acc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                  </tr>
                  <tr ng-show="vm.TCups.length==0"> 
                     <td colspan="14" align="center"><div class="td-usuario-table">No hay información disponible</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TCups | filter:paginate | filter:vm.filtrar_cups" ng-class-odd="odd">                    
                    <td ng-show="vm.Cups==true">{{dato.CupsGas}}</td>
                    <td ng-show="vm.Cups_Ser==true">{{dato.TipServ}}</td>
                    <td ng-show="vm.Cups_Tar==true">{{dato.NomTarGas}}</td> 
                    <td ng-show="vm.EstCUPs==true">
                      <span class="label label-info" ng-show="dato.EstCUPs=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstCUPs}}</span>
                      <span class="label label-danger" ng-show="dato.EstCUPs=='DADO DE BAJA'"><i class="fa fa-ban"></i> {{dato.EstCUPs}}</span>
                    </td>                   
                    <td ng-show="vm.Cups_Acc==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_cups" name="opciones_cups" ng-model="vm.opciones_cups[$index]" ng-change="vm.validar_opcion_cups($index,vm.opciones_cups[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.Cups==true">CUPS</th>
                    <th ng-show="vm.Cups_Ser==true">TIPO SUMINISTRO</th>                                                            
                    <th ng-show="vm.Cups_Tar==true"><i class="fa fa-archive"></i> TARIFA</th> 
                    <th ng-show="vm.EstCUPs==true"><i class="fa fa-archive"></i> ESTATUS</th>      
                    <th ng-show="vm.Cups_Acc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                </tfoot>
              </table>
        </div>
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_cups()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span> 

          <span class="store-qty"> <a href="#/Puntos_Suministros" title='Volver' class="btn btn-info"><div><i class="fa fa-arrow-circle-left" style="color:white;"></i></div></a> </span>      
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>



<!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de CUPs</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCUPs" readonly />
      <form class="form-validate" id="form_lock2" name="form_lock2" ng-submit="submitFormlockCUPs($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.NumCifCUPs"  readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCUPs"  readonly/>    
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Dirección de Suministro</label>
     <input type="text" class="form-control" ng-model="vm.DirPunSumCUPs"  readonly />     
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CUPs</label>
     <input type="text" class="form-control" ng-model="vm.CupsNom"  readonly/>    
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Suministro</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.TipServ"  readonly />     
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6">
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo de Baja</label>     
      <select class="form-control" name="MotBloq" required ng-model="vm.tmodal_data.MotBloq">
          <option ng-repeat="dato in vm.tMotivosBloqueos" value="{{dato.CodMotBloCUPs}}">{{dato.DesMotBloCUPs}}</option>
        </select>
      </div>
     </div>
    </div>

     <div class="col-12 col-sm-6">
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Baja</label>     
      <input type="text" class="form-control" ng-model="vm.tmodal_data.FecBaj" readonly />
      </div>
     </div>
    </div>



     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsMotCUPs" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock2.$invalid">Dar de Baja</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_cups" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosCUPs($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.tmodal_filtro.tipo_filtro">
          <option ng-repeat="dato in vm.Filtro_CUPs" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>    

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtro.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="TipServ" ng-model="vm.tmodal_filtro.TipServ">
        <option value="Gas">Gas</option>
        <option value="Eléctrico">Eléctrico</option>                        
      </select>   
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtro.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="tipo_tarifa" name="tipo_tarifa" ng-model="vm.tmodal_filtro.tipo_tarifa" ng-change="vm.buscar_tarifa()">
        <option value="Gas">Gas</option>
        <option value="Electrico">Eléctrico</option>                        
      </select>   
     </div>
     </div>
    </div>
<!--ng-show="vm.result_tar==true"-->
    <div class="col-12 col-sm-12" ng-show="vm.result_tar==true && vm.tmodal_filtro.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control"  name="NomTar" ng-model="vm.tmodal_filtro.NomTar" >
        <option ng-repeat="dato in vm.T_TarifasFiltros" value="{{dato.NomTar}}">{{dato.NomTar}}</option>                          
      </select>    
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtro.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstCUPs" name="EstCUPs" ng-model="vm.tmodal_filtro.EstCUPs">
        <option value="ACTIVO">ACTIVO</option> 
        <option value="DADO DE BAJA">DADO DE BAJA</option>                         
      </select>     
     </div> 
     </div>
     </div> 
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_cups()" ng-show="vm.tmodal_filtro.tipo_filtro>0">Quitar</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->




    </div><!--NG SHOWW FINAL-->






    <!--NG SHOWW FALSE START-->
    <div ng-show="vm.TVistaCups==false">
	
<form id="register_form" name="register_form" ng-submit="submitFormCups($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
       <input type="text" class="form-control" ng-model="vm.Cups_Cif" maxlength="9" readonly placeholder="* Número del CIF del Cliente"/>
       
       </div>
       </div>
       </div>       
       <div class="col-12 col-sm-8">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>       
        <div class="input-append date">
          <input class="form-control" size="16" type="text" readonly ng-model="vm.Cups_RazSocCli" placeholder="* Razón Social del Cliente">      
      </div>
      
       </div>
       </div>
       </div>
        <br><br><br><br>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Dirección de Suministro</label>
       <input type="text" class="form-control" ng-model="vm.Cups_Dir" onkeyup="this.value=this.value.toUpperCase();" readonly maxlength="100"/>       
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CUPS <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.cups" onkeyup="this.value=this.value.toUpperCase();" placeholder="* ES" maxlength="2" ng-disabled=" vm.validate_info==1"/>
       </div>
       </div>
       </div>    

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">  
       <label class="font-weight-bold nexa-dark" style="color:white;">.</label>     
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.cups1" onkeyup="this.value=this.value.toUpperCase();" maxlength="16" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>  
        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:white;">.</label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.cups2" onkeyup="this.value=this.value.toUpperCase();" maxlength="2" ng-disabled=" vm.validate_info==1"/>
       </div>
       </div>
       </div>      
      <div style="margin-top: 8px;">
       <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO SUMINISTRO</b></label></div></div>
      
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Eléctrico</label>
       <input type="radio" ng-model="vm.fdatos_cups.TipServ" ng-disabled=" vm.validate_info==1" value="1" ng-click="vm.por_servicios(vm.fdatos_cups.TipServ)"/>
       <label class="font-weight-bold nexa-dark" style="color:black;">Gas</label>
       <input type="radio" ng-model="vm.fdatos_cups.TipServ" ng-disabled=" vm.validate_info==1" value="2" ng-click="vm.por_servicios(vm.fdatos_cups.TipServ)"/>
       </div>
       </div>
       </div>

     <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Distribuidora <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodDis" name="CodDis"  ng-model="vm.fdatos_cups.CodDis" ng-disabled="vm.fdatos_cups.TipServ==0 || vm.validate_info==1||vm.sin_data==1">
        <option ng-repeat="dato in vm.T_Distribuidoras" value="{{dato.CodDist}}">{{dato.NumCifDis}} - {{dato.RazSocDis}}</option>                          
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodTar" name="CodTar"  ng-model="vm.fdatos_cups.CodTar" ng-disabled="vm.fdatos_cups.TipServ==0|| vm.validate_info==1||vm.sin_data==1">
        <option ng-repeat="dato in vm.T_Tarifas" value="{{dato.CodTar}}">{{dato.NomTar}}</option>                          
        </select>
       </div>
       </div>
       </div>


<div ng-show="vm.fdatos_cups.TipServ==1">		
	<div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:black;">Potencia </label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div>


	<div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:black;"> Contratada </label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
       </div>
       </div>
    </div>

       <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:black;">  (Kw)</label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP3" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" placeholder="P3" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotConP3)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:white;">.</label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP4" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" placeholder="P4" ng-change="vm.validar_fecha_inputs(7,vm.fdatos_cups.PotConP4)"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:white;">.</label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP5" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" placeholder="P5" ng-change="vm.validar_fecha_inputs(8,vm.fdatos_cups.PotConP5)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:white;">.</label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP6" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" placeholder="P6" ng-change="vm.validar_fecha_inputs(9,vm.fdatos_cups.PotConP6)"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE <b style="color:red;">(*)</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Alta <b style="color:red;">DD/MM/YYYY</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.FecAltCup" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.FecAltCup)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Fecha Última Lectura <b style="color:red;">DD/MM/YYYY</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.FecUltLec" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.FecUltLec)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Consumo (Kw) <b style="color:red;">(*)</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.ConAnuCup" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.ConAnuCup)"/>
       </div>
       </div>
       </div>
	</div> 

	<div ng-show="vm.fdatos_cups.TipServ==2">		
	     <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Alta <b style="color:red;">DD/MM/YYYY</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.FecAltCup" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.FecAltCup)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Fecha Última Lectura <b style="color:red;">DD/MM/YYYY</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.FecUltLec" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.FecUltLec)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">       	
       	<label class="font-weight-bold nexa-dark" style="color:black;">Consumo (kWh) <b style="color:red;">(*)</b></label>
       	<input type="text" class="form-control" ng-model="vm.fdatos_cups.ConAnuCup" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.ConAnuCup)" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info==1"/>
       </div>
       </div>
       </div>
	</div>
  <input type="text" class="form-control" ng-model="vm.fdatos_cups.CodCup" readonly />      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos_cups.CodCup==undefined||vm.fdatos_cups.CodCup==null||vm.fdatos_cups.CodCup==''" >CREAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_cups.CodCup>0">Actualizar</button>            
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_cups()">Volver</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>
</div>

    <!--NG SHOWW FALSE END-->


    <div ng-show="vm.TVistaCups==undefined">
      


<form id="historial_form" name="historial_form" ng-submit="submitFormHistorial($event)"> 
 <input type="hidden" class="form-control" ng-model="vm.historial.CodCup" readonly />
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Desde <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control" ng-model="vm.historial.desde" required="required" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.validar_fecha_inputs(20,vm.historial.desde)" maxlength="10" />
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Hasta <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control" ng-model="vm.historial.hasta" required="required" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.validar_fecha_inputs(21,vm.historial.hasta)" maxlength="10" />
       </div>
       </div>
       </div>
     <div align="center" >
          
            <button class="btn btn-info" type="submit" ng-disabled="historial_form.$invalid">Consultar</button>       
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_cups()">Volver</button>
         
        </div>
</form> 
<div ng-show="vm.result_his==true">
<div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.PotCon1==true">PotCon1</th>
                    <th ng-show="vm.PotCon2==true">PotCon2</th>                                        
                    <th ng-show="vm.PotCon3==true">PotCon3</th>
                    <th ng-show="vm.PotCon4==true">PotCon4</th>
                    <th ng-show="vm.PotCon5==true">PotCon5</th>
                    <th ng-show="vm.PotCon6==true">PotCon6</th>
                    <th ng-show="vm.FecIniConHis==true"><i class="fa fa-calendar"></i> Fecha Inicio</th>
                    <th ng-show="vm.FecFinConHis==true"><i class="fa fa-calendar"></i> Fecha Final</th>
                    <th ng-show="vm.ConCupHis==true">Consumo</th>
                  </tr>
                  <tr ng-show="vm.T_Historial_Consumo.length==0"> 
                     <td colspan="9" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> No ahi datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.T_Historial_Consumo | filter:paginate1250" ng-class-odd="odd">                    
                    <td ng-show="vm.PotCon1==true">{{dato.PotCon1}}</td>
                    <td ng-show="vm.PotCon2==true">{{dato.PotCon2}}</td>
                    <td ng-show="vm.PotCon3==true">{{dato.PotCon3}}</td>
                    <td ng-show="vm.PotCon4==true">{{dato.PotCon4}}</td>  
                    <td ng-show="vm.PotCon5==true">{{dato.PotCon5}}</td>  
                    <td ng-show="vm.PotCon6==true">{{dato.PotCon6}}</td>
                    <td ng-show="vm.FecIniConHis==true">{{dato.FecIniCon}}</td>
                    <td ng-show="vm.FecFinConHis==true">{{dato.FecFinCon}}</td>
                    <td ng-show="vm.ConCupHis==true">{{dato.ConCup}}</td>
                  </tr>
                  <tr>                    
                    <td><b>Total Consumo:</b> </td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td></td>
                    <td>{{vm.Total_Consumo}}</td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.PotCon1==true">PotCon1</th>
                    <th ng-show="vm.PotCon2==true">PotCon2</th>                                        
                    <th ng-show="vm.PotCon3==true">PotCon3</th>
                    <th ng-show="vm.PotCon4==true">PotCon4</th>
                    <th ng-show="vm.PotCon5==true">PotCon5</th>
                    <th ng-show="vm.PotCon6==true">PotCon6</th>
                    <th ng-show="vm.FecIniConHis==true"><i class="fa fa-calendar"></i> Fecha Inicio</th>
                    <th ng-show="vm.FecFinConHis==true"><i class="fa fa-calendar"></i> Fecha Final</th>
                    <th ng-show="vm.ConCupHis==true">Consumo</th>
                </tfoot>
              </table>               
        </div>
        
        <div align="center">
          <span class="store-qty"> <a href="reportes/Exportar_Documentos/Historial_Consumo_CUPs_PDF/{{vm.desde}}/{{vm.hasta}}/{{vm.CodCup}}/{{vm.historial.TipServ}}" target="_black" title='Descargar PDF' class="btn btn-info"><div><i class="fa fa-file" style="color:white;"></i></div></a> </span>
           <span class="store-qty"> <a href="reportes/Exportar_Documentos/Historial_Consumo_CUPs_Excel/{{vm.desde}}/{{vm.hasta}}/{{vm.CodCup}}/{{vm.historial.TipServ}}" target="_black" title='Descargar EXCEL' class="btn btn-info"><div><i class="fa fa-file-excel-o" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
</div>

















</div>
    <!--/TABS 1 FINAL-->


   </div>
 </div>
       
        



        <!--/section-->
        </div>
        </div>
        <!-- page end-->
      </section>
      <!--wrappen end-->
    </section>
    <!--main content end-->
     <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>

</div>
 <script>
      $(function(){
        'use strict'

        // Input Masks
        //$('#FecIniAct').mask('99/99/9999');
        //$('#FecIniActFil').mask('99-99-9999');
        jQuery(function($) 
        {      
          //jquery tabs
          $( "#tabs_clientes" ).tabs(); 
          $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            //mixDate: "<?php echo date("m/d/Y")?>"
            //maxDate: "<?php echo date("m/d/Y")?>"
        });
      });

        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</body>


<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>

<div id="cargando" class="loader loader-default"  data-text="Cargando listado de CUPs"></div>
<div id="cargandos_cups" class="loader loader-default"  data-text="Cargando Información del CUP"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando CUP"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando CUP"></div>                 
<div id="Baja" class="loader loader-default"  data-text="Dando de Baja CUP"></div>   
<div id="Generar_Consumo" class="loader loader-default"  data-text="Generando Historial de Consumo"></div> 

</html>
