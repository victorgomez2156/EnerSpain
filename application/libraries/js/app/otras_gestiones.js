app.controller('Controlador_Gestiones', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.fdatos.CodCli = $route.current.params.CodCli; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.fdatos.tipo = $route.current.params.Tipo;
    scope.fdatos.CodGesGen = $route.current.params.CodGesGen;
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
    var fecha = dd + '-' + mm + '-' + yyyy;
    
   scope.fetchClientes = function(metodo) {
        if (metodo == 1) {
            var searchText_len = scope.NumCifCli.trim().length;
            scope.fdatos.NumCifCli = scope.NumCifCli;
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/Contratos/getclientes";
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
        if (metodo == 2) {
           var searchText_len = scope.NumCifCliFil.trim().length;
            scope.fdatos.NumCifCli = scope.NumCifCliFil;
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/OtrasGestiones/getclientes";
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
    scope.setValue = function(index, $event, result, metodo) {
        if (metodo == 1) {
            
            if (scope.searchResult[index].NumCifCli == null || scope.searchResult[index].NumCifCli == undefined || scope.searchResult[index].NumCifCli == '') {
                scope.Cif = 'S/I';
            } else {
                scope.Cif = scope.searchResult[index].NumCifCli;
            }
            scope.NumCifCli = scope.Cif;
            scope.searchResult = {};
            $event.stopPropagation();
        }
        if (metodo == 2) {
            console.log(scope.searchResult[index]);
            scope.tmodal_filtros.CodCliFil = scope.searchResult[index].CodCli;
            if (scope.searchResult[index].NumCifCli == null || scope.searchResult[index].NumCifCli == undefined || scope.searchResult[index].NumCifCli == '') {
                scope.Cif = 'S/I';
            } else {
                scope.Cif = scope.searchResult[index].NumCifCli;
            }
            scope.NumCifCliFil = scope.Cif + " - " + scope.searchResult[index].RazSocCli;
            scope.searchResult = {};
            $event.stopPropagation();
        }

    }
    scope.searchboxClicked = function($event) {
        $event.stopPropagation();
    }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }
    $scope.Consultar_CIF = function(event) {
        console.log(event);
        if (scope.NumCifCli == undefined || scope.NumCifCli == null || scope.NumCifCli == '') {
            scope.toast('error','El número de CIF del Cliente es requerido','Número de CIF');
            return false;
        }
        $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/OtrasGestiones/get_valida_datos_clientes/NumCifCli/" + scope.NumCifCli;
        $http.get(url).then(function(result) {
            console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                if (result.data.status == false && result.data.statusText == "Error") {
                    scope.toast('error',result.data.menssage,result.data.statusText);
                    return false;
                }
                if (result.data.status == 200 && result.data.statusText == 'OK') {
                    $('#modal_agregar_gestion').modal('hide');
                    location.href = "#/Add_Gestion_Comercial/" + result.data.Cliente.CodCli + "/nueva";
                }
                if (result.data.status == true && result.data.statusText == 'Propuesta_Nueva') {
                    //$("#modal_agregar_gestion").modal('hide');
                    //location.href="#/Add_Propuesta_Comercial/"+result.data.CodCli+"/nueva";
                }
            } else {
                scope.toast('error','El número del CIF no se encuentra asignando a ningun cliente.','Error');
            }
        }, function(error) {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.generar_nueva_gestion = function() {
        $("#generar").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/OtrasGestiones/generarnuevagestion/CodCli/" + scope.fdatos.CodCli;
        $http.get(url).then(function(result) {
            $("#generar").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.RazSocCli = result.data.Cliente.RazSocCli;
                scope.NumCifCli = result.data.Cliente.NumCifCli;
                scope.List_GestionesComerciales = result.data.List_Gestiones;
                scope.FechaServer = result.data.fechagestion;
                scope.FecGesGen = result.data.fechagestion;
                scope.fdatos.NGesGen = result.data.n_gestion;
                $('.FecGesGen').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.fechagestion);
            } else {
                scope.toast('error','Error El Número de CIF no se encuentra registrado.','Error');
            }
        }, function(error) {
            $("#generar").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

    scope.traer_cups = function(TipCups) {
        scope.fdatos.CodCups = undefined;
        scope.ComerNom = undefined;
        console.log(TipCups);
        $("#CUPs").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/OtrasGestiones/buscar_cups/TipCups/" + TipCups + "/CodCli/" + scope.fdatos.CodCli;
        $http.get(url).then(function(result) {
            $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.ListCUPs = result.data.Cups;
                //console.log(scope.ListCUPs);
            } else {
                scope.toast('error','El Cliente no tiene ningun CUPs Asignado.','Error');
            }

        }, function(error) {
            $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.filter_Cups = function(CodCups) {
        console.log(CodCups);
        console.log(scope.ListCUPs);
        scope.ComerNom = undefined;
        for (var i = 0; i < scope.ListCUPs.length; i++) {
            if (scope.ListCUPs[i].CodCups == CodCups) {
                scope.ComerNom = scope.ListCUPs[i].RazSocDis;
            }
        }
    }
    $scope.submitFormGestionComercial = function(event) {

        console.log(scope.fdatos);
        if (!scope.validar_campos_gestion()) {
            return false;
        }
        if (scope.fdatos.tipo == "nueva" || scope.fdatos.tipo == "renovar") {
            var title = '¿Seguro que desea registrar la Gestión Comercial?';
            var loader = "Guardando";
        }
        if (scope.fdatos.tipo == "ver" || scope.fdatos.tipo == "editar") {
            var title = '¿Seguro que desea actualizar la información de la Gestión Comercial?';
            var loader = "Actualizando";
        }

        Swal.fire({
            title: title,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + loader).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/OtrasGestiones/generargestioncomercial/";
                $http.post(url, scope.fdatos).then(function(result) {
                    if (result.data != false) {
                        $("#" + loader).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        if (result.data.status == 200 && result.data.statusText == 'OK') {
                            scope.toast('success',result.data.menssage,'Gestión Comercial');
                            location.href = "#/Edit_Gestion_Comercial/" + result.data.Gestion.CodGesGen + "/editar";
                            return false;
                        }
                        if (result.data.status == 201 && result.data.statusText == 'OK') {
                            scope.toast('info',result.data.menssage,'Gestión Comercial');
                            return false;
                        }

                    } else {
                        scope.toast('error','Ha ocurrido un error, intente nuevamente','');
                    }
                }, function(error) {
                    $("#" + loader).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.validar_campos_gestion = function() {
        resultado = true;
        if (!scope.fdatos.TipGesGen > 0) {
            scope.toast('error','Debe seleccionar un tipo de gestión.','Error');
            return false;
        }
        var FecGesGen1 = document.getElementById("FecGesGen").value;
        scope.FecGesGen = FecGesGen1;
        if (scope.FecGesGen == null || scope.FecGesGen == undefined || scope.FecGesGen == '') {
            scope.toast('error','La Fecha de registro es requerida.','');
            return false;
        } else {
            var FecGesGen = (scope.FecGesGen).split("/");
            if (FecGesGen.length < 3) {
                scope.toast('error','El formato Fecha de Registro correcto es DD/MM/YYYY','');
                event.preventDefault();
                return false;
            } else {
                if (FecGesGen[0].length > 2 || FecGesGen[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecGesGen[1].length > 2 || FecGesGen[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecGesGen[2].length < 4 || FecGesGen[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecGesGen.split("/");
                valuesEnd = scope.FechaServer.split("/");
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de registro no puede ser mayor al " + scope.FechaServer + " Verifique e intente nuevamente",'');
                    return false;
                }
                scope.fdatos.FecGesGen = FecGesGen[2] + "-" + FecGesGen[1] + "-" + FecGesGen[0];
            }
        }
        if (scope.fdatos.TipCups == undefined) {
            scope.toast('error','Debe seleccionar un Tipo de Suministro.','');
            return false;
        }
        if (!scope.fdatos.CodCups > 0) {
            scope.toast('error','Debe seleccionar un CUPs de la lista','');
            return false;
        }
        if (scope.fdatos.MecGesGen == undefined) {
            scope.toast('error','Debe seleccionar un Tipo de Mecanismo','');
            return false;
        }
        if (scope.fdatos.PreGesGen == undefined || scope.fdatos.PreGesGen == null || scope.fdatos.PreGesGen == '') {
            scope.toast('error','El Tipo de Precio es requerido','');
            return false;
        }
        if (scope.fdatos.RefGesGen == undefined || scope.fdatos.RefGesGen == null || scope.fdatos.RefGesGen == '') {
            scope.fdatos.RefGesGen = null;
        } else {
            scope.fdatos.RefGesGen = scope.fdatos.RefGesGen;
        }
        if (scope.fdatos.DesAnaGesGen == undefined || scope.fdatos.DesAnaGesGen == null || scope.fdatos.DesAnaGesGen == '') {
            scope.fdatos.DesAnaGesGen = null;
        } else {
            scope.fdatos.DesAnaGesGen = scope.fdatos.DesAnaGesGen;
        }
        if (scope.fdatos.ObsGesGen == undefined || scope.fdatos.ObsGesGen == null || scope.fdatos.ObsGesGen == '') {
            scope.fdatos.ObsGesGen = null;
        } else {
            scope.fdatos.ObsGesGen = scope.fdatos.ObsGesGen;
        }
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.validar_formatos_input = function(metodo, object) {
        console.log(object);
        console.log(metodo);
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.tmodal_filtros.RangFec = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecGesGen = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos.PreGesGen = numero.substring(0, numero.length - 1);
            }
        }


    }
    scope.buscarXIDGesGen = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/OtrasGestiones/buscarXIDGesGenData/CodGesGen/" + scope.fdatos.CodGesGen;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                if (result.data.status == 200 && result.data.statusText == "OK") {
                    //scope.fdatos=result.data;
                    scope.RazSocCli = result.data.GestionComercial.RazSocCli;
                    scope.NumCifCli = result.data.GestionComercial.NumCifCli;
                    scope.FecGesGen = result.data.GestionComercial.FecGesGen;
                    $('.FecGesGen').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecGesGen);
                    scope.FechaServer = result.data.FechaServer;
                    scope.fdatos.NGesGen = result.data.GestionComercial.NGesGen;
                    scope.fdatos.EstGesGen = result.data.GestionComercial.EstGesGen;
                    scope.fdatos.CodCli = result.data.GestionComercial.CodCli;
                    if (result.data.GestionComercial.CodCupsEle != null && result.data.GestionComercial.CodCupsGas == null) {
                        scope.fdatos.TipCups = 0;
                        scope.traer_cups(scope.fdatos.TipCups, 1);
                        scope.fdatos.CodCups = result.data.GestionComercial.CodCupsEle;

                        setTimeout(function() {
                            console.log('hola');
                            scope.filter_Cups(scope.fdatos.CodCups);
                            scope.GestionesComercialesAll();
                        }, 5000)

                    }
                    if (result.data.GestionComercial.CodCupsGas != null && result.data.GestionComercial.CodCupsEle == null) {
                        scope.fdatos.TipCups = 1;
                        scope.traer_cups(scope.fdatos.TipCups, 2);
                        scope.fdatos.CodCups = result.data.GestionComercial.CodCupsGas;
                        setTimeout(function() {
                            console.log('hola');
                            scope.filter_Cups(scope.fdatos.CodCups);
                            scope.GestionesComercialesAll();
                        }, 5000)
                    }
                    if (result.data.GestionComercial.MecGesGen == 0) {
                        scope.fdatos.MecGesGen = 0;
                    }
                    if (result.data.GestionComercial.MecGesGen == 1) {
                        scope.fdatos.MecGesGen = 1;
                    }
                    scope.fdatos.PreGesGen = result.data.GestionComercial.PreGesGen;
                    scope.fdatos.RefGesGen = result.data.GestionComercial.RefGesGen;
                    scope.fdatos.DesAnaGesGen = result.data.GestionComercial.DesAnaGesGen;
                    scope.fdatos.ObsGesGen = result.data.GestionComercial.ObsGesGen;
                    scope.fdatos.CodGesGen = result.data.GestionComercial.CodGesGen;
                    scope.List_GestionesComerciales = result.data.List_Gestiones;
                    scope.fdatos.TipGesGen = result.data.GestionComercial.TipGesGen;
                }


            } else {
                scope.toast('error','El Código de la gestión comercial no existe.','Error');
                location.href = "#/Otras_Gestiones";
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
    scope.GestionesComercialesAll = function() {
        $("#cargando1").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/OtrasGestiones/get_list_gestiones_comerciales";
        $http.get(url).then(function(result) {
            $("#cargando1").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.TListGestiones = result.data;
                scope.TListGestionesBack = result.data;
                $scope.totalItems = scope.TListGestiones.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.TListGestiones.indexOf(value);
                    return (begin <= index && index < end);
                }
                scope.buscartiposgestiones();
            } else {
                
                scope.TListGestiones = [];
                scope.TListGestionesBack = [];
            }

        }, function(error) {
            $("#cargando1").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.regresar = function() {
        Swal.fire({
            title: "Estás seguro de regresar y no realizar los cambios?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK"
        }).then(function(t) {
            if (t.value == true) {
                location.href = "#/Otras_Gestiones";
            } else {
                console.log('Cancelando ando...');
            }
        });
    }
    if (scope.fdatos.CodCli != undefined && scope.fdatos.tipo == "nueva") {
        scope.fdatos.EstGesGen = "P";
        scope.fdatos.TipCups = undefined;
        scope.fdatos.MecGesGen = undefined;
        scope.generar_nueva_gestion();
    }
    if (scope.fdatos.CodGesGen != undefined && scope.fdatos.tipo == "editar" || scope.fdatos.CodGesGen != undefined && scope.fdatos.tipo == "ver") {
        scope.buscarXIDGesGen();
    }
    if ($route.current.$$route.originalPath == "/Otras_Gestiones/") {
        scope.FecGesGen = true;
        scope.TipGesGen = true;
        scope.NifCliente = true;
        scope.CodCli = true;
        scope.RazSocCli=true;
        scope.PreGesGen = true;
        scope.RefGesGen = true;
        scope.EstGesGen = true;
        scope.CUPsElec=true;
        scope.CUPsGas=true;
        scope.ActGesGen = true;
        scope.ruta_reportes_pdf_gestiones = 0;
        scope.ruta_reportes_excel_gestiones = 0;
        scope.TListGestiones = [];
        scope.TListGestionesBack = [];
        scope.tmodal_filtros = {};
        scope.GestionesComercialesAll();
        scope.opciones_gestiones = [{ id: 1, nombre: 'Ver' }, { id: 2, nombre: 'Editar' }];
    }
    scope.validar_opcion_gestiones = function(index, opcion_select, dato) {
        if (opcion_select == 1) {
            location.href = "#/Edit_Gestion_Comercial/" + dato.CodGesGen + "/ver";
        }
        if (opcion_select == 2) {
            location.href = "#/Edit_Gestion_Comercial/" + dato.CodGesGen + "/editar";
        }
    }
    $scope.SubmitFormFiltrosGestiones = function(event) {
        if (scope.tmodal_filtros.tipo_filtro == 1) {

            var RangFec1 = document.getElementById("RangFec").value;
            scope.tmodal_filtros.RangFec = RangFec1;
            if (scope.tmodal_filtros.RangFec == undefined || scope.tmodal_filtros.RangFec == null || scope.tmodal_filtros.RangFec == '') {
                scope.toast('error','Debe indicar una fecha para poder aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            //scope.TListGestiones=result.data;
            scope.TListGestiones = $filter('filter')(scope.TListGestionesBack, { FecGesGen: scope.tmodal_filtros.RangFec }, true);
            $scope.totalItems = scope.TListGestiones.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TListGestiones.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.RangFec;
            scope.ruta_reportes_excel_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.RangFec;
        }
        if (scope.tmodal_filtros.tipo_filtro == 2) {
            if (!scope.tmodal_filtros.CodCliFil > 0) {
                scope.toast('error','Debe seleccionar un cliente para aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            //scope.TListGestiones=result.data;
            scope.TListGestiones = $filter('filter')(scope.TListGestionesBack, { CodCli: scope.tmodal_filtros.CodCliFil }, true);
            $scope.totalItems = scope.TListGestiones.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TListGestiones.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.CodCliFil;
            scope.ruta_reportes_excel_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.CodCliFil;
        }
        if (scope.tmodal_filtros.tipo_filtro == 3) {
            if (!scope.tmodal_filtros.EstGesGenFil > 0) {
                scope.toast('error','Debe seleccionar un estatus para aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TListGestiones = $filter('filter')(scope.TListGestionesBack, { EstGesGen: scope.tmodal_filtros.EstGesGenFil }, true);
            $scope.totalItems = scope.TListGestiones.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TListGestiones.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.EstGesGenFil;
            scope.ruta_reportes_excel_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.EstGesGenFil;
        }
        if (scope.tmodal_filtros.tipo_filtro == 4) {
            if (!scope.tmodal_filtros.TipoGestion > 0) {
                scope.toast('error','Debe Seleccionar un Tipo de Gestión para aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            //scope.TListGestiones=result.data;
            scope.TListGestiones = $filter('filter')(scope.TListGestionesBack, { TipGesGen: scope.tmodal_filtros.TipoGestion }, true);
            $scope.totalItems = scope.TListGestiones.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TListGestiones.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.TipoGestion;
            scope.ruta_reportes_excel_gestiones = scope.tmodal_filtros.tipo_filtro + "/" + scope.tmodal_filtros.TipoGestion;
        }
    };
    scope.regresar_filtro = function() {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.TListGestiones = scope.TListGestionesBack;
        $scope.totalItems = scope.TListGestiones.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.TListGestiones.indexOf(value);
            return (begin <= index && index < end);
        }
        scope.ruta_reportes_pdf_gestiones = 0;
        scope.ruta_reportes_excel_gestiones = 0;
        scope.tmodal_filtros = {};
        scope.NumCifCliFil = undefined;
    }
    scope.buscartiposgestiones = function() {
        var url = base_urlHome() + "api/OtrasGestiones/get_tipo_gestiones/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                scope.ListTipGes = result.data;
            } else {
                console.log('No existen tipo de gestiones registradas.');
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


    scope.FetchOtrasGestionesFilter=function()
    {

        var searchText_len = scope.filtrar_search.trim().length;
        scope.fdatos.filtrar_search = scope.filtrar_search;
        if (searchText_len > 0) {
            var url = base_urlHome() + "api/OtrasGestiones/FetchOtrasGestionesFilter";
            $http.post(url, scope.fdatos).then(function(result) {
                // console.log(result);
                if (result.data != false) {
                    $scope.predicate = 'id';
                    $scope.reverse = true;
                    $scope.currentPage = 1;
                    $scope.order = function(predicate) {
                        $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                        $scope.predicate = predicate;
                    };
                    scope.TListGestiones = result.data;
                    $scope.totalItems = scope.TListGestiones.length;
                    $scope.numPerPage = 50;
                    $scope.paginate = function(value) {
                        var begin, end, index;
                        begin = ($scope.currentPage - 1) * $scope.numPerPage;
                        end = begin + $scope.numPerPage;
                        index = scope.TListGestiones.indexOf(value);
                        return (begin <= index && index < end);
                    }
                    scope.ruta_reportes_pdf_gestiones = 5  + "/"+scope.filtrar_search;
                    scope.ruta_reportes_excel_gestiones = 5 + "/"+scope.filtrar_search; 
                }
                else 
                {
                        scope.TListGestiones =[];
                        scope.ruta_reportes_pdf_gestiones =0;
                        scope.ruta_reportes_excel_gestiones =0;
                }
            }, function(error) 
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
        else
        {
                    $scope.predicate = 'id';
                    $scope.reverse = true;
                    $scope.currentPage = 1;
                    $scope.order = function(predicate) {
                        $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                        $scope.predicate = predicate;
                    };
                    scope.TListGestiones = scope.TListGestionesBack;
                    $scope.totalItems = scope.TListGestiones.length;
                    $scope.numPerPage = 50;
                    $scope.paginate = function(value) {
                        var begin, end, index;
                        begin = ($scope.currentPage - 1) * $scope.numPerPage;
                        end = begin + $scope.numPerPage;
                        index = scope.TListGestiones.indexOf(value);
                        return (begin <= index && index < end);
                    }
                    scope.ruta_reportes_pdf_gestiones = 0;
                    scope.ruta_reportes_excel_gestiones = 0; 

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
    if($route.current.$$route.originalPath=="/Otras_Gestiones/")
    {
       scope.buscartiposgestiones(); 
    }
    //////////////////////////////////////////////////////////////////////TIPO GESTIONES END///////////////////////////////////////////////////////////////////////////
}