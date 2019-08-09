<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportkantor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loggin();
        $this->load->model('Reportkantor_model');
    }
    public function index()
    {
        $data['tittle'] = 'Laporan Kas Operasional';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/index', $data);
        $this->load->view('templates/footer');
    }

    public function CariHari()
    {
        $data['tittle'] = 'Laporan Kas Operasional';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tgl = $this->input->get('tanggal');

        $data = array(
            "data" => $this->Reportkantor_model->carihari($tgl)->result(),
            "data_pengeluaran" => $this->Reportkantor_model->read('kantor_masuk', array('tanggal' => $tgl))->result(),
            "total_pengeluaran" => $this->Reportkantor_model->total_pengeluaran()->row(),
            "total_pemasukan" => $this->Reportkantor_model->total_pemasukan()->row(),
            "total_pemasukan_hari" => $this->Reportkantor_model->total_pemasukan_hari($tgl)->row(),
            "total_pengeluaran_hari" => $this->Reportkantor_model->total_pengeluaran_hari($tgl)->row(),
            "tanggal" => $tgl
        );


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/hasilhari', $data);
        $this->load->view('templates/footer');
    }

    public function CariPeriode()
    {
        $periode = explode("-", $this->input->get('periode'));
        $awal = str_replace("/", "-", $periode[0]);
        $akhir = str_replace("/", "-", $periode[1]);

        $data = array(
            "data_pemasukan" => $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id_pemasukan FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result(),
            //"data_pengeluaran" => $this->db->query("SELECT * FROM kantor_keluar WHERE tgl between '" . $awal . "' and '" . $akhir . "'")->result(),
            "data_pemasukan" => $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id_pemasukan FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result(),
            //"data_pemasukan" => $this->db->query("SELECT tm_anggota.nama,kantor_masuk.tgl,kantor_masuk.jumlah,kantor_masuk.id_pemasukan FROM kantor_masuk JOIN tm_anggota ON kantor_masuk.id_anggota=tm_anggota.id_anggota WHERE kantor_masuk.tgl between '" . $awal . "' and '" . $akhir . "'")->result(),
            "data_pengeluaran" => $this->db->query("SELECT * FROM kantor_keluar WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->result(),
            "total_pengeluaran" => $this->Reportkantor_model->total_pengeluaran()->row(),
            "total_pemasukan" => $this->Reportkantor_model->total_pemasukan()->row(),
            "total_pemasukan_periode" => $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->row(),
            "total_pengeluaran_periode" => $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->row(),
            "periode" => $this->input->get('periode')
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/hasilperiode', $data);
        $this->load->view('templates/footer');
    }

    public function CariBulan()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        if ($bulan == '01') {
            $bln = "Januari";
        }
        if ($bulan == '02') {
            $bln = "Februari";
        }
        if ($bulan == '03') {
            $bln = "Maret";
        }
        if ($bulan == '04') {
            $bln = "April";
        }
        if ($bulan == '05') {
            $bln = "Mei";
        }
        if ($bulan == '06') {
            $bln = "Juni";
        }
        if ($bulan == '07') {
            $bln = "Juli";
        }
        if ($bulan == '08') {
            $bln = "Agustus";
        }
        if ($bulan == '09') {
            $bln = "September";
        }
        if ($bulan == '10') {
            $bln = "Oktober";
        }
        if ($bulan == '11') {
            $bln = "November";
        }
        if ($bulan == '12') {
            $bln = "Desember";
        }

        $data = array(
            "data_pemasukan" => $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id_pemasukan FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result(),

            "data_pemasukan" => $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id_pemasukan FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result(),
            "total_pengeluaran" => $this->M_model->total_pengeluaran()->row(),
            "total_pemasukan" => $this->M_model->total_pemasukan()->row(),
            "total_pemasukan_bulan" => $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row(),
            "total_pengeluaran_bulan" => $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row(),
            "bulan" => $bln,
            "tahun" => $tahun,
            "bln" => $bulan
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/hasilbulan', $data);
        $this->load->view('templates/footer');
    }
}
