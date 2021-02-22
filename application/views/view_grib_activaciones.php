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
  <div ng-controller="Controlador_Activaciones as vm">
    <!-- modal container section start -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_contrato_rapido_final" class="modal fade">
      <div class="modal-dialog" style="width: auto;">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Contrato Rapido CUPs: {{vm.CUPsName}}</h4>
          </div>
          <div class="modal-body" style="background-color: white;">
            <div class="panel">                  
              <form id="register_form_contratos" name="register_form_contratos" ng-submit="submitFormContratos($event)"> 
                 <div class='row'>              
                   <div class="col-12 col-sm-6">
                     <div class="form">                          
                       <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre</label>
                         
                         <input type="text" class="form-control" ng-model="vm.RazSocCli" placeholder="* Razón Social / Apellidos, Nombre" maxlength="50" readonly="readonly" />
                         
                       </div>
                     </div>
                   </div>

                   <div class="col-12 col-sm-6">
                     <div class="form">                          
                       <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento Fiscal</label>
                         <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="Nº Documento Fiscal" maxlength="50" readonly="readonly" />
                         
                       </div>
                     </div>
                   </div> 
                    
              
        <!--- PARA LOS CUPS ELECTRICOS START-->
      <div ng-show="vm.contrato_fdatos.TipCups==1"> 
   <div class="foreign-supplier-title clearfix">
        <h4 class="breadcrumb">     
          <span class="foreign-supplier-text" style="color:black;">  CUPs Eléctrico Fechas</span><div align="right" style="margin-top: -16px;"></div>
        </h4>
      </div>    
<div class="col-12 col-sm-6">
  <div class="form">                          
   <div class="form-group">
     <label class="font-weight-bold nexa-dark">Fecha Vencimiento</label>
     <input type="text"  class="form-control FecVenCUPs_Ele" id="FecVenCUPs_Ele" ng-model="vm.FecVenCUPs_Ele" placeholder="DD/MM/YYYY" ng-change="vm.ValidarFechasInput(vm.FecVenCUPs_Ele,1)"/>
   </div>
 </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form">                          
   <div class="form-group">
     <label class="font-weight-bold nexa-dark">Fecha Activación</label>
     <input type="text"  class="form-control FecActCUPs_Ele" id="FecActCUPs_Ele"  ng-model="vm.FecActCUPs_Ele" placeholder="DD/MM/YYYY" ng-change="vm.ValidarFechasInput(vm.FecActCUPs_Ele,2)"/>
   </div>
 </div>
</div>

</div>
<!--- PARA LOS CUPS ELECTRICOS END -->



<!--- PARA LOS CUPS GAS START-->
<div ng-show="vm.contrato_fdatos.TipCups==2">

<div class="foreign-supplier-title clearfix">
        <h4 class="breadcrumb">     
          <span class="foreign-supplier-text" style="color:black;">  CUPs Gas Fechas</span><div align="right" style="margin-top: -16px;"></div>
        </h4>
      </div>
<div class="col-12 col-sm-6">
  <div class="form">                          
   <div class="form-group">
     <label class="font-weight-bold nexa-dark">Fecha Vencimiento</label>
     <input type="text"  class="form-control FecVenCUPs_Gas" id="FecVenCUPs_Gas"  ng-model="vm.FecVenCUPs_Gas" placeholder="DD/MM/YYYY" ng-change="vm.ValidarFechasInput(vm.FecVenCUPs_Gas,3)"/>
   </div>
 </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form">                          
   <div class="form-group">
     <label class="font-weight-bold nexa-dark">Fecha Activación</label>
     <input type="text"  class="form-control FecActCUPs_Gas" id="FecActCUPs_Gas"  ng-model="vm.FecActCUPs_Gas" placeholder="DD/MM/YYYY" ng-change="vm.ValidarFechasInput(vm.FecActCUPs_Gas,4)"/>
   </div>
 </div>
</div>

