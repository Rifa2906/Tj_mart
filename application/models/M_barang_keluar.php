<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang_keluar extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_barang_keluar bk',);
        $this->db->join('tb_stok_barang sb', 'sb.kode_barang = bk.kode_barang');
        $this->db->join('tb_barang b', 'b.kode_barang = bk.kode_barang');
        $this->db->join('tb_satuan s', 's.id_satuan = bk.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = bk.id_jenis');
        $this->db->order_by('bk.tanggal_keluar DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }



    function tampil_idBrg($kode_barang)
    {
        return $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
    }

    function tambahData()
    {
        $kode_barang = $this->input->post('kode_barang');
        $barang = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $tanggal_keluar = $this->input->post('tanggal_keluar');
        $id_jenis = $barang['id_jenis'];
        $id_satuan = $barang['id_satuan'];
        $jumlah_keluar = $this->input->post('jumlah_keluar');

        $data = [
            'kode_barang' => $kode_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'tanggal_keluar' => $tanggal_keluar,
            'jumlah' => $jumlah_keluar,
        ];
        $this->db->insert('tb_barang_keluar', $data);
        $jumlah_stok_G = $this->input->post('jumlah_stok_G');
        $total = $jumlah_stok_G - $jumlah_keluar;
        $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
        $min_stok = $jenis['minimal_stok'];
        if ($total < $min_stok) {
            $tanggal_sekarang = strtotime('now');
            $tanggal = date('01 F Y', strtotime('+1 month', $tanggal_sekarang));
            $data = [
                'kode_barang' => $kode_barang,
                'id_satuan' => $id_satuan,
                'id_jenis' => $id_jenis,
                'jumlah_pengadaan' => $this->jumlah_pengadaan($kode_barang, $total),
                'bulan' => $tanggal,
                'pemasok' => $this->supplier($kode_barang)
            ];

            $this->db->insert('tb_pengadaan', $data);
            $status = "Harus melakukan pengadaan";
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
        $id_keluar = $this->input->post('id_keluar');
        $kode_barang = $this->input->post('kode_barang');
        $barang = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $id_jenis = $barang['id_jenis'];
        $id_satuan = $barang['id_satuan'];
        $jumlah_keluar = $this->input->post('jumlah_keluar');
        $jumlah_sebelumnya = $this->input->post('jumlah_sebelum');

        $tanggal_keluar = $this->input->post('tanggal_keluar');

        $brg_stok = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();

        $jumlah_gudang = $brg_stok['stok'];

        if ($jumlah_keluar < $jumlah_sebelumnya) {
            $selisih = $jumlah_sebelumnya - $jumlah_keluar;
            $total_stok = $jumlah_gudang + $selisih;
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
        } else if ($jumlah_keluar > $jumlah_sebelumnya) {
            $selisih = $jumlah_keluar - $jumlah_sebelumnya;
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
        }



        $data = [
            'kode_barang' => $kode_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'tanggal_keluar' => $tanggal_keluar,
            'jumlah' => $jumlah_keluar,
        ];
        $this->db->where('id_keluar', $id_keluar);
        $this->db->update('tb_barang_keluar', $data);
    }

    function jumlah_pengadaan($kode_barang, $total_stok)
    {
        $this->db->select('*');
        $this->db->from('tb_stok_barang sb');
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->where('kode_barang', $kode_barang);
        $barang = $this->db->get()->row_array();

        $query = $this->db->query("SELECT *, SUM(jumlah) as jumlah_baru FROM tb_barang_keluar WHERE kode_barang = '{$kode_barang}' GROUP BY MONTH(tanggal_keluar) ORDER BY tanggal_keluar DESC LIMIT 3")->result_array();

        $total = 0;
        foreach ($query as $key => $value) {
            $total += $value['jumlah_baru'];
        }
        //Rumus Single Moving Average (periode 3 bulan)
        $nilai_peramalan = ($total / 3);
        $min_stok = $barang['minimal_stok'];
        $hasil_peramalan = ceil($nilai_peramalan + $min_stok) - $total_stok;

        return $hasil_peramalan;
    }

    public function supplier($kode_barang)
    {
        $barang = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang = '{$kode_barang}'")->row_array();
        $nama_barang = $barang['nama_barang'];
        $this->db->select_min('harga');
        $this->db->where('nama_barang', $nama_barang);
        $brg = $this->db->get('tb_barang')->row_array();
        $id_pemasok = $barang['id_pemasok'];

        $pemasok = $this->db->get_where('tb_pemasok', ['id_pemasok' => $id_pemasok])->row_array();
        $nama_pemasok = $pemasok['nama_pemasok'];
        return $nama_pemasok;
    }
}
