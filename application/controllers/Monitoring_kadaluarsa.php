<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_kadaluarsa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['mkd'] = $this->monitoring_kadaluarsa();
        $data['title'] = 'Monitoring Kadaluarsa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Monitoring_kadaluarsa/index', $data);
        $this->load->view('templates/footer');
    }

    public function monitoring_kadaluarsa()
    {
        $this->db->select('*');
        $this->db->from('tb_monitoring_kadaluarsa mkd');
        $this->db->join('tb_stok_barang sb', 'sb.kode_barang = mkd.kode_barang');
        $this->db->join('tb_barang b', 'b.kode_barang = mkd.kode_barang');
        $query = $this->db->get()->result_array();
        return $query;
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
