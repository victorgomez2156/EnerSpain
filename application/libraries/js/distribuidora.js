app.controller('Controlador_Distribuidora', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);


function Controlador($http, $scope, $filter, $route, $interval, controller, $cookies, $compile) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.Nivel = $cookies.get('nivel');
    scope.TDistribuidora = [];
    scope.TDistribuidoraBack = [];
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

    if ($route.current.$$route.originalPath == "/Distribuidora/") {
        scope.NumCifDis = true;
        scope.RazSocDis = true;
        scope.TelFijDis = true;
        scope.EstDist = true;
        scope.AccDis = true;
        scope.tmodal_distribuidora = {};
        scope.ruta_reportes_pdf_distribuidora = 0;
        scope.ruta_reportes_excel_distribuidora = 0;
        scope.topciones = [{ id: 1, nombre: 'Ver' }, { id: 2, nombre: 'Editar' }, { id: 3, nombre: 'Activar' }, { id: 4, nombre: 'Bloquear' }];
    }
    if ($route.current.$$route.originalPath == "/Add_Distribuidora/") {
        scope.CIF_DISTRIBUIDORA = $cookies.get('CIF_DISTRIBUIDORA');
        if (scope.CIF_DISTRIBUIDORA == undefined) {
            location.href = "#/Distribuidora/";
        } else {
            scope.fdatos.NumCifDis = scope.CIF_DISTRIBUIDORA;
            scope.disabled_cif = 1;
        }
        scope.fdatos.misma_razon = false;
        scope.SerEle = false;
        scope.SerGas = false;

    }
    if ($route.current.$$route.originalPath == "/Edit_Distribuidora/:ID/:FORM") {
        scope.disabled_form = $route.current.params.FORM;
        if (scope.disabled_form != 1) {
            location.href = "#/Distribuidora/";
        }
    }
    console.log($route.current.$$route.originalPath);
    //
    scope.cargar_lista_distribuidoras = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Distribuidoras/list_distribuidoras/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.TDistribuidora = result.data;
                scope.TDistribuidoraBack = result.data;
                $scope.totalItems = scope.TDistribuidora.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.TDistribuidora.indexOf(value);
                    return (begin <= index && index < end);
                };
                console.log(scope.TDistribuidora);
            } else {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: 'No hay información registrada', type: "info", confirmButtonColor: "#188ae2" });
                scope.TDistribuidora = [];
                scope.TDistribuidoraBack = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.validar_opcion_distribuidora = function(index, opciones_distribuidoras, dato) {
        console.log(index);
        console.log(opciones_distribuidoras);
        console.log(dato);
        scope.opciones_distribuidoras[index] = undefined;
        if (opciones_distribuidoras == 1) {
            location.href = "#/Edit_Distribuidora/" + dato.CodDist + "/" + 1;
        }
        if (opciones_distribuidoras == 2) {
            location.href = "#/Edit_Distribuidora/" + dato.CodDist;
            scope.disabled_form = undefined;
        }
        if (opciones_distribuidoras == 3) {
            if (dato.EstDist == "ACTIVO") {
                Swal.fire({ title: 'Activando', text: 'Está Distribuidora ya se encuentra activa.', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.datos_update = {};
            scope.datos_update.opcion = 1;
            scope.datos_update.CodDist = dato.CodDist;
            Swal.fire({
                title: 'Activando',
                text: 'Estás seguro de activar esta distribuidora',
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: 'Activar'
            }).then(function(t) {
                if (t.value == true) {
                    var url = base_urlHome() + "api/Distribuidoras/update_status/";
                    $http.post(url, scope.datos_update).then(function(result) {
                        if (result.data != false) {
                            Swal.fire({ title: 'Activando', text: 'Distribuidora activada de forma correcta', type: "success", confirmButtonColor: "#188ae2" });
                            scope.cargar_lista_distribuidoras();
                        } else {
                            Swal.fire({ title: "Error.", text: 'Hubo un error al cambiar el estatus de la distribuidora', type: "error", confirmButtonColor: "#188ae2" });
                            scope.cargar_lista_distribuidoras();
                        }
                    }, function(error) {
                        if (error.status == 404 && error.statusText == "Not Found") {
                            Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                        }
                        if (error.status == 401 && error.statusText == "Unauthorized") {
                            Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                        }
                        if (error.status == 403 && error.statusText == "Forbidden") {
                            Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                        }
                        if (error.status == 500 && error.statusText == "Internal Server Error") {
                            Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                        }
                    });
                } else {
                    event.preventDefault();
                }
            });
        }
        if (opciones_distribuidoras == 4) {
            if (dato.EstDist == "BLOQUEADO") {
                Swal.fire({ title: 'Bloqueando', text: 'Está Distribuidora ya se encuentra Bloqueada.', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.tmodal_data = {};
            scope.tmodal_data.CodDist = dato.CodDist;
            scope.tmodal_data.NumCifDis = dato.NumCifDis;
            scope.FechBlo = fecha;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FechBlo);
            scope.tmodal_data.RazSocDis = dato.RazSocDis;
            $("#modal_motivo_bloqueo").modal('show');
            console.log(scope.tmodal_data);

        }

    }
    scope.modal_cif_distribuidora = function() {
        $("#modal_cif_distribuidora").modal('show');
        scope.fdatos = {};
    }
    $scope.submitForm = function(event) {
        if (scope.nID > 0 && scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.disabled_form == 1) {
            Swal.fire({ title: "Error", text: 'No es posible continuar con la operación', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.validar_campos_null()) {
            return false;
        }

        if (scope.fdatos.CodDist > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea actualizar la información de la Distribuidora?';
            var response = 'Distribuidora modificada de forma correcta';
        }
        if (scope.fdatos.CodDist == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar la Distribuidora?';
            var response = 'Distribuidora creado de forma correcta';
        }
        console.log(scope.fdatos);
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
    scope.validar_campos_null = function() {
        resultado = true;

        if (scope.fdatos.RazSocDis == null || scope.fdatos.RazSocDis == undefined || scope.fdatos.RazSocDis == '') {
            Swal.fire({ title: "El Campo Razón Social es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NomComDis == null || scope.fdatos.NomComDis == undefined || scope.fdatos.NomComDis == '') {
            Swal.fire({ title: "El Campo Nombre Comercial es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.SerEle == false && scope.SerGas == false) {
            Swal.fire({ title: "Debe Seleccionar un Tipo de Suministro", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.ObsDis == null || scope.fdatos.ObsDis == undefined || scope.fdatos.ObsDis == '') {
            scope.fdatos.ObsDis = null;
        } else {
            scope.fdatos.ObsDis = scope.fdatos.ObsDis;
        }
        if (scope.SerEle == true && scope.SerGas == false) {
            scope.fdatos.TipSerDis = 0;
        }
        if (scope.SerEle == false && scope.SerGas == true) {
            scope.fdatos.TipSerDis = 1;
        }
        if (scope.SerEle == true && scope.SerGas == true) {
            scope.fdatos.TipSerDis = 2;
        }
        if (scope.fdatos.TelFijDis == null || scope.fdatos.TelFijDis == undefined || scope.fdatos.TelFijDis == '') {
            scope.fdatos.TelFijDis = null;
        } else {
            scope.fdatos.TelFijDis = scope.fdatos.TelFijDis;
        }
        if (scope.fdatos.EmaDis == null || scope.fdatos.EmaDis == undefined || scope.fdatos.EmaDis == '') {
            scope.fdatos.EmaDis = null;
        } else {
            scope.fdatos.EmaDis = scope.fdatos.EmaDis;
        }
        if (scope.fdatos.PagWebDis == null || scope.fdatos.PagWebDis == undefined || scope.fdatos.PagWebDis == '') {
            scope.fdatos.PagWebDis = null;
        } else {
            scope.fdatos.PagWebDis = scope.fdatos.PagWebDis;
        }
        if (scope.fdatos.PerConDis == null || scope.fdatos.PerConDis == undefined || scope.fdatos.PerConDis == '') {
            scope.fdatos.PerConDis = null;
        } else {
            scope.fdatos.PerConDis = scope.fdatos.PerConDis;
        }

        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.guardar = function() {
        if (scope.fdatos.CodDist > 0) {
            var title = 'Actualizando';
            var text = 'Estás seguro de actualizar este registro?';
            var response = 'Distribuidora modificada de forma correcta';
        }
        if (scope.fdatos.CodDist == undefined) {
            var title = 'Guardando';
            var text = 'Estás seguro de incluir este nuevo registro?';
            var response = 'Distribuidora creada de forma correcta';
        }
        $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Distribuidoras/crear_distribuidora/";
        $http.post(url, scope.fdatos).then(function(result) {
            scope.nID = result.data.CodDist;
            $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                console.log(result.data);
                Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                if ($route.current.$$route.originalPath == "/Add_Distribuidora/") {
                    $cookies.remove('CIF_DISTRIBUIDORA');
                    location.href = "#/Edit_Distribuidora/" + scope.nID;
                }
            } else {
                Swal.fire({ title: 'Error', text: 'Error durante la operación, por favor intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.misma_comercial = function() {
        if (scope.fdatos.RazSocDis != undefined) {
            scope.fdatos.NomComDis = scope.fdatos.RazSocDis;
        }
    }
    scope.validarnumero = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([0-9])*$/.test(numero))
                scope.fdatos.TelFijDis = numero.substring(0, numero.length - 1);
        }
    }
    scope.misma_razon = function(value) {
        if (value == true) {
            scope.fdatos.NomComDis = undefined;
        } else {
            scope.fdatos.NomComDis = scope.fdatos.RazSocDis;
        }

    }

    scope.limpiar = function() {
        scope.fdatos = {};
    }

    scope.buscarXID = function() {
        $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Distribuidoras/buscar_xID_Distribuidora/CodDist/" + scope.nID;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos = result.data;
                if (result.data.TipSerDis == 0) {
                    scope.SerGas = false;
                    scope.SerEle = true;
                }
                if (result.data.TipSerDis == 1) {
                    scope.SerGas = true;
                    scope.SerEle = false;
                }
                if (result.data.TipSerDis == 2) {
                    scope.SerGas = true;
                    scope.SerEle = true;
                }
                scope.fdatos.misma_razon = false;
                console.log(scope.fdatos);
            } else {
                $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: 'No hemos encontrado datos relacionados con el código.', type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.borrar_row = function(index, id) {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrando",
            text: "Esta Seguro de Borrar Este Registro.",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "BORRAR"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Distribuidoras/borrar_row_distribuidora/CodDist/" + id;
                $http.delete(url).then(function(result) {
                    if (result.data != false) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        bootbox.alert({
                            message: "Registro eliminado de forma correcta",
                            size: 'middle'
                        });
                        scope.TDistribuidora.splice(index, 1);
                    } else {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        bootbox.alert({
                            message: "No se ha podido eliminar el registro, intente nuevamente",
                            size: 'middle'
                        });
                    }

                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                console.log('Cancelando Ando...');
            }
        });
    }
    scope.borrar = function() {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.disabled_form == 1) {
            Swal.fire({ title: "Error.", text: "No se puede completar esta acción.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrando",
            text: "Esta Seguro de Borrar Este Registro.",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "BORRAR"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Distribuidoras/borrar_row_distribuidora/CodDist/" + scope.fdatos.CodDist;
                $http.delete(url).then(function(result) {
                    if (result.data != false) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ title: "Exito", text: "Registro Borrado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        location.href = "#/Distribuidora/";
                    } else {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ title: "Error", text: "Hubo un error al intertar borrar el registro.", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                console.log('Cancelando Ando...');
            }
        });
    }
    $scope.Consultar_CIF = function(event) {
        if (scope.NumCifDisConsulta == undefined || scope.NumCifDisConsulta == null || scope.NumCifDisConsulta == '') {
            Swal.fire({ title: "Error.", text: 'El Campo Número de CIF es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            $("#NumCifDis").removeClass("loader loader-default").addClass("loader loader-default  is-active");
            var url = base_urlHome() + "api/Distribuidoras/comprobar_cif_distribuidora/";
            $http.post(url, scope.NumCifDisConsulta).then(function(result) {
                if (result.data != false) {
                    $("#NumCifDis").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    Swal.fire({ title: "DNI/NIE.", text: 'El Número de CIF no existe', type: "info", confirmButtonColor: "#188ae2" });
                } else {
                    $("#NumCifDis").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    $("#modal_cif_distribuidora").modal('hide');
                    var CIF_DISTRIBUIDORA = scope.NumCifDisConsulta;
                    $cookies.put('CIF_DISTRIBUIDORA', CIF_DISTRIBUIDORA);
                    location.href = "#/Add_Distribuidora/";

                }
            }, function(error) {
                $("#NumCifDis").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                }
            });

        }
    };
    $scope.submitFormlock = function(event) {
        //console.log(scope.tmodal_distribuidora);
        var FechBlo = document.getElementById("FechBlo").value;
        scope.FechBlo = FechBlo;
        if (scope.FechBlo == null || scope.FechBlo == undefined || scope.FechBlo == '') {
            Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Campo de Fecha de Bloqueo es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FechBlo = (scope.FechBlo).split("/");
            if (FechBlo.length < 3) {
                Swal.fire({ title: 'Fecha de Bloqueo', text: "El Formato de la Fecha de Bloqueo debe Ser: " + fecha, type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FechBlo[0].length > 2 || FechBlo[0].length < 2) {
                    Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato del Día debe ser EJ: 01', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FechBlo[1].length > 2 || FechBlo[1].length < 2) {
                    Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato del Mes debe ser EJ: 01', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FechBlo[2].length < 4 || FechBlo[2].length > 4) {
                    Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato del Año debe ser EJ: 1999', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FechBlo.split("/");
                valuesEnd = fecha.split("/");
                //Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ title: 'Fecha de Bloqueo', text: "La Fecha de Bloqueo no puede ser mayor a " + fecha + " Verifique he intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.tmodal_data.FechBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
            }
        }
        Swal.fire({
            title: 'Bloqueando',
            text: 'Estás seguro de bloquear esta Distribuidora?',
            type: "info",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Bloquear"
        }).then(function(t) {
            if (t.value == true) {
                scope.datos_update = {};
                scope.datos_update.opcion = 2;
                scope.datos_update.CodDist = scope.tmodal_data.CodDist;
                scope.datos_update.FechBlo = scope.tmodal_data.FechBlo;
                scope.datos_update.MotBloq = scope.tmodal_data.MotBloq;
                if (scope.tmodal_data.ObsBloDis == undefined || scope.tmodal_data.ObsBloDis == null || scope.tmodal_data.ObsBloDis == '') {
                    scope.datos_update.ObsBloDis = null;
                } else {
                    scope.datos_update.ObsBloDis = scope.tmodal_data.ObsBloDis;
                }
                console.log(scope.datos_update);
                $("#bloquendo").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Distribuidoras/update_status/";
                $http.post(url, scope.datos_update).then(function(result) {
                    $("#bloquendo").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        $("#modal_motivo_bloqueo").modal('hide');
                        Swal.fire({ title: 'Bloqueando', text: 'Distribuidora Bloqueada de forma correcta', type: "success", confirmButtonColor: "#188ae2" });
                        scope.cargar_lista_distribuidoras();
                    } else {
                        Swal.fire({ title: "Error.", text: 'Error en el proceso, por favor intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
                        scope.cargar_lista_distribuidoras();
                    }
                }, function(error) {
                    $("#bloquendo").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                console.log('Cancelando ando...');
            }
        });
    };
    $scope.SubmitFormFiltrosDistribuidora = function(event) {
        if (scope.tmodal_distribuidora.tipo_filtro == 1) {

            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TDistribuidora = $filter('filter')(scope.TDistribuidoraBack, { TipSerDis: scope.tmodal_distribuidora.TipSerDis }, true);
            $scope.totalItems = scope.TDistribuidora.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TDistribuidora.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.TipSerDis;
            scope.ruta_reportes_excel_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.TipSerDis;
        }
        if (scope.tmodal_distribuidora.tipo_filtro == 2) {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TDistribuidora = $filter('filter')(scope.TDistribuidoraBack, { EstDist: scope.tmodal_distribuidora.EstDist }, true);
            $scope.totalItems = scope.TDistribuidora.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TDistribuidora.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.EstDist;
            scope.ruta_reportes_excel_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.EstDist;
        }

    };
    scope.regresar = function() {

        if (scope.validate_info == undefined) {
            if (scope.fdatos.CodDist == undefined) {
                var title = "Guardando";
                var text = "¿Seguro que desea cerrar sin registrar la Distribuidora?";
            } else {
                var title = "Actualizando";
                var text = "¿Seguro que desea cerrar sin actualizar la información de la Distribuidora?";
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
                    location.href = "#/Distribuidora";
                } else {
                    console.log('Cancelando ando...');
                }
            });
        } else {
            location.href = "#/Distribuidora";
        }
    }
    scope.regresar_filtro_distribuidora = function() {
        scope.tmodal_distribuidora = {};
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.TDistribuidora = scope.TDistribuidoraBack;
        $scope.totalItems = scope.TDistribuidora.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.TDistribuidora.indexOf(value);
            return (begin <= index && index < end);
        };
        scope.ruta_reportes_pdf_distribuidora = 0;
        scope.ruta_reportes_excel_distribuidora = 0;
    }
    if (scope.nID != undefined) {
        scope.buscarXID();
    }
}