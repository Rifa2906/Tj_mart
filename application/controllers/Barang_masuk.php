<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_masuk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_barang_masuk');
        $this->load->model('M_satuan');
        $this->load->model('M_pemasok');
        $this->load->model('M_jenis_barang');
        $this->load->model('M_stok_barang');
    }

    public function index()
    {

        $data['barang_masuk'] = $this->M_barang_masuk->tampil();
        $data['title'] = 'Barang Masuk';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Barang_masuk/index', $data);
        $this->load->view('templates/footer');
    }

    public function tampil_brg()
    {
        $id_brg = $this->input->post('id_brg');

        $barang =  $this->M_barang_masuk->tampil_idBrg($id_brg);
        $data = [
            'stok' => $barang['stok']
        ];

        echo json_encode($data);
    }


    function kode_otomatis()
    {
        $tabel = "tb_barang_masuk";
        $field = "kode_barang_masuk";

        $lastkode = $this->M_barang_masuk->get_max($tabel, $field);
        //mengambil 4 karakter dari belakang
        $noUrut = (int) substr($lastkode, -4, 4);
        $noUrut++;
        $str = "T-BM-";
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
        $this->form_validation->set_rules('jumlah', 'No telpon', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('pemasok', 'Alamat', 'required', [
            'required' => 'Pemasok tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('tanggal_masuk', 'tanggal masuk', 'required', [
            'required' => 'Tanggal masuk tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('tanggal_kadaluarsa', 'tanggal kadaluarsa', 'required', [
            'required' => 'tanggal kadaluarsa tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Tambah Barang Masuk';
            $data['kode_bm'] = $this->kode_otomatis();
            $data['satuan'] = $this->M_satuan->tampil();
            $data['pemasok'] = $this->M_pemasok->tampil();
            $data['jenis'] = $this->M_jenis_barang->tampil();
            $data['brg'] = $this->M_stok_barang->tampil();
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Barang_masuk/form_tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->M_barang_masuk->tambahData();

            $this->session->set_flashdata('message', 'Ditambahkan');
            redirect('Barang_masuk');
        }
    }


    public function form_ubah($id_masuk)
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
        $this->form_validation->set_rules('jumlah', 'No telpon', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('pemasok', 'Alamat', 'required', [
            'required' => 'Pemasok tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('tanggal_masuk', 'tanggal masuk', 'required', [
            'required' => 'Tanggal masuk tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('tanggal_kadaluarsa', 'tanggal kadaluarsa', 'required', [
            'required' => 'tanggal kadaluarsa tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Ubah Barang Masuk';
            $data['satuan'] = $this->M_satuan->tampil();
            $data['pemasok'] = $this->M_pemasok->tampil();
            $data['jenis'] = $this->M_jenis_barang->tampil();
            $data['brg'] = $this->M_stok_barang->tampil();
            $data['id_masuk'] = $this->ambil_IdMasuk($id_masuk);
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Barang_masuk/form_ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->M_barang_masuk->ubahData();
            $this->session->set_flashdata('message', 'Diubah');
            redirect('Barang_masuk');
        }
    }


    public function ambil_IdMasuk($id_masuk)
    {
        return $this->db->get_where('tb_barang_masuk', ['id_masuk' => $id_masuk])->row_array();
    }

    function hapus_data()
    {
        $id_masuk = $this->input->post('id_masuk');

        $brg_masuk = $this->db->get_where('tb_barang_masuk', ['id_masuk' => $id_masuk])->row_array();
        $id_barang = $brg_masuk['id_barang'];
        $jumlah = $brg_masuk['jumlah'];
        $brg_gudang = $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();
        $stok_gudang = $brg_gudang['stok'];

        $total_stok = $stok_gudang - $jumlah;



        $data = [
            'stok' => $total_stok
        ];
        $this->db->where('id_barang', $id_barang);
        $this->db->update('tb_stok_barang', $data);

        $this->db->where('id_masuk', $id_masuk);
        $this->db->delete('tb_barang_masuk');
    }
}
