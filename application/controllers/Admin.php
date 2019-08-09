<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loggin();

        $this->load->library('form_validation');
        $this->load->model('Reportkantor_model');
        $this->load->model('Reportoperasional_model');
    }
    public function index()
    {
        $data['tittle'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];
        $datakas = array(
            "total_pengeluaran" => $this->Reportkantor_model->total_pengeluaran()->row(),
            "total_pemasukan" => $this->Reportkantor_model->total_pemasukan()->row(),
            "total_pengeluaran_op" => $this->Reportoperasional_model->total_pengeluaran()->row(),
            "total_pemasukan_op" => $this->Reportoperasional_model->total_pemasukan()->row()
        );
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $datakas);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['tittle'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'role' => $this->input->post('role'),

            ];
            $this->db->insert('user_role', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
           Role berhasil ditambah
          </div>'
            );
            redirect('admin/role');
        }
    }
    public function RoleAccess($role_id)
    {
        $data['tittle'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id

        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
            Akses Ditambah
            </div>'
            );
        } else {
            $this->db->delete('user_access_menu', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
            Akses Dihapus
            </div>'
            );
        }
    }

    // KAS

}
