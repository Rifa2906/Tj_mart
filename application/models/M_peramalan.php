<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_peramalan extends CI_Model
{
    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_peramalan p',);
        $this->db->join('tb_satuan s', 's.id_satuan = p.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = p.id_jenis');
        $this->db->join('tb_stok_barang sb', 'sb.nama_barang = p.nama_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
