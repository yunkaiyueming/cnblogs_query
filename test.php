<?php
include("QueryList/QueryList.class.php");

$hj = QueryList::Query(
		'http://www.baidu.com/s?wd=QueryList',
		array('title'=>array('h3','text'),'link'=>array('h3>a','href'))
	);
print_r($hj->data);

