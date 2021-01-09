 app.controller('Controlador_Servicios_Especiales', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceServiciosEspeciales', 'upload', Controlador])
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceServiciosEspeciales, upload) {
     //declaramos una variable llamada scope donde tendremos a vm
     /*inyectamos un controlador para acceder a sus variables y metodos*/
     //$controller('Controlador_Clientes as vmAE',{$scope:$scope});
     //var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
     //$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
     //var testCtrl1ViewModel = $controller('Controlador_Clientes');
     //testCtrl1ViewModel.cargar_lista_clientes();
     var scope = this;
     scope.fdatos = {};
     scope.nIDSerEsp = $route.current.params.ID;
     scope.INF = $route.current.params.INF;
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
     scope.NumCifCom = true;
     scope.RazSocCom = true;
     scope.DesSerEsp = true;
     scope.TipCli = true;
     scope.SerElecSerEsp = true;
     scope.SerGasSerEsp = true;
     scope.FecIniSerEsp = true;
     scope.EstSerEsp = true;
     scope.AccSerEsp = true;
     scope.reporte_pdf_servicio_especiales = 0;
     scope.reporte_excel_servicio_especiales = 0;
     scope.TServicioEspeciales = [];
     scope.TServicioEspecialesBack = [];
     scope.servicio_especial = {};

     scope.servicio_especial.SerEle = false;
     scope.servicio_especial.SerGas = false;
     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
     scope.select_tarifa_Elec_Baj_SerEsp = []
     scope.select_tarifa_Elec_Alt_SerEsp = [];
     scope.select_tarifa_gas_SerEsp = [];

     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
     scope.ttipofiltrosServicioEspecial = [{ id: 1, nombre: 'Comercializadora' }, { id: 2, nombre: 'Tipo de Suministro' }, { id: 3, nombre: 'Tipo de Cliente' }, { id: 4, nombre: 'Tipo Comisión' }, { id: 5, nombre: 'Fecha de Inicio' }, { id: 6, nombre: 'Estatus' }];
     scope.Topciones_Grib = [{ id: 4, nombre: 'Ver' }, { id: 3, nombre: 'Editar' }, { id: 1, nombre: 'Activar' }, { id: 2, nombre: 'Suspender' }, { id: 5, nombre: 'Comisiones' }];
     //scope.Topciones_Grib = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'},{id: 5, nombre: 'COMISIONES'}];
     scope.validate_info_servicio_especiales = scope.INF;
     console.log($route.current.$$route.originalPath);

     scope.TComisionesDet = [];
     scope.TComisionesRangoGrib = [];
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES START ////////////////////////////////////////////////////////
     ServiceServiciosEspeciales.getAll().then(function(dato) {

        scope.Tcomercializadoras=dato.Comercializadora;
        scope.Tipos_Comision=dato.TipCom;
        scope.FecIniSerEspForm = dato.fecha;
        $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniSerEspForm);
        scope.Fecha_Server = dato.fecha;
        if(dato.Servicios_Especiales==false)
        {
            scope.TServicioEspeciales = [];
            scope.TServicioEspecialesBack = [];
        }
        else
        {            
            $scope.predicate3 = 'id';
            $scope.reverse3 = true;
            $scope.currentPage3 = 1;
            $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
            };
            scope.TServicioEspeciales = dato.Servicios_Especiales;
            scope.TServicioEspecialesBack = dato.Servicios_Especiales;
            $scope.totalItems3 = scope.TServicioEspeciales.length;
            $scope.numPerPage3 = 50;
            $scope.paginate3 = function(value3) {
                var begin3, end3, index3;
                begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                end3 = begin3 + $scope.numPerPage3;
                index3 = scope.TServicioEspeciales.indexOf(value3);
                return (begin3 <= index3 && index3 < end3);
            };
        }
        scope.Tarifa_Gas_Anexos = dato.Tarifa_Gas;
        scope.Tarifa_Ele_Anexos = dato.Tarifa_Ele;
        angular.forEach(scope.Tarifa_Ele_Anexos, function(Tarifa_Electrica) {
             if (Tarifa_Electrica.TipTen == 'BAJA') {
                 var ObjTarifaElecBaj = new Object();
                 if (scope.Tarifa_Elec_Baja == undefined || scope.Tarifa_Elec_Baja == false) {
                     scope.Tarifa_Elec_Baja = [];
                 }
                 scope.Tarifa_Elec_Baja.push({ TipTen: Tarifa_Electrica.TipTen, NomTarEle: Tarifa_Electrica.NomTarEle, MinPotCon: Tarifa_Electrica.MinPotCon, MaxPotCon: Tarifa_Electrica.MaxPotCon, CodTarEle: Tarifa_Electrica.CodTarEle, CanPerTar: Tarifa_Electrica.CanPerTar });
                //console.log(scope.Tarifa_Elec_Baja);
             } else {
                 var ObjTarifaElecAlt = new Object();
                 if (scope.Tarifa_Elec_Alt == undefined || scope.Tarifa_Elec_Alt == false) {
                     scope.Tarifa_Elec_Alt = [];
                 }
                 scope.Tarifa_Elec_Alt.push({ TipTen: Tarifa_Electrica.TipTen, NomTarEle: Tarifa_Electrica.NomTarEle, MinPotCon: Tarifa_Electrica.MinPotCon, MaxPotCon: Tarifa_Electrica.MaxPotCon, CodTarEle: Tarifa_Electrica.CodTarEle, CanPerTar: Tarifa_Electrica.CanPerTar });
                //console.log(scope.Tarifa_Elec_Alt);
             }
         });
     }).catch(function(error) {
         console.log(error); //Tratar el error
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

     scope.cargar_lista_servicos_especiales = function() {
         $("#List_Serv").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Comercializadora/get_list_servicos_especiales/";
         $http.get(url).then(function(result) {
             $("#List_Serv").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate3 = 'id';
                 $scope.reverse3 = true;
                 $scope.currentPage3 = 1;
                 $scope.order3 = function(predicate3) {
                     $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                     $scope.predicate3 = predicate3;
                 };
                 scope.TServicioEspeciales = result.data;
                 scope.TServicioEspecialesBack = result.data;
                 $scope.totalItems3 = scope.TServicioEspeciales.length;
                 $scope.numPerPage3 = 50;
                 $scope.paginate3 = function(value3) {
                     var begin3, end3, index3;
                     begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                     end3 = begin3 + $scope.numPerPage3;
                     index3 = scope.TServicioEspeciales.indexOf(value3);
                     return (begin3 <= index3 && index3 < end3);
                 };
             } else {
                 scope.TServicioEspeciales = [];
                 scope.TServicioEspecialesBack = [];
             }
         }, function(error) {
                        $("#List_Serv").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

     $scope.SubmitFormFiltrosServiciosEspeciales = function(event) {
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 1) {
             if (!scope.tmodal_servicio_especiales.CodCom > 0) {
                 scope.toast('error','Debe Seleccionar una Comercializadora de la lista.','Comercializadora');
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { NumCifCom: scope.tmodal_servicio_especiales.CodCom }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.CodCom;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.CodCom;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 2) {
             if (!scope.tmodal_servicio_especiales.TipServ > 0) {
                scope.toast('error','Debe Seleccionar un Tipo de Suministro de la lista.','Tipo Suministro');
                 return false;
             }
             /*if(!scope.tmodal_servicio_especiales.Select>0)
             {
             	scope.toast('error','Seleccione un Elemento de la Lista.','Error');
                return false;
             }*/
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             if (scope.tmodal_servicio_especiales.TipServ == 1) {
                 scope.Servicio = "GAS";
                 scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { SerGas: scope.tmodal_servicio_especiales.Select }, true);
             }
             if (scope.tmodal_servicio_especiales.TipServ == 2) {
                 scope.Servicio = "ELÉCTRICO";
                 scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { SerEle: scope.tmodal_servicio_especiales.Select }, true);

             }
             if (scope.tmodal_servicio_especiales.TipServ == 3) {
                 scope.Servicio = "AMBOS";
                 //scope.TServicioEspeciales =$filter('filter')(scope.TServicioEspecialesBack, {SerEle: scope.tmodal_servicio_especiales.Select}, true);
             }
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.Servicio;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.Servicio;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 3) {
             if (!scope.tmodal_servicio_especiales.TipCli > 0) {
                 scope.toast('error','Debe Seleccionar un Tipo de Cliente de la lista.','Tipo Cliente');
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { TipCli: scope.tmodal_servicio_especiales.TipCli }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.TipCli;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.TipCli;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 4) {
             if (!scope.tmodal_servicio_especiales.DesTipCom > 0) {
                 scope.toast('error','Debe Seleccionar un Tipo de Comisión de la lista.','Tipo Comision');
                 //Swal.fire({ title: "Tipo Comision", text: 'Debe Seleccionar un Tipo de Comisión de la lista.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };

             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { DesTipCom: scope.tmodal_servicio_especiales.DesTipCom }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.DesTipCom;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.DesTipCom;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 5) {
             var FecIniSerEsp = document.getElementById("FecIniSerEsp").value;
             scope.tmodal_servicio_especiales.FecIniSerEsp = FecIniSerEsp;
             if (scope.tmodal_servicio_especiales.FecIniSerEsp == undefined || scope.tmodal_servicio_especiales.FecIniSerEsp == null || scope.tmodal_servicio_especiales.FecIniSerEsp == "") {
                 scope.toast('error','La Fecha de Inicio es Requerida.','Fecha de Inicio');
                 return false;
             } else {
                 var FecIniSerEsp = (scope.tmodal_servicio_especiales.FecIniSerEsp).split("/");
                 if (FecIniSerEsp.length < 3) {
                    scope.toast('error',"El Formato de la Fecha de Inicio de Ser: " + fecha,' Fecha de Inicio');
                    event.preventDefault();
                    return false;
                 } else {
                     if (FecIniSerEsp[0].length > 2 || FecIniSerEsp[0].length < 2) {
                         scope.toast('error',"El Formato del Día Debe Ser: " + dd,'Fecha de Inicio');
                         event.preventDefault();
                         return false;

                     }
                     if (FecIniSerEsp[1].length > 2 || FecIniSerEsp[1].length < 2) {
                        scope.toast('error',"El Formato del Mes Debe Ser: " + mm,'Fecha de Inicio');
                        event.preventDefault();
                        return false;
                     }
                     if (FecIniSerEsp[2].length < 4 || FecIniSerEsp[2].length > 4) {
                        scope.toast('error',"El Formato del Año Debe Ser: " + yyyy,'Fecha de Inicio');
                        event.preventDefault();
                        return false;
                     }
                     scope.tmodal_servicio_especiales.FecIniSerEsp = FecIniSerEsp[0] + "/" + FecIniSerEsp[1] + "/" + FecIniSerEsp[2];
                 }
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };

             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { FecIniSerEsp: scope.tmodal_servicio_especiales.FecIniSerEsp }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.FecIniSerEsp;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.FecIniSerEsp;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 6) {
             if (!scope.tmodal_servicio_especiales.EstSerEsp > 0) {
                 scope.toast('error','Debe Seleccionar un Estatus de la lista.','Estatus');
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                 $scope.predicate2 = predicate2;
             };
             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { EstSerEsp: scope.tmodal_servicio_especiales.EstSerEsp }, true);
             $scope.totalItems2 = scope.TServicioEspeciales.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.TServicioEspeciales.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.EstSerEsp;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.EstSerEsp;
         }
     };
     scope.regresar_filtro_servicio_especial = function() {
         scope.tmodal_servicio_especiales = {};
         scope.reporte_pdf_servicio_especiales = 0;
         scope.reporte_excel_servicio_especiales = 0;
         $scope.predicate3 = 'id';
         $scope.reverse3 = true;
         $scope.currentPage3 = 1;
         $scope.order3 = function(predicate3) {
             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
             $scope.predicate3 = predicate3;
         };
         scope.TServicioEspeciales = scope.TServicioEspecialesBack;
         $scope.totalItems3 = scope.TServicioEspeciales.length;
         $scope.numPerPage3 = 50;
         $scope.paginate3 = function(value3) {
             var begin3, end3, index3;
             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
             end3 = begin3 + $scope.numPerPage3;
             index3 = scope.TServicioEspeciales.indexOf(value3);
             return (begin3 <= index3 && index3 < end3);
         };
         console.log(scope.TServicioEspeciales);
     }
     scope.validarsifechaserespe = function(object, metodo) {
         if (object != undefined && metodo == 1) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.tmodal_servicio_especiales.FecIniSerEsp = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && metodo == 2) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecBloSerEsp = numero.substring(0, numero.length - 1);
         }
     }

     scope.validar_opcion_servicios_especiales = function(index, opciones_servicio_especiales, dato) {
         console.log(index);
         console.log(opciones_servicio_especiales);
         console.log(dato);
         scope.opciones_servicio_especiales[index] = undefined;
         if (opciones_servicio_especiales == 1) {
             if (dato.EstSerEsp == "ACTIVO") {
                 scope.toast('error','Este Servicio Especial ya se encuentra activo.','Activando');
                 return false;
             }
             Swal.fire({
                 title: 'Activando',
                 text: '¿Seguro que desea activar el Servicio Especial?',
                 type: "question",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: 'Confirmar'
             }).then(function(t) {
                 if (t.value == true) {
                     scope.cambiar_estatus_servicio_especial(opciones_servicio_especiales, dato.CodSerEsp, index);
                 } else {
                     console.log('Cancelando ando...');
                 }
             });
         }
         if (opciones_servicio_especiales == 2) {
             if (dato.EstSerEsp == "SUSPENDIDO") {
                 scope.toast('error','Este Servicio Especial ya se encuentra suspendido.','Suspendido');
                 return false;
             }
             scope.servicio_especial_bloqueo = {};
             scope.RazSocCom_BloSerEsp = dato.NumCifCom + " - " + dato.RazSocCom;
             scope.DesSerEsp_Blo = dato.DesSerEsp;
             scope.FecBloSerEsp = scope.Fecha_Server;
             $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloSerEsp);
             scope.servicio_especial_bloqueo.CodSerEsp = dato.CodSerEsp;
             scope.servicio_especial_bloqueo.EstSerEsp = opciones_servicio_especiales;
             $("#modal_motivo_bloqueo_servicio_especial").modal('show');
         }
         if (opciones_servicio_especiales == 3) {
             location.href = "#/Edit_Servicios_Adicionales/" + dato.CodSerEsp;
         }
         if (opciones_servicio_especiales == 4) {
             location.href = "#/Ver_Servicios_Adicionales/" + dato.CodSerEsp + "/" + 1;
         }
         if (opciones_servicio_especiales == 5) {
             location.href = "#/Comisiones_Servicios_Adicionales/" + dato.CodSerEsp + "/" + dato.NumCifCom + "/" + dato.RazSocCom + "/" + dato.DesSerEsp;
         }
     }

     scope.cambiar_estatus_servicio_especial = function(opciones_servicio_especiales, CodSerEsp, index) {
         scope.status_servicio_especial = {};
         scope.status_servicio_especial.EstSerEsp = opciones_servicio_especiales;
         scope.status_servicio_especial.CodSerEsp = CodSerEsp;

         if (opciones_servicio_especiales == 2) {
             scope.status_servicio_especial.MotBloSerEsp = scope.servicio_especial_bloqueo.MotBloSerEsp;
             scope.status_servicio_especial.ObsMotBloSerEsp = scope.servicio_especial_bloqueo.ObsMotBloSerEsp;
             scope.status_servicio_especial.FecBlo = scope.servicio_especial_bloqueo.FecBlo;
             console.log(scope.status_servicio_especial);
         }
         console.log(scope.status_servicio_especial);
         $("#estatus").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Comercializadora/cambiar_estatus_servicio_especial/";
         $http.post(url, scope.status_servicio_especial).then(function(result) {
             if (result.data.resultado != false) {
                 if (opciones_servicio_especiales == 1) {
                     var title = 'Activando';
                     var text = 'El Servicio Especial ha sido activado de forma correcta';
                 }
                 if (opciones_servicio_especiales == 2) {
                     var title = 'Suspender';
                     var text = 'El Servicio Especial ha sido suspendido de forma correcta';
                     $("#modal_motivo_bloqueo_servicio_especial").modal('hide');
                 }
                 $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 scope.toast('success',text,title);
                 scope.opciones_servicio_especiales[index] = undefined;
                 scope.cargar_lista_servicos_especiales();
             } else {
                 $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 scope.toast('error','Un error a ocurrido en el proceso de actualización del estatus.','Error');
                 scope.cargar_lista_servicos_especiales();
             }
         }, function(error) {
             $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

     $scope.submitFormlockServicioEspecial = function(event) {
         if (scope.servicio_especial_bloqueo.ObsMotBloSerEsp == undefined || scope.servicio_especial_bloqueo.ObsMotBloSerEsp == null || scope.servicio_especial_bloqueo.ObsMotBloSerEsp == '') {
             scope.servicio_especial_bloqueo.ObsMotBloSerEsp = null;
         } else {
             scope.servicio_especial_bloqueo.ObsMotBloSerEsp = scope.servicio_especial_bloqueo.ObsMotBloSerEsp;
         }
         var FecBloSerEsp1 = document.getElementById("FecBloSerEsp").value;
         scope.FecBloSerEsp = FecBloSerEsp1;
         if (scope.FecBloSerEsp == undefined || scope.FecBloSerEsp == null || scope.FecBloSerEsp == '') {
             scope.toast('error','La Fecha de suspensión es requerido.','Fecha de suspensión');
             return false;
         } else {
             var FecBlo = (scope.FecBloSerEsp).split("/");
             if (FecBlo.length < 3) {
                 scope.toast('error','El Formato de la Fecha de suspensión Debe Ser: ' + scope.Fecha_Server,'Fecha de suspensión');
                 return false;
             } else {
                 if (FecBlo[0].length > 2 || FecBlo[0].length < 2) {
                     scope.toast('error','El Formato Día la Fecha de suspensión Debe Ser EJ: 01','Fecha de suspensión');
                     return false;
                 }
                 if (FecBlo[1].length > 2 || FecBlo[1].length < 2) {
                     scope.toast('error','El Formato Mes la Fecha de suspensión Debe Ser EJ: 01','Fecha de suspensión');
                     return false;
                 }
                 if (FecBlo[2].length < 4 || FecBlo[2].length > 4) {
                     scope.toast('error','El Formato Año la Fecha de suspensión Debe Ser EJ: 1999','Fecha de suspensión');
                     return false;
                 }
                 valuesStart = scope.FecBloSerEsp.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de suspensión No Puede Ser Mayor a: " + scope.Fecha_Server + ' Por Favor verifique e intente nuevamente.','Fecha de suspensión');
                    return false;
                 }
                 scope.servicio_especial_bloqueo.FecBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
             }
         }
         console.log(scope.servicio_especial_bloqueo);
         Swal.fire({
             title: 'Suspendiendo',
             text: 'Estás Seguro de Suspender Este Servicio Especial?',
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: 'Suspender'
         }).then(function(t) {
             if (t.value == true) {
                 console.log(scope.servicio_especial_bloqueo);
                 scope.cambiar_estatus_servicio_especial(scope.servicio_especial_bloqueo.EstSerEsp, scope.servicio_especial_bloqueo.CodSerEsp);
             } else {
                 event.preventDefault();
                 console.log('Cancelando ando...');
             }
         });
     };

     $scope.submitFormServiciosEspeciales = function(event) {
         if (scope.servicio_especial.CodSerEsp == undefined) {
             //var titulo='Guardando_Anexo';
             var titulo = 'Guardando';
             var texto = 'Está seguro de registrar este nuevo registro';
             var response = 'Servicio Especial creado de forma correcta';
         } else {
             //var titulo='Actualizando_Anexo';
             var titulo = 'Actualizando';
             var texto = 'Está seguro de registrar este nuevo registro';
             var response = 'Servicio Especial modificado de forma correcta';
         }
         if (!scope.validar_campos_servicio_especial()) {
             return false;
         }
         console.log(scope.servicio_especial);
         Swal.fire({
             title: titulo,
             text: texto,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "OK"
         }).then(function(t) {
             if (t.value == true) {
                 $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                 var url = base_urlHome() + "api/Comercializadora/registrar_servicios_especiales/";
                 $http.post(url, scope.servicio_especial).then(function(result) {
                     scope.nIDSerEsp = result.data.CodSerEsp;
                     if (result.data != false) {
                        $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        scope.toast('success',response,titulo);
                        location.href = "#/Edit_Servicios_Adicionales/" + scope.nIDSerEsp;
                     } else {
                         $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         scope.toast('error','Un error a ocurrido durante el proceso, por favor intente nuevamente.','Error');
                    }

                 }, function(error) {
                     $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
             }
         });
     };
     scope.validar_campos_servicio_especial = function() {
         resultado = true;
         if (!scope.servicio_especial.CodCom > 0) {
             scope.toast('error','Debe Seleccionar una Comercializadora de la lista.','Comercializadora');
              return false;
         }
         if (scope.servicio_especial.DesSerEsp == null || scope.servicio_especial.DesSerEsp == undefined || scope.servicio_especial.DesSerEsp == '') {
             scope.toast('error','El Nombre del Servicio Especial Es requerido.','Servicio Especial');
             return false;
         }
         var FecIniSerEspForm1 = document.getElementById("FecIniSerEspForm").value;
         scope.FecIniSerEspForm = FecIniSerEspForm1;
         if (scope.FecIniSerEspForm == null || scope.FecIniSerEspForm == undefined || scope.FecIniSerEspForm == '') {
             scope.toast('error','La Fecha de Inicio es Requerida.','Fecha de Inicio');
             return false;
         } else {
             var FecIniSerEspForm = (scope.FecIniSerEspForm).split("/");
             if (FecIniSerEspForm.length < 3) {
                 scope.toast('error','El Formato de la Fecha de Inicio Debe Ser: ' + scope.Fecha_Server,'Fecha de Inicio');
                 return false;
             } else {
                 if (FecIniSerEspForm[0].length > 2 || FecIniSerEspForm[0].length < 2) {
                     scope.toast('error','El Formato del Día Debe Ser: EJ: 01','Fecha de Inicio');
                     return false;

                 }
                 if (FecIniSerEspForm[1].length > 2 || FecIniSerEspForm[1].length < 2) {
                     scope.toast('error','El Formato del Mes Debe Ser: EJ: 01','Fecha de Inicio');
                     return false;
                 }
                 if (FecIniSerEspForm[2].length < 4 || FecIniSerEspForm[2].length > 4) {
                     scope.toast('error','El Formato del Año Debe Ser: EJ: 1999','Fecha de Inicio');
                     return false;
                 }
                 var h1 = new Date();
                 var final = FecIniSerEspForm[2] + "/" + FecIniSerEspForm[1] + "/" + FecIniSerEspForm[0];
                 scope.servicio_especial.FecIniSerEspForm = final;
                 valuesStart = scope.FecIniSerEspForm.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de Inicio No Puede Ser Mayor a: " + scope.Fecha_Server + 'Por favor Verifique he intente nuevamente.','Fecha de Inicio');
                    return false;
                 }
             }
         }

         if (scope.servicio_especial.SerEle == false && scope.servicio_especial.SerGas == false) {
            scope.toast('error','Debe Seleccionar un Tipo de Suministro Eléctrico, Gas o Ambos.','Tipo de Suministros');
            return false;
         }
         if (scope.servicio_especial.SerEle == true) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length == 0 && scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length == 0 || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false && scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                 scope.toast('error','Debe Seleccionar un Tipo de Tensión Alta o Baja.','Tárifa Eléctrica');
                 return false;
             }
         }
         if (scope.servicio_especial.SerGas == true) {
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length == 0) {
                 scope.toast('error','Debe Seleccionar una Tarifa de Gas.','Tarifa Gas');
                 return false;
             }
         }
         if (!scope.servicio_especial.TipCli > 0) {
             scope.toast('error','Debe Seleccionar un Tipo de Cliente.','Tipo Clientes');
             return false;
         }
         if (scope.servicio_especial.CarSerEsp == null || scope.servicio_especial.CarSerEsp == undefined || scope.servicio_especial.CarSerEsp == '') {
            scope.toast('error','Caracteristicas.','Caracteristicas');
            return false;
         }
         if (!scope.servicio_especial.CodTipCom > 0) {
            scope.toast('error','Debe Seleccionar un Tipo de Comisión.','Comisión');
            return false;
         }
         if (scope.servicio_especial.OsbSerEsp == undefined || scope.servicio_especial.OsbSerEsp == null || scope.servicio_especial.OsbSerEsp == '') {
             scope.servicio_especial.OsbSerEsp = null;
         } else {
             scope.servicio_especial.OsbSerEsp = scope.servicio_especial.OsbSerEsp;
         }
         if (scope.servicio_especial.SerEle == false) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt;
             }

             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj;
             }
         } else {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length == 0 || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt;
             }

             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj;
             }
         }
         if (scope.servicio_especial.SerGas == false) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = scope.servicio_especial.T_DetalleServicioEspecialTarifaGas;
             }
         }

         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.limpiar_Servicio_Electrico_SerEsp = function(SerEle) {
         if (SerEle == false) {
             scope.servicio_especial.AggAllBaj = false;
             scope.disabled_all_baja_SerEsp = 0;
             scope.select_tarifa_Elec_Baj_SerEsp = [];
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];

             scope.disabled_all_alta_SerEsp = 0;
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
             scope.select_tarifa_Elec_Alt_SerEsp = [];
             scope.servicio_especial.AggAllAlt = false;

             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
         }
     }
     scope.limpiar_Servicio_Gas_SerEsp = function(SerGas) {
         if (SerGas == false) {
             scope.Todas_Gas_SerEsp = false;
             scope.disabled_all_SerEsp = 0;
             scope.servicio_especial.T_DetalleAnexoTarifaGas = [];
             scope.select_tarifa_gas_SerEsp = [];
             scope.servicio_especial.T_DetalleAnexoTarifaGas = [];
             console.log(scope.servicio_especial.T_DetalleAnexoTarifaGas);
         }
     }
     scope.validarfecini = function(object) {
         if (object != undefined) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecIniSerEspForm = numero.substring(0, numero.length - 1);

         }
         console.log(scope.FecIniSerEspForm);
     }
     scope.agregar_tarifa_elec_baja_SerEsp = function(index, CodTarEle, opcion_tension_baja) {
         console.log(index);
         console.log(opcion_tension_baja);
         console.log(CodTarEle);
         var ObjTarifaElecBaja = new Object();
         scope.select_tarifa_Elec_Baj_SerEsp[CodTarEle] = opcion_tension_baja;
         var ObjTarifaGas = new Object();
         if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false) {
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
         }
         scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({ CodTarEle: opcion_tension_baja.CodTarEle });
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
     }
     scope.quitar_tarifa_elec_baja_SerEsp = function(index, CodTarEle, opcion_tension_baja) {
         console.log(index);
         console.log(opcion_tension_baja);
         console.log(CodTarEle);
         scope.select_tarifa_Elec_Baj_SerEsp[CodTarEle] = false;
         i = 0;
         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; i++) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj[i].CodTarEle == CodTarEle) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.splice(i, 1);
             }
         }
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
     }
     scope.agregar_todas_baja_tension_SerEsp = function(full_datos, AggAllBaj) {
         console.log(full_datos);
         if (AggAllBaj == true) {
             scope.disabled_all_baja_SerEsp = 1;
             angular.forEach(scope.Tarifa_Elec_Baja, function(Tarifa_Elec_Baja) {

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj != false) {
                     if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length > 0) {
                         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; i++) {
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj[i].CodTarEle == Tarifa_Elec_Baja.CodTarEle) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.splice(i, 1);
                             }
                         }
                     }
                 }
                 var ObjTarifaGas = new Object();
                 scope.select_tarifa_Elec_Baj_SerEsp[Tarifa_Elec_Baja.CodTarEle] = Tarifa_Elec_Baja;

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false) {
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                 }
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({ CodTarEle: Tarifa_Elec_Baja.CodTarEle });
                 for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; index++) {
                     scope.servicio_especial[index] = index;
                 }
                 console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
             });
         } else {
             scope.disabled_all_baja_SerEsp = 0;
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
         }
     }
     scope.agregar_tarifa_elec_alta_SerEsp = function(index, CodTarEle, opcion_tension_alta) {
         console.log(index);
         console.log(CodTarEle);
         console.log(opcion_tension_alta);
         scope.select_tarifa_Elec_Alt_SerEsp[CodTarEle] = opcion_tension_alta;
         var ObjTarifaElecAlt = new Object();
         if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
         }
         scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({ CodTarEle: opcion_tension_alta.CodTarEle });
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
     }
     scope.quitar_tarifa_elec_alta_SerEsp = function(index, CodTarEle, opcion_tension_alta) {
         console.log(index);
         console.log(opcion_tension_alta);
         console.log(CodTarEle);
         scope.select_tarifa_Elec_Alt_SerEsp[CodTarEle] = false;
         i = 0;
         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; i++) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt[i].CodTarEle == CodTarEle) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.splice(i, 1);
             }
         }
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
     }
     scope.agregar_todas_alta_tension_SerEsp = function(full_datos, AggAllAlt) {
         console.log(full_datos);
         if (AggAllAlt == true) {
             scope.disabled_all_alta_SerEsp = 1;
             angular.forEach(scope.Tarifa_Elec_Alt, function(Tarifa_Elec_Alta) {
                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt != false) {
                     if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length > 0) {
                         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; i++) {
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt[i].CodTarEle == Tarifa_Elec_Alta.CodTarEle) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.splice(i, 1);
                             }
                         }
                     }
                 }
                 var ObjTarifaGas = new Object();
                 scope.select_tarifa_Elec_Alt_SerEsp[Tarifa_Elec_Alta.CodTarEle] = Tarifa_Elec_Alta;

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                 }
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({ CodTarEle: Tarifa_Elec_Alta.CodTarEle });
                 for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; index++) {
                     scope.servicio_especial[index] = index;
                 }
                 console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
             });
         } else {
             scope.disabled_all_alta_SerEsp = 0;
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
         }
     }
     scope.agregar_tarifa_gas_individual_SerEsp = function(index, dato, CodTarGas) {
         scope.select_tarifa_gas_SerEsp[CodTarGas] = dato;
         var ObjTarifaGasSerEsp = new Object();
         if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == false) {
             scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
         }
         scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.push({ CodTarGas: dato.CodTarGas });
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
     }
     scope.quitar_tarifa_gas_SerEsp = function(index, CodTarGas, tarifa_gas) {
         scope.select_tarifa_gas_SerEsp[CodTarGas] = false;
         i = 0;
         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; i++) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas[i].CodTarGas == CodTarGas) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.splice(i, 1);
             }
         }
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
     }
     scope.agregar_todas_detalle_SerEsp = function(valor) {
         if (valor == true) {
             scope.disabled_all_SerEsp = 1;
             angular.forEach(scope.Tarifa_Gas_Anexos, function(Tarifa) {
                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas != false) {
                     if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length > 0) {
                         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; i++) {
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas[i].CodTarGas == Tarifa.CodTarGas) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.splice(i, 1);
                             }
                         }
                     }
                 }
                 var ObjTarifaGas = new Object();
                 scope.select_tarifa_gas_SerEsp[Tarifa.CodTarGas] = Tarifa;

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == false) {
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                 }
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.push({ CodTarGas: Tarifa.CodTarGas });
                 for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; index++) {
                     scope.servicio_especial[index] = index;
                 }
                 console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
             });
         } else {
             scope.disabled_all_SerEsp = 0;
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
         }
     }

     scope.regresar_servicios_especiales = function() {
         if (scope.INF == undefined) {
             if (scope.servicio_especial.CodSerEsp == undefined) {
                 var title = 'Guardando';
                 var text = '¿Seguro que desea cerrar sin registrar el Servicio Especial?';
             } else {
                 var title = 'Actualizando';
                 var text = '¿Seguro que desea cerrar sin actualizar la información del Servicio Especial?';
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
                     //scope.TvistaServiciosEspeciales=1;
                     scope.servicio_especial = {};
                     scope.select_tarifa_Elec_Baj_SerEsp = [];
                     scope.select_tarifa_Elec_Alt_SerEsp = [];
                     scope.select_tarifa_gas_SerEsp = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                     scope.servicio_especial.SerGas = false;
                     scope.servicio_especial.SerEle = false;
                     scope.servicio_especial.AggAllBaj = false;
                     scope.servicio_especial.AggAllAlt = false;
                     location.href = "#/Servicios_Adicionales/";
                     //console.log(scope.TvistaServiciosEspeciales);	   
                 } else {
                     console.log('Cancelando ando...');
                 }
             });
         } else {
             location.href = "#/Servicios_Adicionales/";
         }
     }
     scope.buscarXIDServicioEspecial = function() {
         $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Comercializadora/Buscar_xID_ServicioEspecial/CodSerEsp/" + scope.nIDSerEsp;
         $http.get(url).then(function(result) {
             $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) { //scope.anexos=result.data;
                 scope.servicio_especial = {};
                 var index = 0;
                 scope.index = 0;
                 scope.servicio_especial.CodSerEsp = result.data.CodSerEsp;
                 scope.servicio_especial.CodCom = result.data.CodCom;
                 scope.servicio_especial.DesSerEsp = result.data.DesSerEsp;
                 scope.FecIniSerEspForm = result.data.FecIniSerEsp;
                 if (result.data.SerEle == "NO") {
                     scope.servicio_especial.SerEle = false;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                     scope.select_tarifa_Elec_Baj_SerEsp = [];
                     scope.select_tarifa_Elec_Alt_SerEsp = [];
                 } else {
                     scope.servicio_especial.SerEle = true;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                     scope.select_tarifa_Elec_Baj_SerEsp = [];
                     scope.select_tarifa_Elec_Alt_SerEsp = [];
                     angular.forEach(result.data.T_DetalleServicioEspecialTarifaEle, function(Tarifa_Electrica) {
                         if (Tarifa_Electrica.TipTen == 0) {
                             var ObjTarifaElecBaja = new Object();
                             scope.select_tarifa_Elec_Baj_SerEsp[Tarifa_Electrica.CodTarEle] = Tarifa_Electrica;
                             var ObjTarifaGas = new Object();
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                             }
                             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({ CodTarEle: Tarifa_Electrica.CodTarEle });
                             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
                         } else {
                             scope.select_tarifa_Elec_Alt_SerEsp[Tarifa_Electrica.CodTarEle] = Tarifa_Electrica;
                             var ObjTarifaElecAlt = new Object();
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                             }
                             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({ CodTarEle: Tarifa_Electrica.CodTarEle });
                             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
                         }
                     });
                 }
                 if (result.data.SerGas == "NO") {
                     scope.servicio_especial.SerGas = false;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                     scope.select_tarifa_gas_SerEsp = [];
                 } else {
                     scope.servicio_especial.SerGas = true;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                     scope.select_tarifa_gas_SerEsp = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = result.data.T_DetalleServicioEspecialTarifaGas;
                     angular.forEach(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas, function(select_tarifa_gas) {
                         scope.select_tarifa_gas_SerEsp[select_tarifa_gas.CodTarGas] = select_tarifa_gas;

                     });
                 }
                 scope.servicio_especial.TipCli = result.data.TipCli;
                 scope.servicio_especial.CarSerEsp = result.data.CarSerEsp;
                 scope.servicio_especial.CodTipCom = result.data.CodTipCom;
                 scope.servicio_especial.OsbSerEsp = result.data.OsbSerEsp;
                 scope.servicio_especial.AggAllBaj = false;
                 scope.servicio_especial.AggAllAlt = false;
                 scope.Todas_Gas_SerEsp = false;
                 scope.disabled_all_baja_SerEsp = 0;
                 scope.disabled_all_alta_SerEsp = 0;
                 scope.disabled_all_SerEsp = 0;
                 //console.log(result.data);
                 console.log(scope.servicio_especial);
             } else {
                 scope.toast('error','No hay información.','Error');
                 
             }
         }, function(error) {
             $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.fetchServiciosEspeciales = function() {
         if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             scope.TServicioEspeciales = scope.TServicioEspecialesBack;
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             scope.reporte_pdf_servicio_especiales = 0;
             scope.reporte_excel_servicio_especiales = 0;
         } else {
             if (scope.filtrar_search.length >= 1) {
                 scope.fdatos.filtrar_search = scope.filtrar_search;
                 var url = base_urlHome() + "api/Comercializadora/getServiciosEspecialesFilter";
                 $http.post(url, scope.fdatos).then(function(result) {
                     console.log(result.data);
                     if (result.data != false) {
                         $scope.predicate3 = 'id';
                         $scope.reverse3 = true;
                         $scope.currentPage3 = 1;
                         $scope.order3 = function(predicate3) {
                             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                             $scope.predicate3 = predicate3;
                         };
                         scope.TServicioEspeciales = result.data;
                         $scope.totalItems3 = scope.TServicioEspeciales.length;
                         $scope.numPerPage3 = 50;
                         $scope.paginate3 = function(value3) {
                             var begin3, end3, index3;
                             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                             end3 = begin3 + $scope.numPerPage3;
                             index3 = scope.TServicioEspeciales.indexOf(value3);
                             return (begin3 <= index3 && index3 < end3);
                         };
                         scope.reporte_pdf_servicio_especiales = 7 + "/" + scope.filtrar_search;
                         scope.reporte_excel_servicio_especiales = 7 + "/" + scope.filtrar_search;
                     } else {
                         scope.TServicioEspeciales=[];
                            scope.reporte_pdf_servicio_especiales = 0;
                         scope.reporte_excel_servicio_especiales = 0;
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
                $scope.predicate3 = 'id';
                         $scope.reverse3 = true;
                         $scope.currentPage3 = 1;
                         $scope.order3 = function(predicate3) {
                             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                             $scope.predicate3 = predicate3;
                         };
                         scope.TServicioEspeciales = scope.TServicioEspecialesBack;
                         $scope.totalItems3 = scope.TServicioEspeciales.length;
                         $scope.numPerPage3 = 50;
                         $scope.paginate3 = function(value3) {
                             var begin3, end3, index3;
                             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                             end3 = begin3 + $scope.numPerPage3;
                             index3 = scope.TServicioEspeciales.indexOf(value3);
                             return (begin3 <= index3 && index3 < end3);
                         };
                         scope.reporte_pdf_servicio_especiales = 0;
                         scope.reporte_excel_servicio_especiales = 0;
             }
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
     if (scope.nIDSerEsp != undefined) {
         scope.buscarXIDServicioEspecial();
     }
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES END ////////////////////////////////////////////////////////
 }