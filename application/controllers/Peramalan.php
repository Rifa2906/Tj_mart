<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peramalan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_peramalan');
        $this->load->model('M_stok_barang');
        $this->load->model('M_produk');
    }

    public function index()
    {
        $data['peramalan'] = $this->M_peramalan->tampil();
        $data['barang'] = $this->M_stok_barang->tampil();
        $data['title'] = 'Peramalan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Peramalan/index', $data);
        $this->load->view('templates/footer');
    }



    public function tambah_data()
    {

        $this->form_validation->set_rules('id_barang', 'Nama barang', 'required|is_unique[tb_peramalan.id_barang]', [
            'is_unique' => 'Barang sudah diramalkan'
        ]);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message');
            redirect('Peramalan');
        } else {
            $this->M_peramalan->tambah_data_peramalan();
            redirect('Peramalan');
        }
    }



    public function kirim()
    {
        $id_barang = $this->input->post('id_barang');
        $id_peramalan = $this->input->post('id_peramalan');

        $peramalan = $this->db->query("SELECT * FROM tb_peramalan WHERE id_peramalan = $id_peramalan")->row_array();

        $this->db->select('*');
        $this->db->from('tb_stok_barang sb',);
        $this->db->join('tb_satuan s', 's.id_satuan = sb.id_satuan');
        $this->db->join('tb_jenis_barang j', 'j.id_jenis = sb.id_jenis');
        $this->db->where('sb.id_barang', $id_barang);
        $barang = $this->db->get()->row_array();



        $id_barang = $barang['id_barang'];
        $id_satuan = $barang['id_satuan'];
        $id_jenis = $barang['id_jenis'];
        $data_pengadaan = [
            'id_barang' => $id_barang,
            'id_satuan' => $id_satuan,
            'id_jenis' => $id_jenis,
            'jumlah_pengadaan' => $peramalan['jumlah_pengadaan'],
            'bulan' => $peramalan['bulan'],
            'pemasok' => "Pilih Supplier",
            'status' => "Belum Diajukan"
        ];

        $this->db->insert('tb_pengadaan', $data_pengadaan);
        $this->db->delete('tb_peramalan', ['id_peramalan' => $id_peramalan]);


        $response['status'] = 1;



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
            'id_peramalan' => $this->input->post('id_peramalan'),
            'supplier' => $query
        ];

        echo json_encode($data);
    }

    public function pilih_suplier()
    {
        $id_peramalan = $this->input->post('id_peramalan');
        $id_pemasok = $this->input->post('id_pemasok');

        $pemasok = $this->db->query("SELECT * FROM tb_pemasok WHERE id_pemasok = $id_pemasok")->row_array();


        $data = [
            'pemasok' => $pemasok['nama_pemasok']
        ];

        $this->db->where('id_peramalan', $id_peramalan);
        $this->db->update('tb_peramalan', $data);

        $response['status'] = 1;
        echo json_encode($response);
    }

    public function hapus_data()
    {
        $id_peramalan = $this->input->post('id_peramalan');
        $this->db->query("DELETE FROM tb_peramalan WHERE id_peramalan = $id_peramalan");
        $response['status'] = 1;
        echo json_encode($response);
    }
}
