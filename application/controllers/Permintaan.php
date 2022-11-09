<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_permintaan');
    }

    public function index()
    {
        $data['permintaan'] = $this->M_permintaan->tampil();
        $data['title'] = 'Permintaan barang';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Permintaan/index', $data);
        $this->load->view('templates/footer');
    }

    public function Disetujui()
    {
        $id_permintaan = $this->input->post('id_permintaan');
        $data = [
            'status' => 'Sudah disetujui'
        ];
        $this->db->update('tb_permintaan', $data, ['id_permintaan' => $id_permintaan]);

        $response['status'] = 1;
        echo json_encode($response);
    }

    public function Ditolak()
    {
        $id_permintaan = $this->input->post('id_permintaan');
        $data = [
            'status' => 'Tidak disetujui'
        ];
        $this->db->update('tb_permintaan', $data, ['id_permintaan' => $id_permintaan]);

        $response['status'] = 1;
        echo json_encode($response);
    }

    public function hapus()
    {
        $id_permintaan = $this->input->post('id_permintaan');
        $this->db->delete('tb_permintaan', ['id_permintaan' => $id_permintaan]);
        $respon['status'] = 1;
        echo json_encode($respon);
    }
}
