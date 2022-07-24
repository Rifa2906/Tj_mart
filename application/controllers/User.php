<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_user');
    }

    public function index()
    {
        $data['user'] = $this->M_user->tampil();
        $data['title'] = 'Halaman Pengguna';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('User/index', $data);
        $this->load->view('templates/footer');
    }
}
