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
        $nama_jenis = $this->input->post('nama_jenis');
        $kode = $this->input->post('kode_barang');
        $stok = $this->input->post('jumlah_stok');
        $satuan = $this->input->post('satuan');


        $data = [
            'kode_barang' => $kode,
            'nama_barang' => $nama_barang,
            'id_jenis' => $nama_jenis,
            'stok' => $stok,
            'id_satuan' => $satuan
        ];
        $this->db->insert('tb_stok_barang', $data);
    }

    function ubahData()
    {
        $id_barang = $this->input->post('Edt_id_brg');
        $nama_barang = $this->input->post('Edt_nama_barang');
        $id_jenis = $this->input->post('Edt_nama_jenis');
        $kode = $this->input->post('Edt_kode_barang');
        $stok = $this->input->post('Edt_stok');
        $id_satuan = $this->input->post('Edt_satuan');

        $data = [
            'kode_barang' => $kode,
            'nama_barang' => $nama_barang,
            'id_jenis' => $id_jenis,
            'stok' => $stok,
            'id_satuan' => $id_satuan,
        ];
        $this->db->where('id_barang', $id_barang);
        $this->db->update('tb_stok_barang', $data);
    }
}
