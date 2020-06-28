<?php

class Welcome_model extends CI_Model {
//put your code here

    public function loginCheck($data)
    {
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['password']);
        $this->db->where('status', 1);
        $query_result=$this->db->get();
        $result=$query_result->row();

        return $result;

    }

}

?>