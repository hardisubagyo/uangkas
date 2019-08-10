<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laba extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loggin();
        $this->load->library('form_validation');
        $this->load->model('M_model');
    }
    public function index(){
        $data['tittle'] = 'Presensate Laba';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //echo 'Selamat datang ' . $data['user']['name'];
        $data['laba'] = $this->M_model->read('laba')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laba/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan(){
        $id_laba = base64_encode(date('YmdHis'));
        $count = count($this->input->post('nama_customer'));

        for($x=0; $x < $count; $x++){
            $list['id_laba'] = $id_laba;
            $list['customer'] = $this->input->post('nama_customer')[$x];
            $list['invoice'] = $this->input->post('no_invoice')[$x];
            $list['total_invoice'] = $this->input->post('total_invoice')[$x];
            $list['keterangan'] = $this->input->post('keterangan')[$x];
            $list['zai'] = $this->input->post('zai')[$x];
            $list['biaya_produksi'] = $this->input->post('biaya_produksi')[$x];
            $list['saldo_laba'] = $this->input->post('saldo_laba')[$x];
            $list['andi'] = $this->input->post('andi')[$x];
            $list['rasit'] = $this->input->post('rasit')[$x];
            $list['kantor'] = $this->input->post('kantor')[$x];
            
            $this->M_model->insert('list_laba',$list);
        }

        $data = array(
            'id_laba' => $id_laba,
            'total_invoice' => $this->input->post('total_invoice_all'),
            'total_zai' => $this->input->post('total_zai'),
            'total_saldo_laba' => $this->input->post('total_saldo_laba'),
            'total_andi' => $this->input->post('total_andi'),
            'total_rasit' => $this->input->post('total_rasit'),
            'total_kantor' => $this->input->post('total_kantor'),
            'status' => '0',
            'tgl' => date('Y-m-d')
        );

        $this->M_model->insert('laba',$data);

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Laba berhasil ditambah</div>');
        redirect(site_url('laba'));
    }

    public function tras($id){
        $get = $this->db->query("
                SELECT 
                    list_laba.customer,
                    list_laba.kantor,
                    list_laba.invoice,
                    laba.tgl
                FROM list_laba
                JOIN laba ON laba.id_laba = list_laba.id_laba
            ")->result();

        foreach($get as $item){
            $data['keterangan'] = $item->customer.' ('.$item->invoice.')';
            $data['tanggal'] = $item->tgl;
            $data['jumlah'] = $item->kantor;

            $this->M_model->insert('kantor_masuk',$data);
        }

        $update = array(
            "status" => '1'
        );

        $this->M_model->update('laba',$update, array('id_laba' => $id));

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Laba berhasil ditambah</div>');
        redirect(site_url('laba'));
    }

    public function pdf(){
        $laba = $this->M_model->read('laba')->result();

        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th>Tanggal Transaksi</th>
                    <th>Total Presentase ZAI</th>
                    <th>Total Presentase ANDI</th>
                    <th>Total Presentase RASIT</th>
                    <th>Total Presentase Kantor</th>
                </tr>
        ');

        foreach($laba as $item){
            $mpdf->WriteHTML('
                <tr>
                    <td>'.$item->tgl.'</td>
                    <td>'.number_format($item->total_zai,0,'.','.').'</td>
                    <td>'.number_format($item->total_andi,0,'.','.').'</td>
                    <td>'.number_format($item->total_rasit,0,'.','.').'</td>
                    <td>'.number_format($item->total_kantor,0,'.','.').'</td>
                </tr>
            ');            
        }

        $mpdf->WriteHTML('</table>');

        $mpdf->Output();
    }

    public function detailpdf($id){
        $listlaba = $this->M_model->read('list_laba', array('id_laba' => $id))->result();
        $laba = $this->M_model->read('laba', array('id_laba' => $id))->row();

        $mpdf = new \Mpdf\Mpdf(
            ['format' => 'A4-L']);
        $stylesheet = file_get_contents(base_url().'assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet,1);

        $mpdf->WriteHTML('
            <table id="customers">
                <tr>
                    <th>Customen</th>
                    <th>No Invoice</th>
                    <th>Total Invoice</th>
                    <th>Keterangan</th>
                    <th>Zai (2,5%)</th>
                    <th>Biaya Produksi</th>
                    <th>Saldo Laba</th>
                    <th>Andi (30%)</th>
                    <th>Rasit (30%)</th>
                    <th>Kantor (40%)</th>
                </tr>
        ');

        foreach($listlaba as $item){
            $mpdf->WriteHTML('
                <tr>
                    <td>'.$item->customer.'</td>
                    <td>'.$item->invoice.'</td>
                    <td>'.number_format($item->total_invoice,0,'.','.').'</td>
                    <td>'.$item->keterangan.'</td>
                    <td>'.number_format($item->zai,0,'.','.').'</td>
                    <td>'.number_format($item->biaya_produksi,0,'.','.').'</td>
                    <td>'.number_format($item->saldo_laba,0,'.','.').'</td>
                    <td>'.number_format($item->andi,0,'.','.').'</td>
                    <td>'.number_format($item->rasit,0,'.','.').'</td>
                    <td>'.number_format($item->kantor,0,'.','.').'</td>
                </tr>
            ');            
        }

        $mpdf->WriteHTML('
            <tr>
                <td colspan="2"><b>Total</b></td>
                <td><b>'.number_format($laba->total_invoice,0,'.','.').'</b></td>
                <td></td>
                <td><b>'.number_format($laba->total_zai,0,'.','.').'</b></td>
                <td></td>
                <td><b>'.number_format($laba->total_saldo_laba,0,'.','.').'</b></td>
                <td><b>'.number_format($laba->total_andi,0,'.','.').'</b></td>
                <td><b>'.number_format($laba->total_rasit,0,'.','.').'</b></td>
                <td><b>'.number_format($laba->total_kantor,0,'.','.').'</b></td>
            </tr>
        ');

        $mpdf->WriteHTML('</table>');

        $mpdf->Output();
    }

    public function excel(){
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "No",
            "Tanggal Transaksi", 
            "Total Presentase ZAI", 
            "Total Presentase ANDI",
            "Total Presentase RASIT",
            "Total Presentase Kantor"
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

        $laba = $this->M_model->read('laba')->result();

        $excel_row = 2;
        $no = 1;

        foreach($laba as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tgl);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->total_zai);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->total_andi);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->total_rasit);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->total_kantor);
            $excel_row++;
            $no++;
        }

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laba' . $filename . '.xlsx"');
        header('Cache-Cpontrol: max-age=0');
        $object_writer->save('php://output');
    }

    public function detailexcel($id){
        $listlaba = $this->M_model->read('list_laba', array('id_laba' => $id))->result();
        $laba = $this->M_model->read('laba', array('id_laba' => $id))->row();

        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array(
            "No",
            "Customen",
            "No Invoice",
            "Total Invoice",
            "Keterangan",
            "Zai (2,5%)",
            "Biaya Produksi",
            "Saldo Laba",
            "Andi (30%)",
            "Rasit (30%)",
            "Kantor (40%)"
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
        $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

        $object->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold( true );

        $excel_row = 2;
        $no = 1;

        foreach($listlaba as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->customer);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->invoice);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->total_invoice);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->keterangan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->zai);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->biaya_produksi);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->saldo_laba);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->andi);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->rasit);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->kantor);
            $excel_row++;
            $no++;
        }

        $total_row = count($listlaba) + 2;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $total_row, 'TOTAL');
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $total_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $total_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $total_row, $laba->total_invoice);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $total_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $total_row, $laba->total_zai);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $total_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $total_row, $laba->total_saldo_laba);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $total_row, $laba->total_andi);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $total_row, $laba->total_rasit);
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $total_row, $laba->total_kantor);

        $filename = date('Ymd His');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laba' . $filename . '.xlsx"');
        header('Cache-Cpontrol: max-age=0');
        $object_writer->save('php://output');
    }

    public function edit($id){

        $data['tittle'] = 'Presensate Laba';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['laba'] = $this->M_model->read('list_laba', array('id_laba' => $id))->result();
        $data['id'] = $id;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laba/edit', $data);
        $this->load->view('templates/footer');
    }

    public function rubah(){
        $id = $this->input->post('id_laba');
        $this->M_model->delete('list_laba', array('id_laba' => $id));

        $count = count($this->input->post('nama_customer'));

        for($x=0; $x < $count; $x++){
            $list['id_laba'] = $id;
            $list['customer'] = $this->input->post('nama_customer')[$x];
            $list['invoice'] = $this->input->post('no_invoice')[$x];
            $list['total_invoice'] = $this->input->post('total_invoice')[$x];
            $list['keterangan'] = $this->input->post('keterangan')[$x];
            $list['zai'] = $this->input->post('zai')[$x];
            $list['biaya_produksi'] = $this->input->post('biaya_produksi')[$x];
            $list['saldo_laba'] = $this->input->post('saldo_laba')[$x];
            $list['andi'] = $this->input->post('andi')[$x];
            $list['rasit'] = $this->input->post('rasit')[$x];
            $list['kantor'] = $this->input->post('kantor')[$x];
            
            $this->M_model->insert('list_laba',$list);
        }

        $data = array(
            'total_invoice' => $this->input->post('total_invoice_all'),
            'total_zai' => $this->input->post('total_zai'),
            'total_saldo_laba' => $this->input->post('total_saldo_laba'),
            'total_andi' => $this->input->post('total_andi'),
            'total_rasit' => $this->input->post('total_rasit'),
            'total_kantor' => $this->input->post('total_kantor'),
        );

        $this->M_model->update('laba',$data, array('id_laba' => $id));

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Laba berhasil diubah</div>');
        redirect(site_url('laba'));
    }

    public function hapus($id){
        $this->M_model->delete('list_laba', array('id_laba' => $id));
        $this->M_model->delete('laba', array('id_laba' => $id));

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Laba berhasil dihapus</div>');
        redirect(site_url('laba'));
    }
}
