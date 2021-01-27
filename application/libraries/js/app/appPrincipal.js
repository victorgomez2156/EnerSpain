var app = angular.module('appPrincipal', ['checklist-model', 'ngResource', 'ngCookies', 'ui.bootstrap', 'angular.ping', 'ngRoute'])
    .config(function($httpProvider, $routeProvider) {
        $httpProvider.defaults.useXDomain = true;
        $httpProvider.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
        $httpProvider.defaults.headers.common["Access-Control-Allow-Methods"] = "GET, POST, PUT, DELETE, OPTIONS";
        $httpProvider.defaults.headers.common["Access-Control-Max-Age"] = "86400";
        $httpProvider.defaults.headers.common["Access-Control-Allow-Credentials"] = "true";
        $httpProvider.defaults.headers.common["Accept"] = "application/javascript";
        $httpProvider.defaults.headers.common["content-type"] = "application/json";
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $routeProvider
        //Se debe colocar  para cada uno de los controladores que desea para el acceso todos los formularios
        .when('/Home/', { templateUrl: 'application/views/view_Home.php' })
        .when('/Dashboard/', { templateUrl: 'application/views/view_dashboard.php' })

        .when('/Comercializadora/', { templateUrl: 'application/views/view_grib_comercializadora.php' })
        .when('/Datos_Basicos_Comercializadora/', { templateUrl: 'application/views/view_comercializadora.php' })
        .when('/Datos_Basicos_Comercializadora/:ID', { templateUrl: 'application/views/view_comercializadora.php' })
        .when('/Datos_Basicos_Comercializadora/:ID/:INF', { templateUrl: 'application/views/view_comercializadora.php' })

        .when('/Productos/', { templateUrl: 'application/views/view_grib_productos.php' })
        .when('/Add_Productos/', { templateUrl: 'application/views/view_add_productos.php' })
        .when('/Edit_Productos/:ID', { templateUrl: 'application/views/view_add_productos.php' })
        .when('/Ver_Productos/:ID/:INF', { templateUrl: 'application/views/view_add_productos.php' })

        .when('/Anexos/', { templateUrl: 'application/views/view_grib_anexos.php' })
        .when('/Add_Anexos/', { templateUrl: 'application/views/view_add_anexos.php' })
        .when('/Edit_Anexos/:ID', { templateUrl: 'application/views/view_add_anexos.php' })
        .when('/Ver_Anexos/:ID/:INF', { templateUrl: 'application/views/view_add_anexos.php' })
        .when('/Comisiones_Anexos/:CodAnePro/:NumCifCom/:RazSocCom/:DesPro/:DesAnePro', { templateUrl: 'application/views/view_add_comisiones_anexos.php' })

        .when('/Servicios_Adicionales/', { templateUrl: 'application/views/view_grib_servicios_especiales.php' })
        .when('/Add_Servicios_Adicionales/', { templateUrl: 'application/views/view_add_servicios_especiales.php' })
        .when('/Edit_Servicios_Adicionales/:ID', { templateUrl: 'application/views/view_add_servicios_especiales.php' })
        .when('/Ver_Servicios_Adicionales/:ID/:INF', { templateUrl: 'application/views/view_add_servicios_especiales.php' })
        .when('/Comisiones_Servicios_Adicionales/:CodSerEsp/:NumCifCom/:RazSocCom/:DesSerEsp', { templateUrl: 'application/views/view_add_comisiones_servicios_especiales.php' })

        .when('/Clientes/', { templateUrl: 'application/views/view_grib_clientes.php' })
        .when('/Datos_Basicos_Clientes/', { templateUrl: 'application/views/view_datos_basicos_clientes.php' })
        .when('/Edit_Datos_Basicos_Clientes/:ID', { templateUrl: 'application/views/view_datos_basicos_clientes.php' })
        .when('/Edit_Datos_Basicos_Clientes/:ID/:INF', { templateUrl: 'application/views/view_datos_basicos_clientes.php' })
        .when('/Actividades/', { templateUrl: 'application/views/view_grib_actividad.php' })
        .when('/Add_Actividades/', { templateUrl: 'application/views/view_add_actividad.php' })
        .when('/Puntos_Suministros/', { templateUrl: 'application/views/view_grib_punto_suministros.php' })

        .when('/Add_Puntos_Suministros/', { templateUrl: 'application/views/view_add_punto_suministros.php' })
        .when('/Add_Puntos_Suministros/:CodCli', { templateUrl: 'application/views/view_add_punto_suministros.php' })


        .when('/Edit_Punto_Suministros/:ID', { templateUrl: 'application/views/view_add_punto_suministros.php' })
        .when('/Edit_Punto_Suministros/:ID/:INF', { templateUrl: 'application/views/view_add_punto_suministros.php' })
        .when('/Contactos/', { templateUrl: 'application/views/view_grib_contactos.php' })
        .when('/Add_Contactos/', { templateUrl: 'application/views/view_add_contactos.php' })
        .when('/Edit_Contactos/:ID', { templateUrl: 'application/views/view_add_contactos.php' })
        .when('/Edit_Contactos/:ID/:INF', { templateUrl: 'application/views/view_add_contactos.php' })
        .when('/Contacto_Otro_Cliente/:NIFConCli', { templateUrl: 'application/views/view_add_contactos.php' })
        .when('/Cuentas_Bancarias/', { templateUrl: 'application/views/view_grib_cuentas_bancarias.php' })
        .when('/Add_Cuentas_Bancarias/', { templateUrl: 'application/views/view_add_cuentas_bancarias.php' })
        .when('/Edit_Cuenta_Bancaria/:ID', { templateUrl: 'application/views/view_add_cuentas_bancarias.php' })
        .when('/Documentos/', { templateUrl: 'application/views/view_grib_documentos.php' })
        .when('/Add_Documentos/', { templateUrl: 'application/views/view_add_documentos.php' })
        .when('/Edit_Documentos/:ID', { templateUrl: 'application/views/view_add_documentos.php' })
        .when('/Gestionar_Cups/', { templateUrl: 'application/views/view_grib_cups.php' })
        .when('/Add_Cups/', { templateUrl: 'application/views/view_add_cups.php' })
        .when('/Add_Cups/:CodCli/:CodPunSum', { templateUrl: 'application/views/view_add_cups.php' })
        .when('/Edit_Cups/:CodCups/:TipServ', { templateUrl: 'application/views/view_add_cups.php' })
        .when('/Edit_Cups/:CodCups/:TipServ/:INF', { templateUrl: 'application/views/view_add_cups.php' })
        .when('/Consumo_CUPs/:CodCup/:TipServ/:CodPunSum', { templateUrl: 'application/views/view_grib_consumo_cups.php' })
        .when('/Historial_Consumo_Cups/:CodCup/:TipServ', { templateUrl: 'application/views/view_grib_historial_cups.php' })
            
            .when('/Reporte_Cups_Colaboradores', { templateUrl: 'application/views/view_reporte_cups_colaboradores.php' })
            .when('/Rueda', { templateUrl: 'application/views/view_reporte_rueda.php' })
            .when('/Rueda20', { templateUrl: 'application/views/view_reporte_rueda20.php' })
            .when('/Proyeccion_Ingresos', { templateUrl: 'application/views/view_reporte_proyeccion_ingresos.php' })
            .when('/Ingresos_Reales', { templateUrl: 'application/views/view_reporte_ingresos_reales.php' })
            .when('/Ingresos_Vs_Proyectado', { templateUrl: 'application/views/view_reporte_ingreso_vs_proyectado.php' })
            .when('/CUPSConsumos', { templateUrl: 'application/views/view_reporte_CUPSConsumos.php' })

            .when('/Propuesta_Comercial/', { templateUrl: 'application/views/view_grib_propuesta.php' })
            .when('/Add_Propuesta_Comercial/:CodCli/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales.php' })
            .when('/Ver_Propuesta_Comercial/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales.php' })
            .when('/Edit_Propuesta_Comercial/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales.php' })
            .when('/Renovar_Propuesta_Comercial/:CodCli/:CodConCom/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales.php' })
            
            .when('/Add_Propuesta_Comercial_UniCliente_MultiPunto/:CodCli/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_UniCliente.php' })
            .when('/Ver_Propuesta_Comercial_UniCliente/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_UniCliente.php' })
            .when('/Edit_Propuesta_Comercial_UniCliente/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_UniCliente.php' })
            .when('/Renovar_Propuesta_Comercial_UniCliente_MultiPunto/:CodCli/:CodConCom/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_UniCliente.php' })    

            .when('/Add_Propuesta_Comercial_MulCliente_MultiPunto/:CodCli/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_MulCliente.php' })
            .when('/Ver_Propuesta_Comercial_MulCliente/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_MulCliente.php' })
            .when('/Edit_Propuesta_Comercial_MulCliente/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_MulCliente.php' })
            .when('/Renovar_Propuesta_Comercial_MulCliente_MultiPunto/:CodCli/:CodConCom/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_propuestas_comerciales_MulCliente.php' })    


            .when('/Contratos/', { templateUrl: 'application/views/view_grib_contratos.php' })            
            .when('/Add_Contrato/:CodCli/:Tipo', { templateUrl: 'application/views/view_add_contratos.php' })
            .when('/Add_Contrato/:CodCli/:Tipo/:TipProCom', { templateUrl: 'application/views/view_add_contratos.php' })
            .when('/Ver_Contrato/:CodCli/:CodConCom/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_contratos.php' })
            .when('/Edit_Contrato/:CodCli/:CodConCom/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_contratos.php' })
            .when('/Edit_Contrato/:CodCli/:CodConCom/:CodProCom/:Tipo/:TipProCom', { templateUrl: 'application/views/view_add_contratos.php' })

            .when('/Activaciones/', { templateUrl: 'application/views/view_grib_activaciones.php' })

            .when('/Otras_Gestiones/', { templateUrl: 'application/views/view_grib_gestiones.php' })
            .when('/Add_Gestion_Comercial/:CodCli/:Tipo', { templateUrl: 'application/views/view_add_gestion_comercial.php' })
            .when('/Edit_Gestion_Comercial/:CodGesGen/:Tipo', { templateUrl: 'application/views/view_add_gestion_comercial.php' })
            
            .when('/Seguimientos', { templateUrl: 'application/views/view_grib_seguimientos.php' })

            .when('/Renovacion_Masiva', { templateUrl: 'application/views/view_grib_renovaciones_masivas.php' })
            // .when('/Edit_Contrato/:CodCli/:CodConCom/:CodProCom/:Tipo', { templateUrl: 'application/views/view_add_contratos.php' })




        ////////////////////////////PARA EL MODULO DE CONFIGURACIONES GENERALES  START//////////////////////////////////////////////////////////////////////////
        .when('/Distribuidora/', { templateUrl: 'application/views/view_grib_distribuidora.php' })
            .when('/Add_Distribuidora/', { templateUrl: 'application/views/view_add_distribuidora.php' })
            .when('/Edit_Distribuidora/:ID', { templateUrl: 'application/views/view_add_distribuidora.php' })
            .when('/Edit_Distribuidora/:ID/:FORM', { templateUrl: 'application/views/view_add_distribuidora.php' })
            .when('/Tarifas/', { templateUrl: 'application/views/view_grib_tarifas.php' })
            .when('/Colaboradores/', { templateUrl: 'application/views/view_grib_colaboradores.php' })
            .when('/Add_Colaborador/', { templateUrl: 'application/views/view_add_colaborador.php' })
            .when('/Editar_Colaborador/:ID', { templateUrl: 'application/views/view_add_colaborador.php' })
            .when('/Editar_Colaborador/:ID/:INF', { templateUrl: 'application/views/view_add_colaborador.php' })
            .when('/Comercial/', { templateUrl: 'application/views/view_grib_comercial.php' })
            .when('/Agregar_Comercial/', { templateUrl: 'application/views/view_add_comercial.php' })
            .when('/Editar_Comercial/:ID', { templateUrl: 'application/views/view_add_comercial.php' })
            .when('/Editar_Comercial/:ID/:INF', { templateUrl: 'application/views/view_add_comercial.php' })
            .when('/Tipos/', { templateUrl: 'application/views/view_grib_tipos.php' })
            .when('/Motivos_Bloqueos/', { templateUrl: 'application/views/view_grib_motivos_bloqueos.php' })
            ////////////////////////////PARA EL MODULO DE CONFIGURACIONES GENERALES  END/////////////////////////////////////////////////////////////////////////////
            .when('/Usuarios/', { templateUrl: 'application/views/view_grib_usuarios.php' })
            .when('/Agregar_Usuarios/', { templateUrl: 'application/views/view_add_usuarios.php' })
            .when('/Editar_Usuarios/:ID', { templateUrl: 'application/views/view_add_usuarios.php' })
            .when('/Bancos/', { templateUrl: 'application/views/view_grib_bancos.php' })
            .when('/Logs/', { templateUrl: 'application/views/view_grib_logs.php' })
            .otherwise({
                //redirectTo: '/Dashboard'
            });

        /*$translateProvider.translations('sp',{});
        $translateProvider.translations('en', 
        {);	*/
        //$translateProvider.preferredLanguage('en');


    }).run(function run($http, $cookies, netTesting, $rootScope, $location, $route) {

        $rootScope.config = {};
        $rootScope.config.app_url = $location.url();
        $rootScope.config.app_path = $location.path();
        $rootScope.layout = {};
        $rootScope.layout.loading = false;
        //console.log($rootScope.config);	
        //console.log($rootScope.config.app_url);
        //console.log($rootScope.config.app_path); translateProvider
        //console.log($rootScope.layout);
        //console.log($rootScope.layout.loading);
        $rootScope.$on('$routeChangeStart', function() {
            //show loading gif
            $rootScope.layout.loading = true;
        });
        $rootScope.$on('$routeChangeSuccess', function() {
            //hide loading gif
            $rootScope.layout.loading = false;
        });
        $rootScope.$on('$routeChangeError', function() {
            //hide loading gif
            //alert('wtff');
            Swal.fire({
                title: "Error General?",
                text: "No es posible mostrar la información",
                type: "warning",
                confirmButtonColor: "#31ce77",
                confirmButtonText: "Aceptar."
            }).then(function(t) {
                if (t.value == true) {
                    //clearTimeout(idleTime);
                    //idleTime = 300;
                    console.log('Recargando Pagina');

                }
            });
            $rootScope.layout.loading = false;

        });
        //console.log($cookies.get('idioma'));
        /**/

        if (!document.getElementById('ApiKey')) {
            ApiKey = $cookies.get('ApiKey');
            $http.defaults.headers.common["x-api-key"] = ApiKey;
        } else {
            var fecha = new Date();
            var dd = fecha.getDate();
            var mm = fecha.getMonth() + 1;
            var yyyy = fecha.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            var fecha = dd + '/' + mm + '/' + yyyy;
            $cookies.put("id", document.getElementById('IdUsers').value);
            $cookies.put("nivel", document.getElementById('NivelUsers').value);
            $cookies.put("ApiKey", document.getElementById('ApiKey').value);
            $cookies.put("Username", document.getElementById('username').value);
            ApiKey = $cookies.get('ApiKey');
            $http.defaults.headers.common["x-api-key"] = ApiKey;
            muestra_preguntas = $cookies.get('id');
            /*if(muestra_preguntas==1)
    	 	{
    			$("#modal-success").modal("hide");
    		}
    		else
    		{
    			$("#modal-success").modal("show");
    		}*/
        }

    });
/*.service('ServiceCodLoc',function($http)
{
   var url = base_urlHome()+"api/Clientes/get_localidad/";
        $http.get(url)
            .success(function(data) 
        {
		this.data = {message : data}		
		console.log(this.data.message);	
		return this.data;
    	});
    
});*/