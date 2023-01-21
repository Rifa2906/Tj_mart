<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_permintaan extends CI_Model
{
    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_permintaan p');
        $this->db->join('tb_barang b', 'b.kode_barang = p.kode_barang');
        $this->db->join('tb_satuan s', 's.id_satuan = p.id_satuan');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
