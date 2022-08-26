<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_satuan');
    }

    public function index()
    {
        $data['satuan'] = $this->M_satuan->tampil();
        $data['title'] = 'Halaman Satuan';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Satuan/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_satuan()
    {
        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'satuan tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == true) {
            $this->M_satuan->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['satuan'] = strip_tags(form_error('satuan'));
        }

        echo json_encode($response);
    }

    public function ambil_IdSatuan()
    {
        $id = $this->input->post('id_satuan');
        $satuan = $this->M_satuan->ambilId($id)->row_array();
        $data = [
            'id_satuan' => $satuan['id_satuan'],
            'satuan' => $satuan['satuan'],
        ];
        echo json_encode($data);
    }

    public function ubah_data()
    {
        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'satuan tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == true) {
            $id_satuan = $this->input->post('id_satuan');
            $this->M_satuan->ubah($id_satuan);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['satuan'] = strip_tags(form_error('satuan'));
        }

        echo json_encode($response);
    }

    function hapus_data()
    {
        $id_satuan = $this->input->post('id_satuan');
        $this->db->where('id_satuan', $id_satuan);
        $this->db->delete('tb_satuan');
    }
}
