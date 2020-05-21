<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuarios_model extends CI_Model 
{
    public function consultar_cookie($cookie)
    {
        $this->db->select('*');
        $this->db->from('T_Session');       
        $this->db->order_by('id');
        $this->db->where('cookie',$cookie);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row(); 
        } 
        else
        {
            return false;
        }       
    }
     public function sesion_cookies($ip,$agent,$version,$os,$cookie,$hora_nueva)
    {
     
        $final=$this->db->insert('T_Session',array('ip'=>$ip,'navegador'=>$agent,'version'=>$version,'os'=>$os,'cookie'=>$cookie,'fecha'=>$hora_nueva));
        return $final;
    }
    public function get_usuarios_buscar($usuario)
    {
        $this->db->select('username');
        $this->db->from('T_Usuarios_Session');       
        $this->db->where('username',$usuario);
        $this->db->or_where('correo_electronico',$usuario);              
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_usuarios_bloqueado($usuario)
    {
        $this->db->select('*');
        $this->db->from('T_Usuarios_Session');       
        $this->db->where('username',$usuario);         
        $this->db->where('bloqueado',1);
        $this->db->or_where('correo_electronico',$usuario);
        $this->db->where('bloqueado',1);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_usuario($usuario,$contrasena)
    {
        $this->db->select('*');
        $this->db->from('T_Usuarios_Session');       
        $this->db->where('username',$usuario);
        $this->db->where('contrasena',$contrasena);
        $this->db->or_where('correo_electronico',$usuario); 
        $this->db->where('contrasena',$contrasena); 
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function actualizar_cookie($huser,$nivel,$ip,$agent,$version,$os,$cookie)
    {
        $fecha_sesion=date('Y-m-d G:i:s');
        $this->db->where('cookie', $cookie);      
        return $this->db->update('T_Session',array('huser'=>$huser,'hnivel'=>$nivel,'estatus'=>0,'fecha_sesion'=>$fecha_sesion));
    }
    public function actualizar_estado_sesion($cookie,$huser)
    {
        $this->db->where('cookie', $cookie);
        $this->db->where('huser',$huser);      
        return $this->db->update('T_Session',array('estatus'=>1));
    }
    public function get_list_empleados()
    {
        $this->db->select('id,nombres,apellidos,username,correo_electronico,nivel,date_format(fecha_registro, "%d/%m/%Y") as fecha_registro,bloqueado');
        $this->db->from('T_Usuarios_Session');
        $this->db->order_by('nombres,apellidos DESC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function get_users_data($huser)
    {
        $this->db->select('id,nombres,apellidos,username,correo_electronico,nivel,date_format(fecha_registro, "%d-%m-%Y") as fecha_registro,bloqueado,key');
        $this->db->from('T_Usuarios_Session');
        $this->db->where('id',$huser);        
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function borrar_empleados_data($id)
    {        
        $this->db->delete('access', array('huser' => $id));
        $this->db->delete('keys', array('huser' => $id));
        return $this->db->delete('T_Usuarios_Session', array('id' => $id));
    }
    public function new_api_key($level,$ignore_limits,$is_private_key,$ip_addresses)
    {
        //generamos la key
        $key = $this->generate_token();
        //comprobamos si existe
        $check_exists_key = $this->db->get_where("keys", array("key"   =>   $key));
 
        //mientras exista la clave en la base de datos buscamos otra
        while($check_exists_key->num_rows() > 0){
            $key = "";
            $key = $this->generate_token();
        }
        //creamos el array con los datos
        $data = array(
            "key"           =>      $key,
            "level"         =>      $level,
            "ignore_limits" =>      $ignore_limits,
            "is_private_key"=>      $is_private_key,
            "ip_addresses"  =>      $ip_addresses
        ); 
        $this->db->insert("keys", $data);
        return $key;
    } 
    //función que genera una clave segura de 40 carácteres, este será nuestro generador de keys para la api
    //https://gist.github.com/jeffreybarke/5347572
    //autor jeffreybarke
    private function generate_token($len = 40)
    {
        //un array perfecto para crear claves
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        //desordenamos el array chars
        shuffle($chars);
        $num_chars = count($chars) - 1;
        $token = ''; 
        //creamos una key de 40 carácteres
        for ($i = 0; $i < $len; $i++)
        {
            $token .= $chars[mt_rand(0, $num_chars)];
        }
        return $token;
    }
    public function agregar($nombres,$apellidos,$username,$correo_electronico,$contrasena,$contrasena_sin_cifrar,$nivel,$key,$bloqueado)
    {
        $this->db->insert('T_Usuarios_Session',array('nombres'=>$nombres,'apellidos'=>$apellidos,'username'=>$username,'correo_electronico'=>$correo_electronico,'contrasena'=>$contrasena,'key'=>$key,'bloqueado'=>$bloqueado,'nivel'=>$nivel,'contrasena_sin_cifrar'=>$contrasena_sin_cifrar));
        return $this->db->insert_id();
    }
     public function agregar_detalle_controladores($key,$controller,$hcontroller,$huser)
    {
        $this->db->insert('access',array('key'=>$key,'controller'=>$controller,'huser'=>$huser,'hcontroller'=>$hcontroller));
        return $this->db->insert_id();
    }
     public function eliminar_all($huser,$key)
    {        
        return $this->db->delete('access', array('huser' => $huser,'key' => $key));       
    }
    public function actualizar($id,$nombres,$apellidos,$username,$correo_electronico,$nivel,$bloqueado)
    {   
        $this->db->where('id', $id);        
        return $this->db->update('T_Usuarios_Session',array('nombres'=>$nombres,'apellidos'=>$apellidos,'username'=>$username,'correo_electronico'=>$correo_electronico,'bloqueado'=>$bloqueado,'nivel'=>$nivel));
    }
    public function update_key($key,$id)
    {   
        $this->db->where('key', $key);        
        return $this->db->update('keys',array('huser'=>$id));
    }
    public function comprobar_email_disponible($email)
    {
        $this->db->select('correo_electronico');
        $this->db->from('T_Usuarios_Session');
        $this->db->where('correo_electronico',$email);        
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return true;
        }
        else
        {
            return false;
        }       
    }
    public function comprobar_username_disponible($username)
    {
        $this->db->select('username');
        $this->db->from('T_Usuarios_Session');
        $this->db->where('username',$username);        
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return true;
        }
        else
        {
            return false;
        }       
    }
    public function get_controladores()
    {
        $this->db->select('id,controller');
        $this->db->from('controllers');
        $this->db->order_by('controller ASC');        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
             return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function get_detalle_access_all($huser)
    {
        $this->db->select('hcontroller as id,controller');
        $this->db->from('access');
        $this->db->where('huser',$huser);        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function getUsuariosFilter($SearchText)
    {
        $this->db->select('id,nombres,apellidos,username,correo_electronico,nivel,date_format(fecha_registro, "%d/%m/%Y") as fecha_registro,bloqueado');
        $this->db->from('T_Usuarios_Session');
        $this->db->like('CONCAT(nombres," ",apellidos)',$SearchText);
        $this->db->or_like('username',$SearchText);
        $this->db->or_like('correo_electronico',$SearchText);
        $this->db->or_like('date_format(fecha_registro, "%d/%m/%Y")',$SearchText);
        $this->db->order_by('nombres,apellidos DESC');
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
}