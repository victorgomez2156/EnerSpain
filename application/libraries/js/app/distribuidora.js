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
        scope.ruta_reportes_pdf_distribuidora_distribuidora = 0;
        scope.ruta_reportes_excel_distribuidora_distribuidora = 0;
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
            scope.SerEle = false;
            scope.SerGas = false;
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
                scope.TDistribuidora = [];
                scope.TDistribuidoraBack = [];
            }
        }, function(error) {
                        $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                scope.toast('error','Está Distribuidora ya se encuentra activa.','Activando');
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
                            scope.toast('success','Distribuidora activada de forma correcta.','Activando');
                            scope.cargar_lista_distribuidoras();
                        } else {
                            scope.toast('error','Hubo un error al cambiar el estatus de la distribuidora.','Activando');
                            scope.cargar_lista_distribuidoras();
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
                    event.preventDefault();
                }
            });
        }
        if (opciones_distribuidoras == 4) {
            if (dato.EstDist == "BLOQUEADO") {
                scope.toast('error','Está Distribuidora ya se encuentra Bloqueada.','Bloqueando');
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
            scope.toast('error','No tiene permisos para realizar esta operación.','Usuario no Autorizado');
            return false;
        }
        if (scope.disabled_form == 1) {
            scope.toast('error','No es posible continuar con la operación.','Error');
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

        if (scope.fdatos.NumCifDis == null || scope.fdatos.NumCifDis == undefined || scope.fdatos.NumCifDis == '') {
            scope.toast('error','El Campo CIF es requerido.','');
            return false;
        }
        if (scope.fdatos.RazSocDis == null || scope.fdatos.RazSocDis == undefined || scope.fdatos.RazSocDis == '') {
            scope.toast('error','El Campo Razón Social es requerido.','');
            return false;
        }
        if (scope.fdatos.NomComDis == null || scope.fdatos.NomComDis == undefined || scope.fdatos.NomComDis == '') {
            scope.toast('error','El Campo Nombre Comercial es requerido.','');
            return false;
        }
        if (scope.SerEle == false && scope.SerGas == false) {
            scope.toast('error','Debe Seleccionar un Tipo de Suministro.','');
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
                scope.toast('success',response,title);                
                if ($route.current.$$route.originalPath == "/Add_Distribuidora/") {
                    $cookies.remove('CIF_DISTRIBUIDORA');
                    location.href = "#/Edit_Distribuidora/" + scope.nID;
                }
            } else {
                scope.toast('error','Error durante la operación, por favor intente nuevamente.','Error');                
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
        //var CIF_DISTRIBUIDORA =scope.fdatos.NumCifDis;
        scope.fdatos = {};
        scope.fdatos.NumCifDis = scope.CIF_DISTRIBUIDORA;
        scope.SerEle = false;
        scope.SerGas = false;
    }

    scope.buscarXID = function() {
        $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Distribuidoras/buscar_xID_Distribuidora/CodDist/" + scope.nID;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos = result.data;
                if (result.data.TipSerDis == null){
                    scope.SerGas = false;
                    scope.SerEle = false;
                }
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
                scope.toast('error','No hemos encontrado datos relacionados con el código.','Error');
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
    scope.borrar_row = function(index, id) {
        if (scope.Nivel == 3) {
            scope.toast('error','No tiene permisos para realizar esta operación.','Usuario no Autorizado');            
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
                        scope.toast('success','Registro eliminado de forma correcta.','Borrado'); 
                        scope.TDistribuidora.splice(index, 1);
                    } else {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        scope.toast('error','No se ha podido eliminar el registro, intente nuevamente.','Borrado');                        
                    }

                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                console.log('Cancelando Ando...');
            }
        });
    }
    scope.borrar = function() {
        if (scope.Nivel == 3) {
            scope.toast('error','No tiene permisos para realizar esta operación.','Usuario no Autorizado');            
            return false;
        }
        if (scope.disabled_form == 1) {
            scope.toast('error','No se puede completar esta acción.','Error');            
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
                        scope.toast('error','Registro Borrado de forma correcta.','Exito');
                        location.href = "#/Distribuidora/";
                    } else {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        scope.toast('error','Hubo un error al intertar borrar el registro.','Error');                        
                    }
                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                    scope.toast('error','El Número de CIF ya se encuentra asignado a una distribuidora.','DNI/NIE');                    
                } else {
                    $("#NumCifDis").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    $("#modal_cif_distribuidora").modal('hide');
                    var CIF_DISTRIBUIDORA = scope.NumCifDisConsulta;
                    $cookies.put('CIF_DISTRIBUIDORA', CIF_DISTRIBUIDORA);
                    location.href = "#/Add_Distribuidora/";

                }
            }, function(error) {
                $("#NumCifDis").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    };
    $scope.submitFormlock = function(event) {
        //console.log(scope.tmodal_distribuidora);
        var FechBlo = document.getElementById("FechBlo").value;
        scope.FechBlo = FechBlo;
        if (scope.FechBlo == null || scope.FechBlo == undefined || scope.FechBlo == '') {
            scope.toast('error','El Campo de Fecha de Bloqueo es requerido.','Fecha de Bloqueo');
            return false;
        } else {
            var FechBlo = (scope.FechBlo).split("/");
            if (FechBlo.length < 3) {
                scope.toast('error',"El Formato de la Fecha de Bloqueo debe Ser: " + fecha,'Fecha de Bloqueo');
                return false;
            } else {
                if (FechBlo[0].length > 2 || FechBlo[0].length < 2) {
                    scope.toast('error','El Formato del Día debe ser EJ: 01','Fecha de Bloqueo');
                    return false;
                }
                if (FechBlo[1].length > 2 || FechBlo[1].length < 2) {
                    scope.toast('error','El Formato del Mes debe ser EJ: 01','Fecha de Bloqueo');
                    return false;
                }
                if (FechBlo[2].length < 4 || FechBlo[2].length > 4) {
                    scope.toast('error','El Formato del Año debe ser EJ: 1999','Fecha de Bloqueo');
                    return false;
                }
                valuesStart = scope.FechBlo.split("/");
                valuesEnd = fecha.split("/");
                //Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de Bloqueo no puede ser mayor a " + fecha + " Verifique he intente nuevamente.",'Fecha de Bloqueo');
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
                        scope.toast('success','Distribuidora Bloqueada de forma correcta.','Bloqueando');
                        scope.cargar_lista_distribuidoras();
                    } else {
                        scope.toast('error','Error en el proceso, por favor intente nuevamente.','Error');
                        scope.cargar_lista_distribuidoras();
                    }
                }, function(error) {
                        $("#bloquendo").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            scope.ruta_reportes_pdf_distribuidora_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.TipSerDis;
            scope.ruta_reportes_excel_distribuidora_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.TipSerDis;
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
            scope.ruta_reportes_pdf_distribuidora_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.EstDist;
            scope.ruta_reportes_excel_distribuidora_distribuidora = scope.tmodal_distribuidora.tipo_filtro + '/' + scope.tmodal_distribuidora.EstDist;
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
        scope.ruta_reportes_pdf_distribuidora_distribuidora = 0;
        scope.ruta_reportes_excel_distribuidora_distribuidora = 0;
    }
    scope.FetchDistribuidoras = function() {
        if (scope.filter_search == undefined || scope.filter_search == null || scope.filter_search == '') {

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

        } else {
            if (scope.filter_search.length >= 2) {
                scope.fdatos.filter_search = scope.filter_search;
                var url = base_urlHome() + "api/Distribuidoras/getDistribuidorasFilter";
                $http.post(url, scope.fdatos).then(function(result) {
                    console.log(result.data);
                    if (result.data != false) {
                        $scope.predicate = 'id';
                        $scope.reverse = true;
                        $scope.currentPage = 1;
                        $scope.order = function(predicate) {
                            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                            $scope.predicate = predicate;
                        };
                        scope.TDistribuidora = result.data;
                        $scope.totalItems = scope.TDistribuidora.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.TDistribuidora.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_distribuidora = 3 + "/" + scope.filter_search;
                        scope.ruta_reportes_excel_distribuidora = 3 + "/" + scope.filter_search;
                    } else {
                        scope.TDistribuidora =[];
                        scope.ruta_reportes_pdf_distribuidora = 0;
                        scope.ruta_reportes_excel_distribuidora = 0;
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



    if (scope.nID != undefined) {
        scope.buscarXID();
    }
}