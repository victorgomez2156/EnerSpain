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
 <div ng-controller="Controlador_Colaboradores as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Colaboradores</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>               
              <li> Colaboradores</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">
 <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="{{ 'Add_Columns'  }}" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.NomCol"/> <b style="color:black;">Nombre</b></li>
                        <li><input type="checkbox" ng-model="vm.NumIdeFis"/> <b style="color:black;">CIF/NIF</b></li></li>
                        <li><input type="checkbox" ng-model="vm.TipCol"/> <b style="color:black;">Tipo</b></li>
                        <li><input type="checkbox" ng-model="vm.PorCol"/> <b style="color:black;">% Comisión</b></li>
                        <li><input type="checkbox" ng-model="vm.TelCelCol"/> <b style="color:black;">Tel. Móvil</b></li>
                        <li><input type="checkbox" ng-model="vm.TelFijCol"/> <b style="color:black;">Tel. Fijo</b></li>
                        <li><input type="checkbox" ng-model="vm.EmaCol"/> <b style="color:black;">Email</b></li>
                        <li><input type="checkbox" ng-model="vm.EstCol"/> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccCol"/> <b style="color:black;">Acción</b></li> 
                      </ul> 
                    </div>                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title="Exportar en PDF" target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Colaboradores/{{vm.ruta_reportes_pdf_colaboradores}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title="Exportar en Excel" target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Colaboradores/{{vm.ruta_reportes_excel_colaboradores}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                         
                      </ul>
                    </div>

                    <div class="btn-group">
                       <a data-toggle="modal" title="Filtros" data-target="#modal_filtros_colaboradores" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                    </div>
    </div>
  </div>
</div>       
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_search" minlength="1" title="Escribe para Filtrar..." id="exampleInputEmail2" placeholder="Escribe para Filtrar..." ng-keyup="vm.FetchColaboradores()">
                    </div>

                    <a style="margin-right: 10px;" href="#/Add_Colaborador" title="Agregar Colaborador" class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-plus-square" style="color:white;"></i></div></a>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_colaboradores()">
                <tbody>
                  <tr>                                       
                    
                    <th ng-show="vm.NomCol==true">Nombre</th>
                    <th ng-show="vm.NumIdeFis==true">CIF/NIF</th>
                    <th ng-show="vm.TipCol==true">Tipo</th>
                    <th ng-show="vm.PorCol==true">% Comisión</th>
                    <th ng-show="vm.TelCelCol==true">Tel. Móvil</th>
                    <th ng-show="vm.TelFijCol==true">Tel. Fijo</th>
                    <th ng-show="vm.EmaCol==true">Email</th>
                    <th ng-show="vm.EstCol==true">Estatus</th>
                    <th ng-show="vm.AccCol==true">Acción</th>                       
                  </tr>
                  <tr ng-show="vm.tColaboradores.length==0"> 
                     <td colspan="9" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.tColaboradores | filter:paginate" ng-class-odd="odd">                    
                    <td ng-show="vm.NomCol==true">{{dato.NomCol}}</td>
                    <td ng-show="vm.NumIdeFis==true">{{dato.NumIdeFis}}</td>
                    <td ng-show="vm.TipCol==true"><div ng-show="dato.TipCol==1">Persona Física</div><div ng-show="dato.TipCol==2">Empresa</div></td>
                    <td ng-show="vm.PorCol==true">{{dato.PorCol}}</td>
                    <td ng-show="vm.TelCelCol==true">{{dato.TelCelCol}}</td>
                    <td ng-show="vm.TelFijCol==true">{{dato.TelFijCol}}</td>
                    <td ng-show="vm.EmaCol==true">{{dato.EmaCol}}</td>
                    <td ng-show="vm.EstCol==true">
                      <span class="label label-info" ng-show="dato.EstCol==1">Activo</span>
                      <span class="label label-danger" ng-show="dato.EstCol==2">Bloqueado</span>
                    </td>                                       
                    <td ng-show="vm.AccCol==true">
                      <select class="form-control" style="width: auto;" id="opciones_colaboradores" name="opciones_colaboradores" ng-model="vm.opciones_colaboradores[$index]" ng-change="vm.validar_opcion($index,vm.opciones_colaboradores[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                      </select>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                    <th ng-show="vm.NomCol==true">Nombre</th>
                    <th ng-show="vm.NumIdeFis==true">CIF/NIF</th>
                    <th ng-show="vm.TipCol==true">Tipo</th>
                    <th ng-show="vm.PorCol==true">% Comisión</th>
                    <th ng-show="vm.TelCelCol==true">Tel. Móvil</th>
                    <th ng-show="vm.TelFijCol==true">Tel. Fijo</th>
                    <th ng-show="vm.EmaCol==true">Email</th>
                    <th ng-show="vm.EstCol==true">Estatus</th>
                    <th ng-show="vm.AccCol==true">Acción</th>     
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_colaboradores()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
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
          Diseñador Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>

<!-- modal container section end -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_colaboradores" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltrocolaboradores" name="frmfiltrocolaboradores" ng-submit="SubmitFormFiltrosColaboradores($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" id="MotBloq" name="MotBloq" required ng-model="vm.tmodal_colaboradores.tipo_filtro">
          <option ng-repeat="dato in vm.ttipofiltros" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_colaboradores.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="TipColFil" name="TipColFil" ng-model="vm.tmodal_colaboradores.TipColFil">
        <option value="1">Persona Física</option> 
        <option value="2">Empresa</option>                       
      </select>   
     </div>
     </div>
</div>

       <div class="col-12 col-sm-12" ng-show="vm.tmodal_colaboradores.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="EstColFil" name="EstColFil" ng-model="vm.tmodal_colaboradores.EstColFil">
        <option value="1">Activo</option> 
        <option value="2">Bloqueado</option>                         
      </select>     
     </div> 
     </div>
     </div> 

    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltrocolaboradores.$invalid"><i class="fa fa-check-circle"></i> Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_colaboradores()" ng-show="vm.tmodal_colaboradores.tipo_filtro>0">Quitar</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->



  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> Bloqueo de Colaborador</h4>
          </div>
          <div class="modal-body">
      <div class="panel"> 
      <input type="hidden" class="form-control" ng-model="vm.t_modal_data.CodCol" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlockCol($event)">                 
     <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">NIF/CIF</label>
     <input type="text" class="form-control" ng-model="vm.NumIdeFisBlo" readonly/>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Colaborador</label>
      <input type="text" class="form-control" ng-model="vm.NomColBlo" readonly />     
     </div>
     </div>
     </div>
   

    <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'FEC_BLO_COM_MODAL'  }}</label>
     <input type="text" class="form-control datepicker" ng-model="vm.FecBloColBlo" name="FecBloColBlo" id="FecBloColBlo"  />    
     </div>
     </div>
     </div>
      
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>          
      <input type="text" class="form-control" id="MotBloqCol" name="MotBloqCol" required ng-model="vm.t_modal_data.MotBloqColBlo" required/>
     </div>
     </div>
     

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
     <textarea type="text" class="form-control" ng-model="vm.t_modal_data.ObsBloColBlo" rows="5" maxlength="100"></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->

<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FecBloColBlo').on('changeDate', function() 
  {
     var FecBloColBlo=document.getElementById("FecBloColBlo").value;
     console.log("FecBloColBlo: "+FecBloColBlo);
  });
</script>
</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando listado de Colaboradores, por favor espere ..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Colaborador, por favor espere ..."></div>
<div id="NumCifCli" class="loader loader-default"  data-text="Comprobando Número de CIF, por favor espere ..."></div>
</html>
