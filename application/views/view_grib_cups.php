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
 <div ng-controller="Controlador_Cups as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-cube"></i> Cups</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Cups</li>
            </ol>
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

    	
      <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
        <div class="btn-group">
          <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><input type="checkbox" ng-model="vm.Cif"/> <i class="fa fa-vcard"></i> <b style="color:black;">CIF</b></li>
            <li><input type="checkbox" ng-model="vm.RazSoc"/> <i class="fa fa-user"></i> <b style="color:black;">RAZÓN SOCIAL</b></li>
            <li><input type="checkbox" ng-model="vm.Cups"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CUPS</b></li>
            <li><input type="checkbox" ng-model="vm.Cups_Ser"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIPO SERVICIO</b></li></li>
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
                    <th ng-show="vm.Cif==true"><i class="fa fa-vcard"></i> CIF</th>
                    <th ng-show="vm.RazSoc==true"><i class="fa fa-vcard"></i> RAZÓN SOCIAL</th>
                    <th ng-show="vm.Cups==true"><i class="fa fa-vcard"></i> CUPS</th>
                    <th ng-show="vm.Cups_Ser==true"><i class="fa fa-building"></i> TIPO SERVICIO</th>
                    <th ng-show="vm.Cups_Tar==true"><i class="fa fa-archive"></i> TARIFA</th> 
                    <th ng-show="vm.Dir_Cups==true"><i class="fa fa-archive"></i> DIRECCÓN</th> 
                    <th ng-show="vm.EstCUPs==true"><i class="fa fa-archive"></i> ESTATUS</th>      
                    <th ng-show="vm.Cups_Acc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                  </tr>
                  <tr ng-show="vm.TCups.length==0"> 
                     <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TCups | filter:paginate | filter:vm.filtrar_cups" ng-class-odd="odd">                    
                    <td ng-show="vm.Cif==true">{{dato.Cups_Cif}}</td>
                    <td ng-show="vm.RazSoc==true">{{dato.Cups_RazSocCli}}</td>
                    <td ng-show="vm.Cups==true">{{dato.CupsGas}}</td>
                    <td ng-show="vm.Cups_Ser==true">{{dato.TipServ}}</td>
                    <td ng-show="vm.Cups_Tar==true">{{dato.NomTarGas}}</td>
                    <td ng-show="vm.Dir_Cups==true">{{dato.TipVia}} {{dato.NomViaPunSum}} {{dato.NumViaPunSum}} {{dato.BloPunSum}} {{dato.EscPunSum}} {{dato.PlaPunSum}} {{dato.PuePunSum}} {{dato.DesPro}} {{dato.DesLoc}} {{dato.CPLocSoc}}</td>  
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
                   <th ng-show="vm.Cif==true"><i class="fa fa-vcard"></i> CIF</th>
                    <th ng-show="vm.RazSoc==true"><i class="fa fa-vcard"></i> RAZÓN SOCIAL</th>
                    <th ng-show="vm.Cups==true"><i class="fa fa-vcard"></i> CUPS</th>
                    <th ng-show="vm.Cups_Ser==true"><i class="fa fa-building"></i> TIPO SERVICIO</th>
                    <th ng-show="vm.Cups_Tar==true"><i class="fa fa-archive"></i> TARIFA</th> 
                    <th ng-show="vm.Dir_Cups==true"><i class="fa fa-archive"></i> DIRECCÓN</th> 
                    <th ng-show="vm.EstCUPs==true"><i class="fa fa-archive"></i> ESTATUS</th>      
                    <th ng-show="vm.Cups_Acc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                </tfoot>
              </table>
        </div>
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_cups()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span> 

          <!--span class="store-qty"> <a href="#/Puntos_Suministros" title='Volver' class="btn btn-info"><div><i class="fa fa-arrow-circle-left" style="color:white;"></i></div></a> </span-->      
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
     <label class="font-weight-bold nexa-dark" style="color:black;">Punto de Suministro</label>
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
     <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Servicio</label>
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
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Baja <b style="color:red;">DD/MM/YYYY</b></label>     
      <input type="text" class="form-control datepicker" name="FecBaj" id="FecBaj" ng-model="vm.tmodal_data.FecBaj" maxlength="10" ng-change="vm.validar_fecha_inputs(22,vm.tmodal_data.FecBaj)"/>
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
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
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
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosCUPs($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
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
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid"><i class="fa fa-check-circle"></i> APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_cups()" ng-show="vm.tmodal_filtro.tipo_filtro>0"><i class="fa fa-trash"></i> QUITAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
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
         
      });
        $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  
        $('#FecBaj').on('changeDate', function() 
        {
          var FecBaj=document.getElementById("FecBaj").value;
          console.log("FecBaj: "+FecBaj);
        });
        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</body>


<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Datos del Modulo, Por Favor Espere..."></div>

<div id="cargando" class="loader loader-default"  data-text="Cargando lista de Cups, Por Favor Espere..."></div>
<div id="cargandos_cups" class="loader loader-default"  data-text="Cargando Datos del Cups, Por Favor Espere..."></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando CUPs, Por Favor Espere..."></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando CUPs, Por Favor Espere..."></div>                 
<div id="Baja" class="loader loader-default"  data-text="Dando de Baja CUPs, Por Favor Espere..."></div>   
<div id="Generar_Consumo" class="loader loader-default"  data-text="Generando Historial, Por Favor Espere..."></div> 

</html>
