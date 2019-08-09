<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loggin();
    }
    public function index()
    {
        $data['tittle'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['tittle'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            //cek jika ada gambar yg di upload
            $uplod_image = $_FILES['image']['name'];

            if ($uplod_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2000';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('user');
                }
            }


            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
            Profil Berhasil di edit
            </div>'
            );
            redirect('user');
        }
    }
    public function changePass()
    {
        $data['tittle'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[3]|matches[repeat_password]', ['matches' => 'Tidak Sama Dengan Repeat Password']);
        $this->form_validation->set_rules('repeat_password', 'Repeat New Password', 'required|trim|min_length[3]|matches[new_password]', ['matches' => 'Tidak Sama Dengan New Password']);


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepass', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $repeat_password = $this->input->post('repeat_password');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">
                Password Lama Salah Broo!!
                </div>'
                );
                redirect('user/changepass');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">
                    Password anda tidak boleh sama dengan yang lama
                    </div>'
                    );
                    redirect('user/changepass');
                } else {

                    //password ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">
                                    Password berhasil diganti
                                    </div>'
                    );
                    redirect('user');
                }
            }
        }
    }

    public function data()
    {
        $data['tittle'] = 'Data Customer';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];

        $data['produk'] = $this->db->get('tb_barang')->result_array();

        $this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required|trim');
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('gambar', 'Gambar', 'required|trim');
        $this->form_validation->set_rules('harga_customer', 'Harga Customer', 'required|trim');
        $this->form_validation->set_rules('harga_produksi', 'Harga Produks', 'required|trim');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/data', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama_customer' => $this->input->post('nama_customer'),
                'nama_produk' => $this->input->post('nama_produk'),
                'gambar' => $this->input->post('gambar'),
                'keterangan' => $this->input->post('keterangan'),
                'harga_customer' => $this->input->post('harga_customer'),
                'harga_produksi' => $this->input->post('harga_produksi')

            ];
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
           Menu berhasil ditambah
          </div>'
            );
            redirect('master/data_produk');
        }
    }
}
