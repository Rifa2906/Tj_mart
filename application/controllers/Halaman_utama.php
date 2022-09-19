<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Halaman_utama extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pengguna');
        $this->load->model('M_pemasok');
        $this->load->model('M_stok_barang');
        $this->load->model('M_barang_masuk');
        $this->load->model('M_barang_keluar');
    }
    public function index()
    {
        $data['title'] = 'Halaman Utama';
        $data['brg'] = $this->tampil();
        // $data['segera_expired'] = $this->segera_kadaluarsa();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Halaman_utama/index', $data);
        $this->load->view('templates/footer');
    }

    public function jml_data()
    {
        $data = [
            'pengguna' => count($this->M_pengguna->tampil()),
            'pemasok' => count($this->M_pemasok->tampil()),
            'pemasok' => count($this->M_pemasok->tampil()),
            'stok' => $this->M_stok_barang->jumlah_stok(),
            'brg_masuk' => count($this->M_barang_masuk->tampil()),
            'brg_keluar' => count($this->M_barang_keluar->tampil())
        ];

        echo json_encode($data);
    }

    public function tampil()
    {
        $tanggal_sekarang = date("Y-m-d");
        $this->db->select('*');
        $this->db->from('tb_barang_masuk bm',);
        $this->db->join('tb_satuan s', 's.id_satuan = bm.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = bm.id_jenis');
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = bm.id_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }

    // public function segera_kadaluarsa()
    // {
    //     $query = $this->db->get('tb_barang_masuk')->result_array();
    //     $tanggal_kadaluarsa = $query['tanggal_kadaluarsa'];
    //     $tanggal_mundur =  date('Y-m-d', strtotime("-3 day", strtotime($tanggal_kadaluarsa)));
    //     return $tanggal_mundur;
    // }
}
