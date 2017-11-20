<?php

class GlobalLib extends CI_Model{


    public function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            //rand($min,$max)生成介于min和max两个数之间的一个随机整数
            $str.=$strPol[rand(0,$max)];
        }
        
        return $str;
    }
    
    
    public function getKey(){
		
		$query = $this->db->query("select consumerKey from apiinfo");
		
		$row = $query->result_array();
		
		return $row[0]['consumerKey'];
	}
	
	public function getSecret(){
		
		$query = $this->db->query("select consumerSecret from apiinfo");
		
		$row = $query->result_array();
		
		return $row[0]['consumerSecret'];
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


	public function getData($url, $method = 'get', $post_data = null){

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


    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {  
	    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙  
	    $ckey_length = 4;  
	      
	    // 密匙  
	    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);  
	      
	    // 密匙a会参与加解密  
	    $keya = md5(substr($key, 0, 16));  
	    // 密匙b会用来做数据完整性验证  
	    $keyb = md5(substr($key, 16, 16));  
	    // 密匙c用于变化生成的密文  
	    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):
		substr(md5(microtime()), -$ckey_length)) : '';  
	    // 参与运算的密匙  
	    $cryptkey = $keya.md5($keya.$keyc);  
	    $key_length = strlen($cryptkey);  
	    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
		//解密时会通过这个密匙验证数据完整性  
	    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确  
	    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : 
		sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
	    $string_length = strlen($string);  
	    $result = '';  
	    $box = range(0, 255);  
	    $rndkey = array();  
	    // 产生密匙簿  
	    for($i = 0; $i <= 255; $i++) {  
	        $rndkey[$i] = ord($cryptkey[$i % $key_length]);  
	    }  
	    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度  
	    for($j = $i = 0; $i < 256; $i++) {  
	        $j = ($j + $box[$i] + $rndkey[$i]) % 256;  
	        $tmp = $box[$i];  
	        $box[$i] = $box[$j];  
	        $box[$j] = $tmp;  
	    }  
	    // 核心加解密部分  
	    for($a = $j = $i = 0; $i < $string_length; $i++) {  
	        $a = ($a + 1) % 256;  
	        $j = ($j + $box[$a]) % 256;  
	        $tmp = $box[$a];  
	        $box[$a] = $box[$j];  
	        $box[$j] = $tmp;  
	        // 从密匙簿得出密匙进行异或，再转成字符  
	        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
	    }  
	    if($operation == 'DECODE') { 
	        // 验证数据有效性，请看未加密明文的格式  
	        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && 
		substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
	            return substr($result, 26);  
	        } else {  
	            return '';  
	        }  
	    } else {  
	        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因  
	        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码  
	        return $keyc.str_replace('=', '', base64_encode($result));  
	    }  
	} 


	function encrypt($string,$operation,$key=''){
	    $key=md5($key);
	    $key_length=strlen($key);
	      $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
	    $string_length=strlen($string);
	    $rndkey=$box=array();
	    $result='';
	    for($i=0;$i<=255;$i++){
	        $rndkey[$i]=ord($key[$i%$key_length]);
	        $box[$i]=$i;
	    }
	    for($j=$i=0;$i<256;$i++){
	        $j=($j+$box[$i]+$rndkey[$i])%256;
	        $tmp=$box[$i];
	        $box[$i]=$box[$j];
	        $box[$j]=$tmp;
	    }
	    for($a=$j=$i=0;$i<$string_length;$i++){
	        $a=($a+1)%256;
	        $j=($j+$box[$a])%256;
	        $tmp=$box[$a];
	        $box[$a]=$box[$j];
	        $box[$j]=$tmp;
	        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
	    }
	    if($operation=='D'){
	        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
	            return substr($result,8);
	        }else{
	            return'';
	        }
	    }else{
	        return str_replace('=','',base64_encode($result));
	    }
	} 

}