<?php
//error_reporting(E_ERROR);

//引用相关的类库
require 'QueryList/QueryList.class.php';
require 'config.php';

// 取值类似jQuery的操作
$reg = array(
	'img_url' => array('img', 'src'), // 解析头像 对应html代码为<img width="48" height="48" class="pfs" src="http://pic.cnblogs.com/face/694143/20141118194530.png" alt="">
	'title' => array('.titlelnk', 'text'), // 解析文章名 对应html代码为 <a class="titlelnk" ....简单的jQuery 四级分类实用插件</a>
	'content' => array('.post_item_summary', 'text', ), // 解析文章简介 对应html代码为  <a href="http://www.cnblogs.com/jr1993/".....   前言最近因需要自　....　首先html代码： ... 
	'content_url' => array('.titlelnk', 'href')
); // 解析帖子链接 对应html代码为<a class="titlelnk" href="http://www.cnblogs.com/jr1993/p/4716308.html" target="_blank">

// 抓取内容的div
$rang = '.post_item';

//3页=60篇博文
$con = mysql_connect(DB_HOST.":".DB_PORT, DB_USER, DB_PWD);
mysql_select_db(DB_NAME);
for($page=4; $page>0; $page--){
	echo 'page:'.$page."<br>";
	$url = 'http://www.cnblogs.com';
	$url = empty($page) ? $url : ($url."/p".$page);
	$hj = QueryList::Query($url, $reg, $rang, 'UTF-8');
	$cn_blogs = $hj->data;

	$cloum_name = array('img_url','title', 'content', 'content_url');
	$get_cnblogs_nums = count($cn_blogs)-1;
	
	for($i=$get_cnblogs_nums; $i>=0; $i--){
		echo $i." ";
		$cn_blog = $cn_blogs[$i];
		
		$exist_sql = "select id from cn_blogs where content_url='".$cn_blog['content_url']."'";
		$exist_res = mysql_query($exist_sql);
		$num_rows = mysql_num_rows($exist_res);
		if(empty($num_rows)){
			$values = implode("','", $cn_blog);			
			$sql = "insert into cn_blogs(img_url,title, content, content_url) values('$values')";
			mysql_query($sql);
			echo 'success';
		}
	}
}

?>