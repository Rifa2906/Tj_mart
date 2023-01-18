<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_barang b',);
        $this->db->join('tb_pemasok pm', 'pm.id_pemasok = b.id_pemasok');
        $this->db->join('tb_satuan s', 's.id_satuan = b.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = b.id_jenis');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_max($tabel = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($tabel)->row_array()[$field];
    }

    function tambahdata()
    {
        $id_pemasok = $this->input->post('pemasok');
        $barang = $this->input->post('barang');
        $kode_barang = $this->input->post('kode_barang');
        $harga = $this->input->post('harga');
        $harga_str = preg_replace('/[^A-Za-z0-9]/', '', $harga);
        $harga_int = (int)$harga_str;
        $id_satuan = $this->input->post('satuan');
        $id_jenis = $this->input->post('jenis');

        $data = [
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'id_pemasok' => $id_pemasok,
            'kode_barang' => $kode_barang,
            'nama_barang' => $barang,
            'harga' => $harga_int,
        ];
        $this->db->insert('tb_barang', $data);
    }
}
