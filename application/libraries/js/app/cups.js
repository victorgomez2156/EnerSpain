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
    scope.fdatos_cups_cups = {};
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
    console.log(scope.CodCups);
    console.log(scope.TipServ);
    console.log(scope.Nivel);
    console.log(fecha);
    console.log(scope.CodCup);
    scope.Cif = true;
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
                Swal.fire({ title: "Cups", text: "No se Encontraron Cups Registrados.", type: "error", confirmButtonColor: "#188ae2" });
                //scope.disabled_button_add_punt=false;
                scope.TCups = [];
                scope.TCupsBack = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }

        });

    }

    scope.agregar_cups = function() {
        location.href = "#/Add_Cups";
        scope.fdatos_cups_cups.TipServ = 0;
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
                Swal.fire({ title: "Error", text: "El CUPs Ya Fue Dado de Baja.", type: "error", confirmButtonColor: "#188ae2" });
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
                    Swal.fire({ title: "Información", text: "No se encontraron motivos de bloqueos registrados, contacte un administrador y notifiquelo.", type: "info", confirmButtonColor: "#188ae2" });
                }

            }, function(error) {
                $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                    scope.fdatos_cups.FecAltCup = numero.substring(0, numero.length - 1);
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
    }
    $scope.submitFormlockCUPs = function(event) {
        console.log(scope.tmodal_data);
        if (scope.tmodal_data.ObsMotCUPs == undefined || scope.tmodal_data.ObsMotCUPs == null || scope.tmodal_data.ObsMotCUPs == '') {
            scope.tmodal_data.ObsMotCUPs = null;
        } else {
            scope.tmodal_data.ObsMotCUPs = scope.tmodal_data.ObsMotCUPs;
        }
        var FecBaj = document.getElementById("FecBaj").value;
        scope.tmodal_data.FecBaj = FecBaj;
        if (scope.tmodal_data.FecBaj == undefined || scope.tmodal_data.FecBaj == null || scope.tmodal_data.FecBaj == '') {
            Swal.fire({ text: "La Fecha de Bloqueo es requerida", type: "error", confirmButtonColor: "#188ae2" });
            event.preventDefault();
            return false;
        } else {
            var FecBaj = (scope.tmodal_data.FecBaj).split("/");
            if (FecBaj.length < 3) {
                Swal.fire({ text: "El formato Fecha de Bloqueo correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecBaj[0].length > 2 || FecBaj[0].length < 2) {
                    Swal.fire({ text: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBaj[1].length > 2 || FecBaj[1].length < 2) {
                    Swal.fire({ text: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBaj[2].length < 4 || FecBaj[2].length > 4) {
                    Swal.fire({ text: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.tmodal_data.FecBaj.split("/");
                valuesEnd = scope.fecha_server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ text: "La Fecha de Bloqueo no puede ser mayor al " + scope.fecha_server + " Verifique e intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
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
                        Swal.fire({ title: 'CUPs', text: 'El CUPs ha sido dado de baja correctamente.', type: "success", confirmButtonColor: "#188ae2" });
                        scope.tmodal_data = {};
                        $("#modal_motivo_bloqueo").modal('hide');
                        scope.cargar_lista_cups();
                    } else {
                        Swal.fire({ title: "Error", text: "Error en la operación por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                        scope.cargar_lista_cups();
                    }
                }, function(error) {
                    $("#Baja").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
            scope.fdatos_cups.FecAltCup = null;
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
            scope.fdatos_cups.FecAltCup = null;
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
                    Swal.fire({ title: "Error", text: "No se encontraron datos registrados.", type: "info", confirmButtonColor: "#188ae2" });
                    scope.sin_data = 1;
                }

            }, function(error) {
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                    Swal.fire({ title: "Error", text: "No se encontraron datos registrados.", type: "info", confirmButtonColor: "#188ae2" });
                    scope.sin_data = 1;
                }

            }, function(error) {
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecAltCup);
                    $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecUltLec);
                    //scope.TVistaCups=false;
                    scope.por_servicios(1);
                    console.log(result.data);
                } else {
                    Swal.fire({ title: "Error", text: "No se encontraron datos intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    scope.fdatos_cups = {};
                    //scope.TVistaCups=true;
                }
            }, function(error) {
                $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                    $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecAltCup);
                    $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecUltLec);
                    //scope.TVistaCups=false;
                    scope.por_servicios(2);
                    console.log(result.data);
                } else {
                    Swal.fire({ title: "Error", text: "No se encontraron datos intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    scope.fdatos_cups = {};
                    //scope.TVistaCups=true;
                }
            }, function(error) {
                $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                }
            });
        }

    }
    scope.search_PunSum = function() {
        var url = base_urlHome() + "api/Cups/search_PunSum_Data";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                scope.T_PuntoSuministros = result.data;
            } else {
                Swal.fire({ title: "Error", text: "No Se Encontraron Direcciones de Suministros Registrados", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    if ($route.current.$$route.originalPath == "/Add_Cups/") {
        scope.search_PunSum();
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
                $http.post(url, scope.fdatos_cups).then(function(result) {
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        scope.fdatos_cups = result.data;
                        $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecAltCup);
                        $('.datepicker`2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecUltLec);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });

                    } else {
                        Swal.fire({ title: "Error", text: "Error en la operación por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    }

                }, function(error) {
                    $("#" + title).removeClass("loader loader-defaul is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }

                });
            } else {
                event.preventDefault();
            }
        });
    };
    scope.validar_campos_cups = function() {
        resultado = true;
        if (!scope.fdatos_cups.CodPunSum > 0) {
            Swal.fire({ title: "Debe seleccionar un Dirección de Suministro de la lista.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos_cups.cups == null || scope.fdatos_cups.cups == undefined || scope.fdatos_cups.cups == '') {
            Swal.fire({ title: "El Campo CUPs es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            if (scope.fdatos_cups.cups.length < 2) {
                Swal.fire({ title: "El Campo CUPs Debe Contener 2 Letras o Números.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        if (scope.fdatos_cups.cups1 == null || scope.fdatos_cups.cups1 == undefined || scope.fdatos_cups.cups1 == '') {
            Swal.fire({ title: "El Campo CUPs 1 es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            if (scope.fdatos_cups.cups1.length < 16) {
                Swal.fire({ title: "El Campo CUPs Debe Contener 16 Letras o Números.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        if (scope.fdatos_cups.cups2 == null || scope.fdatos_cups.cups2 == undefined || scope.fdatos_cups.cups2 == '') {
            Swal.fire({ title: "El Campo CUPs 2 es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            if (scope.fdatos_cups.cups2.length < 2) {
                Swal.fire({ title: "El Campo CUPs Debe Contener 2 Letras o Números.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        if (scope.fdatos_cups.TipServ == 0) {
            Swal.fire({ title: "Debe Seleccionar un Tipo de Suministro", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }

        if (scope.fdatos_cups.TipServ == 1) {
            if (!scope.fdatos_cups.CodDis > 0) {
                Swal.fire({ title: "Debe Seleccionar una Distribuidora Eléctrica de la lista.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (!scope.fdatos_cups.CodTar > 0) {
                Swal.fire({ title: "Debe Seleccionar una Tarifa de Eléctrica la lista.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }

            if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                Swal.fire({ title: "El Campo P1 Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                Swal.fire({ title: "El Campo P2 Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                Swal.fire({ title: "El Campo P3 Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                Swal.fire({ title: "El Campo P4 Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.PotConP5 == null || scope.fdatos_cups.PotConP5 == undefined || scope.fdatos_cups.PotConP5 == '') {
                Swal.fire({ title: "El CampoP5 Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.PotConP6 == null || scope.fdatos_cups.PotConP6 == undefined || scope.fdatos_cups.PotConP6 == '') {
                Swal.fire({ title: "El Campo P6 Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                Swal.fire({ title: "El Campo Potencia Máxima Es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (scope.fdatos_cups.ConAnuCup == null || scope.fdatos_cups.ConAnuCup == undefined || scope.fdatos_cups.ConAnuCup == '') {
                Swal.fire({ title: "El Campo Consumo es requerido", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        if (scope.fdatos_cups.TipServ == 2) {
            if (!scope.fdatos_cups.CodDis > 0) {
                Swal.fire({ title: "Debe Seleccionar una Distribuidora de Gas de la lista.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (!scope.fdatos_cups.CodTar > 0) {
                Swal.fire({ title: "Debe Seleccionar una Tarifa de Gas la lista.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }

            if (scope.fdatos_cups.ConAnuCup == null || scope.fdatos_cups.ConAnuCup == undefined || scope.fdatos_cups.ConAnuCup == '') {
                Swal.fire({ title: "El Campo Consumo es requerido", type: "error", confirmButtonColor: "#188ae2" });
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
        scope.fdatos_cups.FecAltCup = FecAltCup;
        if (scope.fdatos_cups.FecAltCup == null || scope.fdatos_cups.FecAltCup == undefined || scope.fdatos_cups.FecAltCup == '') {
            Swal.fire({ title: "La Fecha de Alta es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecAltCup = (scope.fdatos_cups.FecAltCup).split("/");
            if (FecAltCup.length < 3) {
                Swal.fire({ text: "El formato Fecha de Alta correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
                return false;
            } else {
                if (FecAltCup[0].length > 2 || FecAltCup[0].length < 2) {
                    Swal.fire({ text: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;

                }
                if (FecAltCup[1].length > 2 || FecAltCup[1].length < 2) {
                    Swal.fire({ text: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;
                }
                if (FecAltCup[2].length < 4 || FecAltCup[2].length > 4) {
                    Swal.fire({ text: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;
                }
                var h1 = new Date();
                var final = FecAltCup[0] + "/" + FecAltCup[1] + "/" + FecAltCup[2];
                scope.fdatos_cups.FecAltCup = final;
            }

        }
        var FecUltLec = document.getElementById("FecUltLec").value;
        scope.fdatos_cups.FecUltLec = FecUltLec;
        if (scope.fdatos_cups.FecUltLec == null || scope.fdatos_cups.FecUltLec == undefined || scope.fdatos_cups.FecUltLec == '') {
            Swal.fire({ title: "La Fecha de Última Lectura es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecUltLec = (scope.fdatos_cups.FecUltLec).split("/");
            if (FecUltLec.length < 3) {
                Swal.fire({ text: "El formato Fecha Última Lectura correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
                return false;
            } else {
                if (FecUltLec[0].length > 2 || FecUltLec[0].length < 2) {
                    Swal.fire({ text: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;

                }
                if (FecUltLec[1].length > 2 || FecUltLec[1].length < 2) {
                    Swal.fire({ text: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;
                }
                if (FecUltLec[2].length < 4 || FecUltLec[2].length > 4) {
                    Swal.fire({ text: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;
                }
                var h1 = new Date();
                var final_UltFec = FecUltLec[0] + "/" + FecUltLec[1] + "/" + FecUltLec[2];
                scope.fdatos_cups.FecUltLec = final_UltFec;
            }
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    $scope.SubmitFormFiltrosCUPs = function(event) {
        console.log(scope.tmodal_filtro);
        if (scope.tmodal_filtro.tipo_filtro == 1) {
            if (!scope.tmodal_filtro.TipServ > 0) {
                Swal.fire({ title: "Error", text: "Debe seleccionar un Tipo de Suministro para aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "Debe seleccionar un Tipo de Suministro para la tarifa.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (!scope.tmodal_filtro.NomTar > 0) {
                Swal.fire({ title: "Error", text: "Debe seleccionar una tarifa de la lista para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "Debe seleccionar un Estatus para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "No se encontraron tarifas.", type: "error", confirmButtonColor: "#188ae2" });
                scope.result_tar = false;
            }
        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }

    scope.validar_fechas = function() {
        resultado = true;
        var desde = (scope.historial.desde).split("/");
        if (desde.length < 3) {
            Swal.fire({ text: "El formato Fecha Desde correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            if (desde[0].length > 2 || desde[0].length < 2) {
                Swal.fire({ text: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (desde[1].length > 2 || desde[1].length < 2) {
                Swal.fire({ text: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
                return false;
            }
            if (desde[2].length < 4 || desde[2].length > 4) {
                Swal.fire({ text: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
                return false;
            }
            var h1 = new Date();
            var final = desde[0] + "/" + desde[1] + "/" + desde[2];
            scope.historial.desde = final;
        }
        var hasta = (scope.historial.hasta).split("/");
        if (hasta.length < 3) {
            Swal.fire({ text: "El formato Fecha Hasta correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            if (hasta[0].length > 2 || hasta[0].length < 2) {
                Swal.fire({ text: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (hasta[1].length > 2 || hasta[1].length < 2) {
                Swal.fire({ text: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
                return false;
            }
            if (hasta[2].length < 4 || hasta[2].length > 4) {
                Swal.fire({ text: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
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
                        Swal.fire({ title: "Error", text: "No se encontraron datos en el rango de busqueda.", type: "info", confirmButtonColor: "#188ae2" });
                        scope.result_his = false;
                        scope.T_Historial_Consumo = [];
                        //scope.cargar_lista_consumo_CUPs();
                    }
                }, function(error) {
                    $("#Generar_Consumo").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    };

    if (scope.CodCups != undefined) {
        scope.search_PunSum();
        scope.BuscarxIDCups();
    } else {
        if ($route.current.$$route.originalPath == "/Gestionar_Cups/") {
            scope.cargar_lista_cups();
        }
    }

}