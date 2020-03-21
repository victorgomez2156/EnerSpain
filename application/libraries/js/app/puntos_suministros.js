 app.controller('Controlador_Puntos_Suministros', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceMaster', 'upload', Controlador])
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
     scope.nID = $route.current.params.ID;
     scope.validate_info_PunSum = $route.current.params.INF;
     scope.Nivel = $cookies.get('nivel');
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
     ////////////////////////////////////////////////// PARA LOS PUNTOS DE SUMINISTROS START ////////////////////////////////////////////////////////

     ///////////////////////////// PUNTOS DE SUMINISTROS START ///////////////////////////

     scope.NumCifCli = true;
     scope.RazSocCli = true;
     scope.DirPunSum = true;
     scope.CodProPunSum = true;
     scope.CodLocPunSum = true;
     scope.EstPunSumGrid = true;
     scope.ActPunSum = true;
     scope.ruta_reportes_pdf_puntos_suministros = 0;
     scope.ruta_reportes_excel_puntos_suministros = 0;
     scope.topcionesPunSum = [{ id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'VER' }, { id: 4, nombre: 'BLOQUEAR' }, { id: 5, nombre: 'ACTIVAR' }, ];
     scope.ttipofiltrosPunSum = [{ id: 1, nombre: 'CLIENTES' }, { id: 2, nombre: 'LOCALIDAD' }, { id: 3, nombre: 'PROVINCIA' }, { id: 4, nombre: 'TIPO INMUEBLE' }, { id: 5, nombre: 'ESTATUS' }];
     scope.fpuntosuministro = {};
     scope.tPuntosSuminitros = [];
     scope.tPuntosSuminitrosBack = [];

     scope.tProvidencias = [];
     scope.tLocalidades = [];
     scope.tTipoCliente = [];
     scope.tComerciales = [];
     scope.tSectores = [];
     scope.tColaboradores = [];
     scope.tTiposVias = [];
     scope.TtiposInmuebles = [];
     scope.tListBanc = [];
     scope.tListaContactos = [];
     scope.tListDocumentos = [];
     scope.Tclientes = [];
     ///////////////////////////// PUNTOS DE SUMINISTROS END ///////////////////////////	
     ServiceMaster.getAll().then(function(dato) {
         scope.tProvidencias = dato.Provincias;
         scope.tLocalidades = dato.Localidades;
         scope.tTipoCliente = dato.Tipo_Cliente;
         scope.tComerciales = dato.Comerciales;
         scope.tSectores = dato.Sector_Cliente;
         scope.tColaboradores = dato.Colaborador;
         scope.tTiposVias = dato.Tipo_Vias;
         scope.TtiposInmuebles = dato.Tipo_Inmuebles;
         scope.tListBanc = dato.Bancos;
         scope.tListaContactos = dato.Tipo_Contacto;
         scope.tListDocumentos = dato.Tipos_Documentos;
         scope.fdatos.FecIniCli = dato.Fecha_Server;
         scope.fecha_server = dato.Fecha_Server;

         $scope.predicate2 = 'id';
         $scope.reverse2 = true;
         $scope.currentPage2 = 1;
         $scope.order2 = function(predicate2) {
             $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
             $scope.predicate2 = predicate2;
         };
         scope.tPuntosSuminitros = dato.Puntos_Suministros_Clientes;
         scope.tPuntosSuminitrosBack = dato.Puntos_Suministros_Clientes;
         $scope.totalItems2 = scope.tPuntosSuminitros.length;
         $scope.numPerPage2 = 50;
         $scope.paginate2 = function(value2) {
             var begin2, end2, index2;
             begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
             end2 = begin2 + $scope.numPerPage2;
             index2 = scope.tPuntosSuminitros.indexOf(value2);
             return (begin2 <= index2 && index2 < end2);
         };
         if (scope.tPuntosSuminitros == false) {
             scope.tPuntosSuminitros = [];
             scope.tPuntosSuminitrosBack = [];
         }
         scope.Tclientes = dato.Clientes;
     }).catch(function(err) { console.log(err); });

     scope.filtrar_locaPumSum = function() {
         scope.TLocalidadesfiltradaPumSum = $filter('filter')(scope.tLocalidades, { DesPro: scope.fpuntosuministro.CodPro }, true);
     }
     $scope.SubmitFormFiltrosPumSum = function(event) {

         if (scope.fpuntosuministro.tipo_filtro == 1) {
             if (!scope.fpuntosuministro.CodCliPunSumFil > 0) {
                 Swal.fire({ title: "Seleccionar Un Cliente Para Aplicar el Filtro.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;
                 $scope.predicate2 = predicate2;
             };
             scope.tPuntosSuminitros = $filter('filter')(scope.tPuntosSuminitrosBack, { CodCli: scope.fpuntosuministro.CodCliPunSumFil }, true);
             $scope.totalItems2 = scope.tPuntosSuminitros.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.tPuntosSuminitros.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             scope.ruta_reportes_pdf_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodCliPunSumFil;
             scope.ruta_reportes_excel_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodCliPunSumFil;
         }
         if (scope.fpuntosuministro.tipo_filtro == 2) {
             if (!scope.fpuntosuministro.CodPro > 0) {
                 Swal.fire({ title: "Seleccionar Una Provincia.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (!scope.fpuntosuministro.CodLocFil > 0) {
                 Swal.fire({ title: "Seleccionar Una Localidad Para Aplicar el Filtro.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;
                 $scope.predicate2 = predicate2;
             };
             scope.tPuntosSuminitros = $filter('filter')(scope.tPuntosSuminitrosBack, { DesLoc: scope.fpuntosuministro.CodLocFil }, true);
             $scope.totalItems2 = scope.tPuntosSuminitros.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.tPuntosSuminitros.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             scope.ruta_reportes_pdf_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodLocFil;
             scope.ruta_reportes_excel_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodLocFil;
         }
         if (scope.fpuntosuministro.tipo_filtro == 3) {
             if (!scope.fpuntosuministro.CodPro > 0) {
                 Swal.fire({ title: "Seleccionar Una Provincia Para Aplicar el Filtro.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;
                 $scope.predicate2 = predicate2;
             };
             scope.tPuntosSuminitros = $filter('filter')(scope.tPuntosSuminitrosBack, { DesPro: scope.fpuntosuministro.CodPro }, true);
             $scope.totalItems2 = scope.tPuntosSuminitros.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.tPuntosSuminitros.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             scope.ruta_reportes_pdf_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodPro;
             scope.ruta_reportes_excel_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodPro;
         }
         if (scope.fpuntosuministro.tipo_filtro == 4) {
             if (!scope.fpuntosuministro.CodTipInm > 0) {
                 Swal.fire({ title: "Debe Seleccionar una Tipo de Inmueble.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;
                 $scope.predicate2 = predicate2;
             };
             scope.tPuntosSuminitros = $filter('filter')(scope.tPuntosSuminitrosBack, { DesTipInm: scope.fpuntosuministro.CodTipInm }, true);
             $scope.totalItems2 = scope.tPuntosSuminitros.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.tPuntosSuminitros.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             scope.ruta_reportes_pdf_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodTipInm;
             scope.ruta_reportes_excel_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.CodTipInm;
         }
         if (scope.fpuntosuministro.tipo_filtro == 5) {
             if (!scope.fpuntosuministro.EstPunSum > 0) {
                 Swal.fire({ title: "Debe Seleccionar un Estatus.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;
                 $scope.predicate2 = predicate2;
             };
             scope.tPuntosSuminitros = $filter('filter')(scope.tPuntosSuminitrosBack, { EstPunSum: scope.fpuntosuministro.EstPunSum }, true);
             $scope.totalItems2 = scope.tPuntosSuminitros.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.tPuntosSuminitros.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             scope.ruta_reportes_pdf_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.EstPunSum;
             scope.ruta_reportes_excel_puntos_suministros = scope.fpuntosuministro.tipo_filtro + "/" + scope.fpuntosuministro.EstPunSum;
         }
     };
     scope.regresar_filtroPumSum = function() {
         scope.fpuntosuministro = {};
         $scope.predicate2 = 'id';
         $scope.reverse2 = true;
         $scope.currentPage2 = 1;
         $scope.order2 = function(predicate2) {
             $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
             $scope.predicate2 = predicate2;
         };
         scope.tPuntosSuminitros = scope.tPuntosSuminitrosBack;
         $scope.totalItems2 = scope.tPuntosSuminitros.length;
         $scope.numPerPage2 = 50;
         $scope.paginate2 = function(value2) {
             var begin2, end2, index2;
             begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
             end2 = begin2 + $scope.numPerPage2;
             index2 = scope.tPuntosSuminitros.indexOf(value2);
             return (begin2 <= index2 && index2 < end2);
         };
         scope.fpuntosuministro.tipo_filtro = 0;
         scope.ruta_reportes_pdf_puntos_suministros = 0;
         scope.ruta_reportes_excel_puntos_suministros = 0;
     }
     scope.mostrar_all_puntos = function() {
         $("#cargando_puntos").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/get_all_puntos_sum";
         $http.get(url).then(function(result) {
             $("#cargando_puntos").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate2 = 'id';
                 $scope.reverse2 = true;
                 $scope.currentPage2 = 1;
                 $scope.order2 = function(predicate2) {
                     $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                     $scope.predicate2 = predicate2;
                 };
                 scope.tPuntosSuminitros = result.data;
                 scope.tPuntosSuminitrosBack = result.data;
                 $scope.totalItems2 = scope.tPuntosSuminitros.length;
                 $scope.numPerPage2 = 50;
                 $scope.paginate2 = function(value2) {
                     var begin2, end2, index2;
                     begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                     end2 = begin2 + $scope.numPerPage2;
                     index2 = scope.tPuntosSuminitros.indexOf(value2);
                     return (begin2 <= index2 && index2 < end2);
                 };
             } else {
                 if ($route.current.$$route.originalPath != "/Add_Puntos_Suministros/") {
                     Swal.fire({ title: "Error", text: "No hemos encontrados puntos de suministros registrados.", type: "error", confirmButtonColor: "#188ae2" });
                     scope.tPuntosSuminitros = [];
                 }
             }

         }, function(error) {
             $("#cargando_puntos").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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

     scope.validar_PunSum = function(index, opciones_PunSum, dato) {
         scope.opciones_PunSum[index] = undefined;
         console.log(dato);
         if (opciones_PunSum == 1) {
             location.href = "#/Gestionar_Cups/" + dato.CodPunSum;
         }
         if (opciones_PunSum == 2) {
             location.href = "#/Edit_Punto_Suministros/" + dato.CodPunSum;
         }
         if (opciones_PunSum == 3) {
             location.href = "#/Edit_Punto_Suministros/" + dato.CodPunSum + "/" + 1;
             console.log(opciones_PunSum);
         }
         if (opciones_PunSum == 4) {
             if (dato.EstPunSum == "Bloqueado") {
                 Swal.fire({ title: "Este Punto de Suministro Ya Se Encuentra Bloqueado.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             scope.tPunSum = {};
             scope.tPunSum.CodPunSum = dato.CodPunSum;
             scope.tPunSum.CodCli = dato.CodCli;
             scope.tPunSum.NumCifCli = dato.NumCifCli;
             scope.tPunSum.RazSocCli = dato.RazSocCli;
             scope.FecBloPun = scope.fecha_server;
             $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloPun);
             scope.tPunSum.opcion = opciones_PunSum;
             scope.cargar_lista_motivos_bloqueos_puntos_suministros();
             $("#modal_motivo_bloqueo_punto_suministro").modal('show');
         }
         if (opciones_PunSum == 5) {
             if (dato.EstPunSum == "Activo") {
                 Swal.fire({ title: "Este Punto de Suministro Ya Se Encuentra Activo.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             Swal.fire({
                 title: "¿Esta Seguro de Activar este Punto de Suministro?",
                 type: "question",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: "OK"
             }).then(function(t) {
                 if (t.value == true) {
                     scope.tPunSum = {};
                     scope.tPunSum.opcion = opciones_PunSum;
                     scope.tPunSum.CodPunSum = dato.CodPunSum;
                     scope.tPunSum.CodCli = dato.CodCli;
                     $("#estatus_PumSum").removeClass("loader loader-default").addClass("loader loader-default is-active");
                     var url = base_urlHome() + "api/Clientes/bloquear_PunSum/";
                     $http.post(url, scope.tPunSum).then(function(result) {
                         $("#estatus_PumSum").removeClass("loader loader-default is-active").addClass("loader loader-default");
                         if (result.data != false) {
                             Swal.fire({ title: "Exito!.", text: "El Punto de Suministro a sido activo correctamente.", type: "success", confirmButtonColor: "#188ae2" });
                             scope.mostrar_all_puntos();
                         } else {
                             Swal.fire({ title: "Error.", text: "Hubo un error al ejecutar esta acción por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                         }
                     }, function(error) {
                         $("#estatus_PumSum").removeClass("loader loader-default is-active").addClass("loader loader-default");
                         if (error.status == 404 && error.statusText == "Not Found") {
                             Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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

                 } else {
                     console.log('Cancelando ando...');
                 }
             });
         }
     }
     scope.cargar_lista_motivos_bloqueos_puntos_suministros = function() {
         var url = base_urlHome() + "api/Clientes/Motivos_Bloqueos_PunSum/";
         $http.get(url).then(function(result) {
             if (result.data != false) {
                 scope.tMotivosBloqueosPunSum = result.data;
             } else {
                 bootbox.alert({
                     message: "No hemos encontrados Motivos de Bloqueos para el Punto de Suministro.",
                     size: 'middle'
                 });
             }

         }, function(error) {
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error.", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
     scope.validar_fecha_blo = function(object) {
         console.log(object);
         if (object != undefined) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecBloPun = numero.substring(0, numero.length - 1);
         }
     }
     $scope.submitFormlockPunSum = function(event) {
         var FecBloPun = document.getElementById("FecBloPun").value;
         scope.FecBloPun = FecBloPun;
         if (scope.FecBloPun == undefined || scope.FecBloPun == null || scope.FecBloPun == '') {
             Swal.fire({ text: "El Campo Fecha de Bloqueo no puede estar vacio.", type: "error", confirmButtonColor: "#188ae2" });
             event.preventDefault();
             return false;
         } else {
             var FecBloPun = (scope.FecBloPun).split("/");
             if (FecBloPun.length < 3) {
                 Swal.fire({ text: "El Formato de Fecha de Bloqueo debe Ser EJ: " + scope.fecha_server, type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
             } else {
                 if (FecBloPun[0].length > 2 || FecBloPun[0].length < 2) {
                     Swal.fire({ text: "Por Favor Corrija el Formato del dia en la Fecha de Bloqueo deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecBloPun[1].length > 2 || FecBloPun[1].length < 2) {
                     Swal.fire({ text: "Por Favor Corrija el Formato del mes de la Fecha de Bloqueo deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecBloPun[2].length < 4 || FecBloPun[2].length > 4) {
                     Swal.fire({ text: "Por Favor Corrija el Formato del ano en la Fecha de Bloqueo Ya que deben ser 4 números solamente. EJ: 1999", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecBloPun.split("/");
                 valuesEnd = scope.fecha_server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     Swal.fire({ text: "La Fecha de Bloqueo no puede ser mayor al " + scope.fecha_server + " Por Favor Verifique he intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 scope.tPunSum.FecBloPun = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
             }
         }
         if (scope.tPunSum.ObsBloPunSum == undefined || scope.tPunSum.ObsBloPunSum == null || scope.tPunSum.ObsBloPunSum == '') {
             scope.tPunSum.ObsBloPunSum = null;
         } else {
             scope.tPunSum.ObsBloPunSum = scope.tPunSum.ObsBloPunSum;
         }

         Swal.fire({
             title: "¿Esta Seguro de Bloquear esta Punto de Suministro?",
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "OK"
         }).then(function(t) {
             if (t.value == true) {
                 $("#estatus_PumSum").removeClass("loader loader-default").addClass("loader loader-default is-active");
                 var url = base_urlHome() + "api/Clientes/bloquear_PunSum/";
                 $http.post(url, scope.tPunSum).then(function(result) {
                     $("#estatus_PumSum").removeClass("loader loader-default is-active").addClass("loader loader-default");
                     scope.tPunSum = result.data;
                     if (result.data != false) {
                         Swal.fire({ title: "Exito!.", text: "El Punto de Suministro a sido bloqueado correctamente.", type: "success", confirmButtonColor: "#188ae2" });
                         $("#modal_motivo_bloqueo_punto_suministro").modal('hide');
                         scope.mostrar_all_puntos();
                     } else {
                         Swal.fire({ title: "Error.", text: "Hubo un error al ejecutar esta acción por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                     }
                 }, function(error) {
                     $("#estatus_PumSum").removeClass("loader loader-default is-active").addClass("loader loader-default");
                     if (error.status == 404 && error.statusText == "Not Found") {
                         Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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

             } else {
                 console.log('Cancelando ando...');

             }
         });
     };
     scope.punto_suministro = function() {
         if (!scope.fpuntosuministro.CodCliPunSum > 0) {
             Swal.fire({ title: "Error", text: "Debe Seleccionar un Cliente Para Aplicar la Dirección.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fpuntosuministro.TipRegDir == 0) {
             scope.restringir_input = 0;
             scope.fpuntosuministro.CodTipVia = undefined;
             scope.fpuntosuministro.NomViaPunSum = undefined;
             scope.fpuntosuministro.NumViaPunSum = undefined;
             scope.fpuntosuministro.BloPunSum = undefined;
             scope.fpuntosuministro.EscPunSum = undefined;
             scope.fpuntosuministro.PlaPunSum = undefined;
             scope.fpuntosuministro.PuePunSum = undefined;
             scope.fpuntosuministro.Aclarador = undefined;
             scope.fpuntosuministro.CodProPunSum = undefined;
             scope.fpuntosuministro.CodLocPunSum = undefined;
             scope.fpuntosuministro.CpLocSoc = undefined;
             scope.fpuntosuministro.TelPunSum = undefined;
             scope.fpuntosuministro.CodTipInm = undefined;
             scope.fpuntosuministro.RefCasPunSum = undefined;
             scope.fpuntosuministro.DimPunSum = undefined;
             scope.fpuntosuministro.ObsPunSum = undefined;
         }
         if (scope.fpuntosuministro.TipRegDir == 1) {
             scope.restringir_input = 1;
             $("#DirFisSoc").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Clientes/buscar_direccion_Soc_Fis/Cliente/" + scope.fpuntosuministro.CodCliPunSum + "/TipRegDir/" + scope.fpuntosuministro.TipRegDir;
             $http.get(url).then(function(result) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (result.data != false) {
                     scope.fpuntosuministro.CodTipVia = result.data.CodTipViaSoc;
                     scope.fpuntosuministro.NomViaPunSum = result.data.NomViaDomSoc;
                     scope.fpuntosuministro.NumViaPunSum = result.data.NumViaDomSoc;
                     scope.fpuntosuministro.BloPunSum = result.data.BloDomSoc;
                     scope.fpuntosuministro.EscPunSum = result.data.EscDomSoc;
                     scope.fpuntosuministro.PlaPunSum = result.data.PlaDomSoc;
                     scope.fpuntosuministro.PuePunSum = result.data.PueDomSoc;
                     scope.fpuntosuministro.CodProPunSum = result.data.CodProSoc;
                     scope.fpuntosuministro.CodLocPunSum = result.data.CodLocSoc;
                     scope.fpuntosuministro.CPLocSoc = result.data.CPLocSoc;
                     scope.TLocalidadesfiltradaPunSum = [];
                     setTimeout(function() {
                         scope.filtrarLocalidadPunSum();
                         scope.mostrar_all_puntos();
                         console.log('Pasando por Timeout');
                     }, 1000);

                 } else {
                     Swal.fire({ title: "Error", text: "No hemos encontrados dirección compatible con este cliente.", type: "error", confirmButtonColor: "#188ae2" });
                 }

             }, function(error) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (error.status == 404 && error.statusText == "Not Found") {
                     Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
         if (scope.fpuntosuministro.TipRegDir == 2) {
             scope.restringir_input = 1;
             $("#DirFisSoc").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Clientes/buscar_direccion_Soc_Fis/Cliente/" + scope.fpuntosuministro.CodCliPunSum + "/TipRegDir/" + scope.fpuntosuministro.TipRegDir;
             $http.get(url).then(function(result) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (result.data != false) {
                     scope.fpuntosuministro.CodTipVia = result.data.CodTipViaFis;
                     scope.fpuntosuministro.NomViaPunSum = result.data.NomViaDomFis;
                     scope.fpuntosuministro.NumViaPunSum = result.data.NumViaDomFis;
                     scope.fpuntosuministro.BloPunSum = result.data.BloDomFis;
                     scope.fpuntosuministro.EscPunSum = result.data.EscDomFis;
                     scope.fpuntosuministro.PlaPunSum = result.data.PlaDomFis;
                     scope.fpuntosuministro.PuePunSum = result.data.PueDomFis;
                     scope.fpuntosuministro.CodProPunSum = result.data.CodProFis;
                     scope.fpuntosuministro.CodLocPunSum = result.data.CodLocFis;
                     scope.fpuntosuministro.CPLocSoc = result.data.CPLocFis;
                     scope.TLocalidadesfiltradaPunSum = [];
                     setTimeout(function() {
                         scope.filtrarLocalidadPunSum();
                         scope.mostrar_all_puntos();
                         console.log('Pasando por Timeout');
                     }, 1000);

                 } else {
                     Swal.fire({ title: "Error", text: "No hemos encontrados dirección compatible con este cliente.", type: "error", confirmButtonColor: "#188ae2" });
                 }

             }, function(error) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (error.status == 404 && error.statusText == "Not Found") {
                     Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
     }
     scope.filtrarLocalidadPunSum = function() {
         scope.TLocalidadesfiltradaPunSum = $filter('filter')(scope.tLocalidades, { CodPro: scope.fpuntosuministro.CodProPunSum }, true);
     }
     scope.filtrar_zona_postalPunSum = function() {
         scope.CodLocZonaPostalPunSum = $filter('filter')(scope.tLocalidades, { CodLoc: scope.fpuntosuministro.CodLocPunSum }, true);
         angular.forEach(scope.CodLocZonaPostalPunSum, function(data) {
             scope.ZonPosPunSum = data.CPLoc;
         });
     }
     $scope.submitFormPuntoSuministro = function(event) {
         if (!scope.validar_campos_punto_suministro()) {
             return false;
         }
         if (scope.fpuntosuministro.BloPunSum == undefined || scope.fpuntosuministro.BloPunSum == null || scope.fpuntosuministro.BloPunSum == '') {
             scope.fpuntosuministro.BloPunSum = null;
         } else {
             scope.fpuntosuministro.BloPunSum = scope.fpuntosuministro.BloPunSum;
         }
         if (scope.fpuntosuministro.EscPunSum == undefined || scope.fpuntosuministro.EscPunSum == null || scope.fpuntosuministro.EscPunSum == '') {
             scope.fpuntosuministro.EscPunSum = null;
         } else {
             scope.fpuntosuministro.EscPunSum = scope.fpuntosuministro.EscPunSum;
         }
         if (scope.fpuntosuministro.PlaPunSum == undefined || scope.fpuntosuministro.PlaPunSum == null || scope.fpuntosuministro.PlaPunSum == '') {
             scope.fpuntosuministro.PlaPunSum = null;
         } else {
             scope.fpuntosuministro.PlaPunSum = scope.fpuntosuministro.PlaPunSum;
         }
         if (scope.fpuntosuministro.PuePunSum == undefined || scope.fpuntosuministro.PuePunSum == null || scope.fpuntosuministro.PuePunSum == '') {
             scope.fpuntosuministro.PuePunSum = null;
         } else {
             scope.fpuntosuministro.PuePunSum = scope.fpuntosuministro.PuePunSum;
         }
         if (scope.fpuntosuministro.Aclarador == undefined || scope.fpuntosuministro.Aclarador == null || scope.fpuntosuministro.Aclarador == '') {
             scope.fpuntosuministro.Aclarador = null;
         } else {
             scope.fpuntosuministro.Aclarador = scope.fpuntosuministro.Aclarador;
         }
         if (scope.fpuntosuministro.CPLocSoc == undefined || scope.fpuntosuministro.CPLocSoc == null || scope.fpuntosuministro.CPLocSoc == '') {
             scope.fpuntosuministro.CPLocSoc = null;
         } else {
             scope.fpuntosuministro.CPLocSoc = scope.fpuntosuministro.CPLocSoc;
         }
         if (scope.fpuntosuministro.RefCasPunSum == undefined || scope.fpuntosuministro.RefCasPunSum == null || scope.fpuntosuministro.RefCasPunSum == '') {
             scope.fpuntosuministro.RefCasPunSum = null;
         } else {
             scope.fpuntosuministro.RefCasPunSum = scope.fpuntosuministro.RefCasPunSum;
         }
         if (scope.fpuntosuministro.DimPunSum == undefined || scope.fpuntosuministro.DimPunSum == null || scope.fpuntosuministro.DimPunSum == '') {
             scope.fpuntosuministro.DimPunSum = null;
         } else {
             scope.fpuntosuministro.DimPunSum = scope.fpuntosuministro.DimPunSum;
         }
         if (scope.fpuntosuministro.ObsPunSum == undefined || scope.fpuntosuministro.ObsPunSum == null || scope.fpuntosuministro.ObsPunSum == '') {
             scope.fpuntosuministro.ObsPunSum = null;
         } else {
             scope.fpuntosuministro.ObsPunSum = scope.fpuntosuministro.ObsPunSum;
         }
         if (scope.fpuntosuministro.TelPunSum == undefined || scope.fpuntosuministro.TelPunSum == null || scope.fpuntosuministro.TelPunSum == '') {
             scope.fpuntosuministro.TelPunSum = null;
         }
         if (scope.fpuntosuministro.CodPunSum > 0) {
             var title = 'Actualizando';
             var text = '¿Esta Seguro de Actualizar el Punto de Suministro?';
             var response = "Punto de Suministro modificado satisfactoriamente.";
         }
         if (scope.fpuntosuministro.CodPunSum == undefined) {
             var title = 'Guardando';
             var text = '¿Esta Seguro de Incluir Un Nuevo Registro?';
             var response = "Punto de Suministro creado satisfactoriamente.";
         }
         Swal.fire({
             title: text,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "OK"
         }).then(function(t) {
             if (t.value == true) {
                 $("#" + title).removeClass("loader loader-default").addClass("loader loader-default  is-active");
                 var url = base_urlHome() + "api/Clientes/crear_punto_suministro_cliente/";
                 $http.post(url, scope.fpuntosuministro).then(function(result) {

                     if (result.data != false) {
                         scope.fpuntosuministro = result.data;
                         $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                         //scope.buscarXCodPunSum();							
                     } else {
                         $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         Swal.fire({ title: "Error.", text: "Hubo un error al ejecutar esta acción por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                     }
                 }, function(error) {
                     $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                     if (error.status == 404 && error.statusText == "Not Found") {
                         Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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

             } else {
                 console.log('Cancelando ando...');
                 event.preventDefault();

             }
         });
     };
     scope.validar_campos_punto_suministro = function() {
         resultado = true;
         if (!scope.fpuntosuministro.TipRegDir > 0) {
             Swal.fire({ title: "Debe Seleccionar el Tipo de Dirección", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fpuntosuministro.CodTipVia > 0) {
             Swal.fire({ title: "Debe Seleccionar un Tipo de Via.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fpuntosuministro.NomViaPunSum == null || scope.fpuntosuministro.NomViaPunSum == undefined || scope.fpuntosuministro.NomViaPunSum == '') {
             Swal.fire({ title: "El Nombre del Domicilio es Requerido.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fpuntosuministro.NumViaPunSum == null || scope.fpuntosuministro.NumViaPunSum == undefined || scope.fpuntosuministro.NumViaPunSum == '') {
             Swal.fire({ title: "El Número del Domicilio es Requerido.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fpuntosuministro.CodProPunSum > 0) {
             Swal.fire({ title: "Debe seleccionar una Provincia de la lista.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fpuntosuministro.CodLocPunSum > 0) {
             Swal.fire({ title: "Debe seleccionar una Localidad de la lista.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         /*if (scope.fpuntosuministro.TelPunSum==null || scope.fpuntosuministro.TelPunSum==undefined || scope.fpuntosuministro.TelPunSum=='')
         {
         	Swal.fire({title:"El Campo Número de Teléfono es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
         	return false;
         }*/
         if (!scope.fpuntosuministro.CodTipInm > 0) {
             Swal.fire({ title: "Debe seleccionar un tipo de inmueble de la lista.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (resultado == false) {
             return false;
         }
         return true;
     }
     scope.regresar_punto_suministro = function() {
         if (scope.fpuntosuministro.CodPunSum == undefined) {
             var title = "Guardando";
             var text = "¿Estás seguro de regresar y no guardar los datos?";
         } else {
             var title = "Actualizando";
             var text = "¿Estás seguro de regresar y no actualizar los datos?";
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
                 location.href = "#/Puntos_Suministros";
             } else {
                 console.log('Cancelando ando...');
                 event.preventDefault();
             }
         });
         /*scope.agregar_puntos_suministros=true;
         scope.fpuntosuministro={};
         scope.mostrar_all_puntos();*/
     }
     scope.BuscarXIDPunSum = function() {
         //cargando_I
         $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/BuscarXIDPunSumData/CodPunSum/" + scope.nID;
         $http.get(url).then(function(result) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 scope.fpuntosuministro = result.data;
                 scope.ZonPosPunSum = result.data.ZonPosPunSum;
                 setTimeout(function() {
                     scope.filtrarLocalidadPunSum();
                     scope.mostrar_all_puntos();
                     console.log('Pasando por Timeout');
                 }, 1300);
             } else {
                 Swal.fire({ title: "Error.", text: "Hubo un error al ejecutar esta acción por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
             }
         }, function(error) {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
     scope.validarsinuermo = function(object, metodo) {
         if (metodo == 1) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([0-9])*$/.test(numero))
                     scope.fpuntosuministro.NumViaPunSum = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 2) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fpuntosuministro.RefCasPunSum = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 3) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fpuntosuministro.DimPunSum = numero.substring(0, numero.length - 1);
             }
         }
     }


     if (scope.nID != undefined) {
         scope.BuscarXIDPunSum();
     }
     ////////////////////////////////////////////////// PARA LOS PUNTOS DE SUMINISTROS END ////////////////////////////////////////////////////////
 }