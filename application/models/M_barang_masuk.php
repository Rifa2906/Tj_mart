<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang_masuk extends CI_Model
{

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
        $barang = $this->db->query("SELECT * FROM tb_stok_barang WHERE id_barang = $id_barang")->row_array();
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];
        $jumlah = $this->input->post('jumlah');
        $pemasok = $this->input->post('pemasok');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        $tanggal_kadaluarsa = $this->input->post('tanggal_kadaluarsa');

        $data = [
            'id_barang' => $id_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'id_pemasok' => $pemasok,
            'tanggal_masuk' => $tanggal_masuk,
            'jumlah' => $jumlah,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa
        ];
        $this->db->insert('tb_barang_masuk', $data);

        $data_monitoring = [
            'id_barang' => $id_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            'jumlah' => $jumlah,
        ];
        $this->db->insert('tb_monitoring_kadaluarsa', $data_monitoring);

        $jumlah_stok = $this->input->post('jumlah_stok');
        $total = $jumlah + $jumlah_stok;

        $data = [
            'stok' => $total
        ];

        $this->db->update('tb_stok_barang', $data, ['id_barang' => $id_barang]);
    }

    function ubahData()
    {
        $id_masuk = $this->input->post('id_masuk');
        $id_barang = $this->input->post('nama_barang');
        $barang = $this->db->query("SELECT * FROM tb_stok_barang WHERE id_barang = $id_barang")->row_array();
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];
        $jumlah = $this->input->post('jumlah');
        $jumlah_sebelumnya = $this->input->post('jumlah_sebelum');
        $pemasok = $this->input->post('pemasok');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        $tanggal_kadaluarsa = $this->input->post('tanggal_kadaluarsa');


        $brg_stok = $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();

        $jumlah_gudang = $brg_stok['stok'];

        if ($jumlah < $jumlah_sebelumnya) {
            $selisih = $jumlah_sebelumnya - $jumlah;
            $total_stok = $jumlah_gudang - $selisih;
            $data = [
                'stok' => $total_stok
            ];

            $this->db->where('id_barang', $id_barang);
            $this->db->update('tb_stok_barang', $data);
        } else if ($jumlah > $jumlah_sebelumnya) {
            $selisih = $jumlah - $jumlah_sebelumnya;
            $total_stok = $selisih + $jumlah_gudang;
            $data = [
                'stok' => $total_stok
            ];

            $this->db->where('id_barang', $id_barang);
            $this->db->update('tb_stok_barang', $data);
        }



        $data = [
            'id_barang' => $id_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'id_pemasok' => $pemasok,
            'tanggal_masuk' => $tanggal_masuk,
            'jumlah' => $jumlah,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa
        ];
        $this->db->where('id_masuk', $id_masuk);
        $this->db->update('tb_barang_masuk', $data);

        $data = [
            'id_barang' => $id_barang,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            'jumlah' => $jumlah,
        ];

        $this->db->where('id_barang', $id_barang);
        $this->db->update('tb_monitoring_kadaluarsa', $data);
    }
}
