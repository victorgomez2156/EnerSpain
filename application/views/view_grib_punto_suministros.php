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

#searchResult{
  list-style: none;
  padding: 0px;
  width: auto;
  position: absolute;
  margin: 0;
  z-index:1151 !important;
}

#searchResult li{
  background: lavender;
  padding: 4px;
  margin-bottom: 1px;
}

#searchResult li:nth-child(even){
  background: cadetblue;
  color: white;
}

#searchResult li:hover{
  cursor: pointer;
}
.datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Puntos_Suministros as vm" ng-init="vm.mostrar_all_puntos()">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Direcciones de Suministro</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bullseye"></i>Dirección de Suministros</li>
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
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">CodCli</b></li>
                  <li><input type="checkbox" ng-model="vm.NumCifCli"/> <b style="color:black;">CIF</b></li>
                  <li><input type="checkbox" ng-model="vm.RazSocCli"/> <b style="color:black;">Razón Social</b></li>
                  <li><input type="checkbox" ng-model="vm.DirPunSum"/> <b style="color:black;">Dirección</b></li>                  
                  <li><input type="checkbox" ng-model="vm.CodProPunSum"/> <b style="color:black;">Provincia</b></li></li>
                  <li><input type="checkbox" ng-model="vm.CodLocPunSum"/> <b style="color:black;">Localidad</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EstPunSumGrid"/> <b style="color:black;">Estatus</b></li></li>
                  <li><input type="checkbox" ng-model="vm.ActPunSum"/> <b style="color:black;">Acción</b></li></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Clientes_Doc_PDF_Puntos_Suministros/{{vm.ruta_reportes_pdf_puntos_suministros}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Clientes_Doc_Excel_Puntos_Suministros/{{vm.ruta_reportes_excel_puntos_suministros}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtro Direcciones de Suministros'  data-target="#modal_filtro_puntos_suministros" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar_PumSum" minlength="1" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchPunSum()">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div</div></a-->
                    <a title="Agregar Punto Suministro" style="margin-right: 5px;" href="#/Add_Puntos_Suministros" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
            <tbody>
                  <tr>
                  <th ng-show="vm.CodCli==true"> CodCli</th>
                  <th ng-show="vm.NumCifCli==true"> CIF</th>
                  <th ng-show="vm.RazSocCli==true"> Razón Social</th>
                  <th ng-show="vm.DirPunSum==true">Dirección</th>
                  <th ng-show="vm.CodProPunSum==true">Provincia</th>
                  <th ng-show="vm.CodLocPunSum==true">Localidad</th>
                  <th ng-show="vm.EstPunSumGrid==true">Estatus</th>
                  <th ng-show="vm.ActPunSum==true"> Acción</th>
                  </tr>
                  <tr ng-show="vm.tPuntosSuminitros.length==0"> 
                    <td colspan="7" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> No hay Direcciones de Sumninistro registradas</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.tPuntosSuminitros | filter:paginate2" ng-class-odd="odd">
                    <td ng-show="vm.CodCli==true">{{dato.CodCli}}</td>
                    <td ng-show="vm.NumCifCli==true">{{dato.NumCifCli}}</td>
                     <td ng-show="vm.RazSocCli==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.DirPunSum==true">{{dato.DesTipVia}} {{dato.NomViaPunSum}} {{dato.NumViaPunSum}} {{dato.BloPunSum}} {{dato.EscPunSum}} {{dato.PlaPunSum}} {{dato.PuePunSum}}</td>
                    <td ng-show="vm.CodProPunSum==true">{{dato.DesPro}}</td>
                    <td ng-show="vm.CodLocPunSum==true">{{dato.DesLoc}}</td>                    
                    <td ng-show="vm.EstPunSumGrid==true">
                      <span class="label label-info" ng-show="dato.EstPunSum=='Activo'"><i class="fa fa-check-circle"></i> {{dato.EstPunSum}}</span>
                      <span class="label label-danger" ng-show="dato.EstPunSum=='Bloqueado'"><i class="fa fa-ban"></i> {{dato.EstPunSum}}</span>
                    </td>
                    <td ng-show="vm.ActPunSum==true">
                      <div class="btn-group">
                        <select class="form-control" style="width: auto;" id="opciones_PunSum" name="opciones_PunSum"  ng-model="vm.opciones_PunSum[$index]" ng-change="vm.validar_PunSum($index,vm.opciones_PunSum[$index],dato)">
                          <option ng-repeat="opcion in vm.topcionesPunSum" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.CodCli==true"> CodCli</th>
                  <th ng-show="vm.NumCifCli==true"> CIF</th>
                  <th ng-show="vm.RazSocCli==true"> Razón Social</th>
                  <th ng-show="vm.DirPunSum==true">Dirección</th>
                  <th ng-show="vm.CodProPunSum==true">Provincia</th>
                  <th ng-show="vm.CodLocPunSum==true">Localidad</th>
                  <th ng-show="vm.EstPunSumGrid==true">Estatus</th>
                  <th ng-show="vm.ActPunSum==true"> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.mostrar_all_puntos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>
        



          <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_puntos_suministros" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroPumSum" name="frmfiltroPumSum" ng-submit="SubmitFormFiltrosPumSum($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
       <select class="form-control" name="tipo_filtro" required ng-model="vm.fpuntosuministro.tipo_filtro" ng-change="vm.RealizarCambioFiltro(vm.fpuntosuministro.tipo_filtro)">
          <option ng-repeat="dato in vm.ttipofiltrosPunSum" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
    
     <div class="col-12 col-sm-12" ng-show="vm.fpuntosuministro.tipo_filtro==1" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes <b style="color:red;">(*)</b></label>
        
        <input type="text" class="form-control" ng-model="vm.CodCliPunSumFil" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes(1)' ng-click='vm.searchboxClicked($event)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result,1)' ng-repeat="result in vm.searchResult" >
            {{ result.NumCifCli }} - {{ result.RazSocCli }} 
          </li>
        </ul> 
      <input type="hidden" name="CodCliPunSumFil" id="CodCliPunSumFil" ng-model="vm.fpuntosuministro.CodCliPunSumFil">
       </div>
       </div>
       </div>


     <div class="col-12 col-sm-6" ng-show="vm.fpuntosuministro.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodPro" ng-model="vm.fpuntosuministro.CodPro" ng-change="vm.BuscarLocalidadesPunSun(vm.fpuntosuministro.CodPro,1)">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                          
      </select>    
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-6" ng-show="vm.fpuntosuministro.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodLocFil" ng-model="vm.fpuntosuministro.CodLocFil" ng-disabled="vm.fpuntosuministro.CodPro==undefined || vm.fpuntosuministro.CodPro==null">
        <option ng-repeat="dato in vm.TLocalidadesfiltradaPunSum" value="{{dato.DesLoc}}">{{dato.DesLoc}}</option>                         
      </select>     
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-12" ng-show="vm.fpuntosuministro.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodPro" ng-model="vm.fpuntosuministro.CodPro">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                          
      </select>    
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.fpuntosuministro.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodTipInm" ng-model="vm.fpuntosuministro.CodTipInm">
        <option ng-repeat="dato in vm.TtiposInmuebles" value="{{dato.DesTipInm}}">{{dato.DesTipInm}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.fpuntosuministro.tipo_filtro==5">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstPunSum" name="EstPunSum" ng-model="vm.fpuntosuministro.EstPunSum">
        <option value="Activo">ACTIVO</option> 
        <option value="Bloqueado">BLOQUEADO</option>                         
      </select>     
     </div> 
     </div>
     </div>    
   
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroPumSum.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtroPumSum()">Borrar Filtro</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->

  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_punto_suministro" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Direcciones de Suministros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tPunSum.CodCli" required readonly />
    <form class="form-validate" id="form_lock_PunSum" name="form_lock_PunSum" ng-submit="submitFormlockPunSum($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.tPunSum.NumCifCli" readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo <b style="color:red;">DD/MM/YYYY</b></label>
     <input type="text" class="form-control datepicker" name="FecBloPun" id="FecBloPun" ng-model="vm.FecBloPun" required ng-change="validar_fecha_blo(vm.FecBloPun)" maxlength="10"/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>
     <input type="text" class="form-control" ng-model="vm.tPunSum.RazSocCli" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>
     
      <select class="form-control" id="MotBloPunSum" name="MotBloPunSum" required ng-model="vm.tPunSum.MotBloPunSum">
          <option ng-repeat="dato in vm.tMotivosBloqueosPunSum" value="{{dato.CodMotBloPun}}">{{dato.DesMotBloPun}}</option>
        </select>
     </div>
     </div>
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tPunSum.ObsBloPunSum" rows="5" maxlength="100"/></textarea>
     </div>
     </div>    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_PunSum.$invalid">Bloquear</button>
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
  $('#FecBloPun').on('changeDate', function() 
  {
    var FecBloPun=document.getElementById("FecBloPun").value;
    console.log("FecBloPun: "+FecBloPun);
  });
</script>
    </section>
    </div>
    </div>
    </section>
    </section>

</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>
<div id="cargando_puntos" class="loader loader-default"  data-text="Cargando listado de Direcciones de Suministro"></div>

<div id="estatus_PumSum" class="loader loader-default"  data-text="Actualizando Estatus de la Dirección de Suministro"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
