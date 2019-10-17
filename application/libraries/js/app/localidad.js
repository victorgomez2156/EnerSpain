app.controller('Controlador_Localidad', ['$http', '$scope', '$filter','$route','$interval','upload', '$controller','$cookies','ServiceProvincias', Controlador])
.directive("uploaderModel", function($parse)
{
  return{
    link: function($scope, element, attrs){
      element.on("change", function(event){
        var files = event.target.file;
        $parse(attrs.uploaderModel).assign($scope, element[0].files[0]);
        $scope.$apply();
      });
    }
  }
})
.service('upload', ["$http", "$q", function ($http, $q) 
{
	this.uploadFile = function(file, name)
	{
		var deferred = $q.defer();
		var formData = new FormData();
		//formData.append("name", name);
		formData.append("file", file);
		return $http.post("import.php", formData, {
			headers: {
				"Content-type": undefined 
			},
			transformRequest: angular.identity
		})
		.success(function(res)
		{
			deferred.resolve(res);
		})
		.error(function(msg, code)
		{
			deferred.reject(msg);
		})
		return deferred.promise;
	}	
}]);
function Controlador($http,$scope,$filter,$route,$interval,upload,$controller,$cookies,ServiceProvincias)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.TLocalidad=undefined;
	scope.TLocalidadesfiltrada=undefined;
	scope.fdatos.CPLoc=null;
	scope.import=false;
	ServiceProvincias.getAll().then(function(dato) 
	{
		scope.tProvidencias = dato;
		console.log(scope.tProvidencias);		
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});

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
	$scope.uploadFile = function()
	{
		var file = $scope.file;
		upload.uploadFile(file, name).then(function(res)
		{
			console.log(res);
			 $scope.file="";	
        	$("#importar").val("");
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				console.log(error);
				$scope.file="";	
        		$("#importar").val("");
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});

			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				console.log(error);
				$scope.file="";	
        		$("#importar").val("");
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				console.log(error);
				$scope.file="";	
        		$("#importar").val("");	
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				console.log(error);
				$scope.file="";	
        		$("#importar").val("");
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	  

	scope.guardar=function()
	{		
		$("#crear_provincias").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		var url=base_urlHome()+"api/Configuraciones_Generales/crear_localidad/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			scope.nID=result.data.CodLoc;
			if(scope.nID>0)
			{
				console.log(result.data);				
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "La Localidad a sido registrada correctamente.",
				size: 'middle'});
				scope.buscarXID();				
			}
			else
			{
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "ha ocurrido un error intentando guardar la localidad por favor intente nuevamente.",
				size: 'middle'});				
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#crear_provincias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}	


	scope.cargar_lista_localidad=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Configuraciones_Generales/list_localidad/";
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
				scope.TLocalidad=result.data;	
				scope.TLocalidadesfiltrada=result.data;					
				$scope.totalItems = scope.TLocalidadesfiltrada.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.TLocalidadesfiltrada.indexOf(value);  
					return (begin <= index && index < end);  
				};
				scope.fdatos.CodPro=undefined;
				console.log(scope.TLocalidadesfiltrada);
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "No hemos encontrado Localidades registradas.",
				size: 'middle'});
				scope.TLocalidadesfiltrada=undefined;
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
	scope.filtrarLocalidad =  function()
	{		
		$scope.predicate = 'id';  
		$scope.reverse = true;						
		$scope.currentPage = 1;  
		$scope.order = function (predicate) 
		{  
			$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
			$scope.predicate = predicate;  
		};
		scope.TLocalidadesfiltrada = $filter('filter')(scope.TLocalidad, {CodPro: scope.fdatos.CodPro}, true);				
		$scope.totalItems = scope.TLocalidadesfiltrada.length; 
		$scope.numPerPage = 50;  
		$scope.paginate = function (value) 
		{  
			var begin, end, index;  
			begin = ($scope.currentPage - 1) * $scope.numPerPage;  
			end = begin + $scope.numPerPage;  
			index = scope.TLocalidadesfiltrada.indexOf(value);  
			return (begin <= index && index < end);  
		};		
		console.log(scope.TLocalidadesfiltrada);
	}	
	scope.limpiar=function()
	{
		scope.fdatos={};
		scope.fdatos.CPLoc=null;
	}	

	scope.buscarXID=function()
	{
		$("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Configuraciones_Generales/buscar_xID_Localidad/CodLoc/"+scope.nID;
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
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_localidad/CodLoc/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});
						scope.TLocalidad.splice(index,1);
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
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_localidad/CodLoc/"+scope.fdatos.CodLoc;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});						
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
	$interval(function()
    {
       if($scope.file)
       	{
			$scope.uploadFile();
		}
    },0);	
	if(scope.nID!=undefined)
	{
		scope.buscarXID();
	}		
}			