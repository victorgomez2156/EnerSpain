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
 <div ng-controller="Controlador_Motivos_Bloqueos as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Motivos de Bloqueo</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-ban"></i>Motivos Bloqueos</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">

                <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading" style="color:black;">
                <!--<b>MOTIVOS DE BLOQUEO</b>-->
              </header>
              <div class="panel-body">              
             

<div id="tabs_clientes" class="ui-tabs-nav ui-corner-all">
    <ul >
      <li>
        <a href="#tabs-1">CLIENTE</a>
      </li>       
      <li>
        <a href="#tabs-2">ACTIVIDAD</a>
      </li>
      <li>
        <a href="#tabs-3">DIRECCIÓN DE SUMINISTRO</a>
      </li>
      <li>
        <a href="#tabs-4">CONTACTO</a>
      </li>
       <li>
        <a href="#tabs-5">COMERCIALIZADORA</a>
      </li>    
      <li>
        <a href="#tabs-6">CUPS</a>
      </li>
    </ul>

    <!--INICIO TABS 1 MOTIVO BLOQUEO CLIENTE -->
  <div id="tabs-1"> 
    
    <!--INICIO DIV NG-SHOW TVistaMotCliente 1-->
    <div ng-show="vm.TVistaMotCliente==1">
      <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesMotBloCli"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsMotBloCli"/> <b style="color:black;">Observación</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AccMotBloCli"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Motivo_Bloqueo_Cliente/{{vm.ruta_reportes_pdf_bloqueo_cliente}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Motivo_Bloqueo_Cliente/{{vm.ruta_reportes_excel_bloqueo_cliente}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_bloqueo_cliente" minlength="1" id="exampleInputEmail" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Bloqueo Cliente" ng-click="vm.agg_bloqueo_cliente()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div><!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivos_clientes()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesMotBloCli==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCli==true">Observación</th>   
                    <th ng-show="vm.AccMotBloCli==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TMotivo_BloCliente.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TMotivo_BloCliente | filter:paginate | filter:vm.filtrar_bloqueo_cliente" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesMotBloCli==true">{{dato.DesMotBloCli}}</td>
                     <td ng-show="vm.ObsMotBloCli==true">{{dato.ObsMotBloCli}}</td>
                    <td ng-show="vm.AccMotBloCli==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_motivo_cliente" name="opciones_clientes" ng-model="vm.opciones_motivo_cliente[$index]" ng-change="vm.validar_opcion_MotBloCli($index,vm.opciones_motivo_cliente[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesMotBloCli==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCli==true">Observación</th>   
                    <th ng-show="vm.AccMotBloCli==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivos_clientes()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
    </div>
    <!--FINAL DIV NG-SHOW TVistaMotCliente 1-->


    <!--INICIO DIV NG-SHOW TVistaMotCliente 2-->
    <div ng-show="vm.TVistaMotCliente==2">

      <form class="form-validate form-horizontal " id="form_bloqueo_clientes" name="form_bloqueo_clientes" ng-submit="submitFormMotClientes($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción<span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesMotBloCli" name="DesMotBloCli" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_mot_clientes.DesMotBloCli" ng-disabled="vm.validate_mot_bloqueo_cliente==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsMotBloCli" name="ObsMotBloCli" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_mot_clientes.ObsMotBloCli" ng-disabled="vm.validate_mot_bloqueo_cliente==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_mot_clientes.CodMotBloCli==undefined||vm.fdatos_mot_clientes.CodMotBloCli==null||vm.fdatos_mot_clientes.CodMotBloCli==''" ng-disabled="form_bloqueo_clientes.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_mot_clientes.CodMotBloCli>0 && vm.validate_mot_bloqueo_cliente==undefined" ng-disabled="form_bloqueo_clientes.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_bloqueo_cliente()" ng-show="vm.fdatos_mot_clientes.CodMotBloCli>0 && vm.validate_mot_bloqueo_cliente==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_bloqueo_cliente()" ng-show="vm.fdatos_mot_clientes.CodMotBloCli==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_bloqueo_cliente()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodMotBloCli" name="CodMotBloCli" type="hidden" ng-model="vm.fdatos_mot_clientes.CodMotBloCli" readonly />
      </form>
    </div>
    <!--FINAL DIV NG-SHOW TVISTACLIENTE 2-->
           
  </div>
  <!--FINAL TABS 1 MOTIVO BLOQUEO CLIENTE -->

    <!--INICIO TABS 2 MOTIVO BLOQUEO ACTIVIDAD-->
    <div id="tabs-2">
    
    <!--INICIO DIV NG-SHOW TVistaMotBloAct 1-->
    <div ng-show="vm.TVistaMotBloAct==1">