</div>
<!--- PARA LOS CUPS GAS END -->
<div class="foreign-supplier-title clearfix">
        <h4 class="breadcrumb">     
          <span class="foreign-supplier-text" style="color:black;">  Documentos Contrato</span><div align="right" style="margin-top: -16px;"></div>
        </h4>
      </div>

     <div class="form">                          
       <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black; padding-left:15px">Agregar Documento </label>
         <div id="file-wrap" style="cursor: pointer">
          <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
          <input type="file" id="file_fotocopia"  name="file_fotocopia" class="file_b" ng-model="vm.imagen" onchange="angular.element(this).scope().SelectFile(event)" draggable="true">
          <div id="file_fotocopia1"></div>                       
        </div>
        <script>      
      /*$('#file_fotocopia').on('change', function() 
      {          
        const $file_fotocopia = document.querySelector("#file_fotocopia");
        //console.log($file_fotocopia);
        let file_fotocopia = $file_fotocopia.files;                      
        filenameDocCliDoc = '<i class="fa fa-file"> '+$file_fotocopia.files[0].name+'</i>';
        $('#file_fotocopia1').html(filenameDocCliDoc);
       // console.log($file_fotocopia.files[0].name);
     });*/    
   </script> 
 </div>
</div>


<div class="table-responsive">
  <table class="table table-striped table-advance table-hover table-responsive">
    <tbody>
      <tr>
        <th> Nombre Documento</th>
        <th> Acción</th>
      </tr> 
      <tr ng-show="vm.contrato_fdatos.TDocumentosContratos.length==0"> 
        <td colspan="2" align="center"><div class="td-usuario-table">No hay información disponible</div></td>
      </tr>
      <tr ng-repeat="dato in vm.contrato_fdatos.TDocumentosContratos" ng-class-odd="odd">                    
        <td>{{dato.DocGenCom}}</td>
        <td >
          <a title='Ver Archivo {{dato.DocGenCom}}' class="btn btn-info btn-icon mg-r-5" target="_black" href="uploads/{{dato.DocConRut}}"><div><i class="fa fa-eye" style="color:white;"></i></div></a>
          <!--a ng-click="vm.borrar_row($index,dato.CodDetDocCon)" title='Eliminar Archivo {{dato.DocGenCom}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a-->
        </td>
      </tr>
    </tbody>
    <tfoot>
      <th> Nombre Documento</th>
      <th> Acción</th>
    </tfoot>
  </table>
</div>




<div class="form">                          
 <div class="form-group">
   <label class="font-weight-bold nexa-dark" style="color:black;padding-left:15px">Comentarios</label>
   <textarea class="form-control" name="ObsCon" id="ObsCon" rows="5" placeholder="Comentarios" ng-model="vm.contrato_fdatos.ObsCon" ></textarea>        
 </div>
</div>
<input class="form-control" id="CodConCom_1" name="CodConCom_1" type="hidden" ng-model="vm.contrato_fdatos.CodConCom" readonly/>
<div class="form-group" >
  <div class="col-12 col-sm-12">
    
    <!--button class="btn btn-info" id="showtoast6" type="button" style="margin-top: 0px;" target="_black"  ng-click="vm.generar_contratos_t(vm.contrato_fdatos,2)">Generar T2</button>
    <button class="btn btn-info" id="showtoast7" type="button" style="margin-top: 0px;" target="_black"  ng-click="vm.generar_contratos_t(vm.contrato_fdatos,3)">Generar T3</button>
    <button class="btn btn-info" id="showtoast8" type="button" style="margin-top: 0px;" target="_black"  ng-click="vm.generar_contratos_t(vm.contrato_fdatos,4)">Generar T4</button>

    <a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Contrato_Comercial_Cliente_PDF/{{vm.contrato_fdatos.CodConCom}}" style="margin-top: 9px;" target="_black" >Generar PDF</a-->

    <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.anterior_paso_contrato()">Volver</button>
     <button class="btn btn-success" type="submit"  ng-disabled="vm.disabled_button==true">Grabar</button>
  </div>
</div>

