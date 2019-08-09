<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas_model extends CI_Model
{
    private $_table = "kas_kantor";

    public $id;
    public $keterangan;
    public $tanggal;
    public $jenis;
    public $jumlah;

    public function rules()
    {
        return [
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required'
            ],

            [
                'field' => 'tanggal',
                'label' => 'Tanggal',
                'rules' => ''
            ],

            [
                'field' => 'jenis',
                'label' => 'Jenis',
                'rules' => 'required'
            ],
            [
                'field' => 'jumlah',
                'label' => 'Jumlah',
                'rules' => 'required'
            ]
        ];
    }
    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }
    public function save()
    {
        $post = $this->input->post();

        $this->keterangan = $post["keterangan"];
        $this->tanggal = $post["tanggal"];
        $this->jenis = $post["jenis"];
        $this->jumlah = $post["jumlah"];
        $this->db->insert($this->_table, $this);
    }
    public function update()
    {
        $post = $this->input->post();
        $this->id = $post["id"];
        $this->keterangan = $post["keterangan"];
        $this->tanggal = $post["tanggal"];
        $this->jenis = $post["jenis"];
        $this->jumlah = $post["jumlah"];
        $this->db->update($this->_table, $this, array('id' => $post['id']));
    }
    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }

    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
        redirect('kas_kantor/kas_keluar');
    }
}
