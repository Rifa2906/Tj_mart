<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        // $data['satuan'] = $this->M_satuan->tampil();
        $data['title'] = 'Halaman Stok barang';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Stok_barang/index', $data);
        $this->load->view('templates/footer');
    }
}
