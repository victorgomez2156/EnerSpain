<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *"); 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <link href="application/libraries/estilos/css/daterangepicker.css" rel="stylesheet" />
  <link href="application/libraries/estilos/css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="application/libraries/estilos/css/bootstrap-colorpicker.css" rel="stylesheet" />
  
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
</head>

<body>
 <div ng-controller="Controlador_Tarifas as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Tarifas</h3>
            <!--<ol class="breadcrumb">
            
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              
              <li>TARIFAS</li>
              
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
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
        <a href="#tabs-1">Tarifa Eléctrica</a>
      </li>       
      <li>
        <a href="#tabs-2">Tarifa Gas</a>
      </li>    
    </ul>
    <!--INICIO TABS 1 TARIFA ELÉCTRICA -->
    <div id="tabs-1"> 
    <!--INICIO NG-SHOW 1 TARIFA ELÉCTRICA -->         
        <div ng-show="vm.TVistaTarEle==1">
          
           <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <!--li><input type="checkbox" ng-model="vm.fdatos.Cod"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CodCli</b></li-->
                        <li><input type="checkbox" ng-model="vm.TipTen"/> <b style="color:black;">TIPO TENSIÓN</b></li>
                        <li><input type="checkbox" ng-model="vm.NomTarEle"/> <b style="color:black;">TARIFA</b></li></li>
                        <li><input type="checkbox" ng-model="vm.CanPerTar"/> <b style="color:black;">PERIODOS</b></li></li>
                        <li><input type="checkbox" ng-model="vm.MinPotCon"/> <b style="color:black;">POTENCIA MÍNIMA</b></li>
                        <li><input type="checkbox" ng-model="vm.MaxPotCom"/> <b style="color:black;">POTENCIA MÁXIMA</b></li>
                        <li><input type="checkbox" ng-model="vm.EstTarEle"/> <b style="color:black;">ESTATUS</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTarElec"/> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>
                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Tarifa_Electrica/{{vm.ruta_reportes_pdf_tarifas_electrica}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Tarifa_Electrica/{{vm.ruta_reportes_excel_tarifas_electrica}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_tarifa_electrica" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                    </div>
                    </div>
                  </div>
                </div>
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_tarifa_electrinca" minlength="1" id="exampleInputEmail" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchTarEle()">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Tarifa Eléctrica" ng-click="vm.agregar_tarifa_electrica()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
            </div>  <!--t-0002 end-->    
              <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_Tarifa_Electrica()">
                <tbody>
                  <tr>
                    <th ng-show="vm.TipTen==true">Tipo Tensión</th>
                    <th ng-show="vm.NomTarEle==true">Tarifa</th>                    
                    <th ng-show="vm.CanPerTar==true">Períodos</th>
                    <th ng-show="vm.MinPotCon==true">Mínimo Potencia</th>
                    <th ng-show="vm.MaxPotCom==true">Máximo Potencia</th> 
                    <th ng-show="vm.EstTarEle==true">Estatus</th> 
                    <th ng-show="vm.AccTarElec==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.T_TarifasEle.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_TarifasEle | filter:paginate" ng-class-odd="odd">                    
                    <td ng-show="vm.TipTen==true">{{dato.TipTen}}</td>
                    <td ng-show="vm.NomTarEle==true">{{dato.NomTarEle}}</td>
                    <td ng-show="vm.CanPerTar==true">{{dato.CanPerTar}}</td>
                    <td ng-show="vm.MinPotCon==true">{{dato.MinPotCon}} kw</td>
                    <td ng-show="vm.MaxPotCom==true">{{dato.MaxPotCon}} kw</td>                    
                    <td>
                      <span class="label label-info" ng-show="dato.EstTarEle==1"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstTarEle==2"><i class="fa fa-ban"></i> Bloqueado</span>
                    </td>
                    <td ng-show="vm.AccTarElec==true"> 
                         <select class="form-control" id="opciones_TarEle" name="opciones_TarEle" ng-model="vm.opciones_TarEle[$index]" ng-change="vm.validar_opcion_TarEle($index,vm.opciones_TarEle[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                      </select>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.TipTen==true">Tipo Tensión</th>
                    <th ng-show="vm.NomTarEle==true">Tarifa</th>                    
                    <th ng-show="vm.CanPerTar==true">Períodos</th>
                    <th ng-show="vm.MinPotCon==true">Mínimo Potencia</th>
                    <th ng-show="vm.MaxPotCom==true">Máximo Potencia</th> 
                    <th ng-show="vm.EstTarEle==true">Estatus</th> 
                    <th ng-show="vm.AccTarElec==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_Tarifa_Electrica()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_tarifa_electrica" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frm_filtro_TarEle" name="frm_filtro_TarEle" ng-submit="SubmitFormFiltrosTarEle($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" id="tipo_filtro" name="tipo_filtro" required ng-model="vm.tmodal_TarEle.tipo_filtro">
         <option value="1">TIPO TENSIÓN</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_TarEle.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipTen" name="TipTen" ng-model="vm.tmodal_TarEle.TipTen">
        <option value="BAJA">Baja</option> 
        <option value="ALTA">Alta</option>
        <option value="AMBAS">Ambas</option>                         
      </select>   
     </div>
     </div>
    </div>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frm_filtro_TarEle.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_TarEle()" ng-show="vm.tmodal_TarEle.tipo_filtro>0">Quitar</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


        </div> 
    <!--FINAL NG-SHOW 1 TARIFA ELÉCTRICA -->  
    
    <!--INICIO NG-SHOW 2 TARIFA ELÉCTRICA -->    
        <div ng-show="vm.TVistaTarEle==2">
    <form id="register_form_TarEle" name="register_form_TarEle" ng-submit="submitFormTarEle($event)">           
      <div style="margin-top: 8px;">
      <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO DE TENSIÓN</b></label></div></div>
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">       
        <input type="radio" name="tipo_clienteBaja" id="tipo_clienteBaja" value="0" ng-model="vm.fdatos_tar_elec.TipTen" ng-disabled="vm.disabled_form_TarEle==1">
        <label class="font-weight-bold nexa-dark" style="color:black;">Baja</label>
        <input type="radio" name="tipo_clienteAlta" id="tipo_clienteAlta" value="1" ng-model="vm.fdatos_tar_elec.TipTen" ng-disabled="vm.disabled_form_TarEle==1">
        <label class="font-weight-bold nexa-dark" style="color:black;">Alta</label> 
       </div>
       </div>
       </div>
                    
               <div class="col-12 col-sm-3">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Tarifa <b style="color:red;">(*)</b></label>
               <input class=" form-control" id="NomTarEle"  name="NomTarEle" type="text" maxlength="10" required ng-model="vm.fdatos_tar_elec.NomTarEle" ng-disabled="vm.disabled_form_TarEle==1"/>               
               </div>
               </div>
              </div>

               <div class="col-12 col-sm-3">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Cantidad Períodos <b style="color:red;">(*)</b></label>
                <input class=" form-control" id="CanPerTar" name="CanPerTar" maxlength="2" type="text" required ng-model="vm.fdatos_tar_elec.CanPerTar" ng-change="vm.validarsinumeroTarEle(1,vm.fdatos_tar_elec.CanPerTar)" ng-disabled="vm.disabled_form_TarEle==1"/>              
               </div>
               </div>
              </div>

              <div class="col-12 col-sm-3">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Mínima Potencia <b style="color:red;">(*)</b></label>
                 <input class=" form-control" id="MinPotCon" name="MinPotCon" type="text" required ng-model="vm.fdatos_tar_elec.MinPotCon" ng-change="vm.validarsinumeroTarEle(2,vm.fdatos_tar_elec.MinPotCon)" placeholder="KW" ng-disabled="vm.disabled_form_TarEle==1"/>              
               </div>
               </div>
              </div>


              <div class="col-12 col-sm-3">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Máxima Potencia <b style="color:red;">(*)</b></label>
                  <input class=" form-control" id="MaxPotCon" name="MaxPotCon" type="text" required ng-model="vm.fdatos_tar_elec.MaxPotCon" ng-change="vm.validarsinumeroTarEle(3,vm.fdatos_tar_elec.MaxPotCon)" placeholder="KW" ng-disabled="vm.disabled_form_TarEle==1"/>              
               </div>
               </div>
              </div>

                   <div class="form-group">
                      <div align="right">
                        <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_tar_elec.CodTarEle==undefined||vm.fdatos_tar_elec.CodTarEle==null||vm.fdatos_tar_elec.CodTarEle==''" ng-disabled="register_form_TarEle.$invalid">REGISTRAR</button>
                        <button class="btn btn-success" type="submit" ng-show="vm.fdatos_tar_elec.CodTarEle>0 && vm.disabled_form_TarEle==undefined" ng-disabled="register_form_TarEle.$invalid">ACTUALIZAR</button>
                        <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar_TarEle()" ng-show="vm.fdatos_tar_elec.CodTarEle>0 && vm.Nivel==1" ng-disabled="vm.Nivel==3 && vm.disabled_form_TarEle==1">BORRAR</button-->
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar_TarEle()" ng-show="vm.disabled_form_TarEle==undefined">LIMPIAR</button>
                        <a class="btn btn-info" ng-click="vm.regresar_TarEle()">Volver</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodTarEle" name="CodTarEle" type="hidden" ng-model="vm.fdatos_tar_elec.CodTarEle" readonly />
                  </form>

        </div>     
    <!--FINAL NG-SHOW 2 TARIFA ELÉCTRICA -->             
              
             
    </div>
    <!--FINAL TABS 1 TARIFA ELÉCTRICA -->

    <!--INICIO TABS 2 TARIFA GAS-->
    <div id="tabs-2">
       <!--INICIO NG-SHOW 1 TARIFA GAS -->         
        <div ng-show="vm.TVistaTarGas==1">
           <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">                        
                        <li><input type="checkbox" ng-model="vm.NomTarGas"/> <b style="color:black;">Tarifa</b></li></li>
                        <li><input type="checkbox" ng-model="vm.MinConAnu"/> <b style="color:black;">Consumo Mínimo</b></li></li>
                        <li><input type="checkbox" ng-model="vm.MaxConAnu"/> <b style="color:black;">Consumo Máximo</b></li>
                        <li><input type="checkbox" ng-model="vm.EstTarGas"/> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTarGas"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>
                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Tarifa_Gas/{{vm.ruta_reportes_pdf_tarifas_gas}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Tarifa_Gas/{{vm.ruta_reportes_excel_tarifas_gas}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>                   
                    </div>
                  </div>
                </div>
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_gas" minlength="1" id="exampleInputEmail1" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchTarGas()">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Tarifa Gas" ng-click="vm.agg_TarGas()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
            </div>  <!--t-0002 end-->  
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_Tarifa_Gas()">
                <tbody>
                  <tr>
                    <th ng-show="vm.NomTarGas==true">Nomenclatura</th>
                    <th ng-show="vm.MinConAnu==true">Mínimo Consumo Anual</th>
                    <th ng-show="vm.MaxConAnu==true">Máximo Consumo Anual</th> 
                    <th ng-show="vm.EstTarGas==true">Estatus</th>
                    <th ng-show="vm.AccTarGas==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.T_TarifasGas.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_TarifasGas | filter:paginate1" ng-class-odd="odd">
                    
                    <td ng-show="vm.NomTarGas==true">{{dato.NomTarGas}}</td>
                    <td ng-show="vm.MinConAnu==true">{{dato.MinConAnu}} kWh</td>
                    <td ng-show="vm.MaxConAnu==true">{{dato.MaxConAnu}} kWh</td>                    
                    <td>
                      <span class="label label-info" ng-show="dato.EstTarGas==1"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstTarGas==2"><i class="fa fa-ban"></i> Bloqueado</span>
                    </td>

                    <td ng-show="vm.AccTarGas==true"> 
                      <select class="form-control" id="opciones_TarGas" name="opciones_TarGas" ng-model="vm.opciones_TarGas[$index]" ng-change="vm.validar_opcion_TarGas($index,vm.opciones_TarGas[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                      </select>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.NomTarGas==true">Nomenclatura</th>
                    <th ng-show="vm.MinConAnu==true">Mínimo Consumo Anual</th>
                    <th ng-show="vm.MaxConAnu==true">Máximo Consumo Anual</th> 
                    <th ng-show="vm.EstTarGas==true">Estatus</th>
                    <th ng-show="vm.AccTarGas==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_Tarifa_Gas()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
            </pagination>
          </div>
        </div>



        </div> 
    <!--FINAL NG-SHOW 1 TARIFA GAS -->  
    
    <!--INICIO NG-SHOW 2 TARIFA GAS -->    
        <div ng-show="vm.TVistaTarGas==2">
          
                  <form id="register_form_TarGas" name="register_form_TarGas" ng-submit="submitFormTarGas($event)">           
                       
               <div class="col-12 col-sm-4">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Tarifa <b style="color:red;">(*)</b></label>
               <input class=" form-control" id="NomTarGas"  name="NomTarGas" type="text" maxlength="10" required ng-model="vm.fdatos_tar_gas.NomTarGas" ng-disabled="vm.disabled_form_TarGas==1"/>               
               </div>
               </div>
              </div>

               <div class="col-12 col-sm-4">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Consumo Anual Mínimo <b style="color:red;">(*)</b></label>
                <input class=" form-control" id="MinConAnu" name="MinConAnu" type="text" required ng-model="vm.fdatos_tar_gas.MinConAnu" ng-change="vm.validarsinumeroTarGas(1,vm.fdatos_tar_gas.MinConAnu)" ng-disabled="vm.disabled_form_TarGas==1"/>              
               </div>
               </div>
              </div>

              <div class="col-12 col-sm-4">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Consumo Anual Máximo <b style="color:red;">(*)</b></label>
                 <input class=" form-control" id="MaxConAnu" name="MaxConAnu" type="text" required ng-model="vm.fdatos_tar_gas.MaxConAnu" ng-change="vm.validarsinumeroTarGas(2,vm.fdatos_tar_gas.MaxConAnu)"  placeholder="KW" ng-disabled="vm.disabled_form_TarGas==1"/>              
               </div>
               </div>
              </div>

                   <div class="form-group">
                      <div align="right">
                        <button class="btn btn-primary" type="submit" style="margin-top: 10px;" ng-show="vm.fdatos_tar_gas.CodTarGas==undefined||vm.fdatos_tar_gas.CodTarGas==null||vm.fdatos_tar_gas.CodTarGas==''" ng-disabled="register_form_TarGas.$invalid">Registrar</button>
                        <button class="btn btn-success" type="submit" ng-show="vm.fdatos_tar_gas.CodTarGas>0 && vm.disabled_form_TarGas==undefined" ng-disabled="register_form_TarGas.$invalid">Actualizar</button>
                        <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar_TarGas()" ng-show="vm.fdatos_tar_gas.CodTarGas>0&& vm.disabled_form_TarGas==undefined && vm.Nivel==1" ng-disabled="vm.Nivel==3">Borrar</button-->
                        <button class="btn btn-warning" type="button" ng-show="vm.disabled_form_TarGas==undefined" ng-click="vm.limpiar_TarGas()">Limpiar</button>
                        <a class="btn btn-info" ng-click="vm.regresar_TarGas()">Volver</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodTarGas" name="CodTarGas" type="hidden" ng-model="vm.fdatos_tar_gas.CodTarGas" readonly />
                  </form>
          
        </div>     
    <!--FINAL NG-SHOW 2 TARIFA GAS -->  
                 

    </div>
    <!-- FINAL DE TABS 2 TARIFA GAS-->
  </div>
  <!-- FINAL DE TABS MAESTRO--> 
                
              </div>
            </section>
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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>


</div>
  <!-- container section end -->
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
</body>

<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Registro, por favor espere ..."></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando Registro, por favor espere ..."></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando Listado de Tarifas, por favor espere ..."></div>
<div id="Borrando" class="loader loader-default"  data-text="Borrando Tarifa, por favor espere ..."></div>



</html>