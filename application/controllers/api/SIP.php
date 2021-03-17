<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
/*ESTA PENDIENTE IMPLEMENTAR EL GUARDADO DEL PADRE DEL NEGOCIO*/
class SIP extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   	
		$this->load->model('Auditoria_model');
		$this->load->model('Comercializadora_model');
		header('Access-Control-Allow-Origin: *');
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
    ///////////////////////////////////////////////////COMERCIALIZADORAS START //////////////////////////////////////////////////////////
    public function API_DynargyService_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
			$CUPsName=$this->get('CUPsName');
			$curl = curl_init();
		  	curl_setopt_array($curl, array(
		  	CURLOPT_URL => 'https://api.dynargy.com/PuntoSuministro/%7D',
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => '',
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => 'GET',
		  	CURLOPT_POSTFIELDS =>'{
			  "filtros": {
			    "listaCups": "'.$CUPsName.'",
			    "fechaConsumo": {
			      "desde": null,
			      "hasta": null
			    }
			    },
			  "limite": 5,
			  "offset": 0
			}',
		  	CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'x-api-key: xx',
		    'User: 1'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
				
    }
    

}
?>