 app.controller('Controlador_Cuentas_Bancarias', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceMaster', 'upload', Controlador])
     .directive('uploaderModel', ["$parse", function($parse) {
         return {
             restrict: 'A',
             link: function(scope, iElement, iAttrs) {
                 iElement.on("change", function(e) {
                     $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
                 });
             }
         };
     }])
     .directive('uploadanexoModel', ["$parse", function($parse) {
         return {
             restrict: 'A',
             link: function(scope, iElement, iAttrs) {
                 iElement.on("change", function(e) {
                     $parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]);
                     //console.log($parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]));
                 });
             }
         };
     }])
     .service('upload', ["$http", "$q", function($http, $q) {
         this.uploadFile = function(file, name) {
             var deferred = $q.defer();
             var formData = new FormData();
             //formData.append("name", name);
             formData.append("file", file);
             return $http.post("server.php", formData, {
                     headers: {
                         "Content-type": undefined
                     },
                     transformRequest: angular.identity
                 })
                 .success(function(res) {
                     deferred.resolve(res);
                 })
                 .error(function(msg, code) {
                     deferred.reject(msg);
                 })
             return deferred.promise;
         }
     }])

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceMaster, upload) {
     //declaramos una variable llamada scope donde tendremos a vm
     /*inyectamos un controlador para acceder a sus variables y metodos*/
     //$controller('Controlador_Clientes as vmAE',{$scope:$scope});
     //var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
     //$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
     //var testCtrl1ViewModel = $controller('Controlador_Clientes');
     //testCtrl1ViewModel.cargar_lista_clientes();
     var scope = this;
     scope.fdatos = {};
     scope.tContacto_data_modal = {};
     scope.nID = $route.current.params.ID;
     scope.no_editable = $route.current.params.INF;
     scope.Nivel = $cookies.get('nivel');
     //scope.CIF_Contacto = $cookies.get('CIF_Contacto');
     //const $archivosanexos = document.querySelector("#file_anexo");
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
     scope.tCuentaBan = [];
     scope.tCuentaBanBack = [];
     ////////////////////////////////////////////////// PARA LAS CUENTAS BANCARIAS START ////////////////////////////////////////////////////////
     console.log($route.current.$$route.originalPath);
     ///////////////////////////// CUENTAS BANCARIAS CLIENTES START ///////////////////////////	
     scope.agregar_cuentas = true;
     scope.CodCli = true;
     scope.NumCifCli = true;
     scope.RazSocCli = true;
     scope.CodBan1 = true;
     scope.NumIBan1 = true;
     scope.EstCue = true;
     scope.ActBan1 = true;
     scope.ruta_reportes_pdf_Banco = 0;
     scope.ruta_reportes_excel_Banco = 0;
     scope.tgribBancos = {};
     scope.numIBanValidado = false;
     scope.topcionesBan = [{ id: 3, nombre: 'EDITAR' }, { id: 1, nombre: 'ACTIVAR' }, { id: 2, nombre: 'SUSPENDER' }];
     scope.Tclientes = [];
     scope.tListBanc = [];
     scope.CodEur = "ES";
     scope.numIBanValidado = false;
     
     /*ServiceMaster.getAll().then(function(dato) {
         scope.tListBanc = dato.Bancos;
         scope.fecha_server = dato.Fecha_Server;
         scope.Tclientes = dato.Clientes;

         $scope.predicate3 = 'id';
         $scope.reverse3 = true;
         $scope.currentPage3 = 1;
         $scope.order3 = function(predicate3) {
             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
             $scope.predicate3 = predicate3;
         };
         scope.tCuentaBan = dato.Cuentas_Bancarias;
         scope.tCuentaBanBack = dato.Cuentas_Bancarias;
         $scope.totalItems3 = scope.tCuentaBan.length;
         $scope.numPerPage3 = 50;
         $scope.paginate3 = function(value3) {
             var begin3, end3, index3;
             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
             end3 = begin3 + $scope.numPerPage3;
             index3 = scope.tCuentaBan.indexOf(value3);
             return (begin3 <= index3 && index3 < end3);
         };
         if (scope.tCuentaBan == false) {
             scope.tCuentaBan = [];
             scope.tCuentaBanBack = [];
         }
     }).catch(function(err) { console.log(err); });*/
     ///////////////////////////// CUENTAS BANCARIAS CLIENTES END ///////////////////////////
     scope.cargar_cuentas_bancarias = function() {
         $("#cuentas_bancarias").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Clientes/get_cuentas_bancarias_cliente";
         $http.get(url).then(function(result) {
             $("#cuentas_bancarias").removeClass("loader loader-default  is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate3 = 'id';
                 $scope.reverse3 = true;
                 $scope.currentPage3 = 1;
                 $scope.order3 = function(predicate3) {
                     $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                     $scope.predicate3 = predicate3;
                 };
                 scope.tCuentaBan = result.data;
                 scope.tCuentaBanBack = result.data;
                 $scope.totalItems3 = scope.tCuentaBan.length;
                 $scope.numPerPage3 = 50;
                 $scope.paginate3 = function(value3) {
                     var begin3, end3, index3;
                     begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                     end3 = begin3 + $scope.numPerPage3;
                     index3 = scope.tCuentaBan.indexOf(value3);
                     return (begin3 <= index3 && index3 < end3);
                 };
             } else {
                 scope.toast('error','No existen Cuentas Bancarias Registradas.','Cuentas Bancarias');
                 scope.tCuentaBan = [];
                 scope.tCuentaBanBack = [];
             }
         }, function(error) {
             $("#cuentas_bancarias").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     $scope.SubmitFormFiltrosBancos = function(event) {
         console.log(scope.tmodal_bancos);
         if (scope.tmodal_bancos.tipo_filtro == 1) {
             if (!scope.tmodal_bancos.CodBan > 0) {
                 scope.toast('error','Debe Seleccionar Un Banco de la Lista.','Banco');
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             //scope.tCuentaBan=result.data;
             scope.tCuentaBan = $filter('filter')(scope.tCuentaBanBack, { CodBan: scope.tmodal_bancos.CodBan }, true);
             $scope.totalItems3 = scope.tCuentaBan.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.tCuentaBan.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             }
             scope.ruta_reportes_pdf_Banco = scope.tmodal_bancos.tipo_filtro + "/" + scope.tmodal_bancos.CodBan;
             scope.ruta_reportes_excel_Banco = scope.tmodal_bancos.tipo_filtro + "/" + scope.tmodal_bancos.CodBan;
         }
         if (scope.tmodal_bancos.tipo_filtro == 2) {
             if (!scope.tmodal_bancos.CodCli > 0) {
                 scope.toast('error','Debe Seleccionar Un Cliente de la Lista.','Clientes');
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             //scope.tCuentaBan=result.data;
             scope.tCuentaBan = $filter('filter')(scope.tCuentaBanBack, { CodCli: scope.tmodal_bancos.CodCli }, true);
             $scope.totalItems3 = scope.tCuentaBan.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.tCuentaBan.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             }
             scope.ruta_reportes_pdf_Banco = scope.tmodal_bancos.tipo_filtro + "/" + scope.tmodal_bancos.CodCli;
             scope.ruta_reportes_excel_Banco = scope.tmodal_bancos.tipo_filtro + "/" + scope.tmodal_bancos.CodCli;
         }

     };
     scope.regresar_filtro_bancos = function() {
         $scope.predicate3 = 'id';
         $scope.reverse3 = true;
         $scope.currentPage3 = 1;
         $scope.order3 = function(predicate3) {
             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
             $scope.predicate3 = predicate3;
         };
         scope.tCuentaBan = scope.tCuentaBanBack;
         $scope.totalItems3 = scope.tCuentaBan.length;
         $scope.numPerPage3 = 50;
         $scope.paginate3 = function(value3) {
             var begin3, end3, index3;
             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
             end3 = begin3 + $scope.numPerPage3;
             index3 = scope.tCuentaBan.indexOf(value3);
             return (begin3 <= index3 && index3 < end3);
         }
         scope.tmodal_bancos = {};
         scope.ruta_reportes_pdf_Banco = 0;
         scope.ruta_reportes_excel_Banco = 0;
         scope.NumCifCliSearch=undefined;

     }
     scope.validar_OpcBan = function(index, opcion, datos) {
         scope.bloquear_cueban = {};
         scope.bloquear_cueban.CodCli = datos.CodCli;
         scope.bloquear_cueban.CodCueBan = datos.CodCueBan;
         scope.bloquear_cueban.EstCue = opcion;
         scope.opciones_Ban[index] = undefined;
         if (opcion == 1) {
             if (datos.EstCue == 1) {
                 scope.toast('error','Esta Cuenta Bancaria Ya Se Encuentra Activa.','Cuentas Bancarias');
                 return false;
             }
             scope.update_status_CueBan(scope.bloquear_cueban);
         }
         if (opcion == 2) {
             if (datos.EstCue == 2) {
                 scope.toast('error','Esta Cuenta Bancaria Ya Se Encuentra Suspendida.','Cuentas Bancarias');
                 return false;
             }
             scope.update_status_CueBan(scope.bloquear_cueban);
         }
         if (opcion == 3) {
             console.log(datos);
             location.href = "#/Edit_Cuenta_Bancaria/" + datos.CodCueBan;
         }

     }
     scope.update_status_CueBan = function(total_datos) {
         var url = base_urlHome() + "api/Clientes/update_status_CueBan/";
         $http.post(url, total_datos).then(function(result) {
             if (result.data != false) {
                 if (total_datos.EstCue == 1) {
                     scope.toast('success','Cuenta Bancaria Activada de forma correcta','Activando');
                 }
                 if (total_datos.EstCue == 2) {
                     scope.toast('success','Cuenta Bancaria suspendida de forma correcta','Suspendida');
                 }
                 scope.cargar_cuentas_bancarias();
             } else {
                 scope.toast('error','Error al intentar actualizar estatus de cuenta.','Error');
                 scope.cargar_cuentas_bancarias();
             }

         }, function(error) {
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
     scope.validarsinuermoIBAN = function(IBAN, object) {
         
         if (object != undefined && IBAN == 1) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                scope.IBAN1 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 2) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN2 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 3) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN3 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 4) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN4 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 5) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN5 = numero.substring(0, numero.length - 1);
         }
         
         if (scope.IBAN1.length == 4 && scope.IBAN2.length == 4 && scope.IBAN3.length == 4 && scope.IBAN4.length == 4 && scope.IBAN5.length == 4) 
         {             
            scope.dig_control = scope.CodEur.substr(2, 4);
            scope.cod_pais = "1428";
            scope.tira_cuenta = scope.IBAN1 + scope.IBAN2 + scope.IBAN3 + scope.IBAN4 + scope.IBAN5;
            scope.tira_completa = scope.tira_cuenta + scope.cod_pais + scope.dig_control;
            scope.TIR_RES1 = scope.tira_completa.substr(0, 8);
            scope.VAL_TIR_RES1 = parseInt(scope.TIR_RES1);
            scope.VAL_RES_TIR_RES1 = scope.VAL_TIR_RES1 - (97 * parseInt(scope.VAL_TIR_RES1 / 97));
            var x = scope.VAL_RES_TIR_RES1,
                toString = x.toString(),
                toConcat = x + "";
            scope.CAR_RES_TIR_RES1 = toConcat;
            scope.TIR_RES2 = scope.CAR_RES_TIR_RES1 + scope.tira_completa.substr(8, 8);
            scope.VAL_TIR_RES2 = parseInt(scope.TIR_RES2);
            scope.VAL_RES_TIR_RES2 = scope.VAL_TIR_RES2 - (97 * parseInt(scope.VAL_TIR_RES2 / 97));
            scope.CAR_RES_TIR_RES2 = "0" + scope.VAL_RES_TIR_RES2;
            scope.TIR_RES3 = scope.CAR_RES_TIR_RES2 + scope.tira_completa.substr(16, 6);
            scope.VAL_TIR_RES3 = parseInt(scope.TIR_RES3);
            scope.VAL_RES_TIR_RES3 = scope.VAL_TIR_RES3 - (97 * parseInt(scope.VAL_TIR_RES3 / 97));
            var x1 = scope.VAL_RES_TIR_RES3,
                toString1 = x1.toString(),
                toConcat1 = x1 + "";
            scope.CAR_RES_TIR_RES3 = toConcat1;
            scope.TIR_RES4 = scope.CAR_RES_TIR_RES3 + scope.tira_completa.substr(22, 4);
            scope.VAL_TIR_RES4 = parseInt(scope.TIR_RES4);
            scope.VAL_RES_TIR_RES2 = scope.VAL_TIR_RES4 - (97 * parseInt(scope.VAL_TIR_RES4 / 97));
             
             console.log(scope.tira_cuenta);
             console.log(scope.dig_control);
             console.log(scope.cod_pais);
             console.log(scope.tira_completa);
             console.log(scope.TIR_RES1);
             console.log(scope.VAL_TIR_RES1);
             console.log(scope.VAL_RES_TIR_RES1);
             console.log(scope.CAR_RES_TIR_RES1);
             console.log(scope.TIR_RES2);
             console.log(scope.VAL_TIR_RES2);
             console.log(scope.VAL_RES_TIR_RES2);
             console.log(scope.CAR_RES_TIR_RES2);
             console.log(scope.TIR_RES3);
             console.log(scope.VAL_TIR_RES3);
             console.log(scope.VAL_RES_TIR_RES3);
             console.log(scope.CAR_RES_TIR_RES3);
             console.log(scope.TIR_RES4);
             console.log(scope.VAL_TIR_RES4);
             console.log(scope.VAL_RES_TIR_RES2);
             if (scope.VAL_RES_TIR_RES2 == 1) {
                 scope.toast('success','El IBAN que introdujo es correcto','IBAN');
                 scope.numIBanValidado = true;
             } else {
                 scope.toast('error','El IBAN que introdujo es incorrecto, verifique e intente de nuevo','Error');
                 scope.numIBanValidado = false;
             }
         } else {
             scope.numIBanValidado = false;
         }
     }
     $scope.submitFormRegistroCuentaBanca = function(event) {
         scope.tgribBancos.CodBan=null;
         scope.tgribBancos.NumIBan = scope.CodEur + '' + scope.IBAN1 + '' + scope.IBAN2 + '' + scope.IBAN3 + '' + scope.IBAN4 + '' + scope.IBAN5;
         var url = base_urlHome() + "api/Clientes/Comprobar_Cuenta_Bancaria/";
         $http.post(url, scope.tgribBancos).then(function(result) {
             if (result.data == true) {
                 scope.toast('error','La Cuenta Bancaria ya se encuentra registrada','Error');
                 scope.numIBanValidado = false;
                 return false;
             } else {
                 if (scope.tgribBancos.CodCueBan > 0) {
                     var title = 'Actualizando';
                     var text = '¿Seguro que desea modificar la información de la Cuenta Bancaria?';
                     var response = "Cuenta Bancaria actualizada de forma correcta";
                 }
                 if (scope.tgribBancos.CodCueBan == undefined) {
                     var title = 'Guardando';
                     var text = '¿Seguro que desea registrar la Cuenta Bancaria?';
                     var response = "Cuenta Bancaria creada de forma correcta";
                 }
                 Swal.fire({
                     title: title,
                     text: text,
                     type: "question",
                     showCancelButton: !0,
                     confirmButtonColor: "#31ce77",
                     cancelButtonColor: "#f34943",
                     confirmButtonText: "Confirmar"
                 }).then(function(t) {
                     if (t.value == true) {
                         
                         $("#" + title).removeClass("loader loader-default").addClass("loader loader-default  is-active");
                         var url = base_urlHome() + "api/Clientes/crear_cuenta_bancaria/";
                         $http.post(url, scope.tgribBancos).then(function(result) {
                             scope.tgribBancos = result.data;
                             if (result.data != false) {
                                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                                 scope.toast('success',response,title);
                                 scope.numIBanValidado = false;
                                 scope.cargar_cuentas_bancarias();
                             } else {
                                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                                 scope.toast('error','Hubo un error al ejecutar esta acción por favor intente nuevamente.','Error');
                                 scope.numIBanValidado = false;
                                 scope.cargar_cuentas_bancarias();
                             }
                         }, function(error) {
                             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                             scope.numIBanValidado = false;

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
                         event.preventDefault();
                         scope.numIBanValidado = false;
                         scope.cargar_cuentas_bancarias();
                         console.log('Cancelando ando...');
                     }
                 });
             } //end else////
         }, function(error) {
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
     };
     scope.regresar_cuenta_bancaria = function() {

         if (scope.tgribBancos.CodCueBan == undefined) {
             var title = "Guardando";
             var text = "¿Seguro que desea cerrar sin grabar la Cuenta Bancaria?";

         }
         if (scope.tgribBancos.CodCueBan > 0) {
             var title = "Actualizando";
             var text = "¿Seguro que desea cerrar sin actualizar la información de la Cuenta Bancaria?";
         }
         Swal.fire({
             title: title,
             text: text,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "Confirmar"
         }).then(function(t) {
             if (t.value == true) {
                 location.href = "#/Cuentas_Bancarias";
             } else {
                 console.log('Cancelando ando...');
             }
         });

     }
     scope.BuscarXIDCCuentaBancaria = function() {
         $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/BuscarXIDCuenta_Data/CodCueBan/" + scope.nID;
         $http.get(url).then(function(result) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 scope.tgribBancos.CodCli = result.data.CodCli;
                 scope.tgribBancos.CodBan = result.data.CodBan;
                 scope.tgribBancos.CodCueBan = result.data.CodCueBan;
                 scope.CodEur = result.data.CodEur;
                 scope.IBAN1 = result.data.IBAN1;
                 scope.IBAN2 = result.data.IBAN2;
                 scope.IBAN3 = result.data.IBAN3;
                 scope.IBAN4 = result.data.IBAN4;
                 scope.IBAN5 = result.data.IBAN5;
                 scope.NumCifCliSearch=result.data.NumCifCli;
                 scope.RealizarFiltro(1);
             } else {
                 scope.toast('error','No hay información de la Cuenta Bancaria','Error');
                 scope.tContacto_data_modal = {};
             }
         }, function(error) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.FetchCuentasBancarias = function() {
         if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.tCuentaBan = scope.tCuentaBanBack;
             $scope.totalItems = scope.tCuentaBan.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.tCuentaBan.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf_Banco = 0;
             scope.ruta_reportes_excel_Banco = 0;
         } else {
             if (scope.filtrar_search.length >= 2) {
                 scope.fdatos.filtrar_search = scope.filtrar_search;
                 var url = base_urlHome() + "api/Clientes/getCuentasBancariasFilter";
                 $http.post(url, scope.fdatos).then(function(result) {
                     console.log(result.data);
                     if (result.data != false) {
                         $scope.predicate4 = 'id';
                         $scope.reverse4 = true;
                         $scope.currentPage4 = 1;
                         $scope.order4 = function(predicate4) {
                             $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
                             $scope.predicate4 = predicate4;
                         };
                         scope.tCuentaBan = result.data;
                         $scope.totalItems4 = scope.tCuentaBan.length;
                         $scope.numPerPage4 = 50;
                         $scope.paginate4 = function(value4) {
                             var begin4, end4, index4;
                             begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
                             end4 = begin4 + $scope.numPerPage4;
                             index4 = scope.tCuentaBan.indexOf(value4);
                             return (begin4 <= index4 && index4 < end4);
                         };
                         scope.ruta_reportes_pdf_Banco = 3 + "/" + scope.filtrar_search;
                         scope.ruta_reportes_excel_Banco = 3 + "/" + scope.filtrar_search;
                     } else {
                        
                            scope.tCuentaBan = [];
                         scope.ruta_reportes_pdf_Banco = 0;
                         scope.ruta_reportes_excel_Banco = 0;
                     }
                 }, function(error) {
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
             {      $scope.predicate4 = 'id';
                         $scope.reverse4 = true;
                         $scope.currentPage4 = 1;
                         $scope.order4 = function(predicate4) {
                             $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
                             $scope.predicate4 = predicate4;
                         };
                         scope.tCuentaBan = scope.tCuentaBanBack;
                         $scope.totalItems4 = scope.tCuentaBan.length;
                         $scope.numPerPage4 = 50;
                         $scope.paginate4 = function(value4) {
                             var begin4, end4, index4;
                             begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
                             end4 = begin4 + $scope.numPerPage4;
                             index4 = scope.tCuentaBan.indexOf(value4);
                             return (begin4 <= index4 && index4 < end4);
                         };
                         scope.ruta_reportes_pdf_Banco = 0;
                         scope.ruta_reportes_excel_Banco = 0;}
                        
         }
     }
     scope.RealizarFiltro=function(metodo)
     {
        if(metodo==1)
        {
            var url = base_urlHome()+"api/Clientes/RealizarConsultaFiltros/metodo/"+10;
            $http.get(url).then(function(result)
            {
                if(result.data!=false)
                {
                    scope.tListBanc=result.data;
                }
                else
                {
                    scope.tListBanc=[];
                   scope.tmodal_bancos.CodBan=undefined;
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
     }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }
    scope.searchboxClicked = function($event) {
        $event.stopPropagation();
    }
     scope.fetchClientes = function(metodo) {

        if(metodo==1 || metodo==2)
        {
            var searchText_len = scope.NumCifCliSearch.trim().length;
            scope.fdatos.filtrar_clientes = scope.NumCifCliSearch;
        }
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/Clientes/getClientesFilter";
                $http.post(url, scope.fdatos).then(function(result) {
                //console.log(result);
                if (result.data != false) {
                    scope.searchResult = result.data;
                } else {
                
                         scope.searchResult = {};
                                         }
                                     },
                                     function(error) {
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
                             scope.searchResult = {};
                         }
        
            
    }  
    scope.setValue = function(index, $event, result,metodo) 
    {
        if(metodo==1)
        {
            scope.NumCifCliSearch = scope.searchResult[index].NumCifCli;
            scope.tmodal_bancos.CodCli= scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation();  
        }
        if(metodo==2)
        {
            scope.NumCifCliSearch = scope.searchResult[index].NumCifCli;
            scope.tgribBancos.CodCli= scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation();
            scope.RealizarFiltro(1);
        }
                            
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
     if (scope.nID != undefined) {
         scope.BuscarXIDCCuentaBancaria();
     }
     else
     {
        scope.cargar_cuentas_bancarias();
     }
     ////////////////////////////////////////////////// PARA LAS CUENTAS BANCARIAS END ////////////////////////////////////////////////////////
 }