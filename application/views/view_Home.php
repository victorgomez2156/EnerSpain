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
  
    <!--main content start-->
     <section id="main-content">
      <section class="wrapper">
        <!--overview start-->

        <!--Dashboard start -->
        <div align="center">
         <img src="application/libraries/estilos/img/logo_web_desktop.png" align="center">
        </div>

          <div class="text-right">
            <div class="credits">
              <!--
              All the links in the footer should remain intact.
               You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
                  Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
               -->
              Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
            </div>
          </div>
          </section>
        </section>

         

  <!--main content end-->
  <div id="List_Cli" class="loader loader-default"  data-text="Cargando listado de Clientes"></div>
  <div id="Buscando_Informacion" class="loader loader-default"  data-text="Buscando Información"></div>
</body>
</html>
