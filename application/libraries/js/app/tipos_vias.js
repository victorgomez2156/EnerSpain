app.controller('Controlador_Tipos_Vias', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.Tipos_Vias=undefined;
	scope.Tipos_ViasBack=undefined;
	scope.validacion_formulario=0;	
	scope.validate_form=false;
	scope.enabled_button=false;
	scope.index=0;
	
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
		$("#crear_vias").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		var url=base_urlHome()+"api/Configuraciones_Generales/crear_tipos_vias/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			scope.nID=result.data.CodTipVia;
			if(scope.nID>0)
			{
				console.log(result.data);				
				$("#crear_vias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Exito!",
				message: "El Tipo de vias a sido registrado correctamente.",
				size: 'middle'});
				scope.buscarXID();				
			}
			else
			{
				$("#crear_vias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Error!!",
				message: "ha ocurrido un error intentando guardar el usuario por favor intente nuevamente.",
				size: 'middle'});				
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#crear_vias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Error en Metodo",
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#crear_vias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Permiso Denegado",
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#crear_vias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				title:"Error en Seguridad",
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#crear_vias").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				title:"Error Server",
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}	


	scope.cargar_lista_tipos_vias=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Configuraciones_Generales/list_tipos_vias/";
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
				scope.Tipos_Vias=result.data;
				scope.Tipos_ViasBack=result.data;					
				$scope.totalItems = scope.Tipos_Vias.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.Tipos_Vias.indexOf(value);  
					return (begin <= index && index < end);  
				};				
				//console.log(scope.Tipos_Vias);
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "No hemos encontrado tipos de vias registrados.",
				size: 'middle'});
				scope.Tipos_Vias=undefined;
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
		scope.validate_form=true;
		scope.enabled_button=false;
		scope.cif_cliente_validado=null;
	}	
	scope.buscarXID=function()
	{
		$("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Configuraciones_Generales/buscar_xID_tipo_via/CodTipVia/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.fdatos=result.data;
				//console.log(scope.fdatos);
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
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_tipos_vias/hvia/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});
						scope.Tipos_Vias.splice(index,1);
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
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_tipos_vias/hvia/"+scope.fdatos.CodTipVia;
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
	scope.filtrarLocalidad =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodPro}, true);
		console.log(scope.TLocalidadesfiltrada);
	}
	scope.filtrar_grib = function(expresion)
	{
		if (expresion.length>0)
		{
			//
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tipos_Vias = $filter('filter')(scope.Tipos_ViasBack, {NumCifCli: expresion});								
			$scope.totalItems = scope.Tipos_Vias.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tipos_Vias.indexOf(value);  
				return (begin <= index && index < end);  
			};				
		}
		else
		{
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tipos_Vias=scope.Tipos_ViasBack;								
			$scope.totalItems = scope.Tipos_Vias.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tipos_Vias.indexOf(value);  
				return (begin <= index && index < end);  
			};			

		}
		
	}	
	scope.validar_opcion=function(index,opcion,datos)
	{
		if(opcion==1)
		{
			console.log('Esto es Para Ver');
			console.log(datos);
			scope.tmdodal_data={};
			scope.tmdodal_data=datos;
			$("#modal_ver_datos_Configuraciones_Generales").modal('show');
			scope.opciones_Configuraciones_Generales[index]=undefined;
			scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {CodPro: scope.tmdodal_data.CodPro}, true);
		}
		if(opcion==2)
		{
			console.log('Esto es Para Editar');
			console.log(datos);
		}
		if(opcion==3 || opcion==4)
		{
			scope.datos_update={};
			scope.datos_update.opcion=opcion;
			scope.datos_update.hcliente=datos.CodTipVia;
			var url = base_urlHome()+"api/Configuraciones_Generales/update_status/";
			$http.post(url,scope.datos_update).then(function(result)
			{
				if(result.data!=false)
				{
					Swal.fire({title:"Exito!.",text:"Estatus del cliente actualizado con exito.",type:"success",confirmButtonColor:"#188ae2"});
					scope.cargar_lista_tipos_vias();
					scope.opciones_Configuraciones_Generales[index]=undefined;
				}
				else
				{
					Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					scope.cargar_lista_tipos_vias();
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "El método que esté intentando usar no puede ser localizado.",
					size: 'middle'});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
					size: 'middle'});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Está intentando usar un APIKEY inválido.",
					size: 'middle'});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					bootbox.alert({
					message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
					size: 'middle'});
				}
			});
		}		
	}	
	if(scope.nID!=undefined)
	{
		scope.buscarXID();
	}	
	/*else
	{
		scope.cargar_lista_tipos_vias();
	}*/	
}			