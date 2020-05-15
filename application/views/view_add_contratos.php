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
  .datepicker{z-index:1151 !important;}
</style>

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
    </style>
<body>
 <div ng-controller="Controlador_Contratos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='nuevo'">Registro de Contratos</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='ver'">Consultando Contrato</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='renovar'">Renovación de Propuesta Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='editar'">Modificando Contrato</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


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

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Propuesta Comercial</label>
          <select class="form-control" id="CodProCom" name="CodProCom" required ng-model="vm.fdatos.CodProCom" ng-disabled="vm.fdatos.tipo=='ver'" ng-change="vm.filtrar_propuesta_contratos()"> 
        <option ng-repeat="dato_act in vm.List_Propuestas_Comerciales" value="{{dato_act.CodProCom}}">{{dato_act.CodProCom}} - {{dato_act.FecProCom}} - {{dato_act.RefProCom}}</option>
        </select>
        
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Propuesta</label>
       <input type="text" class="form-control datepicker" name="FecProCom" id="FecProCom" ng-model="vm.FecProCom" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecProCom) " readonly="readonly" />
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Propuesta</label>
          
       <input type="text" class="form-control" name="RefProCom" id="RefProCom" ng-model="vm.RefProCom" placeholder="00000000001" readonly="readonly"/>
         
         </div>
         </div>
      </div>
  
      <div class="col-12 col-sm-7">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dirección de Suministro</label>
             <input type="text" class="form-control" placeholder="Dirección" ng-model="vm.DirPunSum" readonly="readonly"/>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
             <input type="text" class="form-control" ng-model="vm.EscPlaPuerPunSum" placeholder="Escalera / Planta / Puerta" readonly="readonly"/>  
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
             <input type="text" class="form-control" ng-model="vm.DesLocPunSum" placeholder="Localidad" readonly="readonly"/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
             <input type="text" class="form-control" ng-model="vm.DesProPunSum" placeholder="Provincia" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.CPLocPunSum" placeholder="Código Postal" readonly="readonly"/>     
             </div>
             </div>
          </div>  

<!--- PARA LOS CUPS ELECTRICOS START-->
       
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Eléctrico</label>
             <input type="text"  class="form-control" ng-model="vm.CodCupSEle" placeholder="CUPs Eléctrico" readonly="readonly"/>
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>    
        <input type="text"  class="form-control" ng-model="vm.CodTarEle" placeholder="Tarifa" readonly="readonly"/>                 
             </div>
             </div>
          </div>        

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text" class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP2" placeholder="P2" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP3" placeholder="P3" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP4" placeholder="P4" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP5" placeholder="P5" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP6" placeholder="P6" readonly="readonly"/>     
             </div>
             </div>
          </div>
        
          <!--- PARA LOS CUPS ELECTRICOS END -->