<!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesMotBloAct"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsMotBloAct"/> <b style="color:black;">Observación</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AcctMotBloAct"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Motivo_Bloqueo_Actividad/{{vm.ruta_reportes_pdf_MotBloAct}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Motivo_Bloqueo_Actividad/{{vm.ruta_reportes_excel_MotBloAct}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_actividad" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Motivo Actividad" ng-click="vm.agg_bloqueo_actividad()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivos_actividades()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesMotBloAct==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloAct==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloAct==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TMotivo_BloActividad.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TMotivo_BloActividad | filter:paginate2 | filter:vm.filtrar_actividad" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesMotBloAct==true">{{dato.DesMotBloAct}}</td>
                     <td ng-show="vm.ObsMotBloAct==true">{{dato.ObsMotBloAct}}</td>
                    <td ng-show="vm.AcctMotBloAct==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_actividad" name="opciones_actividad" ng-model="vm.opciones_actividad[$index]" ng-change="vm.validar_opcion_activadad($index,vm.opciones_actividad[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesMotBloAct==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloAct==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloAct==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivos_actividades()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>

    </div>
    <!--FINAL DIV NG-SHOW TVistaMotBloAct 1-->



    <!--INICIO DIV NG-SHOW TVistaMotBloAct 2-->
    <div ng-show="vm.TVistaMotBloAct==2">
      <form class="form-validate form-horizontal " id="form_bloqueo_actividad" name="form_bloqueo_actividad" ng-submit="submitFormActividad($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción<span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesMotBloAct" name="DesMotBloAct" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_mot_actividad.DesMotBloAct" ng-disabled="vm.validate_mot_bloqueo_actividad==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsMotBloAct" name="ObsMotBloAct" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_mot_actividad.ObsMotBloAct" ng-disabled="vm.validate_mot_bloqueo_actividad==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_mot_actividad.CodMotBloAct==undefined||vm.fdatos_mot_actividad.CodMotBloAct==null||vm.fdatos_mot_actividad.CodMotBloAct==''" ng-disabled="form_bloqueo_actividad.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_mot_actividad.CodMotBloAct>0 && vm.validate_mot_bloqueo_actividad==undefined" ng-disabled="form_bloqueo_actividad.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_actividad()" ng-show="vm.fdatos_mot_actividad.CodMotBloAct>0 && vm.validate_mot_bloqueo_actividad==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_actividad()" ng-show="vm.fdatos_mot_actividad.CodMotBloAct==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_bloqueo_actividad()"><i class="fa fa-backward"></i> Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodMotBloAct" name="CodMotBloAct" type="hidden" ng-model="vm.fdatos_mot_actividad.CodMotBloAct" readonly />
      </form>
    </div><!--FINAL DIV NG-SHOW TVistaMotBloAct 2-->

    </div><!-- FINAL DE TABS 2 MOTIVO BLOQUEO ACTIVIDAD-->



    <!--INICIO TABS 3 BLOQUEO Direcciones de SuministroS-->
  <div id="tabs-3">  
  <div ng-show="vm.TvistaMotBloPunSum==1"><!--INICIO DIV NG-SHOW TvistaMotBloPunSum 1-->      
   <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesMotBloPun"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsMotBloPun"/> <b style="color:black;">Observación</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AcctMotBloPunSum"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Motivo_Bloqueo_Punto_Suministro/{{vm.ruta_reportes_pdf_MotBloPunSum}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Motivo_Bloqueo_Punto_Suministro/{{vm.ruta_reportes_excel_MotBloPunSum}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_PunSum" minlength="1" id="exampleInputEmail3" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Motivo Punto Suministro" ng-click="vm.agg_bloqueo_PunSum()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivos_punto_sumininistro()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesMotBloPun==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloPun==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloPunSum==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TMotivo_BloPunSum.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TMotivo_BloPunSum | filter:paginate3 | filter:vm.filtrar_PunSum" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesMotBloPun==true">{{dato.DesMotBloPun}}</td>
                     <td ng-show="vm.ObsMotBloPun==true">{{dato.ObsMotBloPun}}</td>
                    <td ng-show="vm.AcctMotBloPunSum==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_PunSum" name="opciones_PunSum" ng-model="vm.opciones_PunSum[$index]" ng-change="vm.validar_opcion_PunSum($index,vm.opciones_PunSum[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesMotBloPun==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloPun==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloPunSum==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivos_punto_sumininistro()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>
  </div><!--FINAL DIV NG-SHOW TvistaMotBloPunSum 1-->



    <!--INICIO DIV NG-SHOW TvistaMotBloPunSum 2-->
    <div ng-show="vm.TvistaMotBloPunSum==2">
       <form class="form-validate form-horizontal " id="form_bloqueo_PunSum" name="form_bloqueo_PunSum" ng-submit="submitFormPunSum($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción<span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesMotBloPun" name="DesMotBloPun" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_mot_PunSum.DesMotBloPun" ng-disabled="vm.validato_mot_bloqueo_PunSum==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsMotBloPun" name="ObsMotBloPun" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_mot_PunSum.ObsMotBloPun" ng-disabled="vm.validato_mot_bloqueo_PunSum==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_mot_PunSum.CodMotBloPun==undefined||vm.fdatos_mot_PunSum.CodMotBloPun==null||vm.fdatos_mot_PunSum.CodMotBloPun==''" ng-disabled="form_bloqueo_PunSum.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_mot_PunSum.CodMotBloPun>0 && vm.validato_mot_bloqueo_PunSum==undefined" ng-disabled="form_bloqueo_PunSum.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_PunSum()" ng-show="vm.fdatos_mot_PunSum.CodMotBloPun>0 && vm.validato_mot_bloqueo_PunSum==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_PunSum()" ng-show="vm.fdatos_mot_PunSum.CodMotBloPun==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_bloqueo_PunSum()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodMotBloPun" name="CodMotBloPun" type="hidden" ng-model="vm.fdatos_mot_PunSum.CodMotBloPun" readonly />
      </form>
     
      
      
    </div>
    <!--FINAL DIV NG-SHOW TvistaMotBloPunSum 2-->

    </div>
    <!-- FINAL DE TABS 3 MOTIVO BLOQUEO Direcciones de SuministroS-->



  <!--INICIO TABS 4 MOTIVO BLOQUEO CONTACTO-->
  <div id="tabs-4">
    <!--INICIO DIV NG-SHOW TVistaBloqueoContacto 1-->
    <div ng-show="vm.TVistaBloqueoContacto==1">

      <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesMotBlocon"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsMotBloCon"/> <b style="color:black;">Observación</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AcctMotBloCon"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Motivo_Bloqueo_Contacto/{{vm.ruta_reportes_pdf_MotBloContacto}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Motivo_Bloqueo_Contacto/{{vm.ruta_reportes_excel_MotBloContacto}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_Contacto" minlength="1" id="exampleInputEmail4" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Motivo Bloqueo Contacto" ng-click="vm.agg_bloqueo_Contacto()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivo_contactos()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesMotBlocon==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCon==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloCon==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TMotivo_BloContacto.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TMotivo_BloContacto | filter:paginate4 | filter:vm.filtrar_Contacto" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesMotBlocon==true">{{dato.DesMotBlocon}}</td>
                     <td ng-show="vm.ObsMotBloCon==true">{{dato.ObsMotBloCon}}</td>
                    <td ng-show="vm.AcctMotBloCon==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_contacto" name="opciones_contacto" ng-model="vm.opciones_contacto[$index]" ng-change="vm.validar_opcion_contacto($index,vm.opciones_contacto[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesMotBlocon==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCon==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloCon==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivo_contactos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems4" ng-model="currentPage4" max-size="5" boundary-links="true" items-per-page="numPerPage4" class="pagination-sm">  
            </pagination>
          </div>
        </div>


          

      
    </div><!--FINAL DIV NG-SHOW TVistaBloqueoContacto 1-->

    <!--INICIO DIV NG-SHOW TVistaBloqueoContacto 2-->
    <div ng-show="vm.TVistaBloqueoContacto==2">

      <form class="form-validate form-horizontal " id="form_bloqueo_contacto" name="form_bloqueo_contacto" ng-submit="submitFormContactos($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción<span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesMotBlocon" name="DesMotBlocon" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_mot_contacto.DesMotBlocon" ng-disabled="vm.validate_mot_contacto==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsMotBloCon" name="ObsMotBloCon" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_mot_contacto.ObsMotBloCon" ng-disabled="vm.validate_mot_contacto==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_mot_contacto.CodMotBloCon==undefined||vm.fdatos_mot_contacto.CodMotBloCon==null||vm.fdatos_mot_contacto.CodMotBloCon==''" ng-disabled="form_bloqueo_contacto.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_mot_contacto.CodMotBloCon>0 && vm.validate_mot_contacto==undefined" ng-disabled="form_bloqueo_contacto.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_Contacto()" ng-show="vm.fdatos_mot_contacto.CodMotBloCon>0 && vm.validate_mot_contacto==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_Contacto()" ng-show="vm.fdatos_mot_contacto.CodMotBloCon==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_Contacto()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodMotBloCon" name="CodMotBloCon" type="hidden" ng-model="vm.fdatos_mot_contacto.CodMotBloCon" readonly />
      </form>
    </div>
    <!--FINAL DIV NG-SHOW TVistaBloqueoContacto 2-->
  </div>
  <!-- FINAL DE TABS 4 MOTIVO BLOQUEO CONTACTO-->





    <!--INICIO TABS 5 BLOQUEO COMERCIALIZADORA-->
  <div id="tabs-5">
    <!--INICIO DIV NG-SHOW TVistaBloqueoComercializadora 1-->
    <div ng-show="vm.TVistaBloqueoComercializadora==1">
        <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesMotBloCom"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsMotBloCom"/> <b style="color:black;">Observación</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AcctMotBloCom"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Motivo_Bloqueo_Comercializadora/{{vm.ruta_reportes_pdf_MotBloComercializadora}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Motivo_Bloqueo_Comercializadora/{{vm.ruta_reportes_excel_MotBloComercializadora}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_comercializadora" minlength="1" id="exampleInputEmail5" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Motivo Bloqueo Comercializadora" ng-click="vm.agg_bloqueo_Comercializadora()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivo_comercializadora()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesMotBloCom==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCom==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloCom==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TMotivo_BloComercializadora.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TMotivo_BloComercializadora | filter:paginate5 | filter:vm.filtrar_comercializadora" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesMotBloCom==true">{{dato.DesMotBloCom}}</td>
                     <td ng-show="vm.ObsMotBloCom==true">{{dato.ObsMotBloCom}}</td>
                    <td ng-show="vm.AcctMotBloCom==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_comercializadora" name="opciones_comercializadora" ng-model="vm.opciones_comercializadora[$index]" ng-change="vm.validar_opcion_comercializadora($index,vm.opciones_comercializadora[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesMotBloCom==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCom==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloCom==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivo_comercializadora()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems5" ng-model="currentPage5" max-size="5" boundary-links="true" items-per-page="numPerPage5" class="pagination-sm">  
            </pagination>
          </div>
        </div>
      
    </div><!--FINAL DIV NG-SHOW TVistaBloqueoComercializadora 1-->

    <!--INICIO DIV NG-SHOW TVistaBloqueoComercializadora 2-->
    <div ng-show="vm.TVistaBloqueoComercializadora==2">
   
      <form class="form-validate form-horizontal " id="form_bloqueo_comercializadora" name="form_bloqueo_comercializadora" ng-submit="submitFormComercializadora($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción<span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesMotBloCom" name="DesMotBloCom" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_mot_comercializadora.DesMotBloCom" ng-disabled="vm.validate_mot_comercializadora==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsMotBloCom" name="ObsMotBloCom" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_mot_comercializadora.ObsMotBloCom" ng-disabled="vm.validate_mot_comercializadora==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_mot_comercializadora.CodMotBloCom==undefined||vm.fdatos_mot_comercializadora.CodMotBloCom==null||vm.fdatos_mot_comercializadora.CodMotBloCom==''" ng-disabled="form_bloqueo_comercializadora.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_mot_comercializadora.CodMotBloCom>0 && vm.validate_mot_comercializadora==undefined" ng-disabled="form_bloqueo_comercializadora.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_Comercializadora()" ng-show="vm.fdatos_mot_comercializadora.CodMotBloCom>0 && vm.validate_mot_comercializadora==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_Comercializadora()" ng-show="vm.fdatos_mot_comercializadora.CodMotBloCom==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_Comercializadora()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodMotBloCom" name="CodMotBloCom" type="hidden" ng-model="vm.fdatos_mot_comercializadora.CodMotBloCom" readonly />
      </form>




    </div>
    <!--FINAL DIV NG-SHOW TVistaBloqueoComercializadora 2-->
  </div>
  <!-- FINAL DE TABS 5 BLOQUEO COMERCIALIZADORA-->

  <!-- INICIO DE TABS 6 BLOQUEO CUPS-->
  <div id="tabs-6">
