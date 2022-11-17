<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_pengguna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_detail');
    }

    public function detail($id_pengguna)
    {
        $data['detail'] = $this->M_detail->tampil($id_pengguna);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Pengguna/detail', $data);
        $this->load->view('templates/footer');
    }

    public function edit_pass()
    {
        $this->form_validation->set_rules('passLama', 'Kata sandi', 'required', [
            'required' => 'Kata sandi tidak boleh kosong'

        ]);

        $this->form_validation->set_rules('passBaru', 'Kata sandi', 'required|is_unique[tb_pengguna.kata_sandi]', [
            'required' => 'Kata sandi tidak boleh kosong',
            'is_unique' => 'Kata sandi ini sudah ada !'
        ]);
        $this->form_validation->set_rules('passKonf', 'Kata sandi Conf', 'required|matches[passBaru]', [
            'required' => 'Kata sandi tidak boleh kosong',
            'matches' => 'Kata sandi tidak sama'
        ]);

        if ($this->form_validation->run() == true) {
            $id_p = $this->input->post('id_p');
            $this->M_detail->edit($id_p);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['passBaru'] = strip_tags(form_error('passBaru'));
            $response['passKonf'] = strip_tags(form_error('passKonf'));
            $response['passLama'] = strip_tags(form_error('passLama'));
        }
        echo json_encode($response);
    }
}
