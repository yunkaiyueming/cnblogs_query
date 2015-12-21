<html>
	<head>
		<meta charset="utf-8">
		<style>
			ul{ list-style-type:none; padding:0px; margin:0px;}
			li{ padding:0px 5px 0px 5px; vertical-align:bottom; line-height:30px;}
			a{ text-decoration:none} 
		</style>
	</head>
	<body>
		<?php
			error_reporting(E_ERROR);
			if(!isset($_GET['id'])){
				exit('参数传入错误');
			}

			$id = $_GET['id'];
			include 'config.php';
			$con = mysql_connect(DB_HOST . ":" . DB_PORT, DB_USER, DB_PWD);
			mysql_select_db(DB_NAME);

			//查看具有相似标签的豆瓣书籍
			$res = mysql_query("select tags from douban_books where id=$id");
			$book_info = mysql_fetch_assoc($res);

			echo "<ul>";
			echo "<li>ID&nbsp&nbsp;书名&nbsp;&nbsp;评分&nbsp;&nbsp;作者&nbsp;&nbsp;译者&nbsp;&nbsp;页数&nbsp;&nbsp;出版日期&nbsp;&nbsp;标签";
			
			if(!empty($book_info['tags'])){
				$tags_infos = explode(',', $book_info['tags']);
				foreach($tags_infos as $tags_info){
					$tags_info = trim($tags_info);
					$sql = "select * from douban_books where tags like '%$tags_info%'";
					$res = mysql_query($sql);
					while($row = mysql_fetch_assoc($res)) {
						echo "<li>" . $row['id'] . "<a href='$row[url]' target='_blank'> 《" . $row['title'] . "》</a>   &nbsp;&nbsp;".$row['average'].' &nbsp;&nbsp;'.$row['author'].' &nbsp;&nbsp;'.$row['translator'].' &nbsp;&nbsp;'.$row['pages'].' &nbsp;&nbsp;'.$row['pubdate'].'&nbsp;&nbsp;'.$row['tags']."</li>";
					}
				}
			}
			echo "</ul>";

			mysql_free_result($res);
		?>
</body>