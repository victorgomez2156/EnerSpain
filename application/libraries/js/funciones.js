 function base_urlHome(segment)
 {
   pathArray = window.location.pathname.split( '/' );  
   indexOfSegment = pathArray.indexOf(segment);
   /*console.log(pathArray);   
   console.log(indexOfSegment);
   console.log(window.location.origin);
   console.log(pathArray.slice(0,indexOfSegment).join('/') + '/');
   console.log(window.location.origin + pathArray.slice(0,indexOfSegment).join('/') + '/');*/
   return window.location.origin + pathArray.slice(0,indexOfSegment).join('/') + '/';
} 
function base_urlHome_Condenado()
{
	return 'http://10.72.0.15/EnerSpain/';
}
