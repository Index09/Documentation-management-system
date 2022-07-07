<?php
ob_start();
session_start();
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'Admin')
	{
	if (isset($_POST['signup']))
		{
		include 'config.php';
		echo '<center>';
		$UserName = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
		$PassWord = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
		$Fullname = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
		$Role= $_POST['role'];
		$office= $_POST['office'];
		
		$stmt = $has->prepare("select * from users where username=?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$data = $stmt->get_result();
		if(preg_match('/^([A-z0-9]+[_\'-]?[a-z0-9]+[ ]?)+$/', $UserName)) 
			{
			if (strlen($PassWord) >= 6)
				{
				if ($data->num_rows== 0)
					{
					if (strlen($UserName) >= 4)
						{
						$stmt = $has->prepare("INSERT INTO users SET username=?, password=?, fullname=?, role=?, office=?, status='on'");
						$stmt->bind_param('ssssi', $UserName, $PassWord, $Fullname, $Role, $office);
						$stmt->execute();
						$stmt->close();
						echo '<center><h2 style="color:green">لقد تم انشاء حساب جديد بنجاح تحت اسم مستخدم ('.$UserName.').</h2><a href="index.php?home=enter">الرجوع إلى الصفحة الرئيسية<a>';
						}
					else
						{
						echo '<h2 style="color:red;font-weight:bold">اسم المستخدم لا يجب ان يقل عن 4 احرف وارقام</h2>';
						echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?url=signup'>";
						}
					}
				else
					{
					echo '<h2 style="color:red;font-weight:bold">اسم المستخدم موجود لدينا بالفعل. ابحث عن اسم مستخدم آخر!</h2>';
					echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?url=signup'>";
					}
				}
			else
				{
				echo '<h2 style="color:red">كلمة السر لا يجب ان تقل عن 6 احرف او ارقام</h2>';
				echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?url=signup'>";
				}
			}
		else
			{
			echo '<h2 style="color:red;font-weight:bold">اسم المستخدم غير صالح</h2>';
			echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?url=signup'>";
			}
		}
	}
else 
	{
	header("Location:error.php"); die();
	}
?>