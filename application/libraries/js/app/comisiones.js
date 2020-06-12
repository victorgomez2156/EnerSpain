app.controller('Controlador_Comisiones', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    var scope = this;
    scope.fdatos = {};
    scope.anexos = {};
    scope.CodAneProID = $route.current.params.CodAnePro;
    scope.CIFComision = $route.current.params.NumCifCom;
    scope.ComerComision = $route.current.params.RazSocCom;
    scope.ProComision = $route.current.params.DesPro;
    scope.AneComision = $route.current.params.DesAnePro;
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
    scope.TComisionesRangoGrib = [];
    scope.TComisionesRango = [];
    scope.select_det_com = [];
    scope.TComisionesDet = [];
    scope.Block_Deta = 0;

    console.log($route.current.$$route.originalPath);
    ///////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE COMISIONES START ////////////////////////////////////////////////
    scope.Buscar_Tarifas_Anexos = function() {
        $("#Car_Det").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/buscar_detalle_anexos_comision/CodAnePro/" + scope.CodAneProID;
        $http.get(url).then(function(result) {
            $("#Car_Det").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate3 = 'id';
                $scope.reverse3 = true;
                $scope.currentPage3 = 1;
                $scope.order3 = function(predicate3) {
                    $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                    $scope.predicate3 = predicate3;
                };
                scope.TComisionesDet = result.data;
                $scope.totalItems3 = scope.TComisionesDet.length;
                $scope.numPerPage3 = 50;
                $scope.paginate3 = function(value3) {
                    var begin3, end3, index3;
                    begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                    end3 = begin3 + $scope.numPerPage3;
                    index3 = scope.TComisionesDet.indexOf(value3);
                    return (begin3 <= index3 && index3 < end3);
                };
            } else {
                Swal.fire({ title: "Error", text: 'No hay Tarifas registradas para el Anexo', type: "info", confirmButtonColor: "#188ae2" });
                scope.TComisionesDet = [];
                scope.TComisionesRangoGrib = [];
                scope.TComisionesRango = [];
                scope.select_det_com = [];

            }
        }, function(error) {
            $("#Car_Det").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error.", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
    scope.agregar_detalle_comision = function(index, CodDetAneTarEle, dato) {
        //console.log(index);
        //console.log(CodDetAneTarEle);
        console.log(dato);
        if (scope.Block_Deta == 1) {
            Swal.fire({ title: "Error", text: 'Actualmente hay un proceso de comisiones activo, terminelo he intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            $("#Car_Det").removeClass("loader loader-default").addClass("loader loader-default is-active");
            var url = base_urlHome() + "api/Comercializadora/buscar_comisiones_detalles/CodAnePro/" + dato.CodAnePro + "/CodDetAneTarEle/" + dato.CodDetAneTarEle + "/CodTar/" + dato.CodTarEle;
            $http.get(url).then(function(result) {
                $("#Car_Det").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (result.data != false) {
                    scope.select_det_com[CodDetAneTarEle] = dato;
                    scope.CodTarEle = dato.CodTarEle;
                    scope.CodDetAne = dato.CodDetAneTarEle;
                    scope.CodAnePro = dato.CodAnePro;
                    scope.Block_Deta = 1;
                    var ObjDetCom = new Object();
                    if (scope.TComisionesRangoGrib == undefined || scope.TComisionesRangoGrib == false) {
                        scope.TComisionesRangoGrib = [];
                    }
                    angular.forEach(result.data, function(Comisiones) {
                        if (Comisiones.TipServ == "Eléctrico") {
                            scope.TipServ = 1;
                        }
                        if (Comisiones.TipServ == "Gas") {
                            scope.TipServ = 2;
                        }
                        scope.TComisionesRangoGrib.push({ CodDetCom: Comisiones.CodDetCom, CodDetAne: Comisiones.CodDetAne, CodAnePro: Comisiones.CodAnePro, CodTarEle: Comisiones.CodTarEle, TipServ: scope.TipServ, RanCon: Comisiones.RanCon, ConMinAnu: Comisiones.ConMinAnu, ConMaxAnu: Comisiones.ConMaxAnu, ConSer: Comisiones.ConSer, ConCerVer: Comisiones.ConCerVer });
                        console.log(scope.TComisionesRangoGrib);
                    });
                } else {
                    scope.select_det_com[CodDetAneTarEle] = dato;
                    scope.CodTarEle = dato.CodTarEle;
                    scope.CodDetAne = dato.CodDetAneTarEle;
                    scope.CodAnePro = dato.CodAnePro;
                    scope.Block_Deta = 1;
                    var ObjDetCom = new Object();
                    if (scope.TComisionesRangoGrib == undefined || scope.TComisionesRangoGrib == false) {
                        scope.TComisionesRangoGrib = [];
                    }
                    if (dato.TipServ == "Eléctrico") {
                        var TipServ = 1;
                        scope.TipServ = 1;
                    }
                    if (dato.TipServ == "Gas") {
                        var TipServ = 2;
                        scope.TipServ = 2;
                    }
                    scope.TComisionesRangoGrib.push({ CodDetAne: dato.CodDetAneTarEle, CodAnePro: dato.CodAnePro, CodTarEle: dato.CodTarEle, TipServ: TipServ, ConSer: "0.00", ConCerVer: "0.00" });
                    console.log(scope.TComisionesRangoGrib);
                }
            }, function(error) {
                $("#Car_Det").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    }
    scope.quitar_detalle_comision = function(index, CodDetAneTarEle, dato) {
        scope.select_det_com[CodDetAneTarEle] = false;
        scope.TComisionesRangoGrib = [];
        scope.Block_Deta = 0;
    }
    scope.agregardetalle = function() {
        var ObjDetCom = new Object();
        ObjDetCom.RanConsu = 0;
        ObjDetCom.ConMinAn = 0;
        ObjDetCom.ConMaxAn = 0;
        ObjDetCom.ConServ = 0;
        ObjDetCom.ConCerVer = 0;
        console.log(scope.TComisionesRangoGrib);

        if (scope.TComisionesRangoGrib.length >= 1) {
            if (!scope.validar_campos_detalles_comisiones()) {
                return false;
            }
            var a = scope.TComisionesRangoGrib;
            var b = a.pop();
            for (var i = 0; i <= a.length - 1; i++) {
                //console.log(i);
                console.log(a[i]);
            }
            console.log(b);
            scope.TComisionesRangoGrib.push({ CodDetAne: b.CodDetAne, CodAnePro: b.CodAnePro, CodTarEle: b.CodTarEle, TipServ: b.TipServ, RanCon: null, ConMinAnu: b.ConMinAnu, ConMaxAnu: b.ConMaxAnu, ConSer: b.ConSer, ConCerVer: b.ConCerVer });
            scope.ConMinAnuCoo = Math.max(parseFloat(b.ConMaxAnu), 0) + 1;
        }
        if (scope.TComisionesRangoGrib == undefined || scope.TComisionesRangoGrib == false) {
            scope.TComisionesRangoGrib = [];
        }
        scope.TComisionesRangoGrib.push({ CodDetAne: scope.CodDetAne, CodAnePro: scope.CodAnePro, CodTarEle: scope.CodTarEle, TipServ: scope.TipServ, ConMinAnu: scope.ConMinAnuCoo, ConSer: "0.00", ConCerVer: "0.00" });
        console.log(scope.TComisionesRangoGrib);
    }
    scope.quitar_detalle_comision_length = function() {
        if (scope.TComisionesRangoGrib.length > 0) {
            var a = scope.TComisionesRangoGrib;
            var b = a.pop();
            for (var i = 0; i <= a.length - 1; i++) {
                console.log(i + " " + a[i]);
            }
            if (scope.TComisionesRangoGrib.length == 0) {
                scope.Block_Deta = 0;
                scope.select_det_com[b.CodDetSerEsp] = false;
            }
            console.log(b);
            console.log(scope.select_det_com);
            console.log(scope.TComisionesRangoGrib);
        }
    }
    scope.guardar_comisiones = function() {
        console.log(scope.TComisionesRangoGrib);
        if (!scope.validar_campos_detalles_comisiones()) {
            return false;
        }
        scope.datos_enviar = {};
        scope.datos_enviar.CodAnePro = scope.CodAnePro;
        scope.datos_enviar.CodTarEle = scope.CodTarEle;
        scope.datos_enviar.CodDetAne = scope.CodDetAne;
        scope.datos_enviar.Detalles = scope.TComisionesRangoGrib;
        console.log(scope.datos_enviar);

        Swal.fire({
            title: 'Comisiones',
            text: '¿Seguro que desea cerrar sin registrar las Comisiones?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#Guar_Deta").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercializadora/guardar_comisiones_detalles_anexos/";
                $http.post(url, scope.datos_enviar).then(function(result) {
                    $("#Guar_Deta").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: 'Comisiones', text: 'Proceso de comisiones realizado de forma correcta', type: "success", confirmButtonColor: "#188ae2" });
                    } else {
                        Swal.fire({ title: "Error", text: 'ha ocurrido un error en el proceso, Por Favor intente Nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#Guar_Deta").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                event.preventDefault();
            }
        });
    }
    scope.validar_campos_detalles_comisiones = function() {
        resultado = true;
        if (!scope.TComisionesRangoGrib.length > 0) {
            Swal.fire({ title: "Error", text: 'Debe indicar al menos un renglo para poder finalizar el proceso de las comisiones', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        for (var i = 0; i < scope.TComisionesRangoGrib.length; i++) {
            /*if (scope.TComisionesRangoGrib[i].RanCon==undefined || scope.TComisionesRangoGrib[i].RanCon==null || scope.TComisionesRangoGrib[i].RanCon=='') 
		{
	        Swal.fire({title:"Error",text:"El Campo Rango de Consumo no puede estar vacío.",type:"error",confirmButtonColor:"#188ae2"});
			i=scope.TComisionesRangoGrib.length;
			resultado = false;
		}*/
            if (scope.TComisionesRangoGrib[i].ConMinAnu == undefined || scope.TComisionesRangoGrib[i].ConMinAnu == null || scope.TComisionesRangoGrib[i].ConMinAnu == '') {
                Swal.fire({ title: 'Consumo Mínimo', text: 'El Campo Consumo Mínimo es requerido', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
            if (scope.TComisionesRangoGrib[i].ConMaxAnu == undefined || scope.TComisionesRangoGrib[i].ConMaxAnu == null || scope.TComisionesRangoGrib[i].ConMaxAnu == '') {
                Swal.fire({ title: 'Consumo Máximo', text: 'El Campo Consumo Máximo es requerido', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
            if (scope.TComisionesRangoGrib[i].ConSer == undefined || scope.TComisionesRangoGrib[i].ConSer == null || scope.TComisionesRangoGrib[i].ConSer == '') {
                Swal.fire({ title: 'Comisión Servicio', text: 'El Campo Comisión de Servicios es requerido', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
            if (scope.TComisionesRangoGrib[i].ConCerVer == undefined || scope.TComisionesRangoGrib[i].ConCerVer == null || scope.TComisionesRangoGrib[i].ConCerVer == '') {
                Swal.fire({ title: 'Comisión Certificado Verde', text: 'El Campo Comisión Certificado Verde es requerido', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.validar_inputs = function(metodo, object, index) {
        //console.log(metodo);
        //console.log(object);
        //console.log(index);
        if (metodo == 1 && object != undefined) {
            numero = object;
            if (!/^([.0-9])*$/.test(numero))
                scope.TComisionesRangoGrib[index].RanCon = numero.substring(0, numero.length - 1);
        }
        if (metodo == 2 && object != undefined) {
            numero = object;
            if (!/^([.0-9])*$/.test(numero))
                scope.TComisionesRangoGrib[index].ConMinAnu = numero.substring(0, numero.length - 1);
        }
        if (metodo == 3 && object != undefined) {
            numero = object;
            if (!/^([.0-9])*$/.test(numero))
                scope.TComisionesRangoGrib[index].ConMaxAnu = numero.substring(0, numero.length - 1);
        }
        if (metodo == 4 && object != undefined) {
            numero = object;
            if (!/^([.0-9])*$/.test(numero))
                scope.TComisionesRangoGrib[index].ConSer = numero.substring(0, numero.length - 1);
        }
        if (metodo == 5 && object != undefined) {
            numero = object;
            if (!/^([.0-9])*$/.test(numero))
                scope.TComisionesRangoGrib[index].ConCerVer = numero.substring(0, numero.length - 1);
        }
    }
    scope.regresar_comisiones = function() {
        Swal.fire({
            title: 'Volver',
            text: '¿Seguro que desea cerrar sin actualizar la información de las Comisiones?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Confirmar'
        }).then(function(t) {
            if (t.value == true) {
                location.href = "#/Anexos";
            } else {
                console.log('Cancelando Ando...');
                event.preventDefault();
            }
        });
    }
    if (scope.CodAneProID != undefined) {
        scope.Buscar_Tarifas_Anexos();
    }
    ////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE COMISIONES END ////////////////////////////////////////////////////////
}