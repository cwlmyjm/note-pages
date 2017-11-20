<?php

class Test extends CI_Controller {
    
    public function __construct() {
        parent::__construct ();
        $this->load->model('apiInfo_model');
    }

	public function index()
	{
        $key = $this->apiInfo_model->getKey();
        //echo $key;
        echo "<br />";
        $secret = $this->apiInfo_model->getSecret();
        //echo $secret;
        echo "<br />";
	}
    
    public function login(){
        
        $p = array(
        "response_type" => "code",
        "redirect_uri" => "https://note-pages.ysyy.zj.cn/index.php",
        "state" => 1,
        "display" => "web",
        );
            
    
        
        $client_id = $this->apiInfo_model->getKey();
        $response_type = "code";
        $redirect_uri = "https://note-pages.ysyy.zj.cn/index.php";
        $state = 1;
        $display = "web";
        
        $url = "https://note.youdao.com/oauth/authorize2";
        
        $url2 = $url.
        "?client_id=".$client_id.
        "&response_type=".$response_type.
        "&redirect_uri=".$redirect_uri.
        "&state=".$state.
        "&display=".$display;
        
        echo $url2;
        
        $p2 = http_build_query($p);
        
        echo $url.'?'.$p2;
    }
    
    public function index2($var1,$var2){
        echo $var1;
        echo $var2;
    }
}
