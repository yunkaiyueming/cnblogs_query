<?php

class MY_Request {
	public static function buid_query($params) {
		$querys = array();
		foreach($params as $field=>$value) {
			$querys[] = "$field=$value";
		}
		
		return implode('&', $querys);
	}
	
	public static function multi_curl($requests) {
		$mh = curl_multi_init();
		$chs = array();

		foreach($requests as $key=>$req) {
			$timeout = empty($req['timeout']) ? 20 : $req['timeout'];
			
			$ch = curl_init($req['url']);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
				curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			}
			
			// 默认走代理，当开启了not_need_proxy项则不走代理，
			// 多进程并发访问自己时就不需要走代理
			if(empty($req['not_need_proxy'])) {
				curl_setopt($ch, CURLOPT_PROXY, $req['host']);
				if(!empty($req['auth'])) {
					curl_setopt($ch, CURLOPT_PROXYUSERPWD, $req['auth']);
				}
			}
			curl_multi_add_handle($mh, $ch);
			$chs[$key] = $ch;
		}
		
		$active = null;
		
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while($mrc == CURLM_CALL_MULTI_PERFORM);
		
		while($active && $mrc==CURLM_OK) {
			if(curl_multi_select($mh) != -1) {
				do {
					$mrc = curl_multi_exec($mh, $active);
				} while($mrc == CURLM_CALL_MULTI_PERFORM);
			}
			usleep(100);
		}
		
		$rets = array();
		foreach($chs as $key=>$ch) {
			$rets[$key] = curl_multi_getcontent($ch);
			curl_multi_remove_handle($mh, $ch);
		}
		curl_multi_close($mh);
		return $rets;
	}
	
	public static function multi_curl_json($requests, $is_raw=FALSE) {
		$rets = self::multi_curl($requests);
		if(!empty($rets)){
			$rets_json = json_encode($rets);
		}
		
		return $is_raw ? gzdeflate($rets) : $rets;
	}

	public static function curl($url, $param, $timeout=40, $is_post = FALSE, $is_ssl = FALSE){
		$result = false;
		if(!$is_post){
			$url = $url.'?'.http_build_query($param);
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);	
		if($is_ssl){
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		}
		if($is_post){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		}

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}