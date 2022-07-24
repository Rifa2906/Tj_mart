<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{

    function tampil()
    {
        return $this->db->get('tb_user')->result_array();
    }
}
