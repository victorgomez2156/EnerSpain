app.controller('Controlador_Seguimientos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    var scope = this;
    scope.fdatos = {};
    scope.T_Seguimientos = [];
    scope.T_SeguimientosBack = [];
    scope.List_Gestiones = [];
    scope.List_GestionesBack = [];
    //scope.CodConCom = $route.current.params.CodConCom;

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
    scope.FecSeg = fecha;
    $('.FecSeg').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", fecha);
    ////////////////////////////////////////////////// PARA LOS CONTRATOS START /////////////////////////////////////////////////////////////
    console.log($route.current.$$route.originalPath);
    scope.UltTipSeg = undefined;
    //scope.fdatos.UltTipSeg=undefined;
    scope.fetchClientes = function() {
        var searchText_len = scope.RazSocCli.trim().length;
        scope.fdatos.NumCifCli = scope.RazSocCli;
        if (searchText_len > 0) {
            var url = base_urlHome() + "api/Seguimientos/getclientes";
            $http.post(url, scope.fdatos).then(function(result) {
                console.log(result);
                if (result.data != false) { scope.searchResult = result.data;
                    console.log(scope.searchResult); } else {
                    Swal.fire({ title: "Error", text: "No existen clientes registrados.", type: "error", confirmButtonColor: "#188ae2" });
                    scope.searchResult = {};
                }
            }, function(error) {
                if (error.status == 404 && error.statusText == "Not Found") { Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" }); }
                if (error.status == 401 && error.statusText == "Unauthorized") { Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" }); }
                if (error.status == 403 && error.statusText == "Forbidden") { Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" }); }
                if (error.status == 500 && error.statusText == "Internal Server Error") { Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" }); }
            });
        } else { scope.searchResult = {}; }
    }

    scope.setValue = function(index, $event, result) {
        scope.RazSocCli = scope.searchResult[index].NumCifCli + " - " + scope.searchResult[index].RazSocCli;
        scope.fdatos.CodCli = scope.searchResult[index].CodCli;
        scope.searchResult = {};
        $event.stopPropagation();
    }
    scope.searchboxClicked = function($event) {
        $event.stopPropagation();
    }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }
    scope.limpiar_cliente = function() {
        scope.RazSocCli = undefined;
        scope.fdatos.CodCli = undefined;
        scope.fdatos.TipSeg = undefined;
        scope.fdatos.CodRef = undefined;
        scope.fdatos.ResSeg = undefined;
        scope.fdatos.RefSeg = undefined;
        scope.fdatos.ObsSeg = undefined;
        scope.traer_datos_server();
    }
    scope.traer_datos_server = function() {
        var url = base_urlHome() + "api/Seguimientos/datos_server/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                scope.FecSeg = result.data.FechaServer;
                scope.FechaServer = result.data.FechaServer;
                $('.FecSeg').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
                scope.fdatos.NumSeg = result.data.nrSeguimiento;
            } else {
                Swal.fire({ title: "Error General", text: "Error General intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
            }

        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") { Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 401 && error.statusText == "Unauthorized") { Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 403 && error.statusText == "Forbidden") { Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 500 && error.statusText == "Internal Server Error") { Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" }); }

        });
    }
    scope.BuscarTipoGestionComercial = function() {
        console.log(scope.fdatos);
        scope.fdatos.CodRef = undefined;
        scope.fdatos.ResSeg = undefined;
        scope.fdatos.RefSeg = undefined;
        scope.fdatos.ObsSeg = undefined;
        scope.fdatos.UltTipSeg = undefined;
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Seguimientos/BuscarGestionComercial/";
        $http.post(url, scope.fdatos).then(function(result) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.List_Gestiones = result.data;
            } else {
                Swal.fire({ title: "Error", text: "No se encontraton Gestiones comerciales asignadas a este cliente.", type: "error", confirmButtonColor: "#188ae2" });
                scope.List_Gestiones = [];
                scope.List_GestionesBack = [];
            }
        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") { Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 401 && error.statusText == "Unauthorized") { Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 403 && error.statusText == "Forbidden") { Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 500 && error.statusText == "Internal Server Error") { Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" }); }
        });
    }
    $scope.submitFormSeguimientos = function(event) {
        if (scope.fdatos.CodSeg == undefined) {
            var titulo = 'Guardando';
            var texto = '¿Seguro de grabar el seguimiento?';
            var response = 'Seguimiento registrado de forma correcta';
        }
        if (scope.fdatos.CodSeg > 0) {
            var titulo = 'Actualizando';
            var texto = '¿Seguro de actualizar el seguimiento?';
            var response = 'Seguimiento actualizado de forma correcta';
        }

        if (!scope.validar_campos_seguimientos()) {
            return false;
        }
        console.log(scope.fdatos);
        Swal.fire({
            title: titulo,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK!"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Seguimientos/registrar_seguimiento/";
                $http.post(url, scope.fdatos).then(function(result) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        if (result.data.CodSeg > 0) {
                            scope.traer_datos_server();
                            scope.fdatos.ResSeg = undefined;
                            scope.fdatos.RefSeg = undefined;
                            scope.fdatos.DesSeg = undefined;
                            scope.fdatos.ObsSeg = undefined;

                            //scope.search_seguimientos();
                            scope.BuscarTipoGestionComercial();
                            scope.fdatos.CodRef = result.data.CodRef;
                            scope.FilterGestion(scope.fdatos.CodRef);
                            scope.search_seguimientos();
                            scope.fdatos.UltTipSeg = result.data.UltTipSeg;
                        }
                        if (result.data.status == 200 && result.data.statusText == 'OK') {
                            Swal.fire({ title: titulo, text: result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });
                        }
                    } else {
                        Swal.fire({ title: "Error", text: "No se ha completado la operación, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.validar_campos_seguimientos = function() {
        resultado = true;
        if (!scope.fdatos.CodCli > 0) {
            Swal.fire({ title: "Debe seleccionar un Cliente.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.TipSeg > 0) {
            Swal.fire({ title: "Debe seleccionar un Tipo de Gestión Comercial.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodRef > 0) {
            Swal.fire({ title: "Debe seleccionar una Gestión Comercial.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        var FecSeg1 = document.getElementById("FecSeg").value;
        scope.FecSeg = FecSeg1;
        if (scope.FecSeg == null || scope.FecSeg == undefined || scope.FecSeg == '') {
            Swal.fire({ title: "La Fecha de Registro es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecSeg = (scope.FecSeg).split("/");
            if (FecSeg.length < 3) {
                Swal.fire({ title: "El Formato de Fecha de Registro debe Ser EJ: DD/MM/YYYY.", type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecSeg[0].length > 2 || FecSeg[0].length < 2) {
                    Swal.fire({ title: "Por Favor Corrija el Formato del dia en la Fecha de Registro deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecSeg[1].length > 2 || FecSeg[1].length < 2) {
                    Swal.fire({ title: "Por Favor Corrija el Formato del mes de la Fecha de Registro deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecSeg[2].length < 4 || FecSeg[2].length > 4) {
                    Swal.fire({ title: "Por Favor Corrija el Formato del ano en la Fecha de Registro Ya que deben ser 4 números solamente. EJ: 1999", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecSeg.split("/");
                valuesEnd = scope.FechaServer.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ text: 'La Fecha de Registro no debe ser mayor a ' + scope.FechaServer, type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.fdatos.FecSeg = FecSeg[2] + "-" + FecSeg[1] + "-" + FecSeg[0];
            }
        }
        if (!scope.fdatos.ResSeg > 0) {
            Swal.fire({ title: "Debe seleccionar un Tipo de Seguimiento.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.RefSeg == undefined || scope.fdatos.RefSeg == null || scope.fdatos.RefSeg == '') {
            scope.fdatos.RefSeg = null;
        } else {
            scope.fdatos.RefSeg = scope.fdatos.RefSeg;
        }
        if (scope.fdatos.DesSeg == undefined || scope.fdatos.DesSeg == null || scope.fdatos.DesSeg == '') {
            scope.fdatos.DesSeg = null;
        } else {
            scope.fdatos.DesSeg = scope.fdatos.DesSeg;
        }
        if (scope.fdatos.ObsSeg == undefined || scope.fdatos.ObsSeg == null || scope.fdatos.ObsSeg == '') {
            scope.fdatos.ObsSeg = null;
        } else {
            scope.fdatos.ObsSeg = scope.fdatos.ObsSeg;
        }
        if (resultado == false) { //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.FilterGestion = function(CodRef) {
        console.log(CodRef);
        console.log(scope.List_Gestiones);
        for (var i = 0; i < scope.List_Gestiones.length; i++) {
            if (scope.List_Gestiones[i].CodRef == CodRef) {
                scope.fdatos.UltTipSeg = scope.List_Gestiones[i].UltTipSeg;
            }
        }
        console.log(scope.fdatos.UltTipSeg);
        scope.search_seguimientos();
    }
    scope.search_seguimientos = function() {
        //$("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Seguimientos/get_seguimientos/TipSeg/" + scope.fdatos.TipSeg + "/CodRef/" + scope.fdatos.CodRef + "/CodCli/" + scope.fdatos.CodCli;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.T_Seguimientos = result.data;
                scope.T_SeguimientosBack = result.data;
                $scope.totalItems = scope.T_Seguimientos.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.T_Seguimientos.indexOf(value);
                    return (begin <= index && index < end);
                }
            } else {
                Swal.fire({ title: "Error", text: "No existen seguimientos asignados", type: "error", confirmButtonColor: "#188ae2" });
                scope.T_Seguimientos = [];
                scope.T_SeguimientosBack = [];
            }
            //$("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");

        }, function(error) {
            //$("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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







    scope.traer_datos_server();
    ////////////////////////////////////////////////// PARA LOS CONTRATOS END ///////////////////////////////////////////////////////////////    
}No existen