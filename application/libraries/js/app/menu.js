app.controller('CtrlMenuController', ['$http','$scope','$interval','ServiceMenu','$cookieStore','netTesting','$cookies', Controlador]);
function Controlador ($http,$scope,$interval,ServiceMenu,$cookieStore,netTesting,$cookies){
			//declaramos una variable llamada scope donde tendremos a vm
	var scope = this;
	scope.fMenu = [];
scope.Dashboard=false;
scope.Comercializadora=false;
scope.Comercializadora_DatosBasicos=false;
scope.Comercializadora_Productos=false;
scope.Comercializadora_Anexos=false;
scope.Comercializadora_ServiciosEspeciales=false;
scope.Clientes=false;
scope.Clientes_DatosBasicos=false;
scope.Clientes_Actividad=false;
scope.Clientes_DirPunSum=false;
scope.Clientes_GestionesCups=false;
scope.Clientes_Contactos=false;
scope.Clientes_CuentasBancarias=false;
scope.Clientes_Documentos=false;
scope.Gestion_Comercial_ProCom=false;
scope.Gestion_Comercial_Contrato=false;
scope.Gestion_Comercial_RenMas=false;
scope.Gestion_Comercial_OtrasGestiones=false;
scope.Gestion_Comercial_Seguimientos=false;
scope.Reportes=false;
scope.Reportes_Colaboradores=false;
scope.Reportes_Rueda=false;
scope.Reportes_ProyeccionIngresos=false;
scope.Reportes_IngresosReales=false;
scope.Reportes_IngVsProyec=false;
scope.Configuracion=false;
scope.Configuracion_Distribuidora=false;
scope.Configuracion_Tarifas=false;
scope.Configuracion_Colaboradores=false;
scope.Configuracion_Comercial=false;
scope.Configuracion_Tipos=false;
scope.Configuracion_Motivos=false;
scope.Configuracion_Usuarios=false;
scope.Configuracion_Logs=false;
	// datos del formulario
	//Menu = $cookieStore.get('Menu');
	ServiceMenu.getAll().then(function(dato) 
	{
		//console.log(dato);
		angular.forEach(dato, function(menu)
			{
	            console.log(menu); 
	            if(menu.titulo=="Dashboard" && menu.id==1) 
	            {
	            	scope.Dashboard=true;
	            }	                
	            else if(menu.titulo=="Comercializadora" && menu.id==2)
	            {
	            	scope.Comercializadora=true;
	            }
	            else if(menu.titulo=="Datos Básicos" && menu.id==3)
	            {
	            	scope.Comercializadora_DatosBasicos=true;
	            }
	            else if(menu.titulo=="Productos" && menu.id==4)
	            {
	            	scope.Comercializadora_Productos=true;
	            }
	            else if(menu.titulo=="Anexos" && menu.id==5)
	            {
	            	scope.Comercializadora_Anexos=true;
	            }
	            else if(menu.titulo=="Servicios Especiales" && menu.id==6)
	            {
	            	scope.Comercializadora_ServiciosEspeciales=true;
	            }
	            else if(menu.titulo=="Clientes" && menu.id==7)
	            {
	            	scope.Clientes=true;
	            }
	            else if(menu.titulo=="Datos Básicos" && menu.id==8)
	            {
	            	scope.Clientes_DatosBasicos=true;
	            }
	            else if(menu.titulo=="Actividad" && menu.id==9)
	            {
	            	scope.Clientes_Actividad=true;
	            }
	            else if(menu.titulo=="Dirección Suministros" && menu.id==10)
	            {
	            	scope.Clientes_DirPunSum=true;
	            }
	            else if(menu.titulo=="Gestionar Cups" && menu.id==11)
	            {
	            	scope.Clientes_GestionesCups=true;
	            }
	            else if(menu.titulo=="Contactos" && menu.id==12)
	            {
	            	scope.Clientes_Contactos=true;
	            }
	            else if(menu.titulo=="Cuentas Bancarias" && menu.id==13)
	            {
	            	scope.Clientes_CuentasBancarias=true;
	            }
	            else if(menu.titulo=="Documentos" && menu.id==14)
	            {
	            	scope.Clientes_Documentos=true;
	            }
	            else if(menu.titulo=="Gestión Comercial" && menu.id==15) 
	            {
	            	scope.Gestion_Comercial=true;
	            }	                
	            else if(menu.titulo=="Propuesta Comercial" && menu.id==16)
	            {
	            	scope.Gestion_Comercial_ProCom=true;
	            }
	            else if(menu.titulo=="Contratos" && menu.id==17)
	            {
	            	scope.Gestion_Comercial_Contrato=true;
	            }
	            else if(menu.titulo=="Renovación Masiva" && menu.id==18)
	            {
	            	scope.Gestion_Comercial_RenMas=true;
	            }
	            else if(menu.titulo=="Otras Gestiones" && menu.id==19)
	            {
	            	scope.Gestion_Comercial_OtrasGestiones=true;
	            }
	            else if(menu.titulo=="Seguimientos" && menu.id==20)
	            {
	            	scope.Gestion_Comercial_Seguimientos=true;
	            }
	            else if(menu.titulo=="Reportes" && menu.id==21) 
	            {
	            	scope.Reportes=true;
	            }	                
	            else if(menu.titulo=="Colaboradores" && menu.id==22)
	            {
	            	scope.Reportes_Colaboradores=true;
	            }
	            else if(menu.titulo=="Rueda" && menu.id==23)
	            {
	            	scope.Reportes_Rueda=true;
	            }
	            else if(menu.titulo=="Proyección de Ingresos" && menu.id==24)
	            {
	            	scope.Reportes_ProyeccionIngresos=true;
	            }
	            else if(menu.titulo=="Ingresos Reales" && menu.id==25)
	            {
	            	scope.Reportes_IngresosReales=true;
	            }
	            else if(menu.titulo=="Ing. Reales Vs Proyectado" && menu.id==26)
	            {
	            	scope.Reportes_IngVsProyec=true;
	            }
	            else if(menu.titulo=="Configuración" && menu.id==27)
	            {
	            	scope.Configuracion=true;
	            }
	            else if(menu.titulo=="Distribuidora" && menu.id==28)
	            {
	            	scope.Configuracion_Distribuidora=true;
	            }
	            else if(menu.titulo=="Tarifas" && menu.id==29)
	            {
	            	scope.Configuracion_Tarifas=true;
	            }
	            else if(menu.titulo=="Colaboradores" && menu.id==30)
	            {
	            	scope.Configuracion_Colaboradores=true;
	            }
	            else if(menu.titulo=="Comerciales" && menu.id==31)
	            {
	            	scope.Configuracion_Comercial=true;
	            }
	            else if(menu.titulo=="Tipos" && menu.id==32) 
	            {
	            	scope.Configuracion_Tipos=true;
	            }	                
	            else if(menu.titulo=="Motivos" && menu.id==33)
	            {
	            	scope.Configuracion_Motivos=true;
	            }
	            else if(menu.titulo=="Usuarios" && menu.id==34)
	            {
	            	scope.Configuracion_Usuarios=true;
	            }
	            else if(menu.titulo=="Logs" && menu.id==35)
	            {
	            	scope.Configuracion_Logs=true;
	            }	           
	        });
		
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
	/*EL MENU ES EL ESPACIO IDEAL PARA HACER LA SOLICITUD DE DATOS REMOTOS PARA TRAER A LA BD LOCAL**/
	var fecha = new Date();
	var dd = fecha.getDate();
	var mm = fecha.getMonth()+1; //January is 0!
	var yyyy = fecha.getFullYear();
	if(dd<10){
	dd='0'+dd
	} 
	if(mm<10){
		mm='0'+mm
	} 
	var fecha = dd+'/'+mm+'/'+yyyy;
	/*var url = base_urlHome()+"api/Menu/usuariomenu";
	$http.get(url).then(function(result)
	{

		//scope.Dashboard=true;
		if(result.data!=false)
		{
			angular.forEach(result.data, function(menu)
			{
	            console.log(menu); 
	            if(menu.titulo=="Dashboard" && menu.id==1) 
	            {
	            	scope.Dashboard=true;
	            }	                
	            else if(menu.titulo=="Comercializadora" && menu.id==2)
	            {
	            	scope.Comercializadora=true;
	            }
	            else if(menu.titulo=="Datos Básicos" && menu.id==3)
	            {
	            	scope.Comercializadora_DatosBasicos=true;
	            }
	            else if(menu.titulo=="Productos" && menu.id==4)
	            {
	            	scope.Comercializadora_Productos=true;
	            }
	            else if(menu.titulo=="Anexos" && menu.id==5)
	            {
	            	scope.Comercializadora_Anexos=true;
	            }
	            else if(menu.titulo=="Servicios Especiales" && menu.id==6)
	            {
	            	scope.Comercializadora_ServiciosEspeciales=true;
	            }
	            else if(menu.titulo=="Clientes" && menu.id==7)
	            {
	            	scope.Clientes=true;
	            }
	            else if(menu.titulo=="Datos Básicos" && menu.id==8)
	            {
	            	scope.Clientes_DatosBasicos=true;
	            }
	            else if(menu.titulo=="Actividad" && menu.id==9)
	            {
	            	scope.Clientes_Actividad=true;
	            }
	            else if(menu.titulo=="Dirección Suministros" && menu.id==10)
	            {
	            	scope.Clientes_DirPunSum=true;
	            }
	            else if(menu.titulo=="Gestionar Cups" && menu.id==11)
	            {
	            	scope.Clientes_GestionesCups=true;
	            }
	            else if(menu.titulo=="Contactos" && menu.id==12)
	            {
	            	scope.Clientes_Contactos=true;
	            }
	            else if(menu.titulo=="Cuentas Bancarias" && menu.id==13)
	            {
	            	scope.Clientes_CuentasBancarias=true;
	            }
	            else if(menu.titulo=="Documentos" && menu.id==14)
	            {
	            	scope.Clientes_Documentos=true;
	            }
	            else if(menu.titulo=="Gestión Comercial" && menu.id==15) 
	            {
	            	scope.Gestion_Comercial=true;
	            }	                
	            else if(menu.titulo=="Propuesta Comercial" && menu.id==16)
	            {
	            	scope.Gestion_Comercial_ProCom=true;
	            }
	            else if(menu.titulo=="Contratos" && menu.id==17)
	            {
	            	scope.Gestion_Comercial_Contrato=true;
	            }
	            else if(menu.titulo=="Renovación Masiva" && menu.id==18)
	            {
	            	scope.Gestion_Comercial_RenMas=true;
	            }
	            else if(menu.titulo=="Otras Gestiones" && menu.id==19)
	            {
	            	scope.Gestion_Comercial_OtrasGestiones=true;
	            }
	            else if(menu.titulo=="Seguimientos" && menu.id==20)
	            {
	            	scope.Gestion_Comercial_Seguimientos=true;
	            }
	            else if(menu.titulo=="Reportes" && menu.id==21) 
	            {
	            	scope.Reportes=true;
	            }	                
	            else if(menu.titulo=="Colaboradores" && menu.id==22)
	            {
	            	scope.Reportes_Colaboradores=true;
	            }
	            else if(menu.titulo=="Rueda" && menu.id==23)
	            {
	            	scope.Reportes_Rueda=true;
	            }
	            else if(menu.titulo=="Proyección de Ingresos" && menu.id==24)
	            {
	            	scope.Reportes_ProyeccionIngresos=true;
	            }
	            else if(menu.titulo=="Ingresos Reales" && menu.id==25)
	            {
	            	scope.Reportes_IngresosReales=true;
	            }
	            else if(menu.titulo=="Ing. Reales Vs Proyectado" && menu.id==26)
	            {
	            	scope.Reportes_IngVsProyec=true;
	            }
	            else if(menu.titulo=="Configuración" && menu.id==27)
	            {
	            	scope.Configuracion=true;
	            }
	            else if(menu.titulo=="Distribuidora" && menu.id==28)
	            {
	            	scope.Configuracion_Distribuidora=true;
	            }
	            else if(menu.titulo=="Tarifas" && menu.id==29)
	            {
	            	scope.Configuracion_Tarifas=true;
	            }
	            else if(menu.titulo=="Colaboradores" && menu.id==30)
	            {
	            	scope.Configuracion_Colaboradores=true;
	            }
	            else if(menu.titulo=="Comerciales" && menu.id==31)
	            {
	            	scope.Configuracion_Comercial=true;
	            }
	            else if(menu.titulo=="Tipos" && menu.id==32) 
	            {
	            	scope.Configuracion_Tipos=true;
	            }	                
	            else if(menu.titulo=="Motivos" && menu.id==33)
	            {
	            	scope.Configuracion_Motivos=true;
	            }
	            else if(menu.titulo=="Usuarios" && menu.id==34)
	            {
	            	scope.Configuracion_Usuarios=true;
	            }
	            else if(menu.titulo=="Logs" && menu.id==35)
	            {
	            	scope.Configuracion_Logs=true;
	            }	           
	        });
		}

	},function(error)
	{

	});*/
};
