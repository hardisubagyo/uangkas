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
        $data['tittle'] = 'Laporan Kantor';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/index', $data);
        $this->load->view('templates/footer');
    }

    public function CariHari()
    {
        $data['tittle'] = 'Laporan Kantor';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $tgl = $this->input->get('tanggal');

        $datalap = array(
            "data" => $this->Reportkantor_model->carihari($tgl)->result(),
            "data_pengeluaran" => $this->Reportkantor_model->read('kantor_keluar', array('tanggal' => $tgl))->result(),
            "total_pengeluaran" => $this->Reportkantor_model->total_pengeluaran()->row(),
            "total_pemasukan" => $this->Reportkantor_model->total_pemasukan()->row(),
            "total_pemasukan_hari" => $this->Reportkantor_model->total_pemasukan_hari($tgl)->row(),
            "total_pengeluaran_hari" => $this->Reportkantor_model->total_pengeluaran_hari($tgl)->row(),
            "tanggal" => $tgl
        );


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/hasilhari', $datalap);
        $this->load->view('templates/footer');
    }

    public function CariHariPdf(){

        $tgl = str_replace('/', '-', $this->input->get('tanggal'));

        $data = $this->Reportkantor_model->carihari($tgl)->result();
        $data_pengeluaran = $this->Reportkantor_model->read('kantor_keluar', array('tanggal' => $tgl))->result();
        $total_pengeluaran = $this->Reportkantor_model->total_pengeluaran()->row();
        $total_pemasukan = $this->Reportkantor_model->total_pemasukan()->row();
        $total_pemasukan_hari = $this->Reportkantor_model->total_pemasukan_hari($tgl)->row();
        $total_pengeluaran_hari = $this->Reportkantor_model->total_pengeluaran_hari($tgl)->row();
        $tanggal = $tgl;

        
        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;
        $sisa_dana_hari = $total_pemasukan_hari->Total - $total_pengeluaran_hari->Total;

        $mpdf->WriteHTML('
            <table id="customers">
                <thead>
                    <tr>
                        <th colspan="6">Laporan Kas Kantor Harian ('.$tanggal.')</th>
                    </tr>
                    <tr>
                        <th>Total Pemasukan Keseluruhan</th>
                        <th>Total Pengeluaran Keseluruhan</th>
                        <th>Total Kas Keseluruhan</th>
                        <th>Total Pemasukan '.$tanggal.'</th>
                        <th>Total Pengeluaran '.$tanggal.'</th>
                        <th>Total Sisa Kas '.$tanggal.'</th>
                    </tr>
                </thead>
                <tr>    
                    <td>'.number_format($total_pemasukan->Total, 0, ',', '.').'</td>
                    <td>'.number_format($total_pengeluaran->Total, 0, ',', '.').'</td>
                    <td>'.number_format($sisa_dana, 0, ',', '.').'</td>
                    <td>'.number_format($total_pemasukan_hari->Total, 0, ',', '.').'</td>
                    <td>'.number_format($total_pengeluaran_hari->Total, 0, ',', '.').'</td>
                    <td>'.number_format($sisa_dana_hari, 0, ',', '.').'</td>
                </tr>
            </table>
        ');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('
            <table id="customers">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4">Laporan Harian ('.$tanggal.')</th>
                    </tr>
                        <tr>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>');
        foreach ($data as $item) {
            $mpdf->WriteHTML('
                <tr>
                    <td>'.$item->keterangan.'</td>
                    <td>'.$item->tanggal.'</td>
                    <td>'.number_format($item->jumlah, 0, ',', '.').'</td>
                    <td>Kas Masuk</td>
                </tr>');
        }
        foreach ($data_pengeluaran as $ros) {
            $mpdf->WriteHTML('
                <tr>
                    <td>'.$ros->keterangan.'</td>
                    <td>'.$ros->tanggal.'</td>
                    <td>'.number_format($ros->jumlah, 0, ',', '.').'</td>
                    <td>Kas Keluar</td>
                </tr>');
        }
        $mpdf->WriteHTML('
                <tr>
                    <td colspan="3"><b>Total Saldo</b></td>
                    <td><b>'.number_format($sisa_dana_hari, 0, ',', '.').'</b></td>
                </tr>
            </tbody>
        </table>
        ');

        $mpdf->Output();
    }

    public function CariHariExcel(){
        $tgl = str_replace('/', '-', $this->input->get('tanggal'));

        $data = $this->Reportkantor_model->carihari($tgl)->result();
        $data_pengeluaran = $this->Reportkantor_model->read('kantor_keluar', array('tanggal' => $tgl))->result();
        $total_pengeluaran = $this->Reportkantor_model->total_pengeluaran()->row();
        $total_pemasukan = $this->Reportkantor_model->total_pemasukan()->row();
        $total_pemasukan_hari = $this->Reportkantor_model->total_pemasukan_hari($tgl)->row();
        $total_pengeluaran_hari = $this->Reportkantor_model->total_pengeluaran_hari($tgl)->row();
        $tanggal = $tgl;

        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;
        $sisa_dana_hari = $total_pemasukan_hari->Total - $total_pengeluaran_hari->Total;

        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "Total Pemasukan Keseluruhan",
            "Total Pengeluaran Keseluruhan",
            "Total Kas Keseluruhan",
            "Total Pemasukan ".$tanggal."",
            "Total Pengeluaran ".$tanggal."",
            "Total Sisa Kas ".$tanggal.""
        );

        $column = 0;

        foreach($table_columns as $field){
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }

        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $object->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold( true );

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $total_pemasukan->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, $total_pengeluaran->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $sisa_dana);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, 2, $total_pemasukan_hari->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, 2, $total_pengeluaran_hari->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, 2, $sisa_dana_hari);

        $table_columns_1 = array(
            "Keterangan",
            "Tanggal",
            "Nominal",
            "Status"
        );
        $column_1 = 0;
        foreach($table_columns_1 as $field){
           $object->getActiveSheet()->setCellValueByColumnAndRow($column_1, 4, $field);
           $column_1++;
        }
        $object->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold( true );

        $excel_row_masuk = 5;
        foreach($data as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_masuk, $row->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row_masuk, $row->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_masuk, $row->jumlah);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row_masuk, 'Kas Masuk');
            $excel_row_masuk++;
        }

        $excel_row_keluar = 5 + count($data);
        foreach($data_pengeluaran as $ros){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_keluar, $ros->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row_keluar, $ros->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_keluar, $ros->jumlah);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row_keluar, 'Kas Keluar');
            $excel_row_keluar++;
        }

        $excel_row_total = $excel_row_keluar + count($data_pengeluaran) + 1;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_total, "Total");
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_total, $sisa_dana_hari);

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laba' . $filename . '.xlsx"');
        header('Cache-Cpontrol: max-age=0');
        $object_writer->save('php://output');
    }

    public function CariPeriode()
    {

        $data['tittle'] = 'Laporan Kantor';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $periode = explode("-", $this->input->get('periode'));
        $awal = str_replace("/", "-", $periode[0]);
        $akhir = str_replace("/", "-", $periode[1]);

        $datapriode = array(
            "data_pemasukan" => $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result(),
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
        $this->load->view('report/hasilperiode', $datapriode);
        $this->load->view('templates/footer');
    }

    public function CariPeriodePdf()
    {
        $periode = explode("-", $this->input->get('periode'));
        $awal = str_replace("/", "-", $periode[0]);
        $akhir = str_replace("/", "-", $periode[1]);

        
        $data_pemasukan = $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result();
        $data_pengeluaran = $this->db->query("SELECT * FROM kantor_keluar WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->result();
        $total_pengeluaran = $this->Reportkantor_model->total_pengeluaran()->row();
        $total_pemasukan = $this->Reportkantor_model->total_pemasukan()->row();
        $total_pemasukan_periode = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->row();
        $total_pengeluaran_periode = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->row();
        $periode = $this->input->get('periode');

        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $sisa_dana_hari = $total_pemasukan_periode->Total - $total_pengeluaran_periode->Total;
        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th colspan="6">Laporan Kas Kantor Periode ('.$periode.')</th>
                </tr>
                <tr>
                    <th>Total Pemasukan Keseluruhan</th>
                    <th>Total Pengeluaran Keseluruhan</th>
                    <th>Total Kas Keseluruhan</th>
                    <th>Total Pemasukan '.$periode.'</th>
                    <th>Total Pengeluaran '.$periode.'</th>
                    <th>Total Sisa Kas '.$periode.'</th>
                </tr>
                <tr>
                    <td>'.number_format($total_pemasukan->Total, 0, ',', '.').'</td>
                    <td>'.number_format($total_pengeluaran->Total, 0, ',', '.').'</td>
                    <td>'.number_format($sisa_dana, 0, ',', '.').'</td>
                    <td>'.number_format($total_pemasukan_periode->Total, 0, ',', '.').'</td>
                    <td>'.number_format($total_pengeluaran_periode->Total, 0, ',', '.').'</td>
                    <td>'.number_format($sisa_dana_hari, 0, ',', '.').'</td>
                </tr>
            </table>
        ');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('
            <table id="customers">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4">Detail Kas Kantor Periode ('.$periode.')</th>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>');

        foreach ($data_pemasukan as $item) {
            $mpdf->WriteHTML('
                        <tr>
                            <td>'.$item->tanggal.'</td>
                            <td>'.$item->keterangan.'</td>
                            <td>'.number_format($item->jumlah, 0, ',', '.').'</td>
                            <td>Kas Masuk</td>
                        </tr>');
        }
        $no = 1;
        foreach ($data_pengeluaran as $ros) {
            $mpdf->WriteHTML('
                        <tr>
                            <td>'.$ros->tanggal.'</td>
                            <td>'.$ros->keterangan.'</td>
                            <td>'.number_format($ros->jumlah, 0, ',', '.').'</td>
                            <td>Kas Keluar</td>
                        </tr>');
        }
        $mpdf->WriteHTML('
                    <tr>
                        <td colspan="3"><b>Total Saldo</b></td>
                        <td colspan="2"><b>'.number_format($sisa_dana_hari, 0, ',', '.').'</b></td>
                    </tr>
                </tbody>
            </table>
        ');

        $mpdf->Output();
    }

    public function CariPeriodeExcel()
    {

        $periode = explode("-", $this->input->get('periode'));
        $awal = str_replace("/", "-", $periode[0]);
        $akhir = str_replace("/", "-", $periode[1]);

        
        $data_pemasukan = $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $awal . "' and '" . $akhir . "'")->result();
        $data_pengeluaran = $this->db->query("SELECT * FROM kantor_keluar WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->result();
        $total_pengeluaran = $this->Reportkantor_model->total_pengeluaran()->row();
        $total_pemasukan = $this->Reportkantor_model->total_pemasukan()->row();
        $total_pemasukan_periode = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->row();
        $total_pengeluaran_periode = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $awal . "' and '" . $akhir . "'")->row();
        $periode = $this->input->get('periode');

        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $sisa_dana_hari = $total_pemasukan_periode->Total - $total_pengeluaran_periode->Total;
        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;

        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "Total Pemasukan Keseluruhan",
            "Total Pengeluaran Keseluruhan",
            "Total Kas Keseluruhan",
            "Total Pemasukan ".$periode."",
            "Total Pengeluaran ".$periode."",
            "Total Sisa Kas ".$periode.""
        );

        $column = 0;

        foreach($table_columns as $field){
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }

        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $object->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold( true );

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $total_pemasukan->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, $total_pengeluaran->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $sisa_dana);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, 2, $total_pemasukan_periode->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, 2, $total_pengeluaran_periode->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, 2, $sisa_dana_hari);

        $table_columns_1 = array(
            "Keterangan",
            "Tanggal",
            "Nominal",
            "Status"
        );
        $column_1 = 0;
        foreach($table_columns_1 as $field){
           $object->getActiveSheet()->setCellValueByColumnAndRow($column_1, 4, $field);
           $column_1++;
        }
        $object->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold( true );

        $excel_row_masuk = 5;
        foreach($data_pemasukan as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_masuk, $row->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row_masuk, $row->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_masuk, $row->jumlah);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row_masuk, 'Kas Masuk');
            $excel_row_masuk++;
        }

        $excel_row_keluar = 5 + count($data_pemasukan);
        foreach($data_pengeluaran as $ros){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_keluar, $ros->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row_keluar, $ros->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_keluar, $ros->jumlah);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row_keluar, 'Kas Keluar');
            $excel_row_keluar++;
        }

        $excel_row_total = $excel_row_keluar + count($data_pengeluaran) + 1;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_total, "Total");
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_total, $sisa_dana_hari);

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laba' . $filename . '.xlsx"');
        header('Cache-Cpontrol: max-age=0');
        $object_writer->save('php://output');
    }

    public function CariBulan()
    {
        $data['tittle'] = 'Laporan Kantor';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

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

        $databulan = array(
            "data_pemasukan" => $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->result(),
            "data_pengeluaran" => $this->db->query("SELECT * FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->result(),
            "total_pengeluaran" => $this->Reportkantor_model->total_pengeluaran()->row(),
            "total_pemasukan" => $this->Reportkantor_model->total_pemasukan()->row(),
            "total_pemasukan_bulan" => $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row(),
            "total_pengeluaran_bulan" => $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row(),
            "bulan" => $bln,
            "tahun" => $tahun,
            "bln" => $bulan
        );
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/hasilbulan', $databulan);
        $this->load->view('templates/footer');
    }

    public function CariBulanPdf(){
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

        $data_pemasukan = $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->result();
        $data_pengeluaran = $this->db->query("SELECT * FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->result();
        $total_pengeluaran = $this->Reportkantor_model->total_pengeluaran()->row();
        $total_pemasukan = $this->Reportkantor_model->total_pemasukan()->row();
        $total_pemasukan_bulan = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row();
        $total_pengeluaran_bulan = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row();
        $bulan = $bln;
        $tahun = $tahun;
        $bln = $bulan;

        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $sisa_dana_hari = $total_pemasukan_bulan->Total - $total_pengeluaran_bulan->Total;
        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th colspan="6">Laporan Kas Kantor Bulan '.$bln . ' ' . $tahun.'</th>
                </tr>
                <tr>
                    <th>Total Pemasukan Keseluruhan</th>
                    <th>Total Pengeluaran Keseluruhan</th>
                    <th>Total Kas Keseluruhan</th>
                    <th>Total Pemasukan '.$bulan . ' ' . $tahun.'</th>
                    <th>Total Pengeluaran '.$bulan . ' ' . $tahun.'</th>
                    <th>Total Sisa Kas '.$bulan . ' ' . $tahun.'</th>
                </tr>
                <tr>
                    <td>'.number_format($total_pemasukan->Total, 0, ',', '.').'</td>
                    <td>'.number_format($total_pengeluaran->Total, 0, ',', '.').'</td>
                    <td>'.number_format($sisa_dana, 0, ',', '.').'</td>
                    <td>'.number_format($total_pemasukan_bulan->Total, 0, ',', '.').'</td>
                    <td>'.number_format($total_pengeluaran_bulan->Total, 0, ',', '.').'</td>
                    <td>'.number_format($sisa_dana_hari, 0, ',', '.').'</td>
                </tr>
            </table>
            <br>
        ');

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th colspan="4">Laporan Bulan '.$bln . ' ' . $tahun.'</th>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Status</th>
                </tr>
                <tbody>
        ');
        foreach ($data_pemasukan as $item) {
        $mpdf->WriteHTML('
                <tr>
                    <td>'.$item->keterangan.'</td>
                    <td>'.$item->tanggal.'</td>
                    <td>'.number_format($item->jumlah, 0, ',', '.').'</td>
                    <td>Kas Masuk</td>
                </tr>');
        }
        $no = 1;
        foreach ($data_pengeluaran as $ros) {
        $mpdf->WriteHTML('
                <tr>
                    <td>'.$ros->keterangan.'</td>
                    <td>'.$ros->tanggal.'</td>
                    <td>'.number_format($ros->jumlah, 0, ',', '.').'</td>
                    <td>Kas Keluar</td>
                </tr>');
        }
        $mpdf->WriteHTML('
                    <tr>
                        <td colspan="2"><b>Total Saldo</b></td>
                        <td colspan="2"><b>'.number_format($sisa_dana_hari, 0, ',', '.').'</b></td>
                    </tr>
                </tbody>
            </table>
        ');

        $mpdf->Output();
    }

    public function CariBulanExcel(){
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

        $data_pemasukan = $this->db->query("SELECT kantor_masuk.keterangan,kantor_masuk.tanggal,kantor_masuk.jumlah,kantor_masuk.id FROM kantor_masuk WHERE kantor_masuk.tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->result();
        $data_pengeluaran = $this->db->query("SELECT * FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->result();
        $total_pengeluaran = $this->Reportkantor_model->total_pengeluaran()->row();
        $total_pemasukan = $this->Reportkantor_model->total_pemasukan()->row();
        $total_pemasukan_bulan = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_masuk WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row();
        $total_pengeluaran_bulan = $this->db->query("SELECT SUM(jumlah) as Total FROM kantor_keluar WHERE tanggal between '" . $tahun . "-" . $bulan . "-01' and '" . $tahun . "-" . $bulan . "-31'")->row();
        $bulan = $bln;
        $tahun = $tahun;
        $bln = $bulan;

        $sisa_dana_hari = $total_pemasukan_bulan->Total - $total_pengeluaran_bulan->Total;
        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;

        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "Total Pemasukan Keseluruhan",
            "Total Pengeluaran Keseluruhan",
            "Total Kas Keseluruhan",
            "Total Pemasukan ".$bln." ".$tahun."",
            "Total Pengeluaran ".$bln." ".$tahun."",
            "Total Sisa Kas ".$bln." ".$tahun.""
        );

        $column = 0;

        foreach($table_columns as $field){
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }

        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $object->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold( true );

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $total_pemasukan->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, $total_pengeluaran->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $sisa_dana);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, 2, $total_pemasukan_bulan->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, 2, $total_pengeluaran_bulan->Total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, 2, $sisa_dana_hari);

        $table_columns_1 = array(
            "Keterangan",
            "Tanggal",
            "Nominal",
            "Status"
        );
        $column_1 = 0;
        foreach($table_columns_1 as $field){
           $object->getActiveSheet()->setCellValueByColumnAndRow($column_1, 4, $field);
           $column_1++;
        }
        $object->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold( true );

        $excel_row_masuk = 5;
        foreach($data_pemasukan as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_masuk, $row->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row_masuk, $row->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_masuk, $row->jumlah);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row_masuk, 'Kas Masuk');
            $excel_row_masuk++;
        }

        $excel_row_keluar = 5 + count($data_pemasukan);
        foreach($data_pengeluaran as $ros){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_keluar, $ros->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row_keluar, $ros->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_keluar, $ros->jumlah);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row_keluar, 'Kas Keluar');
            $excel_row_keluar++;
        }

        $excel_row_total = $excel_row_keluar + count($data_pengeluaran) + 1;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row_total, "Total");
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row_total, $sisa_dana_hari);

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laba' . $filename . '.xlsx"');
        header('Cache-Cpontrol: max-age=0');
        $object_writer->save('php://output');
    }
}
