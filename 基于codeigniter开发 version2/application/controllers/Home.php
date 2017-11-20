<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('userTable');
        $this->load->model('globalLib');
        $this->load->model('globalVar');
		
	}

	public function index()
	{
        if($this->userTable->checkLogin()){
            $data['title'] = "Home";
            $this->load->view('template/header',$data);
            echo "<p>登陆状态验证成功！</p>";
            $this->load->view('template/footer');
        }
        else{
            header('location:home/login');
        }
	}
    
    public function login()
    {
    	$data['username'] = "cwlmyjm";
        $data['title'] = "登录表";
		$this->load->view('template/header',$data);
		$this->load->view('template/login');
        $this->load->view('template/footer');
    }
    
    public function logining(){
        $username = $_POST['username'];
		$password = $_POST['password'];
        

		//if ($this->youdaoyun->login($username,md5($password))){
		if ($this->userTable->login($username,$password)){
			echo "登陆成功";
		}
		else{
			echo "登陆失败";
		}
    }
    
    public function signup(){
        $data['title'] = "注册表";
		$this->load->view('template/header',$data);
		$this->load->view('template/signup');
        $this->load->view('template/footer');
    }


    public function signuping(){
        
        if(!isset($_POST['username']) || !isset($_POST['password'])){

        	echo "非法请求";
        	return;
        }

        $username = $_POST['username'];
		$password = $_POST['password'];

		if($username == "" || $password == ""){
			echo "账户或者密码为空！";
		}
		else{
			switch ($this->userTable->signup($username,$password)) {
				case 0:
					$this->alertAndJump("注册成功！","/home/login");
					break;
				case 1:
					$this->alertAndJump("用户已经存在！","/home/signup");
					break;
				case 2:
					$this->alertAndJump("数据库操作出现错误！","/home/signup");
					break;
				default:
					$this->alertAndJump("未知错误！","/home/signup");
					break;
			};	
		}

    }


    private function alertAndJump($message,$url){
    	$data['message'] = $message;
    	$data['url'] = $url;
    	$this->load->view('template/js_header');
    	$this->load->view('template/js_alert',$data);
    	$this->load->view('template/js_jump',$data);
    	$this->load->view('template/js_footer');
    }

    

    public function setting(){
        if($this->userTable->checkLogin()){
            $data['title'] = "Home";
            $this->load->view('template/header',$data);
            $this->load->view('template/binding');
            $this->load->view('template/footer');
        }
        else{
            header('location:home/login');
        }
    }
   	


    public function request(){
        $url = "https://note.youdao.com/oauth/authorize2"; 
        $domain = $this->globalVar->getDomain();
		$params = array(
			"client_id" => $this->globalLib->getKey(),
			"response_type" => "code",
			"redirect_uri" => $domain."home/callback",
			"state" => "state",);
		$paramstring = http_build_query($params);
		$url = $url."?".$paramstring;
		header('location:'.$url);
    }
    
    public function callback(){
		$state 	= $_GET['state'];
		$code 	= $_GET['code'];
		$url = "https://note.youdao.com/oauth/access2"; 
        $domain = $this->globalVar->getDomain();
		$params = array(
			"client_id" => $this->globalLib->getKey(),
			"client_secret" => $this->globalLib->getSecret(),
			"grant_type" => "authorization_code",
			"redirect_uri" => $domain."home/callback2",
			"code" => $code,);
		$paramstring = http_build_query($params);
		$json = $this->globalLib->juhecurl($url,$paramstring);
		$json_data = json_decode($json,true);
		$this->userTable->updateAccessToken($json_data['accessToken']);
		header('location:index');
	}
    
    public function callback2(){
		//暂时没什么用的页面
	}

}

//如果评论中包含非法的字符，那么拒绝接受该评论存入数据库中
//echo strspn($username,"<>;");
//return;
// <> 防止在评论框中输入html代码
// ;防止mysql注入
// 考虑将评论存在txt文件里面