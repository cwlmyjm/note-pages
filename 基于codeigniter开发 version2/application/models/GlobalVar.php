<?php

class GlobalVar extends CI_Model{

    public function getDomain(){

        $str = "http://ysyy.zj.cn/";
        
        return $str;
    }
    
    
    public function getNotebook(){

    	$str = "有道云博客";

    	return $str;
    }


    public function getTodayKey(){

    	// 每天生成一个密钥，用于加密和解密做key使用
		return md5(date("Ymd", time()));
    }

}