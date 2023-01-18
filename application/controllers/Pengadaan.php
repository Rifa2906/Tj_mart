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



    public function tambah_data()
    {

        $this->form_validation->set_rules('id_barang', 'Nama barang', 'required|is_unique[tb_peramalan.id_barang]', [
            'is_unique' => 'Barang sudah diramal'
        ]);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message');
            redirect('Pengadaan');
        } else {
            $this->M_pengadaan->tambah_data_pengadaan();
            redirect('Pengadaan');
        }
    }

    public function peramalan()
    {
        $id_barang = $this->input->post('id_barang');
        $data_peramalan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang")->num_rows();

        $this->db->select('*');
        $this->db->from('tb_stok_barang sb',);
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->where('sb.id_barang', $id_barang);
        $barang = $this->db->get()->row_array();
        if ($data_peramalan < 3) {
            $produk = $barang['nama_barang'];
            $response['produk'] = $produk;
            $response['status'] = 0;
        } else {
            $query = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 3")->result_array();
            $total = 0;
            foreach ($query as $key => $value) {
                $total += $value['jumlah'];
            }



            //Rumus Single Moving Average (periode 3 bulan)
            $nilai_peramalan = ($total / 3);

            $min_stok = $this->input->post('min_stok');
            $sisa_stok = $barang['stok'];

            $hasil_peramalan = ceil($nilai_peramalan + $min_stok - $sisa_stok);

            $bulan = $this->db->query("SELECT * FROM tb_barang_keluar WHERE id_barang = $id_barang ORDER BY tanggal_keluar DESC LIMIT 1")->row_array();

            $bulan = date('F', strtotime("+1 month", strtotime($bulan['tanggal_keluar'])));
            $produk = $barang['nama_barang'];
            $satuan = $barang['satuan'];
            $jenis = $barang['nama_jenis'];

            $response = [
                'bulan_berikutnya' => $bulan,
                'peramalan' => $hasil_peramalan,
                'produk' => $produk,
                'satuan' => $satuan,
                'jenis' => $jenis,
                'status' => 1
            ];
        }
        echo json_encode($response);
    }

    public function kirim()
    {
        $id_barang = $this->input->post('id_barang');
        $id_pengadaan = $this->input->post('id_pengadaan');

        $pengadaan = $this->db->query("SELECT * FROM tb_pengadaan WHERE id_pengadaan = $id_pengadaan")->row_array();

        $this->db->select('*');
        $this->db->from('tb_stok_barang sb',);
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->where('sb.id_barang', $id_barang);
        $barang = $this->db->get()->row_array();

        if ($pengadaan['pemasok'] == 'Supplier belum dipilih') {
            $response['status'] = 0;
        } else {

            $id_barang = $barang['id_barang'];
            $id_satuan = $barang['id_satuan'];
            $data_permintaan = [
                'id_pengadaan' => $id_pengadaan,
                'id_barang' => $id_barang,
                'id_satuan' => $id_satuan,
                'jumlah_pengadaan' => $pengadaan['jumlah_pengadaan'],
                'bulan' => $pengadaan['bulan'],
                'pemasok' => $pengadaan['pemasok'],
                'status' => 'Meminta persetujuan'
            ];

            $this->db->insert('tb_permintaan', $data_permintaan);

            $data = [
                'status' => "Sudah Diajukan"
            ];

            $this->db->where('id_pengadaan', $id_pengadaan);
            $this->db->update('tb_pengadaan', $data);

            $response['status'] = 1;
        }


        echo json_encode($response);
    }

    public function tampil_supplier()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->db->get('tb_stok_barang', ['id_barang' => $id_barang])->row_array();
        $nama_produk = $barang['nama_barang'];

        $this->db->select('*');
        $this->db->from('tb_produk p',);
        $this->db->join('tb_pemasok pm', 'pm.id_pemasok = p.id_pemasok');
        $this->db->where('p.produk', $nama_produk);
        $query = $this->db->get()->result_array();

        $data = [
            'id_pengadaan' => $this->input->post('id_pengadaan'),
            'supplier' => $query
        ];

        echo json_encode($data);
    }

    public function pilih_suplier()
    {
        $id_pengadaan = $this->input->post('id_pengadaan');
        $id_pemasok = $this->input->post('id_pemasok');

        $pemasok = $this->db->query("SELECT * FROM tb_pemasok WHERE id_pemasok = $id_pemasok")->row_array();


        $data = [
            'pemasok' => $pemasok['nama_pemasok']
        ];

        $this->db->where('id_pengadaan', $id_pengadaan);
        $this->db->update('tb_pengadaan', $data);

        $response['status'] = 1;
        echo json_encode($response);
    }

    public function hapus_data()
    {
        $id_pengadaan = $this->input->post('id_pengadaan');
        $this->db->query("DELETE FROM tb_pengadaan WHERE id_pengadaan = $id_pengadaan");
        $response['status'] = 1;
        echo json_encode($response);
    }
}
