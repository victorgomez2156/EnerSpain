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
 <div ng-controller="Controlador_Consumo_Cups as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos_cups.CodConCup==undefined">Registrar Consumo del CUPs</h3>
            <h3 class="page-header" ng-show="vm.fdatos_cups.CodConCup>0">Actualizando Consumo del CUPs</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Consumo Cups</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">


    <div class="panel-body"> 

 
    	<div ng-show="vm.TVistaConCups==true">
      <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
        <div class="btn-group">
          <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><input type="checkbox" ng-model="vm.Cups"/> <b style="color:black;">CUPS</b></li>
            <li><input type="checkbox" ng-model="vm.Cups_Ser"/> <b style="color:black;">TIPO SUMINISTRO</b></li></li>
            <li><input type="checkbox" ng-model="vm.Cups_Tar"/> <b style="color:black;">TARIFA</b></li></li>
            <li><input type="checkbox" ng-model="vm.FecIniCon"/> <b style="color:black;">FECHA INICIO</b></li></li>
            <li><input type="checkbox" ng-model="vm.FecFinCon"/> <b style="color:black;">FECHA FIN</b></li></li>
            <li><input type="checkbox" ng-model="vm.ConCup"/> <b style="color:black;">CONSUMO</b></li></li>
            <!--li><input type="checkbox" ng-model="vm.EstConCup"/> <b style="color:black;">ESTATUS</b></li></li-->
            <li><input type="checkbox" ng-model="vm.Cups_Acc"/> <b style="color:black;">ACCI??N</b></li>
          </ul> 
        </div>                    
        <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
            <ul class="dropdown-menu">
              <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Gestionar_Consumo_Cups_Pdf/{{vm.ruta_reportes_pdf_consumo_cups}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
              <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Gestionar_Consumo_Cups_Excel/{{vm.ruta_reportes_excel_consumo_cups}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
            </ul>
        </div>
        <!--div class="btn-group">
          <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_cups" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
        </div-->
      </div>
    </div>
   </div>              
<div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
  <div class="t-0029">
   <form class="form-inline" role="form">
      <!--div class="form-group">
        <input type="text" class="form-control" ng-model="vm.filtrar_consumo_cups" minlength="1" placeholder="Escribe para filtrar...">
      </div-->                 
      <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Consumos CUPs" ng-disabled="vm.disabled_button_add==false" ng-click="vm.agregar_consumo_cups()"><i class="fa fa-plus-square"></i> </button>
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
                    <th ng-show="vm.Cups_Tar==true">TARIFA</th>
                    <th ng-show="vm.FecIniCon==true">FECHA INICIO</th>
                    <th ng-show="vm.FecFinCon==true">FECHA FIN</th>
                    <th ng-show="vm.ConCup==true">CONSUMO</th>
                    <!--th ng-show="vm.EstConCup==true"><i class="fa fa-archive"></i> ESTATUS</th-->       
                    <th ng-show="vm.Cups_Acc==true">ACCI??N</th>
                  </tr>
                  <tr ng-show="vm.TCups_Consumo.length==0"> 
                     <td colspan="8" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> No hay consumos registrados</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TCups_Consumo | filter:paginate | filter:vm.filtrar_consumo_cups" ng-class-odd="odd">                    
                    <td ng-show="vm.Cups==true">{{dato.CUPs}}</td>
                    <td ng-show="vm.Cups_Ser==true">{{dato.TipServ}}</td>
                    <td ng-show="vm.Cups_Tar==true">{{dato.NomTar}}</td>  
                    <td ng-show="vm.FecIniCon==true">{{dato.FecIniCon}}</td>  
                    <td ng-show="vm.FecFinCon==true">{{dato.FecFinCon}}</td>
                    <td ng-show="vm.ConCup==true">{{dato.ConCup}}</td>                   
                    <!--td ng-show="vm.EstConCup==true">
                      <span class="label label-info" ng-show="dato.EstConCup=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstConCup}}</span>
                      <span class="label label-danger" ng-show="dato.EstConCup=='DADO DE BAJA'"><i class="fa fa-ban"></i> {{dato.EstConCup}}</span>
                    </td-->
                    <td ng-show="vm.Cups_Acc==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_consumo_CUPs" name="opciones_consumo_CUPs" ng-model="vm.opciones_consumo_CUPs[$index]" ng-change="vm.validar_opcion_consumo_cups($index,vm.opciones_consumo_CUPs[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.Cups==true">CUPS</th>
                    <th ng-show="vm.Cups_Ser==true">TIPO SUMINISTRO</th>                                        
                    <th ng-show="vm.Cups_Tar==true">TARIFA</th>
                    <th ng-show="vm.FecIniCon==true">FECHA INICIO</th>
                    <th ng-show="vm.FecFinCon==true">FECHA FIN</th>
                    <th ng-show="vm.ConCup==true">CONSUMO</th>
                    <!--th ng-show="vm.EstConCup==true"><i class="fa fa-archive"></i> ESTATUS</th-->       
                    <th ng-show="vm.Cups_Acc==true">ACCI??N</th>
                </tfoot>
              </table>
        </div>
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_consumo_CUPs()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>
           <span class="store-qty"> <a href="#/Gestionar_Cups" title='Volver' class="btn btn-info"><div><i class="fa fa-arrow-circle-left" style="color:white;"></i></div></a> </span>       
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
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Bloqueo de Consumo CUPs</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="text" class="form-control" ng-model="vm.tmodal_data.CodConCup" readonly />
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
     <label class="font-weight-bold nexa-dark" style="color:black;">Raz??n Social</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCUPs"  readonly/>    
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Direcci??n de Suministro</label>
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
     <label class="font-weight-bold nexa-dark" style="color:black;">Observaci??n</label>
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





    </div><!--NG SHOWW FINAL-->

    <!--NG SHOWW FALSE START-->


<div ng-show="vm.TVistaConCups==false">
	
<form id="register_form" name="register_form" ng-submit="submitFormCups($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
       <input type="text" class="form-control" ng-model="vm.Cups_Cif" maxlength="9" readonly placeholder="* N??mero del CIF del Cliente"/>
       
       </div>
       </div>
       </div>       
       <div class="col-12 col-sm-8">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Raz??n Social</label>       
        <div class="input-append date">
          <input class="form-control" size="16" type="text" readonly ng-model="vm.Cups_RazSocCli" placeholder="* Raz??n Social del Cliente">      
      </div>
      
       </div>
       </div>
       </div>
        <br><br><br><br>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Direcci??n de Suministro</label>
       <input type="text" class="form-control" ng-model="vm.Cups_Dir" readonly maxlength="100"/>       
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CUPS </label>
       <input type="text" class="form-control" ng-model="vm.CUPs" readonly maxlength="2" ng-disabled=" vm.validate_info==1"/>
       </div>
       </div>
       </div>    

      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">  
       <label class="font-weight-bold nexa-dark" style="color:black;">TIPO SUMINISTRO</label>     
       <input type="text" class="form-control" ng-model="vm.TipServ" readonly maxlength="16" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>  
        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       	<label class="font-weight-bold nexa-dark" style="color:black;">TARIFA</label>
       <input type="text" class="form-control" ng-model="vm.NomTar" readonly maxlength="2" ng-disabled=" vm.validate_info==1"/>
       </div>
       </div>
       </div>      
      <div style="margin-top: 8px;">
       
<div ng-show="vm.fdatos_cups.TipServ==1">		
	


<div style="margin-top: 8px; margin-left: 15px; margin-bottom: -20px;" ng-show="vm.totalPot>0">
       <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"> Potencia Contratada (Kw)</label></div></div>

  <div ng-show="vm.totalPot==1"> 

    <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon1" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.PotCon1)"/>
       </div>
       </div>
       </div>

  </div>     

   <div ng-show="vm.totalPot==2"> 
  
  <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon1" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.PotCon1)"/>
       </div>
       </div>
       </div>

  <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon2" ng-disabled=" vm.validate_info==1" placeholder="P2" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.PotCon2)"/>
       </div>
       </div>
    </div>

  </div>     

<div ng-show="vm.totalPot==3"> 

 <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon1" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.PotCon1)"/>
       </div>
       </div>
       </div>

  <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon2" ng-disabled=" vm.validate_info==1" placeholder="P2" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.PotCon2)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon3" ng-disabled=" vm.validate_info==1" placeholder="P3" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.PotCon3)"/>
       </div>
       </div>
    </div>

  </div>     

<div ng-show="vm.totalPot==4"> 

<div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon1" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.PotCon1)"/>
       </div>
       </div>
       </div>

  <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon2" ng-disabled=" vm.validate_info==1" placeholder="P2" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.PotCon2)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon3" ng-disabled=" vm.validate_info==1" placeholder="P3" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.PotCon3)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon4" ng-disabled=" vm.validate_info==1" placeholder="P4" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotCon4)"/>
       </div>
       </div>
    </div>

