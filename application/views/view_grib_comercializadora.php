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
 <div ng-controller="Controlador_Comercializadora as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Comercializadoras</h3>
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
                        <li><input type="checkbox" ng-model="vm.RazSocCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Razón Social</b></li></li>
                        <li><input type="checkbox" ng-model="vm.NumCifCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                        <li><input type="checkbox" ng-model="vm.NomComCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Comercializadora</b></li></li>
                        <li><input type="checkbox" ng-model="vm.DirCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Dirección</b></li>
                        <li><input type="checkbox" ng-model="vm.ProDirCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Provincia</b></li>
                        <li><input type="checkbox" ng-model="vm.CodLoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Localidad</b></li>
                        <li><input type="checkbox" ng-model="vm.TelFijCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono</b></li>
                        <li><input type="checkbox" ng-model="vm.EmaCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Correo Eléctronico</b></li>
                        <li><input type="checkbox" ng-model="vm.NomConCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Persona Contacto</b></li>
                        <li><input type="checkbox" ng-model="vm.EstCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>                     
                        <li><input type="checkbox" ng-model="vm.Acc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>
                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar En PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Comercializadora/{{vm.reporte_pdf_comercializadora}}"><i class="fa fa-file"></i> Exportar En PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar en Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Comercializadora/{{vm.reporte_excel_comercializadora}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                    </ul>
                    </div>

                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_comercializadora" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
                    </div>
    </div>
  </div>
</div>
              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar" minlength="1" id="exampleInputEmail2" title="Escribe para Filtrar..." placeholder="Escribe para Filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" id="btn_modal_cif_com" class="btn btn-info" title="Agregar Comercializadora" ng-click="vm.modal_cif_comercializadora()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end--> 
   
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.NumCifCom==true"> CIF</th>
                    <th ng-show="vm.RazSocCom==true">Razón Social</th>                    
                    <th ng-show="vm.NomComCom==true">Comercializadora</th>
                    <th ng-show="vm.DirCom==true">Dirección</th>
                    <th ng-show="vm.ProDirCom==true"> Provincia</th>
                    <th ng-show="vm.CodLoc==true"> Localidad</th>
                    <th ng-show="vm.TelFijCom==true"> Teléfono</th>
                    <th ng-show="vm.EmaCom==true"> Correo Eléctronico</th>
                    <th ng-show="vm.NomConCom==true"> Persona Contacto</th>
                    <th ng-show="vm.EstCom==true"> Estatus</th>
                    <th ng-show="vm.Acc==true"> Acción</th>
                  </tr>  

                   <tr ng-show="vm.Tcomercializadoras.length==0"> 
                     <td colspan="29" align="center"><div class="td-usuario-table">No hay información disponible</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.Tcomercializadoras | filter:paginate | filter:vm.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.NumCifCom==true">{{dato.NumCifCom}}</td>
                    <td ng-show="vm.RazSocCom==true">{{dato.RazSocCom}}</td>
                    <td ng-show="vm.NomComCom==true">{{dato.NomComCom}}</td>  
                    <td ng-show="vm.DirCom==true">{{dato.DesTipVia}}, {{dato.NomViaDirCom}}, {{dato.NumViaDirCom}}, {{dato.BloDirCom}}, {{dato.EscDirCom}}, {{dato.PlaDirCom}}, {{dato.PueDirCom}}</td>
                    <td ng-show="vm.ProDirCom==true">{{dato.ProDirCom}}</td>
                    <td ng-show="vm.CodLoc==true">{{dato.CodLoc}}</td>
                    <td ng-show="vm.TelFijCom==true">{{dato.TelFijCom}}</td>
                    <td ng-show="vm.EmaCom==true">{{dato.EmaCom}}</td>
                    <td ng-show="vm.NomConCom==true">{{dato.NomConCom}}</td>
                    <td ng-show="vm.EstCom==true">
                      <span class="label label-info" ng-show="dato.EstCom=='ACTIVA'">Activo</span>
                      <span class="label label-danger" ng-show="dato.EstCom=='BLOQUEADA'">Bloqueado</span>
                    </td>
                    <td ng-show="vm.Acc==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_comercializadoras" name="opciones_comercializadoras" ng-model="vm.opciones_comercializadoras[$index]" ng-change="vm.validar_opcion($index,vm.opciones_comercializadoras[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_comercializadoras" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                     <th ng-show="vm.NumCifCom==true"> CIF</th>
                    <th ng-show="vm.RazSocCom==true">Razón Social</th>                    
                    <th ng-show="vm.NomComCom==true">Comercializadora</th>
                    <th ng-show="vm.DirCom==true">Dirección</th>
                    <th ng-show="vm.ProDirCom==true"> Provincia</th>
                    <th ng-show="vm.CodLoc==true"> Localidad</th>
                    <th ng-show="vm.TelFijCom==true"> Teléfono</th>
                    <th ng-show="vm.EmaCom==true"> Correo Eléctronico</th>
                    <th ng-show="vm.NomConCom==true"> Persona Contacto</th>
                    <th ng-show="vm.EstCom==true"> Estatus</th>
                    <th ng-show="vm.Acc==true"> Acción</th>

                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_comercializadoras()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_comercializadora" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Comercializadora</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.t_modal_data.CodCom" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlockCom($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.NumCifComBlo" required readonly/>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>
      <input type="text" class="form-control" ng-model="vm.RazSocComBlo" required readonly />     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>
       <select class="form-control" id="MotBloq" name="MotBloq" required ng-model="vm.t_modal_data.MotBloq">
          <option ng-repeat="dato in vm.tMotBloCom" value="{{dato.CodMotBloCom}}">{{dato.DesMotBloCom}}</option>
        </select>    
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control datepicker" ng-model="vm.fecha_bloqueo" id="fecha_bloqueo" required maxlength="10" ng-change="vm.validar_fecha_blo(vm.fecha_bloqueo)" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.t_modal_data.ObsBloCom" rows="5" maxlength="100"/></textarea>
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
<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#fecha_bloqueo').on('changeDate', function() 
  {
     var fecha_bloqueo=document.getElementById("fecha_bloqueo").value;
     console.log("fecha_bloqueo: "+fecha_bloqueo);
  });


  
 jQuery('.soloNumeros').keypress(function (tecla) {
  if ((tecla.charCode == 46 )) return true;
  if ((tecla.charCode < 48 || tecla.charCode > 57)) return false;
  
});

