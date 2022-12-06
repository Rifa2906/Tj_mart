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
        $data['mkd'] = $this->monitoring_kadaluarsa();
        $data['brg'] = $this->monitoring_barang_pengadaan();
        $this->load->view('templates/header', $data);
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



    public function monitoring_kadaluarsa()
    {
        $this->db->select('*');
        $this->db->from('tb_monitoring_kadaluarsa mkd');
        $this->db->join('tb_stok_barang sb', 'sb.id_barang = mkd.id_barang');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function monitoring_barang_pengadaan()
    {
        return $this->M_stok_barang->tampil();
    }

    public function barang_keluar()
    {
        $id_monitoring = $this->input->post('id_monitoring');
        $barang = $this->db->get_where('tb_monitoring_kadaluarsa', ['id_monitoring' => $id_monitoring])->row_array();
        $tanggal_kadaluarsa = $barang['tanggal_kadaluarsa'];
        $id_barang = $barang['id_barang'];
        $jumlah = $barang['jumlah'];
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];
        $data = [
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis
        ];

        $this->db->insert('tb_keluar', $data);


        $brg_g = $this->db->get_where('tb_stok_barang', ['id_barang' => $id_barang])->row_array();

        $stok = $brg_g['stok'];

        $total = $stok - $jumlah;

        $data_gudang = [
            'stok' => $total
        ];

        $this->db->update('tb_stok_barang', $data_gudang, ['id_barang' => $id_barang]);

        $this->db->where('id_monitoring', $id_monitoring);
        $this->db->delete('tb_monitoring_kadaluarsa');

        $this->db->where('jumlah', $jumlah);
        $this->db->delete('tb_barang_masuk');
        $respon['status'] = 1;

        echo json_encode($respon);
    }
}
