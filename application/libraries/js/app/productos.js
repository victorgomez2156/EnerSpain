app.controller('Controlador_Productos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceComercializadora', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceComercializadora) {
    var scope = this;
    scope.fdatos = {};
    scope.productos = {};
    scope.nID = $route.current.params.ID;
    scope.INF = $route.current.params.INF;
    scope.Nivel = $cookies.get('nivel');
    scope.TProductos = [];
    scope.TProductosBack = [];
    scope.Tcomercializadoras = [];
    scope.TcomercializadorasBack = [];
    scope.TProComercializadoras = [];

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
    console.log($route.current.$$route.originalPath);
    if ($route.current.$$route.originalPath == "/Ver_Productos/:ID/:INF") {
        scope.validate_info_productos = scope.INF;
    }
    if ($route.current.$$route.originalPath == "/Edit_Productos/:ID") {
        scope.validate_info_productos = scope.INF;
    }
    ////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE PRODUCTOS START///////////////////////////////////////////////////

    scope.Topciones_Grib = [{ id: 4, nombre: 'Ver' }, { id: 3, nombre: 'Editar' }, { id: 1, nombre: 'Activar' }, { id: 2, nombre: 'Bloquear' }];
    scope.NumCifCom = true;
    scope.RazSocCom = true;
    scope.DesTPro = true;
    scope.SerTGas = true;
    scope.SerTEle = true;
    scope.EstTPro = true;
    scope.AccTPro = true;
    scope.TvistaProductos = 1;
    scope.tmodal_productos = {};
    scope.reporte_pdf_productos = 0;
    scope.reporte_excel_productos = 0;
    scope.ttipofiltrosProductos = [{ id: 1, nombre: 'Comercializadora' }, { id: 2, nombre: 'Tipo de Suministro' }, { id: 3, nombre: 'Fecha de Inicio' }, { id: 4, nombre: 'Estatus' }];
    scope.productos.SerGas = false;
    scope.productos.SerEle = false;

    ServiceComercializadora.getAll().then(function(dato) {
        scope.Tcomercializadoras = dato.Comercializadora;
        scope.TcomercializadorasBack = dato.Comercializadora;
        scope.TProComercializadoras = dato.TProComercializadoras;
        scope.Fecha_Server = dato.fecha;
        if (scope.nID == undefined) {
            scope.FecIniPro = scope.Fecha_Server;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniPro);
        }
        $scope.predicate1 = 'id';
        $scope.reverse1 = true;
        $scope.currentPage1 = 1;
        $scope.order1 = function(predicate1) {
            $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
            $scope.predicate1 = predicate1;
        };
        scope.TProductos = dato.Productos;
        scope.TProductosBack = dato.Productos;
        $scope.totalItems1 = scope.TProductos.length;
        $scope.numPerPage1 = 50;
        $scope.paginate1 = function(value1) {
            var begin1, end1, index1;
            begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
            end1 = begin1 + $scope.numPerPage1;
            index1 = scope.TProductos.indexOf(value1);
            return (begin1 <= index1 && index1 < end1);
        };
    }).catch(function(error) {
        console.log(error); //Tratar el error
        if (error.status == false && error.error == "This API key does not have access to the requested controller.") {
            Swal.fire({ title: "Error 401", text: 'Este API KEY no tiene acceso a este controlador', type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Unknown method.") {
            Swal.fire({ title: "Error 404", text: 'El método no puede ser localizado, intente más tarde', type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Unauthorized") {
            Swal.fire({ title: "Error 401", text: 'Usuario no autorizado', type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Invalid API Key.") {
            Swal.fire({ title: "Error 403", text: 'El API KEY que está intentando utilizar no es válido', type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Internal Server Error") {
            Swal.fire({ title: "Error 500", text: 'Ha ocurrido un error en el Servidor, intente más tarde', type: "error", confirmButtonColor: "#188ae2" });
        }
    });

    scope.cargar_lista_productos = function() {
        $("#List_Produc").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/get_list_productos/";
        $http.get(url).then(function(result) {
            $("#List_Produc").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate1 = 'id';
                $scope.reverse1 = true;
                $scope.currentPage1 = 1;
                $scope.order1 = function(predicate1) {
                    $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                    $scope.predicate1 = predicate1;
                };
                scope.TProductos = result.data;
                scope.TProductosBack = result.data;
                $scope.totalItems1 = scope.TProductos.length;
                $scope.numPerPage1 = 50;
                $scope.paginate1 = function(value1) {
                    var begin1, end1, index1;
                    begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                    end1 = begin1 + $scope.numPerPage1;
                    index1 = scope.TProductos.indexOf(value1);
                    return (begin1 <= index1 && index1 < end1);
                };
            } else {
                console.log('No existen Productos registrados');
                Swal.fire({ title: "Error 404", text: 'No existen Productos registrados', type: "error", confirmButtonColor: "#188ae2" });
                scope.TProductos = [];
                scope.TProductosBack = [];
            }
        }, function(error) {
            $("#List_Produc").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }


    $scope.SubmitFormFiltrosProductos = function(event) {
        console.log(event);
        console.log(scope.tmodal_productos.ttipofiltrosProductos);
        if (scope.tmodal_productos.ttipofiltrosProductos == 1) {
            console.log(scope.tmodal_productos);
            //NumCifCom
            $scope.predicate1 = 'id';
            $scope.reverse1 = true;
            $scope.currentPage1 = 1;
            $scope.order1 = function(predicate1) {
                $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                $scope.predicate1 = predicate1;
            };
            scope.TProductos = $filter('filter')(scope.TProductosBack, { NumCifCom: scope.tmodal_productos.NumCifCom }, true);
            $scope.totalItems1 = scope.TProductos.length;
            $scope.numPerPage1 = 50;
            $scope.paginate1 = function(value1) {
                var begin1, end1, index1;
                begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                end1 = begin1 + $scope.numPerPage1;
                index1 = scope.TProductos.indexOf(value1);
                return (begin1 <= index1 && index1 < end1);
            };
            scope.reporte_pdf_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.NumCifCom;
            scope.reporte_excel_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.NumCifCom;
        }
        if (scope.tmodal_productos.ttipofiltrosProductos == 2) {
            $scope.predicate1 = 'id';
            $scope.reverse1 = true;
            $scope.currentPage1 = 1;
            $scope.order1 = function(predicate1) {
                $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                $scope.predicate1 = predicate1;
            };
            if (scope.tmodal_productos.TipServ == 1) {
                scope.TProductos = $filter('filter')(scope.TProductosBack, { SerGas: scope.tmodal_productos.Select }, true);
            }
            if (scope.tmodal_productos.TipServ == 2) {
                scope.TProductos = $filter('filter')(scope.TProductosBack, { SerEle: scope.tmodal_productos.Select }, true);
            }
            $scope.totalItems1 = scope.TProductos.length;
            $scope.numPerPage1 = 50;
            $scope.paginate1 = function(value1) {
                var begin1, end1, index1;
                begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                end1 = begin1 + $scope.numPerPage1;
                index1 = scope.TProductos.indexOf(value1);
                return (begin1 <= index1 && index1 < end1);
            };
            scope.reporte_pdf_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.TipServ + "/" + scope.tmodal_productos.Select;
            scope.reporte_excel_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.TipServ + "/" + scope.tmodal_productos.Select;
        }
        if (scope.tmodal_productos.ttipofiltrosProductos == 3) {
            var FecIniPro1 = document.getElementById("FecIniPro").value;
            scope.tmodal_productos.FecIniPro = FecIniPro1;
            var FecIniPro = (scope.tmodal_productos.FecIniPro).split("/");
            if (FecIniPro.length < 3) {
                Swal.fire({ text: 'Error en Fecha de Inicio, el formato correcto es DD/MM/YYYY', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecIniPro[0].length > 2 || FecIniPro[0].length < 2) {
                    Swal.fire({ text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecIniPro[1].length > 2 || FecIniPro[1].length < 2) {
                    Swal.fire({ text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecIniPro[2].length < 4 || FecIniPro[2].length > 4) {
                    Swal.fire({ text: 'Error en Año, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
            }
            $scope.predicate1 = 'id';
            $scope.reverse1 = true;
            $scope.currentPage1 = 1;
            $scope.order1 = function(predicate1) {
                $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                $scope.predicate1 = predicate1;
            };
            scope.TProductos = $filter('filter')(scope.TProductosBack, { FecIniPro: scope.tmodal_productos.FecIniPro }, true);
            $scope.totalItems1 = scope.TProductos.length;
            $scope.numPerPage1 = 50;
            $scope.paginate1 = function(value1) {
                var begin1, end1, index1;
                begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                end1 = begin1 + $scope.numPerPage1;
                index1 = scope.TProductos.indexOf(value1);
                return (begin1 <= index1 && index1 < end1);
            };
            scope.reporte_pdf_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.FecIniPro;
            scope.reporte_excel_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.FecIniPro;
        }
        if (scope.tmodal_productos.ttipofiltrosProductos == 4) {
            $scope.predicate1 = 'id';
            $scope.reverse1 = true;
            $scope.currentPage1 = 1;
            $scope.order1 = function(predicate1) {
                $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                $scope.predicate1 = predicate1;
            };
            scope.TProductos = $filter('filter')(scope.TProductosBack, { EstPro: scope.tmodal_productos.EstPro }, true);
            $scope.totalItems1 = scope.TProductos.length;
            $scope.numPerPage1 = 50;
            $scope.paginate1 = function(value1) {
                var begin1, end1, index1;
                begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                end1 = begin1 + $scope.numPerPage1;
                index1 = scope.TProductos.indexOf(value1);
                return (begin1 <= index1 && index1 < end1);
            };
            scope.reporte_pdf_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.EstPro;
            scope.reporte_excel_productos = scope.tmodal_productos.ttipofiltrosProductos + "/" + scope.tmodal_productos.EstPro;
        }
    };
    scope.regresar_filtro_productos = function() {
        scope.tmodal_productos = {};

        $scope.predicate1 = 'id';
        $scope.reverse1 = true;
        $scope.currentPage1 = 1;
        $scope.order1 = function(predicate1) {
            $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
            $scope.predicate1 = predicate1;
        };
        scope.TProductos = scope.TProductosBack;
        $scope.totalItems1 = scope.TProductos.length;
        $scope.numPerPage1 = 50;
        $scope.paginate1 = function(value1) {
            var begin1, end1, index1;
            begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
            end1 = begin1 + $scope.numPerPage1;
            index1 = scope.TProductos.indexOf(value1);
            return (begin1 <= index1 && index1 < end1);
        };
        scope.reporte_pdf_productos = 0;
        scope.reporte_excel_productos = 0;
    }
    $scope.submitFormlockPro = function(event) {
        if (scope.t_modal_data.ObsBloPro == undefined || scope.t_modal_data.ObsBloPro == null || scope.t_modal_data.ObsBloPro == '') {
            scope.t_modal_data.ObsBloPro = null;
        } else {
            scope.t_modal_data.ObsBloPro = scope.t_modal_data.ObsBloPro;
        }
        var fecha_bloqueo = document.getElementById("fecha_bloqueo").value;
        scope.fecha_bloqueo = fecha_bloqueo;
        if (scope.fecha_bloqueo == undefined || scope.fecha_bloqueo == null || scope.fecha_bloqueo == '') {
            Swal.fire({ text: 'La Fecha de Bloqueo es obligatoria', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecBlo = (scope.fecha_bloqueo).split("/");
            if (FecBlo.length < 3) {
                Swal.fire({ text: 'Error en Fecha de Bloqueo, el formato correcto es DD/MM/YYYY', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecBlo[0].length > 2 || FecBlo[0].length < 2) {
                    Swal.fire({ text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBlo[1].length > 2 || FecBlo[1].length < 2) {
                    Swal.fire({ text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBlo[2].length < 4 || FecBlo[2].length > 4) {
                    Swal.fire({ text: 'Error en Año, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.fecha_bloqueo.split("/");
                valuesEnd = scope.Fecha_Server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ text: 'La Fecha de Bloqueo no puede ser mayor a ' + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.t_modal_data.FecBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
            }
        }
        Swal.fire({
            text: '¿Seguro que desea bloquear el Producto?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Confirmar'
        }).then(function(t) {
            if (t.value == true) {
                console.log(scope.t_modal_data);
                scope.cambiar_estatus_productos(scope.t_modal_data.OpcPro, scope.t_modal_data.CodPro);
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.cambiar_estatus_productos = function(opciones_productos, CodPro, index) {
        scope.status_producto = {};
        scope.status_producto.EstPro = opciones_productos;
        scope.status_producto.CodPro = CodPro;

        if (opciones_productos == 2) {
            scope.status_producto.MotBloqPro = scope.t_modal_data.MotBloPro;
            scope.status_producto.ObsBloPro = scope.t_modal_data.ObsBloPro;
            scope.status_producto.FecBlo = scope.t_modal_data.FecBlo;
            console.log(scope.status_producto);
        }
        console.log(scope.status_producto);
        $("#estatus").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/cambiar_estatus_productos/";
        $http.post(url, scope.status_producto).then(function(result) {
            $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data.resultado != false) {
                if (opciones_productos == 1) {
                    var title = 'Activando';
                    var text = 'El Producto ha sido activado de forma correcta';
                }
                if (opciones_productos == 2) {
                    var title = 'Bloqueando';
                    var text = 'El Producto ha sido bloqueado de forma correcta';
                    $("#modal_motivo_bloqueo_productos").modal('hide');
                }
                Swal.fire({ title: title, text: text, type: "success", confirmButtonColor: "#188ae2" });
                scope.opciones_productos[index] = undefined;
                scope.cargar_lista_productos();
            } else {
                Swal.fire({ title: "Error", text: "Ha ocurrido un error actualizando el Producto", type: "error", confirmButtonColor: "#188ae2" });
                scope.cargar_lista_productos();
            }

        }, function(error) {
            $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.validar_opcion_productos = function(index, opciones_productos, dato) {
        console.log(index);
        console.log(opciones_productos);
        console.log(dato);
        if (opciones_productos == 1) {
            scope.opciones_productos[index] = undefined;
            if (dato.EstPro == 'ACTIVO') {
                Swal.fire({ text: 'El Producto ya se encuentra activo', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            Swal.fire({
                /**title: 'Activando',**/
                text: '¿Seguro que desea activar el Producto?',
                type: "info",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: 'Confirmar'
            }).then(function(t) {
                if (t.value == true) {
                    scope.cambiar_estatus_productos(opciones_productos, dato.CodPro, index);
                } else {
                    console.log('Cancelando ando...');
                }
            });
        }
        if (opciones_productos == 2) {
            scope.t_modal_data = {};
            scope.opciones_productos[index] = undefined;
            if (dato.EstPro == 'BLOQUEADO') {
                Swal.fire({ text: 'El Producto ya se encuentra bloqueado', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.t_modal_data.CodPro = dato.CodPro;
            scope.Comercializadora = dato.NumCifCom + " - " + dato.RazSocCom;
            scope.Producto = dato.DesPro;
            scope.fecha_bloqueo = scope.Fecha_Server;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fecha_bloqueo);

            scope.t_modal_data.OpcPro = opciones_productos;
            $("#modal_motivo_bloqueo_productos").modal('show');
        }
        if (opciones_productos == 3) {
            scope.opciones_productos[index] = undefined;
            location.href = "#/Edit_Productos/" + dato.CodPro;
        }
        if (opciones_productos == 4) {
            scope.opciones_productos[index] = undefined;
            location.href = "#/Ver_Productos/" + dato.CodPro + "/" + 1;
        }
    }
    scope.validar_fecha = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.FecIniPro = numero.substring(0, numero.length - 1);
        }
    }

    scope.regresar_productos = function() {
        if (scope.INF == undefined) {
            if (scope.productos.CodTPro == undefined) {
                var title = 'Guardando';
                var text = '¿Seguro que desea cerrar sin registrar el Producto?';
            } else {
                var title = 'Actualizando';
                var text = '¿Seguro que desea cerrar sin actualizar la información del Producto';
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
                    location.href = "#/Productos";
                    scope.productos = {};
                } else {
                    console.log('Cancelando ando...');
                }
            });
        } else {
            location.href = "#/Productos";
            scope.productos = {};
        }
    }
    scope.limpiar_productos = function() {
        scope.productos = {};
        scope.productos.SerGas = false;
        scope.productos.SerEle = false;
        scope.validate_info_productos = undefined;
        //scope.FecIniPro=fecha;
    }
    scope.BuscarxID = function() {
        $("#cargando_xID").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/Buscar_xID_Productos/CodPro/" + scope.nID;
        $http.get(url).then(function(result) {
            console.log(result.data);
            $("#cargando_xID").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                //scope.productos=result.data;
                scope.productos.CodTProCom = result.data.CodCom;
                scope.productos.DesPro = result.data.DesPro;
                scope.FecIniPro = result.data.FecIniPro;
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniPro);
                scope.productos.CodTPro = result.data.CodPro;
                scope.productos.ObsPro = result.data.ObsPro;
                if (result.data.SerGas == 0) {
                    scope.productos.SerGas = false;
                } else {
                    scope.productos.SerGas = true;
                }
                if (result.data.SerEle == 0) {
                    scope.productos.SerEle = false;
                } else {
                    scope.productos.SerEle = true;
                }
            } else {
                Swal.fire({ title: "Error", text: 'No hay información registrada', type: "error", confirmButtonColor: "#188ae2" });
                scope.validate_info_productos = 1;
                scope.productos = {};
                scope.productos.CodTPro = scope.nID;
            }

        }, function(error) {
            $("#cargando_xID").removeClass("loader loader-default is-active").addClass("loader loader-default");
            scope.validate_info_productos = 1;
            scope.productos = {};
            scope.productos.CodTPro = scope.nID;
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
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }

    $scope.submitFormProductos = function(event) {
        if (!scope.validar_campos_productos()) {
            return false;
        }
        if (scope.productos.CodTPro == undefined) {
            var titulo = 'Guardando';
            var texto = '¿Seguro que desea registrar el Producto?';
            var response = 'El Producto se ha creado de forma correcta';
        } else {
            var titulo = 'Actualizando';
            var texto = '¿Seguro que desea modificar la información del Producto?';
            var response = 'El Producto se ha actualizado de forma correcta';
        }
        if (scope.productos.ObsPro == undefined || scope.productos.ObsPro == null || scope.productos.ObsPro == '') {
            scope.productos.ObsPro = null;
        } else {
            scope.productos.ObsPro = scope.productos.ObsPro;
        }
        console.log(scope.productos);
        Swal.fire({
            title: titulo,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercializadora/registrar_productos/";
                $http.post(url, scope.productos).then(function(result) {
                    scope.nIDPro = result.data.CodTPro;
                    if (result.data != false) {
                        $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ title: titulo, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.productos = result.data;
                    } else {
                        $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ title: "Error", text: 'Ha ocurrido un error, intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                        Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    };

    scope.validar_campos_productos = function() {
        resultado = true;
        if (!scope.productos.CodTProCom > 0) {
            Swal.fire({ text: 'Seleccione una Comercializadora del listado', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.productos.DesPro == null || scope.productos.DesPro == undefined || scope.productos.DesPro == '') {
            Swal.fire({ text: 'El Nombre del Producto es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        var FecIniPro1 = document.getElementById("FecIniPro").value;
        scope.FecIniPro = FecIniPro1;
        if (scope.FecIniPro == null || scope.FecIniPro == undefined || scope.FecIniPro == '') {
            Swal.fire({ text: 'La Fecha de Inicio es obligatoria', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecIniPro = (scope.FecIniPro).split("/");
            if (FecIniPro.length < 3) {
                Swal.fire({ text: 'Error en Fecha de Inicio, el formato correcto es DD/MM/YYYY', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecIniPro[0].length > 2 || FecIniPro[0].length < 2) {
                    Swal.fire({ text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;

                }
                if (FecIniPro[1].length > 2 || FecIniPro[1].length < 2) {
                    Swal.fire({ text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecIniPro[2].length < 4 || FecIniPro[2].length > 4) {
                    Swal.fire({ text: 'Error en Año, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecIniPro.split("/");
                valuesEnd = scope.Fecha_Server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ text: 'La Fecha de Inicio no puede ser mayor a ' + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.productos.FecIniPro = valuesStart[2] + "/" + valuesStart[1] + "/" + valuesStart[0];
            }
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.validarsifechaproductos = function(object, metodo) {
        if (object != undefined && metodo == 1) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.tmodal_productos.FecIniPro = numero.substring(0, numero.length - 1);
        }
        if (object != undefined && metodo == 2) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.fecha_bloqueo = numero.substring(0, numero.length - 1);
        }
    }
    if (scope.nID != undefined) {
        scope.BuscarxID();
    }
}