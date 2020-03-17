var app = angular.module('appPrincipal', ['checklist-model','ngResource','ngCookies','ui.bootstrap','angular.ping','ngRoute','ngMaterial','pascalprecht.translate'])
.config(function ($httpProvider,$routeProvider,$translateProvider) 
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
		.when('/Tablero/', {
			templateUrl: 'application/views/view_dashboard.php'
		})
		.when('/Comercializadora/', {
		templateUrl: 'application/views/view_grib_comercializadora.php'
		})
		.when('/Marketer/', {
		templateUrl: 'application/views/view_grib_comercializadora.php'
		})		
		.when('/Datos_Basicos_Comercializadora/', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Basic_Data_Commercialist/', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Datos_Basicos_Comercializadora/:ID',{
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Basic_Data_Commercialist/:ID',{
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Datos_Basicos_Comercializadora/:ID/:INF', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Basic_Data_Commercialist/:ID/:INF', {
		templateUrl: 'application/views/view_comercializadora.php'
		})
		.when('/Productos/', 
		{
			templateUrl: 'application/views/view_grib_productos.php'
		})
		.when('/Products/', 
		{
			templateUrl: 'application/views/view_grib_productos.php'
		})
		.when('/Add_Productos/', 
		{
			templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Add_Products/', 
		{
			templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Edit_Productos/:ID',
		{
			templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Edit_Products/:ID',
		{
			templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/Ver_Productos/:ID/:INF', {
			templateUrl: 'application/views/view_add_productos.php'
		})
		.when('/See_Products/:ID/:INF', {
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
		.when('/Comisiones_Anexos/:CodAnePro/:NumCifCom/:RazSocCom/:DesPro/:DesAnePro', {
		templateUrl: 'application/views/view_add_comisiones_anexos.php'
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
		.when('/Comisiones_Servicios_Adicionales/:CodSerEsp/:NumCifCom/:RazSocCom/:DesSerEsp', {
		templateUrl: 'application/views/view_add_comisiones_servicios_especiales.php'
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
		.when('/Contacto_Otro_Cliente/:NIFConCli', {
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
		.otherwise({
			
			redirectTo: '/Dashboard'
		});

		$translateProvider.translations('sp', 
		{	
			'LogOut':'Cerrar Sesión',			
			'LoadView':'Cargando Vista, Por Favor Espere...',
			'DASHBOARD':'Tablero',
			'Designed':'Diseñado Por ',

			'CARGA_DAT':'Cargando Datos, Por Favor Espere...',
			'Add_Columns':'Agregar Columnas',
			'Ex_Reports':'Generar Reportes',
			'FILTRO':'Filtros',
			'Sin_Data':'Actualmente no hay datos disponibles.',
			'RAZ_SOC':'Razón Social',
			'NOM_COM':'Nombre Comecial',
			'DIRECCION':'Dirección',
			'PROVINCIA':'Provincia',
			'LOCALIDAD':'Localidad',
			'TELEFONO':'Teléfono',
			'EMAIL':'Correo Eléctronico',
			'ESTATUS':'Estatus',
			'DESCRIPCION':'Descripción',
			'ACCION':'Ación',
			'PDF':'Exportar en PDF',
			'EXCEL':'Exportar en Excel',
			
			'FILTRO_SEARCH':'Escribe para filtrar...',
			'VER':'Ver',
			'EDITAR':'Editar',
			'ACTIVAR':'Activar',
			'BLOQUEAR':'Bloquear',
			'RELOAD':'Refrescar',
			'TIP_SER':'Tipos de Servicios',
			'SER_GAS':'Servicio Gas',
			'SER_ELE':'Servicio Eléctrico',
			'ESP_SER':'Servicios Adicionales',
			'MOT_BLO_COM_MODAL':'Motivo de Bloqueo',
			'FEC_BLO_COM_MODAL':'Fecha de Bloqueo',
			'OBS_COM_BLO':'Observación',
			'BUTTON_COM_BLO':'Bloquear',
			'BUTTON_COM_REG':'Regresar',
			'tip_fil_modal':'Tipos de Filtro',
			'tip_fil1_modal':'TIPO DE FILTROS',
			'si_modal':'Si',
			'no_modal':'No',
			'app_modal':'Aplicar',
			'lim_modal':'Limpiar',
			'module_data':'Cargando datos del Modulo, Por Favor Espere...',			
			'FECH_INI':'Fecha de Inicio',
			'DIST_SOC':'Distinto a Razón Social',
			'TIP_VIA':'Tipo de Vía',
			'NOM_VIA':'Nombre de la Vía',
			'NUM_VIA':'Número de Vía',
			'BLOQUE':'Bloque',
			'ESCALERA':'Escalera',
			'PLANTA':'Planta',
			'PUERTA':'Puerta',
			'ZON_POST':'Zona Postal',
			'TEL_FIJ':'Teléfono Fijo',
			'CAR_PER_CON':'Cargo Persona Contacto',
			'PAG_WEB':'Página Web',
			'SUM_ELE':'SUMINISTRO ELÉCTRICO',
			'SUM_GAS':'SUMINISTRO GAS',
			'SUM_ADI':'SERVICIOS ADICIONALES',
			'PERS_CONT':'Persona de Contacto',
			'FOT_CONT':'Fotocopia del Contrato',
			'DOWN_CONT':'Descargar Documento',
			'FEC_CONT':'Fecha Contrato',
			'DUR':'Duración',
			'VENCI':'Vencimiento',			
			'RENEW':'Renovación Automatica',
			'REGIS':'Guardar',
			'UPDA':'Actualizar',
			'BACK':'Regresar',
			'CAL_ANO':'La fecha de vencimiento no puede ser inferior a la fecha de inicio.',
			'CAL_ANO_MAY':'El tiempo mínimo del contrato debe ser de 1 año en adelante.',
			'SAVE':'Guardando',
			'TEXT_SAVE':'¿Estás seguro de ingresar este nuevo registro?',			
			'UPDATE':'Actualizando',
			'TEXT_UPDATE':'¿Estás seguro de actualizar este registro?',			
			'ERROR_FILE':"Formato incorrecto, solo se permiten archivos PDF, JPG o PNG.",
			'ERROR_SAVE':"Se ha producido un error durante el proceso. Vuelva a intentarlo.",

			'text_back_save':"¿Estás seguro de volver y no guardar los datos?",
			'text_back_update':"¿Estás seguro de volver y no actualizar los datos?",
			'NO_FOUND_MAR_ID':'No hemos encontrado ningún dato relacionado con este código.',

			'Fec_Ini_Vali':'El Campo Fecha de Inicio es Obligatorio.',
			'format_fec_ini':'El Formato de la fecha de inicio debe ser EJ: DD / MM / AAAA.',
			'format_fec_ini_dia':'Corrija que el formato del día en la fecha de inicio debe ser solo de 2 números. EJ: 01',
			'format_fec_ini_mes':'Corrija que el formato del mes de la fecha de inicio debe ser solo de 2 números. EJ: 01',
			'format_fec_ini_ano':'Corrija el formato del año en la fecha de inicio, ya que debe haber solo 4 números. EJ: 1999',
			'FECH_INI_1':'La fecha de inicio no puede ser mayor que ',
			'FECH_INI_2':" Verifique y intente nuevamente.",

			
			'RAZ_SOC_REQ':"El Campo Razón Social es Obligatorio.",
			'NOM_SOC_REQ':"El Campo Nombre Comercial es Obligatorio.",
			'TIP_VIA_REQ':"Debe Seleccionar un Tipo de Vía de la Lista.",
			'NOM_VIA_REQ':"El Campo Nombre de Vía es Obligatorio.",
			'NUM_VIA_REQ':"El Campo Número de Vía es Obligatorio.",
			'PROVI_REQ':"Debe Seleccionar una Provincia de la Lista.",
			'LOC_REQ':"Debe Seleccionar una Localidad de la Lista.",
			'TEL_REQ':"El Campo Teléfono es Obligatorio",
			'EMAIL_REQ':"El Campo Correo Eléctronico es Obligatorio.",
			'PER_CON_REQ':"El Campo Persona de Contacto es Obligatorio.",
			'CAR_PER_REQ':"El Cargo de La Persona es Obligatorio.",

			'FecComCom':"El formato de fecha del contrato debe ser EJ: DD / MM / AAAA.",
			'FecComComDay':"Corrija que el formato del día en la fecha del contrato debe ser solo de 2 números. EJ: 01",
			'FecComComMonth':"Corrija que el formato del mes de la fecha del contrato debe ser solo de 2 números. EJ: 01",
			'FecComComYear':"Corrija el formato del año en la fecha del contrato, ya que solo debe haber 4 números. EJ: 1999",		
			
			'FecVenConCom':"El formato de fecha de vencimiento debe ser EJ: DD / MM / AAAA.",
			'FecVenConDay':"Corrija que el formato del día en la fecha de vencimiento debe ser solo de 2 números. EJ: 01",		
			'FecVenConMonth':"Corrija que el formato del mes de la fecha de vencimiento debe ser solo de 2 números. EJ: 01",
			'FecVenConYear':"Corrija el formato del año en la fecha de vencimiento, ya que solo debe haber 4 números. EJ: 1999",

			'ACTIVA':'Activa',
			'BLOQUEADA':'Bloqueada',
			
			'DAT_BAS_COM':'Datos_Basicos_Comercializadora',
			'ADD_COM':'Agregar Comercializadora',			
			'MARKETER_NOBD':'No hemos encontrado Comercializadora registradas actualmente.',
			'MARKE_ACTI':'Esta Comercializadora ya está encuentra activa.',
			'ACTI_MARKE':'¿Estás seguro de activar esta Comercializadora?',
			'MARKETER_SAVE':'Registro de Comercializadora',
			'MARKETER_UPDATE':'Actualización de Comercializadora',
			'MARKETER_DATA':'Datos Basicos de la Comercializadora:',
			'CIF_EMPTY':'El Número CIF no puede estar vacío.',
			'TITLE_CIF_REGISTER':'Registrando Comercializadora.',
			'TEXT_CIF_REGISTER':'La Comercializadora ya se encuentra registrada.',
			'MARKE_BLOC':'Ya está Comercializadora se encuentra bloqueada.',
			'MOT_BLO_EMPTY_COME':'No hemos encontrado motivos para bloquear la Comercializadora, por lo que no pueden continuar con esta operación.',
			'list_comer':'Cargando lista de Comercializadoras, Por Favor Espere...',
			'delete_cli':'Borrando Comercializadora, Por Favor Espere...',
			'SAVE_MAR':'Guardando Comercializadora, Por Favor Espere...',			
			'UPDATE_MAR':'Actualizando Comercializadora, Por Favor Espere...',
			'RESPONSE_SAVE_MARKET':'Comercializadora registrada correctamente.',
			'RESPONSE_UPDATE_MARKET':'Comercializadora modificada correctamente.',

			'NO_FOUND1':'No tiene acceso al Controlador de configuración general.',
			'NO_FOUND':'El método que está intentando usar no se puede localizar.',
			'UNAUTHORIZED':'Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.',
			'FORBIDDEN':'Está intentando utilizar una APIKEY no válida.',
			'INTERNAL_ERROR':'Actualmente estamos experimentando fallas en el servidor, intente nuevamente más tarde.',		
			
			'FEC_BLOC':'El campo de fecha de bloqueo no puede estar vacío.',
			'MESSA_BLOC':'El formato de fecha de bloqueo debe ser EJ: DD / MM / AAAA',
			'MESSA_BLOC1':"Corrija que el formato del día en la fecha de bloqueo debe ser solo de 2 números. EJ: 01",
			'MESSA_BLOC2':"Corrija que el formato del mes de la fecha de bloqueo debe ser solo de 2 números. EJ: 01",
			'MESSA_BLOC3':"Corrija el formato del año en la fecha de bloqueo, ya que solo debe haber 4 números. EX: 1999",		

			'MESSA_BLOC4':"La fecha de bloqueo no puede ser mayor que ",
			'MESSA_BLOC5':" Verifique He intente nuevamente.",
			'MESSA_BLOC6':"¿Estás seguro de bloquear esta Comercializadora?",
			'MESSA_BLOC7':"Bloquear",
			'MESSA_BLOC8':"Activando",
			'MESSA_BLOC9':"La Comercializadora ha sido activada correctamente.",
			'MESSA_BLOC10':"Bloqueando",
			'MESSA_BLOC11':'La Comercializadora ha sido bloqueada correctamente.',
			'MESSA_BLOC12':"No hemos podido actualizar el estado de la Comercializadora.",
			'BLO_COM_MODAL':' Bloqueando Comercializadora',
			'RAZ_COM_MODAL':'Razón Social Comercializadora',
	
			'con_cif_modal':'Ingrese Número de CIF:',
			'cif_con_modal':'Número de CIF',
			'button_con_modal':'Consultar',	
			
			'validate_cif':'Verificando Número de CIF, Por Favor Espere...',

			///// side menu start /////
			'MARKETER':'Comercializadora',
			'DAT_BAS':'Datos Basicos',
			'PRODUCTS':'Productos',
			'ANNEXES':'Anexos',
			'SER_ESP':'Ser. Adicionales',

			'CUSTOMERS':'Clientes',			
			'Exercise':'Actividades',
			'Supplies_Dir':'Dir. Suministros',
			'Contacts':'Contactos',
			'Bank_Accounts':'Cuentas Bancarias',
			'Documents':'Documentos',
			'Manage_CUPs':'Gestionar CUPs',

			'Reports':'Reportes',
			'Collaborators':'Colaboradores',

			'Configurations':'Configuraciones',			
			'Distributor':'Distribudora',
			'Rates':'Tarifas',
			'Commercial':'Comercial',
			'Types':'Tipos',
			'Reasons':'Motivos',
			///// side menu end /////

			'TITLE_CLOSE_SESSION':'Cerrar Sesión',
			'Users':'Estimado Usuario: ',
			'UsersConti':' Desea Cerrar su Sesión',
				
		});
		
		$translateProvider.translations('en', 
		{
			'LogOut':'Sign Off',			
			'LoadView':'Loading View, Please Wait...',
			'DASHBOARD':'Dashboard',
			'Designed':'Designed By ',

			'CARGA_DAT':'Loading Data, Please Wait...',
			'Add_Columns':'Add Columns',
			'Ex_Reports':'Generate Reports',
			'FILTRO':'Filters',
			'Sin_Data':'Currently no data available.',
			'RAZ_SOC':'Business Name',
			'NOM_COM':'Tradename',
			'DIRECCION':'Address',
			'PROVINCIA':'Province',
			'LOCALIDAD':'Location',
			'TELEFONO':'Phone',
			'EMAIL':'Email',
			'ESTATUS':'Status',
			'DESCRIPCION':'Description',
			'ACCION':'Action',
			'PDF':'Export in PDF',
			'EXCEL':'Export in Excel',
			
			'FILTRO_SEARCH':'Write to Filter...',
			'VER':'See',
			'EDITAR':'Edit',
			'ACTIVAR':'Activate',
			'BLOQUEAR':'To Block',
			'RELOAD':'Reload',
			'TIP_SER':'Type of Services',
			'SER_GAS':'Gas Service',
			'SER_ELE':'Electric Service',
			'ESP_SER':'Special Service',
			'MOT_BLO_COM_MODAL':'Reason for Blocking',
			'FEC_BLO_COM_MODAL':'Block Date',
			'OBS_COM_BLO':'Observation',
			'BUTTON_COM_BLO':'Block',
			'BUTTON_COM_REG':'Return',
			'tip_fil_modal':'Filter Types',
			'tip_fil1_modal':'FILTER TYPE',
			'si_modal':'Yes',
			'no_modal':'Don´t',
			'app_modal':'Apply',
			'lim_modal':'Clean',
			'module_data':'Loading Module Data, Please Wait...',			
			'FECH_INI':'Start date',
			'DIST_SOC':'Other than Company Name',
			'TIP_VIA':'Type of road',
			'NOM_VIA':'Name of the road',
			'NUM_VIA':'Road number',
			'BLOQUE':'Block',
			'ESCALERA':'Stairs',
			'PLANTA':'Plant',
			'PUERTA':'Door',
			'ZON_POST':'Postal Code',
			'TEL_FIJ':'Landline',
			'CAR_PER_CON':'Position Person Contact',
			'PAG_WEB':'Web page',
			'SUM_ELE':'ELECTRICAL SUPPLY',
			'SUM_GAS':'GAS SUPPLY',
			'SUM_ADI':'ADDITIONAL SERVICES',
			'PERS_CONT':'Contact Person',
			'FOT_CONT':'Photocopy of the Contract',
			'DOWN_CONT':'Download Document',
			'FEC_CONT':'Contract Date',
			'DUR':'Duration',
			'VENCI':'Expiration',			
			'RENEW':'Automatic renewal',
			'REGIS':'Save',
			'UPDA':'Update',
			'BACK':'Return',
			'CAL_ANO':'The expiration date cannot be less than the start date.',
			'CAL_ANO_MAY':'The Minimum Time of the contract must be from 1 year onwards.',
			'SAVE':'Saving',
			'TEXT_SAVE':'Are you sure to enter this new record?',			
			'UPDATE':'Updating',
			'TEXT_UPDATE':'Are you sure to update this record?',			
			'ERROR_FILE':"Wrong format only PDF, JPG or PNG files are allowed.",
			'ERROR_SAVE':"An error has occurred during the process please try again.",

			'text_back_save':"Are you sure to go back and not save the data?",
			'text_back_update':"Are you sure to go back and not update the data?",
			'NO_FOUND_MAR_ID':'We have not found any data related to this code.',

			'Fec_Ini_Vali':'The Start Date Field is Required.',
			'format_fec_ini':'The Start Date Format must be EJ: DD / MM / YYYY.',
			'format_fec_ini_dia':'Please Correct the Format of the day on the Start Date should be 2 numbers only. EJ: 01',
			'format_fec_ini_mes':'Please Correct the Format of the month of the Start Date should be 2 numbers only. EJ: 01',
			'format_fec_ini_ano':'Please Correct the Format of the year on the Start Date Since there must be 4 numbers only. EJ: 1999',
			'FECH_INI_1':'The Start Date cannot be greater than ',
			'FECH_INI_2':" Please verify I have tried again.",

			'RAZ_SOC_REQ':"The Social Reason Field is Required.",
			'NOM_SOC_REQ':"The Commercial Name Field is Required.",
			'TIP_VIA_REQ':"You must Select a Type of Road from the list.",
			'NOM_VIA_REQ':"The Road Name Field is Required.",
			'NUM_VIA_REQ':"The Road Number Field is Required.",
			'PROVI_REQ':"You must Select a Province from the list.",
			'LOC_REQ':"You must Select a Town from the list.",
			'TEL_REQ':"The Telephone Field is Required.",
			'EMAIL_REQ':"The Email Field is Required.",
			'PER_CON_REQ':"The Contact Person Field is Required.",
			'CAR_PER_REQ':"The Person Position Field is Required.",
			
			'FecComCom':"The Contract Date Format must be EJ: DD / MM / YYYY.",
			'FecComComDay':"Please Correct the Format of the day on the Contract Date should be 2 numbers only. EJ: 01",
			'FecComComMonth':"Please Correct the Format of the month of the Contract Date should be 2 numbers only. EJ: 01",
			'FecComComYear':"Please Correct the Format of the year on the Contract Date as there must be 4 numbers only. EJ: 1999",		
			
			'FecVenConCom':"The Expiration Date Format must be EJ: DD / MM / YYYY.",
			'FecVenConDay':"Please Correct the Format of the day on the Expiration Date should be 2 numbers only. EJ: 01",		
			'FecVenConMonth':"Please Correct the Format of the month of the Expiration Date should be 2 numbers only. EJ: 01",
			'FecVenConYear':"Please Correct the Format of the year on the Expiration Date as there must be 4 numbers only. EJ: 1999",
		
			'ACTIVA':'Active',
			'BLOQUEADA':'Blocked Up',
			
			'DAT_BAS_COM':'Basic_Data_Commercialist',
			'ADD_COM':'Add Marketer',			
			'MARKETER_NOBD':'We Have Not Found Currently Registered Marketers.',
			'MARKE_ACTI':'This Marketers is Already Active.',
			'ACTI_MARKE':'¿Are You Sure To Activate This Marketer?',
			'MARKETER_SAVE':'Marketer Registration',
			'MARKETER_UPDATE':'Marketer Data Update',
			'MARKETER_DATA':'Marketing Company Basic Data:',
			'CIF_EMPTY':'The CIF Number Cannot Be Empty.',
			'TITLE_CIF_REGISTER':'Registered Marketer.',
			'TEXT_CIF_REGISTER':'The Marketers is Already Registered.',
			'MARKE_BLOC':'¿This Marketer Is Already Blocked?',
			'MOT_BLO_EMPTY_COME':'We have not found reasons to block the trading companies, so they cannot continue with this operation.',
			'list_comer':'Loading list of Marketers, Please Wait...',
			'delete_cli':'Deleting Marketer, Please Wait...',
			'SAVE_MAR':'Saving Marketer, Please Wait...',			
			'UPDATE_MAR':'Updating Marketer, Please Wait ...',
			'RESPONSE_SAVE_MARKET':'Successfully registered marketer',
			'RESPONSE_UPDATE_MARKET':'Successfully modified marketer',

			'NO_FOUND1':'You do not have access to the General Settings Controller.',
			'NO_FOUND':'The method you are trying to use cannot be located.',
			'UNAUTHORIZED':'Excuse me, the current user does not have permissions to enter this module.',
			'FORBIDDEN':'You are trying to use an invalid APIKEY.',
			'INTERNAL_ERROR':'We are currently experiencing server failures, please try again later.',

			'FEC_BLOC':'The Block Date Field cannot be empty.',
			'MESSA_BLOC':'The Block Date Format must be EJ: ',
			'MESSA_BLOC1':"Please Correct the Format of the day on the Block Date should be 2 numbers only. EX: 01",
			'MESSA_BLOC2':"Please Correct the Format of the month of the Block Date must be 2 numbers only. EX: 01",
			'MESSA_BLOC3':"Please Correct the Format of the year on the Block Date as there must be 4 numbers only. EX: 1999",
			
			'MESSA_BLOC4':"The Block Date cannot be greater than ",
			'MESSA_BLOC5':" Please verify I have tried again.",
			'MESSA_BLOC6':"¿Are You Sure to Block This Marketers?",
			'MESSA_BLOC7':"To Block",
			'MESSA_BLOC8':"Activating",
			'MESSA_BLOC9':"The Marketer has been successfully activated.",
			'MESSA_BLOC10':"Blocking",
			'MESSA_BLOC11':'The Marketer has been successfully blocked.',
			'MESSA_BLOC12':"We have not been able to update the status of the Marketers.",
			'BLO_COM_MODAL':' Marketing Blocker',
			'RAZ_COM_MODAL':'Trading Company Name',
		
			'con_cif_modal':'Enter CIF Number:',
			'cif_con_modal':'CIF number',
			'button_con_modal':'Check',
		
			'validate_cif':'Checking CIF Number, Please Wait...',

			///// side menu start /////
			'MARKETER':'Marketer',
			'DAT_BAS':'Basic Data',
			'PRODUCTS':'Products',
			'ANNEXES':'Annexes',
			'SER_ESP':'Be. Additional',

			'CUSTOMERS':'Customers',			
			'Exercise':'Exercise',
			'Supplies_Dir':'Supplies Dir',
			'Contacts':'Contacts',
			'Bank_Accounts':'Bank Accounts',
			'Documents':'Documents',
			'Manage_CUPs':'Manage CUPs',

			'Reports':'Reports',
			'Collaborators':'Collaborators',

			'Configurations':'Configurations',			
			'Distributor':'Distributor',
			'Rates':'Rates',
			'Commercial':'Commercial',
			'Types':'Types',
			'Reasons':'Reasons',
			///// side menu end /////

			'TITLE_CLOSE_SESSION':'Sign Off',
			'Users':'Dear user: ',
			'UsersConti':' You want to log out',

			////// PARA PRODUCTOS START////////

			'TITLE_PRODUCTS':'Add Products',
			'RUT_PRODUCTS':'Add_Products',
			'BLOC_PRODUC':'Product Blocking',
			'Ver_Productos':'See_Products',
			'Edit_Productos':'Edit_Products',
			'NO_FOUND_PRODUCTS':'We have not found Registered Products.',
			'List_Produc':'Loading Product List, Please Wait...',
			'BLO_PRODUCTS':'Are You Sure You Can Block This Product?',
			'TEXT_PRODUCTS_ACT':'The Product has been successfully activated.',
			'TEXT_PRODUCTS_BLO':'The Product has been successfully blocked.',
			'PRODUCT_ACTIVE':'This Product is already active.',
			'PRODUCT_ACTIVE_TEXT':'Are you sure to activate this product?',
			'PRODUCT_BLOCK_TEXT':'This Product is already blocked.',
			'TEXT_SAVE_PRODUCTS':'Product successfully registered.',
			'TEXT_UPDATE_PRODUCTS':'Product successfully modified.',


			'ACTIVO':'Active',
			'BLOQUEADO':'Locked',


			////// PARA PRODUCTOS END////////



		});		
		$translateProvider.preferredLanguage('sp');

		
}).run(function run( $http, $cookies , netTesting,$rootScope,$location,$route,$translate)
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
	//console.log($cookies.get('idioma'));
    /**/
    
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
		$cookies.put("Username", document.getElementById('username').value);
		$cookies.put("idioma", document.getElementById('idioma').value);					
		ApiKey = $cookies.get('ApiKey');
		$http.defaults.headers.common["x-api-key"] = ApiKey;
		muestra_preguntas=$cookies.get('id');
		if($cookies.get('idioma')==undefined)
	    {
	    	console.log($cookies.get('idioma'));
	    	location.href="Login/desconectar";
	    }
	    else
	    {
	    	$translate.uses($cookies.get('idioma'));
	    	console.log($cookies.get('idioma'));
	    }
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
