<?php
namespace myextend;

class Edcrypt
{
	private $signStr = 'Yclyclyclyechunlin12340822151604cdltxdy';//秘钥

	//加密
	public function encrypt($data){
		$key = $this->signStr;
		$data = rand(100000,999999).$data.rand(1000,9999).date('His');
		$key = md5($key);
		$x   = 0;
		$len = strlen($data);
		$l   = strlen($key);
		$char= '';
		for ($i = 0; $i < $len; $i++){
			if ($x == $l){
				$x = 0;
			}
			$char .= $key[$x];
			$x++;
		}
		$str = '';
		for ($i = 0; $i < $len; $i++){
			$str .= chr(ord($data[$i]) + (ord($char[$i])) % 256);
		}
		$str = base64_encode($str);
		return str_replace('+','-',$str);//+替换掉
	}

	//解密
	public function decrypt($data){
		$key = $this->signStr;
		$key = md5($key);
		$x   = 0;
		$data= base64_decode(str_replace('-','+',$data));
		$len = strlen($data);
		$l = strlen($key);
		$char = '';
		for ($i = 0; $i < $len; $i++){
			if ($x == $l){
				$x = 0;
			}
			$char .= substr($key, $x, 1);
			$x++;
		}
		$str = '';
		for ($i = 0; $i < $len; $i++){
			if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))){
				$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
			}else{
				$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
			}
		}
		$str = substr(substr($str,6),0,-10);
		return $str;
	}

}