<?php defined('BASEPATH') or exit('No direct script access allowed');

class Certificado_model extends PSG_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // public function list_courses($course)
    // {
    //     $this->db->select('c.id, c.fullname, c.shortname');
    //     $this->db->from("mdl_course as c");
    //     $this->db->like("c.fullname", "$course", 'both', false);
    //     return $this->db->get()->result_array();
    // }

    // public function list_user($name)
    // {
    //     $this->db->select('u.id, u.firstname, u.lastname, u.email');
    //     $this->db->from("mdl_user as u");
    //     $this->db->like("concat(u.firstname,' ', u.lastname)", "$name", 'both', false);
    //     $this->db->or_like("concat(u.lastname,' ', u.firstname)", "$name", 'both', false);
    //     return $this->db->get()->result_array();
    // }
}
