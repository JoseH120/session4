<?php 
    class Login_Database extends CI_Model{

        public function registration_insert($data){
            $this->db->insert('user_login', $data);
            if($this->db->affected_rows()  > 0){
                return true;
            }else{
                return false;
            }
        }

        public function login($data){
            $condition = "user_name ='".$data['username']."' AND user_password ='".$data['password']. "'";
            $this->db->select('*');
            $this->db->from('user_login');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            if($query->num_rows() ==1 ){
                return true;
            }else{
                return false;
            }
        }

        public function read_user_information($username){
            $condition = "user_name ="."'".$username."'";
            $this->db->select('*');
            $this->db->from('user_login');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            if($query->num_rows() == 1){
                return $query->result();
            }
            else{
                return false;
            }
        }

    }
?>