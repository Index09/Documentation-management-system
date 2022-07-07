<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'Admin' or $_SESSION['Role'] === 'User')
	{
	if (isset($_POST['submit']))
		{
		$old = htmlspecialchars($_POST['old_pass'], ENT_QUOTES, 'UTF-8');
		$new1 = htmlspecialchars($_POST['new_pass1'], ENT_QUOTES, 'UTF-8');
		$new2 = htmlspecialchars($_POST['new_pass2'], ENT_QUOTES, 'UTF-8');
		$userid = $_SESSION['Id'];
		$olpassword = trim($_SESSION['Password']);
		if (strlen($new2) >= 6)
			{ 
			if ($new1 === $new2 )
				{
				if ($olpassword === $old and $olpassword != $new2 )
					{
					$stmt = $has->prepare("update users set password=? where id=?");
					$stmt->bind_param('si', $new2, $userid);
					$stmt->execute();
					$stmt->close();
					echo "<center><h2 style='color:green'>تم تغيير كلمة السر بنجاح من فضلك اعد تسجيل الدخول مرة اخرى!</h2></center>";
					echo "<META HTTP-EQUIV='Refresh' Content='5;URL=index.php?home=enter'>";
					session_destroy();
					}
				else
					{
					echo '<center><h2 style="color:red">كلمة السر القديمة التى قمت بادخالها غير صحيحة من فضلك اعد المحاولة مرة أخرى!</h2></center>';
					}
				}
			else
				{
				echo '<center><h2 style="color:red">كلمتين السر الجديدتين اللتان قمت بادخالهما غير متطابقتين. يرجئ إعادة ادخالهما مرة أخرى!</h2></center>';
				}
			}
		else
			{
			echo '<center><h2 style="color:red">كلمة السر لا يجب ان تقل عن 6 احرف او ارقام</h2></center>';
			}			
		}
	if (isset($_POST['submit1']))
		{
		$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
		$stmt = $has->prepare("select * from users where username=?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$check1 = $stmt->get_result();
		$reno = $check1->num_rows;
		$stmt->close();
		if ($reno != 0)
			{
			$stmt = $has->prepare("update users set Password='123456', try='0', status='on' where username=?");
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->close();
			echo '<center><h3 style="color:green">تم اعادة تعيين كلمة السر إلى (123456) الخاصة باسم المستخدم ('.$username.')</h3></center>';
			}
		else
			{
			echo '<center><h3 style="color:red">لم يتم العثور على مستخدم بهذا اليوزر نيم يرجئ التأكد من اسم المستخدم واعادة المحاولة مرة أخرى!</h3></center>';
			}
		}
	
	echo '<br/></br><center><img src="imgs/face/password_icon.png" alt="password" title="password"><br />';
	echo '<div style="float:right; width:49%; border:1px solid; height: 300px;">';
		echo '<h3 style="color:blue">تغيير كلمة السر</h3>';	
		echo '<form action="" method="post" id="myform">';
		echo '<table dir="rtl">
		<tr><td>ادخل كلمة السر القديمة</td><td><input type="password" name="old_pass" required /></td><td></td></tr>
		<tr><td>ادخل كلمة السر الجديدة</td><td><input type="password" name="new_pass1" id="txtNewPassword" class="password" required /></td><td id="validpass" ></td></tr>';
		?>
		<script>
		$(".password").change(function() {
		$("#validpass").load("menu1.php?password1="+encodeURI($(".password").val()));
		});
		</script>
		<?php
		echo '<tr><td>اعد ادخال كلمة السر الجديدة</td><td><input type="password" name="new_pass2" id="txtConfirmPassword" required /></td><td id="divCheckPasswordMatch" style="font-weight:bold"></td></tr>
		<tr><td colspan=3><input type="submit" name="submit" value="تغيير" class="submt" id="submit" /></td></tr>
		</table>
		</form>';
	echo '</div>';
	if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin')
		{
		echo '<div style="float:right; width:49%; border:1px solid; margin-right:5px; min-height: 300px;">';
			echo '<h3 style="color:blue">إعادة تعيين كلمة السر لمستخدم آخر</h3>'; 
			echo '<form action="" method="post">';
			echo '<table dir="rtl">';
			echo '<tr><td>ادخل اسم المستخدم صحيح(usename)</td><td><input type="text" name="username" required /></td></tr>';
			echo '<tr><td colspan=2><input type="submit" name="submit1" value="إعادة تعيين" class="submt" /></td></tr>';
		echo '</table></form></div>';
		}
	echo '<div style="clear:both"></div>';
	}
else 
	{
	header("Location:error.php"); die();
	}
?>
<script type="text/javascript">
$('#txtNewPassword, #txtConfirmPassword').on('keyup', function() {
    //     var passw = document.getElementById("txtNewPassword").value;
	var passw = $('#txtNewPassword').val();
	  if ($('#txtNewPassword').val() == $('#txtConfirmPassword').val() && passw !== "" ) {
		$('#divCheckPasswordMatch').html('كلمتى السر متطابقتان').css('color', 'green');
		$('#submit').prop('disabled', false);
	  } else {
		 $('#divCheckPasswordMatch').html('كلمتى السر غير متطابقتان').css('color', 'red');
		$('#submit').prop('disabled', true);
	  }
});
</script>