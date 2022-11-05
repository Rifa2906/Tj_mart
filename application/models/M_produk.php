<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_produk extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_produk p',);
        $this->db->join('tb_pemasok pm', 'pm.id_pemasok = p.id_pemasok');
        $this->db->join('tb_satuan s', 's.id_satuan = p.id_satuan');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function tambahdata()
    {
        $id_pemasok = $this->input->post('pemasok');
        $produk = $this->input->post('produk');
        $harga = $this->input->post('harga');
        $harga_str = preg_replace('/[^A-Za-z0-9]/', '', $harga);
        $harga_int = (int)$harga_str;
        $id_satuan = $this->input->post('satuan');

        $data = [
            'id_pemasok' => $id_pemasok,
            'id_satuan' => $id_satuan,
            'produk' => $produk,
            'harga' => $harga_int,
        ];
        $this->db->insert('tb_produk', $data);
    }
}
