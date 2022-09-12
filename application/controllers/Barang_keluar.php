<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_keluar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_barang_keluar');
        $this->load->model('M_satuan');
        $this->load->model('M_jenis_barang');
        $this->load->model('M_stok_barang');
    }

    public function index()
    {

        $data['barang_keluar'] = $this->M_barang_keluar->tampil();
        $data['title'] = 'Barang keluar';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Barang_keluar/index', $data);
        $this->load->view('templates/footer');
    }

    public function tampil_brg()
    {
        $id_brg = $this->input->post('id_brg');

        $barang =  $this->M_barang_keluar->tampil_idBrg($id_brg);
        $data = [
            'stok' => $barang['stok']
        ];

        echo json_encode($data);
    }

    function kode_otomatis()
    {
        $tabel = "tb_barang_keluar";
        $field = "kode_barang_keluar";

        $lastkode = $this->M_barang_keluar->get_max($tabel, $field);
        //mengambil 4 karakter dari belakang
        $noUrut = (int) substr($lastkode, -4, 4);
        $noUrut++;
        $str = "T-BK-";
        $newKode = $str . sprintf('%04s', $noUrut);
        return $newKode;
    }

    public function form_tambah()
    {

        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('nama_jenis', 'nama_jenis', 'required', [
            'required' => 'Jenis barang tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'Satuan tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('jumlah_keluar', 'jumlah', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('tanggal_keluar', 'tanggal keluar', 'required', [
            'required' => 'Tanggal keluar tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Tambah Barang Keluar';
            $data['kode_bk'] = $this->kode_otomatis();
            $data['satuan'] = $this->M_satuan->tampil();
            $data['jenis'] = $this->M_jenis_barang->tampil();
            $data['brg'] = $this->M_stok_barang->tampil();
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Barang_keluar/form_tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->M_barang_keluar->tambahData();

            $this->session->set_flashdata('message', 'Ditambahkan');
            redirect('Barang_keluar');
        }
    }

    public function form_ubah($id_keluar)
    {

        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('nama_jenis', 'nama_jenis', 'required', [
            'required' => 'Jenis barang tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'Satuan tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('jumlah_keluar', 'No telpon', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('tanggal_keluar', 'tanggal keluar', 'required', [
            'required' => 'Tanggal keluar tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Ubah Barang Keluar';
            $data['satuan'] = $this->M_satuan->tampil();
            $data['jenis'] = $this->M_jenis_barang->tampil();
            $data['brg'] = $this->M_stok_barang->tampil();
            $data['id_keluar'] = $this->ambil_IdKeluar($id_keluar);
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Barang_keluar/form_ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->M_barang_keluar->ubahData();
            $this->session->set_flashdata('message', 'Diubah');
            redirect('Barang_keluar');
        }
    }


    public function ambil_IdKeluar($id_keluar)
    {
        return $this->db->get_where('tb_barang_keluar', ['id_keluar' => $id_keluar])->row_array();
    }

    function hapus_data()
    {
        $id_keluar = $this->input->post('id_keluar');

        $brg_keluar = $this->db->get_where('tb_barang_keluar', ['id_keluar' => $id_keluar])->row_array();
        $id_barang = $brg_keluar['id_barang'];
        $jumlah = $brg_keluar['jumlah'];
        $brg_gudang = $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();
        $stok_gudang = $brg_gudang['stok'];

        $total_stok = $stok_gudang + $jumlah;



        $data = [
            'stok' => $total_stok
        ];
        $this->db->where('id_barang', $id_barang);
        $this->db->update('tb_stok_barang', $data);

        $this->db->where('id_keluar', $id_keluar);
        $this->db->delete('tb_barang_keluar');
    }
}
