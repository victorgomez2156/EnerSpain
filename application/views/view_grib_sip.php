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
            <h3 class="page-header">SIP</h3>
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
     




  </div><!-- FINAL DIV NG-CONTROLLER -->
    <script type="text/javascript">
      

      


      
    </script>
  <script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
    <!-- custom form validation script for this page-->
    <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  </body>
  <div id="buscando" class="loader loader-default"  data-text="Buscando CUPs Contratos"></div>
  </html>
