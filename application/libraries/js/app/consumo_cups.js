app.controller('Controlador_Consumo_Cups', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceCups', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceCups) {
    var scope = this;
    scope.fdatos = {};
    scope.fdatos_cups = {};
    scope.CodCup = $route.current.params.CodCup;
    scope.TipServ = $route.current.params.TipServ;
    scope.CodPunSum = $route.current.params.CodPunSum;
    scope.Nivel = $cookies.get('nivel');
    scope.TCups_Consumo = [];
    scope.TCups_ConsumoBack = [];


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
    /*ServiceCups.getAll().then(function(dato) 
    {
    	//scope.TCups_Consumo=dato.Cups;
    	//scope.TCups_ConsumoBack=dato.Cups;
    	
    }).catch(function(err){console.log(err);});	*/
    console.log($route.current.$$route.originalPath);
    scope.cargar_lista_consumo_CUPs = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Cups/get_Historicos_Consumos_CUPs/TipServ/" + scope.TipServ + "/CodCup/" + scope.CodCup + "/CodPunSum/" + scope.CodPunSum;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");

            scope.CUPs = result.data.Name_CUPs.CUPs;
            scope.NomTar = result.data.Name_CUPs.NomTar;

            scope.Cups_Cif = result.data.Datos_Puntos.NumCifCli;
            scope.Cups_RazSocCli = result.data.Datos_Puntos.RazSocCli;
            scope.Cups_Dir = result.data.Datos_Puntos.DesTipVia + " " + result.data.Datos_Puntos.NomViaPunSum + " " + result.data.Datos_Puntos.NumViaPunSum + " " + result.data.Datos_Puntos.BloPunSum + " " + result.data.Datos_Puntos.EscPunSum + " " + result.data.Datos_Puntos.PlaPunSum + " " + result.data.Datos_Puntos.PuePunSum + " " + result.data.Datos_Puntos.DesPro + " " + result.data.Datos_Puntos.DesLoc + " " + result.data.Datos_Puntos.CPLoc;
            scope.fdatos_cups.CodTar = result.data.Name_CUPs.CodTar;
            scope.totalPot = result.data.Name_CUPs.CanPerTar;
            console.log(scope.totalPot);

            if (result.data.Consumo_CUPs == false) {
                scope.toast('info','No se encontrados consumos regitrados actualmente.','Consumos');
                scope.TCups_Consumo = [];
                scope.TCups_ConsumoBack = [];
            }
            if (result.data.Datos_Puntos == false) {
                scope.toast('error','No se encontrados datos relacionados con el Dirección de Suministro intente nuevamente.','Dirección Suministro');
                scope.TCups_Consumo = [];
                scope.disabled_button_add = false;
                scope.TCups_ConsumoBack = [];
            }
            if (result.data.Consumo_CUPs != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate1;
                };
                scope.TCups_Consumo = result.data.Consumo_CUPs;
                scope.TCups_ConsumoBack = result.data.Consumo_CUPs;
                $scope.totalItems = scope.TCups_Consumo.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.TCups_Consumo.indexOf(value);
                    return (begin <= index && index < end);
                };
            }
            if (result.data.Consumo_CUPs == false && result.data.Name_CUPs == false) {
                scope.toast('error','No hemos encontrados ningun dato relacionado con la busqueda que esta intentando realizar por favor verique los datos e intente nuevamente.','Error');
                scope.disabled_button_add = false;
                scope.TCups_Consumo = [];
                scope.TCups_ConsumoBack = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            scope.TCups_Consumo = [];
            scope.TCups_ConsumoBack = [];
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
    if ($route.current.$$route.originalPath == "/Consumo_CUPs/:CodCup/:TipServ/:CodPunSum") {
        scope.cargar_lista_consumo_CUPs();
        scope.ruta_reportes_pdf_consumo_cups = scope.CodCup + "/" + scope.TipServ + "/" + scope.CodPunSum;
        scope.ruta_reportes_excel_consumo_cups = scope.CodCup + "/" + scope.TipServ + "/" + scope.CodPunSum;
        scope.topciones = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }];
    }
    console.log(scope.CodCup);
    console.log(scope.TipServ);
    console.log(scope.CodPunSum);
    console.log(scope.Nivel);
    console.log(fecha);
    scope.TVistaConCups = true;
    scope.Cups = true;
    scope.ConCup = true;
    scope.Cups_Tar = true;
    scope.Cups_Acc = true;
    scope.FecIniCon = true;
    scope.FecFinCon = true;

    scope.agregar_consumo_cups = function() {
        scope.TVistaConCups = false;
        scope.regresar = "#/Consumo_CUPs/" + scope.CodCup + "/" + scope.TipServ + "/" + scope.CodPunSum;
        $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate");
        $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate");
        if (scope.TipServ == "Eléctrico") {
            scope.fdatos_cups.TipServ = 1;
        }
        if (scope.TipServ == "Gas") {
            scope.fdatos_cups.TipServ = 2;
        }
    }
    scope.validar_opcion_consumo_cups = function(index, opciones_consumo_CUPs, dato) {
        console.log(index);
        console.log(opciones_consumo_CUPs);
        console.log(dato);
        scope.opciones_consumo_CUPs[index] = undefined;
        if (opciones_consumo_CUPs == 1) {
            scope.validate_info = 1;
            scope.TVistaConCups = false;
            scope.fdatos_cups.CodConCup = dato.CodConCup;
            scope.fdatos_cups.FecIniCon = dato.FecIniCon;
            scope.fdatos_cups.FecFinCon = dato.FecFinCon;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fdatos_cups.FecIniCon);
            $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fdatos_cups.FecFinCon);
            scope.fdatos_cups.ConCup = dato.ConCup;
            if (scope.TipServ == "Eléctrico") {
                scope.fdatos_cups.TipServ = 1;
                var url = base_urlHome() + "api/Cups/buscar_datos_electrico/CodConCup/" + dato.CodConCup;
                $http.get(url).then(function(result) {
                    if (result.data != false) {
                        scope.fdatos_cups.PotCon1 = result.data.PotCon1;
                        scope.fdatos_cups.PotCon2 = result.data.PotCon2;
                        scope.fdatos_cups.PotCon3 = result.data.PotCon3;
                        scope.fdatos_cups.PotCon4 = result.data.PotCon4;
                        scope.fdatos_cups.PotCon5 = result.data.PotCon5;
                        scope.fdatos_cups.PotCon6 = result.data.PotCon6;
                    } else {
                        scope.toast('error','Error en cargar los datos.','Error');                        

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
            if (scope.TipServ == "Gas") {
                scope.fdatos_cups.TipServ = 2;
            }

        }
        if (opciones_consumo_CUPs == 2) {
            scope.validate_info = undefined;
            scope.TVistaConCups = false;
            scope.fdatos_cups.CodConCup = dato.CodConCup;
            scope.fdatos_cups.FecIniCon = dato.FecIniCon;
            scope.fdatos_cups.FecFinCon = dato.FecFinCon;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fdatos_cups.FecIniCon);
            $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fdatos_cups.FecFinCon);
            scope.fdatos_cups.ConCup = dato.ConCup;
            if (scope.TipServ == "Eléctrico") {
                scope.fdatos_cups.TipServ = 1;
                var url = base_urlHome() + "api/Cups/buscar_datos_electrico/CodConCup/" + dato.CodConCup;
                $http.get(url).then(function(result) {
                    if (result.data != false) {
                        scope.fdatos_cups.PotCon1 = result.data.PotCon1;
                        scope.fdatos_cups.PotCon2 = result.data.PotCon2;
                        scope.fdatos_cups.PotCon3 = result.data.PotCon3;
                        scope.fdatos_cups.PotCon4 = result.data.PotCon4;
                        scope.fdatos_cups.PotCon5 = result.data.PotCon5;
                        scope.fdatos_cups.PotCon6 = result.data.PotCon6;
                    } else {
                        scope.toast('error','Error en cargar los datos.','Error');

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
            if (scope.TipServ == "Gas") {
                scope.fdatos_cups.TipServ = 2;
            }
        }
        if (opciones_consumo_CUPs == 3) {
            if (dato.EstConCup == "DADO DE BAJA") {
                scope.toast('error','El CUPs Ya Fue Dado de Baja.','Error');
                return false;
            }
            var url = base_urlHome() + "api/Cups/list_motivos_bloqueo_CUPs";
            $http.get(url).then(function(result) {
                if (result.data != false) {
                    $("#modal_motivo_bloqueo").modal('show');
                    scope.tMotivosBloqueos = result.data;
                    scope.tmodal_data = {};
                    scope.tmodal_data.FecBaj = fecha;
                    scope.tmodal_data.TipServ = dato.TipServ;
                    scope.CupsNom = dato.CUPs;
                    scope.NumCifCUPs = scope.Cups_Cif;
                    scope.RazSocCUPs = scope.Cups_RazSocCli;
                    scope.DirPunSumCUPs = scope.Cups_Dir;
                    scope.tmodal_data.CodConCup = dato.CodConCup;
                } else {
                    scope.toast('info','No existen motivos de bloqueos registrados, contacte un administrador y notifiquelo.','Información');
                   
                }

            }, function(error) {
                $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
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
    scope.regresar_consumo_cups = function() {
        scope.TVistaConCups = true;
        scope.fdatos_cups = {};
        scope.cargar_lista_consumo_CUPs();
    }
    scope.validar_fecha_inputs = function(metodo, object) {
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotCon1 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotCon2 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotCon3 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 4) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotCon4 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 5) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotCon5 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 6) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotCon6 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 7) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos_cups.FecIniCon = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 8) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos_cups.FecFinCon = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 9) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.ConCup = numero.substring(0, numero.length - 1);
            }
        }
    }
    $scope.submitFormCups = function(event) {
        scope.fdatos_cups.CodPunSum = scope.CodPunSum;
        scope.fdatos_cups.CodCup = scope.CodCup;
        console.log(scope.fdatos_cups);
        if (!scope.validar_campos_cups()) {
            return false;
        }
        if (scope.fdatos_cups.CodConCup > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del CUPs?';
            var response = "CUPs actualizado de forma correcta";
        }
        if (scope.fdatos_cups.CodConCup == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el consumo de CUPs?';
            var response = "Consumo de CUPs creado de forma correcta";
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
                console.log(scope.fdatos_cups);
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Cups/Registar_Consumo_CUPs/";
                $http.post(url, scope.fdatos_cups).then(function(result) {
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        scope.toast('success',response,title);
                        scope.fdatos_cups = result.data;
                    } else {
                        scope.toast('error','Error en la operación, por favor intente nuevamente.','Error');
                       
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
                event.preventDefault();
            }
        });
    };
    scope.validar_campos_cups = function() {
        resultado = true;
        if (scope.fdatos_cups.TipServ == 1) {


            if (scope.totalPot == null) {
                scope.toast('error','Este CUPs no tiene ninguna Tárifa asignada, asigne la tárifa en la opción Gestionar CUPs','');
                return false;
            }

            if (scope.totalPot == 1) {
                if (scope.fdatos_cups.PotCon1 == null || scope.fdatos_cups.PotCon1 == undefined || scope.fdatos_cups.PotCon1 == '') {
                    scope.toast('error','','El Campo P1 Es requerido');
                   return false;
                }
                scope.fdatos_cups.PotCon2 = null;
                scope.fdatos_cups.PotCon3 = null;
                scope.fdatos_cups.PotCon4 = null;
                scope.fdatos_cups.PotCon5 = null;
                scope.fdatos_cups.PotCon6 = null;
            }
            if (scope.totalPot == 2) {
                if (scope.fdatos_cups.PotCon1 == null || scope.fdatos_cups.PotCon1 == undefined || scope.fdatos_cups.PotCon1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon2 == null || scope.fdatos_cups.PotCon2 == undefined || scope.fdatos_cups.PotCon2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                scope.fdatos_cups.PotCon3 = null;
                scope.fdatos_cups.PotCon4 = null;
                scope.fdatos_cups.PotCon5 = null;
                scope.fdatos_cups.PotCon6 = null;
            }
            if (scope.totalPot == 3) {
                if (scope.fdatos_cups.PotCon1 == null || scope.fdatos_cups.PotCon1 == undefined || scope.fdatos_cups.PotCon1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon2 == null || scope.fdatos_cups.PotCon2 == undefined || scope.fdatos_cups.PotCon2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon3 == null || scope.fdatos_cups.PotCon3 == undefined || scope.fdatos_cups.PotCon3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                scope.fdatos_cups.PotCon4 = null;
                scope.fdatos_cups.PotCon5 = null;
                scope.fdatos_cups.PotCon6 = null;
            }
            if (scope.totalPot == 4) {
                if (scope.fdatos_cups.PotCon1 == null || scope.fdatos_cups.PotCon1 == undefined || scope.fdatos_cups.PotCon1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon2 == null || scope.fdatos_cups.PotCon2 == undefined || scope.fdatos_cups.PotCon2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon3 == null || scope.fdatos_cups.PotCon3 == undefined || scope.fdatos_cups.PotCon3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon4 == null || scope.fdatos_cups.PotCon4 == undefined || scope.fdatos_cups.PotCon4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                scope.fdatos_cups.PotCon5 = null;
                scope.fdatos_cups.PotCon6 = null;
            }
            if (scope.totalPot == 5) {
                if (scope.fdatos_cups.PotCon1 == null || scope.fdatos_cups.PotCon1 == undefined || scope.fdatos_cups.PotCon1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon2 == null || scope.fdatos_cups.PotCon2 == undefined || scope.fdatos_cups.PotCon2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon3 == null || scope.fdatos_cups.PotCon3 == undefined || scope.fdatos_cups.PotCon3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon4 == null || scope.fdatos_cups.PotCon4 == undefined || scope.fdatos_cups.PotCon4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon5 == null || scope.fdatos_cups.PotCon5 == undefined || scope.fdatos_cups.PotCon5 == '') {
                    scope.toast('error','El Campo P5 Es requerido','');
                    return false;
                }
                scope.fdatos_cups.PotCon6 = null;
            }
            if (scope.totalPot == 6) {
                if (scope.fdatos_cups.PotCon1 == null || scope.fdatos_cups.PotCon1 == undefined || scope.fdatos_cups.PotCon1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon2 == null || scope.fdatos_cups.PotCon2 == undefined || scope.fdatos_cups.PotCon2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                   return false;
                }
                if (scope.fdatos_cups.PotCon3 == null || scope.fdatos_cups.PotCon3 == undefined || scope.fdatos_cups.PotCon3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon4 == null || scope.fdatos_cups.PotCon4 == undefined || scope.fdatos_cups.PotCon4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon5 == null || scope.fdatos_cups.PotCon5 == undefined || scope.fdatos_cups.PotCon5 == '') {
                    scope.toast('error','El Campo P5 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotCon6 == null || scope.fdatos_cups.PotCon6 == undefined || scope.fdatos_cups.PotCon6 == '') {
                    scope.toast('error','El Campo P6 Es requerido','');
                    return false;
                }
            }

        }
        var desde = document.getElementById("desde").value;
        scope.fdatos_cups.FecIniCon = desde;
        if (scope.fdatos_cups.FecIniCon == null || scope.fdatos_cups.FecIniCon == undefined || scope.fdatos_cups.FecIniCon == '') {
            scope.toast('error','El Campo Fecha Desde Es requerido','');
            return false;
        } else {
            var FecIniCon = (scope.fdatos_cups.FecIniCon).split("/");
            if (FecIniCon.length < 3) {
                scope.toast('error','El Formato de la fecha Desde debe Ser EJ: DD/MM/YYYY.','');
                return false;
            } else {
                if (FecIniCon[0].length > 2 || FecIniCon[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    return false;

                }
                if (FecIniCon[1].length > 2 || FecIniCon[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');                    	
                    return false;
                }
                if (FecIniCon[2].length < 4 || FecIniCon[2].length > 4) {
                   scope.toast('error','Error en Año, debe introducir cuatro números','');
                   return false;
                }
                var h1 = new Date();
                var final = FecIniCon[0] + "/" + FecIniCon[1] + "/" + FecIniCon[2];
                scope.fdatos_cups.FecIniCon = final;
            }

        }
        var hasta = document.getElementById("hasta").value;
        scope.fdatos_cups.FecFinCon = hasta;
        if (scope.fdatos_cups.FecFinCon == null || scope.fdatos_cups.FecFinCon == undefined || scope.fdatos_cups.FecFinCon == '') {
            scope.toast('error','La Fecha Hasta es requerida','');
            return false;
        } else {
            var FecFinCon = (scope.fdatos_cups.FecFinCon).split("/");
            if (FecFinCon.length < 3) {
                scope.toast('error','El formato Fecha Hasta correcto es DD/MM/YYYY','');
                return false;
            } else {
                if (FecFinCon[0].length > 2 || FecFinCon[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    return false;

                }
                if (FecFinCon[1].length > 2 || FecFinCon[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    return false;
                }
                if (FecFinCon[2].length < 4 || FecFinCon[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    return false;
                }
                var h1 = new Date();
                var final_UltFec = FecFinCon[0] + "/" + FecFinCon[1] + "/" + FecFinCon[2];
                scope.fdatos_cups.FecFinCon = final_UltFec;
            }
        }        
        if (scope.fdatos_cups.TipServ == 2) {
            if (scope.fdatos_cups.ConCup == null || scope.fdatos_cups.ConCup == undefined || scope.fdatos_cups.ConCup == '') {
                scope.toast('error','El Campo Consumo es requerido','');
                return false;
            }
            scope.fdatos_cups.PotCon1 = null;
            scope.fdatos_cups.PotCon2 = null;
            scope.fdatos_cups.PotCon3 = null;
            scope.fdatos_cups.PotCon4 = null;
            scope.fdatos_cups.PotCon5 = null;
            scope.fdatos_cups.PotCon6 = null;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    $scope.submitFormlockCUPs = function(event) {
        console.log(scope.tmodal_data);
        if (scope.tmodal_data.ObsMotCUPs == undefined || scope.tmodal_data.ObsMotCUPs == null || scope.tmodal_data.ObsMotCUPs == '') {
            scope.tmodal_data.ObsMotCUPs = null;
        } else {
            scope.tmodal_data.ObsMotCUPs = scope.tmodal_data.ObsMotCUPs;
        }
        Swal.fire({
            title: 'Dar Baja CUPs',
            text: 'Esta Seguro Dar de Baja Este Consumo CUPs',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Dar de Baja"
        }).then(function(t) {
            if (t.value == true) {
                $("#Baja").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Cups/Dar_Baja_Consumo_Cups/";
                $http.post(url, scope.tmodal_data).then(function(result) {
                    $("#Baja").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        scope.toast('success','El CUPs ha sido dado de baja de forma correcta','CUPs');
                        scope.tmodal_data = {};
                        $("#modal_motivo_bloqueo").modal('hide');
                        scope.cargar_lista_consumo_CUPs();
                    } else {
                        scope.toast('error','Error en la operación por favor intente nuevamente.','');
                        scope.cargar_lista_consumo_CUPs();
                    }
                }, function(error) {
                    $("#Baja").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
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



}