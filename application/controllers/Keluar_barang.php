<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_Keluar_barang');
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI


    }

    public function index()
    {
        $data['kd'] = $this->M_Keluar_barang->tampil();
        $data['title'] = 'Barang yang segera kadaluarsa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Keluar barang/index', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_pdf()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('./assets/ruang-admin/img/logo/Tj.png');
        $pdf->Cell(0, 9, 'Trengginas Jaya Mart', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(200, 9, 'Jl. Sumur Bandung No. 12, Bandung ,Telp: (022) 253205,Fax: (022) 2532053', 0, 1, 'C');
        $pdf->Cell(0, 9, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Data Barang Kadaluarsa', 0, 1, 'C');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Tanggal Kadaluarsa', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jenis', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_Keluar_barang->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(50, 6, date('d-m-Y', strtotime($data['tanggal_kadaluarsa'])), 1, 0);
            $pdf->Cell(60, 6, $data['nama_barang'], 1, 0);
            $pdf->Cell(20, 6, $data['jumlah'], 1,);
            $pdf->Cell(20, 6, $data['satuan'], 1, 0);
            $pdf->Cell(20, 6, $data['nama_jenis'], 1, 1);
        }
        $pdf->Output('Laporan Barang Kadaluarsa.pdf', 'D');
    }

    public function hapus_semua_data()
    {
        return $this->db->query('DELETE FROM tb_keluar');
    }
}
