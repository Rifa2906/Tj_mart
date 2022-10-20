<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kadaluarsa extends CI_Model
{
    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_kadaluarsa kd',);
        $this->db->join('tb_satuan s', 's.id_satuan = kd.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = kd.id_jenis');
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = kd.id_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
