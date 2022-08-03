<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_login');
            $this->load->view('Login/index');
            $this->load->view('templates/footer_login');
        } else {
            $this->login_aksi();
        }
    }

    public function login_aksi()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('tb_user', ['email' => $email])->row_array();

        if ($user) {

            //cek pass
            if ($password == $user['password']) {
                $data = [
                    'nama' => $user['nama']
                ];

                $this->session->set_userdata($data);
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Password salah
               </div>');
                redirect('Login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
           Email belum terdaftar
          </div>');
            redirect('Login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('nama');
        redirect('Login');
    }

    public function sendEmail()
    {
    }
}
