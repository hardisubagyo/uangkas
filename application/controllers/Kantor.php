<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kantor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loggin();
        $this->load->model('Kantor_model');
        $this->load->model('M_model');
    }
    public function kasmasuk()
    {
        $data['tittle'] = 'Kas Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];
        $data['kmasuk'] = $this->db->get('kantor_masuk')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kantor/masuk', $data);
        $this->load->view('templates/footer');
    }
    public function tambahkasmasuk()
    {
        $data['tittle'] = 'Kas Kantor Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/masuk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Kantor_model->tambahKasMasuk();
        }
    }
    public function editkasmasuk($id)
    {
        $data['tittle'] = 'Kas Kantor Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kasmasuk'] = $this->Kantor_model->getKasMasukById($id);
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/editkasmasuk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Kantor_model->editKasMasuk();
        }
    }

    public function Rubah()
    {
        $data['tittle'] = 'Kas Kantor Masuk';
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
        $update = $this->Kantor_model->update('kantor_masuk', $data, $where);

        if ($update == 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas masuk berhasil dirubah
              </div>'
            );
            redirect('kantor/kasmasuk');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas masuk berhasil dirubah
              </div>'
            );
            redirect('kantor/datakasmasuk');
        }
    }
    function hapus($id)
    {

        $this->Kantor_model->hapusKasMasuk($id);
    }

    // Kontrol Kas Keluar

    public function kaskeluar()
    {
        $data['tittle'] = 'Kas Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'Selamat datang ' . $data['user']['name'];
        $data['kkeluar'] = $this->db->get('kantor_keluar')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kantor/keluar', $data);
        $this->load->view('templates/footer');
    }
    public function tambahkaskeluar()
    {
        $data['tittle'] = 'Kas Kantor Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/keluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Kantor_model->tambahKasKeluar();
        }
    }
    public function editkaskeluar($id)
    {
        $data['tittle'] = 'Kas Kantor Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kaskeluar'] = $this->Kantor_model->getKasKeluarById($id);
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/editkaskeluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Kantor_model->editKasKeluar();
        }
    }

    public function Rubahkaskeluar()
    {
        $data['tittle'] = 'Kas Kantor Keluar';
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
        $update = $this->Kantor_model->updatekaskeluar('kantor_keluar', $data, $where);

        if ($update == 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas keluar berhasil dirubah
              </div>'
            );
            redirect('kantor/kaskeluar');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
               Kas krluar berhasil dirubah
              </div>'
            );
            redirect('kantor/kaskeluar');
        }
    }
    function hapuskaskeluar($id)
    {

        $this->Kantor_model->hapusKasKeluar($id);
    }

    public function PdfMasuk(){
        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $kasmasuk = $this->M_model->read('kantor_masuk')->result();

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th colspan="3">Kas Masuk</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
        ');

        foreach($kasmasuk as $item){
            $mpdf->WriteHTML('
                <tr>
                    <td>'.$item->tanggal.'</td>
                    <td>'.$item->keterangan.'</td>
                    <td>'.number_format($item->jumlah,0,'.','.').'</td>
                </tr>
            ');            
        }

        $mpdf->WriteHTML('</table>');

        $mpdf->Output();

    }

    public function ExcelMasuk(){
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "No",
            "Tanggal", 
            "Keterangan", 
            "Jumlah"
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

        $object->getActiveSheet()->getStyle("A1:D1")->getFont()->setBold( true );

        $kasmasuk = $this->M_model->read('kantor_masuk')->result();

        $excel_row = 2;
        $no = 1;

        foreach($kasmasuk as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->jumlah);
            $excel_row++;
            $no++;
        }

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="KasMasuk'.$filename.'.xls"');
        $object_writer->save('php://output');
    }

    public function PdfKeluar(){
        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $kaskeluar = $this->M_model->read('kantor_keluar')->result();

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th colspan="3">Kas Kaluar</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
        ');

        foreach($kaskeluar as $item){
            $mpdf->WriteHTML('
                <tr>
                    <td>'.$item->tanggal.'</td>
                    <td>'.$item->keterangan.'</td>
                    <td>'.number_format($item->jumlah,0,'.','.').'</td>
                </tr>
            ');            
        }

        $mpdf->WriteHTML('</table>');

        $mpdf->Output();
    }

    public function ExcelKeluar(){
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "No",
            "Tanggal", 
            "Keterangan", 
            "Jumlah"
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

        $object->getActiveSheet()->getStyle("A1:D1")->getFont()->setBold( true );

        $kaskeluar = $this->M_model->read('kantor_keluar')->result();

        $excel_row = 2;
        $no = 1;

        foreach($kaskeluar as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tanggal);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->jumlah);
            $excel_row++;
            $no++;
        }

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="KasKeluar'.$filename.'.xls"');
        $object_writer->save('php://output');
    }
}
