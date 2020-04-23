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
 <div ng-controller="Controlador_Actividades as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Actividades</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-briefcase"></i>Actividades</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
              <!--panel start-->
              <section class="panel">
             
              <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.NumCifCli"/> <b style="color:black;">CIF</b></li>
                  <li><input type="checkbox" ng-model="vm.RazSocCli"/> <b style="color:black;">Razón Social</b></li>
                  <li><input type="checkbox" ng-model="vm.DesSec"/> <b style="color:black;">Código CNAE</b></li>
                  <li><input type="checkbox" ng-model="vm.DesGru"/> <b style="color:black;">Descripción</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EstAct"/> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.FecIniAct1"/> <b style="color:black;">Fecha Actividad</b></li></li>
                  <li><input type="checkbox" ng-model="vm.AccAct"/> <b style="color:black;">Action</b></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Clientes_Doc_PDF_Actividades/{{vm.ruta_reportes_pdf_actividad}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Clientes_Doc_Excel_Actividades/{{vm.ruta_reportes_excel_actividad}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_actividades" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.fdatos.filtrar" minlength="1" placeholder="Escribe para filtrar...">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a-->
                    <a title="Asignar Actividad" style="margin-right: 5px;" href="#/Add_Actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.NumCifCli==true">CIF</th>
                    <th ng-show="vm.RazSocCli==true">Razón Social</th>
                    <th ng-show="vm.DesSec==true">Código CNAE</th>
                    <th ng-show="vm.DesGru==true">Descripción</th>
                    <th ng-show="vm.EstAct==true">Estatus Actividad</th>
                    <th ng-show="vm.FecIniAct1==true">Fecha Actividad</th>                    
                    <th ng-show="vm.AccAct==true">Action</th>
                  </tr>
                  <tr ng-show="vm.TActividades.length==0"> 
                     <td colspan="6" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> No existen Actividades registradas</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TActividades | filter:paginate1 | filter:vm.fdatos.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.NumCifCli==true">{{dato.NumCifCli}}</td>
                     <td ng-show="vm.RazSocCli==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.DesSec==true">{{dato.CodActCNAE}}</td>
                    <td ng-show="vm.DesGru==true">{{dato.DesActCNAE}}</td>
                    <td ng-show="vm.EstAct==true">
                      <span class="label label-info" ng-show="dato.EstAct=='Activa'"><i class="fa fa-check-circle"></i>  {{dato.EstAct}}</span>
                      <span class="label label-danger" ng-show="dato.EstAct=='Bloqueada'"><i class="fa fa-ban"></i>  {{dato.EstAct}}</span>
                   </td>
                    <td ng-show="vm.FecIniAct1==true">{{dato.FecIniAct}}</td>                   
                    <td ng-show="vm.AccAct==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_actividades" name="opciones_actividades" ng-model="vm.opciones_actividades[$index]" ng-change="vm.validar_actividad($index,vm.opciones_actividades[$index],dato)">
                          <option ng-repeat="opcion in vm.topcionesactividades" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>  
                  <th ng-show="vm.NumCifCli==true"> CIF</th>
                    <th ng-show="vm.RazSocCli==true"> Razón Social</th>
                    <th ng-show="vm.DesSec==true">Código CNAE</th>
                    <th ng-show="vm.DesGru==true">Descripción</th>
                    <th ng-show="vm.EstAct==true">Estatus Actividad</th>
                    <th ng-show="vm.FecIniAct1==true">Fecha Actividad</th>                    
                    <th ng-show="vm.AccAct==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.mostrar_all_actividades()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
            </pagination>
          </div>
        </div>


         <!--modal container section end -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_actividades" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Filtrar Actividades</h4>
          </div>
          <div class="modal-body">
      <div class="panel">                  
      <form class="form-validate" id="frmfiltrAct" name="frmfiltrAct" ng-submit="SubmitFormFiltrosAct($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" name="MotBloq" required ng-model="vm.tmodal_filtroAct.tipo_filtro_actividad">
          <option ng-repeat="dato in vm.ttipofiltrosact" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtroAct.tipo_filtro_actividad==1">
     <div class="form">                          
     <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:red;">EJ: DD/MM/YYYY</label> 
      <input class="form-control datepicker" name="FecIniActFil" id="FecIniActFil" type="text" ng-change="vm.validar_fecha_act(2,vm.FecIniActFil)" ng-model="vm.FecIniActFil" maxlength="10" placeholder="DD/MM/YYYY"> 
     </div>
     </div>    
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtroAct.tipo_filtro_actividad==2">
     <div class="form">                          
     <div class="form-group"> 
      <select class="form-control" id="EstActFil" name="EstActFil" ng-model="vm.tmodal_filtroAct.EstActFil">
        <option ng-repeat="dato in vm.ttipofiltrosEstAct" value="{{dato.nombre}}">{{dato.nombre}}</option>                         
      </select>     
     </div>
     </div>
     </div> 

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtroAct.tipo_filtro_actividad==3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodCliActFil" name="CodCliActFil" ng-model="vm.tmodal_filtroAct.CodCliActFil"> 
          <option ng-repeat="dato_act in vm.Tclientes" value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select>       
       </div>
       </div>
       </div> 

    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltrAct.$invalid"><i class="fa fa-check-circle"></i> APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.quitar_filtro_actividad()" >LIMPIAR FILTRO</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->



<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_actividades" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Actividades</h4>
          </div>
          <div class="modal-body">
            <div class="panel"> 
              <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" required readonly />
              <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodTActCli" required readonly />
      <form class="form-validate" id="form_lock3" name="form_lock" ng-submit="submitFormlockActividades($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.NumCif" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control datepicker2" name="FecBloAct" id="FecBloAct" ng-model="vm.FecBloAct" required ng-change="vm.validar_fecha_act(3,vm.FecBloAct)" maxlength="10" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social del Cliente</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.RazSoc" required readonly />     
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Descripción</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.DesActCNAE" required readonly/>     
     </div>
     </div>
     </div>
 
    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Grupo</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.GruActCNAE" required readonly/>    
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Sub-Grupo</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.SubGruActCNAE" required readonly/>    
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Sección</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.SecActCNAE" required readonly/>     
     </div>
     </div>
     </div>     

    <div class="form">                          
      <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>     
      <select class="form-control" name="MotBloq" required ng-model="vm.tmodal_data.MotBloq">
        <option ng-repeat="dato in vm.tMotivosBloqueosActividades" value="{{dato.CodMotBloAct}}">{{dato.DesMotBloAct}}</option>
      </select>
     </div>
    </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsBloAct" rows="5" maxlength="100"/></textarea>
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
<!--modal container section end -->




              </section>
            </div>
        </div>
      </section>
    </section>

<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniActFil').on('changeDate', function() 
  {
     var FecIniActFil=document.getElementById("FecIniActFil").value;
     console.log("FecIniActFil: "+FecIniActFil);
  });

  $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('#FecBloAct').on('changeDate', function() 
  {
     var FecBloAct=document.getElementById("FecBloAct").value;
     console.log("FecBloAct: "+FecBloAct);
  });
</script>
</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>
<div id="cargando_actividades" class="loader loader-default"  data-text="Cargando listado de Actividades"></div>

<div id="borrando" class="loader loader-default"  data-text="Eliminando Cliente"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
