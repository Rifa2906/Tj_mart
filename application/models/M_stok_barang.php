<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stok_barang extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_stok_barang sb',);
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function jumlah_stok()
    {
        $jml_stok = 0;
        $query = $this->db->get('tb_stok_barang')->result_array();
        foreach ($query as $key => $value) {
            $jml_stok += $value['stok'];
        }

        return $jml_stok;
    }

    function get_max($tabel = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($tabel)->row_array()[$field];
    }



    function tambahData()
    {
        $nama_barang = $this->input->post('nama_barang');
        $jenis = $this->input->post('jenis');
        $kode_barang = $this->input->post('kode_barang');
        $stok = $this->input->post('stok');
        $satuan = $this->input->post('satuan');

        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_jenis' => $jenis,
            'id_satuan' => $satuan,
            'stok' => $stok

        ];
        $this->db->insert('tb_stok_barang', $data);
    }

    function ambilId($id_barang)
    {
        return $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();
    }

    function ubahData()
    {
        $id_barang = $this->input->post('Edt_id_barang');
        $kode_barang = $this->input->post('Edt_kode_barang');
        $nama_barang = $this->input->post('Edt_nama_barang');
        $id_satuan = $this->input->post('Edt_satuan');
        $id_jenis = $this->input->post('Edt_jenis');
        $stok = $this->input->post('Edt_stok');


        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_jenis' => $id_jenis,
            'id_satuan' => $id_satuan,
            'stok' => $stok,

        ];
        $this->db->where('id_barang', $id_barang);
        $this->db->update('tb_stok_barang', $data);
    }
}
