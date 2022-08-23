<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pemasok extends CI_Model
{

    function tampil()
    {
        return $this->db->get('tb_pemasok')->result_array();
    }

    function get_max($tabel = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($tabel)->row_array()[$field];
    }

    function kode_otomatis()
    {
        $tabel = 'tb_pemasok';
        $field = 'kode_pemasok';
        $lastkode = $this->get_max($tabel, $field);

        //mengambil 4 karakter dari belakang
        $nourut = (int) substr($lastkode, -4, 4);
        $nourut++;

        $ket = 'PM';

        return $newKode = $ket . sprintf('%03s', $nourut);
    }

    function tambahdata()
    {
        $nama = $this->input->post('nama');
        $kode_pemasok = $this->input->post('kode_pemasok');
        $alamat = $this->input->post('alamat');
        $no_telpon = $this->input->post('no_telpon');

        $data = [
            'kode_pemasok' => $kode_pemasok,
            'nama_pemasok' => $nama,
            'no_telpon' => $no_telpon,
            'alamat' => $alamat
        ];
        $this->db->insert('tb_pemasok', $data);
    }

    function ambilId($id_pemasok)
    {
        return $this->db->get_where('tb_pemasok', ['id_pemasok' => $id_pemasok]);
    }

    function ubah_pemasok($id_pemasok)
    {

        $nama_pemasok = $this->input->post('nama_pemasok');
        $kode_pemasok = $this->input->post('kode_pemasok');
        $no_telpon = $this->input->post('no_telpon');
        $alamat = $this->input->post('alamat');


        $data = [
            'kode_pemasok' => $kode_pemasok,
            'nama_pemasok' => $nama_pemasok,
            'no_telpon' => $no_telpon,
            'alamat' => $alamat
        ];



        $this->db->where('id_pemasok', $id_pemasok);
        $this->db->update('tb_pemasok', $data);
    }
}