</div>     

<div ng-show="vm.totalPot==5"> 

<div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon1" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.PotCon1)"/>
       </div>
       </div>
       </div>

  <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon2" ng-disabled=" vm.validate_info==1" placeholder="P2" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.PotCon2)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon3" ng-disabled=" vm.validate_info==1" placeholder="P3" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.PotCon3)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon4" ng-disabled=" vm.validate_info==1" placeholder="P4" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotCon4)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon5" ng-disabled=" vm.validate_info==1" placeholder="P5" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotCon5)"/>
       </div>
       </div>
    </div>

  </div>     
   
   <div ng-show="vm.totalPot==6"> 

<div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon1" ng-disabled=" vm.validate_info==1" placeholder="P1" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.PotCon1)"/>
       </div>
       </div>
       </div>

  <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon2" ng-disabled=" vm.validate_info==1" placeholder="P2" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.PotCon2)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon3" ng-disabled=" vm.validate_info==1" placeholder="P3" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.PotCon3)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon4" ng-disabled=" vm.validate_info==1" placeholder="P4" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotCon4)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon5" ng-disabled=" vm.validate_info==1" placeholder="P5" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotCon5)"/>
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotCon6" ng-disabled=" vm.validate_info==1" placeholder="P6" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotCon6)"/>
       </div>
       </div>
    </div>
  </div>     

	</div> 
 <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Desde <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control datepicker" ng-model="vm.fdatos_cups.FecIniCon" name="desde" id="desde" maxlength="10" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(7,vm.fdatos_cups.FecIniCon)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Hasta <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control datepicker2" ng-model="vm.fdatos_cups.FecFinCon" name="hasta" id="hasta" maxlength="10" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(8,vm.fdatos_cups.FecFinCon)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Consumo (Kw) <b style="color:red;">(*)</b></label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.ConCup" ng-disabled=" vm.validate_info==1" ng-change="vm.validar_fecha_inputs(9,vm.fdatos_cups.ConCup)"/>
       </div>
       </div>
       </div>

     

        <!--input type="text" class="form-control" ng-model="vm.fdatos_cups.CodConCupsEle" readonly /-->
        <input type="hidden" class="form-control" ng-model="vm.fdatos_cups.TipServAnt" readonly />
        <input type="hidden" class="form-control" ng-model="vm.fdatos_cups.CodConCup" readonly />
      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos_cups.CodConCup==undefined||vm.fdatos_cups.CodConCup==null||vm.fdatos_cups.CodConCup==''">CREAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_cups.CodConCup>0 && vm.validate_info==undefined">Actualizar</button>            
            <a class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_consumo_cups()">Volver</a>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>
</div>

    <!--NG SHOWW FALSE END-->


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
          Dise??ado Por<a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
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
         
      });
        $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

        $('#desde').on('changeDate', function() 
        {
           var desde=document.getElementById("desde").value;
           console.log("desde: "+desde);
        });
         $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

        $('#hasta').on('changeDate', function() 
        {
           var hasta=document.getElementById("hasta").value;
           console.log("hasta: "+hasta);
        });

        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</body>


<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Informaci??n"></div>

<div id="cargando" class="loader loader-default"  data-text="Cargando listado de Consumos del CUP"></div>
<div id="cargandos_cups" class="loader loader-default"  data-text="Cargando Informaci??n del CUP"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando CUP"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando CUP"></div>                 
 


</html>
