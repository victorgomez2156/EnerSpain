 app.controller('Controlador_Contactos', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','$compile','ServiceMaster','upload', Controlador])
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
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,$compile,ServiceMaster,upload)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('Controlador_Clientes as vmAE',{$scope:$scope});
	//var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
	//$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
	//var testCtrl1ViewModel = $controller('Controlador_Clientes');
   	//testCtrl1ViewModel.cargar_lista_clientes();
	var scope = this;
	scope.fdatos = {};
	scope.tContacto_data_modal={};
	scope.nID = $route.current.params.ID;
	scope.no_editable = $route.current.params.INF;
	scope.Nivel = $cookies.get('nivel');
	scope.CIF_Contacto = $cookies.get('CIF_Contacto');
	//const $archivosanexos = document.querySelector("#file_anexo");
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
////////////////////////////////////////////////// PARA LOS CONTACTOS START ////////////////////////////////////////////////////////
console.log($route.current.$$route.originalPath);
if($route.current.$$route.originalPath=="/Add_Contactos/")
{
	console.log(scope.CIF_Contacto);
	if(scope.CIF_Contacto==undefined)
	{
		Swal.fire({title:"Error.",text:"El Número de CIF del Contacto No Puede Estar Vacio.",type:"info",confirmButtonColor:"#188ae2"});
		location.href="#/Contactos";
	}
	else
	{
		scope.tContacto_data_modal.NIFConCli=scope.CIF_Contacto;
		scope.tContacto_data_modal.EsRepLeg=undefined;
		scope.tContacto_data_modal.TieFacEsc=undefined;					
		scope.tContacto_data_modal.CanMinRep=1;
		scope.tContacto_data_modal.TipRepr="1";
	}
}
///////////////////////////// CONTACTOS CLIENTES START ///////////////////////////	
	scope.ruta_reportes_pdf_Contactos=0;
	scope.ruta_reportes_excel_Contactos=0;
	scope.ClieCont=true;
	scope.NomConCli=true;
	scope.NIFConCli=true;
	scope.CodTipCon=true;
	scope.CarConCli=true;
	scope.EstConCli=true;
	scope.ActCont=true;
	scope.T_Filtro_Contactos = [{id: 1, nombre: 'Tipo de Contacto'},{id: 2, nombre: 'Representante Legal'},{id: 3, nombre: 'Tipo de Representación'},{id: 4, nombre: 'Estatus'}];
	scope.tListaRepre = [{id: 1, DesTipRepr: 'INDEPENDIENTE'},{id: 2, DesTipRepr: 'MANCOMUNADA'}];
	scope.tmodal_contacto={};
	const $Archivo_DocNIF = document.querySelector("#DocNIF");
	const $Archivo_DocPod = document.querySelector("#DocPod");
	scope.topciones = [{id: 1, nombre: 'VER'},{id: 2, nombre: 'EDITAR'},{id: 3, nombre: 'ACTIVAR'},{id: 4, nombre: 'BLOQUEAR'}];
	scope.Tabla_Contacto=[];
	scope.Tabla_ContactoBack=[];
	///////////////////////////// CONTACTOS CLIENTES END ///////////////////////////
	scope.index=0;
	scope.tListaContactos=[];	
	scope.Tabla_Contacto=[];
	scope.Tabla_ContactoBack=[];
	scope.Tclientes=[];
	ServiceMaster.getAll().then(function(dato) 
	{
		
		scope.tListaContactos = dato.Tipo_Contacto;
		scope.Tclientes=dato.Clientes;	
		scope.fecha_server=dato.Fecha_Server;
		$scope.predicate4 = 'id';  
		$scope.reverse4 = true;						
		$scope.currentPage4 = 1;  
		$scope.order4 = function (predicate4) 
		{  
			$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
			$scope.predicate4 = predicate4;  
		};	
		scope.Tabla_Contacto=dato.Contactos;
		scope.Tabla_ContactoBack=dato.Contactos;							
		$scope.totalItems4 = scope.Tabla_Contacto.length; 
		$scope.numPerPage4 = 50;  
		$scope.paginate4 = function (value4) 
		{  
			var begin4, end4, index4;  
			begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
			end4 = begin4 + $scope.numPerPage4;  
			index4 = scope.Tabla_Contacto.indexOf(value4);  
			return (begin4 <= index4 && index4 < end4);  
		};
	}).catch(function(err){console.log(err);});



