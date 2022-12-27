<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Retur_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_retur_barang');
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
    }

    public function index()
    {
        $data['retur'] = $this->M_retur_barang->tampil();
        $data['brg'] = $this->tampil_barang();
        $data['pm'] = $this->tampil_pemasok();
        $data['title'] = 'Retur Barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Retur_barang/index', $data);
        $this->load->view('templates/footer');
    }

    function tampil_barang()
    {
        $query = $this->db->get('tb_stok_barang')->result_array();
        return $query;
    }

    function tampil_pemasok()
    {
        $query = $this->db->get('tb_pemasok')->result_array();
        return $query;
    }

    public function tambah_retur()
    {
        $this->form_validation->set_rules('barang', 'barang', 'required', [
            'required' => 'barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('jumlah', 'jumlah', 'required', [
            'required' => 'jumlah tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('pemasok', 'pemasok', 'required', [
            'required' => 'pemasok tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == true) {
            $this->M_retur_barang->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['barang'] = strip_tags(form_error('barang'));
            $response['jumlah'] = strip_tags(form_error('jumlah'));
            $response['pemasok'] = strip_tags(form_error('pemasok'));
        }

        echo json_encode($response);
    }

    function hapus_data()
    {
        $id_retur = $this->input->post('id_retur');
        $this->db->where('id_retur', $id_retur);
        $this->db->delete('tb_retur_barang');
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
        $pdf->Cell(0, 10, 'Data Retur Barang', 0, 1, 'C');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFillColor(210, 221, 242);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Pemasok', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_retur_barang->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(50, 6, $data['nama_barang'], 1, 0);
            $pdf->Cell(60, 6, $data['nama_pemasok'], 1, 0);
            $pdf->Cell(20, 6, $data['jumlah'], 1,);
            $pdf->Cell(20, 6, $data['satuan'], 1, 0);
        }
        $pdf->Output('Laporan Retur Barang.pdf', 'D');
    }
}
