 app.controller('Controlador_Puntos_Suministros', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServicePuntoSuministro', 'upload', Controlador])
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServicePuntoSuministro, upload) {
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
     ////////////////////////////////////////////////// PARA LOS Direcciones de SuministroS START ////////////////////////////////////////////////////////

     ///////////////////////////// Direcciones de SuministroS START ///////////////////////////
     scope.CodCli = true;
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
     console.log($route.current.$$route.originalPath);
     if($route.current.$$route.originalPath=="/Add_Puntos_Suministros/" || $route.current.$$route.originalPath=="/Edit_Punto_Suministros/:ID/:INF" || $route.current.$$route.originalPath=="/Edit_Punto_Suministros/:ID")
     {
        ServicePuntoSuministro.getAll().then(function(dato) {
        scope.tTiposVias = dato.Tipo_Vias;
        scope.tProvidencias = dato.Provincias;
        scope.TtiposInmuebles=dato.Tipo_Inmuebles;
         scope.fdatos.FecIniCli = dato.Fecha_Server;
         scope.fecha_server = dato.Fecha_Server;

         
     }).catch(function(err) { console.log(err); });
     }
     ///////////////////////////// Direcciones de SuministroS END ///////////////////////////	
     /**/

     scope.filtrar_locaPumSum = function() {
         scope.TLocalidadesfiltradaPumSum = $filter('filter')(scope.tLocalidades, { DesPro: scope.fpuntosuministro.CodPro }, true);
     }
     scope.BuscarLocalidadesPunSun=function(NomPro,metodo)
     {
        if(metodo==1)
        {
           for (var i = 0; i < scope.tProvidencias.length; i++)
            {
                if (scope.tProvidencias[i].DesPro == NomPro) {
                     console.log(scope.tProvidencias[i]);
                     scope.CodPro=scope.tProvidencias[i].CodPro;                     
                }
            } 
        }
        else
        {
            scope.CodPro=NomPro;
        }
        var url=base_urlHome()+"api/Clientes/BuscarLocalidadesFil/CodPro/"+scope.CodPro;
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.TLocalidadesfiltradaPunSum=result.data;
            }
            else
            {
               scope.toast('error','No se encontraron Localidades asignada a esta Provincia','Error');
               scope.TLocalidadesfiltradaPunSum=[];
               scope.fpuntosuministro.CodLocPunSum=undefined;
               scope.fpuntosuministro.CodLocFil=undefined;
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
     $scope.SubmitFormFiltrosPumSum = function(event) {

         if (scope.fpuntosuministro.tipo_filtro == 1) {
             if (!scope.fpuntosuministro.CodCliPunSumFil > 0) {
                 scope.toast('error','Seleccionar Un Cliente Para Aplicar el Filtro.','');
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
                 scope.toast('error','Seleccionar Una Provincia.','');
                 return false;
             }
             if (!scope.fpuntosuministro.CodLocFil > 0) {
                 scope.toast('error','Seleccionar Una Localidad Para Aplicar el Filtro.','');
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
                 scope.toast('error','Seleccionar Una Provincia Para Aplicar el Filtro.','');
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
                 scope.toast('error','Debe Seleccionar una Tipo de Inmueble.','');
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
                 scope.toast('error','Debe Seleccionar un Estatus.','');
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
                    scope.tPuntosSuminitros = [];
                 }
             }

         }, function(error) {
             $("#cargando_puntos").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                 scope.toast('error','Este Dirección de Suministro Ya Se Encuentra Bloqueado.','');
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
                 scope.toast('error','Este Dirección de Suministro Ya Se Encuentra Activo.','');
                 return false;
             }
             Swal.fire({
                 title: "¿Esta Seguro de Activar este Dirección de Suministro?",
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
                             scope.toast('error','El Dirección de Suministro a sido activo de forma correcta','Exito');
                             scope.mostrar_all_puntos();
                         } else {
                             scope.toast('error','Hubo un error al ejecutar esta acción por favor intente nuevamente.','Error');
                             
                         }
                     }, function(error) {
                         $("#estatus_PumSum").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
         }
     }
     scope.cargar_lista_motivos_bloqueos_puntos_suministros = function() {
         var url = base_urlHome() + "api/Clientes/Motivos_Bloqueos_PunSum/";
         $http.get(url).then(function(result) {
                
                scope.FecBloPun=result.data.FechaServer;
                 $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloPun);
                 scope.fecha_server=result.data.FechaServer;
             if (result.data.data != false) {
                 scope.tMotivosBloqueosPunSum = result.data.data;
                           } else {                
                 scope.toast('error','No hemos encontrados Motivos de Bloqueos para el Dirección de Suministro.','Error');
                 
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
             scope.toast('error','La Fecha de Bloqueo es requerida','');
             event.preventDefault();
             return false;
         } else {
             var FecBloPun = (scope.FecBloPun).split("/");
             if (FecBloPun.length < 3) {
                 scope.toast('error','El formato Fecha de Bloqueo correcto es DD/MM/YYYY','');
                 event.preventDefault();
                 return false;
             } else {
                 if (FecBloPun[0].length > 2 || FecBloPun[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecBloPun[1].length > 2 || FecBloPun[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                   event.preventDefault();
                     return false;
                 }
                 if (FecBloPun[2].length < 4 || FecBloPun[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','');
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecBloPun.split("/");
                 valuesEnd = scope.fecha_server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     scope.toast('error',"La Fecha de Bloqueo no puede ser mayor al " + scope.fecha_server + " Verifique e intente nuevamente",'');
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
             title: "¿Seguro que desea Bloquear la Dirección de Suministro?",
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
                         scope.toast('success','La Dirección de Suministro ha sido bloqueada de forma correcta','Procesado');
                          $("#modal_motivo_bloqueo_punto_suministro").modal('hide');
                         scope.mostrar_all_puntos();
                     } else {
                         scope.toast('error','Hubo un error en el proceso, por favor intente nuevamente','Error');                         
                     }
                 }, function(error) {
                     $("#estatus_PumSum").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.punto_suministro = function() {
         if (!scope.fpuntosuministro.CodCliPunSum > 0) {
             scope.toast('error','Debe Seleccionar un Cliente Para Aplicar la Dirección.','Error');
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
             scope.fpuntosuministro.CPLocSoc =undefined;
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
                    scope.BuscarLocalidadesPunSun(result.data.CodProSoc,2);
                 } else {
                    scope.toast('error','No hemos encontrados dirección compatible con este cliente.','Error');
                 }

             }, function(error) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                     scope.BuscarLocalidadesPunSun(result.data.CodProFis,2);

                 } else {
                     scope.toast('error','No hemos encontrados dirección compatible con este cliente.','Error');
                 }

             }, function(error) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
             var text = '¿Seguro que desea modificar la Dirección de Suministro?';
             var response = "Dirección de Suministro actualizada de forma correcta";
         }
         if (scope.fpuntosuministro.CodPunSum == undefined) {
             var title = 'Guardando';
             var text = '¿Seguro que desea registrar la Dirección de Suministro?';
             var response = "Dirección de Suministro creada de forma correcta";
         }
         Swal.fire({
             title: text,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "Confirmar"
         }).then(function(t) {
             if (t.value == true) {
                 $("#" + title).removeClass("loader loader-default").addClass("loader loader-default  is-active");
                 var url = base_urlHome() + "api/Clientes/crear_punto_suministro_cliente/";
                 $http.post(url, scope.fpuntosuministro).then(function(result) {

                     if (result.data != false) {
                         scope.fpuntosuministro = result.data;
                         $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         scope.toast('success',response,title);                         
                         //scope.buscarXCodPunSum();							
                     } else {
                         $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         scope.toast('error','Hubo un error al ejecutar esta acción por favor intente nuevamente.','Error');
                        
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

             } else {
                 console.log('Cancelando ando...');
                 event.preventDefault();

             }
         });
     };
     scope.validar_campos_punto_suministro = function() {
         resultado = true;
         if (!scope.fpuntosuministro.TipRegDir > 0) {
             scope.toast('error','Debe Seleccionar el Tipo de Dirección','');
             return false;
         }
         if (!scope.fpuntosuministro.CodTipVia > 0) {
             scope.toast('error','Debe Seleccionar un Tipo de Via.','');
             return false;
         }
         if (scope.fpuntosuministro.NomViaPunSum == null || scope.fpuntosuministro.NomViaPunSum == undefined || scope.fpuntosuministro.NomViaPunSum == '') {
             scope.toast('error','El Nombre de la Vía es requerido','');
             //Swal.fire({ title: "", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fpuntosuministro.NumViaPunSum == null || scope.fpuntosuministro.NumViaPunSum == undefined || scope.fpuntosuministro.NumViaPunSum == '') {
             scope.toast('error','El Número de la Vía es requerido','');
             return false;
         }
         if (!scope.fpuntosuministro.CodProPunSum > 0) {
             scope.toast('error','Debe seleccionar una Provincia de la lista.','');
             return false;
         }
         if (!scope.fpuntosuministro.CodLocPunSum > 0) {
             scope.toast('error','Debe seleccionar una Localidad de la lista.','');
             return false;
         }
         /*if (scope.fpuntosuministro.TelPunSum==null || scope.fpuntosuministro.TelPunSum==undefined || scope.fpuntosuministro.TelPunSum=='')
         {
         	scope.toast('error','El Campo Número de Teléfono es requerido','');	           
         	return false;
         }*/
         if (!scope.fpuntosuministro.CodTipInm > 0) {
             scope.toast('error','Debe seleccionar un tipo de inmueble de la lista.','');
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
             var text = "¿Seguro que desea cerrar sin registrar la Dirección de Suministro?";
         } else {
             var title = "Actualizando";
             var text = "¿Seguro que desea cerrar sin actualizar la información de la Dirección de Suministro?";
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
                 location.href = "#/Puntos_Suministros";
             } else {
                 console.log('Cancelando ando...');
                 event.preventDefault();
             }
         });
     }
     scope.BuscarXIDPunSum = function() {
         //cargando_I
         $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/BuscarXIDPunSumData/CodPunSum/" + scope.nID;
         $http.get(url).then(function(result) 
         {
             $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false){

                scope.BuscarLocalidadesPunSun(result.data.data.CodProPunSum,2);
                scope.fpuntosuministro = result.data.data;
                scope.ZonPosPunSum = result.data.ZonPosPunSum;             
                scope.CodCliPunSumFil=result.data.NumCifCli;
             } else {
                scope.toast('error','Ha ocurrido un error, o el punto de suministro no existe en nuestros registros.','Información');
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
     scope.FetchPunSum = function() {
         if (scope.filtrar_PumSum == undefined || scope.filtrar_PumSum == null || scope.filtrar_PumSum == '') {
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
             scope.ruta_reportes_pdf_puntos_suministros = 0;
             scope.ruta_reportes_excel_puntos_suministros = 0;
         } else {
             if (scope.filtrar_PumSum.length >= 2) {
                 scope.fdatos.filtrar_PumSum = scope.filtrar_PumSum;
                 var url = base_urlHome() + "api/Clientes/getPunSumFilter";
                 $http.post(url, scope.fdatos).then(function(result) {
                     console.log(result.data);
                     if (result.data != false) {
                         $scope.predicate2 = 'id';
                         $scope.reverse2 = true;
                         $scope.currentPage2 = 1;
                         $scope.order2 = function(predicate2) {
                             $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                             $scope.predicate2 = predicate2;
                         };
                         scope.tPuntosSuminitros = result.data;
                         $scope.totalItems2 = scope.tPuntosSuminitros.length;
                         $scope.numPerPage2 = 50;
                         $scope.paginate2 = function(value2) {
                             var begin2, end2, index2;
                             begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                             end2 = begin2 + $scope.numPerPage2;
                             index2 = scope.tPuntosSuminitros.indexOf(value2);
                             return (begin2 <= index2 && index2 < end2);
                         };
                         scope.ruta_reportes_pdf_puntos_suministros = 6 + "/" + scope.filtrar_PumSum;
                         scope.ruta_reportes_excel_puntos_suministros = 6 + "/" + scope.filtrar_PumSum;
                     } else {
                         
                            scope.tPuntosSuminitros =[];
                            scope.ruta_reportes_pdf_puntos_suministros = 0;
                            scope.ruta_reportes_excel_puntos_suministros =0;
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
             {
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
                         scope.ruta_reportes_pdf_puntos_suministros = 0;
                         scope.ruta_reportes_excel_puntos_suministros = 0;
             }
         }
     }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }
    scope.searchboxClicked = function($event) {
                     $event.stopPropagation();
                 }
    scope.setValue = function(index, $event, result, metodo) {
                     if (metodo == 1) {
                         scope.CodCliPunSumFil = scope.searchResult[index].NumCifCli;
                         scope.fpuntosuministro.CodCliPunSumFil= scope.searchResult[index].CodCli;
                         scope.searchResult = {};
                         $event.stopPropagation();
                     }
                     if (metodo == 2) {
                         scope.fpuntosuministro.CodCliPunSum = scope.searchResult[index].CodCli;
                         scope.CodCliPunSumFil = scope.searchResult[index].NumCifCli;
                         scope.searchResult = {};
                         $event.stopPropagation();
                     }

                 }
                 scope.fetchClientes = function(metodo) {
             if (metodo == 1) {
                 var searchText_len = scope.CodCliPunSumFil.trim().length;
                 scope.fdatos.filtrar_clientes = scope.CodCliPunSumFil;
                 if (searchText_len > 0) {
                     var url = base_urlHome() + "api/Clientes/getClientesFilter";
                     $http.post(url, scope.fdatos).then(function(result) {
                             //console.log(result);
                             if (result.data != false) {
                                 scope.searchResult = result.data;
                                 //console.log(scope.searchResult);
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
                     if (metodo == 2) {
                         var searchText_len = scope.CodCliPunSumFil.trim().length;
                         scope.fdatos.filtrar_clientes = scope.CodCliPunSumFil;
                         if (searchText_len > 0) {
                             var url = base_urlHome() + "api/Clientes/getClientesFilter";
                             $http.post(url, scope.fdatos).then(function(result) {
                                 console.log(result);
                                 if (result.data != false) {
                                     scope.searchResult = result.data;
                                     console.log(scope.searchResult);
                                 } else {
                                    scope.searchResult = {};
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
                         } else {
                             scope.searchResult = {};
                         }
                     }


                 }  
                 scope.RealizarCambioFiltro=function(metodo)
                 {
                    console.log(metodo);
                    if(metodo==2 || metodo==3)
                    {
                        scope.tProvidencias=[];
                        scope.fpuntosuministro.CodPro=undefined;
                        var url =base_urlHome()+"api/Clientes/RealizarConsultaFiltros/metodo/"+4;
                        $http.get(url).then(function(result)
                        {
                            if(result.data!=false)
                            {
                                 scope.tProvidencias=result.data;
                            }
                            else
                            {
                                scope.tProvidencias=[];
                                scope.fpuntosuministro.CodPro=undefined;
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
                    if(metodo==4)
                    {
                        var url =base_urlHome()+"api/Clientes/RealizarConsultaFiltros/metodo/"+8;
                        $http.get(url).then(function(result)
                        {
                            if(result.data!=false)
                            {
                                 scope.TtiposInmuebles=result.data;
                            }
                            else
                            {
                                scope.TtiposInmuebles=[];
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
     if (scope.nID != undefined) {
         scope.BuscarXIDPunSum();
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
     ////////////////////////////////////////////////// PARA LOS Direcciones de SuministroS END ////////////////////////////////////////////////////////
 }