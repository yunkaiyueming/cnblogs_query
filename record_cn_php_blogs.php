<?php
//error_reporting(E_ERROR);

//引用相关的类库
require 'QueryList/QueryList.class.php';
require 'config.php';

// 取值类似jQuery的操作
$reg = array(
	'title' => array('.searchItemTitle', 'text'),
	'content_url' => array('.searchItemTitle a', 'href'),
	'recommon_num' => array('.searchItemInfo-good', 'text'),
	'comment_num' => array('.searchItemInfo-comments', 'text'),
	'view_num' => array('.searchItemInfo-views', 'text'),
); 

// 抓取内容的div
$rang = '.searchItem';

$con = mysql_connect(DB_HOST.":".DB_PORT, DB_USER, DB_PWD);
mysql_select_db(DB_NAME);

$sql = "select count(*) from cn_php_blogs where view_type='1000'";
$res = mysql_query($sql);
$counts_info = mysql_fetch_array($res);
$exist_max_num = $counts_info['0'];

//每5页一跑, 每页20篇
$start_page = ceil($exist_max_num/20);
$start_num = intval($exist_max_num%20);
if($start_num==19){
	$start_page++;
}

for($page=$start_page ; $page<$start_page+5; $page++){
	$url = 'http://zzk.cnblogs.com/s?w=php&views=1000';
	$url = empty($page) ? $url : ($url."&p=".$page);
	$hj = QueryList::Query($url, $reg, $rang, 'UTF-8');
	$cn_blogs = $hj->data;

	foreach($cn_blogs as $cn_blog) {
		$exist_sql = "select id from cn_php_blogs where content_url='".$cn_blog['content_url']."'";

		$exist_res = mysql_query($exist_sql);
		$num_rows = mysql_num_rows($exist_res);
		var_dump($num_rows);
		if(empty($num_rows)){
			$cn_blog['view_type'] = '1000';
			$values = implode("','", $cn_blog);			
			$sql = "insert into cn_php_blogs(title, content_url, recommon_num, comment_num, view_num, view_type) values('$values')";
			mysql_query($sql);

			echo 'success';
		}
	}
}

?>