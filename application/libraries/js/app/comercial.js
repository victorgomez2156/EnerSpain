app.controller('Controlador_Comercial', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies)
{
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.TComercial=[];
	scope.TComercialBack=[];
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


	scope.ruta_reportes_pdf_comercial=0;
	scope.ruta_reportes_excel_comercial=0;
	scope.NomCom=true;
	scope.NIFCom=true;
	scope.TelFijCom=true;
	scope.TelCelCom=true;
	scope.EmaCom=true;
	scope.EstCom=true;
	scope.AccCom=true;
	scope.topciones = [{id: 1, nombre: 'VER'},{id: 2, nombre: 'EDITAR'},{id: 3, nombre: 'ACTIVAR'},{id: 4, nombre: 'BLOQUEAR'}];
	console.log($route.current.$$route.originalPath);
	if($route.current.$$route.originalPath=="/Editar_Comercial/:ID/:INF")
	{
		scope.validate_form = $route.current.params.INF;
		if(scope.validate_form!=1)
		{
			location.href="#/Comercial";
		}
		
	}
	if($route.current.$$route.originalPath=="/Agregar_Comercial/")
	{
		scope.CIF_COMERCIAL = $cookies.get('CIF_COMERCIAL');
		if(scope.CIF_COMERCIAL==undefined)
		{
			location.href="#/Comercial";
		}
		else
		{
			scope.fdatos.NIFCom=scope.CIF_COMERCIAL;
		}
	}
	
	$scope.submitForm = function(event) 
	{      
	 	console.log(scope.fdatos);
	 	if(scope.fdatos.CodCom>0)
		{
			var title='Actualizando';
			var text='¿Esta Seguro de Actualizar Este Comercial?';
			var response="Los datos del Comercial Fueron Actualizados Correctamente.";
		}
		if(scope.fdatos.CodCom==undefined)
		{
			$cookies.remove('CIF_COMERCIAL');
			var title='Guardando';
			var text='¿Esta Seguro de Incluir Este Comercial?';
			var response="Comercial creado satisfactoriamente.";
		}
	 	Swal.fire({title:title,text:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	          	$("#crear_comercial").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
				var url=base_urlHome()+"api/Comercial/crear_comercial/";
				$http.post(url,scope.fdatos).then(function(result)
				{
					scope.nID=result.data.CodCom;			
					$("#crear_comercial").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(scope.nID>0)
					{
						console.log(result.data);						
						Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
						location.href="#/Editar_Comercial/"+scope.nID;
						//scope.buscarXID();				
					}
					else
					{
						Swal.fire({title:"Error",text:"Ha ocurrido durante el proceso, Por Favor Intente Nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					}
				},function(error)
				{
					$("#crear_comercial").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
	            console.log('Cancelando ando...');
	                
	        }
	    });					
	};
	$scope.Consultar_DNI_NIE= function(event) 
	{ 	
		$("#comprobando_dni").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		var url=base_urlHome()+"api/Comercial/comprobar_dni_nie/NIFComCon/"+scope.fdatos.NumDNI_NIECli;
		$http.get(url).then(function(result)
		{
			$("#comprobando_dni").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{
				Swal.fire({title:'DNI/NIE',text:"El Comercial ya se encuentra registrado.",type:"error",confirmButtonColor:"#188ae2"});
				return false;							
			}
			else
			{
				$("#modal_dni_comprobar").modal('hide'); 
				$cookies.put('CIF_COMERCIAL',scope.fdatos.NumDNI_NIECli);
				location.href="#/Agregar_Comercial/";
				Swal.fire({title:"Disponible",text:"El Número de DNI/NIE Esta Disponible.",type:"success",confirmButtonColor:"#188ae2"});
			}
		},function(error)
		{
			$("#comprobando_dni").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
	};
	$scope.SubmitFormFiltrosComercial= function(event) 
	{ 	
		if(scope.tmodal_data.tipo_filtro==1)
		{
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.TComercial=$filter('filter')(scope.TComercialBack, {EstCom: scope.tmodal_data.EstCom}, true);				
			$scope.totalItems = scope.TComercial.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.TComercial.indexOf(value);  
				return (begin <= index && index < end);  
			};
			scope.ruta_reportes_pdf_comercial=scope.tmodal_data.tipo_filtro+"/"+scope.tmodal_data.EstCom;
			scope.ruta_reportes_excel_comercial=scope.tmodal_data.tipo_filtro+"/"+scope.tmodal_data.EstCom;	
		}            
	};
	scope.regresar_filtro_comercial=function()
	{
		$scope.predicate = 'id';  
		$scope.reverse = true;						
		$scope.currentPage = 1;  
		$scope.order = function (predicate) 
		{  
			$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
			$scope.predicate = predicate;  
		}; 						
		scope.TComercial=scope.TComercialBack;			
		$scope.totalItems = scope.TComercial.length; 
		$scope.numPerPage = 50;  
		$scope.paginate = function (value) 
		{  
			var begin, end, index;  
			begin = ($scope.currentPage - 1) * $scope.numPerPage;  
			end = begin + $scope.numPerPage;  
			index = scope.TComercial.indexOf(value);  
			return (begin <= index && index < end);  
		};
		scope.tmodal_data={};
		scope.ruta_reportes_pdf_comercial=0;
		scope.ruta_reportes_excel_comercial=0;	
	}
	scope.cargar_lista_comercial=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Comercial/list_comercial/";
		$http.get(url).then(function(result)
		{			
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
				scope.TComercial=result.data;
				scope.TComercialBack=result.data;					
				$scope.totalItems = scope.TComercial.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.TComercial.indexOf(value);  
					return (begin <= index && index < end);  
				};				
				console.log(scope.TComercial);
			}
			else
			{
				Swal.fire({title:"Error",text:"No hemos encontrado Comerciales Registrados.",type:"error",confirmButtonColor:"#188ae2"});				
				scope.TComercial=undefined;
			}
		},function(error)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
	scope.limpiar=function()
	{		
		if(scope.fdatos.CodCom==undefined)
		{
			scope.fdatos={};
			scope.fdatos.NIFCom=scope.CIF_COMERCIAL;
		}
		else
		{
			console.log('Nada Que Limpiar');
		}		
	}
	scope.regresar=function()
	{
		if(scope.fdatos.CodCom==undefined)
		{			
			Swal.fire({title:"¿Esta seguro de regresar?",			
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"OK"}).then(function(t)
			{
	          if(t.value==true)
	          {
	              	$cookies.remove('CIF_COMERCIAL');
	              	location.href="#/Comercial/";
	          }
	          else
	          {
	               console.log('Cancelando ando...');	                
	          }
	       });	
		}
		else
		{
			$cookies.remove('CIF_COMERCIAL');
			scope.fdatos={};
			location.href="#/Comercial/";	
		}
	}	

scope.modal_agg_comercial=function()
{
	scope.fdatos={};
	$("#modal_dni_comprobar").modal('show');
}
	scope.buscarXID=function()
	{
		$("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Comercial/buscar_xID_Comercial/CodCom/"+scope.nID;
		$http.get(url).then(function(result)
		{
			$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{
				scope.fdatos=result.data;				
				console.log(scope.fdatos);
			}
			else
			{
				Swal.fire({title:"Error",text:"Hubo un error al intentar cargar los datos.",type:"error",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
				var url = base_urlHome()+"api/Comercial/borrar_row_comercial/CodCom/"+id;
				$http.delete(url).then(function(result)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data!=false)
					{
						Swal.fire({title:"Exito!!",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.TComercial.splice(index,1);
					}
					else
					{
						Swal.fire({title:"Error",text:"Error Al Borrar el Registro.",type:"error",confirmButtonColor:"#188ae2"});	
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
				var url = base_urlHome()+"api/Comercial/borrar_row_comercial/CodCom/"+scope.fdatos.CodCom;
				$http.delete(url).then(function(result)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data!=false)
					{
						Swal.fire({title:"Exito!!",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						location.href="#/Comercial";
					}
					else
					{
						Swal.fire({title:"Error",text:"Error Al Borrar el Registro.",type:"error",confirmButtonColor:"#188ae2"});	
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
		}});
	}	
	scope.validar_opcion=function(index,opcion,datos)
	{
		if(opcion==1)
		{
			location.href ="#/Editar_Comercial/"+datos.CodCom+"/"+1;
		}
		if(opcion==2)
		{
	        location.href ="#/Editar_Comercial/"+datos.CodCom;
		}
		if(opcion==3)
		{
			//console.log(datos);
			scope.opciones_comercial[index]=undefined;
			if(datos.EstCom==1)
			{				
				Swal.fire({title:"Error!.",text:"Ya este Comercial se encuentra activo.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			Swal.fire({title:"¿Esta Seguro de Activar Este Comercial?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
	               	scope.datos_update={};
					scope.datos_update.EstCom=1;
					scope.datos_update.CodCom=datos.CodCom;
					console.log(scope.datos_update);
					var url = base_urlHome()+"api/Comercial/update_status/";
					$http.post(url,scope.datos_update).then(function(result)
					{
						if(result.data!=false)
						{
							Swal.fire({title:"Exito!.",text:"El Comercial ha sido activado correctamente.",type:"success",confirmButtonColor:"#188ae2"});
							scope.cargar_lista_comercial();
							scope.opciones_comercial[index]=undefined;
						}
						else
						{
							Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
							scope.cargar_lista_comercial();
						}
					},function(error)
					{	
						//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
	                console.log('Cancelando ando...');
	                scope.opciones_comercial[index]=undefined;
	            }
	        });

		}
		if(opcion==4)
		{
			scope.opciones_comercial[index]=undefined;			
			if(datos.EstCom==2)
			{
				Swal.fire({title:"Error!.",text:"Ya este Comercial se encuentra bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			scope.datos_update={};
			scope.datos_update.CodCom=datos.CodCom;
			scope.NIFCom=datos.NIFCom;			
			scope.NomCom=datos.NomCom;  
			scope.FechBloCom=fecha;   
			scope.datos_update.EstCom=2;      	
	        $("#modal_motivo_bloqueo").modal('show'); 
		}	
	}
	$scope.submitFormlock = function(event) 
	{      
	 	console.log(scope.datos_update);	 	
	 	Swal.fire({title:'BLOQUEAR',text:"¿Está Seguro de Bloquear Este Comercial?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	          	$("#bloqueando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
				var url=base_urlHome()+"api/Comercial/update_status/";
				$http.post(url,scope.datos_update).then(function(result)
				{		
					$("#bloqueando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					if(result.data.resultado!=false)
					{
						console.log(result.data);	
						scope.datos_update={};	
						Swal.fire({title:"Exito",text:"Comercial Bloqueado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});			
						$("#modal_motivo_bloqueo").modal('hide');
						scope.cargar_lista_comercial();
					}
					else
					{
						Swal.fire({title:"Error",text:"Ha ocurrido durante el proceso, Por Favor Intente Nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					}
				},function(error)
				{
					$("#bloqueando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
	            console.log('Cancelando ando...');
	                
	        }
	    });					
	};	
	if(scope.nID!=undefined)
	{
		scope.buscarXID();
	}
	
}			