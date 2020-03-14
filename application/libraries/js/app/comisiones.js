app.controller('Controlador_Comisiones', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','$compile', Controlador])

function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,$compile,ServiceComercializadora,upload)
{
	var scope = this;
	scope.fdatos = {};	
	scope.anexos = {};	
	scope.CodAnePro=$route.current.params.CodAnePro;
	scope.CIFComision=$route.current.params.NumCifCom;
	scope.ComerComision=$route.current.params.RazSocCom;
	scope.ProComision=$route.current.params.DesPro;
	scope.AneComision=$route.current.params.DesAnePro;
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
	scope.TComisionesRangoGrib=[];	
	scope.TComisionesRango=[];
	scope.select_det_com=[];
	scope.TComisionesDet=[];

	console.log($route.current.$$route.originalPath);	
///////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE COMISIONES START ////////////////////////////////////////////////

scope.Buscar_Tarifas_Anexos=function()
{
	$("#Car_Det").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	var url =base_urlHome()+"api/Comercializadora/buscar_detalle_anexos_comision/CodAnePro/"+scope.CodAnePro;
	$http.get(url).then(function(result)
	{
		$("#Car_Det").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		if(result.data==false)
		{
			scope.TComisionesRangoGrib=[];	
			scope.TComisionesRango=[];
			scope.select_det_com=[];
			scope.TComisionesDet=[];
		}
		else
		{
			if(result.data.data!=false)
			{
				$scope.predicate3 = 'id';  
				$scope.reverse3 = true;						
				$scope.currentPage3 = 1;  
				$scope.order3 = function (predicate3) 
				{  
					$scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
					$scope.predicate3 = predicate3;  
				}; 						
				scope.TComisionesDet=result.data.data;												
				$scope.totalItems3 = scope.TComisionesDet.length; 
				$scope.numPerPage3 = 50;  
				$scope.paginate3 = function (value3) 
				{  
					var begin3, end3, index3;  
					begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
					end3 = begin3 + $scope.numPerPage3;  
					index3 = scope.TComisionesDet.indexOf(value3);  
					return (begin3 <= index3 && index3 < end3);  
				};
				if(result.data.detalle_comisiones!=false)
				{
					scope.TComisionesRangoGrib=result.data.detalle_comisiones;
					angular.forEach(scope.TComisionesRangoGrib, function(Comisiones)
					{					
						scope.select_det_com[Comisiones.CodDetAne]=Comisiones;						
					});
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron comisiones asignadas a este anexo.",type:"info",confirmButtonColor:"#188ae2"});
					scope.TComisionesRangoGrib=[];	
					scope.TComisionesRango=[];
					//scope.select_det_com=[];
					//scope.TComisionesDet=[];
				}
			}
			else
			{
				Swal.fire({title:"Error",text:"No se encontraron detalles asignados a este anexo.",type:"info",confirmButtonColor:"#188ae2"});
				scope.TComisionesRangoGrib=[];	
				scope.TComisionesRango=[];
				scope.select_det_com=[];
				scope.TComisionesDet=[];
			}
		}		
	},function(error)
	{
		$("#Car_Det").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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

scope.regresar_comisiones=function()
{
	Swal.fire({title:'Regresar',
	text:'¿Está seguro de regresar y no guardar las comisiones?',
	type:"question",
	showCancelButton:!0,
	confirmButtonColor:"#31ce77",
	cancelButtonColor:"#f34943",
	confirmButtonText:"Regresar"}).then(function(t)
	{
	    if(t.value==true)
	    {
	        location.href="#/Anexos";	  
	    }
		else
	    {
			console.log('Cancelando Ando...');
			event.preventDefault();						
	    }
	});
}
scope.agregar_detalle_comision=function(index,CodDetAneTarEle,dato)
	{
		console.log('Index: '+index);
		console.log('CodDetAneTarEle: '+CodDetAneTarEle);		
		console.log(dato);
		scope.CodDetAne=dato.CodAnePro;
		var ObjDetCom = new Object();	
		scope.select_det_com[CodDetAneTarEle]=dato;
		if (scope.TComisionesRangoGrib==undefined || scope.TComisionesRangoGrib==false)
		{
			scope.TComisionesRangoGrib = []; 
		}
		scope.TComisionesRangoGrib.push({CodDetAne:dato.CodDetAneTarEle,CodAnePro:dato.CodAnePro,CodTarEle:dato.CodTarEle,TipServ:dato.TipServ,NomTarEle:dato.NomTarEle,TipPre:dato.TipPre});
		console.log(scope.TComisionesRangoGrib);
	}
	scope.quitar_detalle_comision=function(index,CodDetAneTarEle,dato)
	{
		scope.select_det_com[CodDetAneTarEle]=false;
		i=0;
		for (var i = 0; i < scope.TComisionesRangoGrib.length; i++) 
	    {
	      	if(scope.TComisionesRangoGrib[i].CodDetAne==CodDetAneTarEle)
	      	{
		   		scope.TComisionesRangoGrib.splice(i,1);
	       	}
	    }
	}
	scope.quitar_detalle_comision_length=function()
	{
		if(scope.TComisionesRangoGrib.length>0)
		{
			var a =scope.TComisionesRangoGrib;
			var b= a.pop();
			for(var i=0;i<=a.length-1;i++)
			{
				 console.log(i+" "+a[i]);

			}
			console.log(b);
			scope.select_det_com[b.CodDetAne]=false;
			console.log(scope.select_det_com);
			console.log(scope.TComisionesRangoGrib);

		}
		
	}
scope.validar_inputs=function(metodo,object,index)
	{
		console.log(metodo);
		console.log(object);
		console.log(index);
		if(metodo==1 && object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.TComisionesRangoGrib[index].RanCon=numero.substring(0,numero.length-1);
		}
		if(metodo==2 && object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.TComisionesRangoGrib[index].ConMinAnu=numero.substring(0,numero.length-1);
		}
		if(metodo==3 && object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.TComisionesRangoGrib[index].ConMaxAnu=numero.substring(0,numero.length-1);
		}
		if(metodo==4 && object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.TComisionesRangoGrib[index].ConSer=numero.substring(0,numero.length-1);
		}
		if(metodo==5 && object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.TComisionesRangoGrib[index].ConCerVer=numero.substring(0,numero.length-1);
		}
	}
	scope.agregardetalle = function()
	{
		var ObjDetCom = new Object();
		ObjDetCom.RanConsu = 0;
		ObjDetCom.ConMinAn=0
		ObjDetCom.ConMaxAn=0
		ObjDetCom.ConServ=0
		ObjDetCom.ConCerVer=0
		console.log(scope.TComisionesRangoGrib);
		if (scope.TComisionesRangoGrib==undefined || scope.TComisionesRangoGrib==false)
		{
			scope.TComisionesRangoGrib = []; 
		}
			scope.TComisionesRangoGrib.push({ });
			console.log(scope.TComisionesRangoGrib);
	}
	scope.guardar_comisiones=function()
	{
		console.log(scope.TComisionesRangoGrib);
		if (!scope.validar_campos_detalles_comisiones())
		{
			return false;
		}
		scope.datos_enviar={};
		scope.datos_enviar.CodDetAne=scope.CodAnePro;
		scope.datos_enviar.Detalles=scope.TComisionesRangoGrib;
		Swal.fire({title:'Procesando Comisiones',
		text:'Esta Seguro de Continuar con el Procedimiento.',
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Confirmar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	var url=base_urlHome()+"api/Comercializadora/guardar_comisiones_detalles_anexos/";
	         	$http.post(url,scope.datos_enviar).then(function(result)
	         	{
	         		if(result.data!=false)
	         		{
	         			Swal.fire({title:"Exito",text:"Comisiones Registradas Correctamente.",type:"success",confirmButtonColor:"#188ae2"});	         			
	         		}
	         		else
	         		{
	         			Swal.fire({title:"Error",text:"hubo un error en el proceso intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});	
	         		}

	         	},function(error)
	         	{
	         		//$("#Car_Det").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
				console.log('Cancelando Ando...');
				event.preventDefault();						
	        }
	    });

		/**/
	}
	scope.validar_campos_detalles_comisiones = function()
	{
		resultado = true;
		if (!scope.TComisionesRangoGrib.length>0)
		{
			Swal.fire({title:"Error",text:"Debe indicar al menos un renglon de comisión para poder guardar los registros.",type:"error",confirmButtonColor:"#188ae2"});			
			return false;
		}
		for(var i=0; i<scope.TComisionesRangoGrib.length; i++) 
		{
			if (scope.TComisionesRangoGrib[i].RanCon==undefined || scope.TComisionesRangoGrib[i].RanCon==null || scope.TComisionesRangoGrib[i].RanCon=='') 
			{
		        Swal.fire({title:"Error",text:"El Campo Rango de Consumo no puede estar vacío.",type:"error",confirmButtonColor:"#188ae2"});
				i=scope.TComisionesRangoGrib.length;
				resultado = false;
			}
			if (scope.TComisionesRangoGrib[i].ConMinAnu==undefined || scope.TComisionesRangoGrib[i].ConMinAnu==null || scope.TComisionesRangoGrib[i].ConMinAnu=='') 
			{
		        Swal.fire({title:"Error",text:"El Campo Consumo Mínimo Anual no puede estar vacío.",type:"error",confirmButtonColor:"#188ae2"});
				i=scope.TComisionesRangoGrib.length;
				resultado = false;
			}
			if (scope.TComisionesRangoGrib[i].ConMaxAnu==undefined || scope.TComisionesRangoGrib[i].ConMaxAnu==null || scope.TComisionesRangoGrib[i].ConMaxAnu=='') 
			{
		        Swal.fire({title:"Error",text:"El Campo Consumo Máximo Anual no puede estar vacío.",type:"error",confirmButtonColor:"#188ae2"});
				i=scope.TComisionesRangoGrib.length;
				resultado = false;
			}
			if (scope.TComisionesRangoGrib[i].ConSer==undefined || scope.TComisionesRangoGrib[i].ConSer==null || scope.TComisionesRangoGrib[i].ConSer=='') 
			{
		        Swal.fire({title:"Error",text:"El Campo Comisión de Servicio no puede estar vacío.",type:"error",confirmButtonColor:"#188ae2"});
				i=scope.TComisionesRangoGrib.length;
				resultado = false;
			}
			if (scope.TComisionesRangoGrib[i].ConCerVer==undefined || scope.TComisionesRangoGrib[i].ConCerVer==null || scope.TComisionesRangoGrib[i].ConCerVer=='') 
			{
		        Swal.fire({title:"Error",text:"El Campo Comisión Certificado Verde no puede estar vacío.",type:"error",confirmButtonColor:"#188ae2"});
				i=scope.TComisionesRangoGrib.length;
				resultado = false;
			}				
		}
		if (resultado == false)
		{
			return false;
		} 
		return true;
	}
if(scope.CodAnePro!=undefined) 
{
	scope.Buscar_Tarifas_Anexos();	
}
////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE COMISIONES END ////////////////////////////////////////////////////////
}			