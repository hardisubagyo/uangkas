<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportoperasional_model extends CI_Model
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
				operasional_masuk.keterangan,
				operasional_masuk.tanggal,
				operasional_masuk.jumlah,
				operasional_masuk.id
			");
        $this->db->from("operasional_masuk");
        //$this->db->join("tm_anggota", "operasional_masuk.id_anggota=tm_anggota.id_anggota");
        $this->db->order_by("operasional_masuk.tanggal", "DESC");
        return $this->db->get();
    }

    function total_pemasukan()
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("operasional_masuk");
        return $this->db->get();
    }

    function total_pengeluaran()
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("operasional_keluar");
        return $this->db->get();
    }

    function carihari($tgl)
    {
        $this->db->select('
		operasional_masuk.keterangan,
		operasional_masuk.tanggal,
		operasional_masuk.jumlah,
		operasional_masuk.id
			');
        $this->db->from("operasional_masuk");
        //$this->db->join("tm_anggota", "operasional_masuk.id_anggota=tm_anggota.id_anggota");
        $this->db->where("operasional_masuk.tanggal", $tgl);
        $this->db->order_by("operasional_masuk.tanggal", "DESC");
        return $this->db->get();
    }

    function total_pemasukan_hari($tgl)
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("operasional_masuk");
        $this->db->where("operasional_masuk.tanggal", $tgl);
        return $this->db->get();
    }

    function total_pengeluaran_hari($tgl)
    {
        $this->db->select("SUM(jumlah) as Total");
        $this->db->from("operasional_keluar");
        $this->db->where("operasional_keluar.tanggal", $tgl);
        return $this->db->get();
    }
}
