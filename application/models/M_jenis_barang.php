<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_jenis_barang extends CI_Model
{
    function tampil()
    {
        return $this->db->get('tb_jenis_barang')->result_array();
    }

    function tambahdata()
    {
        $nama_jenis = $this->input->post('nama_jenis');

        if ($nama_jenis == 'Minuman') {
            $min_stok = 10;
        } elseif ($nama_jenis == 'Makanan') {
            $min_stok = 3;
        }


        $data = [
            'nama_jenis' => $nama_jenis,
            'minimal_stok' => $min_stok
        ];
        $this->db->insert('tb_jenis_barang', $data);
    }

    function ambilId($id)
    {
        return $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id]);
    }

    function ubah($id_jenis)
    {

        $nama_jenis = $this->input->post('nama_jenis');
        if ($nama_jenis == 'Minuman') {
            $min_stok = 10;
        } elseif ($nama_jenis == 'Makanan') {
            $min_stok = 3;
        }


        $data = [
            'nama_jenis' => $nama_jenis,
            'minimal_stok' => $min_stok
        ];
        $this->db->where('id_jenis', $id_jenis);
        $this->db->update('tb_jenis_barang', $data);
    }
}
