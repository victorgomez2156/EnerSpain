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
    scope.EstTarEle = true;
    scope.AccTarElec = true;

    scope.TVistaTarGas = 1;
    scope.T_TarifasGas = [];
    scope.T_TarifasGasBack = [];
    scope.ruta_reportes_pdf_tarifas_gas = 0;
    scope.ruta_reportes_excel_tarifas_gas = 0;
    scope.NomTarGas = true;
    scope.MinConAnu = true;
    scope.MaxConAnu = true;
    scope.EstTarGas = true;
    scope.AccTarGas = true;
    scope.topciones = [{ id: 1, nombre: 'Ver' }, { id: 2, nombre: 'Editar' }, { id:3, nombre: 'Activar' }, { id: 4, nombre: 'Bloquear' }];
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
                scope.T_TarifasEle = [];
                scope.T_TarifasEleBack = [];
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
    scope.borrar_TarEle = function() {
            if (scope.Nivel != 1) {
                scope.toast('error','Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.','Error');
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
                            scope.toast('success','Registro eliminado de forma correcta','Exito');
                            scope.TVistaTarEle = 1;
                            scope.cargar_lista_Tarifa_Electrica();
                        } else {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            scope.toast('error','No se pudo eliminar el registro intente nuevamente.','Error');
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
                    console.log('Cancelando ando...');
                }
            });
        }
        /*scope.borrar_row_electrica=function(index,id)
        {
        	if(scope.Nivel!=1)
        	{
        		scope.toast('error','Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.','Error');
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
        					scope.toast('success','Registro eliminado de forma correcta','Exito');
                            scope.T_TarifasEle.splice(index,1);						
        				}
        				else
        				{
        					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        					scope.toast('error','No se ha podido eliminar el registro, intente nuevamente.','Error');                            					
        				}
        			},function(error)
        			{
        				$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );						
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
                    console.log('Cancelando ando...');	                
                }
            });
        }*/
    scope.validar_opcion_TarEle = function(index, opciones_TarEle, dato) {
        console.log(index);
        console.log(opciones_TarEle);
        console.log(dato);
        scope.opciones_TarEle[index] = undefined;
        if (opciones_TarEle == 1) {           
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
            scope.fdatos_tar_elec = dato;
            scope.TVistaTarEle = 2;
            scope.disabled_form_TarEle = undefined;
            if (dato.TipTen == "BAJA") {
                scope.fdatos_tar_elec.TipTen = "0";
            } else {
                scope.fdatos_tar_elec.TipTen = "1";
            }
        }
        if(opciones_TarEle==3)
        {
            if (dato.EstTarEle == 1){
                 scope.toast('error','Está Tárifa ya se encuentra activa.','');
                 return false;
            }
            $("#Actualizando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active"); 
            var url = base_urlHome()+"api/Tarifas/ActBloTar/CodTar/"+dato.CodTarEle+"/TipTar/"+1+"/EstTar/"+1;
            $http.get(url).then(function(result)
            {
                $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
                if(result.data!=false)
                {
                    scope.toast('success','Tárifa Eléctrica Activada Correctamente.','');
                    scope.cargar_lista_Tarifa_Electrica();
                } 
                else
                {
                    scope.toast('error','Error al intentar Activar la Tárifa Eléctrica.','');
                    scope.cargar_lista_Tarifa_Electrica();
                }
            },function(error)
            {
                        $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );                        
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
        if(opciones_TarEle==4)
        {
            if (dato.EstTarEle == 2) {
                 scope.toast('error','Está Tárifa ya se encuentra bloqueada.','');
                 return false;
             }
            $("#Actualizando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active"); 
            var url = base_urlHome()+"api/Tarifas/ActBloTar/CodTar/"+dato.CodTarEle+"/TipTar/"+1+"/EstTar/"+2;
            $http.get(url).then(function(result)
            {
                $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
                if(result.data!=false)
                {
                    scope.toast('success','Tárifa Eléctrica Bloqueada Correctamente.','');
                    scope.cargar_lista_Tarifa_Electrica();
                } 
                else
                {
                    scope.toast('error','Error al intentar Bloquear la Tárifa Eléctrica.','');
                    scope.cargar_lista_Tarifa_Electrica();
                }
            },function(error)
            {
                        $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );                        
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
                        scope.toast('success',response,titulo);
                        scope.buscarXIDTarEle();
                    } else {
                        scope.toast('error','Ha ocurro un error, por favor intente nuevamente','Error');
                    }
                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_tension = function() {
        resultado = true;
        if (scope.fdatos_tar_elec.TipTen == null || scope.fdatos_tar_elec.TipTen == undefined || scope.fdatos_tar_elec.TipTen == '') {
            scope.toast('error','Seleccionar un Tipo de Tensión','Tipo de Tensión');
            return false;
        }
        if (scope.fdatos_tar_elec.CanPerTar == null || scope.fdatos_tar_elec.CanPerTar == undefined || scope.fdatos_tar_elec.CanPerTar == '') {
            scope.toast('error','La Cantidad de Períodos es obligatoria','Cantidad Periodos');            
            return false;
        }
        if (scope.fdatos_tar_elec.MinPotCon == null || scope.fdatos_tar_elec.MinPotCon == undefined || scope.fdatos_tar_elec.MinPotCon == '') {
            scope.toast('error','Introduzca la Potencia Mínima','');
            return false;
        }
        if (scope.fdatos_tar_elec.MaxPotCon == null || scope.fdatos_tar_elec.MaxPotCon == undefined || scope.fdatos_tar_elec.MaxPotCon == '') {
            scope.toast('error','Introduzca la Potencia Máxima','');
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
                scope.toast('error','No hay información.','Error');                
            }
        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                        scope.T_TarifasEle=[];
                        scope.ruta_reportes_pdf_tarifas_electrica = 0;
                        scope.ruta_reportes_excel_tarifas_electrica =0;
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
                scope.T_TarifasGas = [];
                scope.T_TarifasGasBack = [];
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
    scope.validar_opcion_TarGas = function(index, opciones_TarGas, dato) {
        console.log(index);
        console.log(opciones_TarGas);
        console.log(dato);
        scope.opciones_TarGas[index] = undefined;
           
        if (opciones_TarGas == 1) {
           scope.fdatos_tar_gas = dato;
            scope.TVistaTarGas = 2;
            scope.disabled_form_TarGas = 1;

        }
        if (opciones_TarGas == 2) {
            scope.fdatos_tar_gas = dato;
            scope.TVistaTarGas = 2;
            scope.disabled_form_TarGas = undefined;
        }
        if(opciones_TarGas==3)
        {
            if (dato.EstTarGas == 1){
                 scope.toast('error','Está Tárifa ya se encuentra activa.','');
                 return false;
            }
            $("#Actualizando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active"); 
            var url = base_urlHome()+"api/Tarifas/ActBloTar/CodTar/"+dato.CodTarGas+"/TipTar/"+2+"/EstTar/"+1;
            $http.get(url).then(function(result)
            {
                $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
                if(result.data!=false)
                {
                    scope.toast('success','Tárifa Gas Activada Correctamente.','');
                    scope.cargar_lista_Tarifa_Gas();
                } 
                else
                {
                    scope.toast('error','Error al intentar Activar la Tárifa Gas.','');
                    scope.cargar_lista_Tarifa_Gas();
                }
            },function(error)
            {
                        $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );                        
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
        if(opciones_TarGas==4)
        {
            if (dato.EstTarGas == 2) {
                 scope.toast('error','Está Tárifa ya se encuentra bloqueada.','');
                 return false;
             }
            $("#Actualizando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active"); 
            var url = base_urlHome()+"api/Tarifas/ActBloTar/CodTar/"+dato.CodTarGas+"/TipTar/"+2+"/EstTar/"+2;
            $http.get(url).then(function(result)
            {
                $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
                if(result.data!=false)
                {
                    scope.toast('success','Tárifa Gas Bloqueada Correctamente.','');
                    scope.cargar_lista_Tarifa_Gas();
                } 
                else
                {
                    scope.toast('error','Error al intentar Bloquear la Tárifa Gas.','');
                    scope.cargar_lista_Tarifa_Gas();
                }
            },function(error)
            {
                        $("#Actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );                        
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
                        scope.toast('success',titulo2,titulo);
                        scope.buscarXIDTarGas();
                    } else {
                        scope.toast('error','Ha ocurrido un error, por favor intente nuevamente.',titulo); 
                    }
                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_TarGas = function() {
        resultado = true;
        if (scope.fdatos_tar_gas.NomTarGas == null || scope.fdatos_tar_gas.NomTarGas == undefined || scope.fdatos_tar_gas.NomTarGas == '') {
            scope.toast('error','El nombre de la Tarifa es requerido','');
            return false;
        }
        if (scope.fdatos_tar_gas.MinConAnu == null || scope.fdatos_tar_gas.MinConAnu == undefined || scope.fdatos_tar_gas.MinConAnu == '') {
            scope.toast('error','El Consumo Mínimo es requerido','');
            return false;
        }
        if (scope.fdatos_tar_gas.MaxConAnu == null || scope.fdatos_tar_gas.MaxConAnu == undefined || scope.fdatos_tar_gas.MaxConAnu == '') {
            scope.toast('error','El Consumo Máximo es requerido','');
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
                scope.toast('error','No hay información','Error');               
            }
        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.borrar_TarGas = function() {
        if (scope.Nivel != 1) {
            scope.toast('error','Usuario no autorizado para realizar la operación, contacte al Administrador del Sistema','Error');
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
                        scope.toast('success','La Tarifa de Gas ha sido eliminada de forma correcta.','');
                        scope.TVistaTarGas = 1;
                        scope.fdatos_tar_gas = {};
                        scope.cargar_lista_Tarifa_Gas();
                    } else {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        scope.toast('error','Ha ocurrido un error, intente nuevamente','');                        
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
                        scope.T_TarifasGas=[];
                        scope.ruta_reportes_pdf_tarifas_gas = 0;
                        scope.ruta_reportes_excel_tarifas_gas =0;
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
                        scope.ruta_reportes_pdf_tarifas_gas = 0 ;
                        scope.ruta_reportes_excel_tarifas_gas = 0;
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


    /////////////////////////////////////////////////////////////////////////////////TARIFAS GAS END///////////////////////////////////////////////////////////

}