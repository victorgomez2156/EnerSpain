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
 <div ng-controller="Controlador_Tipos as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Configurar Tipos</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-meetup"></i>Tipos</li>
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
                <b>TARIFAS:</b>
              </header>
              <div class="panel-body">              
             

<div id="tabs_clientes" class="ui-tabs-nav ui-corner-all">
    <ul >
      <li>
        <a href="#tabs-1">CLIENTE</a>
      </li>       
      <li>
        <a href="#tabs-2">SECTOR</a>
      </li>
      <li>
        <a href="#tabs-3">CONTACTO</a>
      </li>
      <li>
        <a href="#tabs-4">DOCUMENTO</a>
      </li>    
    </ul>

    <!--INICIO TABS 1 TIPO CLIENTE -->
  <div id="tabs-1"> 
    
    <!--INICIO DIV NG-SHOW TVISTACLIENTE 1-->
    <div ng-show="vm.TVistaCliente==1">
      <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <!--li><input type="checkbox" ng-model="vm.fdatos_clientes.Cod"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CodCli</b></li-->
                        <li><input type="checkbox" ng-model="vm.DesTipCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">DESCRIPCION</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsTipCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">OBSERVACIÓN</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AccCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Tipo_Cliente/{{vm.ruta_reportes_pdf_cliente}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Tipo_Cliente/{{vm.ruta_reportes_excel_cliente}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_cliente" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Tipo  Cliente" ng-click="vm.agg_cliente()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div><!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_tipo_clientes()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesTipCli==true">Descripción</th> 
                    <th ng-show="vm.ObsTipCli==true">Observación</th>   
                    <th ng-show="vm.AccCli==true"><i class="icon_cogs"></i> Acción</th>
                  </tr>
                  <tr ng-show="vm.Tipo_Cliente.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tipo_Cliente | filter:paginate | filter:vm.filtrar_cliente" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesTipCli==true">{{dato.DesTipCli}}</td>
                     <td ng-show="vm.ObsTipCli==true">{{dato.ObsTipCli}}</td>
                    <td ng-show="vm.AccCli==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_clientes" name="opciones_clientes" ng-model="vm.opciones_clientes[$index]" ng-change="vm.validar_opcion_clientes($index,vm.opciones_clientes[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesTipCli==true">Descripción</th>    
                    <th ng-show="vm.AccCli==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_tipo_clientes()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
    </div>
    <!--FINAL DIV NG-SHOW TVISTACLIENTE 1-->



    <!--INICIO DIV NG-SHOW TVISTACLIENTE 2-->
    <div ng-show="vm.TVistaCliente==2">

      <form class="form-validate form-horizontal " id="form_clientes" name="form_clientes" ng-submit="submitFormClientes($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción del Tipo Cliente <span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesTipCli" name="DesTipCli" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_clientes.DesTipCli" ng-disabled="vm.validate_cliente==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsTipCli" name="ObsTipCli" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_clientes.ObsTipCli" ng-disabled="vm.validate_cliente==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_clientes.CodTipCli==undefined||vm.fdatos_clientes.CodTipCli==null||vm.fdatos_clientes.CodTipCli==''" ng-disabled="form_clientes.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_clientes.CodTipCli>0 && vm.validate_cliente==undefined" ng-disabled="form_clientes.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_cliente()" ng-show="vm.fdatos_clientes.CodTipCli>0 && vm.validate_cliente==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_cliente()" ng-show="vm.fdatos_clientes.CodTipCli==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_cliente()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodTipCli" name="CodTipCli" type="hidden" ng-model="vm.fdatos_clientes.CodTipCli" readonly />
      </form>
    </div>
    <!--FINAL DIV NG-SHOW TVISTACLIENTE 2-->
           
  </div>
  <!--FINAL TABS 1 TIPO CLIENTE -->

    <!--INICIO TABS 2 TIPO SECTOR-->
    <div id="tabs-2">
    
    <!--INICIO DIV NG-SHOW TVISTASECTOR 1-->
    <div ng-show="vm.TVistaSector==1">
