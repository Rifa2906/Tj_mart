<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lupa_kataSandi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
            'required' => 'Email tidak boleh kosong'

        ]);

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Masukan Email';
            $this->load->view('templates/header_login', $data);
            $this->load->view('Lupa_kataSandi/index');
            $this->load->view('templates/footer_login');
        } else {
            $email = $this->input->post('email');
            $this->sendmail($email);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Silahkan cek email anda
           </div>');
            redirect('Lupa_kataSandi');
        }
    }

    public function Ubah_kata_sandi()
    {
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required', [
            'required' => 'Password tidak boleh kosong'

        ]);

        $this->form_validation->set_rules('password_conf', 'Konfirmasi Password', 'required|matches[password_baru]', [
            'required' => 'Password tidak boleh kosong',
            'matches' => 'Password tidak sama'

        ]);

        $data['email'] = $this->input->get('email');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_login');
            $this->load->view('Lupa_kataSandi/Ubah_kata_sandi', $data);
            $this->load->view('templates/footer_login');
        } else {
            $this->ganti_kataSandi();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
           Kata sandi berhasil diubah
           </div>');
            redirect('Autentikasi');
        }
    }

    public function sendmail($email)
    {
        $type = 'lupakatasandi';
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.trengginasjayamart.com',
            'smtp_user' => 'tjmart@trengginasjayamart.com',
            'smtp_pass' => 'm4ul4n429',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);

        $this->email->from('tjmart@trengginasjayamart.com', 'TJ MART');
        $this->email->to($email);

        if ($type == 'lupakatasandi') {
            $this->email->subject('Reset Katasandi');
            $this->email->message('Klik link ini untuk mengubah katasandi anda : <a href="' . base_url() . 'Lupa_kataSandi/Ubah_kata_sandi?email=' . $email . '" >Reset Katasandi</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            $this->email->print_debugger();
            die;
        }
    }
    public function ganti_kataSandi()
    {
        $email = $this->input->post('email');
        $kataSandi_b = $this->input->post('password_baru');

        $cek = $this->db->get_where('tb_pengguna', ['email' => $email])->row_array();

        if ($cek) {
            $data = [
                'kata_sandi' => $kataSandi_b,
            ];
            $this->db->where('email', $email);
            $this->db->update('tb_pengguna', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email tidak terdaftar
           </div>');
            redirect('Ubah_kata_sandi');
        }
    }
}
