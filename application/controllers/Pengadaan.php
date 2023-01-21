<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pengadaan');
        $this->load->model('M_stok_barang');
        $this->load->model('M_barang');
    }

    public function index()
    {
        $data['pengadaan'] = $this->M_pengadaan->tampil();
        $data['barang'] = $this->M_stok_barang->tampil();
        $data['title'] = 'Pengadaan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Pengadaan/index', $data);
        $this->load->view('templates/footer');
    }

    public function kirim()
    {
        $id_pengadaan = $this->input->post('id_pengadaan');

        $pengadaan = $this->db->query("SELECT * FROM tb_pengadaan WHERE id_pengadaan = $id_pengadaan")->row_array();

        $id_satuan = $pengadaan['id_satuan'];
        $data_permintaan = [
            'id_pengadaan' => $id_pengadaan,
            'kode_barang' => $pengadaan['kode_barang'],
            'id_satuan' => $id_satuan,
            'jumlah_pengadaan' => $pengadaan['jumlah_pengadaan'],
            'bulan' => $pengadaan['bulan'],
            'pemasok' => $pengadaan['pemasok'],
            'status' => 'Meminta persetujuan'
        ];

        $this->db->insert('tb_permintaan', $data_permintaan);
        $this->db->where('id_pengadaan', $id_pengadaan);
        $this->db->delete('tb_pengadaan');
    }

    public function hapus_data()
    {
        $id_pengadaan = $this->input->post('id_pengadaan');
        $this->db->query("DELETE FROM tb_pengadaan WHERE id_pengadaan = $id_pengadaan");
        $response['status'] = 1;
        echo json_encode($response);
    }
}
