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

	<textarea id='q' name='q' rows="10" cols="70" placeholder="请输入要翻译的文字，输入网址可翻译该网页内"></textarea>
	<textarea id='res' name='res' rows="10" cols="70" ></textarea><br>
	<a href='#' onclick="history.go(-1)">返回上一页</a>

	<script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.min.js"></script>
	<script type='text/javascript'>
		$(function(){
			$("#q").keyup(function(event){
				if(event && event.keyCode==13){// enter 键
					var q = $("#q").val();

					$.post('./youdao_translation.php',{"q":q}, function(data){
						var json_arr=JSON.parse(data);
						var res_str = "";
						for(i in json_arr){
							res_str += json_arr[i]+'\n';
						}
						$('#res').val(res_str);		
					});
            	}
			})
		});
	</script>
	</body>
	</html>