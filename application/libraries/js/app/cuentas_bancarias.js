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
     scope.topcionesBan = [{ id: 3, nombre: 'EDITAR' }, { id: 1, nombre: 'ACTIVAR' }, { id: 2, nombre: 'BLOQUEAR' }];
     scope.Tclientes = [];
     scope.tListBanc = [];
     scope.CodEur = "ES";
     scope.numIBanValidado = false;
     ServiceMaster.getAll().then(function(dato) {
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
     }).catch(function(err) { console.log(err); });
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
                 Swal.fire({ title: 'Cuentas Bancarias', text: "No se Encontraron Cuentas Bancarias Registradas.", type: "error", confirmButtonColor: "#188ae2" });
             }
         }, function(error) {
             $("#cuentas_bancarias").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }
     $scope.SubmitFormFiltrosBancos = function(event) {
         console.log(scope.tmodal_bancos);
         if (scope.tmodal_bancos.tipo_filtro == 1) {
             if (!scope.tmodal_bancos.CodBan > 0) {
                 Swal.fire({ title: "Banco", text: "Debe Seleccionar Un Banco de la Lista.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             //scope.Tabla_Contacto=result.data;
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
                 Swal.fire({ title: "Clientes", text: "Debe Seleccionar Un Cliente de la Lista.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             //scope.Tabla_Contacto=result.data;
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

     }
     scope.validar_OpcBan = function(index, opcion, datos) {
         scope.bloquear_cueban = {};
         scope.bloquear_cueban.CodCli = datos.CodCli;
         scope.bloquear_cueban.CodCueBan = datos.CodCueBan;
         scope.bloquear_cueban.EstCue = opcion;
         scope.opciones_Ban[index] = undefined;
         if (opcion == 1) {
             if (datos.EstCue == 1) {
                 Swal.fire({ title: 'Cuentas Bancarias', text: "Esta Cuenta Bancaria Ya Se Encuentra Activa.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             scope.update_status_CueBan(scope.bloquear_cueban);
         }
         if (opcion == 2) {
             if (datos.EstCue == 2) {
                 Swal.fire({ title: 'Cuentas Bancarias', text: "Esta Cuenta Bancaria Ya Se Encuentra Bloqueada.", type: "error", confirmButtonColor: "#188ae2" });
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
                     Swal.fire({ title: 'Activando', text: "Cuenta Bancaria Activada Correctamente.", type: "success", confirmButtonColor: "#188ae2" });
                 }
                 if (total_datos.EstCue == 2) {
                     Swal.fire({ title: 'Bloqueando', text: "Cuenta Bancaria Bloqueada Correctamente.", type: "success", confirmButtonColor: "#188ae2" });
                 }
                 scope.cargar_cuentas_bancarias();
             } else {
                 Swal.fire({ title: "Error.", text: "Error al intentar actualizar estatus de cuenta.", type: "error", confirmButtonColor: "#188ae2" });
                 scope.cargar_cuentas_bancarias();
             }

         }, function(error) {
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
         if (scope.IBAN1.length == 4 && scope.IBAN2.length == 4 && scope.IBAN3.length == 4 && scope.IBAN4.length == 4 && scope.IBAN5.length == 4) {
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
                 Swal.fire({ title: "IBAN.", text: "El IBAN que introdujo es válido, presione el botón Continuar", type: "success", confirmButtonColor: "#188ae2" });
                 scope.numIBanValidado = true;
             } else {
                 Swal.fire({ title: "Error.", text: "El IBAN que introdujo es incorrecto, verifique e intente de nuevo", type: "error", confirmButtonColor: "#188ae2" });
                 scope.numIBanValidado = false;
             }
         } else {
             scope.numIBanValidado = false;
         }
     }
     $scope.submitFormRegistroCuentaBanca = function(event) {
         scope.tgribBancos.NumIBan = scope.CodEur + '' + scope.IBAN1 + '' + scope.IBAN2 + '' + scope.IBAN3 + '' + scope.IBAN4 + '' + scope.IBAN5;
         var url = base_urlHome() + "api/Clientes/Comprobar_Cuenta_Bancaria/";
         $http.post(url, scope.tgribBancos).then(function(result) {
             if (result.data == true) {
                 Swal.fire({ title: "Error.", text: "La Cuenta Bancaria ya se encuentra registrada", type: "error", confirmButtonColor: "#188ae2" });
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
                                 Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                                 scope.numIBanValidado = false;
                                 scope.cargar_cuentas_bancarias();
                             } else {
                                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                                 Swal.fire({ title: "Error.", text: "Hubo un error al ejecutar esta acción por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                                 scope.numIBanValidado = false;
                                 scope.cargar_cuentas_bancarias();
                             }
                         }, function(error) {
                             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                             scope.numIBanValidado = false;

                             if (error.status == 404 && error.statusText == "Not Found") {
                                 Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                             }
                             if (error.status == 401 && error.statusText == "Unauthorized") {
                                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                             }
                             if (error.status == 403 && error.statusText == "Forbidden") {
                                 Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                             }
                             if (error.status == 500 && error.statusText == "Internal Server Error") {
                                 Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
             } else {
                 Swal.fire({ title: "Error.", text: "No hay información de la Cuenta Bancaria", type: "error", confirmButtonColor: "#188ae2" });
                 scope.tContacto_data_modal = {};
             }
         }, function(error) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });

     }
     if (scope.nID != undefined) {
         scope.BuscarXIDCCuentaBancaria();
     }
     ////////////////////////////////////////////////// PARA LAS CUENTAS BANCARIAS END ////////////////////////////////////////////////////////
 }