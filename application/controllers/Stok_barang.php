<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_stok_barang');
        $this->load->model('M_satuan');
        $this->load->model('M_jenis_barang');
        $this->load->model('M_pemasok');
        $this->load->model('M_barang');
    }

    public function index()
    {

        $data['title'] = 'Stok barang';
        $data['stok'] = $this->M_stok_barang->tampil();
        $data['barang'] = $this->M_stok_barang->tampil_groupBy();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Stok_barang/index', $data);
        $this->load->view('templates/footer');
    }


    public function tambah_data()
    {
        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required|is_unique[tb_stok_barang.kode_barang]', [
            'required' => 'Nama barang tidak boleh kosong',
            'is_unique' => 'Nama barang sudah ada'
        ]);


        $this->form_validation->set_rules('stok', 'stok', 'required', [
            'required' => 'Stok tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $response['status'] = 0;
            $response['kode_barang'] = strip_tags(form_error('kode_barang'));
            $response['Stok'] = strip_tags(form_error('stok'));
        } else { 
            $this->M_stok_barang->tambahData();
            $response['status'] = 1;
        }
        echo json_encode($response);
    }

    public function form_ubah($id_stok)
    {


        $this->form_validation->set_rules('Edt_nama_barang', 'nama_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('Edt_stok', 'stok', 'required', [
            'required' => 'Stok tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Ubah Stok Barang';
            $data['id_stok'] = $this->M_stok_barang->ambilId($id_stok);
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Stok_barang/form_ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->M_stok_barang->ubahData();
            $this->session->set_flashdata('message', 'Diubah');
            redirect('Stok_barang');
        }
    }

    public function hapus_data()
    {
        $id_stok = $this->input->post('id_stok');
        return $this->db->query("DELETE FROM tb_stok_barang WHERE id_stok= $id_stok");
    }
}
