<?php
	require 'common_helper.php';

	//使用有道API接口
	$url = "http://fanyi.youdao.com/openapi.do";
	$param = array(
		'keyfrom' => 'ykcnblogs',
		'key' => '1244922828',
		'type' => 'data',
		'doctype' => 'json',
		'version' => '1.1',
		'q' => $_REQUEST['q'],//urlencode($_POST['q']),
		'only' => 'translate',
	);

	$res = '';
	$response_info = MY_Request::curl($url, $param, 60, FALSE, FALSE);
	if(!empty($response_info)){
		$response_decode = json_decode($response_info, TRUE);
		$res = $response_decode['translation'];
	}

	echo json_encode($res);
?>