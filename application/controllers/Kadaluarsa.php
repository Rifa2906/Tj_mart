<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kadaluarsa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_kadaluarsa');
    }

    public function index()
    {
        $data['kd'] = $this->M_kadaluarsa->tampil();
        $data['title'] = 'Barang Kadaluarsa';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Kadaluarsa/index', $data);
        $this->load->view('templates/footer');
    }
}
