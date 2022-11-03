<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_keluar_barang extends CI_Model
{
    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_keluar k',);
        $this->db->join('tb_satuan s', 's.id_satuan = k.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = k.id_jenis');
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = k.id_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
