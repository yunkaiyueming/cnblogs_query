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
			$type = empty($_GET['type']) ? '1' : $_GET['type'];
			include 'config.php';
			$limit_num = 50;

			$page = empty($_GET['page']) ? '1' : $_GET['page'];
			$start_num = ($page - 1) * $limit_num;

			$con = mysql_connect(DB_HOST . ":" . DB_PORT, DB_USER, DB_PWD);
			mysql_select_db(DB_NAME);

			$res = mysql_query("select count(*) from cn_php_blogs");
			$counts_info = mysql_fetch_array($res);
			$php_count_num = $counts_info['0'];
		?>
		<select name='cn_type'>
			<option value='1' url='record_cn_blogs.php' <?php if($type=='1'){echo "selected='selected'";}?>>首页博文</option>
			<option value='2' url="<?php echo 'record_cn_php_blogs.php?num='.$php_count_num?>" <?php if($type=='2'){echo "selected='selected'";}?> >PHP博文</option>
		</select>
		<input type="button" value="手动更新" id="update_btn">

		<?php
		if($type=='1'){
			//显示cn_blogs主页博文
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
		}elseif($type=='2'){
			//显示查询的php的博文
			$res = mysql_query("select count(*) from cn_php_blogs");
			$counts_info = mysql_fetch_array($res);
			$count_num = $counts_info['0'];
			$sql = "select * from cn_php_blogs order by id desc limit $start_num,$limit_num";
			$res = mysql_query($sql, $con);
			echo "<ul>";
			while ($row = mysql_fetch_assoc($res)) {
				echo "<li>" . $row['id'] . "<a href='$row[content_url]' target='_blank'> " . $row['title'] . "</a>   &nbsp;&nbsp;".$row['recommon_num'].' &nbsp;&nbsp;'.$row['comment_num'].' &nbsp;&nbsp;'.$row['view_num']."</li>";
			}
			echo "</ul>";
		}

		mysql_free_result($res);

		$page_num = ceil($count_num / $limit_num);
		$next_page = $page + 1;
		$pre_page = $page - 1;

		echo "<a href='?page=1&type=$type'>首页</a>  ";
		echo "<a href='?page=$pre_page&type=$type'>前页</a>  ";
		echo "第 $page / $page_num 页  ";
		echo "<a href='?page=$next_page&type=$type'>下页</a>  ";
		echo "<a href='?page=$page_num&type=$type'>末页</a>  ";
		?>
	</body>

	<script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.min.js"></script>
	<script type="text/javascript">
        $(function(){
        	$("select[name='cn_type']").change(function(){
        		var cn_type = $("select[name='cn_type']").val();
        		window.location.href='./?type='+cn_type;	
        	});

			$('#update_btn').click(function(){
				var update_url = $("select[name='cn_type'] option:selected").attr("url");
				//alert(update_url);
				$.get("./"+update_url, {}, function (data) {
					if(data){
						window.location.reload();
					}
				});
			});

		});
	</script>
</html>