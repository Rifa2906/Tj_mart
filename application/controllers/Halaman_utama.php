<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Halaman_utama extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pengguna');
        $this->load->model('M_pemasok');
        $this->load->model('M_stok_barang');
        $this->load->model('M_barang_masuk');
        $this->load->model('M_barang_keluar');
    }
    public function index()
    {
        $data['title'] = 'Halaman Utama';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Halaman_utama/index', $data);
        $this->load->view('templates/footer');
    }

    public function jml_data()
    {
        $data = [
            'pengguna' => count($this->M_pengguna->tampil()),
            'pemasok' => count($this->M_pemasok->tampil()),
            'pemasok' => count($this->M_pemasok->tampil()),
            'stok' => $this->M_stok_barang->jumlah_stok(),
            'brg_masuk' => count($this->M_barang_masuk->tampil()),
            'brg_keluar' => count($this->M_barang_keluar->tampil())
        ];

        echo json_encode($data);
    }





    public function monitoring_barang_pengadaan()
    {
        return $this->M_stok_barang->tampil();
    }
}
