<?php
class MY_Controller extends CI_Controller {
	private $content_areas = array();
	protected $menu = array();
	public $area = null;
	//public $sistema = null;
	public $usuario = null;
	public $lugar = null;
	public $estacion = null;
	public $nombrelugar = null;
	public $titulo1 = null;
	public $titulo2 = null;
	public $titulo3 = null;
	public $titulo4 = null;
	public $estado = null;
	private $validado = FALSE;
	//public $logeado = FALSE;
	
	function __construct()
	{
		parent::__construct();
		$logeado = $this->session->userdata('sesion_clientes');
		if (!isset($logeado))
		{		
			redirect(base_url(), 'location', 301);
		}
		/*$cookie_Pref=$this->input->cookie('PREFF');
		if($cookie_Pref==null or $cookie_Pref!=$this->session->userdata('Apikey'))
		{
			redirect(base_url("Equipo_Frecuente#/Validaciones"));
		}*/
		$this->id_usuario=$this->session->userdata('id');		
		$this->usuario=$this->session->userdata('username');
		$this->nivel=$this->session->userdata('nivel');
		$this->NombreMostrar=$this->session->userdata('nombres').' '.$this->session->userdata('apellidos');	
		$this->_build_template();
	}
	function _build_template()
	{
		
		$this->content_areas['msg_valid'] = '';
		$this->content_areas['menus'] = ''; 	
	}
	function get_session_menu($usuario)
	{
		/* if (!$this->session->userdata('tmplt_menu'))
		{
			$var = $this->template_model->get_menu($this->sistema->id);
			
			$this->session->set_userdata('tmplt_menu', $var);
		}

		return $this->session->userdata('tmplt_menu'); */
	}
	function add_view($view, $data = array(), $area = 'main')
	{
		$this->add_html($this->load->view($view, $data, TRUE), $area);
	}

	function add_html($html, $area = 'main') {

		if ( ! array_key_exists($area, $this->content_areas))
		{
			$this->content_areas[$area] = $html;
		}
		else
		{
			$this->content_areas[$area] .= $html;
		}
	}
	function render($layout = "principal")
	{
		$this->load->view('templates/'.$layout, $this->content_areas);
	}
	function render_gestion($layout = "gestion_usuarios")
	{
		$this->load->view($layout, $this->content_areas);
	}
}
?>
