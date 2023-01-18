<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function index()
    {

        $data['data_pertahun'] = $this->tahun();
        $data['title'] = 'Data PerTahun';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function Data_perBulan()
    {

        $data['data_perbulan'] = $this->bulan();
        $data['title'] = 'Data PerBulan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Laporan/Bulan', $data);
        $this->load->view('templates/footer');
    }

    public function Detail_tahun($tahun)
    {
        $data = $this->detailTahun($tahun);
        $data['Detail_tahun'] = $data;
        $data['title'] = 'Data barang keluar Tahun ' . $tahun;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Laporan/Detail_tahun', $data);
        $this->load->view('templates/footer');
    }

    public function Detail_bulan($bulan)
    {
        $data = $this->detailBulan($bulan);
        $data['D_bulan'] = $data;
        $data['title'] = 'Data barang keluar Bulan ' . $bulan;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Laporan/Detail_bulan', $data);
        $this->load->view('templates/footer');
    }


    public function tahun()
    {
        $query =  $this->db->query("SELECT *,SUM(jumlah) AS jumlah FROM tb_laporan GROUP BY YEAR(tanggal_keluar) ORDER BY tanggal_keluar ASC")->result_array();
        return $query;
    }

    public function detailTahun($tahun)
    {
        $query =  $this->db->query("SELECT * FROM tb_laporan  WHERE YEAR(tanggal_keluar) = $tahun GROUP BY MONTH(tanggal_keluar) ORDER BY tanggal_keluar ASC")->result_array();
        return $query;
    }



    public function bulan()
    {
        $query =  $this->db->query("SELECT *,SUM(jumlah) AS jumlah FROM tb_laporan GROUP BY MONTH(tanggal_keluar) ORDER BY tanggal_keluar ASC")->result_array();
        return $query;
    }

    public function detailBulan($bulan)
    {
        // $query =  $this->db->query("SELECT * FROM tb_laporan  WHERE MONTH(tanggal_keluar) = $bulan ORDER BY tanggal_keluar ASC")->result_array();
        // return $query;

        $this->db->select('*');
        $this->db->from('tb_laporan L');
        $this->db->join('tb_barang b', 'b.kode_barang = L.kode_barang');
        $this->db->join('tb_satuan s', 's.id_satuan = L.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = L.id_jenis');
        $this->db->order_by('L.tanggal_keluar ASC');
        $this->db->where('MONTH(L.tanggal_keluar)', $bulan);
        $query = $this->db->get()->result_array();
        return $query;
    }
}
