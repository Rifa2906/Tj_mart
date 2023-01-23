<?php
defined('BASEPATH') or exit('No direct script access allowed');
require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $this->load->model('M_barang');
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


    public function form_tambah()
    {

        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required', [
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
            $data['pemasok'] = $this->M_pemasok->tampil();
            $data['barang'] = $this->M_stok_barang->tampil();
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

        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('jumlah', 'jumlah', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('pemasok', 'pemasok', 'required', [
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
            $data['barang'] = $this->M_barang->tampil();
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
        $kode_barang = $brg_masuk['kode_barang'];
        $jumlah = $brg_masuk['jumlah'];
        $brg_gudang = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $stok_gudang = $brg_gudang['stok'];

        $total_stok = $stok_gudang - $jumlah;

        $id_jenis = $brg_gudang['id_jenis'];
        $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();
        $min_stok = $jenis['minimal_stok'];
        if ($total_stok < $min_stok) {
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman";
        }


        $data = [
            'stok' => $total_stok,
            'status' => $status
        ];
        $this->db->where('kode_barang', $kode_barang);
        $this->db->update('tb_stok_barang', $data);

        $this->db->where('id_masuk', $id_masuk);
        $this->db->delete('tb_barang_masuk');

        // $this->db->where('id_barang', $id_barang);
        // $this->db->delete('tb_monitoring_kadaluarsa');
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
        $pdf->Cell(30, 6, 'Tanggal Masuk', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jenis', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(70, 6, 'Pemasok', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Tanggal Kadaluarsa', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_barang_masuk->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(30, 6, date('d-m-Y', strtotime($data['tanggal_masuk'])), 1, 0, 'C');
            $pdf->Cell(40, 6, $data['nama_barang'], 1, 0, 'C');
            $pdf->Cell(20, 6, $data['jumlah'], 1, 0, 'C');
            $pdf->Cell(20, 6, $data['nama_jenis'], 1, 0, 'C');
            $pdf->Cell(20, 6, $data['satuan'], 1, 0, 'C');
            $pdf->Cell(70, 6, $data['nama_pemasok'], 1, 0, 'L');
            $pdf->Cell(40, 6, date('d-m-Y', strtotime($data['tanggal_kadaluarsa'])), 1, 1, 'C');
        }
        $pdf->Output('Laporan Barang Masuk.pdf', 'D');
    }

    public function cetak_excel()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $coulumID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($coulumID)->setAutosize(true);
        }
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'Tanggal Masuk');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Jenis Barang');
        $sheet->setCellValue('F1', 'Satuan');
        $sheet->setCellValue('G1', 'Supplier');

        $users = $this->M_barang_masuk->tampil();
        $x = 2; //start from row 2
        $no = 1;
        foreach ($users as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['tanggal_masuk']);
            $sheet->setCellValue('C' . $x, $row['nama_barang']);
            $sheet->setCellValue('D' . $x, $row['jumlah']);
            $sheet->setCellValue('E' . $x, $row['nama_jenis']);
            $sheet->setCellValue('F' . $x, $row['satuan']);
            $sheet->setCellValue('F' . $x, $row['nama_pemasok']);
            $x++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan barang masuk.xlsx';
        //$writer->save($fileName);  //this is for save in folder


        /* for force download */
        header('Content-Type: appliction/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        ob_end_clean();
        $writer->save('php://output');
    }
}
