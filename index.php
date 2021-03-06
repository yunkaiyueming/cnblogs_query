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
	<div>
    	<a href="https://github.com/yunkaiyueming"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>
	</div>
		<?php
			//error_reporting(E_ERROR);
			$type = empty($_GET['type']) ? '1' : $_GET['type'];
			$q = empty($_GET['q']) ? '' : $_GET['q'];

			include 'config.php';
			$limit_num = 50;

			$page = empty($_GET['page']) ? '1' : $_GET['page'];
			$start_num = ($page - 1) * $limit_num;

			$con = mysql_connect(DB_HOST . ":" . DB_PORT, DB_USER, DB_PWD);
			mysql_select_db(DB_NAME);
		?>
		<select name='cn_type'>
			<option value='1' url='record_cn_blogs.php' <?php if($type=='1'){echo "selected='selected'";}?>>首页博文</option>
			<option value='6' url='record_cn_kb.php' <?php if($type=='6'){echo "selected='selected'";}?>>知识博文</option>
			<option value='2' url='record_cn_php_blogs.php' <?php if($type=='2'){echo "selected='selected'";}?> >PHP博文</option>
			<option value='3' url="<?php echo 'record_douban_book.php?q='.$q;?>" <?php if($type=='3'){echo "selected='selected'";}?> >豆瓣书籍</option>
			<option value='4' url='youdao_index.php' <?php if($type=='4'){echo "selected='selected'";}?> >有道翻译</option>
			<option value='5' url='record_cn_thinkphp.php' <?php if($type=='5'){echo "selected='selected'";}?> >ThinkPhp</option>
		</select>
		<input type="text" name="q" width='30%' value="<?php echo $q;?>" >
		<input type="button" value="查询" id="query_btn">
		<input type="button" value="更新数据" id="update_btn">

		<?php
		$q_con = empty($q) ? "" : " where title like '%$q%'";
		$query_arrs = array(
			'1'=>array('table_name'=>'cn_blogs', 'row'=>array('url'=>'content_url')),
			'2'=>array('table_name'=>'cn_php_blogs', 'row'=>array('url'=>'content_url', 'recommon_num','comment_num', 'view_num')),
			'3'=>array('table_name'=>'douban_books', 'row'=>array('url'=>'content_url', 'average', 'translator', 'pages','pubdate','')),
			'5'=>array('table_name'=>'cn_thinkphp_tuijian', 'row'=>array('url'=>'title_url')),
			'6'=>array('table_name'=>'cn_kb_blogs', 'row'=>array('url'=>'content_url', 'kb_type')),
		);

		$query_infos = $query_arrs[$type];
		$sql = "select * from $query_infos[table_name] $q_con order by id desc limit $start_num,$limit_num";
		$res = mysql_query($sql, $con);
		echo "<ul>";
		if($type=='1'){
			//显示cn_blogs主页博文
			while ($row = mysql_fetch_assoc($res)) {
				echo "<li>" . $row['id'] . "<a href='$row[content_url]' target='_blank'> " . $row['title'] . "</a></li>";
			}
		}elseif($type=='2'){
			//显示查询的php的博文
			while ($row = mysql_fetch_assoc($res)) {
				echo "<li>" . $row['id'] . "<a href='$row[content_url]' target='_blank'> " . $row['title'] . "</a>   &nbsp;&nbsp;".$row['recommon_num'].' &nbsp;&nbsp;'.$row['comment_num'].' &nbsp;&nbsp;'.$row['view_num']."</li>";
			}
		}elseif($type=='3'){
			//显示查询的豆瓣图书
			echo "<li>ID&nbsp&nbsp;书名&nbsp;&nbsp;评分&nbsp;&nbsp;作者&nbsp;&nbsp;译者&nbsp;&nbsp;页数&nbsp;&nbsp;出版日期&nbsp;&nbsp;标签";
			while ($row = mysql_fetch_assoc($res)) {
				echo "<li>" . $row['id'] . "<a href='$row[url]' target='_blank'> 《" . $row['title'] . "》</a>   &nbsp;&nbsp;".$row['average'].' &nbsp;&nbsp;'.$row['author'].' &nbsp;&nbsp;'.$row['translator'].' &nbsp;&nbsp;'.$row['pages'].' &nbsp;&nbsp;'.$row['pubdate'].'&nbsp;&nbsp;'.$row['tags']."<a href='./db_book_tags_search.php?id=$row[id]' target='_other'> <font color='red'>查看相似</font></a></li>";
			}
		}elseif($type=='5'){
			//显示查询的thinkphp的博文
			while ($row = mysql_fetch_assoc($res)) {
				echo "<li>" . $row['id'] . "<a href='$row[title_url]' target='_blank'> " . $row['title'] . "</a></li>";
			}
		}elseif($type=='6'){
			//显示查询的cnblog知识的博文
			while ($row = mysql_fetch_assoc($res)) {
				echo "<li>" . $row['id'] . "<a href='$row[content_url]' target='_blank'> " . $row['title'] . "</a>&nbsp;&nbsp;".$row['kb_type']."</li>";
			}
		}
		echo "</ul>";

		$res = mysql_query("select count(*) from $query_infos[table_name] $q_con");
		$counts_info = mysql_fetch_array($res);
		$count_num = $counts_info['0'];
		mysql_free_result($res);

		$page_num = ceil($count_num/$limit_num);
		$next_page = $page + 1;
		$pre_page = $page - 1;

		echo "<a href='?page=1&type=$type&q=$q'>首页</a>  ";
		echo "<a href='?page=$pre_page&type=$type&q=$q'>前页</a>  ";
		echo "第 $page / $page_num 页  ";
		echo "<a href='?page=$next_page&type=$type&q=$q'>下页</a>  ";
		echo "<a href='?page=$page_num&type=$type&q=$q'>末页</a>  ";
		?>
	</body>

	<script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.min.js"></script>
	<script type="text/javascript">
        $(function(){
        	$("select[name='cn_type']").change(function(){
        		var cn_type = $("select[name='cn_type']").val();

        		if(cn_type=='4'){//有道翻译跳转翻译页面
        			window.location.href='./youdao_index.php';
        		}else{
        			window.location.href='./?type='+cn_type;	
        		}
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

			$('#query_btn').click(function(){
				var cn_type = <?php echo $type;?>;
				var q = $("input[name='q']").val();
				window.location.href="./?type="+cn_type+"&q="+q;
			});

		});
	</script>
</html>