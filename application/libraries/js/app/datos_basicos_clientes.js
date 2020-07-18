 app.controller('Controlador_Datos_Basicos_Clientes', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceAddClientes', 'upload', Controlador])
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceAddClientes, upload) {
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
     ServiceAddClientes.getAll().then(function(dato) {
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
     }).catch(function(err) { console.log(err); });




     ////////////////////////////////////////////////////////////// MODULO CLIENTES DATOS BASICOS START ////////////////////////////////////////////////////////////////////
     scope.BuscarLocalidad=function(metodo,CodPro)
     {
        console.log(metodo);
        console.log(CodPro);
        var url = base_urlHome()+"api/Clientes/BuscarLocalidadAddClientes/metodo/"+metodo+"/CodPro/"+CodPro;
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                if(metodo==1)
                {
                    if (scope.fdatos.distinto_a_social == false) {
                        scope.TLocalidadesfiltradaFisc=result.data;
                        scope.fdatos.CodProFis = scope.fdatos.CodProSoc;                         
                    }
                    //scope.fdatos.CodLocSoc=undefined;
                    scope.TLocalidadesfiltrada=[];
                    scope.TLocalidadesfiltrada=result.data;
                }
                else
                {
                    //scope.fdatos.CodLocFis=undefined;
                    scope.TLocalidadesfiltradaFisc=[];
                    scope.TLocalidadesfiltradaFisc=result.data;
                }
            }
            else
            {
                if(metodo==1)
                {
                    scope.fdatos.CodLocSoc=undefined;
                    scope.TLocalidadesfiltrada=[];
                    scope.toast('error','No se encontraron Localidades asignada a esta provincia.','Error');                    
                }
                else
                {
                    scope.fdatos.CodLocFis=undefined;
                    scope.TLocalidadesfiltradaFisc=[];
                    scope.toast('error','No se encontraron Localidades asignada a esta provincia.','Error');                    
                }

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
                 var text = "¿Seguro que desea cerrar sin registrar el Cliente?";
             } else {
                 var title = 'Actualizando';
                 var text = "¿Seguro que desea cerrar sin actualizar la información del Cliente?";
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
     scope.asignar_LocalidadFis = function() {
         if (scope.fdatos.distinto_a_social == false) {
             scope.fdatos.CodLocFis = scope.fdatos.CodLocSoc;
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
             scope.TLocalidadesfiltradaFisc = scope.TLocalidadesfiltrada;
             //scope.filtrarLocalidadFisc();
         }
     }

     scope.filtrarLocalidad = function()
     {
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
             scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
             return false;
         }
         if (!scope.validar_campos_datos_basicos()) {
             return false;
         }
         if (scope.fdatos.CodCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea modificar la información del Cliente?';
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
             confirmButtonText: "Confirmar"
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
             scope.toast('error','La Fecha de Inicio es requerida','');
             return false;
         } else {
             var FecIniCli = (scope.FecIniCli).split("/");
             if (FecIniCli.length < 3) {
                 scope.toast('error','El formato de Fecha de Inicio correcto es DD/MM/YYYY','');
                 event.preventDefault();
                 return false;
             } else {
                 if (FecIniCli[0].length > 2 || FecIniCli[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCli[1].length > 2 || FecIniCli[1].length < 2) {
                     scope.toast('error','Error en Mes, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCli[2].length < 4 || FecIniCli[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','');
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecIniCli.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     scope.toast('error',"La Fecha de Inicio no puede ser mayor al " + scope.Fecha_Server + " Verifique e intente nuevamente",'');
                     return false;
                 }
                 scope.fdatos.FecIniCli = FecIniCli[2] + "-" + FecIniCli[1] + "-" + FecIniCli[0];
             }
         }
         if (scope.fdatos.RazSocCli == null || scope.fdatos.RazSocCli == undefined || scope.fdatos.RazSocCli == '') {
             scope.toast('error','La Razón Social del Cliente es requerida','');
             return false;
         }
         if (scope.fdatos.NomComCli == null || scope.fdatos.NomComCli == undefined || scope.fdatos.NomComCli == '') {
             scope.toast('error','El Nombre Comercial del Cliente es requerido','');
             return false;
         }
         if (!scope.fdatos.CodTipCli > 0) {
             scope.toast('error','Seleccione un Tipo de Cliente','');
             return false;
         }
         if (!scope.fdatos.CodSecCli > 0) 
         {
            scope.fdatos.CodSecCli=null;             
         }
         else
         {
            scope.fdatos.CodSecCli=scope.fdatos.CodSecCli;
         }

         if (!scope.fdatos.CodTipViaSoc > 0) {
             scope.toast('error','Seleccione un Tipo de Vía para el Domicilio Social','');
             return false;
         }
         if (scope.fdatos.NomViaDomSoc == null || scope.fdatos.NomViaDomSoc == undefined || scope.fdatos.NomViaDomSoc == '') {
             scope.toast('error','El Nombre de la Vía es requerido','');
             return false;
         }
         if (scope.fdatos.NumViaDomSoc == null || scope.fdatos.NumViaDomSoc == undefined || scope.fdatos.NumViaDomSoc == '') {
             scope.toast('error','El Número de la Vía es requerido','');
             return false;
         }
         if (!scope.fdatos.CodProSoc > 0) {
             scope.toast('error','Seleccione una Provincia para el Domicilio Social','');
             return false;
         }
         if (!scope.fdatos.CodLocSoc > 0) {
             scope.toast('error','Seleccione una Localidad para el Domicilio Social','');
             return false;
         }
         if (scope.fdatos.distinto_a_social == true) {
             if (!scope.fdatos.CodTipViaFis > 0) {
                 scope.toast('error','Seleccione un Tipo de Vía para el Domicilio Fiscal','');
                 return false;
             }
             if (scope.fdatos.NomViaDomFis == null || scope.fdatos.NomViaDomFis == undefined || scope.fdatos.NomViaDomFis == '') {
                 scope.toast('error','El Nombre del Domicilio Fiscal del Cliente es obligatorio','');
                 
                 return false;
             }
             if (scope.fdatos.NumViaDomFis == null || scope.fdatos.NumViaDomFis == undefined || scope.fdatos.NumViaDomFis == '') {
                 scope.toast('error','El Número del Domicilio Fiscal del Cliente es requerido','');
                 return false;
             }
             if (!scope.fdatos.CodProFis > 0) {
                 scope.toast('error','Seleccione una Provincia para el Domicilio Fiscal','');
                 return false;
             }
             if (!scope.fdatos.CodLocFis > 0) {
                 scope.toast('error','Seleccione una Localidad para el Domicilio Fiscal','');
                 return false;
             }
         }
         if (scope.fdatos.TelFijCli == null || scope.fdatos.TelFijCli == undefined || scope.fdatos.TelFijCli == '') {
             scope.toast('error','El Número de Teléfono es requerido','');
             return false;
         }
         if (scope.fdatos.EmaCli == null || scope.fdatos.EmaCli == undefined || scope.fdatos.EmaCli == '') {
             scope.toast('error','El Correo Electrónico es requerido','');
             return false;
         }

         if (!scope.fdatos.CodCom > 0) {
             scope.toast('error','Seleccionar un Comercial','');
             return false;
         }
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
         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.guardar = function() {
         
         if (scope.fdatos.CodCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea actualizar la información del Cliente?';
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
                 scope.toast('error','','');
                 //Swal.fire({ title: result.data.message, type: "error", confirmButtonColor: "#188ae2" });
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
                 scope.toast('error','','');
                 //Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                 location.href = "#/Edit_Datos_Basicos_Clientes/" + scope.nID;
                 //scope.buscarXID();				
             } else {
                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                 scope.toast('error','','');
                 //Swal.fire({ title: 'Error', text: 'Ha ocurrido un error, por favor intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });

             }
         }, function(error) {
             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                    scope.BuscarLocalidad(1,result.data.CodProSoc);

                 } else {
                     scope.fdatos.distinto_a_social = true;
                 }


                scope.fdatos.CodLocSoc=result.data.CodLocSoc;
                scope.fdatos.CodLocFis=result.data.CodLocFis;
                 if (result.data.RazSocCli == result.data.NomComCli) {
                     scope.fdatos.misma_razon = false;
                 } else {
                     scope.fdatos.misma_razon = true;
                 }
                 scope.FecIniCli = result.data.FecIniCli;
                 $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCli);

             } else {
                 scope.toast('error','','');
                 //Swal.fire({ title: "Error", text: "No hay información", type: "error", confirmButtonColor: "#188ae2" });
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
     if (scope.nID != undefined) {
         scope.buscarXID();
         /*var promise = $interval(function() {
             scope.filtrarLocalidad();
             //scope.filtrar_zona_postal();
             //scope.filtrarLocalidadFisc();
             //scope.filtrar_zona_postalFis();
         }, 10000);
         $scope.$on('$destroy', function() {
             $interval.cancel(promise);
         });*/
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

 }