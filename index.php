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
		include 'config.php';

		$page = $_GET['page'];
		$page = empty($page) ? 1 : $page;

		$limit_num = 50;
		$start_num = ($page - 1) * $limit_num;

		$con = mysql_connect(DB_HOST . ":" . DB_PORT, DB_USER, DB_PWD);
		mysql_select_db(DB_NAME);

		$res = mysql_query("select count(*) from cn_blogs");
		$counts_info = mysql_fetch_array($res);
		$count_num = $counts_info['0'];

		$sql = "select * from cn_blogs order by id desc limit $start_num,$limit_num";
		$res = mysql_query($sql, $con);

		echo "<ul>";
		while ($row = mysql_fetch_assoc($res)) {
			echo "<li>" . $row['id'] . "<a href='$row[content_url]' target='_blank'> " . $row['title'] . "</a></li>";
		}
		echo "</ul>";

		mysql_free_result($res);

		$page_num = ceil($count_num / $limit_num);
		$next_page = $page + 1;
		$pre_page = $page - 1;

		echo "<a href='?page=1'>首页</a>  ";
		echo "<a href='?page=$pre_page'>前页</a>  ";
		echo "第 $page 页  ";
		echo "<a href='?page=$next_page'>下页</a>  ";
		echo "<a href='?page=$page_num'>末页</a>  ";
		?>
	</body>
</html>