scope.cargar_lista_contactos=function()
	{
		$("#cargando_contactos").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var url=base_urlHome()+"api/Clientes/lista_contactos";
		$http.get(url).then(function(result)
		{
			$("#cargando_contactos").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(result.data!=false)
			{
				
				$scope.predicate4 = 'id';  
				$scope.reverse4 = true;						
				$scope.currentPage4 = 1;  
				$scope.order4 = function (predicate4) 
				{  
					$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
					$scope.predicate4 = predicate4;  
				};	
				scope.Tabla_Contacto=result.data;
				scope.Tabla_ContactoBack=result.data;							
				$scope.totalItems4 = scope.Tabla_Contacto.length; 
				$scope.numPerPage4 = 50;  
				$scope.paginate4 = function (value4) 
				{  
					var begin4, end4, index4;  
					begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
					end4 = begin4 + $scope.numPerPage4;  
					index4 = scope.Tabla_Contacto.indexOf(value4);  
					return (begin4 <= index4 && index4 < end4);  
				};
				scope.tmodal_contacto={};
				scope.ruta_reportes_pdf_Contactos=0;
				scope.ruta_reportes_excel_Contactos=0;
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrados Contactos Registrados.",type:"info",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			$("#cargando_contactos").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}

$scope.SubmitFormFiltrosContactos = function(event) 
	{ 
		if(scope.tmodal_contacto.tipo_filtro==1)
	 	{
	 		
	 		if(!scope.tmodal_contacto.DesTipCon>0)
	 		{
				Swal.fire({title:"Error.",text:"Debe Seleccionar un tipo de contacto para aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate4 = 'id';  
			$scope.reverse4 = true;						
			$scope.currentPage4 = 1;  
			$scope.order4 = function (predicate4) 
			{  
				$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
				$scope.predicate4 = predicate4;  
			};	
			//scope.Tabla_Contacto=result.data;
			scope.Tabla_Contacto= $filter('filter')(scope.Tabla_ContactoBack, {DesTipCon: scope.tmodal_contacto.DesTipCon}, true);							
			$scope.totalItems4 = scope.Tabla_Contacto.length; 
			$scope.numPerPage4 = 50;  
			$scope.paginate4 = function (value4) 
			{  
				var begin4, end4, index4;  
				begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
				end4 = begin4 + $scope.numPerPage4;  
				index4 = scope.Tabla_Contacto.indexOf(value4);  
				return (begin4 <= index4 && index4 < end4);
			}
			scope.ruta_reportes_pdf_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.DesTipCon;
			scope.ruta_reportes_excel_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.DesTipCon;
		}
		if(scope.tmodal_contacto.tipo_filtro==2)
	 	{
	 		if(!scope.tmodal_contacto.EsRepLeg>0)
	 		{
				Swal.fire({title:"Error.",text:"Debe Seleccionar un tipo de representación legal para aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate4 = 'id';  
			$scope.reverse4 = true;						
			$scope.currentPage4 = 1;  
			$scope.order4 = function (predicate4) 
			{  
				$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
				$scope.predicate4 = predicate4;  
			};	
			//scope.Tabla_Contacto=result.data;
			scope.Tabla_Contacto= $filter('filter')(scope.Tabla_ContactoBack, {EsRepLeg: scope.tmodal_contacto.EsRepLeg}, true);							
			$scope.totalItems4 = scope.Tabla_Contacto.length; 
			$scope.numPerPage4 = 50;  
			$scope.paginate4 = function (value4) 
			{  
				var begin4, end4, index4;  
				begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
				end4 = begin4 + $scope.numPerPage4;  
				index4 = scope.Tabla_Contacto.indexOf(value4);  
				return (begin4 <= index4 && index4 < end4);
			}
			scope.ruta_reportes_pdf_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.EsRepLeg;
			scope.ruta_reportes_excel_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.EsRepLeg;
		}
		if(scope.tmodal_contacto.tipo_filtro==3)
	 	{
	 		if(!scope.tmodal_contacto.TipRepr>0)
	 		{
				Swal.fire({title:"Error.",text:"Debe Seleccionar un tipo de representación para aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate4 = 'id';  
			$scope.reverse4 = true;						
			$scope.currentPage4 = 1;  
			$scope.order4 = function (predicate4) 
			{  
				$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
				$scope.predicate4 = predicate4;  
			};	
			//scope.Tabla_Contacto=result.data;
			scope.Tabla_Contacto= $filter('filter')(scope.Tabla_ContactoBack, {representacion: scope.tmodal_contacto.TipRepr}, true);							
			$scope.totalItems4 = scope.Tabla_Contacto.length; 
			$scope.numPerPage4 = 50;  
			$scope.paginate4 = function (value4) 
			{  
				var begin4, end4, index4;  
				begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
				end4 = begin4 + $scope.numPerPage4;  
				index4 = scope.Tabla_Contacto.indexOf(value4);  
				return (begin4 <= index4 && index4 < end4);
			}
			scope.ruta_reportes_pdf_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.TipRepr;
			scope.ruta_reportes_excel_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.TipRepr;
		}
		if(scope.tmodal_contacto.tipo_filtro==4)
	 	{
	 		if(!scope.tmodal_contacto.EstConCli>0)
	 		{
				Swal.fire({title:"Error.",text:"Debe Seleccionar un Estatus para aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate4 = 'id';  
			$scope.reverse4 = true;						
			$scope.currentPage4 = 1;  
			$scope.order4 = function (predicate4) 
			{  
				$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
				$scope.predicate4 = predicate4;  
			};	
			//scope.Tabla_Contacto=result.data;
			scope.Tabla_Contacto= $filter('filter')(scope.Tabla_ContactoBack, {EstConCli: scope.tmodal_contacto.EstConCli}, true);							
			$scope.totalItems4 = scope.Tabla_Contacto.length; 
			$scope.numPerPage4 = 50;  
			$scope.paginate4 = function (value4) 
			{  
				var begin4, end4, index4;  
				begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
				end4 = begin4 + $scope.numPerPage4;  
				index4 = scope.Tabla_Contacto.indexOf(value4);  
				return (begin4 <= index4 && index4 < end4);
			}
			scope.ruta_reportes_pdf_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.EstConCli;
			scope.ruta_reportes_excel_Contactos=scope.tmodal_contacto.tipo_filtro+"/"+scope.tmodal_contacto.EstConCli;
		}			
	};
	scope.regresar_filtro_contactos=function()
	{				
		$scope.predicate4 = 'id';  
		$scope.reverse4 = true;						
		$scope.currentPage4 = 1;  
		$scope.order4 = function (predicate4) 
		{  
			$scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;  
			$scope.predicate4 = predicate4;  
		};	
		scope.Tabla_Contacto=scope.Tabla_ContactoBack;							
		$scope.totalItems4 = scope.Tabla_Contacto.length; 
		$scope.numPerPage4 = 50;  
		$scope.paginate4 = function (value4) 
		{  
			var begin4, end4, index4;  
			begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;  
			end4 = begin4 + $scope.numPerPage4;  
			index4 = scope.Tabla_Contacto.indexOf(value4);  
			return (begin4 <= index4 && index4 < end4);
		}
		scope.ruta_reportes_pdf_Contactos=0;
		scope.ruta_reportes_excel_Contactos=0;
		scope.tmodal_contacto={};
	}
	scope.validar_OpcCont=function(index,validar_OpcCont,dato)
	{
		scope.validar_OpcCont[index]=undefined;			
		console.log(validar_OpcCont);
		console.log(dato);
		if(validar_OpcCont==1)
		{
			location.href="#/Edit_Contactos/"+dato.CodConCli+"/"+1;			
		}
		if(validar_OpcCont==2)
		{
			location.href="#/Edit_Contactos/"+dato.CodConCli;
		}
		if(validar_OpcCont==3)
		{
			if(dato.EstConCli=="ACTIVO")
			{
				Swal.fire({title:"Este Contacto Ya Se Encuentra Activo.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			 	Swal.fire({title:"¿Esta Seguro de Activar Este Contacto?",
				type:"question",
				showCancelButton:!0,
				confirmButtonColor:"#31ce77",
				cancelButtonColor:"#f34943",
				confirmButtonText:"OK"}).then(function(t)
				{
			        if(t.value==true)
			        {	             	
			         	scope.update_estatus_contacto(1,dato.CodConCli,index)   
			        }
			        else
			        {
			            console.log('Cancelando ando...');
			        }
			    });
		}
		if(validar_OpcCont==4)
		{
			if(dato.EstConCli=="BLOQUEADO")
			{
				Swal.fire({title:"Este Contacto Ya Se Encuentra Bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			scope.tmodal_data={};
			scope.NumCif=dato.NIFConCli;
			scope.FechBlo=scope.fecha_server;
			scope.RazSocCli=dato.NomConCli;
			scope.tmodal_data.CodCli=dato.CodCli;
			scope.tmodal_data.index=index;
			scope.tmodal_data.CodConCli=dato.CodConCli;
			scope.cargar_lista_motivos_bloqueos_contactos();			
		}

	}
	scope.cargar_lista_motivos_bloqueos_contactos=function()
	{
		var url= base_urlHome()+"api/Clientes/list_motivos_bloqueos_contactos";
		$http.get(url).then(function(result)
		{
			if(result.data.resultado!=false)
			{
				scope.tMotivosBloqueoContacto=result.data;
				$("#modal_motivo_bloqueo_contacto").modal('show');
			}
			else
			{
				Swal.fire({title:"Error",text:"No hemos encontrado motivos de bloqueo de contactos registrados.",type:"error",confirmButtonColor:"#188ae2"});			
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });
	}
	scope.update_estatus_contacto=function(validar_OpcCont,CodConCli,index)
	{
		scope.status_comer={};
		scope.status_comer.EstConCli=validar_OpcCont;
		scope.status_comer.CodConCli=CodConCli;
		
		if(validar_OpcCont==2)
		{
			scope.status_comer.MotBloqcontacto=scope.tmodal_data.MotBloqcontacto;
			scope.status_comer.ObsBloContacto=scope.tmodal_data.ObsBloContacto;			
		}
		$("#estatus_contactos").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Clientes/cambiar_estatus_contactos/";
		 $http.post(url,scope.status_comer).then(function(result)
		 {
		 	$("#estatus_contactos").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );		 		
		 	if(result.data.resultado!=false)
		 	{
		 		if(validar_OpcCont==1)
		 		{
		 			var title='Activando.';
		 			var text='El Contacto a sido activado con exito.';
		 		}
		 		if(validar_OpcCont==2)
		 		{
		 			var title='Bloquear.';
		 			var text='El Contacto a sido bloqueado con exito.';
		 			$("#modal_motivo_bloqueo_contacto").modal('hide');
		 		}
		 		scope.tmodal_data={};
		 		Swal.fire({title:title,text:text,type:"success",confirmButtonColor:"#188ae2"});
		 		scope.validar_OpcCont[index]=undefined;
		 		scope.cargar_lista_contactos();
		 	}
		 	else
		 	{
		 		Swal.fire({title:"Error",text:"No Hemos Podido Actualizar el Estatus del Contacto.",type:"error",confirmButtonColor:"#188ae2"});
				scope.tmodal_data={};
				scope.cargar_lista_contactos();
		 	}

		 },function(error)
		 {
		 	$("#estatus_contactos").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });
	}
	$scope.submitFormlockContactos = function(event) 
	{
	 	if(scope.tmodal_data.ObsBloContacto==undefined||scope.tmodal_data.ObsBloContacto==null||scope.tmodal_data.ObsBloContacto=='')
	 	{
	 		scope.tmodal_data.ObsBloContacto=null;
	 	}
	 	else
	 	{
	 		scope.tmodal_data.ObsBloContacto=scope.tmodal_data.ObsBloContacto;
	 	}	 	
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Este Contacto?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	        if(t.value==true)
	        {
	         scope.update_estatus_contacto(2,scope.tmodal_data.CodConCli,scope.tmodal_data.index);
	        }
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	        });		
	};
	scope.asignar_contacto=function()
	{
		scope.tContacto_data_modal={};	
		$("#modal_cif_cliente_contacto").modal('show');
	}
$scope.Consultar_CIF_Contacto = function(event) 
	{      
	 	if(scope.tContacto_data_modal.NIFConCli==undefined || scope.tContacto_data_modal.NIFConCli==null || scope.tContacto_data_modal.NIFConCli=='')
		{
			Swal.fire({title:"Error.",text:"El número de CIF no puede estar vacio.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
	        $("#NIFConCli").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Clientes/comprobar_cif_contacto/";
			$http.post(url,scope.tContacto_data_modal).then(function(result)
			{
				if(result.data!=false)
				{
					$("#NIFConCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"DNI/NIE.",text:"El Número de DNI/NIE del Contacto ya se encuentra registrado.",type:"info",confirmButtonColor:"#188ae2"});					
				}
				else
				{
					$("#NIFConCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					$("#modal_cif_cliente_contacto").modal('hide');
					location.href="#/Add_Contactos";
					$cookies.put('CIF_Contacto', scope.tContacto_data_modal.NIFConCli);
					

					//scope.TVistaContactos=2;
				}
			},function(error)
			{
				$("#NIFConCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );					
				if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});	

		}						
	};	
scope.regresar_contacto=function()
	{
		Swal.fire({title:"Esta Seguro de Regresar?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	$cookies.remove('CIF_Contacto');
	           	location.href="#/Contactos";
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });	
		
	}
	scope.BuscarXIDContactos=function()
	{
		  $("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Clientes/BuscarXIDContactos_Data/CodConCli/"+scope.nID;
			$http.get(url).then(function(result)
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );					
				if(result.data!=false)
				{
					scope.tContacto_data_modal=result.data;
				}
				else
				{
					Swal.fire({title:"Error.",text:"No hemos encontrado datos con el Contacto Seleccionado.",type:"error",confirmButtonColor:"#188ae2"});
					scope.tContacto_data_modal={};

				}
			},function(error)
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );					
				if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});

	}
$scope.submitFormRegistroContacto = function(event) 
	{      
	 	let Archivo_DocNIF = $Archivo_DocNIF.files;	 	
	 	if($Archivo_DocNIF.files.length>0)
	 	{
	 		if($Archivo_DocNIF.files[0].type=="application/pdf" || $Archivo_DocNIF.files[0].type=="image/jpeg" || $Archivo_DocNIF.files[0].type=="image/png")
		 	{
		 		if($Archivo_DocNIF.files[0].size>2097152)
		 		{
		 			Swal.fire({title:'Error',text:"El Archivo No Puede Ser Mayor a 2 MB.",type:"error",confirmButtonColor:"#188ae2"});
					scope.tContacto_data_modal.DocNIF=null;
					document.getElementById('DocNIF').value ='';
		 			return false;
		 		}
		 		else
		 		{
		 			var tipo_file=($Archivo_DocNIF.files[0].type).split("/");$Archivo_DocNIF.files[0].type;			 		
					scope.tContacto_data_modal.DocNIF='documentos/'+$Archivo_DocNIF.files[0].name;
		 		}		 		
		 	}
		 	else	 	
		 	{
		 		Swal.fire({title:'Error',text:"Formato incorrecto solo se permite archivos PDF, JPG o PNG.",type:"error",confirmButtonColor:"#188ae2"});		 		
				document.getElementById('DocNIF').value ='';
				return false;
			}
	 	}
	 	else
	 	{
	 		document.getElementById('DocNIF').value ='';	 		
	 		if(scope.tContacto_data_modal.DocNIF==undefined||scope.tContacto_data_modal.DocNIF==null)
	 		{
	 			scope.tContacto_data_modal.DocNIF=null;
	 		}
	 		else
	 		{
	 			scope.tContacto_data_modal.DocNIF=scope.tContacto_data_modal.DocNIF;
	 		}	 		
	 	}
	 	let Archivo_DocPod = $Archivo_DocPod.files;
	 	if($Archivo_DocPod.files.length>0)
	 	{
	 		if($Archivo_DocPod.files[0].type=="application/pdf" || $Archivo_DocPod.files[0].type=="image/jpeg" || $Archivo_DocPod.files[0].type=="image/png")
		 	{		 	
		 		if($Archivo_DocPod.files[0].size>2097152)
		 		{
		 			Swal.fire({title:'Error',text:"El Archivo No Puede Ser Mayor a 2 MB.",type:"error",confirmButtonColor:"#188ae2"});
					scope.tContacto_data_modal.DocPod=null;
					document.getElementById('DocPod').value ='';
		 			return false;
		 		}
		 		else
		 		{
			 		var tipo_file=($Archivo_DocPod.files[0].type).split("/");$Archivo_DocPod.files[0].type;
					scope.tContacto_data_modal.DocPod='documentos/'+$Archivo_DocPod.files[0].name;
		 		}		 		
		 	}
		 	else	 	
		 	{
		 		Swal.fire({title:'Error',text:"Formato incorrecto solo se permite archivos PDF, JPG o PNG.",type:"error",confirmButtonColor:"#188ae2"});		 		
				document.getElementById('DocPod').value ='';
				return false;
			}
	 	}
	 	else
	 	{
	 		document.getElementById('DocPod').value ='';
	 		if(scope.tContacto_data_modal.DocPod==undefined||scope.tContacto_data_modal.DocPod==null)
	 		{
	 			scope.tContacto_data_modal.DocPod=null;
	 		}
	 		else
	 		{
	 			scope.tContacto_data_modal.DocPod=scope.tContacto_data_modal.DocPod;
	 		}
	 	}
	 	if (!scope.validar_campos_contactos_null())
		{
			return false;
		}
		if(scope.tContacto_data_modal.CodConCli>0)
		{
		 	var title='Actualizando';
		 	var text='¿Esta Seguro de Actualizar Este Contacto?';
		 	var response="Contacto modificado satisfactoriamente.";
		}
		if(scope.tContacto_data_modal.CodConCli==undefined)
		{
		 	var title='Guardando';
		 	var text='¿Esta Seguro de Incluir Un Nuevo Registro?';
		 	var response="Contacto creado satisfactoriamente.";
		}
	 	Swal.fire({title:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            if($Archivo_DocNIF.files.length>0)
	 			{
	 				$scope.uploadFile(1);
	 			}
	 			if($Archivo_DocPod.files.length>0)
	 			{
	 				$scope.uploadFile(2);
	 			}
	            $("#"+title).removeClass("loader loader-default" ).addClass( "loader loader-default  is-active");
	            var url = base_urlHome()+"api/Clientes/Registro_Contacto";
	            $http.post(url,scope.tContacto_data_modal).then(function(result)
	            {
	            	scope.nIDCodCon=result.data.CodConCli;
	            	if(result.data!=false)
	            	{
	            		$("#"+title).removeClass("loader loader-default  is-active" ).addClass( "loader loader-default");
	            		Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
	            		scope.restringir_cliente_cont=1;
	            		document.getElementById('DocNIF').value ='';
	            		document.getElementById('DocPod').value ='';
	            		scope.tContacto_data_modal=result.data;
	            	}
	            	else
	            	{
	            		$("#"+title).removeClass("loader loader-default  is-active" ).addClass( "loader loader-default");
	            		Swal.fire({title:"Error",text:"Hubo un error en la operación intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	            	}
	
	            },function(error)
	            {
			    	$("#"+title).removeClass("loader loader-default  is-active" ).addClass( "loader loader-default");
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
	scope.validar_campos_contactos_null=function()
	{
		resultado = true;
		if (!scope.tContacto_data_modal.CodCli > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Cliente.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.tContacto_data_modal.CodTipCon > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Contacto.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.tContacto_data_modal.CarConCli==null || scope.tContacto_data_modal.CarConCli==undefined || scope.tContacto_data_modal.CarConCli=='')
		{
			Swal.fire({title:"El Campo Cargo es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.tContacto_data_modal.NomConCli==null || scope.tContacto_data_modal.NomConCli==undefined || scope.tContacto_data_modal.NomConCli=='')
		{
			Swal.fire({title:"El Campo Nombre es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.tContacto_data_modal.TelFijConCli==null || scope.tContacto_data_modal.TelFijConCli==undefined || scope.tContacto_data_modal.TelFijConCli=='')
		{
			Swal.fire({title:"El Campo Teléfono Fijo es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.tContacto_data_modal.TelCelConCli==null || scope.tContacto_data_modal.TelCelConCli==undefined || scope.tContacto_data_modal.TelCelConCli=='')
		{
			Swal.fire({title:"El Campo Teléfono Celular es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.tContacto_data_modal.EmaConCli==null || scope.tContacto_data_modal.EmaConCli==undefined || scope.tContacto_data_modal.EmaConCli=='')
		{
			Swal.fire({title:"El Campo Email es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if(scope.tContacto_data_modal.CanMinRep<=0)			
		{
			Swal.fire({title:"La Cantidad de Firmantes Debe Ser Mayor a 0.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if(scope.tContacto_data_modal.ObsConC==null || scope.tContacto_data_modal.ObsConC==undefined || scope.tContacto_data_modal.ObsConC=='')
		{
			scope.tContacto_data_modal.ObsConC=null;
		}
		else
		{
			scope.tContacto_data_modal.ObsConC=scope.tContacto_data_modal.ObsConC;
		}
		if(scope.tContacto_data_modal.EsRepLeg==1)
		{
			if(!scope.tContacto_data_modal.TipRepr>0)
			{
				Swal.fire({title:"Debe Seleccionar un tipo de Representación.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			if(scope.tContacto_data_modal.DocNIF==undefined||scope.tContacto_data_modal.DocNIF==null)
			{
				Swal.fire({title:"Debe Seleccionar el Documento de Identidad.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}

		}
		if(scope.tContacto_data_modal.EsRepLeg==undefined)
		{
			Swal.fire({title:"Debe Indicar Si es o No Representante Legal.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if(scope.tContacto_data_modal.TieFacEsc==undefined)
		{
			Swal.fire({title:"Debe Indicar Si Tiene Facultad de Escrituras.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if(scope.tContacto_data_modal.TieFacEsc==0)
		{
			if(scope.tContacto_data_modal.DocPod==undefined||scope.tContacto_data_modal.DocPod==null)
			{
				Swal.fire({title:"Debe Seleccionar El Poder.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
		}

		if(scope.tContacto_data_modal.DocPod==null || scope.tContacto_data_modal.DocPod==undefined || scope.tContacto_data_modal.DocPod=='')
		{
			scope.tContacto_data_modal.DocPod=null;
		}
		else
		{
			scope.tContacto_data_modal.DocPod=scope.tContacto_data_modal.DocPod;
		}
		if(scope.tContacto_data_modal.DocNIF==null || scope.tContacto_data_modal.DocNIF==undefined || scope.tContacto_data_modal.DocNIF=='')
		{
			scope.tContacto_data_modal.DocNIF=null;
		}
		else
		{
			scope.tContacto_data_modal.DocNIF=scope.tContacto_data_modal.DocNIF;
		}



		if (resultado == false)
		{
			return false;
		} 
			return true;
	}
	scope.verificar_representante_legal=function()
	{
	
		if(scope.tContacto_data_modal.EsRepLeg==0)
		{
			scope.tContacto_data_modal.TipRepr="1";
			scope.tContacto_data_modal.CanMinRep=1;
			document.getElementById('DocNIF').value ='';
			scope.tContacto_data_modal.DocNIF=null;
		}
	}
	scope.verificar_facultad_escrituras=function()
	{
		if(scope.tContacto_data_modal.TieFacEsc==1)
		{
			document.getElementById('DocPod').value ='';
			scope.tContacto_data_modal.DocPod=null;
		}
	}
	$scope.uploadFile = function(metodo)
	{		
		if(metodo==1)
		{
			var file = $scope.DocNIF;			
		}	
		if(metodo==2)
		{
			var file = $scope.DocPod;			
		}
		upload.uploadFile(file, name).then(function(res)
		{},function(error)
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
	scope.validarsinuermoContactos=function(object,metodo)
{
	if(object!=undefined && metodo==1)
	{
		numero=object;		
		if(!/^([0-9])*$/.test(numero))
		scope.tContacto_data_modal.TelFijConCli=numero.substring(0,numero.length-1);
	}
	if(object!=undefined && metodo==2)
	{
		numero=object;		
		if(!/^([0-9])*$/.test(numero))
		scope.tContacto_data_modal.TelCelConCli=numero.substring(0,numero.length-1);
	}
	if(object!=undefined && metodo==3)
	{
		numero=object;		
		if(!/^([0-9])*$/.test(numero))
		scope.tContacto_data_modal.CanMinRep=numero.substring(0,numero.length-1);
	}

}
if(scope.nID!=undefined)
{
	scope.BuscarXIDContactos();
}
////////////////////////////////////////////////// PARA LOS CONTACTOS END ////////////////////////////////////////////////////////
}			