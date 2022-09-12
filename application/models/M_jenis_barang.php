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


        $data = [
            'nama_jenis' => $nama_jenis
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


        $data = [
            'nama_jenis' => $nama_jenis
        ];
        $this->db->where('id_jenis', $id_jenis);
        $this->db->update('tb_jenis_barang', $data);
    }
}
