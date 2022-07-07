<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
	{
?>

<div class="formtit"> اخر محرر لكل حرف
</div>

<form action="" method="post" class="ser1" dir="rtl">
	<center> 
	<label #lab>الحرف</label>
    <select name="doclet" required >
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
    <label #lab>عام</label>
    <select name="year" required>
	<option value="">اختر</option>
	<?php
	for ($i = 2010; $i <= date("Y"); $i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}
	?>
	</select>
    <input type="submit" name="query" value="استعلام"/>
</form>
<?php
		if (isset($_POST['query']))
			{
			$doclet = $_POST['doclet'];
			$year = $_POST['year'];
			$stmt = $has->prepare("select docnum, repet from documentation where YEAR(date)=? and doclet=? and doctyp='1' order by BINARY docnum + 0 desc");
			$stmt->bind_param('ss', $year, $doclet);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($docnum, $repet);
			$total = $stmt->num_rows;
			$stmt->fetch();
			$stmt->close();
			$stmt = $has->prepare("select docnum, repet from documentation where YEAR(date)=? and doclet=? and doctyp='2' order by BINARY docnum + 0 desc");
			$stmt->bind_param('ss', $year, $doclet);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($docnum1, $repet1);
			$total1 = $stmt->num_rows;
			$stmt->fetch();
			$stmt->close();
			$stmt = $has->prepare("select docnum, repet from documentation where YEAR(date)=? and doclet=? and doctyp='3' order by BINARY docnum + 0 desc");
			$stmt->bind_param('ss', $year, $doclet);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($docnum2, $repet2);
			$total2 = $stmt->num_rows;
			$stmt->fetch();
			$stmt->close();
			if	($total > 0 or $total1 > 0 or $total2 > 0)
				{
				echo '<br/><br/><label class="reptit"> تقرير عن اخر معاملة لحرف | '.$doclet.'  | عام  '.$year.' بمكتب توثيق '.$office.'</label>';
				echo '<table class="tab" >';
					echo '<tr>';
						 echo '<td class="td">محررات رسمية موثقة</td>';
						 echo '<td class="td">محاضر التصديق على التوقيعات</td>'; 	
						 echo '<td class="td">محررات عرفية</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="td">'.$docnum;
					if ($repet == 'on')
						{
						echo ' مكرر';
						}
					echo '</td>';
					echo '<td class="td">'.$docnum1; 
					if ($repet1 == 'on')
						{
						echo ' مكرر';
						}
					echo '</td>';					
					echo '<td class="td">'.$docnum2;
					if ($repet2 == 'on')
						{
						echo ' مكرر';
						}
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			}
		else
			{
			echo '<h4 dir="rtl" style="margin-right:20px; color:red">لا توجد أى بيانات</h4>';
			}
			}
		}
	else
		{
		header("Location:error.php"); die();
		}
?>