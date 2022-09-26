<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_jenis_barang');
    }

    public function index()
    {
        $data['jenis'] = $this->M_jenis_barang->tampil();
        $data['title'] = 'Jenis Barang';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Jenis_barang/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_jenis_barang()
    {
        $this->form_validation->set_rules('nama_jenis', 'nama_jenis', 'required', [
            'required' => 'Nama jenis tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == true) {
            $this->M_jenis_barang->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama_jenis'] = strip_tags(form_error('nama_jenis'));
        }

        echo json_encode($response);
    }

    public function ambil_Idjenis()
    {
        $id = $this->input->post('id_jenis');
        $jenis = $this->M_jenis_barang->ambilId($id)->row_array();
        $data = [
            'id_jenis' => $jenis['id_jenis'],
            'nama_jenis' => $jenis['nama_jenis'],
        ];
        echo json_encode($data);
    }


    public function ubah_data()
    {
        $this->form_validation->set_rules('nama_jenis', 'nama_jenis', 'required', [
            'required' => 'Nama jenis tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == true) {
            $id_jenis = $this->input->post('id_jenis');
            $this->M_jenis_barang->ubah($id_jenis);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama_jenis'] = strip_tags(form_error('nama_jenis'));
        }

        echo json_encode($response);
    }

    function hapus_data()
    {
        $id_jenis = $this->input->post('id_jenis');
        $this->db->where('id_jenis', $id_jenis);
        $this->db->delete('tb_jenis_barang');
    }
}
