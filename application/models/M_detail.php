<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_detail extends CI_Model
{

    function tampil($id_pengguna)
    {
        return $this->db->get_where('tb_pengguna', ['id_pengguna' => $id_pengguna])->row_array();
    }

    public function edit($id_p)
    {

        $kata_sandi = $this->input->post('passBaru');


        $data = [
            'kata_sandi' => $kata_sandi,
        ];
        $this->db->where('id_pengguna', $id_p);
        $this->db->update('tb_pengguna', $data);
    }
}
