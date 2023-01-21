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
        $monitoring = $this->db->get_where('tb_monitoring_kadaluarsa', ['id_monitoring' => $id_monitoring])->row_array();
        $tanggal_kadaluarsa = $monitoring['tanggal_kadaluarsa'];
        $kode_barang = $monitoring['kode_barang'];

        $barang_masuk = $this->db->get_where('tb_barang_masuk', ['kode_barang' => $kode_barang])->row_array();

        $id_masuk = $barang_masuk['id_masuk'];

        $jumlah = $monitoring['jumlah'];
        $id_satuan = $monitoring['id_satuan'];
        $id_jenis = $monitoring['id_jenis'];
        $data = [
            'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            'kode_barang' => $kode_barang,
            'jumlah' => $jumlah,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis
        ];


        $this->db->insert('tb_keluar', $data);



        $this->db->where('id_masuk', $id_masuk);
        $this->db->delete('tb_barang_masuk');

        $this->db->where('id_monitoring', $id_monitoring);
        $this->db->delete('tb_monitoring_kadaluarsa');

        $barang_stok = $this->db->get_where('tb_stok_barang', ['kode_barang' => $kode_barang])->row_array();

        $jenis = $this->db->get_where('tb_jenis_barang', ['id_jenis' => $id_jenis])->row_array();

        $stok = $barang_stok['stok'];
        $min_stok = $jenis['minimal_stok'];

        $total = $stok - $jumlah;

        if ($total < $min_stok) {
            $tanggal_sekarang = strtotime('now');
            $tanggal = date('01 F Y', strtotime('+1 month', $tanggal_sekarang));
            $data = [
                'kode_barang' => $kode_barang,
                'id_satuan' => $id_satuan,
                'id_jenis' => $id_jenis,
                'jumlah_pengadaan' => $this->jumlah_pengadaan($kode_barang, $total),
                'bulan' => $tanggal,
                'pemasok' => $this->supplier($kode_barang)
            ];

            $this->db->insert('tb_pengadaan', $data);
            $status = "Harus melakukan pengadaan";
        } else {
            $status = "Stok aman";
        }

        $data_stok = [
            'stok' => $total,
            'status' => $status
        ];

        $this->db->update('tb_stok_barang', $data_stok, ['kode_barang' => $kode_barang]);

        $respon['status'] = 1;

        echo json_encode($respon);
    }

    function jumlah_pengadaan($kode_barang, $total_stok)
    {
        $this->db->select('*');
        $this->db->from('tb_stok_barang sb');
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->where('kode_barang', $kode_barang);
        $barang = $this->db->get()->row_array();

        $query = $this->db->query("SELECT *, SUM(jumlah) as jumlah_baru FROM tb_barang_keluar WHERE kode_barang = '{$kode_barang}' GROUP BY MONTH(tanggal_keluar) ORDER BY tanggal_keluar DESC LIMIT 3")->result_array();

        $total = 0;
        foreach ($query as $key => $value) {
            $total += $value['jumlah_baru'];
        }
        //Rumus Single Moving Average (periode 3 bulan)
        $nilai_peramalan = ($total / 3);
        $min_stok = $barang['minimal_stok'];
        $hasil_peramalan = ceil($nilai_peramalan + $min_stok) - $total_stok;

        return $hasil_peramalan;
    }

    public function supplier($kode_barang)
    {
        $barang = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang = '{$kode_barang}'")->row_array();
        $nama_barang = $barang['nama_barang'];
        $this->db->select_min('harga');
        $this->db->where('nama_barang', $nama_barang);
        $brg = $this->db->get('tb_barang')->row_array();
        $id_pemasok = $barang['id_pemasok'];

        $pemasok = $this->db->get_where('tb_pemasok', ['id_pemasok' => $id_pemasok])->row_array();
        $nama_pemasok = $pemasok['nama_pemasok'];
        return $nama_pemasok;
    }
}
