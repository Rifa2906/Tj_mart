<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        $this->load->view('templates/header_login');
        $this->load->view('Login/index');
        $this->load->view('templates/footer_login');
    }
}
