<script>
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

function validateForm() {
    var a = document.forms["Form"]["member1"].value;
    if (a == null || a == "") {
      alert("يجب ادخال اطراف التعامل");
      return false;
    }
  }

</script>
<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'User')
	{
if (isset($_POST['submit']))
	{
	$date = $_POST['date'];
	$parts = explode("-",$date);
	$year1 = $parts[0];
	$doctyp = $_POST['doctyp'];
	$doclet = $_POST['doclet'];
	$docnum = $_POST['docnum'];
	$repeat = $_POST['repeat'];
	$mrand = $_POST['mrand'];
	$writer = $_POST['writer'];
	$date1 = $_POST['time'];
	$office = $_POST['office'];
	$start = 0;
	$stmt = $has->prepare("select * from documentation where mrand=?");
	$stmt->bind_param('i', $mrand);
	$stmt->execute();
	$checkrn = $stmt->get_result();
	$reno1 = $checkrn->num_rows;
	$stmt->close();
	$stmt = $has->prepare("select date from documentation where doctyp=? and doclet=? and BINARY docnum=? and repet='off' and office=?");
	$stmt->bind_param('ssii', $doctyp, $doclet, $docnum, $office);
	$stmt->execute();
	$stmt->bind_result($date3);
	$stmt->store_result();
	$reno = $stmt->num_rows;
	while ($stmt ->fetch())
		{
		if (strpos($date3, $year1) !== false)
			{
			$count = 1;
			}
		else
			{
			$count = 0;
			}
		$start+=$count;
		}
	$stmt->close();
	if (isset ($repeat))
		{
		$start1 = 0;
		}
	else
		{
		$start1 = $start;
		}
	if ($start1 === 0)
		{
		if ($reno1 === 0)
			{
			if(is_numeric($docnum)) /*to check the whole string if it is just numbers or not*/
				{
				for ($i = 1; $i <= 12; $i++)
					{
					switch ($i)
						{
						case "1":
						$i1="الاول";
						break;
						case "2":
						$i1="الثانى";
						break;
						case "3":
						$i1="الثالث";
						break;
						case "4":
						$i1="الرابع";
						break;
						case "5":
						$i1="الخامس";
						break;
						case "6":
						$i1="السادس";
						break;
						case "7":
						$i1="السابع";
						break;
						case "8":
						$i1="الثامن";
						break;
						case "9":
						$i1="التاسع";
						break;
						case "10":
						$i1="العاشر";
						break;
						case "11":
						$i1="الحادى عشر";
						break;
						case "12":
						$i1="الثانى عشر";
						break;
						}
					$member = htmlspecialchars($_POST['member'.$i], ENT_QUOTES, 'UTF-8');
					$nid = htmlspecialchars($_POST['nid'.$i], ENT_QUOTES, 'UTF-8');
					$arrt = $_POST['arrt'.$i];
					if ($member != null)
						{
						if (mb_strlen($member) > 9)
							{
							if (preg_match("~^[a-z\-'\s\p{Arabic}]{1,60}$~iu",$member))
								{
								$stmt = $has->prepare("insert into members set member=?, nid=?, arrt=?, docnum=?, mrand=?, office=?");
								$stmt->bind_param('ssisii', $member, $nid, $arrt, $docnum, $mrand, $office);
								$stmt->execute();
								$stmt->close();
								}
							else
								{
								echo '<center><h4 style="color:red">خطأ فى اسم المتعامل '.$i1.'</h4></center>';
								echo $letterno;
								$stmt = $has->prepare("DELETE FROM members WHERE BINARY docnum=? and mrand=?");
								$stmt->bind_param('si', $docnum, $mrand);
								$stmt->execute();
								$stmt->close();
								exit;
								}
							}
						else
							{
							echo '<center><h4 style="color:red">خطأ فى اسم المتعامل '.$i1.'</h4></center>';
							$stmt = $has->prepare("DELETE FROM members WHERE BINARY docnum=? and mrand=?");
							$stmt->bind_param('si', $docnum, $mrand);
							$stmt->execute();
							$stmt->close();
							exit;
							}
						}
					}
				if (isset ($repeat))
					{
					$stmt = $has->prepare("insert into documentation set doctyp=?, date=?, doclet=?, docnum=?, repet='on', mrand=?, writer=?, time=?, office=?");
					}
				else
					{
					$stmt = $has->prepare("insert into documentation set doctyp=?, date=?, doclet=?, docnum=?, repet='off', mrand=?, writer=?, time=?, office=?");
					}
				$stmt->bind_param('ssssissi', $doctyp, $date, $doclet, $docnum, $mrand, $writer, $date1, $office );
				$stmt->execute();
				$stmt->close();
				header("Location:index.php?url=reportd&report=".$mrand);
				}
			else 
				{
				echo '<h4 style="color:red">رقم المحرر غير صالح</h4>';
				}
			}
		else 
			{
			echo '<h4 style="color:red">حدث خطأ ما .... من فضلك اعد المحاولة!</h4>';
			}
		}
	else 
		{
		echo '<h4 style="color:red">تم ادخال نفس المحرر من قبل</h4>';
		}
	}
?>
<div id="Rside">
<div id="TopCli"> 
<center>
	<form action="" method="post" dir="rtl"  name="Form" onsubmit="return validateForm()">
	
	<div class="box">
	<label id="lab"> نوع المحرر </label>
     	<select name="doctyp" required>
			<option value="">اختر</option>
			<option value="1">محررات رسمية موثقة</option>
           	<option value="2">محاضر التصديق على التوقيعات</option>
            <option value="3">محررات عرفية</option>
		</select>
		
    </div>
    <label id="lab"> تاريخ المحرر </label>
    <input type="date" name="date" required /> 		
	<label id="lab"> رقم المحرر </label>
	<input name="docnum" type="text" placeholder="رقم المحرر" required />
    <label id="lab"> مكرر</label>
	<input type="checkbox" name="repeat" />
	<div class="box2">
	<label id="lab"> الحرف </label>
		<select name="doclet" required>
			<option value="">اختر</option>
			<option value="أ">أ</option>
			<option value="ب">ب</option>
			<option value="ج">ج</option>
			<option value="د">د</option>
			<option value="هـ">هـ</option>
			<option value="و">و</option>
			<option value="ز" >ز</option>
			<option value="ح" >ح</option>
			<option value="ط" >ط</option>
			<option value="ك" >ك</option>
			<option value="ل" >ل</option>
			<option value="م" >م</option>
			<option value="-">-</option>
        </select>
		
	</div>
	<div id="client">اطراف التعامل</div>
	

</center>
<?php
		$year = explode ("0",date("Y"));
		$year1 = $year['1'];
		$month = (int)date("m");
		$day23 = (int)date("d");
		$n= $month.$year1.mt_rand (100000,999999).$day23;
		echo '<input type="hidden" name="writer" value="'.$_SESSION['Fullname'].'" />';
		echo '<input type="hidden" name="time" value="'.$date.'" />';
		echo '<input type="hidden" name="office" value="'.$_SESSION['office'].'" />';
		echo '<input type="hidden" name="mrand" value="'.$n.'" />';
		echo '<div id="clients"><table class="cora">';
		for ($i = 1; $i <= 12; $i++)
			{
			echo '<tr>';
				echo '<td><input type="text" name="member'.$i.'" id="ruser'.$i.'" placeholder="الاســم" /></td>';
				echo '<td><input type="text" name="nid'.$i.'" placeholder="الرقم القومى او رقم الجواز"  /></td>';
				echo '<td id="choice'.$i.'">'; 
				?>
					<script>
						$("#ruser<?php echo $i; ?>").change(function() {
						$("#choice<?php echo $i; ?>").load("menu2.php?ruser="+encodeURI($("#ruser<?php echo $i; ?>").val()));
						});
					</script>
				<?php
				echo '</td>';
				echo '<td><select name="arrt'.$i.'">';
					echo '<option value="1">طرف أول</option>';
					echo '<option value="2">طرف ثانى</option>';
				echo '</select></td>';
			echo '</tr>';
			}
		echo '</table></div>';
		?>
		
		<div id="clients">
			<input type="submit" name="submit" value="حفظ" />
		</div>
    </div>
	</div>
	</form>
	
</div>
<?php
	}
else 
	{
	header("Location:error.php"); die();
	}
?>