<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
	{
?>

<div class="formtit"> احصائية عن اعمال المكتب
</div>

<form action="" method="post" class="ser1" dir="rtl">
	<center> 
	<div >
        <label #lab>فى الفترة من</label>
        <input type="date" name="start" required />
        <label #lab>إلى</label>
        <input type="date" name="end" required />
        <input type="submit" name="query" value="استعلام"/>
		 </div>
</form>
        
        
		<?php
		if (isset($_POST['query']))
			{
			$start = $_POST['start'];
			$end = $_POST['end'];
			$stmt = $has->prepare("select * from documentation where date between ? and ? ");
			$stmt->bind_param('ss', $start, $end);
			$stmt->execute();
			$result=$stmt->get_result();
			$total = $result->num_rows;
			if	($total > 0)
				{
				echo '<br/><br/><label class="reptit">تقرير عن عدد معاملات مكتب  '.$office.' فى الفترة من '.$start.' إلى  '.$end.' </label>';
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
		?>
     </center>
<?php
	}
else
	{
	header("Location:error.php"); die();
	}
?>