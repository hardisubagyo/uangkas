<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportkantor_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
    }

    function read($table, $where = null, $orderby = null, $limit = null, $page = null)
    {
        $this->db->select("*");
        $this->db->from($table);

        if ($where != null) {
            $this->db->where($where);
        }

        if ($orderby != null) {
            $this->db->order_by($orderby);
        }

        if ($limit != null && $page == null) {
            $this->db->limit($limit);
        }

        if ($limit != null && $page != null) {
            $this->db->limit($limit, $page);
        }

        return $this->db->get();
    }

    function insert($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }

    function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }

    function show_pemasukan()
    {
        $this->db->select("
				kantor_masuk.keterangan,
				kantor_masuk.tanggal,
				kantor_masuk.jumlah,
				kantor_masuk.id
			");
        $this->db->from("kantor_masuk");
        //$this->db->join("tm_anggota", "kantor_masuk.id_anggota=tm_anggota.id_anggota");
        $this->db->order_by("kantor_masuk.tanggal", "DESC");
        return $this->db->get();
    }

    function total_pemasukan()
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("kantor_masuk");
        return $this->db->get();
    }

    function total_pengeluaran()
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("kantor_keluar");
        return $this->db->get();
    }

    function carihari($tgl)
    {
        $this->db->select('
		kantor_masuk.keterangan,
		kantor_masuk.tanggal,
		kantor_masuk.jumlah,
		kantor_masuk.id
			');
        $this->db->from("kantor_masuk");
        //$this->db->join("tm_anggota", "kantor_masuk.id_anggota=tm_anggota.id_anggota");
        $this->db->where("kantor_masuk.tanggal", $tgl);
        $this->db->order_by("kantor_masuk.tanggal", "DESC");
        return $this->db->get();
    }

    function total_pemasukan_hari($tgl)
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("kantor_masuk");
        $this->db->where("kantor_masuk.tanggal", $tgl);
        return $this->db->get();
    }

    function total_pengeluaran_hari($tgl)
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("kantor_keluar");
        $this->db->where("kantor_keluar.tanggal", $tgl);
        return $this->db->get();
    }
}
