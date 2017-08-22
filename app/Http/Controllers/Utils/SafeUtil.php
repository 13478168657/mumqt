<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Utils;

use Illuminate\Routing\Controller;
/**
 * Description of SafeUtil
 *
 * @author yuanl
 */

class SafeUtil extends Controller {
	private $key;
	
	function __construct(){
		$this->key = config('keyConfig.SafeUtilKey');
	}
    
    function test(){
        $key = '12345678';
        $s = SafeUtil::encrypt('abc',$key);
        var_dump($s);
        var_dump(SafeUtil::decrypt($s,$key));
    }

    function encrypt($data) {
        $prep_code = serialize($data);
        $block = mcrypt_get_block_size('des', 'ecb');
        if (($pad = $block - (strlen($prep_code) % $block)) < $block) {
            $prep_code .= str_repeat(chr($pad), $pad);
        }
        $encrypt = mcrypt_encrypt(MCRYPT_DES, $this->key, $prep_code, MCRYPT_MODE_ECB);
        return base64_encode($encrypt);
    }

    function decrypt($str) {
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $this->key, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        if ($pad && $pad < $block && preg_match('/' . chr($pad) . '{' . $pad . '}$/', $str)) {
            $str = substr($str, 0, strlen($str) - $pad);
        }
        return unserialize($str);
    }
}
