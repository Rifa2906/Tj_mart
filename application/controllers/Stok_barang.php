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
    }

    public function index()
    {

        $data['title'] = 'Stok barang';
        $data['brg'] = $this->M_stok_barang->tampil();
        $data['satuan'] = $this->M_satuan->tampil();
        $data['jenis'] = $this->M_jenis_barang->tampil();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Stok_barang/index', $data);
        $this->load->view('templates/footer');
    }

    function kode_otomatis()
    {
        $tabel = "tb_stok_barang";
        $field = "kode_barang";

        $lastkode = $this->M_stok_barang->get_max($tabel, $field);
        //mengambil 4 karakter dari belakang
        $noUrut = (int) substr($lastkode, -4, 4);
        $noUrut++;
        $str = "BRG";
        $newKode = $str . sprintf('%04s', $noUrut);
        echo json_encode($newKode);
    }

    public function tambah_data()
    {
        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required|is_unique[tb_stok_barang.nama_barang]', [
            'required' => 'Nama barang tidak boleh kosong',
            'is_unique' => 'Nama barang sudah ada'
        ]);

        $this->form_validation->set_rules('id_jenis', 'jenis', 'required', [
            'required' => 'Jenis barang tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'Satuan tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('stok', 'stok', 'required', [
            'required' => 'Stok tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $response['status'] = 0;
            $response['nama_barang'] = strip_tags(form_error('nama_barang'));
            $response['id_jenis'] = strip_tags(form_error('id_jenis'));
            $response['satuan'] = strip_tags(form_error('satuan'));
            $response['stok'] = strip_tags(form_error('stok'));
        } else {
            $this->M_stok_barang->tambahData();
            $response['status'] = 1;
        }
        echo json_encode($response);
    }

    public function form_ubah($id_barang)
    {


        $this->form_validation->set_rules('Edt_nama_barang', 'nama_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('Edt_jenis', 'jenis', 'required', [
            'required' => 'Jenis barang tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('Edt_satuan', 'satuan', 'required', [
            'required' => 'Satuan tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('Edt_stok', 'stok', 'required', [
            'required' => 'Stok tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Ubah Stok Barang';
            $data['id_barang'] = $this->M_stok_barang->ambilId($id_barang);
            $data['satuan'] = $this->M_satuan->tampil();
            $data['jenis'] = $this->M_jenis_barang->tampil();
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
        $id_barang = $this->input->post('id_barang');
        return $this->db->query("DELETE FROM tb_stok_barang WHERE id_barang= $id_barang");
    }
}
