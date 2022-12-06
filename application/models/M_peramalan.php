<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_peramalan extends CI_Model
{
    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_peramalan p',);
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = p.id_barang');
        $this->db->join('tb_satuan s', 's.id_satuan = p.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = p.id_jenis');
        $query = $this->db->get()->result_array();
        return $query;
    }



    function tambah_data_peramalan()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->db->query("SELECT * FROM tb_stok_barang WHERE id_barang = $id_barang")->row_array();
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];

        $jenis_barang = $this->db->query("SELECT * FROM tb_jenis_barang WHERE id_jenis = $id_jenis")->row_array();

        if ($jenis_barang['nama_jenis'] == 'Makanan') {
            $minimal_stok = 3;
        } elseif ($jenis_barang['nama_jenis'] == 'Minuman') {
            $minimal_stok = 10;
        }

        // Peramalan
        $data_peramalan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang")->num_rows();

        $this->db->select('*');
        $this->db->from('tb_stok_barang sb',);
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->where('sb.id_barang', $id_barang);
        $barang = $this->db->get()->row_array();

        $query = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 3")->result_array();
        $total = 0;
        foreach ($query as $key => $value) {
            $total += $value['jumlah'];
        }



        //Rumus Single Moving Average (periode 3 bulan)
        $nilai_peramalan = ($total / 3);

        $min_stok = $minimal_stok;
        $sisa_stok = $barang['stok'];

        $hasil_peramalan = ceil($nilai_peramalan + $min_stok - $sisa_stok);

        $bulan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 1")->row_array();

        $tanggal = date('j-F-Y', strtotime("+1 month", strtotime($bulan['tanggal_keluar'])));






        $data = [
            'id_barang' => $id_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'jumlah_pengadaan' => $hasil_peramalan,
            'bulan' => $tanggal,
            'pemasok' => 'Supplier belum dipilih',
            'minimal_stok' => $minimal_stok
        ];

        $this->db->insert('tb_peramalan', $data);
    }
}
