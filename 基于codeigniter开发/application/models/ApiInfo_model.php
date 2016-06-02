<?php
class ApiInfo_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function getKey(){
        
        $query = $this->db->query("SELECT * from apiInfo");
        
        $row = $query->result_array();
        
        return $row[0]['consumerKey'];
    }
    
    public function getSecret(){
        
        $query = $this->db->query("SELECT * from apiInfo");
        
        $row = $query->result_array();
        
        return $row[0]['consumerSecret'];
    }
    
}
