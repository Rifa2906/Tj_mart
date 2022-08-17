<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pengguna');
        $this->load->model('M_detail');
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
        $this->form_validation->set_rules('no_telpon', 'No telpon', 'required|max_length[12]', [
            'required' => 'No telpon tidak boleh kosong',
            'max_length' => 'No telpon Harus 12 karakter'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', [
            'required' => 'Alamat tidak boleh kosong'
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
            $response['alamat'] = strip_tags(form_error('alamat'));
            $response['no_telpon'] = strip_tags(form_error('no_telpon'));
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
            'hak_pengguna' => $pengguna['hak_pengguna'],
            'nama' => $pengguna['nama'],
            'alamat' => $pengguna['alamat'],
            'no_telpon' => $pengguna['no_telpon'],
            'email' => $pengguna['email'],
            'kata_sandi' => $pengguna['kata_sandi']
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
        $this->form_validation->set_rules('no_telpon', 'No telpon', 'required|max_length[12]', [
            'required' => 'No telpon tidak boleh kosong',
            'max_length' => 'No telpon Harus 12 karakter'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', [
            'required' => 'Alamat tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('Pass1', 'Password', 'required', [
            'required' => 'Password tidak boleh kosong'
        ]);




        if ($this->form_validation->run() == true) {
            $id_pengguna = $this->input->post('id_pengguna');
            $peran = $this->input->post('peran');
            $this->M_pengguna->ubah($id_pengguna, $peran);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama'] = strip_tags(form_error('nama'));
            $response['alamat'] = strip_tags(form_error('alamat'));
            $response['no_telpon'] = strip_tags(form_error('no_telpon'));
            $response['email'] = strip_tags(form_error('email'));
            $response['pass1'] = strip_tags(form_error('Pass1'));
        }

        echo json_encode($response);
    }

    function hapus_data()
    {
        $id_pengguna = $this->input->post('id_pengguna');
        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->delete('tb_pengguna');
    }
}
