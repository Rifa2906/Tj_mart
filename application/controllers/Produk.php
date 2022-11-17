<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_pemasok');
        $this->load->model('M_produk');
        $this->load->model('M_satuan');
    }

    public function index()
    {
        $data['title'] = 'Produk';
        $data['pemasok'] = $this->M_pemasok->tampil();
        $data['produk'] = $this->M_produk->tampil();
        $data['satuan'] = $this->M_satuan->tampil();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Pemasok/produk', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_produk()
    {
        $this->form_validation->set_rules('pemasok', 'pemasok', 'required', [
            'required' => 'pemasok tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('produk', 'produk', 'required', [
            'required' => 'produk tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('harga', 'harga', 'required', [
            'required' => 'harga tidak boleh kosong'
        ]);

        $this->form_validation->set_rules('satuan', 'satuan', 'required', [
            'required' => 'satuan tidak boleh kosong'
        ]);


        if ($this->form_validation->run() == true) {
            $this->M_produk->tambahdata();
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['pemasok'] = strip_tags(form_error('pemasok'));
            $response['produk'] = strip_tags(form_error('produk'));
            $response['harga'] = strip_tags(form_error('harga'));
            $response['satuan'] = strip_tags(form_error('satuan'));
        }

        echo json_encode($response);
    }
}