jQuery('.soloValidFecha').keypress(function (tecla) {
  
  if ((tecla.charCode == 45 )) return true;
  if ((tecla.charCode < 48 || tecla.charCode > 57)) return false;
  
});

</script>
<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_comercializadora" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosComercializadoras($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
         <select class="form-control" id="tipo_filtro" name="tipo_filtro" required ng-model="vm.tmodal_comercializadora.tipo_filtro">
                 <option ng-repeat="dato in vm.ttipofiltros" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_comercializadora.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="TipServ" name="TipServ" ng-model="vm.tmodal_comercializadora.TipServ">
        <option ng-repeat="dato in vm.TipServ" value="{{dato.id}}">{{dato.nom_serv}}</option>                        
      </select>   
     </div>
     </div>
    </div>
    
    <div class="col-12 col-sm-12" ng-show="vm.tmodal_comercializadora.TipServ!=undefined && vm.tmodal_comercializadora.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="Selec" name="Selec" ng-model="vm.tmodal_comercializadora.Selec">
        <option value="SI">Si</option> 
         <option value="NO">No</option>                            
      </select>   
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_comercializadora.tipo_filtro==2 || vm.tmodal_comercializadora.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodPro" name="CodPro" ng-model="vm.tmodal_data.CodPro" ng-change="vm.filtrarLocalidad()">
        <option ng-repeat="dato in vm.TProvincias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_comercializadora.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodLocFil" name="CodLocFil" ng-model="vm.tmodal_comercializadora.CodLocFil" ng-disabled="vm.tmodal_data.CodPro==undefined || vm.tmodal_data.CodPro==null">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.DesLoc}}">{{dato.DesLoc}}</option>                         
      </select>     
     </div>
     </div>
     </div> 
    
    <div class="col-12 col-sm-12" ng-show="vm.tmodal_comercializadora.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstCom" name="EstCom" ng-model="vm.tmodal_comercializadora.EstCom">
        <option ng-repeat="dato in vm.EstComFil" value="{{dato.nombre}}">{{dato.nombre}}</option>                        
      </select>   
     </div>
     </div>
    </div>   

  
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid"><i class="fa fa-check-circle"></i> Aplicar </button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_comercializadora()"><i class="fa fa-trash"></i> Quitar </a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
<!--modal modal_cif_comercializadora section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_cif_comercializadora" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Introduzca CIF</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form" name="cif_consulta_form" ng-submit="Consultar_CIF($event)"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-vcard" title="Número de CIF"></i>CIF</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCom" placeholder="* Introduzca CIF" maxlength="8" required/>   
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form.$invalid"> Consultar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_cif_comercializadora section END -->
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>
<div id="List_Comer" class="loader loader-default"  data-text="Cargando listado de Comercializadoras"></div>
<div id="borrando" class="loader loader-default"  data-text="Eliminando Comercializadora"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>
</div>
</body>
</html>