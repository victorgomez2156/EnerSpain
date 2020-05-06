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
<style>
.datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Productos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Productos</h3>
           
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
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.NumCifCom"/> <b style="color:black;">CIF</b></li></li>
                        <li><input type="checkbox" ng-model="vm.RazSocCom"/> <b style="color:black;">Razón Social</b></li></li>
                        <li><input type="checkbox" ng-model="vm.DesTPro"/> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerTGas"/> <b style="color:black;">Gas</b></li>
                        <li><input type="checkbox" ng-model="vm.SerTEle"/> <<b style="color:black;">Eléctrico</b></li>
                        <li><input type="checkbox" ng-model="vm.ObsTPro"/> <b style="color:black;">Observación</b></li>
                        <li><input type="checkbox" ng-model="vm.FecIniTPro"/><b style="color:black;">Fecha de Inicio</b></li>   <li><input type="checkbox" ng-model="vm.EstTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTPro"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar en PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Productos/{{vm.reporte_pdf_productos}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar en Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Productos/{{vm.reporte_excel_productos}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_productos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
          </div>
        </div>
    </div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar" minlength="1" id="exampleInputEmail21" placeholder="Escribe para Filtrar...">
                    </div>                 
                    <a style="margin-right: 10px;" class="btn btn-info" title="Escribe texto a filtrar ..." href="#/Add_Productos"><i class="fa fa-plus-square"></i></a>
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
                    <th ng-show="vm.NumCifCom==true">CIF</th>
                    <th ng-show="vm.RazSocCom==true">Razón Social</th>
                    <th ng-show="vm.DesTPro==true">Descripción</th>
                    <th ng-show="vm.SerTGas==true">Gas</th>
                    <th ng-show="vm.SerTEle==true">Eléctrico</th>
                    <th ng-show="vm.ObsTPro==true">Observación</th>
                    <th ng-show="vm.FecIniTPro==true">Fecha de Inicio</th>
                    <th ng-show="vm.EstTPro==true">Estatus</th>
                    <th ng-show="vm.AccTPro==true">Acción</th>
                  </tr> 
                  <tr ng-show="vm.TProductos.length==0"> 
                    <td colspan="9" align="center"><div class="td-usuario-table">No hay información disponible</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TProductos | filter:paginate1 | filter:vm.filtrar" ng-class-odd="odd">                   
                    
                    <td ng-show="vm.NumCifCom==true">{{dato.NumCifCom}}</td>                  
                    <td ng-show="vm.RazSocCom==true">{{dato.RazSocCom}}</td>  
                    <td ng-show="vm.DesTPro==true">{{dato.DesPro}}</td>
                    <td ng-show="vm.SerTGas==true">{{dato.SerGas}}</td>
                    <td ng-show="vm.SerTEle==true">{{dato.SerEle}}</td>
                    <td ng-show="vm.ObsTPro==true">{{dato.ObsPro}}</td>
                    <td ng-show="vm.FecIniTPro==true">{{dato.FecIniPro}}</td>
                    <td ng-show="vm.EstTPro==true">
                      <span class="label label-info" ng-show="dato.EstPro=='ACTIVO'">Activo</span>
                      <span class="label label-danger" ng-show="dato.EstPro=='BLOQUEADO'">Bloqueado</span>
                    </td>
                    <td ng-show="vm.AccTPro==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_productos" name="opciones_productos" ng-model="vm.opciones_productos[$index]" ng-change="vm.validar_opcion_productos($index,vm.opciones_productos[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.NumCifCom==true">CIF</th>
                    <th ng-show="vm.RazSocCom==true">Razón Social</th>
                    <th ng-show="vm.DesTPro==true">Descripción</th>
                    <th ng-show="vm.SerTGas==true">Gas</th>
                    <th ng-show="vm.SerTEle==true">Eléctrico</th>
                    <th ng-show="vm.ObsTPro==true">Observación</th>
                    <th ng-show="vm.FecIniTPro==true">Fecha de Inicio</th>
                    <th ng-show="vm.EstTPro==true">Estatus</th>
                    <th ng-show="vm.AccTPro==true">Acción</th>
                </tfoot>
              </table>
        </div>
         <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_productos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
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
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>
  <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_productos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Producto</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
      <input type="hidden" class="form-control" ng-model="vm.t_modal_data.CodPro" required readonly />
      <form class="form-validate" id="form_lockPro" name="form_lockPro" ng-submit="submitFormlockPro($event)">                 
     
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora</label>
     <input type="text" class="form-control" ng-model="vm.Comercializadora" readonly />
     </div>
     </div>

      
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Productos</label>
     <input type="text" class="form-control" ng-model="vm.Producto" readonly />
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo<b style="color:red;"> (*)</b></label>
      <input type="text" class="form-control" ng-model="vm.t_modal_data.MotBloPro" required /> 
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo <b style="color:red;"> (*)</b></label>
     <input type="text" class="form-control datepicker" ng-model="vm.fecha_bloqueo" name="fecha_bloqueo" id="fecha_bloqueo" maxlength="10" ng-change="vm.validarsifechaproductos(vm.fecha_bloqueo,2)" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.t_modal_data.ObsBloPro" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lockPro.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->
 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_productos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroproductos" name="frmfiltroproductos" ng-submit="SubmitFormFiltrosProductos($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" id="ttipofiltrosProductos" name="ttipofiltrosProductos" required ng-model="vm.tmodal_productos.ttipofiltrosProductos">
          <option ng-repeat="dato in vm.ttipofiltrosProductos" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_productos.ttipofiltrosProductos==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="NumCifCom" name="NumCifCom" ng-model="vm.tmodal_productos.NumCifCom">
        <option ng-repeat="dato in vm.Tcomercializadoras | orderBy:'+RazSocCom'" value="{{dato.NumCifCom}}">{{dato.NumCifCom}} - {{dato.RazSocCom}}</option>
      </select>   
     </div>
     </div>
    </div>
  
  <div class="col-12 col-sm-12" ng-show="vm.tmodal_productos.ttipofiltrosProductos==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipServ1" name="TipServ" ng-model="vm.tmodal_productos.TipServ">
        <option value="1">Suministro Gas</option>
        <option value="2">Suministro Eléctrico</option>
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_productos.ttipofiltrosProductos==2 && vm.tmodal_productos.TipServ!=undefined">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="Select2" name="Select" ng-model="vm.tmodal_productos.Select">
        <option value="SI">Si</option>
        <option value="NO">No</option>
      </select>   
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_productos.ttipofiltrosProductos==3">
     <div class="form">                          
     <div class="form-group">     
      <input type="text" name="FecIniPro" id="FecIniPro" class="form-control datepicker2" ng-model="vm.tmodal_productos.FecIniPro" placeholder="EJ: DD/MM/YYYY" ng-change="vm.validarsifechaproductos(vm.tmodal_productos.FecIniPro,1)" maxlength="10">  
     </div>
     </div>
    </div>


    <div class="col-12 col-sm-12" ng-show="vm.tmodal_productos.ttipofiltrosProductos==4">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="EstPro" name="EstPro" ng-model="vm.tmodal_productos.EstPro">
        <option value="ACTIVO">Activo</option>
        <option value="BLOQUEADO">Bloqueado</option>
      </select>   
     </div>
     </div>
    </div>

      <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroproductos.$invalid"><i class="fa fa-check-circle"></i> Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_productos()">Quitar</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>

<!--modal container section end -->




</div>

<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#fecha_bloqueo').on('changeDate', function() 
  {
     var fecha_bloqueo=document.getElementById("fecha_bloqueo").value;
     console.log("fecha_bloqueo: "+fecha_bloqueo);
  });

  $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniPro').on('changeDate', function() 
  {
     var FecIniPro=document.getElementById("FecIniPro").value;
     console.log("FecIniPro: "+FecIniPro);
  });

</script>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>
<div id="List_Produc" class="loader loader-default"  data-text="Cargando lista de Productos"></div>

<div id="cargando_xID" class="loader loader-default"  data-text="Buscando Información del Producto"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