<!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesSecCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">DESCRIPCION</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsSecCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">OBSERVACIÓN</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AccSecCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Tipo_Sector/{{vm.ruta_reportes_pdf_sector}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Tipo_Sector/{{vm.ruta_reportes_excel_sector}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_sector" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Tipo Sector" ng-click="vm.agg_sector()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_tipo_sector()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesSecCli==true">Descripción</th> 
                    <th ng-show="vm.ObsSecCli==true">Observación</th>   
                    <th ng-show="vm.AccSecCli==true"><i class="icon_cogs"></i> Acción</th>
                  </tr>
                  <tr ng-show="vm.Tipo_Sector.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tipo_Sector | filter:paginate1 | filter:vm.filtrar_sector" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesSecCli==true">{{dato.DesSecCli}}</td>
                     <td ng-show="vm.ObsSecCli==true">{{dato.ObsSecCli}}</td>
                    <td ng-show="vm.AccSecCli==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_sector" name="opciones_sector" ng-model="vm.opciones_sector[$index]" ng-change="vm.validar_opcion_sector($index,vm.opciones_sector[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.DesSecCli==true">Descripción</th> 
                    <th ng-show="vm.ObsSecCli==true">Observación</th>   
                    <th ng-show="vm.AccSecCli==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_tipo_sector()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
            </pagination>
          </div>
        </div>

    </div>
    <!--FINAL DIV NG-SHOW TVISTASECTOR 1-->



    <!--INICIO DIV NG-SHOW TVISTASECTOR 2-->
    <div ng-show="vm.TVistaSector==2">
      <form class="form-validate form-horizontal " id="form_sector" name="form_sector" ng-submit="submitFormSector($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción del Tipo Sector <span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesSecCli" name="DesSecCli" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_sector.DesSecCli" ng-disabled="vm.validate_sector==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsSecCli" name="ObsSecCli" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_sector.ObsSecCli" ng-disabled="vm.validate_sector==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_sector.CodSecCli==undefined||vm.fdatos_sector.CodSecCli==null||vm.fdatos_sector.CodSecCli==''" ng-disabled="form_sector.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_sector.CodSecCli>0 && vm.validate_sector==undefined" ng-disabled="form_sector.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_sector()" ng-show="vm.fdatos_sector.CodSecCli>0 && vm.validate_sector==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_sector()" ng-show="vm.fdatos_sector.CodSecCli==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_sector()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodSecCli" name="CodSecCli" type="hidden" ng-model="vm.fdatos_sector.CodSecCli" readonly />
      </form>
    </div><!--FINAL DIV NG-SHOW TVISTASECTOR 2-->

    </div><!-- FINAL DE TABS 2 TIPO SECTOR-->



     <!--INICIO TABS 3 TIPO CONTACTO-->
    <div id="tabs-3">
 
  
  <div ng-show="vm.TVistaContacto==1"><!--INICIO DIV NG-SHOW TVISTACONTACTO 1-->
      
    <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesTipCon"/> <i class="fa fa-plus-square"></i> <b style="color:black;">DESCRIPCION</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsTipCon"/> <i class="fa fa-plus-square"></i> <b style="color:black;">OBSERVACIÓN</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AccTipCon"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Tipo_Contacto/{{vm.ruta_reportes_pdf_contacto}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Tipo_Contacto/{{vm.ruta_reportes_excel_contacto}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_contacto" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Tipo Contacto" ng-click="vm.agg_contacto()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_tipo_contacto()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesTipCon==true">Descripción</th> 
                    <th ng-show="vm.ObsTipCon==true">Observación</th>   
                    <th ng-show="vm.AccTipCon==true"><i class="icon_cogs"></i> Acción</th>
                  </tr>
                  <tr ng-show="vm.Tipo_Contacto.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tipo_Contacto | filter:paginate2 | filter:vm.filtrar_contacto" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesTipCon==true">{{dato.DesTipCon}}</td>
                     <td ng-show="vm.ObsTipCon==true">{{dato.ObsTipCon}}</td>
                    <td ng-show="vm.AccTipCon==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_contacto" name="opciones_contacto" ng-model="vm.opciones_contacto[$index]" ng-change="vm.validar_opcion_contacto($index,vm.opciones_contacto[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <th ng-show="vm.DesTipCon==true">Descripción</th> 
                  <th ng-show="vm.ObsTipCon==true">Observación</th>   
                  <th ng-show="vm.AccTipCon==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_tipo_contacto()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>
  </div><!--FINAL DIV NG-SHOW TVISTACONTACTO 1-->



    <!--INICIO DIV NG-SHOW TVISTACONTACTO 2-->
    <div ng-show="vm.TVistaContacto==2">
       <form class="form-validate form-horizontal " id="form_contacto" name="form_contacto" ng-submit="submitFormContacto($event)">
        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Descripción del Tipo Contacto <span class="required">*</span></label>
            
            <div class="col-lg-10">
              <input class=" form-control" id="DesTipCon" name="DesTipCon" type="text" onkeyup="this.value=this.value.toUpperCase();" required ng-model="vm.fdatos_contacto.DesTipCon" ng-disabled="vm.validate_contacto==1"/>
            </div>
        </div>

        <div class="form-group ">
          <label for="fullname" class="control-label col-lg-2">Observación</label>            
            <div class="col-lg-10">
              <textarea class="form-control" id="ObsTipCon" name="ObsTipCon" type="text" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos_contacto.ObsTipCon" ng-disabled="vm.validate_contacto==1" rows="5" maxlength="50"></textarea>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_contacto.CodTipCon==undefined||vm.fdatos_contacto.CodTipCon==null||vm.fdatos_contacto.CodTipCon==''" ng-disabled="form_contacto.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_contacto.CodTipCon>0 && vm.validate_contacto==undefined" ng-disabled="form_contacto.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_contacto()" ng-show="vm.fdatos_contacto.CodTipCon>0 && vm.validate_contacto==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_contacto()" ng-show="vm.fdatos_contacto.CodTipCon==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_contacto()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodTipCon" name="CodTipCon" type="hidden" ng-model="vm.fdatos_contacto.CodTipCon" readonly />
      </form>
      
      
    </div>
    <!--FINAL DIV NG-SHOW TVISTACONTACTO 2-->

    </div>
    <!-- FINAL DE TABS 3 TIPO CONTACTO-->




  <!--INICIO TABS 4 TIPO DOCUMENTO-->
  <div id="tabs-4">
    <!--INICIO DIV NG-SHOW TVISTADOCUMENTOS 1-->
    <div ng-show="vm.TVistaDocumentos==1">


    <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.DesTipDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIPO DOCUMENTO</b></li></li>
                        <li><input type="checkbox" ng-model="vm.EstReq"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ES OBLIGATORIO</b></li></li>
                        <li><input type="checkbox" ng-model="vm.ObsTipDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">OBSERVACIÓN</b></li></li>
                        <li><input type="checkbox" ng-model="vm.AccTipDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Tipo_Documento/{{vm.ruta_reportes_pdf_documento}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Tipo_Documento/{{vm.ruta_reportes_excel_documento}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                  </div>
                </div>
              </div>              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtro_documento" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Tipo Documento" ng-click="vm.agg_documentos()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_tipo_documentos()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.DesTipDoc==true">TIPO DOCUMENTO</th> 
                    <th ng-show="vm.EstReq==true">ES OBLIGATORIO</th>
                    <th ng-show="vm.ObsTipDoc==true">OBSERVACIÓN</th>    
                    <th ng-show="vm.AccTipDoc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                  </tr>
                  <tr ng-show="vm.Tipo_Documento.length==0"> 
                     <td colspan="4" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tipo_Documento | filter:paginate3 | filter:vm.filtro_documento" ng-class-odd="odd">
                    
                     <td ng-show="vm.DesTipDoc==true">{{dato.DesTipDoc}}</td>
                      <td ng-show="vm.EstReq==true">{{dato.EstReq}}</td>
                     <td ng-show="vm.ObsTipDoc==true">{{dato.ObsTipDoc}}</td>
                    <td ng-show="vm.AccTipDoc==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_documento" name="opciones_documento" ng-model="vm.opciones_documento[$index]" ng-change="vm.validar_opcion_documentos($index,vm.opciones_documento[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <th ng-show="vm.DesTipDoc==true">TIPO DOCUMENTO</th> 
                    <th ng-show="vm.EstReq==true">ES OBLIGATORIO</th>
                    <th ng-show="vm.ObsTipDoc==true">OBSERVACIÓN</th>    
                    <th ng-show="vm.AccTipDoc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_tipo_documentos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>



          

      
    </div><!--FINAL DIV NG-SHOW TVISTADOCUMENTOS 1-->

    <!--INICIO DIV NG-SHOW TVISTADOCUMENTOS 2-->
    <div ng-show="vm.TVistaDocumentos==2">
    <form id="form_documentos" name="form_documentos" ng-submit="submitFormDocumentos($event)">
     
     <div class='row'> 
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Documento <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos_documento.DesTipDoc" required onkeyup="this.value=this.value.toUpperCase();" placeholder="* Tipo de Documento" maxlength="50" ng-disabled="vm.validate_documento==1"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Es Obligatorio</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos_documento.EstReq" ng-disabled="vm.validate_documento==1"/>       
       </div>
       </div>
       </div>
     
       <div class="form">                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsTipDoc" name="ObsTipDoc" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos_documento.ObsTipDoc" ng-disabled="vm.validate_documento==1"></textarea>
        
       </div>
       </div>
      
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_documento.CodTipDoc==undefined||vm.fdatos_documento.CodTipDoc==null||vm.fdatos_documento.CodTipDoc==''" ng-disabled="form_documentos.$invalid">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_documento.CodTipDoc>0 && vm.validate_documento==undefined" ng-disabled="form_documentos.$invalid">Actualizar</button>
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar_documento()" ng-show="vm.fdatos_documento.CodTipDoc>0 && vm.validate_documento==undefined" ng-disabled="vm.Nivel==3">Borrar</button>
            <button class="btn btn-warning" type="button" ng-click="vm.limpiar_documento()" ng-show="vm.fdatos_documento.CodTipDoc==undefined">Limpiar</button>
            <button class="btn btn-info" type="button" ng-click="vm.regresar_documento()">Volver</button>
          </div>
        </div>
        <input class="form-control " id="CodTipDoc" name="CodTipDoc" type="hidden" ng-model="vm.fdatos_documento.CodTipDoc" readonly />
         </div><!--FINAL ROW -->
        </form>
          
    </div>
    <!--FINAL DIV NG-SHOW TVISTADOCUMENTOS 2-->
  </div>
  <!-- FINAL DE TABS 4 TIPO DOCUMENTO-->

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
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
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
<div id="cargando_lista" class="loader loader-default"  data-text="Cargando listado de Tipos"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando Registro"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Registro"></div>
<div id="borrando" class="loader loader-default"  data-text="Eliminando Registro"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando Información"></div>
</html>
