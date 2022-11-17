<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasok extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pemasok');
    }

    public function index()
    {
        $data['kode_pemasok'] = $this->kode_otomatis();
        $data['pemasok'] = $this->M_pemasok->tampil();
        $data['title'] = 'Pemasok';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Pemasok/index', $data);
        $this->load->view('templates/footer');
    }

    function kode_otomatis()
    {
        $tabel = "tb_pemasok";
        $field = "kode_pemasok";

        $lastkode = $this->M_pemasok->get_max($tabel, $field);

        //mengambil 4 karakter dari belakang
        $noUrut = (int) substr($lastkode, -4, 4);
        $noUrut++;
        $str = "PM";
        $newKode = $str . sprintf('%04s', $noUrut);
        return $newKode;
    }

    public function tambah_pemasok()
    {
        $this->form_validation->set_rules('nama', 'nama', 'required', [
            'required' => 'nama tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kode_pemasok', 'Kode pemasok', 'required', [
            'required' => 'Kode pemasok tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('no_telpon', 'No telpon', 'required|max_length[12]', [
            'required' => 'No telpon tidak boleh kosong',
            'max_length' => 'No telpon Harus 12 karakter'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', [
            'required' => 'Alamat tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == true) {
            $this->M_pemasok->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama_pemasok'] = strip_tags(form_error('nama'));
            $response['kode_pemasok'] = strip_tags(form_error('kode_pemasok'));
            $response['alamat'] = strip_tags(form_error('alamat'));
            $response['no_telpon'] = strip_tags(form_error('no_telpon'));
        }

        echo json_encode($response);
    }

    public function ambil_IdPemasok()
    {
        $id_pemasok = $this->input->post('id_pemasok');
        $pemasok = $this->M_pemasok->ambilId($id_pemasok)->row_array();
        $data = [
            'id_pemasok' =>  $pemasok['id_pemasok'],
            'kode_pemasok' => $pemasok['kode_pemasok'],
            'nama_pemasok' => $pemasok['nama_pemasok'],
            'no_telpon' => $pemasok['no_telpon'],
            'alamat' => $pemasok['alamat']
        ];
        echo json_encode($data);
    }

    public function ubah()
    {
        $this->form_validation->set_rules('nama_pemasok', 'nama pemasok', 'required', [
            'required' => 'nama pemasok tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('kode_pemasok', 'Kode pemasok', 'required', [
            'required' => 'Kode pemasok tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('no_telpon', 'No telpon', 'required|max_length[12]', [
            'required' => 'No telpon tidak boleh kosong',
            'max_length' => 'No telpon Harus 12 karakter'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', [
            'required' => 'Alamat tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == true) {
            $id_pemasok = $this->input->post('id_pemasok');
            $this->M_pemasok->ubah_pemasok($id_pemasok);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['nama_pemasok'] = strip_tags(form_error('nama_pemasok'));
            $response['kode_pemasok'] = strip_tags(form_error('kode_pemasok'));
            $response['alamat'] = strip_tags(form_error('alamat'));
            $response['no_telpon'] = strip_tags(form_error('no_telpon'));
        }

        echo json_encode($response);
    }

    function hapus_data()
    {
        $id_pemasok = $this->input->post('id_pemasok');
        $this->db->where('id_pemasok', $id_pemasok);
        $this->db->delete('tb_pemasok');
    }

    public function tampil_produk()
    {
        $id_pemasok = $this->input->post('id_pemasok');
        $produk = $this->db->query("SELECT * FROM tb_produk WHERE id_pemasok = $id_pemasok")->result_array();


        echo json_encode($produk);
    }
}
