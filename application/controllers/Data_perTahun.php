<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_perTahun extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data['tahun'] = $this->db->query('SELECT * FROM tb_barang_keluar GROUP BY YEAR(tanggal_keluar)')->result_array();

        $data['data_pertahun'] = $this->tahun();
        $data['title'] = 'Data PerTahun';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Data_per_tahun/brg_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function tahun()
    {
        $query =  $this->db->query("SELECT *,SUM(jumlah) AS jumlah FROM tb_barang_keluar GROUP BY MONTH(tanggal_keluar) ORDER BY tanggal_keluar ASC")->result_array();
        return $query;
    }
}
