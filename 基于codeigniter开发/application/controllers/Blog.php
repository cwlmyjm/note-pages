<?php

class Blog extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('theme');
		$this->load->model('youdaoyun');
		
	}
	
	public function index($username="cwlmyjm",$title="content")
	{
		$temp = $this->theme->lookUp("cwlmyjm");
		$data['note']['title'] = "123";
		$data['note']['content'] = "456";
		//$this->load->view('themes/'.$temp['content'][0],$data);
		//$this->load->view('themes/'.$temp['body'][0],$data);
		$accessToken = $this->youdaoyun->getAccessToken($username);
		
		//header('Authorization:OAuth oauth_token="'.$accessToken.'"');
		
		$str1 = "https://note.youdao.com/yws/open/resource/download";
		
		$str2 = "https://ysyy.zj.cn/blog/translate";
		
		$result = $this->youdaoyun->getnote($username);
		
		$content = $result['content'];
		
		$ff = str_replace($str1,$str2,$content);
		
		echo $ff;
		
		// echo $this->youdaoyun->getKey();
		// echo $this->youdaoyun->getSecret();
	}
	
	public function translate($var1,$var2){
		
		$str1 = "https://note.youdao.com/yws/open/resource/download";
		
		$accessToken = $this->youdaoyun->getAccessToken("cwlmyjm");
		
		$url = $str1."/".$var1."/".$var2.'?oauth_token='.$accessToken;
		
		//header("Content-Type:application/octet-stream");
		header("Content-Type:image");
		
		echo $this->youdaoyun->getData($url);
		
		
	}
}

