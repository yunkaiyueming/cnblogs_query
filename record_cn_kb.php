<?php
//error_reporting(E_ERROR);

//引用相关的类库
require 'QueryList/QueryList.class.php';
require 'config.php';

// 取值类似jQuery的操作
$reg = array(
	'title' => array('.kb-title', 'text'),
	'content_url' => array('.kb-title', 'href'),
	'kb_type' => array('.deepred', 'text'),
); 

// 抓取内容的div
$rang = '.kb_item';

$con = mysql_connect(DB_HOST.":".DB_PORT, DB_USER, DB_PWD);
mysql_select_db(DB_NAME);

$sql = "select count(*) from cn_kb_blogs";
$res = mysql_query($sql);
$counts_info = mysql_fetch_array($res);
$exist_max_num = $counts_info['0'];

//每页20
$start_page = ceil($exist_max_num/20);
$start_num = intval($exist_max_num%20);
if($start_num==19){
	$start_page++;
}

for($page=4; $page>0; $page--){
	$url = 'http://home.cnblogs.com/kb';
	$fetch_page = $start_page+$page;
	$url = empty($page) ? $url : ($url."/page/".$fetch_page);
	$hj = QueryList::Query($url, $reg, $rang, 'UTF-8');
	$cn_blogs = $hj->data;

	$get_cnblogs_nums = count($cn_blogs)-1;
	for($i=$get_cnblogs_nums; $i>=0; $i--){
		$cn_blog = $cn_blogs[$i];
		
		$exist_sql = "select id from cn_kb_blogs where content_url='".$cn_blog['content_url']."'";
		$exist_res = mysql_query($exist_sql);
		$num_rows = mysql_num_rows($exist_res);
		if(empty($num_rows)){
			$values = implode("','", $cn_blog);			
			$sql = "insert into cn_kb_blogs(title, content_url, kb_type) values('$values')";
			mysql_query($sql);
			echo 'success'."<br>";
		}
	}
}

?>