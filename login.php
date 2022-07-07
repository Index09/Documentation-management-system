<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>الحفظ الإلكترونى للمحررات</title>
</head>
<body>
<div id="header1">الحفظ الإلكترونى للمحررات اليدوية</div>
<div id="login">
<center> 
<form action="checklogin2.php" method="post" id="input">
	<select name="office" id="input" required>
		<option value="">اختر المكتب</option>
<?php
		$offices2 = $has->query("select * from offices");
		while ($office2 = $offices2->fetch_array())
			{
			$office3 = $office2['office'];
			$mrand = $office2['mrand'];
			echo '<option value="'.$mrand.'">'.$office3.'</option>';
			}
?>
	</select>
	<input type="text" name="Username" placeholder="اسم الدخول" id="input">
	<input type="password" name="Password" placeholder="كلمة المرور" id="input">
<input type="submit" value="Log in">
</form>

</center>


</div>



</body>
</html>
