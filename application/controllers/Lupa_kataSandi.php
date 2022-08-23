<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lupa_kataSandi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('templates/header_login');
        $this->load->view('Lupa_kataSandi/index');
        $this->load->view('templates/footer_login');
    }
}
