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
 <div ng-controller="Controlador_Contactos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Contactos</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-child"></i>Contactos</li>
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
                  <li><input type="checkbox" ng-model="vm.NumCifCli"/> <b style="color:black;">NIF</b></li>
                  <li><input type="checkbox" ng-model="vm.RazSocCli"/> <b style="color:black;">Raz??n Social</b></li>
                  <li><input type="checkbox" ng-model="vm.NomConCli"/> <b style="color:black;">Nombre Contacto</b></li></li>
                  <li><input type="checkbox" ng-model="vm.NIFConCli"/> <b style="color:black;">NIF</b></li></li>
                  <li><input type="checkbox" ng-model="vm.TelFijConCli"/> <b style="color:black;">Tel??fono Fijo</b></li></li>
                  <li><input type="checkbox" ng-model="vm.TelCelConCli"/> <b style="color:black;">Tel??fono Celular</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EmaConCli"/> <b style="color:black;">Email</b></li></li>
                  <li><input type="checkbox" ng-model="vm.CodTipCon"/> <b style="color:black;">Tipo de Contacto</b></li></li>
                  <li><input type="checkbox" ng-model="vm.CarConCli"/> <b style="color:black;">Cargo</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EsRepLeg"/> <b style="color:black;">Representante Legal</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EstConCli"/> <b style="color:black;">Estatus</b></li></li> 
                  <li><input type="checkbox" ng-model="vm.ActCont"/> <<b style="color:black;">Acci??n</b></li>
                </ul> 
              </div>
              <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2"> 
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Clientes_Doc_PDF_Contactos/{{vm.ruta_reportes_pdf_Contactos}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Clientes_Doc_Excel_Contactos/{{vm.ruta_reportes_excel_Contactos}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_contactos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar_search" ng-keyup="vm.FetchContactos()" minlength="1" placeholder="Escribe para filtrar...">
                  </div> 
                    <a title="Agregar Contactos" style="margin-right: 5px;" href="#/Add_Contactos/" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>
                </form> 
                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_cif_cliente_contacto" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
                        <h4 class="modal-title">Introduzca DNI/NIE: <b style="color:red;">(*)</b></h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="dni_contacto" name="dni_contacto" ng-submit="Consultar_CIF_Contacto($event)"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">N??mero de DNI/NIE:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NIFConCli" id="NIFConCli1" name="NIFConCli1" placeholder="* introduzca N??mero de DNI/NIE"   maxlength="9" required onkeyup="this.value=this.value.toUpperCase();" />   
                            </div>
                          </div>
                          <p id="iLetter"></p>
                          <button class="btn btn-info" type="submit" ng-disabled="dni_contacto.$invalid">CONSULTAR</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>  

            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                 <th>Nombre</th>
                  <th>CIF</th>
                  <th>Cargo</th>
                  <th>Tel??fono Fijo</th>
                  <th>Tel??fono Movil</th>
                  <th>Email</th>
                  <th>Total Clientes</th>
                  <th ng-show="vm.EstConCli==true">Estatus</th>
                  <th ng-show="vm.ActCont==true">Acci??n</th>
                  </tr>
                  <tr ng-show="vm.Tabla_Contacto.length==0"> 
                    <td colspan="14" align="center">
                      <div class="td-usuario-table">No hay Contactos registrados</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tabla_Contacto | filter:paginate4" ng-class-odd="odd">
                   <td>{{dato.NomConCli}}</td>
                   <td>{{dato.NIFConCli}}</td>
                   <td>{{dato.CarConCli}}</td>
                   <td>{{dato.TelFijConCli}}</td>
                   <td>{{dato.TelCelConCli}}</td>
                   <td>{{dato.EmaConCli}}</td>
                   <td>{{dato.TotalClientes}}</td>
                    <td ng-show="vm.EstConCli==true">
                      <span class="label label-info" ng-show="dato.EstConCli=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstConCli}}</span>
                      <span class="label label-danger" ng-show="dato.EstConCli=='SUSPENDIDO'"><i class="fa fa-ban"></i> {{dato.EstConCli}}</span>
                   </td>
                    <td ng-show="vm.ActCont==true">
                      <div class="btn-group">
                        <select class="form-control" id="validar_OpcCont" style="width: auto;" name="validar_OpcCont" ng-model="vm.validar_OpcCont[$index]" ng-change="vm.validar_OpcCont($index,vm.validar_OpcCont[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                 <th>Nombre</th>
                  <th>CIF</th>
                  <th>Cargo</th>
                  <th>Tel??fono Fijo</th>
                  <th>Tel??fono Movil</th>
                  <th>Email</th>
                  <th>Total Clientes</th>
                  <th ng-show="vm.EstConCli==true">Estatus</th>
                  <th ng-show="vm.ActCont==true">Acci??n</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_contactos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems4" ng-model="currentPage4" max-size="5" boundary-links="true" items-per-page="numPerPage4" class="pagination-sm">  
            </pagination>
          </div>
        </div>



        <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_contactos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltrocontactos" name="frmfiltrocontactos" ng-submit="SubmitFormFiltrosContactos($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" id="tipo_filtroContactos" name="tipo_filtro" required ng-model="vm.tmodal_contacto.tipo_filtro">
          <option ng-repeat="dato in vm.T_Filtro_Contactos" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_contacto.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="DesTipCon" name="DesTipCon" ng-model="vm.tmodal_contacto.DesTipCon">
        <option ng-repeat="dato in vm.tListaContactos" value="{{dato.DesTipCon}}">{{dato.DesTipCon}}</option>                        
      </select>   
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_contacto.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EsRepLeg" name="EsRepLeg" ng-model="vm.tmodal_contacto.EsRepLeg">
        <option value="SI">SI</option>
        <option value="NO">NO</option>                          
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_contacto.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="TipRepr" ng-model="vm.tmodal_contacto.TipRepr">
        <option ng-repeat="dato in vm.tListaRepre" value="{{dato.DesTipRepr}}">{{dato.DesTipRepr}}</option>                          
      </select>    
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_contacto.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstConCli" name="EstConCli" ng-model="vm.tmodal_contacto.EstConCli">
        <option value="ACTIVO">ACTIVO</option>
        <option value="SUSPENDIDO">SUSPENDIDO</option>                         
      </select>     
     </div>
     </div>
     </div> 
    
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltrocontactos.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_contactos()">Borrar Filtro</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_contacto" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Suspender Contactos</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" required readonly />
                  <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodConCli" required readonly />
      <form class="form-validate" id="form_lock_contacto" name="form_lock_contacto" ng-submit="submitFormlockContactos($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.NumCif" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Suspensi??n <b style="color:red;">DD/MM/YYYY</b></label>
     <input type="text" class="form-control datepicker" ng-model="vm.FechBlo" name="FechBlo" id="FechBlo" ng-change="vm.validar_fecha_blo(vm.FechBlo)" maxlength="10" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Raz??n Social del Cliente</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCli" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Suspensi??n</label>
     
      <select class="form-control" id="MotBloqcontacto" name="MotBloqcontacto" required ng-model="vm.tmodal_data.MotBloqcontacto">
          <option ng-repeat="dato in vm.tMotivosBloqueoContacto" value="{{dato.CodMotBloCon}}">{{dato.DesMotBlocon}}</option>
        </select>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsBloContacto" rows="5" maxlength="100"/></textarea>
     </div>
     </div>    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_contacto.$invalid">Suspender</button>
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
  $('#FechBlo').on('changeDate', function() 
  {
     var FechBlo=document.getElementById("FechBlo").value;
     console.log("FechBlo: "+FechBlo);
  });
</script>



              </section>
            </div>
        </div>
      </section>
    </section>

</div><!--main content end-->
     <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Dise??ado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Informaci??n"></div>
<div id="cargando_contactos" class="loader loader-default"  data-text="Cargando listado de Contactos"></div>

<div id="estatus_PumSum" class="loader loader-default"  data-text="Actualizando Estatus de la Direcci??n de Suministro"></div>
<div id="NIFConCli" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
