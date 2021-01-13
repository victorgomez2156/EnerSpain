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

	.file-item{
		background: white;
		height: 35px;
		padding: 10px;
		margin-left: 0;
		font-size: 12px;
		border-bottom: 1px solid gainsboro;
	}

	.file_b{
		position:absolute;
		left:0;
		top:0;
		background:red;
		width:100%;
		height:100%;
		opacity:0;
	}     

	#file-wrap{
		position:relative;
		width:100%;
		padding: 5px;
		display: block;
		border: 2px dashed #ccc;
		margin: 0 auto;
		text-align: center;
		box-sizing:border-box;
		border-radius: 5px;
	}


	.file_b{
		position:absolute;
		left:0;
		top:0;
		background:red;
		width:100%;
		height:100%;
		opacity:0;
	}
	.table-responsive {
		min-height: .01%;
		overflow-x: auto
	}

	@media screen and (max-width:767px) 
	{
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
		width: 250px;
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
</style>

<body>
	<div ng-controller="Controlador_Dashbord as vm">
		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
				<!--overview start-->

				<!--Dashboard start -->
				<div class="row" style="margin-top: 20px;">

					<div class="col-md-6 portlets" style="padding-left: 5px; padding-right: 5px;">
						<!-- View Information -->
						<div class="panel panel-default">
							<div class="panel-body" ng-click='vm.containerClicked()'>
								<div id="t-0002" ><!--t-0002 start-->   
									<div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
										<div class="t-0029"><!--t-0029 start--> 
											<div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->

												<div class="btn-group" ng-show="vm.Nivel==1 && vm.response_customer.CodCli>0 || vm.Nivel==2 && vm.response_customer.CodCli>0 ">
													<button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
													<ul class="dropdown-menu">
														<li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_Clientes_Dashboard_PDF/{{vm.response_customer.CodCli}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
														<!--li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Clientes_Dashboard_Excel/{{vm.response_customer.CodCli}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li-->                         
													</ul>
												</div> <div id="xcontainer"></div>              
											</div><!--t-0031 end--> 
										</div><!--t-0029 end--> 
									</div><!--DIV removeformobile end-->
								</div>
								<div style="float: right; margin-left:-100px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
									<div class="t-0029">
										<form class="form-inline" role="form">
											<div class="form-group">
												<input type='text' ng-keyup='vm.fetchClientes()' ng-click='vm.searchboxClicked($event)' ng-model='vm.searchText' placeholder='Buscar Cliente...' class="form-control">

												<ul id='searchResult' style="height: 250px; overflow-y: auto;">
													<li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
														<div ng-show="result.NumCifCli!=''">NumCli: {{ result.CodCli }}, {{ result.NumCifCli }} - </div>{{ result.RazSocCli }} 
													</li>
												</ul>

											</div><button class="btn btn-info" ng-click="vm.fetchClientes()" type="button"><i class="fa fa-search"></i></button>  
										</form>                    
									</div>
								</div><!--t-0002 end-->
								<br><br><br><br><br>	        

								<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(1)">
									<h4 class="breadcrumb">     
										<span class="foreign-supplier-text" style="color:black;"> Datos Generales {{vm.tModalDatosClientes.CodCli}} <i class="fa fa-plus-square" title="Agregar Nuevo Cliente" ng-click="vm.agregar_datos_dashboard(5)"></i></span><div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showDatosGenerales?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
									</h4>
								</div>
								<div ng-if="vm.showDatosGenerales">   
									<div ng-show="vm.response_customer.CodCli==undefined">      
										<div align="center"><label style="color:black;">No hay información registrada</label></div>
									</div>

									<div ng-show="vm.response_customer.CodCli>0">

										<form class="form-validate" id="form_datos_generales" name="form_datos_generales">                 
											<input type="hidden" class="form-control" ng-model="vm.response_customer.CodCli"/>          
											<div class="col-12 col-sm-8">
												<div class="form">                          
													<div class="form-group">
														<label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre </label>
														<input type="text" class="form-control" id="RazSocCli" name="RazSocCli" placeholder="Razón Social / Apellidos, Nombre" ng-model="vm.response_customer.RazSocCli" readonly ng-click="vm.copyText(1)" /> 
													</div>
												</div>
											</div>

											<div class="col-12 col-sm-4">
												<div class="form">                          
													<div class="form-group">
														<label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento </label>
														<input type="text"  class="form-control" placeholder="Nº Documento" ng-model="vm.response_customer.NumCifCli" id="NumCifCli" name="NumCifCli" readonly ng-click="vm.copyText(2)"/>
													</div>
												</div>
											</div>

											<div class="col-12 col-sm-6">
												<div class="form">                          
													<div class="form-group">
														<label class="font-weight-bold nexa-dark" style="color:black;">Dom. Social</label> <label ng-show="vm.response_customer.CodPro!=vm.response_customer.CodProFis" class="font-weight-bold nexa-dark" style="color:black;"> / Dom. Fiscal</label>
														<input type="text" class="form-control" placeholder="Domicilio Social" ng-model="vm.response_customer.DomSoc" id="DomSoc" name="DomSoc" readonly ng-click="vm.copyText(3)"/>     
													</div>
												</div>
											</div>

											<div class="col-12 col-sm-6">
												<div class="form">                          
													<div class="form-group">
														<label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
														<input type="text" class="form-control" ng-model="vm.response_customer.EscPlaPuerSoc" placeholder="Escalera / Planta / Puerta" id="EscPlaPuerSoc" name="EscPlaPuerSoc" readonly ng-click="vm.copyText(4)"/>  
													</div>
												</div>
											</div>
											<div class="col-12 col-sm-4">
												<div class="form">                          
													<div class="form-group">
														<label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
														<input type="text" class="form-control" ng-model="vm.response_customer.DesSoc" placeholder="Localidad" readonly id="DesLocSoc" name="DesLocSoc" ng-click="vm.copyText(5)"/>     
													</div>
												</div>
											</div>
											<div class="col-12 col-sm-4">
												<div class="form">                          
													<div class="form-group">   
														<label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
														<input type="text" class="form-control" ng-model="vm.response_customer.ProSoc" placeholder="Provincia" readonly id="DesProSoc" name="DesProSoc" ng-click="vm.copyText(6)"/>     
													</div>
												</div>
											</div>

											<div class="col-12 col-sm-4">
												<div class="form">                          
													<div class="form-group">    
														<label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
														<input type="text"  class="form-control" ng-model="vm.response_customer.LocSoc" placeholder="Código Postal" readonly id="LocSoc" name="LocSoc" ng-click="vm.copyText(7)"/>     
													</div>
												</div>
											</div>


											<div ng-show="vm.response_customer.CodPro!=vm.response_customer.CodProFis">

												<div class="col-12 col-sm-6">
													<div class="form">                          
														<div class="form-group">
															<label class="font-weight-bold nexa-dark" style="color:black;">Domicilio Fiscal </label>
															<input type="text" class="form-control" placeholder="Domicilio Fiscal" ng-model="vm.response_customer.DomFis" id="DomFis" name="DomFis" readonly ng-click="vm.copyText(8)"/>     
														</div>
													</div>
												</div>

												<div class="col-12 col-sm-6">
													<div class="form">                          
														<div class="form-group">
															<label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
															<input type="text" class="form-control" ng-model="vm.response_customer.EscPlaPuerFis" placeholder="Escalera / Planta / Puerta" id="EscPlaPuerFis" name="EscPlaPuerFis"  readonly ng-click="vm.copyText(9)"/>  
														</div>
													</div>
												</div>
												<div class="col-12 col-sm-5">
													<div class="form">                          
														<div class="form-group">
															<label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
															<input type="text" class="form-control" ng-model="vm.response_customer.DesLocFis" placeholder="Localidad" readonly ng-click="vm.copyText(10)" id="DesLocFis" name="DesLocFis"/>     
														</div>
													</div>
												</div>
												<div class="col-12 col-sm-5">
													<div class="form">                          
														<div class="form-group">   
															<label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
															<input type="text" class="form-control" ng-model="vm.response_customer.DesProFis" placeholder="Provincia" readonly ng-click="vm.copyText(11)" id="DesProFis" name="DesProFis"/>     
														</div>
													</div>
												</div>

												<div class="col-12 col-sm-2">
													<div class="form">                          
														<div class="form-group">    
															<label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
															<input type="text"  class="form-control" ng-model="vm.response_customer.CPLocFis" placeholder="Código Postal" readonly ng-click="vm.copyText(12)" id="CPLocFis" name="CPLocFis"/>     
														</div>
													</div>
												</div>
											</div><!-- FINAL DIV SHOW DOM SOC DIST DOM FIS-->


											<div class="col-12 col-sm-6">
												<div class="form">                          
													<div class="form-group">  
														<label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo</label>           
														<input type="email" class="form-control" id="TelFijCli" name="TelFijCli" ng-model="vm.response_customer.TelFijCli" readonly ng-click="vm.copyText(13)"/>     
													</div>
												</div>
											</div>

											<div class="col-12 col-sm-6">
												<div class="form">                          
													<div class="form-group">  
														<label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Movil</label>           
														<input type="email" class="form-control" id="TelMovCli" name="TelMovCli" ng-model="vm.response_customer.TelMovCli" readonly ng-click="vm.copyText(20)"/>     
													</div>
												</div>
											</div>

											<div class="col-12 col-sm-6">
												<div class="form">                          
													<div class="form-group">  
														<label class="font-weight-bold nexa-dark" style="color:black;"> Email</label>           
														<input type="email" class="form-control" id="EmaCli" name="EmaCli" ng-model="vm.response_customer.EmaCli" readonly ng-click="vm.copyText(14)"/>     
													</div>
												</div>
											</div> 

											<div class="col-12 col-sm-6">
												<div class="form">                          
													<div class="form-group">  
														<label class="font-weight-bold nexa-dark" style="color:black;"> Email Opcional</label>           
														<input type="email" class="form-control" id="EmaCliOpc" name="EmaCliOpc" ng-model="vm.response_customer.EmaCliOpc" readonly ng-click="vm.copyText(21)"/>     
													</div>
												</div>
											</div> 
										</form>
										<div align="center"><a class="btn btn-success" href="#/Edit_Datos_Basicos_Clientes/{{vm.response_customer.CodCli}}" ng-disabled="vm.disabled_button==true"><i class="fa fa-edit"></i> Editar</a></div>
									</div>
								</div>
								<br>
								<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(2)">
									<h4 class="breadcrumb">     
										<span class="foreign-supplier-text" style="color:black;"> Contactos / Representante Legal <i class="fa fa-plus-square" title="Agregar Contactos" ng-click="vm.agregar_datos_dashboard(1)" ng-show="vm.response_customer.CodCli>0"></i></span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showContactosRepresentante?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
									</h4>
								</div>
								<div ng-if="vm.showContactosRepresentante">
									<div ng-show="vm.response_customer.Contactos.length==0">      
										<div align="center"><label style="color:black;">No hay información registrada</label></div>
									</div>

									<div class="row" ng-repeat="dato in vm.response_customer.Contactos">

										<div class="col-12 col-sm-3">
											<div class="form">                          
												<div class="form-group">
													<label class="font-weight-bold nexa-dark" style="color:black;">Nombre Completo </label>
													<input type="text" class="form-control" placeholder="Nombre Completo" ng-model="vm.response_customer.Contactos[$index].NomConCli" readonly id="NomConCli_{{$index}}" name="NomConCli_{{$index}}" ng-click="vm.copyTextArray(1,$index)"/>     
												</div>
											</div>
										</div>

										<div class="col-12 col-sm-3">
											<div class="form">                          
												<div class="form-group">
													<label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento </label>
													<input type="text" class="form-control" ng-model="vm.response_customer.Contactos[$index].NIFConCli" placeholder="Nº Documento" readonly ng-click="vm.copyTextArray(2,$index)" id="NIFConCli_{{$index}}" name="NIFConCli_{{$index}}"/>  
												</div>
											</div>
										</div>

										<div class="col-12 col-sm-2">
											<div class="form">                          
												<div class="form-group">
													<label class="font-weight-bold nexa-dark" style="color:black;">Cargo </label>
													<input type="text" class="form-control" ng-model="vm.response_customer.Contactos[$index].CarConCli" placeholder="Cargo" readonly  ng-click="vm.copyTextArray(3,$index)" id="CarConCli_{{$index}}" name="CarConCli_{{$index}}"/>     
												</div>
											</div>
										</div>

										<div class="col-12 col-sm-2">
											<div class="form">                          
												<div class="form-group">   
													<label class="font-weight-bold nexa-dark" style="color:black;">Representación </label>
													<input type="text" class="form-control" ng-model="vm.response_customer.Contactos[$index].TipRepr" placeholder="Representación" readonly  ng-click="vm.copyTextArray(4,$index)" id="TipRepr_{{$index}}" name="TipRepr_{{$index}}"/>     
												</div>
											</div>
										</div>

										<div class="col-12 col-sm-2">
											<div class="form">                          
												<div class="form-group">   
													<label class="font-weight-bold nexa-dark" style="color:white;">Acción </label>
													<a class="btn btn-success" href="#/Edit_Contactos/{{vm.response_customer.Contactos[$index].CodConCli}}" ng-disabled="vm.disabled_button==true"><i class="fa fa-edit"></i></a>   
												</div>
											</div>
										</div>
									</div>
								</div>              
							</div>
						</div>
					</div>

					<div class="col-md-6 portlets" style="padding-left: 5px; padding-right: 5px;">
						<!-- View Information -->
						<div class="panel panel-default">

							<div class="panel-body" >

								<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(3)">
									<h4 class="breadcrumb">     
										<span class="foreign-supplier-text" style="color:black;"> Puntos de Suministros <i class="fa fa-plus-square" title="Agregar CUPs" ng-click="vm.agregar_datos_dashboard(2)" ng-show="vm.response_customer.CodCli>0"></i></span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showPuntosSuministros?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
									</h4>
								</div>

								<div ng-if="vm.showPuntosSuministros">  

									<div ng-show="vm.response_customer.All_CUPs.length==0">      
										<div align="center"><label style="color:black;">No hay información registrada</label></div>
									</div>



									<div class="table-responsive" ng-show="vm.response_customer.All_CUPs.length>0">
										<table class="table table-striped table-advance table-hover table-responsive">
											<tbody>
												<tr>
													<th style="width: 207px;">CUPS</th>
													<th>Dirección de Suministro</th>
													<th style="width: 50px; text-align: center;">E/G</th>
													<th style="width: 100px;">Acción</th> 
												</tr>
												<tr ng-show="vm.response_customer.All_CUPs.length==0"> 
													<td colspan="4" align="center">
														<div class="td-usuario-table"><i class="fa fa-close"></i> No hay información.</div>
													</td>           
												</tr>
												<tr ng-repeat="dato in vm.response_customer.All_CUPs | filter:paginate" ng-class-odd="odd">                    
													<td><input type="text" class="form-control" ng-model="vm.response_customer.All_CUPs[$index].CUPsName" placeholder="CUPs {{vm.response_customer.All_CUPs[$index].TipServ}}" readonly id="CUPs_{{$index}}" name="CUPs_{{$index}}" ng-click="vm.copyTextArray(5,$index)"> </td>

													<td><input type="text" class="form-control" ng-model="vm.response_customer.All_CUPs[$index].DirPunSum" placeholder="CUPs {{vm.response_customer.All_CUPs[$index].TipServ}}" readonly id="DirPunSum_{{$index}}" name="DirPunSum_{{$index}}" ng-click="vm.copyTextArray(6,$index)">

													</td>
													<td><input type="text" class="form-control" ng-model="vm.response_customer.All_CUPs[$index].TipServ" placeholder="CUPs {{vm.response_customer.All_CUPs[$index].TipServ}}" readonly id="TipServ_{{$index}}" name="TipServ_{{$index}}" ng-click="vm.copyTextArray(7,$index)"> </td>                     
													<td> 
														<button title="Ver Detalles" class="btn btn-info" type="button" ng-click="vm.VerDetallesCUPs($index,dato,dato.TipServ)" ><i class="fa fa-eye"></i></button>

														<a class="btn btn-success" href="#/Edit_Cups/{{vm.response_customer.All_CUPs[$index].CodCups}}/{{vm.response_customer.All_CUPs[$index].TipServLetra}}"><i class="fa fa-edit"></i></a> 
													</td>
												</tr>
											</tbody>
											<tfoot>                 
												<th>CUPS</th>
												<th>Dirección de Suministro</th>
												<th style="text-align: center;">E/G</th>
												<th>Acción</th> 
											</tfoot>
										</table>
									</div>
								</div>

								<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(4)">
									<h4 class="breadcrumb">     
										<span class="foreign-supplier-text" style="color:black;"> Datos Bancarios <i class="fa fa-plus-square" title="Agregar Cuentas Bancarias" ng-click="vm.agregar_datos_dashboard(3)" ng-show="vm.response_customer.CodCli>0"></i></span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showCuentasBancarias?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
									</h4>
								</div>

								<div ng-if="vm.showCuentasBancarias">

									<div ng-show="vm.response_customer.Cuentas_Bancarias.length==0">      
										<div align="center"><label style="color:black;">No hay información registrada</label></div>
									</div>

									<div class="row" ng-repeat="dato in vm.response_customer.Cuentas_Bancarias">
										<div class="col-12 col-sm-8">
											<div class="form">                          
												<div class="form-group">
													<label class="font-weight-bold nexa-dark" style="color:black;">Cuenta Bancaria </label>
													<input type="text" class="form-control" ng-model="vm.response_customer.Cuentas_Bancarias[$index].NumIBan" readonly placeholder="Cuenta Bancaria" id="NumIBan_{{$index}}" name="NumIBan_{{$index}}" ng-click="vm.copyTextArray(17,$index)"/>     
												</div>
											</div>
										</div> 

										<div class="col-12 col-sm-4">
											<div class="form">                          
												<div class="form-group">    
													<label class="font-weight-bold nexa-dark" style="color:black;">Acción </label><br>         
													<a class="btn btn-success" href="#/Edit_Cuenta_Bancaria/{{vm.response_customer.Cuentas_Bancarias[$index].CodCueBan}}"><i class="fa fa-edit"></i></a>     
												</div>
											</div>
										</div> 



									</div>
								</div>

								<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(5)">
									<h4 class="breadcrumb">     
										<span class="foreign-supplier-text" style="color:black;"> Documentos <i class="fa fa-plus-square" title="Agregar Documentos" ng-click="vm.agregar_datos_dashboard(4)" ng-show="vm.response_customer.CodCli>0"></i></span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showDocumentos?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
									</h4>
								</div>

								<div ng-if="vm.showDocumentos">

									<div ng-show="vm.response_customer.documentos.length==0">      
										<div align="center"><label style="color:black;">No hay información registrada</label></div>
									</div>

									<div class="row" ng-repeat="dato in vm.response_customer.documentos">
										<div class="col-12 col-sm-5">
											<div class="form">                          
												<div class="form-group">
													<label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Documento </label>
													<input type="text" class="form-control" ng-model="vm.response_customer.documentos[$index].DesTipDoc" placeholder="Tipo de Documento" readonly id="DesTipDoc_{{$index}}" name="DesTipDoc_{{$index}}" ng-click="vm.copyTextArray(19,$index)"/>     
												</div>
											</div>
										</div>          

										<div class="col-12 col-sm-5">
											<div class="form">                          
												<div class="form-group">    
													<label class="font-weight-bold nexa-dark" style="color:black;">Fichero </label>         
													<input type="text"  class="form-control" ng-model="vm.response_customer.documentos[$index].DesDoc" placeholder="Fichero" readonly id="DesDoc_{{$index}}" name="DesDoc_{{$index}}" ng-click="vm.copyTextArray(20,$index)"/>     
												</div>
											</div>
										</div> 

										<div class="col-12 col-sm-2">
											<div class="form">                          
												<div class="form-group"> 
													<label class="font-weight-bold nexa-dark" style="color:black;">Acción </label>    
													<a class="btn btn-info" href="{{vm.response_customer.documentos[$index].ArcDoc}}" download="Documento"  type="button"><i class="fa fa-download"></i></a>     

													<a class="btn btn-success" href="#/Edit_Documentos/{{vm.response_customer.documentos[$index].CodTipDocAI}}"><i class="fa fa-edit"></i></a> 
												</div>
											</div>
										</div>

									</div>





								</div>
							</div>
						</div>
					</div>

					<div class="text-right">
						<div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
        -->
        Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
    </div>
</div>
</section>







<!-- modal container section start -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_agregarContactos" class="modal fade">
	<div class="modal-dialog" style="width: auto;">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">Agregar Contacto</h4>
			</div>
			<div class="modal-body" style="background-color: white;">
				<div class="panel">                  
					<form class="form-validate" id="form_contacto2" name="form_contacto2" ng-submit="submitFormRegistroContacto($event)">                 

						<div class="col-12 col-sm-10">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Número de Documento DNI/NIE/CIF <b style="color:red;">(*)</b></label>
									<input type="text" class="form-control" id="NIFConCli1" onkeyup="this.value=this.value.toUpperCase();" ng-model="vm.tContacto_data_modal.NIFConCli" maxlength="9" required ng-blur="vm.ValidarNumCIFContacto()"/>     
								</div>
							</div>
						</div>


						<div class="col-12 col-sm-2">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Es Principal </label>             
									<input type="checkbox" class="form-control" ng-model="vm.tContacto_data_modal.ConPrin" ng-click="vm.ComprobarContactoPrincipal(vm.tContacto_data_modal.ConPrin)"/> 

								</div>
							</div>
						</div>

						<div ng-show="vm.tContacto_data_modal.CodCli!=undefined">
							<div class="col-12 col-sm-3">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
										<select class="form-control" id="CodTipViaSoc" name="CodTipViaSoc"  placeholder="* Tipo de Via" ng-model="vm.tContacto_data_modal.CodTipViaSoc" ng-disabled="vm.validate_info!=undefined">
											<option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
										</select>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-5">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía <b style="color:red;">(*)</b></label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomViaDomSoc"   placeholder="* Nombre de la Via del Domicilio del Cliente" ng-disabled="vm.validate_info!=undefined"/>       
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía <b style="color:red;">(*)</b></label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumViaDomSoc"  min="1" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>       
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.BloDomSoc"  placeholder="* Bloque del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.EscDomSoc"  placeholder="* Escalera del Domicilio" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.PlaDomSoc"  placeholder="* Planta del Domicilio" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.PueDomSoc"  placeholder="* Puerta del Domicilio" maxlength="4" ng-disabled="vm.validate_info!=undefined"/>
									</div>
								</div>
							</div>


							<div class="col-12 col-sm-4" ng-click="vm.containerClicked()">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
										<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CPLocSoc" placeholder="* Zona Postal Social" ng-disabled="vm.validate_info!=undefined" ng-click='vm.searchboxClicked($event)' ng-keyup='vm.LocalidadCodigoPostal(1)'/>
										<ul id='searchResult'>
											<li ng-click='vm.setValueCPLoc($index,$event,result,1)' ng-repeat="result in vm.searchResultCPLoc" >
												{{ result.DesPro }}  / {{ result.DesLoc }} / {{ result.CPLoc }} 
											</li>
										</ul>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
										<select class="form-control" id="CodProtContacto_data_modal" name="CodProtContacto_data_modal"  ng-model="vm.tContacto_data_modal.CodProSoc" ng-change="vm.BuscarLocalidad(1,vm.tContacto_data_modal.CodProSoc)" ng-disabled="vm.validate_info!=undefined">
											<option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
										</select>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
										<select class="form-control" id="CodLoctContacto_data_modal" name="CodLoctContacto_data_modal" ng-model="vm.tContacto_data_modal.CodLocSoc" ng-disabled="vm.validate_info!=undefined" >
											<option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Contacto <b style="color:red;">(*)</b></label>
									<select class="form-control" id="CodTipCon" name="CodTipCon" ng-model="vm.tContacto_data_modal.CodTipCon"  ng-disabled="vm.no_editable!=undefined">
										<option ng-repeat="dato in vm.tListaContactos" value="{{dato.CodTipCon}}">{{dato.DesTipCon}}</option>
									</select>     
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Cargo <b style="color:red;">(*)</b></label>
									<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CarConCli"  maxlength="50"  ng-disabled="vm.no_editable!=undefined"/>     
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Nombre <b style="color:red;">(*)</b></label>
									<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomConCli"  maxlength="50"  ng-disabled="vm.no_editable!=undefined"/>  
								</div>
							</div>
						</div>


						<div class="col-12 col-sm-6">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Número de Colegiado </label>
									<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumColeCon" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
								</div>
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<div class="form">                          
								<div class="form-group">   
									<label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo <b style="color:red;">(*)</b></label>          
									<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.TelFijConCli"  ng-change="vm.validarsinuermoContactos(vm.tContacto_data_modal.TelFijConCli,1)" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<div class="form">                          
								<div class="form-group">    
									<label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Móvil </label>         
									<input type="text"  class="form-control" ng-model="vm.tContacto_data_modal.TelCelConCli"  ng-change="vm.validarsinuermoContactos(vm.tContacto_data_modal.TelCelConCli,2)" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<div class="form">                          
								<div class="form-group">  
									<label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>           
									<input type="email" class="form-control" ng-model="vm.tContacto_data_modal.EmaConCli"  maxlength="50" ng-disabled="vm.no_editable!=undefined"/>     
								</div>
							</div>
						</div>



						<div class="col-12 col-sm-3">
							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Es Representante Legal <b style="color:red;">(*)</b></label>             

									<br>
									<input type="radio" name="tipo_cliente" value="1" ng-model="vm.tContacto_data_modal.EsRepLeg" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined" ng-click="vm.verificar_representante_legal()">
									<label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

									<input type="radio" name="tipo_cliente" value="0" ng-model="vm.tContacto_data_modal.EsRepLeg" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined" ng-click="vm.verificar_representante_legal()">
									<label class="font-weight-bold nexa-dark" style="color:black;">No</label>


								</div>
							</div>
						</div>
						<div class="col-12 col-sm-3">
							<div class="form">                          
								<div class="form-group">  
									<label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Representación <b style="color:red;">(*)</b></label> 
									<select class="form-control" id="TipRepr" name="TipRepr" ng-model="vm.tContacto_data_modal.TipRepr" ng-disabled="vm.tContacto_data_modal.EsRepLeg==undefined||vm.tContacto_data_modal.EsRepLeg==0 || vm.no_editable!=undefined" >
										<option ng-repeat="dato in vm.tListaRepre" value="{{dato.id}}">{{dato.DesTipRepr}}</option>
									</select>     
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-3">
							<div class="form">                          
								<div class="form-group">  
									<label class="font-weight-bold nexa-dark" style="color:black;">Firmantes <b style="color:red;">(*)</b></label>           

									<input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CanMinRep" ng-change="vm.validarsinuermoContactos(vm.tContacto_data_modal.CanMinRep,3)" min="1" maxlength="4" ng-disabled="vm.no_editable!=undefined || vm.tContacto_data_modal.TipRepr!=='2'"/>     
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-3">
							<div class="form">                          
								<div class="form-group">  
									<label class="font-weight-bold nexa-dark" style="color:black;">Facultad de Escrituras </label>           
									<br>
									<input type="radio" name="TieFacEsc" value="1" ng-model="vm.tContacto_data_modal.TieFacEsc" ng-disabled="vm.no_editable!=undefined" ng-click="vm.verificar_facultad_escrituras()">
									<label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

									<input type="radio" name="TieFacEsc" value="0" ng-model="vm.tContacto_data_modal.TieFacEsc" ng-disabled="vm.no_editable!=undefined">
									<label class="font-weight-bold nexa-dark" style="color:black;">No</label>

								</div>
							</div>
						</div>
						<div style="margin-top: 8px;">
							<!--div align="center"><label class="font-weight-bold nexa-dark" style="color:gray;"><b>.</b></label></div></div-->

							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del DNI/NIE <a title='Descargar Documento' ng-show="vm.tContacto_data_modal.DocNIF!=null && vm.tContacto_data_modal.CodConCli>0" href="{{vm.tContacto_data_modal.DocNIF}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a>   </label>
									<div id="file-wrap" style="cursor: pointer">
										<p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
										<input type="file" id="filenameDocNIF" name="filenameDocNIF" class="file_b" ng-model="vm.imagen" onchange="angular.element(this).scope().SelectFile(event,1)" draggable="true" uploader-model="DocNIF" ng-disabled="vm.tContacto_data_modal.EsRepLeg==0||vm.tContacto_data_modal.EsRepLeg==undefined||vm.no_editable!=undefined">
										<div id="filenameDocNIF1"></div>                       
									</div>
								</div>
							</div>

							<div class="form">                          
								<div class="form-group">
									<label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del PODER <a title='Descargar Documento' ng-show="vm.tContacto_data_modal.DocPod!=null && vm.tContacto_data_modal.CodConCli>0" href="{{vm.tContacto_data_modal.DocPod}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>
									
									<div id="file-wrap" style="cursor: pointer">
										<p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
										<input type="file" id="DocPod" style="cursor: pointer;"  name="DocPod" class="file_b" ng-model="vm.imagen" onchange="angular.element(this).scope().SelectFile(event,2)" draggable="true" uploader-model="DocPod" ng-disabled="vm.tContacto_data_modal.TieFacEsc==1 || vm.tContacto_data_modal.TieFacEsc==undefined ||vm.no_editable!=undefined" draggable="true">
										<div id="filenameDocPod"></div>                       
									</div>
								</div>
							</div>	

<div class="form">                          
	<div class="form-group">
		<label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
		<textarea type="text" class="form-control" ng-model="vm.tContacto_data_modal.ObsConC"  rows="5" maxlength="200" ng-disabled="vm.no_editable!=undefined"/></textarea>
	</div>
</div>
<input type="text" name="CodConCli" id="CodConCliModalDashboard" ng-model="vm.tContacto_data_modal.CodConCliModalDashboard">
<button class="btn btn-info" type="submit" ng-show="vm.tContacto_data_modal.CodConCli==undefined && vm.no_editable==undefined" ng-disabled="form_contacto2.$invalid">Registrar</button>

</form>
</div>
</div></div>
</div>
</div>
<!--modal container section end -->

































<!-- modal container section start -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_detalles_CUPs" class="modal fade">
	<div class="modal-dialog" style="width: auto;">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">Detalles de CUPs {{vm.ModalTipServ}}</h4>
			</div>
			<div class="modal-body" style="background-color: white;">
				<div class="panel">                  
					<form class="form-validate" id="frmFormDetalles" name="frmFormDetalles" ng-submit="SubmitFormDetalles($event)">                 

						<div class="row">
							<div class="col-12" style="margin-left: 15px; margin-right: 15px;">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">CUPs</label>
										<input type="text" class="form-control" id="CUpsNameModal" name="CUpsNameModal" required ng-model="vm.CUpsNameModal" readonly ng-click="vm.copyText(15)"/>
									</div>
								</div>
							</div>

							<div class="col-12" style="margin-left: 15px; margin-right: 15px;">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Dirección Suministro</label>
										<input type="text" class="form-control" id="DirPunSumModal" name="DirPunSumModal" required ng-model="vm.DirPunSumModal" readonly ng-click="vm.copyText(16)"/>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Tárifa</label>
										<input type="text" class="form-control" id="NomTarModal" name="NomTarModal" required ng-model="vm.NomTarModal" readonly ng-click="vm.copyText(17)"/>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<div class="form">                          
									<div class="form-group">
										<label class="font-weight-bold nexa-dark" style="color:black;">Distribuidora</label>
										<input type="text" class="form-control" id="RazSocDisModal" name="RazSocDisModal" required ng-model="vm.RazSocDisModal" readonly ng-click="vm.copyText(18)"/>
									</div>
								</div>
							</div>

							<div ng-if="vm.ModalTipServ=='E'">

								<div ng-show="vm.CanPerTar==1">
									<div class="col-12 col-sm-12">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P1</label>
												<input type="text" class="form-control" id="PotConP1Modal_1" name="PotConP1Modal_1" required ng-model="vm.PotConP1Modal" readonly />
											</div>
										</div>
									</div>
								</div>


								<div ng-show="vm.CanPerTar==2">   

									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P1</label>
												<input type="text" class="form-control" id="PotConP1Modal_2" name="PotConP1Modal_2" required ng-model="vm.PotConP1Modal" readonly />
											</div>
										</div>
									</div>


									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P2</label>
												<input type="text" class="form-control" id="PotConP2Modal_2" name="PotConP2Modal_2" required ng-model="vm.PotConP2Modal" readonly />
											</div>
										</div>
									</div>

								</div>

								<div ng-show="vm.CanPerTar==3">   

									<div class="col-12 col-sm-4" >
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P1</label>
												<input type="text" class="form-control" id="PotConP1Modal_3" name="PotConP1Modal_3" required ng-model="vm.PotConP1Modal" readonly />
											</div>
										</div>
									</div>


									<div class="col-12 col-sm-4">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P2</label>
												<input type="text" class="form-control" id="PotConP2Modal_3" name="PotConP2Modal_3" required ng-model="vm.PotConP2Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-4">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P3</label>
												<input type="text" class="form-control" id="PotConP3Modal_3" name="PotConP3Modal_3" required ng-model="vm.PotConP3Modal" readonly />
											</div>
										</div>
									</div>

								</div>

								<div ng-show="vm.CanPerTar==4">   

									<div class="col-12 col-sm-6" >
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P1</label>
												<input type="text" class="form-control" id="PotConP1Modal_4" name="PotConP1Modal_4" required ng-model="vm.PotConP1Modal" readonly />
											</div>
										</div>
									</div>


									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P2</label>
												<input type="text" class="form-control" id="PotConP2Modal_4" name="PotConP2Modal_4" required ng-model="vm.PotConP2Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P3</label>
												<input type="text" class="form-control" id="PotConP3Modal_4" name="PotConP3Modal_4" required ng-model="vm.PotConP3Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P4</label>
												<input type="text" class="form-control" id="PotConP4Modal_4" name="PotConP4Modal_4" required ng-model="vm.PotConP4Modal" readonly />
											</div>
										</div>
									</div>

								</div>

								<div ng-show="vm.CanPerTar==5">   

									<div class="col-12 col-sm-3" >
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P1</label>
												<input type="text" class="form-control" id="PotConP1Modal_5" name="PotConP1Modal_5" required ng-model="vm.PotConP1Modal" readonly />
											</div>
										</div>
									</div>


									<div class="col-12 col-sm-3">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P2</label>
												<input type="text" class="form-control" id="PotConP2Modal_5" name="PotConP2Modal_5" required ng-model="vm.PotConP2Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-3">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P3</label>
												<input type="text" class="form-control" id="PotConP3Modal_5" name="PotConP3Modal_5" required ng-model="vm.PotConP3Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-3">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P4</label>
												<input type="text" class="form-control" id="PotConP4Modal_5" name="PotConP4Modal_5" required ng-model="vm.PotConP4Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-12">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P5</label>
												<input type="text" class="form-control" id="PotConP5Modal_5" name="PotConP5Modal_5" required ng-model="vm.PotConP5Modal" readonly />
											</div>
										</div>
									</div>

								</div>


								<div ng-show="vm.CanPerTar==6">   

									<div class="col-12 col-sm-3" >
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P1</label>
												<input type="text" class="form-control" id="PotConP1Modal_6" name="PotConP1Modal_6" required ng-model="vm.PotConP1Modal" readonly />
											</div>
										</div>
									</div>


									<div class="col-12 col-sm-3">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P2</label>
												<input type="text" class="form-control" id="PotConP2Modal_6" name="PotConP2Modal_6" required ng-model="vm.PotConP2Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-3">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P3</label>
												<input type="text" class="form-control" id="PotConP3Modal_6" name="PotConP3Modal_6" required ng-model="vm.PotConP3Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-3">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P4</label>
												<input type="text" class="form-control" id="PotConP4Modal_6" name="PotConP4Modal_6" required ng-model="vm.PotConP4Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P5</label>
												<input type="text" class="form-control" id="PotConP5Modal_6" name="PotConP5Modal_6" required ng-model="vm.PotConP5Modal" readonly />
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-6">
										<div class="form">                          
											<div class="form-group">
												<label class="font-weight-bold nexa-dark" style="color:black;">P6</label>
												<input type="text" class="form-control" id="PotConP6Modal_6" name="PotConP6Modal_6" required ng-model="vm.PotConP6Modal" readonly />
											</div>
										</div>
									</div>

								</div>





							</div>

							<div class="foreign-supplier-title clearfix">
								<h4 class="breadcrumb">     
									<span class="foreign-supplier-text" style="color:black;"> Listado de Contratos Asignados</span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"></span></div>
								</h4>
							</div>
							<div style="width: 100%;
							margin-bottom: 15px;
							overflow-y: hidden;
							-ms-overflow-style: -ms-autohiding-scrollbar;
							border: 1px solid #ddd">
							<table class="table table-striped table-advance table-hover table-responsive">
								<tbody>
									<tr>
										<th >Nº Cliente</th>
										<th >Vigente</th>
										<th >Fecha Firma</th>
										<th >Fecha Fin</th>
										<th >Nº Contrato</th>
										<th >Consumo</th>
										<th >Comercializadora</th> 
										<th >Tárifa</th> 
										<th >Tipo Contrato</th>      
										<th >Agente</th>
									</tr>
									<tr ng-show="vm.ContratosTCups.length==0"> 
										<td colspan="10" align="center"><div class="td-usuario-table">No hay información disponible</div></td>
									</tr>
									<tr ng-repeat="dato in vm.ContratosTCups | filter:paginate1" ng-class-odd="odd">
										<td >{{dato.CodCli}}</td>                    
										<td >
											<span class="label label-success" ng-show="dato.EstBajCon==0"><i class="fa fa-check-circle"></i> Activo</span>
											<span class="label label-danger" ng-show="dato.EstBajCon==1"><i class="fa fa-ban"></i> Dado de Baja</span>
											<span class="label label-info" ng-show="dato.EstBajCon==2"><i class="fa fa-close"></i> Vencido</span>
											<span class="label label-primary" ng-show="dato.EstBajCon==3"><i class="fa fa-check-circle"></i> Renovado</span>
											<span class="label label-warning" ng-show="dato.EstBajCon==4"><i class="fa fa-check-clock-o"></i> En Renovación</span>
										</td>/
										<td >{{dato.FecFirmCon}}</td>
										<td >{{dato.FecFinCon}}</td>
										<td >{{dato.RefCon}}</td>
										<td >{{dato.ConCup}}</td>
										<td >{{dato.RazSocCom}}</td>
										<td >{{dato.NomTar}}</td>  
										<td >{{dato.TipCon}}</td>                   
										<td >
											{{dato.Agente}}
										</td>
									</tr>
								</tbody>
								<tfoot>
									<th >Nº Cliente</th>
									<th >Vigente</th>
									<th >Fecha Firma</th>
									<th >Fecha Fin</th>
									<th >Nº Contrato</th>
									<th >Consumo</th>
									<th >Comercializadora</th> 
									<th >Tárifa</th> 
									<th >Tipo Contrato</th>      
									<th >Agente</th>
								</tfoot>
							</table>
						</div>
						<div align="center">                
							<div class='btn-group' align="center">
								<pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
								</pagination>
							</div>
						</div>


					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!--modal container section end -->

<!--main content end-->
</div>
<div id="List_Cli" class="loader loader-default"  data-text="Cargando listado de Clientes"></div>
<div id="Buscando_Informacion" class="loader loader-default"  data-text="Buscando Información"></div>

<div id="Actualizando" class="loader loader-default"  data-text="Actualizando información"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando información"></div>

<script language="JavaScript">
    // Establecemos las variables
    var DesSoc = document.getElementById("RazSocCli");
    var contenedor = document.getElementById("xcontainer");
    //var copy   = document.getElementById("d_clip_url1");
    DesSoc.addEventListener('click', function(e) {
       // Sleccionando el texto
       console.log('pasando por aqui');
       DesSoc.select(); 
       try {
           // Copiando el texto seleccionado
           var successful = document.execCommand('DesSoc');     
           if(successful) contenedor.innerHTML = 'Copiado!';
           else contenedor.innerHTML = 'Incapaz de copiar!';
       } catch (err) {
       	contenedor.innerHTML = 'Browser no soportado!';
       }
   });
</script>


</body>
</html>
