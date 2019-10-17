app.controller('Controlador_Comercializadora', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','ServiceProvincias','ServiceLocalidades','ServiceTipoViasCom','upload', Controlador])
.directive('uploaderModel', ["$parse", function ($parse) 
{
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) 
		{
			iElement.on("change", function(e)
			{
				$parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
			});
		}
	};
}])
.service('upload', ["$http", "$q", function ($http, $q) 
{
	this.uploadFile = function(file, name)
	{
		var deferred = $q.defer();
		var formData = new FormData();
		//formData.append("name", name);
		formData.append("file", file);
		return $http.post("server.php", formData, {
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
}])
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,ServiceProvincias,ServiceLocalidades,ServiceTipoViasCom,upload)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;	  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.CIF_COM = $cookies.get('CIF_COM');
	scope.Tcomercializadoras=undefined;
	scope.TcomercializadorasBack=undefined;
	scope.INF = $route.current.params.INF;
	const $archivos = document.querySelector("#file");
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
	
	console.log($route.current.$$route.originalPath);
	scope.services_filtros=function()
	{
		ServiceProvincias.getAll().then(function(dato) 
		{
			scope.TProvincias = dato;		
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});	
		
		ServiceLocalidades.getAll().then(function(dato) 
		{
			scope.tLocalidades = dato;	

		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});	
	}
	scope.services_add_edit=function()
	{
		ServiceProvincias.getAll().then(function(dato) 
		{
			scope.TProvincias = dato;		
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});	
		
		ServiceLocalidades.getAll().then(function(dato) 
		{
			scope.tLocalidades = dato;							
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});	
		ServiceTipoViasCom.getAll().then(function(dato) 
		{
			scope.tTiposVias = dato;								
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});	
	}
	if($route.current.$$route.originalPath=="/Add_Comercializadora/")
	{
		if(scope.CIF_COM==undefined)
		{
			//Swal.fire({title:"Error.",text:"El Número de CIF no estar vacio sera regresado a la pantalla de Comercializadoras.",type:"error",confirmButtonColor:"#188ae2"})
			scope.validate_cif=1;
			scope.validate_form=1;
			location.href="#/Comercializadora/";
		}
		else
		{
			scope.validate_cif=1;			
			scope.fdatos.misma_razon=false
			scope.fdatos.NumCifCom=scope.CIF_COM;
			scope.FecIniCom = fecha;	
			scope.fdatos.SerEle=false;
			scope.fdatos.SerGas=false;
			scope.fdatos.SerEsp=false;	
			scope.fdatos.RenAutConCom=false;
			scope.services_add_edit();
		}
	}
	if($route.current.$$route.originalPath=="/Comercializadora/")
	{
		scope.Acc=true;
		scope.RazSocCom=true;
		scope.NumCifCom=true;
		scope.NomViaDirCom=true;
		scope.ProDirCom=true;
		scope.CodLoc=true;
		//scope.TelFijCom=true;
		//scope.EmaCom=true;
		scope.validate_cif==1
		resultado = false;
		scope.EstCom=true;
		//scope.CodTipVia=true;
		scope.Topciones_comercializadoras = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
		scope.ttipofiltros = [{id: 1, nombre: 'TIPO DE SERVICIO'},{id: 2, nombre: 'PROVINCIA'},{id: 3, nombre: 'LOCALIDAD'},{id: 4, nombre: 'ESTATUS'}];
		scope.EstComFil = [{id: 1, nombre: 'ACTIVA'},{id: 2, nombre: 'BLOQUEADA'}];
		scope.services_filtros();
	}
	
	if($route.current.$$route.originalPath=="/Edit_Comercializadora/:ID/:INF" || $route.current.$$route.originalPath=="/Edit_Comercializadora/:ID" )
	{
		scope.validate_info=1;
		scope.services_add_edit();
		scope.Topciones_productos = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
		scope.Topciones_Anexos = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
		scope.CodTCom=true;
		scope.DesTPro=true;
		scope.SerTGas=true;
		scope.SerTEle=true;
		scope.EstTPro=true;
		scope.AccTPro=true;
		scope.TvistaProductos=1;
		scope.TvistaAnexos=1;
	}

	$scope.uploadFile = function()
	{
		var file = $scope.file;
		upload.uploadFile(file, name).then(function(res)
		{ 
			console.log(res);
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				bootbox.alert({
				message: "El método que está intentando usar no puede ser localizado",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				bootbox.alert({
				message: "Usted no tiene acceso a este controlador",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				bootbox.alert({
				message: "Actualmente estamos prensentado fallas en el servidor, por favor intente mas tarde",
				size: 'middle'});
			}
		});
	}
	
	$scope.submitForm = function(event) 
	{      
	 	
	 	if(scope.fdatos.CodCom==undefined)
	 	{
	 		var titulo='Guardando';
	 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	 	}
	 	else
	 	{
	 		var titulo='Actualizando';
	 		var texto='¿Esta Seguro de Actualizar este registro.?';
	 	}
		if (!scope.validar_campos_datos_basicos())
		{
			return false;
		}
		
		let archivos = $archivos.files;
	 	if($archivos.files.length>0)
	 	{	
	 		console.log($archivos.files);
		 	if($archivos.files[0].type=="application/pdf" || $archivos.files[0].type=="image/jpeg" || $archivos.files[0].type=="image/png")
		 	{
		 		console.log('Archivo Permitido');
		 		var tipo_file=($archivos.files[0].type).split("/");$archivos.files[0].type;
		 		console.log(tipo_file[1]);		 		
		 		$scope.uploadFile();
				scope.fdatos.DocConCom='documentos/'+$archivos.files[0].name;
		 	}
		 	else	 	
		 	{
		 		console.log('Archivo No Permitido');
		 		Swal.fire({title:'Error',text:"Formato incorrecto solo se permite archivos PDF, JPG o PNG.",type:"error",confirmButtonColor:"#188ae2"});		 		
				document.getElementById('file').value ='';
				return false;
			}
	 	}
	 	scope.validar_campos_nulos();
		if(scope.FecConCom!=undefined && scope.FecVenConCom!=undefined)
		{
			var hora3 = (scope.FecVenConCom).split("/"),
	   		hora4 =(scope.FecConCom).split("/"),
	   		t3 = new Date(),
	    	t4 = new Date();
	    	scope.fdatos.FecConCom=hora4[2]+"-"+hora4[1]+"-"+hora4[0];
	    	scope.fdatos.FecVenConCom=hora3[2]+"-"+hora3[1]+"-"+hora3[0];
		}
		console.log(scope.fdatos);
	 	Swal.fire({title:titulo,
		text:texto,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Confirmar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	    $("#"+titulo).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
	           	    var url = base_urlHome()+"api/Configuraciones_Generales/registrar_comercializadora/";
	           	    $http.post(url,scope.fdatos).then(function(result)
	           	    {
	           	    	scope.nID=result.data.CodCom;
	           	    	if(result.data!=false)
	           	    	{
	           	    		$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:titulo,text:"Los datos han sido "+titulo+" con Exito.",type:"success",confirmButtonColor:"#188ae2"});
	           	    		document.getElementById('file').value ='';
	           	    		$cookies.remove('CIF_COM');
	           	    		scope.fdatos=result.data;
	           	    	}
	           	    	else
	           	    	{
	           	    		$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error",text:"No hemos podidos guardar los datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	           	    	}

	           	    },function(error)
	           	    {
			           	if(error.status==404 && error.statusText=="Not Found")
						{
							$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
							
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
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
	scope.validar_campos_nulos=function()
	{
		if (scope.fdatos.BloDirCom==undefined || scope.fdatos.BloDirCom==null || scope.fdatos.BloDirCom=='')
		{
			scope.fdatos.BloDirCom=null;
		}
		else
		{
			scope.fdatos.BloDirCom=scope.fdatos.BloDirCom;
		}
		if (scope.fdatos.EscDirCom==undefined || scope.fdatos.EscDirCom==null || scope.fdatos.EscDirCom=='')
		{
			scope.fdatos.EscDirCom=null;
		}
		else
		{
			scope.fdatos.EscDirCom=scope.fdatos.EscDirCom;
		}
		if (scope.fdatos.PlaDirCom==undefined || scope.fdatos.PlaDirCom==null || scope.fdatos.PlaDirCom=='')
		{
			scope.fdatos.PlaDirCom=null;
		}
		else
		{
			scope.fdatos.PlaDirCom=scope.fdatos.PlaDirCom;
		}
		if (scope.fdatos.PueDirCom==undefined || scope.fdatos.PueDirCom==null || scope.fdatos.PueDirCom=='')
		{
			scope.fdatos.PueDirCom=null;
		}
		else
		{
			scope.fdatos.PueDirCom=scope.fdatos.PueDirCom;
		}
		if (scope.fdatos.FecConCom==undefined || scope.fdatos.FecConCom==null || scope.fdatos.FecConCom=='')
		{
			scope.fdatos.FecConCom=null;
		}
		else
		{
			scope.fdatos.FecConCom=scope.fdatos.FecConCom;
		}
		if (scope.fdatos.DurConCom==undefined || scope.fdatos.DurConCom==null || scope.fdatos.DurConCom=='')
		{
			scope.fdatos.DurConCom=null;
		}
		else
		{
			scope.fdatos.DurConCom=scope.fdatos.DurConCom;
		}	
		if (scope.fdatos.FecVenConCom==undefined || scope.fdatos.FecVenConCom==null || scope.fdatos.FecVenConCom=='')
		{
			scope.fdatos.FecVenConCom=null;
		}
		else
		{
			scope.fdatos.FecVenConCom=scope.fdatos.FecVenConCom;
		}
		if (scope.fdatos.ObsCom==undefined || scope.fdatos.ObsCom==null || scope.fdatos.ObsCom=='')
		{
			scope.fdatos.ObsCom=null;
		}
		else
		{
			scope.fdatos.ObsCom=scope.fdatos.ObsCom;
		}
		if (scope.fdatos.PagWebCom==undefined || scope.fdatos.PagWebCom==null || scope.fdatos.PagWebCom=='')
		{
			scope.fdatos.PagWebCom=null;
		}
		else
		{
			scope.fdatos.PagWebCom=scope.fdatos.PagWebCom;
		}
		if (scope.fdatos.DocConCom==undefined || scope.fdatos.DocConCom==null || scope.fdatos.DocConCom=='')
		{
			scope.fdatos.DocConCom=null;
		}
		else
		{
			scope.fdatos.DocConCom=scope.fdatos.DocConCom;
		}
	}
	scope.validar_campos_datos_basicos = function()
	{
		resultado = true;
		if (scope.fdatos.RazSocCom==null || scope.fdatos.RazSocCom==undefined || scope.fdatos.RazSocCom=='')
		{
			Swal.fire({title:"El Campo Razon Social es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NomComCom==null || scope.fdatos.NomComCom==undefined || scope.fdatos.NomComCom=='')
		{
			Swal.fire({title:"El Campo Nombre Comercial es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.CodTipVia > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Vía de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NomViaDirCom==null || scope.fdatos.NomViaDirCom==undefined || scope.fdatos.NomViaDirCom=='')
		{
			Swal.fire({title:"El Campo Nombre de la Vía es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NumViaDirCom==null || scope.fdatos.NumViaDirCom==undefined || scope.fdatos.NumViaDirCom=='')
		{
			Swal.fire({title:"El Campo Número de la Vía es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.CodPro > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Provincia de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.CodLoc > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Localidad de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.TelFijCom==null || scope.fdatos.TelFijCom==undefined || scope.fdatos.TelFijCom=='')
		{
			Swal.fire({title:"El Campo Teléfono es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.EmaCom==null || scope.fdatos.EmaCom==undefined || scope.fdatos.EmaCom=='')
		{
			Swal.fire({title:"El Campo Correo Electrónico es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NomConCom==null || scope.fdatos.NomConCom==undefined || scope.fdatos.NomConCom=='')
		{
			Swal.fire({title:"El Campo Persona Contacto es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.CarConCom==null || scope.fdatos.CarConCom==undefined || scope.fdatos.CarConCom=='')
		{
			Swal.fire({title:"El Campo Cargo Persona es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}		
		if (resultado == false)
		{
			return false;
		} 
			return true;
	} 
	$scope.Consultar_CIF = function(event) 
	{      
	 	if(scope.fdatos.NumCifCom==undefined || scope.fdatos.NumCifCom==null || scope.fdatos.NumCifCom=='')
		{
			Swal.fire({title:"Error.",text:"El número de CIF no puede estar vacio.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
	        $("#NumCifCom").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Configuraciones_Generales/comprobar_cif_comercializadora";
			$http.post(url,scope.fdatos).then(function(result)
			{
				if(result.data!=false)
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Comercializadora Registrada.",text:"El Número de CIF ya se encuentra registrado.",type:"success",confirmButtonColor:"#188ae2"});					
				}
				else
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					$("#modal_cif_comercializadora").modal('hide');
					$cookies.put('CIF_COM', scope.fdatos.NumCifCom);
					location.href ="#/Add_Comercializadora/";
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}						
	}; 
	scope.modal_cif_comercializadora=function()
	{		
		scope.fdatos.NumCifCom=undefined;
		$("#modal_cif_comercializadora").modal('show');		
	}

	scope.cargar_lista_comercializadoras=function()
	{
		 $("#List_Comer").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Configuraciones_Generales/get_list_comercializadora";
			$http.get(url).then(function(result)
			{
				if(result.data!=false)
				{
					$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					$scope.predicate = 'id';  
					$scope.reverse = true;						
					$scope.currentPage = 1;  
					$scope.order = function (predicate) 
					{  
						$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
						$scope.predicate = predicate;  
					}; 						
					scope.Tcomercializadoras =result.data;
					scope.TcomercializadorasBack =result.data; 	 								
					$scope.totalItems = scope.Tcomercializadoras.length; 
					$scope.numPerPage = 50;  
					$scope.paginate = function (value) 
					{  
						var begin, end, index;  
						begin = ($scope.currentPage - 1) * $scope.numPerPage;  
						end = begin + $scope.numPerPage;  
						index = scope.Tcomercializadoras.indexOf(value);  
						return (begin <= index && index < end);  
					};
				}
				else
				{
					$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Comercializadora.",text:"No hemos encontrado Comercializadora Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
					scope.Tcomercializadoras=undefined;
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});	
	}
	
	scope.filtrarLocalidad =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {DesPro: scope.tmodal_data.CodPro}, true);
		
	}
	scope.filtrarLocalidadCom =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodPro}, true);
		
		if($route.current.$$route.originalPath=="/Edit_Comercializadora/:ID/:INF" || $route.current.$$route.originalPath=="/Edit_Comercializadora/:ID")
		{
			scope.contador=0;
			scope.contador=scope.contador+1;
		}
		console.log('para ver si se ejecuta cada 5 segundos?');
		console.log(scope.contador);
		if(scope.contador==1)
		{
			$interval.cancel(promise);
		}
	}
	scope.regresar_filtro=function()
	{
		scope.tmodal_data={};
		scope.Tcomercializadoras=scope.TcomercializadorasBack;
	}
	scope.regresar=function()
	{
		if(scope.fdatos.CodCom==undefined)
		{
			
			Swal.fire({title:"Esta seguro de no completar el registro de la Comercializadora?",			
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"OK"}).then(function(t)
			{
	          if(t.value==true)
	          {
	              	$cookies.remove('CIF_COM');
	              	location.href="#/Comercializadora/";
	          }
	          else
	          {
	               console.log('Cancelando ando...');	                
	          }
	       });	
		}
		else
		{
			location.href="#/Comercializadora/";	
		}
	}
	scope.filtrar_zona_postal =  function()
	{
		scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, {CodLoc: scope.fdatos.CodLoc}, true);
		angular.forEach(scope.CodLocZonaPostal, function(data)
		{
			scope.fdatos.ZonPos=data.CPLoc;						
		});		

	}
	scope.misma_razon=function(opcion)
	{
		if(opcion==true)
		{
			scope.fdatos.NomComCom=undefined;
		}
		else
		{
			scope.fdatos.NomComCom=scope.fdatos.RazSocCom;
		}
		
	}
	scope.asignar_a_nombre_comercial=function()
	{
		if(scope.fdatos.RazSocCom!=undefined || scope.fdatos.RazSocCom!=null || scope.fdatos.RazSocCom!='')
		{
			scope.fdatos.NomComCom=scope.fdatos.RazSocCom;
		}	
		
	}
	scope.validarsinuermo=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([+0-9])*$/.test(numero))
			scope.fdatos.TelFijCom=numero.substring(0,numero.length-1);
		}
	}
	scope.validar_fecha=function(metodo,object)
	{
		
		if(metodo==1)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([/0-9])*$/.test(numero))
				scope.FecConCom=numero.substring(0,numero.length-1);
			}	
		}
		else
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([/0-9])*$/.test(numero))
				scope.FecVenConCom=numero.substring(0,numero.length-1);
			}
		}
		//scope.calcular_anos();		
	}

	scope.calcular_anos=function()
	{		
		if(scope.FecConCom!=undefined && scope.FecVenConCom!=undefined)
		{
			if(new Date(scope.FecVenConCom)<new Date(scope.FecConCom))
			{
				Swal.fire({title:"Error",text:"La fecha de vencimiento no puede ser menor a la fecha de inicio.",type:"error",confirmButtonColor:"#188ae2"});
				scope.fdatos.DurConCom=undefined;
				scope.FecVenConCom=undefined;
				return false;
			}
			var hora3 = (scope.FecVenConCom).split("/"),
	   		hora4 =(scope.FecConCom).split("/"),
	   		t3 = new Date(),
	    	t4 = new Date();
	 		t3.setHours(hora3[2], hora3[1], hora3[0]);
			t4.setHours(hora4[2], hora4[1], hora4[0]);
			t3.setHours(t3.getHours() - t4.getHours(), t3.getMinutes() - t4.getMinutes(), t3.getSeconds() - t4.getSeconds());
			scope.fdatos.DurConCom = (t3.getHours());
			if(scope.fdatos.DurConCom==0)
			{
				Swal.fire({title:"Error",text:"El Tiempo Minimo del contrato debe ser de 1 año en adelante.",type:"error",confirmButtonColor:"#188ae2"});
				scope.FecVenConCom=undefined;
				scope.fdatos.DurConCom=undefined;
				scope.disabled_button=1;					
			}
			else
			{
				scope.disabled_button=0;
			}
		}		
	}
	scope.validar_opcion=function(index,opciones_comercializadoras,dato)
	{
		//console.log(index);
		console.log(opciones_comercializadoras);
		console.log(dato);
		if(opciones_comercializadoras==1)
		{
			if(dato.EstCom=='ACTIVA')
			{
				Swal.fire({title:"Error",text:"Ya esta Comercializadora se encuentra activa.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
				return false;				
			}
			
			Swal.fire({title:"¿Esta Seguro de Activar Esta Comercializadora?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
	              	scope.opciones_comercializadoras[index]=undefined;
					scope.cambiar_estatus_comercializadora(opciones_comercializadoras,dato.CodCom); 
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_comercializadoras[index]=undefined;
	            }
	        });			
		}
		if(opciones_comercializadoras==2)
		{
			scope.t_modal_data={};
			if(dato.EstCom=='BLOQUEADA')
			{
				Swal.fire({title:"Error",text:"Ya esta Comercializadora se encuentra bloqueada.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
				return false;				
			}
			scope.t_modal_data.CodCom=dato.CodCom;
			scope.NumCifCom=dato.NumCifCom;
			scope.RazSocCom=dato.RazSocCom;
			scope.t_modal_data.OpcCom=opciones_comercializadoras;
			scope.fecha_bloqueo=fecha;
			scope.cargar_lista_MotBloCom(index);			
			//scope.opciones_comercializadoras[index]=undefined;
			//scope.cambiar_estatus_comercializadora(opciones_comercializadoras,dato.CodCom);
		}
		if(opciones_comercializadoras==3)
		{
			location.href ="#/Edit_Comercializadora/"+dato.CodCom;
		}
		if(opciones_comercializadoras==4)
		{
			location.href ="#/Edit_Comercializadora/"+dato.CodCom+"/"+1;
			scope.validate_info=1;
		}
	}
	$scope.submitFormlockCom = function(event) 
	{
	 	if(scope.t_modal_data.ObsBloCom==undefined||scope.t_modal_data.ObsBloCom==null||scope.t_modal_data.ObsBloCom=='')
	 	{
	 		scope.t_modal_data.ObsBloCom=null;
	 	}
	 	else
	 	{
	 		scope.t_modal_data.ObsBloCom=scope.t_modal_data.ObsBloCom;
	 	}
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Esta Comercializadora?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            console.log(scope.t_modal_data);
	            scope.cambiar_estatus_comercializadora(scope.t_modal_data.OpcCom,scope.t_modal_data.CodCom);
	        }
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	        });		
	};
	scope.cargar_lista_MotBloCom=function(index)
	{
		var url=base_urlHome()+"api/Configuraciones_Generales/list_MotBloCom/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.tMotBloCom=result.data;
				scope.opciones_comercializadoras[index]=undefined;
				$("#modal_motivo_bloqueo_comercializadora").modal('show'); 
			}
			else
			{
				Swal.fire({title:"Error",text:"No Hemos encontrado motivos de bloqueos para las Comercializadora por lo que no puede continuar con esta operación.",type:"error",confirmButtonColor:"#188ae2"});	
				scope.opciones_comercializadoras[index]=undefined;
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{			
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}	
		});
	}
	scope.cambiar_estatus_comercializadora=function(opciones_comercializadoras,CodCom,index)
	{
		scope.status_comer={};
		scope.status_comer.EstCom=opciones_comercializadoras;
		scope.status_comer.CodCom=CodCom;
		if(opciones_comercializadoras==2)
		{
			scope.status_comer.MotBloq=scope.t_modal_data.MotBloq;
			scope.status_comer.ObsBloCom=scope.t_modal_data.ObsBloCom;
			console.log(scope.status_comer);
		}
		$("#estatus").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/cambiar_estatus_comercializadora/";
		 $http.post(url,scope.status_comer).then(function(result)
		 {
		 	if(result.data.resultado!=false)
		 	{
		 		if(opciones_comercializadoras==1)
		 		{
		 			var title='Activando.';
		 			var text='La Comercializadora a sido activada con exito.';
		 		}
		 		if(opciones_comercializadoras==2)
		 		{
		 			var title='Bloquear.';
		 			var text='La Comercializadora a sido bloqueada con exito.';
		 			$("#modal_motivo_bloqueo_comercializadora").modal('hide');
		 		}

		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		Swal.fire({title:title,text:text,type:"success",confirmButtonColor:"#188ae2"});
		 		scope.opciones_comercializadoras[index]=undefined;
		 		scope.cargar_lista_comercializadoras();
		 	}
		 	else
		 	{
		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos podido actualizar el estatus de la Comercializadora.",type:"error",confirmButtonColor:"#188ae2"});
				scope.cargar_lista_comercializadoras();
		 	}

		 },function(error)
		 {
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });
	}	
	scope.buscarXID=function()
	{
		 $("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/Buscar_xID_Comercializadora/CodCom/"+scope.nID;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		scope.fdatos=result.data;
		 		scope.FecIniCom=result.data.FecIniCom;
		 		scope.FecConCom=result.data.FecConCom;
				scope.FecVenConCom=result.data.FecVenConCom;
		 		
				if(result.data.RenAutConCom==0)
				{
					scope.fdatos.RenAutConCom=false;
				}	
				else
				{
					scope.fdatos.RenAutConCom=true;
				}
				if(result.data.SerEle==1)
				{
					scope.fdatos.SerEle=true;
				}
				else
				{
					scope.fdatos.SerEle=false;
				}
				if(result.data.SerEsp==1)
				{
					scope.fdatos.SerEsp=true;
				}
				else
				{
					scope.fdatos.SerEsp=false;
				}
				if(result.data.SerGas==1)
				{
					scope.fdatos.SerGas=true;
				}
				else
				{
					scope.fdatos.SerGas=false;
				}
				scope.fdatos.misma_razon=false;				
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
	          	var url = base_urlHome()+"api/Configuraciones_Generales/borrar_comercializadora/CodCom/"+scope.fdatos.CodCom;
	          	$http.detele(url).then(function(result)
	          	{
	          		if(result.data!=false)
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Exito!",text:"Registro Eliminado Correctamente.",type:"error",confirmButtonColor:"#188ae2"});
						location.href="#/Comercializadora/";
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
////////////////////////////////////////////////////////////FUNCIONES DE LA GRIB Y ADD COMERCIALIZADORAS END///////////////////////////////////////////////////
////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE PRODUCTOS START///////////////////////////////////////////////////
scope.productos ={};
scope.TProductos =undefined;
scope.TProductosBack =undefined;
scope.productos.SerGas=false;
scope.productos.SerEle=false;
scope.FecIniPro=fecha;
scope.ttipofiltrosProductos = [{id: 1, nombre: 'Comercializadora'},{id: 2, nombre: 'Tipo de Servicio'},{id: 3, nombre: 'Fecha de Inicio'},{id: 4, nombre: 'Estatus del Producto'}];


scope.cargar_lista_productos=function()
{
	//$("#List_Produc").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	var url=base_urlHome()+"api/Configuraciones_Generales/get_list_productos/";
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			}; 						
			scope.TProductos =result.data;
			scope.TProductosBack =result.data; 	 								
			$scope.totalItems1 = scope.TProductos.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TProductos.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
		}
		else
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			console.log('No hemos encontrado Productos registrados.');
			//Swal.fire({title:"Productos.",text:"No hemos encontrado Productos Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
			scope.TProductos=undefined;
		}
	},function(error)
	{
		if(error.status==404 && error.statusText=="Not Found")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==401 && error.statusText=="Unauthorized")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==403 && error.statusText=="Forbidden")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==500 && error.statusText=="Internal Server Error")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
		}
	});	
}
scope.agg_productos=function()
{
	scope.TvistaProductos=2;
	console.log(scope.TvistaProductos);
}
scope.regresar_productos=function()
{
	Swal.fire({title:"Esta seguro de regresar.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	          	scope.TvistaProductos=1;
	          	scope.productos={};
	          	scope.cargar_lista_productos();
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });		
}
$scope.submitFormProductos = function(event) 
{      
	if (!scope.validar_campos_productos())
		{
			return false;
		}
	if(scope.productos.CodTPro==undefined)
 	{
 		var titulo='Guardando';
 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
 	}
 	else
 	{
 		var titulo='Actualizando';
 		var texto='¿Esta Seguro de Actualizar este registro.?';
 	}
 	if(scope.productos.ObsPro==undefined||scope.productos.ObsPro==null||scope.productos.ObsPro=='')
 	{
 		scope.productos.ObsPro=null;
 	}	
 	else
 	{
 		scope.productos.ObsPro=scope.productos.ObsPro;
 	}
	console.log(scope.productos);
	Swal.fire({title:titulo,
	text:texto,
	type:"question",
	showCancelButton:!0,
	confirmButtonColor:"#31ce77",
	cancelButtonColor:"#f34943",
	confirmButtonText:"Confirmar!"}).then(function(t)
	{
	    if(t.value==true)
	    {
	    	$("#"+titulo).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
	        var url = base_urlHome()+"api/Configuraciones_Generales/registrar_productos/";
	        $http.post(url,scope.productos).then(function(result)
	        {
	           	scope.nIDPro=result.data.CodTPro;
	           	if(result.data!=false)
	           	{
	           	    $("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:titulo,text:"Los datos han sido "+titulo+" con Exito.",type:"success",confirmButtonColor:"#188ae2"});
	           	    scope.productos=result.data;
	           	}
	           	else
	           	{
	           	    $("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error",text:"No hemos podidos guardar los datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	           	}
			},function(error)
	        {
			    if(error.status==404 && error.statusText=="Not Found")
				{
					$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
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
scope.cargar_lista_ComAct=function()
{
	var url=base_urlHome()+"api/Configuraciones_Generales/get_list_ComAct";
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			scope.TProComercializadoras =result.data;
		}
		else
		{
			console.log('No hemos encontrado Comercializadora Activas.');
			scope.TProComercializadoras=undefined;
		}
	},function(error)
	{
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
scope.validar_campos_productos = function()
	{
		resultado = true;
		if (!scope.productos.CodTProCom > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Comercializadora de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.productos.DesPro==null || scope.productos.DesPro==undefined || scope.productos.DesPro=='')
		{
			Swal.fire({title:"El Campo Nombre del Producto es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (resultado == false)
		{
			return false;
		} 
			return true;
	} 
	scope.validar_opcion_productos=function(index,opciones_productos,dato)
	{
		console.log(index);
		console.log(opciones_productos);
		console.log(dato);
		if(opciones_productos==1)
		{
			if(dato.EstPro=='ACTIVO')
			{
				Swal.fire({title:"Error",text:"Ya este Producto se encuentra activo.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_productos[index]=undefined;
				return false;				
			}
			
			Swal.fire({title:"¿Esta Seguro de Activar Este Producto?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
	              	scope.opciones_productos[index]=undefined;
					scope.cambiar_estatus_productos(opciones_productos,dato.CodPro,index); 
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_productos[index]=undefined;
	            }
	        });			
		}
		if(opciones_productos==2)
		{
			scope.t_modal_data={};
			if(dato.EstPro=='BLOQUEADO')
			{
				Swal.fire({title:"Error",text:"Ya este Producto ya se encuentra bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_productos[index]=undefined;
				return false;				
			}
			scope.opciones_productos[index]=undefined;
			scope.t_modal_data.CodPro=dato.CodPro;
			scope.Comercializadora=dato.NumCifCom+" - "+dato.RazSocCom;
			scope.Producto=dato.DesPro;
			scope.fecha_bloqueo=fecha;
			scope.t_modal_data.OpcPro=opciones_productos;
			$("#modal_motivo_bloqueo_productos").modal('show');
		}
		if(opciones_productos==3)
		{
			scope.opciones_productos[index]=undefined;
			//location.href ="#/Edit_Comercializadora/"+dato.CodCom;
		}
		if(opciones_productos==4)
		{
			scope.opciones_productos[index]=undefined;
			//location.href ="#/Edit_Comercializadora/"+dato.CodCom+"/"+1;
			//scope.validate_info=1;
		}
	}
	scope.cambiar_estatus_productos=function(opciones_productos,CodPro,index)
	{
		scope.status_producto={};
		scope.status_producto.EstPro=opciones_productos;
		scope.status_producto.CodPro=CodPro;
		
		if(opciones_productos==2)
		{
			scope.status_producto.MotBloqPro=scope.t_modal_data.MotBloPro;
			scope.status_producto.ObsBloPro=scope.t_modal_data.ObsBloPro;
			console.log(scope.status_producto);
		}
		console.log(scope.status_producto);
		$("#estatus").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/cambiar_estatus_productos/";
		 $http.post(url,scope.status_producto).then(function(result)
		 {
		 	if(result.data.resultado!=false)
		 	{
		 		if(opciones_productos==1)
		 		{
		 			var title='Activando.';
		 			var text='El Producto a sido activado con exito.';
		 		}
		 		if(opciones_productos==2)
		 		{
		 			var title='Bloquear.';
		 			var text='El Producto a sido bloqueado con exito.';
		 			$("#modal_motivo_bloqueo_productos").modal('hide');
		 		}

		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		Swal.fire({title:title,text:text,type:"success",confirmButtonColor:"#188ae2"});
		 		scope.opciones_productos[index]=undefined;
		 		scope.cargar_lista_productos();
		 	}
		 	else
		 	{
		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos podido actualizar el estatus del producto.",type:"error",confirmButtonColor:"#188ae2"});
				scope.cargar_lista_productos();
		 	}

		 },function(error)
		 {
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });
	}
	$scope.submitFormlockPro = function(event) 
	{
	 	if(scope.t_modal_data.ObsBloPro==undefined||scope.t_modal_data.ObsBloPro==null||scope.t_modal_data.ObsBloPro=='')
	 	{
	 		scope.t_modal_data.ObsBloPro=null;
	 	}
	 	else
	 	{
	 		scope.t_modal_data.ObsBloPro=scope.t_modal_data.ObsBloPro;
	 	}
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Este Producto?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            console.log(scope.t_modal_data);
	            scope.cambiar_estatus_productos(scope.t_modal_data.OpcPro,scope.t_modal_data.CodPro);
	        }
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	        });		
	};






////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE PRODUCTOS END///////////////////////////////////////////////////
////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE ANEXOS START///////////////////////////////////////////////////
scope.ttipofiltrosAnexos = [{id: 1, nombre: 'Comercializadora'},{id: 2, nombre: 'Producto'},{id: 3, nombre: 'Tipo de Servicio'},{id: 4, nombre: 'Tipo de Comisión'},{id: 5, nombre: 'Fecha de Inicio'},{id: 6, nombre: 'Estatus del Anexo'}];
scope.CodAnePro=true;
scope.CodAneTPro=true;
scope.DesAnePro=true;
scope.SerGasAne=true;
scope.SerTEleAne=true;
//scope.ObsAnePro=true;
//scope.FecIniAne=true;
//scope.EstAne=true;
scope.AccTAne=true;
scope.cargar_lista_anexos=function()
{
	//$("#List_Produc").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	var url=base_urlHome()+"api/Configuraciones_Generales/get_list_anexos/";
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			$scope.predicate2 = 'id';  
			$scope.reverse2 = true;						
			$scope.currentPage2 = 1;  
			$scope.order2 = function (predicate2) 
			{  
				$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;  
				$scope.predicate2 = predicate2;  
			}; 						
			scope.TAnexos =result.data;
			scope.TAnexosBack =result.data; 	 								
			$scope.totalItems2 = scope.TAnexos.length; 
			$scope.numPerPage2 = 50;  
			$scope.paginate2 = function (value2) 
			{  
				var begin2, end2, index2;  
				begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
				end2 = begin2 + $scope.numPerPage2;  
				index2 = scope.TAnexos.indexOf(value2);  
				return (begin2 <= index2 && index2 < end2);  
			};
		}
		else
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			console.log('No hemos encontrado Anexos registrados.');
			//Swal.fire({title:"Productos.",text:"No hemos encontrado Productos Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
			scope.TAnexos=undefined;
		}
	},function(error)
	{
		if(error.status==404 && error.statusText=="Not Found")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==401 && error.statusText=="Unauthorized")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==403 && error.statusText=="Forbidden")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==500 && error.statusText=="Internal Server Error")
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
		}
	});	
}
scope.validar_opcion_anexos=function(index,opciones_anexos,dato)
	{
		console.log(index);
		console.log(opciones_anexos);
		console.log(dato);
		if(opciones_anexos==1)
		{
			if(dato.EstAne=='ACTIVO')
			{
				Swal.fire({title:"Error",text:"Ya este Anexo se encuentra activo.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_anexos[index]=undefined;
				return false;				
			}
			
			Swal.fire({title:"¿Esta Seguro de Activar Este Anexo?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
	              	scope.opciones_anexos[index]=undefined;
					scope.cambiar_estatus_productos(opciones_anexos,dato.CodPro,index); 
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_anexos[index]=undefined;
	            }
	        });			
		}
		if(opciones_anexos==2)
		{
			scope.t_modal_data={};
			if(dato.EstAne=='BLOQUEADO')
			{
				Swal.fire({title:"Error",text:"Ya este Anexo ya se encuentra bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_anexos[index]=undefined;
				return false;				
			}
			scope.opciones_anexos[index]=undefined;
			/*scope.t_modal_data.CodPro=dato.CodPro;
			scope.Comercializadora=dato.NumCifCom+" - "+dato.RazSocCom;
			scope.Producto=dato.DesPro;
			scope.fecha_bloqueo=fecha;
			scope.t_modal_data.OpcPro=opciones_anexos;*/
			$("#modal_motivo_bloqueo_anexos").modal('show');
		}
		if(opciones_anexos==3)
		{
			scope.opciones_anexos[index]=undefined;
			//location.href ="#/Edit_Comercializadora/"+dato.CodCom;
		}
		if(opciones_anexos==4)
		{
			scope.opciones_anexos[index]=undefined;
			//location.href ="#/Edit_Comercializadora/"+dato.CodCom+"/"+1;
			//scope.validate_info=1;
		}
	}
	scope.cambiar_estatus_anexos=function(opciones_anexos,CodAnePro,index)
	{
		scope.status_producto={};
		scope.status_producto.EstAne=opciones_anexos;
		scope.status_producto.CodAnePro=CodAnePro;
		
		/*if(opciones_anexos==2)
		{
			scope.status_producto.MotBloqPro=scope.t_modal_data.MotBloPro;
			scope.status_producto.ObsBloPro=scope.t_modal_data.ObsBloPro;
			console.log(scope.status_producto);
		}*/
		console.log(scope.status_producto);
		$("#estatus").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/cambiar_estatus_anexos/";
		 $http.post(url,scope.status_producto).then(function(result)
		 {
		 	if(result.data.resultado!=false)
		 	{
		 		if(opciones_anexos==1)
		 		{
		 			var title='Activando.';
		 			var text='El Anexo a sido activado con exito.';
		 		}
		 		if(opciones_anexos==2)
		 		{
		 			var title='Bloquear.';
		 			var text='El Anexo a sido bloqueado con exito.';
		 			$("#modal_motivo_bloqueo_productos").modal('hide');
		 		}

		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		Swal.fire({title:title,text:text,type:"success",confirmButtonColor:"#188ae2"});
		 		scope.opciones_anexos[index]=undefined;
		 		scope.cargar_lista_anexos();
		 	}
		 	else
		 	{
		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos podido actualizar el estatus del producto.",type:"error",confirmButtonColor:"#188ae2"});
				scope.cargar_lista_anexos();
		 	}

		 },function(error)
		 {
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });
	}







////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE ANEXOS END///////////////////////////////////////////////////




	
	if(scope.nID!=undefined) 
	{
		scope.buscarXID();
		var promise = $interval(function() 
		{ 
			scope.filtrarLocalidadCom();
			},2000);	
			$scope.$on('$destroy', function () 
			{ 
			$interval.cancel(promise); 
		});
	}
}			