<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{

    // function tampil_tahun()
    // {
    //     $query = $this->db->query("SELECT YEAR(tanggal_masuk) AS tahun FROM tb_barang_masuk GROUP BY YEAR(tanggal_masuk) ORDER BY YEAR(tanggal_masuk) ASC ")->result_array();
    //     return $query;
    // }

    // function tampil_bulan()
    // {
    //     $query = $this->db->query("SELECT MONTH(tanggal_masuk) AS bulan FROM tb_barang_masuk GROUP BY MONTH(tanggal_masuk) ORDER BY MONTH(tanggal_masuk) ASC ")->result_array();
    //     return $query;
    // }

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_barang_masuk bm',);
        $this->db->join('tb_satuan s', 's.id_satuan = bm.id_satuan');
        $this->db->join('tb_pemasok p', 'p.id_pemasok = bm.id_pemasok');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = bm.id_jenis');
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = bm.id_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
