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
    console.log($route.current.$$route.originalPath);

    scope.fetchClientes = function(metodo) {
        if (metodo == 1) {
            var searchText_len = scope.NumCifCli.trim().length;
            scope.fdatos.NumCifCli = scope.NumCifCli;
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/OtrasGestiones/getclientes";
                $http.post(url, scope.fdatos).then(function(result) {
                    console.log(result);
                    if (result.data != false) {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    } else {
                        Swal.fire({ title: "Error", text: "No hay Clientes registrados", type: "error", confirmButtonColor: "#188ae2" });
                        scope.searchResult = {};
                    }
                }, function(error) {
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
            } else {
                scope.searchResult = {};
            }
        }
        /*if(metodo==2)
        {
            var searchText_len = scope.NumCifCli.trim().length;
            scope.fdatos.NumCifCli=scope.NumCifCli;   
            if(searchText_len > 0)
            {
                var url = base_urlHome()+"api/PropuestaComercial/getclientes";
                $http.post(url,scope.fdatos).then(function(result)
                {
                    console.log(result);
                    if (result.data != false)
                    {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No hay Clientes registrados", type: "error", confirmButtonColor: "#188ae2" });                    
                        scope.searchResult = {};
                    }
                }, function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found")
                    {
                        Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized")
                    {
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden")
                    {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
            else
            {
                scope.searchResult = {};
            }      
        }*/


    }
    scope.setValue = function(index, $event, result, metodo) {
        if (metodo == 1) {
            scope.NumCifCli = scope.searchResult[index].NumCifCli;
            scope.searchResult = {};
            $event.stopPropagation();
        }
        /*if(metodo==2)
        {
            scope.CodCliFil=scope.searchResult[index].CodCli;
            scope.NumCifCli=scope.searchResult[index].NumCifCli;
            scope.searchResult = {};
            $event.stopPropagation(); 
        }*/

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
            Swal.fire({ title: 'Número de CIF', text: 'El número de CIF del Cliente es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/OtrasGestiones/get_valida_datos_clientes/NumCifCli/" + scope.NumCifCli;
        $http.get(url).then(function(result) {
            console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                if (result.data.status == false && result.data.statusText == "Error") {
                    Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "El número del CIF no se encuentra asignando a ningun cliente.", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "Error El Número de CIF no se encuentra registrado.", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#generar").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "El Cliente no tiene ningun CUPs Asignado.", type: "error", confirmButtonColor: "#188ae2" });
            }

        }, function(error) {
            $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                            Swal.fire({ title: "Gestión Comercial", text: result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });
                            location.href = "#/Edit_Gestion_Comercial/" + result.data.Gestion.CodGesGen + "/editar";
                            return false;
                        }
                        if (result.data.status == 201 && result.data.statusText == 'OK') {
                            Swal.fire({ title: "Gestión Comercial", text: result.data.menssage, type: "info", confirmButtonColor: "#188ae2" });
                            return false;
                        }
                        /*if(result.data.status==true && result.data.statusText=='Propuesta Comercial')
                        {
                            Swal.fire({ title:result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });
                            location.reload();
                            return false;
                            
                        }
                        Swal.fire({ title: "Propuesta Comercial", text: "Propuesta Comercial generada correctamente bajo el número de referencia: "+result.data.RefProCom, type: "success", confirmButtonColor: "#188ae2" });
                        location.href="#/Propuesta_Comercial";*/
                    } else {
                        Swal.fire({ text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#" + loader).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
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
    scope.validar_campos_gestion = function() {
        resultado = true;
        if (!scope.fdatos.TipGesGen > 0) {
            Swal.fire({ title: "Error", text: "Debe seleccionar un tipo de gestión.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        var FecGesGen1 = document.getElementById("FecGesGen").value;
        scope.FecGesGen = FecGesGen1;
        if (scope.FecGesGen == null || scope.FecGesGen == undefined || scope.FecGesGen == '') {
            Swal.fire({ title: "La Fecha de registro es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecGesGen = (scope.FecGesGen).split("/");
            if (FecGesGen.length < 3) {
                Swal.fire({ title: "El formato Fecha de Registro correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecGesGen[0].length > 2 || FecGesGen[0].length < 2) {
                    Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecGesGen[1].length > 2 || FecGesGen[1].length < 2) {
                    Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecGesGen[2].length < 4 || FecGesGen[2].length > 4) {
                    Swal.fire({ title: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecGesGen.split("/");
                valuesEnd = scope.FechaServer.split("/");
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ title: "La Fecha de registro no puede ser mayor al " + scope.FechaServer + " Verifique e intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.fdatos.FecGesGen = FecGesGen[2] + "-" + FecGesGen[1] + "-" + FecGesGen[0];
            }
        }
        if (scope.fdatos.TipCups == undefined) {
            Swal.fire({ title: "Debe seleccionar un Tipo de Suministro", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodCups > 0) {
            Swal.fire({ title: "Debe seleccionar un CUPs de la lista", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.MecGesGen == undefined) {
            Swal.fire({ title: "Debe seleccionar un Tipo de Mecanismo", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.PreGesGen == undefined || scope.fdatos.PreGesGen == null || scope.fdatos.PreGesGen == '') {
            Swal.fire({ title: "El Tipo de Precio es requerido", type: "error", confirmButtonColor: "#188ae2" });
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
                    scope.RangFec = numero.substring(0, numero.length - 1);
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
                Swal.fire({ title: "Erro", text: "El Código de la gestión comercial no existe.", type: "error", confirmButtonColor: "#188ae2" });
                location.href = "#/Otras_Gestiones";
            }

        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
            } else {
                Swal.fire({ title: "Erro", text: "No hay gestiones comerciales registradas.", type: "error", confirmButtonColor: "#188ae2" });
                scope.TListGestiones = [];
                scope.TListGestionesBack = [];
                //location.href="#/Otras_Gestiones";
            }

        }, function(error) {
            $("#cargando1").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
        scope.CodCli = true;
        scope.PreGesGen = true;
        scope.RefGesGen = true;
        scope.EstGesGen = true;
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





    //////////////////////////////////////////////////////////////////////TIPO GESTIONES END///////////////////////////////////////////////////////////////////////////
}