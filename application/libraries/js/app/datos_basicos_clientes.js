 app.controller('Controlador_Datos_Basicos_Clientes', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceMaster', 'upload', Controlador])
     .directive('stringToNumber', function() {
         return {
             require: 'ngModel',
             link: function(scope, element, attrs, ngModel) {
                 ngModel.$parsers.push(function(value) {
                     return '' + value;
                 });
                 ngModel.$formatters.push(function(value) {
                     return parseFloat(value);
                 });
             }
         };
     }).directive('uploaderModel', ["$parse", function($parse) {
         return {
             restrict: 'A',
             link: function(scope, iElement, iAttrs) {
                 iElement.on("change", function(e) {
                     $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
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
     scope.nID = $route.current.params.ID;
     scope.validate_info = $route.current.params.INF;
     scope.Nivel = $cookies.get('nivel');
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
     scope.index = 0;
     scope.tProvidencias = [];
     scope.tTipoCliente = [];
     scope.tLocalidades = [];
     scope.tComerciales = [];
     scope.tSectores = [];
     scope.tColaboradores = [];
     scope.tTiposVias = [];
     scope.TtiposInmuebles = [];
     scope.fdatos.misma_razon = false;
     scope.fdatos.distinto_a_social = false;
     console.log($route.current.$$route.originalPath);
     if ($route.current.$$route.originalPath == "/Datos_Basicos_Clientes/") {
         scope.CIF_NEW_CLIENTE = $cookies.get('CIF');
         console.log(scope.CIF_NEW_CLIENTE);
         if (scope.CIF_NEW_CLIENTE != undefined) {
             scope.fdatos.NumCifCli = scope.CIF_NEW_CLIENTE;
         } else {
             location.href = "#/Clientes/";
         }
     }
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES START ////////////////////////////////////////////////////////
     ServiceMaster.getAll().then(function(dato) {
         scope.Fecha_Server = dato.Fecha_Server;
         if ($route.current.$$route.originalPath == "/Datos_Basicos_Clientes/") {
             scope.FecIniCli = dato.Fecha_Server;
         }
         scope.tProvidencias = dato.Provincias;
         scope.tTipoCliente = dato.Tipo_Cliente;
         scope.tComerciales = dato.Comerciales;
         scope.tSectores = dato.Sector_Cliente;
         scope.tColaboradores = dato.Colaborador;
         scope.tTiposVias = dato.Tipo_Vias;
         scope.TtiposInmuebles = dato.Tipo_Inmuebles;
         scope.tListaContactos = dato.Tipo_Contacto;
         scope.tLocalidades = dato.Localidades;
     }).catch(function(err) { console.log(err); });




     ////////////////////////////////////////////////////////////// MODULO CLIENTES DATOS BASICOS START ////////////////////////////////////////////////////////////////////

     scope.misma_razon = function(opcion) {
         if (opcion == true) {
             scope.fdatos.NomComCli = undefined;
         } else {
             scope.fdatos.NomComCli = scope.fdatos.RazSocCli;
         }
     }
     scope.asignar_a_nombre_comercial = function() {
         scope.fdatos.NomComCli = scope.fdatos.RazSocCli;
     }
     scope.regresar = function() {
         if (scope.validate_info == undefined) {
             if (scope.fdatos.CodCli == undefined) {
                 var title = 'Guardando';
                 var text = "¿Seguro que desea cerrar sin grabar la información?";
             } else {
                 var title = 'Actualizando';
                 var text = "¿Seguro que desea cerrar sin actualizar la información?";
             }
             Swal.fire({
                 title: title,
                 text: text,
                 type: "question",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: "OK"
             }).then(function(t) {
                 if (t.value == true) {
                     $cookies.remove('CIF');
                     location.href = "#/Clientes";
                     scope.fdatos = {};
                 } else {
                     console.log('Cancelando ando...');
                 }
             });

         } else {
             $cookies.remove('CIF');
             location.href = "#/Clientes";
             scope.fdatos = {};
         }
     }

     scope.asignar_tipo_via = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.CodTipViaFis = scope.fdatos.CodTipViaSoc;
         }
     }
     scope.asignar_domicilio = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.NomViaDomFis = scope.fdatos.NomViaDomSoc;
         }
     }
     scope.asignar_num_domicilio = function(object) {
         console.log(object);

         if (scope.fdatos.distinto_a_social == false) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([0-9])*$/.test(numero))
                     scope.fdatos.NumViaDomSoc = numero.substring(0, numero.length - 1);
             }
             scope.fdatos.NumViaDomFis = scope.fdatos.NumViaDomSoc;
         }
     }
     scope.asignar_bloq_domicilio = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.BloDomFis = scope.fdatos.BloDomSoc;
         }
     }
     scope.asignar_esc_domicilio = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.EscDomFis = scope.fdatos.EscDomSoc;
         }
     }
     scope.asignar_pla_domicilio = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.PlaDomFis = scope.fdatos.PlaDomSoc;
         }
     }
     scope.asignar_puer_domicilio = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.PueDomFis = scope.fdatos.PueDomSoc;
         }
     }
     scope.asignar_CPLoc = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.CPLocFis = scope.fdatos.CPLocSoc;
         }
     }
     scope.distinto_a_social = function() {
         if (scope.fdatos.distinto_a_social == true) {
             scope.fdatos.CodTipViaFis = undefined;
             scope.fdatos.NomViaDomFis = undefined;
             scope.fdatos.NumViaDomFis = undefined;
             scope.fdatos.BloDomFis = undefined;
             scope.fdatos.EscDomFis = undefined;
             scope.fdatos.PlaDomFis = undefined;
             scope.fdatos.PueDomFis = undefined;
             scope.fdatos.CodProFis = undefined;
             scope.fdatos.CodLocFis = undefined;
             scope.fdatos.CPLocFis = undefined;
             scope.TLocalidadesfiltradaFisc = [];
         } else {
             scope.fdatos.CodTipViaFis = scope.fdatos.CodTipViaSoc;
             scope.fdatos.NomViaDomFis = scope.fdatos.NomViaDomSoc;
             scope.fdatos.NumViaDomFis = scope.fdatos.NumViaDomSoc;
             scope.fdatos.BloDomFis = scope.fdatos.BloDomSoc;
             scope.fdatos.EscDomFis = scope.fdatos.EscDomSoc;
             scope.fdatos.PlaDomFis = scope.fdatos.PlaDomSoc;
             scope.fdatos.PueDomFis = scope.fdatos.PueDomSoc;
             scope.fdatos.CodProFis = scope.fdatos.CodProSoc;
             scope.fdatos.CodLocFis = scope.fdatos.CodLocSoc;
             scope.fdatos.CPLocFis = scope.fdatos.CPLocSoc;
             scope.TLocalidadesfiltradaFisc = [];
             scope.filtrarLocalidadFisc();
         }
     }

     scope.filtrarLocalidad = function() {
         scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, { CodPro: scope.fdatos.CodProSoc }, true);
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.CodProFis = scope.fdatos.CodProSoc;
             scope.filtrarLocalidadFisc();
         }
         if ($route.current.$$route.originalPath == "/Edit_Datos_Basicos_Clientes/:ID/:INF" || $route.current.$$route.originalPath == "/Edit_Datos_Basicos_Clientes/:ID") {
             scope.contador = 0;
             scope.contador = scope.contador + 1;
             if (scope.fdatos.distinto_a_social == true) {
                 scope.filtrarLocalidadFisc();
             }
         }
         if (scope.contador == 1) {
             $interval.cancel(promise);
         }
     }
     scope.filtrar_zona_postal = function() {
         scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, { CodLoc: scope.fdatos.CodLocSoc }, true);
         angular.forEach(scope.CodLocZonaPostal, function(data) {
             scope.fdatos.ZonPosSoc = data.CPLoc;
         });
         if (scope.fdatos.distinto_a_social == false && scope.nID == undefined) {
             scope.fdatos.CodLocFis = scope.fdatos.CodLocSoc;
             scope.filtrar_zona_postalFis();
         }
     }
     scope.filtrarLocalidadFisc = function() {
         scope.TLocalidadesfiltradaFisc = $filter('filter')(scope.tLocalidades, { CodPro: scope.fdatos.CodProFis }, true);
     }
     scope.filtrar_zona_postalFis = function() {
         scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, { CodLoc: scope.fdatos.CodLocFis }, true);
         angular.forEach(scope.CodLocZonaPostal, function(data) {
             scope.fdatos.ZonPosFis = data.CPLoc;
         });
     }
     scope.validar_fecha_blo = function(metodo, object) {
         console.log(object);
         console.log(metodo);
         if (metodo == 1) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.tmodal_data.FechBlo = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 2) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([0-9])*$/.test(numero))
                     scope.fdatos.TelFijCli = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 3) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([0-9])*$/.test(numero))
                     scope.fdatos.NumViaDomFis = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 4) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecIniCli = numero.substring(0, numero.length - 1);
             }
         }


     }

     $scope.submitForm = function(event) {
         console.log(scope.fdatos);
         if (scope.nID > 0 && scope.Nivel == 3) {
             Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.validar_campos_datos_basicos()) {
             return false;
         }
         if (scope.fdatos.CodCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea modificar los datos del Cliente?';
             var response = "Cliente actualizado de forma correcta";
         }
         if (scope.fdatos.CodCli == undefined) {
             var title = 'Guardando';
             var text = '¿Seguro que desea registrar el Cliente?';
             var response = "Cliente creado de forma correcta";
         }
         Swal.fire({
             title: title,
             text: text,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "SI"
         }).then(function(t) {
             if (t.value == true) {
                 scope.guardar();
             } else {
                 event.preventDefault();
             }
         });
     };
     scope.validar_campos_datos_basicos = function() {
         resultado = true;
         var FecIniCli1 = document.getElementById("FecIniCli").value;
         scope.FecIniCli = FecIniCli1;
         if (scope.FecIniCli == null || scope.FecIniCli == undefined || scope.FecIniCli == '') {
             Swal.fire({ title: "La Fecha de Inicio es requerida", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         } else {
             var FecIniCli = (scope.FecIniCli).split("/");
             if (FecIniCli.length < 3) {
                 Swal.fire({ text: "El Formato de Fecha de Inicio debe Ser EJ: DD/MM/YYYY.", type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
             } else {
                 if (FecIniCli[0].length > 2 || FecIniCli[0].length < 2) {
                     Swal.fire({ text: "Por Favor Corrija el Formato del dia en la Fecha de Inicio deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCli[1].length > 2 || FecIniCli[1].length < 2) {
                     Swal.fire({ text: "Por Favor Corrija el Formato del mes de la Fecha de Inicio deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCli[2].length < 4 || FecIniCli[2].length > 4) {
                     Swal.fire({ text: "Por Favor Corrija el Formato del ano en la Fecha de Inicio Ya que deben ser 4 números solamente. EJ: 1999", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecIniCli.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     Swal.fire({ text: "La Fecha de Inicio no puede ser mayor al " + scope.Fecha_Server + " Por Favor Verifique he intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 scope.fdatos.FecIniCli = FecIniCli[2] + "-" + FecIniCli[1] + "-" + FecIniCli[0];
             }
         }
         if (scope.fdatos.RazSocCli == null || scope.fdatos.RazSocCli == undefined || scope.fdatos.RazSocCli == '') {
             Swal.fire({ title: "La Razón Social del Cliente es obligatoria", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.NomComCli == null || scope.fdatos.NomComCli == undefined || scope.fdatos.NomComCli == '') {
             Swal.fire({ title: "El Nombre Comercial del Cliente es requerido", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodTipCli > 0) {
             Swal.fire({ title: "Seleccione un Tipo de Cliente", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodSecCli > 0) {
             Swal.fire({ title: "Seleccione un Sector", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodTipViaSoc > 0) {
             Swal.fire({ title: "Seleccione un Tipo de Vía para el Domicilio Social", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.NomViaDomSoc == null || scope.fdatos.NomViaDomSoc == undefined || scope.fdatos.NomViaDomSoc == '') {
             Swal.fire({ title: "El Nombre de la Vía es requerido", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.NumViaDomSoc == null || scope.fdatos.NumViaDomSoc == undefined || scope.fdatos.NumViaDomSoc == '') {
             Swal.fire({ title: "El Número de la Vía es requerido", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodProSoc > 0) {
             Swal.fire({ title: "Seleccione una Provincia para el Domicilio Social", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodLocSoc > 0) {
             Swal.fire({ title: "Seleccione una Localidad para el Domicilio Social", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.distinto_a_social == true) {
             if (!scope.fdatos.CodTipViaFis > 0) {
                 Swal.fire({ title: "Seleccione un Tipo de Vía para el Domicilio Fiscal", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.NomViaDomFis == null || scope.fdatos.NomViaDomFis == undefined || scope.fdatos.NomViaDomFis == '') {
                 Swal.fire({ title: "El Nombre del Domicilio Fiscal del Clientees ocligatorio", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.NumViaDomFis == null || scope.fdatos.NumViaDomFis == undefined || scope.fdatos.NumViaDomFis == '') {
                 Swal.fire({ title: "El Número del Domicilio Fiscal del Cliente es requerido", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (!scope.fdatos.CodProFis > 0) {
                 Swal.fire({ title: "Seleccione una Provincia para el Domicilio Fiscal", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (!scope.fdatos.CodLocFis > 0) {
                 Swal.fire({ title: "Seleccione una Localidad para el Domicilio Fiscal", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
         }
         if (scope.fdatos.TelFijCli == null || scope.fdatos.TelFijCli == undefined || scope.fdatos.TelFijCli == '') {
             Swal.fire({ title: "El Número de Teléfono es requerido", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.EmaCli == null || scope.fdatos.EmaCli == undefined || scope.fdatos.EmaCli == '') {
             Swal.fire({ title: "El Correo Electrónico es requerido", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }

         if (!scope.fdatos.CodCom > 0) {
             Swal.fire({ title: "Seleccionar un Comercial", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.guardar = function() {

         if (scope.fdatos.BloDomSoc == undefined || scope.fdatos.BloDomSoc == null || scope.fdatos.BloDomSoc == '') {
             scope.fdatos.BloDomSoc = null;
         } else {
             scope.fdatos.BloDomSoc = scope.fdatos.BloDomSoc;
         }
         if (scope.fdatos.EscDomSoc == undefined || scope.fdatos.EscDomSoc == null || scope.fdatos.EscDomSoc == '') {
             scope.fdatos.EscDomSoc = null;
         } else {
             scope.fdatos.EscDomSoc = scope.fdatos.EscDomSoc;
         }
         if (scope.fdatos.PlaDomSoc == undefined || scope.fdatos.PlaDomSoc == null || scope.fdatos.PlaDomSoc == '') {
             scope.fdatos.PlaDomSoc = null;
         } else {
             scope.fdatos.PlaDomSoc = scope.fdatos.PlaDomSoc;
         }
         if (scope.fdatos.PueDomSoc == undefined || scope.fdatos.PueDomSoc == null || scope.fdatos.PueDomSoc == '') {
             scope.fdatos.PueDomSoc = null;
         } else {
             scope.fdatos.PueDomSoc = scope.fdatos.PueDomSoc;
         }
         if (scope.fdatos.BloDomFis == undefined || scope.fdatos.BloDomFis == null || scope.fdatos.BloDomFis == '') {
             scope.fdatos.BloDomFis = null;
         } else {
             scope.fdatos.BloDomFis = scope.fdatos.BloDomFis;
         }
         if (scope.fdatos.EscDomFis == undefined || scope.fdatos.EscDomFis == null || scope.fdatos.EscDomFis == '') {
             scope.fdatos.EscDomFis = null;
         } else {
             scope.fdatos.EscDomFis = scope.fdatos.EscDomFis;
         }
         if (scope.fdatos.PlaDomFis == undefined || scope.fdatos.PlaDomFis == null || scope.fdatos.PlaDomFis == '') {
             scope.fdatos.PlaDomFis = null;
         } else {
             scope.fdatos.PlaDomFis = scope.fdatos.PlaDomFis;
         }
         if (scope.fdatos.PueDomFis == undefined || scope.fdatos.PueDomFis == null || scope.fdatos.PueDomFis == '') {
             scope.fdatos.PueDomFis = null;
         } else {
             scope.fdatos.PueDomFis = scope.fdatos.PueDomFis;
         }
         if (scope.fdatos.WebCli == undefined || scope.fdatos.WebCli == null || scope.fdatos.WebCli == '') {
             scope.fdatos.WebCli = null;
         } else {
             scope.fdatos.WebCli = scope.fdatos.WebCli;
         }
         if (scope.fdatos.ObsCli == undefined || scope.fdatos.ObsCli == null || scope.fdatos.ObsCli == '') {
             scope.fdatos.ObsCli = null;
         } else {
             scope.fdatos.ObsCli = scope.fdatos.ObsCli;
         }
         if (scope.fdatos.CodCol == undefined || scope.fdatos.CodCol == null || scope.fdatos.CodCol == '') {
             scope.fdatos.CodCol = null;
         } else {
             scope.fdatos.CodCol = scope.fdatos.CodCol;
         }
         if (scope.fdatos.CPLocSoc == undefined || scope.fdatos.CPLocSoc == null || scope.fdatos.CPLocSoc == '') {
             scope.fdatos.CPLocSoc = null;
         } else {
             scope.fdatos.CPLocSoc = scope.fdatos.CPLocSoc;
         }
         if (scope.fdatos.CPLocFis == undefined || scope.fdatos.CPLocFis == null || scope.fdatos.CPLocFis == '') {
             scope.fdatos.CPLocFis = null;
         } else {
             scope.fdatos.CPLocFis = scope.fdatos.CPLocFis;
         }
         if (scope.fdatos.CodCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea actualizar el Cliente?';
             var response = "El Cliente ha sido modificado de forma correcta";
         }
         if (scope.fdatos.CodCli == undefined) {
             var title = 'Guardando';
             var text = '¿Seguro que desea crear el Cliente?';
             var response = "El Cliente ha sido registrado de forma correcta";
         }
         $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Clientes/crear_clientes/";
         $http.post(url, scope.fdatos).then(function(result) {
             console.log(result);
             $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
             if (result.data.status == false && result.data.response == false) {
                 Swal.fire({ title: result.data.message, type: "error", confirmButtonColor: "#188ae2" });
                 $cookies.remove('CIF');
                 scope.validate_cif = true;
                 document.getElementById("NumCifCliRe").removeAttribute("readonly");
                 return false;
             }
             scope.nID = result.data.CodCli;
             if (scope.nID > 0) {
                 if (scope.CIF_NEW_CLIENTE != undefined) {
                     $cookies.remove('CIF');
                     document.getElementById("NumCifCliRe").setAttribute("readonly", "readonly");
                 }
                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                 Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                 location.href = "#/Edit_Datos_Basicos_Clientes/" + scope.nID;
                 //scope.buscarXID();				
             } else {
                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                 Swal.fire({ title: 'Error', text: 'Ha ocurrido un error, por favor intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });

             }
         }, function(error) {
             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }
     scope.validar_email = function() {
         document.getElementById('EmaCli').addEventListener('input', function() {
             campo = event.target;
             valido = document.getElementById('emailOK');
             emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
             //Se muestra un texto a modo de ejemplo, luego va a ser un icono
             if (emailRegex.test(campo.value)) {
                 valido.innerText = "";
                 scope.disabled_button_by_email = false;
             } else {
                 valido.innerText = "Formato de Email incorrecto";
                 scope.disabled_button_by_email = true;
             }
         });
     }
     scope.buscarXID = function() {
         $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/buscar_xID/huser/" + scope.nID;
         $http.get(url).then(function(result) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 scope.fdatos = result.data;
                 scope.FecIniCli = undefined;
                 if (result.data.CodLocSoc == result.data.CodLocFis) {
                     scope.fdatos.distinto_a_social = false;
                 } else {
                     scope.fdatos.distinto_a_social = true;
                 }
                 if (result.data.RazSocCli == result.data.NomComCli) {
                     scope.fdatos.misma_razon = false;
                 } else {
                     scope.fdatos.misma_razon = true;
                 }
                 scope.FecIniCli = result.data.FecIniCli;
                 $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCli);

             } else {
                 Swal.fire({ title: "Error", text: "No existe información", type: "error", confirmButtonColor: "#188ae2" });
                 $interval.cancel(promise);
                 /*scope.fdatos={};
                 scope.FecIniCli=fecha;
                 $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}).datepicker("setDate", scope.FecIniCli);*/
                 location.href = "#/Clientes";
                 /*$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
                 bootbox.alert({
                 message: "Hubo un error al intentar cargar los datos.",
                 size: 'middle'});*/
             }
         }, function(error) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }
     if (scope.nID != undefined) {
         scope.buscarXID();
         var promise = $interval(function()
         {
             scope.filtrarLocalidad();
                 //scope.filtrar_zona_postal();
                 //scope.filtrarLocalidadFisc();
                 //scope.filtrar_zona_postalFis();
         }, 10000);
         $scope.$on('$destroy', function() {
             $interval.cancel(promise);
         });
     }

 }