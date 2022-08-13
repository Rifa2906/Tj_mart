<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pengguna');
    }

    public function index()
    {
        $data['user'] = $this->M_pengguna->tampil();
        $data['title'] = 'Halaman Pengguna';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Pengguna/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_pengguna()
    {
        $this->form_validation->set_rules('nama', 'nama', 'required', [
            'required' => 'nama tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('email', 'email', 'required|valid_email', [
            'required' => 'Email tidak boleh kosong',
            'valid_email' => 'Email tidak valid'
        ]);
        $this->form_validation->set_rules('Pass1', 'Password', 'required', [
            'required' => 'Password tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('Pass2', 'Password Conf', 'required|matches[Pass1]', [
            'required' => 'Password tidak boleh kosong',
            'matches' => 'Password tidak sama'
        ]);



        if ($this->form_validation->run() == true) {
            $this->M_pengguna->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama'] = strip_tags(form_error('nama'));
            $response['email'] = strip_tags(form_error('email'));
            $response['pass1'] = strip_tags(form_error('Pass1'));
            $response['pass2'] = strip_tags(form_error('Pass2'));
        }

        echo json_encode($response);
    }

    public function ambil_IdPengguna()
    {
        $id = $this->input->post('id_pengguna');
        $pengguna = $this->M_pengguna->ambilId($id)->row_array();
        $data = [
            'id_pengguna' => $pengguna['id_pengguna'],
            'peran' => $pengguna['peran'],
            'nama' => $pengguna['nama'],
            'email' => $pengguna['email'],
            'pass1' => $pengguna['kata_sandi']
        ];
        echo json_encode($data);
    }

    public function ubah_data()
    {
        $this->form_validation->set_rules('nama', 'nama', 'required', [
            'required' => 'nama tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('email', 'email', 'required|valid_email', [
            'required' => 'Email tidak boleh kosong',
            'valid_email' => 'Email tidak valid'
        ]);
        $this->form_validation->set_rules('Pass1', 'Password', 'required', [
            'required' => 'Password tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('Pass2', 'Password Conf', 'required|matches[Pass1]', [
            'required' => 'Password tidak boleh kosong',
            'matches' => 'Password tidak sama'
        ]);



        if ($this->form_validation->run() == true) {
            $id_pengguna = $this->input->post('id_pengguna');
            $peran = $this->input->post('peran');
            $this->M_pengguna->ubah($id_pengguna, $peran);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama'] = strip_tags(form_error('nama'));
            $response['email'] = strip_tags(form_error('email'));
            $response['pass1'] = strip_tags(form_error('Pass1'));
            $response['pass2'] = strip_tags(form_error('Pass2'));
        }

        echo json_encode($response);
    }
}
