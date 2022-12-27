<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stok_barang extends CI_Model
{

    function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_stok_barang sb',);
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $query = $this->db->get()->result_array();
        return $query;
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

    function get_max($tabel = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($tabel)->row_array()[$field];
    }



    function tambahData()
    {
        $nama_barang = $this->input->post('nama_barang');
        $id_jenis = $this->input->post('id_jenis');
        $kode_barang = $this->input->post('kode_barang');
        $stok = $this->input->post('stok');
        $satuan = $this->input->post('satuan');

        $jenis = $this->db->get('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
        $min_stok = $jenis['minimal_stok'];
        if ($stok < $min_stok) {
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman ";
        }

        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_jenis' => $id_jenis,
            'id_satuan' => $satuan,
            'stok' => $stok,
            'status' => $status

        ];
        $this->db->insert('tb_stok_barang', $data);
    }

    function ambilId($id_barang)
    {
        return $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();
    }

    function ubahData()
    {
        $id_barang = $this->input->post('Edt_id_barang');
        $kode_barang = $this->input->post('Edt_kode_barang');
        $nama_barang = $this->input->post('Edt_nama_barang');
        $id_satuan = $this->input->post('Edt_satuan');
        $id_jenis = $this->input->post('Edt_jenis');
        $stok = $this->input->post('Edt_stok');

        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_jenis' => $id_jenis,
            'id_satuan' => $id_satuan,
            'stok' => $stok

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
