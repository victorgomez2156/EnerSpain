app.controller('Controlador_Anexos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceAnexos', 'upload', Controlador])
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

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceAnexos, upload) {
    var scope = this;
    scope.fdatos = {};
    scope.anexos = {};
    scope.nIDAnexos = $route.current.params.ID;
    scope.INF = $route.current.params.INF;
    scope.Nivel = $cookies.get('nivel');
    const $archivosanexos = document.querySelector("#file_anexo");
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
    console.log($route.current.$$route.originalPath);
    //////////////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE ANEXOS START ////////////////////////////////////////////////////////
    scope.TAnexos = [];
    scope.TAnexosBack = [];

    scope.tmodal_anexos = {};
    scope.reporte_pdf_anexos = 0;
    scope.reporte_excel_anexos = 0;
    scope.NumCifCom = true;
    scope.RazSocCom = true;
    scope.CodAneTPro = true;
    scope.DesAnePro = true;
    scope.SerGasAne = true;
    scope.SerTEleAne = true;
    scope.TipPreAne = true;
    scope.CodTipComAne = true;
    scope.FecIniAne = true;
    scope.EstAne = true;
    scope.AccTAne = true;
    scope.ttipofiltrosAnexos = [{ id: 1, nombre: 'Comercializadora' }, { id: 2, nombre: 'Productos' }, { id: 3, nombre: 'Tipo de Suministro' }, { id: 4, nombre: 'Tipo de Comisión' }, { id: 5, nombre: 'Fecha de Inicio' }, { id: 6, nombre: 'Estatus' }];
    scope.Topciones_Grib = [{ id: 4, nombre: 'Ver' }, { id: 3, nombre: 'Editar' }, { id: 1, nombre: 'Activar' }, { id: 2, nombre: 'Bloquear' }, { id: 5, nombre: 'Comisiones' }];
    scope.comisiones = false;
    scope.anexos.SerEle = false;
    scope.anexos.SerGas = false;
    scope.anexos.Fijo = false;
    scope.anexos.Indexado = false;
    scope.select_tarifa_Elec_Baj = [];
    scope.select_tarifa_Elec_Alt = [];
    scope.select_tarifa_gas = [];
    scope.TProComercializadoras = [];
    scope.TProductosActivos = [];
    scope.Tipos_Comision = [];
    scope.Tcomercializadoras = [];
    scope.TProductos = [];
    scope.Tarifa_Gas_Anexos = [];
    scope.Tarifa_Ele_Anexos = [];
    scope.Tarifa_Elec_Baja = [];
    scope.Tarifa_Elec_Alt = [];
    scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
    scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
    scope.anexos.T_DetalleAnexoTarifaGas = [];
    scope.validate_info_anexos = scope.INF;
    ServiceAnexos.getAll().then(function(dato) {
        
        scope.Tcomercializadoras=dato.Comercializadora;
        scope.TProductos=dato.Productos;
        scope.Tipos_Comision=dato.TiPCom;
        scope.Fecha_Server = dato.fecha;
        if (scope.nIDAnexos == undefined) {
            scope.FecIniAneA = dato.fecha;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniAneA);
        }
        if(dato.Anexos==false)
        {
            scope.TAnexos = [];
            scope.TAnexosBack = [];
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
            scope.TAnexos = dato.Anexos;
            scope.TAnexosBack = dato.Anexos;
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
        }
        if($route.current.$$route.originalPath!="Anexos")
        {
            scope.Tarifa_Gas_Anexos = dato.Tarifa_Gas;
            scope.Tarifa_Ele_Anexos = dato.Tarifa_Ele;        
            angular.forEach(scope.Tarifa_Ele_Anexos, function(Tarifa_Electrica) {
                if (Tarifa_Electrica.TipTen == 'BAJA') {
                    var ObjTarifaElecBaj = new Object();
                    if (scope.Tarifa_Elec_Baja == undefined || scope.Tarifa_Elec_Baja == false) {
                        scope.Tarifa_Elec_Baja = [];
                    }
                    scope.Tarifa_Elec_Baja.push({ TipTen: Tarifa_Electrica.TipTen, NomTarEle: Tarifa_Electrica.NomTarEle, MinPotCon: Tarifa_Electrica.MinPotCon, MaxPotCon: Tarifa_Electrica.MaxPotCon, CodTarEle: Tarifa_Electrica.CodTarEle, CanPerTar: Tarifa_Electrica.CanPerTar });
                    console.log(scope.Tarifa_Elec_Baja);
                } else {
                    var ObjTarifaElecAlt = new Object();
                    if (scope.Tarifa_Elec_Alt == undefined || scope.Tarifa_Elec_Alt == false) {
                        scope.Tarifa_Elec_Alt = [];
                    }
                    scope.Tarifa_Elec_Alt.push({ TipTen: Tarifa_Electrica.TipTen, NomTarEle: Tarifa_Electrica.NomTarEle, MinPotCon: Tarifa_Electrica.MinPotCon, MaxPotCon: Tarifa_Electrica.MaxPotCon, CodTarEle: Tarifa_Electrica.CodTarEle, CanPerTar: Tarifa_Electrica.CanPerTar });
                    console.log(scope.Tarifa_Elec_Alt);
                }
            });
        }        



        /*scope.TProComercializadoras = dato.Comercializadora;
        scope.TProductosActivos = dato.Productos;
        scope.Tipos_Comision = dato.Tipos_Comision;
        scope.Tcomercializadoras = dato.Comercializadora;
        scope.TProductos = dato.Productos;               
        
        
       */
    }).catch(function(error) {
        console.log(error); //Tratar el error
        /*if(error.status==false && error.error=="This API key does not have access to the requested controller.")
        {
        	Swal.fire({title:"Error 401.",text:$translate('NO_FOUND1'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Unknown method.")
        {
        	Swal.fire({title:"Error 404.",text:$translate('NO_FOUND'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Unauthorized")
        {
        	Swal.fire({title:"Error 401.",text:$translate('UNAUTHORIZED'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Invalid API Key.")
        {
        	Swal.fire({title:"Error 403.",text:$translate('FORBIDDEN'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Internal Server Error")
        {
        	Swal.fire({title:"Error 500",text:$translate('INTERNAL_ERROR'),type:"error",confirmButtonColor:"#188ae2"});
        }*/
    });
    scope.validarsifechaanexos = function(object, metodo) {
        if (object != undefined && metodo == 1) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.tmodal_anexos.FecIniAne = numero.substring(0, numero.length - 1);
        }
        if (object != undefined && metodo == 2) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.FecBloAne = numero.substring(0, numero.length - 1);
        }
    }
    $scope.SubmitFormFiltrosAnexos = function(event) {
        if (scope.tmodal_anexos.ttipofiltrosAnexos == 1) {
            if (!scope.tmodal_anexos.CodCom > 0) {
                Swal.fire({ title: 'Comercializadora', text: 'Seleccione una Comercializadora del listado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            scope.TAnexos = $filter('filter')(scope.TAnexosBack, { NumCifCom: scope.tmodal_anexos.CodCom }, true);
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            console.log(scope.TAnexos);
            scope.reporte_pdf_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.CodCom;
            scope.reporte_excel_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.CodCom;
        }
        if (scope.tmodal_anexos.ttipofiltrosAnexos == 2) {
            if (!scope.tmodal_anexos.DesPro > 0) {
                Swal.fire({ title: "Productos", text: 'Seleccione un Producto del listado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            scope.TAnexos = $filter('filter')(scope.TAnexosBack, { DesPro: scope.tmodal_anexos.DesPro }, true);
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            console.log(scope.TAnexos);
            scope.reporte_pdf_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.DesPro;
            scope.reporte_excel_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.DesPro;
        }
        if (scope.tmodal_anexos.ttipofiltrosAnexos == 3) {
            if (!scope.tmodal_anexos.TipServ > 0) {
                Swal.fire({ title: "Tipos de Suministro", text: 'Seleccione un Tipo de Suministro del listado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (!scope.tmodal_anexos.Select > 0) {
                Swal.fire({ title: "Error", text: 'Seleccione un Anexo del listado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            if (scope.tmodal_anexos.TipServ == 1) {
                scope.Servicio = "GAS";
                scope.TAnexos = $filter('filter')(scope.TAnexosBack, { SerGas: scope.tmodal_anexos.Select }, true);
            }
            if (scope.tmodal_anexos.TipServ == 2) {
                scope.Servicio = "ELÉCTRICO";
                scope.TAnexos = $filter('filter')(scope.TAnexosBack, { SerEle: scope.tmodal_anexos.Select }, true);
            }
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            console.log(scope.TAnexos);
            scope.reporte_pdf_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.Servicio + "/" + scope.tmodal_anexos.Select;
            scope.reporte_excel_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.Servicio + "/" + scope.tmodal_anexos.Select;
        }
        if (scope.tmodal_anexos.ttipofiltrosAnexos == 4) {
            if (!scope.tmodal_anexos.DesTipCom > 0) {
                Swal.fire({ title: "Tipo de Comisión", text: 'Seleccione una Comisión del listado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            scope.TAnexos = $filter('filter')(scope.TAnexosBack, { DesTipCom: scope.tmodal_anexos.DesTipCom }, true);
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            console.log(scope.TAnexos);
            scope.reporte_pdf_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.DesTipCom;
            scope.reporte_excel_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.DesTipCom;
        }
        if (scope.tmodal_anexos.ttipofiltrosAnexos == 5) {
            var FecIniAne1 = document.getElementById("FecIniAne").value;
            scope.tmodal_anexos.FecIniAne = FecIniAne1;
            if (scope.tmodal_anexos.FecIniAne == undefined || scope.tmodal_anexos.FecIniAne == null || scope.tmodal_anexos.FecIniAne == "") {
                Swal.fire({ title: 'Fecha de Inicio', text: 'La Fecha de Inicio es requerida', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            } else {

                var FecIniAne = (scope.tmodal_anexos.FecIniAne).split("/");
                if (FecIniAne.length < 3) {
                    Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Fecha de Inicio, el formato debe ser DD/MM/YYYY', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                } else {
                    if (FecIniAne[0].length > 2 || FecIniAne[0].length < 2) {
                        Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;

                    }
                    if (FecIniAne[1].length > 2 || FecIniAne[1].length < 2) {
                        Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    if (FecIniAne[2].length < 4 || FecIniAne[2].length > 4) {
                        Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Año, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                }
            }
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            scope.TAnexos = $filter('filter')(scope.TAnexosBack, { FecIniAne: scope.tmodal_anexos.FecIniAne }, true);
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            console.log(scope.TAnexos);
            scope.reporte_pdf_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.FecIniAne;
            scope.reporte_excel_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.FecIniAne;
        }
        if (scope.tmodal_anexos.ttipofiltrosAnexos == 6) {
            if (!scope.tmodal_anexos.EstAne > 0) {
                Swal.fire({ title: "Estatus", text: 'Seleccione Estatus del listado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            scope.TAnexos = $filter('filter')(scope.TAnexosBack, { EstAne: scope.tmodal_anexos.EstAne }, true);
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            console.log(scope.TAnexos);
            scope.reporte_pdf_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.EstAne;
            scope.reporte_excel_anexos = scope.tmodal_anexos.ttipofiltrosAnexos + "/" + scope.tmodal_anexos.EstAne;
        }
    };
    scope.quitar_filtro_anexos = function() {
        scope.tmodal_anexos = {};
        $scope.predicate2 = 'id';
        $scope.reverse2 = true;
        $scope.currentPage2 = 1;
        $scope.order2 = function(predicate2) {
            $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
            $scope.predicate2 = predicate2;
        };
        scope.TAnexos = scope.TAnexosBack;
        $scope.totalItems2 = scope.TAnexos.length;
        $scope.numPerPage2 = 50;
        $scope.paginate2 = function(value2) {
            var begin2, end2, index2;
            begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
            end2 = begin2 + $scope.numPerPage2;
            index2 = scope.TAnexos.indexOf(value2);
            return (begin2 <= index2 && index2 < end2);
        };
        scope.reporte_pdf_anexos = 0;
        scope.reporte_excel_anexos = 0;
        console.log(scope.TAnexos);
    }

    scope.cargar_lista_anexos = function() {
        $("#List_Anex").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Comercializadora/get_list_anexos/";
        $http.get(url).then(function(result) {
            $("#List_Anex").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate2 = 'id';
                $scope.reverse2 = true;
                $scope.currentPage2 = 1;
                $scope.order2 = function(predicate2) {
                    $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                    $scope.predicate2 = predicate2;
                };
                scope.TAnexos = result.data;
                scope.TAnexosBack = result.data;
                $scope.totalItems2 = scope.TAnexos.length;
                $scope.numPerPage2 = 50;
                $scope.paginate2 = function(value2) {
                    var begin2, end2, index2;
                    begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                    end2 = begin2 + $scope.numPerPage2;
                    index2 = scope.TAnexos.indexOf(value2);
                    return (begin2 <= index2 && index2 < end2);
                };
            } else {
                Swal.fire({ title: 'Anexos', text: 'No hay Anexos registrados', type: "info", confirmButtonColor: "#188ae2" });
                scope.TAnexos = [];
                scope.TAnexosBack = [];
            }
        }, function(error) {
            $("#List_Anex").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }

    scope.validar_opcion_anexos = function(index, opciones_anexos, dato) {
        console.log(index);
        console.log(opciones_anexos);
        console.log(dato);
        scope.opciones_anexos[index] = undefined;
        if (opciones_anexos == 1) {
            if (dato.EstAne == 'ACTIVO') {
                Swal.fire({ title: 'Activando', text: 'El Anexo ya se encuentra Activo', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            Swal.fire({
                title: 'Activando',
                text: "¿Seguro que desea Activar el Anexo?",
                type: "info",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.cambiar_estatus_anexos(opciones_anexos, dato.CodAnePro, index);
                } else {
                    console.log('Cancelando ando...');
                }
            });
        }
        if (opciones_anexos == 2) {
            scope.t_modal_data = {};
            if (dato.EstAne == 'BLOQUEADO') {
                Swal.fire({ title: "Bloqueado", text: 'El Anexo ya se encuentra Bloqueado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.anexos_motivo_bloqueos = {};
            scope.RazSocCom_BloAne = dato.NumCifCom + " - " + dato.RazSocCom;
            scope.DesPro_BloAne = dato.DesPro;
            scope.DesAnePro_BloAne = dato.DesAnePro;
            scope.FecBloAne = scope.Fecha_Server;
            $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloAne);
            scope.anexos_motivo_bloqueos.CodAnePro = dato.CodAnePro;
            scope.anexos_motivo_bloqueos.EstAne = opciones_anexos;
            $("#modal_motivo_bloqueo_anexos").modal('show');
        }
        if (opciones_anexos == 3) {
            location.href = "#/Edit_Anexos/" + dato.CodAnePro;
        }
        if (opciones_anexos == 4) {
            location.href = "#/Ver_Anexos/" + dato.CodAnePro + "/" + 1;
        }
        if (opciones_anexos == 5) {
            location.href = "#/Comisiones_Anexos/" + dato.CodAnePro + "/" + dato.NumCifCom + "/" + dato.RazSocCom + "/" + dato.DesPro + "/" + dato.DesAnePro;
        }
    }
    $scope.submitFormlockAnexos = function(event) {
        if (scope.anexos_motivo_bloqueos.ObsMotBloAne == undefined || scope.anexos_motivo_bloqueos.ObsMotBloAne == null || scope.anexos_motivo_bloqueos.ObsMotBloAne == '') {
            scope.anexos_motivo_bloqueos.ObsMotBloAne = null;
        } else {
            scope.anexos_motivo_bloqueos.ObsMotBloAne = scope.anexos_motivo_bloqueos.ObsMotBloAne;
        }
        var FecBloAne = document.getElementById("FecBloAne").value;
        scope.FecBloAne = FecBloAne;
        if (scope.FecBloAne == undefined || scope.FecBloAne == null || scope.FecBloAne == '') {
            Swal.fire({ title: "Fecha de Bloqueo", text: 'La Fecha de Bloqueo es requerida', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecBlo = (scope.FecBloAne).split("/");
            if (FecBlo.length < 3) {
                Swal.fire({ title: "Fecha de Bloqueo", text: "Error en Fecha de Bloqueo, el formato correcto es DD/MM/YYYY" + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecBlo[0].length > 2 || FecBlo[0].length < 2) {
                    Swal.fire({ title: "Fecha de Bloqueo", text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBlo[1].length > 2 || FecBlo[1].length < 2) {
                    Swal.fire({ title: "Fecha de Bloqueo", text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBlo[2].length < 4 || FecBlo[2].length > 4) {
                    Swal.fire({ title: "Fecha de Bloqueo", text: 'Error en Año, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecBloAne.split("/");
                valuesEnd = scope.Fecha_Server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ title: "Fecha de Bloqueo", text: "La Fecha de Bloqueo no debe ser mayor a" + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.t_modal_data.FecBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
            }
        }
        Swal.fire({
            title: "Bloqueado",
            text: '¿Seguro de bloquear el Anexo?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Bloquear'
        }).then(function(t) {
            if (t.value == true) {
                console.log(scope.t_modal_data);
                scope.cambiar_estatus_anexos(scope.anexos_motivo_bloqueos.EstAne, scope.anexos_motivo_bloqueos.CodAnePro);
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };

    scope.cambiar_estatus_anexos = function(opciones_anexos, CodAnePro, index) {
        scope.status_anexos = {};
        scope.status_anexos.EstAne = opciones_anexos;
        scope.status_anexos.CodAnePro = CodAnePro;

        if (opciones_anexos == 2) {
            scope.status_anexos.MotBloAne = scope.anexos_motivo_bloqueos.MotBloAne;
            scope.status_anexos.ObsMotBloAne = scope.anexos_motivo_bloqueos.ObsMotBloAne;
            scope.status_anexos.FecBlo = scope.t_modal_data.FecBlo;
            console.log(scope.status_anexos);
        }
        console.log(scope.status_anexos);
        $("#estatus").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/cambiar_estatus_anexos/";
        $http.post(url, scope.status_anexos).then(function(result) {
            if (result.data.resultado != false) {
                if (opciones_anexos == 1) {
                    var title = 'Activando';
                    var text = 'Anexo activado de forma correcta';
                }
                if (opciones_anexos == 2) {
                    var title = 'Bloquando';
                    var text = 'Anexo bloqueado de forma correcta';
                    $("#modal_motivo_bloqueo_anexos").modal('hide');
                }

                $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: title, text: text, type: "success", confirmButtonColor: "#188ae2" });
                scope.opciones_anexos[index] = undefined;
                scope.cargar_lista_anexos();
            } else {
                $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: 'Error actualizando estatus del Anexo', type: "error", confirmButtonColor: "#188ae2" });
                scope.cargar_lista_anexos();
            }

        }, function(error) {
            $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.filtrar_productos_com = function() {
        scope.TProductosActivosFiltrados = $filter('filter')(scope.TProductos, { CodCom: scope.anexos.CodTProCom }, true);
        console.log(scope.TProductosActivosFiltrados);
        if ($route.current.$$route.originalPath == "/Ver_Anexos/:ID/:INF" || $route.current.$$route.originalPath == "/Edit_Anexos/:ID") {
            scope.contador = 0;
            scope.contador = scope.contador + 1;
        }
        if (scope.contador == 1) {
            $interval.cancel(promise);
        }
    }
    scope.validarFecIni = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.FecIniAneA = numero.substring(0, numero.length - 1);
        }
    }

    scope.limpiar_Servicio_Electrico = function(SerEle) {
        if (SerEle == false) {
            scope.anexos.AggAllBaj = false;
            scope.anexos.AggAllAlt = false;
            scope.disabled_all_baja = 0;
            scope.disabled_all_alta = 0;
            scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
            scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
            scope.select_tarifa_Elec_Alt = [];
            scope.select_tarifa_Elec_Baj = [];
            console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
            console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
        }
    }
    scope.limpiar_Servicio_Gas = function(SerGas) {
        if (SerGas == false) {
            scope.Todas_Gas = false;
            scope.disabled_all = 0;
            scope.anexos.T_DetalleAnexoTarifaGas = [];
            scope.select_tarifa_gas = [];
            scope.anexos.T_DetalleAnexoTarifaGas = [];
            console.log(scope.anexos.T_DetalleAnexoTarifaGas);
        }
    }

    $scope.submitFormAnexos = function(event) {
        if (scope.anexos.CodAnePro == undefined) {
            var titulo = 'Guardando_Anexo';
            var titulo2 = 'Guardando';
            var texto = '¿Seguro de grabar el Anexo?';
            var response = 'Anexo registrado de forma correcta';
        } else {
            var titulo = 'Actualizando_Anexo';
            var titulo2 = 'Actualizando';
            var texto = '¿Seguro de actualizar el Anexo?';;
            var response = 'Anexo modificado de forma correcta';
        }
        if (!scope.validar_campos_anexos()) {
            return false;
        }
        let archivos_anexos2 = $archivosanexos.files;
        //console.log($archivosanexos.files);
        //console.log(archivos_anexos2);
        if ($archivosanexos.files.length > 0) {
            //console.log($archivosanexos.files);
            if ($archivosanexos.files[0].type == "application/pdf") {
                console.log('Fichero correcto');
                var tipo_file = ($archivosanexos.files[0].type).split("/");
                $archivosanexos.files[0].type;
                //console.log(tipo_file[1]);		 		
                $scope.uploadFileAnexo();
                scope.anexos.DocAnePro = 'documentos/' + $archivosanexos.files[0].name;
            } else {
                //console.log('Fichero no Permitido');
                Swal.fire({ title: 'Error', text: 'Error en fichero, el formato debe ser PDF', type: "error", confirmButtonColor: "#188ae2" });
                scope.anexos.DocAnePro = null;
                document.getElementById('file_anexo').value = '';
                return false;
            }
        } else {
            scope.anexos.DocAnePro = null;
        }

        if (scope.anexos.SerEle == false) {
            if (scope.anexos.T_DetalleAnexoTarifaElecAlt.length == 0) {
                scope.anexos.T_DetalleAnexoTarifaElecAlt = false;
            } else {
                scope.anexos.T_DetalleAnexoTarifaElecAlt = scope.anexos.T_DetalleAnexoTarifaElecAlt;
            }

            if (scope.anexos.T_DetalleAnexoTarifaElecBaj.length == 0) {
                scope.anexos.T_DetalleAnexoTarifaElecBaj = false;
            } else {
                scope.anexos.T_DetalleAnexoTarifaElecBaj = scope.anexos.T_DetalleAnexoTarifaElecBaj;
            }
        } else {
            if (scope.anexos.T_DetalleAnexoTarifaElecAlt.length == 0 || scope.anexos.T_DetalleAnexoTarifaElecAlt == false) {
                scope.anexos.T_DetalleAnexoTarifaElecAlt = false;
            } else {
                scope.anexos.T_DetalleAnexoTarifaElecAlt = scope.anexos.T_DetalleAnexoTarifaElecAlt;
            }

            if (scope.anexos.T_DetalleAnexoTarifaElecBaj.length == 0) {
                scope.anexos.T_DetalleAnexoTarifaElecBaj = false;
            } else {
                scope.anexos.T_DetalleAnexoTarifaElecBaj = scope.anexos.T_DetalleAnexoTarifaElecBaj;
            }
        }
        if (scope.anexos.SerGas == false) {
            if (scope.anexos.T_DetalleAnexoTarifaGas.length == 0) {
                scope.anexos.T_DetalleAnexoTarifaGas = false;
            } else {
                scope.anexos.T_DetalleAnexoTarifaGas = scope.anexos.T_DetalleAnexoTarifaGas;
            }
        }
        console.log(scope.anexos);
        Swal.fire({
            title: titulo2,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK!"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo2).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercializadora/registrar_anexos/";
                $http.post(url, scope.anexos).then(function(result) {
                    $("#" + titulo2).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.nIDAnexos = result.data.CodAnePro;
                    if (result.data != false) {
                        Swal.fire({ title: titulo2, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        document.getElementById('file_anexo').value = '';
                        $('#filenameDocAnexo').html('');
                        location.href = "#/Edit_Anexos/" + scope.nIDAnexos;
                    } else {
                        Swal.fire({ title: "Error", text: "No se ha completado la operación, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#" + titulo2).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    };

    scope.validar_campos_anexos = function() {
        resultado = true;
        if (!scope.anexos.CodTProCom > 0) {
            Swal.fire({ title: 'Comercializadora', text: 'Seleccione una Comercializadora del listado', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.anexos.CodPro > 0) {
            Swal.fire({ title: 'Productos', text: 'Seleccione un Producto del listado', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.anexos.DesAnePro == null || scope.anexos.DesAnePro == undefined || scope.anexos.DesAnePro == '') {
            Swal.fire({ title: 'Anexos', text: 'El Nombre del Anexo es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        var FecIniAneA1 = document.getElementById("FecIniAneA").value;
        scope.FecIniAneA = FecIniAneA1;
        if (scope.FecIniAneA == null || scope.FecIniAneA == undefined || scope.FecIniAneA == '') {
            Swal.fire({ title: 'Fecha de Inicio', text: 'La Fecha de Inicio es requerida', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecIniAneA = (scope.FecIniAneA).split("/");
            if (FecIniAneA.length < 3) {
                Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Fecha de Inicio, el formato correcto es DD/MM/YYYY', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecIniAneA[0].length > 2 || FecIniAneA[0].length < 2) {
                    Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;

                }
                if (FecIniAneA[1].length > 2 || FecIniAneA[1].length < 2) {
                    Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecIniAneA[2].length < 4 || FecIniAneA[2].length > 4) {
                    Swal.fire({ title: 'Fecha de Inicio', text: 'Error en Día, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecIniAneA.split("/");
                valuesEnd = scope.Fecha_Server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ title: 'Fecha de Inicio', text: 'La Fecha de Inicio no puede ser mayor a ' + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.anexos.FecIniAneA = valuesStart[2] + "/" + valuesStart[1] + "/" + valuesStart[0];
            }

        }

        if (scope.anexos.SerEle == false && scope.anexos.SerGas == false) {
            Swal.fire({ title: 'Tipos de Suministro', text: 'Seleccione un Tipo de Suministro', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.anexos.SerEle == true) {
            if (scope.anexos.T_DetalleAnexoTarifaElecBaj.length == 0 && scope.anexos.T_DetalleAnexoTarifaElecAlt.length == 0 || scope.anexos.T_DetalleAnexoTarifaElecBaj == false && scope.anexos.T_DetalleAnexoTarifaElecAlt == false) {
                Swal.fire({ title: 'Suministro Eléctrico', text: 'Seleccione Tarifa Eléctrica', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        if (scope.anexos.SerGas == true) {
            console.log(scope.anexos.T_DetalleAnexoTarifaGas);
            if (scope.anexos.T_DetalleAnexoTarifaGas.length == 0) {
                Swal.fire({ title: 'Suministro Gas', text: 'Seleccione Tarifa de Gas', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        if (scope.anexos.Fijo == false && scope.anexos.Indexado == false) {
            Swal.fire({ title: 'Tipo de Precio', text: 'Seleccione Tipo de Precio', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.anexos.CodTipCom > 0) {
            Swal.fire({ title: 'Comisión', text: 'Seleccione Comisión del listado', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.anexos.ObsAnePro == undefined || scope.anexos.ObsAnePro == null || scope.anexos.ObsAnePro == '') {
            scope.anexos.ObsAnePro = null;
        } else {
            scope.anexos.ObsAnePro = scope.anexos.ObsAnePro;
        }

        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.agregar_tarifa_elec_baja = function(index, CodTarEle, opcion_tension_baja) {
        console.log(index);
        console.log(opcion_tension_baja);
        console.log(CodTarEle);
        var ObjTarifaElecBaja = new Object();
        scope.select_tarifa_Elec_Baj[CodTarEle] = opcion_tension_baja;
        if (scope.anexos.T_DetalleAnexoTarifaElecBaj == undefined || scope.anexos.T_DetalleAnexoTarifaElecBaj == false) {
            scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
        }
        scope.anexos.T_DetalleAnexoTarifaElecBaj.push({ CodTarEle: opcion_tension_baja.CodTarEle });
        console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
    }
    scope.quitar_tarifa_elec_baja = function(index, CodTarEle, opcion_tension_baja) {
        console.log(index);
        console.log(opcion_tension_baja);
        console.log(CodTarEle);
        scope.select_tarifa_Elec_Baj[CodTarEle] = false;
        i = 0;
        for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecBaj.length; i++) {
            if (scope.anexos.T_DetalleAnexoTarifaElecBaj[i].CodTarEle == CodTarEle) {
                scope.anexos.T_DetalleAnexoTarifaElecBaj.splice(i, 1);
            }
        }
        console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
    }
    scope.agregar_todas_baja_tension = function(full_datos, AggAllBaj) {
        console.log(full_datos);
        if (AggAllBaj == true) {
            scope.disabled_all_baja = 1;
            angular.forEach(scope.Tarifa_Elec_Baja, function(Tarifa_Elec_Baja) {

                if (scope.anexos.T_DetalleAnexoTarifaElecBaj != false) {
                    if (scope.anexos.T_DetalleAnexoTarifaElecBaj.length > 0) {
                        for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecBaj.length; i++) {
                            if (scope.anexos.T_DetalleAnexoTarifaElecBaj[i].CodTarEle == Tarifa_Elec_Baja.CodTarEle) {
                                scope.anexos.T_DetalleAnexoTarifaElecBaj.splice(i, 1);
                            }
                        }
                    }
                }
                var ObjTarifaGas = new Object();
                scope.select_tarifa_Elec_Baj[Tarifa_Elec_Baja.CodTarEle] = Tarifa_Elec_Baja;

                if (scope.anexos.T_DetalleAnexoTarifaElecBaj == undefined || scope.anexos.T_DetalleAnexoTarifaElecBaj == false) {
                    scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
                }
                scope.anexos.T_DetalleAnexoTarifaElecBaj.push({ CodTarEle: Tarifa_Elec_Baja.CodTarEle });
                for (var index = 0; index <= scope.anexos.T_DetalleAnexoTarifaElecBaj.length; index++) {
                    scope.anexos[index] = index;
                }
                console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
            });
        } else {
            scope.disabled_all_baja = 0;
            console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
        }
    }
    scope.agregar_tarifa_elec_alta = function(index, CodTarEle, opcion_tension_alta) {
        console.log(index);
        console.log(CodTarEle);
        console.log(opcion_tension_alta);
        scope.select_tarifa_Elec_Alt[CodTarEle] = opcion_tension_alta;
        var ObjTarifaElecAlt = new Object();
        if (scope.anexos.T_DetalleAnexoTarifaElecAlt == undefined || scope.anexos.T_DetalleAnexoTarifaElecAlt == false) {
            scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
        }
        scope.anexos.T_DetalleAnexoTarifaElecAlt.push({ CodTarEle: opcion_tension_alta.CodTarEle });
        console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
    }
    scope.quitar_tarifa_elec_alta = function(index, CodTarEle, opcion_tension_alta) {
        console.log(index);
        console.log(opcion_tension_alta);
        console.log(CodTarEle);
        scope.select_tarifa_Elec_Alt[CodTarEle] = false;
        i = 0;
        for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecAlt.length; i++) {
            if (scope.anexos.T_DetalleAnexoTarifaElecAlt[i].CodTarEle == CodTarEle) {
                scope.anexos.T_DetalleAnexoTarifaElecAlt.splice(i, 1);
            }
        }
        console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
    }
    scope.agregar_todas_alta_tension = function(full_datos, AggAllAlt) {
        console.log(full_datos);
        if (AggAllAlt == true) {
            scope.disabled_all_alta = 1;
            angular.forEach(scope.Tarifa_Elec_Alt, function(Tarifa_Elec_Alta) {
                if (scope.anexos.T_DetalleAnexoTarifaElecAlt != false) {
                    if (scope.anexos.T_DetalleAnexoTarifaElecAlt.length > 0) {
                        for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecAlt.length; i++) {
                            if (scope.anexos.T_DetalleAnexoTarifaElecAlt[i].CodTarEle == Tarifa_Elec_Alta.CodTarEle) {
                                scope.anexos.T_DetalleAnexoTarifaElecAlt.splice(i, 1);
                            }
                        }
                    }
                }
                var ObjTarifaGas = new Object();
                scope.select_tarifa_Elec_Alt[Tarifa_Elec_Alta.CodTarEle] = Tarifa_Elec_Alta;

                if (scope.anexos.T_DetalleAnexoTarifaElecAlt == undefined || scope.anexos.T_DetalleAnexoTarifaElecAlt == false) {
                    scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
                }
                scope.anexos.T_DetalleAnexoTarifaElecAlt.push({ CodTarEle: Tarifa_Elec_Alta.CodTarEle });
                for (var index = 0; index <= scope.anexos.T_DetalleAnexoTarifaElecAlt.length; index++) {
                    scope.anexos[index] = index;
                }
                console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
            });
        } else {
            scope.disabled_all_alta = 0;
            console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
        }
    }

    scope.agregar_tarifa_gas_individual = function(index, dato, CodTarGas) {
        var ObjTarifaGas = new Object();
        scope.select_tarifa_gas[CodTarGas] = dato;
        var ObjTarifaGas = new Object();
        if (scope.anexos.T_DetalleAnexoTarifaGas == undefined || scope.anexos.T_DetalleAnexoTarifaGas == false) {
            scope.anexos.T_DetalleAnexoTarifaGas = [];
        }
        scope.anexos.T_DetalleAnexoTarifaGas.push({ CodTarGas: dato.CodTarGas });
        console.log(scope.anexos.T_DetalleAnexoTarifaGas);
    }
    scope.quitar_tarifa_gas = function(index, CodTarGas, tarifa_gas) {
        scope.select_tarifa_gas[CodTarGas] = false;
        i = 0;
        for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaGas.length; i++) {
            if (scope.anexos.T_DetalleAnexoTarifaGas[i].CodTarGas == CodTarGas) {
                scope.anexos.T_DetalleAnexoTarifaGas.splice(i, 1);
            }
        }
        console.log(scope.anexos.T_DetalleAnexoTarifaGas);
    }
    scope.agregar_todas_detalle = function(valor) {
        if (valor == true) {
            scope.disabled_all = 1;
            angular.forEach(scope.Tarifa_Gas_Anexos, function(Tarifa) {
                if (scope.anexos.T_DetalleAnexoTarifaGas != false) {
                    if (scope.anexos.T_DetalleAnexoTarifaGas.length > 0) {
                        for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaGas.length; i++) {
                            if (scope.anexos.T_DetalleAnexoTarifaGas[i].CodTarGas == Tarifa.CodTarGas) {
                                scope.anexos.T_DetalleAnexoTarifaGas.splice(i, 1);
                            }
                        }
                    }
                }
                var ObjTarifaGas = new Object();
                scope.select_tarifa_gas[Tarifa.CodTarGas] = Tarifa;

                if (scope.anexos.T_DetalleAnexoTarifaGas == undefined || scope.anexos.T_DetalleAnexoTarifaGas == false) {
                    scope.anexos.T_DetalleAnexoTarifaGas = [];
                }
                scope.anexos.T_DetalleAnexoTarifaGas.push({ CodTarGas: Tarifa.CodTarGas });
                for (var index = 0; index <= scope.anexos.T_DetalleAnexoTarifaGas.length; index++) {
                    scope.anexos[index] = index;
                }
                console.log(scope.anexos.T_DetalleAnexoTarifaGas);
            });
        } else {
            scope.disabled_all = 0;
            console.log(scope.anexos.T_DetalleAnexoTarifaGas);
        }
    }

    $scope.uploadFileAnexo = function() {
        var file = $scope.file_anexo;
        //console.log($scope.file_anexo);
        upload.uploadFile(file, name).then(function(res) {
            console.log(res);
        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }

    scope.buscarXIDAnexos = function() {
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/Buscar_xID_Anexos/CodAnePro/" + scope.nIDAnexos;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                //scope.anexos=result.data;
                scope.anexos = {};
                var index = 0;
                scope.index = 0;
                scope.anexos.CodTProCom = result.data.CodCom;
                scope.anexos.CodPro = result.data.CodPro;
                scope.anexos.CodAnePro = result.data.CodAnePro;
                scope.anexos.DesAnePro = result.data.DesAnePro;
                scope.FecIniAneA = result.data.FecIniAne;
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniAneA);
                if (result.data.SerEle == 0) {
                    scope.anexos.SerEle = false;
                    scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
                    scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
                    scope.select_tarifa_Elec_Baj = [];
                    scope.select_tarifa_Elec_Alt = [];
                } else {
                    scope.anexos.SerEle = true;
                    scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
                    scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
                    scope.select_tarifa_Elec_Baj = [];
                    scope.select_tarifa_Elec_Alt = [];
                    angular.forEach(result.data.T_DetalleAnexoTarifaElec, function(Tarifa_Electrica) {
                        if (Tarifa_Electrica.TipTen == 0) {
                            var ObjTarifaElecBaja = new Object();
                            scope.select_tarifa_Elec_Baj[Tarifa_Electrica.CodTarEle] = Tarifa_Electrica;
                            var ObjTarifaGas = new Object();
                            if (scope.anexos.T_DetalleAnexoTarifaElecBaj == undefined || scope.anexos.T_DetalleAnexoTarifaElecBaj == false) {
                                scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
                            }
                            scope.anexos.T_DetalleAnexoTarifaElecBaj.push({ CodTarEle: Tarifa_Electrica.CodTarEle });
                            console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
                        } else {
                            scope.select_tarifa_Elec_Alt[Tarifa_Electrica.CodTarEle] = Tarifa_Electrica;
                            var ObjTarifaElecAlt = new Object();
                            if (scope.anexos.T_DetalleAnexoTarifaElecAlt == undefined || scope.anexos.T_DetalleAnexoTarifaElecAlt == false) {
                                scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
                            }
                            scope.anexos.T_DetalleAnexoTarifaElecAlt.push({ CodTarEle: Tarifa_Electrica.CodTarEle });
                            console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
                        }
                    });
                }
                if (result.data.SerGas == 0) {
                    scope.anexos.SerGas = false;
                    scope.anexos.T_DetalleAnexoTarifaGas = [];
                    scope.select_tarifa_gas = [];
                } else {
                    scope.anexos.SerGas = true;
                    scope.anexos.T_DetalleAnexoTarifaGas = [];
                    scope.select_tarifa_gas = [];
                    scope.anexos.T_DetalleAnexoTarifaGas = result.data.T_DetalleAnexoTarifaGas;
                    angular.forEach(scope.anexos.T_DetalleAnexoTarifaGas, function(select_tarifa_gas) {
                        scope.select_tarifa_gas[select_tarifa_gas.CodTarGas] = select_tarifa_gas;

                    });
                }
                if (result.data.TipPre == 0) {
                    scope.anexos.Fijo = true;
                    scope.anexos.Indexado = false;
                }
                if (result.data.TipPre == 1) {
                    scope.anexos.Indexado = true;
                    scope.anexos.Fijo = false;
                }
                if (result.data.TipPre == 2) {
                    scope.anexos.Fijo = true;
                    scope.anexos.Indexado = true;
                }

                scope.anexos.DocAnePro = result.data.DocAnePro;
                scope.anexos.CodTipCom = result.data.CodTipCom;
                scope.anexos.ObsAnePro = result.data.ObsAnePro;
                scope.anexos.AggAllBaj = false;
                scope.anexos.AggAllAlt = false;
                scope.Todas_Gas = false;
                scope.disabled_all_baja = 0;
                scope.disabled_all_alta = 0;
                scope.disabled_all = 0;
                console.log(scope.anexos);
            } else {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: 'No hay Anexos registrados', type: "error", confirmButtonColor: "#188ae2" });
            }

        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.regresar_anexos = function() {
        if (scope.INF == undefined) {
            if (scope.anexos.CodAnePro == undefined) {
                var title = 'Guardando';
                var text = '¿Seguro de cerrar y no grabar el Anexo?';
            } else {
                var title = 'Actualizando';
                var text = '¿Seguro de cerrar y no actualizar el Anexo?';
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
                    scope.cargar_lista_anexos();
                    scope.anexos = {};
                    scope.select_tarifa_gas = [];
                    scope.select_tarifa_Elec_Baj = [];
                    scope.select_tarifa_Elec_Alt = [];
                    scope.anexos.T_DetalleAnexoTarifaGas = [];
                    scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
                    scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
                    scope.anexos.SerGas = false;
                    scope.anexos.SerEle = false;
                    scope.anexos.Fijo = false;
                    scope.anexos.Indexado = false;
                    scope.anexos.AggAllBaj = false;
                    scope.anexos.AggAllAlt = false;
                    location.href = "#/Anexos";
                } else {
                    console.log('Cancelando ando...');
                }
            });

        } else {
            location.href = "#/Anexos";
        }
    }
    scope.fetchAnexos = function() {
        if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {
            $scope.predicate2 = 'id';
            $scope.reverse2 = true;
            $scope.currentPage2 = 1;
            $scope.order2 = function(predicate2) {
                $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                $scope.predicate2 = predicate2;
            };
            scope.TAnexos = scope.TAnexosBack;
            $scope.totalItems2 = scope.TAnexos.length;
            $scope.numPerPage2 = 50;
            $scope.paginate2 = function(value2) {
                var begin2, end2, index2;
                begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                end2 = begin2 + $scope.numPerPage2;
                index2 = scope.TAnexos.indexOf(value2);
                return (begin2 <= index2 && index2 < end2);
            };
            scope.reporte_pdf_anexos = 0;
            scope.reporte_excel_anexos = 0;
        } else {
            if (scope.filtrar_search.length >= 1) {
                scope.fdatos.filtrar_search = scope.filtrar_search;
                var url = base_urlHome() + "api/Comercializadora/getAnexosFilter";
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
                        scope.TAnexos = result.data;
                        $scope.totalItems2 = scope.TAnexos.length;
                        $scope.numPerPage2 = 50;
                        $scope.paginate2 = function(value2) {
                            var begin2, end2, index2;
                            begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                            end2 = begin2 + $scope.numPerPage2;
                            index2 = scope.TAnexos.indexOf(value2);
                            return (begin2 <= index2 && index2 < end2);
                        };
                        scope.reporte_pdf_anexos = 7 + "/" + scope.filtrar_search;
                        scope.reporte_excel_anexos = 7 + "/" + scope.filtrar_search;
                    } else {
                        $scope.predicate2 = 'id';
                        $scope.reverse2 = true;
                        $scope.currentPage2 = 1;
                        $scope.order2 = function(predicate2) {
                            $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                            $scope.predicate2 = predicate2;
                        };
                        scope.TAnexos = scope.TAnexosBack;
                        $scope.totalItems2 = scope.TAnexos.length;
                        $scope.numPerPage2 = 50;
                        $scope.paginate2 = function(value2) {
                            var begin2, end2, index2;
                            begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                            end2 = begin2 + $scope.numPerPage2;
                            index2 = scope.TAnexos.indexOf(value2);
                            return (begin2 <= index2 && index2 < end2);
                        };
                        scope.reporte_pdf_anexos = 0;
                        scope.reporte_excel_anexos = 0;
                    }
                }, function(error) {
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
        }
    }





    if (scope.nIDAnexos != undefined) {
        scope.buscarXIDAnexos();
        var promise = $interval(function() {
            scope.filtrar_productos_com();
        }, 5000);
        $scope.$on('$destroy', function() {
            $interval.cancel(promise);
        });

    }
}