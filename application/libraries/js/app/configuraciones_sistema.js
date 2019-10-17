app.controller('Controlador_Configuraciones_Sistemas', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	//scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	
	scope.buscar_configuracion_sistema=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
	var url = base_urlHome()+"api/Configuraciones_Generales/cargar_configuraciones_sistemas/";
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			scope.fdatos=result.data;
		}
		else
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );	
		}

	},function(error)
	{

		if(error.status==404 && error.statusText=="Not Found")
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			bootbox.alert({
			message: "El método que esté intentando usar no puede ser localizado.",
			size: 'middle'});
		}
		if(error.status==401 && error.statusText=="Unauthorized")
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			bootbox.alert({
			message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
			size: 'middle'});
		}
		if(error.status==403 && error.statusText=="Forbidden")
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			bootbox.alert({
			message: "Está intentando usar un APIKEY inválido.",
			size: 'middle'});
		}
		if(error.status==500 && error.statusText=="Internal Server Error")
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			bootbox.alert({
			message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
			size: 'middle'});
		}

	});
	}

	$scope.submitForm = function(event) 
	{      
	 	console.log(scope.fdatos);
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea actualizar este registro?",
	    buttons: {
	    cancel: {
	    label: '<i class="fa fa-times"></i> Cancelar'
	    },
	    confirm: {
		label: '<i class="fa fa-check"></i> Confirmar'
		}
		},
		callback: function (result) 
		{
			if (result==false) 
			{ 
				event.preventDefault();
			}     
			else
			{
				scope.guardar();	
			}
		}});
					
	}; 
	scope.guardar=function()
	{		
		$("#actualizando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		var url=base_urlHome()+"api/Configuraciones_Generales/guardar_configuraciones/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			scope.nID=result.data.id;
			if(scope.nID>0)
			{
				console.log(result.data);				
				$("#actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Configuracion Actualizada Correctamente.",
				size: 'middle'});	
				scope.buscar_configuracion_sistema()						
			}
			else
			{
				$("#actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "ha ocurrido un error intentando guardar la provincia por favor intente nuevamente.",
				size: 'middle'});				
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#actualizando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.buscar_configuracion_sistema()	
}			