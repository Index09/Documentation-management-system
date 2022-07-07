y<?php
ob_start();
session_start();
include 'config.php';
include 'time.php';
error_reporting(E_ALL ^ E_NOTICE);
?>
<body style="background-image: -webkit-gradient(linear, 50.00% 0.00%, 50.00% 100.00%, color-stop( 2.59% , rgba(211,191,255,1.00)),color-stop( 48.70% , rgba(255,255,255,1.00)),color-stop( 94.82% , rgba(214,196,255,1.00)));
	background-image: -webkit-linear-gradient(270deg,rgba(211,191,255,1.00) 2.59%,rgba(255,255,255,1.00) 48.70%,rgba(214,196,255,1.00) 94.82%);
	background-image: linear-gradient(180deg,rgba(211,191,255,1.00) 2.59%,rgba(255,255,255,1.00) 48.70%,rgba(214,196,255,1.00) 94.82%);">
<meta charset="utf-8">
<br/> <br/> <br/> <br/> <br/> <br/>
<center>

<?php
	$UserName = $has->real_escape_string($_POST['Username']);
	$PassWord = $has->real_escape_string($_POST['Password']);
	$office3 = $has->real_escape_string($_POST['office']);
	/*$stmt = $has->prepare("SELECT id, username, password, fullname, role FROM users where username=? AND password=? AND status!='off'");
	$stmt->bind_param('ss', $_POST['Username'], $_POST['Password']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($logId, $logun, $logpw, $logfirst, $logrole); // number of arguments must match columns in SELECT
	if($stmt->num_rows > 0) 
	{
	$stmt->fetch();
	$_SESSION['id'] = $logId;
	$_SESSION['fullname'] = $logfirst;
	$_SESSION['role'] = $logrole;
	$_SESSION ['password'] = $logpw;
	$_SESSION['LOGINIS'] ='done';
	echo '<h2> أهلا بعودتك <br /><span style="color:red;">'.$logfirst.'</span><br />سيتم تحويلك بعد 5 ثواني</h2>';
	$has->query("update users set try='0', status='on' where Username='$UserName'");
	echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?home=enter'>"; */

$stmt =$has->prepare("select * from users where username=? AND BINARY password=? AND office=? AND status!='off'");
$stmt->bind_param('sii', $UserName, $PassWord, $office3);
$stmt->execute();
$result = $stmt->get_result();   	// You get a result object now
if ($result->num_rows == 1)			// Note: change to $result->...!
	{
	$loginfo = $result->fetch_assoc();
	$logId= $loginfo['id'];
	$logun= $loginfo['username'];
	$logpw= $loginfo['password'];
	$logfirst= $loginfo['fullname'];
	$logrole= $loginfo['role'];
	$office= $loginfo['office'];
	$lsession= $loginfo['lsession'];
	$logstatus= $loginfo['status'];
	$_SESSION['Id'] = $logId;
	$_SESSION['Fullname'] = $logfirst;
	$_SESSION['Role'] = $logrole;
	$_SESSION['office'] = $office;
	$_SESSION ['Password'] = $logpw;
	$_SESSION ['lsession'] = $lsession;
	$_SESSION['LOGINIS'] ='done';
	$date1 = date("d/m/Y").' - '.date("h:i A");
	echo '<h2>اهلا بعودتك<br /><span style="color:red;">'.$logfirst.'</span><br />سيتم تحويلك خلال 5 ثوانى</h2>';
	$has->query("update users set try='0', status='on', lsession='$date' where username='$UserName'");
	echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?home=enter'>";
	$stmt->close();
	}
else 
	{
    $stmt = $has->prepare("SELECT status, try FROM users where username=?");
	$stmt->bind_param('s', $_POST['Username']);
	$stmt->execute();
	$stmt->bind_result($status, $logatt); // number of arguments must match columns in SELECT
	$stmt->fetch();
	$stmt->close();						//  I just seperate my queries with stmt->close(); to make the next query working
	$new = $logatt + 1;
	$end = 40;
	if ($status == 'off')
		{
		echo '<h2 style="color:red">لقد تم ايقاف الحساب الخاص بكم بسبب تجاوز محاولات التسجيل الخاطئ . يرجئ الرجوع إلى قسم الدعم الفنى من اجل حل هذه المشكلة</h2>';
		}
	elseif($logatt < $end)
		{
		echo '<h2>البيانات التى ادخلتها خاطئه</h2>';
		$stmt = $has->prepare("update users set try='$new', wrongpass=? where username=?");
		$stmt->bind_param('ss', $PassWord, $UserName);
		$stmt->execute();
		$stmt->close();
		echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php'>";
        session_destroy();
		}
	else
		{
		echo '<h2 style="color:red">لقد تم ايقاف الحساب الخاص بكم بسسب تجاوز محاولات التسجيل الخاطئ . يرجئ الرجوع إلى قسم الدعم الفنى من اجل حل هذه المشكلة</h2>';
		$stmt = $has->prepare("update users set try='$new', wrongpass=?, status='off' where username=?");
		$stmt->bind_param('ss', $PassWord, $UserName);
		$stmt->execute();
		$stmt->close();
		session_destroy();
		}
	}
?>
</body>