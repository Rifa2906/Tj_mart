<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peramalan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_peramalan');
    }

    public function index()
    {
        $data['peramalan'] = $this->M_peramalan->tampil();
        $data['title'] = 'Peramalan';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Peramalan/index', $data);
        $this->load->view('templates/footer');
    }

    public function peramalan()
    {
        $id_barang = $this->input->post('id_barang');
        $query = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 3")->result_array();
        $total = 0;
        foreach ($query as $key => $value) {
            $total += $value['jumlah'];
        }

        $barang = $this->db->query("SELECT * FROM tb_stok_barang WHERE id_barang = $id_barang")->row_array();

        //Rumus Single Moving Average (periode 3 bulan)
        $nilai_peramalan = ($total / 3);

        $min_stok = $this->input->post('min_stok');
        $sisa_stok = $barang['stok'];

        $hasil_peramalan = $nilai_peramalan + $min_stok - $sisa_stok;

        $bulan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 1")->row_array();

        $bulan = date('F', strtotime("+1 month", strtotime($bulan['tanggal_keluar'])));
        $produk = $barang['nama_barang'];

        $data = [
            'bulan_berikutnya' => $bulan,
            'peramalan' => $hasil_peramalan,
            'produk' => $produk
        ];



        echo json_encode($data);
    }
}