</div><!--FINAL ROW -->
</form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
<!--modal container section end -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Activaciones CUPS</h3>
          </div>
        </div>

        <!-- Form validations -->
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">               
                <div class="panel-body">
                  
                  <form id="form_buscar_cups" name="form_buscar_cups"> 
                    <div class='row'> 
                      <div class="col-12 col-sm-12">
                        <div class="form">                          
                          <div class="form-group">
                            <label class="font-weight-bold nexa-dark" style="color:black;">CUPs</label>
                            <input type="text" class="form-control " name="CUPsName" id="CUPsName" ng-model="vm.CUPsName" placeholder="ES0306000018000121QK" maxlength="30" />
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group" >
                          <div class="col-12 col-sm-4">
                            <button class="btn btn-info" type="submit" ng-disabled="vm.CUPsName.length<=0" ng-click="vm.buscarCUPsActivaciones()">Buscar</button>


                            <button class="btn btn-primary" type="button" ng-show="vm.VistaResponse==true" ng-click="vm.GenerarContratoRapido(2)">Generar Contrato Rapido</button>

                            <button class="btn btn-primary" type="button" ng-show="vm.VistaResponseSinData==true" ng-click="vm.GenerarContratoRapido(1)">Generar Contrato Rapido</button>

                          </div>
                        </div> 
                    </div><!--FINAL ROW -->
                  </form>
                  <div ng-show="vm.VistaResponse==true && vm.T_Contratos.length>0">
      
                                        <form id="form_update_fechas" name="form_update_fechas" ng-submit="submitFormCUPsActivacionesFechas($event)"> 
                                            <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Cliente</label>
                                                  <input type="text" class="form-control " name="RazSocCli" id="RazSocCli" ng-model="vm.RazSocCli" readonly/>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">CUPs</label>
                                                  <input type="text" class="form-control " name="CUPsNameResponse" id="CUPsNameResponse" ng-model="vm.CUPsName" readonly/>
                                                </div>
                                              </div>
                                            </div>

                                              <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Nro Contrato</label>
                                                  <input type="text" class="form-control " name="CodConCom" id="CodConCom" ng-model="vm.fdatos.CodConCom" readonly/>
                                                </div>
                                              </div>
                                            </div>

                                              <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Tárifa</label>                
                                                  <select class="form-control" name="NomTar" required ng-model="vm.NomTar" ng-change="vm.filtrerCanPeriodos(vm.NomTar)">
                                                    <option ng-repeat="dato in vm.ListTar" value="{{dato.CodTar}}" >{{dato.NomTar}}</option>                  
                                                  </select> 
                                                </div>
                                              </div>
                                            </div>

                                          <div ng-show="vm.CanPerEle==6">
                                            
                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
                                               <input type="text"  class="form-control" ng-model="vm.PotEleConP1" placeholder="P1" ng-change="vm.validar_formatos_input(1,vm.PotEleConP1)"/>     
                                               </div>
                                               </div>
                                            </div>

                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
                                               <input type="text"  class="form-control" ng-model="vm.PotEleConP2" placeholder="P2" ng-change="vm.validar_formatos_input(2,vm.PotEleConP2)"/>     
                                               </div>
                                               </div>
                                            </div>

                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
                                               <input type="text"  class="form-control" ng-model="vm.PotEleConP3" placeholder="P3" ng-change="vm.validar_formatos_input(3,vm.PotEleConP3)"/>     
                                               </div>
                                               </div>
                                            </div>

                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
                                               <input type="text"  class="form-control" ng-model="vm.PotEleConP4" placeholder="P4" ng-change="vm.validar_formatos_input(4,vm.PotEleConP4)"/>     
                                               </div>
                                               </div>
                                            </div>

                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
                                               <input type="text"  class="form-control" ng-model="vm.PotEleConP5" placeholder="P5" ng-change="vm.validar_formatos_input(5,vm.PotEleConP5)"/>
                                             </div>
                                               </div>
                                            </div>

                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
                                               <input type="text"  class="form-control" ng-model="vm.PotEleConP6" placeholder="P6" ng-change="vm.validar_formatos_input(6,vm.PotEleConP6)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             
                                          </div>

                                          <div ng-show="vm.CanPerEle==1"> 

                                            <div class="col-12 col-sm-11">
                                                <div class="form">                          
                                                 <div class="form-group">    
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
                                                 <input type="text" class="form-control" ng-model="vm.PotEleConP1" placeholder="P1" ng-change="vm.validar_formatos_input(1,vm.PotEleConP1)"/>     
                                                 </div>
                                                 </div>
                                              </div>
                                          </div>

                                          <div ng-show="vm.CanPerEle==2">

                                            <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP1" placeholder="P1" ng-change="vm.validar_formatos_input(1,vm.PotEleConP1)"/>     
                                               </div>
                                               </div>
                                            </div>

                                              <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP2" placeholder="P2" ng-change="vm.validar_formatos_input(2,vm.PotEleConP2)"/>     
                                               </div>
                                               </div>
                                            </div>         

                                          </div>

                                          <div ng-show="vm.CanPerEle==3">
                                            
                                            <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP1" placeholder="P1" ng-change="vm.validar_formatos_input(1,vm.PotEleConP1)"/>     
                                               </div>
                                               </div>
                                            </div>

                                             <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP2" placeholder="P2" ng-change="vm.validar_formatos_input(2,vm.PotEleConP2)"/>     
                                               </div>
                                               </div>
                                            </div>

                                             <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP3" placeholder="P3" ng-change="vm.validar_formatos_input(3,vm.PotEleConP3)"/>     
                                               </div>
                                               </div>
                                            </div>
                                          </div>

                                          <div ng-show="vm.CanPerEle==4">          
                                            
                                            <div class="col-12 col-sm-3">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP1" placeholder="P1" ng-change="vm.validar_formatos_input(1,vm.PotEleConP1)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-3">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP2" placeholder="P2" ng-change="vm.validar_formatos_input(2,vm.PotEleConP2)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-3">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP3" placeholder="P3" ng-change="vm.validar_formatos_input(3,vm.PotEleConP3)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-3">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP4" placeholder="P4" ng-change="vm.validar_formatos_input(4,vm.PotEleConP4)"/>     
                                               </div>
                                               </div>
                                            </div>         
                                          </div>

                                          <div ng-show="vm.CanPerEle==5">
                                            
                                            <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP1" placeholder="P1" ng-change="vm.validar_formatos_input(1,vm.PotEleConP1)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP2" placeholder="P2" ng-change="vm.validar_formatos_input(2,vm.PotEleConP2)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP3" placeholder="P3" ng-change="vm.validar_formatos_input(3,vm.PotEleConP3)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-2">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP4" placeholder="P4" ng-change="vm.validar_formatos_input(4,vm.PotEleConP4)"/>     
                                               </div>
                                               </div>
                                            </div>
                                             <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                               <div class="form-group">    
                                                <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
                                               <input type="text" class="form-control" ng-model="vm.PotEleConP5" placeholder="P5" ng-change="vm.validar_formatos_input(5,vm.PotEleConP5)"/>     
                                               </div>
                                               </div>
                                            </div>

                                          </div>



                                            <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Producto</label>
                                                  <select class="form-control" name="DesPro" required ng-model="vm.DesPro">
                                                    <option ng-repeat="dato in vm.ListProducts" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                  
                                                  </select> 

                                                </div>
                                              </div>
                                            </div>

                                            <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Activación</label>
                                                  <input type="text" class="form-control FecActCUPs" name="FecActCUPs" id="FecActCUPs" ng-model="vm.FecActCUPs" ng-change="vm.validar_formatos_input(7,vm.FecActCUPs)"/>
                                                </div>
                                              </div>
                                            </div>

                                              <div class="col-12 col-sm-4">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Vencimiento</label>
                                                  <input type="text" class="form-control FecVenCUPs" name="FecVenCUPs" id="FecVenCUPs" ng-model="vm.FecVenCUPs" ng-change="vm.validar_formatos_input(8,vm.FecVenCUPs)"/>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Consumo</label>
                                                  <input type="text" class="form-control " name="ConCup" id="ConCup" ng-model="vm.ConCup" ng-change="vm.validar_formatos_input(9,vm.ConCup)"/>
                                                </div>
                                              </div>
                                            </div>

                                             <div class="col-12 col-sm-6">
                                              <div class="form">                          
                                                <div class="form-group">
                                                  <label class="font-weight-bold nexa-dark" style="color:black;">Estado</label>
                                                  <select class="form-control" name="EstConCups" required ng-model="vm.EstConCups">
                                                    <option ng-repeat="dato in vm.ListNuevosEstadosContrato" value="{{dato.EstConCups}}">{{dato.nombre}}</option>                  
                                                  </select> 


                                                  <!--input type="text" class="form-control " name="EstConCups" id="EstConCups" ng-model="vm.EstConCups" /-->
                                                </div>
                                              </div>
                                            </div>


                                            <div class="form-group" >
                                              <div class="col-12 col-sm-4">
                                                <button class="btn btn-info" type="submit">Actualizar</button>
                                              </div>
                                            </div>
                                        </form>
                </div>






                </div><!--panel-body FINAL-->
              </section>
            </div>
          </div>
      </section>
    </section>
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
      <!-- modal container section start -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_lista_contratos" class="modal fade">
      <div class="modal-dialog" style="width: auto;">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Listado de Contratos</h4>
          </div>
          <div class="modal-body" style="background-color: white;">
            <div class="panel">                  

  <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th >Nro Contrato</th>
                  <th >Cliente</th>
                  <th >CUPs</th>
                  <th >Tárifa</th>
                  <th >Tipo de producto</th>
                  <th >Fecha de activación</th>
                  <th >Fecha de Vencimiento</th>
                  <th >Consumo</th> 
                  <th >Estado</th>          
                  <th >Acción</th>
                  </tr>
                  <tr ng-show="vm.T_Contratos.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_Contratos | filter:paginate" ng-class-odd="odd">                    
                    <td >{{dato.CodConCom}}</td>
                    <td >{{dato.RazSocCli}}</td>
                    <td >{{dato.CUPsName}}</td>
                    <td >{{dato.NomTar}}</td>
                    <td >{{dato.DesPro}}</td>
                    <td >{{dato.FecActCUPs}}</td>
                    <td >{{dato.FecVenCUPs}}</td>
                    <td >{{dato.ConCup}}</td> 
                    <td >
                      <span class="label label-danger" ng-show="dato.CodProCom==null" style="color:black;"><i class="fa fa-ban"></i> S/P/C</span>
                      <span class="label label-success" ng-show="dato.EstConCups==1" style="color:black;"><i class="fa fa-check-circle"></i> Contrato</span>
                      <span class="label label-danger" ng-show="dato.EstConCups==2" style="color:black;"><i class="fa fa-ban"></i> Implícita</span>
                      <span class="label label-info" ng-show="dato.EstConCups==3" style="color:black;"><i class="fa fa-close"></i> Baja Rescatable</span>
                      <span class="label label-danger" ng-show="dato.EstConCups==4" style="color:black;"><i class="fa fa-ban"></i> Baja Definitiva</span>
                      </td>                   
                    <td>
                        <a style="cursor:pointer;" ng-click="vm.asignarcontrato($index,dato,true)" data-dismiss="modal"><i class="fa fa-check" title="Seleccionar"></i></a>
                    </td >

                  </tr>
                </tbody>
                <tfoot>                 
                 <th >Nro Contrato</th>
                  <th >Cliente</th>
                  <th >CUPs</th>
                  <th >Tárifa</th>
                  <th >Tipo de producto</th>
                  <th >Fecha de activación</th>
                  <th >Fecha de Vencimiento</th>
                  <th >Consumo</th> 
                  <th >Estado</th>          
                  <th >Acción</th> 
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <button class="btn btn-primary" type="button" ng-click="vm.GenerarContratoRapido(1)">Generar Contrato Rapido</button>
          <span class="store-qty"> <a ng-click="vm.buscarCUPsActivaciones()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>


            </div>
          </div>
        </div>
      </div>
    </div>
    <!--modal container section end -->

    <!-- modal container section start -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_contrato_rapido" class="modal fade">
      <div class="modal-dialog" style="width: auto;">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Contrato Rapido</h4>
          </div>
          <div class="modal-body" style="background-color: white;">
            <div class="panel">                  

              <form id="register_form_propuesta_comercial" name="register_form_propuesta_comercial" ng-submit="submitFormPropuesta($event)"> 
       <div class='row'>              
         
         <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre {{vm.contrato_fdatos.CodCli}}</label>
          
          <input type="text" class="form-control" ng-model="vm.RazSocCli" placeholder="* Razón Social / Apellidos, Nombre" maxlength="50" readonly="readonly"/>
         
         </div>
         </div>
         </div>

        <div class="col-12 col-sm-6">
           <div class="form">                          
           <div class="form-group">
           <label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento Fiscal</label>
          <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="Nº Documento Fiscal" maxlength="50" readonly="readonly" />
           </div>
           </div>
        </div>
        

      <div class="foreign-supplier-title clearfix">
        <h4 class="breadcrumb">     
          <span class="foreign-supplier-text" style="color:black;"> Puntos de Suministros - CUPs</span><div align="right" style="margin-top: -16px;"></div>
        </h4>
      </div>

     <div class="col-12 col-sm-12">       
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Seleccione una Dirección de Suministro</label>
         <select class="form-control" id="CodPunSum" name="CodPunSum" ng-model="vm.contrato_fdatos.CodPunSum" ng-change="vm.filter_DirPumSum(vm.contrato_fdatos.CodPunSum)" ng-disabled="vm.NumCifCli!=undefined||vm.RazSocCli!=undefined"> 
          <option ng-repeat="dato_act in vm.List_Puntos_Suministros" value="{{dato_act.CodPunSum}}">{{dato_act.DirPumSum}} {{dato_act.DesLoc}} {{dato_act.DesPro}} {{dato_act.CPLocSoc}} {{dato_act.EscPunSum}} {{dato_act.PlaPunSum}} {{dato_act.PuePunSum}}</option>
          </select>       
         </div>
         </div>
      </div>

    
        <!--- PARA LOS CUPS ELECTRICOS START-->
        <div ng-show="vm.contrato_fdatos.TipCups==1">
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Eléctrico</label>
               <select class="form-control" id="CodCupSEle" name="CodCupSEle" ng-model="vm.contrato_fdatos.CodCupSEle" ng-change="vm.CUPsFilter(1,vm.contrato_fdatos.CodCupSEle)" ng-disabled="vm.contrato_fdatos.CodPunSum!=undefined"> 
                  <option ng-repeat="dato_act in vm.List_CUPsEle" value="{{dato_act.CodCupsEle}}">{{dato_act.CUPsEle}}</option>
          </select>     
               </div>
               </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">   
                <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>          
               <select class="form-control" id="CodTarEle" name="CodTarEle" ng-model="vm.contrato_fdatos.CodTarEle" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.filtrerCanPeriodosModal(vm.contrato_fdatos.CodTarEle)"> 
                  <option ng-repeat="dato_act in vm.ListTar" value="{{dato_act.CodTar}}">{{dato_act.NomTar}}</option>
          </select>                  
               </div>
               </div>
            </div>        

          <div ng-show="vm.CanPerEleModalContratoRapido==6">
            
            <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP1" placeholder="P1" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(2,vm.contrato_fdatos.PotEleConP1)"/>     
               </div>
               </div>
            </div>

             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP2" placeholder="P2" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(3,vm.contrato_fdatos.PotEleConP2)"/>     
               </div>
               </div>
            </div>

             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP3" placeholder="P3" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(4,vm.contrato_fdatos.PotEleConP3)"/>     
               </div>
               </div>
            </div>

             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP4" placeholder="P4" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(5,vm.contrato_fdatos.PotEleConP4)"/>     
               </div>
               </div>
            </div>

             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP5" placeholder="P5" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(6,vm.contrato_fdatos.PotEleConP5)"/>     
               </div>
               </div>
            </div>

             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP6" placeholder="P6" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(7,vm.contrato_fdatos.PotEleConP6)"/>     
               </div>
               </div>
            </div>

          </div>

          <div ng-show="vm.CanPerEleModalContratoRapido==1">
            <div class="col-12 col-sm-11">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP1" placeholder="P1" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(2,vm.contrato_fdatos.PotEleConP1)"/>     
               </div>
               </div>
            </div>
          </div>

          <div ng-show="vm.CanPerEleModalContratoRapido==2">

            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP1" placeholder="P1" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(2,vm.contrato_fdatos.PotEleConP1)"/>     
               </div>
               </div>
            </div>

              <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP2" placeholder="P2" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(3,vm.contrato_fdatos.PotEleConP2)"/>     
               </div>
               </div>
            </div>

          </div>

          <div ng-show="vm.CanPerEleModalContratoRapido==3">
            
            <div class="col-12 col-sm-4">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP1" placeholder="P1" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(2,vm.contrato_fdatos.PotEleConP1)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-4">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP2" placeholder="P2" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(3,vm.contrato_fdatos.PotEleConP2)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-4">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP3" placeholder="P3" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(4,vm.contrato_fdatos.PotEleConP3)"/>     
               </div>
               </div>
            </div>

          </div>

          <div ng-show="vm.CanPerEleModalContratoRapido==4">
            
            <div class="col-12 col-sm-3">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP1" placeholder="P1" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(2,vm.contrato_fdatos.PotEleConP1)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-3">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP2" placeholder="P2" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(3,vm.contrato_fdatos.PotEleConP2)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-3">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP3" placeholder="P3" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(4,vm.contrato_fdatos.PotEleConP3)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-3">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP4" placeholder="P4" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(5,vm.contrato_fdatos.PotEleConP4)"/>     
               </div>
               </div>
            </div>


          </div>

          <div ng-show="vm.CanPerEleModalContratoRapido==5">
            
            <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP1" placeholder="P1" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(2,vm.contrato_fdatos.PotEleConP1)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP2" placeholder="P2" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(3,vm.contrato_fdatos.PotEleConP2)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-2">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP3" placeholder="P3" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(4,vm.contrato_fdatos.PotEleConP3)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-3">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP4" placeholder="P4" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(5,vm.contrato_fdatos.PotEleConP4)"/>     
               </div>
               </div>
            </div>
             <div class="col-12 col-sm-3">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.PotEleConP5" placeholder="P5" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined " ng-change="vm.validar_formatos_input(6,vm.contrato_fdatos.PotEleConP5)"/>     
               </div>
               </div>
            </div>

           
          </div>          
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">Consumo (KW/h)</label>         
               <input type="text"  class="form-control" style="margin-top: -1px;" ng-model="vm.contrato_fdatos.ConCupsEle" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined "/>     
               </div>
               </div>
            </div>
           
          <div class="col-12 col-sm-6">      
            <div class="form" >                          
             <div class="form-group">
              <textarea class="form-control" style="display: inline-block;" id="ObsCupEle" name="ObsCupEle" minlength="1" maxlength="200" rows="5" placeholder="Comentarios" ng-model="vm.contrato_fdatos.ObsCup" ng-disabled="vm.contrato_fdatos.CodCupSEle==undefined "></textarea>        
             </div>
             </div> 
          </div> 

      </div>
      <!--- PARA LOS CUPS ELECTRICOS END -->


      <!--- PARA LOS CUPS GAS START-->
      <div ng-show="vm.contrato_fdatos.TipCups==2">
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Gas </label>
               <select class="form-control" id="CodCupGas" name="CodCupGas" ng-model="vm.contrato_fdatos.CodCupGas" ng-disabled="vm.contrato_fdatos.CodPunSum!=undefined"> 
                  <option ng-repeat="dato_act in vm.List_CUPsGas" value="{{dato_act.CodCupGas}}">{{dato_act.CupsGas}}</option>
                </select>     
               </div>
               </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">   
                <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
               <select class="form-control" id="CodTarGas" name="CodTarGas" ng-model="vm.contrato_fdatos.CodTarGas" ng-disabled="vm.contrato_fdatos.CodCupGas==undefined "> 
                   <option ng-repeat="dato in vm.ListTar" value="{{dato.CodTar}}">{{dato.NomTar}}</option>
          </select>                  
               </div>
               </div>
            </div>        

             <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">Consumo Gas</label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.Consumo" placeholder="Consumo" ng-disabled="vm.contrato_fdatos.CodCupGas==undefined " ng-change="vm.validar_formatos_input(10,vm.contrato_fdatos.Consumo)"/>     
               </div>
               </div>
            </div>

             <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">    
                <label class="font-weight-bold nexa-dark" style="color:black;">Caudal Diario </label>         
               <input type="text"  class="form-control" ng-model="vm.contrato_fdatos.CauDiaGas" placeholder="Caudal Diario" ng-disabled="vm.contrato_fdatos.CodCupGas==undefined " ng-change="vm.validar_formatos_input(11,vm.contrato_fdatos.CauDiaGas)"/>     
               </div>
               </div>
            </div>

          


          <div class="form" >                          
         <div class="form-group">
          <textarea class="form-control" style="display: inline-block;"  id="ObsGas" name="ObsGas" minlength="1" maxlength="200" rows="5" placeholder="Comentarios" ng-model="vm.contrato_fdatos.ObsCupGas" ng-disabled="vm.contrato_fdatos.CodCupGas==undefined "></textarea>        
         </div>
         </div>  
        </div>
        <!--- PARA LOS CUPS GAS END -->

      <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
               <select class="form-control" id="CodCom" name="CodCom" required ng-model="vm.contrato_fdatos.CodCom" ng-change="vm.realizar_filtro(1,vm.contrato_fdatos.CodCom)" > 
                  <option ng-repeat="dato_act in vm.List_Comercializadora" value="{{dato_act.CodCom}}">{{dato_act.NomComCom}}</option>
          </select>     
               </div>
               </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">   
                <label class="font-weight-bold nexa-dark" style="color:black;">Producto </label>          
               <select class="form-control" id="CodPro" name="CodPro" required ng-model="vm.contrato_fdatos.CodPro" ng-disabled="vm.contrato_fdatos.CodCom==undefined || vm.List_Productos.length==0" ng-change="vm.realizar_filtro(2,vm.contrato_fdatos.CodPro)"> 
                  <option ng-repeat="dato_act in vm.List_Productos" value="{{dato_act.CodPro}}">{{dato_act.DesPro}}</option>
          </select>                  
               </div>
               </div>
            </div>  

             <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Anexo </label>
               <select class="form-control" id="CodAnePro" name="CodAnePro" required ng-model="vm.contrato_fdatos.CodAnePro" ng-disabled="vm.contrato_fdatos.CodCom==undefined || vm.contrato_fdatos.CodPro==undefined " ng-change="vm.realizar_filtro(3,vm.contrato_fdatos.CodAnePro)"> 
                  <option ng-repeat="dato_act in vm.List_Anexos" value="{{dato_act.CodAnePro}}">{{dato_act.DesAnePro}}</option>
          </select>     
               </div>
               </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <div class="form">                          
               <div class="form-group">   
                <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Precio </label>          
               <select class="form-control" id="TipPre" name="TipPre" required ng-model="vm.contrato_fdatos.TipPre" ng-disabled="vm.contrato_fdatos.CodAnePro==undefined"> 
                  <option ng-repeat="dato_act in vm.List_TipPre" value="{{dato_act.TipPre}}">{{dato_act.nombre}}</option>
          </select>                  
               </div>
               </div>
            </div>  

          <div class="form-group" >
            <div class="col-12 col-sm-6">                          
              <button class="btn btn-success" type="button" ng-click="vm.siguiente_paso_contrato()">Siguiente</button>
            </div>
          </div>       
         
  </form> 
           </div>
          </div>
        </div>
      </div>
    </div>
