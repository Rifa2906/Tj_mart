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
    }
    public function index()
    {
        $data['title'] = 'Halaman Utama';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Halaman_utama/index', $data);
        $this->load->view('templates/footer');
    }

    public function jml_data()
    {
        $data = [
            'pengguna' => count($this->M_pengguna->tampil()),
            'pemasok' => count($this->M_pemasok->tampil())
        ];

        echo json_encode($data);
    }
}