<!--- PARA LOS CUPS GAS START-->
      
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUP Gas </label>
             <input type="text"  class="form-control" ng-model="vm.CodCupGas" placeholder="CUP Gas" readonly="readonly"/>    
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
            
            <input type="text"  class="form-control" ng-model="vm.CodTarGas" placeholder="Tarifa" readonly="readonly"/>                 
             </div>
             </div>
          </div>        

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Consumo </label>         
             <input type="text"  class="form-control" ng-model="vm.Consumo" placeholder="Consumo" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Caudal Diario </label>         
             <input type="text"  class="form-control" ng-model="vm.CauDia" placeholder="Caudal Diario" readonly="readonly"/>     
             </div>
             </div>
          </div>
        
  
  <!--- PARA LOS CUPS GAS END -->

   <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
         <input type="text"  class="form-control" ng-model="vm.CodCom" placeholder="Comercializadora" readonly="readonly"/>
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Producto </label>
        <input type="text" class="form-control" ng-model="vm.CodPro" placeholder="Producto" readonly="readonly"/>               
             </div>
             </div>
          </div>  

           <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Anexo </label>
        <input type="text"  class="form-control" ng-model="vm.CodAnePro" placeholder="Anexo" readonly="readonly"/>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Precio </label>          
         
        <input type="text"  class="form-control" ng-model="vm.TipPre" placeholder="Tipo Precio" readonly="readonly"/>                 
             </div>
             </div>
          </div>  

      <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
        <input type="text" class="form-control datepicker_Inicio" name="FecIniCon" id="FecIniCon" ng-model="vm.FecIniCon" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecIniCon)" ng-blur="vm.blurfechachange()" ng-disabled="vm.fdatos.tipo=='ver'"/>
         
         </div>
         </div>
      </div>


        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Duración </label>          
             <select class="form-control" id="DurCon" name="DurCon" required ng-model="vm.fdatos.DurCon" ng-change="vm.calcular_vencimiento()" ng-disabled="vm.fdatos.tipo=='ver'">   
                <option value="12">12 Meses</option>
                <option value="18">18 Meses</option>
                <option value="24">24 Meses</option>
                <option value="36">36 Meses</option>
        </select> 
                       
             </div>
             </div>
          </div>

      <div class="col-12 col-sm-2">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Vencimiento</label>
        <input type="text" class="form-control datepicker_Vencimiento" name="FecVenCon" id="FecVenCon" ng-model="vm.FecVenCon" placeholder="DD/MM/YYYY" maxlength="10" ng-disabled="vm.fdatos.tipo=='nuevo'"/>
         
         </div>
         </div>
      </div> 

     <div class="col-12 col-sm-2">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Referencia</label>
        <input type="text" class="form-control" name="RefCon" id="RefCon" ng-model="vm.fdatos.RefCon" readonly="readonly" placeholder="Referencia" ng-disabled="vm.fdatos.tipo=='ver'"/>
         
         </div>
         </div>
      </div>      

         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del Contrato <a title='Descargar Documento' ng-show="vm.fdatos.DocConRut!=null && vm.fdatos.CodConCom>0" href="{{vm.fdatos.DocConRut}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>



          <div id="file-wrap">
            <p>Haga Click AQUÍ para adjuntar un archivo,también puede <strong>Arrastrar</strong> el archivo y <strong>Soltarlo</strong> en este recuadro.</p>                       
            <input type="file" id="file_fotocopia"  name="file_fotocopia" class="file_b" updloadfotocopia-model="file_fotocopia" draggable="true">
            <div id="file_fotocopia1"></div>                       
          </div>
        <script>      
      $('#file_fotocopia').on('change', function() 
      {          
        const $file_fotocopia = document.querySelector("#file_fotocopia");
        console.log($file_fotocopia);
        let file_fotocopia = $file_fotocopia.files;                      
        filenameDocCliDoc = '<i class="fa fa-file"> '+$file_fotocopia.files[0].name+'</i>';
        $('#file_fotocopia1').html(filenameDocCliDoc);
        console.log($file_fotocopia.files[0].name);
      });
     
</script>     

        <!--input type="file" id="file_fotocopia"  accept="*/*" class="form-control btn-info" updloadfotocopia-model="file_fotocopia"-->
         
         </div>
         </div>
     
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
        <textarea class="form-control" name="ObsCon" id="ObsCon" ng-disabled="vm.fdatos.tipo=='ver'" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsCon" onkeyup="this.value=this.value.toUpperCase();"></textarea>        
         </div>
         </div>
            <input class="form-control" id="CodConCom" name="CodConCom" type="hidden" ng-model="vm.fdatos.CodConCom" readonly/>
         


         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.tipo=='nuevo'" ng-disabled="vm.disabled_button==true">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.tipo=='editar'|| vm.fdatos.tipo=='ver'">Actualizar</button>

            <!--a class="btn btn-warning" href="reportes/Exportar_Documentos/Doc_Contrato_Cliente_PDF/{{vm.fdatos.CodConCom}}" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar PDF</a-->
            <!--button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodConCom>0 " >Actualizar</button-->            
            <!--button class="btn btn-warning" type="button"  ng-click="vm.limpiar()" ng-show="vm.fdatos.CodConCom==undefined||vm.fdatos.CodConCom==null||vm.fdatos.CodConCom==''">Limpiar</button-->
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">Volver</button>
          </div>
        </div>

  </div><!--FINAL ROW -->
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>
</div>
  <!-- container section end -->

<script>

  
  $('.datepicker_Inicio').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
  $('.datepicker_Vencimiento').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});

//datepicker_Vencimiento
  /*$('#FecIniCon').on('changeDate', function() 
  {
     var FecIniCon=document.getElementById("FecIniCon").value;
     console.log("FecIniCon: "+FecIniCon);
  });*/

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Guardando" class="loader loader-default"  data-text="Grabando Contrato"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Contrato"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando datos del Contrato"></div>
</html>
