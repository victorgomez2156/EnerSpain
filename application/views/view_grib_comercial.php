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
 <div ng-controller="Controlador_Comercial as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Comerciales</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bank"></i>Comerciales</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
        <div class="btn-group">
          <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><input type="checkbox" ng-model="vm.NomCom"/> <b style="color:black;">Nombre</b></li></li>
            <li><input type="checkbox" ng-model="vm.NIFCom"/> <b style="color:black;">DNI/NIE</b></li>
            <li><input type="checkbox" ng-model="vm.TelFijCom"/> <b style="color:black;">Telf. Fijo</b></li></li>
            <li><input type="checkbox" ng-model="vm.TelCelCom"/> <b style="color:black;">Telf. Móvil</b></li>
            <li><input type="checkbox" ng-model="vm.EmaCom"/> <b style="color:black;">Email</b></li>
            <li><input type="checkbox" ng-model="vm.EstCom"/> <b style="color:black;">Estatus</b></li>
            <li><input type="checkbox" ng-model="vm.AccCom"/> <b style="color:black;">Acción</b></li>
          </ul> 
        </div>
        <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
          <ul class="dropdown-menu">
            <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Comercial/{{vm.ruta_reportes_pdf_comercial}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
            <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Comercial/{{vm.ruta_reportes_excel_comercial}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
          </ul>
        </div>
        <div class="btn-group">
          <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_comercial" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
        </div>

    </div>
  </div>
</div>
<div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
  <div class="t-0029">
    <form class="form-inline" role="form">
      <div class="form-group">
          <input type="text" class="form-control" ng-model="vm.filtrar_search" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchComercial()">
      </div>                 
      <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Comercial" ng-click="vm.modal_agg_comercial()"><i class="fa fa-plus-square"> </i> </button>
    </form>                    
  </div>
</div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
 <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_comercial()">
                <tbody>
                  <tr>                    
                    <th ng-show="vm.NomCom==true">Nombre</th>
                    <th ng-show="vm.NIFCom==true">DNI/NIE</th>                    
                    <th ng-show="vm.TelFijCom==true">Telf. Fijo</th>
                    <th ng-show="vm.TelCelCom==true">Telf. Móvil</th>
                    <th ng-show="vm.EmaCom==true">Email</th>
                    <th ng-show="vm.EstCom==true">Estatus</th>                    
                    <th ng-show="vm.AccCom==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TComercial.length==0"> 
                     <td colspan="7" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TComercial | filter:paginate" ng-class-odd="odd">
                    
                     <td ng-show="vm.NomCom==true">{{dato.NomCom}}</td>
                    <td ng-show="vm.NIFCom==true">{{dato.NIFCom}}</td>
                    <td ng-show="vm.TelFijCom==true">{{dato.TelFijCom}}</td>
                    <td ng-show="vm.TelCelCom==true">{{dato.TelCelCom}}</td>
                    <td ng-show="vm.EmaCom==true">{{dato.EmaCom}}</td>                 
                    <td ng-show="vm.EstCom==true">
                      <span class="label label-info" ng-show="dato.EstCom==1">Activo</span>
                      <span class="label label-danger" ng-show="dato.EstCom==2">Bloqueado</span>
                    </td> 
                    <td ng-show="vm.AccCom==true">
                      <div class="btn-group">
                        <select class="form-control" style="width: auto;" id="opciones_comercial" name="opciones_comercial" ng-model="vm.opciones_comercial[$index]" ng-change="vm.validar_opcion($index,vm.opciones_comercial[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                     <th ng-show="vm.NomCom==true">Nombre</th>
                    <th ng-show="vm.NIFCom==true">DNI/NIE</th>                    
                    <th ng-show="vm.TelFijCom==true">Telf. Fijo</th>
                    <th ng-show="vm.TelCelCom==true">Telf. Móvil</th>
                    <th ng-show="vm.EmaCom==true">Email</th>
                    <th ng-show="vm.EstCom==true">Estatus</th>                    
                    <th ng-show="vm.AccCom==true">Acción</th>
                </tfoot>
              </table>
        </div>
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_comercial()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>


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
  <!-- container section end -->

  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Comercial</h4>
          </div>
          <div class="modal-body">
          <div class="panel"> 
      <input type="hidden" class="form-control" ng-model="vm.datos_update.CodCom" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlock($event)">                 
     <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">DNI/NIE</label>
     <input type="text" class="form-control" ng-model="vm.NIFCom" required readonly/>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Comercial</label>
     <input type="text" class="form-control" ng-model="vm.NomCom" required readonly />     
     </div>
     </div>
     </div>
    <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control datepicker" ng-model="vm.FechBloCom" name="FechBloCom" id="FechBloCom"/>    
     </div>
     </div>
     </div>
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.datos_update.MotBloqCom" required/>      
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.datos_update.ObsBloCom" rows="5" maxlength="100"/></textarea>
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

  $('#FechBloCom').on('changeDate', function() 
  {
     var FechBloCom=document.getElementById("FechBloCom").value;
     console.log("FechBloCom: "+FechBloCom);
  });
</script>

  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_comercial" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosComercial($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
      <select class="form-control" id="tipo_filtro" name="tipo_filtro" ng-model="vm.tmodal_data.tipo_filtro">
        <option value="1">Estatus Comercial</option> 
                                
      </select>    
     </div>
     </div>
     </div>
    <div class="col-12 col-sm-12" ng-show="vm.tmodal_data.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstCom" name="EstCom" ng-model="vm.tmodal_data.EstCom">
        <option value="1">Activo</option> 
        <option value="2">Bloqueado</option>                         
      </select>     
     </div> 
     </div>
     </div> 
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_comercial()" ng-show="vm.tmodal_data.tipo_filtro>0&&vm.tmodal_data.EstCom>0">Quitar Filtro</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->

<!--modal modal_dni_comprobar section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_dni_comprobar" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Introduzca DNI/NIE:</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="DNI_NIE_consulta_form" name="DNI_NIE_consulta_form" ng-submit="Consultar_DNI_NIE($event)"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-vcard" title="Número de DNI/NIE"></i> Número de DNI/NIE:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" name="NumDNI_NIECli" id="NumDNI_NIECli" ng-model="vm.fdatos.NumDNI_NIECli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Ingrese Número de DNI/NIE" maxlength="9" required/>   
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="DNI_NIE_consulta_form.$invalid">CONSULTAR</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_dni_comprobar section END -->
</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista Comercial, por favor espere ..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Comercial, por favor espere ..."></div>
<div id="bloqueando" class="loader loader-default"  data-text="Bloqueando Comercial, por favor espere ..."></div>
<div id="comprobando_dni" class="loader loader-default"  data-text="Comprobando Disponiblidad del DNI/NIE, por favor espere ..."></div>
</html>
