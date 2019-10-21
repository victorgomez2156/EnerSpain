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
.directive('uploadanexoModel', ["$parse", function ($parse) 
{
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) 
		{
			iElement.on("change", function(e)
			{
				$parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]);
				//console.log($parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]));
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
	scope.index=0;
	const $archivos = document.querySelector("#file");
	const $archivosanexos = document.querySelector("#file_anexo");
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
		if($route.current.$$route.originalPath=="/Edit_Comercializadora/:ID/:INF")
		{
			scope.validate_info=1;
		}
		scope.services_add_edit();
		scope.Topciones_Grib = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
		scope.CodTCom=true;
		scope.DesTPro=true;
		scope.SerTGas=true;
		scope.SerTEle=true;
		scope.EstTPro=true;
		scope.AccTPro=true;
		scope.TvistaProductos=1;
		scope.TvistaAnexos=1;
		scope.TvistaServiciosEspeciales=1;
		scope.productos ={};
		scope.TProductos =undefined;
		scope.TProductosBack =undefined;
		scope.productos.SerGas=false;
		scope.productos.SerEle=false;
		scope.FecIniPro=fecha;
		scope.ttipofiltrosProductos = [{id: 1, nombre: 'Comercializadora'},{id: 2, nombre: 'Tipo de Servicio'},{id: 3, nombre: 'Fecha de Inicio'},{id: 4, nombre: 'Estatus del Producto'}];
		scope.TAnexos=undefined;
		scope.TAnexosBack =undefined;
		scope.anexos ={};
		scope.CodAnePro=true;
		scope.CodAneTPro=true;
		scope.DesAnePro=true;
		scope.SerGasAne=true;
		scope.SerTEleAne=true;
		scope.FecIniAneA=fecha;
		scope.AccTAne=true;
		scope.ttipofiltrosAnexos = [{id: 1, nombre: 'Comercializadora'},{id: 2, nombre: 'Producto'},{id: 3, nombre: 'Tipo de Servicio'},{id: 4, nombre: 'Tipo de Comisión'},{id: 5, nombre: 'Fecha de Inicio'},{id: 6, nombre: 'Estatus del Anexo'}];
		scope.anexos.SerGas=false;
		scope.anexos.SerEle=false;
		scope.anexos.Fijo=false;
		scope.anexos.Indexado=false;			
		scope.anexos.T_DetalleAnexoTarifaGas=[];
		scope.TServicioEspeciales=undefined;
		scope.TServicioBack=undefined;
		scope.servicio_especial={};
		scope.CodComSerEsp=true;
		scope.DesSerEsp=true;
		scope.TipCli=true;
		scope.SerElecSerEsp=true;
		scope.SerGasSerEsp=true;
		scope.EstSerEsp=true;
		scope.AccSerEsp=true;
		scope.ttipofiltrosServicioEspecial = [{id: 1, nombre: 'Comercializadora'},{id: 2, nombre: 'Tipo de Servicio'},{id: 3, nombre: 'Tipo de Cliente'},{id: 4, nombre: 'Tipo de Comisión'},{id: 5, nombre: 'Fecha de Inicio'},{id: 6, nombre: 'Estatus del Servicio Especial'}];
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
	$scope.uploadFileAnexo = function()
	{
		var file = $scope.file_anexo;
		//console.log($scope.file_anexo);
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
	scope.productos={};
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
	          	scope.validate_info_productos=0;
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
	var url=base_urlHome()+"api/Configuraciones_Generales/get_list_Actividades";
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			scope.TProComercializadoras =result.data.TProComercializadoras;
			scope.TProductosActivos =result.data.TProductosActivos;
			scope.Tipos_Comision =result.data.Tipos_Comision;
			scope.Tarifa_Gas_Anexos =result.data.Tarifa_Gas;
			scope.Tarifa_Ele_Anexos =result.data.Tarifa_Ele;

			angular.forEach(scope.Tarifa_Ele_Anexos, function(Tarifa_Electrica)
			{
				if(Tarifa_Electrica.TipTen=='BAJA')
				{	
					var ObjTarifaElecBaj = new Object();	
					if (scope.Tarifa_Elec_Baja==undefined || scope.Tarifa_Elec_Baja==false)
					{
						scope.Tarifa_Elec_Baja = []; 
					}
					scope.Tarifa_Elec_Baja.push({TipTen:Tarifa_Electrica.TipTen,NomTarEle:Tarifa_Electrica.NomTarEle,MinPotCon:Tarifa_Electrica.MinPotCon,MaxPotCon:Tarifa_Electrica.MaxPotCon,CodTarEle:Tarifa_Electrica.CodTarEle,CanPerTar:Tarifa_Electrica.CanPerTar});
					console.log(scope.Tarifa_Elec_Baja);
				}
				else
				{
					var ObjTarifaElecAlt = new Object();	
					if (scope.Tarifa_Elec_Alt==undefined || scope.Tarifa_Elec_Alt==false)
					{
						scope.Tarifa_Elec_Alt = []; 
					}
					scope.Tarifa_Elec_Alt.push({TipTen:Tarifa_Electrica.TipTen,NomTarEle:Tarifa_Electrica.NomTarEle,MinPotCon:Tarifa_Electrica.MinPotCon,MaxPotCon:Tarifa_Electrica.MaxPotCon,CodTarEle:Tarifa_Electrica.CodTarEle,CanPerTar:Tarifa_Electrica.CanPerTar});
					console.log(scope.Tarifa_Elec_Alt);
				}
			});

			/*scope.filtrarLocalidad =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {DesPro: scope.tmodal_data.CodPro}, true);
		
	}*/


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
			scope.opciones_productos[index]=undefined;
			scope.TvistaProductos=2;
			scope.validate_info_productos=undefined;
			scope.productos={};
			scope.productos.CodTPro=dato.CodPro;
			scope.productos.CodTProCom=dato.CodCom;
			scope.productos.DesPro=dato.DesPro;
			scope.FecIniPro=dato.FecIniPro;
			if(dato.SerGas=="NO")
			{
				scope.productos.SerGas=false;
			}
			else
			{
				scope.productos.SerGas=true;
			}
			if(dato.SerEle=="NO")
			{
				scope.productos.SerEle=false;
			}
			else
			{
				scope.productos.SerEle=true;
			}
			scope.productos.ObsPro=dato.ObsPro;

			

			//location.href ="#/Edit_Comercializadora/"+dato.CodCom;
		}
		if(opciones_productos==4)
		{
			scope.opciones_productos[index]=undefined;
			scope.TvistaProductos=2;
			scope.validate_info_productos=1;
			scope.productos={};
			scope.productos.CodTPro=dato.CodPro;
			scope.productos.CodTProCom=dato.CodCom;
			scope.productos.DesPro=dato.DesPro;
			scope.FecIniPro=dato.FecIniPro;
			if(dato.SerGas=="NO")
			{
				scope.productos.SerGas=false;
			}
			else
			{
				scope.productos.SerGas=true;
			}
			if(dato.SerEle=="NO")
			{
				scope.productos.SerEle=false;
			}
			else
			{
				scope.productos.SerEle=true;
			}
			scope.productos.ObsPro=dato.ObsPro;
			//location.href ="#/Edit_Comercializadora/"+dato.CodCom+"/"+1;
			//scope.validate_info=1;
		}
	}
	scope.limpiar_productos=function()
	{
		scope.productos={};
		scope.productos.SerGas=false;
		scope.productos.SerEle=false;
		scope.validate_info_productos=undefined;
		scope.FecIniPro=fecha;
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
					scope.cambiar_estatus_anexos(opciones_anexos,dato.CodAnePro,index); 
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
			scope.anexos_motivo_bloqueos={};
			scope.RazSocCom_BloAne=dato.NumCifCom+" - "+dato.RazSocCom;
			scope.DesPro_BloAne=dato.DesPro;
			scope.DesAnePro_BloAne=dato.DesAnePro;
			scope.FecBloAne=fecha;
			scope.anexos_motivo_bloqueos.CodAnePro=dato.CodAnePro;
			scope.anexos_motivo_bloqueos.EstAne=opciones_anexos;

			$("#modal_motivo_bloqueo_anexos").modal('show');
		}
		if(opciones_anexos==3)
		{
			scope.anexos={};
			scope.opciones_anexos[index]=undefined;
			scope.TvistaAnexos=2;
			scope.validate_info_anexos=0;
			scope.nIDAnexos=dato.CodAnePro;
			scope.validate_info_anexos=0;
			scope.buscarXIDAnexos();
			scope.filtrar_productos_com();

			//location.href ="#/Edit_Comercializadora/"+dato.CodCom;
		}
		if(opciones_anexos==4)
		{
			scope.anexos={};
			scope.opciones_anexos[index]=undefined;
			scope.TvistaAnexos=2;
			scope.nIDAnexos=dato.CodAnePro;
			scope.buscarXIDAnexos();
			scope.filtrar_productos_com();
			scope.validate_info_anexos=1;
			//location.href ="#/Edit_Comercializadora/"+dato.CodCom+"/"+1;
			//
		}
	}
	scope.cambiar_estatus_anexos=function(opciones_anexos,CodAnePro,index)
	{
		scope.status_anexos={};
		scope.status_anexos.EstAne=opciones_anexos;
		scope.status_anexos.CodAnePro=CodAnePro;
		
		if(opciones_anexos==2)
		{
			scope.status_anexos.MotBloAne=scope.anexos_motivo_bloqueos.MotBloAne;
			scope.status_anexos.ObsMotBloAne=scope.anexos_motivo_bloqueos.ObsMotBloAne;
			console.log(scope.status_anexos);
		}
		console.log(scope.status_anexos);
		$("#estatus").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/cambiar_estatus_anexos/";
		 $http.post(url,scope.status_anexos).then(function(result)
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
		 			$("#modal_motivo_bloqueo_anexos").modal('hide');
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
	scope.agg_anexos=function()
	{
		scope.anexos={};		
		scope.select_tarifa_gas=[];
		scope.select_tarifa_Elec_Baj=[];
		scope.select_tarifa_Elec_Alt=[];
		scope.anexos.T_DetalleAnexoTarifaGas=[];
		scope.anexos.T_DetalleAnexoTarifaElecBaj =[]; 
		scope.anexos.T_DetalleAnexoTarifaElecAlt =[]; 
		scope.anexos.SerGas=false;
		scope.anexos.SerEle=false;
		scope.anexos.Fijo=false;
		scope.anexos.Indexado=false;
		scope.anexos.AggAllBaj=false;
		scope.anexos.AggAllAlt=false;	
		scope.TvistaAnexos=2;
		console.log(scope.TvistaAnexos);
		scope.limpiar_anexo();
	}
	scope.regresar_anexos=function()
	{
		
		Swal.fire({title:"Regresar",
		text:"Esta Seguro de Regresar?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Confirmar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	scope.cargar_lista_anexos();
				scope.anexos={};		
				scope.select_tarifa_gas=[];
				scope.select_tarifa_Elec_Baj=[];
				scope.select_tarifa_Elec_Alt=[];
				scope.anexos.T_DetalleAnexoTarifaGas=[];
				scope.anexos.T_DetalleAnexoTarifaElecBaj =[]; 
				scope.anexos.T_DetalleAnexoTarifaElecAlt =[]; 
				scope.anexos.SerGas=false;
				scope.anexos.SerEle=false;
				scope.anexos.AggAllBaj=false;
				scope.anexos.AggAllAlt=false;	
				scope.TvistaAnexos=1;
				//console.log(scope.TvistaAnexos);	   
	        }
	        else
	        {
					console.log('Cancelando Ando...');
					//event.preventDefault();						
	        }
	    });			
	}
	scope.validate_text=function(CodTarGas,index,tari_gas,valor)
	{	
		console.log('Index: '+index);
		console.log('Código de la Tarifa: '+CodTarGas);
		console.log('Valor: '+valor);
		console.log(tari_gas);
		
	}
	scope.agregar_tarifa_gas_individual=function(index,dato,CodTarGas)
	{
		var ObjTarifaGas = new Object();	
		scope.select_tarifa_gas[CodTarGas]=dato;
		var ObjTarifaGas = new Object();	
			if (scope.anexos.T_DetalleAnexoTarifaGas==undefined || scope.anexos.T_DetalleAnexoTarifaGas==false)
			{
				scope.anexos.T_DetalleAnexoTarifaGas = []; 
			}
			scope.anexos.T_DetalleAnexoTarifaGas.push({CodTarGas:dato.CodTarGas});
			console.log(scope.anexos.T_DetalleAnexoTarifaGas);
	}
	scope.quitar_tarifa_gas=function(index,CodTarGas,tarifa_gas)
	{
		scope.select_tarifa_gas[CodTarGas]=false;
		i=0;
		for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaGas.length; i++) 
	    {
	      	if(scope.anexos.T_DetalleAnexoTarifaGas[i].CodTarGas==CodTarGas)
	       	{
		   		scope.anexos.T_DetalleAnexoTarifaGas.splice(i,1);
	       	}
		}
		console.log(scope.anexos.T_DetalleAnexoTarifaGas);
	}
	scope.agregar_todas_detalle=function(valor)
	{
		if(valor==true)
		{
			scope.disabled_all=1;
			angular.forEach(scope.Tarifa_Gas_Anexos, function(Tarifa)
			{
				if(scope.anexos.T_DetalleAnexoTarifaGas!=false)
				{
					if(scope.anexos.T_DetalleAnexoTarifaGas.length>0)
					{
						for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaGas.length; i++) 
					    {
					        if(scope.anexos.T_DetalleAnexoTarifaGas[i].CodTarGas==Tarifa.CodTarGas)
					       	{
					       		scope.anexos.T_DetalleAnexoTarifaGas.splice(i,1);
					        }
						}
					}
				}
				
				
				var ObjTarifaGas = new Object();
				scope.select_tarifa_gas[Tarifa.CodTarGas]=Tarifa;
				
				if (scope.anexos.T_DetalleAnexoTarifaGas==undefined || scope.anexos.T_DetalleAnexoTarifaGas==false)
				{
					scope.anexos.T_DetalleAnexoTarifaGas = []; 
				}
				scope.anexos.T_DetalleAnexoTarifaGas.push({CodTarGas:Tarifa.CodTarGas});
				for (var index = 0; index <= scope.anexos.T_DetalleAnexoTarifaGas.length; index++) 
				{
				        scope.anexos[index]=index;
				}
				console.log(scope.anexos.T_DetalleAnexoTarifaGas);
			});
		}
		else
		{
			scope.disabled_all=0;			
			console.log(scope.anexos.T_DetalleAnexoTarifaGas);
		}		
	}
	scope.agregar_tarifa_elec_baja=function(index,CodTarEle,opcion_tension_baja)
	{
		console.log(index);
		console.log(opcion_tension_baja);
		console.log(CodTarEle);
		var ObjTarifaElecBaja = new Object();	
		scope.select_tarifa_Elec_Baj[CodTarEle]=opcion_tension_baja;
		var ObjTarifaGas = new Object();	
			if (scope.anexos.T_DetalleAnexoTarifaElecBaj==undefined || scope.anexos.T_DetalleAnexoTarifaElecBaj==false)
			{
				scope.anexos.T_DetalleAnexoTarifaElecBaj = []; 
			}
			scope.anexos.T_DetalleAnexoTarifaElecBaj.push({CodTarEle:opcion_tension_baja.CodTarEle});
			console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
	}
	scope.quitar_tarifa_elec_baja=function(index,CodTarEle,opcion_tension_baja)
	{
		console.log(index);
		console.log(opcion_tension_baja);
		console.log(CodTarEle);
		scope.select_tarifa_Elec_Baj[CodTarEle]=false;
		i=0;
		for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecBaj.length; i++) 
	    {
	      	if(scope.anexos.T_DetalleAnexoTarifaElecBaj[i].CodTarEle==CodTarEle)
	       	{
		   		scope.anexos.T_DetalleAnexoTarifaElecBaj.splice(i,1);
	       	}
		}
		console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
	}
	scope.agregar_todas_baja_tension=function(full_datos,AggAllBaj)
	{
		console.log(full_datos);
		if(AggAllBaj==true)
		{
			scope.disabled_all_baja=1;
			angular.forEach(scope.Tarifa_Elec_Baja, function(Tarifa_Elec_Baja)
			{
				
				if(scope.anexos.T_DetalleAnexoTarifaElecBaj!=false)
				{
					if(scope.anexos.T_DetalleAnexoTarifaElecBaj.length>0)
					{
						for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecBaj.length; i++) 
					    {
					        if(scope.anexos.T_DetalleAnexoTarifaElecBaj[i].CodTarEle==Tarifa_Elec_Baja.CodTarEle)
					       	{
					       		scope.anexos.T_DetalleAnexoTarifaElecBaj.splice(i,1);
					        }
						}
					}
				}
				var ObjTarifaGas = new Object();
				scope.select_tarifa_Elec_Baj[Tarifa_Elec_Baja.CodTarEle]=Tarifa_Elec_Baja;
				
				if (scope.anexos.T_DetalleAnexoTarifaElecBaj==undefined || scope.anexos.T_DetalleAnexoTarifaElecBaj==false)
				{
					scope.anexos.T_DetalleAnexoTarifaElecBaj = []; 
				}
				scope.anexos.T_DetalleAnexoTarifaElecBaj.push({CodTarEle:Tarifa_Elec_Baja.CodTarEle});
				for (var index = 0; index <= scope.anexos.T_DetalleAnexoTarifaElecBaj.length; index++) 
				{
				        scope.anexos[index]=index;
				}
				console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
			});
		}
		else
		{
			scope.disabled_all_baja=0;			
			console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
		}	
	}
	scope.agregar_tarifa_elec_alta=function(index,CodTarEle,opcion_tension_alta)
	{
		console.log(index);
		console.log(CodTarEle);
		console.log(opcion_tension_alta);	
		scope.select_tarifa_Elec_Alt[CodTarEle]=opcion_tension_alta;
		var ObjTarifaElecAlt = new Object();
			if (scope.anexos.T_DetalleAnexoTarifaElecAlt==undefined || scope.anexos.T_DetalleAnexoTarifaElecAlt==false)
			{
				scope.anexos.T_DetalleAnexoTarifaElecAlt = []; 
			}
			scope.anexos.T_DetalleAnexoTarifaElecAlt.push({CodTarEle:opcion_tension_alta.CodTarEle});
			console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
	}
	scope.quitar_tarifa_elec_alta=function(index,CodTarEle,opcion_tension_alta)
	{
		console.log(index);
		console.log(opcion_tension_alta);
		console.log(CodTarEle);
		scope.select_tarifa_Elec_Alt[CodTarEle]=false;
		i=0;
		for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecAlt.length; i++) 
	    {
	      	if(scope.anexos.T_DetalleAnexoTarifaElecAlt[i].CodTarEle==CodTarEle)
	       	{
		   		scope.anexos.T_DetalleAnexoTarifaElecAlt.splice(i,1);
	       	}
		}
		console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
	}
	scope.agregar_todas_alta_tension=function(full_datos,AggAllAlt)
	{
		console.log(full_datos);
		if(AggAllAlt==true)
		{
			scope.disabled_all_alta=1;
			angular.forEach(scope.Tarifa_Elec_Alt, function(Tarifa_Elec_Alta)
			{
				if(scope.anexos.T_DetalleAnexoTarifaElecAlt!=false)
				{
					if(scope.anexos.T_DetalleAnexoTarifaElecAlt.length>0)
					{
						for (var i = 0; i < scope.anexos.T_DetalleAnexoTarifaElecAlt.length; i++) 
					    {
					        if(scope.anexos.T_DetalleAnexoTarifaElecAlt[i].CodTarEle==Tarifa_Elec_Alta.CodTarEle)
					       	{
					       		scope.anexos.T_DetalleAnexoTarifaElecAlt.splice(i,1);
					        }
						}
					}	
				}							
				var ObjTarifaGas = new Object();
				scope.select_tarifa_Elec_Alt[Tarifa_Elec_Alta.CodTarEle]=Tarifa_Elec_Alta;
				
				if (scope.anexos.T_DetalleAnexoTarifaElecAlt==undefined || scope.anexos.T_DetalleAnexoTarifaElecAlt==false)
				{
					scope.anexos.T_DetalleAnexoTarifaElecAlt = []; 
				}
				scope.anexos.T_DetalleAnexoTarifaElecAlt.push({CodTarEle:Tarifa_Elec_Alta.CodTarEle});
				for (var index = 0; index <= scope.anexos.T_DetalleAnexoTarifaElecAlt.length; index++) 
				{
				        scope.anexos[index]=index;
				}
				console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
			});
		}
		else
		{
			scope.disabled_all_alta=0;			
			console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
		}	
	}		
	scope.limpiar_Servicio_Electrico=function(SerEle)
	{
		if(SerEle==false)
		{
			scope.anexos.AggAllBaj=false;
			scope.anexos.AggAllAlt=false;
			scope.disabled_all_baja=0;
			scope.disabled_all_alta=0;
			scope.anexos.T_DetalleAnexoTarifaElecBaj = [];
			scope.anexos.T_DetalleAnexoTarifaElecAlt = [];				
			scope.select_tarifa_Elec_Alt=[];
			scope.select_tarifa_Elec_Baj=[];
			console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
			console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
		}
	}
	scope.limpiar_Servicio_Gas=function(SerGas)
	{
		if(SerGas==false)
		{
			scope.Todas_Gas=false;
			scope.disabled_all=0;
			scope.anexos.T_DetalleAnexoTarifaGas=[];			
			scope.select_tarifa_gas=[];
			scope.anexos.T_DetalleAnexoTarifaGas=[];
			console.log(scope.anexos.T_DetalleAnexoTarifaGas);
		}
	}
	scope.limpiar_anexo=function()
	{
		scope.anexos.CodTProCom=undefined;
		scope.anexos.CodPro=undefined;
		scope.anexos.DesAnePro=undefined;
		scope.anexos.SerEle=false;
		scope.anexos.SerGas=false;
		scope.anexos.AggAllBaj=false;
		scope.select_tarifa_Elec_Baj=[];
		scope.anexos.T_DetalleAnexoTarifaElecBaj = [];		
		scope.disabled_all_baja=0;		
		scope.anexos.AggAllAlt=false;	
		scope.select_tarifa_Elec_Alt=[];
		scope.anexos.T_DetalleAnexoTarifaElecAlt = [];
		scope.disabled_all_alta=0;
		scope.select_tarifa_gas=[];
		scope.anexos.T_DetalleAnexoTarifaGas=[];
		scope.Todas_Gas=false;
		scope.disabled_all=0;
		scope.FecIniAneA=fecha;
		scope.validate_info_anexos=0;
		document.getElementById('file_anexo').value ='';	
		scope.anexos.DocAnePro=undefined;
		scope.anexos.CodTipCom=undefined;
		scope.anexos.ObsAnePro=undefined;
		scope.anexos.CodAnePro=undefined;	
	}
	scope.validar_campos_anexos = function()
	{
		resultado = true;								
		if (!scope.anexos.CodTProCom > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Comercializadora.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}				
		if (!scope.anexos.CodPro > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Producto.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}				
		if (scope.anexos.DesAnePro==null || scope.anexos.DesAnePro==undefined || scope.anexos.DesAnePro=='')
		{
			Swal.fire({title:"El Nombre del Anexo es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
			return false;
		}
		if (scope.anexos.SerEle==false && scope.anexos.SerGas==false)					
		{
			Swal.fire({title:"Debe Seleccionar al menos un Tipo de Suministro. Eléctrico, Gas o Ambos",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if(scope.anexos.SerEle==true)
		{	
			if(scope.anexos.T_DetalleAnexoTarifaElecBaj.length==0 && scope.anexos.T_DetalleAnexoTarifaElecAlt.length==0 || scope.anexos.T_DetalleAnexoTarifaElecBaj==false && scope.anexos.T_DetalleAnexoTarifaElecAlt==false )
			{
				Swal.fire({title:"Debe Seleccionar al menos una Tarifa de Servicio Eléctrico Sea Baja o Alta Tensión.",type:"error",confirmButtonColor:"#188ae2"});
				return false;	
			}
		}
		if(scope.anexos.SerGas==true)
		{
			console.log(scope.anexos.T_DetalleAnexoTarifaGas);
			if(scope.anexos.T_DetalleAnexoTarifaGas.length==0)
			{
				Swal.fire({title:"Debe Seleccionar una Tarifa Gas.",type:"error",confirmButtonColor:"#188ae2"});
				return false;	
			}
		}
		if (scope.anexos.Fijo==false && scope.anexos.Indexado==false)					
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Precio. Fijo, Indexado o Ambos",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.anexos.CodTipCom > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Comisión.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.anexos.ObsAnePro==undefined || scope.anexos.ObsAnePro==null || scope.anexos.ObsAnePro=='')
		{
			scope.anexos.ObsAnePro=null;
		}
		else
		{
			scope.anexos.ObsAnePro=scope.anexos.ObsAnePro;
		}
		
		if (resultado == false)
		{
			//quiere decir que al menos un renglon no paso la validacion
			return false;
		} 
		return true;
	} 
	scope.filtrar_productos_com =  function()
	{
		scope.TProductosActivosFiltrados = $filter('filter')(scope.TProductosActivos, {CodCom: scope.anexos.CodTProCom}, true);
		
	}
	$scope.submitFormAnexos = function(event) 
	{
	 	if(scope.anexos.CodAnePro==undefined)
	 	{
	 		var titulo='Guardando_Anexo';
	 		var titulo2='Guardado';
	 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	 	}
	 	else
	 	{
	 		var titulo='Actualizando_Anexo';
	 		var titulo2='Actualizado';
	 		var texto='¿Esta Seguro de Actualizar este registro.?';
	 	}
		if (!scope.validar_campos_anexos())
		{
			return false;
		}		
		let archivos_anexos2 = $archivosanexos.files;
		//console.log($archivosanexos.files);
		//console.log(archivos_anexos2);
	 	if($archivosanexos.files.length>0)
	 	{	
	 		//console.log($archivosanexos.files);
		 	if($archivosanexos.files[0].type=="application/pdf")
		 	{
		 		console.log('Archivo Permitido');
		 		var tipo_file=($archivosanexos.files[0].type).split("/");$archivosanexos.files[0].type;
		 		//console.log(tipo_file[1]);		 		
		 		$scope.uploadFileAnexo();
				scope.anexos.DocAnePro='documentos/'+$archivosanexos.files[0].name;
		 	}
		 	else	 	
		 	{
		 		//console.log('Archivo No Permitido');
		 		Swal.fire({title:'Error',text:"Formato incorrecto solo se permite archivos PDF",type:"error",confirmButtonColor:"#188ae2"});		 		
				scope.anexos.DocAnePro=null;
				document.getElementById('file_anexo').value ='';
				return false;
			}
	 	}
	 	else
	 	{
	 		scope.anexos.DocAnePro=null;
	 	}

	 	if(scope.anexos.SerEle==false)
	 	{
		 	if(scope.anexos.T_DetalleAnexoTarifaElecAlt.length==0)
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecAlt=false;
		 	}
		 	else
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecAlt=scope.anexos.T_DetalleAnexoTarifaElecAlt;
		 	}
		 	
		 	if(scope.anexos.T_DetalleAnexoTarifaElecBaj.length==0)
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecBaj=false;
		 	}
		 	else
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecBaj=scope.anexos.T_DetalleAnexoTarifaElecBaj;
		 	}
	 	}
	 	else
	 	{
	 		if(scope.anexos.T_DetalleAnexoTarifaElecAlt.length==0 ||scope.anexos.T_DetalleAnexoTarifaElecAlt==false)
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecAlt=false;
		 	}
		 	else
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecAlt=scope.anexos.T_DetalleAnexoTarifaElecAlt;
		 	}
		 	
		 	if(scope.anexos.T_DetalleAnexoTarifaElecBaj.length==0)
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecBaj=false;
		 	}
		 	else
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaElecBaj=scope.anexos.T_DetalleAnexoTarifaElecBaj;
		 	}
	 	}	 	
	 	if(scope.anexos.SerGas==false)
	 	{
		 	if(scope.anexos.T_DetalleAnexoTarifaGas.length==0)
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaGas=false;
		 	}
		 	else
		 	{
		 		scope.anexos.T_DetalleAnexoTarifaGas=scope.anexos.T_DetalleAnexoTarifaGas;
		 	}
	 	}	 	
	 	console.log(scope.anexos);
	 	Swal.fire({title:titulo2,
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
	           	    var url = base_urlHome()+"api/Configuraciones_Generales/registrar_anexos/";
	           	    $http.post(url,scope.anexos).then(function(result)
	           	    {
	           	    	scope.nIDAnexos=result.data.CodAnePro;
	           	    	if(result.data!=false)
	           	    	{
	           	    		$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:titulo2,text:"Los datos han sido "+titulo2+" con Exito.",type:"success",confirmButtonColor:"#188ae2"});
	           	    		document.getElementById('file_anexo').value ='';
	           	    		scope.buscarXIDAnexos();
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

	scope.buscarXIDAnexos=function()
	{
		 $("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/Buscar_xID_Anexos/CodAnePro/"+scope.nIDAnexos;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		//scope.anexos=result.data;
		 		scope.anexos={};
		 		var index = 0;
		 		scope.index  = 0;
		 		scope.anexos.CodTProCom=result.data.CodCom;							
				scope.anexos.CodAnePro=result.data.CodAnePro;
				scope.anexos.CodPro=result.data.CodPro;
				scope.anexos.DesAnePro=result.data.DesAnePro;
				scope.FecIniAneA=result.data.FecIniAne;
				if(result.data.SerEle==0)
				{
					scope.anexos.SerEle=false;
					scope.anexos.T_DetalleAnexoTarifaElecBaj=[];
					scope.anexos.T_DetalleAnexoTarifaElecAlt=[];
					scope.select_tarifa_Elec_Baj=[];
					scope.select_tarifa_Elec_Alt=[];
				}
				else
				{
					scope.anexos.SerEle=true;
					scope.anexos.T_DetalleAnexoTarifaElecBaj=[];
					scope.anexos.T_DetalleAnexoTarifaElecAlt=[];
					scope.select_tarifa_Elec_Baj=[];
					scope.select_tarifa_Elec_Alt=[];
					angular.forEach(result.data.T_DetalleAnexoTarifaElec, function(Tarifa_Electrica)
					{
						if(Tarifa_Electrica.TipTen==0)
						{
							var ObjTarifaElecBaja = new Object();	
							scope.select_tarifa_Elec_Baj[Tarifa_Electrica.CodTarEle]=Tarifa_Electrica;
							var ObjTarifaGas = new Object();	
								if (scope.anexos.T_DetalleAnexoTarifaElecBaj==undefined || scope.anexos.T_DetalleAnexoTarifaElecBaj==false)
								{
									scope.anexos.T_DetalleAnexoTarifaElecBaj = []; 
								}
								scope.anexos.T_DetalleAnexoTarifaElecBaj.push({CodTarEle:Tarifa_Electrica.CodTarEle});
								console.log(scope.anexos.T_DetalleAnexoTarifaElecBaj);
						}
						else
						{	
							scope.select_tarifa_Elec_Alt[Tarifa_Electrica.CodTarEle]=Tarifa_Electrica;
							var ObjTarifaElecAlt = new Object();
								if (scope.anexos.T_DetalleAnexoTarifaElecAlt==undefined || scope.anexos.T_DetalleAnexoTarifaElecAlt==false)
								{
									scope.anexos.T_DetalleAnexoTarifaElecAlt = []; 
								}
								scope.anexos.T_DetalleAnexoTarifaElecAlt.push({CodTarEle:Tarifa_Electrica.CodTarEle});
								console.log(scope.anexos.T_DetalleAnexoTarifaElecAlt);
						}
					});
				}
				if(result.data.SerGas==0)
				{
					scope.anexos.SerGas=false;
					scope.anexos.T_DetalleAnexoTarifaGas=[];
					scope.select_tarifa_gas=[];
				}
				else
				{
					scope.anexos.SerGas=true;
					scope.anexos.T_DetalleAnexoTarifaGas=[];
					scope.select_tarifa_gas=[];
					scope.anexos.T_DetalleAnexoTarifaGas=result.data.T_DetalleAnexoTarifaGas;
					angular.forEach(scope.anexos.T_DetalleAnexoTarifaGas, function(select_tarifa_gas)
					{					
						scope.select_tarifa_gas[select_tarifa_gas.CodTarGas]=select_tarifa_gas;						
									
					});
				}
				if(result.data.TipPre==0)
				{
					scope.anexos.Fijo=true;
				}
				if(result.data.TipPre==1)
				{
					scope.anexos.Indexado=true;
				}
				if(result.data.TipPre==2)
				{
					scope.anexos.Fijo=true;
					scope.anexos.Indexado=true;
				}

				scope.anexos.DocAnePro=result.data.DocAnePro;
				scope.anexos.CodTipCom=result.data.CodTipCom;
				scope.anexos.ObsAnePro=result.data.ObsAnePro;
				scope.anexos.AggAllBaj=false;
				scope.anexos.AggAllAlt=false;
				scope.Todas_Gas=false;
				scope.disabled_all_baja=0;
				scope.disabled_all_alta=0;
				scope.disabled_all	=0;
				//console.log(result.data);
				console.log(scope.anexos);
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
	$scope.submitFormlockAnexos = function(event) 
	{
	 	if(scope.anexos_motivo_bloqueos.ObsMotBloAne==undefined||scope.anexos_motivo_bloqueos.ObsMotBloAne==null||scope.anexos_motivo_bloqueos.ObsMotBloAne=='')
	 	{
	 		scope.anexos_motivo_bloqueos.ObsMotBloAne=null;
	 	}
	 	else
	 	{
	 		scope.anexos_motivo_bloqueos.ObsMotBloAne=scope.anexos_motivo_bloqueos.ObsMotBloAne;
	 	}
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Este Anexo?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            console.log(scope.t_modal_data);
	            scope.cambiar_estatus_anexos(scope.anexos_motivo_bloqueos.EstAne,scope.anexos_motivo_bloqueos.CodAnePro);
	        }
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	        });		
	};


////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE ANEXOS END///////////////////////////////////////////////////



////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES START///////////////////////////////////////////////////



scope.cargar_lista_servicos_especiales=function()
{
	//$("#List_Produc").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	var url=base_urlHome()+"api/Configuraciones_Generales/get_list_servicos_especiales/";
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			$scope.predicate3 = 'id';  
			$scope.reverse3 = true;						
			$scope.currentPage3 = 1;  
			$scope.order3 = function (predicate3) 
			{  
				$scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
				$scope.predicate3 = predicate3;  
			}; 						
			scope.TServicioEspeciales =result.data;
			scope.TServicioEspecialesBack =result.data; 	 								
			$scope.totalItems3 = scope.TServicioEspeciales.length; 
			$scope.numPerPage3 = 50;  
			$scope.paginate3 = function (value3) 
			{  
				var begin3, end3, index3;  
				begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
				end3 = begin3 + $scope.numPerPage3;  
				index3 = scope.TServicioEspeciales.indexOf(value3);  
				return (begin3 <= index3 && index3 < end3);  
			};
		}
		else
		{
			//$("#List_Produc").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			console.log('No hemos encontrado Servicios Especiales registrados.');
			//Swal.fire({title:"Productos.",text:"No hemos encontrado Productos Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
			scope.TServicioEspeciales=undefined;
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
scope.validar_opcion_servicios_especiales=function(index,opciones_servicio_especiales,dato)
{
	console.log(index);
	console.log(opciones_servicio_especiales);
	console.log(dato);	
	if(opciones_servicio_especiales==1)
	{
		scope.opciones_servicio_especiales[index]=undefined;
		if(dato.EstSerEsp=="ACTIVO")
		{
			Swal.fire({title:"Error",text:"Este Servicio Especial ya se encuentra activo.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		Swal.fire({title:"¿Esta Seguro de Activar Este Servicio Especial?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
	              	scope.opciones_servicio_especiales[index]=undefined;
					scope.cambiar_estatus_servicio_especial(opciones_servicio_especiales,dato.CodSerEsp,index); 
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_servicio_especiales[index]=undefined;
	            }
	        });	
	



	}
	if(opciones_servicio_especiales==2)
	{
		scope.opciones_servicio_especiales[index]=undefined;
		if(dato.EstSerEsp=="BLOQUEADO")
		{
			Swal.fire({title:"Error",text:"Este Servicio Especial ya se encuentra bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
			scope.opciones_servicio_especiales[index]=undefined;
			scope.servicio_especial_bloqueo={};
			scope.RazSocCom_BloSerEsp=dato.NumCifCom+" - "+dato.RazSocCom;
			scope.DesSerEsp_Blo=dato.DesSerEsp;
			scope.FecBloSerEsp=fecha;
			scope.servicio_especial_bloqueo.CodSerEsp=dato.CodSerEsp;
			scope.servicio_especial_bloqueo.EstSerEsp=opciones_servicio_especiales;
			$("#modal_motivo_bloqueo_servicio_especial").modal('show');
	}
	if(opciones_servicio_especiales==3)
	{
		scope.opciones_servicio_especiales[index]=undefined;
		scope.TvistaServiciosEspeciales=2;
		scope.servicio_especial={};
		scope.nIDSerEsp=dato.CodSerEsp;
		scope.buscarXIDServicioEspecial();		
		scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj =[]; 
		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt =[]; 
		scope.validate_info_servicio_especiales=0;
	}
	if(opciones_servicio_especiales==4)
	{
		scope.opciones_servicio_especiales[index]=undefined;
		scope.TvistaServiciosEspeciales=2;
		scope.servicio_especial={};
		scope.nIDSerEsp=dato.CodSerEsp;
		scope.buscarXIDServicioEspecial();		
		scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj =[]; 
		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt =[]; 
		scope.validate_info_servicio_especiales=1;

	}
}
scope.cambiar_estatus_servicio_especial=function(opciones_servicio_especiales,CodSerEsp,index)
	{
		scope.status_servicio_especial={};
		scope.status_servicio_especial.EstSerEsp=opciones_servicio_especiales;
		scope.status_servicio_especial.CodSerEsp=CodSerEsp;
		
		if(opciones_servicio_especiales==2)
		{
			scope.status_servicio_especial.MotBloSerEsp=scope.servicio_especial_bloqueo.MotBloSerEsp;
			scope.status_servicio_especial.ObsMotBloSerEsp=scope.servicio_especial_bloqueo.ObsMotBloSerEsp;
			console.log(scope.status_servicio_especial);
		}
		console.log(scope.status_servicio_especial);
		$("#estatus").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/cambiar_estatus_servicio_especial/";
		 $http.post(url,scope.status_servicio_especial).then(function(result)
		 {
		 	if(result.data.resultado!=false)
		 	{
		 		if(opciones_servicio_especiales==1)
		 		{
		 			var title='Activando.';
		 			var text='El Servicio Especial a sido activado con exito.';
		 		}
		 		if(opciones_servicio_especiales==2)
		 		{
		 			var title='Bloquear.';
		 			var text='El Servicio Especial a sido bloqueado con exito.';
		 			$("#modal_motivo_bloqueo_servicio_especial").modal('hide');
		 		}

		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		Swal.fire({title:title,text:text,type:"success",confirmButtonColor:"#188ae2"});
		 		scope.opciones_servicio_especiales[index]=undefined;
		 		scope.cargar_lista_servicos_especiales();
		 	}
		 	else
		 	{
		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos podido actualizar el estatus del producto.",type:"error",confirmButtonColor:"#188ae2"});
				scope.cargar_lista_servicos_especiales();
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
	$scope.submitFormlockServicioEspecial = function(event) 
	{
	 	if(scope.servicio_especial_bloqueo.ObsMotBloSerEsp==undefined||scope.servicio_especial_bloqueo.ObsMotBloSerEsp==null||scope.servicio_especial_bloqueo.ObsMotBloSerEsp=='')
	 	{
	 		scope.servicio_especial_bloqueo.ObsMotBloSerEsp=null;
	 	}
	 	else
	 	{
	 		scope.servicio_especial_bloqueo.ObsMotBloSerEsp=scope.servicio_especial_bloqueo.ObsMotBloSerEsp;
	 	}
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Este Servicio Especial?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            console.log(scope.servicio_especial_bloqueo);
	            scope.cambiar_estatus_servicio_especial(scope.servicio_especial_bloqueo.EstSerEsp,scope.servicio_especial_bloqueo.CodSerEsp);
	        }
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	        });		
	};
scope.agg_servicio_especial=function()
{
	scope.TvistaServiciosEspeciales=2;
	scope.servicio_especial={};
	scope.FecIniSerEsp=fecha;	
	scope.select_tarifa_Elec_Baj_SerEsp=[];
	scope.select_tarifa_Elec_Alt_SerEsp=[];
	scope.select_tarifa_gas_SerEsp=[];
	scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
	scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj =[]; 
	scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt =[]; 
	scope.servicio_especial.SerGas=false;
	scope.servicio_especial.SerEle=false;
	scope.servicio_especial.AggAllBaj=false;
	scope.servicio_especial.AggAllAlt=false;
	console.log(scope.TvistaServiciosEspeciales);
}
scope.regresar_servicios_especiales=function()
{
	Swal.fire({title:"Regresar",
		text:"Esta Seguro de Regresar?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Confirmar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	scope.TvistaServiciosEspeciales=1;
				scope.servicio_especial={};
				scope.select_tarifa_Elec_Baj_SerEsp=[];
				scope.select_tarifa_Elec_Alt_SerEsp=[];
				scope.select_tarifa_gas_SerEsp=[];
				scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
				scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj =[]; 
				scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt =[]; 
				scope.servicio_especial.SerGas=false;
				scope.servicio_especial.SerEle=false;
				scope.servicio_especial.AggAllBaj=false;
				scope.servicio_especial.AggAllAlt=false;
				scope.cargar_lista_servicos_especiales();
				console.log(scope.TvistaServiciosEspeciales);	   
	        }
	        else
	        {
					console.log('Cancelando Ando...');
					//event.preventDefault();						
	        }
	    });	

}
scope.limpiar_servicio_especial=function()
{
	scope.servicio_especial={};
	scope.select_tarifa_Elec_Baj_SerEsp=[];
	scope.select_tarifa_Elec_Alt_SerEsp=[];
	scope.select_tarifa_gas_SerEsp=[];
	scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
	scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj =[]; 
	scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt =[]; 
	scope.servicio_especial.SerGas=false;
	scope.servicio_especial.SerEle=false;
	scope.servicio_especial.AggAllBaj=false;
	scope.servicio_especial.AggAllAlt=false;
	console.log(scope.TvistaServiciosEspeciales);
}
$scope.submitFormServiciosEspeciales = function(event) 
{
	if(scope.servicio_especial.CodSerEsp==undefined)
	{
		var titulo='Guardando_Anexo';
		var titulo2='Guardado';
		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	}
	else
	{
		var titulo='Actualizando_Anexo';
		var titulo2='Actualizado';
		var texto='¿Esta Seguro de Actualizar este registro.?';
	}
	if (!scope.validar_campos_servicio_especial())
	{
		return false;
	}	
	console.log(scope.servicio_especial);
	Swal.fire({title:titulo2,
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
	        var url = base_urlHome()+"api/Configuraciones_Generales/registrar_servicios_especiales/";
	        $http.post(url,scope.servicio_especial).then(function(result)
	        {
	           	scope.nIDSerEsp=result.data.CodSerEsp;
	           	if(result.data!=false)
	           	{
	           	    $("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:titulo2,text:"Los datos han sido "+titulo2+" con Exito.",type:"success",confirmButtonColor:"#188ae2"});
	           	    scope.servicio_especial=result.data;
	           	    scope.buscarXIDServicioEspecial();
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
	scope.validar_campos_servicio_especial = function()
	{
		resultado = true;								
		if (!scope.servicio_especial.CodCom > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Comercializadora.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}			
					
		if (scope.servicio_especial.DesSerEsp==null || scope.servicio_especial.DesSerEsp==undefined || scope.servicio_especial.DesSerEsp=='')
		{
			Swal.fire({title:"El Nombre del Servicio Especial es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
			return false;
		}
		if (scope.servicio_especial.SerEle==false && scope.servicio_especial.SerGas==false)					
		{
			Swal.fire({title:"Debe Seleccionar al menos un tipo de suministro.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if(scope.servicio_especial.SerEle==true)
		{	
			if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length==0 && scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length==0 || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==false && scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==false )
			{
				Swal.fire({title:"Debe Seleccionar al menos una Tarifa de Servicio Eléctrico Sea Baja o Alta Tensión.",type:"error",confirmButtonColor:"#188ae2"});
				return false;	
			}
		}
		if(scope.servicio_especial.SerGas==true)
		{
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
			if(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length==0)
			{
				Swal.fire({title:"Debe Seleccionar una Tarifa Gas.",type:"error",confirmButtonColor:"#188ae2"});
				return false;	
			}
		}
		if (!scope.servicio_especial.TipCli > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Cliente.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.servicio_especial.CarSerEsp==null || scope.servicio_especial.CarSerEsp==undefined || scope.servicio_especial.CarSerEsp=='')
		{
			Swal.fire({title:"La Características del Servicio Especial es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
			return false;
		}
		if (!scope.servicio_especial.CodTipCom > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Comisión.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.servicio_especial.OsbSerEsp==undefined || scope.servicio_especial.OsbSerEsp==null || scope.servicio_especial.OsbSerEsp=='')
		{
			scope.servicio_especial.OsbSerEsp=null;
		}
		else
		{
			scope.servicio_especial.OsbSerEsp=scope.servicio_especial.OsbSerEsp;
		}
		if(scope.servicio_especial.SerEle==false)
	 	{
		 	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length==0)
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt=false;
		 	}
		 	else
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt=scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt;
		 	}
		 	
		 	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length==0)
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj=false;
		 	}
		 	else
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj=scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj;
		 	}
	 	}
	 	else
	 	{
	 		if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length==0 ||scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==false)
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt=false;
		 	}
		 	else
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt=scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt;
		 	}
		 	
		 	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length==0)
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj=false;
		 	}
		 	else
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj=scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj;
		 	}
	 	}	 	
	 	if(scope.servicio_especial.SerGas==false)
	 	{
		 	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length==0)
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=false;
		 	}
		 	else
		 	{
		 		scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=scope.servicio_especial.T_DetalleServicioEspecialTarifaGas;
		 	}
	 	}	
		
		if (resultado == false)
		{
			//quiere decir que al menos un renglon no paso la validacion
			return false;
		} 
		return true;
	} 
	scope.buscarXIDServicioEspecial=function()
	{
		 $("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Configuraciones_Generales/Buscar_xID_ServicioEspecial/CodSerEsp/"+scope.nIDSerEsp;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		//scope.anexos=result.data;
		 		scope.servicio_especial={};
		 		var index = 0;
		 		scope.index  = 0;		 								
				scope.servicio_especial.CodSerEsp=result.data.CodSerEsp;
				scope.servicio_especial.CodCom=result.data.CodCom;
				scope.servicio_especial.DesSerEsp=result.data.DesSerEsp;
				scope.FecIniSerEsp=result.data.FecIniSerEsp;
				if(result.data.SerEle=="NO")
				{
					scope.servicio_especial.SerEle=false;
					scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj=[];
					scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt=[];
					scope.select_tarifa_Elec_Baj_SerEsp=[];
					scope.select_tarifa_Elec_Alt_SerEsp=[];
				}
				else
				{
					scope.servicio_especial.SerEle=true;
					scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj=[];
					scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt=[];
					scope.select_tarifa_Elec_Baj_SerEsp=[];
					scope.select_tarifa_Elec_Alt_SerEsp=[];
					angular.forEach(result.data.T_DetalleServicioEspecialTarifaEle, function(Tarifa_Electrica)
					{
						if(Tarifa_Electrica.TipTen==0)
						{
							var ObjTarifaElecBaja = new Object();	
							scope.select_tarifa_Elec_Baj_SerEsp[Tarifa_Electrica.CodTarEle]=Tarifa_Electrica;
							var ObjTarifaGas = new Object();	
								if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==false)
								{
									scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = []; 
								}
								scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({CodTarEle:Tarifa_Electrica.CodTarEle});
								console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
						}
						else
						{	
							scope.select_tarifa_Elec_Alt_SerEsp[Tarifa_Electrica.CodTarEle]=Tarifa_Electrica;
							var ObjTarifaElecAlt = new Object();
								if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==false)
								{
									scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = []; 
								}
								scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({CodTarEle:Tarifa_Electrica.CodTarEle});
								console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
						}
					});
				}
				if(result.data.SerGas=="NO")
				{
					scope.servicio_especial.SerGas=false;
					scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
					scope.select_tarifa_gas_SerEsp=[];
				}
				else
				{
					scope.servicio_especial.SerGas=true;
					scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=[];
					scope.select_tarifa_gas_SerEsp=[];
					scope.servicio_especial.T_DetalleServicioEspecialTarifaGas=result.data.T_DetalleServicioEspecialTarifaGas;
					angular.forEach(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas, function(select_tarifa_gas)
					{					
						scope.select_tarifa_gas_SerEsp[select_tarifa_gas.CodTarGas]=select_tarifa_gas;						
									
					});
				}
				scope.servicio_especial.TipCli=result.data.TipCli;
				scope.servicio_especial.CarSerEsp=result.data.CarSerEsp;
				scope.servicio_especial.CodTipCom=result.data.CodTipCom;
				scope.servicio_especial.OsbSerEsp=result.data.OsbSerEsp;
				scope.servicio_especial.AggAllBaj=false;
				scope.servicio_especial.AggAllAlt=false;
				scope.Todas_Gas_SerEsp=false;
				scope.disabled_all_baja_SerEsp=0;
				scope.disabled_all_alta_SerEsp=0;
				scope.disabled_all_SerEsp	=0;
				//console.log(result.data);
				console.log(scope.servicio_especial);
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
	scope.agregar_tarifa_elec_baja_SerEsp=function(index,CodTarEle,opcion_tension_baja)
	{
		console.log(index);
		console.log(opcion_tension_baja);
		console.log(CodTarEle);
		var ObjTarifaElecBaja = new Object();	
		scope.select_tarifa_Elec_Baj_SerEsp[CodTarEle]=opcion_tension_baja;
		var ObjTarifaGas = new Object();	
			if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==false)
			{
				scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = []; 
			}
			scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({CodTarEle:opcion_tension_baja.CodTarEle});
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
	}
	scope.quitar_tarifa_elec_baja_SerEsp=function(index,CodTarEle,opcion_tension_baja)
	{
		console.log(index);
		console.log(opcion_tension_baja);
		console.log(CodTarEle);
		scope.select_tarifa_Elec_Baj_SerEsp[CodTarEle]=false;
		i=0;
		for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; i++) 
	    {
	      	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj[i].CodTarEle==CodTarEle)
	       	{
		   		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.splice(i,1);
	       	}
		}
		console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
	}
	scope.agregar_todas_baja_tension_SerEsp=function(full_datos,AggAllBaj)
	{
		console.log(full_datos);
		if(AggAllBaj==true)
		{
			scope.disabled_all_baja_SerEsp=1;
			angular.forEach(scope.Tarifa_Elec_Baja, function(Tarifa_Elec_Baja)
			{
				
				if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj!=false)
				{
					if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length>0)
					{
						for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; i++) 
					    {
					        if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj[i].CodTarEle==Tarifa_Elec_Baja.CodTarEle)
					       	{
					       		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.splice(i,1);
					        }
						}
					}
				}
				var ObjTarifaGas = new Object();
				scope.select_tarifa_Elec_Baj_SerEsp[Tarifa_Elec_Baja.CodTarEle]=Tarifa_Elec_Baja;
				
				if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj==false)
				{
					scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = []; 
				}
				scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({CodTarEle:Tarifa_Elec_Baja.CodTarEle});
				for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; index++) 
				{
				        scope.servicio_especial[index]=index;
				}
				console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
			});
		}
		else
		{
			scope.disabled_all_baja_SerEsp=0;			
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
		}	
	}
	scope.agregar_tarifa_elec_alta_SerEsp=function(index,CodTarEle,opcion_tension_alta)
	{
		console.log(index);
		console.log(CodTarEle);
		console.log(opcion_tension_alta);	
		scope.select_tarifa_Elec_Alt_SerEsp[CodTarEle]=opcion_tension_alta;
		var ObjTarifaElecAlt = new Object();
			if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==false)
			{
				scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = []; 
			}
			scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({CodTarEle:opcion_tension_alta.CodTarEle});
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
	}
	scope.quitar_tarifa_elec_alta_SerEsp=function(index,CodTarEle,opcion_tension_alta)
	{
		console.log(index);
		console.log(opcion_tension_alta);
		console.log(CodTarEle);
		scope.select_tarifa_Elec_Alt_SerEsp[CodTarEle]=false;
		i=0;
		for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; i++) 
	    {
	      	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt[i].CodTarEle==CodTarEle)
	       	{
		   		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.splice(i,1);
	       	}
		}
		console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
	}
	scope.agregar_todas_alta_tension_SerEsp=function(full_datos,AggAllAlt)
	{
		console.log(full_datos);
		if(AggAllAlt==true)
		{
			scope.disabled_all_alta_SerEsp=1;
			angular.forEach(scope.Tarifa_Elec_Alt, function(Tarifa_Elec_Alta)
			{
				if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt!=false)
				{
					if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length>0)
					{
						for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; i++) 
					    {
					        if(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt[i].CodTarEle==Tarifa_Elec_Alta.CodTarEle)
					       	{
					       		scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.splice(i,1);
					        }
						}
					}	
				}							
				var ObjTarifaGas = new Object();
				scope.select_tarifa_Elec_Alt_SerEsp[Tarifa_Elec_Alta.CodTarEle]=Tarifa_Elec_Alta;
				
				if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt==false)
				{
					scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = []; 
				}
				scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({CodTarEle:Tarifa_Elec_Alta.CodTarEle});
				for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; index++) 
				{
				        scope.servicio_especial[index]=index;
				}
				console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
			});
		}
		else
		{
			scope.disabled_all_alta_SerEsp=0;			
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
		}	
	}
	scope.agregar_tarifa_gas_individual_SerEsp=function(index,dato,CodTarGas)
	{
		scope.select_tarifa_gas_SerEsp[CodTarGas]=dato;
		var ObjTarifaGasSerEsp = new Object();	
			if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaGas==false)
			{
				scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = []; 
			}
			scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.push({CodTarGas:dato.CodTarGas});
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
	}
	scope.quitar_tarifa_gas_SerEsp=function(index,CodTarGas,tarifa_gas)
	{
		scope.select_tarifa_gas_SerEsp[CodTarGas]=false;
		i=0;
		for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; i++) 
	    {
	      	if(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas[i].CodTarGas==CodTarGas)
	       	{
		   		scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.splice(i,1);
	       	}
		}
		console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
	}
	scope.agregar_todas_detalle_SerEsp=function(valor)
	{
		if(valor==true)
		{
			scope.disabled_all_SerEsp=1;
			angular.forEach(scope.Tarifa_Gas_Anexos, function(Tarifa)
			{
				if(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas!=false)
				{
					if(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length>0)
					{
						for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; i++) 
					    {
					        if(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas[i].CodTarGas==Tarifa.CodTarGas)
					       	{
					       		scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.splice(i,1);
					        }
						}
					}
				}
				
				
				var ObjTarifaGas = new Object();
				scope.select_tarifa_gas_SerEsp[Tarifa.CodTarGas]=Tarifa;
				
				if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas==undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaGas==false)
				{
					scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = []; 
				}
				scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.push({CodTarGas:Tarifa.CodTarGas});
				for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; index++) 
				{
				        scope.servicio_especial[index]=index;
				}
				console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
			});
		}
		else
		{
			scope.disabled_all_SerEsp=0;			
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
		}		
	}
	scope.limpiar_Servicio_Electrico_SerEsp=function(SerEle)
	{
		if(SerEle==false)
		{
			scope.servicio_especial.AggAllBaj=false;			
			scope.disabled_all_baja_SerEsp=0;
			scope.select_tarifa_Elec_Baj_SerEsp=[];
			scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];

			scope.disabled_all_alta_SerEsp=0;
			scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];				
			scope.select_tarifa_Elec_Alt_SerEsp=[];
			scope.servicio_especial.AggAllAlt=false;
			
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
			console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
		}
	}
	scope.limpiar_Servicio_Gas_SerEsp=function(SerGas)
	{
		if(SerGas==false)
		{
			scope.Todas_Gas_SerEsp=false;
			scope.disabled_all_SerEsp=0;
			scope.servicio_especial.T_DetalleAnexoTarifaGas=[];			
			scope.select_tarifa_gas_SerEsp=[];
			scope.servicio_especial.T_DetalleAnexoTarifaGas=[];
			console.log(scope.servicio_especial.T_DetalleAnexoTarifaGas);
		}
	}


////////////////////////////////////////////////////////////PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES END///////////////////////////////////////////////////


	
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