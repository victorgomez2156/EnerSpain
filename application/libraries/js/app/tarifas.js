app.controller('Controlador_Tarifas', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('Controlador_Clientes as vmAE',{$scope:$scope});
    //var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
    //$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
    //var testCtrl1ViewModel = $controller('Controlador_Clientes');
    //testCtrl1ViewModel.cargar_lista_clientes();
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.fdatos_tar_elec = {};
    scope.fdatos_tar_gas = {};
    //scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
    scope.Nivel = $cookies.get('nivel');
    //testCtrl1ViewModel.cargar_lista_clientes();
    scope.TVistaTarEle = 1;
    scope.T_TarifasEle = [];
    scope.T_TarifasEleBack = [];
    scope.ruta_reportes_pdf_tarifas_electrica = "AMBAS";
    scope.ruta_reportes_excel_tarifas_electrica = "AMBAS";
    scope.TipTen = true;
    scope.NomTarEle = true;
    scope.CanPerTar = true;
    scope.MinPotCon = true;
    scope.MaxPotCom = true;
    scope.AccTarElec = true;

    scope.TVistaTarGas = 1;
    scope.T_TarifasGas = [];
    scope.T_TarifasGasBack = [];
    scope.ruta_reportes_pdf_tarifas_gas = 0;
    scope.ruta_reportes_excel_tarifas_gas = 0;
    scope.NomTarGas = true;
    scope.MinConAnu = true;
    scope.MaxConAnu = true;
    scope.AccTarGas = true;
    scope.topciones = [{ id: 1, nombre: 'Ver' }, { id: 2, nombre: 'Editar' }];
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

    ///////////////////////TARIFAS ELECTRICAS START///////////////////////////
    scope.cargar_lista_Tarifa_Electrica = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Tarifas/get_list_tarifa_electricas";
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
                scope.T_TarifasEle = result.data;
                scope.T_TarifasEleBack = result.data;
                $scope.totalItems = scope.T_TarifasEle.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.T_TarifasEle.indexOf(value);
                    return (begin <= index && index < end);
                };
            } else {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: 'Tarifa Eléctrica', text: 'No se encontraron datos.', type: "info", confirmButtonColor: "#188ae2" });
                scope.T_TarifasEle = [];
                scope.T_TarifasEleBack = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.borrar_TarEle = function() {
            if (scope.Nivel != 1) {
                Swal.fire({ title: "Error", text: "Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.", type: "error", confirmButtonColor: "#188ae2" });
                return false;

            }
            Swal.fire({
                title: 'Borrando',
                text: "Estás seguro de eliminar este registro.?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "OK"
            }).then(function(t) {
                if (t.value == true) {
                    $("#borrando").removeClass("loader loader-default").addClass("loader loader-default is-active");
                    var url = base_urlHome() + "api/Tarifas/borrar_tarifa_electrica/CodTarEle/" + scope.fdatos_tar_elec.CodTarEle;
                    $http.delete(url).then(function(result) {
                        if (result.data != false) {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            Swal.fire({ title: "Exito!", text: "Registro eliminado de forma correcta", type: "error", confirmButtonColor: "#188ae2" });
                            scope.TVistaTarEle = 1;
                            scope.cargar_lista_Tarifa_Electrica();
                        } else {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            Swal.fire({ title: "Error", text: "No se pudo eliminar el registro intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                        }
                    }, function(error) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                } else {
                    console.log('Cancelando ando...');
                }
            });
        }
        /*scope.borrar_row_electrica=function(index,id)
        {
        	if(scope.Nivel!=1)
        	{
        		Swal.fire({title:"Error",text:"Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.",type:"error",confirmButtonColor:"#188ae2"});
        		return false;
        	}
        	Swal.fire({title:"Esta seguro de eliminar este registro.?",			
        	type:"question",
        	showCancelButton:!0,
        	confirmButtonColor:"#31ce77",
        	cancelButtonColor:"#f34943",
        	confirmButtonText:"OK"}).then(function(t)
        	{
                if(t.value==true)
            	{
                 	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        			var url = base_urlHome()+"api/Tarifas/borrar_tarifa_electrica/CodTarEle/"+id;
        			$http.delete(url).then(function(result)
        			{
        				if(result.data!=false)
        				{
        					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        					Swal.fire({title:"Error",text:"Registro eliminado de forma correcta",type:"success",confirmButtonColor:"#188ae2"});
        					scope.T_TarifasEle.splice(index,1);						
        				}
        				else
        				{
        					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        					Swal.fire({title:"Error",text:"No se ha podido eliminar el registro, intente nuevamente",type:"error",confirmButtonColor:"#188ae2"});						
        				}
        			},function(error)
        			{
        				$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );						
        				if(error.status==404 && error.statusText=="Not Found")
        				{
        					Swal.fire({title:"Error.",text:"El método que está intentando usar no puede ser localizado",type:"error",confirmButtonColor:"#188ae2"});
        				}
        				if(error.status==401 && error.statusText=="Unauthorized")
        				{
        					Swal.fire({title:"Error de Privilegios",text:"Usuario no autorizado para acceder a este Módulo",type:"info",confirmButtonColor:"#188ae2"});
        				}
        				if(error.status==403 && error.statusText=="Forbidden")
        				{
        					Swal.fire({title:"Seguridad.",text:"Está intentando utilizar un APIKEY inválido",type:"question",confirmButtonColor:"#188ae2"});
        				}
        				if(error.status==500 && error.statusText=="Internal Server Error")
        				{				
        					Swal.fire({title:"Error.",text:"Ha ocurrido una falla en el Servidor, intente más tarde",type:"error",confirmButtonColor:"#188ae2"});
        				}
        			}); 
                }
                else
                {
                    console.log('Cancelando ando...');	                
                }
            });
        }*/
    scope.validar_opcion_TarEle = function(index, opciones_TarEle, dato) {
        console.log(index);
        console.log(opciones_TarEle);
        console.log(dato);
        if (opciones_TarEle == 1) {

            scope.opciones_TarEle[index] = undefined;
            scope.fdatos_tar_elec = dato;
            scope.TVistaTarEle = 2;
            scope.disabled_form_TarEle = 1;
            if (dato.TipTen == "BAJA") {
                scope.fdatos_tar_elec.TipTen = "0";
            } else {
                scope.fdatos_tar_elec.TipTen = "1";
            }
        }
        if (opciones_TarEle == 2) {
            scope.opciones_TarEle[index] = undefined;
            scope.fdatos_tar_elec = dato;
            scope.TVistaTarEle = 2;
            scope.disabled_form_TarEle = undefined;
            if (dato.TipTen == "BAJA") {
                scope.fdatos_tar_elec.TipTen = "0";
            } else {
                scope.fdatos_tar_elec.TipTen = "1";
            }
        }
    }
    scope.agregar_tarifa_electrica = function() {
        scope.TVistaTarEle = 2;
        scope.fdatos_tar_elec = {};
        scope.disabled_form_TarEle = undefined;
    }
    scope.validarsinumeroTarEle = function(metodo, object) {
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([0-9])*$/.test(numero))
                    scope.fdatos_tar_elec.CanPerTar = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_tar_elec.MinPotCon = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_tar_elec.MaxPotCon = numero.substring(0, numero.length - 1);
            }
        }
    }
    scope.limpiar_TarEle = function() {
        scope.fdatos_tar_elec = {};
    }
    scope.regresar_TarEle = function() {

        if (scope.fdatos_tar_elec.CodTarEle == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea cerrar sin registrar la Tarifa Eléctrica?';
        } else {
            var title = 'Actualizando';
            var text = '¿Seguro que desea cerrar sin actualizar la información de la Tarifa Elétrica?';
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
                scope.fdatos_tar_elec = {};
                scope.TVistaTarEle = 1;
                scope.cargar_lista_Tarifa_Electrica();
            } else {
                console.log('Cancelando ando...');
            }
        });
    }
    $scope.submitFormTarEle = function(event) {
        if (!scope.validar_campos_tension()) {
            return false;
        }
        if (scope.fdatos_tar_elec.CodTarEle == undefined) {
            var titulo = 'Guardando';
            var text = '¿Seguro que desea registrar la Tarifa Eléctrica?';
            var response = 'La Tarifa Eléctrica se ha registrado de forma correcta';
        } else {
            var titulo = 'Actualizando';
            var text = '¿Seguro que desea actualizar la información de la Tarifa Eléctrica?';
            var response = 'La Tarifa Eléctrica se ha modificado de forma correcta';
        }
        console.log(scope.fdatos_tar_elec);
        Swal.fire({
            title: titulo,
            text: text,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Tarifas/crear_tarifa_electrica/";
                $http.post(url, scope.fdatos_tar_elec).then(function(result) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.nID = result.data.CodTarEle;
                    if (result.data != false) {
                        Swal.fire({ title: titulo, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXIDTarEle();
                    } else {
                        Swal.fire({ text: 'Ha ocurro un error, por favor intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });

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
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_tension = function() {
        resultado = true;
        if (scope.fdatos_tar_elec.TipTen == null || scope.fdatos_tar_elec.TipTen == undefined || scope.fdatos_tar_elec.TipTen == '') {
            Swal.fire({ text: 'Seleccionar un Tipo de Tensión', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos_tar_elec.CanPerTar == null || scope.fdatos_tar_elec.CanPerTar == undefined || scope.fdatos_tar_elec.CanPerTar == '') {
            Swal.fire({ text: 'La Cantidad de Períodos es obligatoria', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos_tar_elec.MinPotCon == null || scope.fdatos_tar_elec.MinPotCon == undefined || scope.fdatos_tar_elec.MinPotCon == '') {
            Swal.fire({ text: 'Introduzca la Potencia Mínima', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos_tar_elec.MaxPotCon == null || scope.fdatos_tar_elec.MaxPotCon == undefined || scope.fdatos_tar_elec.MaxPotCon == '') {
            Swal.fire({ text: 'Introduzca la Potencia Máxima', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.buscarXIDTarEle = function() {
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Tarifas/buscar_XID_TarEle/CodTarEle/" + scope.nID;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos_tar_elec = result.data;
                console.log(scope.fdatos_tar_elec);
            } else {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: 'No hay información', type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.editar_TarEle = function(dato) {
        console.log(dato);
        scope.fdatos_tar_elec = {};
        scope.TVistaTarEle = 2;

        scope.fdatos_tar_elec = dato;
        if (dato.TipTen == "BAJA") {
            scope.fdatos_tar_elec.TipTen = 0;
        } else {
            scope.fdatos_tar_elec.TipTen = 1;
        }
    }
    $scope.SubmitFormFiltrosTarEle = function(event) {
        if (scope.tmodal_TarEle.tipo_filtro == 1) {

            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };

            scope.T_TarifasEle = $filter('filter')(scope.T_TarifasEleBack, { TipTen: scope.tmodal_TarEle.TipTen }, true);
            if (scope.tmodal_TarEle.TipTen == "AMBAS") {
                scope.T_TarifasEle = scope.T_TarifasEleBack;
            }
            $scope.totalItems = scope.T_TarifasEle.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_TarifasEle.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_tarifas_electrica = scope.tmodal_TarEle.TipTen;
            scope.ruta_reportes_excel_tarifas_electrica = scope.tmodal_TarEle.TipTen;
        }
    };
    scope.regresar_filtro_TarEle = function() {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.T_TarifasEle = scope.T_TarifasEleBack
            $scope.totalItems = scope.T_TarifasEle.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_TarifasEle.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_tarifas_electrica = "AMBAS";
            scope.ruta_reportes_excel_tarifas_electrica = "AMBAS";
        }
        scope.FetchTarEle = function()
    {
        if(scope.filtrar_tarifa_electrinca==undefined||scope.filtrar_tarifa_electrinca==null||scope.filtrar_tarifa_electrinca=='')
        {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.T_TarifasEle = scope.T_TarifasEleBack;
            $scope.totalItems = scope.T_TarifasEle.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_TarifasEle.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_tarifas_electrica = 0;
            scope.ruta_reportes_excel_tarifas_electrica =0;
        }
        else
        {
            if(scope.filtrar_tarifa_electrinca.length>0)
            {
                scope.fdatos.filtrar_tarifa_electrinca=scope.filtrar_tarifa_electrinca;   
                var url = base_urlHome()+"api/Tarifas/getTarEleFilter";
                $http.post(url,scope.fdatos).then(function(result)
                {
                    console.log(result.data);
                    if (result.data != false)
                    {                        
                        $scope.predicate = 'id';
                        $scope.reverse = true;
                        $scope.currentPage = 1;
                        $scope.order = function(predicate) {
                            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                            $scope.predicate = predicate;
                        };
                        scope.T_TarifasEle = result.data;
                        $scope.totalItems = scope.T_TarifasEle.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.T_TarifasEle.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_tarifas_electrica = 2 + "/" + scope.filtrar_tarifa_electrinca;
                        scope.ruta_reportes_excel_tarifas_electrica = 2 + "/" + scope.filtrar_tarifa_electrinca;
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No existen Tarifas Eléctricas registradas", type: "error", confirmButtonColor: "#188ae2" });                    
                        scope.T_TarifasEle=[];
                        scope.ruta_reportes_pdf_tarifas_electrica = 0;
                        scope.ruta_reportes_excel_tarifas_electrica =0;
                    }
                }, function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found"){
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
        }              
    }
 /////////////////////////////////////////////////////////////////////////////////TARIFAS ELECTRIAS END///////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////TARIFAS GAS START///////////////////////////////////////////////////////////

    scope.cargar_lista_Tarifa_Gas = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Tarifas/get_list_tarifa_Gas";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                $scope.predicate1 = 'id';
                $scope.reverse1 = true;
                $scope.currentPage1 = 1;
                $scope.order1 = function(predicate1) {
                    $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                    $scope.predicate1 = predicate1;
                };
                scope.T_TarifasGas = result.data;
                scope.T_TarifasGasBack = result.data;
                $scope.totalItems1 = scope.T_TarifasGas.length;
                $scope.numPerPage1 = 50;
                $scope.paginate1 = function(value1) {
                    var begin1, end1, index1;
                    begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                    end1 = begin1 + $scope.numPerPage1;
                    index1 = scope.T_TarifasGas.indexOf(value1);
                    return (begin1 <= index1 && index1 < end1);
                };
            } else {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ text: 'No hay información', type: "info", confirmButtonColor: "#188ae2" });
                scope.T_TarifasGas = [];
                scope.T_TarifasGasBack = [];
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
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.validar_opcion_TarGas = function(index, opciones_TarGas, dato) {
        console.log(index);
        console.log(opciones_TarGas);
        console.log(dato);
        if (opciones_TarGas == 1) {
            scope.opciones_TarGas[index] = undefined;
            scope.fdatos_tar_gas = dato;
            scope.TVistaTarGas = 2;
            scope.disabled_form_TarGas = 1;

        }
        if (opciones_TarGas == 2) {
            scope.opciones_TarGas[index] = undefined;
            scope.fdatos_tar_gas = dato;
            scope.TVistaTarGas = 2;
            scope.disabled_form_TarGas = undefined;
        }
    }
    scope.agg_TarGas = function() {
        scope.TVistaTarGas = 2;
        scope.fdatos_tar_gas = {};
        scope.disabled_form_TarGas = undefined;
    }
    scope.validarsinumeroTarGas = function(metodo, object) {
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_tar_gas.MinConAnu = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_tar_gas.MaxConAnu = numero.substring(0, numero.length - 1);
            }
        }
    }
    $scope.submitFormTarGas = function(event) {
        if (!scope.validar_campos_TarGas()) {
            return false;
        }
        if (scope.fdatos_tar_gas.CodTarGas == undefined) {
            var titulo = 'Guardando';
            var titulo2 = 'La Tarifa de Gas ha sido registrada de forma correcta';
            var texto = '¿Seguro que desea registrar la Tarifa de Gas?';
        } else {
            var titulo = 'Actualizando';
            var titulo2 = 'La Tarifa de Gas ha sido modificada de forma correcta';
            var texto = '¿Seguro que desea actualizar la información de la Tarifa de Gas?';
        }
        console.log(scope.fdatos_tar_gas);
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
                var url = base_urlHome() + "api/Tarifas/crear_tarifa_gas/";
                $http.post(url, scope.fdatos_tar_gas).then(function(result) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.nIDTarGas = result.data.CodTarGas;
                    if (result.data != false) {
                        Swal.fire({ title: titulo, text: titulo2, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXIDTarGas();
                    } else {
                        Swal.fire({ title: titulo, text: 'Ha ocurrido un error, por favor intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });

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
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_TarGas = function() {
        resultado = true;
        if (scope.fdatos_tar_gas.NomTarGas == null || scope.fdatos_tar_gas.NomTarGas == undefined || scope.fdatos_tar_gas.NomTarGas == '') {
            Swal.fire({ text: 'El nombre de la Tarifa es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos_tar_gas.MinConAnu == null || scope.fdatos_tar_gas.MinConAnu == undefined || scope.fdatos_tar_gas.MinConAnu == '') {
            Swal.fire({ text: 'El Consumo Mínimo es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos_tar_gas.MaxConAnu == null || scope.fdatos_tar_gas.MaxConAnu == undefined || scope.fdatos_tar_gas.MaxConAnu == '') {
            Swal.fire({ text: 'El Consumo Máximo es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }

        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.buscarXIDTarGas = function() {
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Tarifas/buscar_XID_TarGas/CodTarGas/" + scope.nIDTarGas;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos_tar_gas = result.data;
                console.log(scope.fdatos_tar_gas);
            } else {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: 'No hay información', type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.borrar_TarGas = function() {
        if (scope.Nivel != 1) {
            Swal.fire({ title: "Error", text: "Usuario no autorizado para realizar la operación, contacte al Administrador del Sistema", type: "error", confirmButtonColor: "#188ae2" });
            return false;

        }
        Swal.fire({
            /**title: 'Borrando',**/
            text: "¿Seguro que desea eliminar la Tarifa de Gas?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Tarifas/borrar_tarifa_gas/CodTarGas/" + scope.fdatos_tar_gas.CodTarGas;
                $http.delete(url).then(function(result) {
                    if (result.data != false) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ text: "La Tarifa de Gas ha sido eliminada de forma correcta", type: "error", confirmButtonColor: "#188ae2" });
                        scope.TVistaTarGas = 1;
                        scope.fdatos_tar_gas = {};
                        scope.cargar_lista_Tarifa_Gas();
                    } else {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: $translate('NO_FOUND'), type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: $translate('UNAUTHORIZED'), type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: $translate('FORBIDDEN'), type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: $translate('INTERNAL_ERROR'), type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                console.log('Cancelando ando...');
            }
        });
    }
    scope.limpiar_TarGas = function() {
        scope.fdatos_tar_gas = {};
    }
    scope.regresar_TarGas = function() {
        if (scope.fdatos_tar_gas.CodTarGas == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea cerrar sin registrar la Tarifa de Gas';
        } else {
            var title = 'Actualizando';
            var text = '¿Seguro que desea cerrar sin actualizar la información de la Tarifa de Gas?';
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
                scope.fdatos_tar_gas = {};
                scope.TVistaTarGas = 1;
                scope.cargar_lista_Tarifa_Gas();
            } else {
                console.log('Cancelando ando...');
            }
        });
    }
    scope.FetchTarGas = function()
    {
        if(scope.filtrar_gas==undefined||scope.filtrar_gas==null||scope.filtrar_gas=='')
        {
                $scope.predicate1 = 'id';
                $scope.reverse1 = true;
                $scope.currentPage1 = 1;
                $scope.order1 = function(predicate1) {
                    $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                    $scope.predicate1 = predicate1;
                };
                scope.T_TarifasGas = scope.T_TarifasGasBack;
                $scope.totalItems1 = scope.T_TarifasGas.length;
                $scope.numPerPage1 = 50;
                $scope.paginate1 = function(value1) {
                    var begin1, end1, index1;
                    begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                    end1 = begin1 + $scope.numPerPage1;
                    index1 = scope.T_TarifasGas.indexOf(value1);
                    return (begin1 <= index1 && index1 < end1);
                };
            scope.ruta_reportes_pdf_tarifas_gas = 0;
            scope.ruta_reportes_excel_tarifas_gas =0;
        }
        else
        {
            if(scope.filtrar_gas.length>0)
            {
                scope.fdatos.filtrar_gas=scope.filtrar_gas;   
                var url = base_urlHome()+"api/Tarifas/getTarGasFilter";
                $http.post(url,scope.fdatos).then(function(result)
                {
                    console.log(result.data);
                    if (result.data != false)
                    {                        
                        $scope.predicate1 = 'id';
                $scope.reverse1 = true;
                $scope.currentPage1 = 1;
                $scope.order1 = function(predicate1) {
                    $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                    $scope.predicate1 = predicate1;
                };
                scope.T_TarifasGas = result.data;
                $scope.totalItems1 = scope.T_TarifasGas.length;
                $scope.numPerPage1 = 50;
                $scope.paginate1 = function(value1) {
                    var begin1, end1, index1;
                    begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                    end1 = begin1 + $scope.numPerPage1;
                    index1 = scope.T_TarifasGas.indexOf(value1);
                    return (begin1 <= index1 && index1 < end1);
                };
                        scope.ruta_reportes_pdf_tarifas_gas = 1 + "/" + scope.filtrar_gas;
                        scope.ruta_reportes_excel_tarifas_gas = 1 + "/" + scope.filtrar_gas;
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No existen Tarifas Gas registradas", type: "error", confirmButtonColor: "#188ae2" });                    
                        scope.T_TarifasGas=[];
                        scope.ruta_reportes_pdf_tarifas_gas = 0;
                        scope.ruta_reportes_excel_tarifas_gas =0;
                    }
                }, function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found"){
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
        }              
    }




    /////////////////////////////////////////////////////////////////////////////////TARIFAS GAS END///////////////////////////////////////////////////////////

}