<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Halaman_utama extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Halaman Utama';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Halaman utama/index', $data);
        $this->load->view('templates/footer');
    }
}
