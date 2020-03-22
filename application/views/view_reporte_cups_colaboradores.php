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
<body>
 <div ng-controller="Controlador_Colaboradores as vm">
 <!--main content start-->
    <section id="main-content">
    <!--wrapper start-->
    <section class="wrapper">
    <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-cube"></i>Reporte Cups por Colaboradores</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Reporte Cups por Colaboradores</li>
            </ol>
          </div>
    </div>




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
                         <li><input type="checkbox" ng-model="vm.NomComCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Nombre</b></li>
                         <li><input type="checkbox" ng-model="vm.NumCifCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF o NIF</b></li></li>
                         <li><input type="checkbox" ng-model="vm.RazSocCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Razón Social</b></li>
                         <li><input type="checkbox" ng-model="vm.CupsCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Cups</b></li>
                         <li><input type="checkbox" ng-model="vm.NomVia"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Dirección Social</b></li>
                         <li><input type="checkbox" ng-model="vm.NomViaFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Dirección Fiscal</b></li>
                         <li><input type="checkbox" ng-model="vm.DireccionCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Dirección BBDD</b></li>
                         <li><input type="checkbox" ng-model="vm.EmailCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Email</b></li>
                         <li><input type="checkbox" ng-model="vm.TelCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono</b></li>
                  </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Clientes_x_Colaboradores/{{vm.vColaboradorSeleccionado}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Clientes_x_Colaboradores/{{vm.vColaboradorSeleccionado}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                         
                </ul>
              </div>
              
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                  <select class="form-control" id="opciones_colaboradores" name="opciones_colaboradores" 
                      ng-model="vm.vColaboradorSeleccionado"
                      ng-change="vm.Clientes_x_Colaboradores(vm.vColaboradorSeleccionado)">
                      <option ng-repeat="opcion in vm.tOnlyColaboradores" value="{{opcion.CodCol}}">{{opcion.NomCol}}</option>                          
                  </select>  
                  </div>  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
        
        <div align="center">
        	<br>
        	 <span class="material-input" ng-show="vm.spinner_loader==1" style="margin-left: 235px;"><img src="application/libraries/estilos/img/ajax-loader.gif"> <b style="color:black;">Buscando, Por Favor Espere...</b> </span>
            <span class="material-input" ng-show="vm.data_result==1" style="color:green;"><i class="fa fa-check-circle"></i> Datos encontrados...</span>
            <span class="material-input" ng-show="vm.data_result==2" style="color:red;"><i class="fa fa-close"></i> No se encontraron datos...</span>
            <br>
        </div>
        
        <div class="row">
          <br>
        </div>
        <br>
        <!--INICIO DE TABLA-->
        <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>                                       
                    <th ng-show="vm.NomComCli==true"><i class="fa fa-user-circle"></i> NOMBRE</th>
                    <th ng-show="vm.NumCifCli==true"><i class="fa fa-vcard"></i> CIF/NIF</th>
                    <th ng-show="vm.RazSocCli==true"><i class="fa fa-vcard"></i> RAZÓN SOCIAL</th>
                    <th ng-show="vm.CupsCol==true"><i class="fa fa-bar-chart"></i> CUPS</th>
                    <th ng-show="vm.NomVia==true"><i class="fa fa-phone"></i> DIRECCIÓN SOCIAL</th>
                    <th ng-show="vm.NomViaFis==true"><i class="fa fa-phone"></i> DIRECCIÓN FISCAL</th>
                    <th ng-show="vm.DireccionCol==true"><i class="fa fa-phone"></i> DIRECCIÓN BBDD</th>
                    <th ng-show="vm.EmailCol==true"><i class="fa fa-phone"></i> EMAIL</th>
                    <th ng-show="vm.TelCol==true"><i class="fa fa-phone"></i> TELÉFONO</th>
                  </tr>
                  <tr ng-show="vm.tClientes_x_Colaboradores.length==0"> 
                     <td colspan="9" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.tClientes_x_Colaboradores | filter:paginate" ng-class-odd="odd">                    
                    <td ng-show="vm.NomComCli==true">{{dato.NomComCli}}</td>
                    <td ng-show="vm.NumCifCli==true">{{dato.NumCifCli}}</td>
                    <td ng-show="vm.RazSocCli==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.CupsCol==true">{{dato.Cups}}</td>
                    <td ng-show="vm.NomVia==true">{{dato.NomViaDomSoc}} {{dato.NumViaDomSoc}} {{dato.BloDomSoc}} {{dato.EscDomSoc}} {{dato.PlaDomSoc}} {{dato.PueDomSoc}} {{dato.CodPro}} {{dato.CodLoc}}</td>                   
                    <td ng-show="vm.NomViaFis==true">{{dato.NomViaDomFis}} {{dato.NumViaDomFis}} {{dato.BloDomFis}} {{dato.EscDomFis}} {{dato.PlaDomFis}} {{dato.PueDomFis}} {{dato.CodProFis}} {{dato.CodLocFis}}</td>
                    <td ng-show="vm.DireccionCol==true">{{dato.DireccionBBDD}}</td>
                    <td ng-show="vm.EmailCol==true">{{dato.EmaCli}}</td>
                    <td ng-show="vm.TelCol==true">{{dato.TelFijCli}}</td>
                  </tr>
                </tbody>
                <tfoot>                 
                   <th ng-show="vm.NomComCli==true"><i class="fa fa-user-circle"></i> NOMBRE</th>
                    <th ng-show="vm.NumCifCli==true"><i class="fa fa-vcard"></i> CIF/NIF</th>
                    <th ng-show="vm.RazSocCli==true"><i class="fa fa-vcard"></i> RAZÓN SOCIAL</th>
                    <th ng-show="vm.CupsCol==true"><i class="fa fa-bar-chart"></i> CUPS</th>
                    <th ng-show="vm.NomVia==true"><i class="fa fa-phone"></i> DIRECCIÓN SOCIAL</th>
                    <th ng-show="vm.NomViaFis==true"><i class="fa fa-phone"></i> DIRECCIÓN FISCAL</th>
                    <th ng-show="vm.DireccionCol==true"><i class="fa fa-phone"></i> DIRECCIÓN BBDD</th>
                    <th ng-show="vm.EmailCol==true"><i class="fa fa-phone"></i> EMAIL</th>
                    <th ng-show="vm.TelCol==true"><i class="fa fa-phone"></i> TELÉFONO</th>
                </tfoot>
              </table>
        </div>       
        <!--FIN DE TABLA-->
     </div>

    <!-- page end-->
    </section>
    <!--wrapper end-->
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
          Diseñador Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
    </div>
  </div>
</div> <!--fin div controller-->

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
          $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            //mixDate: "<?php echo date("m/d/Y")?>"
            //maxDate: "<?php echo date("m/d/Y")?>"
        });
      });

        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</body>
</html>
