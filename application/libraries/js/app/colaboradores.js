app.controller('Controlador_Colaboradores', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','ServiceCodPro','ServiceTipoVias','ServiceCodLoc', Controlador])
.directive('stringToNumber', function() 
{
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value; 
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value);
      });
    }
  };
})
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,ServiceCodPro,ServiceTipoVias,ServiceCodLoc)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;	//contiene el id del registro en caso de estarse consultando desde la grid	
	scope.Nivel = $cookies.get('nivel');
	scope.CIF = $cookies.get('CIF');
	scope.tColaboradores=undefined;
	scope.tColaboradoresBack=undefined;	
	scope.index=0;
	scope.tTipoColaborador = [{CodTipCol: 1, DesTipCol: 'Persona'},{CodTipCol: 2, DesTipCol: 'Empresa'}];
	scope.tEstColaborador = [{id: 1, nombre: 'Activo'},{id: 2, nombre: 'Bloqueado'}];
	resultado = false;
	if($route.current.$$route.originalPath=="/Colaboradores/")
	{
		scope.fdatos.NumIdeFis=true;
		scope.fdatos.NomCol=true;
		scope.fdatos.TelCelCol=true;
		scope.fdatos.EmaCol=true;
		scope.fdatos.EstCol=true;
		scope.fdatos.AccCol=true;	
	}
	
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
	scope.FecIniAct = fecha;
	ServiceCodPro.getAll().then(function(dato) 
	{
		scope.tProvidencias = dato;
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});	
	ServiceTipoVias.getAll().then(function(dato) 
	{
		scope.tTiposVias = dato;			
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
	ServiceCodLoc.getAll().then(function(dato) 
	{
		scope.tLocalidades = dato;
		scope.tLocalidadesBack = dato;								
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});	

	$scope.submitForm = function(event) 
	{      
	 	//console.log(scope.fdatos);
	 	if(scope.nID>0 && scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.validar_campos())
		{
			return false;
		}
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

	scope.validar_campos = function()
	{
		resultado = true;
		if (!scope.fdatos.TipCol > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Colaborador.",type:"error",confirmButtonColor:"#188ae2"});	       
			return false;
		}
		if (scope.fdatos.NumIdeFis==null || scope.fdatos.NumIdeFis==undefined || scope.fdatos.NumIdeFis=='')
		{
			Swal.fire({title:"El Campo CIF o NIF es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		    
			return false;
		}
		if (scope.fdatos.NomCol==null || scope.fdatos.NomCol==undefined || scope.fdatos.NomCol=='')
		{
			Swal.fire({title:"El Campo Nombre es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		   
			return false;
		}
		if (!scope.fdatos.CodTipVia > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Via.",type:"error",confirmButtonColor:"#188ae2"});	       
			return false;
		}
		if (scope.fdatos.NomViaDir==null || scope.fdatos.NomViaDir==undefined || scope.fdatos.NomViaDir=='')
		{
			Swal.fire({title:"El Campo Nombre del Domicilio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		  
			return false;
		}		
		if (scope.fdatos.NumViaDir==null || scope.fdatos.NumViaDir==undefined || scope.fdatos.NumViaDir=='')
		{
			Swal.fire({title:"El Campo Número del Domicilio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		    
			return false;
		}
		if (!scope.fdatos.CodPro > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Provincia.",type:"error",confirmButtonColor:"#188ae2"});	        
			return false;
		}
		if (!scope.fdatos.CodLoc > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Localidad.",type:"error",confirmButtonColor:"#188ae2"});	       
			return false;
		}
		if (scope.fdatos.TelCelCol==null || scope.fdatos.TelCelCol==undefined || scope.fdatos.TelCelCol=='')
		{
			Swal.fire({title:"El Campo Teléfono es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.EstCol > 0)
		{
			Swal.fire({title:"Debe Asignarle un Estatus al Colaborador.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (resultado == false)
		{
			return false;
		} 
		return true;
	} 
	scope.guardar=function()
	{		
		$("#crear_colaborador").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		if(scope.fdatos.TelFijCol==undefined||scope.fdatos.TelFijCol==null||scope.fdatos.TelFijCol=='')
		{
			scope.fdatos.TelFijCol=null;
		}
		else
		{
			scope.fdatos.TelFijCol=scope.fdatos.TelFijCol;
		}
		if(scope.fdatos.EmaCol==undefined||scope.fdatos.EmaCol==null||scope.fdatos.EmaCol=='')
		{
			scope.fdatos.EmaCol=null;
		}
		else
		{
			scope.fdatos.EmaCol=scope.fdatos.EmaCol;
		}
		if(scope.fdatos.PorCol==undefined||scope.fdatos.PorCol==null||scope.fdatos.PorCol=='')
		{
			scope.fdatos.PorCol=null;
		}
		else
		{
			scope.fdatos.PorCol=scope.fdatos.PorCol;
		}
		if(scope.fdatos.ObsCol==undefined||scope.fdatos.ObsCol==null||scope.fdatos.ObsCol=='')
		{
			scope.fdatos.ObsCol=null;
		}
		else
		{
			scope.fdatos.ObsCol=scope.fdatos.ObsCol;
		}
		if(scope.fdatos.BloDir==undefined||scope.fdatos.BloDir==null||scope.fdatos.BloDir=='')
		{
			scope.fdatos.BloDir=null;
		}
		else
		{
			scope.fdatos.BloDir=scope.fdatos.BloDir;
		}
		if(scope.fdatos.EscDir==undefined||scope.fdatos.EscDir==null||scope.fdatos.EscDir=='')
		{
			scope.fdatos.EscDir=null;
		}
		else
		{
			scope.fdatos.EscDir=scope.fdatos.EscDir;
		}
		if(scope.fdatos.PlaDir==undefined||scope.fdatos.PlaDir==null||scope.fdatos.PlaDir=='')
		{
			scope.fdatos.PlaDir=null;
		}
		else
		{
			scope.fdatos.PlaDir=scope.fdatos.PlaDir;
		}
		if(scope.fdatos.PueDir==undefined||scope.fdatos.PueDir==null||scope.fdatos.PueDir=='')
		{
			scope.fdatos.PueDir=null;
		}
		else
		{
			scope.fdatos.PueDir=scope.fdatos.PueDir;
		}
		console.log(scope.fdatos);
		var url=base_urlHome()+"api/Configuraciones_Generales/crear_colaborador/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			scope.nID=result.data.CodCol;
			if(scope.nID>0)
			{			
				$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				
				
				bootbox.alert({
				message: "Colaborador Creado satisfactoriamente.",				
				size: 'middle'});
				scope.buscarXID();				
			}
			else
			{
				$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "ha ocurrido un error intentando guardar por favor intente nuevamente.",
				size: 'middle'});				
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.buscarXID=function()
	{		
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");			
		var url=base_urlHome()+"api/Configuraciones_Generales/get_colaborador_data/CodCol/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{			
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				scope.fdatos=result.data;
				scope.filtrarLocalidad();
				/*$("#crear_colaborador").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Colaborador Creado satisfactoriamente.",				
				size: 'middle'});
				scope.buscarXID();*/				
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Ha ocurrido un error al cargar los datos.",
				size: 'middle'});				
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

	scope.validarsiletras=function(object)
	{
		if(object!=undefined)
		{
			letras=object;		
			if(!/^([0-9a-zA-Z])*$/.test(letras))
			scope.fdatos.NumIdeFis=letras.substring(0,letras.length-1);
		}
	}

	scope.validarsinuermotelefonofijo=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([+0-9])*$/.test(numero))
			scope.fdatos.TelFijCol=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsinuermotelefonocel=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([+0-9])*$/.test(numero))
			scope.fdatos.TelCelCol=numero.substring(0,numero.length-1);
		}
	}

	scope.validarsinuermo=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos.PorCol=numero.substring(0,numero.length-1);
		}
	}
	scope.cargar_lista_colaboradores=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Configuraciones_Generales/list_colaboradores/";
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
				scope.tColaboradores=result.data;
				scope.tColaboradoresBack=result.data;					
				$scope.totalItems = scope.tColaboradores.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.tColaboradores.indexOf(value);  
					return (begin <= index && index < end);  
				};	
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "No hemos encontrado colaboradores registrados.",
				size: 'middle'});
				scope.tColaboradores=undefined;
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
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_colaboradores/CodCol/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});
						scope.tColaboradores.splice(index,1);
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
				var url = base_urlHome()+"api/Configuraciones_Generales/borrar_row_colaboradores/CodCol/"+scope.fdatos.CodCol;
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

	}
	scope.filtrar_zona_postal =  function()
	{
		scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, {CodLoc: scope.fdatos.CodLoc}, true);
		angular.forEach(scope.CodLocZonaPostal, function(data)
		{					
			scope.fdatos.CPLoc=data.CPLoc;						
		});
	}
	if(scope.nID!=undefined)
	{
		scope.buscarXID();
		//scope.funcion_services();
	}	
}			