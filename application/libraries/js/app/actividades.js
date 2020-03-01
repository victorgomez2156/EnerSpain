 app.controller('Controlador_Actividades', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','$compile','ServiceMaster','upload', Controlador])
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
	var scope = this;
	scope.fdatos = {};
	scope.nID = $route.current.params.ID;
	scope.INF = $route.current.params.INF;
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
	var fecha = dd+'/'+mm+'/'+yyyy;	
////////////////////////////////////////////////// PARA LAS ACTIVIDADES GRIB START /////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////// PARA LAS ACTIVIDADES START //////////////////////////////////////////////////////////
	
	scope.NumCifCli=true;
	scope.RazSocCli=true;
	scope.DesSec=true;
	scope.DesGru=true;
	scope.DesEpi=true;
	scope.EstAct=true;
	scope.FecIniAct1=true;
	scope.AccAct=true;

	scope.ttipofiltrosact = [{id: 1, nombre: 'FECHA DE INICIO'},{id: 2, nombre: 'ESTATUS ACTIVIDAD'},{id: 3, nombre: 'CLIENTE'}];
	scope.topcionesactividades = [{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
	scope.ttipofiltrosEstAct = [{id: 1, nombre: 'Activa'},{id: 2, nombre: 'Bloqueada'}];
	scope.tmodal_filtroAct={};	
	scope.ruta_reportes_pdf_actividad=0;
	scope.ruta_reportes_excel_actividad=0;
	//scope.T_ActEcoGrib=1;
	scope.fdatos_actividades={};
	scope.TActividades=[];
	scope.TActividadesBack=[];
	scope.tProvidencias=[];
	scope.tLocalidades=[];
	scope.tTipoCliente=[];
	scope.tComerciales=[];
	scope.tSectores=[];
	scope.tColaboradores=[];
	scope.tTiposVias=[];
	scope.TtiposInmuebles=[];
	scope.tListBanc=[];
	scope.tListaContactos=[];
	scope.tListDocumentos=[];
	scope.Tclientes=[];
	////////////////////////////// PARA LAS ACTIVIDADES END //////////////////////////	

	ServiceMaster.getAll().then(function(dato) 
	{
		scope.tProvidencias=dato.Provincias;
		scope.tLocalidades=dato.Localidades;		
		scope.tTipoCliente=dato.Tipo_Cliente;		
		scope.tComerciales=dato.Comerciales;
		scope.tSectores=dato.Sector_Cliente;
		scope.tColaboradores=dato.Colaborador;
		scope.tTiposVias = dato.Tipo_Vias;
		scope.TtiposInmuebles = dato.Tipo_Inmuebles;	
		scope.tListBanc = dato.Bancos;	
		scope.tListaContactos = dato.Tipo_Contacto;
		scope.tListDocumentos = dato.Tipos_Documentos;
		scope.fdatos.FecIniCli=dato.Fecha_Server;
		scope.fecha_server=dato.Fecha_Server;
		$scope.predicate1 = 'id';  
		$scope.reverse1 = true;						
		$scope.currentPage1 = 1;  
		$scope.order1 = function (predicate1) 
		{  
			$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
			$scope.predicate1 = predicate1;  
		};	
		scope.TActividades=dato.Actividades_Clientes;
		scope.TActividadesBack=dato.Actividades_Clientes;							
		$scope.totalItems1 = scope.TActividades.length; 
		$scope.numPerPage1 = 50;  
		$scope.paginate1 = function (value1) 
		{  
			var begin1, end1, index1;  
			begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
			end1 = begin1 + $scope.numPerPage1;  
			index1 = scope.TActividades.indexOf(value1);  
			return (begin1 <= index1 && index1 < end1);  
		};
		if(scope.TActividades==false)
		{
			scope.TActividades=[];
			scope.TActividadesBack=[];
		}
		scope.Tclientes=dato.Clientes;
	}).catch(function(err){console.log(err);});

scope.mostrar_all_actividades=function()
{
	$("#cargando_actividades").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	var url = base_urlHome()+"api/Clientes/all_actividades/";
	$http.get(url).then(function(result)
	{
		$("#cargando_actividades").removeClass( "loader loader-default  is-active" ).addClass( "loader loader-default");
		if(result.data!=false)
		{
			$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			};	
			scope.TActividades= result.data;
			scope.TActividadesBack= result.data;							
			$scope.totalItems1 = scope.TActividades.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TActividades.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
		}
		else
		{
			Swal.fire({text:"Actualmente no hemos encontrados actividades registradas.",type:"info",confirmButtonColor:"#188ae2"});
			scope.TActividades=[];
			scope.TActividadesBack=[];
		}
	},function(error)		
	{	
		$("#cargando_actividades").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
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

$scope.SubmitFormFiltrosAct = function(event) 
{
	if(scope.tmodal_filtroAct.tipo_filtro_actividad==1)
	 {
	 	var FecIniActFil=document.getElementById("FecIniActFil").value;
		scope.FecIniActFil=FecIniActFil;
	 	if(scope.FecIniActFil==undefined || scope.FecIniActFil==null || scope.FecIniActFil=='')
	 	{
	 		Swal.fire({title:"Debe Ingresar la Fecha para Poder Aplicar el Filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 		return false;
	 	}
	 	else
	 	{
	 		var FecActFil= (scope.FecIniActFil).split("/");
			if(FecActFil.length<3)
			{
				Swal.fire({text:"El Formato de Fecha debe Ser EJ: DD-MM-YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecActFil[0].length>2 || FecActFil[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;

				}
				if(FecActFil[1].length>2 || FecActFil[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;
				}
				if(FecActFil[2].length<4 || FecActFil[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del año deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var Final_Act_Fil = FecActFil[0]+"/"+FecActFil[1]+"/"+FecActFil[2];
				scope.tmodal_filtroAct.FecIniActFil=Final_Act_Fil;
				scope.filtro_fecha=FecActFil[0]+"-"+FecActFil[1]+"-"+FecActFil[2];
			}
	 	}
	 		$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			};	
			scope.TActividades= $filter('filter')(scope.TActividadesBack, {FecIniAct: scope.tmodal_filtroAct.FecIniActFil}, true);							
			$scope.totalItems1 = scope.TActividades.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TActividades.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
			
			scope.ruta_reportes_pdf_actividad=scope.tmodal_filtroAct.tipo_filtro_actividad+"/"+scope.filtro_fecha;
			scope.ruta_reportes_excel_actividad=scope.tmodal_filtroAct.tipo_filtro_actividad+"/"+scope.filtro_fecha;
	 	}
	 	if(scope.tmodal_filtroAct.tipo_filtro_actividad==2)
	 	{
	 		if(!scope.tmodal_filtroAct.EstActFil>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar un Estatus para Poder Aplicar el Filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			};	
			scope.TActividades= $filter('filter')(scope.TActividadesBack, {EstAct: scope.tmodal_filtroAct.EstActFil}, true);							
			$scope.totalItems1 = scope.TActividades.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TActividades.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
			
			scope.ruta_reportes_pdf_actividad=scope.tmodal_filtroAct.tipo_filtro_actividad+"/"+scope.tmodal_filtroAct.EstActFil;
			scope.ruta_reportes_excel_actividad=scope.tmodal_filtroAct.tipo_filtro_actividad+"/"+scope.tmodal_filtroAct.EstActFil;
	 	}
	 	if(scope.tmodal_filtroAct.tipo_filtro_actividad==3)
	 	{
	 		if(!scope.tmodal_filtroAct.CodCliActFil>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar un Cliente para Poder Aplicar el Filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			};	
			scope.TActividades= $filter('filter')(scope.TActividadesBack, {CodCli: scope.tmodal_filtroAct.CodCliActFil}, true);							
			$scope.totalItems1 = scope.TActividades.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TActividades.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
			
			scope.ruta_reportes_pdf_actividad=scope.tmodal_filtroAct.tipo_filtro_actividad+"/"+scope.tmodal_filtroAct.CodCliActFil;
			scope.ruta_reportes_excel_actividad=scope.tmodal_filtroAct.tipo_filtro_actividad+"/"+scope.tmodal_filtroAct.CodCliActFil;
	 	}					
	};
scope.quitar_filtro_actividad=function()
{	
	$scope.predicate1 = 'id';  
	$scope.reverse1 = true;						
	$scope.currentPage1 = 1;  
	$scope.order1 = function (predicate1) 
	{  
		$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
		$scope.predicate1 = predicate1;  
	};	
	scope.TActividades=scope.TActividadesBack;				
	$scope.totalItems1 = scope.TActividades.length; 
	$scope.numPerPage1 = 50;  
	$scope.paginate1 = function (value1) 
	{  
		var begin1, end1, index1;  
		begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
		end1 = begin1 + $scope.numPerPage1;  
		index1 = scope.TActividades.indexOf(value1);  
		return (begin1 <= index1 && index1 < end1);  
	};
	scope.tmodal_filtroAct={};
	scope.ruta_reportes_pdf_actividad=0;
	scope.ruta_reportes_excel_actividad=0;
	scope.filtro_fecha=undefined;
	scope.FecIniActFil=undefined;
}
scope.validar_fecha_act=function(metodo,object)
{

	if(object!=undefined && metodo==1)
	{
		numero=object;		
		if(!/^([/0-9])*$/.test(numero))
		scope.FecIniAct=numero.substring(0,numero.length-1);
	}
	if(object!=undefined && metodo==2)
	{
		numero=object;		
		if(!/^([/0-9])*$/.test(numero))
		scope.FecIniActFil=numero.substring(0,numero.length-1);
	}
	if(object!=undefined && metodo==3)
	{
		numero=object;		
		if(!/^([/0-9])*$/.test(numero))
		scope.FecBloAct=numero.substring(0,numero.length-1);
	}
}
scope.validar_actividad=function(index,opcion,datos)
	{	
		scope.update_status_activity={};
		scope.update_status_activity.opcion=opcion;
		scope.update_status_activity.CodTActCli=datos.CodTActCli;
		scope.update_status_activity.CodCli=datos.CodCli;
		if(opcion==1)
		{
			if(datos.EstAct=="Activa")
			{
				Swal.fire({title:"Error.",text:"Esta actividad ya se encuentra activa.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_actividades[index]=undefined;
				return false;
			}
			Swal.fire({title:"¿Esta Seguro de Activar Esta Actividad?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
			        $("#estatus_actividad").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
					var url=base_urlHome()+"api/Clientes/update_status_activity/";
					$http.post(url,scope.update_status_activity).then(function(result)
					{
						if(result.data!=false)
						{					
							if(result.data.opcion==1)
							{
								//scope.buscarXID();					
								$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
								Swal.fire({title:"Exito.",text:"La activiadad a sido activada correctametne.",type:"success",confirmButtonColor:"#188ae2"});
								scope.opciones_actividades[index]=undefined;
								scope.mostrar_all_actividades();
							}
						}
						else
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error.",text:"Hubo un error al intentar asignar esta actividad por favor intente nuevamente.",type:"success",confirmButtonColor:"#188ae2"});
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
							Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
						}
					});  
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_actividades[index]=undefined;
	            }
	        });
		}
		if(opcion==2)
		{
			if(datos.EstAct=="Bloqueada")
			{
				Swal.fire({title:"Error.",text:"Esta actividad ya se encuentra bloqueada.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_actividades[index]=undefined;
				return false;
			}
			
				scope.tmodal_data={};
				scope.tmodal_data.opcion=opcion;
				scope.tmodal_data.index=index;
				if(scope.tmodal_data.ObsBloAct==undefined)
				{
					scope.tmodal_data.ObsBloAct=null;
				}
				else
				{
					scope.tmodal_data.ObsBloAct=scope.tmodal_data.ObsBloAct;
				}
				
				scope.tmodal_data.CodCli=datos.CodCli;
				scope.tmodal_data.CodTActCli=datos.CodTActCli;
				scope.FecBloAct=scope.fecha_server;
				$('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}).datepicker("setDate", scope.FecBloAct); 
				scope.tmodal_data.NumCif=datos.NumCifCli;
				scope.tmodal_data.RazSoc=datos.RazSocCli;
				scope.tmodal_data.DesActCNAE=datos.DesActCNAE;
				scope.tmodal_data.GruActCNAE=datos.GruActCNAE;
				scope.tmodal_data.SubGruActCNAE=datos.SubGruActCNAE;
				scope.tmodal_data.SecActCNAE=datos.SecActCNAE;
				scope.opciones_actividades[index]=undefined;
		        scope.cargar_lista_motivos_bloqueos_actividades();	            	
		        $("#modal_motivo_bloqueo_actividades").modal('show'); 
		}

	}
	scope.cargar_lista_motivos_bloqueos_actividades=function()
	{
		var url=base_urlHome()+"api/Clientes/Motivos_Bloqueos_Actividades/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.tMotivosBloqueosActividades=result.data;
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrados motivos de bloqueos para las actividades.",type:"error",confirmButtonColor:"#188ae2"});
			}

		},function(error)
		{
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

	$scope.submitFormlockActividades = function(event) 
	{ 
		var FecBloAct=document.getElementById("FecBloAct").value;
		scope.FecBloAct=FecBloAct;
		if(scope.FecBloAct==undefined || scope.FecBloAct==null || scope.FecBloAct=='') 
	{
		Swal.fire({text:"El Campo Fecha de Bloqueo no puede estar vacio.",type:"error",confirmButtonColor:"#188ae2"});
		event.preventDefault();	
		return false;
	}	
	else
	{
		var FecBloAct= (scope.FecBloAct).split("/");
		if(FecBloAct.length<3)
		{
			Swal.fire({text:"El Formato de Fecha de Bloqueo debe Ser EJ: "+scope.fecha_server,type:"error",confirmButtonColor:"#188ae2"});
			event.preventDefault();	
			return false;
		}
		else
		{		
			if(FecBloAct[0].length>2 || FecBloAct[0].length<2)
			{
				Swal.fire({text:"Por Favor Corrija el Formato del dia en la Fecha de Bloqueo deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
				}
			if(FecBloAct[1].length>2 || FecBloAct[1].length<2)
			{
				Swal.fire({text:"Por Favor Corrija el Formato del mes de la Fecha de Bloqueo deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			if(FecBloAct[2].length<4 || FecBloAct[2].length>4)
			{
				Swal.fire({text:"Por Favor Corrija el Formato del ano en la Fecha de Bloqueo Ya que deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			valuesStart=scope.FecBloAct.split("/");
	        valuesEnd=scope.fecha_server.split("/"); 
	        // Verificamos que la fecha no sea posterior a la actual
	        var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
	        var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
	        if(dateStart>dateEnd)
	        {
	            Swal.fire({text:"La Fecha de Bloqueo no puede ser mayor al "+scope.fecha_server+" Por Favor Verifique he intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});					
	            return false;
	        }
	        scope.tmodal_data.FecBloAct=valuesStart[2]+"-"+valuesStart[1]+"-"+valuesStart[0];	
		}
	}
	console.log(scope.tmodal_data.FecBloAct);	
	Swal.fire({title:"¿Esta Seguro de Bloquear Esta Actividad?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	       	if(t.value==true)
	        {
	          	$("#estatus_actividad").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url=base_urlHome()+"api/Clientes/update_status_activity/";
				$http.post(url,scope.tmodal_data).then(function(result)
				{
					if(result.data!=false)
					{					
						if(result.data.opcion==2)
						{
							scope.mostrar_all_actividades();					
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Exito.",text:"La activiadad a sido bloqueada correctametne.",type:"success",confirmButtonColor:"#188ae2"});
							scope.opciones_actividades[scope.tmodal_data.index]=undefined;
							  $("#modal_motivo_bloqueo_actividades").modal('hide');
						}
					}
					else
					{
						$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error.",text:"Hubo un error al intentar asignar esta actividad por favor intente nuevamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.opciones_actividades[scope.tmodal_data.index]=undefined;
					}
				},function(error)
				{
					$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
			    else
			    {
			        console.log('Cancelando ando...');
			        event.preventDefault();
			                
			    }
			});	
	};
	scope.buscar_CNAE=function()
{	
	if(scope.CodActCNAE!=undefined)
	{
		$("#buscar_cnae").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Clientes/Buscar_CNAE/CodActCNAE/"+scope.CodActCNAE;
		$http.get(url).then(function(result)
		{
			$("#buscar_cnae").removeClass( "loader loader-default  is-active" ).addClass( "loader loader-default");
			if(result.data!=false)
			{
				scope.resultado_actividad=1;
				scope.fdatos_actividades=result.data;
			}
			else
			{
				Swal.fire({text:"El Código CNAE no esta registrado.",type:"info",confirmButtonColor:"#188ae2"});
				scope.resultado_actividad=0;
				scope.fdatos_actividades={};
			}
		},function(error)		
		{	
			$("#buscar_cnae").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
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
}
$scope.submitFormActividades = function(event) 
	{
	scope.fdatos_actividades.CodCli=scope.CodCliAct;
 	if(scope.nIDAct>0 && scope.Nivel==3)
	{
		Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
		return false;
	}
	/*if (!scope.validar_campos_datos_basicos())
	{
		return false;
	}*/
	if(scope.fdatos_actividades.CodTActCli>0)
	{
		var title='Actualizando';
		var text='¿Está seguro de actualizar esta actividad?';
		var response="Actividad modificada satisfactoriamente.";
	}
	if(scope.fdatos_actividades.CodTActCli==undefined)
	{
		var title='Guardando';
		var text='¿Está seguro de incluir esta actividad??';
		var response="Actividad asignada satisfactoriamente.";
	}
	var FecIniAct=document.getElementById("FecIniAct").value;
	scope.FecIniAct=FecIniAct;
	if(scope.FecIniAct==undefined || scope.FecIniAct==null || scope.FecIniAct=='') 
	{
		Swal.fire({text:"El Campo Fecha de Inicio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
		event.preventDefault();	
		return false;
	}
	var FecActCon= (scope.FecIniAct).split("/");
	if(FecActCon.length<3)
	{
		Swal.fire({text:"El Formato de Fecha debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
		event.preventDefault();	
		return false;
	}
	else
	{		
		if(FecActCon[0].length>2 || FecActCon[0].length<2)
		{
			Swal.fire({text:"Por Favor Corrija el Formato del dia deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
			event.preventDefault();	
			return false;

		}
		if(FecActCon[1].length>2 || FecActCon[1].length<2)
		{
			Swal.fire({text:"Por Favor Corrija el Formato del mes deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
			event.preventDefault();	
			return false;
		}
		if(FecActCon[2].length<4 || FecActCon[2].length>4)
		{
			Swal.fire({text:"Por Favor Corrija el Formato del ano deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
			event.preventDefault();	
			return false;
		}
		var h1=new Date();			
		var final = FecActCon[2]+"/"+FecActCon[1]+"/"+FecActCon[0];
		scope.fdatos_actividades.FecIniAct=final;

		valuesStart=scope.FecIniAct.split("/");
		valuesEnd=scope.fecha_server.split("/"); 
		// Verificamos que la fecha no sea posterior a la actual
		var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
		var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
		if(dateStart>dateEnd)
		{
			Swal.fire({text:"La Fecha de Inicio no puede ser mayor al "+scope.fecha_server+" Por Favor Verifique he intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});					
			return false;
		}
	}
	Swal.fire({title:title,
	text:text,
	type:"question",
	showCancelButton:!0,
	confirmButtonColor:"#31ce77",
	cancelButtonColor:"#f34943",
	confirmButtonText:"SI"}).then(function(t)
	{
	    if(t.value==true)
	    {
	       $("#asignando_actividad").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
			var url = base_urlHome()+"api/Clientes/Asignar_Actividad";
			$http.post(url,scope.fdatos_actividades).then(function(result)
			{
				$("#asignando_actividad").removeClass( "loader loader-default  is-active" ).addClass( "loader loader-default");
				if(result.data!=false)
				{
					Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});
					//scope.resultado_actividad=1;
					//scope.T_ActEcoGrib=2;
					//scope.mostrar_all_actividades();
					scope.fdatos_actividades.CodTActCli=result.data.CodTActCli;
				}
				else
				{
					Swal.fire({text:"No se pudo registrar la actividad ya puede estar asignada al cliente.",type:"info",confirmButtonColor:"#188ae2"});
				}
			},function(error)		
			{	
				$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
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
	    else
	    {
			event.preventDefault();							
	    }
	});		
};
scope.regresar_actividad=function()
{
	//scope.T_ActEcoGrib=1;
	//scope.mostrar_all_actividades();
	/*scope.fdatos_actividades={};
	scope.FecIniAct=undefined;
	scope.resultado_actividad=0;
	scope.CodActCNAE=undefined;
	location.href="#/Actividades";*/
	
	if(scope.fdatos_actividades.CodTActCli==undefined)
		{
			var title="Guardando";
			var text="¿Estás seguro de regresar y no guardar los datos?";
		}
		else
		{
			var title="Actualizando";
			var text="¿Estás seguro de regresar y no actualizar los datos?";
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
	        	location.href="#/Actividades";
	        }
	        else
	        {
	            console.log('Cancelando ando...');
	        }
	    });	

	
}

////////////////////////////////////////////////// PARA LAS ACTIVIDADES GRIB END //////////////////////////////////////////////////////////
}			