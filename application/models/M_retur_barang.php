<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_retur_barang extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_retur_barang rb',);
        $this->db->join('tb_stok_barang s', 's.kode_barang = rb.kode_barang');
        $this->db->join('tb_barang b', 'b.kode_barang = rb.kode_barang');
        $this->db->join('tb_pemasok p', 'p.id_pemasok = rb.id_pemasok');
        $this->db->join('tb_satuan st', 'st.id_satuan = rb.id_satuan');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function tambahdata()
    {
        $kode_barang = $this->input->post('kode_barang');
        $retur = $this->input->post('jumlah');
        $id_pemasok = $this->input->post('pemasok');

        $brg = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $id_jenis = $brg['id_jenis'];
        $id_satuan = $brg['id_satuan'];
        $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
        $min_stok = $jenis['minimal_stok'];
        $stok = $brg['stok'];
        $total_stok = $stok - $retur;
        if ($total_stok < $min_stok) {

            $tanggal_sekarang = strtotime('now');
            $tanggal = date('01 F Y', strtotime('+1 month', $tanggal_sekarang));
            $data = [
                'kode_barang' => $kode_barang,
                'id_satuan' => $id_satuan,
                'id_jenis' => $id_jenis,
                'jumlah_pengadaan' => $this->jumlah_pengadaan($kode_barang, $total_stok),
                'bulan' => $tanggal,
                'pemasok' => $this->supplier($kode_barang)
            ];

            $this->db->insert('tb_pengadaan', $data);
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman";
        }


        $data = [
            'kode_barang' => $kode_barang,
            'id_pemasok' => $id_pemasok,
            'id_satuan' => $brg['id_satuan'],
            'jumlah' => $retur
        ];

        $data_stok = [
            'stok' => $total_stok,
            'status' => $status
        ];

        $this->db->insert('tb_retur_barang', $data);

        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('tb_stok_barang', $data_stok);
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
