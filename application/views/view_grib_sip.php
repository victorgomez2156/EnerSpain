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
  <div ng-controller="Controlador_SIP as vm">
   
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">SIPS</h3>
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
                            <button class="btn btn-info" type="submit" ng-disabled="vm.CUPsName.length<=0" ng-click="vm.Servidor_API_Dynargy()">Buscar</button>
                          </div>
                        </div> 
                    </div><!--FINAL ROW -->
                  </form>

                <br>

                <div class="foreign-supplier-title clearfix">
                <h4 class="breadcrumb">     
                  <span class="foreign-supplier-text" style="color:black;"> Datos Dynargy </span>
                </h4>
                </div>
                  <div id="tabs_dynargy" class="ui-tabs-nav ui-corner-all">
                    <ul>
                      <li>
                        <a href="#tabs-1">Datos Suministros</a>
                      </li>       
                      <li>
                        <a href="#tabs-2">Consumo Activa</a>
                      </li> 
                      <li>
                        <a href="#tabs-3">Consumo Reactiva</a>
                      </li>       
                      <li>
                        <a href="#tabs-4">Maximetro</a>
                      </li>    
                    </ul>
                    <div id="tabs-1"> 
                      <div class="foreign-supplier-title clearfix">
                        <h4 class="breadcrumb">     
                          <span class="foreign-supplier-text" style="color:black;"> Datos del Punto de Suministro </span>
                        </h4>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-striped table-advance table-hover table-responsive">
                          <tbody>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>                             
                            </tr>
                            
                          <tr>                    
                            <td style="color: black;"><b style="color:black;">CUPS </b>                               
                              </td>
                              <td>{{vm.response_cups.cups}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Titular del suministro</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia contratada P1 (KW)</b>                               
                              </td>
                              <td> {{vm.response_cups.potenciasContratadasEnWP1}}                                  
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Código distribuidora </b>                               
                              </td>
                              <td>{{vm.response_cups.codigoEmpresaDistribuidora}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">CIF Titular</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia contratada P2 (KW)</b>                               
                              </td>
                              <td> {{vm.response_cups.potenciasContratadasEnWP2}}                                  
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Distribuidora </b>                               
                              </td>
                              <td>{{vm.response_cups.nombreEmpresaDistribuidora}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Dirección del Titular</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia contratada P3 (KW)</b>                               
                              </td>
                              <td>{{vm.response_cups.potenciasContratadasEnWP3}}                                 
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Tárifa </b>                               
                              </td>
                              <td>{{vm.response_cups.tarifaATR}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">C.P. del Titular
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia contratada P4 (KW)</b>                               
                              </td>
                              <td> {{vm.response_cups.potenciasContratadasEnWP4}}                                 
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Descripción tárifa </b>                               
                              </td>
                              <td>Sin Datos del API                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Localidad Titular</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia contratada P5 (KW)</b>                               
                              </td>
                              <td> {{vm.response_cups.potenciasContratadasEnWP5}}                                  
                              </td>
                          </tr>
                           <tr>                    
                              <td style="color: black;"><b style="color:black;">Tensión </b>                               
                              </td>
                              <td>{{vm.response_cups.Tension}}                                 
                              </td>
                              <td style="color: black;"><b style="color:black;">Provincia Titular</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia contratada P6 (KW)</b>                               
                              </td>
                              <td> {{vm.response_cups.potenciasContratadasEnWP6}}                                  
                              </td>
                          </tr>
                         
                           <tr>                    
                              <td style="color: black;"><b style="color:black;">Dirección suministro </b>                               
                              </td>
                              <td>Sin Datos del API                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Código CNAE</b>
                              </td>
                              <td> {{vm.response_cups.CNAE}}                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia máxima BIE</b>                               
                              </td>
                              <td> {{vm.response_cups.potenciaMaximaBIEW}}                                
                              </td>
                          </tr>


                          <tr>                    
                              <td style="color: black;"><b style="color:black;">C.P. suministro </b>                               
                              </td>
                              <td>{{vm.response_cups.codigoPostalPS}}                                 
                              </td>
                              <td style="color: black;"><b style="color:black;">CNAE</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Potencia máxima APM</b>                               
                              </td>
                              <td>{{vm.response_cups.potenciaMaximaAPMW}}                                  
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Localidad suministro </b>                               
                              </td>
                              <td>{{vm.response_cups.nombreMunicipioPS}}                                 
                              </td>
                              <td style="color: black;"><b style="color:black;">Teléfono</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Derechos de acceso (kw)</b>                               
                              </td>
                              <td> {{vm.response_cups.valorDerechosAccesoW}}                               
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Provincia suministro </b>                               
                              </td>
                              <td>{{vm.response_cups.nombreProvinciaPS}}                                  
                              </td>
                              <td style="color: black;"><b style="color:black;">Tipo titular</b>
                              </td>
                              <td> {{vm.response_cups.docIdentidad}}                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Relación de transformación</b>                               
                              </td>{{vm.response_cups.relacionTransformacionIntensidad}}
                              <td>                               
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Indicativo ICP</b>                               
                              </td>
                              <td>{{vm.response_cups.codigoPropiedadICP}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Persona de Contacto</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Fecha Cambio Comercializadora</b>                               
                              </td>
                              <td> {{vm.response_cups.fechaUltimoCambioComercializador}}                                 
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Propiedad ICP</b>                               
                              </td>
                              <td>{{vm.response_cups.propiedadICP}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Cargo del Contacto</b>
                              </td>
                              <td> Sin Datos del APi                              
                              </td>

                              <td style="color: black;"><b style="color:black;"> Fecha de alta</b>                               
                              </td>
                              <td>{{vm.response_cups.fechaAltaSuministro}}                                  
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Telegestionado</b>                               
                              </td>
                              <td>{{vm.response_cups.codigoTelegestion}} - {{vm.response_cups.tipoTelegestion}}                               
                              </td>
                              <td style="color: black;"><b style="color:black;">Primera vivienda</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Fecha ultima lectura</b>                               
                              </td>
                              <td>{{vm.response_cups.fechaUltimaLectura}}                                
                              </td>
                          </tr>
                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Perfil consumo</b>                               
                              </td>
                              <td>{{vm.response_cups.perfilConsumo}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Cortes</b>
                              </td>
                              <td> Sin Datos Del API                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Fecha caducidad BIE o APM</b>                               
                              </td>
                              <td> {{vm.response_cups.fechaCaducidadAPM}}                             
                              </td>
                          </tr>

                           <tr>                    
                              <td style="color: black;"><b style="color:black;">Tipo PM</b>                               
                              </td>
                              <td>{{vm.response_cups.codClasificacionPM}}                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Impago</b>
                              </td>
                              <td> {{vm.response_cups.informacionImpagos}}                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Suministro contratable</b>                               
                              </td>
                              <td> {{vm.response_cups.codigoPSContratable}}                              
                              </td>
                          </tr>

                          <tr>                    
                              <td style="color: black;"><b style="color:black;">Propiedad EM</b>                               
                              </td>
                              <td>Sin Datos del API                                
                              </td>
                              <td style="color: black;"><b style="color:black;">Depósito garantia</b>
                              </td>
                              <td> {{vm.response_cups.importeDepositoGarantiaEuros}}                              
                              </td>
                              <td style="color: black;"><b style="color:black;"> Estado no contratable</b>                               
                              </td>
                              <td> {{vm.response_cups.motivoEstadoNoContratable}}                              
                              </td>
                          </tr>
                          </tbody>
                          <tfoot>                 
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th> 
                          </tfoot>
                        </table>
                      </div>

                     
                    </div>

                    <div id="tabs-2"> 
                    
                    </div>

                    <div id="tabs-3"> 
                    
                    </div>

                    <div id="tabs-4"> 
                    
                    </div>
                  </div>

                </div><!--panel-body FINAL-->
              </section>
            </div>
          </div>

          <!--div class="row">
          <div class="col-lg-12">

            <div class="row">
              <div class="col-lg-12">
                <section class="panel">
                  <header class="panel-heading">
                    Color Pickers & Date Pickers
                  </header>
                  <div class="panel-body">
                    <form class="form-horizontal " action="#">
                     

                      <div class="form-group">
                        <label class="control-label col-sm-4">Default Datepicker</label>
                        <div class="col-sm-6">
                          <input id="dp1" type="text" value="28-10-2013" size="16" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-4">Default Datepicker</label>
                        <div class="col-sm-6">
                          <input id="dp1" type="text" value="28-10-2013" size="16" class="form-control">
                        </div>
                      </div>

                    </form>
                  </div>
                </section>
              </div>
            </div-->


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
     




  </div><!-- FINAL DIV NG-CONTROLLER -->
   <script>
      $(function(){
        'use strict'
        jQuery(function($) 
        {
          $( "#tabs_dynargy" ).tabs(); 
          $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            //mixDate: "<?php echo date("m/d/Y")?>"
            maxDate: "<?php echo date("m/d/Y")?>"
        });
      });


      });
    </script>
  <script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
    <!-- custom form validation script for this page-->
    <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  </body>
  <div id="buscando" class="loader loader-default"  data-text="Conectando Con Dynargy, Por favor espere..."></div>
  </html>
