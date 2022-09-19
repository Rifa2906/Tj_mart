<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang_keluar extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_barang_keluar bk',);
        $this->db->join('tb_satuan s', 's.id_satuan = bk.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = bk.id_jenis');
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = bk.id_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_max($tabel = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($tabel)->row_array()[$field];
    }

    function tampil_idBrg($id_brg)
    {
        return $this->db->get_where('tb_stok_barang', ['id_barang' => $id_brg])->row_array();
    }

    function tambahData()
    {
        $id_barang = $this->input->post('nama_barang');
        $nama_jenis = $this->input->post('nama_jenis');
        $kode = $this->input->post('kode_barang_keluar');
        $jumlah_keluar = $this->input->post('jumlah_keluar');
        $satuan = $this->input->post('satuan');
        $tanggal_keluar = $this->input->post('tanggal_keluar');

        $data = [
            'kode_barang_keluar' => $kode,
            'tanggal_keluar' => $tanggal_keluar,
            'id_barang' => $id_barang,
            'id_satuan' => $satuan,
            'id_jenis' => $nama_jenis,
            'jumlah' => $jumlah_keluar,
        ];
        $this->db->insert('tb_barang_keluar', $data);
        $jumlah_stok_G = $this->input->post('jumlah_stok_G');
        $total = $jumlah_stok_G - $jumlah_keluar;

        $data = [
            'stok' => $total
        ];

        $this->db->update('tb_stok_barang', $data, ['id_barang' => $id_barang]);
    }

    function ubahData()
    {
        $id_keluar = $this->input->post('id_keluar');
        $id_barang = $this->input->post('nama_barang');
        $id_jenis = $this->input->post('nama_jenis');
        $kode = $this->input->post('kode_barang_keluar');
        $jumlah_keluar = $this->input->post('jumlah_keluar');
        $jumlah_sebelumnya = $this->input->post('jumlah_sebelum');
        $satuan = $this->input->post('satuan');
        $tanggal_keluar = $this->input->post('tanggal_keluar');

        $brg_stok = $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();

        $jumlah_gudang = $brg_stok['stok'];

        if ($jumlah_keluar < $jumlah_sebelumnya) {
            $selisih = $jumlah_sebelumnya - $jumlah_keluar;
            $total_stok = $jumlah_gudang + $selisih;

            $data = [
                'stok' => $total_stok
            ];

            $this->db->where('id_barang', $id_barang);
            $this->db->update('tb_stok_barang', $data);
        } else if ($jumlah_keluar > $jumlah_sebelumnya) {
            $selisih = $jumlah_keluar - $jumlah_sebelumnya;
            $total_stok = $jumlah_gudang - $selisih;

            $data = [
                'stok' => $total_stok
            ];

            $this->db->where('id_barang', $id_barang);
            $this->db->update('tb_stok_barang', $data);
        }



        $data = [
            'kode_barang_keluar' => $kode,
            'tanggal_keluar' => $tanggal_keluar,
            'id_barang' => $id_barang,
            'id_satuan' => $satuan,
            'id_jenis' => $id_jenis,
            'jumlah' => $jumlah_keluar,
        ];
        $this->db->where('id_keluar', $id_keluar);
        $this->db->update('tb_barang_keluar', $data);
    }
}