<!--modal container section end -->




  </div><!-- FINAL DIV NG-CONTROLLER -->
    <script>
    
    $('.FecActCUPs').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
    $('#FecActCUPs').on('changeDate', function() 
    {
       var FecActCUPs=document.getElementById("FecActCUPs").value;
       //console.log("FecActCUPs: "+FecActCUPs);
    });
   
    $('.FecVenCUPs').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
    $('#FecVenCUPs').on('changeDate', function() 
    {
       var FecVenCUPs=document.getElementById("FecVenCUPs").value;
       //console.log("FecVenCUPs: "+FecVenCUPs);
    });

    $('.FecVenCUPs_Ele').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
    $('#FecVenCUPs_Ele').on('changeDate', function() 
    {
       var FecVenCUPs_Ele=document.getElementById("FecVenCUPs_Ele").value;
       //console.log("FecVenCUPs_Ele: "+FecVenCUPs_Ele);
    });
   
    $('.FecActCUPs_Ele').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
    $('#FecActCUPs_Ele').on('changeDate', function() 
    {
       var FecActCUPs_Ele=document.getElementById("FecActCUPs_Ele").value;
       //console.log("FecActCUPs_Ele: "+FecActCUPs_Ele);
    });
    $('.FecVenCUPs_Gas').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
    $('#FecVenCUPs_Gas').on('changeDate', function() 
    {
       var FecVenCUPs_Gas=document.getElementById("FecVenCUPs_Gas").value;
      // console.log("FecVenCUPs_Gas: "+FecVenCUPs_Gas);
    });
   
    $('.FecActCUPs_Gas').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
    $('#FecActCUPs_Gas').on('changeDate', function() 
    {
       var FecActCUPs_Gas=document.getElementById("FecActCUPs_Gas").value;
       //console.log("FecActCUPs_Gas: "+FecActCUPs_Gas);
    });



    



    
  </script>
  <script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
    <!-- custom form validation script for this page-->
    <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  </body>
  <div id="buscando" class="loader loader-default"  data-text="Buscando CUPs Contratos"></div>
  </html>
