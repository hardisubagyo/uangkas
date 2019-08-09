<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operasional extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loggin();
        $this->load->model('Operasional_model');
    }
    public function kasmasuk()
    {
        $data['tittle'] = 'Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];
        $data['kmasuk'] = $this->db->get('operasional_masuk')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operasional/masuk', $data);
        $this->load->view('templates/footer');
    }
    public function tambahkasmasuk()
    {
        $data['tittle'] = 'Kas Operasional Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('operasional/masuk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Operasional_model->tambahKasMasuk();
        }
    }
    public function editkasmasuk($id)
    {
        $data['tittle'] = 'Kas Operasional Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kasmasuk'] = $this->Operasional_model->getKasMasukById($id);
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('operasional/editkasmasuk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Operasional_model->editKasMasuk();
        }
    }

    public function Rubah()
    {
        $data['tittle'] = 'Kas Operasional Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        $data = array(
            "keterangan" => $this->input->post('keterangan'),
            "jumlah" => str_replace(array(",", "."), "", $this->input->post('jumlah')),
            "tanggal" => $this->input->post('tanggal')
        );

        $where = array('id' => $this->input->post('id'));
        $update = $this->Operasional_model->update('operasional_masuk', $data, $where);

        if ($update == 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas masuk berhasil dirubah
              </div>'
            );
            redirect('operasional/kasmasuk');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas masuk berhasil dirubah
              </div>'
            );
            redirect('operasional/datakasmasuk');
        }
    }
    function hapus($id)
    {

        $this->Operasional_model->hapusKasMasuk($id);
    }

    // Kontrol Kas Keluar

    public function kaskeluar()
    {
        $data['tittle'] = 'Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];
        $data['kkeluar'] = $this->db->get('operasional_keluar')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operasional/keluar', $data);
        $this->load->view('templates/footer');
    }
    public function tambahkaskeluar()
    {
        $data['tittle'] = 'Kas Operasional Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('operasional/keluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Operasional_model->tambahKasKeluar();
        }
    }
    public function editkaskeluar($id)
    {
        $data['tittle'] = 'Kas Operasional Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kaskeluar'] = $this->Operasional_model->getKasKeluarById($id);
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('operasional/editkaskeluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Operasional_model->editKasKeluar();
        }
    }

    public function Rubahkaskeluar()
    {
        $data['tittle'] = 'Kas Operasional Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        $data = array(
            "keterangan" => $this->input->post('keterangan'),
            "jumlah" => str_replace(array(",", "."), "", $this->input->post('jumlah')),
            "tanggal" => $this->input->post('tanggal')
        );

        $where = array('id' => $this->input->post('id'));
        $update = $this->Operasional_model->updatekaskeluar('operasional_keluar', $data, $where);

        if ($update == 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas keluar berhasil dirubah
              </div>'
            );
            redirect('operasional/kaskeluar');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas krluar berhasil dirubah
              </div>'
            );
            redirect('operasional/kaskeluar');
        }
    }
    function hapuskaskeluar($id)
    {

        $this->Operasional_model->hapusKasKeluar($id);
    }
}
