app.controller('Controlador_Tipos', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	var fecha = new Date();
	var dd = fecha.getDate();
	var mm = fecha.getMonth()+1; //January is 0!
	var yyyy = fecha.getFullYear();
	if(dd<10)
	{
		dd='0'+dd
	} 
	if(mm<10)
	{
		mm='0'+mm
	} 
	var fecha = dd+'-'+mm+'-'+yyyy;
	scope.topciones = [{id: 1, nombre: 'VER'},{id: 2, nombre: 'EDITAR'}];
	scope.TVistaCliente=1;
	scope.DesTipCli=true;
	scope.AccCli=true;
	scope.ruta_reportes_pdf_cliente=0;
	scope.ruta_reportes_excel_cliente=0;
	scope.Tipo_Cliente=[];
	scope.fdatos_clientes={};
	
	scope.TVistaSector=1;
	scope.Tipo_Sector=[];
	scope.DesSecCli=true;
	scope.AccSecCli=true;
	scope.fdatos_sector={};
	scope.ruta_reportes_pdf_sector=0;
	scope.ruta_reportes_excel_sector=0;
	
	scope.TVistaContacto=1;
	scope.Tipo_Contacto=[];
	scope.DesTipCon=true;
	scope.AccTipCon=true;
	scope.fdatos_contacto={};
	scope.ruta_reportes_pdf_contacto=0;
	scope.ruta_reportes_excel_contacto=0;
	
	scope.TVistaDocumentos=1;
	scope.Tipo_Documento=[];
	scope.DesTipDoc=true;
	scope.EstReq=true;
	scope.AccTipDoc=true;
	scope.fdatos_documento={};
	scope.ruta_reportes_pdf_documento=0;
	scope.ruta_reportes_excel_documento=0;
//////////////////////////////////////////////////////////////////////////////TIPO CLIENTE START////////////////////////////////////////////////////////////////////////
	scope.cargar_lista_tipo_clientes=function()
	{
		$("#cargando_lista").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Tipos/list_tipo_clientes/";
		$http.get(url).then(function(result)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			if(result.data!=false)
			{
				$scope.predicate = 'id';  
				$scope.reverse = true;						
				$scope.currentPage = 1;  
				$scope.order = function (predicate) 
				{  
					$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
					$scope.predicate = predicate;  
				}; 						
				scope.Tipo_Cliente=result.data;					
				$scope.totalItems = scope.Tipo_Cliente.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.Tipo_Cliente.indexOf(value);  
					return (begin <= index && index < end);  
				};				
				console.log(scope.Tipo_Cliente);
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrado tipos de cliente registrados.",type:"error",confirmButtonColor:"#188ae2"});
				scope.Tipo_Cliente=[];
			}
		},function(error)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.agg_cliente=function()
	{
		scope.fdatos_clientes={};
		scope.TVistaCliente=2;
		scope.validate_cliente=undefined;
	}
	scope.regresar_cliente=function()
	{
		Swal.fire({title:"Regresar",
		text:"¿Está Seguro de Regresar y no completar el Proceso?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            scope.fdatos_clientes={};
				scope.TVistaCliente=1;
				scope.validate_cliente=undefined;
				scope.cargar_lista_tipo_clientes();
				return false;
	        }
	        else
	        {
				console.log('Cancelando Ando...');
				return false;							
	        }
	    });		
	}
	$scope.submitFormClientes = function(event) 
	{      
	 	console.log(scope.fdatos_clientes);
	 	if(scope.fdatos_clientes.CodTipCli>0)
		{
		 	var title='Actualizando';
		 	var text='¿Esta Seguro de Actualizar el Tipo de Cliente?';
		 	var response="Tipo de Cliente modificado satisfactoriamente.";
		}
		if(scope.fdatos_clientes.CodTipCli==undefined)
		{
		 	var title='Guardando';
		 	var text='¿Está Seguro de Guardar El Nuevo Tipo de Cliente?';
		 	var response="Tipo de Cliente creado satisfactoriamente.";
		}
		if(scope.fdatos_clientes.ObsTipCli==undefined||scope.fdatos_clientes.ObsTipCli==null||scope.fdatos_clientes.ObsTipCli=="")
		{
			scope.fdatos_clientes.ObsTipCli=null;
		}
		else
		{
			scope.fdatos_clientes.ObsTipCli=scope.fdatos_clientes.ObsTipCli;
		}
	 	Swal.fire({title:title,
		text:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#"+title).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");				
				var url=base_urlHome()+"api/Tipos/crear_tipo_cliente/";
				$http.post(url,scope.fdatos_clientes).then(function(result)
				{
					scope.nIDClientes=result.data.CodTipCli;
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(scope.nIDClientes>0)
					{
						console.log(result.data);
						Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
						scope.buscarXID_Clientes();										
					}
					else
					{
						Swal.fire({title:"Error",text:"Ha ocurrido un error durante el proceso, Por Favor Intente Nuevamente .",type:"error",confirmButtonColor:"#188ae2"});															
					}
				},function(error)
				{
					console.log(error);
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}					
				});	           
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });					
	}; 
	scope.buscarXID_Clientes=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Tipos/buscar_xID_Tipo_Cliente/CodTipCli/"+scope.nIDClientes;
		$http.get(url).then(function(result)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{	
				scope.fdatos_clientes=result.data;				
				console.log(scope.fdatos_clientes);
			}
			else
			{
				Swal.fire({title:"Error",text:"Hubo un error al intentar cargar los datos.",type:"error",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			console.log(error);
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}			
		});
	}
	scope.limpiar_cliente=function()
	{
		scope.fdatos_clientes={};
	}
	scope.borrar_cliente=function()
	{
		var event=true;
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		Swal.fire({title:"Borrar",
		text:"¿Está Seguro de Eliminar Este Registro?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_tipo_cliente/CodTipCli/"+scope.fdatos_clientes.CodTipCli;
				$http.delete(url).then(function(result)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data!=false)
					{
						Swal.fire({title:"Exito!!",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.TVistaCliente=1;
						scope.cargar_lista_tipo_clientes();						
					}
					else
					{
						Swal.fire({title:"Error",text:"No hemos podido borrar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});	
					}
				},function(error)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}	
				});	          
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });
		
	}
	scope.validar_opcion_clientes=function(index,opciones_clientes,datos)
	{
		scope.opciones_clientes[index]=undefined;
		if(opciones_clientes==1)
		{
			scope.TVistaCliente=2;
			scope.fdatos_clientes=datos;
			scope.validate_cliente=1;
		}
		if(opciones_clientes==2)
		{
			scope.TVistaCliente=2;
			scope.fdatos_clientes=datos;
			scope.validate_cliente=undefined;
		}
	}
