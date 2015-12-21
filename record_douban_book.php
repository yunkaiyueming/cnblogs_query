<?php
//error_reporting(E_ERROR);
require 'config.php';
require 'common_helper.php';

//查询API文档: http://developers.douban.com/wiki/?title=book_v2#get_book_search
//查询示例：https://api.douban.com/v2/book/search?q=php&count=50
//q=查询关键字(q和tag必传其一) tag=查询标签 count=取结果的条数（默认为20，最大为100）

$url = "https://api.douban.com/v2/book/search";
$param = array('count'=> 50);
!isset($_GET['q']) OR ($param['q'] = $_GET['q']);
!isset($_GET['tag']) OR ($param['tag'] = $_GET['tag']);

$book_json_infos = MY_Request::curl($url, $param, 60, FALSE, TRUE);

if(!empty($book_json_infos)){
	$book_infos = json_decode($book_json_infos, TRUE);

	$con = mysql_connect(DB_HOST.":".DB_PORT, DB_USER, DB_PWD);
	mysql_select_db(DB_NAME);

	foreach($book_infos['books'] as $book_info){
		$exist_sql = "select douban_book_id from douban_books where douban_book_id='".$book_info['id']."'"; 
		$exist_res = mysql_query($exist_sql); 
		$num_rows = mysql_num_rows($exist_res);

		$tag_str = "";
		foreach($book_info['tags'] as $tag_info){
			$tag_str .= $tag_info['name'].", ";
		}
		$tag_str = substr($tag_str, 0, -2);

		if(empty($num_rows)){
			$book_arr = array( 
				$book_info['id'],
				$book_info['title'], 
				$book_info['url'], 
				$tag_str,
				$book_info['rating']['average'], 
				$book_info['isbn13'],
				implode(',', $book_info['author']), 
				$book_info['pubdate'], 
				implode(',', $book_info['translator']), 
				$book_info['pages'], 
			); 

			$values = implode("','", $book_arr);
			$sql = "insert into douban_books(douban_book_id, title, url, tags, average, isbn13, author, pubdate, translator, pages) values('$values')";
			mysql_query($sql);
			echo 'success'."<br>";
		}
	}

	mysql_free_result($exist_res);
}

?>