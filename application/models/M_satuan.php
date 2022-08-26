<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_satuan extends CI_Model
{

    function tampil()
    {
        return $this->db->get('tb_satuan')->result_array();
    }

    function tambahdata()
    {
        $satuan = $this->input->post('satuan');


        $data = [
            'satuan' => $satuan
        ];
        $this->db->insert('tb_satuan', $data);
    }

    function ambilId($id)
    {
        return $this->db->get_where('tb_satuan', ['id_satuan' => $id]);
    }

    function ubah($id_satuan)
    {

        $satuan = $this->input->post('satuan');


        $data = [
            'satuan' => $satuan
        ];
        $this->db->where('id_satuan', $id_satuan);
        $this->db->update('tb_satuan', $data);
    }
}
