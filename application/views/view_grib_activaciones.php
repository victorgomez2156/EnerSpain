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
   <div ng-controller="Controlador_Activaciones as vm">
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
          </div>
        </div>           

    </div><!--FINAL ROW -->
  </form>

      <div ng-show="vm.VistaResponse==true">
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
                <label class="font-weight-bold nexa-dark" style="color:black;">Tárifa</label>
                <input type="text" class="form-control " name="NomTar" id="NomTar" ng-model="vm.NomTar" readonly/>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
              <div class="form-group">
                <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Producto</label>
                <input type="text" class="form-control " name="DesPro" id="DesPro" ng-model="vm.DesPro" readonly/>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form">                          
              <div class="form-group">
                <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Activación</label>
                <input type="text" class="form-control FecActCUPs" name="FecActCUPs" id="FecActCUPs" ng-model="vm.FecActCUPs" />
              </div>
            </div>
          </div>

            <div class="col-12 col-sm-4">
            <div class="form">                          
              <div class="form-group">
                <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Vencimiento</label>
                <input type="text" class="form-control FecVenCUPs" name="FecVenCUPs" id="FecVenCUPs" ng-model="vm.FecVenCUPs" />
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form">                          
              <div class="form-group">
                <label class="font-weight-bold nexa-dark" style="color:black;">Consumo</label>
                <input type="text" class="form-control " name="ConCup" id="ConCup" ng-model="vm.ConCup" />
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
                  <th >Cliente</th>
                  <th >CUPs</th>
                  <th >Tárifa</th>
                  <th >Tipo de producto</th>
                  <th >Fecha de activación</th>
                  <th >Fecha de Vencimiento</th>
                  <th >CONSUMO</th>           
                  <th >Acción</th>
                  </tr>
                  <tr ng-show="vm.T_Contratos.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_Contratos | filter:paginate" ng-class-odd="odd">                    
                    <td >{{dato.RazSocCli}}</td>
                    <td >{{dato.CUPsName}}</td>
                    <td >{{dato.NomTar}}</td>
                    <td >{{dato.DesPro}}</td>
                    <td >{{dato.FecActCUPs}}</td>
                    <td >{{dato.FecVenCUPs}}</td>
                    <td >{{dato.ConCup}}</td>                    
                    <td>
                        <a style="cursor:pointer;" ng-click="vm.asignarcontrato($index,dato,true)" data-dismiss="modal"><i class="fa fa-check" title="Seleccionar"></i></a>
                    </td >

                  </tr>
                </tbody>
                <tfoot>                 
                 <th >Cliente</th>
                  <th >CUPs</th>
                  <th >Tárifa</th>
                  <th >Tipo de producto</th>
                  <th >Fecha de activación</th>
                  <th >Fecha de Vencimiento</th>
                  <th >CONSUMO</th>  
                </tfoot>
              </table>
        </div> 
        <div align="center">
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
            Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
          </div>
      </div>
    </section>
  </div>

  <script>
    
    $('.FecActCUPs').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
    $('#FecActCUPs').on('changeDate', function() 
    {
       var FecActCUPs=document.getElementById("FecActCUPs").value;
       console.log("FecActCUPs: "+FecActCUPs);
    });
   
    $('.FecVenCUPs').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
    $('#FecVenCUPs').on('changeDate', function() 
    {
       var FecVenCUPs=document.getElementById("FecVenCUPs").value;
       console.log("FecVenCUPs: "+FecVenCUPs);
    });
    
  </script>
  <script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
    <!-- custom form validation script for this page-->
    <script src="application/libraries/estilos/js/form-validation-script.js"></script>
    <!--custome script for all page-->
    <!--script src="application/libraries/estilos/js/scripts.js"></script-->
  </body>
  <div id="buscando" class="loader loader-default"  data-text="Buscando CUPs Contratos"></div>
  </html>
