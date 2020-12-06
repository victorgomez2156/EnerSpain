 app.controller('Controlador_Add_PropuestasMulCliente', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
     var scope = this;
     scope.fdatos = {};

     scope.fdatos.CodCli = $route.current.params.CodCli;
     scope.CodConCom = $route.current.params.CodConCom;
     scope.CodProCom = $route.current.params.CodProCom;
     scope.no_editable = $route.current.params.INF;
     scope.fdatos.tipo = $route.current.params.Tipo;
     scope.fdatos.detalleCUPs=[];
     scope.TDetallesCUPs=[];
     scope.TDetallesCUPsEli=[];
     scope.select_cups=[];
     scope.Nivel = $cookies.get('nivel');
     scope.List_TipPre = [{ TipPre: 0, nombre: 'Fijo' }, { TipPre: 1, nombre: 'Indexado' }];
     var fecha = new Date();
    scope.fdatos.ImpAhoTot=0;
    scope.fdatos.PorAhoTot=0;
     var dd = fecha.getDate();
     var mm = fecha.getMonth() + 1; //January is 0!
     var yyyy = fecha.getFullYear();
     if (dd < 10) {
         dd = '0' + dd
     }
     if (mm < 10) {
         mm = '0' + mm
     }
     scope.disabled_status=true;
     var fecha = dd + '/' + mm + '/' + yyyy;
     scope.CanPerEle = 6;
     ////////////////////////////////////////////////// PARA Las Propuestas START ////////////////////////////////////////////////////////
     console.log('CodCli: '+ scope.fdatos.CodCli);
     console.log('CodConCom: '+scope.CodConCom);
     console.log('CodProCom: '+scope.CodProCom);
     console.log('Tipo: '+scope.fdatos.tipo);
     console.log($route.current.$$route.originalPath);   
    
    scope.fdatos.EstProCom = 'P';
    scope.CanCups=scope.fdatos.detalleCUPs.length;
    $scope.submitFormPropuestaUniCliente = function(event)
    {
         //scope.fdatos.CodCli=scope.fdatos.CodCli;  
         scope.fdatos.TipProCom=3;         
         if (!scope.validar_campos_UniCliente()) {
             return false;
         }
         console.log(scope.fdatos);
         if(scope.fdatos.tipo=="renovar")
         {
            scope.fdatos.CodProCom=scope.CodProCom;
         }
         if (scope.fdatos.tipo == "nueva" || scope.fdatos.tipo == "renovar") {
             var title = '¿Estás seguro de generar una nueva propuesta comercial?';
             var loader = "Guardando";
         }
         if (scope.fdatos.tipo == "ver" || scope.fdatos.tipo == "editar") {
             var title = '¿Estás seguro de cambiar la propuesta comercial?';
             var loader = "Actualizando";
         }
         Swal.fire({
             title: title,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "OK"
         }).then(function(t) {
             if (t.value == true) {
                 $("#" + loader).removeClass("loader loader-default").addClass("loader loader-default is-active");
                 var url = base_urlHome() + "api/PropuestaComercial/generar_propuesta/";
                 $http.post(url, scope.fdatos).then(function(result) {
                     if (result.data != false) {
                         $("#" + loader).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         if (result.data.status == 200 && result.data.statusText == 'Propuesta Comercial') 
                         {                            
                            scope.toast('success',result.data.menssage,loader);
                            location.reload();
                            //location.href="#/Add_Contrato/"+result.data.objSalida.CodCli+"/nuevo/3";
                            return false;
                         }                         
                         if (result.data.status == true && result.data.statusText == 'Propuesta Comercial') 
                         {                            
                            scope.toast('success',result.data.menssage,loader);
                            location.reload();
                            return false;
                         }
                         if (result.data.status == 200 && result.data.statusText == 'Propuesta Comercial Renovación') 
                         {                            
                            scope.toast('success',result.data.menssage,loader);
                            location.href="#/Edit_Propuesta_Comercial_MulCliente/"+result.data.objSalida.CodProCom+"/editar";
                            //location.reload();
                            return false;
                         }

                         scope.toast('success',"Propuesta Comercial generada correctamente bajo el número de referencia: " + result.data.RefProCom,'Propuesta Comercial');
                         location.href="#/Edit_Propuesta_Comercial_MulCliente/"+result.data.CodProCom+"/editar";
                         //location.href="#/Add_Contrato/"+result.data.CodCli+"/nuevo";
                         //location.href = "#/Propuesta_Comercial";
                     } else {
                         scope.toast('error','Ha ocurrido un error, intente nuevamente.','');
                     }
                 }, function(error) {
                     $("#" + loader).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
                 });
             } else {
                 console.log('Cancelando ando...');
             }
         });
     };
     scope.validar_campos_UniCliente = function() 
    {
        resultado = true;         
        var FecProCom1 = document.getElementById("FecProCom").value;
         scope.FecProCom = FecProCom1;
         if (scope.FecProCom == null || scope.FecProCom == undefined || scope.FecProCom == '') {
             scope.toast('error','La Fecha de la Propuesta es requerida','');
             return false;
         } else {
             var FecProCom = (scope.FecProCom).split("/");
             if (FecProCom.length < 3) {
                 scope.toast('error','El Formato de Fecha de la Propuesta debe Ser EJ: DD/MM/YYYY.','');
                 event.preventDefault();
                 return false;
             } else {
                 if (FecProCom[0].length > 2 || FecProCom[0].length < 2) {
                     scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de la Propuesta deben ser 2 números solamente. EJ: 01','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecProCom[1].length > 2 || FecProCom[1].length < 2) {
                    scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de la Propuesta deben ser 2 números solamente. EJ: 01','');
                   
                    event.preventDefault();
                    return false;
                 }
                 if (FecProCom[2].length < 4 || FecProCom[2].length > 4) {
                     scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha de la Propuesta Ya que deben ser 4 números solamente.','');
                     
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecProCom.split("/");
                 valuesEnd = scope.Fecha_Propuesta.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     scope.toast('error',"La Fecha de la Propuesta no puede ser mayor al " + scope.Fecha_Propuesta + " Por Favor Verifique he intente nuevamente.",'');
                     
                     return false;
                 }
                 scope.fdatos.FecProCom = FecProCom[2] + "-" + FecProCom[1] + "-" + FecProCom[0];
             }
         }
        if (!scope.fdatos.detalleCUPs.length > 0) {
             scope.toast('error','Debe Agregar 1 o mas CUPs a está propuesta.','');
             return false;
        }
        if (!scope.fdatos.CodCom > 0) {
             scope.toast('error','Debe Seleccionar una Comercializadora.','Comercializadora');
             return false;
        }
        if (!scope.fdatos.CodPro > 0) {
             scope.toast('error','Debe Seleccionar un Producto.','Producto');
             return false;
        }
        if (!scope.fdatos.CodAnePro > 0) {
             scope.toast('error','Debe Seleccionar un Anexo.','Anexo');
             return false;
        }
        if (!scope.fdatos.TipPre > 0) {
             scope.toast('error','Debe Seleccionar un Tipo de Precio.','Tipo de Precio');
             return false;
        }
        if (scope.fdatos.ObsProCom==undefined||scope.fdatos.ObsProCom==null||scope.fdatos.ObsProCom=='') {
            scope.fdatos.ObsProCom=null;
        }
        else
        {
           scope.fdatos.ObsProCom=scope.fdatos.ObsProCom; 
        }
        if (scope.fdatos.tipo == 'editar' || scope.fdatos.tipo == 'ver') {
             if (scope.fdatos.Apro == false && scope.fdatos.Rech == false) {
                 scope.toast('error','Debe indicar si es aprobada o rechazada.','');
                 return false;
             }
         }
         if (scope.fdatos.Rech == true) {
             if (scope.fdatos.JusRecProCom == null || scope.fdatos.JusRecProCom == undefined || scope.fdatos.JusRecProCom == '') {
                scope.toast('error','Debe indicar una justificación del rechazo.','');
                return false;
             }
         } else {
             scope.fdatos.JusRecProCom = null;
         }
        
         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
    }
     scope.getDatosServer=function()
     {
        var url= base_urlHome()+"api/PropuestaComercial/getDataServerMultiClienteMultiPunto/CodCli/"+scope.fdatos.CodCli;
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.FecProCom=result.data.Fecha_Propuesta;
                scope.Fecha_Propuesta=result.data.Fecha_Propuesta;
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecProCom);
                scope.fdatos.RefProCom=result.data.Referencia;
                scope.RazSocCli=result.data.RazSocCli ;
                scope.NumCifCli=result.data.NumCifCli ;
                scope.List_Comercializadora=result.data.Comercializadoras;
            }

        },function(error)
        {
            if (error.status == 404 && error.statusText == "Not Found"){
            scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
            }if (error.status == 401 && error.statusText == "Unauthorized"){
            scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
            }if (error.status == 403 && error.statusText == "Forbidden"){
            scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
            }if (error.status == 500 && error.statusText == "Internal Server Error") {
            scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
            }
        });
    }
    scope.BuscarXIDProComMulCliente =function()
    {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url=base_urlHome()+"api/PropuestaComercial/GetProComMulCli/CodProCom/"+scope.CodProCom;
        $http.get(url).then(function(result)
        {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                scope.fdatos=result.data.Propuesta;
                scope.fdatos.tipo=$route.current.params.Tipo;
                scope.FecProCom=result.data.Propuesta.FecProCom;
                scope.Fecha_Propuesta=result.data.FechaServer;
                scope.fdatos.detalleCUPs=[];
                scope.List_Comercializadora=result.data.Comercializadora;
                scope.RazSocCli=result.data.Cliente.RazSocCli;
                scope.NumCifCli=result.data.Cliente.NumCifCli;
                if(result.data.detalleCUPs==false)
                {
                    scope.fdatos.detalleCUPs=[];
                }
                else
                {
                    scope.fdatos.detalleCUPs=result.data.detalleCUPs;
                }                
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Propuesta.FecProCom);
                if( result.data.Propuesta.CodCom!=null)
                 {
                    scope.realizar_filtro(1, result.data.Propuesta.CodCom);
                 }
                if( result.data.Propuesta.CodPro!=null)
                {
                    scope.realizar_filtro(2, result.data.Propuesta.CodPro);
                }

                if (scope.fdatos.EstProCom == "P") {
                     scope.fdatos.Apro = false;
                     scope.fdatos.Rech = false;
                }
                if (scope.fdatos.EstProCom == "A") {
                     scope.fdatos.Apro = true;
                     scope.fdatos.Rech = false;
                }
                if (scope.fdatos.EstProCom == "C") {
                     scope.fdatos.Apro = true;
                     scope.fdatos.Rech = false;
                }
                if (scope.fdatos.EstProCom == "R") {
                     scope.fdatos.Apro = false;
                     scope.fdatos.Rech = true;
                     scope.fdatos.JusRecProCom = result.data.Propuesta.JusRecProCom;
                }
                scope.CanCups=scope.fdatos.detalleCUPs.length;
            }
            else
            {

            }
        },function(error)
        {   
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found"){
            scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
            }if (error.status == 401 && error.statusText == "Unauthorized"){
            scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
            }if (error.status == 403 && error.statusText == "Forbidden"){
            scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
            }if (error.status == 500 && error.statusText == "Internal Server Error") {
            scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
            }
        });
    }  

     scope.regresar = function() {
         Swal.fire({
             title: "Estás seguro de regresar y no realizar los cambios?",
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "OK"
         }).then(function(t) {
             if (t.value == true) {
                 location.href = "#/Propuesta_Comercial";
             } else {
                 console.log('Cancelando ando...');
             }
         });
     }
     scope.realizar_filtro = function(metodo, PrimaryKey) {
         var url = base_urlHome() + "api/PropuestaComercial/realizar_filtro/metodo/" + metodo + "/PrimaryKey/" + PrimaryKey;
         $http.get(url).then(function(result) {
             if (result.data != false) {
                 if (metodo == 1) {
                     scope.List_Productos = result.data;
                 }
                 if (metodo == 2) {
                     scope.List_Anexos = result.data;
                 }
                 if (metodo == 3) {
                     scope.fdatos.TipPre = result.data.TipPre;
                 }
             } else {
                 if (metodo == 1) {
                     scope.toast('error','No existen productos asignado a esta Comercializadora.','Comercializadoras');
                     scope.List_Productos = [];
                     scope.List_Anexos = [];
                     scope.fdatos.CodPro = undefined;
                     scope.fdatos.CodAnePro = undefined;
                     scope.fdatos.TipPre = undefined;
                 }
                 if (metodo == 2) {
                     scope.toast('error','No existen anexos asignados a este producto.','productos');
                     scope.List_Anexos = [];
                     scope.fdatos.CodAnePro = undefined;
                     scope.fdatos.TipPre = undefined;
                 }
             }
         }, function(error) {
                    console.log(error);
                    if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
         });
    }
     scope.FetchClientes = function() 
     {
        var searchText_len = scope.NumCIFCliCUPs.trim().length;
        scope.fdatos.NumCifCli = scope.NumCIFCliCUPs;
        if (searchText_len > 0) 
        {
            console.log(scope.fdatos);
            var url = base_urlHome() + "api/PropuestaComercial/getclientesColaboradores";
            $http.post(url, scope.fdatos).then(function(result) 
            {
                //console.log(result);
                if (result.data != false) {
                    scope.searchResult = result.data;
                } else
                {
                    scope.searchResult = {};
                }
            },
            function(error) 
            {
                if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                }if (error.status == 401 && error.statusText == "Unauthorized"){
                    scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                }if (error.status == 403 && error.statusText == "Forbidden"){
                    scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                }
            });
        } 
        else 
        {
            scope.searchResult = {};
        }
    }
    scope.setValue = function(index, $event, result,metodo) 
    {
        if(metodo==1)
        {
            scope.NumCIFCliCUPs = scope.searchResult[index].NumCifCli;
            scope.CodCliCUPs = scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation();
            $("#CUPs").removeClass("loader loader-default").addClass("loader loader-default is-active");
            var url=base_urlHome()+"api/PropuestaComercial/GetCUPsTar/MetodoCUPs/"+metodo+"/CodCli/"+scope.CodCliCUPs;
            $http.get(url).then(function(result)
            {
                $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if(result.data.status==200 && result.data.statusText=="OK")
                {   
                    scope.List_CUPsEle=result.data.CUPs;
                    angular.forEach(scope.fdatos.detalleCUPs,function(detalleCUPs)
                    {
                        if(detalleCUPs.TipServ==1)
                        {
                            for (var i = 0; i < scope.List_CUPsEle.length; i++) 
                            {
                                if (scope.List_CUPsEle[i].CodCupsEle == detalleCUPs.CodCups)
                                {
                                    scope.List_CUPsEle.splice(i, 1);
                                }
                            }
                        }                     
                    });

                    scope.List_TarEle=result.data.TarEle;
                }
                else if(result.data.status==404 && result.data.statusText==false)
                { 
                    scope.toast('error','No se encontraron CUPs Eléctricos para este cliente','CUPs Eléctrico');
                    scope.List_CUPsEle=[];
                    scope.List_TarEle=[];
                }
            },function(error)
            {
                $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                }if (error.status == 401 && error.statusText == "Unauthorized"){
                    scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                }if (error.status == 403 && error.statusText == "Forbidden"){
                    scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                }
            });
        }
        if(metodo==2)
        {
            scope.NumCIFCliCUPs = scope.searchResult[index].NumCifCli;
            scope.CodCliCUPs = scope.searchResult[index].CodCli;
            scope.searchResult = {};
            var url=base_urlHome()+"api/PropuestaComercial/GetCUPsTar/MetodoCUPs/"+metodo+"/CodCli/"+scope.CodCliCUPs;
            $http.get(url).then(function(result)
            {
                if(result.data.status==200 && result.data.statusText=="OK")
                {   
                    scope.List_CUPsGas=result.data.CUPs;
                    angular.forEach(scope.fdatos.detalleCUPs,function(detalleCUPs)
                    {
                        if(detalleCUPs.TipServ==2)
                        {
                            for (var i = 0; i < scope.List_CUPsGas.length; i++) 
                            {
                                if (scope.List_CUPsGas[i].CodCupGas == detalleCUPs.CodCups)
                                {
                                    scope.List_CUPsGas.splice(i, 1);
                                }
                            }
                        }                     
                    });
                    scope.List_TarGas=result.data.TarGas;
                }
                else if(result.data.status==404 && result.data.statusText==false)
                { 
                    scope.toast('error','No se encontraron CUPs Gas para este cliente','CUPs Gas');
                    scope.List_CUPsGas=[];
                    scope.List_TarGas=[];
                }
            },function(error)
            {
                if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                }if (error.status == 401 && error.statusText == "Unauthorized"){
                    scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                }if (error.status == 403 && error.statusText == "Forbidden"){
                    scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                }
            }); 
            $event.stopPropagation();
        }
        
    }
    scope.searchboxClicked = function($event) {
        $event.stopPropagation();
    }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }
    scope.AgregarCUPs=function(MetodoCUPs)
     {
        console.log(MetodoCUPs);
        if(MetodoCUPs==1)
        {  
            scope.CanPerTar=6;
            scope.List_CUPsEle=[];
            scope.List_TarEle=[];
            scope.NumCIFCliCUPs=undefined;
            scope.CodCliCUPs=undefined;
            scope.fdatos.CodCupSEle=undefined;
            scope.DirPunSumCUPsEle=undefined;
            scope.fdatos.CodTar=undefined;
            scope.fdatos.PotEleConP1='0.00';
            scope.fdatos.PotEleConP2='0.00';
            scope.fdatos.PotEleConP3='0.00';
            scope.fdatos.PotEleConP4='0.00';
            scope.fdatos.PotEleConP5='0.00';
            scope.fdatos.PotEleConP6='0.00';
            scope.fdatos.ConCup='0.00';
            scope.fdatos.ImpAho='0.00';
            scope.fdatos.PorAho='0.00';
            scope.fdatos.RenCup=false;
            scope.fdatos.ObsCup=undefined;
            $("#modal_CUPsElectrico").modal('show'); 
        }
        else if(MetodoCUPs==2)
        {   
            scope.List_CUPsGas=[];
            scope.List_TarGas=[];
            scope.NumCIFCliCUPs=undefined;
            scope.CodCliCUPs=undefined;
            scope.fdatos.CodCupSGas=undefined;
            scope.DirPunSumCUPsGas=undefined;
            scope.fdatos.CodTar=undefined;
            scope.fdatos.PotEleConP1=null;
            scope.fdatos.PotEleConP2=null;
            scope.fdatos.PotEleConP3=null;
            scope.fdatos.PotEleConP4=null;
            scope.fdatos.PotEleConP5=null;
            scope.fdatos.PotEleConP6=null;
            scope.fdatos.ConCup='0.00';
            scope.fdatos.ImpAho='0.00';
            scope.fdatos.PorAho='0.00';
            scope.fdatos.RenCup=false;
            scope.fdatos.ObsCup=undefined;
            scope.fdatos.CauDiaGas='0.00';
            $("#modal_CUPsGas").modal('show'); 
        }
        else
        {

        }


     }
     scope.generar_contrato=function()
     {
        if(scope.fdatos.EstProCom=='A')
        {
            location.href="#/Add_Contrato/"+scope.fdatos.CodCli+"/nuevo/3";
        }
        else
        {
            scope.toast('error','Solo se puede generar contrato de una propuesta con estatus aprobada.','Error Propuesta');
        }
        
     }
     scope.CUPsFilter = function(metodo, CodCUPs) {
         if (metodo == 1) {
             for (var i = 0; i < scope.List_CUPsEle.length; i++) {
                 if (scope.List_CUPsEle[i].CodCupsEle == CodCUPs) {
                     console.log(scope.List_CUPsEle[i]);
                     scope.DirPunSumCUPsEle=scope.List_CUPsEle[i].DirPumSum;
                     scope.fdatos.CodTar = scope.List_CUPsEle[i].CodTarElec;
                    
                     if(scope.List_CUPsEle[i].PotConP1==null)
                    {
                        scope.fdatos.PotEleConP1 ='0.00';
                    }
                    else
                    {
                        scope.fdatos.PotEleConP1 = scope.List_CUPsEle[i].PotConP1;
                    }
                    if(scope.List_CUPsEle[i].PotConP2==null)
                    {
                        scope.fdatos.PotEleConP2 ='0.00';
                    }
                    else
                    {
                        scope.fdatos.PotEleConP2 = scope.List_CUPsEle[i].PotConP2;
                    }
                    if(scope.List_CUPsEle[i].PotConP3==null)
                    {
                        scope.fdatos.PotEleConP3 ='0.00';
                    }
                    else
                    {
                        scope.fdatos.PotEleConP3 = scope.List_CUPsEle[i].PotConP3;
                    }
                    if(scope.List_CUPsEle[i].PotConP4==null)
                    {
                        scope.fdatos.PotEleConP4 ='0.00';
                    }
                    else
                    {
                        scope.fdatos.PotEleConP4 = scope.List_CUPsEle[i].PotConP4;
                    }
                    if(scope.List_CUPsEle[i].PotConP5==null)
                    {
                        scope.fdatos.PotEleConP5 ='0.00';
                    }
                    else
                    {
                        scope.fdatos.PotEleConP5 = scope.List_CUPsEle[i].PotConP5;
                    }
                    if(scope.List_CUPsEle[i].PotConP6==null)
                    {
                        scope.fdatos.PotEleConP6 ='0.00';
                    }
                    else
                    {
                        scope.fdatos.PotEleConP6 = scope.List_CUPsEle[i].PotConP6;
                    }                   

                     scope.fdatos.CodPunSum= scope.List_CUPsEle[i].CodPunSum;
                     scope.RazSocCliCups=scope.List_CUPsEle[i].RazSocCli;
                     scope.NumCifCliCups=scope.List_CUPsEle[i].NumCifCli;
                     if(scope.List_CUPsEle[i].CanPerTar==null||scope.List_CUPsEle[i].CanPerTar==0)
                     {
                        scope.CanPerTar =6;
                     }
                     else
                     {
                        scope.CanPerTar = scope.List_CUPsEle[i].CanPerTar;
                     }
                     if(scope.fdatos.CodTar==0||scope.fdatos.CodTar==null)
                     {
                         scope.toast('error','Debe Seleccionar una Tárifa para el CUPs Eléctrico','CUPs Sin Tárifa');
                     }
                     
                 }
             }
         }
         if (metodo == 2) {
             for (var i = 0; i < scope.List_CUPsGas.length; i++) {
                 if (scope.List_CUPsGas[i].CodCupGas == scope.fdatos.CodCupSGas) {
                     scope.DirPunSumCUPsGas=scope.List_CUPsGas[i].DirPumSum;
                     scope.fdatos.CodPunSum= scope.List_CUPsGas[i].CodPunSum;
                     scope.fdatos.CodTar = scope.List_CUPsGas[i].CodTarGas;
                     scope.RazSocCliCups=scope.List_CUPsGas[i].RazSocCli;
                     scope.NumCifCliCups=scope.List_CUPsGas[i].NumCifCli;
                 }
             }
         }
     }
     $scope.AgregarCUPsElectricoGas = function(event,MetodoCUPs)
    {         
        if(MetodoCUPs==1)
        {
            if (!scope.validar_campos_CUPsElectricos()) {
             return false;
            }
            var ObjDetCUPs = new Object();
            if (scope.fdatos.detalleCUPs == undefined || scope.fdatos.detalleCUPs == false) {
                scope.fdatos.detalleCUPs = [];
            }
            for (var i = 0; i < scope.List_CUPsEle.length; i++) 
            {
                if (scope.List_CUPsEle[i].CodCupsEle == scope.fdatos.CodCupSEle) {
                     scope.DirPunSumCUPsEle=scope.List_CUPsEle[i].DirPunSum;
                     scope.CUPsEle = scope.List_CUPsEle[i].CUPsEle;
                     scope.DesLoc = scope.List_CUPsEle[i].DesLoc;
                     scope.DesPro = scope.List_CUPsEle[i].DesPro;
                }
            }
            for (var i = 0; i < scope.List_TarEle.length; i++) 
            {
                if (scope.List_TarEle[i].CodTarEle == scope.fdatos.CodTar) {
                    scope.NomTar=scope.List_TarEle[i].NomTarEle;                     
                }
            }
            for (var i = 0; i < scope.fdatos.detalleCUPs.length; i++) 
            {
                if (scope.fdatos.detalleCUPs[i].CodCups == scope.fdatos.CodCupSEle && scope.fdatos.detalleCUPs[i].TipServ==1) 
                {
                    scope.fdatos.detalleCUPs.splice(i, 1);
                }
            }
            scope.fdatos.detalleCUPs.push({CodPunSum:scope.fdatos.CodPunSum,CodCups:scope.fdatos.CodCupSEle,
                CodTar:scope.fdatos.CodTar,PotConP1:scope.fdatos.PotEleConP1,PotConP2:scope.fdatos.PotEleConP2,
                PotConP3:scope.fdatos.PotEleConP3,PotConP4:scope.fdatos.PotEleConP4,PotConP5:scope.fdatos.PotEleConP5,
                PotConP6:scope.fdatos.PotEleConP6,RenCon:scope.fdatos.RenCup,ImpAho:scope.fdatos.ImpAho,PorAho:scope.fdatos.PorAho,ObsCup:scope.fdatos.ObsCup,
                ConCUPs:scope.fdatos.ConCup,CauDia:null,TipServ:1,DirPunSum:scope.DirPunSumCUPsEle,CUPsName:scope.CUPsEle,NomTar:scope.NomTar,NumCifCli:scope.NumCifCliCups,RazSocCli:scope.RazSocCliCups,DesLoc:scope.DesLoc,DesPro:scope.DesPro});
            console.log(scope.fdatos.detalleCUPs);
            scope.CanCups=scope.fdatos.detalleCUPs.length;
            $("#modal_CUPsElectrico").modal('hide');
        }
        else if(MetodoCUPs==2)
        {
            if (!scope.validar_campos_CUPsGas()) {
             return false;
            }
            var ObjDetCUPs = new Object();
            if (scope.fdatos.detalleCUPs == undefined || scope.fdatos.detalleCUPs == false) {
                scope.fdatos.detalleCUPs = [];
            }
            for (var i = 0; i < scope.List_CUPsGas.length; i++) 
            {
                if (scope.List_CUPsGas[i].CodCupGas == scope.fdatos.CodCupSGas) {
                     scope.DirPunSumCUPsGas=scope.List_CUPsGas[i].DirPunSum;
                     scope.CupsGas = scope.List_CUPsGas[i].CupsGas;
                     scope.DesLoc = scope.List_CUPsGas[i].DesLoc;
                     scope.DesPro = scope.List_CUPsGas[i].DesPro;
                     
                 }
            }
            for (var i = 0; i < scope.List_TarGas.length; i++) 
            {
                if (scope.List_TarGas[i].CodTarGas == scope.fdatos.CodTar) {
                    scope.NomTar=scope.List_TarGas[i].NomTarGas;                     
                 }
            }
            for (var i = 0; i < scope.fdatos.detalleCUPs.length; i++) 
            {
                if (scope.fdatos.detalleCUPs[i].CodCups == scope.fdatos.CodCupSGas && scope.fdatos.detalleCUPs[i].TipServ==2) 
                {
                    scope.fdatos.detalleCUPs.splice(i, 1);
                }
            }
             scope.fdatos.detalleCUPs.push({CodPunSum:scope.fdatos.CodPunSum,CodCups:scope.fdatos.CodCupSGas,
                CodTar:scope.fdatos.CodTar,PotConP1:null,PotConP2:null,
                PotConP3:null, PotConP4:null,PotConP5:null,
                PotConP6:null,RenCon:scope.fdatos.RenCup,ImpAho:scope.fdatos.ImpAho,PorAho:scope.fdatos.PorAho,ObsCup:scope.fdatos.ObsCup,
                ConCUPs:scope.fdatos.ConCup,CauDia:scope.fdatos.CauDiaGas,TipServ:2,DirPunSum:scope.DirPunSumCUPsGas,CUPsName:scope.CupsGas,NomTar:scope.NomTar,NumCifCli:scope.NumCifCliCups,RazSocCli:scope.RazSocCliCups,DesLoc:scope.DesLoc,DesPro:scope.DesPro});
            console.log(scope.fdatos.detalleCUPs);
            scope.CanCups=scope.fdatos.detalleCUPs.length;
            $("#modal_CUPsGas").modal('hide');

        }   
        scope.fdatos.ImpAhoTot = 0;
        scope.fdatos.PorAhoTot = 0;   
        for(var i=0; i<scope.fdatos.detalleCUPs.length; i++) 
        {
            //console.log(scope.fdatos.detalleCUPs[i].ImpAho);
            //console.log(scope.fdatos.detalleCUPs[i].PorAho);
            //scope.fdatos.ImpAhoTot = Math.max(parseInt(scope.fdatos.ImpAhoTot ).toFixed(2)) + Math.max(parseInt(scope.TDetallesCUPs[i].ImpAho).toFixed(2));
            scope.fdatos.ImpAhoTot=Math.max(parseFloat(scope.fdatos.ImpAhoTot),0)+Math.max(parseFloat(scope.fdatos.detalleCUPs[i].ImpAho),0);
            scope.fdatos.PorAhoTot=Math.max(parseFloat(scope.fdatos.PorAhoTot),0)+Math.max(parseFloat(scope.fdatos.detalleCUPs[i].PorAho),0);
        }   
        console.log(scope.fdatos.ImpAhoTot);
        console.log(scope.fdatos.PorAhoTot);
    };
    scope.SelecQuitCUPs=function(dato,index,CodCups)
    {   
        console.log(index);
        console.log(dato);
        var ObjDetCUPsEli = new Object();
        if (scope.TDetallesCUPsEli == undefined || scope.TDetallesCUPsEli == false) {
                scope.TDetallesCUPsEli = [];
        }
        for (var i = 0; i < scope.TDetallesCUPsEli.length; i++) 
        {
            if (scope.TDetallesCUPsEli[i].CodCups == dato.CodCups && scope.TDetallesCUPsEli[i].TipServ==dato.TipServ) 
            {
                scope.TDetallesCUPsEli.splice(i, 1);
                scope.select_cups[CodCups] = false;
            }
        }
        scope.TDetallesCUPsEli.push({CodCups:dato.CodCups,TipServ:dato.TipServ});
        for (var i = 0; i < scope.TDetallesCUPsEli.length; i++) 
        {
            if (scope.TDetallesCUPsEli[i].CodCups == dato.CodCups && scope.TDetallesCUPsEli[i].TipServ==dato.TipServ) 
            {
                scope.select_cups[CodCups] = dato; 
            }                   
        }
        console.log(scope.TDetallesCUPsEli);        
        
    }
    scope.QuitarCUPs=function()
    {
        if(scope.TDetallesCUPsEli.length==0)
        {
            scope.toast('error','Debe Seleccionar un CUPs Para Poder Eliminarlo.','');
            return false;
        }       
        angular.forEach(scope.TDetallesCUPsEli,function(detalleCUPsEli)
        {                        
            for (var i = 0; i < scope.fdatos.detalleCUPs.length; i++) 
            {
                if (scope.fdatos.detalleCUPs[i].CodCups == detalleCUPsEli.CodCups && scope.fdatos.detalleCUPs[i].TipServ == detalleCUPsEli.TipServ )
                {
                    scope.fdatos.detalleCUPs.splice(i, 1);
                }
            }                
        });
        scope.CanCups=scope.fdatos.detalleCUPs.length;
        scope.fdatos.ImpAhoTot = 0;
        scope.fdatos.PorAhoTot = 0;       
        for(var j=0; j<scope.fdatos.detalleCUPs.length; j++) 
        {
            scope.fdatos.ImpAhoTot=Math.max(parseFloat(scope.fdatos.ImpAhoTot),0)+Math.max(parseFloat(scope.fdatos.detalleCUPs[j].ImpAho),0);
            scope.fdatos.PorAhoTot=Math.max(parseFloat(scope.fdatos.PorAhoTot),0)+Math.max(parseFloat(scope.fdatos.detalleCUPs[j].PorAho),0);
        }  
        scope.TDetallesCUPsEli= []; 
    }
    scope.QuitarCUPsDetalle=function(index,dato,CodCups)
    {
        
       for (var i = 0; i < scope.TDetallesCUPsEli.length; i++) 
        {
            if (scope.TDetallesCUPsEli[i].CodCups == dato.CodCups && scope.TDetallesCUPsEli[i].TipServ==dato.TipServ) 
            {
                scope.TDetallesCUPsEli.splice(i, 1);
                scope.select_cups[CodCups] = false; 
            }                   
        }
        console.log(scope.TDetallesCUPsEli);
        console.log(scope.select_cups);
    }
    scope.validar_campos_CUPsElectricos = function() 
    {
        resultado = true; 
        if (scope.CodCliCUPs==null||scope.CodCliCUPs==undefined||scope.CodCliCUPs=='') {
             scope.toast('error','Debe seleccionar un Cliente.','Cliente');
             return false;
        }        
        if (!scope.fdatos.CodCupSEle > 0) {
             scope.toast('error','Debe Seleccionar un CUPs Eléctrico.','CUPs Eléctrico');
             return false;
        }
        if (!scope.fdatos.CodTar > 0 || scope.fdatos.CodTar==0) {
                 scope.toast('error','Debe seleccionar una Tarifa Eléctrica.','Tárifa Eléctrica');
                 return false;
        } 
        if (scope.fdatos.CodCupSEle > 0)
        { 
            if (scope.CanPerTar == 1) 
            {
                scope.fdatos.PotEleConP2=null;
                scope.fdatos.PotEleConP3=null;
                scope.fdatos.PotEleConP4=null;
                scope.fdatos.PotEleConP5=null;
                scope.fdatos.PotEleConP6=null;
                if (scope.fdatos.PotEleConP1 == null || scope.fdatos.PotEleConP1 == undefined || scope.fdatos.PotEleConP1 == '') {
                    scope.toast('error','Debe indicar la Potencia 1','Potencia 1');
                    return false;
                }
            }            
            if (scope.CanPerTar == 2) {
                scope.fdatos.PotEleConP3=null;
                scope.fdatos.PotEleConP4=null;
                scope.fdatos.PotEleConP5=null;
                scope.fdatos.PotEleConP6=null;
                if (scope.fdatos.PotEleConP1 == null || scope.fdatos.PotEleConP1 == undefined || scope.fdatos.PotEleConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','Potencia 1');
                     return false;
                }
                if (scope.fdatos.PotEleConP2 == null || scope.fdatos.PotEleConP2 == undefined || scope.fdatos.PotEleConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','Potencia 2');
                     return false;
                }
            }
           
            if (scope.CanPerTar == 3) {
                scope.fdatos.PotEleConP4=null;
                scope.fdatos.PotEleConP5=null;
                scope.fdatos.PotEleConP6=null;
                 if (scope.fdatos.PotEleConP1 == null || scope.fdatos.PotEleConP1 == undefined || scope.fdatos.PotEleConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','Potencia 1');
                     return false;
                 }
                 if (scope.fdatos.PotEleConP2 == null || scope.fdatos.PotEleConP2 == undefined || scope.fdatos.PotEleConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','Potencia 2');
                     return false;
                 }
                 if (scope.fdatos.PotEleConP3 == null || scope.fdatos.PotEleConP3 == undefined || scope.fdatos.PotEleConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','Potencia 3');
                     return false;
                 }
            }
            
            if (scope.CanPerTar == 4) 
            {   
                scope.fdatos.PotEleConP5=null;
                scope.fdatos.PotEleConP6=null;
                if (scope.fdatos.PotEleConP1 == null || scope.fdatos.PotEleConP1 == undefined || scope.fdatos.PotEleConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','Potencia 1');
                     return false;
                }
                if (scope.fdatos.PotEleConP2 == null || scope.fdatos.PotEleConP2 == undefined || scope.fdatos.PotEleConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','Potencia 2');
                     return false;
                }
                if (scope.fdatos.PotEleConP3 == null || scope.fdatos.PotEleConP3 == undefined || scope.fdatos.PotEleConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','Potencia 3');
                     return false;
                }
                if (scope.fdatos.PotEleConP4 == null || scope.fdatos.PotEleConP4 == undefined || scope.fdatos.PotEleConP4 == '') {
                     scope.toast('error','Debe indicar la Potencia 4','Potencia 4');
                     return false;
                }
            }            
            if (scope.CanPerTar == 5) 
            {   
                scope.fdatos.PotEleConP6=null;
                if (scope.fdatos.PotEleConP1 == null || scope.fdatos.PotEleConP1 == undefined || scope.fdatos.PotEleConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','Potencia 1');
                      return false;
                 }
                 if (scope.fdatos.PotEleConP2 == null || scope.fdatos.PotEleConP2 == undefined || scope.fdatos.PotEleConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','Potencia 2');
                     return false;
                 }
                 if (scope.fdatos.PotEleConP3 == null || scope.fdatos.PotEleConP3 == undefined || scope.fdatos.PotEleConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','Potencia 3');
                     return false;
                 }
                 if (scope.fdatos.PotEleConP4 == null || scope.fdatos.PotEleConP4 == undefined || scope.fdatos.PotEleConP4 == '') {
                     scope.toast('error','Debe indicar la Potencia 4','Potencia 4');
                     return false;
                 }
                 if (scope.fdatos.PotEleConP5 == null || scope.fdatos.PotEleConP5 == undefined || scope.fdatos.PotEleConP5 == '') {
                     scope.toast('error','Debe indicar la Potencia 5','Potencia 5');
                     return false;
                 }
            }             
            if (scope.CanPerTar == 6) 
            {
                if (scope.fdatos.PotEleConP1 == null || scope.fdatos.PotEleConP1 == undefined || scope.fdatos.PotEleConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','Potencia 1');
                     return false;
                }
                if (scope.fdatos.PotEleConP2 == null || scope.fdatos.PotEleConP2 == undefined || scope.fdatos.PotEleConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','Potencia 2');
                     return false;
                }
                if (scope.fdatos.PotEleConP3 == null || scope.fdatos.PotEleConP3 == undefined || scope.fdatos.PotEleConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','Potencia 3');
                     return false;
                }
                if (scope.fdatos.PotEleConP4 == null || scope.fdatos.PotEleConP4 == undefined || scope.fdatos.PotEleConP4 == '') {
                     scope.toast('error','Debe indicar la Potencia 4','Potencia 4');
                     return false;
                }
                if (scope.fdatos.PotEleConP5 == null || scope.fdatos.PotEleConP5 == undefined || scope.fdatos.PotEleConP5 == '') {
                     scope.toast('error','Debe indicar la Potencia 5','Potencia 5');
                     return false;
                }
                if (scope.fdatos.PotEleConP6 == null || scope.fdatos.PotEleConP6 == undefined || scope.fdatos.PotEleConP6 == '') {
                     scope.toast('error','Debe indicar la Potencia 6','Potencia 6');
                     return false;
                }
            }
            if (scope.fdatos.ConCup == null || scope.fdatos.ConCup == undefined || scope.fdatos.ConCup == '') {
                 scope.toast('error','Debe indicar un Consumo Eléctrico.','Consumo');
                 return false;
            }
            if (scope.fdatos.ImpAho == null || scope.fdatos.ImpAho == undefined || scope.fdatos.ImpAho == '') {
                 scope.toast('error','Debe indicar un importe de ahorro eléctrico.','Ahorro');
                 return false;
            }
            if (scope.fdatos.PorAho == null || scope.fdatos.PorAho == undefined || scope.fdatos.PorAho == '') {
                 scope.toast('error','Debe indicar un porcentaje eléctrico.','Porcentaje');
                 return false;
            }
            if (scope.fdatos.ObsCup == null || scope.fdatos.ObsCup == undefined || scope.fdatos.ObsCup == '') {
                 scope.fdatos.ObsCup = null;
            }else {
                 scope.fdatos.ObsCup = scope.fdatos.ObsCup;
            }
            
        }       

         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
    }
    scope.validar_campos_CUPsGas = function() 
    {
        resultado = true; 
        if (scope.CodCliCUPs==null||scope.CodCliCUPs==undefined||scope.CodCliCUPs=='') {
             scope.toast('error','Debe seleccionar un Cliente.','Cliente');
             return false;
        } 
        if (!scope.fdatos.CodCupSGas > 0) 
        {
            scope.toast('error','Debe seleccionar un CUPs Gas.','');
                 return false;
        }
        if (!scope.fdatos.CodTar > 0 || scope.fdatos.CodTar==0) {
                 scope.toast('error','Debe seleccionar una Tarifa de Gas.','');
                 return false;
             }
        if (scope.fdatos.CauDiaGas == null || scope.fdatos.CauDiaGas == undefined || scope.fdatos.CauDiaGas == '') {
                 scope.toast('error','Debe indicar un Caudal Diario.','');
                 return false;
        }
        if (scope.fdatos.ConCup == null || scope.fdatos.ConCup == undefined || scope.fdatos.ConCup == '') {
                 scope.toast('error','Debe indicar un consumo Gas.','');
                 return false;
        }
        
        if (scope.fdatos.ImpAho == null || scope.fdatos.ImpAho == undefined || scope.fdatos.ImpAho == '') {
                 scope.toast('error','Debe indicar un importe de ahorro de gas.','');
                 return false;
             }
             if (scope.fdatos.PorAho == null || scope.fdatos.PorAho == undefined || scope.fdatos.PorAho == '') {
                 scope.toast('error','Debe indicar un porcentaje de gas.','');
                 return false;
             }
             if (scope.fdatos.ObsCup == null || scope.fdatos.ObsCup == undefined || scope.fdatos.ObsCup == '') {
                 scope.fdatos.ObsCup = null;
             } else {
                 scope.fdatos.ObsCup = scope.fdatos.ObsCup;
             }

         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
    }
      scope.validar_formatos_input = function(metodo, object) {
         
        if (metodo == 1){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotEleConP1 = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 2){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotEleConP2 = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 3){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotEleConP3 = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 4){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotEleConP4 = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo ==5){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotEleConP5 = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 6){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotEleConP6 = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 7){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.ConCup = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 8){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.ImpAho = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo == 9){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PorAho = numero.substring(0, numero.length - 1);
             }
        }
        if (metodo ==10){
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.CauDiaGas = numero.substring(0, numero.length - 1);
             }
        }  
        if (metodo ==11){
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecProCom = numero.substring(0, numero.length - 1);
             }
        }        
     }
     scope.filtrerCanPeriodos = function(CodTarEle) {
         console.log(CodTarEle);
         for (var i = 0; i < scope.List_TarEle.length; i++) {
             
             if (scope.List_TarEle[i].CodTarEle == CodTarEle) {
                scope.CanPerTar = scope.List_TarEle[i].CanPerTar;
                console.log(scope.CanPerTar);
                if(scope.CanPerTar==0||scope.CanPerTar==null)
                {
                    scope.toast('error','Esta Tárifa no tiene cantidad de periodos asignada','Error en Periodos');
                    scope.CanPerTar=6;
                }
            }
        }

    }
    scope.enviarcorreopropuesta=function()
     {
        $("#enviando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome()+"api/PropuestaComercial/EnviarPropuestaCorreo/";
        $http.post(url,scope.fdatos).then(function(result)
        {
            $("#enviando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                scope.toast('success','Se ha enviado un correo electrónico a '+result.data.EmailEnviar,'Correo Enviado'); 
            }
            else
            {
                scope.toast('error','Un Error ha ocurrido al intentar enviar el correo, intente nuevamente.','Error Email');
            }
        },function(error)
        {
            $("#enviando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
        });
     }
     if($route.current.$$route.originalPath=="/Add_Propuesta_Comercial_MulCliente_MultiPunto/:CodCli/:Tipo")
    {
        scope.getDatosServer();
    }
    if($route.current.$$route.originalPath=="/Ver_Propuesta_Comercial_MulCliente/:CodProCom/:Tipo" || $route.current.$$route.originalPath=="/Edit_Propuesta_Comercial_MulCliente/:CodProCom/:Tipo")
     {
        scope.BuscarXIDProComMulCliente();
     }

    var i = -1;
    var toastCount = 0;
    var $toastlast;
    var getMessage = function () {
            var msgs = ['My name is Inigo Montoya. You killed my father. Prepare to die!',
                '<div><input class="input-small" value="textbox"/>&nbsp;<a href="http://johnpapa.net" target="_blank">This is a hyperlink</a></div><div><button type="button" id="okBtn" class="btn btn-primary">Close me</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">Surprise me</button></div>',
                'Are you the six fingered man?',
                'Inconceivable!',
                'I do not think that means what you think it means.',
                'Have fun storming the castle!'
            ];
            i++;
            if (i === msgs.length) {
                i = 0;
            }

            return msgs[i];
        };

        var getMessageWithClearButton = function (msg){
            msg = msg ? msg : 'Clear itself?';
            msg += '<br /><br /><button type="button" class="btn clear">Yes</button>';
            return msg;
        };

        $('#closeButton').click(function(){
            if($(this).is(':checked')) {
                $('#addBehaviorOnToastCloseClick').prop('disabled', false);
            } else {
                $('#addBehaviorOnToastCloseClick').prop('disabled', true);
                $('#addBehaviorOnToastCloseClick').prop('checked', false);
            }
        });
        scope.toast=function(status,msg,title)
        {
            var shortCutFunction = status;
            var msg = msg;
            var title = title;
            var $showDuration = 100;
            var $hideDuration = 1000;
            var $timeOut = 800;
            var $extendedTimeOut = 1000;
            var $showEasing = 'swing';
            var $hideEasing = 'linear';
            var $showMethod = 'fadeIn';
            var $hideMethod = "fadeOut";
            var toastIndex = toastCount++;
            var addClear = false;

            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                rtl: false,
                positionClass: "toast-top-right",
                preventDuplicates: true,
                onclick: null
            };

            if ($showDuration.length) {
                toastr.options.showDuration = parseInt($showDuration);
            }

            if ($hideDuration.length) {
                toastr.options.hideDuration = parseInt($hideDuration);
            }

            if ($timeOut.length) {
                toastr.options.timeOut = addClear ? 0 : parseInt($timeOut);
            }

            if ($extendedTimeOut.length) {
                toastr.options.extendedTimeOut = addClear ? 0 : parseInt($extendedTimeOut);
            }

            if ($showEasing.length) {
                toastr.options.showEasing = $showEasing;
            }

            if ($hideEasing.length) {
                toastr.options.hideEasing = $hideEasing;
            }

            if ($showMethod.length) {
                toastr.options.showMethod = $showMethod;
            }

            if ($hideMethod.length) {
                toastr.options.hideMethod = $hideMethod;
            }

            if (addClear) {
                msg = getMessageWithClearButton(msg);
                toastr.options.tapToDismiss = false;
            }
            if (!msg) {
                msg = getMessage();
            }
            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;

            if(typeof $toast === 'undefined'){
                return;
            }
            if ($toast.find('#okBtn').length) {
                $toast.delegate('#okBtn', 'click', function () {
                    alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
                    $toast.remove();
                });
            }
            if ($toast.find('#surpriseBtn').length) {
                $toast.delegate('#surpriseBtn', 'click', function () {
                    alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
                });
            }
            if ($toast.find('.clear').length) {
                $toast.delegate('.clear', 'click', function () {
                    toastr.clear($toast, { force: true });
                });
            }
        }
        function getLastToast()
        {
            return $toastlast;
        }
        $('#clearlasttoast').click(function (){
            toastr.clear(getLastToast());
        });
        $('#cleartoasts').click(function () {
            toastr.clear();
        });
     /*else
     {
         scope.PropuestasClientesAll();
     }*/
     ////////////////////////////////////////////////// PARA Las Propuestas END ////////////////////////////////////////////////////////    
 }