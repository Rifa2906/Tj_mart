<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_permintaan');
    }

    public function index()
    {
        $data['permintaan'] = $this->M_permintaan->tampil();
        $data['title'] = 'Permintaan barang';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Permintaan/index', $data);
        $this->load->view('templates/footer');
    }
}
