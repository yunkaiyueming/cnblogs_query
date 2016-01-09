<?php

error_reporting(E_ERROR);
//引用相关的类库
require 'QueryList/QueryList.class.php';
require 'config.php';

$con = mysql_connect(DB_HOST . ":" . DB_PORT, DB_USER, DB_PWD);
mysql_select_db(DB_NAME);

$base_url = "http://www.thinkphp.cn/extend";
$fetch_url_types = array('engine', 'function', 'library','driver','action','model','behavior','mode','example','others');

$reg = array(
	'title' => array('a', 'text'),
	'title_url' => array('a', 'href'),
);
$rang = ".article-title";

foreach($fetch_url_types as $url_type){
	$real_fetch_url = $base_url."/".$url_type;
	//每类抓取2页
	for($i=1; $i<6;$i++){
		$url = $real_fetch_url."/p/".$i.".html";
		$hj = QueryList::Query($url, $reg, $rang, 'UTF-8');
		$cn_thinkphp_infos = $hj->data;
		$arr_exit = get_all_url();
		//数据入库
		foreach ($cn_thinkphp_infos as $cn_thinkphp_info) {
			//从数据库中查处所有已经有的数据，进行对比，如果有，则不插入
			if(!in_array('http://www.thinkphp.cn'.$cn_thinkphp_info['title_url'], $arr_exit)){
				$cn_thinkphp_info['title_url'] = 'http://www.thinkphp.cn'.$cn_thinkphp_info['title_url'];
				$values = implode("','", $cn_thinkphp_info);
				$sql = "insert into cn_thinkphp_tuijian(title,title_url) values('$values')";
				mysql_query($sql);
				echo 'success';
			}
		}
	}
}

//从结果集中获取所有的数据
function getAll($sql) {
	$query = mysql_query($sql);
	if ($query) {
		$temp = array();
		while ($res = mysql_fetch_row($query)) {
			$temp[] = $res;
		}
		return $temp; //定义一个空数组用于存储接收到的数据
	} else {
		return false;
	}
}

function get_all_url(){
	//从数据库中查处所有已经有的数据，进行对比，如果有，则不插入
	$mysql_str = "SELECT cn_thinkphp_tuijian.title_url from cn_thinkphp_tuijian ORDER BY id ;";
	$res_datas = getAll($mysql_str);
	$arr_exit = [];
	foreach ($res_datas as $res_data) {
		$arr_exit[] = $res_data[0];
	}
	
	return $arr_exit;
}
