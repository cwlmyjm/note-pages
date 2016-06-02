<?php 

class Youdaoyun extends CI_Model {
	
	public function __construct(){
		$this->load->database();
	}
	
	public function getKey(){
		
		$query = $this->db->query("select consumerKey from np_apiinfo");
		
		$row = $query->result_array();
		
		return $row[0]['consumerKey'];
	}
	
	public function getSecret(){
		
		$query = $this->db->query("select consumerSecret from np_apiinfo");
		
		$row = $query->result_array();
		
		return $row[0]['consumerSecret'];
	}
	
	public function getAccessToken($username){
		$query = $this->db->query("select accessToken from np_userinfo where username = '$username'");
		$row = $query->result_array();
		return $row[0]['accessToken'];
	}
	
	public function login($username,$password){
		
		$query = $this->db->query("select password from np_userinfo where username = '$username'");
		
		$row = $query->result_array();
		
		if (count($row) == 0){
			return false;
		}
		else{
			if ($row[0]['password']==$password){
				$this->input->set_cookie('username',$username,86400);
				$safecode = md5($username.$password);
				$this->input->set_cookie('safecode',$safecode,86400);
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	public function checkLogin(){
		
		$username = $this->input->cookie('username');
		$safecode = $this->input->cookie('safecode');
		
		$query = $this->db->query("select password from np_userinfo where username = '$username'");
		
		$row = $query->result_array();
		if (count($row) == 0){
			return false;
		}
		else{
			$safecode2 = md5($username.$row[0]['password']);
			return ($safecode == $safecode2);
		}
	}
	
	public function updateAccessToken($accessToken){
		
		$username = $this->input->cookie('username');
		$query = $this->db->query("update np_userinfo set accesstoken = '$accessToken' where username = '$username'");
		$this->db->affected_rows();
	}
	
	public function notebookall($username){
		
		$url = "https://note.youdao.com/yws/open/notebook/all.json";
		
		$accessToken = $this->getAccessToken($username);
		
		$params = array(
			"oauth_token" => $accessToken,
		);
		
		$paramstring = http_build_query($params);
		
		$json = $this->juhecurl($url,$paramstring,1);
		
		print_r($json);
	}
	
	public function listnotes($username){
		
		$url = "https://note.youdao.com/yws/open/notebook/list.json";
		
		$accessToken = $this->getAccessToken($username);
		
		$path = "/SVR88396FEA3B054C169F4E70D43CEC8C4D";
		
		$params = array(
			"oauth_token" => $accessToken,
			"notebook" => $path,
		);

		$paramstring = http_build_query($params);
		
		$json = $this->juhecurl($url,$paramstring,1);
		
		print_r($json);
	}
	
	public function getnote($username){
		
		$url = "https://note.youdao.com/yws/open/note/get.json";
		
		$accessToken = $this->getAccessToken($username);
		
		$path = "/SVR88396FEA3B054C169F4E70D43CEC8C4D/SVR4B7B6C59B4194D4CA5EB63D1746FB994";
		
		$params = array(
			"oauth_token" => $accessToken,
			"path" => $path,
		);

		$paramstring = http_build_query($params);
		
		$json = $this->juhecurl($url,$paramstring,1);
		
		return json_decode($json,true);
		
		// print_r($json);
	}
	
	public function juhecurl($url,$params=false,$ispost=0){
		
		$httpInfo = array();
		$ch = curl_init();
	 
		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		if( $ispost )
		{
			curl_setopt( $ch , CURLOPT_POST , true );
			curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
			curl_setopt( $ch , CURLOPT_URL , $url );
		}
		else
		{
			
			if($params){
				curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
			}else{
				curl_setopt( $ch , CURLOPT_URL , $url);
			}
		}
		
		$response = curl_exec( $ch );
		
		if ($response === FALSE) {
			echo "cURL Error: " . curl_error($ch);
			return false;
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		return $response;
	}
	
	public function   getData($url, $method = 'get', $post_data = null){

//        print_r("   <a target='_blank' href='$url'>$url</a><br>");
        return file_get_contents($url);
        $url = trim($url);
        $timeout = 20;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13');
        curl_setopt($curl, CURLOPT_HEADER, true); //设定是否显示头信息
//        curl_setopt($curl, CURLOPT_NOBODY, false); //设定是否输出页面内容

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout); //在发起连接前等待的时间

//        Accept-Charset:GBK,utf-8;q=0.7,*;q=0.3
//Accept-Language:zh-CN,zh;q=0.8


        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: GBK,utf-8;q=0.7,*;q=0.3";
        $header[] = "Accept-Language: zh-CN,zh;q=0.8";
        $header[] = "Pragma: "; // browsers keep this blank.


        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($method === 'post') {
            if (!empty($post_data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            }
            curl_setopt($curl, CURLOPT_POST, 1);
            ob_start();
            curl_exec($curl);
            $content = ob_get_contents();
            ob_end_clean();
        } else {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //post 无法使用
            $content = curl_exec($curl);
        }
        curl_close($curl);
		
        return $content;
    }

}