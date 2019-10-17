 function base_urlHome(segment)
 {
   pathArray = window.location.pathname.split( '/' );  
   indexOfSegment = pathArray.indexOf(segment);  
   return window.location.origin + pathArray.slice(0,indexOfSegment).join('/') + '/';
} 
function base_urlHome_Condenado()
{
	return 'http://10.72.0.15/new_project/';
}
