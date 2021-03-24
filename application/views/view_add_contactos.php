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
 <div ng-controller="Controlador_Contactos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.tContacto_data_modal.CodConCli==undefined">Registro de Contacto del Cliente</h3>
            <h3 class="page-header" ng-show="vm.tContacto_data_modal.CodConCli>0">Actualización de Contacto del Cliente</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-child"></i>Registro de Contacto</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">             
              <div class="panel-body">
                <form class="form-validate" id="form_contacto2" name="form_contacto2" ng-submit="submitFormRegistroContacto($event)">                 
                  

                  <div class="col-12 col-sm-6" ng-click="vm.containerClickedNIFNombre(1)">
                    <div class="form">                          
                     <div class="form-group">
                     <label class="font-weight-bold nexa-dark" style="color:black;">Nombre <b style="color:red;">(*)</b></label>
                     <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomConCli" ng-keyup="vm.BuscarPorNombreoDni(1,vm.tContacto_data_modal.NomConCli)" maxlength="50"  ng-disabled="vm.no_editable!=undefined" ng-click='vm.searchboxClicked($event)'/>  
                     <ul id='searchResult'>
                          <li ng-click='vm.setValuePorCliente($index,$event,result,1)' ng-repeat="result in vm.ResultNombreContacto" >
                          {{ result.CodConCli }}, {{ result.NomConCli }} - {{ result.NIFConCli }} 
                          </li>
                        </ul>
                     </div>
                     </div>
                  </div>

                  <div class="col-12 col-sm-6">
                    <div class="form">                          
                     <div class="form-group">
                     <label class="font-weight-bold nexa-dark" style="color:black;">Número de Colegiado </label>
                     <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumColeCon" maxlength="9"  ng-disabled="vm.no_editable!=undefined"/>     
                     </div>
                     </div>
                  </div>

                  <div class="col-12 col-sm-6" ng-click="vm.containerClickedNIFNombre(2)">
                    <div class="form">                          
                      <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Número de Documento </label>
                        <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NIFConCli" maxlength="9" ng-disabled="vm.no_editable!=undefined" ng-keyup="vm.BuscarPorNombreoDni(2,vm.tContacto_data_modal.NIFConCli)" ng-click='vm.searchboxClicked($event)'/>
                         <ul id='searchResult'>
                          <li ng-click='vm.setValuePorCliente($index,$event,result,2)' ng-repeat="result in vm.ResultNIFContacto" >
                          {{ result.CodConCli }}, {{ result.NomConCli }} - {{ result.NIFConCli }} 
                          </li>
                        </ul>     
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
                        <label class="font-weight-bold nexa-dark" style="color:black;">Email </label>           
                        <input type="email" class="form-control" ng-model="vm.tContacto_data_modal.EmaConCli"  maxlength="50" ng-disabled="vm.no_editable!=undefined"/>     
                      </div>
                   </div>
                  </div>
                

                  



                            <div style="margin-top: 8px;">
                             <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Datos Envío de facturas.</b></label></div></div>

                             <div class="col-12 col-sm-3">
                             <div class="form">                          
                               <div class="form-group">
                                 <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via</label>
                                 <select class="form-control" id="CodTipViaFis" name="CodTipViaFis"  placeholder="* Tipo de Via" ng-model="vm.tContacto_data_modal.CodTipViaFis" ng-disabled="vm.validate_info!=undefined ">
                                   <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
                                 </select>
                               </div>
                             </div>
                           </div>

                           <div class="col-12 col-sm-5">
                             <div class="form">                          
                               <div class="form-group">
                                 <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía </label>
                                 <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomViaDomFis"  placeholder="* Nombre de la Via del Domicilio del Cliente" maxlength="100"  ng-disabled="vm.validate_info!=undefined"/>       
                               </div>
                             </div>
                           </div>

                           <div class="col-12 col-sm-4">
                             <div class="form">                          
                               <div class="form-group">
                                 <label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía </label>
                                 <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumViaDomFis"   min="1" placeholder="* Numero del Domicilio" maxlength="100" ng-disabled="vm.validate_info!=undefined" ng-change="vm.validar_fecha_blo(3,vm.tContacto_data_modal.NumViaDomFis)"/>       
                               </div>
                             </div>
                           </div>                       

                           <div class="col-12 col-sm-4" ng-click="vm.containerClickedFis()">
                             <div class="form">                          
                               <div class="form-group">
                                 <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
                                 <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CPLocFis" placeholder="* Zona Postal Fiscal" ng-disabled="vm.validate_info!=undefined || vm.tContacto_data_modal.distinto_a_social==false" ng-click='vm.searchboxClickedFis($event)' ng-keyup='vm.LocalidadCodigoPostal(2)'/>
                                 <ul id='searchResult'>
                                  <li ng-click='vm.setValueCPLoc($index,$event,result,2)' ng-repeat="result in vm.searchResultFis" >
                                    {{ result.DesPro }}  / {{ result.DesLoc }} / {{ result.CPLoc }} 
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>

                          <div class="col-12 col-sm-4">
                           <div class="form">                          
                             <div class="form-group">
                               <label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>
                               <select class="form-control" id="CodProFisc" name="CodProFisc"  ng-model="vm.tContacto_data_modal.CodProFis" ng-change="vm.BuscarLocalidad(2,vm.tContacto_data_modal.CodProFis)"  ng-disabled="vm.validate_info!=undefined">
                                <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-sm-4">
                         <div class="form">                          
                           <div class="form-group">
                             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
                             <select class="form-control" id="CodLocFis" name="CodLocFis" ng-model="vm.tContacto_data_modal.CodLocFis" ng-disabled="vm.validate_info!=undefined">
                              <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
                            </select>
                          </div>
                        </div>
                      </div>



            <!--div ng-show="vm.tContacto_data_modal.EsRepLeg==1">

                

            </div-->
                 
                   
            <div style="margin-top: 8px;">
             <div align="center"><label class="font-weight-bold nexa-dark" style="color:gray;"><b>Documentos del Contacto</b></label></div></div>
        

            <div class="form">                          
             <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del DNI/NIE <a title='Descargar Documento' ng-show="vm.tContacto_data_modal.DocNIF!=null && vm.tContacto_data_modal.CodConCli>0" href="{{vm.tContacto_data_modal.DocNIF}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a>   </label>
               
               <div id="file-wrap">
                  <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
                  <input type="file" id="DocNIF" class="file_b" uploader-model="DocNIF" ng-disabled="vm.no_editable!=undefined" draggable="true">
                  <div id="filenameDocNIF"></div>                       
                </div>

            </div>
             </div>
            

      <script>
                
            $('#DocNIF').on('change', function() 
            { const $Archivo_DocNIF = document.querySelector("#DocNIF");         
              let Archivo_DocNIF = $Archivo_DocNIF.files;                      
              namefileDocNIF = '<i class="fa fa-file"> '+$Archivo_DocNIF.files[0].name+'</i>';
                $('#filenameDocNIF').html(namefileDocNIF);
            });
                
            $('#DocPod').on('change', function() 
            {
              const $Archivo_DocPod = document.querySelector("#DocPod");           
              let Archivo_DocPod = $Archivo_DocPod.files;
              console.log(Archivo_DocPod);                      
              namefile = '<i class="fa fa-file"> '+$Archivo_DocPod.files[0].name+'</i>'; //$Archivo_DocPod.files[0].name;
                $('#filenameDocPod').html(namefile);
            });
      </script>

            <div class="form">                          
              <div class="form-group">
                <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
                <textarea type="text" class="form-control" ng-model="vm.tContacto_data_modal.ObsConC"  rows="5" maxlength="200" ng-disabled="vm.no_editable!=undefined"/></textarea>
              </div>
           </div>

                       
            <div style="margin-top: 8px;">
             <div align="center"><label class="font-weight-bold nexa-dark" style="color:gray;"><b>Datos del Cliente</b>  <a data-toggle="modal" title='Asignar Cliente al Contacto' data-target="#modal_agregar_clientes" class="btn btn-default"><div><i class="fa fa-plus-square"></i></div></a></label></div></div>
              
              <div class="table-responsive">
               <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th>CodCli</th>
                  <th>NIF</th>
                  <th>Razón Social</th>
                  <th>Es Representante Legal</th>
                  <th>Tipo Representación</th> 
                  <th>Firmantes</th>
                  <th>Facultad de Escrituras</th>
                  <th>Es Colaborador </th>
                  <th>Es Prescriptor</th>
                  <th>Documento Poder</th>
                  <th>Acción</th>
                  </tr>
                  <tr ng-show="vm.Tabla_Contacto.length==0"> 
                    <td colspan="11" align="center">
                      <div class="td-usuario-table">No Ahi clientes asignados a este contacto</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tabla_Contacto" ng-class-odd="odd">
                    <td >{{dato.CodCli}}</td>
                    <td >{{dato.NumCifCli}}</td>
                    <td >{{dato.RazSocCli}}</td>                    
                    <td>
                      <label ng-show="dato.EsRepLeg==null">N/A</label>
                      <label ng-show="dato.EsRepLeg==1">SI</label>
                      <label ng-show="dato.EsRepLeg==0">NO</label>
                    </td>
                    <td>
                      <label ng-show="dato.TipRepr==null">N/A</label>
                      <label ng-show="dato.TipRepr==1">INDEPENDIENTE</label>
                      <label ng-show="dato.TipRepr==2">MANCOMUNADA</label>
                    </td>
                    
                    <td >{{dato.CanMinRep}}</td>
                    
                    <td>
                      <label ng-show="dato.TieFacEsc==null">N/A</label>
                      <label ng-show="dato.TieFacEsc==1">SI</label>
                      <label ng-show="dato.TieFacEsc==0">NO</label></td>
                    <td >
                      <label ng-show="dato.EsColaborador==null">N/A</label>
                      <label ng-show="dato.EsColaborador==1">SI</label>
                      <label ng-show="dato.EsColaborador==0">NO</label>
                    </td>
                    <td>
                      <label ng-show="dato.EsPrescritor==null">N/A</label>
                      <label ng-show="dato.EsPrescritor==1">SI</label>
                      <label ng-show="dato.EsPrescritor==0">NO</label>
                    </td>
                    
                    <td>
                      <label ng-show="dato.DocPod==null">N/A</label>
                      <label ng-show="dato.DocPod!=null"><a class="btn btn-primary" target="_black" href="{{dato.DocPod}}"><i class="fa fa-eye"></i></a></label>
                    </td>
                    <td>
                       <a class="btn btn-primary" ng-click="vm.editar_Cliente($index,dato)"><i class="fa fa-edit"></i></a> 
                       <a class="btn btn-danger" ng-click="vm.Eliminar_Cliente($index,dato)"><i class="fa fa-trash"></i></a>
                     </td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th>CodCli</th>
                  <th>NIF</th>
                  <th>Razón Social</th>
                  <th>Es Representante Legal</th>
                  <th>Tipo Representación</th> 
                  <th>Firmantes</th>
                  <th>Facultad de Escrituras</th>
                  <th>Es Colaborador </th>
                  <th>Es Prescriptor</th>
                  <th>Documento Poder</th>
                  <th>Acción</th>
                </tfoot>
              </table>
        </div>


                  <button class="btn btn-info" type="submit" ng-show="vm.tContacto_data_modal.CodConCli==undefined && vm.no_editable==undefined" ng-disabled="form_contacto2.$invalid">Registrar</button>
                  <button class="btn btn-success" type="submit" ng-show="vm.tContacto_data_modal.CodConCli>0 && vm.no_editable==undefined">Actualizar</button>
                  <a class="btn btn-danger" ng-click="vm.regresar_contacto()">Volver</a>
                  <input type="hidden" class="form-control" ng-model="vm.tContacto_data_modal.CodConCli" readonly /> 
                </form>
              


              </div>
            </section>
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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_agregar_clientes" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Asignar Cliente a Contacto</h4>
          </div>
          <div class="modal-body">
            <div class="panel">                  
              <form class="form-validate" id="frmContactosClientes" name="frmContactosClientes" ng-submit="SubmitFormClienteContactos($event)">                 
                
                <div class="col-12 col-sm-12" ng-click="vm.containerClicked()">
                  <div class="form">                          
                    <div class="form-group">
                      <label class="font-weight-bold nexa-dark" style="color:black;">Clientes {{vm.CodCliInsert}} <b style="color:red;">(*)</b></label>
                      <input type="text" class="form-control" ng-model="vm.CodCliContacto" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes()' ng-click='vm.searchboxClicked($event)' ng-disabled="vm.restringir_cliente_cont==1||vm.no_editable!=undefined"/>
                        <ul id='searchResult'>
                          <li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
                          {{ result.CodCli }}, {{ result.NumCifCli }} - {{ result.RazSocCli }} 
                          </li>
                        </ul> 
                      <input type="hidden" name="CodCliInsert" id="CodCliInsert" ng-model="vm.CodCliInsert" class="form-control">
                    
                    </div>
                  </div>
                </div>
              
              <div class="col-12 col-sm-4">
                  <div class="form">                          
                   <div class="form-group">
                  <label class="font-weight-bold nexa-dark" style="color:black;">Representante Legal <b style="color:red;">(*)</b></label>             
                   
                  <br>
                   <input type="radio" name="tipo_cliente" value="1" ng-model="vm.EsRepLeg" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined||vm.EsPrescritor==1" ng-click="vm.verificar_representante_legal()">
                  <label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

                   <input type="radio" name="tipo_cliente" value="0" ng-model="vm.EsRepLeg" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined" ng-click="vm.verificar_representante_legal()">
                   <label class="font-weight-bold nexa-dark" style="color:black;">No</label>
                   </div>
                   </div>
                </div>

                <div class="col-12 col-sm-4">
                  <div class="form">                          
                   <div class="form-group">  
                    <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Representación <b style="color:red;">(*)</b></label> 
                    <select class="form-control" id="TipRepr" name="TipRepr" ng-model="vm.TipRepr" ng-disabled="vm.EsRepLeg==undefined||vm.EsRepLeg==0 || vm.no_editable!=undefined" >
                     <option ng-repeat="dato in vm.tListaRepre" value="{{dato.id}}">{{dato.DesTipRepr}}</option>
                  </select>     
                   </div>
                   </div>
                </div>


                 <div class="col-12 col-sm-4">
                  <div class="form">                          
                   <div class="form-group">  
                    <label class="font-weight-bold nexa-dark" style="color:black;">Firmantes <b style="color:red;">(*)</b></label>           
                   
                   <input type="text" class="form-control" ng-model="vm.CanMinRep" ng-change="vm.validarsinuermoContactos(vm.CanMinRep,3)" min="1" maxlength="4" ng-disabled="vm.no_editable!=undefined || vm.TipRepr!=='2'"/>     
                   </div>
                   </div>
                </div>
               
                <div class="col-12 col-sm-4">
                  <div class="form">                          
                   <div class="form-group">  
                    <label class="font-weight-bold nexa-dark" style="color:black;">Facultad de Escrituras </label>           
                   <br>
                   <input type="radio" name="TieFacEsc" value="1" ng-model="vm.TieFacEsc" ng-disabled="vm.no_editable!=undefined" ng-click="vm.verificar_facultad_escrituras()">
                  <label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

                   <input type="radio" name="TieFacEsc" value="0" ng-model="vm.TieFacEsc" ng-disabled="vm.no_editable!=undefined">
                   <label class="font-weight-bold nexa-dark" style="color:black;">No</label>

                   </div>
                   </div>
                </div>

                <div class="col-12 col-sm-4">
                  <div class="form">                          
                   <div class="form-group">
                      <label class="font-weight-bold nexa-dark" style="color:black;">Es Colaborador</label> 
                      <br>
                      <input type="radio" name="EsCol" value="1" ng-model="vm.EsColaborador" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined||vm.EsPrescritor==1" ng-click="vm.verificar_colaborador()">
                  <label class="font-weight-bold nexa-dark" style="color:black;">Si</label>
                   <input type="radio" name="EsCol" value="0" ng-model="vm.EsColaborador" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined" ng-click="vm.verificar_colaborador()">
                   <label class="font-weight-bold nexa-dark" style="color:black;">No</label>
                   </div>
                   </div>
                </div>

                 <div class="col-12 col-sm-4">
              <div class="form">                          
               <div class="form-group">
              <label class="font-weight-bold nexa-dark" style="color:black;">Es Prescriptor</label>             
               
              <br>
               <input type="radio" name="EsPresc" value="1" ng-model="vm.EsPrescritor" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined || vm.EsRepLeg==1||vm.EsColaborador==1" ng-click="vm.verificar_prescristor()">
              <label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

               <input type="radio" name="EsPresc" value="0" ng-model="vm.EsPrescritor" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined|| vm.EsRepLeg==1" ng-click="vm.verificar_prescristor()" >
               <label class="font-weight-bold nexa-dark" style="color:black;">No</label>

               </div>
               </div>
            </div>
             <div style="margin-top: 8px;">
             <div align="center"><label class="font-weight-bold nexa-dark" style="color:gray;"><b>Documentos del Cliente</b></label></div></div>
             <div class="form">                          
             <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del PODER <a title='Descargar Documento' ng-show="vm.DocPod!=null" href="{{vm.DocPod}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>

                <div id="file-wrap">
                  <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
                  <input  type="file" id="DocPod" class="file_b" uploader-model="DocPod" ng-disabled="vm.TieFacEsc==1 ||vm.no_editable!=undefined" draggable="true" ng-model="vm.imagen" onchange="angular.element(this).scope().SelectFile(event)">
                  <div id="filenameDocPod"></div>                       
                </div>
             </div>
             </div>

        
                <div style="margin-left:15px; ">
                  <button class="btn btn-info" type="submit" ng-disabled="frmContactosClientes.$invalid"><b style="color:black;">Asignar Cliente</b></button>
                </div>
            </form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


  </section>
</div>
  <!-- container section end -->
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>

<div id="cargando" class="loader loader-default"  data-text="Cargando listado de Comerciales"></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información del Contacto"></div>

<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>
<div id="Principal" class="loader loader-default"  data-text="Verificando Contacto Principal"></div>

</html>
