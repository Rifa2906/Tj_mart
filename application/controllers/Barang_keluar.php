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
        $this->load->model('M_barang');
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
    }

    public function index()
    {

        $data['barang_keluar'] = $this->M_barang_keluar->tampil();
        $data['brg'] = $this->M_stok_barang->tampil();
        $data['title'] = 'Barang keluar';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Barang_keluar/index', $data);
        $this->load->view('templates/footer');
    }

    public function tampil_brg()
    {
        $kode_barang = $this->input->post('kode_barang');

        $barang =  $this->M_barang_keluar->tampil_idBrg($kode_barang);
        $data = [
            'stok' => $barang['stok']
        ];

        echo json_encode($data);
    }



    public function form_tambah()
    {


        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('jumlah_keluar', 'jumlah', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('tanggal_keluar', 'tanggal keluar', 'required', [
            'required' => 'Tanggal keluar tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Tambah Barang Keluar';
            $data['brg'] = $this->M_stok_barang->tampil();
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('Barang_keluar/form_tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_keluar = $this->input->post('jumlah_keluar');
            $jumlah_stok = $this->input->post('jml_stok');
            $url = base_url('Barang_keluar/form_tambah');
            if ($jumlah_keluar > $jumlah_stok) {
                echo "
                <script>
                alert('Stok di gudang tidak mencukupi');
                window.location.href='" . $url . "';
                </script>
                ";
            } else {
                $this->M_barang_keluar->tambahData();
                $this->session->set_flashdata('message', 'Ditambahkan');
                redirect('Barang_keluar');
            }
        }
    }



    public function form_ubah($id_keluar)
    {

        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required', [
            'required' => 'Nama barang tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('jumlah_keluar', 'No telpon', 'required', [
            'required' => 'Jumlah tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('tanggal_keluar', 'tanggal keluar', 'required', [
            'required' => 'Tanggal keluar tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Ubah Barang Keluar';
            $data['barang'] = $this->M_barang->tampil();
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
        $kode_barang = $brg_keluar['kode_barang'];
        $jumlah = $brg_keluar['jumlah'];
        $brg_gudang = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();
        $stok_gudang = $brg_gudang['stok'];

        $total_stok = $stok_gudang + $jumlah;
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

        $this->db->where('id_keluar', $id_keluar);
        $this->db->delete('tb_barang_keluar');
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
        $pdf->Cell(0, 10, 'Data Barang Keluar', 0, 1, 'C');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFillColor(210, 221, 242);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Tanggal keluar', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Jenis barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_barang_keluar->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(30, 6, date('d-m-Y', strtotime($data['tanggal_keluar'])), 1, 0, 'C');
            $pdf->Cell(40, 6, $data['nama_barang'], 1, 0, 'C');
            $pdf->Cell(20, 6, $data['jumlah'], 1, 0, 'C');
            $pdf->Cell(25, 6, $data['nama_jenis'], 1, 0, 'C');
            $pdf->Cell(20, 6, $data['satuan'], 1, 1, 'C');
        }
        $pdf->Output('I', 'Laporan Barang Keluar.pdf');
    }
}
