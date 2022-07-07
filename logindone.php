مرحبا <?php echo $_SESSION['Fullname'];?> | الشهر العقارى والتوثيق | 
<a href="logout.php">تسجيل خروج</a> |
<?php
if ($_SESSION['lsession'] !='')
	{
	echo 'أخر تسجيل دخول: '.$_SESSION['lsession'];
	}
	echo ' | ';
?>