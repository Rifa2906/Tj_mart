<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Autentikasi extends CI_Controller
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
            $this->load->view('Autentikasi/index');
            $this->load->view('templates/footer_login');
        } else {
            $this->login_aksi();
        }
    }

    public function login_aksi()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('tb_pengguna', ['email' => $email])->row_array();


        if ($user) {

            //cek pass
            if ($password == $user['kata_sandi']) {
                $data = [
                    'nama' => $user['nama'],
                    'hak_pengguna' => $user['hak_pengguna'],
                    'id' => $user['id_pengguna']
                ];

                $this->session->set_userdata($data);
                redirect('Halaman_utama');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Password salah
               </div>');
                redirect('Autentikasi');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
           Email belum terdaftar
          </div>');
            redirect('Autentikasi');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('nama');
        redirect('Autentikasi');
    }

    public function sendEmail()
    {
    }
}
