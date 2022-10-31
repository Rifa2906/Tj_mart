<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_peramalan extends CI_Model
{
    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_peramalan p',);
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = p.id_barang');
        $this->db->join('tb_satuan s', 's.id_satuan = p.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = p.id_jenis');
        $query = $this->db->get()->result_array();
        return $query;
    }



    function tambah_data_peramalan()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->db->query("SELECT * FROM tb_stok_barang WHERE id_barang = $id_barang")->row_array();
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];

        $jenis_barang = $this->db->query("SELECT * FROM tb_jenis_barang WHERE id_jenis = $id_jenis")->row_array();

        if ($jenis_barang['nama_jenis'] == 'Makanan') {
            $minimal_stok = 3;
        } elseif ($jenis_barang['nama_jenis'] == 'Minuman') {
            $minimal_stok = 10;
        }
        $data = [
            'id_barang' => $id_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'minimal_stok' => $minimal_stok
        ];

        $this->db->insert('tb_peramalan', $data);
    }
}
