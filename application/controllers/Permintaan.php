<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_permintaan');
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
    }

    public function index()
    {
        $data['permintaan'] = $this->M_permintaan->tampil();
        $data['title'] = 'Permintaan barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Permintaan/index', $data);
        $this->load->view('templates/footer');
    }

    public function Disetujui()
    {
        $id_permintaan = $this->input->post('id_permintaan');
        $data = [
            'status' => 'Sudah disetujui'
        ];
        $this->db->update('tb_permintaan', $data, ['id_permintaan' => $id_permintaan]);

        $response['status'] = 1;
        echo json_encode($response);
    }

    public function Ditolak()
    {
        $id_permintaan = $this->input->post('id_permintaan');
        $data = [
            'status' => 'Tidak disetujui'
        ];
        $this->db->update('tb_permintaan', $data, ['id_permintaan' => $id_permintaan]);

        $response['status'] = 1;
        echo json_encode($response);
    }

    public function hapus()
    {
        $id_permintaan = $this->input->post('id_permintaan');
        $this->db->delete('tb_permintaan', ['id_permintaan' => $id_permintaan]);
        $respon['status'] = 1;
        echo json_encode($respon);
    }

    public function cetak_pdf()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('./assets/ruang-admin/img/logo/Tj.png');
        $pdf->Cell(0, 5, 'Trengginas Jaya Mart', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(250, 9, 'Jl. Sumur Bandung No. 12, Bandung ,Telp: (022) 253205,Fax: (022) 2532053', 0, 1, 'C');
        $pdf->Cell(0, 9, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Data Permintaan Barang', 0, 1, 'C');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFillColor(210, 221, 242);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama barang', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Jumlah Pengadaan', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(80, 6, 'Pemasok', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Status', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_permintaan->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(40, 6, $data['nama_barang'], 1, 0, 'C');
            $pdf->Cell(40, 6, $data['jumlah_pengadaan'], 1, 0, 'C');
            $pdf->Cell(20, 6, $data['satuan'], 1, 0, 'C');
            $pdf->Cell(80, 6, $data['pemasok'], 1, 0);
            $pdf->Cell(30, 6, $data['status'], 1, 1, 'C');
        }
        $pdf->Output('I', 'Laporan Permintaan Barang.pdf');
    }
}
