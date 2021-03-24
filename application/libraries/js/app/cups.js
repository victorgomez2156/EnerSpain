app.controller('Controlador_Cups', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceCups', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceCups) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('Controlador_Clientes as vmAE',{$scope:$scope});
    //var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
    //$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
    //var testCtrl1ViewModel = $controller('Controlador_Clientes');
    //testCtrl1ViewModel.cargar_lista_clientes();
    var scope = this;
    scope.fdatos_cups = {};
    scope.CodCups = $route.current.params.CodCups;
    scope.TipServ = $route.current.params.TipServ;
    scope.validate_info = $route.current.params.INF;
    scope.CodCup = $route.current.params.CodCup;
    scope.Nivel = $cookies.get('nivel');
    scope.TCups = [];
    scope.TCupsBack = [];
    scope.fdatos_cups.TipServ = "0";
    scope.historial = {};
    scope.FecIniConHis = true;
    scope.FecFinConHis = true;
    scope.ConCupHis = true;

    scope.T_PuntoSuministrosVistaNuevaDireccion=false;
    scope.fdatos_cups.AgregarNueva=true;
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
    	scope.TCups=dato.Cups;
    	scope.TCupsBack=dato.Cups;
    	
    }).catch(function(err){console.log(err);});	*/
    console.log($route.current.$$route.originalPath);
    //console.log(scope.CodCups);
    //console.log(scope.TipServ);
    //console.log(scope.Nivel);
    ////console.log(fecha);
    //// console.log(scope.CodCup);
    scope.Cif = true;
    scope.CodCli = true;
    scope.RazSoc = true;
    scope.Cups = true;
    scope.Cups_Ser = true;
    scope.Cups_Tar = true;
    scope.Dir_Cups = true;
    scope.Cups_Acc = true;
    scope.EstCUPs = true;
    scope.ruta_reportes_pdf_cups = 0;
    scope.ruta_reportes_excel_cups = 0;
    scope.topciones = [{ id: 1, nombre: 'EDITAR' }, { id: 2, nombre: 'VER' }, { id: 3, nombre: 'CONSUMO' }, { id: 4, nombre: 'DAR BAJA' }, { id: 5, nombre: 'HISTORIAL' }];
    scope.Filtro_CUPs = [{ id: 1, nombre: 'TIPO SUMINISTRO' }, { id: 2, nombre: 'TARIFA' }, { id: 3, nombre: 'ESTATUS' }];
    scope.cargar_datos_nueva_dirPunSum=function()
    {
        var url=base_urlHome()+"api/Cups/getNuevaDirPunSum";
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.tTiposVias=result.data.tTiposVias;
                scope.tProvidencias=result.data.tProvidencias;
            }
            else
            {
                scope.toast('error','No se encontraron los tipos de vias y provincias para este metodo','Error');
                scope.tTiposVias=[];
                scope.tProvidencias=[];
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
    scope.cargar_lista_cups = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Cups/get_all_cups_PumSum/";
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data.Cups != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.TCups = result.data.Cups;
                scope.TCupsBack = result.data.Cups;
                $scope.totalItems = scope.TCups.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.TCups.indexOf(value);
                    return (begin <= index && index < end);
                };
                scope.fecha_server = result.data.Fecha;
            } else {
                
                scope.TCups = [];
                scope.TCupsBack = [];
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
    scope.agregar_cups = function() {
        location.href = "#/Add_Cups";
        scope.fdatos_cups.TipServ = 0;
    }
    scope.validar_opcion_cups = function(index, opciones_cups, dato) {
        console.log(index);
        console.log(opciones_cups);
        console.log(dato);
        scope.opciones_cups[index] = undefined;
        if (opciones_cups == 1) {
            location.href = "#/Edit_Cups/" + dato.CodCupGas + "/" + dato.TipServ;
        }
        if (opciones_cups == 2) {
            location.href = "#/Edit_Cups/" + dato.CodCupGas + "/" + dato.TipServ + "/" + 1;
        }
        if (opciones_cups == 3) {
            location.href = "#/Consumo_CUPs/" + dato.CodCupGas + "/" + dato.TipServ + "/" + dato.CodPunSum;
        }

        if (opciones_cups == 4) {
            if (dato.EstCUPs == "DADO DE BAJA") {
                scope.toast('error','El CUPs Ya Fue Dado de Baja.','Error');
                return false;
            }
            var url = base_urlHome() + "api/Cups/list_motivos_bloqueo_CUPs";
            $http.get(url).then(function(result) {
                if (result.data != false) {
                    $("#modal_motivo_bloqueo").modal('show');
                    scope.tMotivosBloqueos = result.data;
                    scope.tmodal_data = {};
                    scope.tmodal_data.FecBaj = scope.fecha_server;
                    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.tmodal_data.FecBaj);
                    scope.tmodal_data.TipServ = dato.TipServ;
                    scope.CupsNom = dato.CupsGas;
                    scope.NumCifCUPs = dato.Cups_Cif;
                    scope.RazSocCUPs = dato.Cups_RazSocCli;
                    scope.DirPunSumCUPs = dato.TipVia + " " + dato.NomViaPunSum + " " + dato.NumViaPunSum + " " + dato.BloPunSum + " " + dato.EscPunSum + " " + dato.PlaPunSum + " " + dato.PuePunSum + " " + dato.DesPro + " " + dato.DesLoc + " " + dato.CPLoc; //dato.Cups_Dir;
                    scope.tmodal_data.CodCUPs = dato.CodCupGas;
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
        if (opciones_cups == 5) {
            //$("#modal_motivo_bloqueo").modal('show');
            location.href = "#/Historial_Consumo_Cups/" + dato.CodCupGas + "/" + dato.TipServ;
            /*scope.TVistaCups=undefined;
            scope.historial={};
            scope.historial.CodCup=dato.CodCupGas;
            scope.historial.TipServ=dato.TipServ;
            console.log(scope.TVistaCups);
            scope.T_Historial_Consumo=[];
            scope.FecIniConHis=true;
            scope.FecFinConHis=true;
            scope.ConCupHis=true;*/
        }
    }
    scope.regresar_cups = function() {

        if (scope.validate_info == undefined) {
            if (scope.fdatos_cups.CodCup == undefined) {
                var title = "Guardando";
                var text = "¿Seguro que desea cerrar sin registrar el CUPs?";
            } else {
                var title = "Actualizando";
                var text = "¿Seguro que desea cerrar sin actualizar la información del CUPs?";
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
                    location.href = "#/Gestionar_Cups";
                } else {
                    console.log('Cancelando ando...');
                }
            });
        } else {
            location.href = "#/Gestionar_Cups";
        }
    }
    scope.regresar_a_cups = function() {
        location.href = "#/Gestionar_Cups";
    }
    scope.validar_fecha_inputs = function(metodo, object) {
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecAltCup = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos_cups.FecUltLec = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.ConAnuCup = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 4) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP1 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 5) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP2 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 6) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP3 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 7) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP4 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 8) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP5 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 9) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP6 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 10) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotMaxBie = numero.substring(0, numero.length - 1);
            }
        }

        if (metodo == 20) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.historial.desde = numero.substring(0, numero.length - 1);
            }
        }

        if (metodo == 21) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.historial.hasta = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 22) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.tmodal_data.FecBaj = numero.substring(0, numero.length - 1);
            }
        }
         if (metodo == 23) {
            if (object != undefined) {
                numero = object;
                if (!/^([,0-9])*$/.test(numero))
                    scope.fdatos_cups.DerAccKW = numero.substring(0, numero.length - 1);
            }
        }
    }
    $scope.submitFormlockCUPs = function(event) 
    {
        console.log(scope.tmodal_data);
        if (scope.tmodal_data.ObsMotCUPs == undefined || scope.tmodal_data.ObsMotCUPs == null || scope.tmodal_data.ObsMotCUPs == '') {
            scope.tmodal_data.ObsMotCUPs = null;
        } else {
            scope.tmodal_data.ObsMotCUPs = scope.tmodal_data.ObsMotCUPs;
        }
        var FecBaj = document.getElementById("FecBaj").value;
        scope.tmodal_data.FecBaj = FecBaj;
        if (scope.tmodal_data.FecBaj == undefined || scope.tmodal_data.FecBaj == null || scope.tmodal_data.FecBaj == '') {
            scope.toast('error','La Fecha de Bloqueo es requerida.','');
            event.preventDefault();
            return false;
        } else {
            var FecBaj = (scope.tmodal_data.FecBaj).split("/");
            if (FecBaj.length < 3) {
                scope.toast('error','El formato Fecha de Bloqueo correcto es DD/MM/YYYY','');
                event.preventDefault();
                return false;
            } else {
                if (FecBaj[0].length > 2 || FecBaj[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecBaj[1].length > 2 || FecBaj[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecBaj[2].length < 4 || FecBaj[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.tmodal_data.FecBaj.split("/");
                valuesEnd = scope.fecha_server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de Bloqueo no puede ser mayor al " + scope.fecha_server + " Verifique e intente nuevamente",'');
                    return false;
                }
            }
        }
        Swal.fire({
            title: 'Dar Baja CUPs',
            text: 'Esta Seguro Dar de Baja Este CUPs',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Dar de Baja"
        }).then(function(t) {
            if (t.value == true) {
                $("#Baja").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Cups/Dar_Baja_Cups/";
                $http.post(url, scope.tmodal_data).then(function(result) {
                    $("#Baja").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        scope.toast('success','El CUPs ha sido dado de baja de forma correcta','CUPs');
                        scope.tmodal_data = {};
                        $("#modal_motivo_bloqueo").modal('hide');
                        scope.cargar_lista_cups();
                    } else {
                        scope.toast('error','Error en la operación por favor intente nuevamente.','Error');
                        scope.cargar_lista_cups();
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
    scope.por_servicios = function(objecto) {
        if (scope.fdatos_cups.CodCup > 0 && scope.fdatos_cups.TipServ != scope.fdatos_cups.TipServAnt) {
            scope.fdatos_cups.PotConP1 = null;
            scope.fdatos_cups.PotConP2 = null;
            scope.fdatos_cups.PotConP3 = null;
            scope.fdatos_cups.PotConP4 = null;
            scope.fdatos_cups.PotConP5 = null;
            scope.fdatos_cups.PotConP6 = null;
            scope.fdatos_cups.PotMaxBie = null;
            scope.fdatos_cups.CodDis = null;
            scope.fdatos_cups.CodTar = null;
            scope.FecAltCup = null;
            scope.fdatos_cups.FecUltLec = null;
            scope.fdatos_cups.ConAnuCup = null;
        }
        if (scope.fdatos_cups.CodCup == undefined && scope.fdatos_cups.TipServAnt == undefined) {
            scope.fdatos_cups.PotConP1 = null;
            scope.fdatos_cups.PotConP2 = null;
            scope.fdatos_cups.PotConP3 = null;
            scope.fdatos_cups.PotConP4 = null;
            scope.fdatos_cups.PotConP5 = null;
            scope.fdatos_cups.PotConP6 = null;
            scope.fdatos_cups.PotMaxBie = null;
            scope.fdatos_cups.CodDis = null;
            scope.fdatos_cups.CodTar = null;
            scope.FecAltCup = null;
            scope.fdatos_cups.FecUltLec = null;
            scope.fdatos_cups.ConAnuCup = null;
        }
        scope.sin_data = 1;
        if (objecto == 1) {
            var url = base_urlHome() + "api/Cups/Por_Servicios";
            $http.post(url, scope.fdatos_cups).then(function(result) {
                if (result.data != false) {
                    scope.T_Distribuidoras = result.data.Distribuidoras;
                    scope.T_Tarifas = result.data.Tarifas;
                    scope.sin_data = 0;
                } else {
                    scope.toast('info','No existen datos registrados.','Error');
                    scope.sin_data = 1;
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
        if (objecto == 2) {
            var url = base_urlHome() + "api/Cups/Por_Servicios";
            $http.post(url, scope.fdatos_cups).then(function(result) {
                if (result.data != false) {
                    scope.T_Distribuidoras = result.data.Distribuidoras;
                    scope.T_Tarifas = result.data.Tarifas;
                    scope.sin_data = 0;
                } else {
                    scope.toast('error','No existen datos registrados.','Error');
                    scope.sin_data = 1;
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
    }
    scope.BuscarxIDCups = function() {
        
        if (scope.TipServ == "Eléctrico") {
            $("#cargandos_cups").removeClass("loader loader-defaul").addClass("loader loader-default is-active");
            var url = base_urlHome() + "api/Cups/Buscar_XID_Servicio/TipServ/" + 1 + "/CodCup/" + scope.CodCups;
            $http.get(url).then(function(result) {
                $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                if (result.data != false) {
                    scope.fdatos_cups = result.data;
                    scope.Cups_Cif = result.data.NumCifCli + " - " + result.data.RazSocCli;
                    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecAltCup);
                    $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecUltLec);
                    scope.FecAltCup=result.data.FecAltCup;
                    //scope.TVistaCups=false;
                    scope.por_servicios(1);
                    console.log(result.data);
                    scope.search_PunSum();
                    scope.totalPot = result.data.CanPerTar;
                    scope.fdatos_cups.AgregarNueva=true;
                } else {
                    scope.toast('error','No existen datos intente nuevamente.','Error');
                    scope.fdatos_cups = {};
                    //scope.TVistaCups=true;
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
        if (scope.TipServ == "Gas") {
            $("#cargandos_cups").removeClass("loader loader-defaul").addClass("loader loader-default is-active");
            var url = base_urlHome() + "api/Cups/Buscar_XID_Servicio/TipServ/" + 2 + "/CodCup/" + scope.CodCups;
            $http.get(url).then(function(result) {
                $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                if (result.data != false) {
                    scope.fdatos_cups = result.data;
                    scope.Cups_Cif = result.data.NumCifCli + " - " + result.data.RazSocCli;
                    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecAltCup);
                    $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecUltLec);
                    //scope.TVistaCups=false;
                    scope.por_servicios(2);
                    console.log(result.data);
                    scope.search_PunSum();
                    scope.fdatos_cups.AgregarNueva=true;
                } else {
                    scope.toast('error','No existen datos intente nuevamente.','Error');
                    scope.fdatos_cups = {};
                    //scope.TVistaCups=true;
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
    scope.search_PunSum = function() {
            var url = base_urlHome() + "api/Cups/search_PunSum_Data/CodCli/" + scope.fdatos_cups.CodCli;
            $http.get(url).then(function(result) {
                if (result.data != false) 
                {
                    scope.T_PuntoSuministros = result.data;
                } else {
                    scope.toast('error','No existen Direcciones de Suministros Registrados','Error');
                    scope.T_PuntoSuministros = [];
                }
            }, function(error) {
                //$("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
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
        if ($route.current.$$route.originalPath == "/Add_Cups/")
        {
            scope.fdatos_cups.cups='ES';
            //scope.cargar_datos_nueva_dirPunSum();
        }
        scope.agregarnuevadireccion=function(value)
        {
            console.log(value);           
           // var oldpunsum=scope.fdatos_cups.CodPunSum;
            if(value==false)
            {                
                if (!scope.fdatos_cups.CodCli > 0) 
                {
                    scope.toast('error','Debe Seleccionar un Cliente Para Aplicar la Dirección.','Error');
                    return false;
                }
                scope.fdatos_cups.TipRegDir=1;
                scope.punto_suministro();
                scope.T_PuntoSuministrosVistaNuevaDireccion=true;                
                
                //console.log(oldpunsum);
                scope.fdatos_cups.CodPunSum=null;
                scope.fdatos_cups.AgregarNueva=value;
                var url = base_urlHome()+"api/Cups/TipViaProvin/";
                $http.get(url).then(function(result)
                {
                    if(result.data!=false)
                    {
                        scope.tTiposVias=result.data.tTiposVias;
                        scope.tProvidencias=result.data.tProvidencias;

                    }
                    else
                    {
                        scope.toast('error','no se encontraron los complementos para este procedimiento','Error');
                        scope.tTiposVias=[];
                        scope.tProvidencias=[];
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
            else
            {
                scope.T_PuntoSuministrosVistaNuevaDireccion=false;
                scope.fdatos_cups.AgregarNueva=value;
                //console.log(oldpunsum);
                //scope.fdatos_cups.CodPunSum=punsumold;
                //console.log(punsumold);
                /*if(scope.fdatos_cups.CodCli>0)
                {
                    
                }*/
                //scope.fdatos_cups.CodPunSum=null;
            }
            //console.log(punsumold);
        }
    scope.punto_suministro = function() 
    {
        if (!scope.fdatos_cups.CodCli > 0) 
        {
            scope.toast('error','Debe Seleccionar un Cliente Para Aplicar la Dirección.','Error');
            return false;
        }
        if (scope.fdatos_cups.TipRegDir == 0) 
        {
             scope.restringir_input = 0;
             scope.fdatos_cups.CodTipVia = undefined;
             scope.fdatos_cups.NomViaPunSum = undefined;
             scope.fdatos_cups.NumViaPunSum = undefined;
             scope.fdatos_cups.BloPunSum = undefined;
             scope.fdatos_cups.EscPunSum = undefined;
             scope.fdatos_cups.PlaPunSum = undefined;
             scope.fdatos_cups.PuePunSum = undefined;             
             scope.fdatos_cups.CPLocSoc = undefined;
             scope.fdatos_cups.CodProPunSum = undefined;
             scope.fdatos_cups.CodLocPunSum = undefined;
             scope.fdatos_cups.ObsPunSum = undefined;
        }        
        else if (scope.fdatos_cups.TipRegDir == 1) 
        {
             scope.restringir_input = 1;
             $("#DirFisSoc").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Cups/buscar_direccion_Soc_Fis/Cliente/" + scope.fdatos_cups.CodCli + "/TipRegDir/" + scope.fdatos_cups.TipRegDir;
             $http.get(url).then(function(result) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (result.data != false) {
                    
                    scope.fdatos_cups.CodTipVia = result.data.CodTipViaSoc;
                    scope.fdatos_cups.NomViaPunSum = result.data.NomViaDomSoc;
                    scope.fdatos_cups.NumViaPunSum = result.data.NumViaDomSoc;
                    scope.fdatos_cups.BloPunSum = result.data.BloDomSoc;
                    scope.fdatos_cups.EscPunSum = result.data.EscDomSoc;
                    scope.fdatos_cups.PlaPunSum = result.data.PlaDomSoc;
                    scope.fdatos_cups.PuePunSum = result.data.PueDomSoc;
                    scope.fdatos_cups.CodProPunSum = result.data.CodProSoc;
                    scope.fdatos_cups.CodLocPunSum = result.data.CodLocSoc;
                    scope.fdatos_cups.CPLocSoc = result.data.CPLocSoc;
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
        else if (scope.fdatos_cups.TipRegDir == 2) 
        {
             scope.restringir_input = 1;
             $("#DirFisSoc").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Cups/buscar_direccion_Soc_Fis/Cliente/" + scope.fdatos_cups.CodCli + "/TipRegDir/" + scope.fdatos_cups.TipRegDir;
             $http.get(url).then(function(result) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                     scope.fdatos_cups.CodTipVia = result.data.CodTipViaFis;
                     scope.fdatos_cups.NomViaPunSum = result.data.NomViaDomFis;
                     scope.fdatos_cups.NumViaPunSum = result.data.NumViaDomFis;
                     scope.fdatos_cups.BloPunSum = result.data.BloDomFis;
                     scope.fdatos_cups.EscPunSum = result.data.EscDomFis;
                     scope.fdatos_cups.PlaPunSum = result.data.PlaDomFis;
                     scope.fdatos_cups.PuePunSum = result.data.PueDomFis;
                     scope.fdatos_cups.CodProPunSum = result.data.CodProFis;
                     scope.fdatos_cups.CodLocPunSum = result.data.CodLocFis;
                     scope.fdatos_cups.CPLocSoc = result.data.CPLocFis;
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
        else
        {

        }
    }
    scope.containerClicked = function() 
    {
        scope.searchResultCPLoc = {};
    }
    scope.containerClickedCUPs = function() 
    {
        scope.searchResultCUPs = {};
    }
    
    scope.searchboxClicked = function($event) 
    {
        $event.stopPropagation();
    }
    scope.LocalidadCodigoPostal=function(metodo)
    {
        var searchText_len = scope.fdatos_cups.CPLocSoc.trim().length;
        if (searchText_len >=3) 
        {
            if(metodo==1)
            {
               var url= base_urlHome()+"api/Cups/LocalidadCodigoPostal/CPLoc/"+scope.fdatos_cups.CPLocSoc;
            }
            $http.get(url).then(function(result) 
            {
                if (result.data != false) 
                {
                    if(metodo==1)
                    {
                        scope.searchResultCPLoc = result.data;
                    }
                } 
                else
                {                    
                    if(metodo==1)
                    {
                        scope.searchResultCPLoc = {};
                        scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
                        scope.fdatos_cups.CPLocSoc=null;
                    }                   
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
        else 
        {
            scope.searchResultCPLoc = {};
        }
    }
    scope.setValueCPLoc = function(index, $event, result, metodo) 
    {
        if (metodo == 1) 
        {
            console.log(index);
            console.log($event);
            console.log(result);
            console.log(metodo);
            scope.fdatos_cups.CodProPunSum=scope.searchResultCPLoc[index].CodPro;
            scope.BuscarLocalidadesPunSun(scope.fdatos_cups.CodProPunSum,2);
            scope.fdatos_cups.CodLocPunSum=scope.searchResultCPLoc[index].CodLoc;
            scope.fdatos_cups.CPLocSoc= scope.searchResultCPLoc[index].CPLoc;
            scope.searchResultCPLoc = {};
            $event.stopPropagation();
        }
    }
    scope.BuscarLocalidadesPunSun=function(CodPro,metodo)
    {
        console.log(CodPro);        
        var url=base_urlHome()+"api/Cups/BuscarLocalidadesFil/CodPro/"+CodPro;
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
               scope.fdatos_cups.CodLocPunSum=undefined;
               scope.fdatos_cups.CodLocFil=undefined;
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
    $scope.submitFormCups = function(event) {
        //scope.fdatos_cups.CodPunSum=scope.CodPunSum;
        console.log(scope.fdatos_cups);
        if (!scope.validar_campos_cups()) {
            return false;
        }
        if (scope.fdatos_cups.CodCup > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del CUPs?';
            var response = "CUPs actualizado de forma correcta";
        }
        if (scope.fdatos_cups.CodCup == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el CUPs?';
            var response = "CUPs creado de forma correcta";
        }
        console.log(scope.fdatos_cups);
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Cups/Registrar_Cups/";
                $http.post(url, scope.fdatos_cups).then(function(result) 
                {
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    
                    console.log(result.data);
                    if(result.data.status==400 && result.data.statusText=='OK')
                    {
                        scope.toast('error',result.data.response,'CUPs Registrado');
                        return false;
                    }
                    else if(result.data.status==200 && result.data.statusText=='OK')
                    {
                        console.log(result.data.objSalida);
                        scope.fdatos_cups = result.data.objSalida;
                        console.log(scope.fdatos_cups);
                        $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.objSalida.FecAltCup);
                        $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.objSalida.FecUltLec);
                        scope.FecAltCup=result.data.objSalida.FecAltCup;
                        scope.toast('success',result.data.response,title);
                        if(scope.fdatos_cups.AgregarNueva==false && scope.fdatos_cups.CodCup!=undefined)                            
                        { 
                            scope.agregarnuevadireccion(true)
                            scope.search_PunSum();
                            scope.fdatos_cups.CodPunSum=result.data.objSalida.CodPunSum;
                            console.log(result.data.objSalida.CodPunSum);
                            console.log(scope.fdatos_cups.CodPunSum);
                        }
                    }

                    /*if (result.data != false) 
                    {
                        scope.fdatos_cups = result.data;
                        $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecAltCup);
                        $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecUltLec);
                        scope.toast('success',response,title);
                    } 
                    else 
                    {
                        scope.toast('error','Error en la operación por favor intente nuevamente.','Error');
                    }*/

                }, function(error) {
                    $("#" + title).removeClass("loader loader-defaul is-active").addClass("loader loader-default");
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
    scope.validar_campos_cups = function()
    {
        resultado = true;
        if (!scope.fdatos_cups.CodCli > 0) {
            scope.toast('error','Debe seleccionar un Cliente.','');
            return false;
        }
        
        if(scope.fdatos_cups.AgregarNueva==true)
        {
            if (!scope.fdatos_cups.CodPunSum > 0) 
            {
                scope.toast('error','Debe seleccionar un Dirección de Suministro de la lista.','');
                return false;
            }  
        }
        else
        {
            if (!scope.fdatos_cups.CodTipVia > 0) 
            {
               scope.toast('error','Debe seleccionar un Tipo de Vía de la lista.','');
                return false;
            } 
            if (scope.fdatos_cups.NomViaPunSum == null || scope.fdatos_cups.NomViaPunSum == undefined || scope.fdatos_cups.NomViaPunSum == '') {
                scope.toast('error','Debe colocar el nombre de la vía','Requerido');
                return false;
            }
            if (scope.fdatos_cups.NumViaPunSum == null || scope.fdatos_cups.NumViaPunSum == undefined || scope.fdatos_cups.NumViaPunSum == '') {
                scope.toast('error','Debe colocar el nombre de la vía','Requerido');
                return false;
            }
            if (scope.fdatos_cups.BloPunSum == null || scope.fdatos_cups.BloPunSum == undefined || scope.fdatos_cups.BloPunSum == '') {
                scope.fdatos_cups.BloPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.BloPunSum=scope.fdatos_cups.BloPunSum;
            }
            if (scope.fdatos_cups.EscPunSum == null || scope.fdatos_cups.EscPunSum == undefined || scope.fdatos_cups.EscPunSum == '') {
                 scope.fdatos_cups.EscPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.EscPunSum=scope.fdatos_cups.EscPunSum;
            }


            if (scope.fdatos_cups.PlaPunSum == null || scope.fdatos_cups.PlaPunSum == undefined || scope.fdatos_cups.PlaPunSum == '') {
                 scope.fdatos_cups.PlaPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.PlaPunSum=scope.fdatos_cups.PlaPunSum;
            }
            if (scope.fdatos_cups.PuePunSum == null || scope.fdatos_cups.PuePunSum == undefined || scope.fdatos_cups.PuePunSum == '') {
                 scope.fdatos_cups.PuePunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.PuePunSum=scope.fdatos_cups.PuePunSum;
            }
            if (scope.fdatos_cups.CPLocSoc == null || scope.fdatos_cups.CPLocSoc == undefined || scope.fdatos_cups.CPLocSoc == '') {
                 scope.fdatos_cups.CPLocSoc=null;
            } 
            else 
            {
                scope.fdatos_cups.CPLocSoc=scope.fdatos_cups.CPLocSoc;
            }
            if (!scope.fdatos_cups.CodProPunSum > 0) 
            {
               scope.toast('error','Debe seleccionar una provincia de la lista.','');
                return false;
            } 
            if (!scope.fdatos_cups.CodLocPunSum > 0) 
            {
               scope.toast('error','Debe seleccionar una localidad de la lista.','');
                return false;
            }
            if (scope.fdatos_cups.ObsPunSum == null || scope.fdatos_cups.ObsPunSum == undefined || scope.fdatos_cups.ObsPunSum == '') {
                 scope.fdatos_cups.ObsPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.ObsPunSum=scope.fdatos_cups.ObsPunSum;
            }
        }
        if (scope.fdatos_cups.cups == null || scope.fdatos_cups.cups == undefined || scope.fdatos_cups.cups == '') {
            scope.toast('error','El Campo CUPs es requerido','');
            return false;
        } else {
            if (scope.fdatos_cups.cups.length < 2) {
                scope.toast('error','El Campo CUPs Debe Contener 2 Letras o Números.','');
                return false;
            }
        }
        if (scope.fdatos_cups.cups1 == null || scope.fdatos_cups.cups1 == undefined || scope.fdatos_cups.cups1 == '') {
            scope.toast('error','El Campo CUPs 1 es requerido','');
            return false;
        } else {
            if (scope.fdatos_cups.cups1.length < 16) {
                scope.toast('error','El Campo CUPs Debe Contener 16 Letras o Números.','');
                return false;
            }
        }        
        if (scope.fdatos_cups.TipServ == 0) {
            scope.toast('error','Debe Seleccionar un Tipo de Suministro','');
            return false;
        }

        if (scope.fdatos_cups.TipServ == 1) {
            
            if (!scope.fdatos_cups.CodDis > 0) {
                //scope.toast('error','Debe Seleccionar una Distribuidora Eléctrica de la lista.','');
                //return false;
                scope.fdatos_cups.CodDis=null;
            }
            else
            {
                scope.fdatos_cups.CodDis=scope.fdatos_cups.CodDis;
            }            
            if (!scope.fdatos_cups.CodTar > 0) {
                scope.toast('error','Debe Seleccionar una Tarifa de Eléctrica la lista.','');
                return false;
            }
            if (scope.totalPot == 1) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');                   
                    return false;
                }*/
                scope.fdatos_cups.PotConP2 = null;
                scope.fdatos_cups.PotConP3 = null;
                scope.fdatos_cups.PotConP4 = null;
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;

            }
            if (scope.totalPot == 2) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP3 = null;
                scope.fdatos_cups.PotConP4 = null;
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 3) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP4 = null;
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 4) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 5) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP5 == null || scope.fdatos_cups.PotConP5 == undefined || scope.fdatos_cups.PotConP5 == '') {
                    scope.toast('error','El CampoP5 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 6) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP5 == null || scope.fdatos_cups.PotConP5 == undefined || scope.fdatos_cups.PotConP5 == '') {
                    scope.toast('error','El CampoP5 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP6 == null || scope.fdatos_cups.PotConP6 == undefined || scope.fdatos_cups.PotConP6 == '') {
                    scope.toast('error','El Campo P6 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
            }
            if (scope.fdatos_cups.ConAnuCup == null || scope.fdatos_cups.ConAnuCup == undefined || scope.fdatos_cups.ConAnuCup == '') {
                scope.toast('error','El Campo Consumo es requerido','');
                return false;
            }
            if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                   
                   scope.fdatos_cups.PotMaxBie = null;
            }
        }
        if (scope.fdatos_cups.TipServ == 2) {
            if (!scope.fdatos_cups.CodDis > 0) {
                //scope.toast('error','Debe Seleccionar una Distribuidora Gas de la lista.','');
                //return false;
                scope.fdatos_cups.CodDis=null;
            }
            else
            {
                scope.fdatos_cups.CodDis=scope.fdatos_cups.CodDis;
            }
            if (!scope.fdatos_cups.CodTar > 0) {
                scope.toast('error','Debe Seleccionar una Tarifa de Gas la lista.','');
                return false;
            }

            if (scope.fdatos_cups.ConAnuCup == null || scope.fdatos_cups.ConAnuCup == undefined || scope.fdatos_cups.ConAnuCup == '') {
                scope.toast('error','El Campo Consumo es requerido','');
                return false;
            }
            scope.fdatos_cups.PotConP1 = null;
            scope.fdatos_cups.PotConP2 = null;
            scope.fdatos_cups.PotConP3 = null;
            scope.fdatos_cups.PotConP4 = null;
            scope.fdatos_cups.PotConP5 = null;
            scope.fdatos_cups.PotConP6 = null;
            scope.fdatos_cups.PotMaxBie = null;

        }
        var FecAltCup = document.getElementById("FecAltCup").value;
        scope.FecAltCup = FecAltCup;
        if (scope.FecAltCup == null || scope.FecAltCup == undefined || scope.FecAltCup == '') {
            scope.fdatos_cups.FecAltCup = null;
        } else {
            var FecAltCup = (scope.FecAltCup).split("/");
            if (FecAltCup.length < 3) {
                scope.toast('error','El formato Fecha de Alta correcto es DD/MM/YYYY','');
                return false;
            } else {
                if (FecAltCup[0].length > 2 || FecAltCup[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    return false;

                }
                if (FecAltCup[1].length > 2 || FecAltCup[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    return false;
                }
                if (FecAltCup[2].length < 4 || FecAltCup[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    return false;
                }
                var h1 = new Date();
                var final = FecAltCup[2] + "/" + FecAltCup[1] + "/" + FecAltCup[0];
                scope.fdatos_cups.FecAltCup = final;
            }

        }
        scope.fdatos_cups.FecUltLec = null;
        /*var FecUltLec = document.getElementById("FecUltLec").value;
        scope.fdatos_cups.FecUltLec = FecUltLec;
        if (scope.fdatos_cups.FecUltLec == null || scope.fdatos_cups.FecUltLec == undefined || scope.fdatos_cups.FecUltLec == '') {
            scope.fdatos_cups.FecUltLec = null;
            //scope.toast('error','El Campo Fecha de Última Lectura es requerido','');
            //return false;
        } else {
            var FecUltLec = (scope.fdatos_cups.FecUltLec).split("/");
            if (FecUltLec.length < 3) {
                scope.toast('error','El formato Fecha Última Lectura correcto es DD/MM/YYYY','');
                return false;
            } else {
                if (FecUltLec[0].length > 2 || FecUltLec[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    return false;

                }
                if (FecUltLec[1].length > 2 || FecUltLec[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    return false;
                }
                if (FecUltLec[2].length < 4 || FecUltLec[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    return false;
                }
                var h1 = new Date();
                var final_UltFec = FecUltLec[0] + "/" + FecUltLec[1] + "/" + FecUltLec[2];
                scope.fdatos_cups.FecUltLec = final_UltFec;
            }
        }*/
        var CUPS = scope.fdatos_cups.cups+""+scope.fdatos_cups.cups1;
        if (!scope.valida_cups(CUPS)) {
            return false;
        }
        if (scope.fdatos_cups.DerAccKW == null || scope.fdatos_cups.DerAccKW == undefined || scope.fdatos_cups.DerAccKW == '') {
            scope.fdatos_cups.DerAccKW = null;
        }
        else
        {   
            scope.fdatos_cups.DerAccKW = scope.fdatos_cups.DerAccKW;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.valida_cups_existe=function(CUPS)
    {
        var url=base_urlHome()+"api/Cups/VerificarCUPsExistente/Cups/"+CUPS;
        $http.get(url).then(function(result)
        {
            if(result.data.status==200 && result.data.statusText=='OK')
            {
                scope.toast('success',result.data.response,result.data.statusText);
                return true;
            }
            else if(result.data.status==400  && result.data.statusText=='Bad Request')
            {
                scope.toast('error',result.data.response,result.data.statusText);
                return false;
            }
            else
            {
                scope.toast('error','Error en Petición intente nuevamente.','Error');
                return false;
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
                            return false;
        });
    }
    Math.fmod = function (a,b) { return Number((a - (Math.floor(a / b) * b)).toPrecision(8)); };
    scope.valida_cups=function(CUPS)
    { 
        
        console.log(CUPS);
        var status=false;
        var RegExPattern =/^ES[0-9]{16}[a-zA-Z]{2}[0-9]{0,1}[a-zA-Z]{0,1}$/;
        if ((CUPS.match(RegExPattern)) && (CUPS!='')) {
            var CUPS_16 = CUPS.substr(2,16);
            var control = CUPS.substr(18,2);
            var letters = Array('T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E');

            var fmodv = Math.fmod(CUPS_16,529);
            var imod = parseInt(fmodv);
            var quotient = Math.floor(imod / 23);
            var remainder = imod % 23;            
            var dc1 = letters[quotient];
            var dc2 = letters[remainder];
            status = (control == dc1+dc2);
        } else {
            status=false;
        }
        if(!status){
           //alert("ERROR: Código CUPS incorrecto");
            scope.toast('error','Este CUPS es incorrecto por favor intente con otro','Error CUPS');            
            $('#CUPSNUM').val("");
            $('#CUPSNUM2').val("");
            $('#CUPSES').focus();
            $('#CUPSNUM').focus();
            $('#CUPSNUM2').focus();
        }
        console.log(status);
        return status;  
    }


    $scope.SubmitFormFiltrosCUPs = function(event) {
        console.log(scope.tmodal_filtro);
        if (scope.tmodal_filtro.tipo_filtro == 1) {
            if (!scope.tmodal_filtro.TipServ > 0) {
                scope.toast('error','Debe seleccionar un Tipo de Suministro para aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TCups = $filter('filter')(scope.TCupsBack, { TipServ: scope.tmodal_filtro.TipServ }, true);
            $scope.totalItems = scope.TCups.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TCups.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_cups = scope.tmodal_filtro.tipo_filtro + "/" + scope.tmodal_filtro.TipServ;
            scope.ruta_reportes_excel_cups = scope.tmodal_filtro.tipo_filtro + "/" + scope.tmodal_filtro.TipServ;
        }
        if (scope.tmodal_filtro.tipo_filtro == 2) {
            if (!scope.tmodal_filtro.tipo_tarifa > 0) {
                scope.toast('error','Debe seleccionar un Tipo de Suministro para la tarifa.','Error');
                return false;
            }
            if (!scope.tmodal_filtro.NomTar > 0) {
                scope.toast('error','Debe seleccionar una tarifa de la lista para poder aplicar el filtro.','Error');
                return false;
            }

            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TCups = $filter('filter')(scope.TCupsBack, { NomTarGas: scope.tmodal_filtro.NomTar }, true);
            $scope.totalItems = scope.TCups.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TCups.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_cups = scope.tmodal_filtro.tipo_filtro + "/" + scope.tmodal_filtro.tipo_tarifa + "/" + scope.tmodal_filtro.NomTar;
            scope.ruta_reportes_excel_cups = scope.tmodal_filtro.tipo_filtro + "/" + scope.tmodal_filtro.tipo_tarifa + "/" + scope.tmodal_filtro.NomTar;
        }
        if (scope.tmodal_filtro.tipo_filtro == 3) {
            if (!scope.tmodal_filtro.EstCUPs > 0) {
                scope.toast('error','Debe seleccionar un Estatus para poder aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TCups = $filter('filter')(scope.TCupsBack, { EstCUPs: scope.tmodal_filtro.EstCUPs }, true);
            $scope.totalItems = scope.TCups.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TCups.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_cups = scope.tmodal_filtro.tipo_filtro + "/" + scope.tmodal_filtro.EstCUPs;
            scope.ruta_reportes_excel_cups = scope.tmodal_filtro.tipo_filtro + "/" + scope.tmodal_filtro.EstCUPs;
        }


    };

    scope.regresar_filtro_cups = function() {

        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };

        scope.TCups = scope.TCupsBack;
        $scope.totalItems = scope.TCups.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.TCups.indexOf(value);
            return (begin <= index && index < end);
        }
        scope.tmodal_filtro = {};
        scope.ruta_reportes_pdf_cups = 0;
        scope.ruta_reportes_excel_cups = 0;
        scope.result_tar = false;

    }

    scope.buscar_tarifa = function() {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.TCups = scope.TCupsBack;
        $scope.totalItems = scope.TCups.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.TCups.indexOf(value);
            return (begin <= index && index < end);
        }
        var url = base_urlHome() + "api/Cups/Buscar_Tarifas/TipServ/" + scope.tmodal_filtro.tipo_tarifa;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                scope.result_tar = true;
                scope.T_TarifasFiltros = result.data;
            } else {
                scope.toast('error','No existen tarifas','Error');
                scope.result_tar = false;
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

    scope.validar_fechas = function() {
        resultado = true;
        var desde = (scope.historial.desde).split("/");
        if (desde.length < 3) {
            scope.toast('error','El formato Fecha Desde correcto es DD/MM/YYYY.','');
            return false;
        } else {
            if (desde[0].length > 2 || desde[0].length < 2) {
                scope.toast('error','Error en Día, debe introducir dos números','');
                return false;
            }
            if (desde[1].length > 2 || desde[1].length < 2) {
                scope.toast('error','Error en Mes, debe introducir dos números','');
                return false;
            }
            if (desde[2].length < 4 || desde[2].length > 4) {
                scope.toast('error','Error en Año, debe introducir cuatro números','');
                return false;
            }
            var h1 = new Date();
            var final = desde[0] + "/" + desde[1] + "/" + desde[2];
            scope.historial.desde = final;
        }
        var hasta = (scope.historial.hasta).split("/");
        if (hasta.length < 3) {
            scope.toast('error','El formato Fecha Hasta correcto es DD/MM/YYYY','');
            return false;
        } else {
            if (hasta[0].length > 2 || hasta[0].length < 2) {
                scope.toast('error','Error en Día, debe introducir dos números','');
                return false;
            }
            if (hasta[1].length > 2 || hasta[1].length < 2) {
                scope.toast('error','Error en Mes, debe introducir dos números','');
                return false;
            }
            if (hasta[2].length < 4 || hasta[2].length > 4) {
                scope.toast('error','Error en Año, debe introducir cuatro números','');
                return false;
            }
            var h1 = new Date();
            var final2 = hasta[0] + "/" + hasta[1] + "/" + hasta[2];
            scope.historial.hasta = final2;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.PeriodosTarifas = function(TipServ, CodTar) {
        if (TipServ == 1) {
            console.log(TipServ);
            console.log(CodTar);
            console.log(scope.T_Tarifas);
            for (var i = 0; i < scope.T_Tarifas.length; i++) {
                if (scope.T_Tarifas[i].CodTar == CodTar) {
                    //console.log(scope.T_Tarifas[i]);
                    scope.totalPot = scope.T_Tarifas[i].CanPerTar;
                }
            }
            console.log(scope.totalPot);
        }
    }
    $scope.submitFormHistorial = function(event) {
        scope.historial.TipServ = scope.TipServ
        scope.historial.CodCup = scope.CodCup
        var desde = document.getElementById("desde").value;
        scope.historial.desde = desde;
        var hasta = document.getElementById("hasta").value;
        scope.historial.hasta = hasta;
        scope.result_his = false;
        scope.T_Historial_Consumo = [];
        console.log(scope.historial);
        if (!scope.validar_fechas()) {
            return false;
        }
        Swal.fire({
            title: 'Historial CUPs',
            text: 'Generar Historial de Consumo CUPs',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Generar"
        }).then(function(t) {
            if (t.value == true) {
                $("#Generar_Consumo").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Cups/Historial_Consumo_CUPs/";
                $http.post(url, scope.historial).then(function(result) {
                    $("#Generar_Consumo").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        scope.result_his = true;
                        scope.T_Historial_Consumo = result.data.result;
                        scope.Total_Consumo = result.data.total_consumo;
                        scope.desde = result.data.desde;
                        scope.hasta = result.data.hasta;
                        scope.CodCup = result.data.CodCup;
                        if (scope.historial.TipServ == "Eléctrico") {
                            scope.PotCon1 = true;
                            scope.PotCon2 = true;
                            scope.PotCon3 = true;
                            scope.PotCon4 = true;
                            scope.PotCon5 = true;
                            scope.PotCon6 = true;
                        } else {
                            scope.PotCon1 = false;
                            scope.PotCon2 = false;
                            scope.PotCon3 = false;
                            scope.PotCon4 = false;
                            scope.PotCon5 = false;
                            scope.PotCon6 = false;
                        }
                    } else {
                        scope.toast('error','No existen datos en el rango de busqueda.','Error');
                        scope.result_his = false;
                        scope.T_Historial_Consumo = [];
                        //scope.cargar_lista_consumo_CUPs();
                    }
                }, function(error) {
                    $("#Generar_Consumo").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.fetchClientes = function() {
            var searchText_len = scope.Cups_Cif.trim().length;
            scope.fdatos_cups.Cups_Cif = scope.Cups_Cif;
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/Cups/getclientes";
                $http.post(url, scope.fdatos_cups).then(function(result) {
                    console.log(result);
                    if (result.data != false) {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    } else {
                        scope.toast('error','No hay Clientes registrados','Error');
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
        scope.fetchClientesCambioTitular = function() {
            var searchText_len = scope.NumCifCliCambio.trim().length;
            scope.fdatos_cups.Cups_Cif = scope.NumCifCliCambio;
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/Cups/getclientes";
                $http.post(url, scope.fdatos_cups).then(function(result) {
                    //console.log(result);
                    if (result.data != false) {
                        scope.searchResultCUPs = result.data;
                        console.log(scope.searchResultCUPs);
                    } else {
                        scope.toast('error','No hay Clientes registrados','Error');
                        scope.searchResultCUPs = {};
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
                scope.searchResultCUPs = {};
            }
        }
        // Set value to search box
    scope.setValue = function(index, $event, result) {
        console.log(index);
        console.log($event);
        console.log(result);
        console.log(scope.searchResult[index].CodCli);
        scope.fdatos_cups.CodCli = scope.searchResult[index].CodCli;
        scope.Cups_Cif = scope.searchResult[index].NumCifCli + " - " + scope.searchResult[index].RazSocCli
        scope.searchResult = {};
        $event.stopPropagation();
        scope.search_PunSum();
    }
    scope.setValueCambio = function(index, $event, result) {
        console.log(index);
        console.log($event);
        console.log(result);
        console.log(scope.searchResultCUPs[index].CodCli);
        scope.CambioTitular.CodCli = scope.searchResultCUPs[index].CodCli;
        scope.NumCifCliCambio = scope.searchResultCUPs[index].NumCifCli + " - " + scope.searchResultCUPs[index].RazSocCli
        scope.searchResultCUPs = {};
        $event.stopPropagation();
    }
    scope.searchboxClicked = function($event) {
        $event.stopPropagation();
    }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }

    if($route.current.$$route.originalPath == "/Add_Cups/:CodCli/:CodPunSum")
    {
        scope.Cups_Cif=$route.current.params.CodCli;
        scope.CodPunSum=$route.current.params.CodPunSum;
        scope.fdatos_cups.Cups_Cif = scope.Cups_Cif;
        var url = base_urlHome() + "api/Cups/getclientes";
                             $http.post(url, scope.fdatos_cups).then(function(result) {
                                 //console.log(result);
                                 if (result.data != false) {
                                    scope.Customers = result.data;
                                   for (var i = 0; i < scope.Customers.length; i++) {
                                        if (scope.Customers[i].CodCli == $route.current.params.CodCli) {                
                                            console.log(scope.Customers[i]);
                                            scope.Cups_Cif=scope.Customers[i].NumCifCli+" - "+scope.Customers[i].RazSocCli;
                                            scope.fdatos_cups.CodCli=scope.Customers[i].CodCli;
                                            scope.search_PunSum();
                                            scope.fdatos_cups.CodPunSum=$route.current.params.CodPunSum;
                                            scope.fdatos_cups.cups="ES";
                                            //scope.fdatos_cups.CodCli

                                        }
                                    }
                                 } else {
                                    scope.Customers = [];
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
                             //scope.cargar_datos_nueva_dirPunSum();
    }

    scope.FetchCUPs = function() {
        if (scope.filtrar_cups == undefined || scope.filtrar_cups == null || scope.filtrar_cups == '') {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TCups = scope.TCupsBack;
            $scope.totalItems = scope.TCups.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TCups.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_cups = 0;
            scope.ruta_reportes_excel_cups = 0;
        } else {
            if (scope.filtrar_cups.length >= 2) {
                scope.fdatos_cups.filtrar_cups = scope.filtrar_cups;
                var url = base_urlHome() + "api/Cups/getCUPsFilter";
                $http.post(url, scope.fdatos_cups).then(function(result) {
                    console.log(result.data);
                    if (result.data != false) {
                        $scope.predicate = 'id';
                        $scope.reverse = true;
                        $scope.currentPage = 1;
                        $scope.order = function(predicate) {
                            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                            $scope.predicate = predicate;
                        };
                        scope.TCups = result.data;
                        $scope.totalItems = scope.TCups.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.TCups.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_cups = 4 + "/" + scope.filtrar_cups;
                        scope.ruta_reportes_excel_cups = 4 + "/" + scope.filtrar_cups;
                    } else {
                        scope.toast('error','No hay CUPs registrados','Error');
                        scope.TCups =[];
                        scope.ruta_reportes_pdf_cups =0;
                        scope.ruta_reportes_excel_cups = 0;
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
                        scope.TCups = scope.TCupsBack;
                        $scope.totalItems = scope.TCups.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.TCups.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_cups = 0;
                        scope.ruta_reportes_excel_cups = 0;
            }
        }
    }
    scope.CambiarTitularModal=function()
    {
       scope.CambioTitular={};
       $("#modalCambiarTitularCUPs").modal('show'); 
    }
    $scope.CambiarTitular = function(event) 
    {       
        scope.CambioTitular.CodPunSum=scope.fdatos_cups.CodPunSum;
        Swal.fire({
            title: 'Cambio de Cliente',
            text: 'Esta Seguro de cambiar el cliente del CUPs?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Continuar"
        }).then(function(t) {
            if (t.value == true) 
            {
                var url = base_urlHome()+"api/Cups/CambiodeClienteCUPs";
                $http.post(url,scope.CambioTitular).then(function(result)
                {
                   if(result.data!=false)
                    {
                        scope.toast('success','Cliente Cambiado Correctamente','Cambio de Cliente');
                        $("#modalCambiarTitularCUPs").modal('hide');
                        window.location.reload();
                    }
                    else
                    {
                        scope.toast('error','Error intentando cambiar de cliente','Error');
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
                console.log(scope.CambioTitular);        
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

    if (scope.CodCups != undefined) {
        //scope.search_PunSum();
        scope.BuscarxIDCups();
    } else {
        if ($route.current.$$route.originalPath == "/Gestionar_Cups/") {
            scope.cargar_lista_cups();
        }
    }

}