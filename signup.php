<?php
if ($_SESSION['Role'] === 'Admin1' or $_SESSION['Role'] === 'Admin')
{
?>
<center><br/><br/><br/><h1> انشاء حساب جديد </h1>
<br/>
<table dir="rtl">
<form action="checklogin3.php" method="post" dir="rtl">
<tr><td><label>اسم المستخدم (بالانجليزى)  </label></td><td><input type="text" name="username" id="username" required /></td><td id="validuser">
<script>
$("#username").change(function() {
$("#validuser").load("menu1.php?username="+encodeURI($("#username").val()));
});
</script>
</td></tr>

<tr><td><label>الرقم السرى  </label></td><td><input type="password" name="password" id="password" required /></td><td id="validpass">
<script>
$("#password").change(function() {
$("#validpass").load("menu1.php?password="+encodeURI($("#password").val()));
});
</script>
</td></tr>

<tr><td><label>الاسم بالكامل  </label></td><td><input type="text" name="fullname" required /></td><td></td></tr>
<br/>
<br/>
<?php
	if ($_SESSION['Role'] === 'Admin1')
		{
		echo '<tr><td><label>اسم المكتب</label></td>';
		echo '<td><select name="office" required>';
		echo '<option value="">اختر</option>';
		$offices3 = $has->query("select * from offices where mrand='{$_SESSION['office']}'");
		$office3 = $offices3->fetch_array();
		echo '<option value="'.$office3['mrand'].'">'.$office3['office'].'</option>';
		$offices2 = $has->query("select * from offices where mrand!='{$_SESSION['office']}'");
		while ($office2 = $offices2->fetch_array())
			{
			$office3 = $office2['office'];
			$mrand = $office2['mrand'];
			echo '<option value="'.$mrand.'">'.$office3.'</option>';
			}
		echo '</select>';
		echo '</td><td></td></tr>';
		}
if ($_SESSION['Role'] === 'Admin1')
	{
	echo '<tr><td><label>صلاحيات الحساب</label></td>';
	echo '<td><select name="role" required>';
	echo '<option value="">اختر</option>';
	echo '<option value="Admin">admin</option>';
	echo '<option value="User">user</option>';
	echo '</select>';
	echo '</td><td></td></tr>';
	}
elseif ($_SESSION['Role'] === 'Admin')
	{
	echo '<input type="hidden" name="role" value="User">';
	echo '<input type="hidden" name="office" value="'.$_SESSION['office'].'">';
	}
?>
<tr><td colspan=3><input type="submit" id="linked" value="انشاء حساب" name="signup" class="submt" disabled="disabled" /></td></tr>
</form>
</table> 
<?php
	}
else 
	{
	header("Location:error.php"); die();
	}
?>
<script>
$(document).ready(function() {
$("#username").blur(function(e) {
    var uname = $(this).val();
    if (uname == "")
    {
        $("#validuser").html("");
        $("#linked").attr("disabled", true);
    }
    else
    {
      //  $("#validuser").html("checking...");
        $.ajax({
            url: "menu1.php",
            data: {username: uname},
            type: "POST",
            success: function(data) {
                if(data > '0') {
               //     $("#validuser").html('<span class="text-danger">Username is already taken!</span>');
                    $("#linked").attr("disabled", true);
                } else {
                //    $("#validuser").html('<span class="text-success">Username is available!</span>');
                    $("#linked").attr("disabled", false);
                }
            }
        });
    }
});
});
</script>