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
            <h3 class="page-header">Reporte de CUPs por Colaborador. Total Registros: {{vm.tClientes_x_Colaboradores.length}}</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Reporte Cups por Colaboradores</li>
            </ol>-->
          </div>
    </div>
    <div class="row">
            <div class="col-lg-12">
              <!--panel start-->
              <section class="panel">

              			              		   
				     <div class="col-12 col-sm-6">
				     <div class="form">                          
				     <div class="form-group">
				     <label class="font-weight-bold nexa-dark" style="color:black;">Seleccione Tipo de Contacto</label>
				      <select class="form-control" id="tipo_filtro" name="tipo_filtro" required ng-model="vm.fdatos.tipo_filtro" ng-change="vm.ValidarCambioTipoContacto()">
				         <option value="1">Colaborador</option> 
				        <option value="2">Prescriptor</option>
				        </select>     
				     </div>
				     </div>
				     </div>
     				<div class="col-12 col-sm-6">
						<div class="form">                          
											<div class="form-group">    
												<label class="font-weight-bold nexa-dark" style="color:black;">Ingrese Nombre o CIF </label>         
												<input type="text"  class="form-control" ng-model="vm.ColSearch" placeholder="Nombre o CIF del Contacto" id="NombreCIF" name="NombreCIF" ng-disabled="vm.fdatos.tipo_filtro==null" ng-keyup='vm.fetchColaboradoresCUPs()'/>  
												 <ul id='searchResult' style="height: 250px; overflow-y: auto;">
								                  <li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
								                  {{ result.CodConCli }},  {{ result.NIFConCli }} - {{ result.NomConCli }} 
								                  </li>
								                </ul>    
											</div>
											<input type="hidden" name="vColaboradorSeleccionado" id="vColaboradorSeleccionado" ng-model="vm.vColaboradorSeleccionado">
						</div>
						</div> 
					<div class="t-0029"><!--t-0029 start--> 
					    <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
					        <div class="btn-group">
					            <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> 
					                <span class="caret"></span>
					            </button>
					            <ul class="dropdown-menu">
					            	  <li><input type="checkbox" ng-model="vm.NomComCli"/> <b style="color:black;">Nombre</b></li>
			                         	<li><input type="checkbox" ng-model="vm.NumCifCli"/> <b style="color:black;">CIF o NIF</b></li></li>
			                         	<li><input type="checkbox" ng-model="vm.RazSocCli"/> <b style="color:black;">Razón Social</b></li>
			                         <li><input type="checkbox" ng-model="vm.CupsCol"/> <b style="color:black;">Cups</b></li>
			                         <li><input type="checkbox" ng-model="vm.NomVia"/> <b style="color:black;">Dirección Social</b></li>
			                         <li><input type="checkbox" ng-model="vm.NomViaFis"/> <b style="color:black;">Dirección Fiscal</b></li>
			                         <li><input type="checkbox" ng-model="vm.DireccionCol"/> <b style="color:black;">Dirección BBDD</b></li>
			                         <li><input type="checkbox" ng-model="vm.EmailCol"/> <b style="color:black;">Email</b></li>
			                         <li><input type="checkbox" ng-model="vm.TelCol"/> <b style="color:black;">Teléfono</b></li>
					                       
					            </ul> 
					        </div>
					              <div class="btn-group " align="center" ng-show="vm.Nivel==1 || vm.Nivel==2">
					                <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
					                <ul class="dropdown-menu">
					                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Clientes_x_Colaboradores/{{vm.vColaboradorSeleccionado}}/{{vm.fdatos.tipo_filtro}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
					                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Clientes_x_Colaboradores/{{vm.vColaboradorSeleccionado}}/{{vm.fdatos.tipo_filtro}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                         
					                </ul>
					              </div>
					              
					    </div><!--t-0031 end--> 
         			</div><!--t-0029 end--> 
              		  <div align="center">
			        	<br>
			        	 <span class="material-input" ng-show="vm.spinner_loader==1" style="margin-left: 235px;"><img src="application/libraries/estilos/img/ajax-loader.gif"> <b style="color:black;">Buscando, por favor espere ...</b> </span>
			            <span class="material-input" ng-show="vm.data_result==1" style="color:green;"><i class="fa fa-check-circle"></i> Datos encontrados...</span>
			            <span class="material-input" ng-show="vm.data_result==2" style="color:red;"><i class="fa fa-close"></i> No existen datos...</span>
			            <br>
			        </div>
			         <br>
        <!--INICIO DE TABLA-->
        <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>                                       
                    <!--th ng-show="vm.NomComCli==true">Nombre</th-->
                    <th ng-show="vm.NumCifCli==true">CIF/NIF</th>
                    <th ng-show="vm.RazSocCli==true">Razón Social</th>
                    <th ng-show="vm.CodCupEle==true">CUPS</th>
                    <th ng-show="vm.TarEle==true">Tárifa</th> 
                    <th ng-show="vm.ConCupEle==true">Consumó</th>
                    <th ng-show="vm.CodProEle==true">Producto</th>
                    <!--th ng-show="vm.CupsColGas==true">CUPS Gas</th>
                    <th ng-show="vm.TarGas==true">Tárifa</th>                        
                    <th ng-show="vm.ConCupGas==true">Consumó</t>
                    <th ng-show="vm.CodProGas==true">Producto</thh-->
                    <th ng-show="vm.CodCom==true">Comercializadora</th>
                    <!--th ng-show="vm.NomVia==true"> Dirección Social</th-->
                    <th ng-show="vm.NomViaFis==true"> Dirección Fiscal</th>
                    <th ng-show="vm.DireccionCol==true"> Dirección BBDD</th>
                    <th ng-show="vm.EmailCol==true"> Email</th>
                  </tr>
                  <tr ng-show="vm.tClientes_x_Colaboradores.length==0"> 
                     <td colspan="16" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.tClientes_x_Colaboradores | filter:paginate" ng-class-odd="odd">                    
                    <!--td ng-show="vm.NomComCli==true">{{dato.Cups_RazSocCli}}</td-->
                    <td ng-show="vm.NumCifCli==true">{{dato.Cups_Cif}}</td>
                    <td ng-show="vm.RazSocCli==true">{{dato.Cups_RazSocCli}}</td>
                    <td ng-show="vm.CodCupEle==true">{{dato.CupsGas}}</td>
                    <td ng-show="vm.TarEle==true">{{dato.NomTarGas}}</td>
                    <td ng-show="vm.ConCupEle==true">{{dato.ConAnuCup}}</td>
                    <td ng-show="vm.CodProEle==true">{{dato.CodProEle}}</td>
                    <!--td ng-show="vm.CupsColGas==true">{{dato.CupsGas}}</td>
                    <td ng-show="vm.TarGas==true">{{dato.NomTarGas}}</td>
                    <td ng-show="vm.ConCupGas==true">{{dato.ConCupGas}}</td>
                    <td ng-show="vm.CodProGas==true">{{dato.CodProGas}}</td-->
                    <td ng-show="vm.CodCom==true">{{dato.CodCom}}</td> 
                    <!--td ng-show="vm.NomVia==true">{{dato.NomViaDomSoc}} {{dato.NumViaDomSoc}} {{dato.BloDomSoc}} {{dato.EscDomSoc}} {{dato.PlaDomSoc}} {{dato.PueDomSoc}} {{dato.CodPro}} {{dato.CodLoc}}</td-->                
                    <td ng-show="vm.NomViaFis==true">{{dato.NomViaDomFis}} {{dato.NumViaDomFis}} {{dato.BloDomFis}} {{dato.EscDomFis}} {{dato.PlaDomFis}} {{dato.PueDomFis}} {{dato.CodProFis}} {{dato.CodLocFis}}</td>
                    <td ng-show="vm.DireccionCol==true">{{dato.DireccionBBDD}}</td>
                    <td ng-show="vm.EmailCol==true">{{dato.EmaCli}}</td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <!--th ng-show="vm.NomComCli==true">Nombre</th-->
                    <th ng-show="vm.NumCifCli==true">CIF/NIF</th>
                    <th ng-show="vm.RazSocCli==true">Razón Social</th>
                    <th ng-show="vm.CodCupEle==true">CUPS</th>
                    <th ng-show="vm.TarEle==true">Tárifa</th> 
                    <th ng-show="vm.ConCupEle==true">Consumó</th>
                    <th ng-show="vm.CodProEle==true">Producto</th>
                    <!--th ng-show="vm.CupsColGas==true">CUPS Gas</th>
                    <th ng-show="vm.TarGas==true">Tárifa</th>                        
                    <th ng-show="vm.ConCupGas==true">Consumó</t>
                    <th ng-show="vm.CodProGas==true">Producto</thh-->
                    <th ng-show="vm.CodCom==true">Comercializadora</th>
                    <!--th ng-show="vm.NomVia==true"> Dirección Social</th-->
                    <th ng-show="vm.NomViaFis==true"> Dirección Fiscal</th>
                    <th ng-show="vm.DireccionCol==true"> Dirección BBDD</th>
                    <th ng-show="vm.EmailCol==true"> Email</th>
                </tfoot>
              </table>
        </div>       
        <!--FIN DE TABLA--> <div align="center">               
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>

        	</section>
        </div></div>

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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
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
