<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pemasok');
        $this->load->model('M_barang');
        $this->load->model('M_satuan');
        $this->load->model('M_jenis_barang');
    }

    public function index()
    {
        $data['title'] = 'Data barang';
        $data['kode_barang'] = $this->kode_otomatis();
        $data['pemasok'] = $this->M_pemasok->tampil();
        $data['barang'] = $this->M_barang->tampil();
        $data['satuan'] = $this->M_satuan->tampil();
        $data['jenis'] = $this->M_jenis_barang->tampil();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Barang/index', $data);
        $this->load->view('templates/footer');
    }

    function kode_otomatis()
    {
        $tabel = "tb_barang";
        $field = "kode_barang";

        $lastkode = $this->M_barang->get_max($tabel, $field);
        //mengambil 4 karakter dari belakang
        $noUrut = (int) substr($lastkode, -4, 4);
        $noUrut++;
        $str = "BRG";
        $newKode = $str . sprintf('%04s', $noUrut);
        return $newKode;
    }

    public function tambah_barang()
    {
        $this->form_validation->set_rules('pemasok', 'pemasok', 'required', [
            'required' => 'pemasok tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('barang', 'barang', 'required', [
            'required' => 'barang tidak boleh kosong'
        ]);


        $this->form_validation->set_rules('harga', 'harga', 'required', [
            'required' => 'harga tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'satuan tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('jenis', 'jenis', 'required', [
            'required' => 'jenis tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == true) {
            $this->M_barang->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['pemasok'] = strip_tags(form_error('pemasok'));
            $response['barang'] = strip_tags(form_error('barang'));
            $response['harga'] = strip_tags(form_error('harga'));
            $response['satuan'] = strip_tags(form_error('satuan'));
            $response['jenis'] = strip_tags(form_error('jenis'));
        }

        echo json_encode($response);
    }

    public function form_ubah($id_barang)
    {

        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('harga', 'harga', 'required', [
            'required' => 'Harga tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'Satuan tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('jenis_barang', 'jenis_barang', 'required', [
            'required' => 'Jenis barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('supplier', 'pemasok', 'required', [
            'required' => 'Supplier tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Ubah Data Barang';
            $data['pemasok'] = $this->M_pemasok->tampil();
            $data['satuan'] = $this->M_satuan->tampil();
            $data['jenis'] = $this->M_jenis_barang->tampil();
            $data['id_barang'] = $this->M_barang->ambil_IdBarang($id_barang);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Barang/form_ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->M_barang->ubah_data();
            $this->session->set_flashdata('message', 'Diubah');
            redirect('Barang');
        }
    }

    function hapus_data()
    {
        $id_barang = $this->input->post('id_barang');
        $this->db->where('id_barang', $id_barang);
        $this->db->delete('tb_barang');
    }
}
