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
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
            'required' => 'Email tidak boleh kosong'

        ]);

        $this->form_validation->set_rules('password_baru', 'Kata sandi', 'required', [
            'required' => 'Kata sandi tidak boleh kosong'

        ]);

        $this->form_validation->set_rules('password_conf', 'Kata sandi', 'required|matches[password_baru]', [
            'required' => 'Kata sandi tidak boleh kosong',
            'matches' => 'Kata sandi tidak sama'

        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_login');
            $this->load->view('Lupa_kataSandi/index');
            $this->load->view('templates/footer_login');
        } else {

            $this->ganti_kataSandi();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Kata sandi berhasil dibuat
           </div>');
            redirect('Lupa_kataSandi');
        }
    }

    public function ganti_kataSandi()
    {
        $email = $this->input->post('email');
        $kataSandi_b = $this->input->post('password_baru');


        $data = [
            'kata_sandi' => $kataSandi_b,
        ];
        $this->db->where('email', $email);
        $this->db->update('tb_pengguna', $data);
    }
}
