<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function getSubmenu()
    {
        $query = "SELECT `user_sub_menu`.*,`user_menu`.`menu`
                    FROM `user_sub_menu`JOIN`user_menu` 
                    ON `user_sub_menu`.`menu_id`=`user_menu`.`id`
                ";
        return $this->db->query($query)->result_array();
    }

    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
        redirect('menu');
    }
}
