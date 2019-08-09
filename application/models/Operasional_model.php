<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operasional_model extends CI_Model
{
    public function getAllKasMAsuk()
    {
        return $this->db->get('operasional_masuk')->result_array();
    }
    public function getKasMasukById($id)
    {
        return $this->db->get_where('operasional_masuk', ['id' => $id])->row_array();
    }
    public function getAllKasKeluar()
    {
        return $this->db->get('operasional_keluar')->result_array();
    }
    public function getKasKeluarById($id)
    {
        return $this->db->get_where('operasional_keluar', ['id' => $id])->row_array();
    }
    public function tambahKasMasuk()
    {
        $data = [
            'keterangan' => $this->input->post('keterangan', true),
            'jumlah' => $this->input->post('jumlah', true),
            'tanggal' => $this->input->post('tanggal', true)
        ];
        $this->db->insert('operasional_masuk', $data);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
           Kas masuk berhasil ditambah
          </div>'
        );
        redirect('operasional/kasmasuk');
    }

    public function editKasMasuk($id)
    {
        $data = array(
            "keterangan" => $this->input->post('keterangan'),
            "jumlah" => str_replace(array(",", "."), "", $this->input->post('jumlah')),
            "tanggal" => $this->input->post('tanggal')
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('operasional_masuk', $data);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
           Kas masuk berhasil dirubah
          </div>'
        );
        redirect('operasional/kasmasuk');
    }

    function update($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }

    public function hapusKasMasuk($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('operasional_masuk');
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger" role="alert">
       Kas berhasil dihapus
      </div>'
        );
        redirect('operasional/kasmasuk');
    }

    // Kas Keluar 

    public function tambahKasKeluar()
    {
        $data = [
            'keterangan' => $this->input->post('keterangan', true),
            'jumlah' => $this->input->post('jumlah', true),
            'tanggal' => $this->input->post('tanggal', true)
        ];
        $this->db->insert('operasional_keluar', $data);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
           Kas Keluar berhasil ditambah
          </div>'
        );
        redirect('operasional/kaskeluar');
    }

    function updatekaskeluar($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
           Kas Keluar berhasil dirubah
          </div>'
        );
        redirect('operasional/kaskeluar');
    }

    public function hapusKasKeluar($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('operasional_keluar');
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger" role="alert">
       Kas Keluar berhasil dihapus
      </div>'
        );
        redirect('operasional/kaskeluar');
    }
}
