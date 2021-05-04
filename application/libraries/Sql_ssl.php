<?php defined('BASEPATH') or exit('No direct script access allowed');
class Sql_ssl
{
    protected $CI;
    public function __construct()
    {
        $this->CI = get_instance();
    }

    public function insertar_tabla($tabla = null, $datos = null)
    {
        return ($this->CI->db->insert($tabla, $datos)) ? $this->CI->db->insert_id() : $this->CI->db->error();
    }

    /*
    * listar tablas
    */
    public function listar_tabla($tabla = null, $condicion = null, $orden = null, $row_result = null)
    {
        $this->CI->db->order_by($orden);
        if ($row_result != 'row') {
            $query = $this->CI->db->get_where($tabla, $condicion)->result();
            return $query;
        } else {
            $query =  $this->CI->db->get_where($tabla, $condicion)->row();
            return $query;
        }
    }

    /** 
     * pruebas modificar jhonatan
     */
    public function modificar_tabla($tabla, $datos, $condicion)
    {
        return ($this->CI->db->update($tabla, $datos, $condicion)) ? TRUE : $this->CI->db->error;
    }
}