<!--INICIO DIV NG-SHOW TVistaBloqueoCUPs 1-->
    <div ng-show="vm.TVistaBloqueoCUPs==1">
        <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesMotBloCUPs"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsMotBloCUPs"/> <b style="color:black;">Observación</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AcctMotBloCUPs"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Motivo_Bloqueo_CUPs/{{vm.ruta_reportes_pdf_MotBloCUPs}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Motivo_Bloqueo_CUPs/{{vm.ruta_reportes_excel_MotBloCUPs}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_cups" minlength="1" id="exampleInputEmail6" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Motivo Bloqueo CUPs" ng-click="vm.agg_bloqueo_CUPs()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivo_cups()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesMotBloCUPs==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCUPs==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloCUPs==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TMotivo_BloCUPs.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TMotivo_BloCUPs | filter:paginate6 | filter:vm.filtrar_cups" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesMotBloCUPs==true">{{dato.DesMotBloCUPs}}</td>
                     <td ng-show="vm.ObsMotBloCUPs==true">{{dato.ObsMotBloCUPs}}</td>
                    <td ng-show="vm.AcctMotBloCUPs==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_cups" name="opciones_cups" ng-model="vm.opciones_cups[$index]" ng-change="vm.validar_opcion_cups($index,vm.opciones_cups[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesMotBloCUPs==true">Descripción</th> 
                    <th ng-show="vm.ObsMotBloCUPs==true">Observación</th>   
                    <th ng-show="vm.AcctMotBloCUPs==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivo_cups()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems6" ng-model="currentPage6" max-size="5" boundary-links="true" items-per-page="numPerPage6" class="pagination-sm">  
            </pagination>
          </div>
        </div>
      
    </div><!--FINAL DIV NG-SHOW TVistaBloqueoCUPs 1-->

    <!--INICIO DIV NG-SHOW TVistaBloqueoCUPs 2-->
    <div ng-show="vm.TVistaBloqueoCUPs==2">
   
      <form class="form-validate form-horizontal " id="form_bloqueo_cups" name="form_bloqueo_cups" ng-submit="submitFormCUPs($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción<span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesMotBloCUPs" name="DesMotBloCUPs" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_mot_cups.DesMotBloCUPs" ng-disabled="vm.validate_mot_bloqueo_cups==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsMotBloCUPs" name="ObsMotBloCUPs" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_mot_cups.ObsMotBloCUPs" ng-disabled="vm.validate_mot_bloqueo_cups==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_mot_cups.CodMotBloCUPs==undefined||vm.fdatos_mot_cups.CodMotBloCUPs==null||vm.fdatos_mot_cups.CodMotBloCUPs==''" ng-disabled="form_bloqueo_cups.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_mot_cups.CodMotBloCUPs>0 && vm.validate_mot_bloqueo_cups==undefined" ng-disabled="form_bloqueo_cups.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_CUPs()" ng-show="vm.fdatos_mot_cups.CodMotBloCUPs>0 && vm.validate_mot_bloqueo_cups==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_CUPs()" ng-show="vm.fdatos_mot_cups.CodMotBloCUPs==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_CUPs()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodMotBloCUPs" name="CodMotBloCUPs" type="hidden" ng-model="vm.fdatos_mot_cups.CodMotBloCUPs" readonly />
      </form>




    </div>
    <!--FINAL DIV NG-SHOW TVistaBloqueoComercializadora 2-->
  </div>
  <!-- FINAL DE TABS 6 BLOQUEO CUPS-->








</div>
<!-- FINAL DE TABS MAESTRO--> 
                
            



















            </section><!-- page end-->
          </div>
        </div>
        <!-- page end-->
      </section>
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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
        </div>
    </div>
  </section>
    <script>
      $(function(){
        'use strict'
        jQuery(function($) 
        {
          $( "#tabs_clientes" ).tabs(); 
          $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            //mixDate: "<?php echo date("m/d/Y")?>"
            maxDate: "<?php echo date("m/d/Y")?>"
        });
      });


      });
    </script>
  <!-- container section end -->
</div>
</body>
<div id="cargando_lista" class="loader loader-default"  data-text="Cargando listado de Motivos de Bloqueo"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando Registro"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Registro"></div>
<div id="borrando" class="loader loader-default"  data-text="Eliminando Registro"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando Información"></div>
</html>
