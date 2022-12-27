<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_stok extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_stok_barang');
        $this->load->model('M_jenis_barang');
    }

    public function index()
    {

        $data['title'] = 'Monitoring Stok';
        $data['brg'] = $this->monitoring_stok();
        $data['jb'] = $this->M_jenis_barang->tampil();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Monitoring_stok/index', $data);
        $this->load->view('templates/footer');
    }

    public function monitoring_stok()
    {
        return $this->M_stok_barang->tampil();
    }
}
