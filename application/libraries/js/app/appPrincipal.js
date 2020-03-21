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
		.when('/Dashboard/', {templateUrl: 'application/views/view_dashboard.php'})
		.when('/Tablero/', {templateUrl: 'application/views/view_dashboard.php'})
		
		.when('/Comercializadora/',{templateUrl: 'application/views/view_grib_comercializadora.php'})
		.when('/Marketer/', {templateUrl: 'application/views/view_grib_comercializadora.php'})		
		.when('/Datos_Basicos_Comercializadora/', {templateUrl: 'application/views/view_comercializadora.php'})
		.when('/Basic_Data_Commercialist/', {templateUrl: 'application/views/view_comercializadora.php'})
		.when('/Datos_Basicos_Comercializadora/:ID',{templateUrl: 'application/views/view_comercializadora.php'})
		.when('/Basic_Data_Commercialist/:ID',{templateUrl: 'application/views/view_comercializadora.php'})
		.when('/Datos_Basicos_Comercializadora/:ID/:INF', {templateUrl: 'application/views/view_comercializadora.php'})
		.when('/Basic_Data_Commercialist/:ID/:INF', {templateUrl: 'application/views/view_comercializadora.php'})

		.when('/Productos/',{templateUrl: 'application/views/view_grib_productos.php'})
		.when('/Products/', {templateUrl: 'application/views/view_grib_productos.php'})
		.when('/Add_Productos/',{templateUrl: 'application/views/view_add_productos.php'})
		.when('/Add_Products/',{templateUrl: 'application/views/view_add_productos.php'})
		.when('/Edit_Productos/:ID',{templateUrl: 'application/views/view_add_productos.php'})
		.when('/Edit_Products/:ID',{templateUrl: 'application/views/view_add_productos.php'})
		.when('/Ver_Productos/:ID/:INF',{templateUrl: 'application/views/view_add_productos.php'})
		.when('/See_Products/:ID/:INF', {templateUrl: 'application/views/view_add_productos.php'})

		.when('/Anexos/',{templateUrl: 'application/views/view_grib_anexos.php'})
		.when('/Annexes/',{templateUrl: 'application/views/view_grib_anexos.php'})
		.when('/Add_Anexos/', {templateUrl: 'application/views/view_add_anexos.php'})
		.when('/Add_Annexes/', {templateUrl: 'application/views/view_add_anexos.php'})
		.when('/Edit_Anexos/:ID', {templateUrl: 'application/views/view_add_anexos.php'})
		.when('/Edit_Annexes/:ID', {templateUrl: 'application/views/view_add_anexos.php'})
		.when('/Ver_Anexos/:ID/:INF', {templateUrl: 'application/views/view_add_anexos.php'})
		.when('/See_Annexes/:ID/:INF', {templateUrl: 'application/views/view_add_anexos.php'})
		.when('/Comisiones_Anexos/:CodAnePro/:NumCifCom/:RazSocCom/:DesPro/:DesAnePro',
			{templateUrl: 'application/views/view_add_comisiones_anexos.php'})
		.when('/Commissions_Annexes/:CodAnePro/:NumCifCom/:RazSocCom/:DesPro/:DesAnePro',
			{templateUrl: 'application/views/view_add_comisiones_anexos.php'})

		.when('/Servicios_Adicionales/',{templateUrl: 'application/views/view_grib_servicios_especiales.php'})
		.when('/Additional_Services/',{templateUrl: 'application/views/view_grib_servicios_especiales.php'})
		.when('/Add_Servicios_Adicionales/', {templateUrl: 'application/views/view_add_servicios_especiales.php'})
		.when('/Add_Additional_Services/', {templateUrl: 'application/views/view_add_servicios_especiales.php'})
		.when('/Edit_Servicios_Adicionales/:ID',{templateUrl: 'application/views/view_add_servicios_especiales.php'})
		.when('/Edit_Additional_Services/:ID',{templateUrl: 'application/views/view_add_servicios_especiales.php'})		
		.when('/Ver_Servicios_Adicionales/:ID/:INF',{templateUrl: 'application/views/view_add_servicios_especiales.php'})
		.when('/See_Additional_Services/:ID/:INF',{templateUrl: 'application/views/view_add_servicios_especiales.php'})		
		.when('/Comisiones_Servicios_Adicionales/:CodSerEsp/:NumCifCom/:RazSocCom/:DesSerEsp',{
			templateUrl: 'application/views/view_add_comisiones_servicios_especiales.php'})
		.when('/Commissions_Additional_Services/:CodSerEsp/:NumCifCom/:RazSocCom/:DesSerEsp',{
		templateUrl: 'application/views/view_add_comisiones_servicios_especiales.php'})

		.when('/Clientes/',{templateUrl: 'application/views/view_grib_clientes.php'})
		.when('/Datos_Basicos_Clientes/', {templateUrl: 'application/views/view_datos_basicos_clientes.php'})		
		.when('/Edit_Datos_Basicos_Clientes/:ID', {templateUrl: 'application/views/view_datos_basicos_clientes.php'})
		.when('/Edit_Datos_Basicos_Clientes/:ID/:INF', {templateUrl: 'application/views/view_datos_basicos_clientes.php'})
		

		.when('/Actividades/', {templateUrl: 'application/views/view_grib_actividad.php'})	
		.when('/Add_Actividades/', {templateUrl: 'application/views/view_add_actividad.php'})	
		.when('/Puntos_Suministros/', {templateUrl: 'application/views/view_grib_punto_suministros.php'})
		.when('/Add_Puntos_Suministros/', {templateUrl: 'application/views/view_add_punto_suministros.php'})
		.when('/Edit_Punto_Suministros/:ID', {templateUrl: 'application/views/view_add_punto_suministros.php'})
		.when('/Edit_Punto_Suministros/:ID/:INF', {templateUrl: 'application/views/view_add_punto_suministros.php'})
		.when('/Contactos/', {templateUrl: 'application/views/view_grib_contactos.php'})
		.when('/Add_Contactos/', {templateUrl: 'application/views/view_add_contactos.php'})
		.when('/Edit_Contactos/:ID', {templateUrl: 'application/views/view_add_contactos.php'})
		.when('/Edit_Contactos/:ID/:INF', {templateUrl: 'application/views/view_add_contactos.php'})
		.when('/Contacto_Otro_Cliente/:NIFConCli', {templateUrl: 'application/views/view_add_contactos.php'})
		.when('/Cuentas_Bancarias/', {templateUrl: 'application/views/view_grib_cuentas_bancarias.php'})
		.when('/Add_Cuentas_Bancarias/', {templateUrl: 'application/views/view_add_cuentas_bancarias.php'})
		.when('/Edit_Cuenta_Bancaria/:ID', {templateUrl: 'application/views/view_add_cuentas_bancarias.php'})
		.when('/Documentos/', {templateUrl: 'application/views/view_grib_documentos.php'})
		.when('/Add_Documentos/', {templateUrl: 'application/views/view_add_documentos.php'})
		.when('/Edit_Documentos/:ID', {templateUrl: 'application/views/view_add_documentos.php'})
		.when('/Gestionar_Cups/', {templateUrl: 'application/views/view_grib_cups.php'})
		.when('/Add_Cups/', {templateUrl: 'application/views/view_add_cups.php'})
		.when('/Edit_Cups/:CodCups/:TipServ',{mytext:"This is angular",templateUrl: 'application/views/view_add_cups.php'})
		.when('/Edit_Cups/:CodCups/:TipServ/:INF', {mytext:"This is angular",templateUrl: 'application/views/view_add_cups.php'})		
		.when('/Consumo_CUPs/:CodCup/:TipServ/:CodPunSum', {mytext:"This is angular",templateUrl: 'application/views/view_grib_consumo_cups.php'})
		.when('/Historial_Consumo_Cups/:CodCup/:TipServ', {mytext:"This is angular",templateUrl: 'application/views/view_grib_historial_cups.php'})	
		.when('/Reporte_Cups_Colaboradores', {mytext:"This is angular",templateUrl: 'application/views/view_reporte_cups_colaboradores.php'})
				
		
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
		});$translateProvider.translations('sp',{});
		$translateProvider.translations('en', 
		{
			'LogOut':'Sign Off',			
			'LoadView':'Loading View, Please Wait...',
			'DASHBOARD':'Dashboard',
			'Designed':'Designed By ',

			'Add_Columns':'Add Columns',
			'Ex_Reports':'Generate Reports',
			'FILTRO':'Filters',
			'PDF':'Export in PDF',
			'EXCEL':'Export in Excel',			
			'FILTRO_SEARCH':'Write to Filter...',
			
			'LOGIN':'Welcome',
			'TITLE':"Application for the Management of Energy Services.",

			'Sin_Data':'Currently no data available.',
			'CARGA_DAT':'Loading Data, Please Wait...',
			'module_data':'Loading Module Data, Please Wait...',

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
			
			'VER':'See',
			'EDITAR':'Edit',
			'ACTIVAR':'Activate',
			'BLOQUEAR':'To Block',			
			'RELOAD':'Reload',
			
			'REGIS':'Save',
			'UPDA':'Update',
			'BACK':'Return',
			'lim_modal':'Clean',

			'FECH_INI':'Start Date',

			'TIP_SER':'Types of Services',
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

			'CAR_PER_CON':'Position Person Contact',
			'PAG_WEB':'Web Page',
			'SUM_ELE':'ELECTRICAL SUPPLY',
			'SUM_GAS':'GAS SUPPLY',
			'SUM_ADI':'ADDITIONAL SERVICES',
			'PERS_CONT':'Contact Person',			
			'FOT_CONT':'Photocopy of the Contract',
			'DOWN_CONT':'Download Document',
			
			'TAR_ACC_GAS':'GAS ACCESS RATE',
			'HIG_TENS':'High Voltage',
			'DOW_TENS':'Low Voltage',
			'TAR_ACC_ELE':'ELECTRICAL ACCESS RATE',

			'FEC_CONT':'Contract Date',
			'DUR':'Duration',
			'VENCI':'Expiration',			
			'RENEW':'Automatic renewal',

			'CAL_ANO':'The expiration date cannot be less than the start date.',
			'CAL_ANO_MAY':'The Minimum Time of the contract must be from 1 year onwards.',

			'SAVE':'Saving',
			'UPDATE':'Updating',

			'TEXT_SAVE':'Are you sure to enter this new record?',			
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
			'RAZ_COM_MODAL':'Trading Company Name',
			'MESSA_BLOC7':"To Block",

			'MESSA_BLOC8':"Activating",
			'MESSA_BLOC10':"Blocking",	

			'con_cif_modal':'Enter CIF Number:',
			'cif_con_modal':'CIF number',
			'validate_cif':'Checking CIF Number, Please Wait...',
			'button_con_modal':'Check',				
			
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

			///// side menu start /////
			'MARKETER':'Marketer',
			'DAT_BAS':'Basic Data',
			'PRODUCTS':'Products',
			'ANNEXES':'Annexes',
			'SER_ESP':'Be. Additional',
			'CUSTOMERS':'Customers',			
			'Exercise':'Exercise',
			'Supplies_Dir':'Supplies Add.',
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
			'ACTIVO':'Active',
			'BLOQUEADO':'Locked',
			'TIPO_SUM':'Type Of Supplies',
			'NOM_PROD':'Product Name',
			'search_comer_req':'You must Select a Marketer from the list.',
			'search_prod_req':'You must Select a Products from the list.',
			'search_tip_ser_req':'You must select a Type of Service.',
			'select_item':'Select an Item from the List.',
			'select_com_req':'You Must Select A Commission Type From the list.',			
			'produc_req':'The Product Name Field is Required.',
			
			'SER_ELE_REQ':'You must Select at least one Supply Type. Electric, Gas or Both.',	
			'SER_ELE_TAR_REQ':'You must select at least one Electric Service Rate, Low or High Voltage.',
			'SER_GAS_TAR_REQ':'You must select at least one Gas Rate.'	,
			'TIP_PRICE_REQ':'You must select a price type. Fixed, Indexed or Both.'
			,'TIP_COM_REQ':'You must Select a Commission Type from the list.'	,
			'ROW_DET_COM':'You must indicate at least one commission row to continue the process.',
			'ROW_DET_COM_CONMIN':'The Annual Minimum Consumption Field cannot be empty.',
			'ROW_DET_COM_CONMAX':'The Annual Maximum Consumption Field cannot be empty.',
			'ROW_DET_COM_CONSER':'The Service Commission Field cannot be empty.',
			'ROW_DET_COM_CONCERVE':'The Green Certificate Commission Field cannot be empty.',
			'CIF_EMPTY':'The CIF Number Cannot Be Empty.',
			'tip_cli_req':'You must select a type client from the list',	

			'COMISION':'Commissions',
			'ADD':'Add',
			'REMOVE':'Remove',
			'CONMINANU':'Annual Minimum Consumption',
			'CONMAXANU':'Annual Maximum Consumption',
			'CONSER':'Service Commission',
			'CONSERVER':'Green Certificate Commission',
			'TIP_COM':'Commission Type',
			'TIP_PRICE':'Types of Prices',
			'TIP_PRICE_FIJ':'PERMANENT',
			'TIP_PRICE_INDEX':'INDEXED',
			'TIP_CLI':'Client Types',
			'Both':'Both',
			'NEGOCIO':'Deal',
			'PARTICULAR':'Particular',
			'ALL':'All',
			'TIP_CLI_PART':'Private Customers',
			'TIP_CLI_NEG':'Business Clients',
			'MOT_BLO_EMPTY_COME':'We have not found reasons to block the trading companies, so they cannot continue with this operation.',
			'MESSA_BLOC12':"We have not been able to update the status.",
			
			/////COMERCIALIZADORA START ////
			'DAT_BAS_COM':'Basic_Data_Commercialist',
			'ADD_COM':'Add Marketer',			
			'MARKETER_NOBD':'We Have Not Found Currently Registered Marketers.',
			'MARKE_ACTI':'This Marketer is Already Active.',
			'ACTI_MARKE':'¿Are You Sure To Activate This Marketer?',
			'MARKETER_SAVE':'Marketer Registration',
			'MARKETER_UPDATE':'Marketer Data Update',
			'MARKETER_DATA':'Marketing Company Basic Data:',			
			'TITLE_CIF_REGISTER':'Registered Marketer.',
			'TEXT_CIF_REGISTER':'The Marketer is Already Registered.',
			'MARKE_BLOC':'¿This Marketer Is Already Blocked?',						
			'list_comer':'Loading list of Marketer, Please Wait...',
			'delete_cli':'Deleting Marketer, Please Wait...',
			'SAVE_MAR':'Saving Marketer, Please Wait...',			
			'UPDATE_MAR':'Updating Marketer, Please Wait ...',
			'RESPONSE_SAVE_MARKET':'Successfully registered Marketer',
			'RESPONSE_UPDATE_MARKET':'Successfully modified Marketer',
			'MESSA_BLOC6':"¿Are You Sure to Block This Marketer?",			
			'MESSA_BLOC9':"The Marketer has been successfully activated.",						
			'MESSA_BLOC11':'The Marketer has been successfully blocked.',			
			'BLO_COM_MODAL':' Marketing Blocker',
			/////COMERCIALIZADORA END ////

			
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
			'SAVE_PRODUC':'Register Products',
			'UPDATE_PRODUCT':'Updating Products',
			////// PARA PRODUCTOS END////////

			////// PARA ANEXOS START////////			
			'DESC_ANNEX':'Description Annex',						
			'List_Anex':'Loading Annex List, Please Wait...',
			'BLO_ANNE':'Annexed Lock',
			'ADD_ANNEX':'Add Annexes',
			'acti_annex':'This Annexed is already active.',
			'select_status':'You Must Select A Status.',
			'MESSA_TEXT_ACT_ANE':'Are You Sure to Activate This Annexed?',
			'MESSA_TEXT_BLO_ANE':'This Annexed is already blocked.',
			'TEXT_BLO_ANNEX':'Are you sure to block the Annexed.',
			'TEXT_ACT_ANNEX_RESPONSE':'The Annex has been successfully activated.',
			'TEXT_BLO_ANNEX_RESPONSE':'The Annex has been successfully Blocked.',
			'error_update_anex':'We were unable to process the status of the Annexed.',
			'NO_DATA_ANENNE':'We have not found Registered Annexed.',			
			'TEXT_SAVE_RESPONSE_ANE':'Annex successfully registered.',
			'TEXT_UPDATE_RESPONSE_ANE':'Annex updated correctly.',
			'SAVE_ANE':'Saving Annex, Please Wait...',
			'UPDATE_ANE':'Updating Annex, Please Wait...',
			'REGIST_ANENE':'Register Annexes',
			'FOT_ANNEX':'Photocopy of the Annex',
			'NAME_ANNEX':'Annex Name',			
			'nom_anex_req':'The Name of the annex is required.',
			'COM_ANE':'Annex Commissions',
			'SEE_ANNEXES':'See_Annexes',
			'EDIT_ANNEXES':'Edit_Annexes',
			'COMI_ANNEXES':'Commissions_Annexes',		
			////// PARA ANEXOS END////////

			////// PARA COMISIONES ANEXOS START////////
			'Car_Det':'Loading Commission Rates, Please Wait...',
			'Guar_Deta':'Performing Commission Process, Please Wait...',
			'NO_FOUND_TAR':'No assigned rates found',
			'ERROR_TAR_DETA':'You must finish the commission process you have active to be able to add or modify another one.',
			'pro_com_1':'Processing commissions',
			'pro_com_2':'Be sure to continue the procedure.',
			'MEN_EXI_COM_DET':'Commissions processed correctly.',
			////// PARA COMISIONES ANEXOS END////////

			////// PARA SERVICIOS ESPECIALES START////////
			'SER_ESP_TIT':'Special Services',
			'SER_ADD':'Additional_Services',
			'SER_ADD_ADD':'Add_Additional_Services',
			'SER_SEE_SEE':'See_Additional_Services',
			'SER_EDIT_EDIT':'Edit_Additional_Services',
			'SER_SEE_COM':'Commissions_Additional_Services',
			'TITLE_ADD_SER_ESP':'Add Special Service',
			'BLO_SER_ESP':'Special Service Lock',
			'List_Serv':'Loading list of Additional Services, Please Wait...',
			'SER_ESP_NAME':'Special Services Registry',			
			'TIP_CLI_CART':'Main features of the Special Service',
			'NAME_SER_ESP':'Name of the Special Service',
			'SAVE_SER_ESP':'Saving Special Services, Please Wait...',
			'UPDATE_SER_ESP':'Updating Special Services, Please Wait...',
			'RESPONSE_SAVE_SER_ESPE':'Special Service successfully created.',
			'RESPONSE_UPDATE_SER_ESP':'Special Service successfully modified.',
			'no_ser_esp_regis':'We have not found registered Special Services.',
			'ACT_SER_ESPE':'This Special Service is already active.',
			'ACT_QUES_SER_ESP':'Are you sure to activate the special service?',
			'BLO_QUES_SER_ESP':'This Special Service is already blocked.',
			'TEXT_SER_ESP_ACT':'The Special Service has been successfully activated.',
			'TEXT_SER_ESP_BLO':'The Special Service has been blocked successfully.',
			'MESSA_BLOC_SER_ESP':'Are you sure you want to block this Special Service?',
			'search_name_ser_req':'The Special Service Name is Required.',
			'car_ser_espe_req':'The Characteristics of the Special Service is Required.',
			////// PARA SERVICIOS ESPECIALES END////////

			////// PARA COMISIONES DE LOS SERVICIOS ESPECIALES START////////
			'COM_SER_ESP':'Special Services Commissions',
			////// PARA COMISIONES DE LOS SERVICIOS ESPECIALES END//////////



		});		
		//$translateProvider.preferredLanguage('en');

		
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
