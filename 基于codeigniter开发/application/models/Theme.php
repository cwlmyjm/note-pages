<?php 

class Theme extends CI_Model {
	
	public function __construct(){
		$this->load->database();
	}
	
	public function lookUp($username){
		
		$query = $this->db->query("select theme from np_userinfo where username = '$username'");
		
		$row = $query->result_array();
		
		if (count($row)==0){
			return $this->getTheme();
		}
		else{
			return $this->getTheme($row[0]['theme']);
		}
	}
	
	private function getTheme($themeName = "default"){
		if ( ! file_exists(APPPATH.'/views/themes/'.$themeName.'/config.json')){
			return $this->getTheme();
		}
		else{
			$fileName = APPPATH.'/views/themes/'.$themeName.'/config.json';
			$handle = fopen($fileName,"r");
			$contents = fread($handle,filesize($fileName));
			
			$configFile = json_decode($contents);
			
			$result['content'] = $configFile->content;
			$result['body'] = $configFile->body;
			
			return $result;
		}
	}

	
}