////////////////////////////////////////////////////////////////////////TIPO CLIENTE END///////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////TIPO SECTOR START///////////////////////////////////////////////////////////////////////////
	scope.cargar_lista_tipo_sector=function()
	{
		$("#cargando_lista").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Tipos/list_tipo_sector/";
		$http.get(url).then(function(result)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			if(result.data!=false)
			{
				$scope.predicate1 = 'id';  
				$scope.reverse1 = true;						
				$scope.currentPage1 = 1;  
				$scope.order1 = function (predicate1) 
				{  
					$scope.reverse1= ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
					$scope.predicate1 = predicate1;  
				}; 						
				scope.Tipo_Sector=result.data;					
				$scope.totalItems1 = scope.Tipo_Sector.length; 
				$scope.numPerPage1 = 50;  
				$scope.paginate1 = function (value1) 
				{  
					var begin1, end1, index1;  
					begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
					end1 = begin1 + $scope.numPerPage1;  
					index1 = scope.Tipo_Sector.indexOf(value1);  
					return (begin1 <= index1 && index1 < end1);  
				};				
				console.log(scope.Tipo_Sector);
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrado tipos de sectores registrados.",type:"error",confirmButtonColor:"#188ae2"});
				scope.Tipo_Sector=[];
			}
		},function(error)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.agg_sector=function()
	{
		scope.fdatos_sector={};
		scope.TVistaSector=2;
		scope.validate_sector=undefined;
	}
	scope.regresar_sector=function()
	{
		if(scope.validate_sector==undefined)
		{
			Swal.fire({title:"Regresar",
			text:"¿Está Seguro de Regresar y no completar el Proceso?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
			{
		        if(t.value==true)
		        {
		            scope.fdatos_sector={};
					scope.TVistaSector=1;
					scope.validate_sector=undefined;
					scope.cargar_lista_tipo_sector();
					return false;
		        }
		        else
		        {
					console.log('Cancelando Ando...');
					return false;							
		        }
		    });	
		}
		else
		{
			scope.fdatos_sector={};
			scope.TVistaSector=1;
			scope.validate_sector=undefined;
			scope.cargar_lista_tipo_sector();
		}			
	}
	$scope.submitFormSector = function(event) 
	{      
	 	console.log(scope.fdatos_sector);
	 	if(scope.fdatos_sector.CodSecCli>0)
		{
		 	var title='Actualizando';
		 	var text='¿Esta Seguro de Actualizar el Tipo de Sector?';
		 	var response="Tipo de Sector modificado satisfactoriamente.";
		}
		if(scope.fdatos_sector.CodSecCli==undefined)
		{
		 	var title='Guardando';
		 	var text='¿Está Seguro de Guardar El Nuevo Tipo de Sector?';
		 	var response="Tipo de Sector creado satisfactoriamente.";
		}
		if(scope.fdatos_sector.ObsSecCli==undefined||scope.fdatos_sector.ObsSecCli==null||scope.fdatos_sector.ObsSecCli=="")
		{
			scope.fdatos_sector.ObsSecCli=null;
		}
		else
		{
			scope.fdatos_sector.ObsSecCli=scope.fdatos_sector.ObsSecCli;
		}
	 	Swal.fire({title:title,
		text:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#"+title).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");				
				var url=base_urlHome()+"api/Tipos/crear_tipo_sector/";
				$http.post(url,scope.fdatos_sector).then(function(result)
				{
					scope.nIDSector=result.data.CodSecCli;
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(scope.nIDSector>0)
					{
						console.log(result.data);
						Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
						scope.buscarXID_Sector();										
					}
					else
					{
						Swal.fire({title:"Error",text:"Ha ocurrido un error durante el proceso, Por Favor Intente Nuevamente .",type:"error",confirmButtonColor:"#188ae2"});															
					}
				},function(error)
				{
					console.log(error);
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}					
				});	           
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });					
	};
	scope.buscarXID_Sector=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Tipos/buscar_xID_Tipo_Sector/CodSecCli/"+scope.nIDSector;
		$http.get(url).then(function(result)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{	
				scope.fdatos_sector=result.data;				
				console.log(scope.fdatos_sector);
			}
			else
			{
				Swal.fire({title:"Error",text:"Hubo un error al intentar cargar los datos.",type:"error",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			console.log(error);
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}			
		});
	}
	scope.limpiar_sector=function()
	{
		scope.fdatos_sector={};
	}
	scope.borrar_sector=function()
	{
		var event=true;
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		Swal.fire({title:"Borrar",
		text:"¿Está Seguro de Eliminar Este Registro?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Tipos/borrar_row_tipo_sector/CodSecCli/"+scope.fdatos_sector.CodSecCli;
				$http.delete(url).then(function(result)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data!=false)
					{
						Swal.fire({title:"Exito!!",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.TVistaSector=1;
						scope.cargar_lista_tipo_sector();						
					}
					else
					{
						Swal.fire({title:"Error",text:"No hemos podido borrar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});	
					}
				},function(error)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}	
				});	          
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });		
	}
	scope.validar_opcion_sector=function(index,opciones_sector,datos)
	{
		scope.opciones_sector[index]=undefined;
		if(opciones_sector==1)
		{
			scope.TVistaSector=2;
			scope.fdatos_sector=datos;
			scope.validate_sector=1;
		}
		if(opciones_sector==2)
		{
			scope.TVistaSector=2;
			scope.fdatos_sector=datos;
			scope.validate_sector=undefined;
		}
	}
////////////////////////////////////////////////////////////////////////TIPO SECTOR END///////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////TIPO CONTACTO START///////////////////////////////////////////////////////////////////////////
scope.cargar_lista_tipo_contacto=function()
{
		$("#cargando_lista").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Tipos/list_tipo_contacto/";
		$http.get(url).then(function(result)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			if(result.data!=false)
			{
				$scope.predicate2 = 'id';  
				$scope.reverse2 = true;						
				$scope.currentPage2 = 1;  
				$scope.order2 = function (predicate2) 
				{  
					$scope.reverse2= ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;  
					$scope.predicate2 = predicate2;  
				}; 						
				scope.Tipo_Contacto=result.data;					
				$scope.totalItems2 = scope.Tipo_Contacto.length; 
				$scope.numPerPage2 = 50;  
				$scope.paginate2 = function (value2) 
				{  
					var begin2, end2, index2;  
					begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
					end2 = begin2 + $scope.numPerPage2;  
					index2 = scope.Tipo_Contacto.indexOf(value2);  
					return (begin2 <= index2 && index2 < end2);  
				};				
				console.log(scope.Tipo_Contacto);
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrado tipos de contactos registrados.",type:"error",confirmButtonColor:"#188ae2"});
				scope.Tipo_Contacto=[];
			}
		},function(error)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.agg_contacto=function()
	{
		scope.fdatos_contacto={};
		scope.TVistaContacto=2;
		scope.validate_contacto=undefined;
	}
	scope.regresar_contacto=function()
	{
		if(scope.validate_contacto==undefined)
		{
			Swal.fire({title:"Regresar",
			text:"¿Está Seguro de Regresar y no completar el Proceso?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
			{
		        if(t.value==true)
		        {
		            scope.fdatos_contacto={};
					scope.TVistaContacto=1;
					scope.validate_contacto=undefined;
					scope.cargar_lista_tipo_contacto();
					return false;
		        }
		        else
		        {
					console.log('Cancelando Ando...');
					return false;							
		        }
		    });	
		}
		else
		{
			scope.fdatos_contacto={};
			scope.TVistaContacto=1;
			scope.validate_contacto=undefined;
			scope.cargar_lista_tipo_contacto();
		}			
	}
	$scope.submitFormContacto = function(event) 
	{      
	 	console.log(scope.fdatos_contacto);
	 	if(scope.fdatos_contacto.CodTipCon>0)
		{
		 	var title='Actualizando';
		 	var text='¿Esta Seguro de Actualizar el Tipo de Contacto?';
		 	var response="Tipo de Contacto modificado satisfactoriamente.";
		}
		if(scope.fdatos_contacto.CodTipCon==undefined)
		{
		 	var title='Guardando';
		 	var text='¿Está Seguro de Guardar El Nuevo Tipo de Contacto?';
		 	var response="Tipo de Contacto creado satisfactoriamente.";
		}
		if(scope.fdatos_contacto.ObsTipCon==undefined||scope.fdatos_contacto.ObsTipCon==null||scope.fdatos_contacto.ObsTipCon=="")
		{
			scope.fdatos_contacto.ObsTipCon=null;
		}
		else
		{
			scope.fdatos_contacto.ObsTipCon=scope.fdatos_contacto.ObsTipCon;
		}
	 	Swal.fire({title:title,
		text:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#"+title).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");				
				var url=base_urlHome()+"api/Tipos/crear_tipo_contacto/";
				$http.post(url,scope.fdatos_contacto).then(function(result)
				{
					scope.nIDContacto=result.data.CodTipCon;
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(scope.nIDContacto>0)
					{
						console.log(result.data);
						Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
						scope.buscarXID_Contacto();										
					}
					else
					{
						Swal.fire({title:"Error",text:"Ha ocurrido un error durante el proceso, Por Favor Intente Nuevamente .",type:"error",confirmButtonColor:"#188ae2"});															
					}
				},function(error)
				{
					console.log(error);
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}					
				});	           
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });					
	};
	scope.buscarXID_Contacto=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Tipos/buscar_xID_Tipo_Contacto/CodTipCon/"+scope.nIDContacto;
		$http.get(url).then(function(result)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{	
				scope.fdatos_contacto=result.data;				
				console.log(scope.fdatos_contacto);
			}
			else
			{
				Swal.fire({title:"Error",text:"Hubo un error al intentar cargar los datos.",type:"error",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			console.log(error);
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}			
		});
	}
	scope.limpiar_contacto=function()
	{
		scope.fdatos_contacto={};
	}
	scope.borrar_contacto=function()
	{
		var event=true;
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		Swal.fire({title:"Borrar",
		text:"¿Está Seguro de Eliminar Este Registro?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Tipos/borrar_row_tipo_contacto/CodTipCon/"+scope.fdatos_contacto.CodTipCon;
				$http.delete(url).then(function(result)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data!=false)
					{
						Swal.fire({title:"Exito!!",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.TVistaContacto=1;
						scope.cargar_lista_tipo_contacto();						
					}
					else
					{
						Swal.fire({title:"Error",text:"No hemos podido borrar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});	
					}
				},function(error)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}	
				});	          
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });		
	}
	scope.validar_opcion_contacto=function(index,opciones_contacto,datos)
	{
		scope.opciones_contacto[index]=undefined;
		if(opciones_contacto==1)
		{
			scope.TVistaContacto=2;
			scope.fdatos_contacto=datos;
			scope.validate_contacto=1;
		}
		if(opciones_contacto==2)
		{
			scope.TVistaContacto=2;
			scope.fdatos_contacto=datos;
			scope.validate_contacto=undefined;
		}
	}
////////////////////////////////////////////////////////////////////////TIPO CONTACTO END///////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////TIPO DOCUMENTOS START///////////////////////////////////////////////////////////////////////////

scope.cargar_lista_tipo_documentos=function()
{
		$("#cargando_lista").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Tipos/list_tipo_documentos/";
		$http.get(url).then(function(result)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			if(result.data!=false)
			{
				$scope.predicate3 = 'id';  
				$scope.reverse3 = true;						
				$scope.currentPage3 = 1;  
				$scope.order3 = function (predicate3) 
				{  
					$scope.reverse3= ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
					$scope.predicate3 = predicate3;  
				}; 						
				scope.Tipo_Documento=result.data;					
				$scope.totalItems3 = scope.Tipo_Documento.length; 
				$scope.numPerPage3 = 50;  
				$scope.paginate3 = function (value3) 
				{  
					var begin3, end3, index3;  
					begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
					end3 = begin3 + $scope.numPerPage3;  
					index3 = scope.Tipo_Documento.indexOf(value3);  
					return (begin3 <= index3 && index3 < end3);  
				};				
				console.log(scope.Tipo_Documento);
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrado documentos registrados.",type:"info",confirmButtonColor:"#188ae2"});
				scope.Tipo_Documento=[];
			}
		},function(error)
		{
			$("#cargando_lista").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.agg_documentos=function()
	{
		scope.fdatos_documento={};
		scope.fdatos_documento.EstReq=false;
		scope.TVistaDocumentos=2;
		scope.validate_documento=undefined;
	}
	scope.regresar_documento=function()
	{
		if(scope.validate_documento==undefined)
		{
			Swal.fire({title:"Regresar",
			text:"¿Está Seguro de Regresar y no completar el Proceso?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
			{
		        if(t.value==true)
		        {
		            scope.fdatos_documento={};
					scope.TVistaDocumentos=1;
					scope.validate_documento=undefined;
					scope.cargar_lista_tipo_documentos();
					return false;
		        }
		        else
		        {
					console.log('Cancelando Ando...');
					return false;							
		        }
		    });	
		}
		else
		{
			scope.fdatos_documento={};
			scope.TVistaDocumentos=1;
			scope.validate_documento=undefined;
			scope.cargar_lista_tipo_documentos();
		}			
	}
	$scope.submitFormDocumentos = function(event) 
	{      
	 	console.log(scope.fdatos_documento);
	 	if(scope.fdatos_documento.CodTipDoc>0)
		{
		 	var title='Actualizando';
		 	var text='¿Esta Seguro de Actualizar el Tipo de Documento?';
		 	var response="Tipo de Documento modificado satisfactoriamente.";
		}
		if(scope.fdatos_documento.CodTipDoc==undefined)
		{
		 	var title='Guardando';
		 	var text='¿Está Seguro de Guardar El Nuevo Tipo de Documento?';
		 	var response="Tipo de Documento creado satisfactoriamente.";
		}
		if(scope.fdatos_documento.ObsTipDoc==undefined||scope.fdatos_documento.ObsTipDoc==null||scope.fdatos_documento.ObsTipDoc=="")
		{
			scope.fdatos_documento.ObsTipDoc=null;
		}
		else
		{
			scope.fdatos_documento.ObsTipDoc=scope.fdatos_documento.ObsTipDoc;
		}
	 	Swal.fire({title:title,
		text:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#"+title).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");				
				var url=base_urlHome()+"api/Tipos/crear_tipo_documento/";
				$http.post(url,scope.fdatos_documento).then(function(result)
				{
					scope.nIDDocumentos=result.data.CodTipDoc;
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(scope.nIDDocumentos>0)
					{
						console.log(result.data);
						Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
						scope.buscarXID_Documentos();										
					}
					else
					{
						Swal.fire({title:"Error",text:"Ha ocurrido un error durante el proceso, Por Favor Intente Nuevamente .",type:"error",confirmButtonColor:"#188ae2"});															
					}
				},function(error)
				{
					console.log(error);
					$("#"+title).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}					
				});	           
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });					
	};
	scope.buscarXID_Documentos=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Tipos/buscar_xID_Tipo_Documento/CodTipDoc/"+scope.nIDDocumentos;
		$http.get(url).then(function(result)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{	
				scope.fdatos_documento=result.data;	
				if(result.data.EstReq==0)
				{
					scope.fdatos_documento.EstReq=false;
				}
				else
				{
					scope.fdatos_documento.EstReq=true;
				}			
				console.log(scope.fdatos_documento);
			}
			else
			{
				Swal.fire({title:"Error",text:"Hubo un error al intentar cargar los datos.",type:"error",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			console.log(error);
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}			
		});
	}
	scope.limpiar_documento=function()
	{
		scope.fdatos_documento={};
	}
	scope.borrar_documento=function()
	{
		var event=true;
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		Swal.fire({title:"Borrar",
		text:"¿Está Seguro de Eliminar Este Registro?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	        	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Tipos/borrar_row_tipo_documento/CodTipDoc/"+scope.fdatos_documento.CodTipDoc;
				$http.delete(url).then(function(result)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data!=false)
					{
						Swal.fire({title:"Exito!!",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.TVistaDocumentos=1;
						scope.cargar_lista_tipo_documentos();						
					}
					else
					{
						Swal.fire({title:"Error",text:"No hemos podido borrar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});	
					}
				},function(error)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}	
				});	          
	        }
	        else
	        {
				event.preventDefault();				
	        }
	    });		
	}
	scope.validar_opcion_documentos=function(index,opciones_documento,datos)
	{
		scope.opciones_documento[index]=undefined;
		if(opciones_documento==1)
		{
			scope.TVistaDocumentos=2;
			scope.fdatos_documento=datos;
			if(datos.EstReq=="NO")
			{
				scope.fdatos_documento.EstReq=false;
			}
			if(datos.EstReq=="SI")
			{
				scope.fdatos_documento.EstReq=true;
			}
			scope.validate_documento=1;
		}
		if(opciones_documento==2)
		{
			scope.TVistaDocumentos=2;
			scope.fdatos_documento=datos;
			if(datos.EstReq=="NO")
			{
				scope.fdatos_documento.EstReq=false;
			}
			if(datos.EstReq=="SI")
			{
				scope.fdatos_documento.EstReq=true;
			}
			scope.validate_documento=undefined;
		}
	}

////////////////////////////////////////////////////////////////////////TIPO DOCUMENTOS END///////////////////////////////////////////////////////////////////////////
	
}			