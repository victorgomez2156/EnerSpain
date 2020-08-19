 app.controller('Controlador_Add_Propuestas', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
     var scope = this;
     scope.fdatos = {};

     scope.fdatos.CodCli = $route.current.params.CodCli;
     scope.CodConCom = $route.current.params.CodConCom;
     scope.CodProCom = $route.current.params.CodProCom;
     scope.no_editable = $route.current.params.INF;
     scope.fdatos.tipo = $route.current.params.Tipo;
     scope.fdatos.detalleCUPs=[];
     scope.Nivel = $cookies.get('nivel');
     scope.List_TipPre = [{ TipPre: 0, nombre: 'Fijo' }, { TipPre: 1, nombre: 'Indexado' }, { TipPre: 2, nombre: 'Ambos' }];
     var fecha = new Date();
     var dd = fecha.getDate();
     var mm = fecha.getMonth() + 1; //January is 0!
     var yyyy = fecha.getFullYear();
     if (dd < 10) {
         dd = '0' + dd
     }
     if (mm < 10) {
         mm = '0' + mm
     }
     var fecha = dd + '/' + mm + '/' + yyyy;
     scope.CanPerEle = 6;
     ////////////////////////////////////////////////// PARA LOS CONTACTOS START ////////////////////////////////////////////////////////
     //console.log('CodCli: '+ scope.fdatos.CodCli);
     //console.log('CodConCom: '+scope.CodConCom);
     //console.log('CodProCom: '+scope.CodProCom);
     //console.log('Tipo: '+scope.fdatos.tipo);
     //console.log($route.current.$$route.originalPath);
     scope.fdatos.EstProCom = 'P';
     scope.fdatos.RenConEle = false;
     scope.fdatos.RenConGas = false;
     scope.fdatos.Rech = false;
     scope.fdatos.Apro = false;

     scope.buscar_datos_clientes = function() {
         $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/get_data_clientes_propuestas/CodCli/" + scope.fdatos.CodCli;
         $http.get(url).then(function(result) {
             $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 if (result.data.Cliente != false) {
                     scope.RazSocCli = result.data.Cliente.RazSocCli;
                     scope.NumCifCli = result.data.Cliente.NumCifCli;
                     scope.FecProCom = result.data.Cliente.Fecha_Propuesta;
                     scope.Fecha_Propuesta = result.data.Cliente.Fecha_Propuesta;
                     $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Cliente.Fecha_Propuesta);
                     scope.fdatos.RefProCom = result.data.Cliente.Referencia;
                     scope.disabled_status = true;
                     scope.List_TarEle = result.data.TarEle;
                     scope.List_TarGas = result.data.TarGas;
                     scope.List_Comercializadora = result.data.Comercializadoras;
                 }
                 if (result.data.Puntos_Suministros == false) {
                     scope.toast('error','Este cliente no tiene puntos de suministros asignados.','Puntos de Suministros');
                     scope.disabled_button = true;
                     scope.List_Puntos_Suministros = [];
                     scope.DirPumSum = undefined;
                     scope.EscPlaPuerPumSum = undefined;
                     scope.DesLocPumSum = undefined;
                     scope.DesProPumSum = undefined;
                     scope.CPLocPumSum = undefined;
                 } else {
                     scope.List_Puntos_Suministros = result.data.Puntos_Suministros;
                 }
             } else {
                 scope.toast('error','Este cliente no esta registrado.','Cliente');
                 location.href = "#/Propuesta_Comercial";
             }
         }, function(error) {
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
     scope.filter_DirPumSum = function(CodPunSum) {
         console.log(CodPunSum);
         scope.fdatos.CodCupSEle = undefined;
         scope.fdatos.CodTarEle = undefined;
         scope.fdatos.PotConP1 = undefined;
         scope.fdatos.PotConP2 = undefined;
         scope.fdatos.PotConP3 = undefined;
         scope.fdatos.PotConP4 = undefined;
         scope.fdatos.PotConP5 = undefined;
         scope.fdatos.PotConP6 = undefined;
         scope.fdatos.CodCupGas = undefined;
         scope.fdatos.CodTarGas = undefined;
         scope.fdatos.Consumo = undefined;
         scope.fdatos.CauDia = undefined;
         for (var i = 0; i < scope.List_Puntos_Suministros.length; i++) {
             if (scope.List_Puntos_Suministros[i].CodPunSum == CodPunSum) {
                 //console.log(scope.List_Puntos_Suministros[i]);
                 scope.DirPumSum = scope.List_Puntos_Suministros[i].DirPumSum;
                 scope.EscPlaPuerPumSum = scope.List_Puntos_Suministros[i].EscPunSum + " " + scope.List_Puntos_Suministros[i].PlaPunSum + " " + scope.List_Puntos_Suministros[i].PuePunSum;
                 scope.DesLocPumSum = scope.List_Puntos_Suministros[i].DesLoc;
                 scope.DesProPumSum = scope.List_Puntos_Suministros[i].DesPro;
                 scope.CPLocPumSum = scope.List_Puntos_Suministros[i].CPLocSoc;
             }
         }
         $("#CUPs").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/Search_CUPs_Customer/CodPumSum/" + scope.fdatos.CodPunSum;
         $http.get(url).then(function(result) {
             $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");

             if (result.data != false) {
                 console.log(result);
                 scope.List_CUPsEle = result.data.CUPs_Electricos;
                 scope.List_CUPs_Gas = result.data.CUPs_Gas;
             }
             if (result.data.CUPs_Electricos == false && result.data.CUPs_Gas == false) {
                scope.toast('error','El Cliente debe tener al menos un tipo de CUPs registrado para poder generar una Propuesta Comercial','CUPs');
                
             }
         }, function(error) {
             $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.CUPsFilter = function(metodo, CodCUPs) {
         if (metodo == 1) {
             console.log(CodCUPs);
             for (var i = 0; i < scope.List_CUPsEle.length; i++) {
                 if (scope.List_CUPsEle[i].CodCupsEle == CodCUPs) {
                     console.log(scope.List_CUPsEle[i]);
                     scope.fdatos.CodTarEle = scope.List_CUPsEle[i].CodTarElec;
                     scope.fdatos.PotConP1 = scope.List_CUPsEle[i].PotConP1;
                     scope.fdatos.PotConP2 = scope.List_CUPsEle[i].PotConP2;
                     scope.fdatos.PotConP3 = scope.List_CUPsEle[i].PotConP3;
                     scope.fdatos.PotConP4 = scope.List_CUPsEle[i].PotConP4;
                     scope.fdatos.PotConP5 = scope.List_CUPsEle[i].PotConP5;
                     scope.fdatos.PotConP6 = scope.List_CUPsEle[i].PotConP6;
                     if(scope.List_CUPsEle[i].CanPerTar==null||scope.List_CUPsEle[i].CanPerTar==0)
                     {
                        scope.CanPerEle =6;
                     }
                     else
                     {
                        scope.CanPerEle = scope.List_CUPsEle[i].CanPerTar;
                     }
                     if(scope.fdatos.CodTarEle==0||scope.fdatos.CodTarEle==null)
                     {
                         scope.toast('error','Debe Seleccionar una Tárifa para el CUPs Eléctrico','CUPs Sin Tárifa');
                     }
                     
                 }
             }
         }
         if (metodo == 2) {
             for (var i = 0; i < scope.List_CUPs_Gas.length; i++) {
                 if (scope.List_CUPs_Gas[i].CodCupGas == CodCUPs) {
                     console.log(scope.List_CUPs_Gas[i]);
                     scope.fdatos.CodTarGas = scope.List_CUPs_Gas[i].CodTarGas;
                     scope.fdatos.Consumo = scope.List_CUPs_Gas[i].ConAnuCup;
                 }
             }
         }
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
     $scope.submitFormPropuesta = function(event) {
         //scope.fdatos.CodCli=scope.fdatos.CodCli;  
         scope.fdatos.TipProCom=1;
         console.log(scope.fdatos);
         if (!scope.validar_campos_propuestas()) {
             return false;
         }
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
         scope.crear_array_cups();
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
                         if (result.data.status == false && result.data.statusText == 'Error') {
                             scope.toast('error',result.data.menssage,loader);
                             location.href = "#/Propuesta_Comercial";
                             return false;

                         }
                         if (result.data.status == true && result.data.statusText == 'Propuesta Comercial') {
                             scope.toast('success',result.data.menssage,loader);
                             location.reload();
                             return false;

                         }
                         scope.toast('success',"Propuesta Comercial generada correctamente bajo el número de referencia: " + result.data.RefProCom,'Propuesta Comercial');
                         location.href = "#/Propuesta_Comercial";
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
     scope.crear_array_cups=function()
     {
        scope.fdatos.detalleCUPs = [];
        if(scope.fdatos.CodCupSEle>0 && scope.fdatos.CodCupGas==null)
        {
            var ObjDetCUPs = new Object();
            if (scope.fdatos.detalleCUPs == undefined || scope.fdatos.detalleCUPs == false) {
                scope.fdatos.detalleCUPs = [];
            }
               if(scope.fdatos.RenConEle==false)
               {
               		scope.fdatos.RenConEle=null;
               }
                scope.fdatos.detalleCUPs.push({CodCups:scope.fdatos.CodCupSEle,CodTar:scope.fdatos.CodTarEle,
                PotConP1:scope.fdatos.PotConP1,PotConP2:scope.fdatos.PotConP2,PotConP3:scope.fdatos.PotConP3,
                PotConP4:scope.fdatos.PotConP4,PotConP5:scope.fdatos.PotConP5,PotConP6:scope.fdatos.PotConP6,
                ImpAho:scope.fdatos.ImpAhoEle,PorAho:scope.fdatos.PorAhoEle,RenCon:scope.fdatos.RenConEle,
                ObsCup:scope.fdatos.ObsAhoEle,ConCUPs:scope.fdatos.ConCupsEle,CauDia:null,TipServ:1 });
        }
        else if (scope.fdatos.CodCupSEle==null && scope.fdatos.CodCupGas>0) 
        {
            if(scope.fdatos.RenConGas==false)
               {
               		scope.fdatos.RenConGas=null;
               }
            scope.fdatos.detalleCUPs.push({CodCups:scope.fdatos.CodCupGas,CodTar:scope.fdatos.CodTarGas,
                PotConP1:null,PotConP2:null,PotConP3:null,
                PotConP4:null,PotConP5:null,PotConP6:null,
                ImpAho:scope.fdatos.ImpAhoGas,PorAho:scope.fdatos.PorAhoGas,RenCon:scope.fdatos.RenConGas,
                ObsCup:scope.fdatos.ObsAhoGas,ConCUPs:scope.fdatos.Consumo,CauDia:scope.fdatos.CauDia,TipServ:2});
        }
        else
        {
            if(scope.fdatos.CodCupSEle>0)
            {
                var ObjDetCUPs = new Object();
                if (scope.fdatos.detalleCUPs == undefined || scope.fdatos.detalleCUPs == false) {
                    scope.fdatos.detalleCUPs = [];
                }
                    
                    if(scope.fdatos.RenConEle==false)
               {
               		scope.fdatos.RenConEle=null;
               }
                    scope.fdatos.detalleCUPs.push({CodCups:scope.fdatos.CodCupSEle,CodTar:scope.fdatos.CodTarEle,
                    PotConP1:scope.fdatos.PotConP1,PotConP2:scope.fdatos.PotConP2,PotConP3:scope.fdatos.PotConP3,
                    PotConP4:scope.fdatos.PotConP4,PotConP5:scope.fdatos.PotConP5,PotConP6:scope.fdatos.PotConP6,
                    ImpAho:scope.fdatos.ImpAhoEle,PorAho:scope.fdatos.PorAhoEle,RenCon:scope.fdatos.RenConEle,
                    ObsCup:scope.fdatos.ObsAhoEle,ConCUPs:scope.fdatos.ConCupsEle,CauDia:null,TipServ:1 });
            }
            if (scope.fdatos.CodCupGas>0)
             {
                var ObjDetCUPs = new Object();
                if (scope.fdatos.detalleCUPs == undefined || scope.fdatos.detalleCUPs == false) {
                    scope.fdatos.detalleCUPs = [];
                }
                    if(scope.fdatos.RenConGas==false)
               {
               		scope.fdatos.RenConGas=null;
               }
                    scope.fdatos.detalleCUPs.push({CodCups:scope.fdatos.CodCupGas,CodTar:scope.fdatos.CodTarGas,
                    PotConP1:null,PotConP2:null,PotConP3:null,
                    PotConP4:null,PotConP5:null,PotConP6:null,
                    ImpAho:scope.fdatos.ImpAhoGas,PorAho:scope.fdatos.PorAhoGas,RenCon:scope.fdatos.RenConGas,
                    ObsCup:scope.fdatos.ObsAhoGas,ConCUPs:scope.fdatos.Consumo,CauDia:scope.fdatos.CauDia,TipServ:2});
                    //console.log(scope.fdatos.detalleCUPs);
             }

        }
        console.log(scope.fdatos.detalleCUPs);
     }
     scope.validar_campos_propuestas = function() {
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
         if (scope.fdatos.RefProCom == null || scope.fdatos.RefProCom == undefined || scope.fdatos.RefProCom == '') {
             scope.toast('error','El número de la propuesta es requerido.','');
             return false;
         }

         if (!scope.fdatos.EstProCom > 0) {
             scope.toast('error','El Estatus de la propuesta es requerido.','');
             return false;
         }

         if (!scope.fdatos.CodPunSum > 0) {
             scope.toast('error','Debe seleccionar un punto de suministro.','');
             return false;
         }
         if (!scope.fdatos.CodCupSEle > 0 && !scope.fdatos.CodCupGas > 0) {
             scope.toast('error','Debe seleccionar un Tipo de CUPs Para generer una propuesta comercial','');
             return false;
         }
         if (scope.fdatos.CodCupSEle > 0) {             
             if (!scope.fdatos.CodTarEle > 0 || scope.fdatos.CodTarEle==0) {
                 scope.toast('error','Debe seleccionar una Tarifa Eléctrica.','');
                 return false;
             }

             if (scope.CanPerEle == 1) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 2) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 3) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 4) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                     scope.toast('error','Debe indicar la Potencia 4','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 5) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','');
                      return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                     scope.toast('error','Debe indicar la Potencia 4','');
                     return false;
                 }
                 if (scope.fdatos.PotConP5 == null || scope.fdatos.PotConP5 == undefined || scope.fdatos.PotConP5 == '') {
                     scope.toast('error','Debe indicar la Potencia 5','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 6) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                     scope.toast('error','Debe indicar la Potencia 4','');
                     return false;
                 }
                 if (scope.fdatos.PotConP5 == null || scope.fdatos.PotConP5 == undefined || scope.fdatos.PotConP5 == '') {
                     scope.toast('error','Debe indicar la Potencia 5','');
                     return false;
                 }
                 if (scope.fdatos.PotConP6 == null || scope.fdatos.PotConP6 == undefined || scope.fdatos.PotConP6 == '') {
                     scope.toast('error','Debe indicar la Potencia 6','');
                     return false;
                 }
             }
             if (scope.fdatos.ImpAhoEle == null || scope.fdatos.ImpAhoEle == undefined || scope.fdatos.ImpAhoEle == '') {
                 scope.toast('error','Debe indicar un importe de ahorro eléctrico.','');
                 return false;
             }
             if (scope.fdatos.PorAhoEle == null || scope.fdatos.PorAhoEle == undefined || scope.fdatos.PorAhoEle == '') {
                 scope.toast('error','Debe indicar un porcentaje eléctrico.','');
                 return false;
             }
             if (scope.fdatos.ObsAhoEle == null || scope.fdatos.ObsAhoEle == undefined || scope.fdatos.ObsAhoEle == '') {
                 scope.fdatos.ObsAhoEle = null;
             } else {
                 scope.fdatos.ObsAhoEle = scope.fdatos.ObsAhoEle;
             }
             if (scope.fdatos.ConCupsEle == null || scope.fdatos.ConCupsEle == undefined || scope.fdatos.ConCupsEle == '') {
                 scope.toast('error','Debe indicar un consumo Eléctrico.','');
                 return false;
             }
         } else {
             scope.fdatos.CodCupSEle = null;
             scope.fdatos.CodTarEle = null;
             scope.fdatos.PotConP1 = null;
             scope.fdatos.PotConP2 = null;
             scope.fdatos.PotConP3 = null;
             scope.fdatos.PotConP4 = null;
             scope.fdatos.PotConP5 = null;
             scope.fdatos.PotConP6 = null;
             scope.fdatos.ImpAhoEle = null;
             scope.fdatos.PorAhoEle = null;
             scope.fdatos.ObsAhoEle = null;
         }
         if (scope.fdatos.CodCupGas > 0) {
             if (!scope.fdatos.CodTarGas > 0 || scope.fdatos.CodTarGas==0) {
                 scope.toast('error','Debe seleccionar una Tarifa de Gas.','');
                 return false;
             }
             if (scope.fdatos.Consumo == null || scope.fdatos.Consumo == undefined || scope.fdatos.Consumo == '') {
                 scope.toast('error','Debe indicar un consumo Gas.','');
                 return false;
             }
             if (scope.fdatos.CauDia == null || scope.fdatos.CauDia == undefined || scope.fdatos.CauDia == '') {
                 scope.toast('error','Debe indicar un Caudal Diario.','');
                 return false;
             }
             if (scope.fdatos.ImpAhoGas == null || scope.fdatos.ImpAhoGas == undefined || scope.fdatos.ImpAhoGas == '') {
                 scope.toast('error','Debe indicar un importe de ahorro de gas.','');
                 return false;
             }
             if (scope.fdatos.PorAhoGas == null || scope.fdatos.PorAhoGas == undefined || scope.fdatos.PorAhoGas == '') {
                 scope.toast('error','Debe indicar un porcentaje de gas.','');
                 return false;
             }
             if (scope.fdatos.ObsAhoGas == null || scope.fdatos.ObsAhoGas == undefined || scope.fdatos.ObsAhoGas == '') {
                 scope.fdatos.ObsAhoGas = null;
             } else {
                 scope.fdatos.ObsAhoGas = scope.fdatos.ObsAhoGas;
             }
         } else {
             scope.fdatos.CodCupGas = null;
             scope.fdatos.CodTarGas = null;
             scope.fdatos.Consumo = null;
             scope.fdatos.CauDia = null;
             scope.fdatos.ImpAhoGas = null;
             scope.fdatos.PorAhoGas = null;
             scope.fdatos.ObsAhoGas = null;
         }
         if (!scope.fdatos.CodCom > 0) {
             scope.toast('error','Debe seleccionar una Comercializadora.','');
              return false;
         }
         if (!scope.fdatos.CodPro > 0) {
             scope.toast('error','Debe seleccionar un producto.','');
             return false;
         }
         if (!scope.fdatos.CodAnePro > 0) {
             scope.toast('error','Debe seleccionar un Anexo.','');
             return false;
         }
         if (!scope.fdatos.TipPre > 0) {
             scope.toast('error','Debe seleccionar un Tipo de Precio.','');
             return false;
         }
         if (scope.fdatos.ObsProCom == null || scope.fdatos.ObsProCom == undefined || scope.fdatos.ObsProCom == '') {
             scope.fdatos.ObsProCom = null;
         } else {
             scope.fdatos.ObsProCom = scope.fdatos.ObsProCom;
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
     scope.validar_formatos_input = function(metodo, object) {
         console.log(object);
         console.log(metodo);
         if (metodo == 1) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecProCom = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 2) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP1 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 3) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP2 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 4) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP3 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 5) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP4 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 6) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP5 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 7) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP6 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 8) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.ImpAhoEle = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.ImpAhoEle != undefined || scope.fdatos.ImpAhoEle != null || scope.fdatos.ImpAhoEle != '' && scope.fdatos.ImpAhoGas != undefined || scope.fdatos.ImpAhoGas != null || scope.fdatos.ImpAhoGas != '') {
                 scope.fdatos.ImpAhoTot = Math.max(parseFloat(scope.fdatos.ImpAhoEle), 0) + Math.max(parseFloat(scope.fdatos.ImpAhoGas), 0);
                 //scope.fdatos.ImpAhoTot = Math.max(parseInt(scope.fdatos.ImpAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.ImpAhoGas).toFixed(2));
             }
             if (scope.fdatos.ImpAhoGas == undefined || scope.fdatos.ImpAhoGas == null || scope.fdatos.ImpAhoGas == '') {
                 scope.fdatos.ImpAhoTot = scope.fdatos.ImpAhoEle;
             }

         }
         if (metodo == 9) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PorAhoEle = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.PorAhoEle != undefined || scope.fdatos.PorAhoEle != null || scope.fdatos.PorAhoEle != '' && scope.fdatos.PorAhoGas != undefined || scope.fdatos.PorAhoGas != null || scope.fdatos.PorAhoGas != '') {
                 scope.fdatos.PorAhoTot = Math.max(parseFloat(scope.fdatos.PorAhoEle), 0) + Math.max(parseFloat(scope.fdatos.PorAhoGas), 0);
                 //scope.fdatos.PorAhoTot = Math.max(parseInt(scope.fdatos.PorAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.PorAhoGas).toFixed(2));
             }
             if (scope.fdatos.PorAhoGas == undefined || scope.fdatos.PorAhoGas == null || scope.fdatos.PorAhoGas == '') {
                 scope.fdatos.PorAhoTot = scope.fdatos.PorAhoEle;
             }
         }
         if (metodo == 10) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.Consumo = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 11) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.CauDia = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 12) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.ImpAhoGas = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.ImpAhoEle != undefined || scope.fdatos.ImpAhoEle != null || scope.fdatos.ImpAhoEle != '' && scope.fdatos.ImpAhoGas != undefined || scope.fdatos.ImpAhoGas != null || scope.fdatos.ImpAhoGas != '') {
                 scope.fdatos.ImpAhoTot = Math.max(parseFloat(scope.fdatos.ImpAhoEle), 0) + Math.max(parseFloat(scope.fdatos.ImpAhoGas), 0);
                 //scope.fdatos.ImpAhoTot = Math.max(parseInt(scope.fdatos.ImpAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.ImpAhoGas).toFixed(2));
             }
             if (scope.fdatos.ImpAhoEle == undefined || scope.fdatos.ImpAhoEle == null || scope.fdatos.ImpAhoEle == '') {
                 scope.fdatos.ImpAhoTot = scope.fdatos.ImpAhoGas;
             }

         }
         if (metodo == 13) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PorAhoGas = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.PorAhoEle != undefined || scope.fdatos.PorAhoEle != null || scope.fdatos.PorAhoEle != '' && scope.fdatos.PorAhoGas != undefined || scope.fdatos.PorAhoGas != null || scope.fdatos.PorAhoGas != '') {
                 scope.fdatos.PorAhoTot = Math.max(parseFloat(scope.fdatos.PorAhoEle), 0) + Math.max(parseFloat(scope.fdatos.PorAhoGas), 0);
                 //scope.fdatos.PorAhoTot = Math.max(parseInt(scope.fdatos.PorAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.PorAhoGas).toFixed(2));
             }
             if (scope.fdatos.PorAhoEle == undefined || scope.fdatos.PorAhoEle == null || scope.fdatos.PorAhoEle == '') {
                 scope.fdatos.PorAhoTot = scope.fdatos.PorAhoGas;
             }
         }
     }

     scope.BuscarXidCodPro = function()
     {
         $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/get_propuesta_comercial/CodProCom/" + scope.CodProCom;
         $http.get(url).then(function(result) {
             $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 
                 scope.RazSocCli = result.data.Cliente.RazSocCli;
                 scope.NumCifCli = result.data.Cliente.NumCifCli;
                 scope.List_TarEle = result.data.TarEle;
                 scope.List_TarGas = result.data.TarGas;
                 scope.List_CUPsEle = result.data.CUPs_Electricos;
                 scope.List_CUPs_Gas = result.data.CUPs_Gas;
                 scope.List_Comercializadora = result.data.Comercializadoras;
                 scope.FecProCom = result.data.Propuesta.FecProCom;
                 scope.Fecha_Propuesta = scope.FecProCom;
                 scope.fdatos = result.data.Propuesta;
                 scope.fdatos.CodCli = result.data.CodCli;
                 scope.fdatos.CodProComCli=result.data.CodProComCli;
                 scope.disabled_status = true;
                 scope.fdatos.tipo = $route.current.params.Tipo;
                 scope.List_Puntos_Suministros = result.data.Puntos_Suministros;                 
                 scope.BuscarDetallesCUPs(result.data.CodProComCli);                 
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
             } else {
                 scope.toast('error','Está propuesta no se encuentra registrada.','Error');
                 location.href = "#/Propuesta_Comercial";
             }

         }, function(error) {
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
         console.log(url);

     }
    scope.LimpiarCUPs=function(metodo,CodCup)
    {
     	//console.log(metodo);
     	//console.log(CodCup);
     	scope.crear_array_cups();
     	//console.log(scope.fdatos.detalleCUPs);
     	if(metodo==1)
     	{
     		scope.fdatos.CodCupSEle=undefined;
	     	scope.fdatos.CodTarEle=undefined;
	     	scope.fdatos.PotConP1=undefined;
	     	scope.fdatos.PotConP2=undefined;
	     	scope.fdatos.PotConP3=undefined;
	     	scope.fdatos.PotConP4=undefined;
	     	scope.fdatos.PotConP5=undefined;
	     	scope.fdatos.PotConP6=undefined;
	     	scope.fdatos.ImpAhoEle=undefined;
	     	scope.fdatos.PorAhoEle=undefined;
	     	scope.fdatos.RenConEle=null;
	     	scope.fdatos.ConCupsEle=undefined;
	     	scope.fdatos.ObsAhoEle=undefined;
	     	scope.CanPerEle=6;
     	}
     	if(metodo==2)
     	{
     		scope.fdatos.CodCupGas=undefined;
     		scope.fdatos.CodTarGas=undefined;
     		scope.fdatos.Consumo=undefined;
     		scope.fdatos.CauDia=undefined;
     		scope.fdatos.ImpAhoGas=undefined;
			scope.fdatos.PorAhoGas=undefined;
			scope.fdatos.RenConGas=null;
			scope.fdatos.ObsAhoGas=undefined;
     	}
     	for (var i = 0; i < scope.fdatos.detalleCUPs.length; i++) {
            if (scope.fdatos.detalleCUPs[i].CodCups == CodCup) {
                scope.fdatos.detalleCUPs.splice(i, 1);
            }
        }
        console.log(scope.fdatos.detalleCUPs);
     	

    }
     scope.BuscarDetallesCUPs=function(CodProComCli)
     {
        var url = base_urlHome()+"api/PropuestaComercial/BuscarDetallesCUPsSencilla/CodProComCli/"+CodProComCli
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
            	scope.fdatos.CodPunSum=result.data[0].CodPunSum;
                scope.filter_DirPumSum(scope.fdatos.CodPunSum);


                angular.forEach(result.data, function(CUPs)
                {
                    scope.fdatos.CodPunSum=CUPs.CodPunSum;
                    
                    if(CUPs.TipCups==1)
                    {
                        scope.fdatos.CodCupSEle=CUPs.CodCup;
                        scope.fdatos.CodTarEle=CUPs.CodTar;
                        scope.filtrerCanPeriodos(scope.fdatos.CodTarEle)
                        scope.fdatos.PotConP1=CUPs.PotEleConP1;
                        scope.fdatos.PotConP2=CUPs.PotEleConP2;
                        scope.fdatos.PotConP3=CUPs.PotEleConP3;
                        scope.fdatos.PotConP4=CUPs.PotEleConP4;
                        scope.fdatos.PotConP5=CUPs.PotEleConP5;
                        scope.fdatos.PotConP6=CUPs.PotEleConP6;
                        scope.fdatos.ImpAhoEle=CUPs.ImpAho;
                        scope.fdatos.PorAhoEle=CUPs.PorAho;
                        if(CUPs.RenCup==0){scope.fdatos.RenConEle=false;}
                        else{scope.fdatos.RenConEle=true;}
                        scope.fdatos.ConCupsEle=CUPs.ConCup;
                        scope.fdatos.ObsAhoEle=CUPs.ObsAho;
                	}
                	if(CUPs.TipCups==2)
                    {
                        scope.fdatos.CodCupGas=CUPs.CodCup;
                        scope.fdatos.CodTarGas=CUPs.CodTar;
                        scope.fdatos.Consumo=CUPs.ConCup;
                        scope.fdatos.CauDia=CUPs.CauDiaGas;
                        scope.fdatos.ImpAhoGas=CUPs.ImpAho;
                        scope.fdatos.PorAhoGas=CUPs.PorAho;
                        if(CUPs.RenCup==0){scope.fdatos.RenConGas=false;}
                        else{scope.fdatos.RenConGas=true;}                        
                        scope.fdatos.ObsAhoGas=CUPs.ObsAho;
                	}
                });

                
            }
            else
            {
				scope.toast('error','No se encontraron CUPs Asignados a esta Propuesta Comercial','CUPs');
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
     scope.BuscarXidCodProComReno = function() {
         $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/get_propuesta_renovacion_contrato/CodCli/" + scope.fdatos.CodCli + "/CodConCom/" + scope.CodConCom + "/CodProCom/" + scope.CodProCom;
         $http.get(url).then(function(result) {
             $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 
                if(result.data.BuscarPropuesta==false)
                {
                    scope.toast('error','Esta renovación no pertenece a esta cliente o no existe.','Error');
                    location.href="#/Propuesta_Comercial";
                    return false;
                }
                 scope.disabled_status = true;
                 scope.RazSocCli = result.data.Cliente.RazSocCli;
                 scope.NumCifCli = result.data.Cliente.NumCifCli;
                 scope.FecProCom = result.data.FechaServer;
                 scope.fdatos.RefProCom = result.data.RefProCom;                 
                 scope.List_Puntos_Suministros = result.data.Puntos_Suministros;
                 $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
                 scope.fdatos.CodPunSum = result.data.BuscarPropuesta.CodPunSum;
                 scope.filter_DirPumSum(result.data.BuscarPropuesta.CodPunSum);
                 scope.List_TarEle = result.data.TarEle;
                 scope.List_TarGas = result.data.TarGas;
                 scope.fdatos.CodCupSEle = result.data.BuscarPropuesta.CodCupsEle;
                 scope.fdatos.CodTarEle = result.data.BuscarPropuesta.CodTarEle;
                 scope.fdatos.PotConP1 = result.data.BuscarPropuesta.PotConP1;
                 scope.fdatos.PotConP2 = result.data.BuscarPropuesta.PotConP2;
                 scope.fdatos.PotConP3 = result.data.BuscarPropuesta.PotConP3;
                 scope.fdatos.PotConP4 = result.data.BuscarPropuesta.PotConP4;
                 scope.fdatos.PotConP5 = result.data.BuscarPropuesta.PotConP5;
                 scope.fdatos.PotConP6 = result.data.BuscarPropuesta.PotConP6;
                 scope.fdatos.ImpAhoEle = result.data.BuscarPropuesta.ImpAhoEle;
                 scope.fdatos.PorAhoEle = result.data.BuscarPropuesta.PorAhoEle;
                 scope.fdatos.RenConEle = true;
                 scope.fdatos.ObsAhoEle = result.data.BuscarPropuesta.ObsAhoEle;
                 scope.fdatos.CodCupGas = result.data.BuscarPropuesta.CodCupsGas;
                 scope.fdatos.CodTarGas = result.data.BuscarPropuesta.CodTarGas;
                 scope.fdatos.Consumo = result.data.BuscarPropuesta.Consumo;
                 scope.fdatos.CauDia = result.data.BuscarPropuesta.CauDia;
                 scope.fdatos.ImpAhoGas = result.data.BuscarPropuesta.ImpAhoGas;
                 scope.fdatos.PorAhoGas = result.data.BuscarPropuesta.PorAhoGas;
                 scope.fdatos.RenConGas = true;
                 scope.fdatos.ObsAhoGas = result.data.BuscarPropuesta.ObsAhoGas;
                 scope.List_Comercializadora = result.data.Comercializadora;
                 scope.fdatos.CodCom = result.data.BuscarPropuesta.CodCom;
                 if( result.data.BuscarPropuesta.CodCom!=null)
                 {
                    scope.realizar_filtro(1, result.data.BuscarPropuesta.CodCom);
                 }
                if( result.data.BuscarPropuesta.CodPro!=null)
                {
                    scope.realizar_filtro(2, result.data.BuscarPropuesta.CodPro);
                }

                 scope.fdatos.CodPro = result.data.BuscarPropuesta.CodPro;
                 scope.fdatos.CodAnePro = result.data.BuscarPropuesta.CodAnePro;
                 scope.fdatos.TipPre = result.data.BuscarPropuesta.TipPre;
                 scope.fdatos.ImpAhoTot = result.data.BuscarPropuesta.ImpAhoTot;
                 scope.fdatos.PorAhoTot = result.data.BuscarPropuesta.PorAhoTot;
                 scope.fdatos.ObsProCom = result.data.BuscarPropuesta.ObsProCom;
                 scope.Fecha_Propuesta = result.data.FechaServer;

                 scope.fdatos.CodConCom = scope.CodConCom;
                 if (scope.fdatos.CodCupSEle != null) {
                     scope.filtrerCanPeriodos(result.data.BuscarPropuesta.CodTarEle);
                 }
                 scope.ProRenPen=1;
             } else {
                 scope.toast('error','El Número de CIF no se encuentra registrado.','Error');                 
                 //location.href="#/Propuesta_Comercial";
             }

         }, function(error) {
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
     scope.filtrerCanPeriodos = function(CodTarEle) {
         console.log(CodTarEle);
         //scope.fdatos.PotConP1=undefined;
         //scope.fdatos.PotConP2=undefined;
         //scope.fdatos.PotConP3=undefined;
         //scope.fdatos.PotConP4=undefined;
         //scope.fdatos.PotConP5=undefined;
         //scope.fdatos.PotConP6=undefined;
         for (var i = 0; i < scope.List_TarEle.length; i++) {
             
             if (scope.List_TarEle[i].CodTarEle == CodTarEle) {
                 scope.CanPerEle = scope.List_TarEle[i].CanPerTar;
                 console.log(scope.CanPerEle);
                 if(scope.CanPerEle==0||scope.CanPerEle==null)
                 {
                    scope.toast('error','Esta Tárifa no tiene cantidad de periodos asignada','Error en Periodos');
                    scope.CanPerEle=6;
                 }
             }
         }

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
     if (scope.fdatos.tipo == "nueva") {
         scope.buscar_datos_clientes();
         scope.disabled_button = false;
     }
     if (scope.fdatos.tipo == "ver") {
         scope.BuscarXidCodPro();
         scope.disabled_button = false;
     }
     if (scope.fdatos.tipo == "editar") {
         scope.BuscarXidCodPro();
         scope.disabled_button = false;
     }
     if (scope.fdatos.tipo == "renovar") {
         scope.BuscarXidCodProComReno();
         scope.disabled_button = false;
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
     ////////////////////////////////////////////////// PARA LOS CONTACTOS END ////////////////////////////////////////////////////////    
 }