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
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
    }

    public function index()
    {

        $data['barang_masuk'] = $this->M_barang_masuk->tampil();
        $data['title'] = 'Barang Masuk';
        $this->load->view('templates/header', $data);
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




    public function form_tambah()
    {

        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
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
            $data['pemasok'] = $this->M_pemasok->tampil();
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

        $this->db->where('id_barang', $id_barang);
        $this->db->delete('tb_monitoring_kadaluarsa');
    }

    public function cetak_pdf()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('./assets/ruang-admin/img/logo/Tj.png');
        $pdf->Cell(0, 9, 'Trengginas Jaya Mart', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(250, 9, 'Jl. Sumur Bandung No. 12, Bandung ,Telp: (022) 253205,Fax: (022) 2532053', 0, 1, 'C');
        $pdf->Cell(0, 9, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Data Barang Masuk', 0, 1, 'C');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFillColor(210, 221, 242);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Tanggal Masuk', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jenis', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Pemasok', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Tanggal Kadaluarsa', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_barang_masuk->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(50, 6, date('d-m-Y', strtotime($data['tanggal_masuk'])), 1, 0);
            $pdf->Cell(40, 6, $data['nama_barang'], 1, 0);
            $pdf->Cell(20, 6, $data['jumlah'], 1,);
            $pdf->Cell(20, 6, $data['nama_jenis'], 1, 0);
            $pdf->Cell(20, 6, $data['satuan'], 1, 0);
            $pdf->Cell(50, 6, $data['nama_pemasok'], 1, 0);
            $pdf->Cell(50, 6, date('d-m-Y', strtotime($data['tanggal_kadaluarsa'])), 1, 1);
        }
        $pdf->Output('Laporan Barang Masuk.pdf', 'D');
    }
}
