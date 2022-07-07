<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
	{
?>
<div class="formtit"> تقرير انجاز عن فترة
</div>

<form action="" method="post" class="ser1" dir="rtl">
	<center> 
        <label>الاسم</label>
        <select name="writer" id="sel" required >
        <?php
		echo '<option value="">اختر</option>';
		if ($_SESSION['Role'] == 'User')
			{
			echo '<option value="'.$_SESSION['Fullname'].'">'.$_SESSION['Fullname'].'</option>';
			}
		if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin')
			{
			$users = $has->query("select * from users");
			while ($user = $users->fetch_array())
				{
				$fullname = $user['fullname'];
				echo '<option value="'.$fullname.'">'.$fullname.'</option>';
				}
			}
		?>
       </select>
        <label #lab>فى الفترة من</label>
        <input type="date" name="start" required />
        <label #lab>إلى</label>
        <input type="date" name="end" required />
        <input type="submit" name="query" value="استعلام"/>
</form>
<?php
		if (isset($_POST['query']))
			{
			$writer = $_POST['writer'];
			$start = $_POST['start'];
			$end = $_POST['end'];
			$stmt = $has->prepare("select * from documentation where date between ? and ? and writer=?");
			$stmt->bind_param('sss', $start, $end, $writer);
			$stmt->execute();
			$result=$stmt->get_result();
			$total = $result->num_rows;
			if	($total > 0)
				{
				echo '<br/><br/><label class="reptit">تقرير انجاز عن الفترة من '.$start.' إلى  '.$end.'  لـ   /'.$writer.' بمكتب توثيق '.$office.' </label>';
				echo '<table class="tab" >';
					echo '<tr>';
						 echo '<td class="td">محررات رسمية موثقة</td>';
						 echo '<td class="td">محاضر التصديق على التوقيعات</td>'; 	
						 echo '<td class="td">محررات عرفية</td>';
						 echo '<td class="td">الاجمالى</td>';
					echo '</tr>';
					$doctyp1 = 0;
					$doctyp2 = 0;
					$doctyp3 = 0;
					while($item=$result->fetch_array())
						{
						$doctyp = $item['doctyp'];
						if ($doctyp == 1)
							{
							$doctyp1++;
							}
						elseif ($doctyp == 2)
							{
							$doctyp2++;
							}
						else
							{
							$doctyp3++;
							}
						}
					echo '<tr>';
						 echo '<td class="td">'.$doctyp1.'</td>';
						 echo '<td class="td">'.$doctyp2.'</td>'; 	
						 echo '<td class="td">'.$doctyp3.'</td>';
						 echo '<td class="td">'.$total.'</td>';
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