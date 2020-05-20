app.controller('Controlador_Comisiones_Servicios_Adicionales', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    var scope = this;
    scope.fdatos = {};
    scope.anexos = {};
    scope.CodSerEspID = $route.current.params.CodSerEsp;
    scope.CIFComision = $route.current.params.NumCifCom;
    scope.ComerComision = $route.current.params.RazSocCom;
    scope.DesSerEsp = $route.current.params.DesSerEsp;
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

    console.log($route.current.$$route.originalPath);
    ///////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE COMISIONES START ////////////////////////////////////////////////
    scope.Buscar_Tarifas_Servicios_Adicionales = function() {
        $("#Car_Det").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/buscar_detalle_Servicios_Especiales_comision/CodSerEsp/" + scope.CodSerEspID;
        $http.get(url).then(function(result) {
            $("#Car_Det").removeClass("loader loader-default is-active").addClass("loader loader-default");

            if (result.data != false) {
                $scope.predicate4 = 'id';
                $scope.reverse4 = true;
                $scope.currentPage4 = 1;
                $scope.order4 = function(predicate4) {
                    $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
                    $scope.predicate4 = predicate4;
                };
                scope.TComisionesDet = result.data;
                $scope.totalItems4 = scope.TComisionesDet.length;
                $scope.numPerPage4 = 50;
                $scope.paginate4 = function(value4) {
                    var begin4, end4, index4;
                    begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
                    end4 = begin4 + $scope.numPerPage4;
                    index4 = scope.TComisionesDet.indexOf(value4);
                    return (begin4 <= index4 && index4 < end4);
                };
            } else {
                Swal.fire({ title: "Error", text: 'No existen Tarifas registradas', type: "info", confirmButtonColor: "#188ae2" });
                scope.comisiones = false;
                scope.TComisionesRangoGrib = [];
                scope.TComisionesDet = [];
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
                Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.validar_inputs = function(metodo, object, index) {
        console.log(metodo);
        console.log(object);
        console.log(index);
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
    scope.agregar_detalle_comision = function(index, CodDetSerEsp, dato) {
        //console.log('Index: '+index);
        //console.log('CodDetSerEsp: '+CodDetSerEsp);		
        //console.log(dato);
        if (scope.Block_Deta == 1) {
            Swal.fire({ title: "Error", text: 'No es posible continuar con la operación porque está actualizando Comisiones', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            $("#Car_Det").removeClass("loader loader-default").addClass("loader loader-default is-active");
            var url = base_urlHome() + "api/Comercializadora/buscar_comisiones_detalles_servicios_especiales/CodSerEsp/" + dato.CodSerEsp + "/CodDetSerEsp/" + dato.CodDetSerEsp + "/CodTarEle/" + dato.CodTarEle;
            $http.get(url).then(function(result) {
                $("#Car_Det").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (result.data != false) {
                    scope.select_det_com[CodDetSerEsp] = dato;
                    scope.CodSerEsp = dato.CodSerEsp;
                    scope.CodDetSerEsp = dato.CodDetSerEsp;
                    scope.CodTarEle = dato.CodTarEle;
                    scope.Block_Deta = 1;
                    angular.forEach(result.data, function(Comisiones) {
                        if (Comisiones.TipServ == "Eléctrico") {
                            scope.TipServ = 1;
                        }
                        if (Comisiones.TipServ == "Gas") {
                            scope.TipServ = 2;
                        }
                        var ObjDetCom = new Object();
                        if (scope.TComisionesRangoGrib == undefined || scope.TComisionesRangoGrib == false) {
                            scope.TComisionesRangoGrib = [];
                        }
                        scope.TComisionesRangoGrib.push({ CodDetCom: Comisiones.CodDetCom, CodDetSerEsp: Comisiones.CodDetSerEsp, CodSerEsp: Comisiones.CodSerEsp, CodTarEle: Comisiones.CodTarEle, TipServ: scope.TipServ, RanCon: Comisiones.RanCon, ConMinAnu: Comisiones.ConMinAnu, ConMaxAnu: Comisiones.ConMaxAnu, ConSer: Comisiones.ConSer, ConCerVer: Comisiones.ConCerVer });
                        console.log(scope.TComisionesRangoGrib);
                    });
                } else {
                    scope.select_det_com[CodDetSerEsp] = dato;
                    scope.CodSerEsp = dato.CodSerEsp;
                    scope.CodDetSerEsp = dato.CodDetSerEsp;
                    scope.CodTarEle = dato.CodTarEle;
                    scope.Block_Deta = 1;
                    if (dato.TipServ == "Eléctrico") {
                        scope.TipServ = 1;
                    }
                    if (dato.TipServ == "Gas") {
                        scope.TipServ = 2;
                    }
                    var ObjDetCom = new Object();
                    if (scope.TComisionesRangoGrib == undefined || scope.TComisionesRangoGrib == false) {
                        scope.TComisionesRangoGrib = [];
                    }
                    scope.TComisionesRangoGrib.push({ CodDetSerEsp: dato.CodDetSerEsp, CodSerEsp: dato.CodSerEsp, CodTarEle: dato.CodTarEle, TipServ: scope.TipServ, ConSer: "0.00", ConCerVer: "0.00" });
                    console.log(scope.TComisionesRangoGrib);
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
                    Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                }
            });
        }
    }
    scope.quitar_detalle_comision = function(index, CodDetSerEsp, dato) {
        scope.select_det_com[CodDetSerEsp] = false;
        scope.TComisionesRangoGrib = [];
        scope.Block_Deta = 0;
        console.log(scope.TComisionesRangoGrib);
    }
    scope.agregardetalle = function() {
        var ObjDetCom = new Object();
        ObjDetCom.RanConsu = 0;
        ObjDetCom.ConMinAn = 0;
        ObjDetCom.ConMaxAn = 0;
        ObjDetCom.ConServ = 0;
        ObjDetCom.ConCerVer = 0;
        //console.log(scope.TComisionesRangoGrib);
        if (scope.TComisionesRangoGrib == undefined || scope.TComisionesRangoGrib == false) {
            scope.TComisionesRangoGrib = [];
        }
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
            scope.TComisionesRangoGrib.push({ CodDetSerEsp: b.CodDetSerEsp, CodSerEsp: b.CodSerEsp, CodTarEle: b.CodTarEle, TipServ: b.TipServ, RanCon: null, ConMinAnu: b.ConMinAnu, ConMaxAnu: b.ConMaxAnu, ConSer: b.ConSer, ConCerVer: b.ConCerVer });
            scope.ConMinAnuCoo = Math.max(parseFloat(b.ConMaxAnu), 0) + 1;
        }
        scope.TComisionesRangoGrib.push({ CodDetSerEsp: scope.CodDetSerEsp, CodSerEsp: scope.CodSerEsp, CodTarEle: scope.CodTarEle, TipServ: scope.TipServ, ConMinAnu: scope.ConMinAnuCoo, ConSer: "0.00", ConCerVer: "0.00" });
        console.log(scope.TComisionesRangoGrib);
    }
    scope.quitar_detalle_comision_length = function() {
        if (scope.TComisionesRangoGrib.length > 0) {
            var a = scope.TComisionesRangoGrib;
            var b = a.pop();
            for (var i = 0; i <= a.length - 1; i++) {
                console.log(i + " " + a[i]);
            }
            console.log(b);
            console.log(scope.select_det_com);
            console.log(scope.TComisionesRangoGrib);
            if (scope.TComisionesRangoGrib.length == 0) {
                scope.Block_Deta = 0;
                scope.select_det_com[b.CodDetSerEsp] = false;
            }
        }
    }

    scope.guardar_comisiones = function() {
        console.log(scope.TComisionesRangoGrib);
        if (!scope.validar_campos_detalles_comisiones()) {
            return false;
        }
        scope.datos_enviar = {};
        scope.datos_enviar.CodSerEsp = scope.CodSerEsp;
        scope.datos_enviar.CodTarEle = scope.CodTarEle;
        scope.datos_enviar.CodDetSerEsp = scope.CodDetSerEsp;
        scope.datos_enviar.TipServ = scope.TipServ;
        scope.datos_enviar.Detalles = scope.TComisionesRangoGrib;
        console.log(scope.datos_enviar);
        Swal.fire({
            title: 'Comisiones',
            text: '¿Seguro que desea registrar la Comisión?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#Guar_Deta").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercializadora/guardar_comisiones_detalles_servicios_especiales/";
                $http.post(url, scope.datos_enviar).then(function(result) {
                    $("#Guar_Deta").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: 'Comisiones', text: 'Comisiones actualizadas de forma correcta', type: "success", confirmButtonColor: "#188ae2" });
                    } else {
                        Swal.fire({ title: "Error", text: 'Ha ocurrido un error, intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });
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
                        Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error del Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
            Swal.fire({ title: "Error", text: 'Debe agregar información del rango para poder continuar', type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: 'Consumo Mínimo', text: 'El Consumo Mínimo es requerido', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
            if (scope.TComisionesRangoGrib[i].ConMaxAnu == undefined || scope.TComisionesRangoGrib[i].ConMaxAnu == null || scope.TComisionesRangoGrib[i].ConMaxAnu == '') {
                Swal.fire({ title: 'Consumo Máximo', text: 'El Consumo Máximo es requerido', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
            if (scope.TComisionesRangoGrib[i].ConSer == undefined || scope.TComisionesRangoGrib[i].ConSer == null || scope.TComisionesRangoGrib[i].ConSer == '') {
                Swal.fire({ title: 'Comisión Servicios', text: 'La Comisión de Servicio es obligatoria', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
            if (scope.TComisionesRangoGrib[i].ConCerVer == undefined || scope.TComisionesRangoGrib[i].ConCerVer == null || scope.TComisionesRangoGrib[i].ConCerVer == '') {
                Swal.fire({ title: 'Comisión Certificado Verde', text: 'La Comisión de Certificado Verde es obligatoria', type: "error", confirmButtonColor: "#188ae2" });
                i = scope.TComisionesRangoGrib.length;
                resultado = false;
            }
        }
        if (resultado == false) {
            return false;
        }
        return true;
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
                location.href = "#/Servicios_Adicionales";
            } else {
                console.log('Cancelando Ando...');
                event.preventDefault();
            }
        });
    }
    if (scope.CodSerEspID != undefined) {
        scope.Buscar_Tarifas_Servicios_Adicionales();
    }
    ////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE COMISIONES END ////////////////////////////////////////////////////////
}