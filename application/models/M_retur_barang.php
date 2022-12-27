<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_retur_barang extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_retur_barang rb',);
        $this->db->join('tb_stok_barang s', 's.id_barang = rb.id_barang');
        $this->db->join('tb_pemasok p', 'p.id_pemasok = rb.id_pemasok');
        $this->db->join('tb_satuan st', 'st.id_satuan = rb.id_satuan');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function tambahdata()
    {
        $id_barang = $this->input->post('barang');
        $jumlah = $this->input->post('jumlah');
        $id_pemasok = $this->input->post('pemasok');

        $brg = $this->db->get('tb_stok_barang', ['id_barang' => $id_barang])->row_array();

        $data = [
            'id_barang' => $id_barang,
            'id_pemasok' => $id_pemasok,
            'id_satuan' => $brg['id_satuan'],
            'jumlah' => $jumlah,
            'status' => 'Belum diterima'

        ];
        $this->db->insert('tb_retur_barang', $data);
    }
}
