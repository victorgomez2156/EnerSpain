var app = angular.module('appPrincipal', ['checklist-model','ngResource','ngCookies','ui.bootstrap','angular.ping','ngRoute','ngMaterial'])
.config(function ($httpProvider,$routeProvider) 
{
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
		.when('/Dashboard/', {
			templateUrl: 'application/views/view_dashboard.php'
		})
		
		.when('/Comercializadora/', {
		templateUrl: 'application/views/view_grib_comercializadora.php'
		})
		.when('/Datos_Basicos_Comercializadora/', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Datos_Basicos_Comercializadora/:ID', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Datos_Basicos_Comercializadora/:ID/:INF', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Productos/', {
		templateUrl: 'application/views/view_grib_productos.php'
		})
		.when('/Add_Productos/', {
		templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Edit_Productos/:ID', {
		templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Ver_Productos/:ID/:INF', {
		templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Anexos/', {
		templateUrl: 'application/views/view_grib_anexos.php'
		})
		.when('/Add_Anexos/', {
		templateUrl: 'application/views/view_add_anexos.php'
		})
		.when('/Edit_Anexos/:ID', {
		templateUrl: 'application/views/view_add_anexos.php'
		})
		.when('/Ver_Anexos/:ID/:INF', {
		templateUrl: 'application/views/view_add_anexos.php'
		})
		.when('/Servicios_Adicionales/', {
		templateUrl: 'application/views/view_grib_servicios_especiales.php'
		})
		.when('/Add_Servicios_Adicionales/', {
		templateUrl: 'application/views/view_add_servicios_especiales.php'
		})
		.when('/Edit_Servicios_Adicionales/:ID', {
		templateUrl: 'application/views/view_add_servicios_especiales.php'
		})
		.when('/Ver_Servicios_Adicionales/:ID/:INF', {
		templateUrl: 'application/views/view_add_servicios_especiales.php'
		})

		.when('/Datos_Basicos_Clientes/', {
		templateUrl: 'application/views/view_datos_basicos_clientes.php'
		})		
		.when('/Edit_Datos_Basicos_Clientes/:ID', {
		templateUrl: 'application/views/view_datos_basicos_clientes.php'
		})
		.when('/Edit_Datos_Basicos_Clientes/:ID/:INF', {
		templateUrl: 'application/views/view_datos_basicos_clientes.php'
		})
		.when('/Actividades/', {
		templateUrl: 'application/views/view_grib_actividad.php'
		})	
		.when('/Add_Actividades/', {
		templateUrl: 'application/views/view_add_actividad.php'
		})	
		.when('/Puntos_Suministros/', {
		templateUrl: 'application/views/view_grib_punto_suministros.php'
		})
		.when('/Add_Puntos_Suministros/', {
		templateUrl: 'application/views/view_add_punto_suministros.php'
		})
		.when('/Edit_Punto_Suministros/:ID', {
		templateUrl: 'application/views/view_add_punto_suministros.php'
		})
		.when('/Edit_Punto_Suministros/:ID/:INF', {
		templateUrl: 'application/views/view_add_punto_suministros.php'
		})
		.when('/Contactos/', {
		templateUrl: 'application/views/view_grib_contactos.php'
		})
		.when('/Add_Contactos/', {
		templateUrl: 'application/views/view_add_contactos.php'
		})
		.when('/Edit_Contactos/:ID', {
		templateUrl: 'application/views/view_add_contactos.php'
		})
		.when('/Edit_Contactos/:ID/:INF', {
		templateUrl: 'application/views/view_add_contactos.php'
		})
		.when('/Cuentas_Bancarias/', {
		templateUrl: 'application/views/view_grib_cuentas_bancarias.php'
		})
		.when('/Add_Cuentas_Bancarias/', {
		templateUrl: 'application/views/view_add_cuentas_bancarias.php'
		})
		.when('/Edit_Cuenta_Bancaria/:ID', {
		templateUrl: 'application/views/view_add_cuentas_bancarias.php'
		})
		.when('/Documentos/', {
		templateUrl: 'application/views/view_grib_documentos.php'
		})
		.when('/Add_Documentos/', {
		templateUrl: 'application/views/view_add_documentos.php'
		})
		.when('/Edit_Documentos/:ID', {
		templateUrl: 'application/views/view_add_documentos.php'
		})

		.when('/Gestionar_Cups/', {
		templateUrl: 'application/views/view_grib_cups.php'
		})
		.when('/Add_Cups/', {
		templateUrl: 'application/views/view_add_cups.php'
		})
		.when('/Edit_Cups/:CodCups/:TipServ', 
		{
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_cups.php'
		})
		.when('/Edit_Cups/:CodCups/:TipServ/:INF', 
		{
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_cups.php'
		})		
		.when('/Consumo_CUPs/:CodCup/:TipServ/:CodPunSum', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_grib_consumo_cups.php'
		})
		.when('/Historial_Consumo_Cups/:CodCup/:TipServ', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_grib_historial_cups.php'
		})	
		.when('/Reporte_Cups_Colaboradores', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_reporte_cups_colaboradores.php'
		})	

		/*.when('/Comercializadora/', {
			templateUrl: 'application/views/view_grib_comercializadora.php'
		})
		.when('/Edit_Comercializadora/:ID', {
			templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Edit_Comercializadora/:ID/:INF', {
			templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Add_Comercializadora/', {
			templateUrl: 'application/views/view_comercializadora.php'
		})
		*/




















		.when('/Clientes/', 
		{		
			templateUrl: 'application/views/view_grib_clientes.php'			
		})		
		.when('/Creacion_Clientes/', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_clientes.php'
		})
		.when('/Editar_Clientes/:ID', {
			templateUrl: 'application/views/view_add_clientes.php'
		})		
		.when('/Editar_Clientes/:ID/:MET', {
			templateUrl: 'application/views/view_add_clientes.php'
		})
		////////////////////////////PARA EL MODULO DE CONFIGURACIONES GENERALES  START//////////////////////////////////////////////////////////////////////////
		.when('/Distribuidora/', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_grib_distribuidora.php'
		})
		.when('/Add_Distribuidora/', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_distribuidora.php'
		})
		.when('/Edit_Distribuidora/:ID', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_distribuidora.php'
		})
		.when('/Edit_Distribuidora/:ID/:FORM', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_distribuidora.php'
		})
		.when('/Tarifas/', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_grib_tarifas.php'
		})
		.when('/Colaboradores/', 
		{		
			templateUrl: 'application/views/view_grib_colaboradores.php'			
		})		
		.when('/Add_Colaborador/', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_add_colaborador.php'
		})
		.when('/Editar_Colaborador/:ID', {
			templateUrl: 'application/views/view_add_colaborador.php'
		})
		.when('/Editar_Colaborador/:ID/:INF', {
			templateUrl: 'application/views/view_add_colaborador.php'
		})
		.when('/Comercial/', {
			templateUrl: 'application/views/view_grib_comercial.php'
		})
		.when('/Agregar_Comercial/', {
			templateUrl: 'application/views/view_add_comercial.php'
		})
		.when('/Editar_Comercial/:ID', {
			templateUrl: 'application/views/view_add_comercial.php'
		})
		.when('/Editar_Comercial/:ID/:INF', {
			templateUrl: 'application/views/view_add_comercial.php'
		})
		.when('/Tipos/', {
			templateUrl: 'application/views/view_grib_tipos.php'
		})
		.when('/Motivos_Bloqueos/', {
			mytext:"This is angular",
			templateUrl: 'application/views/view_grib_motivos_bloqueos.php'
		})
		



		////////////////////////////PARA EL MODULO DE CONFIGURACIONES GENERALES  END/////////////////////////////////////////////////////////////////////////////
		.when('/Usuarios/', {
			templateUrl: 'application/views/view_grib_usuarios.php'
		})
		.when('/Agregar_Usuarios/', 
		{
			templateUrl: 'application/views/view_add_usuarios.php'
		})
		.when('/Editar_Usuarios/:ID', 
		{
			templateUrl: 'application/views/view_add_usuarios.php'
		})			
		
		.when('/Bancos/', {
			templateUrl: 'application/views/view_grib_bancos.php'
		})
		/*
		.when('/Provincia/', {
			templateUrl: 'application/views/view_grib_provincias.php'
		})
		.when('/Agregar_Provincia/', {
			templateUrl: 'application/views/view_add_provincias.php'
		})
		.when('/Editar_Provincia/:ID', {
			templateUrl: 'application/views/view_add_provincias.php'
		})	
		.when('/Localidad/', {
			templateUrl: 'application/views/view_grib_localidad.php'
		})
		.when('/Agregar_Localidad/', {
			templateUrl: 'application/views/view_add_localidad.php'
		})
		.when('/Editar_Localidad/:ID', {
			templateUrl: 'application/views/view_add_localidad.php'
		})			
		.when('/Tipo_Clientes/', {
			templateUrl: 'application/views/view_grib_tipo_clientes.php'
		})
		.when('/Agregar_Tipo_Clientes/', {
			templateUrl: 'application/views/view_add_tipo_clientes.php'
		})
		.when('/Editar_Tipo_Clientes/:ID', {
			templateUrl: 'application/views/view_add_tipo_clientes.php'
		})
		.when('/Configuracion_Sistema/', {
			templateUrl: 'application/views/view_configuraciones_sistema.php'
		})
		.when('/Bancos/', {
			templateUrl: 'application/views/view_grib_bancos.php'
		})	
		.when('/Agregar_Banco/', {
			templateUrl: 'application/views/view_add_bancos.php'
		})
		.when('/Editar_Banco/:ID', {
			templateUrl: 'application/views/view_add_bancos.php'
		})
		.when('/Tipo_Vias/', 
		{		
			templateUrl: 'application/views/view_grib_tipos_vias.php'			
		})		
		.when('/Add_Tipo_Vias/', {			
			templateUrl: 'application/views/view_add_tipos_vias.php'
		})
		.when('/Edit_Tipo_Vias/:ID', {
			templateUrl: 'application/views/view_add_tipos_vias.php'
		})
		.when('/Motivos_Bloqueos/', 
		{		
			templateUrl: 'application/views/view_grib_motivos_bloqueos.php'			
		})		
		.when('/Add_Motivos_Bloqueos/', {			
			templateUrl: 'application/views/view_add_motivos_bloqueos.php'
		})
		.when('/Edit_Motivos_Bloqueos/:ID', {
			templateUrl: 'application/views/view_add_motivos_bloqueos.php'
		})
		.when('/Motivos_Bloqueos_Actividades/', 
		{		
			templateUrl: 'application/views/view_grib_motivos_bloqueos_actividades.php'			
		})		
		.when('/Add_Motivos_Bloqueos_Actividades/', {			
			templateUrl: 'application/views/view_add_motivos_bloqueos_actividades.php'
		})
		.when('/Edit_Motivos_Bloqueos_Actividades/:ID', {
			templateUrl: 'application/views/view_add_motivos_bloqueos_actividades.php'
		})
		.when('/Sector_Cliente/', 
		{		
			templateUrl: 'application/views/view_grib_sector_cliente.php'			
		})		
		.when('/Add_Sector_Cliente/', {			
			templateUrl: 'application/views/view_add_sector_cliente.php'
		})
		.when('/Edit_Sector_Cliente/:ID', {
			templateUrl: 'application/views/view_add_sector_cliente.php'
		})
		.when('/Tipo_Inmueble/', 
		{		
			templateUrl: 'application/views/view_grib_tipo_inmueble.php'			
		})		
		.when('/Add_Tipo_Inmueble/', {			
			templateUrl: 'application/views/view_add_tipo_inmueble.php'
		})
		.when('/Edit_Tipo_Inmueble/:ID', {
			templateUrl: 'application/views/view_add_tipo_inmueble.php'
		})


		.when('/Expediente_General/', {
			templateUrl: 'application/views/view_contruccion.php'
		})	
		.when('/Discriminacion_Horaria/', {
			templateUrl: 'application/views/view_contruccion.php'
		})
		.when('/Impuestos_Especiales/', {
			templateUrl: 'application/views/view_contruccion.php'
		})
		.when('/Optimizacion_Potencia/', {
			templateUrl: 'application/views/view_contruccion.php'
		})
		.when('/Contrato_Energia/', {
			templateUrl: 'application/views/view_contruccion.php'
		})
		.when('/Denuncia_Contrato/', {
			templateUrl: 'application/views/view_contruccion.php'
		})
		.when('/Registro_Suministros/', {
			templateUrl: 'application/views/view_contruccion.php'
		})
		
		.when('/Motivos_Bloqueos_Puntos_Suministros/', {
			templateUrl: 'application/views/view_grib_motivos_bloqueo_puntos_suministros.php'
		})
		.when('/Edit_Motivos_Bloqueos_Puntos_Suministros/:ID', {
			templateUrl: 'application/views/view_motivos_bloqueo_puntos_suministros.php'
		})
		.when('/Add_Motivos_Bloqueos_Puntos_Suministros/', {
			templateUrl: 'application/views/view_motivos_bloqueo_puntos_suministros.php'
		})
		.when('/Motivos_Bloqueos_Comercializadora/', {
			templateUrl: 'application/views/view_grib_motivos_bloqueo_comercializadoras.php'
		})
		.when('/Edit_Motivos_Bloqueos_Comercializadora/:ID', {
			templateUrl: 'application/views/view_motivos_bloqueo_comercializadoras.php'
		})
		.when('/Add_Motivos_Bloqueos_Comercializadora/', {
			templateUrl: 'application/views/view_motivos_bloqueo_comercializadoras.php' 
		})

		.when('/Tarifa_Electrica/', {
			templateUrl: 'application/views/view_grib_tarifa_electrica.php'
		})
		.when('/Edit_Tarifa_Electrica/:ID', {
			templateUrl: 'application/views/view_add_tarifa_electrica.php'
		})
		.when('/Add_Tarifa_Electrica/', {
			templateUrl: 'application/views/view_add_tarifa_electrica.php' 
		})

		.when('/Tarifa_Gas/', {
			templateUrl: 'application/views/view_grib_tarifa_gas.php'
		})
		.when('/Edit_Tarifa_Gas/:ID', {
			templateUrl: 'application/views/view_add_tarifa_gas.php'
		})
		.when('/Add_Tarifa_Gas/', {
			templateUrl: 'application/views/view_add_tarifa_gas.php' 
		})

		.when('/Tipo_Comision/', {
			templateUrl: 'application/views/view_grib_tipo_comision.php'
		})
		.when('/Edit_Tipo_Comision/:ID', {
			templateUrl: 'application/views/view_add_tipo_comision.php'
		})
		.when('/Add_Tipo_Comision/', {
			templateUrl: 'application/views/view_add_tipo_comision.php' 
		})
		.when('/Tipo_Contacto/', {
			templateUrl: 'application/views/view_grib_tipo_contacto.php'
		})
		.when('/Editar_Tipo_Contacto/:ID', {
			templateUrl: 'application/views/view_add_tipo_contacto.php'
		})
		.when('/Agregar_Tipo_Contacto/', {
			templateUrl: 'application/views/view_add_tipo_contacto.php' 
		})

		.when('/Motivos_Bloqueos_Contacto/', {
			templateUrl: 'application/views/view_grib_motivos_bloqueos_contactos.php'
		})
		.when('/Edit_Motivos_Bloqueos_Contactos/:ID', {
			templateUrl: 'application/views/view_add_motivos_bloqueos_contactos.php'
		})
		.when('/Add_Motivos_Bloqueos_Contactos/', {
			templateUrl: 'application/views/view_add_motivos_bloqueos_contactos.php' 
		})*/
		




		.otherwise({
			
			//redirectTo: '/Dashboard'
		});

		
}).run(function run( $http, $cookies , netTesting,$rootScope,$location,$route)
{
	
	$rootScope.config = {};
    $rootScope.config.app_url = $location.url();
    $rootScope.config.app_path = $location.path();
    $rootScope.layout = {};
    $rootScope.layout.loading = false;
    //console.log($rootScope.config);	
    //console.log($rootScope.config.app_url);
    //console.log($rootScope.config.app_path);
    //console.log($rootScope.layout);
    //console.log($rootScope.layout.loading);
    $rootScope.$on('$routeChangeStart', function () 
    {
    	//show loading gif
    	$rootScope.layout.loading = true;
    });
    $rootScope.$on('$routeChangeSuccess', function () 
    {
        //hide loading gif
        $rootScope.layout.loading = false;
    });
    $rootScope.$on('$routeChangeError', function () 
    {
        //hide loading gif
        //alert('wtff');
         Swal.fire({title:"Error al Cargar Vista?",
         	text:"No hemos podido cargar la vista un error a ocurrido intente nuevamente.",
         	type:"warning",confirmButtonColor:"#31ce77",confirmButtonText:"Aceptar."}).then(function(t)
      {
        if(t.value==true)
        {                
          //clearTimeout(idleTime);
          //idleTime = 300;
          console.log('Recargando Pagina');

        }
      });
        $rootScope.layout.loading = false;

    });


	if (!document.getElementById('ApiKey'))
	{
		ApiKey = $cookies.get('ApiKey');
		$http.defaults.headers.common["x-api-key"] = ApiKey;
	} 
	else
	{
		var fecha = new Date();
		var dd = fecha.getDate();
		var mm = fecha.getMonth()+1; 
		var yyyy = fecha.getFullYear();

		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 
		var fecha = dd+'/'+mm+'/'+yyyy;	
		$cookies.put("id", document.getElementById('IdUsers').value);
		$cookies.put("nivel", document.getElementById('NivelUsers').value);
		$cookies.put("ApiKey", document.getElementById('ApiKey').value);					
		ApiKey = $cookies.get('ApiKey');
		$http.defaults.headers.common["x-api-key"] = ApiKey;
		muestra_preguntas=$cookies.get('id');
		/*if(muestra_preguntas==1)
	 	{
			$("#modal-success").modal("hide");
		}
		else
		{
			$("#modal-success").modal("show");
		}*/
	}
	
});/*.service('ServiceCodLoc',function($http)
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
