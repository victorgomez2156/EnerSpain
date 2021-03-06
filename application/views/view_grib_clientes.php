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
 <div ng-controller="Controlador_Clientes as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Clientes</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li>Clientes</li>
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
          <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">CodCli</b></li>
            <li><input type="checkbox" ng-model="vm.NumCif"/> <b style="color:black;">CIF</b></li>
            <li><input type="checkbox" ng-model="vm.RazSoc"/> <b style="color:black;">Raz??n Social</b></li></li>
            <li><input type="checkbox" ng-model="vm.NomCli"/> <b style="color:black;">Nombre Comercial</b></li></li>
            <li><input type="checkbox" ng-model="vm.NomVia"/> <b style="color:black;">Domicilio Social</b></li>
            <li><input type="checkbox" ng-model="vm.NomViaFis"/> <b style="color:black;">Domicilio Fiscal</b></li>
            <li><input type="checkbox" ng-model="vm.Tel"/> <b style="color:black;">Tel??fono</b></li>
            <li><input type="checkbox" ng-model="vm.Ema"/> <b style="color:black;">Email</b></li>
            <li><input type="checkbox" ng-model="vm.CodTip"/> <b style="color:black;">Tipo Cliente</b></li>
            <li><input type="checkbox" ng-model="vm.CodSecCli"/> <b style="color:black;">Sector</b></li>
            <li><input type="checkbox" ng-model="vm.CodCo"/> <b style="color:black;">Comercial</b></li>
            <li><input type="checkbox" ng-model="vm.CodCol"/> <b style="color:black;">Colaborador</b></li>
            <li><input type="checkbox" ng-model="vm.FechRe"/> <b style="color:black;">Fecha Inicio</b></li>
            <li><input type="checkbox" ng-model="vm.Est"/> <b style="color:black;">Estatus</b></li>
            <li><input type="checkbox" ng-model="vm.Acc"/> <b style="color:black;">Action</b></li>
          </ul> 
        </div>                    
        <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
          <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
            <ul class="dropdown-menu">
              <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Clientes_Doc_PDF/{{vm.ruta_reportes_pdf}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
              <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Clientes_Doc_Excel/{{vm.ruta_reportes_excel}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
            </ul>
        </div>
        <div class="btn-group">
          <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_clientes" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
        </div>
      </div>
    </div>
   </div>              
<div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
  <div class="t-0029">
   <form class="form-inline" role="form">
      <div class="form-group">
        <input type="text" class="form-control" ng-model="vm.filtrar_clientes" ng-keyup="vm.fetchClientesFilter()" minlength="1" placeholder="Escribe para filtrar...">
      </div>                 
      <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Cliente" ng-click="vm.modal_cif_cliente()"><i class="fa fa-plus-square"></i></button>
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
                    <th ng-show="vm.CodCli==true">CodCli</th>
                    <th ng-show="vm.NumCif==true">CIF</th>
                    <th ng-show="vm.RazSoc==true">Raz??n Social</th>                                        
                    <th ng-show="vm.NomCli==true">Nombre Comercial</th>
                    <th ng-show="vm.NomVia==true">Domicilio Social</th>
                    <th ng-show="vm.NomViaFis==true">Domicilio Fiscal</th>
                    <th ng-show="vm.Tel==true">Tel??fono</th>
                    <th ng-show="vm.Ema==true">Email</th>  
                    <th ng-show="vm.CodTip==true">Tipo de Cliente</th>
                    <th ng-show="vm.CodSecCli==true">Sector</th>
                    <th ng-show="vm.CodCo==true">Comercial</th>
                    <th ng-show="vm.CodCol==true">Colaborador</th>
                    <th ng-show="vm.FechRe==true">Fecha Inicio</th>
                    <th ng-show="vm.Est==true">Estatus</th>                    
                    <th ng-show="vm.Acc==true">Acci??n</th>
                  </tr>
                  <tr ng-show="vm.Tclientes.length==0"> 
                     <td colspan="14" align="center"><div class="td-usuario-table">No hay informaci??n</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.Tclientes | filter:paginate" ng-class-odd="odd">  
                    <td ng-show="vm.CodCli==true">{{dato.CodCli}}</td>                  
                    <td ng-show="vm.NumCif==true">{{dato.NumCifCli}}</td>
                    <td ng-show="vm.RazSoc==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.NomCli==true">{{dato.NomComCli}}</td>
                    <td ng-show="vm.NomVia==true">{{dato.NomViaDomSoc}} {{dato.NumViaDomSoc}} {{dato.BloDomSoc}} {{dato.EscDomSoc}} {{dato.PlaDomSoc}} {{dato.PueDomSoc}} {{dato.CodPro}} {{dato.CodLoc}}</td>                   
                    <td ng-show="vm.NomViaFis==true">{{dato.NomViaDomFis}} {{dato.NumViaDomFis}} {{dato.BloDomFis}} {{dato.EscDomFis}} {{dato.PlaDomFis}} {{dato.PueDomFis}} {{dato.CodProFis}} {{dato.CodLocFis}}</td>
                    <td ng-show="vm.Tel==true">{{dato.TelFijCli}}</td> 
                    <td ng-show="vm.Ema==true">{{dato.EmaCli}}</td>
                    <td ng-show="vm.CodTip==true">{{dato.CodTipCli}}</td>
                    <td ng-show="vm.CodSecCli==true">{{dato.CodSecCli}}</td>
                    <td ng-show="vm.CodCo==true">{{dato.CodCom}}</td>
                    <td ng-show="vm.CodCol==true">
                      <span ng-show="dato.CodCol==null">Sin Colaborador</span>
                      <span ng-show="dato.CodCol!=null">{{dato.CodCol}}</span>
                    </td>
                    <td ng-show="vm.FechRe==true">{{dato.FecIniCli}}</td>
                    <td ng-show="vm.Est==true">
                      <span class="label label-info" ng-show="dato.EstCli==1"><i class="fa fa-check-circle"></i> {{dato.EstCliN}}</span>
                      <span class="label label-danger" ng-show="dato.EstCli==2"><i class="fa fa-ban"></i> {{dato.EstCliN}}</span>
                    </td> 
                    <td ng-show="vm.Acc==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_clientes" style="width: auto;" name="opciones_clientes" ng-model="vm.opciones_clientes[$index]" ng-change="vm.validar_opcion($index,vm.opciones_clientes[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.CodCli==true">CodCli</th>
                    <th ng-show="vm.NumCif==true">CIF</th>
                    <th ng-show="vm.RazSoc==true">Raz??n Social</th>                                        
                    <th ng-show="vm.NomCli==true">Nombre Comercial</th>
                    <th ng-show="vm.NomVia==true">Domicilio Social</th>
                    <th ng-show="vm.NomViaFis==true">Domicilio Fiscal</th>
                    <th ng-show="vm.Tel==true">Tel??fono</th>
                    <th ng-show="vm.Ema==true">Email</th>  
                    <th ng-show="vm.CodTip==true">Tipo de Cliente</th>
                    <th ng-show="vm.CodSecCli==true">Sector</th>
                    <th ng-show="vm.CodCo==true">Comercial</th>
                    <th ng-show="vm.CodCol==true">Colaborador</th>
                    <th ng-show="vm.FechRe==true">Fecha Inicio</th>
                    <th ng-show="vm.Est==true">Estatus</th>                    
                    <th ng-show="vm.Acc==true">Acci??n</th>
                </tfoot>
              </table>
        </div>
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_clientes()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
<!--- SECCION PARA MODALES-->

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_clientes" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosClientes($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.tmodal_data.tipo_filtro" ng-change="vm.RealizarConsulta(vm.tmodal_data.tipo_filtro)">
          <option ng-repeat="dato in vm.Filtro_Clientes" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>    

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_data.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodTipCli" ng-model="vm.tmodal_data.CodTipCliFil">
        <option ng-repeat="dato in vm.tTipoCliente" value="{{dato.DesTipCli}}">{{dato.DesTipCli}}</option>                        
      </select>   
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_data.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodSecCliFil" name="CodSecCliFil" ng-model="vm.tmodal_data.CodSecCliFil">
        <option ng-repeat="dato in vm.tSectores" value="{{dato.DesSecCli}}">{{dato.DesSecCli}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==3 || vm.tmodal_data.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodPro" ng-model="vm.tmodal_data.CodPro" ng-change="vm.BuscarLocalidad(vm.tmodal_data.CodPro)">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                          
      </select>    
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodLocFil" ng-model="vm.tmodal_data.CodLocFil" ng-disabled="vm.tmodal_data.CodPro==undefined || vm.tmodal_data.CodPro==null">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.DesLoc}}">{{dato.DesLoc}}</option>                         
      </select>     
     </div>
     </div>
     </div> 

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_data.tipo_filtro==5">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodCom" ng-model="vm.tmodal_data.CodCom">
        <option ng-repeat="dato in vm.tComerciales" value="{{dato.NomCom}}">{{dato.NomCom}}</option>                        
      </select>   
     </div>
     </div>
    </div> 

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_data.tipo_filtro==6">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodCol" ng-model="vm.tmodal_data.CodCol">
        <option ng-repeat="dato in vm.tColaboradores" value="{{dato.NomCol}}">{{dato.NomCol}}</option>                        
      </select>   
     </div>
     </div>
    </div>    

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_data.tipo_filtro==7">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstCliFil" name="EstCliFil" ng-model="vm.tmodal_data.EstCliFil">
        <option value="1">ACTIVO</option> 
        <option value="2">SUSPENDIDO</option>                         
      </select>     
     </div> 
     </div>
     </div>     
    <br ng-show="vm.tmodal_data.tipo_filtro==3">
     <br ng-show="vm.tmodal_data.tipo_filtro==3"> 
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid"><i class="fa fa-check-circle"></i> Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_clientes()" ng-show="vm.tmodal_data.tipo_filtro>0">Quitar</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->

<!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Suspender Clientes</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" required readonly />
      <form class="form-validate" id="form_lock2" name="form_lock2" ng-submit="submitFormlock($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.NumCif" readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Suspensi??n</label>
     <input type="text" class="form-control datepicker" ng-model="vm.FechBlo" id="FechBlo" name="FechBlo" required ng-change="vm.validar_fecha_blo(vm.FechBlo)" maxlength="10" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Raz??n Social</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.RazSoc" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Suspensi??n</label>
     
      <select class="form-control" name="MotBloq" required ng-model="vm.tmodal_data.MotBloq">
          <option ng-repeat="dato in vm.tMotivosBloqueos" value="{{dato.CodMotBloCli}}">{{dato.DesMotBloCli}}</option>
        </select>


     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsBloCli" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock2.$invalid">Suspender</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->

<!--modal modal_cif_cliente section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_cif_cliente" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
                        <h4 class="modal-title">Introduzca CIF:</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form" name="cif_consulta_form" ng-submit="Consultar_CIF_Clientes($event)"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">N??mero de CIF:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="CliDNI" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.fdatos.Clientes_CIF" placeholder="* Introduzca CIF" maxlength="50" required/>   
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form.$invalid">CONSULTAR</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_cif_cliente section END -->

<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FechBlo').on('changeDate', function() 
  {
     var FechBlo=document.getElementById("FechBlo").value;
     console.log("FechBlo: "+FechBlo);
  });
</script>

<!-- FINAL SECCION PARA MODALES-->
              </section>
            </div>
        </div>
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
          Dise??ado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Informaci??n"></div>
<div id="List_Cli" class="loader loader-default"  data-text="Cargando listado de Clientes"></div>

<div id="borrando" class="loader loader-default"  data-text="Eliminando Cliente"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
