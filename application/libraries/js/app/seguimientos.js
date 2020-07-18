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
                    scope.toast('error','No existen clientes registrados.','Error');
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
                    } });
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
        scope.fdatos.UltTipSeg=undefined;
        scope.T_Seguimientos=[];
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
                scope.toast('error','Error General intente nuevamente.','Error General');
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
                scope.toast('error','No se encontraton Gestiones comerciales asignadas a este cliente.','Error');
                scope.List_Gestiones = [];
                scope.List_GestionesBack = [];
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
                    }});
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
                            scope.BuscarTipoGestionComercial();
                            scope.fdatos.CodRef = result.data.CodRef;
                            scope.FilterGestion(scope.fdatos.CodRef);
                            scope.search_seguimientos();
                            scope.fdatos.UltTipSeg = result.data.UltTipSeg;
                        }
                        if (result.data.status == 200 && result.data.statusText == 'OK') {
                            scope.toast('success',result.data.menssage,titulo);
                        }
                    } else {
                        scope.toast('error','No se ha completado la operación, intente nuevamente.','Error');
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
    scope.validar_campos_seguimientos = function() {
        resultado = true;
        if (!scope.fdatos.CodCli > 0) {
            scope.toast('error','Debe seleccionar un Cliente.','');            
            return false;
        }
        if (!scope.fdatos.TipSeg > 0) {
            scope.toast('error','Debe seleccionar un Tipo de Gestión Comercial.','');
            return false;
        }
        if (!scope.fdatos.CodRef > 0) {
           scope.toast('error','Debe seleccionar una Gestión Comercial.','');
            return false;
        }
        var FecSeg1 = document.getElementById("FecSeg").value;
        scope.FecSeg = FecSeg1;
        if (scope.FecSeg == null || scope.FecSeg == undefined || scope.FecSeg == '') {
            scope.toast('error','La Fecha de Registro es requerida','');
            return false;
        } else {
            var FecSeg = (scope.FecSeg).split("/");
            if (FecSeg.length < 3) {
                scope.toast('error','El Formato de Fecha de Registro debe Ser EJ: DD/MM/YYYY.','');
                event.preventDefault();
                return false;
            } else {
                if (FecSeg[0].length > 2 || FecSeg[0].length < 2) {
                    scope.toast('error','Error en Dia, deben ser 2 números EJ: 01','');
                    event.preventDefault();
                    return false;
                }
                if (FecSeg[1].length > 2 || FecSeg[1].length < 2) {
                    scope.toast('error','Error en Mes, deben ser 2 números EJ: 01','');
                    event.preventDefault();
                    return false;
                }
                if (FecSeg[2].length < 4 || FecSeg[2].length > 4) {
                   scope.toast('error','Error en Año, deben ser 4 números EJ: 1999','');
                   event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecSeg.split("/");
                valuesEnd = scope.FechaServer.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error','La Fecha de Registro no debe ser mayor a ' + scope.FechaServer,'');
                    return false;
                }
                scope.fdatos.FecSeg = FecSeg[2] + "-" + FecSeg[1] + "-" + FecSeg[0];
            }
        }
        if (!scope.fdatos.ResSeg > 0) {
            scope.toast('error','Debe seleccionar un Tipo de Seguimiento.','');
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
    scope.search_seguimientos = function(){
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Seguimientos/get_seguimientos/TipSeg/" + scope.fdatos.TipSeg + "/CodRef/" + scope.fdatos.CodRef + "/CodCli/" + scope.fdatos.CodCli;
        $http.get(url).then(function(result) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                scope.toast('error','No existen seguimientos asignados','Error');
                scope.T_Seguimientos = [];
                scope.T_SeguimientosBack = [];
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
    scope.traer_datos_server();
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
    ////////////////////////////////////////////////// PARA LOS CONTRATOS END ///////////////////////////////////////////////////////////////    
}