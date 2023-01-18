<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stok_barang extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_stok_barang sb');
        $this->db->join('tb_barang b', 'b.kode_barang  = sb.kode_barang ');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        return $this->db->get()->result_array();
    }

    public function tampil_groupBy()
    {
        $this->db->select('*');
        $this->db->from('tb_barang b',);
        $this->db->join('tb_pemasok pm', 'pm.id_pemasok = b.id_pemasok');
        $this->db->join('tb_satuan s', 's.id_satuan = b.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = b.id_jenis');
        return $this->db->get()->result_array();
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


    function tambahData()
    {
        $kode_barang = $this->input->post('kode_barang');
        $stok = $this->input->post('stok');
        $barang = $this->db->get_where('tb_barang', ['kode_barang' => $kode_barang])->row_array();
        $id_jenis = $barang['id_jenis'];
        $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
        $min_stok = $jenis['minimal_stok'];
        if ($stok < $min_stok) {
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman";
        }

        $data = [
            'kode_barang' => $kode_barang,
            'id_jenis' => $barang['id_jenis'],
            'id_satuan' => $barang['id_satuan'],
            'stok' => $stok,
            'status' => $status

        ];
        $this->db->insert('tb_stok_barang', $data);
    }

    function ambilId($id_stok)
    {
        $this->db->select('*');
        $this->db->from('tb_stok_barang sb');
        $this->db->from('tb_barang b', 'b.id_barang = sb.id_barang');
        $this->db->where('sb.id_stok', $id_stok);
        return $this->db->get()->row_array();
    }

    function ubahData()
    {
        $id_barang = $this->input->post('id_barang');
        $stok = $this->input->post('Edt_stok');

        $brg = $this->db->get('tb_stok_barang', ['id_barang' => $id_barang])->row_array();
        $id_jenis = $brg['id_jenis'];
        $jenis = $this->db->get('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();

        $min_stok = $jenis['minimal_stok'];

        if ($stok < $min_stok) {
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman";
        }

        $data = [
            'id_barang' => $id_barang,
            'id_jenis' => $id_jenis,
            'id_satuan' => $id_satuan,
            'stok' => $stok,
            'status' => $status

        ];
        $this->db->where('id_barang', $id_barang);
        $this->db->update('tb_stok_barang', $data);
    }


    public function monitoring()
    {
        $barang = $this->M_stok_barang->tampil();
        if ($barang['status'] == "Harus melakukan pengadaan") {
            $id_barang = $barang['id_barang'];
            $this->db->select('*');
            $this->db->from('tb_stok_barang sb',);
            $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
            $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
            $this->db->where('sb.id_barang', $id_barang);
            $barang = $this->db->get()->row_array();

            $bulan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 1")->row_array();

            $tanggal = date('1 F Y', strtotime("+1 month", strtotime($bulan['tanggal_keluar'])));


            $query = $this->db->query("SELECT *,SUM(jumlah) AS jumlah FROM tb_barang_keluar WHERE id_barang = $id_barang GROUP BY MONTH(tanggal_keluar) ORDER BY tanggal_keluar DESC LIMIT 3")->result_array();
            $total = 0;
            foreach ($query as $key => $value) {
                $total += $value['jumlah'];
            }

            //Rumus Single Moving Average (periode 3 bulan)
            $nilai_peramalan = ($total / 3);


            $sisa_stok = $barang['stok'];

            $hasil_peramalan = ceil($nilai_peramalan + $barang['minimal_stok'] - $sisa_stok);

            $bulan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 1")->row_array();

            $tanggal = date('1 F Y', strtotime("+1 month", strtotime($bulan['tanggal_keluar'])));

            $data = [
                'id_barang' => $id_barang,
                'id_satuan' => $barang['id_satuan'],
                'id_jenis' => $barang['id_jenis'],
                'jumlah_pengadaan' => $hasil_peramalan,
                'bulan' => $tanggal,
            ];

            $this->db->insert('tb_peramalan', $data);
        }
    }
}
