app.controller('Controlador_Tarifa_Electrica', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;	  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.Tarifa_Electrica=undefined;
	scope.Tarifa_ElectricaBack=undefined;
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
	var fecha = dd+'/'+mm+'/'+yyyy;
	if($route.current.$$route.originalPath=='/Tarifa_Electrica/')
	{
		scope.TipTen=true;
		scope.NomTarEle=true;
		scope.CanPerTar=true;
		scope.MinPotCon=true;
		scope.MaxPotCom=true;
		scope.AccTarElec=true;
	}	
	console.log($route.current.$$route.originalPath);
	if($route.current.$$route.originalPath=='/Add_Tarifa_Electrica/'||$route.current.$$route.originalPath=='/Edit_Tarifa_Electrica/:ID')
	{
		scope.tension = [{id: 0, nombre: 'BAJA'},{id: 1, nombre: 'ALTA'}];
	}
	$scope.submitForm = function(event) 
	{
	 	if(scope.fdatos.CodTarEle==undefined)
	 	{
	 		var titulo='Guardando';
	 		var titulo2='Guardar';
	 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	 	}
	 	else
	 	{
	 		var titulo='Actualizando';
	 		var titulo2='Actualizar';
	 		var texto='¿Esta Seguro de Actualizar este registro.?';
	 	}
	 	console.log(scope.fdatos);
	 	Swal.fire({title:titulo,
		text:texto,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	var url=base_urlHome()+"api/Configuraciones_Generales/crear_tarifa_electrica/";
				$http.post(url,scope.fdatos).then(function(result)
				{
					scope.nID=result.data.CodTarEle;
					if(result.data!=false)
					{
						Swal.fire({title:titulo,text:"Registro "+titulo2+ " Con Exito.",type:"info",confirmButtonColor:"#188ae2"});
						scope.buscarXID();
					}
					else
					{
						Swal.fire({title:titulo,text:"No hemos podido "+titulo2+" este registro intente nuevamente",type:"error",confirmButtonColor:"#188ae2"});
						
					}
				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
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
	            console.log('Cancelando ando...');
	        }
	        });		
	};

	scope.cargar_lista_Tarifa_Electrica=function()
	{
		 $("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Configuraciones_Generales/get_list_tarifa_electricas";
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
					scope.Tarifa_Electrica =result.data;
					scope.Tarifa_ElectricaBack =result.data; 	 								
					$scope.totalItems = scope.Tarifa_Electrica.length; 
					$scope.numPerPage = 50;  
					$scope.paginate = function (value) 
					{  
						var begin, end, index;  
						begin = ($scope.currentPage - 1) * $scope.numPerPage;  
						end = begin + $scope.numPerPage;  
						index = scope.Tarifa_Electrica.indexOf(value);  
						return (begin <= index && index < end);  
					};
				}
				else
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Tarifas Electrica.",text:"No hemos encontrado Tarifas Electrica Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
					scope.Tarifa_Electrica=undefined;
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});	
	}
	scope.borrar=function()
	{	
		if(scope.Nivel!=1)
		{
			Swal.fire({title:"Error",text:"Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
			
		}		
		Swal.fire({title:"Esta seguro de eliminar este registro.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	          	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	          	var url = base_urlHome()+"api/Configuraciones_Generales/borrar_tarifa_electrica/CodTarEle/"+scope.fdatos.CodTarEle;
	          	$http.delete(url).then(function(result)
	          	{
	          		if(result.data!=false)
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Exito!",text:"Registro Eliminado Correctamente.",type:"error",confirmButtonColor:"#188ae2"});
						location.href="#/Tarifa_Electrica/";
	          		}
	          		else
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"No se pudo eliminar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	          		}

	          	},function(error)
	          	{
	          		if(error.status==404 && error.statusText=="Not Found")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}
	          	});
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });		
	}
scope.borrar_row=function(index,id)
	{
		if(scope.Nivel!=1)
		{
			Swal.fire({title:"Error",text:"Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
			
		}
		Swal.fire({title:"Esta seguro de eliminar este registro.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	         	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_tarifa_electrica/CodTarEle/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"Registro Eliminado Correctamente.",type:"error",confirmButtonColor:"#188ae2"});
						scope.Tarifa_Electrica.splice(index,1);
					}
					else
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"No hemos podido borrar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});						
					}
				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}
				}); 
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });		
		
	}
	scope.validar_numeros=function(metodo,object)
	{		
		if(metodo==1)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos.CanPerTar=numero.substring(0,numero.length-1);
			}
		}
		if(metodo==2)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos.MinPotCon=numero.substring(0,numero.length-1);
			}
		}
		if(metodo==3)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos.MaxPotCon=numero.substring(0,numero.length-1);
			}
		}
	}
	scope.limpiar=function()
	{	
		if(scope.nID>0)
		{
		 	location.href="#/Tarifa_Electrica/";
		}
		scope.fdatos={};
	}
	scope.buscarXID=function()
	{
		 $("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/buscar_XID_TarEle/CodTarEle/"+scope.nID;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		scope.fdatos=result.data;		 				
				console.log(scope.fdatos);
		 	}
		 	else
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos encontrado datos relacionados con este código.",type:"error",confirmButtonColor:"#188ae2"});
		 	}
		 },function(error)
		 {
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });

	}
	if(scope.nID!=undefined) 
	{
		scope.buscarXID();		
	}
}			