<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_permintaan extends CI_Model
{
    function tampil()
    {
        return $this->db->get('tb_permintaan')->result_array();
    }
}
