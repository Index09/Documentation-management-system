<?php
include 'config.php';
	$choice = $_GET['ruser'];
		
	if (mb_strlen($choice) < 10)
		{
		echo '<font style="color:red">خطأ باسم المتعامل</font>';
		}
	elseif (!preg_match("~^[a-z\-'\s\p{Arabic}]{1,60}$~iu",$choice))
		{
		echo '<font style="color:red">خطأ باسم المتعامل</font>';
		}
	else 
		{
		echo '<font style="color:green">ادخال صحيح</font>';
		}
?>