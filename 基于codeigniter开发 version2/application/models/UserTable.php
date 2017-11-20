<?php

class UserTable extends CI_Model {
    
    public function __construct(){
		$this->load->database();
        $this->load->model("globalLib");
	}
    
    // public function getUsernameByID($id){
        
        // $query = $this->db->query("select * from php");
        
        // $row = $query->result_array();
        
        // return $row[0]['username'];
    // }
    
    public function login($username,$password){
       	
        $query = $this->db->query("select password from usertable where username = '$username'");
        
        $row = $query->result_array();
        
 		if (count($row) == 0){
			return false;
		}
		else{
			if ($row[0]['password']==$password){
                
				$this->input->set_cookie('username',$username,86400);
                $salt = $this->globalLib->getRandChar(6);

                $query = $this->db->query("update usertable set salt = '$salt' where username = '$username'");
                
				$safecode = md5($username.$salt);
				$this->input->set_cookie('safecode',$safecode,86400);
				return true;
			}
			else{
				return false;
			}
		}
    }


    public function signup($username,$password){

    	if($this->isUserExist($username)){
    		// 如果用户已经存在
    		return 1;
    	}
    	else{
	        $query = $this->db->query("insert into usertable (username,password) values ('$username','$password')");

  			if ($this->db->affected_rows() == 1){
  				return 0;
  			}
  			else {
  				return 2;
  			}
    	}



    }
    
    public function checkLogin(){
		
		$username = $this->input->cookie('username');
		$safecode = $this->input->cookie('safecode');
		
		$query = $this->db->query("select salt from usertable where username = '$username'");
		
		$row = $query->result_array();
		if (count($row) == 0){
			return false;
		}
		else{
			$safecode2 = md5($username.$row[0]['salt']);
			return ($safecode == $safecode2);
		}
	}
    
	public function isUserExist($username){
		
		$query = $this->db->query("select * from usertable where username = '$username'");

		$row = $query->result_array();

		return count($row) > 0;
	}
    
    public function getAccessToken($username){
    	
		$query = $this->db->query("select accessToken from usertable where username = '$username'");
		$row = $query->result_array();
		return $row[0]['accessToken'];
	}
    
    
    public function updateAccessToken($accessToken){
		
		$username = $this->input->cookie('username');
		$query = $this->db->query("update usertable set accesstoken = '$accessToken' where username = '$username'");
		$this->db->affected_rows();
	}
}