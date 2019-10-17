app.controller('Controlador_Sectores', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,controller,$cookies)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.tSectores=undefined;	
	scope.tSectoresBack=undefined;
	if($route.current.$$route.originalPath=="/Sector_Cliente/")
	{
		scope.fdatos.CodSecCli=true;
		scope.fdatos.DesSecCli=true;
		scope.fdatos.AccCol=true;
	}	
	$scope.submitForm = function(event) 
	{      
	 	console.log(scope.fdatos);
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea incluir este nuevo registro?",
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
		$("#crear").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		var url=base_urlHome()+"api/Configuraciones_Generales/crear_sectores/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			scope.nID=result.data.CodSecCli;
			if(scope.nID>0)
			{
				console.log(result.data);				
				$("#crear").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El Sector a sido registrada correctamente.",
				size: 'middle'});
				scope.buscarXID();				
			}
			else
			{
				$("#crear").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "ha ocurrido un error intentando guardar el sector por favor intente nuevamente.",
				size: 'middle'});				
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#crear").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#crear").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#crear").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#crear").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}	


	scope.cargar_lista_sectores=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Configuraciones_Generales/list_sectores/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				$scope.predicate = 'id';  
				$scope.reverse = true;						
				$scope.currentPage = 1;  
				$scope.order = function (predicate) 
				{  
					$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
					$scope.predicate = predicate;  
				}; 						
				scope.tSectores=result.data;
				scope.tSectoresBack=result.data;					
				$scope.totalItems = scope.tSectores.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.tSectores.indexOf(value);  
					return (begin <= index && index < end);  
				};				
				console.log(scope.tSectores);
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "No hemos encontrado Sectores registradas.",
				size: 'middle'});
				scope.tSectores=undefined;
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
	scope.limpiar=function()
	{
		scope.fdatos={};		
	}	

	scope.buscarXID=function()
	{
		$("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Configuraciones_Generales/buscar_xID_sectores/CodSecCli/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.fdatos=result.data;				
				console.log(scope.fdatos);
			}
			else
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Hubo un error al intentar cargar los datos.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.borrar_row=function(index,id)
	{
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea eliminar este registro?",
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
				console.log('Cancelando Ando...');
			}     
			else
			{					
				$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_sectores/CodSecCli/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});
						scope.tSectores.splice(index,1);
					}
					else
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "No hemos podido borrar el registro intente nuevamente.",
						size: 'middle'});	
					}

				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "El método que esté intentando usar no puede ser localizado.",
						size: 'middle'});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
						size: 'middle'});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Está intentando usar un APIKEY inválido.",
						size: 'middle'});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						bootbox.alert({
						message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
						size: 'middle'});
					}
				});
			}
		}});
	}
	scope.borrar=function()
	{
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea eliminar este registro?",
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
				console.log('Cancelando Ando...');
			}     
			else
			{					
				$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_sectores/CodSecCli/"+scope.fdatos.CodSecCli;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});	
						location.href="#/Sector_Cliente/";
					}
					else
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "No hemos podido borrar el registro intente nuevamente.",
						size: 'middle'});	
					}

				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "El método que esté intentando usar no puede ser localizado.",
						size: 'middle'});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
						size: 'middle'});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Está intentando usar un APIKEY inválido.",
						size: 'middle'});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						bootbox.alert({
						message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
						size: 'middle'});
					}
				});
			}
		}});
	}
	scope.filtrar = function(expresion)
	{
		if (expresion.length>0)
		{
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.tSectores = $filter('filter')(scope.tSectoresBack, {CodEur: expresion});				
			$scope.totalItems = scope.tSectores.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.tSectores.indexOf(value);  
				return (begin <= index && index < end);  
			};
		}
		else
		{
			//scope.cargar_lista_sectores();
			scope.tSectores=scope.tSectoresBack;
		}
	}	
	if(scope.nID!=undefined)
	{
		scope.buscarXID();
	}
		
}			