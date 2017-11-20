<?php 

class Youdaoyun extends CI_Model {
	
	public function __construct(){
		$this->load->database();
		$this->load->model('userTable');
		$this->load->model('globalLib');
	}

	public function getnote($username,$path){
		
		$url = "https://note.youdao.com/yws/open/note/get.json";
		
		$accessToken = $this->userTable->getAccessToken($username);
		
		//$path = "/SVR88396FEA3B054C169F4E70D43CEC8C4D/SVR4B7B6C59B4194D4CA5EB63D1746FB994";
		//$path = "/B0A22203E9BD46DEA466BE5D0160D731/D47035E20FE94BFBA0CEB9B3B6156D88";
		
		$params = array(
			"oauth_token" => $accessToken,
			"path" => $path,
		);

		$paramstring = http_build_query($params);
		
		$json = $this->globalLib->juhecurl($url,$paramstring,1);
		
		return json_decode($json,true);
		
	}

	public function notebookall($username){
		
		$url = "https://note.youdao.com/yws/open/notebook/all.json";
		
		$accessToken = $this->userTable->getAccessToken($username);
		
		$params = array(
			"oauth_token" => $accessToken,
		);
		
		$paramstring = http_build_query($params);
		
		$json = $this->globalLib->juhecurl($url,$paramstring,1);
		
		print_r($json);
	}

	public function listnotes($username){
		
		$url = "https://note.youdao.com/yws/open/notebook/list.json";
		
		$accessToken = $this->userTable->getAccessToken($username);
		
		$path = "/B0A22203E9BD46DEA466BE5D0160D731";
		
		$params = array(
			"oauth_token" => $accessToken,
			"notebook" => $path,
		);

		$paramstring = http_build_query($params);
		
		$json = $this->globalLib->juhecurl($url,$paramstring,1);
		
		return json_decode($json,true);

		//print_r($json);
	}

}