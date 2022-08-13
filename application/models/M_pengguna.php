<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengguna extends CI_Model
{

    function tampil()
    {
        return $this->db->get('tb_pengguna')->result_array();
    }

    function tambahdata()
    {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $pass = $this->input->post('Pass1');

        $data = [
            'nama' => $nama,
            'email' => $email,
            'kata_sandi' => $pass,
            'peran' => 'user'
        ];
        $this->db->insert('tb_pengguna', $data);
    }

    function ambilId($id)
    {
        return $this->db->get_where('tb_pengguna', ['id_pengguna' => $id]);
    }

    function ubah($id_pengguna, $peran)
    {

        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $pass = $this->input->post('Pass1');

        $Peran = $peran;
        if ($Peran == 'admin') {
            $data = [
                'nama' => $nama,
                'email' => $email,
                'kata_sandi' => $pass,
                'peran' => 'admin'
            ];
        } else {
            $data = [
                'nama' => $nama,
                'email' => $email,
                'kata_sandi' => $pass,
                'peran' => 'user'
            ];
        }


        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->update('tb_pengguna', $data);
    }
}
