<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang_masuk extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_barang_masuk bm');
        $this->db->join('tb_stok_barang sb', 'sb.kode_barang = bm.kode_barang');
        $this->db->join('tb_barang b', 'b.kode_barang = bm.kode_barang');
        $this->db->join('tb_satuan s', 's.id_satuan = bm.id_satuan');
        $this->db->join('tb_pemasok p', 'p.id_pemasok = bm.id_pemasok');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = bm.id_jenis');
        $query = $this->db->get()->result_array();
        return $query;
    }





    function tambahData()
    {
        $kode_barang = $this->input->post('kode_barang');
        $barang = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];
        $jumlah = $this->input->post('jumlah');
        $pemasok = $this->input->post('pemasok');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        $tanggal_kadaluarsa = $this->input->post('tanggal_kadaluarsa');

        $data = [
            'kode_barang' => $kode_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'id_pemasok' => $pemasok,
            'tanggal_masuk' => $tanggal_masuk,
            'jumlah' => $jumlah,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa
        ];
        $this->db->insert('tb_barang_masuk', $data);

        $data_monitoring = [
            'kode_barang' => $kode_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            'jumlah' => $jumlah,
        ];
        $this->db->insert('tb_monitoring_kadaluarsa', $data_monitoring);

        $jumlah_stok = $barang['stok'];
        $total = $jumlah + $jumlah_stok;
        $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
        $min_stok = $jenis['minimal_stok'];
        if ($total < $min_stok) {
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman";
        }

        $data = [
            'stok' => $total,
            'status' => $status
        ];

        $this->db->update('tb_stok_barang', $data, ['kode_barang' => $kode_barang]);
    }

    function ubahData()
    {
        $id_masuk = $this->input->post('id_masuk');
        $kode_barang = $this->input->post('kode_barang');
        $barang = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];
        $jumlah = $this->input->post('jumlah');
        $jumlah_sebelumnya = $this->input->post('jumlah_sebelum');
        $id_pemasok = $this->input->post('pemasok');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        $tanggal_kadaluarsa = $this->input->post('tanggal_kadaluarsa');

        $jumlah_gudang = $barang['stok'];

        if ($jumlah < $jumlah_sebelumnya) {
            $selisih = $jumlah_sebelumnya - $jumlah;
            $total_stok = $jumlah_gudang - $selisih;
            $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
            $min_stok = $jenis['minimal_stok'];
            if ($total_stok < $min_stok) {
                $status = "Harus melakukan pengadaan";
            } else {
                $status = "Stok aman";
            }
            $data = [
                'stok' => $total_stok,
                'status' => $status
            ];

            $this->db->where('kode_barang', $kode_barang);
            $this->db->update('tb_stok_barang', $data);
        } else if ($jumlah > $jumlah_sebelumnya) {
            $selisih = $jumlah - $jumlah_sebelumnya;
            $total_stok = $selisih + $jumlah_gudang;
            $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
            $min_stok = $jenis['minimal_stok'];
            if ($total_stok < $min_stok) {
                $status = "Harus melakukan pengadaan";
            } else {
                $status = "Stok aman";
            }
            $data = [
                'stok' => $total_stok,
                'status' => $status
            ];

            $this->db->where('kode_barang', $kode_barang);
            $this->db->update('tb_stok_barang', $data);
        }



        $data = [
            'kode_barang' => $kode_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'id_pemasok' => $id_pemasok,
            'tanggal_masuk' => $tanggal_masuk,
            'jumlah' => $jumlah,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa
        ];
        $this->db->where('id_masuk', $id_masuk);
        $this->db->update('tb_barang_masuk', $data);

        $data = [
            'kode_barang' => $kode_barang,
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            'jumlah' => $jumlah,
        ];

        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('tb_monitoring_kadaluarsa', $data);
    }
}
