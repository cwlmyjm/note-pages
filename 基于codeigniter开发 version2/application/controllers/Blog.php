<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('userTable');
        $this->load->model('globalLib');
        $this->load->model('globalVar');
        $this->load->model('youdaoyun');
		
	}

	public function index(){
		echo "Blog";
	}

	public function content($username = "cwlmyjm"){

		if($this->userTable->isUserExist($username)){
			
			$data['title'] = "目录";

			$notes = $this->youdaoyun->listnotes($username);
			
			$key = 'www.helloweba.com';

			// $num = count($notes); 
			// for($i=0;$i<$num;++$i){ 
				 
			// 	$notes[$i] = $this->globalLib->encrypt($notes[$i],'E',$key);
			// } 

			
			$data['notes'] = $notes;

			$data['username'] = $username;

			$this->load->view('template/header',$data);

			$this->load->view('template/content',$data);

        	$this->load->view('template/footer');



			//$this->index0();

			//$this->view("cwlmyjm","/SVR88396FEA3B054C169F4E70D43CEC8C4D/SVR4B7B6C59B4194D4CA5EB63D1746FB994");


		}
		else{
			echo "用户不存在！";	
		}

	}

	public function view($username,$path){
		
		//$key = 'www.helloweba.com';

		//$path = $this->globalLib->encrypt($path,'D',$key);

		//$path = str_replace("FLAG","/",$path);

		//$path = "/".$notebook."/".$note;

		$path = base64_decode($path);

		$result = $this->youdaoyun->getnote($username,$path);

		$data['title'] = $result['title'];

		$str1 = "https://note.youdao.com/yws/open/resource/download";
		
		$str2 = "http://ysyy.zj.cn/blog/translate";

		$content = $result['content'];

		$data['content'] = str_replace($str1,$str2,$content);

		$this->load->view('template/header',$data);

		$this->load->view('template/note',$data);

        $this->load->view('template/footer');


	}

	public function index0($username="cwlmyjm",$title="content")
	{

		$accessToken = $this->userTable->getAccessToken($username);
				
		$str1 = "https://note.youdao.com/yws/open/resource/download";
		
		$str2 = "http://ysyy.zj.cn/blog/translate";
		
		$result = $this->youdaoyun->getnote($username,"/SVR88396FEA3B054C169F4E70D43CEC8C4D/SVR4B7B6C59B4194D4CA5EB63D1746FB994");
		
		$content = $result['content'];
		
		$ff = str_replace($str1,$str2,$content);
		
		echo $ff;
		
	}
	
	public function translate($var1,$var2){
		
		$str1 = "https://note.youdao.com/yws/open/resource/download";
		
		$accessToken = $this->userTable->getAccessToken("cwlmyjm");
		
		$url = $str1."/".$var1."/".$var2.'?oauth_token='.$accessToken;
		
		//header("Content-Type:application/octet-stream");
		header("Content-Type:image");
		
		echo $this->globalLib->getData($url);

	}

	public function test($username = "cwlmyjm"){

		//$this->youdaoyun->listnotes($username);
		//$this->youdaoyun->notebookall($username);

		//$str = base64_encode("string");
		//echo $str;
		//$str0 = base64_decode($str);
		//echo $str0;


		echo md5(date("Ymd", time()));
	}

}