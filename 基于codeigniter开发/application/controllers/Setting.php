<?php

class Setting extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('theme');
		$this->load->model('youdaoyun');
		
	}
	
	public function index(){
		// echo md5("cwlmyjm");
		if ($this->youdaoyun->checkLogin()){
			$this->load->view('setting_index');
		}
		else{
			header('location:login');
		}
	}
	
	public function logining(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		//if ($this->youdaoyun->login($username,md5($password))){
		if ($this->youdaoyun->login($username,$password)){
			echo "login successful";
			header('location:index');
		}
		else{
			echo "failed";
		}
	}
	
	public function login(){
		$this->load->view('login.php');
	}
	
	public function request(){
		$url = "https://note.youdao.com/oauth/authorize2"; 
		$params = array(
			"client_id" => $this->youdaoyun->getKey(),
			"response_type" => "code",
			"redirect_uri" => "http://ysyy.zj.cn/setting/callback",
			"state" => "state",);
		$paramstring = http_build_query($params);
		$url = $url."?".$paramstring;
		header('location:'.$url);
	}
	
	public function callback(){
		$state 	= $_GET['state'];
		$code 	= $_GET['code'];
		$url = "https://note.youdao.com/oauth/access2"; 
		$params = array(
			"client_id" => $this->youdaoyun->getKey(),
			"client_secret" => $this->youdaoyun->getSecret(),
			"grant_type" => "authorization_code",
			"redirect_uri" => "http://ysyy.zj.cn/setting/callback2",
			"code" => $code,);
		$paramstring = http_build_query($params);
		$json = $this->youdaoyun->juhecurl($url,$paramstring);
		$json_data = json_decode($json,true);
		$this->youdaoyun->updateAccessToken($json_data['accessToken']);
		header('location:index');
	}
	
	public function callback2(){
		//暂时没什么用的页面
	}
	

	
	
}